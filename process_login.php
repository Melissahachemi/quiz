<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['username']; // Le champ s'appelle "username" dans le HTML mais contient un email
    $password = $_POST['password'];

    // Préparer la requête SQL pour chercher par email uniquement
    $sql = "SELECT id, username, email, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Erreur de préparation de la requête : " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: dashboard.php?login_success=1');
            exit();
        } else {
            // Mauvais mot de passe
            header('Location: index.php?error=invalid_credentials');
            exit();
        }
    } else {
        // Aucun utilisateur trouvé
        header('Location: index.php?error=no_user');
        exit();
    }
} else {
    // Accès direct au fichier sans POST
    header('Location: index.php');
    exit();
}
?>