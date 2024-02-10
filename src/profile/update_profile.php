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

    // retrieve user data
    $db = new Database();
    $db->connect();
    $query = $db->prepare("SELECT * FROM users WHERE email = ?");
    $db->bindParam($query, "s", Session::getSessionVar("email"));
    $db->execute($query);
    $result = $db->getResult($query);
    $query->close();
    $db->close();
    if($result->num_rows != 1)
        ErrorHandler::displayError("Internal Error: cannot fetch user data", 500);
    if(!$row = $result->fetch_assoc())
        ErrorHandler::displayError("Internal Error", 500);
    $user = User::withRow($row);

    function update_profile(){
        if(empty($_POST))
            throw new Exception();
        
        if(!VarUtils::checkIsSetInArray($_POST, "firstname", "lastname", "email"))
            ErrorHandler::displayError("Internal Error: variables not set", 500);

        if(VarUtils::checkIsEmptyInArray($_POST, "firstname", "lastname", "email")){
            echo '<div aria-live="assertive" class="notification notification--failure no-animate text-small">Check input data, some are missing</div>';
            throw new Exception();
        }

        if(!VarUtils::checkValidEmail($_POST["email"])){
			echo '<div aria-live="assertive" class="notification notification--failure no-animate text-small">Invalid email</div>';
			throw new Exception();
		}

        $newFirstname = trim($_POST["firstname"]);
        $newLastname = trim($_POST["lastname"]);
        $newEmail = trim($_POST["email"]);
        $db = new Database();
        $db->connect();
        $query = $db->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ? WHERE email = ?");
        $db->bindParam($query, "ssss", $newFirstname, $newLastname, $newEmail, Session::getSessionVar("email"));
        $db->execute($query);
        if($query->affected_rows < 0)
                ErrorHandler::displayError("Internal Error: cannot update user data", 500);
        $query->close();
        $db->close();
        Session::setSessionVar("email", $newEmail);
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
    <title>Update Profile</title>
    <script src="https://kit.fontawesome.com/9d36b0df12.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include(VarUtils::getDocumentRoot()."components/header.php");
    ?>
    <main class="container column flex-center">
        <?php
            try{
                update_profile();
            }catch(Exception $e){
                echo '
                <h1 class="page-title text-large">UPDATE PROFILE</h1>
                <form action="update_profile.php" method="post" class="form text-small" id="update-form" novalidate>
                    <label for="firstname" class="form__label">First Name</label>
                    <input type="text" class="form__input text-small" id="firstname" name="firstname" value="'.htmlspecialchars($user->getFirstname()).'">

                    <label for="lastname" class="form__label">Last Name</label>
                    <input type="text" class="form__input text-small" id="lastname" name="lastname" value="'.htmlspecialchars($user->getLastname()).'">

                    <label for="email" class="form__label">Email</label>
                    <input type="email" class="form__input text-small" id="email" name="email" value="'.htmlspecialchars($user->getEmail()).'">
                    <br>

                    <input type="submit" class="form__input form__input--submit text-small" id="submit" name="submit" value="Update">
                </form>';
            }
        ?>
        <a href="/Totalitarian/src/profile/show_profile.php" class="btn"><span aria-hidden="true">&#x25c0;</span> Back to Profile</a>
    </main>
    <script src="/Totalitarian/src/scripts/main.js"></script>
    <script src="/Totalitarian/src/scripts/updateProfileForm.js" type="module"></script>
</body>
</html>