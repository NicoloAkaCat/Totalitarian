<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."session.php");
    class ErrorHandler{
        public static function errorHandler(int $errno, string $errstr, ?string $errfile, ?int $errline = NULL): bool{
            $timestamp = date('l jS \of F Y h:i:s A');
            error_log("$timestamp - Error($errno): $errstr in $errfile on line $errline\n\n", 3, "/Applications/XAMPP/xamppfiles/htdocs/Totalitarian/errors.log");
            return true;
        }

        public static function exceptionHandler(Throwable $e): void{
            $timestamp = date('l jS \of F Y h:i:s A');
            error_log("$timestamp - Uncaught Exception: ".$e->getMessage()."\n\n", 3, "/Applications/XAMPP/xamppfiles/htdocs/Totalitarian/errors.log");
        }

        public static function init(){
            error_reporting(E_ALL);
            ini_set("display_errors", "On");
            set_error_handler(array("ErrorHandler", "errorHandler"));
            set_exception_handler(array("ErrorHandler", "exceptionHandler"));
        }

        public static function logMysqlEx(string $f, mysqli_sql_exception $ex): void{
            $sqlCode = $ex->getCode();
            $sqlMsg = $ex->getMessage();
            $timestamp = date('l jS \of F Y h:i:s A');
            error_log("$timestamp - Database->$f($sqlCode): $sqlMsg\n\n", 3, "/Applications/XAMPP/xamppfiles/htdocs/Totalitarian/errors.log");
        }

        public static function displayError(string $msg, int $code): void{
            Session::setSessionVar("errorMessage", $msg);
            Session::setSessionVar("errorCode", $code);
            header("Location: /Totalitarian/src/error/error_page.php");
            exit(1);
        }

        public static function displayJsonError(string $msg, int $code): void{
            Session::setSessionVar("errorMessage", $msg);
            Session::setSessionVar("errorCode", $code);
            echo json_encode(array("status" => "error"));
            exit(1);
        }
    }
?>