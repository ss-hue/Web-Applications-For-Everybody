<?php

if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1){
    die('Name Parameter Missing');
}

if( isset($_POST['logout']) ){
    header("Location: login.php");
    return;
}

$names = array('Rock', 'Paper', 'Scissors');
$human = isset($_POST['human']) ? $_POST['human'] + 0 : -1;

#TODO=> random selection of hand by computer
$computer = rand(0,2);

#encapsulated test on a function, for a better organized code.
function test($names){
    for($h=0;$h<3;$h++) {
        for($c=0;$c<3;$c++) {
            $r = check($h, $c);
            print "Human=$names[$h] Computer=$names[$c] Result=$r\n";
        }
}
}
#check function modified for random selection of hand by computer
function check($human, $computer){

    if ($human > $computer) {
        if ($human == 1 || $computer == 1) {
            return "You win";
        } else {
            return "You lose";
        }
    }
    if($human < $computer){
        if($human == 1 || $computer == 1){
            return "You lose";    
        }
        else{
            return "You win"; 
        }
    }
    if($human == $computer){
        return "Tie";
    }
    return false;
}

$result = check($human, $computer);

?>
<!DOCTYPE html>
<html>
<head>
<title>Sergio Roldán's Rock, Paper, Scissors Game</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Rock Paper Scissors</h1>
<?php
if ( isset($_REQUEST['name']) ) {
    echo "<p>Welcome: ";
    echo htmlentities($_REQUEST['name']);
    echo "</p>\n";
}
?>
<form method="post">
<select name="human">
<option value="-1">Select</option>
<option value="0">Rock</option>
<option value="1">Paper</option>
<option value="2">Scissors</option>
<option value="3">Test</option>
</select>
<input type="submit" value="Play">
<input type="submit" name="logout" value="Logout">
</form>

<pre>
<?php

if($human == -1){
    echo "Please select a strategy and press Play.\n";
}else if($human == 3){
    test($names);
}else {
    print "Your Play=$names[$human] Computer Play=$names[$computer] Result=$result\n";
}

?>
</pre>
</div>
</body>
</html>