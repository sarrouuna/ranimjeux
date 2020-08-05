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
$pdf->SetAuthor('younescoif');
$pdf->SetTitle('Commandeclient');
$ent = 'entete.jpg';
$ModelSociete = ClassRegistry::init('Pointdevente');
$pontdevente = $ModelSociete->find('first',array('conditions'=>array('Pointdevente.id'=>$commandeclient['Commandeclient']['pointdevente_id'])));
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
$a1=$pdf->getAliasNumPage();
$a2=$pdf->getAliasNbPages();
$a3="/";

// ---------------------------------------------------------
$styl_cadr_bottom='style="border-left:1px solid black;border-right:1px solid black;border-bottom: none;"';
$styl_cadr_hauteur='style="border-bottom: 1px solid black;border-left:1px solid black;border-right:1px solid black;border-top: none;"';
$styl_cadr_fin='style="border-bottom:1px solid black;border-right:1px solid black;border-left:1px solid black;"';
$pdf->AddPage();

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 9);
$logo=  CakeSession::read('logo');
$ModelSociete = ClassRegistry::init('Zone');
$zone = $ModelSociete->find('first',array('conditions'=>array('Zone.id'=>$commandeclient['Client']['zone_id'])));
//debug($commandeclient);die;

$entette .=' 

<table width="100%"  >
<tr>
    <td width="70%" align="left" >
            <strong style="font-size:20;">'.$soc['Societe']['nom'].'</strong> <br>
            <table>
            <tr>
            <td align="left" width="70%">
            '.$soc['Societe']['adresse'].'<br>
            '.$soc['Societe']['tel'].'<br>
            '.$soc['Societe']['rib'].'<br>
            '.$soc['Societe']['rc'].'   <br> 
            '.$soc['Societe']['codetva'].'   <br> 
            </td>
            </tr>
            </table>
    </td>
    <td  width="30%" align="left">
            <IMG SRC="../webroot/img/'.$soc["Societe"]["logo"].'" width="150" height="100" >
    </td>
    
</tr>
</table>




<table >
    <tr >
        <td width="49%" '.$styl_cadr.'>
            <table border="0">
                <tr>
                    <td height="40px" align="left" style="border: 1px solid black;" >
                        <strong style="font-size:15;">Bon Commande N°: '.$commandeclient['Commandeclient']['numero'].'</strong><br><br> 
                        <strong style="font-size:10;">LE  : '.date("d/m/Y", strtotime(str_replace('-', '/',  $commandeclient['Commandeclient']['date']))).' </strong> <br> 
                    </td> 
                </tr>
            </table>
        </td>
        <td width="2%"></td>
        <td width="49%" '.$styl_cadr.'>
            <table border="0">
                <tr>
                    <td height="40px" align="left" style="border: 3px solid black;">
                        <strong>Code Client&nbsp;:&nbsp;'.$commandeclient['Client']['code'].'</strong><br>
                        <strong>Client&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;'.$commandeclient['Client']['name'].'</strong><br>
                        <strong>Adresse&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;'.$commandeclient['Client']['adresse'].' </strong><br>    
                        <strong>Ville&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;'.$zone['Zone']['name'].' </strong><br> 
                        <strong>Mat.Fisc&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;'.$commandeclient['Client']['matriculefiscale'].' </strong><br>    
                    </td>     
                </tr>
            </table>
        </td>
    </tr>
    <br>
    </tr>
</table>

<table  cellpadding="2" cellspacing="0" >
    
    <tr>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="15%"><strong>code</strong></td>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="30%"><strong>Article</strong></td>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="10%"><strong>Quantité</strong></td>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="7%"><strong>TVA</strong></td>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="10%"><strong>P.U.HT</strong></td>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="8%"><strong>REM</strong></td>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="10%"><strong>P.U.TTC</strong></td>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="10%"><strong>TOTAL HT</strong></td>
    </tr>';










$tbl .=' 

<table width="100%"  >
<tr>
    <td width="70%" align="left" >
            <strong style="font-size:20;">'.$soc['Societe']['nom'].'</strong> <br>
            <table>
            <tr>
            <td align="left" width="70%">
            <center>'.$soc['Societe']['adresse'].'</center><br>
            <center>'.$soc['Societe']['tel'].'</center><br>
            <center>'.$soc['Societe']['rib'].'</center><br>
            <center>'.$soc['Societe']['rc'].'</center>   <br> 
            <center>'.$soc['Societe']['codetva'].'</center>   <br> 
            </td>
            </tr>
            </table>
    </td>
    <td  width="30%" align="left">
            <IMG SRC="../webroot/img/'.$soc["Societe"]["logo"].'" width="150" height="100" >
    </td>
    
</tr>
</table>




<table >
    <tr >
        <td width="49%" '.$styl_cadr.'>
            <table border="0">
                <tr>
                    <td height="40px" align="center" style="border: 1px solid black;" >
                        <strong style="font-size:15;">Bon Commande N°: <br> '.$commandeclient['Commandeclient']['numero'].'</strong><br><br> 
                        <strong style="font-size:10;">LE  : '.date("d/m/Y", strtotime(str_replace('-', '/',  $commandeclient['Commandeclient']['date']))).' </strong> <br> 
                    </td> 
                </tr>
            </table>
        </td>
        <td width="2%"></td>
        <td width="49%" '.$styl_cadr.'>
            <table border="0">
                <tr>
                    <td height="40px" align="left" style="border: 3px solid black;">
                        <strong>Code Client&nbsp;:&nbsp;'.$commandeclient['Client']['code'].'</strong><br>
                        <strong>Client&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;'.$commandeclient['Client']['name'].'</strong><br>
                        <strong>Adresse&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;'.$commandeclient['Client']['adresse'].' </strong><br>    
                        <strong>Ville&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;'.$zone['Zone']['name'].' </strong><br> 
                        <strong>Mat.Fisc&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;'.$commandeclient['Client']['matriculefiscale'].' </strong><br>    
                    </td>     
                </tr>
            </table>
        </td>
    </tr>
    <br>
    </tr>
</table>

<table cellpadding="2" cellspacing="0" >
    
    <tr>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="15%"><strong>code</strong></td>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="30%"><strong>Article</strong></td>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="10%"><strong>Quantité</strong></td>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="7%"><strong>TVA</strong></td>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="10%"><strong>P.U.HT</strong></td>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="8%"><strong>REM</strong></td>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="10%"><strong>P.U.TTC</strong></td>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="10%"><strong>TOTAL HT</strong></td>
    </tr>
    ';

        $long="670";
        $n=0;
        $kk=0;
        $nbr_tot=count($lignecommandeclients);
        $tot_rest=$nbr_tot;
        $hauteur=380;
        foreach ($lignecommandeclients as $i=>$lr){
        
        
        
        $kk++;
        $n=$n+10;   
        $long=$long-10;
        if($lr['Lignecommandeclient']['prix']==0){
        $lr['Lignecommandeclient']['prix']="";
        }
        if($lr['Lignecommandeclient']['remise']==0){
        $lr['Lignecommandeclient']['remise']="";
        }
        if($lr['Lignecommandeclient']['tva']==0){
        $lr['Lignecommandeclient']['tva']="";
        }
        if($lr['Lignecommandeclient']['totalht']==0){
        $lr['Lignecommandeclient']['totalht']="";
        }
        if($lr['Lignecommandeclient']['totalttc']==0){
        $lr['Lignecommandeclient']['totalttc']="";
        }
$tbl .='
    
     <tr> 
        <td align="left" '.$styl_cadr_bottom.' width="15%" >&nbsp;'. $lr['Article']['code'].'</td>
        <td align="left" '.$styl_cadr_bottom.' width="30%" >&nbsp;'.substr($lr['Lignecommandeclient']['designation'],0,40).'</td>
        <td align="center" '.$styl_cadr_bottom.' width="10%">&nbsp;'.$lr['Lignecommandeclient']['quantite'].'</td>  
        <td align="right" '.$styl_cadr_bottom.' width="7%" >&nbsp;'.number_format($lr['Lignecommandeclient']['tva'],2, '.', ' ').'</td>
        <td align="right" '.$styl_cadr_bottom.' width="10%" >&nbsp;'.$lr['Lignecommandeclient']['prix'].'</td>
        <td align="right" '.$styl_cadr_bottom.' width="8%" >&nbsp;'.number_format($lr['Lignecommandeclient']['remise'],2, '.', ' ').'</td>
        <td align="right" '.$styl_cadr_bottom.' width="10%" >&nbsp;'.$lr['Lignecommandeclient']['puttc'].'</td>
        <td align="right" '.$styl_cadr_bottom.' width="10%" >&nbsp;'.number_format($lr['Lignecommandeclient']['totalht'],3, '.', ' ').'</td>    
        
        
</tr>
    
';
$hauteur=$hauteur-10;
if($tot_rest !=37){
if(($kk==37)){
        $tot_rest=$tot_rest-$kk;
        $kk=0; 
        if($nbr_tot>37){
        $hauteur=380;
        $n=0;
        }
        $tbl .='
        <tr>         
        <td align="center" '.$styl_cadr_fin.' width="15%"></td>
        <td align="center" '.$styl_cadr_fin.' width="30%"></td>
        <td align="center" '.$styl_cadr_fin.' width="10%"></td>
        <td align="center" '.$styl_cadr_fin.' width="7%"></td>
        <td align="center" '.$styl_cadr_fin.' width="10%"></td>
        <td align="center" '.$styl_cadr_fin.' width="8%"></td>
        <td align="center" '.$styl_cadr_fin.' width="10%"></td>
        <td align="center" '.$styl_cadr_fin.' width="10%"></td>    
        </tr> 
        </table>
        ';
        //$pdf->writeHTML($tbl, true, false, false, false, '');
        //$pdf->AddPage('P');
        //$tbl .='</table>';
        $tbl .='<br pagebreak="true"/>';
        $tbl .=$entette;
        
}}




}
if(($kk>14)&&($kk<37)){

if($kk==15) {
$hauteur=190;    
}
if($kk==16) {
$hauteur=180;    
}
if($kk==17) {
$hauteur=170;    
}
if($kk==18) {
$hauteur=160;    
}
if($kk==19) {
$hauteur=150;    
}
if($kk==20) {
$hauteur=130;    
}
if($kk==21) {
$hauteur=110;    
}
if($kk==22) {
$hauteur=90;    
}
if($kk==23) {
$hauteur=80;    
}
if($kk==24) {
$hauteur=60;    
}
if($kk==25) {
$hauteur=40;    
}
if($kk==26) {
$hauteur=40;    
}
if($kk==27) {
$hauteur=40;    
}
if($kk==28) {
$hauteur=40;    
}
if($kk==29) {
$hauteur=40;    
}
if($kk==30) {
$hauteur=40;    
}
if($kk==31) {
$hauteur=40;    
}
if($kk==32) {
$hauteur=115;    
}
if($kk==33) {
$hauteur=95;    
}
if($kk==34) {
$hauteur=75;    
}
if($kk==35) {
$hauteur=55;    
}
if($kk==36) {
$hauteur=35;    
}

}
 
   $tbl .='
    <tr>
        <td align="center" '.$styl_cadr_hauteur.' width="15%" >&nbsp;<br></td>
        <td align="center" '.$styl_cadr_hauteur.' width="30%">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_hauteur.' width="10%">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_hauteur.' width="7%">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_hauteur.' width="10%">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_hauteur.' width="8%" height="'.$hauteur.'px">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_hauteur.' width="10%">&nbsp;<br></td>  
        <td align="center" '.$styl_cadr_hauteur.' width="10%">&nbsp;<br></td>  
    </tr>';

if(($nbr_tot>25)&&($nbr_tot<38)){
        //$tbl .='<br pagebreak="true"/>';
}
   
   
   
   
$tbl .='
<tr>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8"  width="32.8%" height="10px">CACHET ET SIGNATURE</td>
        <td align="center" style="border: 1px solid black;background-color:#b8b8b8" width="29.2%">
        <table>
        <tr>
        <td align="center" style="border-left:none;border-right:1px solid black;border-bottom: none;border-top: none;" width="40%">ASSIETTE</td>  
        <td align="center" style="border-left:1px solid black;border-right:1px solid black;border-bottom: none;border-top: none;" width="20%">TAUX</td>  
        <td align="center"  width="40%">MONT. TVA</td>  
        </tr>
        </table>
        </td>
        <td align="left" style="border: 1px solid black;background-color:#b8b8b8" width="38%">
            <table>
            <tr>
            <td align="left" width="50%">TOTAL H.T :</td>
            <td align="right" width="50%">'.number_format($commandeclient['Commandeclient']['totalht']+$commandeclient['Commandeclient']['remise'],3, '.', ' ').'&nbsp;&nbsp;</td>
            </tr>
            </table>
        </td>  
        </tr>     
        <tr>
        <td align="center" style="border: 1px solid black;"  width="32.8%" height="120px"></td>
        <td align="right" style="border: 1px solid black;" width="29.2%">
        <table >';
        $obj = ClassRegistry::init('Lignecommandeclient');
        $lignefactureclientstva = $obj->find('all',array('fields'=>array(
        'SUM((Lignecommandeclient.totalht*Lignecommandeclient.tva)/100)  mtva'
        ,'SUM(Lignecommandeclient.totalht) totalht'
        ,'AVG(Lignecommandeclient.tva) tva'),
        'conditions'=>array('Lignecommandeclient.commandeclient_id' => $commandeclient['Commandeclient']['id'])
        ,'group'=>array('Lignecommandeclient.tva')       
        ));
        $tva=0;
        foreach ($lignefactureclientstva as $i=>$lr){
        if(!empty($lr[0]['mtva'])){     
        $hauteurtva=120-18;    
        $tbl .='
        <tr>
        <td align="right" style="border-left:none;border-right:1px solid black;border-bottom: none;border-top: none;"  width="40%">'.number_format($lr[0]['totalht'],3, '.', ' ').'&nbsp;&nbsp;&nbsp;&nbsp;</td>  
        <td align="center" style="border-left:1px solid black;border-right:1px solid black;border-bottom: none;border-top: none;"  width="20%">'.sprintf('%.0f',$lr[0]['tva']).' %</td>  
        <td align="right"  width="40%">'.number_format($lr[0]['mtva'],3, '.', ' ').'&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>';
        }}
        $tbl .='
        <tr>
        <td height="'.$hauteurtva.'px" style="border-left:none;border-right:1px solid black;border-bottom: none;border-top: none;"></td>
        <td style="border-left:1px solid black;border-right:1px solid black;border-bottom: none;border-top: none;"></td>
        <td></td>
        </tr>    
        </table>
        </td>
        <td align="left" style="border: 1px solid black;" width="38%">
        <table  width="100%" align="left" >
        <tr>
        <td height="24px" align="left">REMISE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
        <td  align="right">'.number_format($commandeclient['Commandeclient']['remise'],3, '.', ' ').'</td>
        </tr>
        <tr>
        <td height="24px" align="left">NET H.TVA&nbsp;&nbsp;:</td>
        <td align="right">'.number_format($commandeclient['Commandeclient']['totalht'],3, '.', ' ').'</td>
        </tr>
        <tr >
        <td height="24px" align="left">TOTAL TVA  :</td>
        <td align="right">'.number_format($commandeclient['Commandeclient']['tva'],3, '.', ' ').'</td>
        </tr>
        <tr>
        <td height="24px" align="left">TIMBRE FIS&nbsp;:</td>
        <td align="right">'.number_format($commandeclient['Timbre']['timbre'],3, '.', ' ').'</td>
        </tr>
        <tr>
        <td style="border-left:none;border-right:none;border-bottom: none;border-top:none;"  align="left"><strong style="font-size:10;">NET T.T.C</strong></td>
        <td style="border-left:none;border-right:none;border-bottom: none;border-top:none;" align="right"><strong style="font-size:10;">'.number_format($commandeclient['Commandeclient']['totalttc'],3, '.', ' ').'</strong></td>
        </tr>
        </table>
        </td>  
</tr>    
';    
    
           
$tbl .='</table>
<br><br>
<table >
    <tr>
        <td   width="100%" align="left" >
            <strong style="font-size:10;">Arreter la présente Commandeclient à  la somme de :</strong><br>
            <strong style="font-size:15;">'.chifre_en_lettre($commandeclient['Commandeclient']['totalttc'],1,1).'</strong>
        </td>
    </tr>
</table> 
';

$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------
//Close and output PDF document
ob_end_clean();
$pdf->Output('imprimer_view_devis', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>