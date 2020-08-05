<?php
$soc = ClassRegistry::init('Societe')->find('first', array('conditions' => array('Societe.mere' => 1)));
if ($date1 != "__/__/____" && $date1 != "1970-01-01" && $date2 != "__/__/____" && $date2 != "1970-01-01") {
    $date1 = date('d/m/Y', strtotime(str_replace('-', '/', $date1)));
    $date2 = date('d/m/Y', strtotime(str_replace('-', '/', $date2)));
    $m = ' du  ' . $date1 . ' au  ' . $date2;
}
$lborder = 'border="0"';
$w =0;
if(count($tvas)!=0){
$w = 34 / (count($tvas) * 2);
}
ob_start();
?>
<table align="center" cellpadding="0" cellspacing="0"  style=" width: 100%; font-size: 3mm;" border="1">       
    <tr align="center" >
        <td bgcolor="#CCCCCC" width="8%" align="center"  ><strong>N° Fact</strong></td> 

        <td bgcolor="#CCCCCC" width="5%" align="center"  ><strong>Date</strong></td>
        <td bgcolor="#CCCCCC" width="23%" align="center"  height="30px" ><strong>Nom_Prenom</strong></td>
        <td bgcolor="#CCCCCC" width="5%" align="center"  ><strong>Code Cli</strong></td>  
        <td bgcolor="#CCCCCC" width="5%" align="center"  ><strong>V Exo</strong></td> 
        <td bgcolor="#CCCCCC" width="5%" align="center"  ><strong>Base 0%</strong></td> 
        <?php foreach ($tvas as $t) { //debug($t);die; ?>
            <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Base <?php echo intval(floatval($t['Tva']['name'])); ?>%</strong></td> 
            <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>TVA <?php echo intval(floatval($t['Tva']['name'])); ?>%</strong></td>
        <?php } ?>


        <td bgcolor="#CCCCCC" width="5%" align="center"  ><strong>Timbre</strong></td>
        <td bgcolor="#CCCCCC" width="10%" align="center"  ><strong>Net a payer</strong></td>
        <td bgcolor="#CCCCCC" width="10%" align="center"  ><strong>ht</strong></td>
    </tr>

    <?php 
    $totnetapayer = 0;
    $tottimbre = 0;
    $totfactzero = 0;
    $totexo = 0;
    foreach ($tablignefactures as $br) {
        $totnetapayer = $totnetapayer + $br['totalttc'];
        $tottimbre = $tottimbre + $br['timbre'];
        ?>
        <tr bgcolor="#FFFFFF" align="center">    

            <td width="8%" align="center"  ><?php echo $br['numero']; ?></td>    

            <td width="5%" align="center"  ><?php echo date("Y-m-d", strtotime(str_replace('/', '-', $br['date']))); ?></td>
            <td width="23%" align="left"   ><?php echo $br['client']; ?></td>
            <td width="5%" align="center"  ><?php echo $br['code']; ?></td>
            <td width="5%" align="right"  ><?php echo $br['venteexo']; ?></td>
            <td width="5%" align="right"  ><?php echo $br['ventesup']; ?></td>
            <?php
            $totfactzero = floatval($totfactzero) + floatval($br['ventesup']);
            $totexo = floatval($totexo) + floatval($br['venteexo']);
            foreach ($tvas as $v) { //debug($v); 
                $tv = intval(floatval($v['Tva']['name']));
                $base = 'base' . $tv;
                $tva = 'tva' . $tv;
                $b = $br[$base];
                $tvav = $br[$tva];
                if (floatval($br[$base]) == 0) {
                    $b = '';
                }
                if (floatval($br[$tva]) == 0) {
                    $tvav = '';
                }
                ?>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $b; ?></td> 
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $tvav; ?></td>
            <?php } ?>


            <td width="5%" align="right"  ><?php echo $br['timbre']; ?></td>
            <td width="10%" align="right"  ><?php echo $br['totalttc']; ?></td>
            <td width="10%" align="right"  ><?php echo $br['totalht']; ?></td>
        </tr>
    <?php } ?>
        
        <?php
    $tf = array(); //debug($listvaall);die;
    foreach ($listvaall as $l) {
        if (!isset($tf[$l['tva']]['montant'])) {
            $tf[$l['tva']]['montant'] = 0;
        }
        if (!isset($tf[$l['tva']]['base'])) {
            $tf[$l['tva']]['base'] = 0;
        }

        $tf[$l['tva']]['montant'] = $tf[$l['tva']]['montant'] + $l['mtva'];
        $tf[$l['tva']]['base'] = $tf[$l['tva']]['base'] + $l['base'];
        $tf[$l['tva']]['nom'] = $l['nom'];
    }
  
    ?>

    <tr align="center">    

        <td bgcolor="#CCCCCC" width="41%" colspan="4" nobr="nobr" align="right"  >Total</td>
        <th bgcolor="#CCCCCC" width="5%" align="right"  ><?php echo sprintf("%.3f", $totexo); ?></th>
        <td bgcolor="#CCCCCC" width="5%" align="right"  ><?php echo sprintf("%.3f", $totfactzero); ?></td>
        <?php
        foreach ($tf as $y) {  ?>
            <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $y['base']); ?></td> 
            <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $y['montant']); ?></td>
<?php } ?>
        <td bgcolor="#CCCCCC" width="5%" align="right"  ><?php echo sprintf("%.3f", $tottimbre); ?></td>
        <td bgcolor="#CCCCCC" width="10%" align="right"  ><?php echo sprintf("%.3f", $totnetapayer); ?></td>
    </tr>

    

</table>
<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
header("Content-type: application/vnd.ms-excel");
//header("Content-Type: application/force-download");
//header("Content-Type: application/download");
header("Content-Disposition: attachment; filename=Listefacturetout.xls");
?>