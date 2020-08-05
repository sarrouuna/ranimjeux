<?php
function chifre_en_lettre($montant, $devise1, $devise2)
{
 if(($devise1==1)) $dev1='Dinars';
 if(($devise1==2)) $dev1='Dollars';
 if(($devise1==3)) $dev1='Euro';
 if(($devise1==1)) $dev2='Millimes';
 if(($devise1==2)) $dev2='Cents';
 if(($devise1==3)) $dev2='Centimes';
 $valeur_entiere=intval($montant);
 $valeur_decimal=(($montant-intval($montant))*1000);
 $dix_c=($valeur_decimal%100/10);
 $cent_c=intval($valeur_decimal%1000/100);
 $unite_c=$valeur_decimal%10;
 $unite[1]=$valeur_entiere%10;
 $dix[1]=intval($valeur_entiere%100/10);
 $cent[1]=intval($valeur_entiere%1000/100);
 $unite[2]=intval($valeur_entiere%10000/1000);
 $dix[2]=intval($valeur_entiere%100000/10000);
 $cent[2]=intval($valeur_entiere%1000000/100000);
 $unite[3]=intval($valeur_entiere%10000000/1000000);
 $dix[3]=intval($valeur_entiere%100000000/10000000);
 $cent[3]=intval($valeur_entiere%1000000000/100000000);
 //echo $unite_c;
 $chif=array('', 'Un', 'Deux', 'Trois', 'Quatre', 'Cinq', 'Six', 'Sept', 'Huit', 'Neuf', 'Dix', 'Onze', 'Douze', 'Treize', 'Quatorze', 'Quinze', 'Seize', 'Dix-sept', 'Dix-huit', 'Dix-neuf');
  $secon_c='';
  $trio_c='';
 for($i=1; $i<=3; $i++){
  $prim[$i]='';
  $secon[$i]='';
  $trio[$i]='';
  if($dix[$i]==0){
   $secon[$i]='';
   $prim[$i]=$chif[$unite[$i]];
  }
  else if($dix[$i]==1){
   $secon[$i]='';
   $prim[$i]=$chif[($unite[$i]+10)];
  }
  else if($dix[$i]==2){
   if($unite[$i]==1){
   $secon[$i]='Vingt et';
   $prim[$i]=$chif[$unite[$i]];
   }
   else {
   $secon[$i]='Vingt';
   $prim[$i]=$chif[$unite[$i]];
   }
  }
  else if($dix[$i]==3){
   if($unite[$i]==1){
   $secon[$i]='Trente et';
   $prim[$i]=$chif[$unite[$i]];
   }
   else {
   $secon[$i]='Trente';
   $prim[$i]=$chif[$unite[$i]];
   }
  }
  else if($dix[$i]==4){
   if($unite[$i]==1){
   $secon[$i]='Quarante et';
   $prim[$i]=$chif[$unite[$i]];
   }
   else {
   $secon[$i]='Quarante';
   $prim[$i]=$chif[$unite[$i]];
   }
  }
  else if($dix[$i]==5){
   if($unite[$i]==1){
   $secon[$i]='Cinquante et';
   $prim[$i]=$chif[$unite[$i]];
   }
   else {
   $secon[$i]='Cinquante';
   $prim[$i]=$chif[$unite[$i]];
   }
  }
  else if($dix[$i]==6){
   if($unite[$i]==1){
   $secon[$i]='Soixante et';
   $prim[$i]=$chif[$unite[$i]];
   }
   else {
   $secon[$i]='Soixante';
   $prim[$i]=$chif[$unite[$i]];
   }
  }
  else if($dix[$i]==7){
   if($unite[$i]==1){
   $secon[$i]='Soixante et';
   $prim[$i]=$chif[$unite[$i]+10];
   }
   else {
   $secon[$i]='Soixante';
   $prim[$i]=$chif[$unite[$i]+10];
   }
  }
  else if($dix[$i]==8){
   if($unite[$i]==1){
   $secon[$i]='Quatre-vingts et';
   $prim[$i]=$chif[$unite[$i]];
   }
   else {
   $secon[$i]='Quatre-vingts';
   $prim[$i]=$chif[$unite[$i]];
   }
  }
  else if($dix[$i]==9){
   if($unite[$i]==1){
   $secon[$i]='Quatre-vingts et';
   $prim[$i]=$chif[$unite[$i]+10];
   }
   else {
   $secon[$i]='Quatre-vingts';
   $prim[$i]=$chif[$unite[$i]+10];
   }
  }
  if($cent[$i]==1) $trio[$i]='Cent';
  else if($cent[$i]!=0 || $cent[$i]!='') $trio[$i]=$chif[$cent[$i]] .' Cents';
 }
 $v="";
 
$chif2=array('', 'Dix', 'Vingt', 'Trente', 'Quarante', 'Cinquante', 'Soixante', 'Soixante-dix', 'Quatre-vingts', 'Quatre-vingt-dix');
 $secon_c=$chif2[$dix_c];
 if($cent_c==1) $trio_c='Cent';
 else if($cent_c!=0 || $cent_c!='') $trio_c=$chif[$cent_c] .' Cents';
 
 if(($cent[3]==0 || $cent[3]=='') && ($dix[3]==0 || $dix[3]=='') && ($unite[3]==1)) 
  $v=$v.' '. $trio[3]. '  ' .$secon[3]. ' ' . $prim[3]. ' Million ';
 else if(($cent[3]!=0 && $cent[3]!='') || ($dix[3]!=0 && $dix[3]!='') || ($unite[3]!=0 && $unite[3]!=''))
  $$v=$v.' '. $trio[3]. ' ' .$secon[3]. ' ' . $prim[3]. ' Millions ';
 else
  $v=$v.' '. $trio[3]. ' ' .$secon[3]. ' ' . $prim[3];
 
 if(($cent[2]==0 || $cent[2]=='') && ($dix[2]==0 || $dix[2]=='') && ($unite[2]==1)) 
  $v=$v.' '. ' Mille ';
 else if(($cent[2]!=0 && $cent[2]!='') || ($dix[2]!=0 && $dix[2]!='') || ($unite[2]!=0 && $unite[2]!=''))
  $v=$v.' '. $trio[2]. ' ' .$secon[2]. ' ' . $prim[2]. ' Milles ';
 else
  $v=$v.' '. $trio[2]. ' ' .$secon[2]. ' ' . $prim[2];
 
 $v=$v. $trio[1]. ' ' .$secon[1]. ' ' . $prim[1];
 
 $v=$v. ' '. $dev1 .' ' ;
 
 if(($cent_c=='0' || $cent_c=='') && ($dix_c=='0' || $dix_c==''))
  $v=$v.' '. ' et z&eacute;ro '. $dev2;
 else
  $v=$v.' et '.round( $valeur_decimal,0). ' ' . $dev2;
return $v;
} 


App::import('Vendor', 'xtcpdf');
$pdf = new XTCPDF();

class MYPDF extends TCPDF {
var $xheadertext  = 'PDF created using CakePHP and TCPDF'; 
    var $xheadercolor = array(0,0,200); 
    //var $xfootertext  = 'Copyright Ã‚Â© %d XXXXXXXXXXX. <b>All rights reserved.</b>'; 
    var $xfooterfont  = PDF_FONT_NAME_MAIN ; 
    var $xfooterfontsize = 7 ;
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

// ---------------------------------------------------------
$styl_cadr='style="border-left:1px solid black;border-right:1px solid black;"';
$styl_cadr_ent='style="border-bottom:1px solid black;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;background-color:#b8b8b8"';
$styl_cadr_bottom='style="border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;"';
$pdf->AddPage();

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 11);
$logo=  CakeSession::read('logo');

$array_entete .=' 


<table width="100%">

                <tr>
                    <td width="45%">
                        <table>
                            <tr>
                                <td style="font-size:30;" align="center"><strong>Ste ThermEco</strong></td>
                            </tr>
                            <tr>
                                <td style="font-size:16;" align="center"><strong>' . $soc['Societe']['adresse'] . '</strong></td>
                            </tr>
                            <tr>
                                <td align="center">' . $soc['Societe']['codepostale'] . ' SFAX</td>
                            </tr>
                            <tr>
                                <td align="center" > <strong>Tel : </strong>' . $soc['Societe']['tel'] . '</td>
                            </tr>
                            <tr>
                                <td align="center" > <strong>Fax : </strong>' . $soc['Societe']['fax'] . '</td>
                            </tr>

                        </table>
                    </td>

                    <td width="55%">
                        <br><br><br>
                        <table>
                            <tr>
                                <td align="left" width="23%"  ><strong> Code TVA : </strong></td>
                                <td align="left" width="77%"  >' . $soc['Societe']['codetva'] . '</td>
                            </tr>
                            <tr>
                                <td align="left" width="23%" ><strong> Reg . Com :</strong></td>
                                <td align="left" width="77%" >' . $soc['Societe']['rc'] . '</td>
                            </tr>
                            <tr>
                                <td align="left" width="23%" ><strong> C.C.B :</strong></td>
                                <td align="left" width="77%" >03 03716701150040041 3 BNA POUDRIERE</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <br><br>


            <table>
                <tr>
                    <td width="40%">
                        <table cellpadding="2" cellspacing="0" border="1" >
                            <tr>
                                <td align="center" width="100%" colspan="3" style="background-color:#b3b3b3"  ><strong> Facture a voir N </strong></td>
                            </tr>
                            <tr>
                                <td height="33px" align="center" width="50%"  ><strong>Numero</strong></td>
                                <td align="center" width="50%"  ><strong>Date</strong></td>
                            </tr>
                             <tr>
                                <td height="33px" align="center" width="50%"  >'.$factureavoir['Factureavoir']['numero'].'</td>
                                <td align="center" width="50%"  > '.date("d/m/Y", strtotime(str_replace('-', '/',  $factureavoir['Factureavoir']['date']))).'  </td>
                            </tr>
                        </table>
                    </td>

                    <td width="10%"></td>

                    <td width="50%">
                    
                        <table border="1">
                            <tr>
                                <td align="center" width="100%" height="22px" style="background-color:#b8b8b8" ><strong>Client </strong></td>
                            </tr>
                            <tr>
                                <td>
                                    <table >
                                        
                                        <tr>
                                            <td align="center" width="100%"   ><strong>'.$factureavoir['Client']['name'].' </strong></td>
                                        </tr>
                                        <tr>
                                            <td align="left" width="100%"  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Matricule Fiscal :</strong>'.$devi['Client']['matriculefiscale'].'</td>
                                        </tr>
                                        <tr>
                                            <td align="left" width="100%"  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Telephone :</strong>'.$factureavoir['Client']['tel'].'</td>
                                        </tr>
                                        <tr>
                                            <td align="left" width="100%"  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Adresse :</strong>'.$factureavoir['Client']['adresse'].'</td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                        </table>
                        
                    </td>
                </tr>
            </table>';









$tbl .=' <p>'.$array_entete.'</p>';


$tbl .=' 
<table cellpadding="2" cellspacing="0" >
    
        <tr>         
            <td align="center" '.$styl_cadr_ent.' width="55%"><strong>Article</strong></td>
            <td align="center" '.$styl_cadr_ent.' width="5%"><strong>Qte</strong></td>
            <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Prix</strong></td>
            <td align="center" '.$styl_cadr_ent.' width="5%"><strong>Rem</strong></td>
            <td align="center" '.$styl_cadr_ent.' width="5%"><strong>TVA</strong></td>
            <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Total HT</strong></td>
            <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Total TTC</strong></td>
       
        </tr>
    ';

$long="670";
          $n=0;$kk=0;
            foreach ($Lignefactureavoirs as $i=>$lr){
                 $kk++;
                if($kk==26){
                    $n=0;
                    $tbl .= '</table>';
                        $pdf->writeHTML($tbl, true, false, false, false, '');
                            $pdf->AddPage('P');
                            $kk=0;
                            $tbl = '
                                 <p>'.$array_entete.'</p>
                        <table cellpadding="2" cellspacing="0" >       
                            <tr>         
                                <td align="center" '.$styl_cadr_ent.' width="55%"><strong>Article</strong></td>
                                <td align="center" '.$styl_cadr_ent.' width="5%"><strong>Qte</strong></td>
                                <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Prix</strong></td>
                                <td align="center" '.$styl_cadr_ent.' width="5%"><strong>Rem</strong></td>
                                <td align="center" '.$styl_cadr_ent.' width="5%"><strong>TVA</strong></td>
                                <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Total HT</strong></td>
                                <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Total TTC</strong></td>
                            </tr>';
                }       
                                            $n=$n+30;    

              $long=$long-10;
$tbl .='
    
     <tr> 
        <td align="left" '.$styl_cadr.' width="55%" >'. $lr['Article']['name'].'</td>
        <td align="center" '.$styl_cadr.' width="5%">'.$lr['Lignefactureavoir']['quantite'].'</td>  
        <td align="center" '.$styl_cadr.' width="10%">'.$lr['Lignefactureavoir']['prix'].'</td>  
        <td align="center" '.$styl_cadr.' width="5%">'.$lr['Lignefactureavoir']['remise'].'</td>  
        <td align="center" '.$styl_cadr.' width="5%">'.$lr['Lignefactureavoir']['tva'].'</td>  
        <td align="center" '.$styl_cadr.' width="10%">'.$lr['Lignefactureavoir']['totalht'].'</td>  
        <td align="center" '.$styl_cadr.' width="10%">'.$lr['Lignefactureavoir']['totalttc'].'</td>  
        
</tr>
    
';
                            
} $hauteur=380-$n;

    $tbl .='
   <tr>
        <td align="center" '.$styl_cadr_bottom.' width="55%" >&nbsp;<br></td>
        <td align="center" '.$styl_cadr_bottom.' width="5%">&nbsp;<br></td>   
        <td align="center" '.$styl_cadr_bottom.' width="10%" height="'.$hauteur.'px">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_bottom.' width="5%">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_bottom.' width="5%">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_bottom.' width="10%">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_bottom.' width="10%">&nbsp;<br></td>  
    </tr>      
 
<tr>
</table>';
    
    
    $obj = ClassRegistry::init('Lignefactureavoir');

    $lignefactureclientstva = $obj->find('all',array('fields'=>array(
             'SUM(Lignefactureavoir.totalht*Lignefactureavoir.tva)/100  mtva'
             ,'SUM(Lignefactureavoir.totalht) totalht'
             ,'AVG(Lignefactureavoir.tva) tva'),
             'conditions'=>array('Lignefactureavoir.factureavoir_id' => $factureavoir['Factureavoir']['id'])
             ,'group'=>array('Lignefactureavoir.tva')       
                    ));

    //debug($lignefactureclientstva);die;

$tbl .='<br><br>
    <table>
        <tr>
            <td width="40%">
                <table border="1">
                    <tr>
                        <td align="center" style="background-color:#b8b8b8"><strong>Base</strong></td>
                        <td align="center" style="background-color:#b8b8b8"><strong>TVA</strong></td>
                        <td align="center" style="background-color:#b8b8b8"><strong>Montant</strong></td>
                    </tr>';
                    $tva=0;
                     foreach ($lignefactureclientstva as $i=>$lr){
                         
                         $mnt=0;$mnt_ttc=0;
                         $mnt=($lr['Lignefactureavoir']['totalht']*$lr['Lignefactureavoir']['tva'])/100;
                         $mnt_ttc=$lr['Lignefactureavoir']['totalht']+$mnt;
                         
                         $tbl .='
                             <tr>
                                <td align="center" >&nbsp;'.sprintf('%.3f',$lr[0]['totalht']).' </td>
                                <td align="center" >&nbsp;'.sprintf('%.0f',$lr[0]['tva']).' %</td>
                                <td align="center" >&nbsp;'.sprintf('%.3f',$lr[0]['mtva']).'</td>
                             </tr>';
                     }
                    
                $tbl .='</table>
            </td>


            <td width="24%"></td>

            <td width="36%">
                <table border="1">
                    <tr>
                        <td align="left" style="background-color:#b8b8b8" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total remise  </strong></td>  
                        <td align="right"  width="50%">'.$factureavoir['Factureavoir']['remise'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" style="background-color:#b8b8b8;" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total TVA  </strong></td>  
                        <td align="right"  width="50%">'.$factureavoir['Factureavoir']['tva'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>  
                     </tr> 
                     
                    <tr>
                        <td align="left" style="background-color:#b8b8b8;" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Timbre  </strong></td>  
                        <td align="right"  width="50%">'.$factureavoir['Timbre']['timbre'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>  
                     </tr> 
                   
                    <tr>
                        <td align="left" style="background-color:#b8b8b8;" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total HT  </strong></td>  
                        <td align="right"  width="50%">'.$factureavoir['Factureavoir']['totalht'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 
                    </tr>    
                    <tr>
                        <td align="left" style="background-color:#b8b8b8;" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total TTC  </strong></td>  
                        <td align="right"  width="50%">'.$factureavoir['Factureavoir']['totalttc'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>  
                    </tr>   
                     
                </table>
            
            </td>
            

            
        </tr>
    </table>
<br><br>


<table border="1">
  

<tr>
        
        <td height="40px" colspan="6" width="70%" align="center" >
        <br>   <br>
            <strong>Arretée la présente Facture à la somme de :</strong>
            <br>
            '.chifre_en_lettre($factureavoir['Factureavoir']['totalttc'],1,1).'
        </td>
        <td height="90px" width="30%" align="center" >
            <strong>Signature et cachet</strong>
        </td>
    </tr> 
</table>
        ';
    
    
           
$tbl .='</table>';

$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
//Close and output PDF document
ob_end_clean();
$pdf->Output('imprimer_view_factureavoir', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>