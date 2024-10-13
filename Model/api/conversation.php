<?php

/*
 * 
 */
header('Content-Type: application/json');
include '../Outil.php';
$pdo = PdoInit();
$requestMethod = $_SERVER['REQUEST_METHOD'];

if (isset($_REQUEST["conv_id"])) {
    $conv_id = $_REQUEST["conv_id"];
}
if (isset($_REQUEST["name"])) {
    $name = $_REQUEST["name"];
}
if (isset($_REQUEST["author"])) {
    $author = $_REQUEST["author"];
}
if (isset($_REQUEST["created_at"])) {
    $created_at = $_REQUEST["created_at"];
}
if (isset($_REQUEST["searchby"])) {
    $searchby = $_REQUEST["searchby"];
}
if (isset($_REQUEST["user_id"])) {
    $user_id = $_REQUEST["user_id"];
}



switch ($requestMethod) {
    // ------ ROUTE GET -----
    case 'GET':
        $request = "select * from conversation where conv_id = :conversation_id";
                $stmt = $pdo->prepare($request);
                $stmt->bindParam(':conversation_id', $conv_id, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($result);

        break;
    // ------ FIN ROUTE GET -----
    // ------ ROUTE POST -----
    case 'POST':

        try {
            //si la conversation n'existe pas
            if (!isset($conv_id)) {

                //creation du participant a partir de l'auteur";
                $request = "insert into participant (user_id,conversation_id) 
                    values (:user_id,null)";
                $stmt = $pdo->prepare($request);

                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->execute();
                $participant_id = $pdo->lastInsertId();
                //création de la conversation";
                $request = "insert into conversation (name,author) 
                    values (:name,:author)";
                $stmt = $pdo->prepare($request);

                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':author', $participant_id, PDO::PARAM_INT);

                $stmt->execute();
                $conv_id = $pdo->lastInsertId();
                //on assigne au participant la conversation";
                $request = "update participant 
                            set conversation_id = :conv_id
                            where participant_id = :participant_id ";
                $stmt = $pdo->prepare($request);

                $stmt->bindParam(':participant_id', $participant_id, PDO::PARAM_STR);
                $stmt->bindParam(':conv_id', $conv_id, PDO::PARAM_STR);
                $stmt->execute();
                //Si la conversation existe déja
            } else if (isset($conv_id) && isset($name)) {
                $request = "update conversation 
                            set name = :name
                            where conv_id = :conv_id ";
                $stmt = $pdo->prepare($request);

                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':conv_id', $conv_id, PDO::PARAM_INT);
                
                $stmt->execute();
            }else if (isset($conv_id)) {
                $request = "update conversation 
                            set name = :name,author = :author
                            where conv_id = :conv_id ";
                $stmt = $pdo->prepare($request);

                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':conv_id', $conv_id, PDO::PARAM_INT);
                $stmt->bindParam(':author', $author, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                throw new Exception("Valeur non défini");
            }
            echo '{"status":"ok"}';
        } catch (Exception $e) {
            http_response_code(500);
            echo '{"Erreur":"' . $e->getMessage() . '"}';
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
        echo json_encode(['Erreur' => 'Méthode non autorisée']);
        break;
}