<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des champs du formulaire
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation basique (tu peux en ajouter plus)
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        header('Location: signUp.php?error=empty_fields');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: signUp.php?error=invalid_email');
        exit();
    }

    if ($password !== $confirm_password) {
        header('Location: signUp.php?error=password_mismatch');
        exit();
    }

    // Vérifie si l'email ou le nom d'utilisateur existe déjà
    $sql_check = "SELECT id FROM users WHERE email = ? OR username = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    if (!$stmt_check) {
        die("Erreur lors de la préparation : " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_check, "ss", $email, $username);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        header('Location: signUp.php?error=user_exists');
        exit();
    }

    // Hachage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertion du nouvel utilisateur
    $sql_insert = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    if (!$stmt_insert) {
        die("Erreur lors de la préparation : " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_insert, "sss", $username, $email, $hashed_password);
    if (mysqli_stmt_execute($stmt_insert)) {
        // Inscription réussie → redirige vers login
        header('Location: index.php?signup_success=1');
        exit();
    } else {
        header('Location: signUp.php?error=insert_failed');
        exit();
    }

} else {
    header('Location: signUp.php');
    exit();
}
?>
