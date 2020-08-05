
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
if(!empty($date1) && !empty($date2)){
$date1=date('d/m/Y', strtotime(str_replace('-', '/',$date1)));
$date2=date('d/m/Y', strtotime(str_replace('-', '/',$date2)));
$m=' du  '.$date1.' au  '.$date2;
}
// ---------------------------------------------------------

$pdf->AddPage('L');

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 12);
$logo=  CakeSession::read('logo');
$footer = 'Thermeco';

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
if(($testclient==0)&&($testarticle==1)){$val="Client"; }else { $val="Article";  }

$tbl = '
 
<table width="100%">
<tr>
    <td  width="55%">
        <IMG SRC="../webroot/img/'.$soc['Societe']['logo'].'" >
    </td>
    <td  width="45%">
        <table width="100%">
            <tr>
            <br> 
                <td height="35px" align="left" ><strong>Etat de solde Commande Clients</strong></td>'.@$m.'
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
<table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       

<tr bgcolor="#FFFFFF" align="center">
        <th width="8%" align="center"  ><strong>Délai Liv</strong></th>
        <th width="44%" align="center"  ><strong>'.$val.'</strong></th>
        <th width="6%" align="center"  ><strong>Q.Com</strong></th>
        <th width="6%" align="center"  ><strong>Q.Liv</strong></th>
        <th width="8%" align="center"  ><strong>Solde</strong></th>
        <th width="8%" align="center"  ><strong>M.TTC</strong></th>
        <th width="12%" align="center"  ><strong>B.Com</strong></th>
        <th width="8%" align="center"  ><strong>Date</strong></th>
    </tr>';
        
if(!empty($name)){                       
$tbl .='<tr>
    <td style="background-color: #FFFFFF;" align="center"> Client </td>    <td colspan="8" bgcolor="#F2D7D5" ><strong>'. @$name .'</strong></td>
    </tr>';
 }     
   
       
        $totqte=0;
        $totqteliv=0;
        $totsolde=0;
        $totttc=0;
        $clt_id=0;
        $art_id=0;
        $hh=0;
        //debug($testarticle);
        //debug($testclient);die;
        foreach ($lignecommandes as $i=>$lignecommande){
       if(empty($name)){ 
        $obj = ClassRegistry::init('Client');
        $test = $obj->find('first',array('conditions'=>array('Client.id'=>$lignecommande['Commandeclient']['client_id']),'recursive'=>-1));
        }  
         $hh++; 
                    if($hh==13){
                        $tbl.='</table>';
                        $pdf->writeHTML($tbl, true, false, false, false, '');
                        $pdf->AddPage('L');
                        $hh=0;
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
                <td height="35px" align="left" ><strong>Etat de solde Commande Clients</strong></td>'.@$m.'
            </tr>
        </table>
    </td>
</tr>
<br>
<tr>
    <td align="left" width="55%"  >' . $soc['Societe']['adresse'] . '</td>
    <td align="left" width="45%" ><strong>TÃ©l : </strong>' . $soc['Societe']['tel'] . '</td>
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
<table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       

<tr bgcolor="#FFFFFF" align="center">
        <th width="8%" align="center"  ><strong>Délai Liv</strong></th>
        <th width="44%" align="center"  ><strong>'.$val.'</strong></th>
        <th width="6%" align="center"  ><strong>Q.Com</strong></th>
        <th width="6%" align="center"  ><strong>Q.Liv</strong></th>
        <th width="8%" align="center"  ><strong>Solde</strong></th>
        <th width="8%" align="center"  ><strong>M.TTC</strong></th>
        <th width="12%" align="center"  ><strong>B.Com</strong></th>
        <th width="8%" align="center"  ><strong>Date</strong></th>
    </tr>';
        
        } 
        
        
 if(($testclient==0)&&($testarticle==0)){
 if ($lignecommande['Commandeclient']['client_id']!=$clt_id){   
    if($i!=0){ 
        
$tbl .='
       <tr>
        <td colspan="3" bgcolor="#F2D7D5" align="center"><strong> Total Client  </strong></td>    
        <td  align="right"><strong>'.@$totqte.'</strong></td>
        <td  align="right"><strong>'.@$totqteliv.'</strong></td>
        <td  align="right"><strong>'.@$totsolde.'</strong></td>
        <td  align="right"><strong>'.@$totttc.'</strong></td>
        <td colspan="2" bgcolor="#F2D7D5" align="center"><strong>   </strong></td>
      </tr>';
       $totqte=0;
       $totqteliv=0;
       $totsolde=0;
       $totttc=0; 
        
} 

$tbl .='<tr>
    <td bgcolor="#FFFFFF" align="center"><strong> Client </strong></td>    <td colspan="8" bgcolor="#F2D7D5"  ><strong>&nbsp;&nbsp;&nbsp;&nbsp;'. @$test['Client']['code'].'  '.@$test['Client']['name']. '</strong></td>
</tr>';

}}
$clt_id=$lignecommande['Commandeclient']['client_id'];                   
   
                        
//****************************************************************************************************
if(($testclient==0)&&($testarticle==1)){
 if ($lignecommande['Article']['id']!=$art_id){   
        if($i!=0){ 
        
$tbl .='
       <tr>
        <td colspan="3" bgcolor="#F2D7D5" align="center"><strong> Total Article  </strong></td>    
        <td  align="right"><strong>'.@$totqte.'</strong></td>
        <td  align="right"><strong>'.@$totqteliv.'</strong></td>
        <td  align="right"><strong>'.@$totsolde.'</strong></td>
        <td  align="right"><strong>'.@$totttc.'</strong></td>
        <td colspan="2" bgcolor="#F2D7D5" align="center"><strong>   </strong></td>
      </tr>';
        $totqte=0;
        $totqteliv=0;
        $totsolde=0;
        $totttc=0; 
        
} 

$tbl .='<tr>
    <td bgcolor="#FFFFFF" align="center"><strong> Article </strong></td>    <td colspan="8" bgcolor="#F2D7D5" ><strong>&nbsp;&nbsp;&nbsp;&nbsp;'. @$lignecommande['Article']['code'].'  '.@$lignecommande['Article']['name']. '</strong></td>
</tr>';

}}
$art_id=$lignecommande['Article']['id']; 


       
        $totqte=$totqte+$lignecommande['Lignecommandeclient']['quantite'];
        $totqteliv=$totqteliv+$lignecommande['Lignecommandeclient']['quantiteliv'];
        $totsolde=$totsolde+($lignecommande['Lignecommandeclient']['quantite']-$lignecommande['Lignecommandeclient']['quantiteliv']);
        $totttc=$totttc+($lignecommande['Lignecommandeclient']['puttc']*($lignecommande['Lignecommandeclient']['quantite']-$lignecommande['Lignecommandeclient']['quantiteliv']));
       
if(!empty($lignecommande['Commandeclient']['dateliv'])){$date_liv=date("d-m-Y",strtotime(str_replace('/','-',$lignecommande['Commandeclient']['dateliv'])));}
$a=$lignecommande['Lignecommandeclient']['quantite']-$lignecommande['Lignecommandeclient']['quantiteliv'];
$b=$lignecommande['Lignecommandeclient']['puttc']*($lignecommande['Lignecommandeclient']['quantite']-$lignecommande['Lignecommandeclient']['quantiteliv']);
$a=sprintf('%.3f',$a);
$b=sprintf('%.3f',$b);

                 if(($testclient==0)&&($testarticle==1)){  
		 $code=$test['Client']['code'] ;
                 $n=$test['Client']['name'] ;
                 }
                 if(($testclient==1)&&($testarticle==0)){  
                 $code=$lignecommande['Article']['code'] ;
                 $n=$lignecommande['Article']['name'] ;
                } 
                 if(($testclient==0)&&($testarticle==0)){  
                 $code=$lignecommande['Article']['code'] ;
                 $n=$lignecommande['Article']['name'] ;
                } 
                 if(($testclient==1)&&($testarticle==1)){  
                 $code=$lignecommande['Article']['code'] ;
                 $n=$lignecommande['Article']['name'] ;
                } 





$tbl .= 
    '<tr  align="center">    
        <td width="8%" nobr="nobr" align="center"  ><strong>'.@$date_liv.'</strong></td>
        <td width="10%" nobr="nobr" align="center"   >'.@$code.'</td>
        <td width="34%" nobr="nobr" align="left"   >'.@$n .'</td>
        <td width="6%" nobr="nobr" align="right"   >'.@$lignecommande['Lignecommandeclient']['quantite'].'</td>
        <td width="6%" nobr="nobr" align="right"   >'.@$lignecommande['Lignecommandeclient']['quantiteliv'].'</td>
        <td width="8%" nobr="nobr" align="right"  >'.$a.'</td>
        <td width="8%" nobr="nobr" align="right"  >'.$b.'</td> 
        <td width="12%" nobr="nobr" align="center"  >'.@$lignecommande['Commandeclient']['numero'].'</td> 
        <td width="8%" nobr="nobr" align="center"  >'.@date("d-m-Y",strtotime(str_replace('/','-',$lignecommande['Commandeclient']['date']))).'</td> 
    </tr>';    
 
 
        
        }
 $tottt=sprintf('%.3f',$totttc);
      $tbl .=  
       ' 
           <tr  align="center">  
                <td colspan="3" bgcolor="#F2D7D5" align="center"    ><strong>Total </strong></td>
                <td  align="right" width="6%"><strong>'.@$totqte.'</strong></td>
                <td  align="right" width="6%"><strong>'.@$totqteliv.'</strong></td>     
                <td  align="right" width="8%"><strong>'.@$totsolde.'</strong></td>
                <td  align="right" width="8%"><strong>'.@$tottt.'</strong></td>
                <td colspan="2" bgcolor="#F2D7D5" align="center"><strong>   </strong></td>
           </tr>';
           
        
           
            
           
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