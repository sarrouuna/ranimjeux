
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
$soc = $ModelSociete->find('first');
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
if(@$date1!="" && @$date2!=""){
$date1=date('d/m/Y', strtotime(str_replace('-', '/',@$date1)));
$date2=date('d/m/Y', strtotime(str_replace('-', '/',@$date2)));
$m=' du  '.@$date1.' au  '.@$date2;
}
// ---------------------------------------------------------

$pdf->AddPage();

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 11);
$logo=  CakeSession::read('logo');

$tbl .=' 

<table width="100%">
<tr>
    <td  width="55%">
        <IMG SRC="../webroot/img/'.$logo.'" >
    </td>
    <td  width="45%">
        <table width="100%">
            <tr>
            <br> 
                <td height="35px" align="left" ><strong>CA Par Clients Et Articles  '.@$m.'</strong></td> 
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
   <tr bgcolor="#FFFFFF" align="center">
                        <th width="35%" align="center" $zz height="30px" ><strong>Client</strong></th>
                        <th width="35%" align="center" $zz ><strong>Article</strong></th>
                        <th width="10%" align="center" $zz ><strong>Qte</strong></th>
                        <th width="20%" align="center" $zz ><strong>CA</strong></th>
                        
                        
   </tr>';
        $i=0;$total=0;$kk=0;
        $cl="";$nom="";$style="";
        //debug($tab);die;
        $totaleqte=0;       
        $totaleca=0; 
        $totqte=0;
        $totcl=0;        
               foreach ($tab as $k=>$action){
               $totaleqte=$totaleqte+$action[0]['qte'];
               $totaleca=$totaleca+$action[0]['tot']; 
               $hh=1;$st=0;     
              if($cl!=$action['Tabetatcaparclientarticle']['clientid']){
                       $cl=$action['Tabetatcaparclientarticle']['clientid'];
                       $nom=$action['Tabetatcaparclientarticle']['name'];
                       //$style="style='border-bottom: none !important;'";
                       if($k!=0){
                       $st=1;    
                       $hh=8888;
                       }else{
                       $totqte=$totqte+$action[0]['qte'];
                       $totcl=$totcl+$action[0]['tot'];    
                       }
                        
                   }else{
                       $nom="";
                       $style="style='border: none !important;'";
                       $totqte=$totqte+$action[0]['qte'];
                       $totcl=$totcl+$action[0]['tot']; 
                   }      
                   
            
            $i++;
            if($i==17){
                $tbl .='</table>';
                $pdf->writeHTML($tbl, true, false, false, false, '');
                $pdf->AddPage();
                $i=0;
                $tbl='
                    <table width="100%">
<tr>
    <td  width="55%">
        <IMG SRC="../webroot/img/'.$logo.'" >
    </td>
    <td  width="45%">
        <table width="100%">
            <tr>
            <br> 
                <td height="35px" align="left" ><strong>Liste des clients  '.@$m.'</strong></td> 
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
<br><br>
                    <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                   <tr bgcolor="#FFFFFF" align="center">
                       <th width="35%" align="center" $zz height="30px" ><strong>Client</strong></th>
                       <th width="35%" align="center" $zz ><strong>Article</strong></th>
                       <th width="10%" align="center" $zz ><strong>Qte</strong></th>
                       <th width="20%" align="center" $zz ><strong>CA</strong></th>
                              
                   </tr>';
            }
if($hh==8888){
$tbl .='<tr><td colspan="2" align="right"><strong>Total</strong></td><td align="right"><strong>'.$totqte.'</strong></td><td align="right"><strong>'.sprintf("%01.3f",$totcl).'</strong></td></tr>';
$totcl=0;
$totqte=0;
$totqte=$totqte+$action[0]['qte'];
$totcl=$totcl+$action[0]['tot'];
$i++;
}                
    
               
        $tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="35%"' ; if($st==1){ $tbl .= 'style="border-bottom: 0px solid #FEFEFE; border-left: 0px solid #000101;"';}else{$tbl .= 'style="border-bottom: 0px solid #FEFEFE; border-left: 0px solid #000101; "';} $tbl .= ' nobr="nobr" align="center"  $zz>'.$nom.'</td>
        <td width="35%" nobr="nobr" align="center"  $zz>'.$action['Tabetatcaparclientarticle']['article'].'</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.$action[0]['qte'].'</td>     
        <td width="20%" nobr="nobr" align="right"  $zz>'.sprintf("%01.3f",$action[0]['tot']).'</td>
    </tr>' ;     
}
$tbl .='<tr><td colspan="2" align="right"><strong>Total</strong></td><td align="right"><strong>'.$totqte.'</strong></td><td align="right"><strong>'.sprintf("%01.3f",$totcl).'</strong></td></tr>';
$tbl .= '
   <tr bgcolor="#FFFFFF" align="center">    
       
        <td width="70%" colspan="3" nobr="nobr" align="center"  $zz>Total</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.$totaleqte.'</td>
        <td width="20%" nobr="nobr" align="right"  $zz>'.sprintf("%01.3f",$totaleca).'</td>
       
    </tr>
</table>';
$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('etat.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>