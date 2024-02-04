<?php
	require_once(__DIR__."/../variable_utils.php");
	require_once(VarUtils::getDocumentRoot()."database/user.php");
	require_once(VarUtils::getDocumentRoot()."database/database.php");
	require_once(VarUtils::getDocumentRoot()."error/error_handler.php");
	require_once(VarUtils::getDocumentRoot()."session.php");
	
	ErrorHandler::init();
	Session::startSession();
	
	if(VarUtils::checkIsSetInArray($_COOKIE, "UID"))
        Session::loginWithCookie($_COOKIE["UID"]);
	
	if(VarUtils::checkIsSetInArray($_SESSION, "UID")){
		header("Location: /Totalitarian/src/index.php");
		exit(0);
	} 

	function register(): void{

		if(empty($_POST))
			throw new Exception();

		if(!VarUtils::checkIsSetInArray($_POST, "firstname", "lastname", "email", "pass", "confirm"))
			ErrorHandler::displayError("Internal Error: variables not set", 500);

		if(VarUtils::checkIsEmptyInArray($_POST, "firstname", "lastname", "email", "pass", "confirm")){
			echo '<div class="notification notification--failure no-animate text-small">Check input data, some are missing</div>';
			throw new Exception();
		}

		if(!VarUtils::checkValidEmail($_POST["email"])){
			echo '<div class="notification notification--failure no-animate text-small">Invalid email</div>';
			throw new Exception();
		}
			
		if(!User::checkPassEqualsConfirm($_POST["pass"], $_POST["confirm"])){
			echo '<div class="notification notification--failure no-animate text-small">Passwords don\'t match</div>';
			throw new Exception();
		}

		if(!VarUtils::checkValidPassword($_POST["pass"])){
			echo '<div class="notification notification--failure no-animate text-small">Password must contain at least 8 characters, one uppercase, one lowercase, one number and one special character</div>';
			throw new Exception();
		}

		$user = new User($_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["pass"]);

		$db = new Database();

		$db->connect();
		
		$query = $db->prepare("INSERT INTO users (firstname, lastname, email, pass) VALUES (?, ?, ?, ?)");

		$db->bindParam($query, "ssss", $user->getFirstname(), $user->getLastname(), $user->getEmail(), $user->getPass());
		
		$db->execute($query);

		if($query->affected_rows <= 0){
			echo '<div class="notification notification--failure no-animate text-small">Cannot register user or user already registered</div>';
			throw new Exception();
		}
		$query->close();
		$db->close();

		Session::setSessionVar("UID", Session::generateUniqueToken());
		Session::setSessionVar("email", $user->getEmail());
		header("Location: /Totalitarian/src/index.php");
		exit(0);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/Totalitarian/src/styles/style.css" type="text/css">
	<link rel="stylesheet" href="/Totalitarian/src/styles/form.css" type="text/css">
	<link rel="icon" href="/Totalitarian/src/assets/logo_icon_white.svg" type="image/x-icon">
    <title>Sign-In</title>
	<script src="https://kit.fontawesome.com/9d36b0df12.js" crossorigin="anonymous"></script>
</head>

<body>
	<main class="container column flex-center" id="main-container">
		<?php
			try{
				register();
			}catch(Exception $e){
				include("register_form.php");
			}
		?>
		<a href="/Totalitarian/src/index.php" class="btn text-small"><i class="fa-solid fa-house"></i>Home</a>
	</main>
	<script src="/Totalitarian/src/scripts/registerForm.js" type="module"></script>
</body>
</html>
