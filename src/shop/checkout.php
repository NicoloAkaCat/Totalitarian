<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."database/database.php");
	require_once(VarUtils::getDocumentRoot()."error/error_handler.php");
    ErrorHandler::init();
    Session::startSession();

    // check if user is logged
    if(!VarUtils::checkIsSetInArray($_SESSION, "UID")){
        Session::setSessionVar("redirect", "/Totalitarian/src/shop/cart.php");
        echo json_encode(array("status" => "redirect"));
        exit(1);
    }

    if(!$JSON = file_get_contents("php://input"))
        ErrorHandler::displayJsonError("Internal Error", 500);
    $data = json_decode($JSON, true);
    if($data == null)
        ErrorHandler::displayJsonError("Internal Error", 500);
    function fail($db, ...$queries){
        $db->rollback();
        $db->close();
        foreach($queries as $query)
            $query->close();
    }
    
    $db = new Database();
    $db->connect();
    $db->beginTransaction();

    $queryInsertOrder = $db->prepare("INSERT INTO Orders (buyer, ordered_on, estimated_shipping) VALUES (?, ?, ?)");
    $db->bindParam($queryInsertOrder, "sii", Session::getSessionVar("email"), time(), time() + 60 * 60 * 24 * 90);
    $db->execute($queryInsertOrder);
    if($queryInsertOrder->affected_rows != 1){
        fail($db, $queryInsertOrder);
        ErrorHandler::displayJsonError("Internal Error", 500);
    }
    $queryInsertOrder->close();

    $orderId = $db->getInsertId();
    $queryRemoveStock = $db->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
    $queryInsertProducts = $db->prepare("INSERT INTO OrderProducts (order_id, product, ordered_quantity) VALUES (?, ?, ?)");

    foreach($data['productIds'] as $productIdString){
        $productId = intval($productIdString);
        if($productId == 0){
            fail($db, $queryRemoveStock, $queryInsertProducts);
            ErrorHandler::displayJsonError("Internal Error", 500);
        }
        $quantity = intval($data['quantities'][$productIdString]);
        if($quantity == 0){
            fail($db, $queryRemoveStock, $queryInsertProducts);
            ErrorHandler::displayJsonError("Internal Error", 500);
        }

        $db->bindParam($queryRemoveStock, "ii", $quantity, $productId);
        $db->execute($queryRemoveStock);
        if($queryRemoveStock->affected_rows != 1){
            fail($db, $queryRemoveStock, $queryInsertProducts);
            echo json_encode(array("status" => "outOfStock", "outOfStock" => $productId));
            exit(1);
        }
        $db->bindParam($queryInsertProducts, "iii", $orderId, $productId, $quantity);
        $db->execute($queryInsertProducts);
        if($queryInsertProducts->affected_rows != 1){
            fail($db, $queryRemoveStock, $queryInsertProducts);
            ErrorHandler::displayJsonError("Internal Error", 500);
        }
    }

    $queryRemoveStock->close();
    $queryInsertProducts->close();
    $db->commit();
    $db->close();
    echo json_encode(array("status" => "ok"));