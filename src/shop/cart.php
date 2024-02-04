<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."error/error_handler.php");
    require_once(VarUtils::getDocumentRoot()."session.php");
    
    ErrorHandler::init();
	Session::startSession();
	if(!VarUtils::checkIsSetInArray($_SESSION, "UID")){
        if(VarUtils::checkIsSetInArray($_COOKIE, "UID"))
            Session::loginWithCookie($_COOKIE["UID"]);
    }

    if(VarUtils::checkIsSetInArray($_GET, "js") && $_GET["js"] == "false")
        ErrorHandler::displayError("Please enable JavaScript", 400);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Totalitarian/src/styles/style.css" type="text/css">
    <link rel="stylesheet" href="/Totalitarian/src/styles/cart.css" type="text/css">
    <link rel="icon" href="/Totalitarian/src/assets/logo_icon_white.svg" type="image/x-icon">
    <title>Cart</title>
    <script src="https://kit.fontawesome.com/9d36b0df12.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include(VarUtils::getDocumentRoot()."components/header.php");
    ?>
    <main class="container column flex-center" id="main-container">
        <h1 class="page-title text-large">CART</h1>

        <section class="empty-cart column flex-center">
            <img src="/Totalitarian/src/assets/logo_icon_white.svg" alt="Totalitarian logo" class="empty-cart__img">
            <h2 class="empty-cart__msg text-medium">Please enable JavaScript</h2> <!-- JS will replace this -->
        </section>

        <section class="product-list"></section> <!-- populated by JS -->
    </main>
    <script src="/Totalitarian/src/scripts/main.js"></script>
    <script src="/Totalitarian/src/scripts/cart.js" type="module"></script>
</body>
</html>