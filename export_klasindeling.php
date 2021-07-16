<?php
include_once('inc/dbconnection.class.php');

header('Content-Type: csv; charset=utf-8');
header('Content-Disposition: attachment; filename=SD-klasindeling-cohort2122.csv');
$output = fopen("php://output", "w");
$headdata=array("Volgnr","Studentid","Achternaam","Roepnaam","Klas");
fputcsv($output,$headdata,";");

$oplcode = 1;
$cohort = "21/22";

$dbconnect = new dbconnection();
$sql = "SELECT * FROM gesprekken WHERE gespr_opl=:oplcode AND gespr_cohort=:coh ORDER BY gespr_achternaam";
$query = $dbconnect->prepare($sql);
$query -> bindParam(':oplcode',$oplcode);
$query -> bindParam(':coh',$cohort);
$query -> execute();

$teller = 1;
while($recset=$query->fetch(PDO::FETCH_ASSOC)){
    $data=array($teller, $recset['gespr_stid'], $recset['gespr_achternaam'],$recset['gespr_roepnaam'],$recset['gespr_klas']);
    fputcsv($output,$data,";");
    $teller++;
}
fclose($output);