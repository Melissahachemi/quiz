<?php
session_start();
require_once 'db_connect.php';

// Mettre à jour le statut de l'utilisateur hors ligne
if (isset($_SESSION['user_id'])) {
    $sql = "UPDATE users SET online = 0 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
}

session_destroy();
header('Location: index.php?logout_success=1');
exit();
?>
