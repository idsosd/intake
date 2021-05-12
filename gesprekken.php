<?php
@include_once('inc/sessie.php');
@include_once('inc/db.php');
$sql="SELECT * FROM gesprekken ORDER BY gespr_datum, gespr_naam";
if(dbConnect())
{
	dbQuery($sql,array());
	$gesprekken=dbGetAll();
	//echo "<pre>";
	//print_r($gesprekken);
	//echo "</pre>";	
}
	
	?>
<!DOCTYPE html>
<html lang="nl">
  <head>
	  <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="Ids Osinga">
<title>Welkomstgesprekken</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.0.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/a293ef7e4c.js" crossorigin="anonymous"></script>
<script src="gesprjs.js"></script>

<style>
        .modal_lg {
          width: 1000px; /* New width for default modal */
        }
</style>

 </head>
<body>
	
<div class="mai-wrapper">

<div class="container">	

<div id="detailsModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="modal-title" class="modal-title">Details welkomstgesprek</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modal-body" class="modal-body"></div>
      <div id="modal-footer" class="modal-footer"></div>
    </div>
  </div>
</div>

<div class="row">	
	<div class="col-lg-10">
<h1>Welkomstgesprekken Alfa-college OSD</h1>
	</div>
	<div class="col-lg-2" style="margin-top: 10px"><button class="btn btn-primary btn-block" onclick="addGesprek()">Voeg toe</button>
	</div>
</div>
<table class="table table-hover">
	<thead class="thead-dark">
    <tr>
      <th class="text-right">#</th>
      <th>Datum</th>
      <th>Naam</th>
      <th>Telefoon</th>
      <th>Opleiding</th>
      <th>Nodig</th>
      <th>Advies</th>
      <th>Verwerkt</th>
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
		echo "<td class='text-right' width='40'><a href='#' onclick=\"showDetails({$gesprek['gespr_id']})\">{$i}.</a></td>";
		$datum=strftime('%a %e %h %Y' , strtotime($gesprek['gespr_datum']));
		echo "<td width='150'>".$datum."</td>";
		echo "<td width='250'>".$gesprek['gespr_naam']."</td>";
		echo "<td width='150'>".$gesprek['gespr_tel1']."</td>";
		$opleiding="AO";
		if($gesprek['gespr_opl']==0)
			$opleiding="BEHEER";
		echo "<td width='40'>".$opleiding."</td>";
		echo "<td>".$gesprek['gespr_nodig']."</td>";
		echo "<td class='text-center'>".$gesprek['gespr_advies']."</td>";
		$afgehandeld="<i style='color: red;' class='far fa-circle'></i>";
		if($gesprek['gespr_afgehandeld']==1)
			$afgehandeld="<i style='color: green;' class='far fa-check-circle'></i>";
		echo "<td id='afgeh_{$gesprek['gespr_id']}' class='text-center'><a href='#' onclick=\"checkAfgehandeld({$gesprek['gespr_id']},{$gesprek['gespr_afgehandeld']})\">{$afgehandeld}</a></td>";
		echo "</tr>";
		$i++;
	}
	?>
</table>
</div>
</div>
</body>
</html>