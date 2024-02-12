<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."error/error_handler.php");
    
    class Database{
        private $db;
        private $db_username;
        private $db_pass;
        private $db_schema;

        private function getCredentials(): void{
            if(!$fd = fopen(VarUtils::getDocumentRoot()."../server_credentials", "r"))
                ErrorHandler::displayError("", 500);
            flock($fd, LOCK_SH);
            $line = fgets($fd);
            flock($fd, LOCK_UN);
            fclose($fd);
            if(!$line)
                ErrorHandler::displayError("", 500);
            $credentials = explode(":", $line);
            $this->db_username = $credentials[0];
            $this->db_pass = $credentials[1];
            $this->db_schema = $credentials[2];
        }

        public function __construct(){
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $this->getCredentials();
        }

        public function connect(): void{
            try{
                $this->db = new mysqli("localhost", $this->db_username, $this->db_pass, $this->db_schema);
            }
            catch(mysqli_sql_exception $e){
                ErrorHandler::logMysqlEx("connect", $e);
                ErrorHandler::displayError("", 500);
            }
        }

        public function prepare(string $query): mysqli_stmt{
            try{
                return $this->db->prepare($query);
            }
            catch(mysqli_sql_exception $e){
                ErrorHandler::logMysqlEx("prepare", $e);
                ErrorHandler::displayError("", 500);
                exit(1); // only to suppress warning
            }
        }

        public function bindParam(mysqli_stmt $query, string $type, ...$vars): void{
            try{
                $query->bind_param($type, ...$vars);
            }
            catch(mysqli_sql_exception $e){
                ErrorHandler::logMysqlEx("bindParam", $e);
                ErrorHandler::displayError("", 500);
            }
        }

        public function execute(mysqli_stmt $query): void{
            try{
                $query->execute();
            }
            catch(mysqli_sql_exception $e){
                ErrorHandler::logMysqlEx("execute", $e);
            }
        }

        public function getResult(mysqli_stmt $query): mysqli_result{
            try{
                return $query->get_result();
            }
            catch(mysqli_sql_exception $e){
                ErrorHandler::logMysqlEx("getResult", $e);
                ErrorHandler::displayError("", 500);
                exit(1); // only to suppress warning
            }
        }

        public function close(): void{
            $this->db->close(); //since php 8.0.0 always returns true
        }

        public function beginTransaction(): void{
            if(!$this->db->begin_transaction())
                ErrorHandler::displayError("", 500);
        }

        public function commit(): void{
            try{
                $this->db->commit();
            }
            catch(mysqli_sql_exception $e){
                ErrorHandler::logMysqlEx("commit", $e);
                ErrorHandler::displayError("", 500);
            }    
        }

        public function rollback(): void{
            try{
                $this->db->rollback();
            }
            catch(mysqli_sql_exception $e){
                ErrorHandler::logMysqlEx("rollback", $e);
                ErrorHandler::displayError("", 500);
            }    
        }

        public function getInsertId(): int|string{
            $id = $this->db->insert_id;
            if($id == 0)
                ErrorHandler::displayError("", 500);
            return $id; // I assume it's always an int, such a number of orders to exceed it is unlikely
        }
    }
?>