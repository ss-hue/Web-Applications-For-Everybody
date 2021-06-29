<?php
//Required only here because is when the SQL Query and performance will take place, in this case.
require_once("pdo.php");

$message = false;

$row = False;

if(isset($_POST['logout'])){
    header("Location: index.php");

}


if( !isset($_GET['name']) OR strlen($_GET['name'])<1){

    die("Name parameter missing");

}


if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && ( strlen($_POST['year']) > 1 && strlen($_POST['mileage']) > 1)){
    
    if( isset($_POST['add']) ){
        if( ! is_numeric($_POST['year']) || ! is_numeric($_POST['mileage']) ){

            $message = '<p style="color:red">Mileage and year must be numeric! => '."\"".($_POST['mileage'])."\""." | "."\"".($_POST['year'])."\"".'</p>';

        } else if(strlen($_POST['make']) < 1){
            $message = '<p style="color:red">Make is required!</p>';
        }
        else{
            try{
                $sql = "INSERT INTO autos (make, year, mileage) VALUES (:mk, :yr, :mil)";

                $stmt = $pdo->prepare($sql);

    
                $stmt->execute(array(
                    ':mk' => $_POST['make'],
                    ':yr' => $_POST['year'],
                    ':mil' => $_POST['mileage']
                ));

                $message = '<p style="color:green">Record inserted!</p>'; 

                
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
<h1>Tracking Autos for <?php print($_GET['name']); ?></h1>
<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" name="add" value="Add">
<input type="submit" name="logout" value="Logout">
<?php echo $message?>
</form>
<h2>Automobiles</h2>
<?php
$stmt2 = $pdo->query("SELECT* FROM autos");


echo'<table border="1">'."\n";

while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){

    echo "<tr><td>";
    echo($row['make'])."\n";
    echo "<td><td>";
    echo($row['year'])."\n";
    echo "<td><td>";
    echo($row['mileage'])."\n";
    echo "<td><tr>\n";

}
echo "<table>.\n";

?>
<ul>
<p>
</ul>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>


