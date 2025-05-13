<?php
    /*
        Script pour récupérer les questions utilisées dans tous les quiz
    */
    session_start();

    // Si l'utilisateur n'est pas connecté, il est redirigé vers la page d'accueil
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit(); 
    }

    require_once 'db_connect.php';

    // Nombre de questions à récupérer pour le quiz
    $nombre_questions = 10;
    // Temps limite pour le quiz en secondes
    $temps_limite = 120;

    /*
        Fonction pour récupérer un nombre donné de questions d'une catégorie spécifique
        - $conn : connexion à la base de données
        - $categorie : la catégorie de questions à cibler
        - $nombre_questions : le nombre de questions souhaité
    */
    function getQuestions($conn, $categorie, $nombre_questions) {
        // Requête pour obtenir tous les IDs des questions correspondant à la catégorie
        $sql_ids = "SELECT id FROM questions WHERE categorie = '$categorie'";
        $result_ids = mysqli_query($conn, $sql_ids);

        $ids = [];
        // Parcourt les résultats et stocke chaque ID dans un tableau
        while ($row = mysqli_fetch_assoc($result_ids)) {
            $ids[] = $row['id'];
        }

        // Mélange les IDs pour créer un ordre aléatoire
        shuffle($ids); 

        // Sélectionne uniquement les premiers $nombre_questions IDs
        $ids_selectionnes = array_slice($ids, 0, $nombre_questions);

        $questions = [];

        // Préparation de la requête SQL pour récupérer les questions dont l'ID est dans la liste sélectionnée
        // Utilisation de "?" pour éviter les injections SQL 
        $placeholders = implode(',', array_fill(0, count($ids_selectionnes), '?'));
        $sql_questions = "SELECT * FROM questions WHERE id IN ($placeholders)";
        $stmt = mysqli_prepare($conn, $sql_questions);

        // Prépare le type de chaque paramètre (i = integer) pour le bind_param
        $types = str_repeat('i', count($ids_selectionnes));
        mysqli_stmt_bind_param($stmt, $types, ...$ids_selectionnes);

        // Exécution de la requête préparée
        mysqli_stmt_execute($stmt);

        // Récupération des résultats
        $result_questions = mysqli_stmt_get_result($stmt);

        // Remplissage du tableau $questions avec les données extraites
        while ($row = mysqli_fetch_assoc($result_questions)) {
            $questions[] = $row;
        }
        
        return $questions;
    }
?>
