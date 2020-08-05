<?php
function chifre_en_lettre($montant, $devise1, $devise2) {
    if (($devise1 == 1))
        $dev1 = 'Dinars';
    if (($devise1 == 2))
        $dev1 = 'Dollars';
    if (($devise1 == 3))
        $dev1 = 'Euro';
    if (($devise1 == 1))
        $dev2 = 'Millimes';
    if (($devise1 == 2))
        $dev2 = 'Cents';
    if (($devise1 == 3))
        $dev2 = 'Centimes';
    $valeur_entiere = intval($montant);
    $valeur_decimal = (($montant - intval($montant)) * 1000);
    $dix_c = ($valeur_decimal % 100 / 10);
    $cent_c = intval($valeur_decimal % 1000 / 100);
    $unite_c = $valeur_decimal % 10;
    $unite[1] = $valeur_entiere % 10;
    $dix[1] = intval($valeur_entiere % 100 / 10);
    $cent[1] = intval($valeur_entiere % 1000 / 100);
    $unite[2] = intval($valeur_entiere % 10000 / 1000);
    $dix[2] = intval($valeur_entiere % 100000 / 10000);
    $cent[2] = intval($valeur_entiere % 1000000 / 100000);
    $unite[3] = intval($valeur_entiere % 10000000 / 1000000);
    $dix[3] = intval($valeur_entiere % 100000000 / 10000000);
    $cent[3] = intval($valeur_entiere % 1000000000 / 100000000);
    //echo $unite_c;
    $chif = array('', 'Un', 'Deux', 'Trois', 'Quatre', 'Cinq', 'Six', 'Sept', 'Huit', 'Neuf', 'Dix', 'Onze', 'Douze', 'Treize', 'Quatorze', 'Quinze', 'Seize', 'Dix-sept', 'Dix-huit', 'Dix-neuf');
    $secon_c = '';
    $trio_c = '';
    for ($i = 1; $i <= 3; $i++) {
        $prim[$i] = '';
        $secon[$i] = '';
        $trio[$i] = '';
        if ($dix[$i] == 0) {
            $secon[$i] = '';
            $prim[$i] = $chif[$unite[$i]];
        } else if ($dix[$i] == 1) {
            $secon[$i] = '';
            $prim[$i] = $chif[($unite[$i] + 10)];
        } else if ($dix[$i] == 2) {
            if ($unite[$i] == 1) {
                $secon[$i] = 'Vingt et';
                $prim[$i] = $chif[$unite[$i]];
            } else {
                $secon[$i] = 'Vingt';
                $prim[$i] = $chif[$unite[$i]];
            }
        } else if ($dix[$i] == 3) {
            if ($unite[$i] == 1) {
                $secon[$i] = 'Trente et';
                $prim[$i] = $chif[$unite[$i]];
            } else {
                $secon[$i] = 'Trente';
                $prim[$i] = $chif[$unite[$i]];
            }
        } else if ($dix[$i] == 4) {
            if ($unite[$i] == 1) {
                $secon[$i] = 'Quarante et';
                $prim[$i] = $chif[$unite[$i]];
            } else {
                $secon[$i] = 'Quarante';
                $prim[$i] = $chif[$unite[$i]];
            }
        } else if ($dix[$i] == 5) {
            if ($unite[$i] == 1) {
                $secon[$i] = 'Cinquante et';
                $prim[$i] = $chif[$unite[$i]];
            } else {
                $secon[$i] = 'Cinquante';
                $prim[$i] = $chif[$unite[$i]];
            }
        } else if ($dix[$i] == 6) {
            if ($unite[$i] == 1) {
                $secon[$i] = 'Soixante et';
                $prim[$i] = $chif[$unite[$i]];
            } else {
                $secon[$i] = 'Soixante';
                $prim[$i] = $chif[$unite[$i]];
            }
        } else if ($dix[$i] == 7) {
            if ($unite[$i] == 1) {
                $secon[$i] = 'Soixante et';
                $prim[$i] = $chif[$unite[$i] + 10];
            } else {
                $secon[$i] = 'Soixante';
                $prim[$i] = $chif[$unite[$i] + 10];
            }
        } else if ($dix[$i] == 8) {
            if ($unite[$i] == 1) {
                $secon[$i] = 'Quatre-vingts et';
                $prim[$i] = $chif[$unite[$i]];
            } else {
                $secon[$i] = 'Quatre-vingts';
                $prim[$i] = $chif[$unite[$i]];
            }
        } else if ($dix[$i] == 9) {
            if ($unite[$i] == 1) {
                $secon[$i] = 'Quatre-vingts et';
                $prim[$i] = $chif[$unite[$i] + 10];
            } else {
                $secon[$i] = 'Quatre-vingts';
                $prim[$i] = $chif[$unite[$i] + 10];
            }
        }
        if ($cent[$i] == 1)
            $trio[$i] = 'Cent';
        else if ($cent[$i] != 0 || $cent[$i] != '')
            $trio[$i] = $chif[$cent[$i]] . ' Cents';
    }
    $v = "";

    $chif2 = array('', 'Dix', 'Vingt', 'Trente', 'Quarante', 'Cinquante', 'Soixante', 'Soixante-dix', 'Quatre-vingts', 'Quatre-vingt-dix');
    $secon_c = $chif2[$dix_c];
    if ($cent_c == 1)
        $trio_c = 'Cent';
    else if ($cent_c != 0 || $cent_c != '')
        $trio_c = $chif[$cent_c] . ' Cents';

    if (($cent[3] == 0 || $cent[3] == '') && ($dix[3] == 0 || $dix[3] == '') && ($unite[3] == 1))
        $v = $v . ' ' . $trio[3] . '  ' . $secon[3] . ' ' . $prim[3] . ' Million ';
    else if (($cent[3] != 0 && $cent[3] != '') || ($dix[3] != 0 && $dix[3] != '') || ($unite[3] != 0 && $unite[3] != ''))
        $$v = $v . ' ' . $trio[3] . ' ' . $secon[3] . ' ' . $prim[3] . ' Millions ';
    else
        $v = $v . ' ' . $trio[3] . ' ' . $secon[3] . ' ' . $prim[3];

    if (($cent[2] == 0 || $cent[2] == '') && ($dix[2] == 0 || $dix[2] == '') && ($unite[2] == 1))
        $v = $v . ' ' . ' Mille ';
    else if (($cent[2] != 0 && $cent[2] != '') || ($dix[2] != 0 && $dix[2] != '') || ($unite[2] != 0 && $unite[2] != ''))
        $v = $v . ' ' . $trio[2] . ' ' . $secon[2] . ' ' . $prim[2] . ' Milles ';
    else
        $v = $v . ' ' . $trio[2] . ' ' . $secon[2] . ' ' . $prim[2];

    $v = $v . $trio[1] . ' ' . $secon[1] . ' ' . $prim[1];

    $v = $v . ' ' . $dev1 . ' ';

    if (($cent_c == '0' || $cent_c == '') && ($dix_c == '0' || $dix_c == ''))
        $v = $v . ' ' . ' et z&eacute;ro ' . $dev2;
    else
        $v = $v . ' et ' . round($valeur_decimal, 0) . ' ' . $dev2;
    return $v;
}

$lborder = 'border="0"';
ob_start();
//$ModelSociete = ClassRegistry::init('Societe');
//$soc = $ModelSociete->find('first',array('conditions'=>array('Societe.id'=>1),'recursive'=>-1));
?>

<style>
.classtable {
  border-collapse: collapse;
}

.classtable td {
  border: 2px solid black;
}
</style>
<style type="text/css">

    .div1 { color: #000000; width: 90mm; margin: 1mm; border: solid 1px black; border-radius: 3mm;font-size: 3.3mm;padding:3mm; -moz-border-radius: 1mm; vertical-align: middle }
</style>
<?php
$styl_cadr='border-left:1px solid black;border-right:1px solid black;';
$styl_cadr_bottom = 'border-left:1px solid black;border-right:1px solid black;border-bottom: none;';
$styl_cadr_hauteur = 'style="border-bottom: 1px solid black;border-left:1px solid black;border-right:1px solid black;border-top: none;"';
$styl_cadr_fin = 'style="border-bottom:1px solid black;border-right:1px solid black;border-left:1px solid black;"';
$ModelSociete = ClassRegistry::init('Pointdevente');
$pontdevente = $ModelSociete->find('first', array('conditions' => array('Pointdevente.id' => $factureclient[$model]['pointdevente_id'])));
$ModelSociete = ClassRegistry::init('Societe');
$soc = $ModelSociete->find('first', array('conditions' => array('Societe.id' => $pontdevente['Pointdevente']['societe_id'])));
$ModelSociete = ClassRegistry::init('Zone');
$zone = $ModelSociete->find('first',array('conditions'=>array('Zone.id'=>$factureclient['Client']['zone_id'])));
?>
<page backtop="60mm" backbottom="10mm" footer="page">
    <page_header style="margin-top: 0mm " >
        <table style="width: 100%;"  border="0">
            <tr><td  style="width: 50%;" align="center">
                    <IMG SRC="../webroot/img/<?php echo @$soc["Societe"]["logo"];?>" style="width: 250px; " >
                </td>
                <td style="width: 60%;" align="left" >
                    <table>
                        <tr>
                            <td align="left" width="70%" style="font-size:3mm;">
                                <strong><?php //echo @$soc['Societe']['activite'] ;?></strong><br>
								<strong style="font-size:3mm;"><?php echo strtoupper(@$soc['Societe']['nom'] );?></strong> <br>
								<strong>Siege :  </strong> <?php echo @$soc['Societe']['adresse'] ;?><br>
                                <strong>Tél : </strong><?php echo @$soc['Societe']['tel'] ;?><strong>       Fax:</strong><?php echo @$soc['Societe']['fax'] ;?><br>
								<strong>Showroom : </strong><?php echo @$pontdevente['Pointdevente']['adresse'] ;?><br>
 								<strong>Tél : </strong><?php  echo @$pontdevente['Pointdevente']['tel'] ; ?><br>
 							<strong>E-Mail : </strong><?php echo @$soc['Societe']['mail'];?><br>
                                <strong>Site Web : </strong><?php echo @$soc['Societe']['site'] ;?><br>

<!--  <strong>M.F : </strong><?php echo @$soc['Societe']['codetva'] ;?><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RC : </strong><?php echo $soc['Societe']['rc'] ;?><br>
                                <strong>RIB : </strong><?php echo @$soc['Societe']['rib'] ;?>--><br>
                            </td>
                        </tr>
                    </table>
                </td>


            </tr>
        </table>
        <table style="width: 100%;" border="0">
            <tr >
                <td style="width: 40%;">
                    <table style="width: 100%; " border="0" align="center">
                        <tr >
                            <td style="width: 100%;  " align="center"  >
                                <strong style="font-size:4mm;"><?php echo $designation; ?> N°:<?php echo @$factureclient[$model]['numero']; ?></strong><br><br>
                                <strong style="font-size:3mm;">Date  :<?php echo date("d/m/Y", strtotime(str_replace('-', '/', @$factureclient[$model]['date']))); ?> </strong> <br>
                                <?php if($model=="Bonlivraison"){ ?>
                                <?php if($factureclient[$model]['numbc']!=" "){ ?>
                                <strong style="font-size:3mm;">Numero BC  :<?php echo @$factureclient[$model]['numbc']; ?> </strong> <br>
                                <?php }?>
                                <?php }?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 2%;"></td>
                <td  style="width: 58%;" >
                    <table style="width: 100%;" border="0" align="center">
                        <tr>
                            <td style="font-size:3mm;width: 100%;border: 3px solid black;height:80px; border-radius: 3mm;-moz-border-radius: 1mm;" align="left">
                               &nbsp; Code&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong style="font-size:3mm;"><?php echo @$factureclient['Client']['code']; ?></strong><br>
                                <?php if($model!="Factureavoir"){ ?>
                              &nbsp;  Client&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong style="font-size:3mm;"><?php echo @$factureclient[$model]['name']; ?></strong><br>
                                <?php }else{ ?>
                               &nbsp; Client&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong style="font-size:3mm;"><?php echo @$factureclient['Client']['name']; ?></strong><br>
                                <?php }?>&nbsp;
                                Matricule Fiscale&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;<strong style="font-size:3mm;"><?php echo @$factureclient['Client']['matriculefiscale']; ?> </strong><br>
                               &nbsp; Adresse&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;<strong style="font-size:3mm;"><?php echo @$factureclient['Client']['adresse']; ?> </strong><br>
                             <!--  &nbsp; Ville&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong style="font-size:3mm;"><?php echo @$zone['Zone']['name']; ?></strong><br>-->&nbsp; Tél&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong style="font-size:3mm;"><?php echo @$factureclient['Client']['tel']; ?></strong><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
    </page_header>
        <table cellspacing="0"  style="width: 100%;font-size: 3mm;border: 1px solid black; border-radius: 3mm;-moz-border-radius: 1mm;">
        <tr>
            <td align="center" style="width: 14%;border: 1px solid black;background-color:#b8b8b8; border-radius: 3mm 0mm 0mm 0mm;-moz-border-radius: 1mm;" ><strong>code</strong></td>
            <td align="center" style="width: 36%;border: 1px solid black;background-color:#b8b8b8;" ><strong>Désignation des Articles</strong></td>
            <td align="center" style="width: 7%;border: 1px solid black;background-color:#b8b8b8;" ><strong>Qte</strong></td>
            <td align="center" style="width: 6%;border: 1px solid black;background-color:#b8b8b8;" ><strong>TVA</strong></td>
            <td align="center" style="width: 10%;border: 1px solid black;background-color:#b8b8b8;" ><strong>P.U.HT</strong></td>
            <td align="center" style="width: 7%;border: 1px solid black;background-color:#b8b8b8;" ><strong>REM</strong></td>
            <td align="center" style="width: 10%;border: 1px solid black;background-color:#b8b8b8;" ><strong>TOTAL HT</strong></td>
            <td align="center" style="width: 10%;border: 1px solid black;background-color:#b8b8b8; border-radius: 0mm 3mm 0mm 0mm;-moz-border-radius: 1mm;" ><strong>P.U.TTC</strong></td>
        </tr>
        <?php
//debug($lignefactureclients);die;
        $long = 137;
        $compteur = 0;
        $compteurnbligne = 0;
        $bl = 0;
        $nbligne=count($lignefactureclients);
        foreach ($lignefactureclients as $i => $lr) {


            if($model=="Factureclient"){
            if ($lr['Lignefactureclient']['bonlivraison_id'] != $bl) {
                if($i!=0){
                if($compteur==0){
                ?>
                <tr>
                <td align="center" style="width: 14%;border: 1px solid black;background-color:#b8b8b8; border-radius: 3mm 0mm 0mm 0mm;-moz-border-radius: 1mm;" ><strong>code</strong></td>
                <td align="center" style="width: 36%;border: 1px solid black;background-color:#b8b8b8;" ><strong>Désignation des Articles</strong></td>
                <td align="center" style="width: 7%;border: 1px solid black;background-color:#b8b8b8;" ><strong>Qte</strong></td>
                <td align="center" style="width: 6%;border: 1px solid black;background-color:#b8b8b8;" ><strong>TVA</strong></td>
                <td align="center" style="width: 10%;border: 1px solid black;background-color:#b8b8b8;" ><strong>P.U.HT</strong></td>
                <td align="center" style="width: 7%;border: 1px solid black;background-color:#b8b8b8;" ><strong>REM</strong></td>
                <td align="center" style="width: 10%;border: 1px solid black;background-color:#b8b8b8;" ><strong>TOTAL HT</strong></td>
                <td align="center" style="width: 10%;border: 1px solid black;background-color:#b8b8b8; border-radius: 0mm 3mm 0mm 0mm;-moz-border-radius: 1mm;" ><strong>P.U.TTC</strong></td>
                </tr>
                <?php
                }
            }
                $long=$long-4;
                $compteur++;
                ?>
                <tr>
                    <td style="width: 14%;height: 4mm;<?php echo $styl_cadr; ?>"></td>
                    <td style="width: 36%;<?php echo $styl_cadr; ?>"><strong><?php echo $lr['Bonlivraison']['numero']; ?></strong></td>
                    <td style="width: 7%;<?php echo $styl_cadr; ?>" align="center"></td>
                    <td style="width: 6%;<?php echo $styl_cadr; ?>" align="right"></td>
                    <td style="width: 10%;<?php echo $styl_cadr; ?>" align="center"></td>
                    <td style="width: 7%;<?php echo $styl_cadr; ?>" align="center"></td>
                    <td style="width: 10%;<?php echo $styl_cadr; ?>" align="right"></td>
                    <td style="width: 10%;<?php echo $styl_cadr; ?>" align="right"></td>
                </tr>
                <?php
                if($compteur>=41){
                 $long=164;
                 $compteur=0;
                }
            }
            }
            if($i!=0){
                if($compteur==0){
                ?>
                <tr>
                <td align="center" style="width: 14%;border: 1px solid black;background-color:#b8b8b8; border-radius: 3mm 0mm 0mm 0mm;-moz-border-radius: 1mm;" ><strong>code</strong></td>
                <td align="center" style="width: 36%;border: 1px solid black;background-color:#b8b8b8;" ><strong>Article</strong></td>
                <td align="center" style="width: 7%;border: 1px solid black;background-color:#b8b8b8;" ><strong>Qte</strong></td>
                <td align="center" style="width: 6%;border: 1px solid black;background-color:#b8b8b8;" ><strong>TVA</strong></td>
                <td align="center" style="width: 10%;border: 1px solid black;background-color:#b8b8b8;" ><strong>P.U.HT</strong></td>
                <td align="center" style="width: 7%;border: 1px solid black;background-color:#b8b8b8;" ><strong>REM</strong></td>
                <td align="center" style="width: 10%;border: 1px solid black;background-color:#b8b8b8;" ><strong>TOTAL HT</strong></td>
                <td align="center" style="width: 10%;border: 1px solid black;background-color:#b8b8b8; border-radius: 0mm 3mm 0mm 0mm;-moz-border-radius: 1mm;" ><strong>P.U.TTC</strong></td>
                </tr>
                <?php
                }
            }

            if($model=="Factureclient"){
            $bl = $lr['Lignefactureclient']['bonlivraison_id'];
            }
            $compteur++;
            $compteurnbligne++;
             $long=$long-4;
            ?>
            <tr>
                <td style="width: 14%;height: 4mm;<?php echo $styl_cadr_bottom; ?>" align="left"><?php echo substr(@$lr['Article']['code'], 0, 15) ?></td>
                <td style="width: 36%;<?php echo $styl_cadr_bottom; ?>" align="left"><?php echo substr(@$lr[$ligne_model]['designation'], 0, 35) ?></td>
                <td style="width: 7%;<?php echo $styl_cadr_bottom; ?>" align="center"><?php echo @$lr[$ligne_model]['quantite'] ?></td>
                <td style="width: 6%;<?php echo $styl_cadr_bottom; ?>" align="center"><?php echo @$lr[$ligne_model]['tva'] ?>&nbsp;</td>
                <td style="width: 10%;<?php echo $styl_cadr_bottom; ?>" align="right"><?php echo number_format(@$lr[$ligne_model]['prix'], 3, '.', ' '); ?></td>
                <td style="width: 7%;<?php echo $styl_cadr_bottom; ?>" align="center"><?php echo number_format(@$lr[$ligne_model]['remise'], 2, '.', ' ') ?></td>
                <td style="width: 10%;<?php echo $styl_cadr_bottom; ?>" align="right"><?php echo number_format(@$lr[$ligne_model]['totalht'], 3, '.', ' ') ?></td>
                <td style="width: 10%;<?php echo $styl_cadr_bottom; ?>" align="right"><?php echo number_format(@$lr[$ligne_model]['puttc'], 3, '.', ' ') ?></td>

            </tr>
        <?php



                if($compteur>=41){
                 $long=164;
                 $compteur=0;
                }
                if($nbligne==$compteurnbligne){
                if($long==164){
                    $long=0;
                }
                if($long>135){
                    $long=135-(4*$compteur);
                }else{
                   $long=$long-40;
                }
                }



            } ?>

            <tr>
                <td  style="width: 14%;<?php echo $styl_cadr_bottom; ?>;height: <?php echo @$long; ?>mm; border-radius: 0mm 0mm 0mm 3mm;-moz-border-radius: 1mm;"></td>
                <td  style="width: 36%;<?php echo $styl_cadr_bottom; ?>"></td>
                <td  style="width: 7%;<?php echo $styl_cadr_bottom; ?>"></td>
                <td  style="width: 6%;<?php echo $styl_cadr_bottom; ?>"></td>
                <td  style="width: 10%;<?php echo $styl_cadr_bottom; ?>"></td>
                <td  style="width: 7%;<?php echo $styl_cadr_bottom; ?>"></td>
                <td  style="width: 10%;<?php echo $styl_cadr_bottom; ?>"></td>
                <td  style="width: 10%;<?php echo $styl_cadr_bottom; ?>;border-radius: 0mm 0mm 3mm 0mm;-moz-border-radius: 1mm;"></td>
            </tr>
    </table>
    <?php
        if($factureclient[$model]['typeclient_id']==2){
        $exono = ClassRegistry::init('Exonorationclient')->find('first', array('conditions' => (array(
        'Exonorationclient.client_id' => @$factureclient['Client']['id'],
        'Exonorationclient.datedu <= ' => $factureclient[$model]['date'],
        'Exonorationclient.dateau >= ' => $factureclient[$model]['date'])),
        'recursive' => -1));
        }
        ?>
    <br>
    <table nobr="true"  style="width: 100%;">
        <tr>
            <td style="width:40%;vertical-align: top;">
                <table   style="width:100%;" class="classtable">
                    <tr>
                        <td align="center" style="width:40%; border-radius: 3mm 0mm 0mm 0mm;-moz-border-radius: 1mm;"><strong>Base</strong></td>
                        <td align="center" style="width:20%;"><strong>TVA</strong></td>
                        <td align="center" style="width:40%; border-radius: 0mm 3mm 0mm 0mm;-moz-border-radius: 1mm;"><strong>Montant</strong></td>
                    </tr>
                    <?php
                    $obj = ClassRegistry::init($ligne_model);
                    $lignefactureclientstva = $obj->find('all', array('fields' => array(
                            'SUM((' . $ligne_model . '.totalht*' . $ligne_model . '.tva)/100)  mtva'
                            ,'SUM(' . $ligne_model . '.totalht) totalht'
                            ,'AVG(' . $ligne_model . '.tva) tva')
							, 'conditions' => array($ligne_model . '.' . $attribut => $factureclient[$model]['id'])
					        , 'group' => array($ligne_model . '.tva')
                    ));
                    $tva = 0;$tot_tva=0;
                    foreach ($lignefactureclientstva as $i => $lr) {
                        if (!empty($lr[0]['mtva'])) {
                         $tot_tva=$tot_tva+$lr[0]['mtva'];
                         ?>
                            <tr>
                                <td align="center" >&nbsp;<?php echo number_format($lr[0]['totalht'],3, '.', ' ');?> </td>
                                <td align="center" >&nbsp;<?php echo sprintf('%.0f',$lr[0]['tva']);?> %</td>
                                <td align="center" >&nbsp;<?php echo number_format($lr[0]['mtva'],3, '.', ' ');?></td>
                            </tr>
                    <?php }} ?>
                            <tr>
                                <td align="center" colspan="2" style="border-radius: 0mm 0mm 0mm 3mm;-moz-border-radius: 1mm;">Total</td>
                                <td align="center" style="border-radius: 0mm 0mm 3mm 0mm;-moz-border-radius: 1mm;">&nbsp;<?php echo number_format($tot_tva,3, '.', ' ');?></td>
                            </tr>
                </table>
				<br>
				<?php if($model=="Factureclient"){?>
				<table  style="width:65%;" class="classtable">
					<tr>
						<td align="center" style="width:50%; border-radius: 3mm 0mm 0mm 0mm;-moz-border-radius: 1mm;"><strong>Mode de P</strong></td>
						<td align="center" style="width:40%;"><strong>Montant</strong></td>
						<td align="center" style="width:20%;"><strong>N°</strong></td>
						<td align="center" style="width:40%;"><strong>Echéance</strong></td>
						<td align="center" style="width:30%;border-radius: 0mm 3mm 0mm 0mm;-moz-border-radius: 1mm;"><strong>Banque</strong></td>
					</tr>
					<tr>
						<td align="center" style="width:50%;height:10mm;vertical-align: top;" >&nbsp;</td>
						<td align="center" style="width:40%;height:10mm;vertical-align: top;" >&nbsp;</td>
						<td align="center" style="width:20%;height:10mm;vertical-align: top;" >&nbsp;</td>
						<td align="center" style="width:40%;height:10mm;vertical-align: top;" >&nbsp;</td>
						<td align="center" style="width:30%;height:10mm;vertical-align: top;" >&nbsp;</td>
					</tr>
				</table>
				<?php }?>
            </td>
            <td style="width:10%;"></td>


            <td style="width:36%;">
                <table  style="width: 100%;" class="classtable">
                    <tr>
                        <td align="left" style="width:50%;border-radius: 3mm 0mm 0mm 0mm;-moz-border-radius: 1mm;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total HT  </strong></td>
                        <td align="right"  style="width:50%;border-radius: 0mm 3mm 0mm 0mm;-moz-border-radius: 1mm;"><?php echo number_format($factureclient[$model]['totalht'] + $factureclient[$model]['remise'], 3, '.', ' ');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" style="width:50%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total remise  </strong></td>
                        <td align="right" style="width:50%;"><?php echo number_format($factureclient[$model]['remise'], 3, '.', ' ');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" style="width:50%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total NET  </strong></td>
                        <td align="right"  style="width:50%;"><?php echo number_format($factureclient[$model]['totalht'], 3, '.', ' ');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" style="width:50%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Montant TVA  </strong></td>
                        <td align="right" style="width:50%;"><?php echo number_format($factureclient[$model]['tva'], 3, '.', ' ');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" style="width:50%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total TTC  </strong></td>
                        <td align="right"  style="width:50%;"><?php echo number_format($factureclient[$model]['totalttc']-$factureclient[$model]['timbre_id'], 3, '.', ' ');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" style="width:50%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Timbre  </strong></td>
                        <td align="right"  style="width:50%;"><?php echo number_format($factureclient[$model]['timbre_id'], 3, '.', ' ');?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="left" style="width:50%;border-radius: 0mm 0mm 0mm 3mm;-moz-border-radius: 1mm;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Net à payer  </strong></td>
                        <td align="right"  style="width:50%;border-radius: 0mm 0mm 3mm 0mm;-moz-border-radius: 1mm;"><strong><?php echo number_format($factureclient[$model]['totalttc'], 3, '.', ' ');?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>

                </table>

            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
        </tr>
        <tr>
        <td colspan="3">
        <table  style="width: 100%;" class="classtable">
        <tr>
        <td  style="width:20%;height:20mm;vertical-align: top;border-radius: 3mm 0mm 0mm 3mm;-moz-border-radius: 1mm;" align="center" >
            <strong>Reçu Conforme Client</strong>
        </td>
        <td   style="width:60%;height:20mm;vertical-align: top;" align="center" >
            <strong>Arrêté la présente <?php echo $designation; ?> à la somme de :</strong><br>
            <?php echo chifre_en_lettre($factureclient[$model]['totalttc'],1,1);?><br><br>
                   Tout litige relatif à la vente est soumis au tribunale de commerce de Tunis.
            <?php if($factureclient[$model]['typeclient_id']==2){
                 if(!empty($exono)){
                    ?>
                <strong style="font-size:4mm;">N° Exo : <?php echo $exono['Exonorationclient']['num_exe'] ?>
                Du : <?php echo date("d/m/Y", strtotime(str_replace('-', '/',  $exono['Exonorationclient']['datedu']))) ?>
                Au : <?php echo date("d/m/Y", strtotime(str_replace('-', '/',  $exono['Exonorationclient']['dateau']))) ?>
                </strong>
                <?php }} ?>


        </td>
        <td  style="width:20%;height:20mm;vertical-align: top;border-radius: 0mm 3mm 3mm 0mm;-moz-border-radius: 1mm;" align="center" >
            <strong>Signature et cachet</strong>
        </td>
        </tr>
        </table>
        </td>
        </tr>
		<br><br>
      
    </table>
</page>

<page_footer >
<table>
 <tr>
            <td style="height: 5mm;font-size: 3mm;" colspan="3">
            SARL au Capital de :  <?php echo $soc['Societe']['capital'] ;?>  R.C: <?php echo $soc['Societe']['rc'] ;?> Code T.V.A: <?php echo $soc['Societe']['codetva'] ;?> Code BTS : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    RIB: <?php echo $soc['Societe']['rib']; ?> 
           
            
            </td>
        </tr>
        </table>
</page_footer>

<?php
$content = ob_get_clean();
APP::import("Vendor", "html2pdf/html2pdf");
try {
    $html2pdf = new HTML2PDF('P', 'A4', 'fr');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->Output('FC_matricielle.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>
