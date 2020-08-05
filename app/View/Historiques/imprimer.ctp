<?php
//App::import('Vendor','tcpdf/tcpdf'); 
App::import('Vendor', 'xtcpdf');
$pdf = new XTCPDF();

/////////////////////////
// set document information
//debug($lignes);die;
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Paramed');
$pdf->SetTitle('bonreception');

// set default header data
//debug($boncommande['Client']['Raison_Social']);die;

$logo=  CakeSession::read('logo');
$pdf->SetHeaderData($logo, 60,'              Bon de reception');

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

$pdf->SetFont('times', 'A', 10);


$tbl .=' 
<table cellpadding="2" cellspacing="0" >
    <thead>
     <tr>
        <td height="35px" align="left"  width="25%"><strong>Numero : </strong></td> 
        <td align="left">'.$bonreception['Bonreception']['numero'].'</td>
        <td height="35px" align="left"  width="25%"><strong>Fournisseur : </strong></td> 
        <td align="left">'.$bonreception['Fournisseur']['name'].'</td>
  
    </tr> 
     
     <tr>
        <td height="35px" align="left" width="20%"><strong>Date : </strong></td>
        <td align="left">'.date("d/m/Y",strtotime(str_replace('-','/',($bonreception['Bonreception']['date'])))).'</td>
     </tr>
    
    <tr>
        <td height="35px"></td>
    </tr>
    <tr>
         <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%"><strong>Article</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%"><strong>Date de fabrication</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%"><strong>Date de validité</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="6%"><strong>N° de lot</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="6%"><strong>Qte</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%"><strong>Prix unitaire</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="7%"><strong>Remise</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="7%"><strong>Fodec</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="5%"><strong>TVA</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="14%"><strong>Total HT</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="15%"><strong>Total TTC</strong></td>
       
          </tr>
    </thead>';

$long="670";
          $n=0;
                     foreach ($lignereceptions as $i=>$lr){
                                       
                       if ($lr['Lignereception']['datefabrication']){  $datefabrication=date("d/m/Y",strtotime(str_replace('-','/',$lr['Lignereception']['datefabrication'])));}
                       if ($lr['Lignereception']['datevalidite']){   $datevalidite=date("d/m/Y",strtotime(str_replace('-','/',$lr['Lignereception']['datevalidite'])));}
                                    
                                            $n=$n+30;    

              $long=$long-10;
$tbl .='
    
     <tr> 
        <td align="center" style="border-bottom:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%" >&nbsp;<br>'. $lr['Article']['name'].'</td>
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="10%">&nbsp;<br>'.@$datefabrication.'</td>   
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="10%">&nbsp;<br>'.@$datevalidite.'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="6%">&nbsp;<br>'.$lr['Lignereception']['numerolot'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="6%">&nbsp;<br>'.$lr['Lignereception']['quantite'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="10%">&nbsp;<br>'.$lr['Lignereception']['prixhtva'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="7%">&nbsp;<br>'.$lr['Lignereception']['remise'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="7%">&nbsp;<br>'.$lr['Lignereception']['fodec'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="5%">&nbsp;<br>'.$lr['Lignereception']['tva'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="14%">&nbsp;<br>'.$lr['Lignereception']['totalht'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="15%">&nbsp;<br>'.$lr['Lignereception']['totalttc'].'</td>  
        
</tr>
    
';
                            
} $hauteur=500-$n;

    $tbl .='
   <tr>
 
<td align="center" style="border-bottom:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="30%" >&nbsp;<br></td>
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="22%">&nbsp;<br></td>   
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="14%" height="'.$hauteur.'px">&nbsp;<br></td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="19%">&nbsp;<br></td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="15%">&nbsp;<br></td>  
       


     </tr>      
 <tr>
 
<td align="center" style="border-bottom:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="30%" >&nbsp;<br></td> 
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="22%"><strong>Total remise : </strong></td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="14%">'.$bonreception['Bonreception']['remise'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="19%"><strong>Total Fodec : </strong></td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="15%">'.$bonreception['Bonreception']['fodec'].'</td>  


     </tr> 
   <tr>
 
<td align="center" style="border-bottom:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="30%" >&nbsp;<br></td> 
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="22%"><strong>Total TVA : </strong></td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="14%">'.$bonreception['Bonreception']['tva'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="19%"><strong>Total HT : </strong></td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="15%">'.$bonreception['Bonreception']['totalht'].'</td>  


     </tr>    
      <tr>
 
<td align="center" style="border-bottom:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="52%" >&nbsp;<br></td> 
 
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="23%"><strong>Total TTC : </strong></td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="25%">'.$bonreception['Bonreception']['totalttc'].'</td>  


     </tr>    
   
</table>
        ';
    
    
           
$tbl .='</table>';

$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
//Close and output PDF document
ob_end_clean();
$pdf->Output('imprimer_view_bonreception', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>