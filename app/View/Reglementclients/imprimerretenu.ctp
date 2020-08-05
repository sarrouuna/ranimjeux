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

// ---------------------------------------------------------

$pdf->AddPage();

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 9);
$logo=  CakeSession::read('logo');

$tbl =' 

<table width="100%">
<tr>
    <td  width="55%">
        <IMG SRC="../webroot/img/'.$logo.'" width="120" >
    </td>
    <td  width="45%">
        <table width="100%">
            <tr>
            <br> 
                <td height="35px" align="left" ><strong>Reglement N°: '.$reglement['Reglementclient']['numero'].'</strong></td> 
            </tr> 
        </table>
    </td>
</tr>
<br>
<tr>
    <td align="left" width="1%"  ></td>
    <td align="left" width="54%"  >' . $soc['Societe']['adresse'] . '</td>
    <td align="left" width="45%" ><strong>Tél : </strong>' . $soc['Societe']['tel'] . '</td>
</tr>
<tr>
    <td align="left" width="1%"  ></td>
    <td align="left" width="54%"  ><strong>TVA :</strong>' . $soc['Societe']['codetva'] . '</td>
    <td align="left" width="45%" ><strong>Fax :</strong>' . $soc['Societe']['fax'] . '</td>
</tr>
<tr>
    <td align="left" width="1%"  ></td>
    <td align="left" width="54%"  ><strong>R.C :</strong>' . $soc['Societe']['rc'] . '</td>
     <td align="left" width="45%" ><strong>Site web : </strong>' . $soc['Societe']['site'] . '</td>
</tr>
    
</table>
<br><br>



<table>
    <tr>
        <td width="49%">
            <table border="0">
                <tr>
                    <td height="40px" align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" >
                        <strong>'.$reglement['Client']['name'].'</strong>
                        <br>
                        '.$reglement['Client']['adresse'].'
                    </td> 
                              
                </tr>
            </table>
        </td>
        <td width="2%"></td>
        <td width="49%">
            <table border="0">
                <tr>
                    <td height="40px" align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;">
                        <strong>Matricule Fiscal</strong>
                        <br>
                        '.$reglement['Client']['matriculefiscale'].'
                    </td> 
                              
                </tr>
            </table>
        </td>
    </tr>
    <br>

<tr>
        <td width="49%">
            <table border="0">
                <tr>
                    <td height="40px" align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" >
                       <br><br> 
                       <strong> Reglement </strong>  
                    </td> 
                              
                </tr>
            </table>
        </td>
        <td width="2%"></td>
        <td width="49%">
            <table border="0">
                <tr>
                    <td height="40px" align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;">
                        <strong>Date</strong>
                        <br>
                        '.date("d/m/Y",strtotime(str_replace('-','/',($reglement['Reglementclient']['Date'])))).'
                    </td>
                    
                    <td height="40px" align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;">
                        <strong>Client N°</strong>
                        <br>
                        '.$reglement['Client']['code'].'
                    </td>
                              
                </tr>
            </table>
        </td>
    </tr>





</table>
        <table>
            <tr>
                <td height="20px"></td>
            </tr>
        </table>
        <table  cellpadding="2" cellspacing="0" width="100%" >
    <thead>
    
    
        <tr>
            <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="20%"  height="35px"><strong>Numéro</strong></td>
            <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="20%"><strong>Date</strong></td>
            <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="20%"><strong>Montant</strong></td>
            <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="20%"><strong>Montant Reglé</strong></td>
            <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="20%"><strong>Reste</strong></td>
        </tr>
    </thead>';

//$long="670";
         // debug($ligneregement);die;
                                            foreach ($ligneregement as $l){
        $numero = $l['Factureclient']['numero']; 
        $date = date("d/m/Y",strtotime(str_replace('-','/',$l['Factureclient']['date'])));
        $total_ttc = $l['Factureclient']['totalttc'];
        $mnt_reg = $l['Factureclient']['Montant_Regler'];
        $resteee = $total_ttc-$mnt_reg ;
                                                
$tbl .='
    <tbody>
     <tr> 
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="20%" >&nbsp;'.$numero.'</td>
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="20%">&nbsp;'.$date.'</td>  
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="20%">&nbsp;'.$total_ttc.'</td>
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="20%">&nbsp;'.$mnt_reg.'</td>
        <td align="center" style="border-bottom:solid #000 2px;border-right:solid #000 2px;" width="20%">&nbsp;'.$resteee.'</td>
        
    </tr> ';
                            
}
        $tot=$reglement['Reglementclient']['Montant'];

    $tbl .='<tr>
        <td height="20px"></td>
    </tr>
        <tr>
            <td align="center" colspan="3" style="border-left:solid #000 2px;border-right:solid #000 2px;border-top:solid #000 2px;" width="50%" >&nbsp;<br>Montant Total<br></td>
            <td align="center" colspan="2" style="border-right:solid #000 2px;border-top:solid #000 2px;" width="50%">&nbsp;<br><strong>'.$tot.'</strong></td>
        </tr>
        
        <tr>
            <td align="center" colspan="3" style="border-left:solid #000 2px;border-right:solid #000 2px;border-top:solid #000 2px;" width="50%" >&nbsp;<br>Montant Payée<br></td>
            <td align="center" colspan="2" style="border-right:solid #000 2px;border-top:solid #000 2px;" width="50%">&nbsp;<br><strong>'.$reglement['Reglementclient']['Montant'].'</strong></td>
        </tr>
        <tr>
            <td height="20px" colspan="5" style="border-top:solid #000 2px;"></td>
        </tr>
        
   </tbody>
</table>
        ';
    
    
            $tbl .='
                <table cellpadding="2" cellspacing="3" border="1">
                <tr>
                    <td width="20%" align="center" height="35px"><strong>Mode règlement</strong></td>
                    <td width="20%" align="center" ><strong>Montant</strong></td>
                    <td width="20%" align="center" ><strong>Echéance  </strong></td>
                    <td width="20%" align="center" ><strong>Numéro Pièce</strong></td>
                    <td width="20%" align="center" ><strong>Banque </strong></td>
                </tr>';
            $tot_esp=0;$tot_ch=0;$tot_tr=0;$tot_vir=0;$tot_ret=0;$tot_fact=0;
            foreach($pieceregement as $i=>$lp ){
                if($lp['Paiement']['id']==1){
                    $tot_esp=$tot_esp+$lp['Piecereglementclient']['montant'];
                }
                if($lp['Paiement']['id']==2){
                    $tot_ch=$tot_ch+$lp['Piecereglementclient']['montant'];
                }
                if($lp['Paiement']['id']==3){
                    $tot_tr=$tot_tr+$lp['Piecereglementclient']['montant'];
                }
                if($lp['Paiement']['id']==4){
                    $tot_vir=$tot_vir+$lp['Piecereglementclient']['montant'];
                }
                if($lp['Paiement']['id']==5){
                    $tot_ret=$tot_ret+$lp['Piecereglementclient']['montant'];
                }
                if($lp['Paiement']['id']==6){
                    $tot_fact=$tot_fact+$lp['Piecereglementclient']['montant'];
                }
                //debug($lp);die;
                if($lp['Paiement']['id']==1){
                 $tbl .='
                    <tr> 
                        <td  align="center"  width="20%" height="35px">'.$lp['Paiement']['name'].'</td>
                        <td  align="center"  width="20%" height="35px">'.$lp['Piecereglementclient']['montant'].'</td>
                        <td  align="center"  width="20%" height="35px"></td>
                        <td  align="center"  width="20%" height="35px"></td>
                        <td  align="center"  width="20%" height="35px"></td>
                    </tr>';
                }
            if($lp['Paiement']['id']!=1 && $lp['Paiement']['id']!=5 && $lp['Paiement']['id']!=6){
            $tbl .='
                <tr> 
                    <td  align="center"  width="20%" height="35px">'.$lp['Paiement']['name'].'</td>
                    <td  align="center"  width="20%" height="35px">'.$lp['Piecereglementclient']['montant'].'</td>
                    
                    <td  align="center"  width="20%" height="35px">'.date("d/m/Y",strtotime(str_replace('-','/',$lp['Piecereglementclient']['echance']))).'</td>
                    <td  align="center"  width="20%" height="35px">'.$lp['Piecereglementclient']['num'].'</td>
                    <td  align="center"  width="20%" height="35px">'.$lp['Piecereglementclient']['banque'].'</td>
                </tr>';
            }
            if($lp['Paiement']['id']==6 || $lp['Paiement']['id']==5){
            $tbl .='
                <tr> 
                    <td  align="center"  width="20%" height="35px">'.$lp['Paiement']['name'].'</td>
                    <td  align="center"  width="20%" height="35px">'.$lp['Piecereglementclient']['montant'].'</td>
                    
                    <td  align="center"  width="20%" height="35px"></td>
                    <td  align="center"  width="20%" height="35px">'.$lp['Piecereglementclient']['num'].'</td>
                    <td  align="center"  width="20%" height="35px">'.$lp['Piecereglementclient']['banque'].'</td>
                </tr>';
            }
            }
$tbl .='</table>';
//--------------------- Total -------------

$tbl .='
    <table>
    <tr>
        <td height="20px"></td>
    </tr>
    </table>
                <table align="center" cellpadding="2" cellspacing="3" border="1" >
                <tr>
                    <td width="50%" align="center" height="35px"><strong>Total facture à voir</strong></td>
                    <td width="50%" align="center" ><strong>'.sprintf("%.3f",$tot_fact).'</strong></td>
                </tr>
                <tr>
                    <td width="50%" align="center" height="35px"><strong>Total Espèce</strong></td>
                    <td width="50%" align="center" ><strong>'.sprintf("%.3f",$tot_esp).'</strong></td>
                </tr>
                <tr>
                    <td width="50%" align="center" height="35px"><strong>Total Chèque</strong></td>
                    <td width="50%" align="center" ><strong>'.sprintf("%.3f",$tot_ch).'</strong></td>
                </tr>
                <tr>
                    <td width="50%" align="center" height="35px"><strong>Total Traite</strong></td>
                    <td width="50%" align="center" ><strong>'.sprintf("%.3f",$tot_tr).'</strong></td>
                </tr>
                 <tr>
                    <td width="50%" align="center" height="35px"><strong>Total Virement</strong></td>
                    <td width="50%" align="center" ><strong>'.sprintf("%.3f",$tot_vir).'</strong></td>
                </tr>
                 <tr>
                    <td width="50%" align="center" height="35px"><strong>Total Retenue</strong></td>
                    <td width="50%" align="center" ><strong>'.sprintf("%.3f",$tot_ret).'</strong></td>
                </tr>';
 
 $tbl .='</table>';

$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
//Close and output PDF document
ob_end_clean();
$pdf->Output('imprimer_view_reglement', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>