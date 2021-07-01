<?php
    require_once("pdo.php");
    session_start();
    

    if ( !isset($_GET['autos_id']) ) {
        $_SESSION['error'] = "Missing user_id";
        header("Location: view.php");
        return;
        }

    if ( ! isset($_SESSION['name']) ) {
    die('ACCESS DENIED');
    }

    if ( isset($_POST['cancel']) ) {
        header("Location: view.php");
        return;
        }


    if( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year'])  && isset($_POST['mileage']) && isset($_POST['autos_id'])){

 

        if(!is_numeric($_POST['year']) || !is_numeric($_POST['mileage']) || strlen($_POST['year']) <1 || strlen($_POST['mileage']) <1 ){
            $_SESSION['error'] = "Year and Mileage must be numeric.";
            header("Location: view.php");
            return;
        }
        else if(strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1){
            $_SESSION['error'] = "Make and Model are required.";
            header("Location: view.php");
            return;

        }



        $sql = "UPDATE autos SET make = :mk, 
            model = :mdl, 
            year  = :yr,
            mileage = :ml 
            WHERE autos_id = :a_id";
        
        $stmt =$pdo->prepare($sql);
        $stmt->execute(array(
            ':mk' => $_POST['make'],
            ':mdl' => $_POST['model'],
            ':yr' => $_POST['year'],
            ':ml' => $_POST['mileage'],
            ':a_id' => $_POST['autos_id']
                ));

        $_SESSION['success'] = "Record Updated!";
        header("Location: view.php");
        return;



    }


    $stmt = $pdo->prepare("SELECT* FROM autos WHERE autos_id = :a_id");
    $stmt->execute(array(':a_id' => $_GET['autos_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row == false){
        $_SESSION['error'] = "Bad Value for User ID";
        header("Location: view.php");
        return;

    }

    $mk = htmlentities($row['make']);
    $mdl = htmlentities($row['model']);
    $yr = htmlentities($row['year']);
    $mil = htmlentities($row['mileage']);
    $autos_id = $row['autos_id'];

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
<h1>Editing Automobile</h1>
<form method="POST">
<p>Make:
<input type="text" name="make" size="60" value="<?= $mk ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $mdl ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $yr ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $mil ?>"></p>
<input type="hidden" name="autos_id" value="<?= $autos_id ?>"></p>
<input type="submit" name="save" value="Save">
<input type="submit" name="cancel" value="Cancel">
</form>
<ul>
<p>
</ul>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>