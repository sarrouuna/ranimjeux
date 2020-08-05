
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

$pdf->AddPage();

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 9);
$logo=  CakeSession::read('logo');

$tbl .=' 

<table width="100%">
<tr>
    <td width="45%" align="left" >
                        <IMG SRC="../webroot/img/'.$soc["Societe"]["logo"].'" width="120"  >
                    </td>
    <td  width="55%">
        <table width="100%">
            <tr>
            <br> 
                <td height="35px" align="left" ><h1>Liste des reglements  '.$m.'</h1></td> 
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
    <tr bgcolor="#CCCCCC" align="center">
        <th width="35%" align="center" $zz  height="30px"><strong>Fournisseur</strong></th>
        <th width="35%" align="center" $zz ><strong>Date</strong></th>
        <th width="30%" align="center" $zz ><strong>Montant</strong></th>
     </tr>';
$tot=0;$totR=0;$i=0;
//debug($reglements);die;
        foreach ($reglements as $reglement){
            
            foreach($reglement['Lignereglement'] as $y=>$li ){
            
        }
            //                ---------- Supp Decalage entre l en Tete et Le Tableau ------------
                    $i++;
                    if($i==34){
                        $tbl .='</table>';
                        
                        $pdf->writeHTML($tbl, true, false, false, false, '');
                        $pdf->AddPage('P'); 
                        $i=0;
            
            $tbl = '
                 
                  <br>  
                   <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                        <tr bgcolor="#CCCCCC" align="center">
                                <th width="35%" align="center" $zz height="30px" ><strong>Fournisseur</strong></th>
                                <th width="35%" align="center" $zz ><strong>Date</strong></th>
                                <th width="30%" align="center" $zz ><strong>Montant</strong></th>
                         </tr>';
                    
                        
//                 ---------- Supp Decalage entre l en Tete et Le Tableau ------------
              
              
        
        }
        $cli=$reglement['Fournisseur']['name'];
        $date=$reglement['Reglement']['Date'];
        $date=date("d/m/Y",strtotime(str_replace('-','/',$date)));
        $mont=$reglement['Reglement']['Montant'];
        $totR=$totR+$rem;
        $tot=$tot+$mont;
        
        
        
        $tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="35%" nobr="nobr" align="left" height="20px" $zz>'.$cli.'</td>
        <td width="35%" nobr="nobr" align="center"  $zz>'.$date.'</td>
        <td width="30%" nobr="nobr" align="center"  $zz>'.$mont.'</td>
       
    </tr>' ;   

    
}
$totR=sprintf('%.3f',$totR); 
$tot=sprintf('%.3f',$tot);
$tbl .= '
   <tr bgcolor="#CCCCCC" align="center">    
        <td colspan="2" width="70%" nobr="nobr" align="right" height="30px" $zz><strong>Total</strong></td>
        <td width="30%" nobr="nobr" align="center"  $zz><strong>'.$tot.'</strong></td>
       
    </tr>
</table>';
    

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('Reglements.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>