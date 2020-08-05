
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
$pdf->SetTitle('Detail importation');

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
    <td width="45%" align="left" >
    <IMG SRC="../webroot/img/'.$soc["Societe"]["logo"].'" width="110"  >
</td>
    <td  width="55%">
        <table width="100%">
            <tr>
            <br> 
                <td height="35px" align="left" ><strong>liste des importation  '.$m.'</strong></td> 
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
        
          
               
$tbl .= '
<table width="100%" align="center">
<tr>
<td align="left">Désignation :</td><td>'.@$this->request->data['Importation']['name'].'</td><td align="left">Avis :</td><td>'.@$this->request->data['Importation']['avis'].'</td>
</tr>
<tr>
<td align="left">Numero :</td><td>'.@$this->request->data['Importation']['numero'].'</td><td align="left">Transitaire :</td><td>'.@$this->request->data['Importation']['transitaire'].'</td>
</tr>
<tr>
<td align="left">Date :</td><td>'.@date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Importation']['date']))).'</td><td align="left">DD&TVA :</td><td>'.@$this->request->data['Importation']['ddttva'].'</td>
</tr>
<tr>
<td align="left">Fournisseur :</td><td>'.@$this->request->data['Fournisseur']['name'].'</td><td align="left">Assurance :</td><td>'.@$this->request->data['Importation']['assurence'].'</td>
</tr>
<tr>
<td align="left">Devise :</td><td>'.@$this->request->data['Devise']['name'].'</td><td align="left">Divers :</td><td>'.@$this->request->data['Importation']['divers'].'</td>
</tr>
<tr>
<td align="left">Montant Achat :</td><td>'.@$this->request->data['Importation']['montantachat'].'</td><td align="left">Frais Financiers :</td><td>'.@$this->request->data['Importation']['fraisfinancie'].'</td>
</tr>
<tr>
<td align="left">Cours Devise :</td><td>'.@$this->request->data['Importation']['tauxderechenge'].'</td><td align="left">Coefficient :</td><td>'.@$this->request->data['Importation']['coefficien'].'</td>
</tr>
<tr>
<td></td><td></td><td align="left">Totale :</td><td>'.@$this->request->data['Importation']['totale'].'</td>
</tr></table><br><br><table border="1"><tr><td width="100%" align="center">Table des Pieces Jointes</td></tr>
<tr><td align="center" width="40%">Désignation</td><td align="center" width="60%">Piece</td></tr>';
     
foreach (@$this->request->data['Piecejointe'] as $br){
        $obj = ClassRegistry::init('Namepiecejointe');
        $test = $obj->find('first',array('conditions'=>array('Namepiecejointe.id'=>$br['namepiecejointe_id']),'recursive'=>-1));     
        
 $tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="40%" nobr="nobr" align="center" height="30px" $zz>'.@$test['Namepiecejointe']['name'].'</td>
        <td width="60%" nobr="nobr" align="center"  $zz>'.$br['piece'].'</td>    
    </tr>' ;     
}
$tbl .= '</table><br><br><table border="1"><tr><td width="100%" align="center">Table des Situations</td>
</tr><tr><td align="center" width="55%">Situation</td><td align="center" width="15%">Date début</td><td align="center" width="15%">Date fin</td><td align="center" width="10%">Nbr Jours</td><td align="center" width="5%"></td></tr>';
foreach ($situations as $s=>$situation) {
$croix="";    
if($situation_id==$situation['Situation']['id']){$croix='<IMG SRC="../webroot/img/cross.png" >'; }       
 $tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="55%" nobr="nobr" align="center" height="30px" $zz>'.$situation['Namesituation']['name'].'</td>
        <td width="15%" nobr="nobr" align="center"  $zz>'.date("d/m/Y",strtotime(str_replace('/','/',$situation['Situation']['datedebut']))).'</td>
        <td width="15%" nobr="nobr" align="center"  $zz>'.date("d/m/Y",strtotime(str_replace('/','/',$situation['Situation']['datefin']))).'</td>
        <td width="10%" nobr="nobr" align="center"  $zz>'.$situation['Situation']['nbrjour'].'</td>
        <td width="5%" nobr="nobr" align="center"  $zz>'.@$croix.'</td>    
    </tr>' ;     
}    
$tbl .= '</table><br><br><br><br><table border="1"><tr><td width="100%" align="center">Ligne d\'achat par cette importation</td></tr>
<tr><td align="center" width="10%">Ref</td><td align="center" width="52%">Article</td><td align="center" width="6%">Quantite</td>
<td align="center" width="8%">Prix</td><td align="center" width="8%">Tot Prix</td><td align="center" width="8%">CDR</td><td align="center" width="8%">Total CDR</td></tr>';
foreach ($lignefactures as $i=>$lr) {
 $tbl .= 
    '<tr bgcolor="#FFFFFF" align="center">    
        <td width="10%" nobr="nobr" align="center" height="30px" $zz>'.$lr['Article']['code'].'</td>
        <td width="52%" nobr="nobr" align="center"  $zz>'.$lr['Article']['name'].'</td>
        <td width="6%" nobr="nobr" align="center"  $zz>'.$lr['Lignefacture']['quantite'].'</td>
        <td width="8%" nobr="nobr" align="center"  $zz>'.$lr['Lignefacture']['prix'].'</td>
        <td width="8%" nobr="nobr" align="center"  $zz>'.sprintf('%.3f',$lr['Lignefacture']['prix']*$lr['Lignefacture']['quantite']).'</td> 
        <td width="8%" nobr="nobr" align="center"  $zz>'.$lr['Lignefacture']['prixhtva'].'</td>
        <td width="8%" nobr="nobr" align="center"  $zz>'.sprintf('%.3f',$lr['Lignefacture']['prixhtva']*$lr['Lignefacture']['quantite']).'</td>    
    </tr>' ;     
}    
$tbl .= '</table>';
if(!empty($reglements)){
   // debug($reglements);die();
     foreach($reglements as $reglement){
$tbl .='<br><br><br><table>
    <tr>
        <td width="49%">
            <table border="0">
                <tr>
                    <td height="40px" align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" >
                        <strong>'.$reglement['Fournisseur']['name'].'</strong>
                        <br>
                        '.$reglement['Fournisseur']['adresse'].'
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
                        '.$reglement['Fournisseur']['matriculefiscale'].'
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
                    <td height="30px" align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;">
                        <strong>Date</strong>
                        <br>
                        '.date("d/m/Y",strtotime(str_replace('-','/',($reglement['Reglement']['Date'])))).'
                    </td>
                    
                    <td height="30px" align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;">
                        <strong>Fournisseur N°</strong>
                        <br>
                        '.$reglement['Fournisseur']['code'].'
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
<table cellpadding="2" cellspacing="0" >
    <thead>    
    <tr>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="20%"  height="35px"><strong>Numéro</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="20%"><strong>Date</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="20%"><strong>Montant</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="20%"><strong>Montant Reglé</strong></td>
        <td align="center" style="border-bottom:solid #000 2px;border-top:solid #000 2px;border-left:solid #000 2px;border-right:solid #000 2px;" width="20%"><strong>Reste</strong></td>
    </tr>
    </thead>';

$long="670";
        $t='0';
        foreach($reglement['Lignereglement']as $j=>$l){
        $t=$t.','.$l['facture_id'];
        }
        $obj = ClassRegistry::init('Facture');
        $factures = $obj->find('all',array('conditions'=>array('Facture.id in('.$t.')'),'recursive'=>0));  
        foreach ($factures as $l){
        $numero = $l['Facture']['numero']; 
        $date = date("d/m/Y",strtotime(str_replace('-','/',$l['Facture']['date'])));
        $total_ttc = $l['Facture']['totalttc'];
        $mnt_reg = $l['Facture']['Montant_Regler'];
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
        $tot=$reglement['Reglement']['Montant'];

    $tbl .='
          <table>
            <tr>
                <td height="20px"></td>
            </tr>
        </table>
        <tr>
            <td height="30px" align="center" colspan="3" style="border-left:solid #000 2px;border-right:solid #000 2px;border-top:solid #000 2px;" width="50%" >&nbsp;<br>Montant Total<br></td>
            <td height="30px"align="center" colspan="2" style="border-right:solid #000 2px;border-top:solid #000 2px;" width="50%">&nbsp;<br><strong>'.$tot.'</strong></td>
        </tr>
        
        <tr>
            <td height="30px"align="center" colspan="3" style="border-left:solid #000 2px;border-right:solid #000 2px;border-top:solid #000 2px;" width="50%" >&nbsp;<br>Montant Payée<br></td>
            <td height="30px"align="center" colspan="2" style="border-right:solid #000 2px;border-top:solid #000 2px;" width="50%">&nbsp;<br><strong>'.$reglement['Reglement']['Montant'].'</strong></td>
        </tr>
        <tr>
            <td height="20px" colspan="5" style="border-top:solid #000 2px;"></td>
        </tr></tbody>
</table>
        ';
    
    
            $tbl .='
                
                <table cellpadding="2" cellspacing="3" border="1">
                <tr>
                    <td width="20%" align="center" height="35px"><strong>Mode règlement</strong></td>
                    <td width="20%" align="center" ><strong>Montant</strong></td>
                    <td width="20%" align="center" ><strong>Echéance  </strong></td>
                    <td width="10%" align="center" ><strong>Numéro Pièce</strong></td>
                    <td width="20%" align="center" ><strong>Banque </strong></td>
                    <td width="10%" align="center" ><strong>Nbr mois </strong></td>
                </tr>';
            $tot_esp=0;$tot_ch=0;$tot_tr=0;$tot_vir=0;$tot_ret=0;$tot_lc=0;$tot_c=0;
            //debug($pieceregement);die();
            $obj = ClassRegistry::init('Piecereglement');
            $piecereglement = $obj->find('all',array('conditions'=>array('Piecereglement.reglement_id'=>$reglement['Reglement']['id'])));
            foreach($piecereglement as $i=>$lp ){
                $montantcredit=$lp['Piecereglement']['montant'];
            if($lp['Piecereglement']['paiement_id']==7){
            $obj = ClassRegistry::init('Traitecredit');
            $credit = $obj->find('all',array('conditions'=>array('Traitecredit.piecereglement_id'=>$lp['Piecereglement']['id']),'recursive'=>0));   
            }       
            $obj = ClassRegistry::init('Situationpiecereglement');
            $situationpiecereglement = $obj->find('all',array('conditions'=>array('Situationpiecereglement.piecereglement_id'=>$lp['Piecereglement']['id'])));
                $piece_id=$lp['Paiement']['id'];
                if($lp['Paiement']['id']==1){
                    $tot_esp=$tot_esp+$lp['Piecereglement']['montant'];
                }
                if($lp['Paiement']['id']==2){
                    $tot_ch=$tot_ch+$lp['Piecereglement']['montant'];
                }
                if($lp['Paiement']['id']==3){
                    $tot_tr=$tot_tr+$lp['Piecereglement']['montant'];
                }
                if($lp['Paiement']['id']==4){
                    $tot_vir=$tot_vir+$lp['Piecereglement']['montant'];
                }
                if($lp['Paiement']['id']==5){
                    $tot_ret=$tot_ret+$lp['Piecereglement']['montant'];
                }
                if($lp['Paiement']['id']==6){
                    $tot_lc=$tot_lc+$lp['Piecereglement']['montant'];
                }
                if($lp['Paiement']['id']==7){
                    $tot_c=$tot_c+$lp['Piecereglement']['montant'];
                }
                //debug($lp);die;
                if($lp['Paiement']['id']==1){
                 $tbl .='
                    <tr> 
                        <td  align="center"  width="20%" height="35px">'.$lp['Paiement']['name'].'</td>
                        <td  align="center"  width="20%" height="35px">'.$lp['Piecereglement']['montant'].'</td>
                        <td  align="center"  width="20%" height="35px"></td>
                        <td  align="center"  width="10%" height="35px"></td>
                        <td  align="center"  width="20%" height="35px"></td>
                        <td  align="center"  width="10%" height="35px"></td>
                    </tr>';
                }
                if($lp['Paiement']['id']==5){
                 $tbl .='
                    <tr> 
                        <td  align="center"  width="20%" height="35px">'.$lp['Paiement']['name'].'</td>
                        <td  align="center"  width="20%" height="35px">'.$lp['Piecereglement']['montant'].'</td>
                        <td  align="center"  width="20%" height="35px"></td>     
                        <td  align="center"  width="10%" height="35px">'.$lp['Piecereglement']['num'].'</td>
                        <td  align="center"  width="20%" height="35px"></td>
                        <td  align="center"  width="10%" height="35px"></td>
                    </tr>';
                }
                if($lp['Paiement']['id']==7){
                 $tbl .='
                    <tr> 
                        <td  align="center"  width="20%" height="35px">'.$lp['Paiement']['name'].'</td>
                        <td  align="center"  width="20%" height="35px">'.$lp['Piecereglement']['montant'].'</td>
                        <td  align="center"  width="20%" height="35px"></td>
                        <td  align="center"  width="10%" height="35px"></td>
                        <td  align="center"  width="20%" height="35px">'.$lp['Compte']['banque'].'</td>
                        <td  align="center"  width="10%" height="35px">'.$lp['Piecereglement']['nbrmoins'].'</td>
                    </tr>';
                }
            if($lp['Paiement']['id']!=1 && $lp['Paiement']['id']!=5 && $lp['Paiement']['id']!=7){
            $tbl .='
                <tr> 
                    <td  align="center"  width="20%" height="35px">'.$lp['Paiement']['name'].'</td>
                    <td  align="center"  width="20%" height="35px">'.$lp['Piecereglement']['montant'].'</td>
                    
                    <td  align="center"  width="20%" height="35px">'.date("d/m/Y",strtotime(str_replace('-','/',$lp['Piecereglement']['echance']))).'</td>
                    <td  align="center"  width="10%" height="35px">'.$lp['Piecereglement']['num'].'</td>
                    <td  align="center"  width="20%" height="35px">'.$lp['Compte']['banque'].'</td>
                    <td  align="center"  width="10%" height="35px"></td>    
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

                <table cellpadding="2" cellspacing="3" border="1" >
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
                </tr>
                 <tr>
                    <td width="50%" align="center" height="35px"><strong>Total Lettre de crédit</strong></td>
                    <td width="50%" align="center" ><strong>'.sprintf("%.3f",$tot_lc).'</strong></td>
                </tr>
                 <tr>
                    <td width="50%" align="center" height="35px"><strong>Total crédit </strong></td>
                    <td width="50%" align="center" ><strong>'.sprintf("%.3f",$tot_c).'</strong></td>
                </tr>

';
 
 $tbl .='</table><br><br><br>';
 
 if($piece_id==7){
 $tbl .='
                
                <table cellpadding="2" cellspacing="3" border="1">
                <tr>
                    <td width="10%" align="center" height="35px"><strong>N°</strong></td>
                    <td width="30%" align="center" ><strong>Numéro de piéce</strong></td>
                    <td width="30%" align="center" ><strong>Echéance  </strong></td>
                    <td width="30%" align="center" ><strong>Montant</strong></td>
                    
                </tr>'; 
$totale=0;
$agio=0;
foreach ($credit as $n=>$c){ 
$m=$n+1;
$totale=$totale+$c['Traitecredit']['montantcredit'];
$agio=$totale-$montantcredit;
$tbl .='
                <tr> 
                    <td  align="center"  width="10%" height="35px">'.$m.'</td>
                    <td  align="center"  width="30%" height="35px">'.@$c['Traitecredit']['num_piececredit'].'</td>
                    <td  align="center"  width="30%" height="35px">'.date("d/m/Y",strtotime(str_replace('-','/',@$c['Traitecredit']['echancecredit']))).'</td>
                    <td  align="center"  width="30%" height="35px">'.@$c['Traitecredit']['montantcredit'].'</td>
                </tr>';    
}
$tbl .='<tr>
                    <td width="71%" align="center" height="35px"><strong>Total</strong></td>
                    <td width="30%" align="center" ><strong>'.sprintf("%.3f",$totale).'</strong></td>
        </tr>
        <tr>
                    <td width="71%" align="center" height="35px"><strong>Agio</strong></td>
                    <td width="30%" align="center" ><strong>'.sprintf("%.3f",$agio).'</strong></td>
        </tr>
        </table><br><br>';
}
if(!empty($situationpiecereglement)){ 
 $tbl .='
                
                <table cellpadding="2" cellspacing="3" border="1">
                <tr>
                    <td width="30%" align="center" height="35px"><strong>Etat</strong></td>
                    <td width="30%" align="center" ><strong>Date</strong></td>
                    <td width="30%" align="center" ><strong>Agio</strong></td>
                    <td width="10%" align="center" ><strong></strong></td>
                    
                </tr>'; 
foreach ($situationpiecereglement as $n=>$l){ 
$croi="";    
if($l['Piecereglement']['etatpiecereglement_id']==$l['Situationpiecereglement']['etatpiecereglement_id']){$croi='<IMG SRC="../webroot/img/cross.png" >'; }    
$tbl .='
                <tr> 
                    <td  align="center"  width="30%" height="35px">'.@$l['Etatpiecereglement']['name'].'</td>
                    <td  align="center"  width="30%" height="35px">'.@date("d/m/Y",strtotime(str_replace('-','/',$l['Situationpiecereglement']['date']))).'</td>
                    <td  align="center"  width="30%" height="35px">'.@$l['Situationpiecereglement']['agio'].'</td>
                    <td  align="center"  width="10%" height="35px">'.@$croi.'</td>
                </tr>';    
}
$tbl .='</table>';
}
}
}
$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('detail_importation.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>