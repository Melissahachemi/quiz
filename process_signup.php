<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Inclure le fichier de connexion à la base de données 
require_once 'db_connect.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Tableau pour stocker les erreurs
    $errors = [];

    // Vérification de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }

    // Vérification de la longueur du mot de passe (minimum 6 caractères par exemple)
    if (strlen($password) < 6) {
        $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
    }

    // Vérification si les mots de passe correspondent
    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // Vérifier si l'email existe déjà dans la base de données
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "Cet email est déjà utilisé.";
    }

    // S'il n'y a pas d'erreurs, enregistrer l'utilisateur
    if (empty($errors)) {
        // Hacher le mot de passe de manière sécurisée
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Préparer la requête d'insertion
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);

        // Exécuter la requête
        if ($stmt->execute()) {
            // Rediriger vers une page de succès ou la page de connexion
            header('Location: index.php?signup_success=1');
            exit();
        } else {
            // En cas d'erreur lors de l'enregistrement
            $errors[] = "Une erreur est survenue lors de la création du compte.";
        }
    }

    // S'il y a des erreurs, rediriger vers la page d'inscription avec les erreurs
    if (!empty($errors)) {
        $error_string = implode('&error[]=', $errors);
        header('Location: signup.php?error=1&error[]=' . $error_string);
        exit();
    }
} else {
    // Si on accède à ce fichier sans soumettre le formulaire
    header('Location: signup.php');
    exit();
}
?>