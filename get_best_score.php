<?php
// Script pour récupérer le meilleur score d'un utilisateur
// Utilisé pour afficher le meilleur score d'un utilisateur sur le tableau de bord
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

$user_id = $_SESSION['user_id'];
// Réponse par défaut si aucun score n'est trouvé
$response = [ 
    'score' => 0, 
    'categorie' => 'Aucun quiz joué',
    'hasScore' => false 
];
// Requête pour récupérer le meilleur score de l'utilisateur
$query = "SELECT categorie, score FROM scores WHERE user_id = ? ORDER BY score DESC LIMIT 1";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $categorie, $score);
    
    if (mysqli_stmt_fetch($stmt)) {
        $response = [
            'score' => $score,
            'categorie' => $categorie,
            'hasScore' => true
        ];
    }
    mysqli_stmt_close($stmt);
}

echo json_encode($response); // Envoie la réponse au format JSON
?>