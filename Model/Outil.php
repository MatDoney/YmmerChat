<?php
/*
 * Fichier contenant toutes les methodes outil
 */

function PdoInit(): PDO {
    try {


        include "/bdd/db_settings";

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
        return $ex->getMessage();
    }
    
}





