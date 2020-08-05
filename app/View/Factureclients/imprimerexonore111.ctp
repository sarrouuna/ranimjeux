
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
if ($pvfacture != 0) {
    $pontdevente = ClassRegistry::init('Pointdevente')->find('first',array('conditions'=>array('Pointdevente.id'=>$pvfacture)));
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
$m='';
if ($date1 != "__/__/____" && $date1 != "1970-01-01" && $date2 != "__/__/____" && $date2 != "1970-01-01") {
    $date1 = date('d/m/Y', strtotime(str_replace('-', '/', $date1)));
    $date2 = date('d/m/Y', strtotime(str_replace('-', '/', $date2)));
    $m = ' du  ' . $date1 . ' au  ' . $date2;
}
// ---------------------------------------------------------

$pdf->AddPage('L');
$w = 26 / (count($tvas) * 2);

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 7);
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
                <td height="35px" align="left" ><h3>Liste des factures exonorée de la TVA ' . $m . '</h3></td>
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
                        <td width="3%" align="center" $zz ><strong>N°</strong></td>
                        <td width="5%" align="center" $zz ><strong>Date</strong></td>
                        <td width="7%" align="center" $zz ><strong>N° Fact</strong></td>
                        <td width="10%" align="center" $zz ><strong>Matricule_Fiscal</strong></td>
                        <td width="22%" align="center" $zz  ><strong>Nom/Raison</strong></td>

                        <td width="8%" align="center" $zz ><strong>Exonoration</strong></td>
                        <td width="5%" align="center" $zz ><strong>Montant HT</strong></td>';
foreach ($tvas as $t) { //debug($t);die;
    $tbl.='
    					<td width="' . $w . '%" align="center" $zz ><strong>Brut</strong></td>
                        <td width="' . $w . '%" align="center" $zz ><strong>TVA ' . intval(floatval($t['Tva']['name'])) . '%</strong></td>';
}
$tbl.='<td width="5%" align="center" $zz ><strong>Timbre</strong></td>
                <td width="5%" align="center" $zz ><strong>Montant TTC</strong></td>';


$tbl.='</tr>';
$i = 0;
$total = 0;
$tottimbre = 0;
$tottotalttc = 0;
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
    if ($i == 22) {
        $tbl .='</table>';
        $pdf->writeHTML($tbl, true, false, false, false, '');
        $pdf->AddPage('L');
        $i = 0;
        $tbl = '
                    <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">
                   <tr  bgcolor="#CCCCCC" align="center">
                       <td width="3%" align="center" $zz ><strong>N°</strong></td>
                        <td width="5%" align="center" $zz ><strong>Date</strong></td>
                        <td width="7%" align="center" $zz ><strong>N° Fact</strong></td>
                        <td width="10%" align="center" $zz ><strong>Matricule_Fiscal</strong></td>
                        <td width="22%" align="center" $zz  ><strong>Nom/Raison</strong></td>

                        <td width="8%" align="center" $zz ><strong>Exonoration</strong></td>
                        <td width="5%" align="center" $zz ><strong>Montant HT</strong></td>';
        foreach ($tvas as $t) { //debug($t);die;
            $tbl.='<td width="' . $w . '%" align="center" $zz ><strong>Base ' . intval(floatval($t['Tva']['name'])) . '%</strong></td>
                        <td width="' . $w . '%" align="center" $zz ><strong>TVA ' . intval(floatval($t['Tva']['name'])) . '%</strong></td>';
        }
            $tbl.='<td width="5%" align="center" $zz ><strong>Timbre</strong></td>
                <td width="5%" align="center" $zz ><strong>Montant TTC</strong></td>';

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
    //debug($tvas);
    if ($br['type'] == 'Facture client') {


            foreach ($tvas as $t) {
                $tv = intval(floatval($t['Tva']['name']));
                $fact = $objfact->find('all', array('fields' => array('SUM(Lignefactureclient.totalht) as mtva', 'Lignefactureclient.tva as taux'), 'conditions' => (array('Lignefactureclient.factureclient_id' => $br['id_piece'], 'Lignefactureclient.tva' => $tv)), 'recursive' => -1));
//debug($fact);
                if ($fact[0][0]['mtva'] != NULL ) {
                    $tvmnt = floatval($fact[0][0]['mtva']) * floatval($tv) / 100;
                    $listva[$p]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                    $listva[$p]['mtva'] = sprintf("%.3f", $tvmnt);
                    $listva[$p]['base'] = sprintf("%.3f", $fact[0][0]['mtva']);
                    $listva[$p]['tva'] = intval(floatval($t['Tva']['name']));
                    $p++;

                    $listvaall[$ccp]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                    $listvaall[$ccp]['mtva'] = sprintf("%.3f", $tvmnt);
                    $listvaall[$ccp]['base'] = sprintf("%.3f", $fact[0][0]['mtva']);
                    $listvaall[$ccp]['tva'] = intval(floatval($t['Tva']['name']));
                    $ccp++;

                    $type = 'a';
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
        } else {


            foreach ($tvas as $t) {
                $tv = intval(floatval($t['Tva']['name']));
                $lignefactavoir = $objfactavoir->find('all', array('fields' => array('SUM(Lignefactureavoir.totalht) as mtva', 'Lignefactureavoir.tva'), 'conditions' => (array('Lignefactureavoir.factureavoir_id' => $br['id_piece'], 'Lignefactureavoir.tva' => $tv)), 'recursive' => -1));

                if ($lignefactavoir[0][0]['mtva'] != NULL ) {

                    $tvmnt = floatval($lignefactavoir[0][0]['mtva']) * floatval($tv) / 100;
                    //debug($fact);//die;
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
        }

//    debug($listva);
//    debug($listvaall);
//    die;
    //debug($br);die;
    $totht = $totht + $br['totalht'];
    $tottimbre = $tottimbre + $br['timbre'];
    $tottotalttc = $tottotalttc + $br['totalttc'];
//    $totbase6 = $totbase6 + $base6;
//    $tottva6 = $tottva6 + $tva6;
//    $totbase12 = $totbase12 + $base12;
//    $tottva12 = $tottva12 + $tva12;
//    $totbase18 = $totbase18 + $base18;
//    $tottva18 = $tottva18 + $tva18;
    $tbl .=
            '<tr bgcolor="#FFFFFF" align="center">
        <td width="3%" align="center" heigth="30px" $zz >' . $i . '</td>
                        <td width="5%" align="center" $zz >' . date("Y-m-d", strtotime(str_replace('/', '-', $br['date']))) . '</td>
                        <td width="7%" align="center" $zz >' . $br['numero'] . '</td>
                        <td width="10%" align="left" $zz >' . $br['matriculefiscal'] . '</td>
                        <td width="22%" align="left" $zz  >' . $br['client'] . '</td>

                        <td width="8%" align="left" $zz >' . $br['num_exe'] . '</td>
                        <td width="5%" align="right" $zz >' . $br['totalht'] . '</td>';
                        //debug($listva);die;
                            foreach ($listva as $v) { //debug($v); die;

                                $tbl.='<td width="' . $w . '%" align="right" $zz >' . $v['base'] . '</td>
                                            <td width="' . $w . '%" align="right" $zz >' . $v['mtva'] . '</td>';
                            }
                        $tbl.='<td width="5%" align="right" $zz >' . $br['timbre'] . '</td>
                        <td width="5%" align="right" $zz >' . $br['totalttc'] . '</td>';


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
}//die;
//debug($listvaall);//die;
//$listvaall[3]['tva']=19;
//$listvaall[3]['mtva']=800;
//debug($listvaall);die;
$tf=array(); //debug($listvaall);die;
foreach ($listvaall as $l){
    if(!isset($tf[$l['tva']]['montant'])){
        $tf[$l['tva']]['montant']=0;
    }
    if(!isset($tf[$l['tva']]['base'])){
        $tf[$l['tva']]['base']=0;
    }
    $tf[$l['tva']]['montant']=$tf[$l['tva']]['montant']+$l['mtva'];
    $tf[$l['tva']]['base']=$tf[$l['tva']]['base']+$l['base'];
    $tf[$l['tva']]['nom']=$l['nom'];
}
//debug($tf);die;
$tbl .= '
   <tr  bgcolor="#CCCCCC" align="center">

        <td width="55%" colspan="6" nobr="nobr" align="right"  $zz>Total</td>
        <td width="5%" align="right" $zz >' . sprintf("%.3f", $totht) . '</td>';
foreach ($tf as $y){//debug($y);die;
                        $tbl .='<td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $y['base']) . '</td>
                        <td width="' . $w . '%" align="right" $zz >' . sprintf("%.3f", $y['montant']) . '</td>';
}
        $tbl.='<td width="5%" align="right" $zz >' . sprintf("%.3f", $tottimbre) . '</td>
                <td width="5%" align="right" $zz >' . sprintf("%.3f", $tottotalttc) . '</td>';


    $tbl .='</tr>
</table>';

//    debug($tbl);die;
$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('EtatFactureExonore.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
