
<?php

App::import('Vendor', 'xtcpdf');
$pdf = new XTCPDF();

class MYPDF extends TCPDF {

    var $xheadertext = 'PDF created using CakePHP and TCPDF';
    var $xheadercolor = array(0, 0, 200);
    //var $xfootertext  = 'Copyright Ã‚Â© %d XXXXXXXXXXX. <b>All rights reserved.</b>'; 
    var $xfooterfont = PDF_FONT_NAME_MAIN;
    var $xfooterfontsize = 8;

    //Page header
    public function Header() {
        
    }

    // Page footer
    public function Footer() {
        $year = date('Y');
        $footertext = sprintf($this->xfootertext, $year);
        $this->SetY(-20);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($this->xfooterfont, '', $this->xfooterfontsize);
        $footertext1 = sprintf($this->xfootertext1, $year);
        $this->SetY(-20);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($this->xfooterfont, '', $this->xfooterfontsize);
        $footertext2 = sprintf($this->xfootertext2, $year);
        $this->SetY(-20);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($this->xfooterfont, '', $this->xfooterfontsize);
        $this->Cell(0, 8, $footertext, 'T', 1, 'L');
        $this->Cell(0, 1, $footertext1, 0, 1, 'L');
        $this->Cell(0, 3, $footertext2, 0, 1, 'L');
    }

}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sotem');
$pdf->SetTitle('Liste Factureavoirfrs achat');

$ent = 'entete.jpg';
if ($pointdeventeachat != 0) {
    $pontdevente = ClassRegistry::init('Pointdevente')->find('first',array('conditions'=>array('Pointdevente.id'=>$pointdeventeachat)));
    $soc = ClassRegistry::init('Societe')->find('first',array('conditions'=>array('Societe.id'=>$pontdevente['Pointdevente']['societe_id'])));
    }else{
        $soc = ClassRegistry::init('Societe')->find('first');
    }
    
$footer = '     SARL au Capital de : ' . $soc['Societe']['capital'] . '          Adresse : ' . $soc['Societe']['adresse'] . '          Code T.V.A: ' . $soc['Societe']['codetva'] . '          RIB: ' . $soc['Societe']['rib'] . '          RC: ' . $soc['Societe']['rc'];
$footer1 = '';
$aaa = "abc";
$pdf->xfootertext = $footer;
$pdf->xfootertext1 = '';
$pdf->xfootertext2 = '';

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}
$m ='';
if ($datefinimpaye != "__/__/____" && $datefinimpaye != "1970-01-01" && $datedebutimpaye != "__/__/____" && $datedebutimpaye != "1970-01-01") {
    $datefinimpaye = date('d/m/Y', strtotime(str_replace('-', '/', $datefinimpaye)));
    $datedebutimpaye = date('d/m/Y', strtotime(str_replace('-', '/', $datedebutimpaye)));
    $m = ' du  ' . $datedebutimpaye . ' au  ' . $datefinimpaye;
}
// ---------------------------------------------------------

$pdf->AddPage('L');

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);
$w = 80 / 10;
$pdf->SetFont('times', 'A', 6);
$logo = CakeSession::read('logo');

$tbl .=' 

<table width="100%">
<tr>
    <td width="45%" align="left" >
    <strong ><h1>'. $soc['Societe']['nom'].'</h1></strong> 
                    </td>
    <td  width="55%">
        <table width="100%">
            <tr>
            <br> 
                <td height="35px" align="left" ><h1>Liste des factures d\'avoir ' . $m . '</h1></td> 
            </tr> 
        </table>
    </td>
</tr>
<br>
<tr>
    <td align="left" width="55%"  >' . $soc['Societe']['adresse'] . '</td>
    <td align="left" width="45%" ><strong>Tél : </strong>' . $soc['Societe']['tel'] . '</td>
</tr>
<tr>
    <td align="left" width="55%"  ><strong>TVA :</strong>' . $soc['Societe']['codetva'] . '</td>
    <td align="left" width="45%" ><strong>Fax :</strong>' . $soc['Societe']['fax'] . '</td>
</tr>
<tr>
    <td align="left" width="55%"  ><strong>R.C :</strong>' . $soc['Societe']['rc'] . '</td>
     <td align="left" width="45%" ><strong>Site web : </strong>' . $soc['Societe']['site'] . '</td>
</tr>
    
</table>
<br><br><br>
   
<table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
<tr  bgcolor="#CCCCCC" align="center">
<td width="' . $w . '%" align="center" $zz ><strong>N° BLF</strong></td> 
<td width="' . $w . '%" align="center" $zz ><strong>Date</strong></td> 
<td width="' . $w . '%" align="center" $zz ><strong>Code Frs</strong></td>                      
<td width="20%" align="center" $zz ><strong>Nom prenom</strong></td>
<td width="' . $w . '%" align="center" $zz  ><strong>Piece Frs</strong></td>'
        . '<td width="' . $w . '%" align="center" $zz ><strong>Date dec</strong></td>';
$tbl.='<td width="' . $w . '%" align="center" $zz ><strong>Tot HT</strong></td>
<td width="' . $w . '%" align="center" $zz ><strong>Tot TVA</strong></td>
    <td width="' . $w . '%" align="center" $zz ><strong>Net</strong></td>
        <td width="' . $w . '%" align="center" $zz ><strong>Tot Reg</strong></td>
<td width="' . $w . '%" align="center" $zz ><strong>Reste à payer</strong></td>';


$tbl.='</tr>';
$i = 0;
$totmntimp = 0;
$totnet = 0;
$tottotreg = 0;
$totrestepayer = 0;

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
//debug($lignereg);die;
    $numreg = '';
    $totreg = $br['Factureavoirfr']['Montant_Regler'];
    $totreg = sprintf("%.3f", $totreg);
    

    //debug($reg);debug($totreg);die;
    if(floatval($reg==0) || $reg=='Tous' || ($reg=='Regle' && floatval($totreg)!=0) || ($reg=='Nonregle' && floatval($totreg==0))){
    $total = $total + 0;
    $i++;
    if ($nbpage == 0) {
        $a = 34;
    } else {
        $a = 43;
    }
    if ($i > $a) {
        $nbpage = 1;
        $tbl .='</table>';
        $pdf->writeHTML($tbl, true, false, false, false, '');
        $pdf->AddPage('L');
        $i = 0;
        $tbl = '
                    <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                   <tr  bgcolor="#CCCCCC" align="center">
                   <td width="' . $w . '%" align="center" $zz ><strong>N° BLF</strong></td>
                   <td width="' . $w . '%" align="center" $zz ><strong>Date</strong></td> 
<td width="' . $w . '%" align="center" $zz ><strong>Code Frs</strong></td>                      
<td width="20%" align="center" $zz ><strong>Nom prenom</strong></td>
<td width="' . $w . '%" align="center" $zz  ><strong>Piece Frs</strong></td>'
        . '<td width="' . $w . '%" align="center" $zz ><strong>Date dec</strong></td>';
$tbl.='<td width="' . $w . '%" align="center" $zz ><strong>Tot HT</strong></td>
<td width="' . $w . '%" align="center" $zz ><strong>Tot TVA</strong></td>
    <td width="' . $w . '%" align="center" $zz ><strong>Net</strong></td>
        <td width="' . $w . '%" align="center" $zz ><strong>Tot Reg</strong></td>
<td width="' . $w . '%" align="center" $zz ><strong>Reste à payer</strong></td>';


        $tbl.='</tr>';
    }
    

//debug($br);die;
  
    
    $reste = sprintf("%.3f", floatval($br['Factureavoirfr']['totalttc']) - floatval($totreg));
    $totht = $totnet + floatval($br['Factureavoirfr']['totalht']);
    $tottottva = $totnet + floatval($br['Factureavoirfr']['tva']);
    $totnet = $totnet + floatval($br['Factureavoirfr']['totalttc']);
    $tottotreg = $tottotreg + floatval($totreg);
    $totreste = $totreste + floatval($reste);
    if ($reste == 0)
        $reste = '';
    
    $datedec='';
    if($br['Factureavoirfr']['datedeclaration']!=NULL && $br['Factureavoirfr']['datedeclaration']!='0000-00-00'){
        $datedec=date("d/m/Y", strtotime(str_replace('-', '/', $br['Factureavoirfr']['datedeclaration'])));
    }

    $tbl .=
            '<tr bgcolor="#FFFFFF" align="center">
                <td width="' . $w . '%" align="center" $zz >' . $br['Factureavoirfr']['numero'] . '</td>
                    <td width="' . $w . '%" align="center" $zz >' . date("d/m/Y", strtotime(str_replace('-', '/', $br['Factureavoirfr']['date']))) . '</td>
                    <td width="' . $w . '%" align="center" $zz >' . $clt['Fournisseur']['code'] . '</td>                      
                    <td width="20%" align="left" $zz >' . $clt['Fournisseur']['name'] . '</td>
                    <td width="' . $w . '%" align="center" $zz  >' . $br['Factureavoirfr']['numerofrs'] . '</td>';
    $tbl.='<td width="' . $w . '%" align="right" $zz >' . $datedec . '</td>
                    <td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $br['Factureavoirfr']['totalht']) . '</td>
                        <td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $br['Factureavoirfr']['tva']) . '</td>
                            <td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $br['Factureavoirfr']['totalttc']) . '</td>
                    <td width="' . $w . '%" align="right" $zz >' . $totreg . '</td>';
    $tbl.='<td width="' . $w . '%" align="right" $zz >' . $reste . '</td>'
            . '</tr>';
}
}
//die;
$tbl .= '
   <tr  bgcolor="#CCCCCC" align="center">    
       
        <td colspan="6" nobr="nobr" align="right"  $zz>Total</td>
        ';

$tbl .='<td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $totht) . '</td>
        <td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $tottottva) . '</td>'
        . '<td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $totnet) . '</td>
        <td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $tottotreg) . '</td>
            <td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $totreste) . '</td>
        </tr>
</table>';


$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('Listefacturesavoir.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>