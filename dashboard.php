<?php
session_start();
if (!isset($_SESSION['nom_utilisateur'])) {
    header("Location: login.php");
    exit();
}
$nom_utilisateur = $_SESSION['nom_utilisateur'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tableau de bord - MYqwiz</title>
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>

  <div class="dashboard-header">
    <div class="left">
      <h1>Bienvenue, <?php echo htmlspecialchars($nom_utilisateur); ?> 👋</h1>
      <p>Prête à tester tes connaissances ?</p>
    </div>
    <div class="right">
      <form action="logout.php" method="post">
        <button type="submit" class="logout-button">Déconnexion</button>
      </form>
    </div>
  </div>

  <div class="dashboard-container">
    <div class="button-group">
      <a href="new_game_page.php" class="btn">🎮 Lancer un quiz</a>
      <a href="mes_scores.php" class="btn">📊 Mes scores</a>
      <a href="classement.php" class="btn">🏆 Classement</a>
    </div>

    <div class="extras">
      <p>📚 Envie d’apprendre en t’amusant ?</p>
      <a href="profil.php">Voir mon profil</a>
    </div>
  </div>

</body>
</html>
