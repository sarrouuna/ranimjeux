
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
$pdf->SetTitle('Factures vente exonoree');

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

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 8);
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
                <td height="35px" align="left" ><h1>Liste des factures exonorée de la TVA ' . $m . '</h1></td> 
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
                        <th width="3%" align="center" $zz ><strong>N°</strong></th>
                        <th width="7%" align="center" $zz ><strong>Date</strong></th>
                        <th width="5%" align="center" $zz ><strong>N° Fact</strong></th>                        
                        <th width="10%" align="center" $zz ><strong>Matricule_Fiscal</strong></th>
                        <th width="20%" align="center" $zz height="30px" ><strong>Nom/Raison</strong></th>
                        
                        <th width="15%" align="center" $zz ><strong>Adresse</strong></th>
                        <th width="10%" align="center" $zz ><strong>Montant HT</strong></th>';
foreach ($tvas as $t) { //debug($t);die;
    $tbl.='<th width="5%" align="center" $zz ><strong>Base ' . intval(floatval($t['Tva']['name'])) . '%</strong></th> 
                        <th width="5%" align="center" $zz ><strong>TVA ' . intval(floatval($t['Tva']['name'])) . '%</strong></th>';
}


$tbl.='</tr>';
$i = 0;
$total = 0;
$totht = 0;
$totbase6 = 0;
$totbase12 = 0;
$totbase18 = 0;
$tottva6 = 0;
$tottva12 = 0;
$tottva18 = 0;
$objfact = ClassRegistry::init('Lignefactureclient');
$objfactavoir = ClassRegistry::init('Lignefactureavoir');
$ccp = 0;
$listvaall = array();
//      debug($tablignefactures);die;
if($tablignefactures != array()){
foreach ($tablignefactures as $br) {
    $total = $total + $br['totalttc'];
    $i++;
    if ($i == 15) {
        $tbl .='</table>';
        $pdf->writeHTML($tbl, true, false, false, false, '');
        $pdf->AddPage('P');
        $i = 0;
        $tbl = '
                    <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                   <tr  bgcolor="#CCCCCC" align="center">
                       <th width="3%" align="center" $zz ><strong>N°</strong></th>
                        <th width="7%" align="center" $zz ><strong>Date</strong></th>
                        <th width="5%" align="center" $zz ><strong>N° Fact</strong></th>                        
                        <th width="10%" align="center" $zz ><strong>Matricule_Fiscal</strong></th>
                        <th width="20%" align="center" $zz height="30px" ><strong>Nom/Raison</strong></th>
                        
                        <th width="15%" align="center" $zz ><strong>Adresse</strong></th>
                        <th width="10%" align="center" $zz ><strong>Montant HT</strong></th>';
        foreach ($tvas as $t) { //debug($t);die;
            $tbl.='<th width="5%" align="center" $zz ><strong>Base ' . intval(floatval($t['Tva']['name'])) . '%</strong></th> 
                        <th width="5%" align="center" $zz ><strong>TVA ' . intval(floatval($t['Tva']['name'])) . '%</strong></th>';
        }


        $tbl.='</tr>';
    }

    //debug($br);die;
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
    foreach ($tvas as $t) { //debug($t);die;
        if ($br['type'] == 'Facture client') {
            $lignefact = $objfact->find('all', array('fields' => array('SUM(Lignefactureclient.totalht * (Lignefactureclient.tva /100)) as mtva', 'Lignefactureclient.tva as taux'), 'conditions' => (array('Lignefactureclient.factureclient_id' => $br['id_piece'])), 'group' => ['Lignefactureclient.tva'], 'recursive' => -1));

            if($lignefact != array()){
            foreach ($lignefact as $fact) {
                //debug($fact);die;
                if ($fact['Lignefactureclient']['taux'] == intval(floatval($t['Tva']['name']))) {
                    $listva[$p]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                    $listva[$p]['mtva'] = sprintf("%.3f", $fact[0]['mtva']);
                    $listva[$p]['base'] = $br['totalht'];
                    $listva[$p]['tva'] = intval(floatval($t['Tva']['name']));
                    $p++;

                    $listvaall[$ccp]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                    $listvaall[$ccp]['mtva'] = sprintf("%.3f", $fact[0]['mtva']);
                    $listvaall[$ccp]['base'] = $br['totalht'];
                    $listvaall[$ccp]['tva'] = intval(floatval($t['Tva']['name']));
                    $ccp++;
                }else{
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
            }else {
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
        } else {
            $lignefactavoir = $objfactavoir->find('all', array('fields' => array('SUM(Lignefactureavoir.totalht * (Lignefactureavoir.tva /100)) as mtva', 'Lignefactureavoir.tva'), 'conditions' => (array('Lignefactureavoir.factureavoir_id' => $br['id_piece'])), 'group' => ['Lignefactureavoir.tva'], 'recursive' => -1));
         if($lignefactavoir != array()){
            foreach ($lignefactavoir as $fact) {
                //debug($fact);die;
                if ($fact['Lignefactureavoir']['taux'] == intval(floatval($t['Tva']['name']))) {
                    $listva[$p]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                    $listva[$p]['mtva'] = sprintf("%.3f", $fact[0]['mtva']);
                    $listva[$p]['base'] = $br['totalht'];
                    $listva[$p]['tva'] = intval(floatval($t['Tva']['name']));
                    $p++;

                    $listvaall[$ccp]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                    $listvaall[$ccp]['mtva'] = sprintf("%.3f", $fact[0]['mtva']);
                    $listvaall[$ccp]['base'] = $br['totalht'];
                    $listvaall[$ccp]['tva'] = intval(floatval($t['Tva']['name']));
                    $ccp++;
                }else{
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
         }else {
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
    }

//    debug($listva);
//    die;
    //debug($br);die;
    $totht = $totht + $br['totalht'];
//    $totbase6 = $totbase6 + $base6;
//    $tottva6 = $tottva6 + $tva6;
//    $totbase12 = $totbase12 + $base12;
//    $tottva12 = $tottva12 + $tva12;
//    $totbase18 = $totbase18 + $base18;
//    $tottva18 = $tottva18 + $tva18;
    $tbl .=
            '<tr bgcolor="#FFFFFF" align="center">    
        <th width="3%" align="center" heigth="30px" $zz >' . $i . '</th>
                        <th width="7%" align="center" $zz >' . date("Y-m-d", strtotime(str_replace('/', '-', $br['date']))) . '</th>
                        <th width="5%" align="center" $zz >' . $br['numero'] . '</th>                        
                        <th width="10%" align="left" $zz >' . $br['matriculefiscal'] . '</th>
                        <th width="20%" align="left" $zz height="30px" >' . $br['client'] . '</th>
                        
                        <th width="15%" align="left" $zz >' . $br['adresse'] . '</th>
                        <th width="10%" align="center" $zz >' . $br['totalht'] . '</th>';
                        //debug($listva);die;
                            foreach ($listva as $v) { //debug($v); die;
                                
                                $tbl.='<th width="5%" align="center" $zz >' . $v['base'] . '</th> 
                                            <th width="5%" align="center" $zz >' . $v['mtva'] . '</th>';
                            }
                       

    $tbl.='</tr>';
}
}else {
    foreach ($tvas as $t){
        $listvaall[$ccp]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                    $listvaall[$ccp]['mtva'] = 0;
                    $listvaall[$ccp]['base'] = 0;
                    $listvaall[$ccp]['tva'] = intval(floatval($t['Tva']['name']));
                    $ccp++;
    }
}
//debug($listvaall);//die;
//$listvaall[3]['tva']=19;
//$listvaall[3]['mtva']=800;
//debug($listvaall);//die;
$tf=array(); //debug($listvaall);die;
foreach ($listvaall as $l){
    $tf[$l['tva']]['montant']=$tf[$l['tva']]['montant']+$l['mtva'];
    $tf[$l['tva']]['base']=$tf[$l['tva']]['base']+$l['base'];
    $tf[$l['tva']]['nom']=$l['nom'];
}
//debug($tf);die;
$tbl .= '
   <tr  bgcolor="#CCCCCC" align="center">    
       
        <td width="60%" colspan="6" nobr="nobr" align="right"  $zz>Total</td>
        <th width="10%" align="center" $zz >' . sprintf("%.3f", $totht) . '</th>';
foreach ($tf as $y){//debug($y);die;
                        $tbl .='<th width="5%" align="center" $zz >' . sprintf("%.3f", $y['base']) . '</th> 
                        <th width="5%" align="center" $zz >' . sprintf("%.3f", $y['montant']) . '</th>';
}       
    $tbl .='</tr>
</table>';


$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('EtatFactureExonore.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>