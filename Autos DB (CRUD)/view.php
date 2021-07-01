<?php
    session_start();

    require_once("pdo.php");

    if ( ! isset($_SESSION['name']) ) {
    die('ACCESS DENIED');
    }

?>
<!DOCTYPE html>
<html>
<head>
<title>Sergio Roldán's Automobile Tracker</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Welcome to the Automobiles Database</h1>
<p><?php if( isset($_SESSION['success'])) echo'<p style="color:green">'.($_SESSION['success']).'</p>'; unset($_SESSION['success']);?></p>
<?php if( isset($_SESSION['error'])) echo'<p style="color:red">'.($_SESSION['error']).'</p>'; unset($_SESSION['error']);?>
<h2>Automobiles</h2>
<?php
$stmt2 = $pdo->query("SELECT* FROM autos");



if($stmt2->rowCount()>0){

    echo'<table border="1">'."\n";
    echo"<thead>";
    echo"<tr>";
    echo"<th>Make</th>";
    echo"<th>Model</th>";
    echo"<th>Year</th>";
    echo"<th>Mileage</th>";
    echo"<th>Action</th>";
    echo"</tr>";
    echo"</thead>";

    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
        
        echo"<tr><td>";
        echo(htmlentities($row['make']));
        echo"</td><td>";
        echo(htmlentities($row['model']));
        echo"</td><td>";
        echo(htmlentities($row['year']));
        echo"</td><td>";
        echo(htmlentities($row['mileage']));
        echo"</td><td>";
        echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
        echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
        echo"</td></tr>\n";


    }
    echo "<table>.\n";

    }
    else{
        echo'<p style="color:black">'."No rows are found...".'</p>';
    }





?>
<ul>
<p>

</ul>
<p>
<a href="add.php">Add New Entry</a><br>
<a href="logout.php">Logout</a>
</p>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>