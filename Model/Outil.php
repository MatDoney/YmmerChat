<?php

/*
 * Fichier contenant toutes les methodes outil
 */

function PdoInit(): object
{
    try {


        include $_SERVER['DOCUMENT_ROOT'] . "/bdd/db_settings.php";

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



function GetUrl(): string
{

    // Obtenir le protocole (http ou https)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    // Obtenir le nom de domaine
    $host = $_SERVER['HTTP_HOST'];

    // Construire l'URL de la racine
    $rootUrl = $protocol . $host;

    // Afficher l'URL racine
    return $rootUrl;
}

function UpdateUser($username, $email, $nom, $prenom, $num, $user_id, $password, $passwordConfirm): bool
{
    try {
        $pdo = PdoInit();

        $request = "update user 
                    set username = :username,email = :email,nom =:nom, prenom = :prenom,num=:num
                    where user_id = :user_id ;";
        $stmt = $pdo->prepare($request);

        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':num', $num, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $password = password_hash($password, PASSWORD_DEFAULT);
        if ($password != '') {
            if ($password == $passwordConfirm) {

                $request = "update user 
                            set password = :password
                            where user_id = :user_id ";
                $stmt = $pdo->prepare($request);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->execute();

            }

        }
        return true;
    } catch (PDOException $e) {
        return false;
    }
}
function GetUserInfo($user_id): array
{
    $pdo = PdoInit();
    $request = "select * from user where user_id = :user_id;";
    $stmt = $pdo->prepare($request);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function VerifyConnexion(): void
{
    if (!isset($_GET['debug'])) {
        
        if (!isset($_SESSION['user_id']))  {
            ?>
            <meta http-equiv="refresh" content="0;url=login.php">
            <?php
        }
    }
}

function IsParticipant($user_id, $conv_id)
{
    $pdo = PdoInit();
    $request = "select * from participant where user_id = :user_id && conversation_id = :conversation_id";
    $stmt = $pdo->prepare($request);

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':conversation_id', $conv_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    if (empty($result)) {
        ?>
            <meta http-equiv="refresh" content="0;url=home.php">
            <?php
    }

}