<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation</title>
</head>
<body>
    <h1> PHP Form Validation</h1>
    <form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Name : <input type="text" name = "name" required> 
        <br><br>
        E-mail: <input type= "email" name = "email" required>
        <br> <br>
        Password: <input type="password" name = "password" required>
        <br><br>
        <input type="Submit" name= "submit" value="Submit">
    </form>
    <?php 
    // $name = $email = $password = "";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $name = ($_POST["name"]);
        $email = ($_POST["email"]);
        $password = ($_POST["password"]);
        if(!empty($name) && !empty($email) && !empty($password)){
            echo "<h3 style='color: green';> Registration Successful!</h3>";
            echo "<p><strong>Name:</strong> $name</p>";
            echo "<p><strong>Email:</strong> $email</p>";
        }else{
            echo "<h3 style='color:red;'>All the fields are required</h3>";
        }
    }
    ?>
</body>
</html>