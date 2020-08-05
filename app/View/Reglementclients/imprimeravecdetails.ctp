<?php
if ($pointdevente_id_recette != 0) {
    $pontdevente = ClassRegistry::init('Pointdevente')->find('first',array('conditions'=>array('Pointdevente.id'=>$pointdevente_id_recette)));
    $soc = ClassRegistry::init('Societe')->find('first',array('conditions'=>array('Societe.id'=>$pontdevente['Pointdevente']['societe_id'])));
    }else{
        $soc = ClassRegistry::init('Societe')->find('first');
    }
    $m="";
    
    if ($datereglement1 != "__/__/____" && $datereglement1 != "1970-01-01" && $datereglement2 != "__/__/____" && $datereglement2 != "1970-01-01") {
    $datereglement1 = date('d/m/Y', strtotime(str_replace('-', '/', $datereglement1)));
    $datereglement2 = date('d/m/Y', strtotime(str_replace('-', '/', $datereglement2)));
    $m = ' du  ' . $datereglement1 . ' au  ' . $datereglement2;
}
$lborder = 'border="0"';

$w = $w = 65 / 10;

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
                <td height="35px" align="right" ><h3>Edition recette <?php echo @$m; ?></h3></td> 
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
<table align="center" cellpadding="0" cellspacing="0"  style=" width: 100%; font-size: 2.8mm;" border="1">       
    <tr  bgcolor="#CCCCCC" align="center">
        <td style=" width: <?php echo $w; ?>%;" align="center"  ><strong>N° Reg</strong></td> 
        <td style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Date</strong></td>
        <td style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Code Cli</strong></td>                      
        <td style=" width: 18%;" align="center"  ><strong>Nom prenom</strong></td>
        <td style=" width: <?php echo $w; ?>%;" align="center"   ><strong>N° BORD</strong></td>
        <td style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Espece</strong></td>
        <td style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Cheque</strong></td>
        <td style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Effet</strong></td>
        <td style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Retenue</strong></td>
        <td style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Virement</strong></td>
        <td style=" width: <?php echo $w; ?>%;" align="center"  ><strong>N° Cheque</strong></td>
        <td style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Date ECH</strong></td>
        <td width="10%" align="center"  ><strong>Factures</strong></td>
    </tr>

    <?php
    $i = 0;
    $totespece = 0;
    $totcheque = 0;
    $toteffet = 0;
    $totretenue = 0;
    $totvir = 0;

    $objbord = ClassRegistry::init('Lignebordereau');
    $ccp = 0;
    $nbpage = 0;
    foreach ($lignefactures as $br) {


//debug($br);die;

        $clt = ClassRegistry::init('Client')->find('first', array('conditions' => array('Client.id' => $br['Reglementclient']['client_id']), 'recursive' => -1));


        $numbord = 0;

        $bord = $objbord->find('first', array('conditions' => array('Lignebordereau.piecereglementclient_id' => $br['Piecereglementclient']['id']), 'contain' => ('Bordereau'), 'recursive' => 0));
        if ($bord != array()) {
            $numbord = $bord['Bordereau']['numero'];
        }

        //debug($bordereau);debug($numbord);
        if ((($bordereau == 'AvecBordereau') && (floatval($numbord) != 0)) || ($bordereau == 'Tous') || (($bordereau == 'SansBordereau') && ($numbord == 0))) {
//debug('aa');die;
            $lignereg = ClassRegistry::init('Lignereglementclient')->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $br['Reglementclient']['id']), 'contain' => ('Factureclient'), 'recursive' => 0));

            $numreg = '';
            foreach ($lignereg as $j => $l) {
                if ($j != 0) {
                    $numreg.='<br>' . $l['Factureclient']['numero'];
                    $i++;
                } else {
                    $numreg.=$l['Factureclient']['numero'];
                }
            }


            $mntespece = '';
            $mntcheque = '';
            $mnteffet = '';
            $mntretenue = '';
            $numcheque = '';
            $mntvirement = '';
            if ($br['Piecereglementclient']['paiement_id'] == 1) {
                $mntespece = $br['Piecereglementclient']['montant'];
                $mntcheque = '';
                $mnteffet = '';
                $mntretenue = '';
                $numcheque = '';
                $mntvirement = '';
            }
            if ($br['Piecereglementclient']['paiement_id'] == 2) {
                $mntespece = '';
                $mntcheque = $br['Piecereglementclient']['montant'];
                $mnteffet = '';
                $mntretenue = '';
                $numcheque = $br['Piecereglementclient']['num'];
                $mntvirement = '';
            }
            if ($br['Piecereglementclient']['paiement_id'] == 3) {
                $mntespece = '';
                $mntcheque = '';
                $mnteffet = $br['Piecereglementclient']['montant'];
                $mntretenue = '';
                $numcheque = '';
                $mntvirement = '';
            }
            if ($br['Piecereglementclient']['paiement_id'] == 5 || $br['Piecereglementclient']['paiement_id'] == 8) {
                $mntespece = '';
                $mntcheque = '';
                $mnteffet = '';
                $mntretenue = $br['Piecereglementclient']['montant'];
                $numcheque = '';
                $mntvirement = '';
            }
            if ($br['Piecereglementclient']['paiement_id'] == 4) {
                $mntespece = '';
                $mntcheque = '';
                $mnteffet = '';
                $mntretenue = '';
                $numcheque = '';
                $mntvirement = $br['Piecereglementclient']['montant'];
            }
//debug($br);die;
            $totespece = $totespece + $mntespece;
            $totcheque = $totcheque + $mntcheque;
            $toteffet = $toteffet + $mnteffet;
            $totretenue = $totretenue + $mntretenue;
            $totvir = $totvir + $mntvirement;
            $dateecheance = '';
            if ($br['Piecereglementclient']['echance'] != null && $br['Piecereglementclient']['echance'] != '1970-01-01') {
                $dateecheance = date("d/m/Y", strtotime(str_replace('-', '/', $br['Piecereglementclient']['echance'])));
            }
            ?>

            <tr bgcolor="#FFFFFF" align="center">    
                <td  align="center"  ><?php echo $br['Reglementclient']['numero']; ?></td> 
                <td  align="center"  ><?php echo date("d/m/Y", strtotime(str_replace('-', '/', $br['Reglementclient']['Date']))); ?></td>
                <td  align="center"  ><?php echo $clt['Client']['code']; ?></td>                      
                <td  align="left"  ><?php echo substr($clt['Client']['name'],0,30); ?></td>
                <td  align="center"   ><?php echo $numbord; ?></td>
                <td align="right"  ><?php echo $mntespece; ?></td>
                <td align="right"  ><?php echo $mntcheque; ?></td>
                <td align="right"  ><?php echo $mnteffet; ?></td>
                <td align="right"  ><?php echo $mntretenue; ?></td>
                <td align="right"  ><?php echo $mntvirement; ?></td>
                <td align="right"  ><?php echo $numcheque; ?></td>
                <td align="center"  ><?php echo $dateecheance; ?></td>
                <td width="10%" align="center"  ><?php echo $numreg; ?></td>
            </tr>


            <?php
        }
    }
    ?>
    <tr  bgcolor="#CCCCCC" align="center">    

        <td colspan="5" nobr="nobr" align="right"  >Total</td>
        <td style=" width: <?php echo $w; ?>%;" align="right"  ><?php echo sprintf("%.3f", $totespece); ?></td>
        <td style=" width: <?php echo $w; ?>%;" align="right"  ><?php echo sprintf("%.3f", $totcheque); ?></td>
        <td style=" width: <?php echo $w; ?>%;" align="right"  ><?php echo sprintf("%.3f", $toteffet); ?></td>
        <td style=" width: <?php echo $w; ?>%;" align="right"  ><?php echo sprintf("%.3f", $totretenue); ?></td>
        <td style=" width: <?php echo $w; ?>%;" align="right"  ><?php echo sprintf("%.3f", $totvir); ?></td>
        <td  bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="right"  ></td>
        <td  bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="right"  ></td>
        <td  bgcolor="#CCCCCC" width="10%" align="right"  ></td>
    </tr>
</table>

<?php
//die;
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
    $html2pdf->Output('Etatrecetteavecdetails.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}