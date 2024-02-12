<?php
    require_once(__DIR__."/variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."error/error_handler.php");
    require_once(VarUtils::getDocumentRoot()."session.php");
    
    ErrorHandler::init();
	Session::startSession();
    if(!VarUtils::checkIsSetInArray($_SESSION, "UID")){
        if(VarUtils::checkIsSetInArray($_COOKIE, "UID"))
            Session::loginWithCookie($_COOKIE["UID"]);
    }
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Totalitarian/src/styles/style.css" type="text/css">
    <link rel="stylesheet" href="/Totalitarian/src/styles/homepage.css" type="text/css">
    <link rel="icon" href="/Totalitarian/src/assets/logo_icon_white.svg" type="image/x-icon">
    <title>Totalitarian</title>
    <script src="https://kit.fontawesome.com/9d36b0df12.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include(VarUtils::getDocumentRoot()."components/header.php");
        if(VarUtils::checkIsSetInArray($_SESSION, "UID"))
            include(VarUtils::getDocumentRoot()."components/homepage_logged.php");
        else
            include(VarUtils::getDocumentRoot()."components/homepage.html");
        include(VarUtils::getDocumentRoot()."components/footer.html");
    ?>
    <script src="/Totalitarian/src/scripts/main.js"></script>
    <script src="/Totalitarian/src/scripts/homepage.js"></script>
</body>
</html>