<!-- Page d'inscription -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire - MYqwiz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Gestion des messages d'erreur et de succès -->
    <?php
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                
                    switch ($error) {
                        case 'empty_fields':
                            echo '<p class="error-message">Veuillez remplir tous les champs.</p>';
                            break;
                        case 'invalid_email':
                            echo '<p class="error-message">Adresse email invalide.</p>';
                            break;
                        case 'password_mismatch':
                            echo '<p class="error-message">Les mots de passe ne correspondent pas.</p>';
                            break;
                        case 'user_exists':
                            echo '<p class="error-message">Un compte avec ce nom ou email existe déjà.</p>';
                            break;
                        case 'insert_failed':
                            echo '<p class="error-message">Erreur lors de l\'enregistrement. Veuillez réessayer.</p>';
                            break;
                        default:
                            echo '<p class="error-message">Erreur inconnue.</p>';
                            break;
                    }
                } elseif (isset($_GET['signup_success']) && $_GET['signup_success'] === '1') {
                    echo '<p class="success-message">Inscription réussie ! Vous pouvez maintenant vous connecter.</p>';
                }
                
                
            ?>
    <div class="logo-container"> <!-- Conteneur pour le logo -->
        <img src="logo.png" alt="Logo MYqwiz" class="top-right-logo">
    </div>
    
    <div class="page-container"> <!-- Conteneur principal de la page -->
        <div class="right-content">
            <p class="slogan">Fais partie de l'aventure MYqwiz !</p>
            <img src="mario.jpg" alt="supermario" class="mario">
        </div>
        <div class="login-container">
            <h2>Créer un compte MYqwiz</h2>
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