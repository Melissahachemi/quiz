<?php
session_start();
require_once 'db_connect.php'; // Assurez-vous que la connexion à la base de données est incluse

if (!isset($_SESSION['user_id'])) {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['error' => 'Non authentifié']);
    exit();
}

// Fonction pour ajouter un message à la base de données
function addMessageToDB($senderId, $receiverId, $message, $conn) {
    $stmt = $conn->prepare("INSERT INTO chat_messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $senderId, $receiverId, $message);
    $stmt->execute();
    $stmt->close();
}

// Fonction pour récupérer les messages entre deux utilisateurs
function getMessagesFromDB($userId, $otherUserId, $conn) {
    $stmt = $conn->prepare("SELECT cm.message, cm.timestamp, u.username AS sender_username, cm.sender_id
                           FROM chat_messages cm
                           JOIN users u ON cm.sender_id = u.id
                           WHERE (cm.sender_id = ? AND cm.receiver_id = ?)
                              OR (cm.sender_id = ? AND cm.receiver_id = ?)
                           ORDER BY cm.timestamp ASC
                           LIMIT 50"); // Limiter le nombre de messages
    $stmt->bind_param("iiii", $userId, $otherUserId, $otherUserId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    $stmt->close();
    return $messages;
}

// Gestion de l'envoi de message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && isset($_POST['receiver_id'])) {
    $senderId = $_SESSION['user_id'];
    $receiverId = (int)$_POST['receiver_id'];
    $message = trim($_POST['message']);

    if (!empty($message) && $receiverId > 0 && $senderId !== $receiverId) {
        addMessageToDB($senderId, $receiverId, $message, $conn);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Message invalide ou destinataire incorrect.']);
    }
    exit();
}

// Gestion de la récupération des messages
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get' && isset($_GET['receiver_id'])) {
    $userId = $_SESSION['user_id'];
    $receiverId = (int)$_GET['receiver_id'];
    if ($receiverId > 0) {
        $messagesData = getMessagesFromDB($userId, $receiverId, $conn);
        $formattedMessages = array_map(function($msg) use ($userId) {
            $isCurrentUser = ($msg['sender_id'] === $userId);
            return '<div class="message ' . ($isCurrentUser ? 'sent' : 'received') . '"><strong>' . htmlspecialchars($msg['sender_username']) . ':</strong> ' . htmlspecialchars($msg['message']) . ' <small>(' . date('H:i', strtotime($msg['timestamp'])) . ')</small></div>';
        }, $messagesData);
        echo json_encode(['messages' => implode('', $formattedMessages)]);
    } else {
        echo json_encode(['messages' => '']); // Ou un message indiquant de sélectionner un utilisateur
    }
    exit();
}

// Si aucune action n'est spécifiée
header('HTTP/1.1 400 Bad Request');
echo json_encode(['error' => 'Requête invalide.']);
$conn->close();
?>