
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
$pdf->SetAuthor('PARAMED');
$pdf->SetTitle('Facture Client');

$ent = 'entete.jpg';
$ModelSociete = ClassRegistry::init('Societe');
$soc = $ModelSociete->find('first', array('conditions' => array('Societe.mere' => 1)));

$footer = 'SARL au Capital de : ' . $soc['Societe']['capital'] . '                                Adresse : ' . $soc['Societe']['adresse'] . '                                 Code T.V.A: ' . $soc['Societe']['codetva']    ;
$footer1 = 'Site : ' . $soc['Societe']['site'] . '           E-mail: ' . $soc['Societe']['mail'] . '           Tel : ' . $soc['Societe']['tel'] . '             Fax : ' . $soc['Societe']['fax'].'                                                                   '.$pdf->getAliasNumPage().' / '.$pdf->getAliasNbPages();

$aaa = "abc";
$pdf->xfootertext = $footer;
$pdf->xfootertext1 = $footer1;
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
if (!empty($date1) && !empty($date2)) {
    $date1 = date('d/m/Y', strtotime(str_replace('-', '/', $date1)));
    $date2 = date('d/m/Y', strtotime(str_replace('-', '/', $date2)));
    $m = ' du  ' . $date1 . ' au  ' . $date2;
}
// ---------------------------------------------------------

$pdf->AddPage('L');

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 9);
$logo = CakeSession::read('logo');





$footer = 'Paramed';

//$aaa = "abc";
//$pdf->xfootertext = $footer;
//$pdf->xfootertext1 = '';
//$pdf->xfootertext2 = '';
//
//// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//
//// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//
//// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//
//// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//
//// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//
//// set some language-dependent strings (optional)
//if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
//    require_once(dirname(__FILE__) . '/lang/eng.php');
//    $pdf->setLanguageArray($l);
//}
//
//// ---------------------------------------------------------
//
//
//
////$pdf->SetFont('dejavusans', '', 12);
////$pdf->SetFont('times', 'B', 12);
//$pdf->SetFont('aealarabiya', '', 12);
////$pdf->SetFont('dejavusans', '', 12);
// $pdf->AddPage('L');   //  P  ou L 
//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);
//$pdf->SetFont('times', 'A', 11);
// --------------------------------------------------------------------------
//$dd='';
// debug($soldeinitial);die;
$tbl = '
 
<table width="100%">
<tr>
    <td width="45%" align="left" >
                        <IMG SRC="../webroot/img/' . $soc["Societe"]["logo"] . '" width="120"  >
                    </td>
    <td  width="55%">
        <table width="100%">
            <tr>
                <td height="35px" align="left" ><strong>Etat de solde Fournisseurs ' . @$m . '</strong></td>
            </tr>
        </table>
    </td>
</tr>
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

<table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" >       

<tr bgcolor="#EAEAEA" align="center">
        <th width="10%" align="center"  ><strong>Date</strong></th>
        <th width="12%" align="center"  ><strong>N° Piece</strong></th>
        <th width="18%" align="center"  ><strong>Libellé Piece</strong></th>
        <th width="10%" align="center"  ><strong>Dédit</strong></th>
        <th width="10%" align="center"  ><strong>Crédit</strong></th>
        <th width="10%" align="center"  ><strong>Impayé</strong></th>
        <th width="10%" align="center"  ><strong>Règlement</strong></th>
        <th width="10%" align="center"  ><strong>Avoir</strong></th>
        <th width="10%" align="center"  ><strong>Solde</strong></th>
    </tr>';



if (!empty($relefes)) {
    $totdebit = 0;
    $totcredit = 0;
    $totimpayer = 0;
    $totreg = 0;
    $totavoir = 0;
    $totsolde = 0;
    $totdebitt = 0;
    $totcreditt = 0;
    $totimpayert = 0;
    $totregt = 0;
    $totavoirt = 0;
    $totsoldet = 0;
    $clt_id = 0;
    //debug($relefes);
    $hh = 0;
    $c = 0;
    $t = 0;$sldtot=0;
    foreach ($relefes as $i => $relefe) {
        $totdebitt = $totdebitt + @$relefe['Recouvrement']['debit'];
        $totcreditt = $totcreditt + @$relefe['Recouvrement']['credit'];
        $totimpayert = $totimpayert + @$relefe['Recouvrement']['impaye'];
        $totregt = $totregt + @$relefe['Recouvrement']['reglement'];
        $totavoirt = $totavoirt + @$relefe['Recouvrement']['avoir'];
        $totsoldet = $totsoldet + @$relefe['Recouvrement']['solde'];
        $hh++;


        if ($relefe['Recouvrement']['fournisseur_id'] != $clt_id) {

            if ($i != 0) {

                $tbl .='
       <tr>
        <td colspan="3" bgcolor="#EAEAEA" align="center"><strong> Total  </strong></td>    
        <td  align="right"><strong>' . number_format(@$totdebit, 3, '.', ' ') . '</strong></td>
        <td  align="right"><strong>' . number_format(@$totcredit, 3, '.', ' ') . '</strong></td>
        <td  align="right"><strong>' . number_format(@$totimpayer, 3, '.', ' ') . '</strong></td>
        <td  align="right"><strong>' . number_format(@$totreg, 3, '.', ' ') . '</strong></td>
        <td  align="right"><strong>' . number_format(@$totavoir, 3, '.', ' ') . '</strong></td>
        <td  align="right"><strong>' . number_format(@$totsolde, 3, '.', ' ') . '</strong></td>
      </tr>';
                $totdebit = 0;
                $totcredit = 0;
                $totimpayer = 0;
                $totreg = 0;
                $totavoir = 0;
                $totsolde = 0;
            }
            $soldedeb = "";
            $soldecred = "";
            $sld = $soldeint;
            $soldecredd = 0;
            $soldedebb = 0;
            if ($soldeint > 0) {
                $soldedeb = $soldeint;
                $soldedebb = $soldeint;
            }
            if ($soldeint < 0) {
                $soldecredd = $soldeint;
                $soldecred = $soldeint * (-1);
            }
             $client_ans = ClassRegistry::init('Fournisseur')->find('first', array('conditions' => array('Fournisseur.id' =>$relefe['Recouvrement']['fournisseur_id']), 'recursive' => 0));
            $tbl .='<tr>
    <td bgcolor="#EAEAEA" align="center"><strong> Fournisseur </strong></td>    <td colspan="8" align="left" ><strong>&nbsp;&nbsp;&nbsp;&nbsp;' . @$client_ans['Fournisseur']['code']  . '  ' . @$client_ans['Fournisseur']['name']  . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TEL '.@$client_ans['Fournisseur']['tel'] .'</strong></td>
</tr>
<tr>
    <td bgcolor="#EAEAEA" width="40%" align="right" colspan="3"> Solde départ</td> 
       
        <td width="10%" nobr="nobr" align="right"   ><strong>' . number_format(@$soldedeb, 3, '.', ' ') . '</strong></td>
        <td width="10%" nobr="nobr" align="right"   ><strong>' . number_format(@$soldecred, 3, '.', ' ') . '</strong></td>
        <td width="10%" nobr="nobr" align="right"  ></td>
        <td width="10%" nobr="nobr" align="right"  ></td> 
        <td width="10%" nobr="nobr" align="right"  ></td> 
        <td width="10%" nobr="nobr" align="right"  ><strong>' . number_format(@$soldeint, 3, '.', ' ') . '</strong></td> 
</tr>';
        }
        $clt_id = $relefe['Recouvrement']['fournisseur_id'];
//   if($relefe['Recouvrement']['debit']!=null) {
//           // debug("debit");die;
//         $sld=$sld+$relefe['Recouvrement']['debit']-@$relefe['Recouvrement']['reglement'];
//        }   else{
//            // debug("credit");die;
//             $sld=$sld-$relefe['Recouvrement']['credit'];
//        }

        if ($relefe['Recouvrement']['debit'] != null) {
            // debug("debit");die;
            if ($relefe['Recouvrement']['typ'] == "imp") {
                $sld = $sld + ($relefe['Recouvrement']['debit'] - $relefe['Recouvrement']['impaye']);
            } else {
                $sld = $sld + ($relefe['Recouvrement']['debit'] - $relefe['Recouvrement']['reglement']);
            }
        } else {
            // debug("credit");die;
            $sld = $sld - ($relefe['Recouvrement']['credit'] - $relefe['Recouvrement']['reglement']);
        }
        
        if ($relefe['Recouvrement']['debit'] != null) {
            // debug("debit");die;
            if ($relefe['Recouvrement']['typ'] == "imp") {
                $sldtot = $sldtot + ($relefe['Recouvrement']['debit'] - $relefe['Recouvrement']['impaye']);
            } else {
                $sldtot = $sldtot + ($relefe['Recouvrement']['debit'] - $relefe['Recouvrement']['reglement']);
            }
        } else {
            // debug("credit");die;
            $sldtot = $sldtot - ($relefe['Recouvrement']['credit'] - $relefe['Recouvrement']['reglement']);
        }

        if ((!empty($relefe['Recouvrement']['debit'])) && ($relefe['Recouvrement']['debit'] != 0)) {
            $ldebit = number_format(@$relefe['Recouvrement']['debit'], 3, '.', ' ');
        } else {
            $ldebit = "";
        }
        if ((!empty($relefe['Recouvrement']['credit'])) && ($relefe['Recouvrement']['credit'] != 0)) {
            $lcredit = number_format(@$relefe['Recouvrement']['credit'], 3, '.', ' ');
        } else {
            $lcredit = "";
        }
        if ((!empty($relefe['Recouvrement']['impaye'])) && ($relefe['Recouvrement']['impaye'] != 0)) {
            $limpaye = number_format(@$relefe['Recouvrement']['impaye'], 3, '.', ' ');
        } else {
            $limpaye = "";
        }
        if ((!empty($relefe['Recouvrement']['reglement'])) && ($relefe['Recouvrement']['reglement'] != 0)) {
            $lreglement = number_format(@$relefe['Recouvrement']['reglement'], 3, '.', ' ');
        } else {
            $lreglement = "";
        }
        if ((!empty($relefe['Recouvrement']['avoir'])) && ($relefe['Recouvrement']['avoir'] != 0)) {
            $lavoir = number_format(@$relefe['Recouvrement']['avoir'], 3, '.', ' ');
        } else {
            $lavoir = "";
        }
        if ((!empty($relefe['Recouvrement']['solde'])) && ($relefe['Recouvrement']['solde'] != 0)) {
            $lsolde = number_format(@$relefe['Recouvrement']['solde'], 3, '.', ' ');
        } else {
            $lsolde = "";
        }




        $tbl .=
                '<tr  align="center">    
        <td width="10%" nobr="nobr" align="center"  ><strong>' . date("d/m/Y", strtotime(str_replace('/', '-', @$relefe['Recouvrement']['date']))) . '</strong></td>
        <td width="12%" nobr="nobr" align="center"   >' . @$relefe['Recouvrement']['numero'] . '</td>
        <td width="18%" nobr="nobr" align="left"   >' . @$relefe['Recouvrement']['type'] . '</td>    
        <td width="10%" nobr="nobr" align="right"   >' . $ldebit . '</td>
        <td width="10%" nobr="nobr" align="right"   >' . $lcredit . '</td>
        <td width="10%" nobr="nobr" align="right"  >' . $limpaye . '</td>
        <td width="10%" nobr="nobr" align="right"  >' . $lreglement . '</td> 
        <td width="10%" nobr="nobr" align="right"  >' . $lavoir . '</td> 
        <td width="10%" nobr="nobr" align="right"  >' . $lsolde . '</td> 
    </tr>';


        $totdebit = $totdebit + @$relefe['Recouvrement']['debit'];
        $totcredit = $totcredit + @$relefe['Recouvrement']['credit'];
        $totimpayer = $totimpayer + @$relefe['Recouvrement']['impaye'];
        $totreg = $totreg + @$relefe['Recouvrement']['reglement'];
        $totavoir = $totavoir + @$relefe['Recouvrement']['avoir'];
        $totsolde = $totsolde + @$relefe['Recouvrement']['solde'];
    }
}
$tbl .=
        ' 
           <tr bgcolor="#EAEAEA" align="center">  
                <td colspan="3" align="center" width="40%"   ><strong>Total </strong></td>
                <td  align="right" width="10%"><strong>' . number_format(($totdebit + $soldedebb), 3, '.', ' ') . '</strong></td>
                <td  align="right" width="10%"><strong>' . number_format(($totcredit + $soldecredd), 3, '.', ' ') . '</strong></td>     
                <td  align="right" width="10%"><strong>' . number_format($totimpayer, 3, '.', ' ') . '</strong></td>
                <td  align="right" width="10%"><strong>' . number_format($totreg, 3, '.', ' ') . '</strong></td>
                <td  align="right" width="10%"><strong>' . number_format($totavoir, 3, '.', ' ') . '</strong></td>
                <td  align="right" width="10%"><strong>' . number_format($sld, 3, '.', ' ') . '</strong></td>
           </tr>
            <tr bgcolor="#EAEAEA" align="center">  
                <td colspan="3" align="center" width="40%"   ><strong>Total Générale</strong></td>
                <td  align="right" width="10%"><strong>' . number_format(($totdebitt + $soldedebb), 3, '.', ' ') . '</strong></td>
                <td  align="right" width="10%"><strong>' . number_format(($totcreditt + $soldecredd), 3, '.', ' ') . '</strong></td>     
                <td  align="right" width="10%"><strong>' . number_format(($totimpayert), 3, '.', ' ') . '</strong></td>
                <td  align="right" width="10%"><strong>' . number_format(($totregt), 3, '.', ' ') . '</strong></td>
                <td  align="right" width="10%"><strong>' . number_format(($totavoirt), 3, '.', ' ') . '</strong></td>
                <td  align="right" width="10%"><strong>' . number_format(($sldtot), 3, '.', ' ') . '</strong></td>
           </tr>
           ';

$tbl .=
        ' 
</table> <br><br>
';




$tbl .='
</table>            
';


$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('releve_client.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>