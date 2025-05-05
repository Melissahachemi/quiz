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
    </head>
<body>

<div>
    <h1>Résultats du Quiz <?php echo htmlspecialchars($nom_categorie); ?></h1>

    <p>Votre score : <?php echo $score; ?> / 10</p>
    <p>Durée : <?php echo $duree; ?> secondes</p>

    <a href="home.php">Retour à l'accueil</a>
</div>

</body>
</html>