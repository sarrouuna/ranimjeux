<?php
if ($pvfacture != 0) {
    $pontdevente = ClassRegistry::init('Pointdevente')->find('first',array('conditions'=>array('Pointdevente.id'=>$pvfacture)));
    $soc = ClassRegistry::init('Societe')->find('first',array('conditions'=>array('Societe.id'=>$pontdevente['Pointdevente']['societe_id'])));
    }else{
        $soc = ClassRegistry::init('Societe')->find('first');
    }

$m='';
if ($date1 != "__/__/____" && $date1 != "1970-01-01" && $date2 != "__/__/____" && $date2 != "1970-01-01") {
    $date1 = date('d/m/Y', strtotime(str_replace('-', '/', $date1)));
    $date2 = date('d/m/Y', strtotime(str_replace('-', '/', $date2)));
    $m = ' du  ' . $date1 . ' au  ' . $date2;
}
$lborder = 'border="0"';
$w =0;
if(count($tvas)!=0){
$w = 34 / (count($tvas) * 2);
}
ob_start();
?>
<table>
<tr>
        <td style=" width: 30%;" align="left" >
        <strong ><h1><?php echo $soc['Societe']['nom']; ?></h1></strong> 
        </td>
        <td  style=" width: 70%;">
            <table style=" width: 100%;font-size: 1.5mm;">
                <tr>
                <br> 
                <td height="35px" align="right" ><h3>Liste des factures Vente <?php echo @$m; ?></h3></td> 
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
    <tr  bgcolor="#CCCCCC" align="center" >
        <th style=" width: 8%;" align="center"  ><strong>N° Fact</strong></th> 

        <th style=" width: 5%;" align="center"  ><strong>Date</strong></th>
        <th style=" width: 20%;" align="center"  height="30px" ><strong>Nom_Prenom</strong></th>
        <th style=" width: 5%;" align="center"  ><strong>Code Cli</strong></th>
        <th style=" width: 5%;" align="center"  ><strong>V Exo</strong></th> 
        <th style=" width: 5%;" align="center"  ><strong>Base 0%</strong></th> 
        <?php foreach ($tvas as $t) { //debug($t);die; ?>
            <th style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Base <?php echo intval(floatval($t['Tva']['name'])); ?>%</strong></th> 
            <th style=" width: <?php echo $w; ?>%;" align="center"  ><strong>TVA <?php echo intval(floatval($t['Tva']['name'])); ?>%</strong></th>
        <?php } ?>


        <th style=" width: 5%;" align="center"  ><strong>Timbre</strong></th>
        <th style=" width: 10%;" align="center"  ><strong>Net a payer</strong></th>
    </tr>

    <?php 
    $totnetapayer = 0;
    $tottimbre = 0;
    $totfactzero = 0;
    $totexo = 0;
    foreach ($tablignefactures as $br) {
        $totnetapayer = $totnetapayer + $br['totalttc'];
        $tottimbre = $tottimbre + $br['timbre'];
        ?>
        <tr bgcolor="#FFFFFF" align="center">    

            <td align="center"  ><?php echo $br['numero']; ?></td>    

            <td align="center"  ><?php echo date("Y-m-d", strtotime(str_replace('/', '-', $br['date']))); ?></td>
            <td  align="left"   ><?php echo substr($br['client'],0,30); ?></td>
            <td align="center"  ><?php echo $br['code']; ?></td>
            <td align="right"  ><?php echo $br['venteexo']; ?></td>
            <td align="right"  ><?php echo $br['ventesup']; ?></td>
            <?php
            $totfactzero = floatval($totfactzero) + floatval($br['ventesup']);
            $totexo = floatval($totexo) + floatval($br['venteexo']);
            foreach ($tvas as $v) { //debug($v); 
                $tv = intval(floatval($v['Tva']['name']));
                $base = 'base' . $tv;
                $tva = 'tva' . $tv;
                $b = $br[$base];
                $tvav = $br[$tva];
                if (floatval($br[$base]) == 0) {
                    $b = '';
                }
                if (floatval($br[$tva]) == 0) {
                    $tvav = '';
                }
                ?>
                <td  align="right"  ><?php echo $b; ?></td> 
                <td  align="right"  ><?php echo $tvav; ?></td>
            <?php } ?>


            <td  align="right"  ><?php echo $br['timbre']; ?></td>
            <td  align="right"  ><?php echo $br['totalttc']; ?></td>
        </tr>
    <?php } ?>
        
        <?php
    $tf = array(); //debug($listvaall);die;
    foreach ($listvaall as $l) {
        if (!isset($tf[$l['tva']]['montant'])) {
            $tf[$l['tva']]['montant'] = 0;
        }
        if (!isset($tf[$l['tva']]['base'])) {
            $tf[$l['tva']]['base'] = 0;
        }

        $tf[$l['tva']]['montant'] = $tf[$l['tva']]['montant'] + $l['mtva'];
        $tf[$l['tva']]['base'] = $tf[$l['tva']]['base'] + $l['base'];
        $tf[$l['tva']]['nom'] = $l['nom'];
    }
  
    ?>

    <tr  bgcolor="#CCCCCC" align="center">    

        <td width="41%" colspan="4" nobr="nobr" align="right"  >Total</td>
        <th width="5%" align="right"  ><?php echo sprintf("%.3f", $totexo); ?></th>
        <th width="5%" align="right"  ><?php echo sprintf("%.3f", $totfactzero); ?></th>
        <?php
        foreach ($tf as $y) {  ?>
            <th width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $y['base']); ?></th> 
            <th width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $y['montant']); ?></th>
<?php } ?>
        <th width="5%" align="right"  ><?php echo sprintf("%.3f", $tottimbre); ?></th>
        <th width="10%" align="right"  ><?php echo sprintf("%.3f", $totnetapayer); ?></th>
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
    $html2pdf->Output('Etatfacture.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}