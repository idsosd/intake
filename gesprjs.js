function showDetails(gesprid)
{
	var submit_button="<button type='submit' form='gespreksform' class='btn btn-primary'>Bewaar</button>";
	var reset_button="<button type='reset' form='gespreksform' class='btn btn-secondary'>Reset</button>";
	var delete_button="<button type='button' class='btn btn-danger' onclick=\"deleteGesprek(" + gesprid + ")\">Verwijder</button>";
	$.ajax({                                      
      url: 'gesprjs.php',      
      data: { 
	      action: 'select', 
	      gespr_id: gesprid },
	  dataType: 'json',   
      type: 'post',
      success: function(data) {
	    $('#detailsModal').modal("show");
	    $('#modal-title').empty().append("Details intakegesprek " + data[0]);
		$('#modal-body').empty().append(data[1]);
		$('#modal-footer').empty().append(delete_button + reset_button + submit_button); 
	      },
      error: function() { alert("De gespreksdetails kunnen niet worden getoond!"); }
    });
}

function updateGesprek(gesprid)
{
	var stid = $('#stid').val();
	var leeftijd = $('#leeftijd').val();
	var emailadres1 = $('#emailadres1').val();
	var emailadres2 = $('#emailadres2').val();
	var tel1 = $('#tel1').val();
	var opl = $('#opl').val();
	var oplvariant = $('#oplvariant').val();
	let oplcohort = $('#oplcohort').val();
	var doorwie = $('#doorwie').val();
	var datum = $('#datum').val();
	var vorigeopl = $('#vorigeopl').val();
	var andereintake = $('#andereintake').val();
	var thuissituatie = $('#thuissituatie').val();
	var vrijetijd = $('#vrijetijd').val();
	var waarom = $('#waarom').val();
	var doel = $('#doel').val();
	var nodig = $('#nodig').val();
	var voorkennis = $('#voorkennis').val();
	var generiek = $('#generiek').val();
	var vaardigheden = $('#vaardigheden').val();
	var opmerking = $('#opmerking').val();
	var vooropl = $('.vooropl:checked').val();
	var voork = $('.voork:checked').val();
	var zorgstatus = $('#zorgstatus').val();
	var uitkomst = $('#uitkomst').val();
	$.ajax({                                      
      url: 'gesprjs.php',      
      data: { 
	      action: 'update', 
	      gesprid: gesprid,
	      stid: stid,
		  leeftijd: leeftijd,
		  emailadres1: emailadres1,
		  emailadres2: emailadres2,
		  tel1: tel1,
		  opl: opl,
		  oplvariant: oplvariant,
		  oplcohort: oplcohort,
		  doorwie: doorwie,
	      datum: datum,
		  vorigeopl: vorigeopl,
	      andereintake: andereintake,
		  thuissituatie: thuissituatie,
		  vrijetijd: vrijetijd,
		  waarom: waarom,
		  doel: doel,
		  nodig: nodig,
		  voorkennis: voorkennis,
		  generiek: generiek,
		  vaardigheden: vaardigheden,
		  opmerking: opmerking,
		  vooropl: vooropl,
		  voork: voork,
	      zorgstatus: zorgstatus,
		  uitkomst: uitkomst
	       },
	  //dataType: 'json',   
      type: 'post',
      success: function() {
	    //alert(data + " " + doorwie + " " + extracont);
	    $('#detailsModal').modal("hide");
	    window.location.reload();	  
	      },
      error: function() { alert("De gespreksdetails kunnen niet worden ge-update!"); }
    });
}

function addGesprek()
{
	var form="<form id='addgesprek' onsubmit=\"insertGesprek(); return false\">" +
				"<div class='row'>" +
		"<div class='col-2'>" +
		"<label for='studnr'><b>Studentnr</b></label>" +
		"<input id='studnr' class='form-control' type='text'>" +
		"</div>" +
				"<div class='col-3'>" +
				"<label for='achternaam'><b>Achternaam</b></label>" +
				"<input id='achternaam' class='form-control' type='text' placeholder='achternaam' required>" +
				"</div>" +
				"<div class='col-2'>" +
				"<label for='voorv'><b>Voorv.</b></label>" +
				"<input id='voorv' class='form-control' type='text' placeholder='voorvoegsel'>" +
				"</div>" +
				"<div class='col-3'>" +
				"<label for='roepnaam'><b>Roepnaam</b></label>" +
				"<input id='roepnaam' class='form-control' type='text' placeholder='roepnaam' required>" +
				"</div>" +
		"<div class='col-2'>" +
		"<label for='geslacht'><b>Geslacht</b></label>" +
		"<SELECT id='geslacht' class='form-control' required>" +
		"<option value=''>kies...</option>" +
		"<option value='m'>man</option>" +
		"<option value='v'>vrouw</option>" +
		"<option value='n'>neutraal</option>" +
		"</SELECT>" +
		"</div>" +
		"</div>" +
		"<div class='row'>" +

				"<div class='col'>" +
				"<label for='email1'><b>E-mailadres 1</b></label>" +
				"<input id='email1' class='form-control' type='email' placeholder='' required>" +
				"</div>" +
				"<div class='col'>" +
				"<label for='email2'><b>E-mailadres 2</b></label>" +
				"<input id='email2' class='form-control' type='email' placeholder=''>" +
				"</div>" +
		"<div class='col'>" +
		"<label for='tel1'><b>Telefoonnr. 1</b></label>" +
		"<input id='tel1' class='form-control' type='text' placeholder='' required>" +
		"</div>" +
				"</div>" +
				"<div class='row'>" +
				"<div class='col-md-1'>" +
				"<label for='leeftijd'><b>Leeftijd</b></label>" +
				"<input id='leeftijd' class='form-control' type='text' placeholder=''>" +
				"</div>" +
				"<div class='col-md-3'>" +
				"<label for='opl'><b>Opleiding</b></label>" +
				"<SELECT id='opl' class='form-control' required>" +
				"<option value=''>kies...</option>" +
				"<option value='0'>Expert IT systems and devices</option>" +
				"<option value='1'>Software Developer</option>" +
				"</SELECT>" +
				"</div>" +
				"<div class='col-md-2'>" +
				"<label for='var'><b>Variant</b></label>" +
				"<SELECT id='var' class='form-control' required>" +
				"<option value=''>kies...</option>" +
				"<option value='0'>BOL</option>" +
				"<option value='1'>BBL</option>" +
				"</SELECT>" +
				"</div>" +
		"<div class='col-md-1'>" +
		"<label for='coh'><b>Cohort</b></label>" +
		"<SELECT id='coh' class='form-control' required>" +
		"<option value=''>kies...</option>" +
		"<option value='20/21'>20/21</option>" +
		"<option value='21/22'>21/22</option>" +
		"<option value='22/23'>22/23</option>" +
		"<option value='23/24'>23/24</option>" +
		"</SELECT>" +
		"</div>" +
				"<div class='col-md-3'>" +
				"<label for='datum'><b>Datum</b></label>" +
				"<input id='datum' class='form-control' type='date'>" +
				"</div>" +
				"<div class='col-md-2'>" +
				"<label for='doorwie'><b>Door</b></label>" +
				"<SELECT id='doorwie' class='form-control' required>" +
				"<option value=''>kies...</option>" +
				"<option value='JIO'>JIO</option>" +
				"<option value='OSD'>OSD</option>" +
				"<option value='RUH'>RUH</option>" +
				"</SELECT>" +
				"</div>" +
				"</div>" +
				"</form>";
	var bewaarknop="<button type='submit' form='addgesprek' class='btn btn-primary'>Bewaar</button>";			
	$('#detailsModal').modal("show");
	$('#modal-title').empty().append("Voeg gesprek toe");	
	$('#modal-body').empty().append(form);
	$('#modal-footer').empty().append(bewaarknop);	
}

function insertGesprek()
{
	let studnr = $('#studnr').val();
	let achternaam = $('#achternaam').val();
	let voorv = $('#voorv').val();
	let roepnaam = $('#roepnaam').val();
	let geslacht = $('#geslacht').val();
	let leeftijd = $('#leeftijd').val();
	let datum = $('#datum').val();
	let tel1 = $('#tel1').val();
	let email1 = $('#email1').val();
	let email2 = $('#email2').val();
	let opl = $('#opl').val();
	let variant = $('#var').val();
	let cohort = $('#coh').val()
	let wie = $('#doorwie').val();
	$.ajax({                                      
      url: 'gesprjs.php',      
      data: { 
	      action: 'insert',
		  studnr: studnr,
	      achternaam: achternaam,
		  voorv: voorv,
		  roepnaam: roepnaam,
		  geslacht: geslacht,
		  leeftijd: leeftijd,
	      datum: datum,
	      tel1: tel1,
	      email1: email1,
		  email2: email2,
	      opl: opl,
		  var: variant,
		  coh: cohort,
	      wie: wie
	       },
      type: 'post',
      success: function() {
	      //alert("gaat goed!" + naam + " " + datum + " " + tel1 + " " + email1 + " " + opl);
	    $('#detailsModal').modal("hide");
	    window.location.reload();	  
	      },
      error: function() { alert("Het nieuwe gesprek kan niet worden toegevoegd!" + naam + " " + datum + " " + tel1 + " " + email1 + " " + opl + " " + wie); }
    });
}

function deleteGesprek(gesprid)
{
	if(confirm("Weet je zeker dat je dit gesprek wilt verwijderen?"))
	{
		$.ajax({                                      
	    url: 'gesprjs.php',      
	    data: { 
		      action: 'delete', 
		      gesprid: gesprid
		      },
		//dataType: 'json',   
	    type: 'post',
	    success: function() {
		      //alert("gaat goed!" + naam + " " + datum + " " + tel1 + " " + tel2 + " " + opl);
		    $('#detailsModal').modal("hide");
		    window.location.reload();	  
		      },
	    error: function() { alert("Het gesprek kan niet worden verwijderd!"); }
	    	});
	}
}

function checkAfgehandeld(gesprid,afgehwaarde)
{
	var input;
	var link;
	if(afgehwaarde===1)
	{
		input=0;
		link="<a href='#' onclick=\"checkAfgehandeld(" + gesprid + "," + input + ")\"><i style='color: red;' class='bi bi-check-circle'>";
	}	
	else
	{
		input=1;
		link="<a href='#' onclick=\"checkAfgehandeld(" + gesprid + "," + input + ")\"><i style='color: green;' class='bi bi-check-circle'>";
	}	
	$.ajax({                                      
	    url: 'gesprjs.php',      
	    data: { 
		      action: 'update_afgeh', 
		      gesprid: gesprid,
		      afgeh: input
		      },
		//dataType: 'json',   
	    type: 'post',
	    success: function() {
		      //alert("gaat goed!" + naam + " " + datum + " " + tel1 + " " + tel2 + " " + opl);
		    $('#afgeh_' + gesprid).empty().append(link);
		      },
	    error: function() { alert("Het gesprek kan niet worden verwijderd!"); }
	    	});		
}

function checkUitgenodigd(gesprid,uitgenwaarde)
{
	var input;
	var link;
	if(uitgenwaarde===1)
	{
		input=0;
		link="<a href='#' onclick=\"checkUitgenodigd(" + gesprid + "," + input + ")\"><i style='color: red;' class='bi bi-check-circle'>";
	}
	else
	{
		input=1;
		link="<a href='#' onclick=\"checkUitgenodigd(" + gesprid + "," + input + ")\"><i style='color: green;' class='bi bi-check-circle'>";
	}
	$.ajax({
		url: 'gesprjs.php',
		data: {
			action: 'update_uitgen',
			gesprid: gesprid,
			uitgen: input
		},
		//dataType: 'json',
		type: 'post',
		success: function() {
			//alert("gaat goed!" + naam + " " + datum + " " + tel1 + " " + tel2 + " " + opl);
			$('#uitgen_' + gesprid).empty().append(link);
		},
		error: function() { alert("Het gesprek kan niet worden verwijderd!"); }
	});
}

function updateAanmstatus(aanmid){
	let aanmstatus = $("#aanmstatus_" + aanmid).val();
	$.ajax({
		url: 'gesprjs.php',
		data: {
			action: 'update_aanmstatus',
			inp_aanmid: aanmid,
			inp_aanmstatus: aanmstatus
		},
		type: 'post',
		success: function() { },
		error: function(){
			alert("De aanmeldstatus kan niet worden bijgewerkt" + aanmstatus);
		}
	})
}

function updateKlas(aanmid){
	let klas = $("#klas_" + aanmid).val();
	$.ajax({
		url: 'gesprjs.php',
		data: {
			action: 'update_klas',
			inp_aanmid: aanmid,
			inp_klas: klas
		},
		type: 'post',
		success: function() { },
		error: function(){
			alert("De klas kan niet worden bijgewerkt");
		}
	})
}