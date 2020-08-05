<?php
if ($pointdeventeachat != 0) {
    $pontdevente = ClassRegistry::init('Pointdevente')->find('first',array('conditions'=>array('Pointdevente.id'=>$pointdeventeachat)));
    $soc = ClassRegistry::init('Societe')->find('first',array('conditions'=>array('Societe.id'=>$pontdevente['Pointdevente']['societe_id'])));
    }else{
        $soc = ClassRegistry::init('Societe')->find('first');
    }
    $m="";
    if ($datefinimpaye != "__/__/____" && $datefinimpaye != "1970-01-01" && $datedebutimpaye != "__/__/____" && $datedebutimpaye != "1970-01-01") {
        $datefinimpaye = date('d/m/Y', strtotime(str_replace('-', '/', $datefinimpaye)));
        $datedebutimpaye = date('d/m/Y', strtotime(str_replace('-', '/', $datedebutimpaye)));
        $m = ' du  ' . $datedebutimpaye . ' au  ' . $datefinimpaye;
    }
    
$w = 80 / 10;
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
                <td height="35px" align="right" ><h3>Liste des factures achat <?php echo $m; ?></h3></td> 
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

<table align="center" cellpadding="0" cellspacing="0"  style=" width: 100%; font-size: 3.3mm;" border="1">       
    <tr align="center">
        <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="center"  ><strong>N° BLF</strong></td> 
        <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Date</strong></td> 
        <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Code Frs</strong></td>                      
        <td bgcolor="#CCCCCC" style=" width: 18%;" align="center"  ><strong>Nom prenom</strong></td>
        <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="center"   ><strong>Piece Frs</strong></td>
        <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Date dec</strong></td>
        <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Tot HT</strong></td>
        <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Tot TVA</strong></td>
        <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Net</strong></td>
        <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Tot Reg</strong></td>
        <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="center"  ><strong>Reste à payer</strong></td>
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

        $clt = ClassRegistry::init('Fournisseur')->find('first', array('conditions' => array('Fournisseur.id' => $br['Facture']['fournisseur_id']), 'recursive' => -1));




        //debug($bordereau);debug($numbord);
//debug('aa');die;
        //$lignereg = ClassRegistry::init('Lignereglement')->find('all', array('conditions' => array('Lignereglement.facture_id' => $br['Facture']['id']),'fields' => array('sum(Lignereglement.Montant) as totalreg'), 'recursive' => -1));
//debug($lignereg);die;
        $numreg = '';
        $totreg = $br['Facture']['Montant_Regler'];
        $totreg = sprintf("%.3f", $totreg);


        //debug($reg);debug($totreg);die;
        if ($reg == 0 || $reg == 'Tous' || ($reg == 'Regle' && $totreg != 0) || ($reg == 'Nonregle' && $totreg == 0)) {

            $reste = sprintf("%.3f", floatval($br['Facture']['totalttc']) - floatval($totreg));
            $totht = $totnet + floatval($br['Facture']['totalht']);
            $tottottva = $totnet + floatval($br['Facture']['tva']);
            $totnet = $totnet + floatval($br['Facture']['totalttc']);
            $tottotreg = $tottotreg + floatval($totreg);
            $totreste = $totreste + floatval($reste);
            if ($reste == 0)
                $reste = '';

            $datedec = '';
            if ($br['Facture']['datedeclaration'] != NULL && $br['Facture']['datedeclaration'] != '0000-00-00') {
                $datedec = date("d/m/Y", strtotime(str_replace('-', '/', $br['Facture']['datedeclaration'])));
            }
            $num=$br['Facture']['numero'];
            if($br['Facture']['numerofrs']!=NULL){
                $num=$br['Facture']['numerofrs'];
            }
            ?>

            <tr bgcolor="#FFFFFF" align="center">
                <td  align="center"  ><?php echo $num; ?></td>
                <td  align="center"  ><?php echo date("d/m/Y", strtotime(str_replace('-', '/', $br['Facture']['date']))); ?></td>
                <td  align="center"  ><?php echo $clt['Fournisseur']['code']; ?></td>                      
                <td  align="left"  ><?php echo substr( $clt['Fournisseur']['name'],0,20); ?></td>
                <td  align="center"   ><?php echo $br['Facture']['numerofrs']; ?></td>
                <td  align="right"  ><?php echo $datedec; ?></td>
                <td  align="right"  ><?php echo sprintf("%.3f", $br['Facture']['totalht']); ?></td>
                <td  align="right"  ><?php echo sprintf("%.3f", $br['Facture']['tva']); ?></td>
                <td  align="right"  ><?php echo sprintf("%.3f", $br['Facture']['totalttc']); ?></td>
                <td  align="right"  ><?php echo $totreg; ?></td>
                <td  align="right"  ><?php echo $reste; ?></td>
            </tr>
            <?php
        }
    }
    ?>

    <tr align="center">    

        <td bgcolor="#CCCCCC" colspan="6" nobr="nobr" align="right"  >Total</td>
        <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="right"  ><?php echo  sprintf("%.3f", $totht) ; ?></td>
        <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="right"  ><?php echo  sprintf("%.3f", $tottottva) ; ?></td>
        <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="right"  ><?php echo  sprintf("%.3f", $totnet) ; ?></td>
        <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="right"  ><?php echo  sprintf("%.3f", $tottotreg) ; ?></td>
        <td bgcolor="#CCCCCC" style=" width: <?php echo $w; ?>%;" align="right"  ><?php echo  sprintf("%.3f", $totreste) ; ?></td>
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
    $html2pdf->Output('Listefactureachat.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}