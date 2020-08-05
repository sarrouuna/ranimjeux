<?php
$soc = ClassRegistry::init('Societe')->find('first', array('conditions' => array('Societe.mere' => 1)));
if ($datefinimpaye != "__/__/____" && $datefinimpaye != "1970-01-01" && $datedebutimpaye != "__/__/____" && $datedebutimpaye != "1970-01-01") {
    $datefinimpaye = date('d/m/Y', strtotime(str_replace('-', '/', $datefinimpaye)));
    $datedebutimpaye = date('d/m/Y', strtotime(str_replace('-', '/', $datedebutimpaye)));
    $m = ' du  ' . $datedebutimpaye . ' au  ' . $datefinimpaye;
}
$w = 80 / 10;
ob_start();
?>
<table width="100%" style=" width: 100%; font-size: 2.5mm; ">
    <tr>
        <td width="45%" align="left" >
            <IMG SRC="../webroot/img/<?php echo $soc["Societe"]["logo"]; ?>" width="120"  >
        </td>
        <td  width="55%">
            <table width="100%">
                <tr>
                <br> 
                <td height="35px" align="left" ><h1>Liste des factures avoir <?php echo $m; ?></h1></td> 
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

<table align="center" cellpadding="0" cellspacing="0"  style=" width: 100%; font-size: 3.5mm;" border="1">        
    <tr align="center">
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>N° BLF</strong></td> 
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Date</strong></td> 
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Code Frs</strong></td>                      
        <td bgcolor="#CCCCCC" width="20%" align="center"  ><strong>Nom prenom</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"   ><strong>Piece Frs</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Date dec</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Tot HT</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Tot TVA</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Net</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Tot Reg</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Reste à payer</strong></td>
    </tr>

    <?php
    $i = 0;
    $totmntimp = 0;
    $totnet = 0;
    $tottotreg = 0;
    $totrestepayer = 0;
    $totreste=0;

    $ccp = 0;
    $nbpage = 0;
//debug($lignefactures);die;
//debug($bordereau);die;

    foreach ($lignefactures as $br) {


//debug($br);die;

        $clt = ClassRegistry::init('Fournisseur')->find('first', array('conditions' => array('Fournisseur.id' => $br['Factureavoirfr']['fournisseur_id']), 'recursive' => -1));




        //debug($bordereau);debug($numbord);
//debug('aa');die;
        //$lignereg = ClassRegistry::init('Lignereglement')->find('all', array('conditions' => array('Lignereglement.facture_id' => $br['Factureavoirfr']['id']),'fields' => array('sum(Lignereglement.Montant) as totalreg'), 'recursive' => -1));
//debug($br);die;
        $numreg = '';
        $totreg = @$br['Factureavoirfr']['Montant_Regler'];
        $totreg = sprintf("%.3f", $totreg);


        //debug($reg);debug($totreg);die;
        if (floatval($reg == 0) || $reg == 'Tous' || ($reg == 'Regle' && floatval($totreg) != 0) || ($reg == 'Nonregle' && floatval($totreg == 0))) {
            $reste = sprintf("%.3f", floatval($br['Factureavoirfr']['totalttc']) - floatval($totreg));
            $totht = $totnet + floatval($br['Factureavoirfr']['totalht']);
            $tottottva = $totnet + floatval($br['Factureavoirfr']['tva']);
            $totnet = $totnet + floatval($br['Factureavoirfr']['totalttc']);
            $tottotreg = $tottotreg + floatval($totreg);
            $totreste = $totreste + floatval($reste);
            if ($reste == 0)
                $reste = '';

            $datedec = '';
            if (@$br['Factureavoirfr']['datedeclaration'] != NULL && @$br['Factureavoirfr']['datedeclaration'] != '0000-00-00') {
                $datedec = date("d/m/Y", strtotime(str_replace('-', '/', @$br['Factureavoirfr']['datedeclaration'])));
            }
            ?>
            <tr bgcolor="#FFFFFF" align="center">
                <td width="<?php echo $w; ?>%" align="center"  ><?php echo $br['Factureavoirfr']['numero']; ?></td>
                <td width="<?php echo $w; ?>%" align="center"  ><?php echo date("d/m/Y", strtotime(str_replace('-', '/', $br['Factureavoirfr']['date']))); ?></td>
                <td width="<?php echo $w; ?>%" align="center"  ><?php echo $clt['Fournisseur']['code']; ?></td>                      
                <td width="20%" align="left"  ><?php echo $clt['Fournisseur']['name']; ?></td>
                <td width="<?php echo $w; ?>%" align="center"   ><?php echo @$br['Factureavoirfr']['numerofrs']; ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $datedec; ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $br['Factureavoirfr']['totalht']); ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $br['Factureavoirfr']['tva']); ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $br['Factureavoirfr']['totalttc']); ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $totreg; ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $reste; ?></td>
            </tr>

            <?php
        }
    }
    ?>

    <tr align="center">    

        <td bgcolor="#CCCCCC" colspan="6" nobr="nobr" align="right"  >Total</td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo  sprintf("%.3f", $totht) ; ?></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo  sprintf("%.3f", $tottottva) ; ?></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo  sprintf("%.3f", $totnet) ; ?></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo  sprintf("%.3f", $tottotreg) ; ?></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo  sprintf("%.3f", $totreste) ; ?></td>
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
    $html2pdf->Output('Listefactureavoir.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}