<?php

$dbhost = "localhost";
$dbuname = "root";
$dbpass = "";
$dbname = "sotem";

$link = @mysql_connect( 'localhost', 'root', '');
mysql_select_db($dbname, $link);

ini_set('max_execution_time', 3600); 

$i=0;

$ligneregs = mysql_query('SELECT lignereglements.* FROM lignereglements,factures,reglements WHERE reglements.id=lignereglements.reglement_id and factures.id=lignereglements.facture_id and reglements.pointdevente_id=2 and factures.pointdevente_id=1')
      or die(mysql_error('SELECT lignereglements.* FROM lignereglements,factures,reglements WHERE reglements.id=lignereglements.reglement_id and factures.id=lignereglements.facture_id and reglements.pointdevente_id=2 and factures.pointdevente_id=1'));
while ($lignereg = mysql_fetch_array($ligneregs)) {
    
    $integration = $lignereg['integration'];
    $Montant = $lignereg['Montant'];
    $facture_ans = $lignereg['facture_id'];
    $id = $lignereg['id'];
    $sihelmis = mysql_query("select * from sihelmi_achat where num_regl LIKE'$integration' and montant LIKE '$Montant'")
    or die(mysql_error("select * from sihelmi_achat where num_regl='$integration' and montant='$Montant'"));
    if (@mysql_num_rows($sihelmis) <> 0) {
        $sihelmi = mysql_fetch_array($sihelmis);
        $facture_id = $sihelmi['facture_id'];
    }else{
        $facture_id =0;
    }
    //echo "n: ".$i." **** integration: ".$integration." *** facture: ".$facture_id." *** montant: ".$Montant."<br>";
    if($facture_ans!=$facture_id){
        $i++;
        echo "n: ".$i." deff: ".$integration ." montant ".$Montant." entre ".$facture_ans." et ".$facture_id."<br>";
       // mysql_query("UPDATE lignereglements SET lignereglements.facture_id='$facture_id' WHERE lignereglements.id='$id'") 
       // or die(mysql_error() . "UPDATE lignereglements SET lignereglements.facture_id='$facture_id' WHERE lignereglements.id='$id'");
    }
    }

