<?php
    class VarUtils{

        public static function checkIsSetInArray(array $array, string ...$variables): bool{
            foreach($variables as $var){
                if(!isset($array[$var])){
                    return false;
                }
            }
            return true;
        }

        public static function checkIsEmptyInArray(array $array, string ...$variables): bool{
            foreach($variables as $var){
                if(empty($array[$var])){
                    return true;
                }
            }
            return false;
        }

        public static function getDocumentRoot(): string{
            return "/Applications/XAMPP/xamppfiles/htdocs/Totalitarian/src/";
        }

        public static function checkValidEmail(string $email): bool{
            $emailRegex = "/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/";
            return preg_match($emailRegex, $email);
        }

        public static function checkValidPassword(string $password): bool{
            $passwordRegex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
            return preg_match($passwordRegex, $password);
        }
    }
?>