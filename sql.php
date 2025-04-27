<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "myDB";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

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

    /* Commented out because table can only be created once
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

    // Prepare SQL query with placeholders 
    $sql = "INSERT INTO MyGuests (firstname, lastname, email)
            VALUES (?, ?, ?)";

    // Initialize a prepared statement
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt)
    {
        // Bind parameters to the prepared statement 
        mysqli_stmt_bind_param($stmt, "sss", $firstname, $lastname, $email);

        // Set parameters and execute the staeement for the first entry
        $firstname = "Ephraim";
        $lastname = "kabungo";
        $email = "ephraimkaungo84@gmail.com";
        mysqli_stmt_execute($stmt);

        // Set parameters and execute the statement for the second entry
        $firstname = "Chasaya";
        $lastname = "Sichilima";
        $email = "shinataizya@gmail.com";
        mysqli_stmt_execute($stmt);

        $firstname = "Bwalya";
        $lastname = "kabungo";
        $email = "bawayakabungo@hotmail.com";
        mysqli_stmt_execute($stmt);

        echo "<br>New records created successfully";
    } else{
        echo "Error preparing statement: " . mysqli_error($conn);
    } */

    // To retreive data, first make a variable to hold the query
    $sql = "SELECT id, firstname, lastname, email, reg_date FROM MyGuests";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) 
    {
        // Output data of each row
        while ($row = mysqli_fetch_assoc($result))  // Retreaves each row as an associative array
        {
            echo "ID: " . $row["id"] . " - Name: " . $row["firstname"] . " ". $row["lastname"]. "  -  " . $row["email"] . "  -   ". $row["reg_date"] . "<br>";    
        }
    } else {
        echo "0 results";
    }

    // To access a specific value from the database
    $sql = "SELECT * FROM MyGuests
            WHERE lastname = 'Sichilima'";
    $result = mysqli_query($conn, $sql);

    // Display the result
    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            echo "ID: " . $row["id"] . "  " . "Name: " . $row["firstname"]. $row["lastname"] . " - " ."Email: " . $row["email"] ." - ". $row["reg_date"]. "<br>";
        }
    } else{
        echo "Failed to fetch data " . mysqli_error($conn);
    }

    // Query to sort a specific search result
    $sql = "SELECT * FROM MyGuests
            WHERE lastname = 'Yuzya'
            ORDER BY reg_date ASC";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            echo "<br>ID: " . $row["id"] . " - " . $row["firstname"] . " " . $row["lastname"]. " - " . $row["email"] . " - " . $row["reg_date"] . "<br>";
        }
    } else {
        echo "Error retreiving data: " . mysqli_error($conn);    
    }

    // To delete specific data from table
    $sql = "DELETE FROM MyGuests
            WHERE lastname = 'Sichilima' AND id > 20";
    
    // Check if the delete was successful
    if (mysqli_query($conn, $sql))
    {
        echo "<br>Records successfully deleted!";
    } else{
        echo "Encountered an error: " . mysqli_error($conn);
    }

    // to update data 
    $sql = "UPDATE MyGuests
            SET lastname = 'Mulenga Linda' 
            WHERE lastname = 'Mulenga'";

    // Execute and give feedback on the action
    if (mysqli_query($conn, $sql))
    {
        echo "Record Successfully Updated";
    } else {
        echo "Error occured when updating recs: " . mysqli_error($conn);
    }
    
    // To close the connection
    mysqli_close($conn);
?> 