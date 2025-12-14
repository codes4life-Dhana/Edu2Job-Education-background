<?php


        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname='edu2job';

        
        $conn = new mysqli($servername, $username, $password);
        $sql = " CREATE DATABASE IF NOT EXISTS edu2job ";
        $conn->query($sql);
            

        $conn = new mysqli($servername, $username, $password, $dbname);

            $sql = "SHOW TABLES LIKE 'users'";
            
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                
            } else {
                 $sql = "CREATE TABLE users(
                        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                        first_name VARCHAR(30) NOT NULL,
                        last_name VARCHAR(30) NOT NULL,
                        email VARCHAR(70) NOT NULL UNIQUE,
                        password VARCHAR(70) NOT NULL 
                    )";
                    mysqli_query($conn, $sql);
            }
            
            $sql = "SELECT * FROM users where email ='dhanasri@gmail.com' ";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0){
                }else{
                $sql = "INSERT INTO users (first_name, last_name, email,password) VALUES ('Dhanasri', 'Dhanasri', 'dhanasri@gmail.com','1234656')";
                mysqli_query($conn, $sql);
                }


               $sql = "SELECT * FROM users where email ='".$_POST['email']."' and password='".$_POST['password']."' ";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0){
                   echo 'Success';exit;
                }
                    echo 'Error';exit;
            


?>