<?php

$dbhost = "localhost";
$dbuname = "root";
$dbpass = "";
$dbname = "sotem";

$link = @mysql_connect( 'localhost', 'root', '');
mysql_select_db($dbname, $link);

ini_set('max_execution_time', 3600); 

$i=0;

$ligneregs = mysql_query('SELECT lignereglementclients.* FROM lignereglementclients,factureclients,reglementclients WHERE reglementclients.id=lignereglementclients.reglementclient_id and factureclients.id=lignereglementclients.factureclient_id and reglementclients.pointdevente_id=2 and factureclients.pointdevente_id=1')
      or die(mysql_error('SELECT lignereglementclients.* FROM lignereglementclients,factureclients,reglementclients WHERE reglementclients.id=lignereglementclients.reglementclient_id and factureclients.id=lignereglementclients.factureclient_id and reglementclients.pointdevente_id=2 and factureclients.pointdevente_id=1'));
while ($lignereg = mysql_fetch_array($ligneregs)) {
    
    $integration = $lignereg['integration'];
    $Montant = $lignereg['Montant'];
    $facture_ans = $lignereg['factureclient_id'];
    $id = $lignereg['id'];
    $sihelmis = mysql_query("select * from sihelmi where num_regl LIKE'$integration' and montant LIKE '$Montant'")
    or die(mysql_error("select * from sihelmi where num_regl='$integration' and montant='$Montant'"));
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
       // mysql_query("UPDATE lignereglementclients SET lignereglementclients.factureclient_id='$facture_id' WHERE lignereglementclients.id='$id'") 
       // or die(mysql_error() . "UPDATE lignereglementclients SET lignereglementclients.factureclient_id='$facture_id' WHERE lignereglementclients.id='$id'");
    }
    }

