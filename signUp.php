<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire - MYqwiz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="logo-container">
        <img src="logo.png" alt="Logo MYqwiz" class="top-right-logo">
    </div>
    
    <div class="page-container">
        <div class="right-content">
            <p class="slogan">Fais partie de l'aventure MYqwiz !</p>
            <img src="mario.jpg" alt="supermario" class="mario">
        </div>
        <div class="login-container">
            <h2>Créer un compte MYqwiz</h2>
            <?php
                // Affichage des erreurs d'inscription s'il y en a
                if (isset($_GET['error']) && $_GET['error'] === '1' && isset($_GET['error'])) {
                    foreach ($_GET['error'] as $error) {
                        echo '<p class="error-message">' . htmlspecialchars($error) . '</p>';
                    }
                } elseif (isset($_GET['signup_success']) && $_GET['signup_success'] === '1') {
                    echo '<p class="success-message">Inscription réussie ! Vous pouvez maintenant vous connecter.</p>';
                }
            ?>
            <form action="process_signup.php" method="post">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur:</label>
                    <input type="text" id="username" name="username" placeholder="Votre pseudo" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Votre email" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe:</label>
                    <div class="password-container">
        <input type="password" id="password" name="password" placeholder="Mot de passe" required>
        <button type="button" id="togglePassword-signup">Afficher</button>
    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe:</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Répétez le mot de passe" required>
                </div>
                <button type="submit">S'inscrire</button>
            </form>
            <div class="signup-link">
                Déjà un compte ? <a href="index.php">Se connecter</a>
            </div>
        </div>
    </div>
    <script src="qwiz.js"></script>

</body>
</html>
