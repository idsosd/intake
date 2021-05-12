<?php
function volledigeNaam($type, $achternaam, $voorvoegsel, $roepnaam){
    if($type==0){
        $returnstmt = $roepnaam;
        if(!is_null($voorvoegsel) AND $voorvoegsel<>"")
            $returnstmt.=" ".$voorvoegsel;
        $returnstmt.=" ".$achternaam;
    }
    else {
        $returnstmt = $achternaam.", ".$roepnaam;
        if(!is_null($voorvoegsel) AND $voorvoegsel<>"")
            $returnstmt.=" ".$voorvoegsel;
    }
    return $returnstmt;
}