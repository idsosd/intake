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
{
    $gesprek -> updateGesprek();
}
elseif($action=="insert")
{
	$gesprek -> insertGesprek();
}
/*
elseif($action=="delete")
{
	if(dbConnect())
	{
		$sql="DELETE FROM gesprekken WHERE gespr_id=:gesprid";
		dbQuery($sql,array(':gesprid'=>$_POST['gesprid']));
	}
}*/
elseif($action=="update_afgeh")
{
    $gesprek -> updateAfgehandeld();
}
elseif($action=="update_uitgen")
{
    $gesprek -> updateUitgenodigd();
}
