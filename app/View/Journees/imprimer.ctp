<?php

App::import('Vendor', 'xtcpdf');
$pdf = new XTCPDF();

class MYPDF extends TCPDF {
var $xheadertext  = 'PDF created using CakePHP and TCPDF'; 
    var $xheadercolor = array(0,0,200); 
    //var $xfootertext  = 'Copyright Â© %d XXXXXXXXXXX. <b>All rights reserved.</b>'; 
    var $xfooterfont  = PDF_FONT_NAME_MAIN ; 
    var $xfooterfontsize = 8 ;
    //Page header
    public function Header() {
        
    }

    // Page footer
   
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ranim');
$pdf->SetTitle('BC');

$ent = 'entete.jpg';
$footer = '            '  ;

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
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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
$pdf->SetFont('times', 'A', 9);

// add a page
//$pdf->SetFont('dejavusans', '', 12);
$pdf->AddPage('P');

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);
//$pdf->SetFont('times', 'A', 11);
// --------------------------------------------------------------------------

$cadre = 'style="font-family:Arial, Helvetica, sans-serif;font-size:20px; border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;padding: 5px;"';
$cadrei = 'style="font-family:Arial, Helvetica, sans-serif;font-size:12px; border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;padding: 2px;"';
$cadre2 = 'style="font-family:Arial, Helvetica, sans-serif;font-size:15px; border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;padding: 5px;"';
$cadre3 = 'style="font-family:Arial, Helvetica, sans-serif;font-size:10px; border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;padding: 5px;"';
$cadre4 = 'style="font-family:Arial, Helvetica, sans-serif;font-size:10px; border-right:1px solid black;border-left:1px solid black;padding: 5px;"';
$cadre5 = 'style=" padding: 8px;font-family:Arial, Helvetica, sans-serif;font-size:12px;"';
$cadre6 = 'style="font-family:Arial, Helvetica, sans-serif;font-size:13px; border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;padding: 5px;"';
$cadre7 = 'style="font-family:Arial, Helvetica, sans-serif;font-size:16px;  padding: 5px;"';
//debug($document);die;
//debug($soc);die;
//<tr><td align="left" colspan="6">'.$this->Html->image('logistiaue.png').'</td></tr>

 
$tbl.='';
$i=0;
              
             $tbl .='  
			  <br><br>
			   <table  align="left" width="100%" > 
                    <tr align="left" >
                        <td align="left" width="2%" style=" font-family:Arial, Helvetica, sans-serif;font-size:13px;"   ></td>
                        <td align="center" width="98%" style=" font-family:Arial, Helvetica, sans-serif;font-size:14px;"   ><strong>
						Historique Caisse</strong>
						<br><br><b> Journée : </b> '.$Journee['Journee']['date_debut'].'<br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; 
						 </td> 
                    </tr> 
                </table>
                <br><br>
               
			
               
                   ';  
				   
/*		<td align="left"><font color="#FF0000"><i> Total Caisse :'. $ticket[$per['Personnel']['id']][0][0]['Total_TTC'].'  DT</i></font></td>
*/		 
				 
 $k=0; $espt=0;
 $cht=0;
 $cartt=0;
 $tickrest=0;
 $Rest=0;
 foreach($personnels as $k=>$per)
{
	$total=0;

	$total+=$ticket[$per['Personnel']['id']][0][0]['Total_TTC'];
	$Rest+=$ticket[$per['Personnel']['id']][0][0]['Rest'];
	
	
	if($ticket[$per['Personnel']['id']][0][0]['Total_TTC']!='')
	{
 $tbl .='      <table      width="550"   style=" font-family:Arial, Helvetica, sans-serif;font-size:16px;  "  >  <tr>
 <td   align="left" width="200"> <font  color="#FF0000">'.$per['Personnel']['Name'].' : </font></td>
 </tr>
 </table>
 <br> <br>
    <table    	 border="1"   align="center"  style=" font-family:Arial, Helvetica, sans-serif;font-size:12px; "  width="100%"   > 
 
 ';
 /*  $tbl .='   <tr>
 <td>Numéro Ticket</td>
 <td>Date </td>
 <td>Total</td>
 <td>Mode</td>
 
 </tr>
 ';*/
 $esp=0;
 $ch=0;
 $cart=0;
 $tickres=0;
//debug($ticket); die;
   foreach($tickets[$per['Personnel']['id']] as $tt)
{
	 
 	 if($tt['Piecereglement']['paiement_id']==1)
	 
	 $esp+=($tt['Piecereglement']['Montant']);
	  if($tt['Piecereglement']['paiement_id']==2)
	 $ch+=$tt['Piecereglement']['Montant'];
	  if($tt['Piecereglement']['paiement_id']==14)
	 $cart+=$tt['Piecereglement']['Montant'];
	  if($tt['Piecereglement']['paiement_id']==15)
	 $tickres+=$tt['Piecereglement']['Montant'];
/*  $tbl .='   <tr>
 <td>'.$tt['Reglement']['Ticketcaiss'][0]['Numero'].'</td>
 <td>'.$tt['Reglement']['Date'].'</td>
 <td>'.$tt['Piecereglement']['Montant'].'</td>
 <td>'.$tt['Paiement']['name'].'</td>
 
 </tr>
 ';*/
   }
     $tbl .='
	 </table> ';
	
	   $tbl .='
	 <br><br>  
	 <table	 border="1" align="center"     style="font-family:Arial, Helvetica, sans-serif;font-size:14px; "  width="40%"  > 
	 <tr>
 <td align="left" >Total Espéce </td>
 <td align="right">'.sprintf('%.3f',$esp-$ticket[$per['Personnel']['id']][0][0]['Rest']).'</td>
  </tr>
	 <tr>
 <td align="left" >Total Chéque </td>
 <td align="right">'.sprintf('%.3f',$ch).'</td>
  </tr>
   <tr>
 <td align="left" >Total Carte </td>
 <td align="right">'.sprintf('%.3f',$cart).'</td>
  </tr>
   <tr>
 <td align="left">Total Ticket </td>
 <td align="right">'.sprintf('%.3f',$tickres).'</td>
  </tr>
   <tr>
 <td align="left">Total   </td>
 <td align="right"><font  color="#FF0000">'.sprintf('%.3f',$esp+$ch+$cart+$tickres-$ticket[$per['Personnel']['id']][0][0]['Rest']).'</font></td>
  </tr> 
         </table> <br><br>
			';
	 $espt+= $esp;
  $cht+=$ch;
 $cartt+=$cart;
 $tickrest+=$tickres;		
   }
            
	
}

 if($this->params['pass'][1]=='')
	 {
  $tbl .='
	 
	 <br><br> <font size="14px"> Total Caisse :</font> <br><br> 
	 <table	 border="1" align="center"     style="font-family:Arial, Helvetica, sans-serif;font-size:14px; "  width="40%"  > 
	 <tr>
 <td align="left" >Total Espéce </td>
 <td align="right">'.sprintf('%.3f',$espt-$Rest).'</td>
  </tr>
	 <tr>
 <td align="left" >Total Chéque </td>
 <td align="right">'.sprintf('%.3f',$cht).'</td>
  </tr>
   <tr>
 <td align="left" >Total Carte </td>
 <td align="right">'.sprintf('%.3f',$cartt).'</td>
  </tr>
   <tr>
 <td align="left">Total Ticket </td>
 <td align="right">'.sprintf('%.3f',$tickrest).'</td>
  </tr>
     
  
 
  <tr>
 <td align="left">Recette   </td>
 <td align="right"><font  color="#FF0000">'.sprintf('%.3f',$espt+$cht+$cartt+$tickrest-$Rest).'</font></td>
  </tr>   
           </table> <br><br>
			';      
   }



//
//foreach ($validateurs as $k => $validateur) {
//$tbl .=' <br><br><br>'.$personnels[$validateur].'<br>
//
//
//
//
//';
//}

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('journee.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>