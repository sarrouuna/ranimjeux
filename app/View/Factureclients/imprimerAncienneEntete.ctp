<?php
//App::import('Vendor','tcpdf/tcpdf'); 
App::import('Vendor', 'xtcpdf');
$pdf = new XTCPDF();

/////////////////////////
// set document information
//debug($lignes);die;
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Paramed');
$pdf->SetTitle('factureclient');

// set default header data
//debug($boncommande['Client']['Raison_Social']);die;

$logo=  CakeSession::read('logo');
$pdf->SetHeaderData($logo, 60,'              Facture Client');

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
        <td align="left">'.$factureclient['Factureclient']['numero'].'</td>
        <td height="35px" align="left"  width="25%"><strong>Client : </strong></td> 
        <td align="left">'.$factureclient['Client']['name'].'</td>
  
    </tr> 
     
     <tr>
        <td height="35px" align="left" width="25%"><strong>Date : </strong></td>
        <td align="left">'.date("d/m/Y",strtotime(str_replace('-','/',($factureclient['Factureclient']['date'])))).'</td>
     </tr>
    
    <tr>
        <td height="35px"></td>
    </tr>
    <tr>         
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="14%"><strong>Depot</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="20%"><strong>Article</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="7%"><strong>Qte</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="11%"><strong>Prix unitaire</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="7%"><strong>Remise</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="7%"><strong>Fodec</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="5%"><strong>TVA</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="14%"><strong>Total HT</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="15%"><strong>Total TTC</strong></td>
       
          </tr>
    </thead>';

$long="670";
          $n=0;
                                                        foreach ($lignefactureclients as $i=>$lr){
                                            $n=$n+30;    

              $long=$long-10;
$tbl .='
    
     <tr> 
        <td align="center" style="border-bottom:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="14%" >&nbsp;<br>'. $lr['Depot']['designation'].'</td>
        <td align="center" style="border-bottom:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="20%" >&nbsp;<br>'. $lr['Article']['name'].'</td>
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="7%">&nbsp;<br>'.$lr['Lignefactureclient']['quantite'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="11%">&nbsp;<br>'.$lr['Lignefactureclient']['prix'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="7%">&nbsp;<br>'.$lr['Lignefactureclient']['remise'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="7%">&nbsp;<br>'.$lr['Lignefactureclient']['fodec'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="5%">&nbsp;<br>'.$lr['Lignefactureclient']['tva'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="14%">&nbsp;<br>'.$lr['Lignefactureclient']['totalht'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="15%">&nbsp;<br>'.$lr['Lignefactureclient']['totalttc'].'</td>  
        
</tr>
    
';
                            
} $hauteur=500-$n;

    $tbl .='
   <tr>
 
<td align="center" style="border-bottom:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="34%" >&nbsp;<br></td>
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="18%">&nbsp;<br></td>   
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="14%" height="'.$hauteur.'px">&nbsp;<br></td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="19%">&nbsp;<br></td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="15%">&nbsp;<br></td>  
       


     </tr>      
 <tr>
 
<td align="center" style="border-bottom:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="34%" >&nbsp;<br></td> 
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="18%"><strong>Total remise : </strong></td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="14%">'.$factureclient['Factureclient']['remise'].'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="19%"><strong>Total Fodec : </strong></td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="15%">'.$factureclient['Factureclient']['fodec'].'</td>  


     </tr> 
   <tr>
 
<td align="center" style="border-bottom:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="34%" >&nbsp;<br></td> 
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="18%"><strong>Total TVA : </strong></td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="14%">'.$factureclient['Factureclient']['tva'].'</td>  
       <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="19%"><strong>Timbre : </strong></td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="15%">'.$factureclient['Timbre']['timbre'].'</td> 

     </tr>    
      <tr>
 
<td align="center" style="border-bottom:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="52%" >&nbsp;<br></td> 
       
        
 <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="23%"><strong>Total HT : </strong></td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="25%">'.$factureclient['Factureclient']['totalht'].'</td>  


     </tr>    
      <tr>
 
<td align="center" style="border-bottom:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="52%" >&nbsp;<br></td> 
 
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="23%"><strong>Total TTC : </strong></td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="25%">'.$factureclient['Factureclient']['totalttc'].'</td>  


     </tr>    
   
</table>
        ';
    
    
           
$tbl .='</table>';

$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
//Close and output PDF document
ob_end_clean();
$pdf->Output('imprimer_view_factureclient', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>