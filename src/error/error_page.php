<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."session.php");

    Session::startSession();
    if(!VarUtils::checkIsSetInArray($_SESSION, "errorMessage", "errorCode"))
        header("Location: /Totalitarian/src/index.php");
        
    http_response_code(Session::getSessionVar("errorCode"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Totalitarian/src/styles/style.css">
    <link rel="stylesheet" href="/Totalitarian/src/styles/error.css">
    <title>Error</title>
</head>
<body class="container column flex-center" id="error-body">
    <img src="/Totalitarian/src/assets/logo_icon_white.svg" alt="Totalitarian Logo">
    <h1 class="text-small">Oops! Something went wrong</h1>
    <p class="text-small">
    <?php 
        echo Session::getSessionVar("errorMessage"); 
        Session::unsetSessionVar("errorMessage");
        Session::unsetSessionVar("errorCode");
    ?>
    </p>
    <a href="/Totalitarian/src/index.php" class="btn text-small">Home</a>
</body>
</html>