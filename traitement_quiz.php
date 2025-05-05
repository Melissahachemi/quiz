<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['quiz_questions'])) {
    header('Location: index.php');
    exit();
}

$questions = $_SESSION['quiz_questions'];
$score = 0;
$categorie = $_POST['categorie'];

foreach ($questions as $index => $question) {
    $nom_reponse = "reponse" . $index;
    if (isset($_POST[$nom_reponse]) && $_POST[$nom_reponse] == $question['bonne_reponse']) {
        $score++;
    }
}

$temps_debut = $_SESSION['quiz_start_time'];
$temps_fin = time();
$duree = $temps_fin - $temps_debut;

require_once 'db_connect.php';
$user_id = $_SESSION['user_id'];
$sql_insert_score = "INSERT INTO scores (user_id, score, duree, categorie, date_partie) VALUES (?, ?, ?, ?, NOW())";
$stmt_insert_score = mysqli_prepare($conn, $sql_insert_score);
mysqli_stmt_bind_param($stmt_insert_score, "iiis", $user_id, $score, $duree, $categorie);
mysqli_stmt_execute($stmt_insert_score);

mysqli_close($conn);

unset($_SESSION['quiz_questions']);
unset($_SESSION['quiz_start_time']);
unset($_SESSION['quiz_end_time']);

header("Location: resultats_quiz.php?score=$score&duree=$duree&categorie=$categorie");
exit();
?>