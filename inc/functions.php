<?php
include_once("dbconnection.class.php");

function volledigeNaam($type, $achternaam, $voorvoegsel, $roepnaam){
    if($type==0){
        $returnstmt = $roepnaam;
        if(!is_null($voorvoegsel) AND $voorvoegsel<>"")
            $returnstmt.=" ".$voorvoegsel;
        $returnstmt.=" ".$achternaam;
    }
    else {
        $returnstmt = $achternaam.", ".$roepnaam;
        if(!is_null($voorvoegsel) AND $voorvoegsel<>"")
            $returnstmt.=" ".$voorvoegsel;
    }
    return $returnstmt;
}

function haalWachtwoordOp($emailadres){
    $dbconnect = new dbconnection();
    $sql = "SELECT user_password, user_status FROM user WHERE user_email=:mail";
    $query = $dbconnect -> prepare($sql);
    $query->bindParam(":mail", $emailadres);
    $query ->execute();
    $recset = $query->fetch(PDO::FETCH_ASSOC);
    if($recset['user_status'] == 1) {
        //dan is de user dus geverifieerd en kan het wachtwoord geretourneerd worden
        return $recset['user_password'];
    }
    else {
        return "idsisgek";
    }
}

function haalUseridOp($emailadres){
    $dbconnect = new dbconnection();
    $sql = "SELECT user_id FROM user WHERE user_email=:mail";
    $query = $dbconnect -> prepare($sql);
    $query->bindParam(":mail", $emailadres);
    $query ->execute();
    return $query->fetchColumn();
}

function checkEmailadres($emailadres){
    $dbconnect = new dbconnection();
    $sql = "SELECT COUNT(*) FROM user WHERE user_email = :mail";
    $query = $dbconnect -> prepare($sql);
    $query->bindParam(":mail", $emailadres);
    $query ->execute();
    return $query->fetchColumn();
}

function insertUser($mail,$password){
    $dbconnect = new dbconnection();
    $sql = "INSERT INTO user (user_email, user_password) VALUES(:mailadres,:wachtwoord)";
    $query = $dbconnect -> prepare($sql);
    $query->bindParam(":mailadres", $mail);
    $query->bindParam(":wachtwoord", $password);
    $query ->execute();
    return $dbconnect -> lastInsertId();
}