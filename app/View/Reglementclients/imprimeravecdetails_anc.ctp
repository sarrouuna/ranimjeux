
<?php

App::import('Vendor', 'xtcpdf');
$pdf = new XTCPDF();

class MYPDF extends TCPDF {

    var $xheadertext = 'PDF created using CakePHP and TCPDF';
    var $xheadercolor = array(0, 0, 200);
    //var $xfootertext  = 'Copyright Ã‚Â© %d XXXXXXXXXXX. <b>All rights reserved.</b>'; 
    var $xfooterfont = PDF_FONT_NAME_MAIN;
    var $xfooterfontsize = 8;

    //Page header
    public function Header() {
        
    }

    // Page footer
    public function Footer() {
        $year = date('Y');
        $footertext = sprintf($this->xfootertext, $year);
        $this->SetY(-20);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($this->xfooterfont, '', $this->xfooterfontsize);
        $footertext1 = sprintf($this->xfootertext1, $year);
        $this->SetY(-20);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($this->xfooterfont, '', $this->xfooterfontsize);
        $footertext2 = sprintf($this->xfootertext2, $year);
        $this->SetY(-20);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($this->xfooterfont, '', $this->xfooterfontsize);
        $this->Cell(0, 8, $footertext, 'T', 1, 'L');
        $this->Cell(0, 1, $footertext1, 0, 1, 'L');
        $this->Cell(0, 3, $footertext2, 0, 1, 'L');
    }

}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sotem');
$pdf->SetTitle('Edition recette');

$ent = 'entete.jpg';
$ModelSociete = ClassRegistry::init('Societe');
$soc = $ModelSociete->find('first', array('conditions' => array('Societe.mere' => 1)));

$footer = '     SARL au Capital de : ' . $soc['Societe']['capital'] . '          Adresse : ' . $soc['Societe']['adresse'] . '          Code T.V.A: ' . $soc['Societe']['codetva'] . '          RIB: ' . $soc['Societe']['rib'] . '          RC: ' . $soc['Societe']['rc'];
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
if ($datereglement1 != "__/__/____" && $datereglement1 != "1970-01-01" && $datereglement2 != "__/__/____" && $datereglement2 != "1970-01-01") {
    $datereglement1 = date('d/m/Y', strtotime(str_replace('-', '/', $datereglement1)));
    $datereglement2 = date('d/m/Y', strtotime(str_replace('-', '/', $datereglement2)));
    $m = ' du  ' . $datereglement1 . ' au  ' . $datereglement2;
}
// ---------------------------------------------------------

$pdf->AddPage('L');

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);
$w=60/10; 
$pdf->SetFont('times', 'A', 6);
$logo = CakeSession::read('logo');

$tbl .=' 

<table width="100%">
<tr>
    <td width="45%" align="left" >
                        <IMG SRC="../webroot/img/' . $soc["Societe"]["logo"] . '" width="120"  >
                    </td>
    <td  width="55%">
        <table width="100%">
            <tr>
            <br> 
                <td height="35px" align="left" ><h1>Edition recette ' . $m . '</h1></td> 
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
   
<table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" >       
<tr  bgcolor="#CCCCCC" align="center">
<th width="'.$w.'%" align="center" $zz ><strong>N° Reg</strong></th> 
<th width="'.$w.'%" align="center" $zz ><strong>Date</strong></th>
<th width="'.$w.'%" align="center" $zz ><strong>Code Cli</strong></th>                      
<th width="25%" align="center" $zz ><strong>Nom prenom</strong></th>
<th width="'.$w.'%" align="center" $zz  ><strong>N° BORD</strong></th>'
        . '<th width="'.$w.'%" align="center" $zz ><strong>Espece</strong></th>';
$tbl.='<th width="'.$w.'%" align="center" $zz ><strong>Cheque</strong></th>
<th width="'.$w.'%" align="center" $zz ><strong>Effet</strong></th>
<th width="'.$w.'%" align="center" $zz ><strong>Retenue</strong></th>'
        . '<th width="'.$w.'%" align="center" $zz ><strong>Virement</strong></th>';
$tbl.='<th width="'.$w.'%" align="center" $zz ><strong>N° Cheque</strong></th>
<th width="'.$w.'%" align="center" $zz ><strong>Date ECH</strong></th>
<th width="10%" align="center" $zz ><strong>Factures</strong></th>';


$tbl.='</tr>';
$i = 0;
$totespece=0;$totcheque=0;$toteffet=0;$totretenue=0;$totvir=0;

$objbord = ClassRegistry::init('Lignebordereau');
$ccp = 0;
$nbpage=0;
//debug($tablignefactures);die;
//debug($bordereau);die;

foreach ($lignefactures as $br) {


//debug($br);die;

    $clt=ClassRegistry::init('Client')->find('first',array('conditions'=>array('Client.id'=>$br['Reglementclient']['client_id']),'recursive'=>-1));
    

    $numbord = 0;
    
        $bord = $objbord->find('first', array('conditions' => array('Lignebordereau.piecereglementclient_id' => $br['Piecereglementclient']['id']), 'contain' => ('Bordereau'), 'recursive' => 0));
        if ($bord != array()) {
            $numbord = $bord['Bordereau']['numero'];
        }
           
     //debug($bordereau);debug($numbord);
if ((($bordereau == 'AvecBordereau')&&(floatval($numbord)!=0)) || ($bordereau == 'Tous') || (($bordereau == 'SansBordereau')&&($numbord==0))) {
//debug('aa');die;
    $lignereg=ClassRegistry::init('Lignereglementclient')->find('all',array('conditions'=>array('Lignereglementclient.reglementclient_id'=>$br['Reglementclient']['id']),'contain'=>('Factureclient'),'recursive'=>0));

    $numreg='';
    foreach ($lignereg as $j=>$l){
        if($j!=0){
            $numreg.='<br>'.$l['Factureclient']['numero'];$i++;
        }
        else 
        {
            $numreg.=$l['Factureclient']['numero'];
        }
    }
    
        $total = $total + 0;
        $i++;
        if($nbpage==0){
            $a=37;
        }else{
            $a=40;
        }
        if ($i > $a) {
            $nbpage=1;
            $tbl .='</table>';
            $pdf->writeHTML($tbl, true, false, false, false, '');
            $pdf->AddPage('L');
            $i = 0;
            $tbl = '
                    <table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" >       
                   <tr  bgcolor="#CCCCCC" align="center">
                   <th width="'.$w.'%" align="center" $zz ><strong>N° Reg</strong></th> 
                    <th width="'.$w.'%" align="center" $zz ><strong>Date</strong></th>
                    <th width="'.$w.'%" align="center" $zz ><strong>Code Cli</strong></th>                      
                    <th width="25%" align="center" $zz ><strong>Nom prenom</strong></th>
                    <th width="'.$w.'%" align="center" $zz  ><strong>N° BORD</strong></th>';
            $tbl.='<th width="'.$w.'%" align="center" $zz ><strong>Espece</strong></th>
                <th width="'.$w.'%" align="center" $zz ><strong>Cheque</strong></th>
                    <th width="'.$w.'%" align="center" $zz ><strong>Effet</strong></th>
                    <th width="'.$w.'%" align="center" $zz ><strong>Retenue</strong></th>'
                    . '<th width="'.$w.'%" align="center" $zz ><strong>Virement</strong></th>';
            $tbl.='<th width="'.$w.'%" align="center" $zz ><strong>N° Cheque</strong></th>
                    <th width="'.$w.'%" align="center" $zz ><strong>Date ECH</strong></th>
                    <th width="10%" align="center" $zz ><strong>Factures</strong></th>';


            $tbl.='</tr>';
        }
        $mntespece='';$mntcheque='';$mnteffet='';$mntretenue='';$numcheque='';$mntvirement='';
        if($br['Piecereglementclient']['paiement_id']==1){ $mntespece=$br['Piecereglementclient']['montant'];$mntcheque='';$mnteffet='';$mntretenue='';$numcheque='';$mntvirement='';}
        if($br['Piecereglementclient']['paiement_id']==2){ $mntespece='';$mntcheque=$br['Piecereglementclient']['montant'];$mnteffet='';$mntretenue='';$numcheque=$br['Piecereglementclient']['num'];$mntvirement='';}
        if($br['Piecereglementclient']['paiement_id']==3){ $mntespece='';$mntcheque='';$mnteffet=$br['Piecereglementclient']['montant'];$mntretenue='';$numcheque='';$mntvirement='';}
        if($br['Piecereglementclient']['paiement_id']==5 || $br['Piecereglementclient']['paiement_id']==8){ $mntespece='';$mntcheque='';$mnteffet='';$mntretenue=$br['Piecereglementclient']['montant'];$numcheque='';$mntvirement='';}
        if($br['Piecereglementclient']['paiement_id']==4){ $mntespece='';$mntcheque='';$mnteffet='';$mntretenue='';$numcheque='';$mntvirement=$br['Piecereglementclient']['montant'];}
//debug($br);die;
$totespece=$totespece+$mntespece;
        $totcheque=$totcheque+$mntcheque;
        $toteffet=$toteffet+$mnteffet;
        $totretenue=$totretenue+$mntretenue;
        $totvir=$totvir+$mntvirement;
        $dateecheance='';
        if($br['Piecereglementclient']['echance']!=null && $br['Piecereglementclient']['echance']!='1970-01-01'){
        $dateecheance=date("d/m/Y", strtotime(str_replace('-', '/', $br['Piecereglementclient']['echance'])));
        }
        $tbl .=
                '<tr bgcolor="#FFFFFF" align="center">    
<th width="'.$w.'%" align="center" $zz >' . $br['Reglementclient']['numero'] . '</th> 
                    <th width="'.$w.'%" align="center" $zz >' . date("d/m/Y", strtotime(str_replace('-', '/', $br['Reglementclient']['Date']))) . '</th>
                    <th width="'.$w.'%" align="center" $zz >' . $clt['Client']['code'] . '</th>                      
                    <th width="25%" align="left" $zz >' . $clt['Client']['name'] . '</th>
                    <th width="'.$w.'%" align="center" $zz  >' . $numbord . '</th>';
        $tbl.='<th width="'.$w.'%" align="right" $zz >' . $mntespece . '</th>
                    <th width="'.$w.'%" align="right" $zz >' . $mntcheque . '</th>
                    <th width="'.$w.'%" align="right" $zz >' . $mnteffet . '</th>';
        $tbl.='<th width="'.$w.'%" align="right" $zz >' . $mntretenue . '</th>
            <th width="'.$w.'%" align="right" $zz >' . $mntvirement . '</th>
                    <th width="'.$w.'%" align="right" $zz >' . $numcheque . '</th>
                    <th width="'.$w.'%" align="center" $zz >' . $dateecheance . '</th>
                <th width="10%" align="center" $zz >' . $numreg . '</th>'
                . '</tr>';
        
        
    }
}

$tbl .= '
   <tr  bgcolor="#CCCCCC" align="center">    
       
        <td colspan="5" nobr="nobr" align="right"  $zz>Total</td>
        ';

$tbl .='<th width="'.$w.'%" align="right" $zz >' . sprintf("%.3f", $totespece) . '</th>
        <th width="'.$w.'%" align="right" $zz >' . sprintf("%.3f", $totcheque) . '</th>
            <th width="'.$w.'%" align="right" $zz >' . sprintf("%.3f", $toteffet) . '</th>
                <th width="'.$w.'%" align="right" $zz >' . sprintf("%.3f", $totretenue) . '</th>
                    <th width="'.$w.'%" align="right" $zz >' . sprintf("%.3f", $totvir) . '</th>
                        <th  bgcolor="#CCCCCC" width="'.$w.'%" align="right" $zz ></th>
                            <th  bgcolor="#CCCCCC" width="'.$w.'%" align="right" $zz ></th>
                                <th  bgcolor="#CCCCCC" width="10%" align="right" $zz ></th>
        </tr>
</table>';


$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('Listeeditionrecettes.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>