<!DOCTYPE html>
<html lang="fr">
    <head>
    <meta charset="UTF-8">
    <title>Se connecter - MYqwiz</title>
    <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <div class="logo-container">
        <img src="logo.png" alt="Logo MYqwiz" class="top-right-logo">
    </div>

    <div class="page-container">
        <div class="right-content">
        <p class="slogan">Rejoins la communauté des esprits curieux !</p>
        <img src="mario.jpg" alt="supermario" class="mario">
        </div>

        <div class="login-container">
        <h2>Se connecter à MYqwiz</h2>
        <?php
            if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials') {
                echo '<p class="error-message">Email ou mot de passe incorrect.</p>';
            }elseif(isset($_GET['error'])&& $_GET['error']==='no_user'){
                echo '<p class="error-message">Utilisateur existe pas ! creer un compte .</p>';
 

            }
        ?>
        <form action="process_login.php" method="post">
            <div class="form-group">
            <label for="username">Email :</label>
            <input type="email" id="username" name="username" placeholder="email@gmail.com" required>
            </div>
            <div class="form-group">
            <label for="password">Mot de passe :</label>
            <div class="password-container">
                <input type="password" id="password" name="password" placeholder="Mot de passe" required>
                <button type="button" id="togglePassword-login">Afficher</button>
            </div>
            </div>
            <button type="submit">Se connecter</button>
        </form>
        <div class="signup-link">
            Pas encore de compte ? <a href="signUp.php">S'inscrire</a>
        </div>
        </div>
    </div>

    <script src="qwiz.js"></script>
    </body>
</html>
