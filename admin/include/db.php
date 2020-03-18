<?php
    class DB{
        private $db_host;
        private $username;
        private $pwd;
        private $database;
        private $connection;
        
        public $error_message = '';
        
        function __construct(){
            $array_ini = parse_ini_file('setup.ini', true);
            $this->InitDB(
                $array_ini['host'],
                $array_ini['username'],
                $array_ini['pwd'],
                $array_ini['database']);
            return $array_ini['database'];
            // $this->DBLogin();
        }

        //-----Initialization -------
        function InitDB($host,$uname,$pwd,$database){
            $this->db_host  = $host;
            $this->username = $uname;
            $this->pwd  = $pwd;
            $this->database  = $database;

        }

        function CloseAll(){
            mysqli_close($this->connection);
        }
        

        //-------   FUNCIONES GLOBALES   ----------------------
        //  UTIL FUNCTIONS
        function DBLogin(){
            $this->connection = mysqli_connect($this->db_host,$this->username,$this->pwd,$this->database);
            if(!$this->connection){   
                $this->HandleDBError("Database Login failed!");
                return false;
            }
            if(!mysqli_query($this->connection,"SET NAMES 'UTF8'")){
                $this->HandleDBError('Error setting utf8 encoding');
                return false;
            }
            return true;
        }

        function selectQuery($select){
            $result = mysqli_query($this->connection,$select);
            if(!$result){
                return false;
            }
            return $result;
        }
        function insertQuery($insert){
            $result = mysqli_query($this->connection,$insert);
            if(!$result){
                return false;
            }
            return true;
        }
        function updateQuery($update){
            $result = mysqli_query($this->connection,$update);
            if(!$result){
                return false;
            }
            return true;
        }
        function deleteQuery($delete){
            $result = mysqli_query($this->connection,$delete);
            if(!$result){
                return false;
            }
            return true;
        }
        function fetchAssoc($result){
            $return = mysqli_fetch_array($result,MYSQLI_ASSOC);return $return;
        }
        function fetchArray($result){
            $return = mysqli_fetch_array($result);return $return;
        }
        
        function numRows($result){
            if(mysqli_num_rows($result)<=0){return false;}
            else{return true;}
        }
        
        function insertID(){
            return mysqli_insert_id($this->connection); 
        }
        function HandleError($err)   {      $this->error_message .= $err."\r\n";}
        function HandleDBError($err) {      $this->HandleError($err."\r\n mysqlerror:".mysqli_error($this->connection));}
    }
?>