
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
$pdf->SetTitle('Historique utilisateur');

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
if($date1!="" && $date2!=""){
$date1=date('d/m/Y', strtotime(str_replace('-', '/',$date1)));
$date2=date('d/m/Y', strtotime(str_replace('-', '/',$date2)));
$m=' du  '.$date1.' au  '.$date2;
}
// ---------------------------------------------------------

$pdf->AddPage();

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
                <td height="35px" align="left" ><strong>Historique'.$m.'</strong></td> 
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
                        <th width="25%" align="center" $zz height="30px" ><strong>Utilisateur</strong></th>
                        <th width="25%" align="center" $zz ><strong>Horaire</strong></th>
                        <th width="50%" align="center" $zz ><strong>Action</strong></th>
                  
   </tr>';
        $i=0;$total=0;
       // debug($commfournisseurs);die;
       foreach ($bonlivraisons as $tracemisejour){
          
           
            $wakt = date('H:i',strtotime('+1 hour',strtotime($tracemisejour['Tracemisejour']['heure'])));
       
        $oper="";
        $pag="";
        if($tracemisejour['Tracemisejour']['operation']=="add"){
            $oper="Ajout";
        }
        if($tracemisejour['Tracemisejour']['operation']=="edit"){
            $oper="Modification";
        }
        if($tracemisejour['Tracemisejour']['operation']=="delete"){
            $oper="Suppression";
        }
        
        if($tracemisejour['Tracemisejour']['model']=="Factureclient"){
            $pag="Facture client";
        }else{
        if($tracemisejour['Tracemisejour']['model']=="Commandeclient"){
            $pag="Commande client";
        }else{
        if($tracemisejour['Tracemisejour']['model']=="Reglementclient"){
            $pag="Reglement client";
        }else{
         if($tracemisejour['Tracemisejour']['model']=="Bonlivraison"){
            $pag="Bon livraison";
        }else{
        if($tracemisejour['Tracemisejour']['model']=="Factureavoir"){
            $pag="Facture avoir client";
        }else{
        if($tracemisejour['Tracemisejour']['model']=="Factureavoirfr"){
            $pag="Facture avoir fournisseur";
        }else{
           $pag= $tracemisejour['Tracemisejour']['model'];
        }
        }}}}}
        if($tracemisejour['Tracemisejour']['operation']=="delete"){
            $numero=" Numéro : ".$tracemisejour['Tracemisejour']['numero'];
        }else{
            if($tracemisejour['Tracemisejour']['model']=="Retrait"){
                $modeltoucher = ClassRegistry::init('Bordereau')->find('first',array('conditions'=>array('Bordereau.id' => $tracemisejour['Tracemisejour']['id_piece'])));  
            $numero=" Numéro : ".@$modeltoucher['Bordereau']['numero'];
            }else{
            $modeltoucher = ClassRegistry::init($tracemisejour['Tracemisejour']['model'])->find('first',array('conditions'=>array($tracemisejour['Tracemisejour']['model'].'.id' => $tracemisejour['Tracemisejour']['id_piece'])));  
            $numero=" Numéro : ".@$modeltoucher[$tracemisejour['Tracemisejour']['model']]['numero'];
        }
        }
           
           
           
           
            $i++;
            if($i==20){
                $tbl .='</table>';
                $pdf->writeHTML($tbl, true, false, false, false, '');
                $pdf->AddPage('P');
                $i=0;
                $tbl='
                    <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                   <tr bgcolor="#FFFFFF" align="center">
                        <th width="25%" align="center" $zz height="30px" ><strong>Utilisateur</strong></th>
                        <th width="25%" align="center" $zz ><strong>Horaire</strong></th>
                        <th width="50%" align="center" $zz ><strong>Action</strong></th>
                  
   </tr>';
            }
            
          
               
        $tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="25%" nobr="nobr" align="center" height="30px" $zz>'.$tracemisejour['Utilisateur']['Personnel']['name'].'</td>
        <td width="25%" nobr="nobr" align="center"  $zz>'.date("d/m/Y", strtotime(str_replace('-', '/',$tracemisejour['Tracemisejour']['date'])))." ".$wakt.'</td>
        <td width="50%" nobr="nobr" align="center"  $zz>'.$oper." ".$pag." ".@$numero.'</td>
        
    </tr>' ;     
}

$tbl .= '</table>';
    

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('historique.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>