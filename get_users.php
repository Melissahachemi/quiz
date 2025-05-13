<?php
// Script pour récupérer les utilisateurs qui ne sont pas amis avec l'utilisateur connecté
    session_start();
    require_once 'db_connect.php';

    // Vérifie si l'utilisateur est connecté
    if (isset($_SESSION['user_id'])) {
        $user_id_connecte = $_SESSION['user_id'];

        // Requête SQL pour sélectionner les utilisateurs qui ne sont PAS amis avec l'utilisateur connecté
        $query_users = "SELECT u.id, u.username
                        FROM users u
                        WHERE u.id != ?
                        AND u.id NOT IN (SELECT f.friend_id FROM friends f WHERE f.user_id = ?
                                        UNION
                                        SELECT f.user_id FROM friends f WHERE f.friend_id = ?)";

        $stmt_users = mysqli_prepare($conn, $query_users);
        mysqli_stmt_bind_param($stmt_users, "iii", $user_id_connecte, $user_id_connecte, $user_id_connecte);
        mysqli_stmt_execute($stmt_users);
        mysqli_stmt_bind_result($stmt_users, $user_id_liste, $username_liste);

        $users_data = [];
        while (mysqli_stmt_fetch($stmt_users)) {
            $users_data[] = ['id' => $user_id_liste, 'username' => htmlspecialchars($username_liste)];
        }
        mysqli_stmt_close($stmt_users);
        // Envoie la réponse au format JSON
        header('Content-Type: application/json');
        echo json_encode(['users' => $users_data]);

    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Utilisateur non connecté.']);
    }

    mysqli_close($conn);
?>