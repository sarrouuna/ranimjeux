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
    
    //$integration = $lignereg['integration'];
    //$Montant = $lignereg['Montant'];
    //$facture_ans = $lignereg['facture_id'];
    $id = $lignereg['id'];
	$ligners = mysql_query("select * from lignereglementclients where id ='$id'")
    or die(mysql_error("select * from lignereglementclients where id ='$id'"));
    if (@mysql_num_rows($ligners) <> 0) {
        $ligner = mysql_fetch_array($ligners);
        $integration = $ligner['integration'];
		$Montant = $ligner['Montant'];
		$facture_ans = $ligner['factureclient_id'];
    }else{
		$integration = 0;
		$Montant = 0;
		$facture_ans = 0;	
	}
	
	
    $sihelmis = mysql_query("select * from sihelmi where num_regl LIKE'$integration' and montant ='$Montant'")
    or die(mysql_error("select * from sihelmi where num_regl='$integration' and montant='$Montant'"));
	//print_r(mysql_num_rows($sihelmis));die;
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

