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
           $returnstmt="<form id='gespreksform' onsubmit=\"updateGesprek(".$recset['gespr_id'].");return false;\">";
           $returnstmt.="<div class='row' style='background: coral;'>";
           $returnstmt.="<div class='col-md-2'>";
           $returnstmt.="<label for='stid'>Studentnr.</label>";
           $returnstmt.="<input id='stid' class='form-control' type='text' value='".$recset['gespr_stid']."'>";
           $returnstmt.="</div>";

           $returnstmt.="<div class='col-md-4'>";
           $returnstmt.="<label for='emailadres1'>E-mailadres 1</label>";
           $returnstmt.="<input id='emailadres1' class='form-control' type='email' value='".$recset['gespr_emailadres1']."'>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col-md-3'>";
           $returnstmt.="<label for='emailadres2'>E-mailadres 2</label>";
           $returnstmt.="<input id='emailadres2' class='form-control' type='email' value='".$recset['gespr_emailadres2']."'>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col-md-3'>";
           $returnstmt.="<label for='tel1'>Telefoonnr. 1</label>";
           $returnstmt.="<input id='tel1' class='form-control' type='text' value='".$recset['gespr_tel1']."'>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='row' style='background: coral; padding-bottom: 20px'>";
           $returnstmt.="<div class='col-md-5'>";
           $returnstmt.="<label for='opl'>Opleiding</label>";
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
           $returnstmt.="</div>";
           $returnstmt.="<div class='col-md-2'>";
           $returnstmt.="<label for='oplvariant'>Variant</label>";
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
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='datum'>Datum</label>";
           $returnstmt.="<input id='datum' class='form-control' type='date' value='".$recset['gespr_datum']."'>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='doorwie'>Door wie</label>";
           $selectedOSD="";
           $selectedJIO="";
           if($recset['gespr_doorwie']=='OSD')
               $selectedOSD="SELECTED";
           elseif($recset['gespr_doorwie']=='JIO')
               $selectedJIO="SELECTED";
           $returnstmt.="<SELECT id='doorwie' class='form-control' required>";
           $returnstmt.="<option value=''>kies...</option>";
           $returnstmt.="<option value='JIO' ".$selectedJIO.">JIO</option>";
           $returnstmt.="<option value='OSD' ".$selectedOSD.">OSD</option>";
           $returnstmt.="</SELECT>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<hr>";
           $returnstmt.="<div class='row'>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='vorigeopl'>Vorige opleiding (incl. richting, vakken)</label>";
           $returnstmt.="<textarea id='vorigeopl' class='form-control'>".$recset['gespr_vorigeopl']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='andereintake'>Andere intakegesprekken lopen</label>";
           $returnstmt.="<textarea id='andereintake' class='form-control'>".$recset['gespr_andereintake']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='row'>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='thuissituatie'>Thuissituatie</label>";
           $returnstmt.="<textarea id='thuissituatie' class='form-control'>".$recset['gespr_thuissituatie']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='vrijetijd'>Vrije tijd (Hobbies, bijbaan)</label>";
           $returnstmt.="<textarea id='vrijetijd' class='form-control'>".$recset['gespr_vrijetijd']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='row'>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='waarom'>Verwachtingen (Waarom deze opleiding, waar in vrije tijd al mee bezig)</label>";
           $returnstmt.="<textarea id='waarom' class='form-control'>".$recset['gespr_waarom']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='doel'>Doel (HBO, eigen bedrijf, bij een bedrijf)</label>";
           $returnstmt.="<textarea id='doel' class='form-control'>".$recset['gespr_doel']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='row'>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='nodig'>Bijzonderheden qua extra aandacht (denk aan ADHD, dyslexie e.d.)</label>";
           $returnstmt.="<textarea id='nodig' class='form-control'>".$recset['gespr_nodig']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='opmerking'>Opmerking in het algemeen</label>";
           $returnstmt.="<textarea id='opmerking' class='form-control'>".$recset['gespr_opmerking']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='row'>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='voorkennis'>Voorkennis</label>";
           if(is_null($recset['gespr_voorkennis']))
               $voorkennisveld = "1. server 
2. variabele 
3. HTML/CSS 
4. PHP 
5. JavaScript <br>6. Git(Hub) <br>7. JAVA <br>8. API <br>9. C#";
           else
               $voorkennisveld = $recset['gespr_voorkennis'];
           $returnstmt.="<textarea id='voorkennis' class='form-control' rows='9'>$voorkennisveld</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='generiek'>Generieke vakken</label>";
           $returnstmt.="<textarea id='generiek' class='form-control' rows='9'>".$recset['gespr_generiek']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='vaardigheden'>Vaardigheden</label>";
           $returnstmt.="<textarea id='vaardigheden' class='form-control' rows='9'>".$recset['gespr_vaardigheden']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<hr>";
           $returnstmt.="<div class='row' style='background: aqua; padding-bottom: 20px'>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='zorgstatus'>Zorgstatus</label>";
           $selectedA="";
           $selectedB="";
           $selectedC="";
           $selectedC1="";
           $selectedC2="";
           $selectedD="";
           if($recset['gespr_zorgstatus']=='A')
               $selectedA="SELECTED";
           elseif($recset['gespr_zorgstatus']=='B')
               $selectedB="SELECTED";
           elseif($recset['gespr_zorgstatus']=='C')
               $selectedC="SELECTED";
           elseif($recset['gespr_zorgstatus']=='C1')
               $selectedC1="SELECTED";
           elseif($recset['gespr_zorgstatus']=='C2')
               $selectedC2="SELECTED";
           elseif($recset['gespr_zorgstatus']=='D')
               $selectedD="SELECTED";
           $returnstmt.="<SELECT id='zorgstatus' class='form-control'>";
           $returnstmt.="<option value=''>Kies ......</option>";
           $returnstmt.="<option value='A' $selectedA>A Diplomaperspectief</option>";
           $returnstmt.="<option value='B' $selectedB>B Diplomaperspectief mits begeleiding</option>";
           $returnstmt.="<option value='C' $selectedC>C Geen diplomaperspectief tenzij</option>";
           $returnstmt.="<option value='C1' $selectedC1>C1 Intensieve ondersteuning</option>";
           $returnstmt.="<option value='C2' $selectedC2>C2 Via bijzondere toelating</option>";
           $returnstmt.="<option value='D' $selectedD>D Geen diplomaperspectief</option>";
           $returnstmt.="</SELECT>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='uitkomst'>Uitkomst</label>";
           $selected00="";
           $selected01="";
           $selected02="";
           $selected03="";
           $selected04="";
           $selected05="";
           $selected06="";
           if($recset['gespr_uitkomst']===0)
               $selected00="SELECTED";
           elseif($recset['gespr_uitkomst']===1)
               $selected01="SELECTED";
           elseif($recset['gespr_uitkomst']===2)
               $selected02="SELECTED";
           elseif($recset['gespr_uitkomst']===3)
               $selected03="SELECTED";
           elseif($recset['gespr_uitkomst']===4)
               $selected04="SELECTED";
           elseif($recset['gespr_uitkomst']===5)
               $selected05="SELECTED";
           elseif($recset['gespr_uitkomst']===6)
               $selected06="SELECTED";
           $returnstmt.="<SELECT id='uitkomst' class='form-control'>";
           $returnstmt.="<option value=''>Kies.....</option>";
           $returnstmt.="<option value='0' $selected00>Geen</option>";
           $returnstmt.="<option value='1' $selected01>Geplaatst</option>";
           $returnstmt.="<option value='2' $selected02>Afmelden</option>";
           $returnstmt.="<option value='3' $selected03>Afgewezen</option>";
           $returnstmt.="<option value='4' $selected04>Nieuw gesprek inplannen</option>";
           $returnstmt.="<option value='5' $selected05>Andere opleiding binnen Alfa</option>";
           $returnstmt.="<option value='6' $selected06>Student heeft zich afgemeld</option>";
           $returnstmt.="</SELECT>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="</form>";
          // $returndata = array(0=>volledigeNaam(0, $recset['gespr_achternaam'], $recset['gespr_voorvoegsel'], $recset['gespr_roepnaam']), 1=>$returnstmt);
           return array(0=>volledigeNaam(0, $recset['gespr_achternaam'], $recset['gespr_voorvoegsel'], $recset['gespr_roepnaam']), 1=>$returnstmt);
       } catch (PDOException $e){
           echo $e -> getMessage();
       }
   }

    public function insertGesprek(){
        try{
            $dbconnect = new dbconnection();
            $sql="INSERT INTO gesprekken (gespr_achternaam, gespr_roepnaam, gespr_voorvoegsel, gespr_datum, gespr_tel1, gespr_emailadres1, gespr_emailadres2, gespr_opl, gespr_oplvariant, gespr_doorwie) VALUES (:achternaam, :roepnaam, :voorv, :datum, :tel1, :email1, :email2, :opl, :var, :wie)";
            $query = $dbconnect -> prepare($sql);
            $query -> bindParam(':achternaam', $_POST['achternaam']);
            $query -> bindParam(':roepnaam', $_POST['roepnaam']);
            $query -> bindParam(':voorv', $_POST['voorv']);
            $query -> bindParam(':datum', $_POST['datum']);
            $query -> bindParam(':tel1', $_POST['tel1']);
            $query -> bindParam(':email1', $_POST['email1']);
            $query -> bindParam(':email2', $_POST['email2']);
            $query -> bindParam(':opl', $_POST['opl']);
            $query -> bindParam(':var', $_POST['var']);
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
            gespr_emailadres1=:emailadres1,
            gespr_emailadres2=:emailadres2,
            gespr_tel1=:tel1,
            gespr_opl=:opl,
            gespr_oplvariant=:oplvariant,      
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
            gespr_zorgstatus=:zorgstatus, 
            gespr_uitkomst=:uitkomst 
            WHERE gespr_id=:id";
            $query = $dbconnect -> prepare($sql);
            $query -> bindParam(':stid', $_POST['stid']);
            $query -> bindParam(':datum', $_POST['datum']);
            $query -> bindParam(':doorwie', $_POST['doorwie']);
            $query -> bindParam(':emailadres1', $_POST['emailadres1']);
            $query -> bindParam(':emailadres2', $_POST['emailadres2']);
            $query -> bindParam(':tel1', $_POST['tel1']);
            $query -> bindParam(':opl', $_POST['opl']);
            $query -> bindParam(':oplvariant', $_POST['oplvariant']);
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
            $query -> bindParam(':zorgstatus', $_POST['zorgstatus']);
            $query -> bindParam(':uitkomst', $_POST['uitkomst']);
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
}