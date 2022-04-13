<?php
include_once('inc/sessie.php');
if( !isset($_SESSION['loggedin']) OR $_SESSION['loggedin'] == 0)
    header("Location: login.php");
include_once('inc/dbconnection.class.php');
include_once('inc/functions.php');
include_once('gesprek.class.php');

$gesprek= new Gesprek();

$oplcode=1;
$tweedecohjaar = intval($_GET['coh']) + 1;
$cohort=$_GET['coh']."/".$tweedecohjaar;

$dbconnect=new dbconnection();


$sql = "SELECT * FROM gesprekken WHERE gespr_opl=:oplcode AND gespr_cohort=:coh ORDER BY gespr_datum, gespr_achternaam";
$query = $dbconnect->prepare($sql);
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
            <a class="navbar-brand" href="index.php?coh=<?= $_GET['coh'] ?>"><img src="img/alfalogo.png" alt="" width="40"class="d-inline-block align-text-top">&nbsp;&nbsp;&nbsp;&nbsp;Intakegesprekken SD</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn btn-outline-warning" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?= $cohort ?></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index_overz.php?coh=22">22/23</a></li>
                            <li><a class="dropdown-item" href="index_overz.php?coh=21">21/22</a></li>
                            <li><a class="dropdown-item" href="index_overz.php?coh=20">20/21</a></li>
                        </ul>
                    </li>
                </ul>
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


<div class="row" style="padding-top: 20px;">
	<div class="col">
        <h3>Draaitabel BOL <?= $cohort ?></h3>
        <?php
        $draaitabel = $gesprek->selectStatusDraaitabel($oplcode, $cohort, 0);
        echo $draaitabel;
        ?>
	</div>
</div>
    <div class="row" style="padding-top: 20px;">
    <div class="col">
        <h3>Draaitabel BBL <?= $cohort ?></h3>
        <?php
        $draaitabel = $gesprek->selectStatusDraaitabel($oplcode, $cohort, 1);
        echo $draaitabel;
        ?>
    </div>
</div>
    <div class="row" style="padding-top: 20px;">
        <div class="col">
            <h3>Draaitabel Vooropleiding <?= $cohort ?></h3>
            <?php
            $draaitabel = $gesprek->selectVooroplDraaitabel($oplcode, $cohort, 0);
            echo $draaitabel;
            ?>
        </div>
    </div>
    <div class="row" style="padding-top: 20px;">
        <div class="col">
            <h3>Draaitabel klas <?= $cohort ?></h3>
        </div>
        <div class="col text-end">
            <a class="btn btn-success" href="export_klasindeling.php">DOWNLOAD KLASINDELING</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php
            $draaitabel = $gesprek->selectKlasDraaitabel($oplcode, $cohort, 0);
            echo $draaitabel;
            ?>
        </div>
    </div>
<table class="table table-hover w-auto">
	<thead class="thead-dark">
    <tr>
      <th class="text-right">#</th>
      <th>Naam</th>
      <th>Opl.</th>
        <th>Vooropl.</th>
        <th>Nodig</th>
      <th>Zorgstatus</th>
        <th>Uitkomst</th>
        <th style="width: 15%">Status</th>
        <th style="width: 10%">Klas</th>
    </tr>
  </thead><tbody>
<?php
$uitkomstopties = array(0=>'Geen', 1=>'Geplaatst', 2=>'Afmelden', 3=>'Afgewezen', 4=>'Nieuw gesprek inplannen', 5=>'Andere opleiding binnen Alfa', 6=>'Student heeft zich afgemeld');
	$i=1;
	foreach($gesprekken as $gesprek)
	{
		$trclass="";
		if($gesprek['gespr_zorgstatus']=="")
			$trclass="table-success";
		echo "<tr class='".$trclass."'>";
		echo "<td class='fit text-end' width='40'>{$i}.</td>";
		echo "<td class='fit'>".volledigeNaam(1, $gesprek['gespr_achternaam'], $gesprek['gespr_voorvoegsel'], $gesprek['gespr_roepnaam'])."</td>";
        $variantarray=array(0=>"BOL", 1=>"BBL");
		echo "<td class='fit'>".$variantarray[$gesprek['gespr_oplvariant']]."</td>";
        echo "<td class='fit'>".$gesprek['gespr_vooropl_niv']."</td>";
		echo "<td>".$gesprek['gespr_nodig']."</td>";
		echo "<td class='fit text-center'>".$gesprek['gespr_zorgstatus']."</td>";
        echo "<td class='fit'>".$uitkomstopties[$gesprek['gespr_uitkomst']]."</td>";
		$statusarray = array(0=>"intake", 1=>"afgedrukt", 2=>"definitief",3=>"afgemeld");
        echo "<td class='fit'><SELECT id='aanmstatus_{$gesprek['gespr_id']}' class='form-select form-select-sm' onchange='updateAanmstatus({$gesprek['gespr_id']})'>";
        $j = 0;
        while($j < count($statusarray)){
            $selected = "";
            if($j == $gesprek['gespr_aanmstatus'])
                $selected = "SELECTED";
            echo "<option value='$j' $selected>{$statusarray[$j]}</option>";
            $j++;
        }
        echo "</SELECT></td>";
        $klassenarray = array(0=>"B-ITA4-1a", 1=>"B-ITA4-1b", 2=>"B-ITA4-BBL-1a");
        echo "<td class='fit'><SELECT id='klas_{$gesprek['gespr_id']}' class='form-select form-select-sm' onchange='updateKlas({$gesprek['gespr_id']})'>";
        $k = 0;
        echo "<option value=''>kies...</option>";
        while($k < count($klassenarray)){
            $selected = "";
            if($klassenarray[$k] == $gesprek['gespr_klas'])
                $selected = "SELECTED";
            echo "<option value='$klassenarray[$k]' $selected>{$klassenarray[$k]}</option>";
            $k++;
        }
        echo "</SELECT></td>";
		echo "</tr>";
		$i++;
	}
	?>
    </tbody>
</table>
</div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>