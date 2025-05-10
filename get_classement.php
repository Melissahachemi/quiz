<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

$user_id_connecte = $_SESSION['user_id'];

$response = [
    'classement' => [],
    'error' => null
];

$liste_amis_ids = [$user_id_connecte];

// Récupérer les IDs des amis
$query_amis = "SELECT friend_id FROM friends WHERE user_id = ?";
$stmt_amis = mysqli_prepare($conn, $query_amis);
mysqli_stmt_bind_param($stmt_amis, "i", $user_id_connecte);
mysqli_stmt_execute($stmt_amis);
mysqli_stmt_bind_result($stmt_amis, $ami_id);

while (mysqli_stmt_fetch($stmt_amis)) {
    $liste_amis_ids[] = $ami_id;
}
mysqli_stmt_close($stmt_amis);

$classement_data = [];

// Récupérer le meilleur score et le nom d'utilisateur pour chaque ami (et l'utilisateur connecté)
$placeholders = implode(',', array_fill(0, count($liste_amis_ids), '?'));
$query_classement = "SELECT u.username, MAX(s.score) AS meilleur_score
                     FROM scores s
                     JOIN users u ON s.user_id = u.id
                     WHERE s.user_id IN ($placeholders)
                     GROUP BY u.id
                     ORDER BY meilleur_score DESC";

$stmt_classement = mysqli_prepare($conn, $query_classement);

if ($stmt_classement) {
    mysqli_stmt_bind_param($stmt_classement, str_repeat('i', count($liste_amis_ids)), ...$liste_amis_ids);
    mysqli_stmt_execute($stmt_classement);
    mysqli_stmt_bind_result($stmt_classement, $username, $meilleur_score);

    while (mysqli_stmt_fetch($stmt_classement)) {
        $classement_data[] = [
            'username' => htmlspecialchars($username),
            'meilleur_score' => intval($meilleur_score)
        ];
    }
    mysqli_stmt_close($stmt_classement);
} else {
    $response['error'] = "Erreur lors de la préparation de la requête de classement : " . mysqli_error($conn);
}

$response['classement'] = $classement_data;

mysqli_close($conn);

echo json_encode($response);
?>