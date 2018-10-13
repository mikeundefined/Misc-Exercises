<?php
/*
Michael Nathan 10/13/2018

PHP Login form.

Small one page form that connects to a SQL database 
and verifies that the username and password received in the 
form matches the username and password in the database.
*/


//Include the file that connects to the database
include("connect.php");
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {

    echo '<div class="alert alert-success">Received POST variables.</div>';

    //Assign variables to information received from the form, sanitize the input, hash the password
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = md5(mysqli_real_escape_string($conn, $_POST['password']));
    echo '<div class="alert alert-success">Input assigned to variables and sanitized.</div>';

    //Store the SQL in a variable, run the SQL query and store the result in another variable.
    $sql = "Select * FROM users WHERE username = '$user'";
    $result = $conn->query($sql);

    //Store the SQL query results in a variable
    $row = $result->fetch_assoc();

    //Check to see if any rows were returned. This verifies if the username is present in the database.
    if (isset($row['username'])) {
        echo '<div class="alert alert-success">Verified the user exists.</div>';

        //Check to see if the password in the database matches the password we received from the form.
        if ($row['password'] == $pass) {
            echo '<div class="alert alert-success">The password matches.</div>';

            //Create session variables to identify the user is now logged in. 
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            echo '<div class="alert alert-primary">Session variables have been set.</div>';
        } else {
            echo '<div class="alert alert-danger">The password did not match.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">User not found.</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" />
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                    </div>
                    <button type="submit" class="btn btn-info">Submit</button>
                </form>
            </div>
        </div>
    <div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>