<?php
// Script de connexion à la base de données MySQL
    $host = 'localhost';
    $dbname = 'qwiz';
    $username = 'root';
    $password = 'vomounix23_';

    // Connexion avec MySQLi en mode procédural
    $conn = mysqli_connect($host, $username, $password, $dbname);

    // Vérification de la connexion
    if (!$conn) {
        die("Erreur de connexion à la base de données : " . mysqli_connect_error());
    }

    // Définir l'encodage des caractères
    mysqli_set_charset($conn, "utf8");
?>
