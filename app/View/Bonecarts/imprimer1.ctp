<?php
//App::import('Vendor','tcpdf/tcpdf'); 
App::import('Vendor', 'xtcpdf');
$pdf = new XTCPDF();

/////////////////////////
// set document information
//debug($lignes);die;
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Paramed');
$pdf->SetTitle('inventaire');

// set default header data
//debug($boncommande['Client']['Raison_Social']);die;
$logo=  CakeSession::read('logo');

$pdf->SetHeaderData($logo, 60,' Bon d\'écart sur l\'inventaire Numero : '.$bon[0]['Inventaire']['numero']);

$html = "<p>Hello world</p>";
$pdf->writeHTML($html);

//$pdf->SetHeaderData('entete.jpg', 60);


$aaa = "Paramed";
$pdf->xfootertext =$aaa;
//$pdf->xfootertext1 = $footer1;
//$pdf->xfootertext2 = $footer2;

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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

$pdf->AddPage();

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 9);


$tbl .=' 
<table cellpadding="2" cellspacing="0" >
   
     
      
    <tr>
        
              <td height="35px" align="center"  width="25%" ><strong>Depot  : </strong></td> 
        <td align="left" width="25%">'.$bon[0]['Depot']['designation'].'</td>
             <td height="35px" align="center" width="25%"><strong>Date : </strong></td>
        <td align="left" width="25%">'.date("d/m/Y",strtotime(str_replace('-','/',($bon[0]['Inventaire']['date'])))).'</td>
    </tr> 
    </table>
    <table width="100%" cellpadding="2" cellspacing="0" >
    <tr>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="50%"><strong>Article</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%"><strong>Qte anc</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%"><strong>Qte nv</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%"><strong>Quantite</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%"><strong>Prix</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%"><strong>Prix ToT</strong></td>
    </tr>
   ';

$long="670";
          
                                                        foreach ($bonecarts as $i=>$af){
                                               //debug($af);die;

              $long=$long-10;
$tbl .='
    
     <tr> 
        <td align="lfet" style="border-bottom:solid #000 0px;border-left:solid #000 0px;border-right:solid #000 0px;" width="50%" >&nbsp;<br>'.$af['Article']['nom'].'</td>
        <td align="center" style="border-bottom:solid #000 0px;border-right:solid #000 0px;" width="10%">&nbsp;<br>'.$af['Bonecart']['qteanc'].'</td> 
        <td align="center" style="border-bottom:solid #000 0px;border-right:solid #000 0px;" width="10%">&nbsp;<br>'.$af['Bonecart']['qtenv'].'</td>
        <td align="center" style="border-bottom:solid #000 0px;border-right:solid #000 0px;" width="10%">&nbsp;<br>'.$af['Bonecart']['quantite'].'</td>
        <td align="center" style="border-bottom:solid #000 0px;border-right:solid #000 0px;" width="10%">&nbsp;<br>'.$af['Bonecart']['prix'].'</td>
        <td align="center" style="border-bottom:solid #000 0px;border-right:solid #000 0px;" width="10%">&nbsp;<br>'.$af['Bonecart']['prixtot'].'</td>
    
</tr>
    
';
                            
}
  // debug($af);die;    

    $tbl .='
      
</table>
        ';
    
    
           
$tbl .='</table>';

$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
//Close and output PDF document
ob_end_clean();
$pdf->Output('imprimer_view_inventaire', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>