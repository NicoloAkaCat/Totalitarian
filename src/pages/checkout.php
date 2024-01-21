<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."database/database.php");
	require_once(VarUtils::getDocumentRoot()."error/error_handler.php");
    ErrorHandler::init();
    Session::startSession();

    if(!VarUtils::checkIsSetInArray($_SESSION, "UID")){
        Session::setSessionVar("redirect", "/Totalitarian/src/pages/cart.php");
        echo json_encode(array("status" => "redirect"));
        exit(1);
    }

    if(!$JSON = file_get_contents("php://input"))
        ErrorHandler::displayJsonError("Internal Error", 500);

    $data = json_decode($JSON, true);
    if($data == null)
        ErrorHandler::displayJsonError("Internal Error", 500);
    
    foreach($data['productIds'] as $productIdString){
        $productId = intval($productIdString);
        if($productId == 0)
            ErrorHandler::displayJsonError("Internal Error", 500);
        $quantity = intval($data['quantities'][$productIdString]);
        if($quantity == 0)
            ErrorHandler::displayJsonError("Internal Error", 500);
        //TODO insert order
    }
    