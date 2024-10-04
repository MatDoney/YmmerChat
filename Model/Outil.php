<?php

/*
 * Fichier contenant toutes les methodes outil
 */

function PdoInit(): object {
    try {


        include "../../bdd/db_settings.php";

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
        // Data Source Name
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Mode de rapport d'erreur
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Mode de récupération par défaut
            PDO::ATTR_EMULATE_PREPARES => false, // Désactiver l'émulation de requêtes préparées
        ];

        $pdo = new PDO($dsn, $user, $pass, $options); // Création de l'objet PDO
        return $pdo;
    } catch (Exception $ex) {
        return $ex;
    }
}

/*
 * Compare la derniere session utilisateur avec l'actuel 
 */

function VerifSession(PDO $pdo): bool {
    if (!isset($_SESSION["user_id"]) || !isset($_SESSION["token"])) {
        return false;
    } else {
        $requete = "select token from user where user_id = :user_id";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $_SESSION["token"] == $result[token];
    }
}
