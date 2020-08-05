
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
$pdf->SetTitle('Engagment Fournisseur');

$ent = 'entete.jpg';
$ModelSociete = ClassRegistry::init('Societe');
$soc = $ModelSociete->find('first',array('conditions'=>array('Societe.mere'=>1)));

$footer = '     SARL au Capital de : ' . $soc['Societe']['capital'] . '          Adresse : ' . $soc['Societe']['adresse'] . '          Code T.V.A: ' . $soc['Societe']['codetva']  ;
$footer1 ='     RIB: ' . $soc['Societe']['rib'] . '          RC: ' . $soc['Societe']['rc']; 
$aaa = "abc";
$pdf->xfootertext = $footer;
$pdf->xfootertext1 = $footer1 ;
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
//debug($Date_debut);die;
if($Date_debut !="" ){
$date1=date('d/m/Y', strtotime(str_replace('-', '/',$Date_debut)));
$m='Encaissement du '.$date1;
}
if($Date_fin!=""){
$date2=date('d/m/Y', strtotime(str_replace('-', '/',$Date_fin)));
$m=$m.' jusqu à '.$date2;
}else{
$date2="";
}
if($Date_deb!="" ){
$date11=date('d/m/Y', strtotime(str_replace('-', '/',$Date_deb)));
$m=$m.' Echéance du '.$date11;
}
if($Date_fn!=""){
$date22=date('d/m/Y', strtotime(str_replace('-', '/',$Date_fn)));
$m=$m.' jusqu à '.$date22;
}else{
$date22="";
}
if($client_id!="" ){
$m=$m.' par client : '.$clients[$client_id];
}
if($paiement_id!="" ){
$m=$m.' par mode de paiement : '.$paiements[$paiement_id];
}
if($compte_id!="" ){
$m=$m.' dans Compte : '.$comptes[$compte_id];
}
if($situation!="" ){
$m=$m.' de situation : '.$situation;
}



// ---------------------------------------------------------

$pdf->AddPage('P');

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 8);
$logo=  CakeSession::read('logo');

$tbl .=' 

<table width="100%">
<tr>
    <td width="45%" align="left" >
    <IMG SRC="../webroot/img/'.$soc["Societe"]["logo"].'" width="110px"  >
</td>
    <td  width="55%">
        <table width="100%">
            <tr>
            <br> 
                <td height="35px" align="left" ><strong>Engagment client  '.$m.'</strong></td> 
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
                        <th width="10%" align="center" $zz height="30px" ><strong>Mode de Paiement</strong></th>
                        <th width="20%" align="center" $zz ><strong>Client</strong></th>
                        <th width="10%" align="center" $zz ><strong>Numéro</strong></th>
                        <th width="10%" align="center" $zz ><strong>Encaissement</strong></th>
                        <th width="10%" align="center" $zz ><strong>Echéance</strong></th>
                        <th width="20%" align="center" $zz><strong>Compte</strong></th>
                        <th width="10%" align="center" $zz><strong>Situation</strong></th>
                        <th width="10%" align="center" $zz><strong>Montant</strong></th>
   </tr>';
        $i=0;$style=""; 
        $echance='';
        $tot=0;
               foreach ($piecereglementclients as $k=>$piece){
                $tot=$tot+$piece['Piecereglementclient']['montant'];    
                $obj = ClassRegistry::init('Client');
                $client = $obj->find('first',array('conditions'=>array('Client.id'=>$piece['Reglementclient']['client_id']),'recursive'=>0)); 
                if(!empty($piece['Piecereglementclient']['echance'])&& $piece['Piecereglementclient']['echance']!="1970-01-01"){
                $echeance=date("d/m/Y",strtotime(str_replace('-','/',($piece['Piecereglementclient']['echance']))));
                }else{
                $echeance="" ;   
                }
                
        $tbl .= 
    '<tr align="center">    
        <td width="10%" nobr="nobr" align="lfet" height="30px" $zz>'.$piece['Paiement']['name'].'</td>
        <td width="20%" nobr="nobr" align="lfet"  $zz>'.$client['Client']['code']." ".$client['Client']['name'].'</td>
        <td width="10%" nobr="nobr" align="center"  $zz>'.$piece['Piecereglementclient']['num'].'</td>
        <td width="10%" nobr="nobr" align="center"  $zz>'.date("d/m/Y",strtotime(str_replace('-','/',($piece['Reglementclient']['Date'])))).'</td>
        <td width="10%" nobr="nobr" align="center"  $zz>'.$echeance.'</td>
        <td width="20%" nobr="nobr" align="lfet"  $zz>'.$piece['Compte']['banque'].'</td>
        <td width="10%" nobr="nobr" align="lfet"  $zz>'.$piece['Piecereglementclient']['situation'].'</td>    
        <td width="10%" nobr="nobr" align="right"  $zz>'.number_format($piece['Piecereglementclient']['montant'],3, '.', ' ').'</td>
    </tr>' ;     
}
$tbl .= 
    '<tr align="center">    
        <td width="90%" nobr="nobr" align="center" height="30px" $zz><strong>Total</strong></td>
        <td width="10%" nobr="nobr" align="right"  $zz>'.number_format($tot,3, '.', ' ').'</td>
    </tr>';

$tbl .= '</table>';
    

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('historique_article.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>