<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."database/database.php");
	require_once(VarUtils::getDocumentRoot()."error/error_handler.php");
    ErrorHandler::init();
    
    function fail(){
        echo json_encode(array("status" => "error"));
        exit(1);
    }

    if (!VarUtils::checkIsSetInArray($_GET, "email"))
        fail();

    $email = $_GET["email"];
    $db = new Database();
    $db->connect();
    $query = $db->prepare("SELECT * FROM users WHERE email = ?");
    $db->bindParam($query, "s", $email);
    $db->execute($query);
    $result = $db->getResult($query);
    $query->close();
    $db->close();

    $response = array();
    if($result->num_rows > 0)
        $response["exists"] = true;
    else
        $response["exists"] = false;

    echo json_encode($response);
?>