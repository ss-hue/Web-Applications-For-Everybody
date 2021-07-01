<?php 

session_start();

if( isset($_POST['cancel']) ){
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // Pw is php123




if( isset($_POST['email']) && isset($_POST['pass']) ){
    unset($_SESSION['name']);
    if( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1){
        $_SESSION['error'] = "Username and password are required";
        header("Location: login.php");
        return;
    }
    else if( !stristr($_POST['email'], '@') || !stristr($_POST['email'], '.')){
        $_SESSION['error'] = "A valid username must contain \"@\" and a \".\"";
        header("Location: login.php");
        error_log("Login fail ".$_POST['email']);
        return;
    }
    else{
        $check = hash('md5', $salt.$_POST['pass']);
        if($check == $stored_hash){
            $_SESSION['name'] = $_POST['email'];
            header("Location: view.php");
            error_log("Login Success ".$_POST['email']);
            return;
        }
        else{
            $_SESSION['error'] = "Incorrect Password";
            error_log("Login fail ".$_POST['email']." $check");
            header("Location: login.php");
            return;
        }
    }
}


?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Sergio Roldán</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
if( isset($_SESSION['error']) ){
    echo('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);//Makes that the error message is shown once only (Flash message)
}
?>
<form method="POST">
<label for="email">User Name</label>
<input type="text" name="email" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<button type="submit" value="Log In">Log In</button>
<button type="submit" name="cancel" value="Cancel">Cancel</button>
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the three character server side language used in this course
 (all lower case) followed by 123. -->
</p>
</div>
</body>
