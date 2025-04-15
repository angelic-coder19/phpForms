<!DOCTYPE html>
<html>
    <head>
        <title>Form</title>
        <style> .error{ color: #ff0000}</style>
    </head>
    <body>
    <?php
        // first initialize the variables to empty
        $name = $email = $comment = "";

        // Variables that will display errors if the a field is not entered are first initiallized to empty
        $nameError = $emailError = ""; 

        // Checks if the request method is POST
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            if (empty($_POST['fname'])){
                $nameError = "Name is required";
            } else{
                $name = clean_input($_POST['fname']);
            }
            if (empty($_POST['email'])){
                $emailError = "email is required";
            } else{
                $email = clean_input($_POST['email']);
            }
            $comment = clean_input($_POST['comment']);            
        }
        // Make a variabe that stores the date to be displyed later
        $timeStamp = date("h:i:sa, d-m-Y");

        // Display the users input
        echo "$name <br> $email <br> $comment <br> $timeStamp"; 

        // Create a function that validates the user's input
        function clean_input($data){
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            $data = trim($data);
            return $data;
        }
    ?>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
       <p class="error">* (required field)</p>
        NAME: <input type="text" name="fname" value= "<?php echo $name ?>"><span class="error"> * <?php echo $nameError ?></span><br>
        EMAIL: <input type="text" name="email" value="<?php echo $email ?>"><span class="error"> * <?php echo $emailError ?></span><br>
        COMMENT:<br> <textarea name="comment" value="<?php echo $comment ?>" placeholder="Your comment here" col=40 rows=5 ></textarea><br>
        <input type="submit">
    </form>
    </body>
</html>