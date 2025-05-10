<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - MYqwiz</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        /* Style pour l'indicateur de statut */
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%; /* Pour créer un cercle */
            margin-right: 8px;
        }

        /* Couleur pour les amis en ligne */
        .status-indicator.online {
            background-color: green;
        }

        /* Couleur pour les amis hors ligne */
        .status-indicator.offline {
            background-color: red;
        }
    </style>
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

        // Récupérer la liste des amis avec leur statut en ligne
        $query_amis = "SELECT u.id, u.username, u.online
                       FROM friends f
                       INNER JOIN users u ON (f.friend_id = u.id AND f.user_id = ?) OR (f.user_id = u.id AND f.friend_id = ?)
                       WHERE (f.user_id = ? OR f.friend_id = ?) AND u.id != ?";
        $stmt_amis = mysqli_prepare($conn, $query_amis);
        mysqli_stmt_bind_param($stmt_amis, "iiiii", $user_id, $user_id, $user_id, $user_id, $user_id);
        mysqli_stmt_execute($stmt_amis);
        mysqli_stmt_bind_result($stmt_amis, $ami_id, $ami_username, $ami_online);

        $liste_amis_data = [];
        while (mysqli_stmt_fetch($stmt_amis)) {
            $liste_amis_data[] = ['id' => $ami_id, 'username' => htmlspecialchars($ami_username), 'online' => $ami_online];
        }
        mysqli_stmt_close($stmt_amis);
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
            <div id="best-score-container">
                <div id="best-score-display" class="extras" style="display:none; text-align: center; margin-bottom: 10px;">
                    <h3>🏆 Votre Meilleur Score</h3>
                    <p>Score : <strong id="best-score-value"></strong></p>
                    <p>Catégorie : <strong id="best-score-category"></strong></p>
                </div>
                <button class="btn" id="best-score-btn">📊 Best Score</button>
            </div>
            <div id="classement-container">
                <div id="classement-section" class="extras" style="display:none; margin-bottom: 10px;">
                    <h3>🏆 Classement des Meilleurs Scores</h3>
                    <ol id="classement-liste"></ol>
                </div>
                <button class="btn" id="classement-btn">🏆 Classement</button>
            </div>
            <div class="amis-group">
                <button class="btn small-btn" id="amis-btn">👥 Amis</button>
                <button class="btn small-btn" id="ajouter-amis-btn">➕ Ajouter</button>
            </div>
        </div>
    </div>

    <div id="modal-amis" class="modal">
        <div class="modal-content">
            <span class="close" id="close-modal">&times;</span>
            <h2>Amis</h2>
            <ul id="liste-amis">
                <?php foreach ($liste_amis_data as $ami): ?>
                    <li>
                        <span class="status-indicator <?php echo $ami['online'] ? 'online' : 'offline'; ?>"></span>
                        <?php echo $ami['username']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div id="modal-ajouter-amis" class="modal">
        <div class="modal-content">
            <span class="close" id="close-ajouter-amis-modal">&times;</span>
            <h2>Ajouter des amis</h2>
            <ul id="liste-utilisateurs">
            </ul>
        </div>
    </div>

    <div class="dashboard-container">
        <div id="chat-area"></div>
    </div>  
    <script src="dashboard.js"></script>
</body>
</html>