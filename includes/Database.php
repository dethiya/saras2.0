<?php

require_once('new_config.php');

class Database{
    public $connection;

    function __construct(){
        $this->open_db_connection();
    }

    /*
        database connection
    */
    public function open_db_connection()
    {
        // $this->connection=mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
        $this->connection=new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
        if($this->connection->connect_errno){
	        echo ("DB Connection Failed! ". $this->connection->error);
        }
    }

    public function query($sql)
    {
        $result=$this->connection->query($sql);
        $this->confirm_query($result);
        return $result;
    }

    private function confirm_query($result){
        if(!$result){   
            echo('Query Failed '.$this->connection->error);
        }
    }

    public function escape_string($string){
        $escape_string=$this->connection->real_escape_string($string);
        return $escape_string;
    }

    public function the_insert_id()
    {
//        return $this->connection->insert_id;
        return mysqli_insert_id($this->connection);
    }
}

$database=new Database();
