
<?php

App::import('Vendor', 'xtcpdf');
$pdf = new XTCPDF();
/////////////////////////
// set document information
//debug($lignes);die;
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ranim');
$pdf->SetTitle('Liste des Tickets');

// set default header data
//$date1 = explode('-', $date);
//$new_date = $date1[2] . '/' . $date1[1] . '/' . $date1[0];
$chr=' ';
if((!empty($debut))&& (!empty($fin))){
    $chr='  du '.$debut.'  au '.$fin;
}
$ent='logoimp.png'; 
$pdf->SetHeaderData($ent,40, '                         Liste des Tickets  '.$chr);
//$pdf->SetHeaderData('entete.jpg', 60);
//$footer = 'Société ' . $soc['Societe']['Nom'] . ' SARL au capital de ' . $soc['Societe']['Capital'] . ' DTN,' . $soc['Societe']['Adresse'] . $point . ' Tél: ' . $soc['Societe']['Tel'];
//$footer1 = 'Fax: ' . $soc['Societe']['Fax'] . ' E-mail: ' . $soc['Societe']['Mail'] . ' ' . $soc['Societe']['Site'] . 'R.C: ' . $soc['Societe']['RC'] . '-Code T.V.A: ' . $soc['Societe']['Code_TVA'];
$footer = '            SARL au Capital de:   ' . $soc['Societe']['Capital'] . '           R.C: ' . $soc['Societe']['RC'] . '           Code T.V.A: ' . $soc['Societe']['Code_TVA'] . '           Zitouna  RIB: ' . $soc['Societe']['RIB'];

$aaa = "abc";
$pdf->xfootertext = $footer;
$pdf->xfootertext1 = $footer1;
$pdf->xfootertext2 = $footer2;

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
// set font
$pdf->SetFont('times', 'B', 16);

// add a page
$pdf->AddPage();

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('times', 'A', 10);

// -----------------------------------------------------------------------------
$tbl = <<<EOF

<table border="2" align="center" cellpadding="2" cellspacing="0"  width="100%"  nobr="true">
<thead>
    <tr bgcolor="#FFFFFF" align="center">
        <th width="10%" align="center"><strong>Numéro</strong></th>
        <th width="45%" align="center"><strong>Client</strong></th>
        <th width="15%" align="center"><strong>Date</strong></th>
        <th width="20%" align="center"><strong>Depot</strong></th>
        <th width="10%" align="center"><strong>Montant</strong></th>
    </tr>
    </thead>
EOF;
//debug($ticketcaisses);die;
foreach ($ticketcaisses as $k=>$ligne) {
    //debug($ligne);die;
        $num = $ligne['Ticketcaiss']['Numero'];
        $client = $ligne['Client']['Raison_Social'];
        $date = $ligne['Ticketcaiss']['Date'];
        $depot = $ligne['Depot']['Nom'];
        $mnt = $ligne['Ticketcaiss']['Total_TTC'];
        
        $date1 = explode('-', $date);
        $new_dated = $date1[2] . '/' . $date1[1] . '/' . $date1[0];
        $tbl = $tbl . <<<EOF


    <tr bgcolor="#FFFFFF" align="center">
        <th width="10%" align="center">$num</th>
        <th width="45%" align="left">$client</th>
        <th width="15%" align="center">$new_dated</th>
        <th width="20%" align="center">$depot</th>
        <th width="10%" align="right">$mnt</th>
        </tr>
EOF;
    
}
$tbl = $tbl . <<<EOF

        </table>
EOF;

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$pdf->Output('list_ticket.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>