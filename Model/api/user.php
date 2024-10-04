<?php

/*
 * Route d'api de la table User
 */
header('Content-Type: application/json');
include '../Outil.php';
$pdo = PdoInit();
$requestMethod = $_SERVER['REQUEST_METHOD'];

if (isset($_REQUEST["user_id"])) {
    $user_id = $_REQUEST["user_id"];
}
if (isset($_REQUEST["username"])) {
    $username = $_REQUEST["username"];
}
if (isset($_REQUEST["email"])) {
    $email = $_REQUEST["email"];
}
if (isset($_REQUEST["nom"])) {
    $nom = $_REQUEST["nom"];
}
if (isset($_REQUEST["premom"])) {
    $prenom = $_REQUEST["premom"];  
}
if (isset($_REQUEST["num"])) {
    $num = $_REQUEST["num"];
}
if (isset($_REQUEST["password"])) {
    $password = $_REQUEST["password"];
}
if (isset($_REQUEST["searchby"])) {
    $searchby = $_REQUEST["searchby"];
}





switch ($requestMethod) {
    // ------ ROUTE GET -----
    case 'GET':
        try {
            
        //RECHERCHE PAR ID
            if (isset($user_id) && $searchby == "user_id") {
                $request = "select * from user where user_id = :user_id;";
                $stmt = $pdo->prepare($request);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
            }
            //FIN RECHERCHE PAR ID
        //RECHERCHE PAR USERNAME A FINIR
            else if (isset($username) && $searchby == "username") {
                
                $request = "select * from user where username like :username;";
                $stmt = $pdo->prepare($request);
                $username = "%" . $username . "%";
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->execute();
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
            } 
            else if ($searchby == "all") {
                
                $request = "select * from user ";
                $stmt = $pdo->prepare($request);
                
                $stmt->execute();
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
            } else {
                throw new Exception("Utilisateur n'existe pas");
            }
            //FIN RECHERCHE PAR USERNAME
        } catch (Exception $e) {
            http_response_code(500);
            echo '{"Erreur":"'.$e->getMessage().'"}';
        }
        
        

        break;
    // ------ FIN ROUTE GET -----
    // ------ ROUTE POST -----
    case 'POST':
        try {

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
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                throw new Exception("Valeur non défini");
            }
            echo '{"status":"ok"}';
        } catch (Exception $e) {
            http_response_code(500);
            echo '{"Erreur":"'.$e->getMessage().'"}';
        }

        break;
    // ------ FIN ROUTE POST -----
    // ------ ROUTE PUT -----
    case 'PUT':

        break;

    // ------ FIN ROUTE PUT -----
    // ------ ROUTE DELETE -----
    case 'DELETE':
        try {
            if (isset($user_id)) {
                $request = "delete from user where user_id = :user_id;";
                $stmt = $pdo->prepare($request);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                throw new Exception("Utilisateur n'existe pas");
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo '{"Erreur":"'.$e->getMessage().'"}';
        }


        break;
    // ----- FIN ROUTE DELETE -----
    default:
        http_response_code(405);
        echo json_encode(['Erreur' => 'Méthode non autorisée']);
        break;
}