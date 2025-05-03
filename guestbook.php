<!DOCTYPE html>
</html>
    <head>
        <title>
            The Ndola Guestbook
        </title>
        <link rel="stylesheet" href="styles.css">
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale = 1.0">
    <?php 
    // Connect with the database file
    include "db_queries.php";

    // Create variables that will contain the contents of the form
    $name = $email = $comment = $time = "";

    // Make variables that will display errors
    $name_error = $email_error = $comment_error = "";

    // Variable that will check if any errors have been detected in the form 
    $error = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (empty($_POST['name']))
        {
            $name_error = "Name field is empty";
            $error = true;
        } else {
            $name = clean_input($_POST['name']);
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name))
            {
                $name_error = "Only letters and white space allowed";
                $error = true;
            }
        }
        if (empty($_POST['email']))
        {
            $email_error = "Email is empty";
            $error = true;
        } else {
            $email = clean_input($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $email_error = "Invaid email format";
                $error = true;
            }
        } 
        if (empty($_POST['comment']))
        {
            $comment_error = "Please leave a comment";
            $error = true;
        } else {
            $comment = clean_input($_POST['comment']);
        }

        $timestamp = strtotime("now"); // This ensures that the timestamp will be for that instance
        $time = date("h:iA d-m-Y", $timestamp);            
    }

    // create a function that will validate the input from the user
    function clean_input($input){
        $input = stripslashes($input);
        $input = trim($input);
        $input = htmlspecialchars($input);        
        return $input;
    }
    ?>
    </head>
    <body>
        <div id="header">
            <h1>The Ndola Experience</h1>
        </div><div id = inner>
                <h2>Share Your Thoughts!</h2> 
        </div>
        <div id="main-paragraph"> 
            <P>
                <b>Welcome to the Guestbook of Ndola, the beating heart of Zambia's Copperbelt!<span class = "emoji">&#128151;&#127961;</span>
                - your space to share memories, moments and stories about our beautiful city!</b>
                Whether you are a proud resident (a <b><i>Zimandola</i></b>), a nostalgic visitor, or someone passing through, 
                we would love to hear about your experiences in the friendly city of Ndola.
            </p>
                Share your favorite spots, unforgattable moments<span class = "emoji">&#10024;</span>, or simply say hello. From the lively streets of Masala<span class = "emoji">&#127750;</span>
                to the calm evenings of Itawa<span class = "emoji">&#127769;</span>, every story adds a little more heart to our city story.
            <p>
            </p>  
        </div>
        <div class="row">
            <div id="form">
                <form method ="POST" action ="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>"> 
                    <label for="Name" name= "name">Name:</label><br>
                    <input class = "input" type = "text" name = "name" id = "name" value = "<?php echo $name ?>">
                    <span class = "error" ><?php echo $name_error ?></span> <br>
                    <label for="email">Email:</label><br>
                    <input class = "input" type="text" name= "email" placeholder="example@gmail.com" id="email" value = "<?php echo $email ?>">
                    <span class = "error"><?php echo $email_error ?> </span><br>
                    <label for="comment">Comment:</label> 
                    <span class = "error" ><?php echo $comment_error ?></span><br>
                    <textarea class = "input" id="comment" name = "comment" placeholder="Tell us about your experience!" rows="4"></textarea><br>
                    <input id = "button" type="submit"><span><?php $success_message = ""; echo $success_message; ?></span>
                </form>
            </div>
            <div id="viewComment">
                <div id="ViewHeader">
                    <h3>What Others have to say</h3>
                </div> 
                <p><?php 
                    // Displays the input of the user with the timestamp only if no errors have been detected
                    if (!$error)
                    {
                        // Send data to the data base using prepared statement for entry queries
                        $sql = "INSERT INTO Guestbook (full_name, email, comment) 
                                VALUES (?, ?, ?)";
                        $stmt = mysqli_prepare($conn, $sql);

                        if ($stmt && !empty($name) && !empty($email) && !empty($comment))
                        {       

                                mysqli_stmt_bind_param($stmt, "sss", $first_name, $db_email, $db_comment);

                                // Store form input from the user into the above variables 
                                $first_name = $name;
                                $db_email = $email;
                                $db_comment = $comment;

                                // This query checks whether a comment already exits in the database to prevent duplicate entries 
                                $query = "SELECT * FROM Guestbook 
                                          WHERE full_name = '$first_name' AND email = '$db_email' AND comment = '$db_comment' ";
                                $result = mysqli_query($conn, $query);
                  
                                // This switch statement will prevent entry dupliation even after page resubmission
                                switch (mysqli_num_rows($result)) 
                                {
                                    case 0:
                                    mysqli_stmt_execute($stmt); 

                                    // This displays a success message everytime the user submits a comment
                                    $success_message = "Thank you for sharing! successfully sent!";
                                    break;
                                default:
                                    $success_message = "This comment already exists";
                            }
                        } else {
                            $success_message = "Couldn't save your comment";
                        }  
                    }

                    // Dynamically display the contents of the database table for users to see previous comments 
                    $sql = "SELECT full_name, email, comment, reg_date
                            FROM Guestbook 
                            ORDER BY reg_date DESC";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0)
                    {
                        while ($row = mysqli_fetch_assoc($result)) // This places the content in each column into an associative array
                        {
                            echo $row["comment"] . "<br><br>" . $row["full_name"] . "<br>" . $row["email"] . "<br>" . $row["reg_date"] . "<br><br>_________________________<br><br>";
                        }
                    }
                    // Close the connection
                    mysqli_close($conn);
                ?></p>
            <div id = "comment_count">
                <h4>
                    <?php echo $comment_count . " comments"; ?> 
                </h4>
            </div>
            </div>
        </div>
        <div class="footer">
            <h3>Our Ndola</h3>
            <P>
                Thank you for being part of Ndola's story. Your words help keep the spirit of Ndola Alive. Keep sharing and celebrating
                our home!
            </P>
            <p id = "credits">
                <i>this guest book is a passion project by <a target = "_blank" href = "https://www.linkedin.com/in/angel-yuzya-852a4031b?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app">Angel Yuzya</a> in partnership
                    with <a href = "https://www.linkedin.com/in/emmanuel-mazonga-69b3032a1?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app">Emmanuel Mazonga</a>, dedicated to celebarting the beating heart of Ndola.</i>
            </p>
        </div>
    </body>
</html>