<?php

    class DbConnect{

        private $con;

        function connect(){
            //for getting constants from another file
            include dirname(__FILE__).'/Constants.php';

            $this-> con = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
            
            //to check if the connection is sucessfull or not
            if(mysqli_connect_errno()){
                echo "Failed to connect ". mysqli_connect_error();
                return null;
            }
            
            //if everything is okay return to con.
            return $this->con;
        }
    }