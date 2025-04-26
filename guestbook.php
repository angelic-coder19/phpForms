<!DOCTYPE html>
</html>
    <head>
        <title>
            Guestbook
        </title>
        <link rel="stylesheet" href="styles.css">
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale = 1.0">
    <?php 
    // Create variables that will contain the contents of the form
    $name = $email = $comment = $time = "";

    // Make variables that will display errors when the fields are blank 
    $name_error = $email_error = $comment_error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (empty($_POST['name']))
        {
            $name_error = "Name field is empty";
        } else {
            $name = clean_input($_POST['name']);
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name))
            {
                $name_error = "Only letters and white space allowed";
            }
        }
        if (empty($_POST['email']))
        {
            $email_error = "Email is empty";
        } else {
            $email = clean_input($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $email_error = "Invaid email format";
            }
        } 
        if (empty($_POST['comment']))
        {
            $comment_error = "Please leave a comment";
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
            <h1>Share Your Thoughts!</h1>
        </div>
        <div id="main-paragraph">
            <p>Leaving the friendly city already<span class="emoji">&#128532</span>? We are glad you visited<span class="emoji">&#128515</span>. share your <strong><i>Zimandola</i></strong> experience 
                with us by leaving a comment below!<span class="emoji">&#128071</span>
            </p>  
        </div>
        <div class="row">
            <div id="form">
                <form method ="POST" action ="<?php echo $_SERVER['PHP_SELF'] ?>"> 
                    <label for="Name" name= "name">Name:</label><br>
                    <input type = "text" name = "name" id = "name" value = "<?php echo $name ?>">
                    <span class = "error" ><?php echo $name_error ?></span> <br>
                    <label for="email">Email:</label><br>
                    <input type="text" name= "email" placeholder="example@gmail.com" id="email" value = "<?php echo $email ?>">
                    <span class = "error"><?php echo $email_error ?> </span><br>
                    <label for="comment">Comment:</label> 
                    <span class = "error" ><?php echo $comment_error ?></span><br>
                    <textarea id="comment" name = "comment" placeholder="Tell us about your experience!" rows="4"></textarea><br>
                    <div id="button">
                        <input type="submit">
                    </div>
                </form>
            </div>
            <div id="viewComment">
                <h3>What Others have to say</h3> 
                <p><?php 
                    // Displays the input of the user with the timestamp
                    echo "$comment <br><br> $name <br> $email <br> $time <br>";
                ?></p>
            </div>
        </div>
        <div class="footer">
            <h3>About Us</h3>
            <P>You can contact us on our socials!</P>
        </div>
    </body>
</html>