<!DOCTYPE html>
<html lang="fr">
    <head>
    <meta charset="UTF-8">
    <title>Tableau de bord - MYqwiz</title>
    <link rel="stylesheet" href="dashboard.css">
    </head>
    <body>

        <div class="dashboard-header">
            <div class="left">
            <h1>Bienvenue, <?php echo htmlspecialchars($nom_utilisateur); ?> 👋</h1>
            <p>entrer your bio : </p>
            </div>
        </div>

        <div class="dashboard-container">
            <div class="button-group">
            <a href="new_game_page.php" class="btn">🎮 Lancer un quiz</a>
            <a href="mes_scores.php" class="btn">📊 Mes scores</a>
            <a href="classement.php" class="btn">🏆 Classement</a>
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