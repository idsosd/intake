<?php
include_once('inc/sessie.php');
if( !isset($_SESSION['loggedin']) OR $_SESSION['loggedin'] == 0)
    header("Location: login.php");
include_once('inc/dbconnection.class.php');
include_once('inc/functions.php');

$oplcode=1;
$cohort='21/22';
$dbconnect=new dbconnection();
$sql="SELECT * FROM gesprekken WHERE gespr_opl=:oplcode AND gespr_cohort=:coh ORDER BY gespr_datum, gespr_achternaam";
$query = $dbconnect -> prepare($sql);
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
            <a class="navbar-brand" href="#">Intakegesprekken SD-team Alfa-college</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                 <!--   <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>-->
                </ul>
                <div style="color: white;">
                    <?= $_SESSION['user_email'] ?>&nbsp;&nbsp;&nbsp;
                </div>
                <div class="d-flex">
                    <a class="btn btn-outline-secondary" href="loguit.php">Log uit</a>
                </div>
            </div>
        </div>
    </nav>
</header>
<main class="flex-shrink-0">

<div class="mai-wrapper">

<div class="container">

    <div id="detailsModal"  class="modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
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


<div class="row">	
	<div class="col-lg-10">
<h1>Intakegesprekken Alfa-college SD-team</h1>
	</div>
	<div class="col-lg-2 text-end" style="margin-top: 10px"><button class="btn btn-primary btn-block" onclick="addGesprek()">Voeg toe</button>
	</div>
</div>
<table class="table table-hover">
	<thead class="thead-dark">
    <tr>
      <th class="text-right">#</th>
      <th>Datum</th>
      <th>Naam</th>
      <th>E-mailadres</th>
        <th>Uitgenodigd</th>
      <th>Opleiding</th>
      <th>Nodig</th>
      <th>Advies</th>
      <th>Verwerkt</th>
        <th>Door</th>
    </tr>
  </thead>
<?php
	$i=1;
	foreach($gesprekken as $gesprek)
	{
		$trclass="";
		if($gesprek['gespr_advies']=="")
			$trclass="table-success";
		echo "<tr class='".$trclass."'>";
		echo "<td class='text-end' width='40'><a href='#' onclick=\"showDetails({$gesprek['gespr_id']})\">{$i}.</a></td>";
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
		$opleiding="SD";
		if($gesprek['gespr_opl']==0)
			$opleiding="BEHEER";
        $variant="BOL";
        if($gesprek['gespr_oplvariant']==1)
            $variant="BBL";
		echo "<td width='40'>".$opleiding."-".$variant."</td>";
		echo "<td>".$gesprek['gespr_nodig']."</td>";
		echo "<td class='text-center'>".$gesprek['gespr_advies']."</td>";
		$afgehandeld="<i style='color: red;' class='bi bi-check-circle'></i>";
		if($gesprek['gespr_afgehandeld']==1)
			$afgehandeld="<i style='color: green;' class='bi bi-check-circle'></i>";
		echo "<td id='afgeh_{$gesprek['gespr_id']}' class='text-center'><a href='#' onclick=\"checkAfgehandeld({$gesprek['gespr_id']},{$gesprek['gespr_afgehandeld']})\">{$afgehandeld}</a></td>";
		echo "<td>{$gesprek['gespr_doorwie']}</td>";
		echo "</tr>";
		$i++;
	}
	?>
</table>
</div>
</div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>