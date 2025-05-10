<?php
session_start();
require_once 'db_connect.php';
require_once 'quiz_common.php';

$categories = [
    'films' => ['name' => 'Films', 'icon' => 'film'],
    'literature' => ['name' => 'Littérature', 'icon' => 'book'],
    'musique' => ['name' => 'Musique', 'icon' => 'music'],
    'sport' => ['name' => 'Sports', 'icon' => 'running']
];

// Compter les questions par catégorie
$counts = [];
foreach ($categories as $key => $_) {
    $code = getCategoryCode($key);
    $count = $conn->query("SELECT COUNT(*) FROM questions WHERE categorie = '$code'")->fetch_row()[0];
    $counts[$key] = $count;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégories | MYqwiz</title>
    <link rel="stylesheet" href="quiz.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="categories-container">
        <h1>Choisissez une catégorie</h1>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="error">
                <?= $_GET['error'] === 'no_questions' ? 'Aucune question disponible' : 'Catégorie invalide' ?>
            </div>
        <?php endif; ?>

        <div class="categories-grid">
            <?php foreach ($categories as $key => $cat): ?>
                <a href="quiz.php?category=<?= $key ?>&mode=solo" class="category-card <?= $counts[$key] === 0 ? 'disabled' : '' ?>">
                    <i class="fas fa-<?= $cat['icon'] ?>"></i>
                    <h2><?= $cat['name'] ?></h2>
                    <span><?= $counts[$key] ?> questions</span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>