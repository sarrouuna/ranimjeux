
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
$footer = '     SARL au Capital de : ' . $soc['Societe']['capital'] . '          Adresse : ' . $soc['Societe']['adresse'] . '          Code T.V.A: ' . $soc['Societe']['codetva'] . '          RIB: ' . $soc['Societe']['rib']      ;
$footer1 = '     Site : ' . $soc['Societe']['site'] . '           E-mail: ' . $soc['Societe']['mail'] . '           Tel : ' . $soc['Societe']['tel'] . '             Fax : ' . $soc['Societe']['fax'].'                                                                                              '.$pdf->getAliasNumPage().' / '.$pdf->getAliasNbPages();

$aaa = "abc";
$pdf->xfootertext = $footer;
$pdf->xfootertext1 = $footer1;
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
if(!empty($date1) && !empty($date2)){
$date1=date('d/m/Y', strtotime(str_replace('-', '/',$date1)));
$date2=date('d/m/Y', strtotime(str_replace('-', '/',$date2)));
$m=' du  '.$date1.' au  '.$date2;
}
// ---------------------------------------------------------

$pdf->AddPage('L');

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 9);
$logo=  CakeSession::read('logo');



        

$footer = 'Paramed';

//$aaa = "abc";
//$pdf->xfootertext = $footer;
//$pdf->xfootertext1 = '';
//$pdf->xfootertext2 = '';
//
//// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//
//// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//
//// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//
//// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//
//// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//
//// set some language-dependent strings (optional)
//if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
//    require_once(dirname(__FILE__) . '/lang/eng.php');
//    $pdf->setLanguageArray($l);
//}
//
//// ---------------------------------------------------------
//
//
//
////$pdf->SetFont('dejavusans', '', 12);
////$pdf->SetFont('times', 'B', 12);
//$pdf->SetFont('aealarabiya', '', 12);
////$pdf->SetFont('dejavusans', '', 12);
// $pdf->AddPage('L');   //  P  ou L 

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

//$pdf->SetFont('times', 'A', 11);
   
        
// --------------------------------------------------------------------------
//$dd='';
 // debug($soldeinitial);die;
$styl_cadr='style="height: 20px;line-height:10px;"';
$tbl = '
 
<table width="100%">
<tr>
    <td  width="55%">
        <IMG SRC="../webroot/img/'.$logo.'" >
    </td>
    <td  width="45%">
        <table width="100%">
            <tr>
            <br> 
                <td height="35px" align="left" ><strong>Etat de solde Clients</strong></td>'.@$m.'
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
&nbsp;
<br> &nbsp;
<table  border="1" align="center" cellpadding="1" cellspacing="0"  width="100%" class="table">       

<tr bgcolor="#EAEAEA" align="center">
        <th width="7%" align="center"  ><strong>Date</strong></th>
        <th width="8%" align="center"  ><strong>N° Piece</strong></th>
        <th width="37%" align="center"  ><strong>Libellé Piece</strong></th>
        <th width="8%" align="center"  ><strong>Dédit</strong></th>
        <th width="8%" align="center"  ><strong>Crédit</strong></th>
        <th width="8%" align="center"  ><strong>Impayé</strong></th>
        <th width="8%" align="center"  ><strong>Règlement</strong></th>
        <th width="8%" align="center"  ><strong>Avoir</strong></th>
        <th width="8%" align="center"  ><strong>Solde</strong></th>
    </tr>';
        
     
   
        if(!empty($relefes)){
        $totdebit=0;
        $totcredit=0;
        $totimpayer=0;
        $totreg=0; 
        $totavoir=0;
        $totsolde=0;
        $totdebitt=0;
        $totcreditt=0;
        $totimpayert=0;
        $totregt=0; 
        $totavoirt=0;
        $totsoldet=0;
        $clt_id=0;
        $sldtot=0;
        $sldd=0;
        $sld=0;
        //debug($relefes);
        $hh=0;
        $c=0;$t=0;
        foreach ($relefes as $i=>$relefe){
        $totdebitt=$totdebitt+@$relefe['Recouvrement']['debit'];
        $totcreditt=$totcreditt+@$relefe['Recouvrement']['credit'];
        $totimpayert=$totimpayert+@$relefe['Recouvrement']['impaye'];
        $totregt=$totregt+@$relefe['Recouvrement']['reglement'];
        $totavoirt=$totavoirt+@$relefe['Recouvrement']['avoir'];
        $totsoldet=$totsoldet+@$relefe['Recouvrement']['solde'];
            $hh++; 
                   
                    
if ($relefe['Client']['id']!=$clt_id){
$client_ans = ClassRegistry::init('Client')->find('first', array('conditions' => array('Client.id' =>$clt_id), 'recursive' => 0));
        if($i!=0){ 
        
$tbl .='
       <tr>
        <td colspan="3" bgcolor="#EAEAEA" align="center"><strong> Total '.@$client_ans['Client']['code'] .' '. @$client_ans['Client']['name'].' </strong></td>    
        <td  align="right"><strong>'.number_format(@$totdebit,3, '.', ' ').'</strong></td>
        <td  align="right"><strong>'.number_format(@$totcredit,3, '.', ' ').'</strong></td>
        <td  align="right"><strong>'.number_format(@$totimpayer,3, '.', ' ').'</strong></td>
        <td  align="right"><strong>'.number_format(@$totreg,3, '.', ' ').'</strong></td>
        <td  align="right"><strong>'.number_format(@$totavoir,3, '.', ' ').'</strong></td>
        <td  align="right"><strong>'.number_format(@$sld,3, '.', ' ').'</strong></td>
      </tr>';
        $totdebit=0;
        $totcredit=0;
        $totimpayer=0;
        $totreg=0; 
        $totavoir=0;
        
}
$clientt=ClassRegistry::init('Client')->find('first', array('conditions' => array('Client.id'=>$relefe['Client']['id']),'recursive'=>0 ));
     $soldeint=$clientt['Client']['solderecouvrement'];
$client_contact = ClassRegistry::init('Contact')->find('first', array('conditions' => array('Contact.client_id' =>$relefe['Client']['id'],'Contact.fonction="financier"'), 'recursive' =>-1));
    if($soldeint>0){
    $totdebit=@$totdebit+ $soldeint;   
    }
    if($soldeint<0){
    $totcredit=@$totcredit+ $soldeint;   
    }
    if ($soldeint > 0) {
    $sldtot = @$sldtot + $soldeint;
    }
    if ($soldeint < 0) {
    $sldtot = @$sldtot + $soldeint;
    }
   
            $clientid=@$relefe['Client']['id'];
            $sldd=0;
            $sld=0;
            //$sldtot=$soldeint;
            $sld=$soldeint;  
     
            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id ='.$clientid;
            $condfa3='Factureavoir.client_id ='.$clientid;
            $condr3 = 'Reglementclient.client_id ='.$clientid;







$soldedeb="";$soldecred="";
$sld=$soldeint;$soldecredd=0;
$soldedebb=0;
if($soldeint>0){
 $soldedeb=$soldeint;  
 $soldedebb=$soldeint;
}
if($soldeint<0){
 $soldecredd=$soldeint;   
 $soldecred=$soldeint*(-1);   
}
$tbl .='<tr>
    <td bgcolor="#EAEAEA" align="center"><strong> Client </strong></td>    
    <td colspan="5"  align="left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;'. @$relefe['Client']['code'].'  '.@$relefe['Client']['name']. '</strong></td>
    <td colspan="3" align="left" >FINANCIER : '. @$client_contact['Contact']['tel'].'</td>
</tr>
<tr>
    <td bgcolor="#EAEAEA" width="52%" align="center" colspan="3"><strong> Solde départ </strong></td> 
       
        <td width="8%" nobr="nobr" align="right"   ><strong>'.number_format(@$soldedeb,3, '.', ' ').'</strong></td>
        <td width="8%" nobr="nobr" align="right"   ><strong>'.number_format(@$soldecred,3, '.', ' ').'</strong></td>
        <td width="8%" nobr="nobr" align="right"  ></td>
        <td width="8%" nobr="nobr" align="right"  ></td> 
        <td width="8%" nobr="nobr" align="right"  ></td> 
        <td width="8%" nobr="nobr" align="right"  ><strong>'.number_format(@$soldeint,3, '.', ' ').'</strong></td> 
</tr>';

}
if($relefe['Recouvrement']['debit']!=null) {
           // debug("debit");die;
     if($relefe['Recouvrement']['typ']=="imp"){
         $sld=$sld+($relefe['Recouvrement']['debit']-$relefe['Recouvrement']['impaye']);
     }else{
         $sld=$sld+($relefe['Recouvrement']['debit']-$relefe['Recouvrement']['reglement']);
     }
        }else{
            // debug("credit");die;
             $sld=$sld-($relefe['Recouvrement']['credit']-$relefe['Recouvrement']['reglement']);
        }    
$clt_id=$relefe['Client']['id'];
                        
     
            
        
        
        $tbl .= 
    '<tr  align="center"  >    
        <td  width="7%" nobr="nobr" align="center"  ><strong>'.date("d/m/Y",strtotime(str_replace('/','-',@$relefe['Recouvrement']['date']))).'</strong></td>
        <td  width="8%" nobr="nobr" align="center"   >'.@$relefe['Recouvrement']['numero'].'</td>
        <td  width="37%" nobr="nobr" align="left"   >'.@$relefe['Recouvrement']['type'].'</td>    
        <td  width="8%" nobr="nobr" align="right"   >'.number_format(@$relefe['Recouvrement']['debit'],3, '.', ' ').'</td>
        <td  width="8%" nobr="nobr" align="right"   >'.number_format(@$relefe['Recouvrement']['credit'],3, '.', ' ').'</td>
        <td  width="8%" nobr="nobr" align="right"  >'.number_format(@$relefe['Recouvrement']['impaye'],3, '.', ' ').'</td>
        <td  width="8%" nobr="nobr" align="right"  >'.number_format(@$relefe['Recouvrement']['reglement'],3, '.', ' ').'</td> 
        <td  width="8%" nobr="nobr" align="right"  >'.number_format(@$relefe['Recouvrement']['avoir'],3, '.', ' ').'</td> 
        <td  width="8%" nobr="nobr" align="right"  >'.number_format(@$relefe['Recouvrement']['solde'],3, '.', ' ').'</td> 
    </tr>';    
 
 $totdebit=$totdebit+@$relefe['Recouvrement']['debit'];
        $totcredit=$totcredit+@$relefe['Recouvrement']['credit'];
        $totimpayer=$totimpayer+@$relefe['Recouvrement']['impaye'];
        $totreg=$totreg+@$relefe['Recouvrement']['reglement'];
        $totavoir=$totavoir+@$relefe['Recouvrement']['avoir'];
        if($relefe['Recouvrement']['debit']!=null) {
           // debug("debit");die;
        if($relefe['Recouvrement']['typ']=="imp"){    
         $sldd=$sldd+($relefe['Recouvrement']['debit']-$relefe['Recouvrement']['impaye']);
        }else{    
         $sldd=$sldd+($relefe['Recouvrement']['debit']-$relefe['Recouvrement']['reglement']);
        }
        }else{
            // debug("credit");die;
             $sldd=$sldd-($relefe['Recouvrement']['credit']-$relefe['Recouvrement']['reglement']);
        } 
        if($relefe['Recouvrement']['debit']!=null) {
           // debug("debit");die;
        if($relefe['Recouvrement']['typ']=="imp"){ 
         $sldtot=$sldtot+($relefe['Recouvrement']['debit']-$relefe['Recouvrement']['impaye']);
        }  else{  
         $sldtot=$sldtot+($relefe['Recouvrement']['debit']-$relefe['Recouvrement']['reglement']);
        }
        }else{
            // debug("credit");die;
        $sldtot=$sldtot-($relefe['Recouvrement']['credit']-$relefe['Recouvrement']['reglement']);
        }
//        if($soldeint>0){
//        $sldtot=@$sldtot+ $soldeint;   
//        }
//        if($soldeint<0){
//        $sldtot=@$sldtot+ $soldeint;   
//        }
        }
        
 }
 if($soldeint>0){
    $totdebit=@$totdebit+ $soldeint;   
    }
    if($soldeint<0){
    $totcredit=@$totcredit+ $soldeint;   
    }
      $tbl .=  
       ' 
           <tr bgcolor="#EAEAEA" align="center">  
                <td colspan="3" align="center" width="52%"   ><strong>Total '.@$relefe['Client']['code'] .' '. @$relefe['Client']['name'].' </strong></td>
                <td  align="right" width="8%"><strong>'.number_format((@$totdebit),3, '.', ' ').'</strong></td>
                <td  align="right" width="8%"><strong>'.number_format((@$totcredit),3, '.', ' ').'</strong></td>     
                <td  align="right" width="8%"><strong>'.number_format(@$totimpayer,3, '.', ' ').'</strong></td>
                <td  align="right" width="8%"><strong>'.number_format(@$totreg,3, '.', ' ').'</strong></td>
                <td  align="right" width="8%"><strong>'.number_format(@$totavoir,3, '.', ' ').'</strong></td>
                <td  align="right" width="8%"><strong>'.number_format(@$sldd,3, '.', ' ').'</strong></td>
           </tr>
            <tr bgcolor="#EAEAEA" align="center">  
                <td colspan="3" align="center" width="52%"   ><strong>Total Générale</strong></td>
                <td  align="right" width="8%"><strong>'.number_format((@$totdebitt),3, '.', ' ').'</strong></td>
                <td  align="right" width="8%"><strong>'.number_format((@$totcreditt),3, '.', ' ').'</strong></td>     
                <td  align="right" width="8%"><strong>'.number_format((@$totimpayert),3, '.', ' ').'</strong></td>
                <td  align="right" width="8%"><strong>'.number_format((@$totregt),3, '.', ' ').'</strong></td>
                <td  align="right" width="8%"><strong>'.number_format((@$totavoirt),3, '.', ' ').'</strong></td>
                <td  align="right" width="8%"><strong>'.number_format((@$sldtot),3, '.', ' ').'</strong></td>
           </tr>
           ';
        
$tbl .= 
        ' 
</table> <br><br>
';

           
            
           
 $tbl .='
</table>            
';
    

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('releve_client.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
