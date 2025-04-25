<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'furaha'); 

class Database{
    private $connection;

    // Constructor
    public function __construct(){
        $this->open_db_connection();
    }

    // Creating connection with the database
    public function open_db_connection(){
        $this->connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if(mysqli_connect_error()){
            die('Connection Error :' . mysqli_connect_error());
        }
    }

    public function query($sql){

        $result = $this->connection->query($sql);

        if(!$result){
            die("Query Fails:" . $sql);
        }

        return $result;

    }

    public function fetch_array($result){
        $result_array = [];
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $result_array[] = $row;
            }
            return $result_array;

        }

    }

    public function last_insert_id(){
        return $this->connection->insert_id;
    }

    public function fetch_row($result){
        if($result-> num_rows > 0)
            return $result->fetch_assoc();
    }

    public function escape_value($value){
        if($this->connection == null){
            die("Error: Database connection is not established");

        }

        return $this->connection->real_escape_string($value);

    }

    public function close_connection(){
        $this->connection->close();
    }

}

$database = new Database();
