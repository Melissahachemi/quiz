<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['user_id'])) {
    $bio = trim($_POST['bio']);
    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE users SET bio = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $bio, $user_id);
    mysqli_stmt_execute($stmt);

    // Retour au dashboard avec un succès
    header("Location: dashboard.php?bio_updated=1");
    exit();
} else {
    // Pas autorisé
    header("Location: dashboard.php?error=unauthorized");
    exit();
}
