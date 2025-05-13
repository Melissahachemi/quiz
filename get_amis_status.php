<?php
// Script pour récupérer la liste des amis et leur statut (en ligne ou hors ligne)
    session_start();
    require_once 'db_connect.php';

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        // Récupérer la liste des amis de l'utilisateur et leur statut en ligne
        $query_amis = "SELECT DISTINCT u.id, u.username, u.online
                    FROM friends f
                    INNER JOIN users u ON f.friend_id = u.id
                    WHERE f.user_id = ?";
        $stmt_amis = mysqli_prepare($conn, $query_amis); 
        mysqli_stmt_bind_param($stmt_amis, "i", $user_id); 
        mysqli_stmt_execute($stmt_amis);
        mysqli_stmt_bind_result($stmt_amis, $ami_id, $ami_username, $ami_online); // Récupère les résultats
        // Tableau pour stocker les amis et leur statut
        $amis_data = [];
        while (mysqli_stmt_fetch($stmt_amis)) {
            $amis_data[] = ['id' => $ami_id, 'username' => htmlspecialchars($ami_username), 'online' => (bool) $ami_online];
        }
        mysqli_stmt_close($stmt_amis);

        header('Content-Type: application/json'); 
        echo json_encode(['amis' => $amis_data]); // Envoie la réponse au format JSON
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Utilisateur non connecté.']);
    }

    mysqli_close($conn);
?>