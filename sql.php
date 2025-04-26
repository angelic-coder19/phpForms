<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "nyDB";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dabname);

    // Check connection 
    if (!$conn) 
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    echo "Connected successfully <br>";

    /* Create database commented out because the database is a
       already created 

    $sql = "CREATE DATABASE myDB";
    if (mysqli_query($conn, $sql)) 
    {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . mysqli_error($conn);
    } */ 

    // sql to create table 
    $sql = "CREATE TABLE MyGuests 
    ( 
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if (mysqli_query($conn, $sql))
    {
        echo "<br> Table MyGuests created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }

    // To close the connection
    mysqli_close($conn);
?> 