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
        // Démarrage ou reprise de la session
        session_start();
        // Vérification si l'ID de l'utilisateur n'est pas défini dans la session
        if (!isset($_SESSION['user_id'])) {
            // Redirection vers la page d'index si l'utilisateur n'est pas connecté
            header('Location: index.php');
            // Arrêt de l'exécution du script
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
                <h2>Musique</h2>
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
</body>
</html>