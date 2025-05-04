<?php
session_start();

// Supposons que tu récupères les identifiants envoyés via le formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Exemple simple de vérification (à adapter avec base de données)
    // Ici, on suppose que le nom d'utilisateur est 'yasmine' et le mot de passe est '1234'
    if ($username === 'yasmine' && $password === '1234') {
        $_SESSION['nom_utilisateur'] = $username;  // On enregistre le nom dans la session
        header('Location: dashboard.php');    // Redirection vers la page d'accueil
        exit();
    } else {
        $error_message = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter - MYqwiz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="logo-container">
        <img src="logo.png" alt="Logo MYqwiz" class="top-right-logo">
    </div>
    
    <div class="page-container">
        <div class="right-content">
            <p class="slogan">Rejoins la communauté des esprits curieux !!</p>
            <img src="mario.jpg" alt="supermario" class="mario">
        </div>
        <div class="login-container">
            <h2>Se connecter à MYqwiz</h2>
            <?php
                // Affichage des erreurs de connexion s'il y en a
                if (isset($error_message)) {
                    echo '<p class="error-message">' . $error_message . '</p>';
                }
            ?>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur ou Email:</label>
                    <input type="text" id="username" name="username" placeholder="email@gmail.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe:</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Mot de passe" required>
                        <button type="button" id="togglePassword-login">Afficher</button>
                    </div>
                </div>
                <button type="submit">Se connecter</button>
            </form>
            <div class="signup-link">
                Pas encore de compte? <a href="signup.php">S'inscrire</a>
            </div>
        </div>
    </div>
    <script src="qwiz.js"></script>
</body>
</html>
