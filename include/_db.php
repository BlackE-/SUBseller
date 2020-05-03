<?php
    class DB{
        private $db_host;
        private $username;
        private $pwd;
        private $database;
        private $connection;
        public $error_message = '';


        
        function __construct(){
            $path = dirname(__DIR__).'/admin/include/setup.ini';
            // $array_ini = parse_ini_file('admin/include/setup.ini', true);
            $array_ini = parse_ini_file($path, true);
            $this->InitDB(
                $array_ini['host'],
                $array_ini['username'],
                $array_ini['pwd'],
                $array_ini['database']);
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
            $returnValue = true;
            try{
                $this->connection = mysqli_connect($this->db_host,$this->username,$this->pwd,$this->database);
                if(!$this->connection){ 
                    $this->HandleError("Database Login failed!");
                    $returnValue = false;
                }else{
                    if(!mysqli_query($this->connection,"SET NAMES 'UTF8'")){
                        $this->HandleDBError('Error setting utf8 encoding');
                        $returnValue = false;
                    }
                }
            }
            catch(Exception $e){
                 $this->HandleDBError($e->getMessage());
                 $returnValue = false;
            }
            return $returnValue;
        }

        function selectQuery($select){
            $result = mysqli_query($this->connection,$select);
            if(!$result){
                return false;
            }
            return $result;
        }
        function insertQuery($insert){
            $returnValue = true;
            $this->HandleError('Insert Correct');
            $result = mysqli_query($this->connection,$insert);
            if(!$result){
                if (mysqli_errno($this->connection) == 1062) {
                    $this->HandleError('Dato duplicado');
                }
                else{
                    $this->HandleDBError('No insert'.$insert);
                }
                $returnValue = false;
            }
            return $returnValue;
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

        function getNumRows($result){
            return mysqli_num_rows($result);
        }
        
        function lastInsertID(){
            return mysqli_insert_id($this->connection); 
        }
        function HandleError($err)   {      $this->error_message = $err."\r\n";}
        function HandleDBError($err) {      $this->HandleError($err."\r\n mysqlerror:".mysqli_error($this->connection));}
        function GetErrorMessage(){
            if(empty($this->error_message)){return '';}
            $errormsg = nl2br(htmlentities($this->error_message));
            return $errormsg;
        }
    }
?>