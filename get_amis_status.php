<?php
session_start();
require_once 'db_connect.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $query_amis = "SELECT u.id, u.username, u.online
                   FROM friends f
                   INNER JOIN users u ON (f.friend_id = u.id AND f.user_id = ?) OR (f.user_id = u.id AND f.friend_id = ?)
                   WHERE (f.user_id = ? OR f.friend_id = ?) AND u.id != ?";
    $stmt_amis = mysqli_prepare($conn, $query_amis);
    mysqli_stmt_bind_param($stmt_amis, "iiiii", $user_id, $user_id, $user_id, $user_id, $user_id);
    mysqli_stmt_execute($stmt_amis);
    mysqli_stmt_bind_result($stmt_amis, $ami_id, $ami_username, $ami_online);

    $amis_data = [];
    while (mysqli_stmt_fetch($stmt_amis)) {
        $amis_data[] = ['id' => $ami_id, 'username' => htmlspecialchars($ami_username), 'online' => (bool) $ami_online];
    }
    mysqli_stmt_close($stmt_amis);

    header('Content-Type: application/json');
    echo json_encode(['amis' => $amis_data]);
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Utilisateur non connecté.']);
}

mysqli_close($conn);
?>