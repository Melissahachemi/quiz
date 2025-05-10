<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - MYqwiz</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <?php
        session_start();
        require_once 'db_connect.php';
        $user_id = $_SESSION['user_id'];

        $query_username = "SELECT username FROM users WHERE id = ?";
        $stmt_username = mysqli_prepare($conn, $query_username);
        mysqli_stmt_bind_param($stmt_username, "i", $user_id);
        mysqli_stmt_execute($stmt_username);
        mysqli_stmt_bind_result($stmt_username, $username);
        mysqli_stmt_fetch($stmt_username);
        mysqli_stmt_close($stmt_username);

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
            <button class="btn" id="best-score-btn">📊 Best Score</button>
            <button class="btn" id="classement-btn">🏆 Classement</button>
        </div>

        <div id="best-score-display" class="extras" style="display:none; text-align: center; margin-top: 20px;">
            <h3>🏆 Votre Meilleur Score</h3>
            <p>Score : <strong id="best-score-value"></strong></p>
            <p>Catégorie : <strong id="best-score-category"></strong></p>
        </div>

        <div id="classement-section" class="extras" style="display:none; margin-top: 20px;">
            <h3>🏆 Classement des Meilleurs Scores</h3>
            <ol id="classement-liste"></ol>
        </div>

        <div class="extras amis-en-ligne" id="amis-en-ligne">
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