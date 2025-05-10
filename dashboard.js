$(document).ready(function() {
    // Amis en ligne
    const amisEnLigne = ["Alice", "Bob", "Charlie"];
    const $amisEl = $("#amis-en-ligne");
    const $modal = $("#modal-amis");
    const $closeModal = $("#close-modal");
    const $listeAmis = $("#liste-amis");

    if ($amisEl.length) {
        $amisEl.on("click", function() {
            $listeAmis.empty();
            $.each(amisEnLigne, function(index, ami) {
                $listeAmis.append($("<li>").text(ami));
            });
            $modal.css("display", "block");
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
        // Annuler le timeout précédent s'il existe
        clearTimeout(classementTimeout);
        
        // Si le classement est déjà visible, on le cache immédiatement
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
                        $classementListe.append(
                            `<li>${item.username} - Score: <strong>${item.meilleur_score}</strong></li>`
                        );
                    });
                } else {
                    $classementListe.append("<li>Aucun score enregistré</li>");
                }
                
                // Fermer automatiquement après 3 secondes (3000ms)
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

    // Fermer aussi si on clique en dehors
    $(window).on("click", function(event) {
        if ($classementSection.is(":visible") && 
            !$(event.target).closest("#classement-section, #classement-btn").length) {
            $classementSection.slideUp(300);
            clearTimeout(classementTimeout);
        }
    });
});