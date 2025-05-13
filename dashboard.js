//script pour le dashboard
$(document).ready(function() {
    const $modal = $("#modal-amis");
    const $closeModal = $("#close-modal");
    const $listeAmis = $("#liste-amis");
    const $amisBtn = $("#amis-btn");
    const $chatArea = $("#chat-area"); // Conteneur pour les chat boxes
    const openChats = {}; // Garder une trace des chats ouverts (par ID d'ami)

    // Fonction pour échapper les caractères HTML
    function htmlspecialchars(str) {
        if (typeof(str) == "string") {
            str = str.replace(/&/g, '&amp;');
            str = str.replace(/"/g, '&quot;');
            str = str.replace(/'/g, '&#039;');
            str = str.replace(/</g, '&lt;');
            str = str.replace(/>/g, '&gt;');
        }
        return str;
    }

    // Fonction pour rendre une chat box déplaçable
    function makeChatDraggable($chatBox) {
        const $header = $chatBox.find(".chat-header");
        let isDragging = false;
        let offsetX, offsetY;

        $header.on("mousedown", function(e) {
            console.log("mousedown détecté sur l'en-tête");
            isDragging = true;
            $chatBox.addClass("dragging");
            offsetX = e.clientX - $chatBox.offset().left;
            offsetY = e.clientY - $chatBox.offset().top;
            console.log("offsetX:", offsetX, "offsetY:", offsetY);
        });

        $(document).on("mouseup", function() {
            console.log("mouseup détecté sur le document");
            if (isDragging) {
                isDragging = false;
                $chatBox.removeClass("dragging");
            }
        });

        $(document).on("mousemove", function(e) {
            if (!isDragging) return;
            console.log("mousemove détecté sur le document");
            $chatBox.css({
                left: e.clientX - offsetX,
                top: e.clientY - offsetY,
                right: 'auto',
                bottom: 'auto'
            });
            console.log("left:", e.clientX - offsetX, "top:", e.clientY - offsetY);
        });
    }

    // Fonction pour créer/afficher une chat box pour un utilisateur
    function openChat(friendId, friendUsername) {
        if (openChats[friendId]) {
            openChats[friendId].show();
            loadMessages(friendId, $(`#chat-messages-${friendId}`));
            // makeChatDraggable(openChats[friendId]); // Rendre déplaçable si elle existait déjà
            return;
        }

        const chatBoxId = `chat-with-${friendId}`;
        const chatBoxHtml = `
            <div class="mini-chat-box" id="${chatBoxId}" data-friend-id="${friendId}">
                <div class="chat-header">
                    Chat avec ${htmlspecialchars(friendUsername)}
                    <span class="close-chat" data-chat-id="${chatBoxId}">×</span>
                </div>
                <div class="chat-messages" id="chat-messages-${friendId}">
                </div>
                <div class="chat-input">
                    <input type="text" id="message-input-${friendId}" placeholder="Votre message...">
                    <button class="send-button" data-receiver-id="${friendId}">Envoyer</button>
                </div>
            </div>
        `;
        $chatArea.append(chatBoxHtml);
        const $newChatBox = $(`#${chatBoxId}`);
        openChats[friendId] = $newChatBox;

        const $messagesContainer = $(`#chat-messages-${friendId}`);
        const $inputField = $(`#message-input-${friendId}`);
        const $sendBtn = $newChatBox.find(".send-button");
        const $closeBtn = $newChatBox.find(".close-chat");

        loadMessages(friendId, $messagesContainer);

        $sendBtn.on("click", function() {
            const receiverId = $(this).data("receiver-id");
            const message = $inputField.val().trim();
            if (message !== "") {
                sendMessage(receiverId, message, $inputField, $messagesContainer);
            }
        });

        $inputField.on("keypress", function(e) {
            if (e.which === 13) {
                $sendBtn.trigger('click');
            }
        });

        $closeBtn.on("click", function() {
            const chatIdToRemove = $(this).data("chat-id");
            $(`#${chatIdToRemove}`).hide();
        });

        makeChatDraggable($newChatBox); // Rendre la nouvelle chat box déplaçable
    }

        // Ajoutez cette fonction pour vérifier les nouveaux messages
    function checkForNewMessages() {
        $.ajax({
            url: 'check_new_messages.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.new_messages && data.new_messages.length > 0) {
                    data.new_messages.forEach(function(msg) {
                        if (!openChats[msg.sender_id]) {
                            openChat(msg.sender_id, msg.sender_name);
                        }
                        // Vous pouvez aussi ajouter une notification
                        showMessageNotification(msg.sender_name, msg.content);
                    });
                }
            },
            complete: function() {
                // Vérifie à nouveau après 5 secondes
                setTimeout(checkForNewMessages, 5000);
            }
        });
    }

    // Fonction pour afficher une notification
    function showMessageNotification(sender, message) {
        if (Notification.permission === "granted") {
            new Notification("Nouveau message de " + sender, {
                body: message.length > 30 ? message.substring(0, 30) + "..." : message,
                icon: 'chemin/vers/icone.png'
            });
        }
    }

    // Demander la permission pour les notifications
    if (window.Notification && Notification.permission !== "granted") {
        Notification.requestPermission();
    }

    // Démarrer la vérification au chargement de la page
    $(document).ready(function() {
        checkForNewMessages();
    });


    // Fonction pour charger les messages pour un utilisateur spécifique
    function loadMessages(receiverId, $messagesContainer) {
        $.ajax({
            url: `chat_messages.php?action=get&receiver_id=${receiverId}`,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.messages) {
                    $messagesContainer.html(data.messages);
                    $messagesContainer.scrollTop($messagesContainer[0].scrollHeight);
                }
            },
            error: function() {
                console.error("Erreur lors du chargement des messages.");
            }
        });
    }

    // Fonction pour envoyer un message à un utilisateur spécifique
    function sendMessage(receiverId, message, $inputField, $messagesContainer) {
        $.ajax({
            url: 'chat_messages.php',
            method: 'POST',
            dataType: 'json',
            data: { receiver_id: receiverId, message: message },
            success: function(response) {
                if (response.success) {
                    $inputField.val('');
                    loadMessages(receiverId, $messagesContainer);
                } else if (response.error) {
                    console.error("Erreur lors de l'envoi du message : " + response.error);
                }
            },
            error: function() {
                console.error("Erreur lors de l'envoi du message.");
            }
        });
    }

    if ($amisBtn.length) {
        $amisBtn.off("click").on("click", function() {
            $listeAmis.empty();
            $.ajax({
                url: 'get_amis_status.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.amis && data.amis.length > 0) {
                        $.each(data.amis, function(index, ami) {
                            const statusClass = ami.online ? 'online' : 'offline';
                            $listeAmis.append(`<li>
                                    <span class="status-indicator ${statusClass}"></span>
                                    ${htmlspecialchars(ami.username)}
                                    <button class="start-chat-btn small-btn" data-friend-id="${ami.id}" data-friend-username="${htmlspecialchars(ami.username)}">Chat</button>
                                </li>`);
                        });
                        $(".start-chat-btn").on("click", function() {
                            const friendId = $(this).data("friend-id");
                            const friendUsername = $(this).data("friend-username");
                            openChat(friendId, friendUsername);
                            $modal.css("display", "none");
                        });
                    } else {
                        $listeAmis.append("<li>Aucun ami trouvé.</li>");
                    }
                    $modal.css("display", "block");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de la récupération des amis : " + textStatus, errorThrown);
                    alert("Erreur lors du chargement de la liste des amis.");
                }
            });
        });
    }

    $closeModal.on("click", function() {
        $modal.css("display", "none");
    });

    $(window).on("click", function(event) {
        if (event.target === $modal[0]) {
            $modal.css("display", "none");
        }
    });

    // Best Score 
    const $bestScoreDisplay = $("#best-score-display");
    const $bestScoreValue = $("#best-score-value");
    const $bestScoreCategory = $("#best-score-category");

    $("#best-score-btn").on("click", function() {
        $.ajax({
            url: "get_best_score.php",
            method: "GET",
            dataType: "json",
            success: function(data) {
                if (data.hasScore) {
                    const categories = {
                        'f': 'Films et Séries',
                        's': 'Sport',
                        'l': 'Littérature',
                        'm': 'Musique'
                    };
                    $bestScoreValue.text(data.score);
                    $bestScoreCategory.text(categories[data.categorie] || 'Catégorie inconnue');
                    $bestScoreDisplay.slideDown(300).delay(3000).slideUp(300);
                } else {
                    alert("Vous n'avez pas encore joué à un quiz !");
                }
            },
            error: function() {
                alert("Erreur lors de la récupération du score");
            }
        });
    });

    // Classement avec fermeture automatique 
    const $classementSection = $("#classement-section");
    const $classementListe = $("#classement-liste");
    let classementTimeout;

    $("#classement-btn").on("click", function() {
        clearTimeout(classementTimeout);

        if ($classementSection.is(":visible")) {
            $classementSection.slideUp(300);
            return;
        }

        $classementSection.slideDown(300);
        $classementListe.empty();

        $.ajax({
            url: "get_classement.php",
            method: "GET", "dataType": "json",
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                    $classementSection.slideUp(300);
                    return;
                }

                if (data.classement && data.classement.length > 0) {
                    $.each(data.classement, function(index, item) {
                        $classementListe.append(`<li>${htmlspecialchars(item.username)} - Score: <strong>${htmlspecialchars(item.meilleur_score)}</strong></li>`);
                    });
                } else {
                    $classementListe.append("<li>Aucun score enregistré</li>");
                }

                classementTimeout = setTimeout(function() {
                    $classementSection.slideUp(300);
                }, 3000);
            },
            error: function() {
                alert("Erreur lors du chargement du classement");
                $classementSection.slideUp(300);
            }
        });
    });

    $(window).on("click", function(event) {
        if ($classementSection.is(":visible") &&
            !$(event.target).closest("#classement-section, #classement-btn").length) {
            $classementSection.slideUp(300);
            clearTimeout(classementTimeout);
        }
    });

    // Ajouter des amis
    const $ajouterAmisBtn = $("#ajouter-amis-btn");
    const $modalAjouterAmis = $("#modal-ajouter-amis");
    const $closeAjouterAmisModal = $("#close-ajouter-amis-modal");
    const $listeUtilisateurs = $("#liste-utilisateurs");

    if ($ajouterAmisBtn.length) {
        $ajouterAmisBtn.on("click", function() {
            $listeUtilisateurs.empty();
            $.ajax({
                url: 'get_users.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.users && data.users.length > 0) {
                        $.each(data.users, function(index, user) {
                            $listeUtilisateurs.append(`
                                <li>
                                    ${htmlspecialchars(user.username)}
                                    <button class="ajouter-ami-btn" data-user-id="${user.id}">Ajouter</button>
                                </li>
                            `);
                        });
                        $listeUtilisateurs.on('click', '.ajouter-ami-btn', function() {
                            const friendId = $(this).data('user-id');
                            $.ajax({
                                url: 'ajouter_ami.php',
                                method: 'POST',
                                dataType: 'json',
                                data: { friend_id: friendId },
                                success: function(response) {
                                    if (response.success) {
                                        alert(response.success);
                                        $modalAjouterAmis.css("display", "none");
                                    } else if (response.error) {
                                        alert(response.error);
                                    } else if (response.info) {
                                        alert(response.info);
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.error("Erreur lors de l'ajout d'ami : " + textStatus, errorThrown);
                                    alert("Erreur lors de l'ajout de l'ami.");
                                }
                            });
                        });
                    } else if (data.error) {
                        alert(data.error);
                    } else {
                        $listeUtilisateurs.append("<li>Aucun autre utilisateur trouvé.</li>");
                    }
                    $modalAjouterAmis.css("display", "block");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de la récupération des utilisateurs : " + textStatus, errorThrown);
                    alert("Erreur lors du chargement de la liste des utilisateurs.");
                }
            });
        });
    }

    $closeAjouterAmisModal.on("click", function() {
        $modalAjouterAmis.css("display", "none");
    });

    $(window).on("click", function(event) {
        if (event.target === $modalAjouterAmis[0]) {
            $modalAjouterAmis.css("display", "none");
        }
    });
});