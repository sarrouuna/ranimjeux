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
$pdf->SetTitle('Article');

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
  $total=0;
 foreach($Famillearticles as $k=>$per)
{
	 
	if(!empty($ligne[$per['Famillearticle']['id']])) 
	{
 $tbl .='    <br>  <table      width="550"   style=" font-family:Arial, Helvetica, sans-serif;font-size:16px;  "  >  <tr>
 <td   align="left" width="200" valign="middle"> <font  color="#FF0000">'.$per['Famillearticle']['Designation'].' : </font></td>
 </tr>
 </table>
 <br> <br>
    <table    	 border="1"   align="center"  style=" font-family:Arial, Helvetica, sans-serif;font-size:12px; "  width="100%"   > 
 
 ';
   $tbl .='   <tr>
 <td width="275px">Article</td>
 <td>qte </td>
 <td width="75px">Prix Achat </td>
 <td width="75px">Prix Vente </td>
 <td width="75px">Marge </td>
 <td width="75px">Total </td>
 
 </tr>
 ';
 $totalfamille=0;
// debug($ligne[$per['Famillearticle']['id']]); die;
   foreach($ligne[$per['Famillearticle']['id']] as $tt)
{
 	 $obj = ClassRegistry::init('Article'); 
                $insmoi = $obj->find('all',array(
                    'conditions'=>array('Article.id'=>$tt['Ticketcaisseligne']['article_id'] )  ,'recursive'=>-1));
					
  $totalfamille=$totalfamille+($insmoi[0]['Article']['Marge']*($insmoi[0]['Article']['prix_ttc']*$tt['Ticketcaisseligne']['qte'])/100);

				//debug($insmoi); die;	
					
  $tbl .='   <tr >
 <td align="left" width="275px">'.$insmoi[0]['Article']['Designation'].'</td>
 <td>'.$tt['Ticketcaisseligne']['qte'].'</td>
 <td width="75px">'.$insmoi[0]['Article']['prix_achat_ttc'].'</td>
 <td width="75px">'.$insmoi[0]['Article']['prix_ttc'].'</td>
 <td width="75px">'.$insmoi[0]['Article']['Marge'].'</td>
 <td width="75px">'.sprintf('%.3f',$insmoi[0]['Article']['Marge']*($insmoi[0]['Article']['prix_ttc']*$tt['Ticketcaisseligne']['qte'])/100).'</td>
    

 </tr>
 ';
   }
     $tbl .='  <tr >
 <td align="right"   colspan="5"><font  color="#FF0000">Bénéfice Par Famille</font> </td>
 
 <td width="75px"><font  color="#FF0000">'.sprintf('%.3f',$totalfamille).'</font></td>
    

 </tr>
	 </table> ';
	
 	
   }
         $total+=$totalfamille;    
}

  $tbl .=' <br><br><table> <tr >
 <td align="right"   colspan="5"><font  color="#FF0000"><b>Total Bénéfice</b></font> </td>
 
 <td width="75px"><font  color="#FF0000" size=3><b>'.sprintf('%.3f',$total).'</b></font></td>
    

 </tr>
	 </table> ';


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