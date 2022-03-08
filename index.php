<?php
include_once('inc/sessie.php');
if( !isset($_SESSION['loggedin']) OR $_SESSION['loggedin'] == 0)
    header("Location: login.php");
include_once('inc/dbconnection.class.php');
include_once('inc/functions.php');

$oplcode=1;
$tweedecohjaar = intval($_GET['coh']) + 1;
$cohort=$_GET['coh']."/".$tweedecohjaar;

$intaker = "";
if(isset($_GET['intaker']))
    $intaker = $_GET['intaker'];

$variant = "";
if(isset($_GET['variant']))
    $variant = $_GET['variant'];

$dbconnect=new dbconnection();

if($intaker <> '') {
    if($variant <> '') {
        $sql = "SELECT * FROM gesprekken WHERE gespr_opl=:oplcode AND gespr_cohort=:coh AND gespr_doorwie=:intaker AND gespr_oplvariant=:variant ORDER BY gespr_datum, gespr_achternaam";
        $query = $dbconnect->prepare($sql);
        $query->bindParam(':variant', $variant);
    }
    else {
        $sql = "SELECT * FROM gesprekken WHERE gespr_opl=:oplcode AND gespr_cohort=:coh AND gespr_doorwie=:intaker ORDER BY gespr_datum, gespr_achternaam";
        $query = $dbconnect->prepare($sql);
    }
    $query->bindParam(':intaker', $intaker);
}
else {
    if($variant <> '') {
        $sql = "SELECT * FROM gesprekken WHERE gespr_opl=:oplcode AND gespr_cohort=:coh AND gespr_oplvariant=:variant ORDER BY gespr_datum, gespr_achternaam";
        $query = $dbconnect->prepare($sql);
        $query->bindParam(':variant', $variant);
    }
    else {
        $sql = "SELECT * FROM gesprekken WHERE gespr_opl=:oplcode AND gespr_cohort=:coh ORDER BY gespr_datum, gespr_achternaam";
        $query = $dbconnect->prepare($sql);
    }
}
$query -> bindParam(':oplcode',$oplcode);
$query -> bindParam(':coh',$cohort);
$query -> execute();
$gesprekken = $query -> fetchAll(2);

	?>
<!DOCTYPE html>
<html lang="nl">
  <head>
	  <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="Ids Osinga">
<title>Intake-gesprekken</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
      <link rel="stylesheet" href="css/mystyle.css" />
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="gesprjs.js"></script>

<style>
        .modal_lg {
          width: 1000px; /* New width for default modal */
        }
</style>

 </head>
<body class="d-flex flex-column h-100">
<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index_overz.php"><img src="img/alfalogo.png" alt="" width="40"class="d-inline-block align-text-top">&nbsp;&nbsp;&nbsp;&nbsp;Intakegesprekken SD</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn btn-outline-warning" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?= $cohort ?></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?coh=22&intaker=<?= $intaker ?>">22/23</a></li>
                            <li><a class="dropdown-item" href="index.php?coh=21&intaker=<?= $intaker ?>&variant=0">21/22</a></li>
                            <li><a class="dropdown-item" href="index.php?coh=20&intaker=<?= $intaker ?>&variant=1">20/21</a></li>
                        </ul>
                    </li>
                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle btn btn-outline-warning" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?= $variant ?></a>
                     <ul class="dropdown-menu">
                         <li><a class="dropdown-item" href="index.php?coh=<?= $_GET['coh'] ?>&intaker=<?= $intaker ?>">Beide</a></li>
                         <li><hr class="dropdown-divider"></li>
                         <li><a class="dropdown-item" href="index.php?coh=<?= $_GET['coh'] ?>&intaker=<?= $intaker ?>&variant=0">BOL</a></li>
                         <li><a class="dropdown-item" href="index.php?coh=<?= $_GET['coh'] ?>&intaker=<?= $intaker ?>&variant=1">BBL</a></li>
                     </ul>
                    </li>
                    <li class="nav-item dropdown" style="margin-left: 20px;">
                        <a class="nav-link dropdown-toggle btn btn-outline-warning" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?= $intaker ?></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?coh=<?= $_GET['coh'] ?>&variant=<?= $variant ?>">Alle</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php
                            $sql="SELECT * FROM intaker";
                            $query = $dbconnect -> prepare($sql);
                            $query -> execute();
                            $intakers = $query -> fetchAll(2);
                            foreach($intakers as $intaker){
                                echo "<li><a class='dropdown-item' href='index.php?coh={$_GET['coh']}&intaker={$intaker['it_afk']}&variant=$variant'>{$intaker['it_afk']}</a></li>";
                                }
                            ?>
                        </ul>
                    </li>
                </ul>
                <span class="navbar-text">
                    <a class="btn btn-info" href="intakegesprek.php" tabindex="-1"><i class="bi bi-info-circle"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a class="btn btn-success" href="#" onclick="addGesprek()" tabindex="-1">Voeg toe</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $_SESSION['user_email'] ?>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="loguit.php">Log uit</a>
      </span>
            </div>
        </div>
    </nav>
</header>
<main class="flex-shrink-0">

<div class="container">

    <div id="detailsModal"  class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modal-title" class="modal-title">Details intakegesprek</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="modal-body" class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div  id="modal-footer" class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


<!--<div class="row">
	<div class="col-lg-10">
<h1>Intakegesprekken Alfa-college SD-team</h1>
	</div>
	<div class="col-lg-2 text-end" style="margin-top: 10px"><button class="btn btn-primary btn-block" onclick="addGesprek()">Voeg toe</button>
	</div>
</div>-->
<table class="table table-hover">
	<thead class="thead-dark">
    <tr>
      <th class="text-right">#</th>
      <th>Datum</th>
      <th>Naam</th>
      <th>E-mailadres</th>
        <th>Uitgenodigd</th>
      <th>Opl.</th>
      <th>Nodig</th>
      <th>Zorgstatus</th>
        <th>Uitkomst</th>
      <th>Verwerkt</th>
        <th>Door</th>
        <th>Status</th>
    </tr>
  </thead>
<?php
$uitkomstopties = array(0=>'Geen', 1=>'Geplaatst', 2=>'Afmelden', 3=>'Afgewezen', 4=>'Nieuw gesprek inplannen', 5=>'Andere opleiding binnen Alfa', 6=>'Student heeft zich afgemeld');
	$i=1;
	foreach($gesprekken as $gesprek)
	{
		$trclass="";
		if($gesprek['gespr_zorgstatus']=="")
			$trclass="table-success";
		echo "<tr class='".$trclass."'>";
		echo "<td class='text-end' width='40'><a href='#' onclick=\"showDetails({$gesprek['gespr_id']})\">{$i}.</a></td>";
		if(is_null($gesprek['gespr_datum']) OR $gesprek['gespr_datum'] == '' OR $gesprek['gespr_datum'] == '0000-00-00')
            $datum = "";
		else
		    $datum=strftime('%a %e %h %Y' , strtotime($gesprek['gespr_datum']));
		echo "<td width='150'>".$datum."</td>";
		echo "<td width='250'>".volledigeNaam(1, $gesprek['gespr_achternaam'], $gesprek['gespr_voorvoegsel'], $gesprek['gespr_roepnaam'])."</td>";
		$emailbody = "Beste {$gesprek['gespr_roepnaam']},%0A%0AJe hebt je aangemeld voor de Software Developer opleiding aan het Alfa-college. Het is de bedoeling dat ik eerst een intakegesprek met je doe.%0A
		%0AIk nodig je daarom uit om mij uit te nodigen voor een online bijeenkomst via MS Teams (of een vergelijkbare tool) van een half uur. De momenten waarop ik doorgaans prima kan, zijn:%0A%0A%0AIk ontvang graag een uitnodiging van je!%0A%0A";
		echo "<td width='150'><a href='mailto:{$gesprek['gespr_emailadres1']}?subject=Intakegesprek Alfa-college Software Developer&body=$emailbody'>{$gesprek['gespr_emailadres1']}</a></td>";
        $uitgenodigd="<i style='color: red;' class='bi bi-check-circle'></i>";
        if($gesprek['gespr_uitgenodigd']==1)
            $uitgenodigd="<i style='color: green;' class='bi bi-check-circle'></i>";
		echo "<td id='uitgen_{$gesprek['gespr_id']}' class='text-center'><a href='#' onclick=\"checkUitgenodigd({$gesprek['gespr_id']},{$gesprek['gespr_uitgenodigd']})\">{$uitgenodigd}</a></td>";

       // echo "<td width='150' class='text-center'>".$gesprek['gespr_uitgenodigd']."</td>";
		/*$opleiding="SD";
		if($gesprek['gespr_opl']==0)
			$opleiding="BEHEER";
        $variant="BOL";
        if($gesprek['gespr_oplvariant']==1)
            $variant="BBL";*/
        $variantarray=array(0=>"BOL", 1=>"BBL");
		echo "<td>".$variantarray[$gesprek['gespr_oplvariant']]."</td>";
		echo "<td>".$gesprek['gespr_nodig']."</td>";
		echo "<td class='text-center'>".$gesprek['gespr_zorgstatus']."</td>";
        echo "<td>".$uitkomstopties[$gesprek['gespr_uitkomst']]."</td>";
		$afgehandeld="<i style='color: red;' class='bi bi-check-circle'></i>";
		if($gesprek['gespr_afgehandeld']==1)
			$afgehandeld="<i style='color: green;' class='bi bi-check-circle'></i>";
		echo "<td id='afgeh_{$gesprek['gespr_id']}' class='text-center'><a href='#' onclick=\"checkAfgehandeld({$gesprek['gespr_id']},{$gesprek['gespr_afgehandeld']})\">{$afgehandeld}</a></td>";
		echo "<td>{$gesprek['gespr_doorwie']}</td>";
		$statusarray = array(0=>"intake", 1=>"afgedrukt", 2=>"definitief",3=>"afgemeld");
        echo "<td>{$statusarray[$gesprek['gespr_aanmstatus']]}</td>";
		echo "</tr>";
		$i++;
	}
	?>
</table>
</div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>