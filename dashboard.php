<!DOCTYPE html>
<html lang="fr">
    <head>
    <meta charset="UTF-8">
    <title>Tableau de bord - MYqwiz</title>
    <link rel="stylesheet" href="dashboard.css">
    </head>
    <body>
        <?php 
            session_start(); 
        ?>

        <div class="dashboard-header">
            <div class="left">
            <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h1>
            </div>
            <div class="bio-section">
                <h3>🖊️ Votre biographie :</h3>

                <?php
                require_once 'db_connect.php';
                $user_id = $_SESSION['user_id'];

                // Récupérer la bio actuelle de l'utilisateur
                $query = "SELECT bio FROM users WHERE id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "i", $user_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $bio);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);
                ?>

                <form method="post" action="update_bio.php">
                    <textarea name="bio" rows="2" cols="30" placeholder="Ajoutez une bio..."><?php echo htmlspecialchars($bio); ?></textarea><br>
                    <button type="submit" id="btn_b">Mettre à jour</button>
                </form>
            </div>

        </div>

        <div class="dashboard-container">
            <div class="button-group">
            <a href="home.php" class="btn">🎮 Lancer un quiz</a>
            <span class="btn">📊 Best Score</span>
            <span class="btn">🏆 Classement</span>
            </div>

            <div class="extras">
            <!-- Modification ici -->
                <p id="amis-en-ligne" class="amis-en-ligne">
                <strong>👥 Amis en ligne :</strong> <span id="nbr-en-ligne">3</span>
                </p>
            </div>
        </div>

    <!-- Modale personnalisée -->
        <div id="modal-amis" class="modal">
            <div class="modal-content">
            <span class="close" id="close-modal">&times;</span>
            <h2>Amis en ligne</h2>
            <ul id="liste-amis"></ul>
            </div>
        </div>

        <div class="dashboard-footer">
            <form action="logout.php" method="post">
            <button type="submit" class="logout-button">Déconnexion</button>
            </form>
        </div>

        <!-- Script Javascript -->
        <script src="dashboard.js"></script>
    </body>
</html>