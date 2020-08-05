
<?php

App::import('Vendor', 'xtcpdf');
$pdf = new XTCPDF();
/////////////////////////
// set document information
//debug($lignes);die;
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Logistic Office');
$pdf->SetTitle('Articles');

// set default header data
//$date1 = explode('-', $date);
//$new_date = $date1[2] . '/' . $date1[1] . '/' . $date1[0];
$ent='entete.jpg'; 
$m='';
if($familleid!=""){
$m=' de la famille '.$familleid;
}

$ModelSociete = ClassRegistry::init('Societe');
$soc = $ModelSociete->find('first',array('conditions'=>array('Societe.mere'=>1)));

//$logo=  CakeSession::read('logo');
$logo='';
$pdf->SetHeaderData($logo, '60', '          Liste des Articles '.$m);
//$pdf->SetHeaderData('entete.jpg', 60);
$footer = 'Kinda';
//$footer1 = 'Fax: ' . $soc['Societe']['Fax'] . ' E-mail: ' . $soc['Societe']['Mail'] . ' ' . $soc['Societe']['Site'] . 'R.C: ' . $soc['Societe']['RC'] . '-Code T.V.A: ' . $soc['Societe']['Code_TVA'];

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
// set font
$pdf->SetFont('times', 'B', 10);

// add a page
//$pdf->SetFont('dejavusans', '', 12);
$pdf->AddPage('P');

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

//$pdf->SetFont('times', 'A', 11);
        

        
        
// --------------------------------------------------------------------------
$zz='style="font-family:Arial, Helvetica, sans-serif;font-size:13px; border-top:2px solid black;border-left:2px solid black;border-right:2px solid black;"';
$tbl = '
   
 <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                    <tr bgcolor="#FFFFFF" align="center">
                        <th width="10%" align="center" $zz height="30px" ><strong>Code</strong></th>
                        <th width="12%" align="center" $zz ><strong>Désignation</strong></th>
                        <th width="10%" align="center" $zz ><strong>Famille</strong></th>
                        <th width="10%" align="center" $zz ><strong>Sous famille</strong></th>
                        <th width="10%" align="center" $zz ><strong>Sou sous famille</strong></th>
                        <th width="10%" align="center" $zz ><strong>Unités</strong></th>
                        <th width="10%" align="center" $zz ><strong>Stock alert</strong></th> 
                        <th width="10%" align="center" $zz ><strong>Prix d\'achat</strong></th>
                        <th width="10%" align="center" $zz ><strong>Prix de vente</strong></th>
                        <th width="8%" align="center" $zz ><strong>TVA</strong></th>
                              
                   </tr>';
        $i=0;$total=0;
       // debug($commfournisseurs);die;
       foreach ($articles as $br){
           
            $i++;
            if($i==15){
                $tbl .='</table>';
                $pdf->writeHTML($tbl, true, false, false, false, '');
                $pdf->AddPage('P');
                $i=0;
                $tbl='
                    <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                   <tr bgcolor="#FFFFFF" align="center">
                        <th width="10%" align="center" $zz height="30px" ><strong>Code</strong></th>
                        <th width="12%" align="center" $zz ><strong>Désignation</strong></th>
                        <th width="10%" align="center" $zz ><strong>Famille</strong></th>
                        <th width="10%" align="center" $zz ><strong>Sous famille</strong></th>
                        <th width="10%" align="center" $zz ><strong>Sou sous famille</strong></th>
                        <th width="10%" align="center" $zz ><strong>Unités</strong></th>
                        <th width="10%" align="center" $zz ><strong>Stock alert</strong></th> 
                        <th width="10%" align="center" $zz ><strong>Prix d\'achat</strong></th>
                        <th width="10%" align="center" $zz ><strong>Prix de vente</strong></th>
                        <th width="8%" align="center" $zz ><strong>TVA</strong></th>
                              
                   </tr>';
            }
            
          
               
        $tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="10%" nobr="nobr" align="center" height="30px" $zz>'.$br['Article']['code'].'</td>
        <td width="12%" nobr="nobr" align="center" height="30px" $zz>'.$br['Article']['name'].'</td>
        <td width="10%" nobr="nobr" align="center"  $zz>'.$br['Famille']['name'].'</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.$br['Sousfamille']['name'].'</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.$br['Soussousfamille']['name'].'</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.$br['Unite']['name'].'</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.$br['Article']['stockalert'].'</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.$br['Article']['prixachat'].'</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.$br['Article']['prixvente'].'</td>
        <td width="8%" nobr="nobr" align="right"  $zz>'.$br['Article']['tva'].'</td>
    </tr>' ;     
}

$tbl .= '
  
</table>';
    

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('bon_reception.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>