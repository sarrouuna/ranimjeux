<?php
if ($pointdeventeachat != 0) {
    $pontdevente = ClassRegistry::init('Pointdevente')->find('first',array('conditions'=>array('Pointdevente.id'=>$pointdeventeachat)));
    $soc = ClassRegistry::init('Societe')->find('first',array('conditions'=>array('Societe.id'=>$pontdevente['Pointdevente']['societe_id'])));
    }else{
        $soc = ClassRegistry::init('Societe')->find('first');
    }
    $m="";
    if ($date1 != "__/__/____" && $date1 != "1970-01-01" && $date2 != "__/__/____" && $date2 != "1970-01-01") {
        $date1 = date('d/m/Y', strtotime(str_replace('-', '/', @$date1)));
        $date2 = date('d/m/Y', strtotime(str_replace('-', '/',@$date2)));
        $m = ' du  ' . $date1 . ' au  ' . $date2;
    }
    if ($datedec1 != "__/__/____" && $datedec1 != "1970-01-01" && $datedec2 != "__/__/____" && $datedec2 != "1970-01-01") {
        $datedec1 = date('d/m/Y', strtotime(str_replace('-', '/', @$datedec1)));
        $datedec2 = date('d/m/Y', strtotime(str_replace('-', '/',@$datedec2)));
        $m = ' du  ' . $datedec1 . ' au  ' . $datedec2;
    }
$w = 0;
if (count($tvas) != 0) {
    $w = 35 / (count($tvas) * 2);
}

$tf = array();
foreach ($tvas as $t) {
    $tf[intval(floatval($t['Tva']['name']))]['montant'] = 0;
    $tf[intval(floatval($t['Tva']['name']))]['base'] = 0;
    $tf[intval(floatval($t['Tva']['name']))]['nom'] = intval(floatval($t['Tva']['name']));
}
ob_start();
?>
<table style=" width: 100%;  ">
    <tr>
        <td style=" width: 30%;" align="left" >
        <strong ><h1><?php echo $soc['Societe']['nom']; ?></h1></strong> 
        </td>
        <td  style=" width: 70%;">
            <table style=" width: 100%;font-size: 1.5mm;">
                <tr>
                <br> 
                <td height="35px" align="right" ><h3>Liste des factures depense <?php echo $m; ?></h3></td> 
    </tr> 
</table>
</td>
</tr>
<br>
<tr>
    <td align="left" width="55%"  ><?php echo $soc['Societe']['adresse']; ?></td>
    <td align="left" width="45%" ><strong>Tél : </strong><?php echo $soc['Societe']['tel']; ?></td>
</tr>
<tr>
    <td align="left" width="55%"  ><strong>TVA :</strong><?php echo $soc['Societe']['codetva']; ?></td>
    <td align="left" width="45%" ><strong>Fax :</strong><?php echo $soc['Societe']['fax']; ?></td>
</tr>
<tr>
    <td align="left" width="55%"  ><strong>R.C :</strong><?php echo $soc['Societe']['rc']; ?></td>
    <td align="left" width="45%" ><strong>Site web : </strong><?php echo $soc['Societe']['site']; ?></td>
</tr>

</table>
<br><br><br>

<table align="center" cellpadding="0" cellspacing="0"  style=" width: 100%; font-size: 3mm;" border="1">        
    <tr align="center">
        <td bgcolor="#CCCCCC" style=" width: 8%;" align="center"  ><strong>N° FACT</strong></td> 
        <td bgcolor="#CCCCCC" style=" width: 5%;" align="center"  ><strong>Date</strong></td>
        <td bgcolor="#CCCCCC" style=" width: 5%;" align="center"  ><strong>Code Frs</strong></td>                      
        <td bgcolor="#CCCCCC" style=" width: 27%;" align="center"  ><strong>Nom_Prenom</strong></td>
        <!-- <td bgcolor="#CCCCCC" style=" width: 11%;" align="center"  ><strong>Piece Frs</strong></td> -->
        <td bgcolor="#CCCCCC" style=" width: 5%;" align="center"  ><strong>Base 0%</strong></td>
        <?php foreach ($tvas as $t) { //debug($t);die; ?>
            <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Base <?php echo intval(floatval($t['Tva']['name'])); ?>%</strong></td> 
            <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="center"  ><strong>TVA <?php echo intval(floatval($t['Tva']['name'])); ?>%</strong></td>
        <?php } ?>
        <td bgcolor="#CCCCCC" style=" width: 5%;" align="center"  ><strong>Timbre</strong></td>   
        <td bgcolor="#CCCCCC" style=" width: 8%;" align="center"  ><strong>Net a payer</strong></td>
    </tr>

    <?php
    $i = 0;
    $total = 0;
    $totht = 0;
    $totnetapayer = 0;
    $tottimbre = 0;
    $totbase6 = 0;
    $totbase12 = 0;
    $totbase18 = 0;
    $tottva6 = 0;
    $tottva12 = 0;
    $tottva18 = 0;
    $objfactavoir = ClassRegistry::init('Lignefacture');
    $ccp = 0;
    $listvaall = array();
    $totfactzero = 0;
    $nbpage = 0;
    //debug($tablignefactures);die;
    if ($tablignefactures != array()) {
        foreach ($tablignefactures as $br) {
            $total = $total + $br['totalttc'];

            $base6 = '';
            $base12 = '';
            $base18 = '';
            $tva6 = '';
            $tva12 = '';
            $tva18 = '';

            $lignefact = array();
            $lignefactavoir = array();
            $listva = array();
            $p = 0;
            $f = '';
            foreach ($tvas as $t) { //debug($t);die;
                $tv = $t['Tva']['name'];

                $lignefactavoirzero = $objfactavoir->find('all', array('fields' => array('SUM(Lignefacture.totalht) as mtva', 'Lignefacture.tva'), 'conditions' => (array('Lignefacture.facture_id' => $br['id_piece'], 'Lignefacture.tva' => 0)), 'recursive' => -1));


                if ($lignefactavoirzero[0][0]['mtva'] != NULL) {
                    $f = $lignefactavoirzero[0][0]['mtva'];
                }
                $lignefactavoir = $objfactavoir->find('all', array('fields' => array('SUM(Lignefacture.totalht) as mtva'), 'conditions' => (array('Lignefacture.tva' => $tv, 'Lignefacture.facture_id' => $br['id_piece'])), 'recursive' => -1));
//debug($br['id_piece']);die;
                if ($lignefactavoir[0][0]['mtva'] != NULL) {

                    $tvmnt = floatval($lignefactavoir[0][0]['mtva']) * floatval($tv) / 100;
                    //debug($fact);die;
                    $listva[$p]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                    $listva[$p]['mtva'] = sprintf("%.3f", $tvmnt);
                    $listva[$p]['base'] = sprintf("%.3f", $lignefactavoir[0][0]['mtva']);
                    $listva[$p]['tva'] = intval(floatval($t['Tva']['name']));
                    $p++;

                    $listvaall[$ccp]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                    $listvaall[$ccp]['mtva'] = sprintf("%.3f", $tvmnt);
                    $listvaall[$ccp]['base'] = sprintf("%.3f", $lignefactavoir[0][0]['mtva']);
                    $listvaall[$ccp]['tva'] = intval(floatval($t['Tva']['name']));
                    $ccp++;
                } else {
                    $listva[$p]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                    $listva[$p]['mtva'] = 0;
                    $listva[$p]['base'] = 0;
                    $listva[$p]['tva'] = intval(floatval($t['Tva']['name']));
                    $p++;
                    $listvaall[$ccp]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                    $listvaall[$ccp]['mtva'] = 0;
                    $listvaall[$ccp]['base'] = 0;
                    $listvaall[$ccp]['tva'] = intval(floatval($t['Tva']['name']));
                    $ccp++;
                }
            }

//    debug($listva);
//    die;
            //debug($br);die;
            $totnetapayer = $totnetapayer + $br['totalttc'];
            $tottimbre = $tottimbre + $br['timbre'];
            ?>
            <tr bgcolor="#FFFFFF" align="center">    
                <td  align="left" heigth="30px"  ><?php echo $br['numero']; ?></td>
                <td  align="center"  ><?php echo date("d/m/y", strtotime(str_replace('-', '/', $br['date']))); ?></td>
                <td  align="center"  ><?php echo $br['code']; ?></td>                        
                <td  align="left"   ><?php echo substr($br['Fournisseur'],0,30); ?></td>
                <!-- <td align="left"   ><?php echo $br['numerofrs']; ?></td> -->
                <td  align="right"  ><?php echo $f; ?></td>
                <?php foreach ($listva as $v) { //debug($v); die;  ?>

                    <td align="right"  ><?php echo $v['base']; ?></td> 
                    <td align="right"  ><?php echo $v['mtva']; ?></td>
                <?php } ?>
                <td  align="right"  ><?php echo $br['timbre']; ?></td>    
                <td  align="right"  ><?php echo $br['totalttc']; ?></td>
            </tr>

            <?php
            $totfactzero = floatval($totfactzero) + floatval($f);
        }
    } else {
        foreach ($tvas as $t) {
            $listvaall[$ccp]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
            $listvaall[$ccp]['mtva'] = 0;
            $listvaall[$ccp]['base'] = 0;
            $listvaall[$ccp]['tva'] = intval(floatval($t['Tva']['name']));
            $ccp++;
        }
    }
    foreach ($listvaall as $l) {
        $tf[$l['tva']]['montant'] = $tf[$l['tva']]['montant'] + $l['mtva'];
        $tf[$l['tva']]['base'] = $tf[$l['tva']]['base'] + $l['base'];
        $tf[$l['tva']]['nom'] = $l['nom'];
    }
    ?>

            <tr align="center">    
       
        <td bgcolor="#CCCCCC" colspan="4" nobr="nobr" align="right"  >Total</td>
        <td bgcolor="#CCCCCC" width="5%" align="right"  ><?php echo sprintf("%.3f", $totfactzero) ; ?></td>
<?php foreach ($tf as $y){//debug($y);die; ?>
                        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $y['base']) ; ?></td> 
                        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $y['montant']) ; ?></td>
<?php } ?>  
    <td bgcolor="#CCCCCC" width="5%" align="right"  ><?php echo sprintf("%.3f", $tottimbre) ; ?></td>                    
    <td bgcolor="#CCCCCC" width="8%" align="right"  ><?php echo sprintf("%.3f", $totnetapayer) ; ?></td>
        
        </tr>
</table>

<?php //die;
//die;
$content = ob_get_clean();

// convert in PDF
//require_once(dirname(__FILE__).'/../html2pdf.class.php');
//require_once('../Vendor/html2pdf.class.php');
//require_once('html2pdf/html2pdf.class.php');
//APP::import("Vendor", "html2pdf");
APP::import("Vendor", "html2pdf/html2pdf");
try {
    $html2pdf = new HTML2PDF('L', 'A4', 'fr');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->Output('Listefacturedepense.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}