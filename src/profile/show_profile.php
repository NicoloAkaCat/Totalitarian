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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Totalitarian/src/styles/style.css">
    <link rel="stylesheet" href="/Totalitarian/src/styles/profile.css">
    <link rel="icon" href="/Totalitarian/src/assets/logo_icon_white.svg" type="image/x-icon">
    <title>Profile</title>
    <script src="https://kit.fontawesome.com/9d36b0df12.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include(VarUtils::getDocumentRoot()."components/header.php");
    ?>
    <main class="container column flex-center" id="main-container">
        <h1 class="page-title text-large">PROFILE</h1>
        <?php
            if(VarUtils::checkIsSetInArray($_SESSION, "notification")){
                echo '<div id="js-notify"></div>';
                Session::unsetSessionVar("notification");
            }
        ?>

        <section class="profile column flex-center">
            <img src="/Totalitarian/src/assets/logo_icon_white.svg" alt="default profile picture" class="profile__img">
            <h2 class="profile__name text-medium">
                <?php echo htmlspecialchars(ucfirst($user->getFirstname()))." ".htmlspecialchars(ucfirst($user->getLastname()));?>
            </h2>
            <h2 class="profile__email text-medium"><?php echo htmlspecialchars($user->getEmail());?></h2>
            <div class="profile__update column flex-center">
                <a href="/Totalitarian/src/profile/update_profile.php" class="profile__update__info btn text-small"><i class="fa-solid fa-user"></i>Update Profile</a>
                <a href="/Totalitarian/src/profile/update_password.php" class="profile__update__password btn text-small"><i class="fa-solid fa-key"></i>Change Password</a>
            </div>
        </section>
    </main>
    <script src="/Totalitarian/src/scripts/main.js"></script>
    <script src="/Totalitarian/src/scripts/profile.js" type="module"></script>
</body>
</html>