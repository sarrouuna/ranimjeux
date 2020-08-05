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
$pdf->SetAuthor('Thermeco');
$pdf->SetTitle($model);

$ent = 'entete.jpg';
$ModelSociete = ClassRegistry::init('Pointdevente');
$pontdevente = $ModelSociete->find('first',array('conditions'=>array('Pointdevente.id'=>$factureclient[$model]['pointdevente_id'])));
//debug($pontdevente);die;
$ModelSociete = ClassRegistry::init('Societe');
$soc = $ModelSociete->find('first',array('conditions'=>array('Societe.id'=>$pontdevente['Pointdevente']['societe_id'])));


$footer = '     SARL au Capital de : ' . $soc['Societe']['capital'] . '          Adresse : ' . $soc['Societe']['adresse'] . '          Code T.V.A: ' . $soc['Societe']['codetva'] . '          RIB: ' . $soc['Societe']['rib']      ;
$footer1 = '     Site : ' . $soc['Societe']['site'] . '           E-mail: ' . $soc['Societe']['mail'] . '           Tel : ' . $soc['Societe']['tel'] . '             Fax : ' . $soc['Societe']['fax'].'                          '.$pdf->getAliasNumPage().' / '.$pdf->getAliasNbPages();

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
$styl_cadr='style="border:1px solid black;"';
$styl_cadr_ent='style="border-bottom:1px solid black;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;background-color:#b8b8b8"';
$styl_cadr_bottom='style="border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;"';
$pdf->AddPage();



//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 11);
$logo=  CakeSession::read('logo');
//'.$pdf->getAliasNumPage().' / '.$pdf->getAliasNbPages().'
$a1=$pdf->getAliasNumPage();
$a2=$pdf->getAliasNbPages();
$a3="/";
if($model=="Facture"){
    $entete="FACTURE ";
    $ent="facture";
}else{
    $entete="BON RECEPTION ";
    $ent="bon reception ";
}

$array_entete .=' 


<table width="100%">

                <tr>
                    <td width="45%" align="center" >
                        <IMG SRC="../webroot/img/'.$soc["Societe"]["logo"].'" width="120"  >
                    </td>

                    <td width="55%">
                        <br><br><br>
                        <table>
                            <tr>
                                <td align="left" width="23%"  ><strong> Adresse : </strong></td>
                                <td align="left" width="77%"  >' . $soc['Societe']['adresse'] . '</td>
                            </tr>
                            <tr>
                                <td align="left" width="23%" ><strong> Telephone :</strong></td>
                                <td align="left" width="77%" >' . $soc['Societe']['tel'] . '</td>
                            </tr>
                            <tr>
                                <td align="left" width="23%" ><strong> Fax :</strong></td>
                                <td align="left" width="77%" >' . $soc['Societe']['fax'] . '</td>
                            </tr>
                            <tr>
                                <td align="left" width="23%" ><strong> Mail :</strong></td>
                                <td align="left" width="77%" >' . $soc['Societe']['mail'] . '</td>
                            </tr>
                            <tr>
                                <td align="left" width="23%" ><strong> Site :</strong></td>
                                <td align="left" width="77%" >' . $soc['Societe']['site'] . '</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

<br><br>
<br><br>

            <table>
                <tr>
                    <td width="45%">
                        <table cellpadding="2" cellspacing="0" border="1">
                            <tr>
                                <td align="center" width="100%" colspan="3" style="background-color:#b8b8b8"  ><strong> '.$entete.' </strong></td>
                            </tr>
                            <tr>
                                <td height="33px" align="center" width="50%" ><strong>Numero</strong></td>
                                <td align="center" width="50%"  ><strong>Date</strong></td>
                            </tr>
                             <tr>
                                <td height="33px" align="center" width="50%"  >'.$factureclient[$model]['numero'].'</td>
                                <td align="center" width="50%"  > '.date("d/m/Y", strtotime(str_replace('-', '/',  $factureclient[$model]['date']))).'  </td>
                            </tr>
                        </table>
                    </td>

                    <td width="10%"></td>

                    <td width="45%">
                        <table border="1">
                            <tr>
                                <td align="center" width="100%" height="22px" style="background-color:#b8b8b8;" ><strong>Fournisseur </strong></td>
                            </tr>
                            <tr>
                                <td>
                                    <table >
                                        
                                        <tr>
                                            <td align="center" width="100%"  ><strong>'.$factureclient['Fournisseur']['name'].' </strong></td>
                                        </tr>
                                        <tr>
                                            <td align="left" width="100%"  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Adresse :</strong>'.$factureclient['Fournisseur']['adresse'].'</td>
                                        </tr>
                                        <tr>
                                            <td align="left" width="100%"  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Matricule Fiscal :</strong>'.$factureclient['Fournisseur']['matriculefiscale'].'</td>
                                        </tr>
                                        <tr>
                                            <td align="left" width="100%"  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Telephone :</strong>'.$factureclient['Fournisseur']['tel'].'</td>
                                        </tr>
                                        

                                    </table>
                                </td>
                            </tr>
                        </table>
                        
                    </td>
                </tr>
            </table>';


$tbl =' <p>'.$array_entete.'</p>';
$tbl .= '
<table cellpadding="2" cellspacing="0"  >
    <thead>
    <tr>       
       
        <td align="center" ' . $styl_cadr_ent . ' ' . $lgcode . '><strong>Montant HT</strong></td>
        <td align="center" ' . $styl_cadr_ent . ' ' . $lgarticle . '><strong>TVA %</strong></td>
        <td align="center" ' . $styl_cadr_ent . ' ' . $lgremise . '><strong>Montant TVA</strong></td>
        <td align="center" ' . $styl_cadr_ent . ' ' . $lgremise . '><strong>Montant TTC</strong></td>
          </tr>
    </thead>';

foreach ($tvas as $i => $tva) {
    $ligne=ClassRegistry::init($ligne_model)->find('first',array('conditions'=>array($ligne_model . '.' . $attribut => $factureclient[$model]['id'], $ligne_model . '.tva'=>$tva['Tva']['name']),'recursive'=>-1));
      $tbl .= ' <tr> 
                 <td height="25px" align="right" ' . $styl_cadr . ' ' . $lgcode . ' >&nbsp;' . @$ligne[$ligne_model]['totalht'] . '</td>
                 <td height="25px" align="right" ' . $styl_cadr . ' ' . $lgcode . ' >&nbsp;' . $tva['Tva']['name'] . '</td>
                 <td height="25px" align="right" ' . $styl_cadr . ' ' . $lgcode . ' >&nbsp;' . @$ligne[$ligne_model]['tttva'] . '</td>
                 <td height="25px" align="right" ' . $styl_cadr . ' ' . $lgcode . ' >&nbsp;' . @$ligne[$ligne_model]['totalttc'] . '</td>
                </tr>';
    
}

$tbl .= '</table>
    
                 <br><br>
    <table>
        <tr>
            <td width="50%"></td>
            <td width="50%">
                <table border="1">';

               $tbl .= '<tr>
                        <td align="left" style="background-color:#b8b8b8;" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total TVA  </strong></td>  
                        <td align="right" height="25px"  width="50%">' . number_format($factureclient[$model]['tva'], 3, '.', ' ') . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>  
                      </tr>';
if ($model == 'Facture') {
    $tbl .= '<tr>
                        <td align="left" style="background-color:#b8b8b8;" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Timbre  </strong></td>  
                        <td align="right" height="25px"  width="50%">' . number_format($factureclient[$model]['timbre_id'], 3, '.', ' ') . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 
                    </tr>';
}
               $tbl .= '<tr>
                          <td align="left" style="background-color:#b8b8b8;" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total HT  </strong></td>  
                          <td align="right" height="25px"  width="50%">' . number_format($factureclient[$model]['totalht'], 3, '.', ' ') . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> 
                    </tr>    
                    <tr>
                        <td align="left" style="background-color:#b8b8b8;" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total TTC  </strong></td>  
                        <td align="right" height="25px"  width="50%">' . number_format($factureclient[$model]['totalttc'], 3, '.', ' ') . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>  
                    </tr> 
                </table>
            </td>
        </tr>
    </table>
        
<br><br>
    <table cellpadding="2" cellspacing="0" >
    <thead>
    
    <tr>
        <td height="35px"></td>
    </tr>
     <tr>
        <td height="90px" width="25%" align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;">
            <strong>Signature et cachet</strong>
        </td>
        <td height="40px" colspan="6" width="50%" align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;">
        <br>   <br>
            <strong>Arretée la présente '.$ent.' à la somme de :</strong>
            <br>
            '.chifre_en_lettre($factureclient[$model]['totalttc'],1,1).'
        </td>
        <td height="40px" colspan="6" width="25%" align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;">
        <br>   <br>
           <strong>TOTAL TTC </strong>
            <br>
            '.$factureclient[$model]['totalttc'].'
        </td>
    </tr>     
      
</table>
        ';
    
    
           
$tbl .='</table>';

$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
//Close and output PDF document
ob_end_clean();
$pdf->Output('imprimer_view_facture', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>