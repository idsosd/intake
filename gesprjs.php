<?php
include_once('gesprek.class.php');
$action = $_POST['action'];

$gesprek = new Gesprek();

if ($action=='select')
{
    $returndata=array();
    $returndata = $gesprek -> selectGesprek();
	echo json_encode($returndata);
}
elseif($action=="update")
    $gesprek -> updateGesprek();
elseif($action=="insert")
	$gesprek -> insertGesprek();
elseif($action=="delete")
    $gesprek -> deleteGesprek();
elseif($action=="update_afgeh")
    $gesprek -> updateAfgehandeld();
elseif($action=="update_uitgen")
    $gesprek -> updateUitgenodigd();
elseif($action=="update_aanmstatus")
    $gesprek -> updateAanmstatus();
