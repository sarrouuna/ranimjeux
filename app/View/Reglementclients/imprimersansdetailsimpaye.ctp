
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
$pdf->SetTitle('Liste impayes');

$ent = 'entete.jpg';
if ($pointdeventeimpaye != 0) {
    $pontdevente = ClassRegistry::init('Pointdevente')->find('first',array('conditions'=>array('Pointdevente.id'=>$pointdeventeimpaye)));
    $soc = ClassRegistry::init('Societe')->find('first',array('conditions'=>array('Societe.id'=>$pontdevente['Pointdevente']['societe_id'])));
    }else{
        $soc = ClassRegistry::init('Societe')->find('first');
    }
    $m="";

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
if ($datefinimpaye != "__/__/____" && $datefinimpaye != "1970-01-01" && $datedebutimpaye != "__/__/____" && $datedebutimpaye != "1970-01-01") {
    $datefinimpaye = date('d/m/Y', strtotime(str_replace('-', '/', $datefinimpaye)));
    $datedebutimpaye = date('d/m/Y', strtotime(str_replace('-', '/', $datedebutimpaye)));
    $m = ' du  ' . $datedebutimpaye . ' au  ' . $datefinimpaye;
}
// ---------------------------------------------------------

$pdf->AddPage('L');

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);
$w = 75 / 9;
$pdf->SetFont('times', 'A', 6);
$logo = CakeSession::read('logo');

$tbl .=' 

<table width="100%">
<tr>
    <td width="30%" align="left" >
    <strong ><h1>'. $soc['Societe']['nom'].'</h1></strong> 
                    </td>
    <td  width="70%">
        <table width="100%">
            <tr>
            <br> 
                <td height="35px" align="left" ><h3>Liste des impayés ' . $m . '</h3></td> 
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
   
<table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" >       
<tr  bgcolor="#CCCCCC" align="center">
<td width="' . $w . '%" align="center" $zz ><strong>Num IMP</strong></td> 
<td width="' . $w . '%" align="center" $zz ><strong>Date</strong></td> 
<td width="' . $w . '%" align="center" $zz ><strong>Code Cli</strong></td>                      
<td width="25%" align="center" $zz ><strong>Nom prenom</strong></td>
<td width="' . $w . '%" align="center" $zz  ><strong>Nature</strong></td>'
        . '<td width="' . $w . '%" align="center" $zz ><strong>N° piece</strong></td>';
$tbl.='<td width="' . $w . '%" align="center" $zz ><strong>MONT.IMPAY</strong></td>
    <td width="' . $w . '%" align="center" $zz ><strong>Net</strong></td>
<td width="' . $w . '%" align="center" $zz ><strong>Tot REG</strong></td>
<td width="' . $w . '%" align="center" $zz ><strong>Reste à payer</strong></td>';



$tbl.='</tr>';
$i = 0;$ii = 0;
$totespece = 0;
$totcheque = 0;
$toteffet = 0;
$totretenue = 0;
$totvir = 0;
$totnet = 0;
$tottotreg = 0;
$totreste = 0;

$objbord = ClassRegistry::init('Lignebordereau');
$ccp = 0;
$nbpage = 0;
//debug($lignefactures);die;
//debug($bordereau);die;

foreach ($lignefactures as $br) {


//debug($br);die;

    $clt = ClassRegistry::init('Client')->find('first', array('conditions' => array('Client.id' => $br['Reglementclient']['client_id']), 'recursive' => -1));




    //debug($bordereau);debug($numbord);
//debug('aa');die;
    $lignereg = ClassRegistry::init('Lignereglementclient')->find('all', array('conditions' => array('Lignereglementclient.piecereglementclient_id' => $br['Piecereglementclient']['id']), 'recursive' => -1));
//debug($lignereg);die;
    $numreg = '';
    $totreg = 0;
    foreach ($lignereg as $j => $l) {
        $lignepiece = ClassRegistry::init('Piecereglementclient')->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $l['Lignereglementclient']['reglementclient_id']), 'recursive' => 0));
        //debug($lignepiece);
        foreach ($lignepiece as $p) {
            $t = $p['Paiement']['name'] . ' ';

            $totreg = $totreg + floatval($p['Piecereglementclient']['montant']);
            if ($j != 0) {
                $numreg.= '<br>' . $t . $p['Piecereglementclient']['montant'] . ' ' . $p['Piecereglementclient']['banque'] . ' ' . $p['Piecereglementclient']['num'] . ' Le ' . date("d/m/Y", strtotime(str_replace('-', '/', $p['Piecereglementclient']['echance'])));

                $i++;
            } else {
                $numreg.=$t . $p['Piecereglementclient']['montant'] . ' ' . $p['Piecereglementclient']['banque'] . ' ' . $p['Piecereglementclient']['num'] . ' Le ' . date("d/m/Y", strtotime(str_replace('-', '/', $p['Piecereglementclient']['echance'])));
            }
        }
    }
    if (floatval($totreg) == 0) {
        $totreg = '';
    } else {
        $totreg = sprintf("%.3f", $totreg);
    }

    if($reg=='0' || $reg=='Tous' || ($reg=='Regle' && $br['Piecereglementclient']['montant']==$br['Piecereglementclient']['mantantregler']) || ($reg=='Nonregle' && $br['Piecereglementclient']['montant']!=$br['Piecereglementclient']['mantantregler'])){
        $total = $total + 0;
        $ii++;
        if ($nbpage == 0) {
            $a = 34;
        } else {
            $a = 40;
        }
        if ($ii > $a) {
            $nbpage = 1;
            $tbl .='</table>';
            $pdf->writeHTML($tbl, true, false, false, false, '');
            $pdf->AddPage('L');
            $ii = 0;
            $tbl = '
                    <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" >       
                   <tr  bgcolor="#CCCCCC" align="center">
                   <td width="' . $w . '%" align="center" $zz ><strong>Num IMP</strong></td> 
                   <td width="' . $w . '%" align="center" $zz ><strong>Date</strong></td> 
<td width="' . $w . '%" align="center" $zz ><strong>Code Cli</strong></td>                      
<td width="25%" align="center" $zz ><strong>Nom prenom</strong></td>
<td width="' . $w . '%" align="center" $zz  ><strong>Nature</strong></td>'
                    . '<td width="' . $w . '%" align="center" $zz ><strong>N° piece</strong></td>';
            $tbl.='<td width="' . $w . '%" align="center" $zz ><strong>MONT.IMPAY</strong></td>'
                    . '<td width="' . $w . '%" align="center" $zz ><strong>Net</strong></td>
<td width="' . $w . '%" align="center" $zz ><strong>Tot REG</strong></td>
<td width="' . $w . '%" align="center" $zz ><strong>Reste à payer</strong></td>';


            $tbl.='</tr>';
        }
        $mntcheque = '';
        $numcheque = '';
        $type = '';

        if ($br['Piecereglementclient']['paiement_id'] == 2) {
            
            $type = 'CHEQUE';
        }
        if ($br['Piecereglementclient']['paiement_id'] == 3) {
            
            $type = 'EFFET';
        }

//debug($br);die;
        $reste = sprintf("%.3f", floatval($br['Piecereglementclient']['montant']) - floatval($br['Piecereglementclient']['mantantregler']));
    $totnet = $totnet + floatval($br['Piecereglementclient']['montant']);
    $tottotreg = $tottotreg + floatval($br['Piecereglementclient']['mantantregler']);
    $totreste = $totreste + floatval($reste);
        if ($reste == 0)
            $reste = '';

        $tbl .=
                '<tr bgcolor="#FFFFFF" align="center">
                <td width="' . $w . '%" align="center" $zz >' . $br['Reglementclient']['numero'] . '</td> 
                    <td width="' . $w . '%" align="center" $zz >' . date("d/m/Y", strtotime(str_replace('-', '/', $br['Piecereglementclient']['datesituation']))) . '</td>
                    <td width="' . $w . '%" align="center" $zz >' . $clt['Client']['code'] . '</td>                      
                    <td width="25%" align="left" $zz >' . $clt['Client']['name'] . '</td>
                    <td width="' . $w . '%" align="center" $zz  >' . $type . '</td>';
        $tbl.='<td width="' . $w . '%" align="right" $zz >' . $numcheque . '</td>
                    <td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $br['Piecereglementclient']['montant']) . '</td>
                        <td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $br['Piecereglementclient']['montant']) . '</td>
                    <td width="' . $w . '%" align="right" $zz >' . $br['Piecereglementclient']['mantantregler'] . '</td>';
        $tbl.='<td width="' . $w . '%" align="right" $zz >' . $reste . '</td>
            </tr>';
    }
}
//die;
$tbl .= '
   <tr  bgcolor="#CCCCCC" align="center">    
       
        <td colspan="6" nobr="nobr" align="right"  $zz>Total</td>
        ';

$tbl .='<td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $totnet) . '</td>
    <td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $totnet) . '</td>
        <td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $tottotreg) . '</td>
            <td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $totreste) . '</td>
        </tr>
</table>';


$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('Listeimpayes.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>