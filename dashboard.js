$(document).ready(function() {
    const $modal = $("#modal-amis");
    const $closeModal = $("#close-modal");
    const $listeAmis = $("#liste-amis");
    const $amisBtn = $("#amis-btn");

    if ($amisBtn.length) {
        $amisBtn.on("click", function() {
            $listeAmis.empty();
            $.ajax({
                url: 'get_amis_status.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.amis && data.amis.length > 0) {
                        $.each(data.amis, function(index, ami) {
                            const statusClass = ami.online ? 'online' : 'offline';
                            $listeAmis.append(`<li><span class="status-indicator ${statusClass}"></span>${htmlspecialchars(ami.username)}</li>`);
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
            method: "GET",
            dataType: "json",
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
                        // Ajouter un gestionnaire d'événements délégué pour les boutons "Ajouter" créés dynamiquement
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
                                        $modalAjouterAmis.css("display", "none"); // Fermer la modal après l'ajout
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
});