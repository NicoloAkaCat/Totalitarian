<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."database/database.php");
	require_once(VarUtils::getDocumentRoot()."error/error_handler.php");
    ErrorHandler::init();
    Session::startSession();

    if(!$JSON = file_get_contents("php://input"))
        ErrorHandler::displayJsonError("Internal Error", 500);

    $productIds = json_decode($JSON);
    $db = new Database();
    $db->connect();
    $query = $db->prepare("SELECT id FROM products WHERE id = ?");
    foreach($productIds as $productId){
        $productId = intval($productId);
        if($productId == 0){
            $query->close();
            $db->close();
            ErrorHandler::displayJsonError("Internal Error", 500);
        }
        $db->bindParam($query, 'i', $productId);
        $db->execute($query);
        if($db->getResult($query)->num_rows != 1){
            $query->close();
            $db->close();
            ErrorHandler::displayJsonError("Try cleaning your localstorage", 409);
        }
    }
    $query->close();
    $db->close();
    echo json_encode(array("status" => "ok"));