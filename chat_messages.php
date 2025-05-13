<?php
/**
 * Script de gestion du système de messagerie instantanée entre utilisateurs:
 * - Envoi de messages (via requête POST),
 * - Récupération des derniers messages échangés entre deux utilisateurs (via requête GET),
 * - Communication avec la base de données pour stocker et lire les messages.
 */

    session_start();
    require_once 'db_connect.php'; // Connexion à la base de données

    // Vérifie si l'utilisateur est authentifié (session active)
    if (!isset($_SESSION['user_id'])) {
        header('HTTP/1.1 401 Unauthorized'); // Erreur 401 si non connecté
        echo json_encode(['error' => 'Non authentifié']);
        exit();
    }

    // Fonction pour ajouter un message dans la base de données
    function addMessageToDB($senderId, $receiverId, $message, $conn) {
        $stmt = $conn->prepare("INSERT INTO chat_messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $senderId, $receiverId, $message);
        $stmt->execute();
        $stmt->close();
    }

    // Fonction pour récupérer les derniers messages échangés entre deux utilisateurs
    function getMessagesFromDB($userId, $otherUserId, $conn) {
        $stmt = $conn->prepare("SELECT cm.message, cm.timestamp, u.username AS sender_username, cm.sender_id
                            FROM chat_messages cm
                            JOIN users u ON cm.sender_id = u.id
                            WHERE (cm.sender_id = ? AND cm.receiver_id = ?)
                                OR (cm.sender_id = ? AND cm.receiver_id = ?)
                            ORDER BY cm.timestamp ASC
                            LIMIT 50"); // Limite à 50 messages les plus anciens au plus récents
        $stmt->bind_param("iiii", $userId, $otherUserId, $otherUserId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $messages = [];

        // Stocke les messages dans un tableau associatif
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
        $stmt->close();
        return $messages;
    }

    // Traitement de l'envoi d'un nouveau message (requête POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && isset($_POST['receiver_id'])) {
        $senderId = $_SESSION['user_id'];
        $receiverId = (int)$_POST['receiver_id'];
        $message = trim($_POST['message']); // Supprime les espaces inutiles

        // Vérifie que le message est non vide, que l'ID du destinataire est valide et que l'utilisateur ne s'envoie pas un message à lui-même
        if (!empty($message) && $receiverId > 0 && $senderId !== $receiverId) {
            addMessageToDB($senderId, $receiverId, $message, $conn); // Ajout à la base de données
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Message invalide ou destinataire incorrect.']);
        }
        exit();
    }

    // Traitement de la récupération des messages (requête GET)
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get' && isset($_GET['receiver_id'])) {
        $userId = $_SESSION['user_id'];
        $receiverId = (int)$_GET['receiver_id'];

        // Vérifie que l'ID du destinataire est valide
        if ($receiverId > 0) {
            $messagesData = getMessagesFromDB($userId, $receiverId, $conn);

            // Formate les messages en HTML avec indication de l'expéditeur
            $formattedMessages = array_map(function($msg) use ($userId) {
                $isCurrentUser = ($msg['sender_id'] === $userId);
                return '<div class="message ' . ($isCurrentUser ? 'sent' : 'received') . '">
                            <strong>' . htmlspecialchars($msg['sender_username']) . ':</strong> ' . 
                            htmlspecialchars($msg['message']) . ' 
                            <small>(' . date('H:i', strtotime($msg['timestamp'])) . ')</small>
                        </div>';
            }, $messagesData);

            echo json_encode(['messages' => implode('', $formattedMessages)]);
        } else {
            echo json_encode(['messages' => '']); // Aucun message si l'ID n'est pas valide
        }
        exit();
    }

    // Cas où aucune requête valide n'est reconnue
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Requête invalide.']);
    $conn->close(); // Fermeture de la connexion à la base de données
?>
