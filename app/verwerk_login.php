<?php
include_once("../inc/sessie.php");
include_once("../inc/functions.php");

$wachtwoord=haalWachtwoordOp($_POST['inputEmail']);
//echo "Het wachtwoord is: ".$wachtwoord;

if($wachtwoord=="idsisgek"){
    //de user-status is dus nog 0, er moet nog geverifieerd worden
    $_SESSION['loggedin'] = 0;
    header("Location: ../login.php?error=2");
}
else {
    if (password_verify($_POST['inputPassword'], $wachtwoord)) {
        //de sessievariabele vullen dat je ingelogd bent
        $_SESSION['loggedin'] = 1;
        $_SESSION['user_email'] = $_POST['inputEmail'];
        //de user_id ook opslaan in een sessie-variabele om een apparaat te kunnen reserveren
        $_SESSION['user_id'] = haalUseridOp($_POST['inputEmail']);
        //ga door naar het deel achter de login
        header("Location: ../index.php");
    } else {
        $_SESSION['loggedin'] = 0;
        header("Location: ../login.php?error=1");
    }
}



?>
