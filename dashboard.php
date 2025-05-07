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
        require_once 'db_connect.php';
        $user_id = $_SESSION['user_id'];

        // Récupérer le nom d'utilisateur
        $query_username = "SELECT username FROM users WHERE id = ?";
        $stmt_username = mysqli_prepare($conn, $query_username);
        mysqli_stmt_bind_param($stmt_username, "i", $user_id);
        mysqli_stmt_execute($stmt_username);
        mysqli_stmt_bind_result($stmt_username, $username);
        mysqli_stmt_fetch($stmt_username);
        mysqli_stmt_close($stmt_username);

        // Récupérer la bio actuelle de l'utilisateur
        $query_bio = "SELECT bio FROM users WHERE id = ?";
        $stmt_bio = mysqli_prepare($conn, $query_bio);
        mysqli_stmt_bind_param($stmt_bio, "i", $user_id);
        mysqli_stmt_execute($stmt_bio);
        mysqli_stmt_bind_result($stmt_bio, $bio);
        mysqli_stmt_fetch($stmt_bio);
        mysqli_stmt_close($stmt_bio);
    ?>

    <div class="dashboard-header">
        <div class="left">
            <h1>Bienvenue, <?php echo htmlspecialchars($username); ?> 👋</h1>
        </div>
        <div class="bio-section">
            <h3>🖊️ Votre biographie :</h3>
            <form method="post" action="update_bio.php">
                <textarea name="bio" rows="2" cols="30" placeholder="Ajoutez une bio..."><?php echo htmlspecialchars($bio); ?></textarea><br>
                <button type="submit" id="btn_b">Mettre à jour</button>
            </form>
        </div>
        <form action="logout.php" method="post">
            <button type="submit" class="logout-button">Déconnexion</button>
        </form>
    </div>

    <div class="dashboard-container">
        <div class="button-group">
            <a href="home.php" class="btn">🎮 Lancer un quiz</a>
            <span class="btn">📊 Best Score</span>
            <span class="btn">🏆 Classement</span>
        </div>

        <div class="extras amis-en-ligne">
            <p>
                <strong>👥 Amis en ligne :</strong> <span id="nbr-en-ligne">3</span>
            </p>
        </div>
    </div>

    <div id="modal-amis" class="modal">
        <div class="modal-content">
            <span class="close" id="close-modal">&times;</span>
            <h2>Amis en ligne</h2>
            <ul id="liste-amis"></ul>
        </div>
    </div>

    <script src="dashboard.js"></script>
</body>
</html>