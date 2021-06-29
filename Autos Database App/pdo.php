<?php

$pdo = new PDO('mysql:host=localhost;port=XXXX;dbname=Autos', username, pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
