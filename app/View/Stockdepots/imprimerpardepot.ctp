
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
//        $year = date('Y'); 
//        $footertext = sprintf($this->xfootertext, $year); 
//        $this->SetY(-20); 
//        $this->SetTextColor(0, 0, 0); 
//        $this->SetFont($this->xfooterfont,'',$this->xfooterfontsize);  
//         $footertext1 = sprintf($this->xfootertext1, $year); 
//        $this->SetY(-20); 
//        $this->SetTextColor(0, 0, 0); 
//        $this->SetFont($this->xfooterfont,'',$this->xfooterfontsize); 
//         $footertext2 = sprintf($this->xfootertext2, $year); 
//        $this->SetY(-20); 
//        $this->SetTextColor(0, 0, 0); 
//        $this->SetFont($this->xfooterfont,'',$this->xfooterfontsize); 
//        $this->Cell(0,8, $footertext,'T',1,'L'); 
//        $this->Cell(0,1, $footertext1,0,1,'L'); 
//        $this->Cell(0,3, $footertext2,0,1,'L'); 
    }
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PARAMED');
$pdf->SetTitle('Etat de Stock');

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
$m=' de date validité entre  '.$date1.' et  '.$date2;
}
// ---------------------------------------------------------

$pdf->AddPage('L');
//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 9);
$logo=  CakeSession::read('logo');
$n='Etat du stock';
if(!empty($namedepot)){
    $n=$n.' du d&eacute;p&ocirc;t '.$namedepot;
}
$nbrdepot=count($depotalls);
$widharticle=100-(($nbrdepot*15)+21);
$codewidth=$widharticle/2;
//debug($nbrdepot);
//debug($widharticle);die;
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
                <td height="35px" align="left" ><strong>'.$n.'</strong></td> 
            </tr> 
        </table>
    </td>
</tr>
    
</table>
<br><br>
   
 <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
   <tr bgcolor="#FFFFFF" align="center">
                        <th width="'.$codewidth.'%"   style="background-color:#b8b8b8" align="center" $zz height="10px" >Code Article</th>
                        <th width="'.$codewidth.'%"   style="background-color:#b8b8b8" align="center" $zz height="10px" >Réf Article</th>';
                      
					    foreach ($depotalls as $depot){
                        $tbl .= '<th width="15%" style="background-color:#b8b8b8" align="center" $zz >'.$depot['Depot']['designation'].'</th>';
                        }
                        $tbl .= '<th width="7%"  style="background-color:#b8b8b8" align="center" $zz >Qte ToT</th>
                            <th width="7%" style="background-color:#b8b8b8" align="center" $zz >PR HT</th>
                            <th width="7%" style="background-color:#b8b8b8" align="center" $zz >PR ToT</th>
   </tr>';
        $tot_qte_the=0;
        $i=0;$total=0;$qte=0;
        $test=0;$nbr=27;
       // debug($commfournisseurs);die;
       foreach ($stockdepots as $stockdepot){
            $qte=$qte+$stockdepot[0]['qte'];
            $total=$total+($stockdepot[0]['prix']*$stockdepot[0]['qte']);  
            $i++;
            if($test==1){
            $nbr=31;    
            }
            if($i==$nbr){
                $test++;
                $tbl .='</table>';
                $pdf->writeHTML($tbl, true, false, false, false, '');
                $pdf->AddPage('L');
                $i=0;
                $tbl='
 <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                        <tr bgcolor="#FFFFFF" align="center">
                          <th width="'.$codewidth.'%"   style="background-color:#b8b8b8" align="center" $zz height="10px" >Code Article</th>
                        <th width="'.$codewidth.'%"   style="background-color:#b8b8b8" align="center" $zz height="10px" >Réf Article</th>';
                      foreach ($depotalls as $depot){
                        $tbl .= '<th width="15%" style="background-color:#b8b8b8" align="center" $zz >'.$depot['Depot']['designation'].'</th>';
                        }
                        $tbl .= '<th width="7%" style="background-color:#b8b8b8" align="center" $zz >Qte ToT</th>
                            <th width="7%"  style="background-color:#b8b8b8" align="center" $zz >PR HT</th>
                            <th width="7%" style="background-color:#b8b8b8" align="center" $zz >PR ToT</th>
                        </tr>';
            }
   $chainearticle= $stockdepot['Article']['code']." ".$stockdepot['Article']['name'];
   $nbchaine=strlen($chainearticle);
   if($nbchaine>65){
       $i++;
   }
$tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="'.$codewidth.'%"  nobr="nobr" align="left" height="10px" $zz>'.$stockdepot['Article']['code'].'</td>
        <td width="'.$codewidth.'%"  nobr="nobr" align="left" height="10px" $zz>'.$stockdepot['Article']['name'].'</td>';
    
foreach ($depotalls as $d=>$depot){ 
                $obj = ClassRegistry::init('Stockdepot');
                $stckdepot=$obj->find('all',array('conditions'=>array('Stockdepot.article_id'=>$stockdepot['Article']['id'],'Stockdepot.depot_id'=>$depot['Depot']['id']),false));
//                if(!empty($stckdepot)){
//                $qtestock=$stckdepot['Stockdepot']['quantite'];    
//                }else{
//                $qtestock=0;    
//                } 
       
        
$tbl .= '<td width="15%" nobr="nobr" align="center"  $zz><table border="1" width="100%">';

 foreach ($stckdepot as $dep=>$sd){ 
     
                if($sd['Stockdepot']['quantite']!=0){    
                     $test=strpos($sd['Stockdepot']['quantite'], ".");
                        if($test==true){
                        $qtestock= sprintf('%.3f',$sd['Stockdepot']['quantite']);
                        }else{
                        $qtestock= $sd['Stockdepot']['quantite'];    
                        }
					/*	if($sd['Stockdepot']['date_exp']!='NULL' || $sd['Stockdepot']['date_exp']!='0000-00-00') 
						$date_exp=date("d/m/Y",strtotime(str_replace('/','-',$sd['Stockdepot']['date_exp']))); else $date_exp='';
                 <td>'.$date_exp.'</td> */   $tbl .='<tr>
                       
                        <td>'.$qtestock.'</td>
                    </tr>';
                 }}


$tbl .= '</table></td>';

    }
                $test=strpos($stockdepot[0]['qte'], ".");
                if($test==true){
                $stockdepot[0]['qte']= sprintf('%.3f',$stockdepot[0]['qte']);
                }else{
                $stockdepot[0]['qte']= $stockdepot[0]['qte'];    
                }
$tbl .= '<td width="7%" nobr="nobr" align="center"  $zz>'.$stockdepot[0]['qte'].'</td>
<td width="7%" nobr="nobr" align="right"  $zz>'.number_format($stockdepot[0]['prix'],3,'.',' ').'</td>   
<td width="7%" nobr="nobr" align="right"  $zz>'.number_format($stockdepot[0]['prix']*$stockdepot[0]['qte'],3,'.',' ').'</td>      
    </tr>' ;     
}
$d=@$d+3;
$tbl .= '
  <tr bgcolor="#FFFFFF" align="center">    
        <td colspan="'.@$d.'"  nobr="nobr" align="right" height="10px" $zz>Total</td>
        <td colspan="2" nobr="nobr" align="right"  $zz>'.number_format($total,3,'.',' ').'</td>    
    </tr>
</table>';
    

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('etatstock.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>