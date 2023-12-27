<?php
    class User{
        private $firstname;
        private $lastname;
        private $email;
        private $pass;
        private $token;
        private $token_expires;
        private $remember_me = false;

        public function getFirstname(): string{
            return $this->firstname;
        }

        public function getLastname(): string{
            return $this->lastname;
        }

        public function getEmail(): string{
            return $this->email;
        }

        public function getPass(): string{
            return $this->pass;
        }

        public function getToken(): string{
            return $this->token;
        }

        public function getTokenExpires(): int{
            return $this->token_expires;
        }

        public function isRememberMe(): bool{
            return $this->remember_me;
        }

        public function __construct(string $firstname, string $lastname, string $email, string $pass = null, string $token = null, int $token_expires = null){
            $this->firstname = trim($firstname);
            $this->lastname = trim($lastname);
            $this->email = trim($email);
            $this->pass = $pass ? password_hash($pass, PASSWORD_DEFAULT) : null;
            $this->token = $token;
            $this->token_expires = $token_expires;
            $this->remember_me = $token && $token_expires ? true : false;
        }

        public static function withRow(?array $row): ?User{
            if($row == null || !$row)
                return null;
            $user = new User($row["firstname"], $row["lastname"], $row["email"]);
            $user->pass = $row["pass"];
            $user->token = $row["token"];
            $user->token_expires = $row["token_expires"];
            $user->remember_me = $row["remember_me"];
            return $user;
        }

        public static function checkPassEqualsConfirm(string $pass, string $confirm): bool{
            return trim($pass) == trim($confirm);
        }

        public function verifyPassword(string $inputPass): bool{
            return password_verify(trim($inputPass), $this->pass);
        }
    }
?>