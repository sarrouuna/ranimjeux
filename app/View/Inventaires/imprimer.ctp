<?php

App::import('Vendor', 'xtcpdf');
$pdf = new XTCPDF();

class MYPDF extends TCPDF {

    var $xheadertext = 'PDF created using CakePHP and TCPDF';
    var $xheadercolor = array(0, 0, 200);
    //var $xfootertext  = 'Copyright Ãƒâ€šÃ‚Â© %d XXXXXXXXXXX. <b>All rights reserved.</b>'; 
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
$pdf->SetTitle('Inventaire ');
$ent = 'entete.jpg';
$ModelSociete = ClassRegistry::init('Societe');
$soc = $ModelSociete->find('first');

$footer = 'SARL au Capital de : ' . $soc['Societe']['capital'] . '      Adresse : ' . $soc['Societe']['adresse'] . '     Code T.V.A: ' . $soc['Societe']['codetva'] . '   RIB: ' . $soc['Societe']['rib']      ;
$footer1 = 'Site : ' . $soc['Societe']['site'] . '      E-mail: ' . $soc['Societe']['mail'] . '     Tel : ' . $soc['Societe']['tel'] . '     Fax : ' . $soc['Societe']['fax'].'                                '.$pdf->getAliasNumPage().' / '.$pdf->getAliasNbPages();    

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

// ---------------------------------------------------------
$styl_cadr_bottom = 'style="border:2px solid black"';
$pdf->AddPage();

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 9);




$tbl .= ' 
    
<table>
    <tr>
        <td width="45%" align="left" >
             <IMG SRC="../webroot/img/'.$soc["Societe"]["logo"].'" width="110">
        </td>
         <td width="55%" align="left" >            Inventaire Finale
         </td>
    </tr>
</table>

<table cellpadding="2" cellspacing="0" >
   
     
      
    <tr>
        <td height="35px" align="left"  width="12%"><strong>Numero : </strong></td> 
        <td align="left" width="13%">' . $inventaire['Inventaire']['numero'] . '</td>
              <td height="35px" align="center"  width="10%" ><strong>Depot  : </strong></td> 
        <td align="left" width="30%">' . $inventaire['Depot']['designation'] . '</td>
             <td height="35px" align="left" width="10%"><strong>Date : </strong></td>
        <td align="left" width="15%">' . date("d/m/Y", strtotime(str_replace('-', '/', ($inventaire['Inventaire']['date'])))) . '</td>
    </tr> 
    </table>
    <table width="100%" cellpadding="2" cellspacing="0" ' . $styl_cadr_bottom . ' >
    <tr>
        <td align="center"' . $styl_cadr_bottom . ' style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="70%"><strong>Article</strong></td>
        <td align="center"' . $styl_cadr_bottom . ' style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%"><strong>Quantite</strong></td>
        <td align="center"' . $styl_cadr_bottom . ' style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%"><strong>Valeur</strong></td>
        <td align="center"' . $styl_cadr_bottom . ' style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%"><strong>ToT Valeur</strong></td>
</tr>
   ';
$tot=0;
$long = "670";
$date = $ligneinvents[0]['Inventaire']['date'];
$id = $ligneinvents[0]['Inventaire']['id'];
//debug($date);die;
foreach ($ligneinvents as $i => $af) {




    if ($af['Ligneinventaire']['qte_invpar'] == NULL) {
        $qte = $af['Ligneinventaire']['quantite']; 
    }else{
        $qte = $af['Ligneinventaire']['qte_invpar']; 
    }
    $tot+=$qte*$af['Ligneinventaire']['coutderevien'];
    
    
    $long = $long - 10;
    $tbl .= '        
    
     <tr> 
        <td align="lfet" ' . $styl_cadr_bottom . ' style="border-bottom:solid #000 0px;border-left:solid #000 0px;border-right:solid #000 0px;" width="70%" >&nbsp;' . @$af['Ligneinventaire']['code'] . " " . @$af['Ligneinventaire']['designation'] . '</td>
        <td align="center" ' . $styl_cadr_bottom . 'style="border-bottom:solid #000 0px;border-right:solid #000 0px;" width="10%">&nbsp;' . @$qte . '</td>   
        <td align="right" ' . $styl_cadr_bottom . 'style="border-bottom:solid #000 0px;border-right:solid #000 0px;" width="10%">&nbsp;' . @$af['Ligneinventaire']['coutderevien'] . '</td> 
        <td align="right" ' . $styl_cadr_bottom . 'style="border-bottom:solid #000 0px;border-right:solid #000 0px;" width="10%">&nbsp;' . number_format(@$qte*@$af['Ligneinventaire']['coutderevien'],3, '.', ' '). '</td> 
</tr>
    
';
}
// debug($af);die;    

$tbl .= '<tr>
    <td colspan="3" align="center" ' . $styl_cadr_bottom . 'style="border-bottom:solid #000 0px;border-right:solid #000 0px;">Total</td>
    <td align="right" ' . $styl_cadr_bottom . 'style="border-bottom:solid #000 0px;border-right:solid #000 0px;">'. number_format(@$tot,3, '.', ' ').'</td> 
        </tr>
</table>
        ';





$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
//Close and output PDF document
ob_end_clean();
$pdf->Output('imprimer_view_inventaire', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>