
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

$pdf->AddPage("L");

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
<br><br><br>';


 $tbl .='<table >
    <thead>
	<tr>
            <td>
              Mois  
            </td>';    
        if(!empty($moiid)){
        $comp=$moiid;    
        foreach ($moiid as $m){ 
            $tbl .='<td align="center">'.
                  $mois[$m]  
            .'</td> '; 
        }} else { 
        $comp=$mois;    
          foreach ($mois as $m){ 
            $tbl .='<td align="center">'.
                  $m   
          .'</td>';
         }}       
        $tbl .='</tr>
                      </thead>
                      <tbody>
	<tr>
        <td>
            <table  border="2" style="width:100%">
                <tr>
                    <td> CA</td> 
                </tr>
                <tr>
                    <td>Année</td> 
                </tr>
                <tr>
                   <td> Qte <br> CA</td>
                </tr>
                <tr>
                    <td>Écart <br>%</td>
                </tr>
            </table>      
        </td>';    
        foreach ($comp as $m=>$c){ 
        if(!empty($moiid)){    
        $m=$c;
        }
        $tot1b=0;
        $tot2b=0;
        $tot1f=0;
        $tot2f=0;
        $qte1b=0;
        $qte2b=0;
        $qte1f=0;
        $qte2f=0;
        $tot_bf1=0;
        $tot_bf2=0;
        $qte_bf1=0;
        $qte_bf2=0;
        //debug($m);
        $tbl .='<td>
            <table border="2" style="width:100%">
                <tr>
                    <td colspan="2" align="center">CA</td>
                </tr>
                <tr>
                    <td align="center">'.$exercice1s[$exerciceid1].'</td>
                    <td align="center">'.$exercice2s[$exerciceid2].'</td>
                </tr>
                <tr>
                    <td align="center" nowrap="nowrap">';
                    if(!empty($bonlivraisonparprix1s)){
                    foreach ($bonlivraisonparprix1s as $bon){ 
                    if($bon[0]['mois']==$m){ 
                        //debug("d5Al bl 2015");
                    $qte1b=$bon[0]['quantite'];
                    $tot1b=$bon[0]['total']; 
                    }}}
                    if(!empty($factureclientparprix1s)){
                    foreach ($factureclientparprix1s as $fac){ 
                    if($fac[0]['mois']==$m){
                        //debug("d5Al fac 2015");
                    $qte1f=$fac[0]['quantite'];
                    $tot1f=$fac[0]['total']; 
                    }}}
                    $qte_bf1=$qte1b+$qte1f;
                    $tot_bf1=$tot1b+$tot1f;
                    
                    $tbl .=''.$qte_bf1.'<br>'.sprintf('%.3f',$tot_bf1).'   
                    </td>
                    
                    
                    
                    
                    
                    <td align="center" nowrap="nowrap">';
                    if(!empty($bonlivraisonparprix2s)){
                    foreach ($bonlivraisonparprix2s as $bon2){ 
                    if($bon2[0]['mois']==$m){
                        //debug("d5Al bl 2016");
                    $qte2b=$bon2[0]['quantite'];
                    $tot2b=$bon2[0]['total']; 
                    }}}
                    if(!empty($factureclientparprix2s)){
                    foreach ($factureclientparprix2s as $fac2){ 
                    if($fac2[0]['mois']==$m){ 
                        //debug("d5Al fac 2016");
                    $qte2f=$fac2[0]['quantite'];
                    $tot2f=$fac2[0]['total'];
                    }}}
                    $qte_bf2=$qte2b+$qte2f;
                    $tot_bf2=$tot2b+$tot2f;
                    $tbl .=''.$qte_bf2.'<br>'.sprintf('%.3f',$tot_bf2).'   
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="2">';
                    $ecart=$tot_bf2-$tot_bf1;
                    $ecartt=$tot_bf2-$tot_bf1;
                    if($tot_bf1!=0){
                    if($ecart<0){
                    $ecart=0-$ecart;
                    $img='<img class="rounded" src="'.$this->webroot.'img/decroissante.jpg" width="20px" height="20px" />';
                    }else{
                    $img='<img class="rounded" src="'.$this->webroot.'img/croissante.png" width="20px" height="20px" />';
                    }    
                    $p=($ecart/$tot_bf1)*100;
                    }else{
                    $img='<img class="rounded" src="'.$this->webroot.'img/croissante.png" width="20px" height="20px" />';
                    $p=100;    
                    }
                        $tbl .='<table style="width:100%">
                            <tr >
                                <td colspan="2" align="center" nowrap="nowrap">'.
                                sprintf('%.3f',$ecartt).  
                                '</td> 
                            </tr>
                            <tr>
                                <td align="center" nowrap="nowrap">
                                '.$img.  
                                '</td>
                                <td align="center" nowrap="nowrap">';
                                 $test=strpos($p, ".");
                                 if($test==true){
                                 $tbl .=sprintf('%.2f',$p).'%';
                                 }else{
                                 $tbl .=$p.'%';    
                                 }
                                $tbl .='</td>
                            </tr>
                        </table>  
                    </td>   
                </tr>
            </table>       
        </td>';
        }    
	$tbl .='</tr>
                       </tbody>
	</table>';
        
               
$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('etat.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>