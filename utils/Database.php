<?php
    class Database{
        private string $host = "";
        private string $user = "";
        private string $pass = "";
        private string $db = "";
        private string $condb = "";

        function __construct(object $conf){
            $this->host = $conf->host;
            $this->user = $conf->user;
            $this->pass = $conf->pass;
            $this->db = $conf->db;
        }

        public function connect(){
            try {
                $this->condb = new PDO("mysql:host=$this->host;dbname=$this->db;", $this->user, $this->pass);
                $this->condb->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);            
            } catch (PDOException $e) {
                //throw $th;
                echo "Connention fialed".$e->getNMessage();
            }
        }
        public function close_db(){
            $this->condb = null;
        }
    }

?>