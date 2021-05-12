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
	var nummer = $('#nummer').val();
	var datum = $('#datum').val();
	var tel1 = $('#tel1').val();
	var email1 = $('#email1').val();
	var extracont = $('#extracontgeg').val();
	var doorwie = $('#doorwie').val();
	var bijzonderheden = $('#bijzonderheden').val();
	var vorigeopl = $('#vorigeopl').val();
	var waarom = $('#waarom').val();
	var doel = $('#doel').val();
	var nodig = $('#nodig').val();
	var advies = $('#advies').val();
	var opmerking = $('#opmerking').val();
	$.ajax({                                      
      url: 'gesprjs.php',      
      data: { 
	      action: 'update', 
	      gesprid: gesprid,
	      nummer: nummer,
	      datum: datum,
	      tel1: tel1,
	      email1: email1,
	      extrac: extracont,
	      wie: doorwie,
	      bijz: bijzonderheden,
	      voropl: vorigeopl,
	      waarom: waarom,
	      doel: doel,
	      nod: nodig,
	      adv: advies,
	      opm: opmerking
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
				"<div class='col'>" +
				"<label for='achternaam'>Achternaam</label>" +
				"<input id='achternaam' class='form-control' type='text' placeholder='achternaam' required>" +
				"</div>" +
				"<div class='col'>" +
				"<label for='voorv'>Voorv.</label>" +
				"<input id='voorv' class='form-control' type='text' placeholder='voorvoegsel'>" +
				"</div>" +
				"<div class='col'>" +
				"<label for='roepnaam'>Roepnaam</label>" +
				"<input id='roepnaam' class='form-control' type='text' placeholder='roepnaam' required>" +
				"</div>" +
		"</div>" +
		"<div class='row'>" +
				"<div class='col'>" +
				"<label for='tel1'>Telefoonnr. 1</label>" +
				"<input id='tel1' class='form-control' type='text' placeholder='' required>" +
				"</div>" +
				"<div class='col'>" +
				"<label for='email1'>E-mailadres 1</label>" +
				"<input id='email1' class='form-control' type='email' placeholder='' required>" +
				"</div>" +
				"<div class='col'>" +
				"<label for='email2'>E-mailadres 2</label>" +
				"<input id='email2' class='form-control' type='email' placeholder=''>" +
				"</div>" +
				"</div>" +
				"<div class='row'>" +
				"<div class='col'>" +
				"<label for='opl'>Opleiding</label>" +
				"<SELECT id='opl' class='form-control' required>" +
				"<option value=''>kies...</option>" +
				"<option value='0'>Expert IT systems and devices</option>" +
				"<option value='1'>Software Developer</option>" +
				"</SELECT>" +
				"</div>" +
				"<div class='col'>" +
				"<label for='var'>Variant</label>" +
				"<SELECT id='var' class='form-control' required>" +
				"<option value=''>kies...</option>" +
				"<option value='0'>BOL</option>" +
				"<option value='1'>BBL</option>" +
				"</SELECT>" +
				"</div>" +
				"<div class='col'>" +
				"<label for='datum'>Datum</label>" +
				"<input id='datum' class='form-control' type='date'>" +
				"</div>" +
				"<div class='form-group col'>" +
				"<label for='doorwie'>Door wie</label>" +
				"<SELECT id='doorwie' class='form-control' required>" +
				"<option value=''>kies...</option>" +
				"<option value='JIO'>Jorgen Nieboer</option>" +
				"<option value='OSD'>Ids Osinga</option>" +
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
	var achternaam = $('#achternaam').val();
	var voorv = $('#voorv').val();
	var roepnaam = $('#roepnaam').val();
	var datum = $('#datum').val();
	var tel1 = $('#tel1').val();
	var email1 = $('#email1').val();
	var email2 = $('#email2').val();
	var opl = $('#opl').val();
	var variant = $('#var').val();
	var wie = $('#doorwie').val();
	$.ajax({                                      
      url: 'gesprjs.php',      
      data: { 
	      action: 'insert', 
	      achternaam: achternaam,
		  voorv: voorv,
		  roepnaam: roepnaam,
	      datum: datum,
	      tel1: tel1,
	      email1: email1,
		  email2: email2,
	      opl: opl,
		  var: variant,
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
	if(afgehwaarde==1)
	{
		var input=0;
		var link="<a href='#' onclick=\"checkAfgehandeld(" + gesprid + "," + input + ")\"><i style='color: red;' class='bi bi-check-circle'>";
	}	
	else
	{
		var input=1;
		var link="<a href='#' onclick=\"checkAfgehandeld(" + gesprid + "," + input + ")\"><i style='color: green;' class='bi bi-check-circle'>";
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
	if(uitgenwaarde==1)
	{
		var input=0;
		var link="<a href='#' onclick=\"checkUitgenodigd(" + gesprid + "," + input + ")\"><i style='color: red;' class='bi bi-check-circle'>";
	}
	else
	{
		var input=1;
		var link="<a href='#' onclick=\"checkUitgenodigd(" + gesprid + "," + input + ")\"><i style='color: green;' class='bi bi-check-circle'>";
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