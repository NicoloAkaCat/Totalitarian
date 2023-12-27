<?php
    require_once(__DIR__."/variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."error/error_handler.php");
    require_once(VarUtils::getDocumentRoot()."database/database.php");
    require_once(VarUtils::getDocumentRoot()."database/user.php");
    
    class Session{

        public static function setSessionVar(string $key, $value): void{
            $_SESSION[$key] = $value;
        }

        public static function getSessionVar(string $key){
            return $_SESSION[$key];
        }

        public static function unsetSessionVar(string $key): void{
            unset($_SESSION[$key]);
        }

        public static function startSession(): void{
            if(!isset($_SESSION)){
                if(!session_start())
                    ErrorHandler::displayError("Internal Error: cannot start session", 500);
            }
        }

        public static function checkRedirectionIfLogged(){
            if(VarUtils::checkIsSetInArray($_SESSION, "UID")){
                header("Location: /Totalitarian/src/index.php");
                exit(0);
            }
        }

        public static function destroySession(): void{
            $_SESSION = array();
            if(!session_destroy())
                ErrorHandler::displayError("Internal Error: cannot destroy session", 500);
            if(VarUtils::checkIsSetInArray($_COOKIE, "UID")){
                Session::deleteRememberCookie($_COOKIE["UID"]);
            }
        }

        private static function deleteRememberCookie(string $token): void{
            $db = new Database();
            $db->connect();
            $query = $db->prepare("UPDATE users SET token = NULL, token_expires = NULL, remember_me = 0 WHERE token = ?");
            $db->bindParam($query, "s", $token);
            $db->execute($query);
            if($query->affected_rows <= 0)
                ErrorHandler::displayError("Internal Error: cannot update user data", 500);
            $query->close();
            $db->close();
            setcookie("UID", "", time() - 3600, "/");
        }

        public static function getSessionId(): string{
            $id = session_id();
            if(!$id)
                ErrorHandler::displayError("Internal Error: cannot get session id", 500);
            return $id;
        }

        public static function regenerateSessionId(): void{
            if(!session_regenerate_id())
                ErrorHandler::displayError("Internal Error: cannot regenerate session id", 500);
        }

        public static function generateUniqueToken(): string{
            return bin2hex(random_bytes(64));
        }

        public static function checkRememberCookie(string $token): void{
            $db = new Database();
            $db->connect();
            $query = $db->prepare("SELECT * FROM users WHERE token = ?");
            $db->bindParam($query, "s", $token);
            $db->execute($query);
            $result = $db->getResult($query);
            $query->close();
            $db->close();

            if($result->num_rows == 0){
                setcookie("UID", "", time() - 3600, "/");
                ErrorHandler::displayError("Internal Error: cannot find user with this token... someone manipulated cookies?", 500);
            }
            if(!$row = $result->fetch_assoc())
                ErrorHandler::displayError("Internal Error: cannot fetch user data", 500);

            $user = User::withRow($row);
            if(!$user->isRememberMe()){
                setcookie("UID", "", time() - 3600, "/");
                ErrorHandler::displayError("Internal Error: server info doesn't match... someone manipulated cookies?", 500);
            }
            if($user->getTokenExpires() < time()){
                setcookie("UID", "", time() - 3600, "/");
                header("Location: /Totalitarian/src/auth/login.php");
                exit(0);
            }
            Session::regenerateSessionId();
            Session::setSessionVar("UID", Session::generateUniqueToken());
            Session::setSessionVar("email", $user->getEmail());
        }

        public static function setRememberCookie(string $email): void{
            $token = Session::generateUniqueToken();
            $toke_expires = time() + 60 * 60 * 24 * 30;
            $db = new Database();
            $db->connect();
            $query = $db->prepare("UPDATE users SET token = ?, token_expires = ?, remember_me = 1 WHERE email = ?");
            $db->bindParam($query, "sis", $token, $toke_expires, $email);
            $db->execute($query);
            if($query->affected_rows <= 0)
                ErrorHandler::displayError("Internal Error: cannot update user data", 500);
            $query->close();
            $db->close();
            setcookie("UID", $token, $toke_expires, "/");
        }
    }
?>