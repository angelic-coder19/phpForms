<?php 
    // Set up environment variables to hold database credentials
    $server_name = "localhost";
    $user_name = "root";
    $password = "";
    $db_name = "myDB"; 

    // create connection 
    $conn = mysqli_connect($server_name, $user_name, $password, $db_name);

    // Check if connection is okay
    if (!$conn)
    {
        echo "Connection failed: " . mysqli_connect_error($conn);
    } else {
        echo "Connection successful"; 
    }

    /*
    // Create a table 
    $sql = "CREATE TABLE Guestbook
           (
            id INT(6) AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(100) NOT NULL,
            email VARCHAR(50) NOT NULL, 
            comment TEXT NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
           )";
            
    if (mysqli_query($conn, $sql))
    {
        echo "<br> Table created successfully!";
    } else {
        echo "<br> Error Creating table: " . mysqli_error($conn);
    } */

    // To delete all blank entries
    $sql = "DELETE FROM Guestbook
            WHERE full_name = '       '";
    mysqli_query($conn, $sql);
    
    // To return the number of comments in the database 
    $sql = "SELECT COUNT(*) AS count FROM Guestbook";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result))
    {
        while ($row = mysqli_fetch_assoc($result))
        {
             $comment_count = $row['count'];
        }
    }

    // Close connection 
    //mysqli_close($conn);
?>