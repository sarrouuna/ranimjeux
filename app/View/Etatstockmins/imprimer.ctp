
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
if($date1!="" ){
$date1=date('d/m/Y', strtotime(str_replace('-', '/',$date1)));
$m='de '.$date1;
}
if( $date2!=""){
$date2=date('d/m/Y', strtotime(str_replace('-', '/',$date2)));
$m=$m.' jusqu à '.$date2;
}else{
$date2="";
}


// ---------------------------------------------------------

$pdf->AddPage();

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 11);
$logo=  CakeSession::read('logo');
$n='Etat du stock Min';
$tbl .=' 

<table width="100%">
<tr>
    <td width="45%" align="left" >
    <IMG SRC="../webroot/img/'.$soc["Societe"]["logo"].'" width="110"  >
</td>
    <td  width="45%">
        <table width="100%">
            <tr>
            <br> 
                <td height="35px" align="left" ><strong>'.$n." ".$m.'</strong></td> 
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
                        <th width="70%" align="center" $zz height="30px" ><strong>Article</strong></th>
                       <th width="10%" align="center" $zz ><strong>Quantite</strong></th>
                        <th width="10%" align="center" $zz ><strong>Quantite</strong></th>
                        <th width="10%" align="center" $zz ><strong>Quantite Théorique</strong></th>
                       
   </tr>';
        $tot_qte_the=0;
        $i=0;$total=0;$qte=0;
       // debug($commfournisseurs);die;
       foreach ($stockdepots as $stockdepot){
            $qte=$qte+$stockdepot[0]['qte'];
            if($i==22){
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
                <td height="35px" align="left" ><strong>'.$n." ".$m.'</strong></td> 
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
                       <th width="70%" align="center" $zz height="30px" ><strong>Article</strong></th>
                       <th width="10%" align="center" $zz ><strong>Quantite</strong></th>
                        <th width="10%" align="center" $zz ><strong>Quantite</strong></th>
                        <th width="10%" align="center" $zz ><strong>Quantite Théorique</strong></th>
                              
                   </tr>';
            }
                $lignecommandes=ClassRegistry::init('Lignecommande')->find('all', array('fields'=>array('sum(Lignecommande.quantite) as qte'),'conditions' => array('Lignecommande.id > ' => 0,'Lignecommande.article_id' =>$stockdepot['Article']['id'],@$cond1f, @$cond3f, @$cond4f )
                ,'group'=>array('Lignecommande.article_id')));
                //debug($lignecommandes);
                $commandeclts =ClassRegistry::init('Lignecommandeclient')->find('all', array('fields'=>array('sum(Lignecommandeclient.quantite) as qte'),'conditions' => array('Lignecommandeclient.id > ' => 0,'Lignecommandeclient.article_id' =>$stockdepot['Article']['id'],@$cond1c, @$cond3c, @$cond4c )
                ,'group'=>array('Lignecommandeclient.article_id')));
                //debug($commandeclts);
                if(!empty($lignecommandes)){
                $qtecom_entre=$lignecommandes[0][0]['qte'];
                }else{
                $qtecom_entre=0;
                }
                if(!empty($commandeclts)){
                $qtecom_sortie=$commandeclts[0][0]['qte'];
                }else{
                $qtecom_sortie=0;
                }
                $qte_theorique=$stockdepot[0]['qte']-$qtecom_sortie+$qtecom_entre;            
                $tot_qte_the=$tot_qte_the+$qte_theorique;
                if($stockdepot['Article']['stockmin']>=$qte_theorique){
               $i++;
        $tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="70%" nobr="nobr" align="left" height="30px" $zz>'.$stockdepot['Article']['name'].'</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.$stockdepot['Article']['stockmin'].'</td>    
        <td width="10%" nobr="nobr" align="right"  $zz>'.$stockdepot[0]['qte'].'</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.$qte_theorique.'</td>    
    </tr>' ;     
       }}

$tbl .= '
  <tr bgcolor="#FFFFFF" align="center">    
        <td width="80%" nobr="nobr" align="right" height="30px" $zz>Total</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.$qte.'</td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.$tot_qte_the.'</td>    
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