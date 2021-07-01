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

    if(isset($_POST['delete']) && isset($_POST['autos_id'])){
        $sql = "DELETE FROM autos WHERE autos_id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->execute(array(':id' => $_POST['autos_id']));

        $_SESSION['success'] = 'Record Deleted';
        header("Location: view.php");
        return;
    }

    

    $stmt = $pdo->prepare("SELECT* FROM autos WHERE autos_id = :a_id");
    $stmt->execute(array(':a_id' => $_GET['autos_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row == false){
        $_SESSION['error'] = "Bad Value for user_id";
        header("Location: view.php");
        return;
    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sergio Roldán</title>
</head>
<body>
<p>Confirm : Deleting <?= htmlentities($row['make']) ?></p>

<form method="POST">
<input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
<input type="submit" name="delete" value="Delete">
<a href="view.php">Cancel</a>
</form>
    
</body>
</html>
