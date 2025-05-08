<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil - MYqwiz</title>
  <link rel="stylesheet" href="home.css">
</head>
<body>

<div class="home-container">
  <h1 class="welcome-title">Bienvenue sur MYqwiz 🎉</h1>
  <p class="welcome-subtitle">Choisissez votre catégorie de quiz :</p>

  <div class="cards-container">
    <a href="quiz_sport.php" class="card">
      <h2>Sport 🏀</h2>
      <p>Relève les défis sportifs les plus fous !</p>
    </a>

    <a href="quiz_films.php" class="card">
      <h2>Films / Séries 🎬</h2>
      <p>Connaisseur ou binge-watcher ? À toi de jouer !</p>
    </a>

    <a href="quiz_music.php" class="card">
      <h2>Musique 🎵</h2>
      <p>Montre que tu es un vrai mélomane !</p>
    </a>

    <a href="quiz_books.php" class="card">
      <h2>Littérature 📚</h2>
      <p>Plonge dans les mondes fascinants des livres !</p>
    </a>
  </div>

</div>
<a href="logout.php" id="deconnection">Se déconnecter</a>

</body>
</html>