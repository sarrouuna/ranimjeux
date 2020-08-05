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
$pdf->SetTitle('Bonreception ');
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

// ---------------------------------------------------------
$styl_cadr='style="border-left:1px solid black;  border-right:1px solid black;  border-top:1px solid black;  border-bottom:1px solid black;"';
$styl_cadr_ent='style="border-bottom:1px solid black;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;background-color:#b8b8b8"';
$styl_cadr_bottom='style="border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;"';
$pdf->AddPage();

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 9);

$tbl .='<table>
    <tr>
        <td width="45%" align="left" >
            <IMG SRC="../webroot/img/'.$soc["Societe"]["logo"].'" width="110"  >
        </td>
         <td width="55%" align="left" >          Bon d\'écart sur l\'inventaire Numero : '.$bon[0]['Inventaire']['numero'].'
         </td>
    </tr>
</table>';



if($bon[0]['Inventaire']['type']==1){
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
        <td align="center" '.$styl_cadr_ent.' width="40%"><strong>Article</strong></td>
       
        <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Qte anc</strong></td>
        <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Qte nv</strong></td>
        <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Quantite</strong></td>
        <td align="center" '.$styl_cadr_ent.' width="15%"><strong>Prix</strong></td>
        <td align="center" '.$styl_cadr_ent.' width="15%"><strong>Prix ToT</strong></td>
    </tr>
   ';


          
                                                        foreach ($bonecarts as $i=>$af){
                                                
                                                            
                                                            
                                                            
                                               if($kk==22){
                    $n=0;
                    $tbl .= '</table>';
                        $pdf->writeHTML($tbl, true, false, false, false, '');
                            $pdf->AddPage();
                            $kk=0;
                            $tbl = '<table cellpadding="2" cellspacing="0" >       
    <tr>
        <td align="center" '.$styl_cadr_ent.' width="40%"><strong>Article</strong></td>
       
        <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Qte anc</strong></td>
        <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Qte nv</strong></td>
        <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Quantite</strong></td>
        <td align="center" '.$styl_cadr_ent.' width="15%"><strong>Prix</strong></td>
        <td align="center" '.$styl_cadr_ent.' width="15%"><strong>Prix ToT</strong></td>
    </tr>';
                }$kk++;    

         
$tbl .='
    
     <tr> 
        <td align="lfet" '.$styl_cadr.'  width="40%" >&nbsp;<br>'.$af['Article']['nom'].'</td>
       
        <td align="center" '.$styl_cadr.' width="10%">&nbsp;<br>'.$af['Bonecart']['qteanc'].'</td> 
        <td align="center" '.$styl_cadr.' width="10%">&nbsp;<br>'.$af['Bonecart']['qtenv'].'</td>
        <td align="center" '.$styl_cadr.' width="10%">&nbsp;<br>'.$af['Bonecart']['quantite'].'</td>
        <td align="center" '.$styl_cadr.' width="15%">&nbsp;<br>'.$af['Bonecart']['prix'].'</td>
        <td align="center" '.$styl_cadr.' width="15%">&nbsp;<br>'.$af['Bonecart']['prixtot'].'</td>
    
</tr>
    
';
                            
}
$tbl .='</table>';
}    
    
if($bon[0]['Inventaire']['type']==2){
$tbl .=' 
<table cellpadding="2" cellspacing="0" >
   
     
      
    <tr>
        
              <td height="35px" align="center"  width="10%" ><strong>Article  : </strong></td> 
        <td align="left" width="60%">'.$bon[0]['Article']['code'].' '.$bon[0]['Article']['name'].'</td>
             <td height="15px" align="center" width="25%"><strong>Date : </strong></td>
        <td align="left" width="15%">'.date("d/m/Y",strtotime(str_replace('-','/',($bon[0]['Inventaire']['date'])))).'</td>
    </tr> 
    </table>
    <table width="100%" cellpadding="2" cellspacing="0" '.$styl_cadr_bottom.' >
    <tr>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="40%"><strong>Depot</strong></td>
   
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%"><strong>Qte anc</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%"><strong>Qte nv</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="10%"><strong>Quantite</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="15%"><strong>Prix</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="15%"><strong>Prix ToT</strong></td>
    </tr>
   ';

$long="670";
          $totanc=0;
          $totnv=0;
          $totecart=0;
          $totprix=0;
                                                        foreach ($bonecarts as $i=>$af){
           
                                                            
                                                            $totanc=$totanc+$af['Bonecart']['qteanc'];
                                                            $totnv=$totnv+$af['Bonecart']['qtenv'];
                                                            $totecart=$totecart+$af['Bonecart']['quantite'];
                                                            $totprix=$totprix+$af['Bonecart']['prixtot'];
                                               //debug($af);die;

              $long=$long-10;
$tbl .='
    
     <tr> 
        <td align="lfet" style="border-bottom:solid #000 0px;border-left:solid #000 0px;border-right:solid #000 0px;" width="40%" >&nbsp;<br>'.$af['Depot']['code'].' '.$af['Depot']['designation'].'</td>
        
        <td align="center" '.$styl_cadr.' width="10%">&nbsp;<br>'.$af['Bonecart']['qteanc'].'</td> 
        <td align="center" '.$styl_cadr.' width="10%">&nbsp;<br>'.$af['Bonecart']['qtenv'].'</td>
        <td align="center" '.$styl_cadr.' width="10%">&nbsp;<br>'.$af['Bonecart']['quantite'].'</td>
        <td align="center" '.$styl_cadr.' width="15%">&nbsp;<br>'.$af['Bonecart']['prix'].'</td>
        <td align="center" '.$styl_cadr.' width="15%">&nbsp;<br>'.$af['Bonecart']['prixtot'].'</td>
    
</tr>
    
';
                            
}
$tbl .='<tr> 
        <td align="lfet" style="border-bottom:solid #000 0px;border-left:solid #000 0px;border-right:solid #000 0px;" width="40%" >&nbsp;<br>Totale</td>
        <td align="center" '.$styl_cadr.' width="10%">&nbsp;<br>'.$totanc.'</td> 
        <td align="center" '.$styl_cadr.' width="10%">&nbsp;<br>'.$totnv.'</td>
        <td align="center" '.$styl_cadr.' width="10%">&nbsp;<br>'.$totecart.'</td>
        <td align="center" '.$styl_cadr.' width="15%">&nbsp;<br></td>
        <td align="center" '.$styl_cadr.' width="15%">&nbsp;<br>'.$totprix.'</td>
    
</tr>
        
        
        
        </table>';
}            

$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
//Close and output PDF document
ob_end_clean();
$pdf->Output('imprimer_view_inventaire', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>