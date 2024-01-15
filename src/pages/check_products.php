<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."database/database.php");
	require_once(VarUtils::getDocumentRoot()."error/error_handler.php");
    ErrorHandler::init();

    function fail(){
        echo json_encode(array("status" => "error"));
        exit(1);
    }

    if(!$JSON = file_get_contents("php://input"))
        fail();

    $productIds = json_decode($JSON);
    $db = new Database();
    $db->connect();
    $query = $db->prepare("SELECT id FROM products WHERE id = ?");
    foreach($productIds as $productId){
        $productId = intval($productId);
        if($productId == 0){
            $query->close();
            $db->close();
            fail();
        }
        $db->bindParam($query, 'i', $productId);
        $db->execute($query);
        if($db->getResult($query)->num_rows != 1){
            $query->close();
            $db->close();
            fail();
        }
    }
    $query->close();
    $db->close();
    echo json_encode(array("status" => "ok"));