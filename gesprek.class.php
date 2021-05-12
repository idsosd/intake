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
           $returnstmt.="<div class='row'>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='nummer'>Studentnr.</label>";
           $returnstmt.="<input id='nummer' class='form-control' type='text' value='".$recset['gespr_stid']."'>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='tel1'>Telefoonnr. 1</label>";
           $returnstmt.="<input id='tel1' class='form-control' type='text' value='".$recset['gespr_tel1']."'>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col'>";
           $returnstmt.="<label for='email1'>E-mailadres 1</label>";
           $returnstmt.="<input id='email1' class='form-control' type='email' value='".$recset['gespr_emailadres1']."'>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='row'>";
           $returnstmt.="<div class='col-md-5'>";
           $returnstmt.="<label for='extracontgeg'>Extra contactgegevens</label>";
           $returnstmt.="<input id='extracontgeg' class='form-control' type='text' value='".$recset['gespr_extracont']."'>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col-md-3'>";
           $returnstmt.="<label for='datum'>Datum</label>";
           $returnstmt.="<input id='datum' class='form-control' type='date' value='".$recset['gespr_datum']."'>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col-md-3'>";
           $returnstmt.="<label for='doorwie'>Door wie</label>";
           $selectedOSD="";
           $selectedSAE="";
           if($recset['gespr_doorwie']=='OSD')
               $selectedOSD="SELECTED";
           elseif($recset['gespr_doorwie']=='SAE')
               $selectedSAE="SELECTED";
           $returnstmt.="<SELECT id='doorwie' class='form-control' required>";
           $returnstmt.="<option value=''>kies...</option>";
           $returnstmt.="<option value='SAE' ".$selectedSAE.">Sven Franssens</option>";
           $returnstmt.="<option value='OSD' ".$selectedOSD.">Ids Osinga</option>";
           $returnstmt.="</SELECT>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='col-md-1'>";
           $returnstmt.="<label for='advies'>Advies</label>";
           $returnstmt.="<input id='advies' class='form-control text-center' type='text' value='".$recset['gespr_advies']."'>";
           $returnstmt.="</div>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='form-group'>";
           $returnstmt.="<label for='bijzonderheden'>Bijzonderheden</label>";
           $returnstmt.="<textarea id='bijzonderheden' class='form-control'>".$recset['gespr_bijzonderheden']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='form-group'>";
           $returnstmt.="<label for='vorigeopl'>Vorige opleiding</label>";
           $returnstmt.="<textarea id='vorigeopl' class='form-control'>".$recset['gespr_vorigeopl']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='form-group'>";
           $returnstmt.="<label for='waarom'>Waarom ICT</label>";
           $returnstmt.="<textarea id='waarom' class='form-control'>".$recset['gespr_waarom']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='form-group'>";
           $returnstmt.="<label for='doel'>Doel</label>";
           $returnstmt.="<textarea id='doel' class='form-control'>".$recset['gespr_doel']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='form-group'>";
           $returnstmt.="<label for='nodig'>Nodig</label>";
           $returnstmt.="<textarea id='nodig' class='form-control'>".$recset['gespr_nodig']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="<div class='form-group'>";
           $returnstmt.="<label for='nodig'>Opmerking bij advies</label>";
           $returnstmt.="<textarea id='opmerking' class='form-control'>".$recset['gespr_opmerking']."</textarea>";
           $returnstmt.="</div>";
           $returnstmt.="</form>";
           $returndata = array(0=>volledigeNaam(0, $recset['gespr_achternaam'], $recset['gespr_voorvoegsel'], $recset['gespr_roepnaam']), 1=>$returnstmt);
           return $returndata;
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
            gespr_stid=:nummer, 
            gespr_datum=:datum, 
            gespr_tel1=:tel1, 
            gespr_emailadres1=:email1,
            gespr_extracont=:extrac,
            gespr_bijzonderheden=:bijz, 
            gespr_vorigeopl=:voropl, 
            gespr_waarom=:why, 
            gespr_doel=:doel, 
            gespr_nodig=:nod, 
            gespr_advies=:adv, 
            gespr_opmerking=:opm,
            gespr_doorwie=:wie
            WHERE gespr_id=:id";
            $query = $dbconnect -> prepare($sql);
            $query -> bindParam(':nummer', $_POST['nummer']);
            $query -> bindParam(':datum', $_POST['datum']);
            $query -> bindParam(':tel1', $_POST['tel1']);
            $query -> bindParam(':email1', $_POST['email1']);
            $query -> bindParam(':extrac', $_POST['extrac']);
            $query -> bindParam(':bijz', $_POST['bijz']);
            $query -> bindParam(':voropl', $_POST['voropl']);
            $query -> bindParam(':why', $_POST['waarom']);
            $query -> bindParam(':doel', $_POST['doel']);
            $query -> bindParam(':nod', $_POST['nod']);
            $query -> bindParam(':adv', $_POST['adv']);
            $query -> bindParam(':opm', $_POST['opm']);
            $query -> bindParam(':wie', $_POST['wie']);
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
}