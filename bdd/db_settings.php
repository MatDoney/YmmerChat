<?php
$host = 'localhost'; // Adresse de l'hôte
$db = 'YmmerChat'; // Nom de la base de données
$user = 'YmmerUser'; // Nom d'utilisateur
$pass = 'Arachnide'; // Mot de passe
$charset = 'utf8mb4'; // Jeu de caractères
$port = '3306'; // Port

// Connexion à la base de données avec PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
?>