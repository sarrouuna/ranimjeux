
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
$pdf->SetTitle('Factures vente');

$ent = 'entete.jpg';
$ModelSociete = ClassRegistry::init('Societe');
$soc = $ModelSociete->find('first', array('conditions' => array('Societe.mere' => 1)));

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
if ($date1 != "__/__/____" && $date1 != "1970-01-01" && $date2 != "__/__/____" && $date2 != "1970-01-01") {
    $date1 = date('d/m/Y', strtotime(str_replace('-', '/', $date1)));
    $date2 = date('d/m/Y', strtotime(str_replace('-', '/', $date2)));
    $m = ' du  ' . $date1 . ' au  ' . $date2;
}
// ---------------------------------------------------------

$pdf->AddPage('L');
$w = 39 / (count($tvas) * 2);
//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 7);
$logo = CakeSession::read('logo');

$tbl .=' 

<table width="100%">
<tr>
    <td width="45%" align="left" >
                        <IMG SRC="../webroot/img/' . $soc["Societe"]["logo"] . '" width="120"  >
                    </td>
    <td  width="55%">
        <table width="100%">
            <tr>
            <br> 
                <td height="35px" align="left" ><h1>Liste des factures Vente ' . $m . '</h1></td> 
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
                        <th width="8%" align="center" $zz ><strong>N° Fact</strong></th> 
                       
                        <th width="5%" align="center" $zz ><strong>Date</strong></th>
                        <th width="23%" align="center" $zz height="30px" ><strong>Nom_Prenom</strong></th>
                        <th width="5%" align="center" $zz ><strong>Code Cli</strong></th>              
                        ';
$tbl.='<th width="5%" align="center" $zz ><strong>Base 0%</strong></th> ';
foreach ($tvas as $t) { //debug($t);die;
    $tbl.='<th width="' . $w . '%" align="center" $zz ><strong>Base ' . intval(floatval($t['Tva']['name'])) . '%</strong></th> 
                        <th width="' . $w . '%" align="center" $zz ><strong>TVA ' . intval(floatval($t['Tva']['name'])) . '%</strong></th>';
}


$tbl.='<th width="5%" align="center" $zz ><strong>Timbre</strong></th>
                        <th width="10%" align="center" $zz ><strong>Net a payer</strong></th>'
        . '</tr>';
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
//$objfact = ClassRegistry::init('Lignefactureclient');
//$objfactavoir = ClassRegistry::init('Lignefactureavoir');
//$objexo = ClassRegistry::init('Exonorationclient');
//debug($tablignefactures);die;
//debug($tvas);die;
$totfactzero = 0;
if ($tablignefactures != array()) {
    foreach ($tablignefactures as $br) {
        $total = $total + $br['totalttc'];
        $i++;
        if ($i == 31) {
            $tbl .='</table>';
            $pdf->writeHTML($tbl, true, false, false, false, '');
            $pdf->AddPage('L');
            $i = 0;
            $tbl = '
                     <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
   <tr  bgcolor="#CCCCCC" align="center">
                        <th width="8%" align="center" $zz ><strong>N° Fact</strong></th> 
                       
                        <th width="5%" align="center" $zz ><strong>Date</strong></th>
                        <th width="23%" align="center" $zz height="30px" ><strong>Nom_Prenom</strong></th>
                        <th width="5%" align="center" $zz ><strong>Code Cli</strong></th>              
                        ';
            $tbl.='<th width="5%" align="center" $zz ><strong>Base 0%</strong></th> ';
            foreach ($tvas as $t) { //debug($t);die;
                $tbl.='<th width="' . $w . '%" align="center" $zz ><strong>Base ' . intval(floatval($t['Tva']['name'])) . '%</strong></th> 
                        <th width="' . $w . '%" align="center" $zz ><strong>TVA ' . intval(floatval($t['Tva']['name'])) . '%</strong></th>';
            }


            $tbl.='<th width="5%" align="center" $zz ><strong>Timbre</strong></th>
                        <th width="10%" align="center" $zz ><strong>Net a payer</strong></th>'
                    . '</tr>';
        }

        //debug($br);die;
//die;
        //debug($listva);die;
//    die;
        //debug($br);die;
        $totnetapayer = $totnetapayer + $br['totalttc'];
        $tottimbre = $tottimbre + $br['timbre'];
        $tbl .=
                '<tr bgcolor="#FFFFFF" align="center">    

        <th width="8%" align="center" $zz >' . $br['numero'] . '</th>    

                                <th width="5%" align="center" $zz >' . date("Y-m-d", strtotime(str_replace('/', '-', $br['date']))) . '</th>
                                 <th width="23%" align="left" $zz  >' . $br['client'] . '</th>
        <th width="5%" align="center" $zz >' . $br['code'] . '</th>
                                ';
        $tbl.='<th width="5%" align="right" $zz >' . $br['ventesup'] . '</th>';
        //debug($listva);die;
        foreach ($tvas as $v) { //debug($v); 
            $tv = intval(floatval($v['Tva']['name']));
            $tbl.='<th width="' . $w . '%" align="right" $zz >' . $br['base' . $tv] . '</th> 
                                                    <th width="' . $w . '%" align="right" $zz >' . $br['tva' . $tv] . '</th>';
        }

        $tbl.='
                                <th width="5%" align="right" $zz >' . $br['timbre'] . '</th>
                                <th width="10%" align="right" $zz >' . $br['totalttc'] . '</th>'
                . '</tr>';

        $totfactzero = floatval($totfactzero) + floatval($br['ventesup']);
    }//debug($tbl);
//die; 
}
//debug("amine");
//    die;
////die;
//debug($listva);die;
//debug($listvaall);die;
//$listvaall[3]['tva']=19;
//$listvaall[3]['mtva']=800;
//debug($listvaall);//die;
$tbl.='
</table>';


$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('EtatFactureTout.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>