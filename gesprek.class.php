<?php
include_once('inc/dbconnection.class.php');
include_once('inc/functions.php');

class Gesprek
{
   public function selectGesprek(){
       try{
           $dbconnect = new dbconnection();
           $sql="SELECT * FROM gesprekken WHERE gespr_id=:id";
           $query = $dbconnect -> prepare($sql);
           $query -> bindParam(':id', $_POST['gespr_id']);
           $query -> execute();
           $recset = $query -> fetch(2);

           $returnstmt = "<form id='gespreksform' onsubmit=\"updateGesprek('{$recset['gespr_id']}');return false;\">";
           $returnstmt .= "<div class='row' style='background: coral;'>";
           $returnstmt .= "<div class='col-2'>";
           $returnstmt .= "<label for='stid'><b>Studentnr</b></label>";
           $returnstmt .= "<input id='stid' class='form-control' type='text' value='{$recset['gespr_stid']}'>";
           $returnstmt .= "</div>";
           $returnstmt .= "<div class='col-3'>";
           $returnstmt .= "<label for='achternaam'><b>Achternaam</b></label>";
           $returnstmt .= "<input id='achternaam' class='form-control' type='text' value='{$recset['gespr_achternaam']}' required>";
           $returnstmt .= "</div>";
           $returnstmt .= "<div class='col-2'>";
           $returnstmt .= "<label for='voorv'><b>Voorv.</b></label>";
           $returnstmt .= "<input id='voorv' class='form-control' type='text' value='{$recset['gespr_voorvoegsel']}'>";
           $returnstmt .= "</div>";
           $returnstmt .= "<div class='col-3'>";
           $returnstmt .= "<label for='roepnaam'><b>Roepnaam</b></label>";
           $returnstmt .= "<input id='roepnaam' class='form-control' type='text' value='{$recset['gespr_roepnaam']}' required>";
           $returnstmt .= "</div>";
           $returnstmt .= "<div class='col-2'>";
           $returnstmt .= "<label for='geslacht'><b>Geslacht</b></label>";

           $geslachtarray= array('man', 'vrouw', 'neutraal');
           $returnstmt.="<SELECT id='geslacht' class='form-control' required>";
           $returnstmt.="<option value=''>kies...</option>";
           $geslteller = 0;
           while($geslteller < count($geslachtarray)){
               $selected = "";
               if(substr($geslachtarray[$geslteller], 0, 1) == $recset['gespr_geslacht'])
                   $selected = "SELECTED";
               $returnstmt.="<option value='".substr($geslachtarray[$geslteller], 0, 1)."' $selected>$geslachtarray[$geslteller]</option>";
               $geslteller++;
           }
           $returnstmt.="</SELECT>";
           $returnstmt .= "</div>";
           $returnstmt .= "</div>";
           $returnstmt .= "<div class='row'>";
           $returnstmt .= "<div class='col'>";
           $returnstmt .= "<label for='emailadres1'><b>E-mailadres 1</b></label>";
           $returnstmt .= "<input id='emailadres1' class='form-control' type='email' value='{$recset['gespr_emailadres1']}' required>";
           $returnstmt .= "</div>";
           $returnstmt .= "<div class='col'>";
           $returnstmt .= "<label for='emailadres2'><b>E-mailadres 2</b></label>";
           $returnstmt .= "<input id='emailadres2' class='form-control' type='email' value='{$recset['gespr_emailadres2']}'>";
           $returnstmt .= "</div>";
           $returnstmt .= "<div class='col'>";
           $returnstmt .= "<label for='tel1'><b>Telefoonnr. 1</b></label>";
           $returnstmt .= "<input id='tel1' class='form-control' type='text' value='{$recset['gespr_tel1']}' required>";
           $returnstmt .= "</div>";
           $returnstmt .= "</div>";
           $returnstmt .= "<div class='row'>";
           $returnstmt .= "<div class='col-md-1'>";
           $returnstmt .= "<label for='leeftijd'><b>Leeftijd</b></label>";
           $returnstmt .= "<input id='leeftijd' class='form-control' type='text' value='{$recset['gespr_leeftijd']}'>";
           $returnstmt .= "</div>";
           $returnstmt .= "<div class='col-md-3'>";
           $returnstmt.="<label for='opl'><b>Opleiding</b></label>";
           $selectedOpl0="";
           $selectedOpl1="";
           if($recset['gespr_opl']==0)
               $selectedOpl0="SELECTED";
           elseif($recset['gespr_opl']==1)
               $selectedOpl1="SELECTED";
           $returnstmt.="<SELECT id='opl' class='form-control' required>";
           $returnstmt.="<option value=''>kies...</option>";
           $returnstmt.="<option value='0' ".$selectedOpl0.">Expert IT systems and devices</option>";
           $returnstmt.="<option value='1' ".$selectedOpl1.">Software Developer</option>";
           $returnstmt.="</SELECT>";
           $returnstmt .= "</div>";
           $returnstmt .= "<div class='col-md-2'>";
           $returnstmt.="<label for='oplvariant'><b>Variant</b></label>";
           $selectedVariant0="";
           $selectedVariant1="";
           if($recset['gespr_oplvariant']==0)
               $selectedVariant0="SELECTED";
           elseif($recset['gespr_oplvariant']==1)
               $selectedVariant1="SELECTED";
           $returnstmt.="<SELECT id='oplvariant' class='form-control' required>";
           $returnstmt.="<option value=''>kies...</option>";
           $returnstmt.="<option value='0' ".$selectedVariant0.">BOL</option>";
           $returnstmt.="<option value='1' ".$selectedVariant1.">BBL</option>";
           $returnstmt.="</SELECT>";
           $returnstmt .= "</div>";
           $returnstmt .= "<div class='col-md-1'>";
           $cohortarray = array('20' => '20/21', '21' => '21/22', 22 => '22/23', 23 => '23/24');
           $returnstmt.="<label for='oplcohort'><b>Cohort</b></label>";
           $returnstmt.="<SELECT id='oplcohort' class='form-control' required>";
           $returnstmt.="<option value=''>kies...</option>";
           foreach ($cohortarray as $key => $value) {
               $selected = "";
               if($recset['gespr_cohort'] == $value)
                   $selected = "SELECTED";
               $returnstmt.="<option value='$value' $selected>$value</option>";
           }
           $returnstmt.="</SELECT>";
           $returnstmt .= "</div>";
           $returnstmt .= "<div class='col-md-3'>";
           $returnstmt .= "<label for='datum'><b>Datum</b></label>";
           $returnstmt .= "<input id='datum' class='form-control' type='date' value='{$recset['gespr_datum']}'>";
           $returnstmt .= "</div>";
           $returnstmt .= "<div class='col-md-2'>";
           $returnstmt.="<label for='doorwie'><b>Door</b></label>";
           $intakersarray= array(0 => 'JIO', 1 => 'OSD', 2 => 'RUH');
           $returnstmt.="<SELECT id='doorwie' class='form-control' required>";
           $returnstmt.="<option value=''>kies...</option>";
           $intaketeller = 0;
           while($intaketeller < count($intakersarray)){
               $selected = "";
               if($intakersarray[$intaketeller] == $recset['gespr_doorwie'])
                   $selected = "SELECTED";
               $returnstmt.="<option value='$intakersarray[$intaketeller]' $selected>$intakersarray[$intaketeller]</option>";
               $intaketeller++;
           }
           $returnstmt.="</SELECT>";
//           $returnstmt .= "</div>";
//           $returnstmt .= "</div>";
//           $returnstmt .= "</form>";
//
//
//           $returnstmt="<form id='gespreksform' onsubmit=\"updateGesprek(".$recset['gespr_id'].");return false;\">";
//           $returnstmt.="<div class='row' style='background: coral;'>";
//           $returnstmt.="<div class='col-md-2'>";
//           $returnstmt.="<label for='stid'><b>Studentnr</b></label>";
//           $returnstmt.="<input id='stid' class='form-control' type='text' value='".$recset['gespr_stid']."'>";
//           $returnstmt.="</div>";
//
//           $returnstmt.="<div class='col-md-4'>";
//           $returnstmt.="<label for='emailadres1'><b>E-mailadres 1</b></label>";
//           $returnstmt.="<input id='emailadres1' class='form-control' type='email' value='".$recset['gespr_emailadres1']."'>";
//           $returnstmt.="</div>";
//           $returnstmt.="<div class='col-md-3'>";
//           $returnstmt.="<label for='emailadres2'><b>E-mailadres 2</b></label>";
//           $returnstmt.="<input id='emailadres2' class='form-control' type='email' value='".$recset['gespr_emailadres2']."'>";
//           $returnstmt.="</div>";
//           $returnstmt.="<div class='col-md-3'>";
//           $returnstmt.="<label for='tel1'><b>Telefoonnr. 1</b></label>";
//           $returnstmt.="<input id='tel1' class='form-control' type='text' value='".$recset['gespr_tel1']."'>";
//           $returnstmt.="</div>";
//           $returnstmt.="</div>";
//           $returnstmt.="<div class='row' style='background: coral; padding-bottom: 20px'>";
//           $returnstmt.="<div class='col-md-1'>";
//           $returnstmt.="<label for='leeftijd'><b>Leeftijd</b></label>";
//           $returnstmt.="<input id='leeftijd' class='form-control' type='text' value='".$recset['gespr_leeftijd']."'>";
//           $returnstmt.="</div>";
//           $returnstmt.="<div class='col-md-3'>";
//           $returnstmt.="<label for='opl'><b>Opleiding</b></label>";
//           $selectedOpl0="";
//           $selectedOpl1="";
//           if($recset['gespr_opl']==0)
//               $selectedOpl0="SELECTED";
//           elseif($recset['gespr_opl']==1)
//               $selectedOpl1="SELECTED";
//           $returnstmt.="<SELECT id='opl' class='form-control' required>";
//           $returnstmt.="<option value=''>kies...</option>";
//           $returnstmt.="<option value='0' ".$selectedOpl0.">Expert IT systems and devices</option>";
//           $returnstmt.="<option value='1' ".$selectedOpl1.">Software Developer</option>";
//           $returnstmt.="</SELECT>";
//           $returnstmt.="</div>";
//           $returnstmt.="<div class='col-md-2'>";
//           $returnstmt.="<label for='oplvariant'><b>Variant</b></label>";
//           $selectedVariant0="";
//           $selectedVariant1="";
//           if($recset['gespr_oplvariant']==0)
//               $selectedVariant0="SELECTED";
//           elseif($recset['gespr_oplvariant']==1)
//               $selectedVariant1="SELECTED";
//           $returnstmt.="<SELECT id='oplvariant' class='form-control' required>";
//           $returnstmt.="<option value=''>kies...</option>";
//           $returnstmt.="<option value='0' ".$selectedVariant0.">BOL</option>";
//           $returnstmt.="<option value='1' ".$selectedVariant1.">BBL</option>";
//           $returnstmt.="</SELECT>";
//           $returnstmt.="</div>";
//           $returnstmt.="<div class='col-md-1'>";
//           $cohortarray = array('20' => '20/21', '21' => '21/22', 22 => '22/23', 23 => '23/24');
//           $returnstmt.="<label for='oplcohort'><b>Cohort</b></label>";
//           $returnstmt.="<SELECT id='oplcohort' class='form-control' required>";
//           $returnstmt.="<option value=''>kies...</option>";
//           foreach ($cohortarray as $key => $value) {
//               $selected = "";
//               if($recset['gespr_cohort'] == $value)
//                   $selected = "SELECTED";
//               $returnstmt.="<option value='$value' $selected>$value</option>";
//           }
//           $returnstmt.="</SELECT>";
//           $returnstmt.="</div>";
//           $returnstmt.="<div class='col'>";
//           $returnstmt.="<label for='datum'><b>Datum</b></label>";
//           $returnstmt.="<input id='datum' class='form-control' type='date' value='".$recset['gespr_datum']."'>";
//           $returnstmt.="</div>";
//           $returnstmt.="<div class='col'>";
//           $returnstmt.="<label for='doorwie'><b>Door</b></label>";
//           $intakersarray= array(0 => 'JIO', 1 => 'OSD', 2 => 'RUH');
//           $returnstmt.="<SELECT id='doorwie' class='form-control' required>";
//           $returnstmt.="<option value=''>kies...</option>";
//           $intaketeller = 0;
//           while($intaketeller < count($intakersarray)){
//               $selected = "";
//               if($intakersarray[$intaketeller] == $recset['gespr_doorwie'])
//                   $selected = "SELECTED";
//               $returnstmt.="<option value='$intakersarray[$intaketeller]' $selected>$intakersarray[$intaketeller]</option>";
//               $intaketeller++;
//           }
//           $returnstmt.="</SELECT>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<hr>";
           $returnstmt.="<div class='row'>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='vorigeopl'><b>Vorige opleiding (incl. richting, vakken)</b></label>";
           $returnstmt.="<textarea id='vorigeopl' class='form-control'>".$recset['gespr_vorigeopl']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='andereintake'><b>Andere intakegesprekken lopen</b></label>";
           $returnstmt.="<textarea id='andereintake' class='form-control'>".$recset['gespr_andereintake']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='row'>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='thuissituatie'><b>Thuissituatie</b></label>";
           $returnstmt.="<textarea id='thuissituatie' class='form-control'>".$recset['gespr_thuissituatie']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='vrijetijd'><b>Vrije tijd (Hobbies, bijbaan)</b></label>";
           $returnstmt.="<textarea id='vrijetijd' class='form-control'>".$recset['gespr_vrijetijd']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='row'>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='waarom'><b>Verwachtingen (Waarom deze opleiding, waar in vrije tijd al mee bezig)</b></label>";
           $returnstmt.="<textarea id='waarom' class='form-control'>".$recset['gespr_waarom']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='doel'><b>Doel (HBO, eigen bedrijf, bij een bedrijf)</b></label>";
           $returnstmt.="<textarea id='doel' class='form-control'>".$recset['gespr_doel']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='row'>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='nodig'><b>Bijzonderheden qua extra aandacht (denk aan ADHD, dyslexie e.d.)</b></label>";
           $returnstmt.="<textarea id='nodig' class='form-control'>".$recset['gespr_nodig']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='opmerking'><b>Opmerking in het algemeen</b></label>";
           $returnstmt.="<textarea id='opmerking' class='form-control'>".$recset['gespr_opmerking']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='row'>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='voorkennis'><b>Voorkennis</b></label>";
           if(is_null($recset['gespr_voorkennis']))
               $voorkennisveld = "1. server 
2. variabele 
3. HTML/CSS 
4. PHP 
5. JavaScript 
6. Git(Hub) 
7. JAVA 
8. API 
9. C# ";
           else
               $voorkennisveld = $recset['gespr_voorkennis'];
           $returnstmt.="<textarea id='voorkennis' class='form-control' rows='9'>$voorkennisveld</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='generiek'><b>Generieke vakken</b></label>";
           if(is_null($recset['gespr_generiek']))
               $generiekveld = "1. Nederlands 
2. Engels 
3. rekenen 
4. burgerschap 
5. Fit4Life 
6. wiskunde ";
           else
               $generiekveld = $recset['gespr_generiek'];
           $returnstmt.="<textarea id='generiek' class='form-control' rows='9'>$generiekveld</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='vaardigheden'><b>Vaardigheden</b></label>";
           if(is_null($recset['gespr_vaardigheden']))
               $vaardighedenveld = "1. Onderzoeken 
2. Doorzetten 
3. Nieuwsgierig zijn 
4. Geordend zijn 
5. Gedisciplineerd zijn 
6. Zelfstandig zijn 
7. Samenwerken 
8. Sociaal vaardig zijn 
9. Raadplegen van bronnen ";
           else
               $vaardighedenveld = $recset['gespr_vaardigheden'];
           $returnstmt.="<textarea id='vaardigheden' class='form-control' rows='9'>$vaardighedenveld</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<hr>";
           $returnstmt.="<div class='row' style='background: aqua; padding-top: 10px'>";
           $returnstmt.="<div class='col'><b>Vooropleiding</b>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='row' style='background: aqua;'>";
           $returnstmt.="<div class='col'>";
           $vooroplopties = array(0=>'MBO N2', 1=>'MBO N3', 2=>'MBO N4', 3=>'VMBO-K', 4=>'VMBO-(G)T', 5=>'HAVO 3', 6=>'HAVO 4', 7=>'HAVO 5', 8=>'anders');
           $k=0;
           while($k<count($vooroplopties)){
               $checkedText="";
               if($recset['gespr_vooropl_niv']===$vooroplopties[$k])
                   $checkedText="checked";
               $returnstmt.="<div class='form-check form-check-inline'>";
               $returnstmt.="<input class='form-check-input vooropl' type='radio' name='vooropleiding' id='vooropleiding$k' value='$vooroplopties[$k]' $checkedText>";
               $returnstmt.="<label class='form-check-label' for='vooropleiding$k'>$vooroplopties[$k]</label>";
               $returnstmt.="</div>";
               $k++;
           }
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='row' style='background: aqua; padding-bottom: 20px'>";

           $returnstmt.="<div class='col'>";
           $returnstmt.="<b>Voorkennis</b><br>";
           $m=0;
           while($m < 5){
               $checkedText="";
               if($recset['gespr_voorkennis_niv']===$m)
                   $checkedText="checked";
               $returnstmt.="<div class='form-check form-check-inline'>";
               $returnstmt.="<input class='form-check-input voork' type='radio' name='voorkennis' id='voorkennis$m' value='$m' $checkedText>";
               $returnstmt.="<label class='form-check-label' for='voorkennis$m'>$m</label>";
               $returnstmt.="</div>";
               $m++;
           }
           $returnstmt.="</div>";

           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='zorgstatus'><b>Zorgstatus</b></label>";
           $returnstmt.="<SELECT id='zorgstatus' class='form-control'>";
           $returnstmt.="<option value=''>Kies ......</option>";
           $zorgstatusopties = array('A'=>'A Diplomaperspectief', 'B'=>'B Diplomaperspectief mits begeleiding', 'C'=>'C Geen diplomaperspectief tenzij', 'C1'=>'C1 Intensieve ondersteuning', 'C2'=>'C2 Via bijzondere toelating', 'D'=>'D Geen diplomaperspectief');
           foreach ($zorgstatusopties as $array_key => $array_value) {
               $selectedText="";
               if($recset['gespr_zorgstatus']==$array_key)
                   $selectedText="SELECTED";
               $returnstmt.="<option value='$array_key' $selectedText>$array_value</option>";
           }
           $returnstmt.="</SELECT>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='uitkomst'><b>Uitkomst</b></label>";
           $returnstmt.="<SELECT id='uitkomst' class='form-control'>";
           $returnstmt.="<option value=''>Kies.....</option>";
           $uitkomstopties = array(0=>'Geen', 1=>'Geplaatst', 2=>'Afmelden', 3=>'Afgewezen', 4=>'Nieuw gesprek inplannen', 5=>'Andere opleiding binnen Alfa', 6=>'Student heeft zich afgemeld');
           foreach ($uitkomstopties as $array_key => $array_value) {
               $selectedText="";
               if($recset['gespr_uitkomst']===$array_key)
                   $selectedText="SELECTED";
               $returnstmt.="<option value='$array_key' $selectedText>$array_value</option>";
           }
           $returnstmt.="</SELECT>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="</form>";
          // $returndata = array(0=>volledigeNaam(0, $recset['gespr_achternaam'], $recset['gespr_voorvoegsel'], $recset['gespr_roepnaam']), 1=>$returnstmt);
           return array(0=>volledigeNaam(0, $recset['gespr_achternaam'], $recset['gespr_voorvoegsel'], $recset['gespr_roepnaam']), 1=>$returnstmt);
       } catch (PDOException $e){
           return $e -> getMessage();
       }
   }

    public function insertGesprek(){
        try{
            $dbconnect = new dbconnection();
            $sql="INSERT INTO gesprekken (gespr_stid, gespr_achternaam, gespr_roepnaam, gespr_voorvoegsel, gespr_geslacht, gespr_leeftijd, gespr_datum, gespr_tel1, gespr_emailadres1, gespr_emailadres2, gespr_opl, gespr_oplvariant, gespr_cohort, gespr_doorwie) VALUES (:studnr, :achternaam, :roepnaam, :voorv, :gesl, :leeftijd, :datum, :tel1, :email1, :email2, :opl, :var, :coh, :wie)";
            $query = $dbconnect -> prepare($sql);
            $query -> bindParam(':studnr', $_POST['studnr']);
            $query -> bindParam(':achternaam', $_POST['achternaam']);
            $query -> bindParam(':roepnaam', $_POST['roepnaam']);
            $query -> bindParam(':voorv', $_POST['voorv']);
            $query -> bindParam(':gesl', $_POST['geslacht']);
            $query -> bindParam(':leeftijd', $_POST['leeftijd']);
            $query -> bindParam(':datum', $_POST['datum']);
            $query -> bindParam(':tel1', $_POST['tel1']);
            $query -> bindParam(':email1', $_POST['email1']);
            $query -> bindParam(':email2', $_POST['email2']);
            $query -> bindParam(':opl', $_POST['opl']);
            $query -> bindParam(':var', $_POST['var']);
            $query -> bindParam(':coh', $_POST['coh']);
            $query -> bindParam(':wie', $_POST['wie']);
            $query -> execute();
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
    }

    public function updateGesprek(){
        try{
            $dbconnect = new dbconnection();
            $sql="UPDATE gesprekken SET 
            gespr_stid=:stid, 
            gespr_datum=:datum,
            gespr_doorwie=:doorwie,
            gespr_leeftijd=:leeftijd,   
            gespr_emailadres1=:emailadres1,
            gespr_emailadres2=:emailadres2,
            gespr_tel1=:tel1,
            gespr_opl=:opl,
            gespr_oplvariant=:oplvariant,
            gespr_cohort=:oplcohort,
            gespr_vorigeopl=:vorigeopl,
            gespr_andereintake=:andereintake,
            gespr_thuissituatie=:thuissituatie,
            gespr_vrijetijd=:vrijetijd, 
            gespr_waarom=:waarom, 
            gespr_doel=:doel, 
            gespr_nodig=:nodig,
            gespr_voorkennis=:voorkennis,
            gespr_generiek=:generiek,
            gespr_vaardigheden=:vaardigheden,
            gespr_opmerking=:opmerking,
            gespr_vooropl_niv=:vooropl,
            gespr_voorkennis_niv=:voork,
            gespr_zorgstatus=:zorgstatus, 
            gespr_uitkomst=:uitkomst 
            WHERE gespr_id=:id";
            $query = $dbconnect -> prepare($sql);
            $query -> bindParam(':stid', $_POST['stid']);
            $query -> bindParam(':datum', $_POST['datum']);
            $query -> bindParam(':doorwie', $_POST['doorwie']);
            $query -> bindParam(':leeftijd', $_POST['leeftijd']);
            $query -> bindParam(':emailadres1', $_POST['emailadres1']);
            $query -> bindParam(':emailadres2', $_POST['emailadres2']);
            $query -> bindParam(':tel1', $_POST['tel1']);
            $query -> bindParam(':opl', $_POST['opl']);
            $query -> bindParam(':oplvariant', $_POST['oplvariant']);
            $query -> bindParam(':oplcohort', $_POST['oplcohort']);
            $query -> bindParam(':vorigeopl', $_POST['vorigeopl']);
            $query -> bindParam(':andereintake', $_POST['andereintake']);
            $query -> bindParam(':thuissituatie', $_POST['thuissituatie']);
            $query -> bindParam(':vrijetijd', $_POST['vrijetijd']);
            $query -> bindParam(':waarom', $_POST['waarom']);
            $query -> bindParam(':doel', $_POST['doel']);
            $query -> bindParam(':nodig', $_POST['nodig']);
            $query -> bindParam(':voorkennis', $_POST['voorkennis']);
            $query -> bindParam(':generiek', $_POST['generiek']);
            $query -> bindParam(':vaardigheden', $_POST['vaardigheden']);
            $query -> bindParam(':opmerking', $_POST['opmerking']);
            $query -> bindParam(':vooropl', $_POST['vooropl']);
            $query -> bindParam(':voork', $_POST['voork']);
            $query -> bindParam(':zorgstatus', $_POST['zorgstatus']);
            $uitkomst = $_POST['uitkomst'];
            if($_POST['uitkomst'] == '')
                unset($uitkomst);
            $query -> bindParam(':uitkomst', $uitkomst);
            $query -> bindParam(':id', $_POST['gesprid']);
            $query -> execute();
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
    }

    public function updateAfgehandeld(){
        try{
            $dbconnect = new dbconnection();
            $sql="UPDATE gesprekken SET gespr_afgehandeld=:afgeh WHERE gespr_id=:id";
            $query = $dbconnect -> prepare($sql);
            $query -> bindParam(':afgeh', $_POST['afgeh']);
            $query -> bindParam(':id', $_POST['gesprid']);
            $query -> execute();
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
    }

    public function updateUitgenodigd(){
        try{
            $dbconnect = new dbconnection();
            $sql="UPDATE gesprekken SET gespr_uitgenodigd=:uitgen WHERE gespr_id=:id";
            $query = $dbconnect -> prepare($sql);
            $query -> bindParam(':uitgen', $_POST['uitgen']);
            $query -> bindParam(':id', $_POST['gesprid']);
            $query -> execute();
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
    }

    public function deleteGesprek(){
        try{
            $dbconnect = new dbconnection();
            $sql="DELETE FROM gesprekken WHERE gespr_id=:id";
            $query = $dbconnect -> prepare($sql);
            $query -> bindParam(':id', $_POST['gesprid']);
            $query -> execute();
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
    }

    public function selectStatusDraaitabel($oplcode, $cohort, $variant){
        try{
            $dbconnect = new dbconnection();
            $sql="SELECT gespr_stid, gespr_aanmstatus, COUNT(gespr_aanmstatus) AS aantal FROM gesprekken WHERE gespr_opl=:oplcode AND gespr_cohort=:coh AND gespr_oplvariant=:variant AND gespr_uitkomst=1 GROUP BY gespr_aanmstatus";
            $query = $dbconnect -> prepare($sql);
            $query -> bindParam(':oplcode',$oplcode);
            $query -> bindParam(':coh',$cohort);
            $query -> bindParam(':variant',$variant);
            $query -> execute();
            $totaal = 0;
            $alleemailadressen = "";
            $statusarray = array(0=>"intake", 1=>"afgedrukt", 2=>"definitief",3=>"afgemeld");
            $returnstmt = "<table class='table table-sm table-hover'><tr><th>status</th><th>aantal</th><th>studenten</th></tr>";
            while($recset=$query->fetch(PDO::FETCH_ASSOC)){
                $emailadressen = $this->selectEmailadressen($oplcode, $cohort, $recset['gespr_aanmstatus'], $variant);
                $returnstmt.="<tr><td>{$statusarray[$recset['gespr_aanmstatus']]}</td>";
                $returnstmt.="<td class='text-center'><a href='mailto:{$emailadressen[0]}'>{$recset['aantal']}</a></td>";
                $returnstmt.="<td>{$emailadressen[1]}</td>";
                $returnstmt.="</tr>";
                if($alleemailadressen <> "")
                    $alleemailadressen .= "; ";
                $alleemailadressen .= $emailadressen[0];
                $totaal+=$recset['aantal'];
            }
            $returnstmt.="<tr><td>totaal</td><td class='text-center'><a href='mailto:$alleemailadressen'>$totaal</a></td><td></td></tr>";
            $returnstmt .= "</table>";
            return $returnstmt;
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
    }

    private function selectEmailadressen($oplcode, $cohort, $status, $variant){
        try{
            $dbconnect = new dbconnection();
            $sql="SELECT * FROM gesprekken WHERE gespr_opl=:oplcode AND gespr_cohort=:coh AND gespr_aanmstatus=:status AND gespr_oplvariant=:variant AND gespr_uitkomst=1 ORDER BY gespr_achternaam";
            $query = $dbconnect -> prepare($sql);
            $query -> bindParam(':oplcode',$oplcode);
            $query -> bindParam(':coh',$cohort);
            $query -> bindParam(':status',$status);
            $query -> bindParam(':variant',$variant);
            $query -> execute();
            $emailadresarray=array();
            $achternaamenid = "| ";
            while($recset=$query->fetch(PDO::FETCH_ASSOC)){
                if(!in_array($recset['gespr_emailadres1'], $emailadresarray))
                    array_push($emailadresarray, $recset['gespr_emailadres1']);
                $achternaamenid.=$recset['gespr_achternaam'].", {$recset['gespr_roepnaam']} {$recset['gespr_voorvoegsel']} ({$recset['gespr_stid']}) | ";
            }
            $returndata = array(0=>implode("; ", $emailadresarray), 1=>$achternaamenid);
            return $returndata;
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
    }

    public function updateAanmstatus(){
       try{
           $dbconnect = new dbconnection();
           $sql="UPDATE gesprekken SET gespr_aanmstatus=:status WHERE gespr_id=:id";
           $query = $dbconnect -> prepare($sql);
           $query -> bindParam(':status',$_POST['inp_aanmstatus']);
           $query -> bindParam(':id',$_POST['inp_aanmid']);
           $query -> execute();
       } catch (PDOException $e){
           echo $e -> getMessage();
       }
    }

    public function updateKlas(){
        try{
            $dbconnect = new dbconnection();
            $sql="UPDATE gesprekken SET gespr_klas=:klas WHERE gespr_id=:id";
            $query = $dbconnect -> prepare($sql);
            $query -> bindParam(':klas',$_POST['inp_klas']);
            $query -> bindParam(':id',$_POST['inp_aanmid']);
            $query -> execute();
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
    }

    public function selectVooroplDraaitabel($oplcode, $cohort, $variant){
        try{
            $dbconnect = new dbconnection();
            $sql="SELECT gespr_stid, gespr_vooropl_niv, COUNT(gespr_vooropl_niv) AS aantal FROM gesprekken WHERE gespr_opl=:oplcode AND gespr_cohort=:coh AND gespr_oplvariant=:variant AND gespr_aanmstatus<>3 AND gespr_uitkomst=1 GROUP BY gespr_vooropl_niv ORDER BY gespr_vooropl_niv";
            $query = $dbconnect -> prepare($sql);
            $query -> bindParam(':oplcode',$oplcode);
            $query -> bindParam(':coh',$cohort);
            $query -> bindParam(':variant',$variant);
            $query -> execute();
            $totaal = 0;
            $alleemailadressen = "";
            $returnstmt = "<table class='table table-sm table-hover'><tr><th>vooropleiding</th><th>aantal</th><th>studenten</th></tr>";
            while($recset=$query->fetch(PDO::FETCH_ASSOC)){
                $emailadressen = $this->selectEmailadressenBijVooropl($oplcode, $cohort, $recset['gespr_vooropl_niv'], $variant);
                $returnstmt.="<tr><td style='width: 15%'>{$recset['gespr_vooropl_niv']}</td>";
                $returnstmt.="<td class='text-center'><a href='mailto:{$emailadressen[0]}'>{$recset['aantal']}</a></td>";
                $returnstmt.="<td>{$emailadressen[1]}</td>";
                $returnstmt.="</tr>";
                if($alleemailadressen <> "")
                    $alleemailadressen .= "; ";
                $alleemailadressen .= $emailadressen[0];
                $totaal+=$recset['aantal'];
            }
            $returnstmt.="<tr><td>totaal</td><td class='text-center'><a href='mailto:$alleemailadressen'>$totaal</a></td><td></td></tr>";
            $returnstmt .= "</table>";
            return $returnstmt;
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
    }

    private function selectEmailadressenBijVooropl($oplcode, $cohort, $vooropl, $variant){
        try{
            $dbconnect = new dbconnection();
            $sql="SELECT * FROM gesprekken WHERE gespr_opl=:oplcode AND gespr_cohort=:coh AND gespr_vooropl_niv=:vooropl AND gespr_oplvariant=:variant AND gespr_aanmstatus<>3 ORDER BY gespr_achternaam";
            $query = $dbconnect -> prepare($sql);
            $query -> bindParam(':oplcode',$oplcode);
            $query -> bindParam(':coh',$cohort);
            $query -> bindParam(':vooropl',$vooropl);
            $query -> bindParam(':variant',$variant);
            $query -> execute();
            $emailadresarray=array();
            $achternaamenid = "| ";
            while($recset=$query->fetch(PDO::FETCH_ASSOC)){
                if(!in_array($recset['gespr_emailadres1'], $emailadresarray))
                    array_push($emailadresarray, $recset['gespr_emailadres1']);
                $achternaamenid.=$recset['gespr_achternaam'].", {$recset['gespr_roepnaam']} {$recset['gespr_voorvoegsel']} ({$recset['gespr_stid']}) | ";
            }
            $returndata = array(0=>implode("; ", $emailadresarray), 1=>$achternaamenid);
            return $returndata;
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
    }

    public function selectKlasDraaitabel($oplcode, $cohort){
        try{
            $dbconnect = new dbconnection();
            $sql="SELECT gespr_stid, gespr_klas, COUNT(gespr_klas) AS aantal FROM gesprekken WHERE gespr_opl=:oplcode AND gespr_cohort=:coh GROUP BY gespr_klas ORDER BY gespr_klas";
            $query = $dbconnect -> prepare($sql);
            $query -> bindParam(':oplcode',$oplcode);
            $query -> bindParam(':coh',$cohort);
            $query -> execute();
            $totaal = 0;
            $alleemailadressen = "";
            $returnstmt = "<table class='table table-sm table-hover'><tr><th>klas</th><th>aantal</th><th>studenten</th></tr>";
            while($recset=$query->fetch(PDO::FETCH_ASSOC)){
                $emailadressen = $this->selectEmailadressenBijKlas($oplcode, $cohort, $recset['gespr_klas']);
                $returnstmt.="<tr><td style='width: 15%'>{$recset['gespr_klas']}</td>";
                $returnstmt.="<td class='text-center'><a href='mailto:{$emailadressen[0]}'>{$recset['aantal']}</a></td>";
                $returnstmt.="<td>{$emailadressen[1]}</td>";
                $returnstmt.="</tr>";
                if($alleemailadressen <> "")
                    $alleemailadressen .= "; ";
                $alleemailadressen .= $emailadressen[0];
                $totaal+=$recset['aantal'];
            }
            $returnstmt.="<tr><td>totaal</td><td class='text-center'><a href='mailto:$alleemailadressen'>$totaal</a></td><td></td></tr>";
            $returnstmt .= "</table>";
            return $returnstmt;
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
    }

    private function selectEmailadressenBijKlas($oplcode, $cohort, $klas){
        try{
            $dbconnect = new dbconnection();
            $sql="SELECT * FROM gesprekken WHERE gespr_opl=:oplcode AND gespr_cohort=:coh AND gespr_klas=:klas ORDER BY gespr_achternaam";
            $query = $dbconnect -> prepare($sql);
            $query -> bindParam(':oplcode',$oplcode);
            $query -> bindParam(':coh',$cohort);
            $query -> bindParam(':klas',$klas);
            $query -> execute();
            $emailadresarray=array();
            $achternaamenid = "| ";
            while($recset=$query->fetch(PDO::FETCH_ASSOC)){
                if(!in_array($recset['gespr_emailadres1'], $emailadresarray))
                    array_push($emailadresarray, $recset['gespr_emailadres1']);
                $achternaamenid.=$recset['gespr_achternaam'].", {$recset['gespr_roepnaam']} {$recset['gespr_voorvoegsel']} ({$recset['gespr_stid']}) | ";
            }
            $returndata = array(0=>implode("; ", $emailadresarray), 1=>$achternaamenid);
            return $returndata;
        } catch (PDOException $e){
            echo $e -> getMessage();
        }
    }
}