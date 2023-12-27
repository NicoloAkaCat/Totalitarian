<?php
    require_once(__DIR__."/../variable_utils.php");
	require_once(VarUtils::getDocumentRoot()."database/user.php");
	require_once(VarUtils::getDocumentRoot()."database/database.php");
	require_once(VarUtils::getDocumentRoot()."error/error_handler.php");
    require_once(VarUtils::getDocumentRoot()."session.php");

	ErrorHandler::init();
	Session::startSession();
    Session::checkRedirectionIfLogged(); 
  
    if(VarUtils::checkIsSetInArray($_COOKIE, "UID"))
        Session::checkRememberCookie($_COOKIE["UID"]);

    function login(): void{
        if(empty($_POST))
            throw new Exception();
        
        if(!VarUtils::checkIsSetInArray($_POST, "email", "pass"))
            ErrorHandler::displayError("Internal Error: variables not set", 500);

        if(VarUtils::checkIsEmptyInArray($_POST, "email", "pass")){
            echo '<div class="form-error text-small">Check input data, some are missing</div>';
            throw new Exception();
        }

        $inputEmail = trim($_POST["email"]); 
        $inputPass = trim($_POST["pass"]);

        $db = new Database();

        $db->connect();

        $query = $db->prepare("SELECT * FROM users WHERE email = ?");

        $db->bindParam($query, "s", $inputEmail);
        
        $db->execute($query);

        $result = $db->getResult($query);
        $query->close();
        $db->close();

        if($result->num_rows <= 0){
            echo '<div class="form-error text-small">User not found</div>';
            throw new Exception();
        }

        if(!$row = $result->fetch_assoc())
            ErrorHandler::displayError("Internal Error: cannot fetch user data", 500);

        $user = User::withRow($row);
        if(!$user->verifyPassword($inputPass)){
            echo '<div class="form-error text-small">Wrong email or password</div>';
            throw new Exception();
        }

        Session::regenerateSessionId();
        Session::setSessionVar("UID", Session::generateUniqueToken());
        Session::setSessionVar("email", $inputEmail);
        if(VarUtils::checkIsSetInArray($_POST, "remember"))
            Session::setRememberCookie($inputEmail);

        header("Location: /Totalitarian/src/index.php");
        exit(0);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Totalitarian/src/styles/style.css">
    <link rel="stylesheet" href="/Totalitarian/src/styles/form.css">
    <link rel="icon" href="/Totalitarian/src/assets/logo_icon_white.svg" type="image/x-icon">
    <title>Login</title>
    <script src="https://kit.fontawesome.com/9d36b0df12.js" crossorigin="anonymous"></script>
</head>
<body>
    <main class="container column flex-center">
        <?php  
            try{
                login();
            }catch(Exception $e){
                include("login_form.php");
            }
        ?>
        <a href="/Totalitarian/src/index.php" class="btn"><button class="text-small"><i class="fa-solid fa-house"></i>Home</button></a>
    </main>
    <script src="/Totalitarian/src/scripts/loginForm.js" type="module"></script>
</body>
</html>