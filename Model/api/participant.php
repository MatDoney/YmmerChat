<?php

/*
 * 
 */

include '../Outil.php';
$pdo = PdoInit();
$requestMethod = $_SERVER['REQUEST_METHOD'];
if (isset($_REQUEST["conv_id"])) {
    $conv_id = $_REQUEST["conv_id"];
}
if (isset($_REQUEST["user_id"])) {
    $user_id = $_REQUEST["user_id"];
}
if (isset($_REQUEST["searchby"])) {
    $searchby = $_REQUEST["searchby"];
}

switch ($requestMethod) {
    // ------ ROUTE GET -----
    case 'GET':


        break;
    // ------ FIN ROUTE GET -----
    // ------ ROUTE POST -----
    case 'POST':
        try {
            //verification si le participant n'existe pas déja
            $request = "select * from participant where user_id = :user_id && conversation_id = :conversation_id";
            $stmt = $pdo->prepare($request);

            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':conversation_id', $conv_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                //creation du participant
                $request = "insert into participant (user_id,conversation_id) 
                    values (:user_id,:conversation_id)";
                $stmt = $pdo->prepare($request);

                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':conversation_id', $conv_id, PDO::PARAM_INT);
                $stmt->execute();
            }else {
                throw new Exception("Utilisateur participe déja à la conversation");
            }
            echo '{"status":"ok"}';
        } catch (Exception $e) {
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
        echo json_encode(['error' => 'Méthode non autorisée']);
        break;
}