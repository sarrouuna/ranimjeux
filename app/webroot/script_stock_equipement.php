<?php

$dbhost = "localhost";
$dbuname = "root";
$dbpass = "";
$dbname = "sotem_d_v";
//$connexion = mysql_connect($dbhost, $dbuname, $dbpass);
//mysql_select_db($dbname, $connexion);

$connexion = @mysql_connect( 'localhost', 'root', '');
mysql_select_db($dbname, $connexion);


ini_set('max_execution_time', 3600); 



$i=0;
$articles = mysql_query("select * from articles WHERE `societe` LIKE 'q'")or die(mysql_error("select * from articles WHERE `societe` LIKE 'q'"));
while ($article = mysql_fetch_array($articles)) {
    $i++;
    $article_id = $article['id'];
    $code = $article['code'];
    $prix = $article['coutrevient'];
    $depots = mysql_query("select * from depots")or die(mysql_error("select * from depots"));
    while ($depot = mysql_fetch_array($depots)) {
    $solde=0;$qte_stock=0;    
    $depot_id = $depot['id'];
    $depot_code = $depot['code'];
    // Qte inventaire 
    $ligneinventaires = mysql_query("select sum(quantite) AS quantite from ligneinventaires,inventaires where ligneinventaires.article_id='$article_id' and inventaires.depot_id='$depot_id' and inventaires.date = '2018-12-28' and inventaires.id =ligneinventaires.inventaire_id order by ligneinventaires.id desc")
    or die(mysql_error("select sum(quantite) from ligneinventaires,inventaires where ligneinventaires.article_id='$article_id' and inventaires.depot_id='$depot_id' and inventaires.date = '2018-12-28' and inventaires.id =ligneinventaires.inventaire_id"));
    $qte_inventaire=0;
    if (@mysql_num_rows($ligneinventaires) <> 0) {
        $ligneinventaire = mysql_fetch_array($ligneinventaires);
        $qte_inventaire = $ligneinventaire['quantite'];
        $solde=sprintf("%.3f",$solde)+$qte_inventaire;
        //echo "Inventaire : ".$qte_inventaire."<br>";
    }
    // Qte bonlivraisons
    $lignelivraisons = mysql_query("select sum(quantite) AS quantite from lignelivraisons,bonlivraisons where lignelivraisons.article_id='$article_id' and lignelivraisons.depot_id='$depot_id' and bonlivraisons.date >= '2019-01-01' and bonlivraisons.id =lignelivraisons.bonlivraison_id")
    or die(mysql_error("select sum(quantite) from lignelivraisons,bonlivraisons where lignelivraisons.article_id='$article_id' and lignelivraisons.depot_id='$depot_id' and bonlivraisons.date >= '2019-01-01' and bonlivraisons.id =lignelivraisons.bonlivraison_id"));
    $qte_livraison=0;
    if (@mysql_num_rows($lignelivraisons) <> 0) {
        $lignelivraison = mysql_fetch_array($lignelivraisons);
        $qte_livraison = $lignelivraison['quantite'];
        $solde=sprintf("%.3f",$solde)-$qte_livraison;
        //echo "bonlivraisons : ".$qte_livraison."<br>";
    }
    // Qte factureclient
    $lignefactureclients = mysql_query("select sum(quantite) AS quantite from lignefactureclients,factureclients where lignefactureclients.article_id='$article_id' and lignefactureclients.depot_id='$depot_id' and factureclients.date >= '2019-01-01' and factureclients.id =lignefactureclients.factureclient_id and factureclients.source ='fac'")
    or die(mysql_error("select sum(quantite) from lignefactureclients,factureclients where lignefactureclients.article_id='$article_id' and lignefactureclients.depot_id='$depot_id' and factureclients.date >= '2019-01-01' and factureclients.id =lignefactureclients.factureclient_id and factureclients.source ='fac'"));
    $qte_factureclient=0;
    if (@mysql_num_rows($lignefactureclients) <> 0) {
        $lignefactureclient = mysql_fetch_array($lignefactureclients);
        $qte_factureclient = $lignefactureclient['quantite'];
        $solde=sprintf("%.3f",$solde)-$qte_factureclient;
        //echo "factureclients : ".$qte_factureclient."<br>";
    }
    // Qte factureavoir
    $lignefactureavoirs = mysql_query("select sum(quantite) AS quantite from lignefactureavoirs,factureavoirs where lignefactureavoirs.article_id='$article_id' and lignefactureavoirs.depot_id='$depot_id' and factureavoirs.date >= '2019-01-01' and  factureavoirs.id =lignefactureavoirs.factureavoir_id and factureavoirs.typefacture_id =1")
    or die(mysql_error("select sum(quantite) from lignefactureavoirs,factureavoirs where lignefactureavoirs.article_id='$article_id' and lignefactureavoirs.depot_id='$depot_id' and factureavoirs.date >= '2019-01-01' and factureavoirs.id =lignefactureavoirs.factureavoir_id and factureavoirs.typefacture_id =1"));
    $qte_factureavoir=0;
    if (@mysql_num_rows($lignefactureavoirs) <> 0) {
        $lignefactureavoir = mysql_fetch_array($lignefactureavoirs);
        $qte_factureavoir = $lignefactureavoir['quantite'];
        $solde=sprintf("%.3f",$solde)+$qte_factureavoir;
        //echo "factureavoirs : ".$qte_factureavoir."<br>";
    }
    // Qte bonreception
    $lignereceptions = mysql_query("select sum(quantite) AS quantite from lignereceptions,bonreceptions where lignereceptions.article_id='$article_id' and lignereceptions.depot_id='$depot_id' and bonreceptions.date >= 2019-01-01' and  bonreceptions.id =lignereceptions.bonreception_id and bonreceptions.facture_id=0")
    or die(mysql_error("select sum(quantite) from lignereceptions,bonreceptions where lignereceptions.article_id='$article_id' and lignereceptions.depot_id='$depot_id' and bonreceptions.date >= '2019-01-01' and bonreceptions.id =lignereceptions.bonreception_id and bonreceptions.facture_id=0"));
    $qte_bonreception=0;
    if (@mysql_num_rows($lignereceptions) <> 0) {
        $lignereception = mysql_fetch_array($lignereceptions);
        $qte_bonreception = $lignereception['quantite'];
        $solde=sprintf("%.3f",$solde)+$qte_bonreception;
        //echo "bonreceptions : ".$qte_bonreception."<br>";
    }
    // Qte facture
    $lignefactures = mysql_query("select sum(quantite) AS quantite from lignefactures,factures where lignefactures.article_id='$article_id' and lignefactures.depot_id='$depot_id' and factures.date >= '2019-01-01' and  factures.id =lignefactures.facture_id")
    or die(mysql_error("select sum(quantite) from lignefactures,factures where lignefactures.article_id='$article_id' and lignefactures.depot_id='$depot_id' and factures.date >= '2019-01-01' and factures.id =lignefactures.facture_id"));
    $qte_facture=0;
    if (@mysql_num_rows($lignefactures) <> 0) {
        $lignefacture = mysql_fetch_array($lignefactures);
        $qte_facture = $lignefacture['quantite'];
        $solde=sprintf("%.3f",$solde)+$qte_facture;
        //echo "factures : ".$qte_facture."<br>";
    }
    // Qte facture avoir fr
    $lignefactureavoirfrs = mysql_query("select sum(quantite) AS quantite from lignefactureavoirfrs,factureavoirfrs where lignefactureavoirfrs.article_id='$article_id' and lignefactureavoirfrs.depot_id='$depot_id' and factureavoirfrs.date >= '2019-01-01' and  factureavoirfrs.id =lignefactureavoirfrs.factureavoirfr_id and factureavoirfrs.typefacture_id =1")
    or die(mysql_error("select sum(quantite) from lignefactureavoirfrs,factureavoirfrs where lignefactureavoirfrs.article_id='$article_id' and lignefactureavoirfrs.depot_id='$depot_id' and factureavoirfrs.date >= '2019-01-01' and factureavoirfrs.id =lignefactureavoirfrs.factureavoirfr_id and factureavoirfrs.typefacture_id =1"));
    $qte_facture=0;
    if (@mysql_num_rows($lignefactureavoirfrs) <> 0) {
        $lignefactureavoirfr = mysql_fetch_array($lignefactureavoirfrs);
        $qte_factureavoirfr = $lignefactureavoirfr['quantite'];
        $solde=sprintf("%.3f",$solde)-$qte_factureavoirfr;
        //echo "factures avoir FR : ".$qte_factureavoirfr."<br>";
    }
    // Qte bonreceptionstock
    $lignebonreceptionstocks = mysql_query("select sum(quantite) AS quantite from lignebonreceptionstocks,bonreceptionstocks where lignebonreceptionstocks.article_id='$article_id' and lignebonreceptionstocks.depot_id='$depot_id' and bonreceptionstocks.date >= '2019-01-01' and  bonreceptionstocks.id =lignebonreceptionstocks.bonreceptionstock_id")
    or die(mysql_error("select sum(quantite) from lignebonreceptionstocks,bonreceptionstocks where lignebonreceptionstocks.article_id='$article_id' and lignebonreceptionstocks.depot_id='$depot_id' and bonreceptionstocks.date >= '2019-01-01' and bonreceptionstocks.id =lignebonreceptionstocks.bonreceptionstock_id"));
    $qte_bonreceptionstock=0;
    if (@mysql_num_rows($lignebonreceptionstocks) <> 0) {
        $lignebonreceptionstock = mysql_fetch_array($lignebonreceptionstocks);
        $qte_bonreceptionstock = $lignebonreceptionstock['quantite'];
        $solde=sprintf("%.3f",$solde)+$qte_bonreceptionstock;
        //echo "bonreceptionstocks : ".$qte_bonreceptionstock."<br>";
    }
    // Qte bonsortiestock
    $lignebonsortiestocks = mysql_query("select sum(quantite) AS quantite from lignebonsortiestocks,bonsortiestocks where lignebonsortiestocks.article_id='$article_id' and lignebonsortiestocks.depot_id='$depot_id' and bonsortiestocks.date >= '2019-01-01' and  bonsortiestocks.id =lignebonsortiestocks.bonsortiestock_id and  bonsortiestocks.valide='1'")
    or die(mysql_error("select sum(quantite) from lignebonsortiestocks,bonsortiestocks where lignebonsortiestocks.article_id='$article_id' and lignebonsortiestocks.depot_id='$depot_id' and bonsortiestocks.date >= '2019-01-01' and bonsortiestocks.id =lignebonsortiestocks.bonsortiestock_id and  bonsortiestocks.valide='1'"));
    $qte_bonsortiestock=0;
    if (@mysql_num_rows($lignebonsortiestocks) <> 0) {
        $lignebonsortiestock = mysql_fetch_array($lignebonsortiestocks);
        $qte_bonsortiestock = $lignebonsortiestock['quantite'];
        $solde=sprintf("%.3f",$solde)-$qte_bonsortiestock;
        //echo "bonsortiestocks : ".$qte_bonsortiestock."<br>";
    }
    // Qte transfert
    $lignetransferts = mysql_query("select sum(quantite) AS quantite from lignetransferts,transferts where lignetransferts.article_id='$article_id' and lignetransferts.depot_id='$depot_id' and transferts.date >= '2019-01-01' and  transferts.id =lignetransferts.transfert_id")
    or die(mysql_error("select sum(quantite) from lignetransferts,transferts where lignetransferts.article_id='$article_id' and lignetransferts.depot_id='$depot_id' and transferts.date >= '2019-01-01' and transferts.id =lignetransferts.transfert_id"));
    $qte_transfert=0;
    if (@mysql_num_rows($lignetransferts) <> 0) {
        $lignetransfert = mysql_fetch_array($lignetransferts);
        $qte_transfert = $lignetransfert['quantite'];
        $solde=sprintf("%.3f",$solde)-$qte_transfert;
        //echo "transfert sorti : ".$qte_transfert."<br>";
    }
    // Qte transfert
    $lignetransfert2s = mysql_query("select sum(quantite) AS quantite from lignetransferts,transferts where lignetransferts.article_id='$article_id' and transferts.depotarrive='$depot_id' and transferts.date >= '2019-01-01' and  transferts.id =lignetransferts.transfert_id")
    or die(mysql_error("select sum(quantite) from lignetransferts,transferts where lignetransferts.article_id='$article_id' and transferts.depotarrive='$depot_id' and transferts.date >= '2019-01-01' and transferts.id =lignetransferts.transfert_id"));
    $qte_transfert2=0;
    if (@mysql_num_rows($lignetransfert2s) <> 0) {
        $lignetransfert2 = mysql_fetch_array($lignetransfert2s);
        $qte_transfert2 = $lignetransfert2['quantite'];
        $solde=sprintf("%.3f",$solde)+$qte_transfert2;
        //echo "transfert entre  : ".$qte_transfert2."<br>";
    }
    
    // Qte bonecart
//    $bonecarts = mysql_query("select sum(bonecarts.quantite) AS quantite from bonecarts,inventaires where bonecarts.article_id='$article_id' and bonecarts.depot_id='$depot_id' and inventaires.date >= '2018-12-28' and  inventaires.id =bonecarts.inventaire_id and inventaires.valide !=0")
//    or die(mysql_error("select sum(bonecarts.quantite) from bonecarts,inventaires where bonecarts.article_id='$article_id' and bonecarts.depot_id='$depot_id' and inventaires.date >= '2018-12-28' and  inventaires.id =bonecarts.inventaire_id and inventaires.valide !=0"));
//    $qte_bonecart=0;
//    if (@mysql_num_rows($bonecarts) <> 0) {
//        $bonecart = mysql_fetch_array($bonecarts);
//        $qte_bonecart = $bonecart['quantite'];
//        $solde=sprintf("%.3f",$solde)+$qte_bonecart;
//        //echo "bonecarts : ".$qte_bonecart."<br>";
//    }
    
    $solde=sprintf("%.3f",$solde);
    $date=date("Y-m-d H:i:s");
    $stocks = mysql_query("select * from stockdepots where stockdepots.article_id='$article_id' and stockdepots.depot_id='$depot_id'")
    or die(mysql_error("select * from stockdepots where stockdepots.article_id='$article_id' and stockdepots.depot_id='$depot_id'"));
    if (@mysql_num_rows($stocks) <> 0) {
        $stock = mysql_fetch_array($stocks);
        $qte_stock = $stock['quantite'];
    }else{
    mysql_query("insert into stockdepots(article_id,depot_id,quantite,prix)" . "value ('$article_id','$depot_id','0','$prix')", $connexion);
    }
    
    if($qte_stock != $solde){
    echo "///article : ".$code."/// depot : ".$depot_code."///historique: ".$solde."/stock: ".$qte_stock."<br>";
    mysql_query("UPDATE stockdepots SET stockdepots.quantite='$solde' WHERE stockdepots.article_id='$article_id' and stockdepots.depot_id='$depot_id'") or die(mysql_error() . "UPDATE stockdepots SET stockdepots.quantite='$solde' WHERE stockdepots.article_id='$article_id' and stockdepots.depot_id='$depot_id'");
    //mysql_query("insert into correctiondestocks(article_id,depot_id,qtehistorique,qtestock,date)" . "value ('$article_id','$depot_id','$solde','$qte_stock','$date')", $connexion)
    //or die(mysql_error() . "insert into correctiondestocks(article_id,depot_id,qtehistorique,qtestock,date)" . "value ('$article_id','$depot_id','$solde','$qte_stock','$date')");
    }
             
}
echo "*********".$i."********<br>";

    }

