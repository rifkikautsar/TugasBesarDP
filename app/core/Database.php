<?php 
class Database{
        private $dbhost = DB_HOST; // set the hostname
		private $dbname = DB_NAME; // set the database name
		private $dbuser = DB_USER; // set the mysql username
        private $dbpass = DB_PASS;  // set the mysql password
        private $dbport = DB_PORT; //set the mysql port

        private $dbh;
        private $stmt;

        public function __construct()
        {
            $dsn = "mysql:host=".$this->dbhost.";port=".$this->dbport.";dbname=".$this->dbname."";

            $option = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            try{
                $this->dbh = new PDO($dsn, $this->dbuser,$this->dbpass, $option);
            } catch(PDOException $e) {
                echo '<strong>Mohon Maaf terjadi Kesalahan. Koneksi ke Database GAGAL.</strong><br>';
                die($e->getMessage());
            }
        }

        public function query($query)
        {
            $this->stmt = $this->dbh->prepare($query);
        }

        public function bind($param, $value, $type = null)
        {
            if(is_null($type)){
                switch(true){
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default :
                    $type = PDO::PARAM_STR;
            }
        }
            $this->stmt->bindValue($param,$value,$type);
        }
        public function execute()
        {
            $this->stmt->execute();
        }

        public function resultSet()
        {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function single()
        {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function rowCount(){
            return $this->stmt->rowCount();
        }

}