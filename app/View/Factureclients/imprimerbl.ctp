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
$pdf->SetTitle('Facture Client');

$ent = 'entete.jpg';
$ModelSociete = ClassRegistry::init('Societe');
$soc = $ModelSociete->find('first');
$footer = '     SARL au Capital de : ' . $soc['Societe']['capital'] . '          Adresse : ' . $soc['Societe']['adresse'] . '          Code T.V.A: ' . $soc['Societe']['codetva'] . '          RIB: ' . $soc['Societe']['rib']      ;
$footer1 = '     Site : ' . $soc['Societe']['site'] . '           E-mail: ' . $soc['Societe']['mail'] . '           Tel : ' . $soc['Societe']['tel'] . '             Fax : ' . $soc['Societe']['fax'].'         '.$pdf->getAliasNumPage().' / '.$pdf->getAliasNbPages();

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
$styl_cadr_ent='style="border: 1px solid black;background-color:#b8b8b8"';
$styl_cadr_bottom='style="border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;"';
$pdf->AddPage();

$obj = ClassRegistry::init('Piecereglementclient');
$pieces = $obj->find('all',array('conditions'=>array('Piecereglementclient.reglementclient_id'=>$factureclient['Factureclient']['id'])));//

$ch_piece='';
if(!empty($pieces)){
    foreach ($pieces as $piece){
        $ch_piece=$ch_piece .'  '.$piece['Paiement']['name'];
    }
}

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 10);
$logo=  CakeSession::read('logo');
//'.$pdf->getAliasNumPage().' / '.$pdf->getAliasNbPages().'

if(empty($factureclient['Factureclient']['adressclient'])){
    $factureclient['Factureclient']['adressclient']=$factureclient['Client']['adresse'];
}
if(empty($factureclient['Factureclient']['matriculefiscaleclient'])){
    $factureclient['Factureclient']['matriculefiscaleclient']=$factureclient['Client']['matriculefiscale'];
}
if(empty($factureclient['Factureclient']['telclient'])){
    $factureclient['Factureclient']['telclient']=$factureclient['Client']['tel'];
}
$array_entete .=' 


<table width="100%"  border="0">
<tr>
    <td width="80%" align="left" >
            <strong style="font-size:13;">'.$soc['Societe']['nom'].'</strong> <br>
            <table>
            <tr>
            <td align="left" width="100%" style="font-size:9;">
            <strong>'.$soc['Societe']['activite'].'</strong><br>
            '.$soc['Societe']['adresse'].'<br>
            <strong>M.F : </strong>'.$soc['Societe']['codetva'].'<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RC : </strong>'.$soc['Societe']['rc'].'<br> 
            <strong>RIB : </strong>'.$soc['Societe']['rib'].'<br>
            <strong>TEL/FAX : </strong>'.$soc['Societe']['tel'].'<br>   
            </td>
            </tr>
            </table>
    </td>
    <td  width="20%" align="left">
            <IMG SRC="../webroot/img/'.$soc["Societe"]["logo"].'" style="width: 100px;height:80px;" >
    </td>
    
</tr>
</table>




<table >
    <tr >
        <td width="49%" '.$styl_cadr.'>
            <table border="0">
                <tr>
                    <td height="40px" align="center" style="border: 1px solid black;" >
                        <strong style="font-size:15;">Facture N°:'.$factureclient['Factureclient']['numero'].'</strong><br><br> 
                        <strong style="font-size:10;">LE  :'.date("d/m/Y", strtotime(str_replace('-', '/',  $factureclient['Factureclient']['date']))).' </strong> <br> 
                    </td> 
                </tr>
            </table>
        </td>
        <td width="2%"></td>
        <td width="49%" '.$styl_cadr.'>
            <table border="0">
                <tr>
                    <td height="40px" align="left" style="border: 3px solid black;">
                        <strong>Code Client&nbsp;:&nbsp;'.$factureclient['Client']['code'].'</strong><br>
                        <strong>Client&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;'.$factureclient['Client']['name'].'</strong><br>
                        <strong>Adresse&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;'.$factureclient['Client']['adresse'].' </strong><br>    
                        <strong>Ville&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;'.$zone['Zone']['name'].' </strong><br> 
                        <strong>Mat.Fisc&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;'.$factureclient['Client']['matriculefiscale'].' </strong><br>    
                    </td>     
                </tr>
            </table>
        </td>
    </tr>
    <br>
    </tr>
</table>';
$tbl .=' <p>'.$array_entete.'</p>';  
$tbl .='
<table cellpadding="2" cellspacing="0"  >
    <thead>
    
    
    
    <tr>         
        <td align="center" '.$styl_cadr_ent.' width="5%"><strong>Mg</strong></td>
        <td align="center" '.$styl_cadr_ent.' width="17%"><strong>Référence</strong></td>
        <td align="center" '.$styl_cadr_ent.' width="38%"><strong>Désignation</strong></td>
        <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Qte</strong></td>
        <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Prix HT</strong></td>
        <td align="center" '.$styl_cadr_ent.' width="5%"><strong>Rem</strong></td>
        <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Total HT</strong></td>
        <td align="center" '.$styl_cadr_ent.' width="5%"><strong>TVA</strong></td>
       
          </tr>
    </thead>';

        $n=0;  $kk=0;
        $nbr=count($lignefactureclients);
        //$coe=$nbr/26;
//         $reste = new variant_mod (  $nbr ,  26 );
        $reste = $nbr % 26;
        $bl=0;
            foreach ($lignefactureclients as $i=>$lr){
                 if($lr['Lignefactureclient']['remise'] !=0){
                    $remise=sprintf('%.0f',$lr['Lignefactureclient']['remise']);
                }else{
                   $remise="" ;
                }
                $kk++;
                if($kk >27){
                    $n=0;
                    $tbl .= '</table>';
                        $pdf->writeHTML($tbl, true, false, false, false, '');
                            $pdf->AddPage('P');
                            $kk=0;
                            $tbl = '
                                 <p>'.$array_entete.'</p>
                        <table cellpadding="2" cellspacing="0" >       
                            <tr>         
                                <td align="center" '.$styl_cadr_ent.' width="5%"><strong>Mg</strong></td>
                                <td align="center" '.$styl_cadr_ent.' width="17%"><strong>Référence</strong></td>
                                <td align="center" '.$styl_cadr_ent.' width="38%"><strong>Désignation</strong></td>
                                <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Qte</strong></td>
                                <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Prix HT</strong></td>
                                <td align="center" '.$styl_cadr_ent.' width="5%"><strong>Rem</strong></td>
                                <td align="center" '.$styl_cadr_ent.' width="10%"><strong>Total HT</strong></td>
                                <td align="center" '.$styl_cadr_ent.' width="5%"><strong>TVA</strong></td>
                            </tr>';
                }                                           
                                                            
         $n=$n+30;  
//         debug($lr);die;
    if ($lr['Lignefactureclient']['bonlivraison_id']!=$bl){     
    $tbl .='
    <tr> 
        <td colspan="8" height="20px" '.$styl_cadr.' align="center"  width="5%"></td> 
        <td align="center" '.$styl_cadr.' width="17%">&nbsp;</td> 
        <td align="left" '.$styl_cadr.' width="38%" ><strong>'.$lr['Bonlivraison']['numero'].'</strong></td>
        <td align="center" '.$styl_cadr.' width="10%">&nbsp;</td>  
        <td align="center" '.$styl_cadr.' width="10%">&nbsp;</td>  
        <td align="center" '.$styl_cadr.' width="5%">&nbsp;</td> 
        <td align="right" '.$styl_cadr.' width="10%">&nbsp;</td> 
        <td align="center" '.$styl_cadr.' width="5%">&nbsp;</td>  
    </tr>'; 
    $kk++;
    }     
    $bl=$lr['Lignefactureclient']['bonlivraison_id'];     
         
         

              
$tbl .='
    
    <tr> 
        <td height="20px" '.$styl_cadr.' align="center"  width="5%">&nbsp;'. $lr['Depot']['code'].'</td> 
        <td align="center" '.$styl_cadr.' width="17%">&nbsp;'. substr($lr['Article']['code'],0,15).'</td> 
        <td align="left" '.$styl_cadr.' width="38%" >&nbsp;'. substr($lr['Lignefactureclient']['designation'],0,35).'</td>
        <td align="center" '.$styl_cadr.' width="10%">&nbsp;'.$lr['Lignefactureclient']['quantite'].'</td>  
        <td align="center" '.$styl_cadr.' width="10%">&nbsp;'.number_format($lr['Lignefactureclient']['prix'],3, '.', ' ').'</td>  
        <td align="center" '.$styl_cadr.' width="5%">&nbsp;'.$remise.'</td> 
        <td align="right" '.$styl_cadr.' width="10%">&nbsp;'.number_format($lr['Lignefactureclient']['totalht'],3, '.', ' ').'</td> 
        <td align="center" '.$styl_cadr.' width="5%">&nbsp;'.$lr['Lignefactureclient']['tva'].'</td>  
    </tr>
    
';
                            
} $hauteur=400-$n;

    $tbl .='
    <tr>
        <td align="center" '.$styl_cadr_bottom.' width="5%" >&nbsp;<br></td>
        <td align="center" '.$styl_cadr_bottom.' width="17%">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_bottom.' width="38%">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_bottom.' width="10%">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_bottom.' width="10%" height="'.$hauteur.'px">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_bottom.' width="5%">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_bottom.' width="10%">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_bottom.' width="5%">&nbsp;<br></td>  
    </tr> 
    
</table>';
    
if($reste>20){
                    $n=0;
                    $tbl .= '</table>';
                        $pdf->writeHTML($tbl, true, false, false, false, '');
                            $pdf->AddPage('P');
                            $kk=0;
                            $tbl = '
                                 <p>'.$array_entete.'</p>
                        ';
                }          
    
    
    
$tbl .='<br><br>
    <table nobr="true">
        <tr>
        
            <td width="40%">
                <table border="1" nobr="true">
                    <tr>
                        <td align="center" style=""><strong>Base</strong></td>
                        <td align="center" style=""><strong>TVA</strong></td>
                        <td align="center" style=""><strong>Montant</strong></td>
                    </tr>';
                    $tva=0;
                     foreach ($lignefactureclientstva as $i=>$lr){
                         $tot_tva=$tot_tva+$lr[0]['mtva'];
                         $mnt=0;$mnt_ttc=0;
                         $mnt=($lr['Lignefactureclient']['totalht']*$lr['Lignefactureclient']['tva'])/100;
                         $mnt_ttc=$lr['Lignefactureclient']['totalht']+$mnt;
                         
                         $tbl .='
                             <tr>
                                <td align="center" >&nbsp;'.number_format($lr[0]['totalht'],3, '.', ' ').' </td>
                                <td align="center" >&nbsp;'.sprintf('%.0f',$lr[0]['tva']).' %</td>
                                <td align="center" >&nbsp;'.number_format($lr[0]['mtva'],3, '.', ' ').'</td>
                             </tr>';
                     }
                      $tbl .='<tr>
                                <td align="center" colspan="2">Total</td>
                                <td align="center" >&nbsp;'.number_format($tot_tva,3, '.', ' ').'</td>
                             </tr>';
                    
                $tbl .='</table>
            </td>


            <td width="24%"></td>';
$ttc_sans_timbre=$factureclient['Factureclient']['totalttc']-$factureclient['Factureclient']['timbre_id'];
if($ttc_sans_timbre==$factureclient['Factureclient']['totalht']){
$factureclient['Factureclient']['tva']=0;    
}
$total_ht_avant_remise=$factureclient['Factureclient']['totalht']+$factureclient['Factureclient']['remise'];

            $tbl .='<td width="36%">
                <table border="1" nobr="true">
                    <tr>
                        <td align="left" style="" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total HT  </strong></td>  
                        <td align="right"  width="50%">'.number_format($total_ht_avant_remise,3, '.', ' ').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" style="" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total remise  </strong></td>  
                        <td align="right"  width="50%">'.number_format($factureclient['Factureclient']['remise'],3, '.', ' ').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" style="" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total NET  </strong></td>  
                        <td align="right"  width="50%">'.number_format($factureclient['Factureclient']['totalht'],3, '.', ' ').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 
                    </tr>
                    <tr>
                        <td align="left" style="" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total TVA  </strong></td>  
                        <td align="right"  width="50%">'.number_format($factureclient['Factureclient']['tva'],3, '.', ' ').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>  
                     </tr> 
                   <tr>
                        <td align="left" style="" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Timbre  </strong></td>  
                        <td align="right"  width="50%">'.number_format($factureclient['Factureclient']['timbre_id'],3, '.', ' ').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 
                    </tr>
                        
                    <tr>
                        <td align="left" style="" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total TTC  </strong></td>  
                        <td align="right"  width="50%"><strong>'.number_format($factureclient['Factureclient']['totalttc'],3, '.', ' ').'</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>  
                    </tr>   
                     
                </table>
            
            </td>
            

            
        </tr>
    </table>
        
<br><br>
<table cellpadding="2" cellspacing="0" border="1" nobr="true">
    <tr>
        <td height="40px" colspan="6" width="70%" align="center" >
        <br>   <br>
            <strong>Arreter la présente Facture à la somme de :</strong>
            <br>
            '.chifre_en_lettre($factureclient['Factureclient']['totalttc'],1,1).'<br>';
            if($factureclient['Factureclient']['typeclient_id']==2){
                
        $exono = ClassRegistry::init('Exonorationclient')->find('first', array('conditions' => (array(
        'Exonorationclient.client_id' => @$factureclient['Client']['id'], 
        'Exonorationclient.datedu <= ' => $factureclient['Factureclient']['date'], 
        'Exonorationclient.dateau >= ' => $factureclient['Factureclient']['date'])), 
        'recursive' => -1));
        }  
             if($factureclient['Factureclient']['typeclient_id']==2){ 
                 if(!empty($exono)){
               $tbl .=' <strong style="font-size:4mm;">N° Exo :'.  $exono['Exonorationclient']['num_exe']  .'
                Du :  '.date("d/m/Y", strtotime(str_replace('-', '/',  $exono['Exonorationclient']['datedu']))) .' 
                Au :  '.date("d/m/Y", strtotime(str_replace('-', '/',  $exono['Exonorationclient']['dateau']))) .'
                </strong>';
             } }
       $tbl .=' </td>
        <td height="90px" width="30%" align="center" >
            <strong>Signature et cachet</strong>
        </td>
        
    </tr>
</table>
      


 <br>
        ';
    
    
           
$tbl .='</table>';

$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
//Close and output PDF document
ob_end_clean();
$pdf->Output('factureclient.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>