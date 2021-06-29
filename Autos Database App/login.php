<?php 

if( isset($_POST['cancel']) ){
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // Pw is php123

$failure = false;

if( isset($_POST['who']) && isset($_POST['pass']) ){
    if( strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1){
        $failure = "Email and password are required";
    }
    else if( !stristr($_POST['who'], '@') || !stristr($_POST['who'], '.')){
        $failure = "Please, enter a valid email address (verify that has a \"@\" in it)."." => ". $_POST['who'];
        error_log("Login fail ".$_POST['who']);
    }
    else{
        $check = hash('md5', $salt.$_POST['pass']);
        if($check == $stored_hash){
            header("Location: autos.php?name=".urlencode($_POST['who']));
            error_log("Login success ".$_POST['who']);
            return;
        }
        else{
            $failure = "Incorrect password";
            error_log("Login fail ".$_POST['who']." $check");
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
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
?>
<form method="POST">
<label for="email">Email</label>
<input type="text" name="who" id="nam"><br/>
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
