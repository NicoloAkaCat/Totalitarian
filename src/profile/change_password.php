<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."error/error_handler.php");
    require_once(VarUtils::getDocumentRoot()."session.php");
    require_once(VarUtils::getDocumentRoot()."database/database.php");
    require_once(VarUtils::getDocumentRoot()."database/user.php");
    
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

    function change_password(){
        if(empty($_POST))
            throw new Exception();
        
        if(!VarUtils::checkIsSetInArray($_POST, "pass", "newPass", "newPassConfirm"))
            ErrorHandler::displayError("Internal Error: variables not set", 500);

        if(VarUtils::checkIsEmptyInArray($_POST, "pass", "newPass", "newPassConfirm")){
            echo '<div class="notification notification--failure no-animate text-small">Check input data, some are missing</div>';
            throw new Exception();
        }

        $pass = trim($_POST["pass"]);
        $newPass = trim($_POST["newPass"]);
        $newPassConfirm = trim($_POST["newPassConfirm"]);

        if(!User::checkPassEqualsConfirm($newPass, $newPassConfirm)){
			echo '<div class="notification notification--failure no-animate text-small">Passwords don\'t match</div>';
			throw new Exception();
		}

        if(!VarUtils::checkValidPassword($newPass)){
			echo '<div class="notification notification--failure no-animate text-small">Password must contain at least 8 characters, one uppercase, one lowercase, one number and one special character</div>';
			throw new Exception();
		}

        $db = new Database();
        $db->connect();
        
        //check old password
        $query = $db->prepare("SELECT * FROM users WHERE email = ?");
        $db->bindParam($query, "s", Session::getSessionVar("email"));
        $db->execute($query);
        $result = $db->getResult($query);
        $query->close();
        if($result->num_rows != 1)
            ErrorHandler::displayError("Internal Error: cannot fetch user data", 500);
        if(!$row = $result->fetch_assoc())
            ErrorHandler::displayError("Internal Error", 500);
        $user = User::withRow($row);
        if(!$user->verifyPassword($pass)){
            echo '<div class="notification notification--failure no-animate text-small">Old password is wrong!</div>';
            throw new Exception();
        }

        //update password
        $userUpdated = new User($user->getFirstname(), $user->getLastname(), $user->getEmail(), $newPass);
        $query = $db->prepare("UPDATE users SET pass = ? WHERE email = ?");
        $db->bindParam($query, "ss", $userUpdated->getPass(), $userUpdated->getEmail());
        $db->execute($query);
        if($query->affected_rows != 1)
                ErrorHandler::displayError("Internal Error: cannot update user data", 500);
        $query->close();
        $db->close();

        Session::setSessionVar("notification", true);
        header("Location: /Totalitarian/src/profile/show_profile.php");
        exit(0);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Totalitarian/src/styles/style.css" type="text/css">
    <link rel="stylesheet" href="/Totalitarian/src/styles/form.css" type="text/css">
    <link rel="icon" href="/Totalitarian/src/assets/logo_icon_white.svg" type="image/x-icon">
    <title>Change Password</title>
    <script src="https://kit.fontawesome.com/9d36b0df12.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include(VarUtils::getDocumentRoot()."components/header.php");
    ?>
    <main class="container column flex-center">
        <?php
            try{
                change_password();
            }catch(Exception $e){
                echo '
                <h1 class="page-title text-large">CHANGE PASSWORD</h1>
                <form action="change_password.php" method="post" class="form text-small" id="update-form" novalidate>
                    <label for="pass" class="form__label">Old Password</label>
                    <input type="password" class="form__input text-small" id="pass" name="pass" placeholder="nationalSecret">
                
                    <label for="newPass" class="form__label">New Password</label>
                    <input type="password" class="form__input text-small" id="newPass" name="newPass" placeholder="nationalSecret">

                    <label for="newPassConfirm" class="form__label">Confirm New Password</label>
                    <input type="password" class="form__input text-small" id="newPassConfirm" name="newPassConfirm" placeholder="nationalSecret">
                    <br>

                    <input type="submit" class="form__input form__input--submit text-small" id="submit" name="submit" value="Change">
                </form>';
            }
        ?>
        <a href="/Totalitarian/src/profile/show_profile.php" class="btn"><span aria-hidden="true">&#x25c0;</span> Back to Profile</a>
    </main>
    <script src="/Totalitarian/src/scripts/main.js"></script>
    <script src="/Totalitarian/src/scripts/changePasswordForm.js" type="module"></script>
</body>
</html>