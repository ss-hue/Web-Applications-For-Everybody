<?php
    session_start();

    require_once("pdo.php");

    if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
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
<h1>Tracking Autos for <?php print($_SESSION['name']); ?></h1>
<?php if( isset($_SESSION['success'])) print($_SESSION['success']); unset($_SESSION['success']);?>
<h2>Automobiles</h2>
<?php
$stmt2 = $pdo->query("SELECT* FROM autos");


echo'<table border="1">'."\n";

while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){

    echo "<ul>";
    echo("<li>".$row['year'])." ".$row['make']."/ ".$row['mileage']."</li>"."\n";
    echo "</ul>";

}
echo "<table>.\n";

?>
<ul>
<p>
</ul>
<p>
<a href="add.php">Add New</a> |
<a href="logout.php">Logout</a>
</p>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>