
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
$pdf->SetAuthor('Thermeco');
$pdf->SetTitle('Liste Importation');

$ent = 'entete.jpg';
$ModelSociete = ClassRegistry::init('Societe');
$soc = $ModelSociete->find('first',array('conditions'=>array('Societe.mere'=>1)));

$footer = '     SARL au Capital de : ' . $soc['Societe']['capital'] . '          Adresse : ' . $soc['Societe']['adresse'] . '          Code T.V.A: ' . $soc['Societe']['codetva'] . '          RIB: ' . $soc['Societe']['rib'] . '          RC: ' . $soc['Societe']['rc']  ;
$footer1 = ''; 
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
if($date1!="" && $date2!=""){
$date1=date('d/m/Y', strtotime(str_replace('-', '/',$date1)));
$date2=date('d/m/Y', strtotime(str_replace('-', '/',$date2)));
$m=' du  '.$date1.' au  '.$date2;
}
// ---------------------------------------------------------

$pdf->AddPage('L');

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
                <td height="35px" align="left" ><strong>liste des importation  '.$m.'</strong></td> 
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
                        <th width="15%" align="center" $zz height="30px" ><strong>Désignation</strong></th>
                        <th width="5%" align="center" $zz ><strong>N°</strong></th>
                        <th width="10%" align="center" $zz ><strong>Date</strong></th>
                        <th width="15%" align="center" $zz ><strong>Fournisseur</strong></th>
                        <th width="7%" align="center" $zz ><strong>Devise</strong></th>
                        <th width="10%" align="center" $zz ><strong>M A</strong></th>
                        <th width="10%" align="center" $zz ><strong>T R</strong></th> 
                        <th width="10%" align="center" $zz ><strong>Totale</strong></th>
                        <th width="10%" align="center" $zz ><strong>Coefficient</strong></th>
                        <th width="10%" align="center" $zz ><strong>Situation</strong></th>
   </tr>';
        $i=0;$total=0;
       // debug($commfournisseurs);die;
       foreach (@$importations as $br){
        $obj = ClassRegistry::init('Namesituation');
        $test = $obj->find('first',array('conditions'=>array('Namesituation.id'=>$br['Situation']['namesituation_id']),'recursive'=>-1));     
        //debug($test);             
            $i++;
            if($i==13){
                $tbl .='</table>';
                $pdf->writeHTML($tbl, true, false, false, false, '');
                $pdf->AddPage('L');
                $i=0;
                $tbl='
                    <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                   <tr bgcolor="#FFFFFF" align="center">
                        <th width="15%" align="center" $zz height="30px" ><strong>Désignation</strong></th>
                        <th width="5%" align="center" $zz ><strong>N°</strong></th>
                        <th width="10%" align="center" $zz ><strong>Date</strong></th>
                        <th width="15%" align="center" $zz ><strong>Fournisseur</strong></th>
                        <th width="7%" align="center" $zz ><strong>Devise</strong></th>
                        <th width="10%" align="center" $zz ><strong>M A</strong></th>
                        <th width="10%" align="center" $zz ><strong>T R</strong></th> 
                        <th width="10%" align="center" $zz ><strong>Totale</strong></th>
                        <th width="10%" align="center" $zz ><strong>Coefficient</strong></th>
                        <th width="10%" align="center" $zz ><strong>Situation</strong></th>
                   </tr>';
            }
            
          
               
        $tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="15%" nobr="nobr" align="center" height="30px" $zz>'.$br['Importation']['name'].'</td>
        <td width="5%" nobr="nobr" align="center"  $zz>'.$br['Importation']['numero'].'</td>    
        <td width="10%" nobr="nobr" align="center"  $zz>'.date("d/m/Y",strtotime(str_replace('-','/',$br['Importation']['date']))).'</td>
        <td width="15%" nobr="nobr" align="center"  $zz>'.$br['Fournisseur']['name'].'</td>
        <td width="7%" nobr="nobr" align="center"  $zz>'.$br['Devise']['name'].'</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.sprintf('%.3f',$br['Importation']['montantachat']).'</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.sprintf('%.3f',$br['Importation']['tauxderechenge']).'</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.sprintf('%.3f',$br['Importation']['totale']).'</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.sprintf('%.3f',$br['Importation']['coefficien']).'</td>
        <td width="10%" nobr="nobr" align="center"  $zz>'.@$test['Namesituation']['name'].'</td>
    </tr>' ;     
}

$tbl .= '</table>';
    

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('liste_importation.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>