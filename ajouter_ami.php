<?php
/*
 * Script pour ajouter un ami dans la base de données.
 * Vérifie si l'utilisateur est authentifié et si l'ami existe.
 * Si l'ami n'existe pas, renvoie une erreur.
 * Si l'ami existe déjà, renvoie un message d'information.
 * Sinon, ajoute l'ami dans les deux sens.
 */

    session_start();
    require_once 'db_connect.php';

    // Vérification de la session
    if (!isset($_SESSION['user_id'])) {
        header('HTTP/1.1 401 Unauthorized');
        echo json_encode(['error' => 'Non authentifié']);
        exit();
    }
    // Vérification de la méthode de requête et si l'ami est spécifié
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['friend_id'])) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['error' => 'Requête invalide']);
        exit();
    }
   
    header('Content-Type: application/json');

    $my_id = $_SESSION['user_id'];
    $friend_id = (int)$_POST['friend_id'];

    // Vérification si l'ami est le même que l'utilisateur
    if ($my_id === $friend_id) {
        echo json_encode(['error' => 'Auto-ajout impossible']);
        exit();
    }

    // Requête pour vérifier si l'utilisateur existe
    $check_user = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $check_user->bind_param("i", $friend_id);
    $check_user->execute();

    // Cas ou l'utilisateur n'existe pas
    if ($check_user->get_result()->num_rows === 0) {
        echo json_encode(['error' => 'Utilisateur introuvable']);
        $check_user->close();
        exit();
    }
    $check_user->close();

    // Vérification si l'utilisateur est déjà ami
    $check_friendship = $conn->prepare("SELECT 1 FROM friends 
                                    WHERE (user_id = ? AND friend_id = ?) 
                                    OR (user_id = ? AND friend_id = ?)");
    $check_friendship->bind_param("iiii", $my_id, $friend_id, $friend_id, $my_id);
    $check_friendship->execute();

    if ($check_friendship->get_result()->num_rows > 0) {
        echo json_encode(['info' => 'Déjà amis']);
        $check_friendship->close();
        exit();
    }
    $check_friendship->close();

    // Création de l'amitié 
    try {
        $conn->begin_transaction();
        
        // Insertion dans les deux sens pour optimisation des requêtes
        $stmt1 = $conn->prepare("INSERT INTO friends (user_id, friend_id, friendship_date) VALUES (?, ?, NOW())");
        $stmt2 = $conn->prepare("INSERT INTO friends (user_id, friend_id, friendship_date) VALUES (?, ?, NOW())");
        
        $stmt1->bind_param("ii", $my_id, $friend_id);
        $stmt2->bind_param("ii", $friend_id, $my_id);
        
        $stmt1->execute();
        $stmt2->execute();
        
        $conn->commit();
        
        echo json_encode(['success' => 'Ami ajouté avec succès']);   
    } catch (Exception $e) {
        $conn->rollback();
        error_log("Erreur ajout ami: " . $e->getMessage());
        echo json_encode(['error' => 'Erreur technique']);
    } finally {
        if (isset($stmt1)) $stmt1->close();
        if (isset($stmt2)) $stmt2->close();
        $conn->close();
    }
?>