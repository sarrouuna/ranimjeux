
<?php

App::import('Vendor', 'xtcpdf');
$pdf = new XTCPDF();

class MYPDF extends TCPDF {
var $xheadertext  = 'PDF created using CakePHP and TCPDF'; 
    var $xheadercolor = array(0,0,200); 
    //var $xfootertext  = 'Copyright Ã‚Â© %d XXXXXXXXXXX. <b>All rights reserved.</b>'; 
    var $xfooterfont  = PDF_FONT_NAME_MAIN ; 
    var $xfooterfontsize = 8 ;
    //Page header
    public function Header() {
        
    }

    // Page footer
    public function Footer() {
        $year = date('Y'); 
        $footertext = sprintf($this->xfootertext, $year); 
        $this->SetY(-20); 
        $this->SetTextColor(0, 0, 0); 
        $this->SetFont($this->xfooterfont,'',$this->xfooterfontsize);  
         $footertext1 = sprintf($this->xfootertext1, $year); 
        $this->SetY(-20); 
        $this->SetTextColor(0, 0, 0); 
        $this->SetFont($this->xfooterfont,'',$this->xfooterfontsize); 
         $footertext2 = sprintf($this->xfootertext2, $year); 
        $this->SetY(-20); 
        $this->SetTextColor(0, 0, 0); 
        $this->SetFont($this->xfooterfont,'',$this->xfooterfontsize); 
        $this->Cell(0,8, $footertext,'T',1,'L'); 
        $this->Cell(0,1, $footertext1,0,1,'L'); 
        $this->Cell(0,3, $footertext2,0,1,'L'); 
    }
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PARAMED');
$pdf->SetTitle('Facture Client');

$ent = 'entete.jpg';
$ModelSociete = ClassRegistry::init('Societe');
$soc = $ModelSociete->find('first',array('conditions'=>array('Societe.mere'=>1)));
$footer = '            SARL au Capital de:   ' . $soc['Societe']['capital'] . '           E-mail: ' . $soc['Societe']['mail'] . '           Code T.V.A: ' . $soc['Societe']['codetva'] . '             RIB: ' . $soc['Societe']['rib'];

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
if(@$date1!="" && @$date2!=""){
$date1=date('d/m/Y', strtotime(str_replace('-', '/',@$date1)));
$date2=date('d/m/Y', strtotime(str_replace('-', '/',@$date2)));
$m.=' du  '.@$date1.' au  '.@$date2;
}
if(@$familleid!=""){
    $m.=' de famille '.@$familleid;
}
if(@$articleid!=""){
    $m.=' d\'article '.@$articleid;
}
if($fournisseurid!=""){
    $m.=' de fournisseur '.$fournisseurid;
}
if($clientid!=""){
    $m.=' de client '.$clientid;
}
if($personnelid!=""){
    $m.=' d\' agent '.$personnelid;
}
if($pointdeventeid!=""){
    $m.=' de point de vente '.$pointdeventeid;
}

// ---------------------------------------------------------

$pdf->AddPage("L");

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 9);
$logo=  CakeSession::read('logo');

$tbl .=' 

<table width="100%">
<tr>
    <td width="45%" align="left" >
    <IMG SRC="../webroot/img/'.$soc["Societe"]["logo"].'" width="110"  >
</td>
    <td  width="55%">
        <table width="100%">
            <tr>
            <br> 
                <td height="35px" align="left" ><strong>  '.$m.'</strong></td> 
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
<br><br><br>';

$tbl.='<table border="1">
        
        <tr style="background-color:#a49fbf">
	         
                <th width="48%" align="center" colspan="3" height="30px"><center><strong> Article</strong></center></th>
		<th width="8%" align="center"><center><strong>Achat</strong></center></th>
                <th width="22%" align="center" colspan="3"><center><strong>Vente HT</strong></center></th>
                <th width="22%" align="center" colspan="3"><center><strong>Vente TTC</strong></center></th>
        </tr>                  
	<tr style="background-color:#a49fbf">
                <th width="10%" align="center" height="30px"><center>Code</center></th>
		<th width="33%" align="center"><center>Designation</center></th>
		<th width="5%" align="center"><center>Qte V</center></th>
		<th width="8%" align="center"><center>T Achat</center></th>
		<th width="8%" align="center"><center>V HT</center></th>
		<th width="8%" align="center"><center>B HT</center></th>
		<th width="6%" align="center"><center>T HT</center></th>
                <th width="8%" align="center"><center>V TTC</center></th>
		<th width="8%" align="center"><center>B TTC</center></th>
		<th width="6%" align="center"><center>T TTC</center></th>
        </tr>';
            

           $i=0;
        $total_ht=0;
        $total_ttc=0;
        $total_achat=0;
        foreach ($etatbenefices as $k=>$etatbenefice): 
               if(($i==13 && $k==13) || $i==18){
                $tbl .='</table>';
                $tbl .='  <br pagebreak="true"/>';
                $i=0;
          $tbl.='<table border="1">
        
        <tr style="background-color:#a49fbf">
	         
                <th width="48%" align="center" colspan="3" height="30px"><center><strong> Article</strong></center></th>
		<th width="8%" align="center"><center><strong>Achat</strong></center></th>
                <th width="22%" align="center" colspan="3"><center><strong>Vente HT</strong></center></th>
                <th width="22%" align="center" colspan="3"><center><strong>Vente TTC</strong></center></th>
        </tr>                  
	<tr style="background-color:#a49fbf">
                <th width="10%" align="center" height="30px"><center>Code</center></th>
		<th width="33%" align="center"><center>Designation</center></th>
		<th width="5%" align="center"><center>Qte V</center></th>
		<th width="8%" align="center"><center>T Achat</center></th>
		<th width="8%" align="center"><center>V HT</center></th>
		<th width="8%" align="center"><center>B HT</center></th>
		<th width="6%" align="center"><center>T HT</center></th>
                <th width="8%" align="center"><center>V TTC</center></th>
		<th width="8%" align="center"><center>B TTC</center></th>
		<th width="6%" align="center"><center>T TTC</center></th>
        </tr>';
            }
            
            $i++;
            
            $test=strpos($k/2,".");
            if($test==true){
            $style="style='background-color:#EAEAEA'";
            }else{
            $style="style='background-color:white'";   
            }
            $total_ht=$total_ht+$etatbenefice[0]['ht'];
            $total_ttc=$total_ttc+$etatbenefice[0]['ttc']; 
            
          $obj = ClassRegistry::init('Stockdepot');
          $stckdepot=$obj->find('first',array('conditions'=>array('Stockdepot.article_id'=>$etatbenefice['tmp']['article_id']),false)); 
          $total_achat=$total_achat+($stckdepot['Stockdepot']['prix']*$etatbenefice[0]['qte']);
    $tbl.=' <tr>
		
		<td width="10%" height="30px" align="center">'.$etatbenefice['tmp']['code'].' </td>
		<td width="33%">'.$etatbenefice['tmp']['name'].' </td>
		<td width="5%" align="center"> '.number_format($etatbenefice[0]["qte"]).' </td>
		<td width="8%" align="right"> '.number_format($stckdepot["Stockdepot"]["prix"]*$etatbenefice[0]['qte'],3, ".", " ").'&nbsp;</td>
		<td width="8%" align="right"> '.number_format($etatbenefice[0]["ht"],3, ".", " ").'&nbsp;</td>
		<td width="8%" align="right"> '.number_format($etatbenefice[0]["ht"]-($stckdepot['Stockdepot']['prix']*$etatbenefice[0]['qte']),3, ".", " ").'&nbsp;</td>
		<td width="6%" align="right"> '.number_format((((($etatbenefice[0]['ht'])-($stckdepot['Stockdepot']['prix']*$etatbenefice[0]['qte']))/$etatbenefice[0]['ht'])*100),2, ".", " ") .'&nbsp;%&nbsp;</td>
		
                <td width="8%" align="right"> '.number_format($etatbenefice[0]["ttc"],3, ".", " ").'&nbsp;</td>
		<td width="8%" align="right"> '.number_format($etatbenefice[0]['ttc']-($stckdepot['Stockdepot']['prix']*$etatbenefice[0]['qte']),3, ".", " ").'&nbsp;</td>
		<td width="6%" align="right"> '. number_format((((($etatbenefice[0]['ttc'])-($stckdepot['Stockdepot']['prix']*$etatbenefice[0]['qte']))/$etatbenefice[0]['ttc'])*100),2, ".", " ") .'&nbsp;%&nbsp;</td></tr>';
             
         
  endforeach;
   $tbl.= '</table><br><br>';
    if($i>15){
              
                $tbl .='  <br pagebreak="true"/>';
    }
         $tbl.= '  <center><table width="100%" ><tr>
           <td width="40%">
               <table border="1" width="100%">
                <tr>
                    <td colspan="2" height="30px" align="center"><strong><center> Total HT </center></strong></td>
                </tr> 
                <tr>
                    <td align="center" height="30px"><strong>Total Achat </strong></td><td align="center"><strong>'.number_format($total_achat,3, '.', ' ').'</strong></td>
                </tr>
                <tr>
                    <td align="center" height="30px"><strong>Total HT </strong></td><td align="center"><strong>'.number_format($total_ht,3, '.', ' ').'</strong></td>
                </tr>
                <tr>
                    <td align="center" height="30px"><strong>Total Bénéfice </strong></td><td align="center"><strong>'.number_format($total_ht-$total_achat,3, '.', ' ').'</strong></td>
                </tr>
                <tr>
                    <td align="center" height="30px"><strong>Taux Totale </strong></td><td align="center"><strong>'.number_format((($total_ht-$total_achat)/$total_ht)*100,3, '.', ' ').'%</strong></td>
                </tr>
            </table>   
           </td>
           <td width="18%">
           </td>
           <td width="40%">
               <table border="1" width="100%">
                <tr>
                    <td height="30px" colspan="2" height="30px" align="center"><strong><center> Total TTC </center></strong></td>
                </tr>
                <tr>
                    <td height="30px" align="center"><strong >Total Achat </strong></td><td align="center"><strong> '.number_format($total_achat,3, '.', ' ').'</strong> </td>
                </tr>
                <tr>
                    <td height="30px" align="center"><strong>Total TCC </strong></td><td align="center"><strong> '.number_format($total_ttc,3, '.', ' ').'</strong> </td>
                </tr>
                <tr>
                    <td height="30px" align="center"><strong>Total Bénéfice </strong></td><td align="center"><strong> '.number_format($total_ttc-$total_achat,3, '.', ' ').' </strong></td>
                </tr>
                <tr>
                    <td height="30px" align="center"><strong>Taux Totale </strong></td><td align="center"><strong> '.number_format((($total_ttc-$total_achat)/$total_ttc)*100,3, '.', ' ').'% </strong></td>
                </tr>
            </table>   
           </td>
           </tr></table></center>
           ' ;         
            
            
            
$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('etat.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>