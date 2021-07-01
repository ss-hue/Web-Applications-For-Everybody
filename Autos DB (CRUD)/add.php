<?php
session_start();
//Required only here because is when the SQL Query and performance will take place, in this case.
require_once("pdo.php");

$row = False;

if(isset($_POST['cancel'])){
    header("Location: view.php");

}


if( !isset($_SESSION['name']) OR strlen($_SESSION['name'])<1){

    die("ACCESS DENIED");

}

if(isset($_POST['make'])  && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']) ){

    if( isset($_POST['add']) ){
        if(strlen( $_POST['make']) < 1 || strlen( $_POST['model']) < 1 || strlen($_POST['mileage']) < 1 || strlen( $_POST['year']) < 1){
            $_SESSION['error'] = '<p style="color:red">All fields are required</p>';
            header('Location: add.php');
            return;
        }else if( ! is_numeric($_POST['year']) || ! is_numeric($_POST['mileage']) ){
            $_SESSION['error'] = '<p style="color:red">Mileage and year must be numeric!';
            header('Location: add.php');
            return;

        }else{
            try{
                $sql = "INSERT INTO autos (make, model, year, mileage) VALUES (:mk, :md , :yr, :mil)";

                $stmt = $pdo->prepare($sql);

    
                $stmt->execute(array(
                    ':mk' => $_POST['make'],
                    ':md' => $_POST['model'],
                    ':yr' => $_POST['year'],
                    ':mil' => $_POST['mileage']
                ));

                $_SESSION['success'] = '<p style="color:green">Added</p>'; 
                header('Location: view.php');
                return;

                
            } catch (PDOException $ex){
                echo "Internal error, please contact the administrator.";
                error_log("Exception Message: " . $ex->getMessage());
                return;

            }  

        }
        

    }

}



?>

<!DOCTYPE html>
<html>
<title>Sergio Roldán Automobile Tracker</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Tracking Autos for <?php htmlentities($_SESSION['name']); ?></h1>
<?php if( isset($_SESSION['error'])) print($_SESSION['error']); unset($_SESSION['error']);?>
<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Model:
<input type="text" name="model"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" name="add" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>
<ul>
<p>
</ul>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>


