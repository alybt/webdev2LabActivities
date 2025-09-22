<?php
    class Database{
        private $host = "127.0.0.1";
        private $dbname = "library";
        private $username = "root";
        private $password = "";
        

        protected $conn;

        public function connect(){
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
        
            return $this->conn;
        
        }

    }
