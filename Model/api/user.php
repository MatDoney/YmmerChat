<?php

/*
 * Route d'api de la table User
 */
header('Content-Type: application/json');
include '../Outil.php';
$pdo = PdoInit();
$requestMethod = $_SERVER['REQUEST_METHOD'];

if (isset($_POST["user_id"])) {
    $user_id = $_POST["user_id"];
}
if (isset($_POST["username"])) {
    $username = $_POST["username"];
}
if (isset($_POST["email"])) {
    $email = $_POST["email"];
}
if (isset($_POST["nom"])) {
    $nom = $_POST["nom"];
}
if (isset($_POST["premom"])) {
    $prenom = $_POST["premom"];
}
if (isset($_POST["num"])) {
    $num = $_POST["num"];
}
if (isset($_POST["password"])) {
    $password = $_POST["password"];
}
if (isset($_POST["searchby"])) {
    $searchby = $_POST["searchby"];
}









switch ($requestMethod) {
    // ------ ROUTE GET -----
    case 'GET':
        var_dump($pdo);

        break;
    // ------ FIN ROUTE GET -----
    // ------ ROUTE POST -----
    case 'POST':
        try {
            echo json_encode($_POST);
            if (!isset($user_id)) {
                $request = "insert into user (username,email,nom,prenom,num,password) 
                    values (:username,:email,:nom,:prenom,:num,:password)";
                $stmt = $pdo->prepare($request);

                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                $stmt->bindParam(':num', $num, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->execute();
            } else if (isset($user_id)) {
                $request = "update user 
                            set username = :username,email = :email,nom =:nom,prenom = :prenom,num=:num,password = :password
                            where user_id = :user_id ";
                $stmt = $pdo->prepare($request);

                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                $stmt->bindParam(':num', $num, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                $stmt->execute();
            } else {
                throw new Exception("Valeur non défini");
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo $e->getMessage();
        }

        break;
    // ------ FIN ROUTE POST -----
    // ------ ROUTE PUT -----
    case 'PUT':

        break;

    // ------ FIN ROUTE PUT -----
    // ------ ROUTE DELETE -----
    case 'DELETE':


        break;
    // ----- FIN ROUTE DELETE -----
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
        break;
}