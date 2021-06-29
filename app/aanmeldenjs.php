<?php
include_once('../inc/dbconnection.class.php');

$dbconnect = new dbconnection();
$sql="UPDATE gesprekken
SET gespr_aanmstatus=:status
WHERE gespr_id=:id";
$query = $dbconnect -> prepare($sql);
$query -> bindParam(':status',$_POST['inp_aanmstatus']);
$query -> bindParam(':id',$_POST['inp_aanmid']);
$query -> execute();
?>