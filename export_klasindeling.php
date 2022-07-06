<?php
include_once('inc/dbconnection.class.php');
$coh = $_GET['coh'];
$coh2 = $coh + 1;
header('Content-Type: csv; charset=utf-8');
header('Content-Disposition: attachment; filename=SD-klasindeling-cohort'.$coh.$coh2.'.csv');
$output = fopen("php://output", "w");
$headdata=array("Volgnr","Studentid","Achternaam","Roepnaam","Cohort","Klas");
fputcsv($output,$headdata,";");

$oplcode = 1;
$cohort = $coh."/".$coh2;
$variant = 0;

$dbconnect = new dbconnection();
$sql = "SELECT * FROM gesprekken WHERE gespr_opl=:oplcode AND gespr_cohort=:coh AND gespr_oplvariant=:variant ORDER BY gespr_achternaam";
$query = $dbconnect->prepare($sql);
$query -> bindParam(':oplcode',$oplcode);
$query -> bindParam(':coh',$cohort);
$query -> bindParam(':variant',$variant);
$query -> execute();

$teller = 1;
while($recset=$query->fetch(PDO::FETCH_ASSOC)){
    $data=array($teller, $recset['gespr_stid'], $recset['gespr_achternaam'],$recset['gespr_roepnaam']." ".$recset['gespr_voorvoegsel'],$cohort,$recset['gespr_klas']);
    fputcsv($output,$data,";");
    $teller++;
}
fclose($output);