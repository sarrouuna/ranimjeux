
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
$pdf->SetAuthor('Thermeco');
$pdf->SetTitle('Engagment Fournisseur');

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
if($fournisseur_id!="" ){
$m=$m.' par fournisseur : '.$fournisseurs[$fournisseur_id];
}
if($paiement_id!="" ){
$tabd=explode(",",$paiement_id);  
//debug($tabd);die;
    $ch="";
    foreach ($tabd as $k=>$type)  {
    if($k !=0){    
    if($k==1){
     $ch=$ch." ".$paiements[$type]  ;
    }else{
     $ch=$ch." et ".$paiements[$type]  ;   
    }
    }
    }
$m=$m.' de mode de paiement : '.$ch;
}
if($compte_id!="" ){
$tabd=explode(",",$compte_id);  
//debug($tabd);die;
    $ch="";
    foreach ($tabd as $k=>$type)  {
    if($k !=0){    
    if($k==1){
     $ch=$ch." ".$comptes[$type]  ;
    }else{
     $ch=$ch." et ".$comptes[$type]  ;   
    }
    }
    }
$m=$m.' de compte : '.$ch;
}
if($situation!="" ){
$situationn=str_replace('/','',$situation);
$tabd=explode(",",$situationn);  
//debug($tabd);die;
    $ch="";
    foreach ($tabd as $k=>$type)  {
    if($k !=0){    
    if($k==1){
     $ch=$ch." ".$type  ;
    }else{
     $ch=$ch." et ".$type  ;   
    }
    }
    }
$m=$m.' de situation : '.$ch;
}
if($nacionalitefournisseur_id!="" ){
$m=$m.' de type  : '.$nacionalitefournisseurs[$nacionalitefournisseur_id];
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
                <td height="35px" align="left" ><strong>Engagment Fournisseur  '.$m.'</strong></td> 
            </tr> 
        </table>
    </td>
</tr>
</table>
<br>
<table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
   <tr bgcolor="#FFFFFF" align="center">
                        <th width="10%" align="center" $zz height="10px" ><strong>Mode de Paiement</strong></th>
                        <th width="20%" align="center" $zz ><strong>Fournisseur</strong></th>
                        <th width="10%" align="center" $zz ><strong>Réglement</strong></th>
                        <th width="8%" align="center" $zz ><strong>Numero</strong></th>
                        <th width="8%" align="center" $zz ><strong>Encaissement</strong></th>
                        <th width="8%" align="center" $zz ><strong>Echéance</strong></th>
                        <th width="15%" align="center" $zz><strong>Compte</strong></th>
                        <th width="12%" align="center" $zz><strong>Situation</strong></th>
                        <th width="9%" align="center" $zz><strong>Montant</strong></th>
   </tr>';
        $i=0;$style=""; 
        $echance='';
        $tot=0;
               foreach ($piecereglements as $k=>$piece){
                if(!empty($piece['Piecereglement']['echance'])){
                $echance=h(date("d/m/Y",strtotime(str_replace('-','/',($piece['Piecereglement']['echance'])))));    
                }else{
                $echance="";    
                }   
                $tot=$tot+$piece['Piecereglement']['montant'];    
                $obj = ClassRegistry::init('Fournisseur');
                $fournisseur = $obj->find('first',array('conditions'=>array('Fournisseur.id'=>$piece['Reglement']['fournisseur_id']),'recursive'=>0));  
                if($piece['Paiement']['id']==7){$echance=$piece['Piecereglement']['nbrmoins'];}
                $test=strpos($k/2,".");
                if($test==true){
                 $style="#F2D7D5";
                }else{
                 $style="white";   
                }    
            
            $i++;
            if($i==23){
                $tbl .='</table>';
                $pdf->writeHTML($tbl, true, false, false, false, '');
                $pdf->AddPage('L');
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
                <td height="35px" align="left" ><strong>Engagment Fournisseur  '.$m.'</strong></td> 
            </tr> 
        </table>
    </td>
</tr>
</table>
<br>
                    <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                   <tr bgcolor="#FFFFFF" align="center">
                        <th width="10%" align="center" $zz height="10px" ><strong>Mode de Paiement</strong></th>
                        <th width="20%" align="center" $zz ><strong>Fournisseur</strong></th>
                        <th width="10%" align="center" $zz ><strong>Réglement</strong></th>
                        <th width="8%" align="center" $zz ><strong>Numero</strong></th>
                        <th width="8%" align="center" $zz ><strong>Encaissement</strong></th>
                        <th width="8%" align="center" $zz ><strong>Echéance</strong></th>
                        <th width="15%" align="center" $zz><strong>Compte</strong></th>
                        <th width="12%" align="center" $zz><strong>Situation</strong></th>
                        <th width="10%" align="center" $zz><strong>Montant</strong></th>
                              
                   </tr>';
            }
            
       
              
                  
                  
       
               
        $tbl .= 
       '<tr align="center" bgcolor="'.$style.'">    
        <td  width="10%" nobr="nobr" align="lfet" height="10px" $zz><strong>'.$piece['Paiement']['name'].'</strong></td>
        <td width="20%" nobr="nobr" align="lfet"  $zz>'.$fournisseur['Fournisseur']['name'].'</td>
        <td width="10%" nobr="nobr" align="lfet"  $zz>'.$piece['Reglement']['designation'].'</td>
        <td width="8%" nobr="nobr" align="right"  $zz>'.$piece['Piecereglement']['num'].'</td>
        <td width="8%" nobr="nobr" align="center"  $zz>'.date("d/m/Y",strtotime(str_replace('-','/',($piece['Reglement']['Date'])))).'</td>
        <td width="8%" nobr="nobr" align="center"  $zz>'.$echance.'</td>
        <td width="15%" nobr="nobr" align="lfet"  $zz>'.$piece['Compte']['banque'].'</td>
        <td width="12%" nobr="nobr" align="lfet"  $zz>'.$piece['Piecereglement']['situation']." ".$piece['Piecereglement']['nbrmoins'].'</td>    
        <td width="9%" nobr="nobr" align="right"  $zz>'.number_format($piece['Piecereglement']['montant'],3, '.', ' ').'</td>
    </tr>' ;     
}
$tbl .= 
    '<tr align="center">    
        <td width="91%" nobr="nobr" align="center" height="30px" $zz><strong>Total</strong></td>
        <td width="9%" nobr="nobr" align="right"  $zz>'.number_format($tot,3, '.', ' ').'</td>
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