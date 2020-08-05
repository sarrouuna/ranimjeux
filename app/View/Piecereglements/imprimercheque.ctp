
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
if($Date_debut!="" && $Date_fin!=""){
$Date_debut=date('d/m/Y', strtotime(str_replace('-', '/',$Date_debut)));
$Date_fin=date('d/m/Y', strtotime(str_replace('-', '/',$Date_fin)));
$m=' entre  '.$Date_debut.' et  '.$Date_fin;
}
// ---------------------------------------------------------

$pdf->AddPage('L');

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
                <td height="35px" align="left" ><strong>liste des chèques '.$m.'</strong></td> 
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
        
// --------------------------------------------------------------------------
$az="En attente";
if(!empty($situation)){
   $az=$situation; 
}
$zz='style="font-family:Arial, Helvetica, sans-serif;font-size:13px; border-top:2px solid black;border-left:2px solid black;border-right:2px solid black;"';
$ff='style="font-family:Arial, Helvetica, sans-serif;font-size:25px;"';
$tbl .= '
   
 <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
 <tr><td align="center" '.$ff.'><strong>'.$az.'</strong></td></tr>     
     <tr bgcolor="#FFFFFF" align="center">
        <th width="18%" align="center" $zz height="30px" ><strong>Fournisseur</strong></th>
        <th width="16%" align="center" $zz ><strong>Numéro</strong></th>
        <th width="16%" align="center" $zz ><strong>Compte</strong></th>
        <th width="18%" align="center" $zz ><strong>Encaissement</strong></th>
        <th width="16%" align="center" $zz ><strong>Echéance</strong></th>
         <th width="16%" align="center" $zz><strong>Montant</strong></th>
   </tr>';
    $tot=0;
        if(!empty($situation)){
            $hhk=0;
    foreach ($piecereglements as $k=>$piece){
        $hhk++;
                          if($hhk==10){
                              $tbl.='</table>';
                              $pdf->writeHTML($tbl, true, false, false, false, '');
                              $pdf->AddPage('L');
                              $hhk=0;
                   $tbl = '
                       <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                    <tr><td align="center" '.$ff.'><strong>'.$az.'</strong></td></tr>     
                        <tr bgcolor="#FFFFFF" align="center">
                           <th width="18%" align="center" $zz height="30px" ><strong>Fournisseur</strong></th>
                           <th width="16%" align="center" $zz ><strong>Numéro</strong></th>
                           <th width="16%" align="center" $zz ><strong>Compte</strong></th>
                           <th width="18%" align="center" $zz ><strong>Encaissement</strong></th>
                           <th width="16%" align="center" $zz ><strong>Echéance</strong></th>
                            <th width="16%" align="center" $zz><strong>Montant</strong></th>
                      </tr>';
                          }
$bn=0;$compt=0;
            if($situation=='En attente'){
                $bbb=$piece['Compte']['banque'];
            }
            else{
                $bn= $piece['Compte']['banque'];  //debug($bn);die;
                $compt= $piece['Compte']['rib'];
                $bbb=$bn.'  '.$compt;
            }
            
            $tot=$tot+$piece['Piecereglement']['montant'];
            $tot=  sprintf('%.3f',$tot);
        $tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="18%" nobr="nobr" align="center" height="30px" $zz>'.$fournisseurs[$piece['Reglement']['fournisseur_id']].'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$piece['Piecereglement']['num'].'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$bbb.'</td>   
        <td width="18%" nobr="nobr" align="center"   $zz>'.date("d/m/Y",strtotime(str_replace('-','/',($piece['Reglement']['Date'])))).'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.date("d/m/Y",strtotime(str_replace('-','/',($piece['Piecereglement']['echance'])))).'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$piece['Piecereglement']['montant'].'</td>
        
        
    </tr>' ;      
}
$tbl .= '      
    <tr bgcolor="#FFFFFF" align="center">  
        <td colspan="5"width="84%" nobr="nobr" align="center" height="30px" ></td>
        <td width="16%" nobr="nobr" align="center"  $zz><strong>'.$tot.'</strong></td>
    </tr>';
    }
    
    if(empty($situation)){
//----------------------- En attente------------------------
        if(!empty($piece_att)){
            $tot_att=0;$hh=0;
         foreach ($piece_att as $k=>$piece){
             $hh++;
                        if($hh==15){
                             $tbl .=  '</table>';
                 
                            $pdf->writeHTML($tbl, true, false, false, false, '');
                             $pdf->AddPage('L');   //  P  ou L 
                            $hh=0;
                            $tbl='
                            <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                                <tr><td align="center" '.$ff.'><strong>'.$az.'</strong></td></tr>     
                                     <tr bgcolor="#FFFFFF" align="center">
                                        <th width="18%" align="center" $zz height="30px" ><strong>Fournisseur</strong></th>
                                        <th width="16%" align="center" $zz ><strong>Numéro</strong></th>
                                        <th width="16%" align="center" $zz ><strong>Compte</strong></th>
                                        <th width="18%" align="center" $zz ><strong>Encaissement</strong></th>
                                        <th width="16%" align="center" $zz ><strong>Echéance</strong></th>
                                         <th width="16%" align="center" $zz><strong>Montant</strong></th>
                                    </tr>';
                        }
             
$bn=0;$compt=0;
            $bn= $piece['Compte']['banque'];  //debug($bn);die;
            $compt= $piece['Compte']['rib'];
            $tot_att=$tot_att+$piece['Piecereglement']['montant'];
            $tot_att=  sprintf('%.3f',$tot_att);
            $bbb=$bn.'  '.$compt;
        $tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="18%" nobr="nobr" align="center" height="30px" $zz>'.$fournisseurs[$piece['Reglement']['fournisseur_id']].'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$piece['Piecereglement']['num'].' </td>
        <td width="16%" nobr="nobr" align="center"  $zz> '.$bbb.'</td>
        <td width="18%" nobr="nobr" align="center"  $zz>'.date("d/m/Y",strtotime(str_replace('-','/',($piece['Reglement']['Date'])))).'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.date("d/m/Y",strtotime(str_replace('-','/',($piece['Piecereglement']['echance'])))).'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$piece['Piecereglement']['montant'].'</td>
        
       
    </tr>' ;      
                }
                
                $tbl .= '      
                <tr bgcolor="#FFFFFF" align="center">  
                    <td colspan="5"width="84%" nobr="nobr" align="center" height="30px" ></td>
                    <td width="16%" nobr="nobr" align="center"  $zz><strong>'.$tot_att.'</strong></td>
                </tr>';
        }
//---------------------------- Versé ----------------------------------------
            if(!empty($piece_ver)){
                
                $tbl .='</table>';
                  $pdf->writeHTML($tbl, true, false, false, false, '');
                      $pdf->AddPage('L');
                   $tbl = '
                      
                       <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                     <tr><td align="center" '.$ff.'><strong>Versé</strong></td></tr>
                            
                         <tr bgcolor="#FFFFFF" align="center">
                            <th width="18%" align="center" $zz height="30px" ><strong>Fournisseur</strong></th>
                            <th width="16%" align="center" $zz ><strong>Numéro</strong></th>
                            <th width="16%" align="center" $zz ><strong>Compte</strong></th>
                            <th width="18%" align="center" $zz ><strong>Encaissement</strong></th>
                            <th width="16%" align="center" $zz ><strong>Echéance</strong></th>
                             <th width="16%" align="center" $zz><strong>Montant</strong></th>
                        </tr>';
                  $tot_ver=0; $hh=0;    
 foreach ($piece_ver as $k=>$piece){
     $hh++;
                        if($hh==15){
                             $tbl .=  '</table>';
                 
                            $pdf->writeHTML($tbl, true, false, false, false, '');
                             $pdf->AddPage('L');   //  P  ou L 
                            $hh=0;
                            $tbl='
                   <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                    <tr><td align="center" '.$ff.'><strong>Versé</strong></td></tr>
                            
                         <tr bgcolor="#FFFFFF" align="center">
                            <th width="18%" align="center" $zz height="30px" ><strong>Fournisseur</strong></th>
                            <th width="16%" align="center" $zz ><strong>Numéro</strong></th>
                            <th width="16%" align="center" $zz ><strong>Compte</strong></th>
                            <th width="18%" align="center" $zz ><strong>Encaissement</strong></th>
                            <th width="16%" align="center" $zz ><strong>Echéance</strong></th>
                             <th width="16%" align="center" $zz><strong>Montant</strong></th>
                        </tr>';
                        }
                            
                            
$bn=0;$compt=0;
            $bn= $piece['Compte']['banque'];  //debug($bn);die;
            $compt= $piece['Compte']['rib'];
            $tot_ver=$tot_ver+$piece['Piecereglement']['montant'];
            $tot_ver=  sprintf('%.3f',$tot_ver);
        $tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="18%" nobr="nobr" align="center" height="30px" $zz>'.$fournisseurs[$piece['Reglement']['fournisseur_id']].'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$piece['Piecereglement']['num'].'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$bn.'  '.$compt.'</td>
        <td width="18%" nobr="nobr" align="center"   $zz>'.date("d/m/Y",strtotime(str_replace('-','/',($piece['Reglement']['Date'])))).'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.date("d/m/Y",strtotime(str_replace('-','/',($piece['Piecereglement']['echance'])))).'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$piece['Piecereglement']['montant'].'</td>
        
        
    </tr>' ;      
                       }
                       $tbl .= '      
                <tr bgcolor="#FFFFFF" align="center">  
                    <td colspan="5"width="84%" nobr="nobr" align="center" height="30px" ></td>
                    <td width="16%" nobr="nobr" align="center"  $zz><strong>'.$tot_ver.'</strong></td>
                </tr>';
            }
//-----------------------------------Preavis ---------------------
            if(!empty($piece_pre)){
                
                $tbl .='</table>';
                  $pdf->writeHTML($tbl, true, false, false, false, '');
                      $pdf->AddPage('L');
                   $tbl = '
                     
                       <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                    <tr><td align="center" '.$ff.'><strong>Preavis</strong></td></tr>
                         <tr bgcolor="#FFFFFF" align="center">
                            <th width="18%" align="center" $zz height="30px" ><strong>Fournisseur</strong></th>
                            <th width="16%" align="center" $zz ><strong>Numéro</strong></th>
                            <th width="16%" align="center" $zz ><strong>Compte</strong></th>
                            <th width="18%" align="center" $zz ><strong>Encaissement</strong></th>
                            <th width="16%" align="center" $zz ><strong>Echéance</strong></th>
                             <th width="16%" align="center" $zz><strong>Montant</strong></th>
                       </tr>';   
                $tot_pre=0;$hh=0;
 foreach ($piece_pre as $k=>$piece){
     $hh++;
                        if($hh==15){
                             $tbl .=  '</table>';
                 
                            $pdf->writeHTML($tbl, true, false, false, false, '');
                             $pdf->AddPage('L');   //  P  ou L 
                            $hh=0;
                            $tbl = '
                     
                       <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                    <tr><td align="center" '.$ff.'><strong>Préavis</strong></td></tr>
                         <tr bgcolor="#FFFFFF" align="center">
                            <th width="18%" align="center" $zz height="30px" ><strong>Fournisseur</strong></th>
                            <th width="16%" align="center" $zz ><strong>Numéro</strong></th>
                            <th width="16%" align="center" $zz ><strong>Compte</strong></th>
                            <th width="18%" align="center" $zz ><strong>Encaissement</strong></th>
                            <th width="16%" align="center" $zz ><strong>Echéance</strong></th>
                             <th width="16%" align="center" $zz><strong>Montant</strong></th>
                       </tr>'; 
                        }
                            
$bn=0;$compt=0;
            $bn= $piece['Compte']['banque'];  //debug($bn);die;
            $compt= $piece['Compte']['rib'];
            $tot_pre=$tot_pre+$piece['Piecereglement']['montant'];
            $tot_pre=  sprintf('%.3f',$tot_pre);
        $tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="18%" nobr="nobr" align="center" height="30px" $zz>'.$fournisseurs[$piece['Reglement']['fournisseur_id']].'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$piece['Piecereglement']['num'].'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$bn.'  '.$compt.'</td>
        <td width="18%" nobr="nobr" align="center"   $zz>'.date("d/m/Y",strtotime(str_replace('-','/',($piece['Reglement']['Date'])))).'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.date("d/m/Y",strtotime(str_replace('-','/',($piece['Piecereglement']['echance'])))).'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$piece['Piecereglement']['montant'].'</td>
        
       
    </tr>' ; 
 }
 $tbl .= '      
                <tr bgcolor="#FFFFFF" align="center">  
                    <td colspan="5"width="84%" nobr="nobr" align="center" height="30px" ></td>
                    <td width="16%" nobr="nobr" align="center"  $zz><strong>'.$tot_pre.'</strong></td>
                </tr>';
}
//-------------------------------- Paye----------------------------------------
        if(!empty($piece_pay)){
            
            $tbl .='</table>';
                  $pdf->writeHTML($tbl, true, false, false, false, '');
                      $pdf->AddPage('L');
                   $tbl = '
                      
                       <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                   <tr><td align="center" '.$ff.'><strong>Payé</strong></td></tr>
                        <tr bgcolor="#FFFFFF" align="center">
                            <th width="18%" align="center" $zz height="30px" ><strong>Fournisseur</strong></th>
                            <th width="16%" align="center" $zz ><strong>Numéro</strong></th>
                            <th width="16%" align="center" $zz ><strong>Compte</strong></th>
                            <th width="18%" align="center" $zz ><strong>Encaissement</strong></th>
                            <th width="16%" align="center" $zz ><strong>Echéance</strong></th>
                             <th width="16%" align="center" $zz><strong>Montant</strong></th>
                    </tr>';  
             $tot_pay=0;$hh=0;
 foreach ($piece_pay as $k=>$piece){
     $hh++;
                        if($hh==15){
                             $tbl .=  '</table>';
                 
                            $pdf->writeHTML($tbl, true, false, false, false, '');
                             $pdf->AddPage('L');   //  P  ou L 
                            $hh=0;
                            $tbl = '
                      
                       <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                   <tr><td align="center" '.$ff.'><strong>Payé</strong></td></tr>
                        <tr bgcolor="#FFFFFF" align="center">
                            <th width="18%" align="center" $zz height="30px" ><strong>Fournisseur</strong></th>
                            <th width="16%" align="center" $zz ><strong>Numéro</strong></th>
                            <th width="16%" align="center" $zz ><strong>Compte</strong></th>
                            <th width="18%" align="center" $zz ><strong>Encaissement</strong></th>
                            <th width="16%" align="center" $zz ><strong>Echéance</strong></th>
                             <th width="16%" align="center" $zz><strong>Montant</strong></th>
                    </tr>'; 
                        }
$bn=0;$compt=0;
            $bn= $piece['Compte']['banque'];  //debug($bn);die;
            $compt= $piece['Compte']['rib'];
            $tot_pay=$tot_pay+$piece['Piecereglement']['montant'];
            $tot_pay=  sprintf('%.3f',$tot_pay);
        $tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="18%" nobr="nobr" align="center" height="30px" $zz>'.$fournisseurs[$piece['Reglement']['fournisseur_id']].'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$piece['Piecereglement']['num'].'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$bn.'  '.$compt.'</td>
        <td width="18%" nobr="nobr" align="center"   $zz>'.date("d/m/Y",strtotime(str_replace('-','/',($piece['Reglement']['Date'])))).'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.date("d/m/Y",strtotime(str_replace('-','/',($piece['Piecereglement']['echance'])))).'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$piece['Piecereglement']['montant'].'</td>
       
       
    </tr>' ; 
 }
 $tbl .= '      
                <tr bgcolor="#FFFFFF" align="center">  
                    <td colspan="5"width="84%" nobr="nobr" align="center" height="30px" ></td>
                    <td width="16%" nobr="nobr" align="center"  $zz><strong>'.$tot_pay.'</strong></td>
                </tr>';
}
//------------------------------------- Impaye ----------------------
        if(!empty($piece_imp)){
            
            
            $tbl .='</table>';
                  $pdf->writeHTML($tbl, true, false, false, false, '');
                      $pdf->AddPage('L');
                   $tbl = '
                       
                       <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                     <tr><td align="center" '.$ff.'><strong>Impayé</strong></td></tr>
                         <tr bgcolor="#FFFFFF" align="center">
                            <th width="18%" align="center" $zz height="30px" ><strong>Fournisseur</strong></th>
                            <th width="16%" align="center" $zz ><strong>Numéro</strong></th>
                            <th width="16%" align="center" $zz ><strong>Compte</strong></th>
                            <th width="18%" align="center" $zz ><strong>Encaissement</strong></th>
                            <th width="16%" align="center" $zz ><strong>Echéance</strong></th>
                             <th width="16%" align="center" $zz><strong>Montant</strong></th>
                    </tr>';  
            $tot_imp=0;$hh=0;
 foreach ($piece_imp as $k=>$piece){
     $hh++;
                        if($hh==15){
                             $tbl .=  '</table>';
                 
                            $pdf->writeHTML($tbl, true, false, false, false, '');
                             $pdf->AddPage('L');   //  P  ou L 
                            $hh=0;
                            $tbl = '
                       
                       <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
                     <tr><td align="center" '.$ff.'><strong>Impayé</strong></td></tr>
                         <tr bgcolor="#FFFFFF" align="center">
                            <th width="18%" align="center" $zz height="30px" ><strong>Fournisseur</strong></th>
                            <th width="16%" align="center" $zz ><strong>Numéro</strong></th>
                            <th width="16%" align="center" $zz ><strong>Compte</strong></th>
                            <th width="18%" align="center" $zz ><strong>Encaissement</strong></th>
                            <th width="16%" align="center" $zz ><strong>Echéance</strong></th>
                             <th width="16%" align="center" $zz><strong>Montant</strong></th>
                    </tr>'; 
                        }
$bn=0;$compt=0;
            $bn= $piece['Compte']['banque'];  //debug($bn);die;
            $compt= $piece['Compte']['rib'];
            $tot_imp=$tot_imp+$piece['Piecereglement']['montant'];
            $tot_imp=  sprintf('%.3f',$tot_imp);
        $tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="18%" nobr="nobr" align="center" height="30px" $zz>'.$fournisseurs[$piece['Reglement']['fournisseur_id']].'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$piece['Piecereglement']['num'].'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$bn.'  '.$compt.'</td>
        <td width="18%" nobr="nobr" align="center"   $zz>'.date("d/m/Y",strtotime(str_replace('-','/',($piece['Reglement']['Date'])))).'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.date("d/m/Y",strtotime(str_replace('-','/',($piece['Piecereglement']['echance'])))).'</td>
        <td width="16%" nobr="nobr" align="center"  $zz>'.$piece['Piecereglement']['montant'].'</td>
        
        
    </tr>' ;     
 }
 $tbl .= '      
                <tr bgcolor="#FFFFFF" align="center">  
                    <td colspan="5"width="84%" nobr="nobr" align="center" height="30px" ></td>
                    <td width="16%" nobr="nobr" align="center"  $zz><strong>'.$tot_imp.'</strong></td>
                </tr>';
}



    }
$tbl .= '
</table>';
 
   //---------------------------------

if(empty($situation)){
    

  $cadre='style="font-family:Arial, Helvetica, sans-serif;font-size:13px; border-top:2px solid black;border-left:2px solid black;border-right:2px solid black;border-bottom:2px solid black;"';    
  $cadre2='style="font-family:Arial, Helvetica, sans-serif;font-size:13px; border-right:2px solid black;"';    
  $cadre3='style="font-family:Arial, Helvetica, sans-serif;font-size:13px; border-top:2px solid black;border-left:2px solid black;border-right:2px solid black;"';    
      $tots=$tot_att+$tot_ver+$tot_pre+$tot_pay + $tot_imp;
      $tots=  sprintf('%.3f',$tots);
    
$tbl .= '
    <br>
    <br>
    <br>
<table border="0" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table"  nobr="true" >       
     
        <tr bgcolor="#FFFFFF" align="center"> 
                <td width="30%" '.$cadre2.'></td>
                <td colspan="2" align="centre" width="25%" '.$cadre.'><strong>&nbsp;<br>Total En attente<br></strong></td>
                <td  align="center" width="20%" '.$cadre.' ><strong>&nbsp;<br>'.$tot_att.'<br></strong></td> 
        </tr>
        <tr bgcolor="#FFFFFF" align="center">
                <td width="30%" '.$cadre2.'></td>
                <td colspan="2" align="centre" width="25%" '.$cadre.' ><strong>&nbsp;<br>Total Versé<br></strong></td>
                <td  align="center" width="20%" '.$cadre.' ><strong>&nbsp;<br>'.$tot_ver.'<br></strong></td>
       </tr>
       <tr bgcolor="#FFFFFF" align="center">
                <td width="30%" '.$cadre2.'></td>
                <td colspan="2" align="centre" width="25%" '.$cadre.' ><strong>&nbsp;<br>Total Payé<br></strong></td>
                <td  align="center" width="20%" '.$cadre.' ><strong>&nbsp;<br>'.$tot_pay.'<br></strong></td>
       </tr>
       <tr bgcolor="#FFFFFF" align="center">
                <td width="30%" '.$cadre2.'></td>
                <td colspan="2" align="centre" width="25%" '.$cadre.' ><strong>&nbsp;<br>Total Préavis<br></strong></td>
                <td  align="center" width="20%" '.$cadre.' ><strong>&nbsp;<br>'.$tot_pre.'<br></strong></td>
       </tr>
       <tr bgcolor="#FFFFFF" align="center">
                <td width="30%" '.$cadre2.'></td>
                <td colspan="2" align="centre" width="25%" '.$cadre.' ><strong>&nbsp;<br>Total Impayé<br></strong></td>
                <td  align="center" width="20%" '.$cadre.' ><strong>&nbsp;<br>'.$tot_imp.'<br></strong></td>
       </tr>
       
       <tr bgcolor="#FFFFFF" align="center">
                <td width="30%" '.$cadre2.' ></td>
                <td colspan="2" align="centre" width="25%" '.$cadre.' ><strong>&nbsp;<br>Total<br></strong></td>
                <td  align="center" width="20%" '.$cadre.' ><strong>&nbsp;<br>'.$tots.'<br></strong></td>
       </tr>
       
 </table>';
    }
    //------------------------------------  

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('Piece_Reglement_cheque.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>