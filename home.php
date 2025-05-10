<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de jeu - MYqwiz</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <?php
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit();
        }
    ?>
    <div class="home-container">
        <h1 class="welcome-title">Nouvelle partie 🎉</h1>
        <p class="welcome-subtitle">Choisissez un thème pour lancer une partie solo</p>

        <div class="cards-container">
            <a href="quiz_sport.php?mode=solo" class="card solo-play" data-category="sport" data-mode="solo">
                <h2>Sport 🏀</h2>
                <p>Relève les défis sportifs les plus fous !</p>
            </a>

            <a href="quiz_films.php?mode=solo" class="card solo-play" data-category="films" data-mode="solo">
                <h2>Films / Séries 🎬</h2>
                <p>Connaisseur ou binge-watcher ? À toi de jouer !</p>
            </a>

            <a href="quiz_music.php?mode=solo" class="card solo-play" data-category="music" data-mode="solo">
                <h2>Musique </h2>
                <p>Montre que tu es un vrai mélomane !</p>
            </a>

            <a href="quiz_books.php?mode=solo" class="card solo-play" data-category="books" data-mode="solo">
                <h2>Littérature 📚</h2>
                <p>Plonge dans les mondes fascinants des livres !</p>
            </a>
        </div>

        <div class="back-to-dashboard">
            <a href="dashboard.php">Retour au Tableau de Bord</a>
        </div>

    </div>
    <form action="logout.php" method="post" id="lg" style="margin-top: 20px;">
        <button type="submit" class="logout-button">Déconnexion</button>
    </form>
    <script>
        // Ce script n'est plus nécessaire pour la sélection du mode de jeu.
        // Vous pouvez le supprimer si vous n'avez pas d'autres fonctionnalités dans home.js.
        // Si vous le conservez, assurez-vous qu'il ne contient pas de code qui interfère
        // avec la redirection directe vers le quiz solo.
        // Par exemple, vous pourriez commenter ou supprimer les event listeners
        // liés aux boutons de mode de jeu et aux clics sur les cartes.
        // document.addEventListener('DOMContentLoaded', function() {
        //     const playBtn = document.getElementById('play-btn');
        //     const playOnlineBtn = document.getElementById('play-online-btn');
        //     const themeSelectionTitle = document.querySelector('.theme-selection-title');
        //     const cardsContainer = document.querySelector('.cards-container');
        //     const soloPlayCards = document.querySelectorAll('.solo-play');

        //     if (playBtn) {
        //         playBtn.addEventListener('click', function() {
        //             themeSelectionTitle.style.display = 'block';
        //             cardsContainer.style.display = 'grid';
        //             // Retirer l'affichage des boutons de mode
        //             const gameModeSelection = document.querySelector('.game-mode-selection');
        //             if (gameModeSelection) {
        //                 gameModeSelection.style.display = 'none';
        //             }
        //         });
        //     }

        //     if (playOnlineBtn) {
        //         playOnlineBtn.style.display = 'none'; // Cacher le bouton "Jouer en VS"
        //     }

        //     soloPlayCards.forEach(card => {
        //         card.addEventListener('click', function(event) {
        //             const category = this.dataset.category;
        //             window.location.href = `quiz_${category}.php?mode=solo`;
        //         });
        //     });
        // });
    </script>
</body>
</html>