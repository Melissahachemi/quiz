<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

require_once 'db_connect.php';

$nombre_questions = 10;
$temps_limite = 120; // en secondes

// Fonction pour récupérer les questions (peut être placée ici)
function getQuestions($conn, $categorie, $nombre_questions) {
    $sql_ids = "SELECT id FROM questions WHERE categorie = '$categorie'";
    $result_ids = mysqli_query($conn, $sql_ids);
    $ids = [];
    while ($row = mysqli_fetch_assoc($result_ids)) {
        $ids[] = $row['id'];
    }

    shuffle($ids);
    $ids_selectionnes = array_slice($ids, 0, $nombre_questions);

    $questions = [];
    $placeholders = implode(',', array_fill(0, count($ids_selectionnes), '?'));
    $sql_questions = "SELECT * FROM questions WHERE id IN ($placeholders)";
    $stmt = mysqli_prepare($conn, $sql_questions);

    $types = str_repeat('i', count($ids_selectionnes));
    mysqli_stmt_bind_param($stmt, $types, ...$ids_selectionnes);

    mysqli_stmt_execute($stmt);
    $result_questions = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result_questions)) {
        $questions[] = $row;
    }

    return $questions;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="quiz_style.css">  </head>
</head>
<body>

<p>Temps restant : <span id="timer"><?php echo $temps_limite; ?></span> secondes</p>

<form id="quiz-form" action="traitement_quiz.php" method="post">