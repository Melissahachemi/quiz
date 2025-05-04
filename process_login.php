<?php
session_start(); // Démarrer la session pour stocker les informations de l'utilisateur connecté
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = $_POST['username']; // L'utilisateur peut entrer son nom d'utilisateur ou son email
    $password = $_POST['password'];

    $errors = [];

    // Rechercher l'utilisateur par nom d'utilisateur ou email
    $stmt = $pdo->prepare("SELECT id, username, email, password FROM users WHERE username = :username OR email = :email");
    $stmt->bindParam(':username', $usernameOrEmail);
    $stmt->bindParam(':email', $usernameOrEmail);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        // Vérifier le mot de passe haché
        if (password_verify($password, $user['password'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            // Rediriger vers la page d'accueil ou une autre page sécurisée
            header('Location: home.php?login_success=1'); // Créez une page home.php
            exit();
        } else {
            // Mot de passe incorrect
            header('Location: index.php?error=invalid_credentials');
            exit();
        }
    } else {
        // Utilisateur non trouvé
        header('Location: index.php?error=invalid_credentials');
        exit();
    }
} else {
    // Si on accède à ce fichier sans soumettre le formulaire
    header('Location: index.php');
    exit();
}
?>