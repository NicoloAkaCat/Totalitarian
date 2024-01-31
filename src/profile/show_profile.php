<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."error/error_handler.php");
    require_once(VarUtils::getDocumentRoot()."session.php");
    
    ErrorHandler::init();
	Session::startSession();
	if(!VarUtils::checkIsSetInArray($_SESSION, "UID")){
        if(VarUtils::checkIsSetInArray($_COOKIE, "UID"))
            Session::loginWithCookie($_COOKIE["UID"]);
        else{
            header("Location: /Totalitarian/src/index.php");
            exit(0);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Totalitarian/src/styles/style.css">
    <link rel="icon" href="/Totalitarian/src/assets/logo_icon_white.svg" type="image/x-icon">
    <title>Profile</title>
    <script src="https://kit.fontawesome.com/9d36b0df12.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include(VarUtils::getDocumentRoot()."components/header.php");
    ?>
</body>
</html>