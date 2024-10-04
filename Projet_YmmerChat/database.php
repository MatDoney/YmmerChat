<?php
// Fichier: db.php

$host = 'localhost';
$dbname = 'chat_db';
$user = 'root'; // Remplace par tes identifiants MySQL
$password = ''; // Remplace par ton mot de passe MySQL

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
