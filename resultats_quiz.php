<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_GET['score'])) {
    header('Location: index.php');
    exit();
}

$score = $_GET['score'];
$duree = $_GET['duree'];
$categorie = $_GET['categorie'];

require_once 'db_connect.php';
$sql_categorie = "SELECT name FROM categories WHERE code = '$categorie'";
$result_categorie = mysqli_query($conn, $sql_categorie);
$nom_categorie = mysqli_fetch_assoc($result_categorie)['name'] ?? 'Inconnu';
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats du Quiz</title>
    <link rel="stylesheet" href="quiz_resultat.css">

    </head>
<body>
    <div class="logo-container">
        <img src="logo.png" alt="Logo MYqwiz" class="top-right-logo">
    </div>
    
        <div class="right-content">
        <p class="slogan">Mission accomplie ! Vos neurones ont brillamment relevé le défi</p>
        <img src="mario.jpg" alt="supermario" class="mario">
</div>
<h1 >Résultats du Quiz <?php echo htmlspecialchars($nom_categorie); ?></h1>

<div class="r">
    

    <p class="res">Votre score : <?php echo $score; ?> / 10</p>
    <p class="res">Durée : <?php echo $duree; ?> secondes</p>

    
</div>
<div class="footer">
    <a class="f" href="home.php">Rejouer</a>
    <form action="logout.php" method="post" class="f">
        <button type="submit" class="logout-button">Déconnexion</button>

    </form>

    

    <div id="modal-amis" class="modal" class="f">
        <div class="modal-content">
            <span class="close" id="close-modal">&times;</span>
            <h2>Amis en ligne</h2>
            <ul id="liste-amis"></ul>
        </div>
    </div>

</div>
<script src="dashboard.js"></script>
</body>
</html>