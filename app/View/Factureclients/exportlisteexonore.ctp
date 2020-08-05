<script language="JavaScript" type="text/JavaScript">
    function flvFPW1(){
    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;
    } 
</script>
<?php
$w = 0;
if (count($tvas)) {
    $w = 33 / (count($tvas) * 2);
}
?>

<table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" nobr="true">       
    <tr align="center">
        <td bgcolor="#CCCCCC" width="3%" align="center"  ><strong>N&#176;</strong></td>
        <td bgcolor="#CCCCCC" width="5%" align="center"  ><strong>Date</strong></td>
        <td bgcolor="#CCCCCC" width="7%" align="center"  ><strong>N&#176; Fact</strong></td>                        
        <td bgcolor="#CCCCCC" width="10%" align="center"  ><strong>Matricule_Fiscal</strong></td>
        <td bgcolor="#CCCCCC" width="22%" align="center"   ><strong>Nom/Raison</strong></td>
        <td bgcolor="#CCCCCC" width="8%" align="center"  ><strong>Exonoration</strong></td>
        <td bgcolor="#CCCCCC" width="5%" align="center"  ><strong>Montant HT</strong></td>
        <?php foreach ($tvas as $t) { //debug($t);die; ?>
            <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Base <?php echo intval(floatval($t['Tva']['name'])); ?>%</strong></td> 
            <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>TVA <?php echo intval(floatval($t['Tva']['name'])); ?>%</strong></td>
        <?php } ?>
            <td bgcolor="#CCCCCC" width="5%" align="center"  ><strong>Timbre</strong></td>
            <td bgcolor="#CCCCCC" width="5%" align="center"  ><strong>Montant TTC</strong></td>
    </tr>
    <?php
    $i = 0;
    $total = 0;
    $totht = 0;
    $tottimbre = 0;
    $tottotalttc = 0;
    $totbase6 = 0;
    $totbase12 = 0;
    $totbase18 = 0;
    $tottva6 = 0;
    $tottva12 = 0;
    $tottva18 = 0;
    $objfact = ClassRegistry::init('Lignefactureclient');
    $objfactavoir = ClassRegistry::init('Lignefactureavoir');
    $ccp = 0;
    $listvaall = array();
//      debug($tablignefactures);die;
    if ($tablignefactures != array()) {
        foreach ($tablignefactures as $br) {
            $total = $total + $br['totalttc'];

            $base6 = '';
            $base12 = '';
            $base18 = '';
            $tva6 = '';
            $tva12 = '';
            $tva18 = '';

            $lignefact = array();
            $lignefactavoir = array();
            $listva = array();
            $p = 0;
            //debug($tvas);
            if ($br['type'] == 'Facture client') {


                foreach ($tvas as $t) {
                    $tv = intval(floatval($t['Tva']['name']));
                    $fact = $objfact->find('all', array('fields' => array('SUM(Lignefactureclient.totalht) as mtva', 'Lignefactureclient.tva as taux'), 'conditions' => (array('Lignefactureclient.factureclient_id' => $br['id_piece'], 'Lignefactureclient.tva' => $tv)), 'recursive' => -1));
//debug($fact);
                    if ($fact[0][0]['mtva'] != NULL) {
                        $tvmnt = floatval($fact[0][0]['mtva']) * floatval($tv) / 100;
                        $listva[$p]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                        $listva[$p]['mtva'] = sprintf("%.3f", $tvmnt);
                        $listva[$p]['base'] = sprintf("%.3f", $fact[0][0]['mtva']);
                        $listva[$p]['tva'] = intval(floatval($t['Tva']['name']));
                        $p++;

                        $listvaall[$ccp]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                        $listvaall[$ccp]['mtva'] = sprintf("%.3f", $tvmnt);
                        $listvaall[$ccp]['base'] = sprintf("%.3f", $fact[0][0]['mtva']);
                        $listvaall[$ccp]['tva'] = intval(floatval($t['Tva']['name']));
                        $ccp++;

                        $type = 'a';
                    } else {
                        $listva[$p]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                        $listva[$p]['mtva'] = 0;
                        $listva[$p]['base'] = 0;
                        $listva[$p]['tva'] = intval(floatval($t['Tva']['name']));
                        $p++;
                        $listvaall[$ccp]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                        $listvaall[$ccp]['mtva'] = 0;
                        $listvaall[$ccp]['base'] = 0;
                        $listvaall[$ccp]['tva'] = intval(floatval($t['Tva']['name']));
                        $ccp++;
                    }
                }
            } else {


                foreach ($tvas as $t) {
                    $tv = intval(floatval($t['Tva']['name']));
                    $lignefactavoir = $objfactavoir->find('all', array('fields' => array('SUM(Lignefactureavoir.totalht) as mtva', 'Lignefactureavoir.tva'), 'conditions' => (array('Lignefactureavoir.factureavoir_id' => $br['id_piece'], 'Lignefactureavoir.tva' => $tv)), 'recursive' => -1));

                    if ($lignefactavoir[0][0]['mtva'] != NULL) {

                        $tvmnt = floatval($lignefactavoir[0][0]['mtva']) * floatval($tv) / 100;
                        //debug($fact);//die;
                        $listva[$p]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                        $listva[$p]['mtva'] = sprintf("%.3f", $tvmnt);
                        $listva[$p]['base'] = sprintf("%.3f", $lignefactavoir[0][0]['mtva']);
                        $listva[$p]['tva'] = intval(floatval($t['Tva']['name']));
                        $p++;

                        $listvaall[$ccp]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                        $listvaall[$ccp]['mtva'] = sprintf("%.3f", $tvmnt);
                        $listvaall[$ccp]['base'] = sprintf("%.3f", $lignefactavoir[0][0]['mtva']);
                        $listvaall[$ccp]['tva'] = intval(floatval($t['Tva']['name']));
                        $ccp++;
                    } else {
                        $listva[$p]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                        $listva[$p]['mtva'] = 0;
                        $listva[$p]['base'] = 0;
                        $listva[$p]['tva'] = intval(floatval($t['Tva']['name']));
                        $p++;
                        $listvaall[$ccp]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
                        $listvaall[$ccp]['mtva'] = 0;
                        $listvaall[$ccp]['base'] = 0;
                        $listvaall[$ccp]['tva'] = intval(floatval($t['Tva']['name']));
                        $ccp++;
                    }
                }
            }
            $totht = $totht + $br['totalht'];
            $tottimbre = $tottimbre + $br['timbre'];
            $tottotalttc = $tottotalttc + $br['totalttc'];
            ?>
            <tr bgcolor="#FFFFFF" align="center">    
                <td width="3%" align="center" heigth="30px"  ><?php echo $i; ?></td>
                <td width="5%" align="center"  ><?php echo date("Y-m-d", strtotime(str_replace('/', '-', $br['date']))); ?></td>
                <td width="7%" align="center"  ><?php echo $br['numero']; ?></td>                        
                <td width="10%" align="left"  ><?php echo $br['matriculefiscal']; ?></td>
                <td width="22%" align="left"   ><?php echo $br['client']; ?></td>
                <td width="8%" align="left"  ><?php echo "EXO: ".$br['num_exe']; ?></td>
                <td width="5%" align="right"  ><?php echo $br['totalht']; ?></td>
                <?php foreach ($listva as $v) { //debug($v); die;  ?>

                    <td width="<?php echo $w; ?>%" align="right"  ><?php echo $v['base']; ?></td> 
                    <td width="<?php echo $w; ?>%" align="right"  ><?php echo $v['mtva']; ?></td>
                <?php } ?>
                <td width="5%" align="right"  ><?php echo $br['timbre']; ?></td>   
                <td width="5%" align="right"  ><?php echo $br['totalttc']; ?></td>
            </tr>
            <?php
        }
    } else {
        foreach ($tvas as $t) {
            $listvaall[$ccp]['nom'] = 'Base ' . intval(floatval($t['Tva']['name'])) . '%';
            $listvaall[$ccp]['mtva'] = 0;
            $listvaall[$ccp]['base'] = 0;
            $listvaall[$ccp]['tva'] = intval(floatval($t['Tva']['name']));
            $ccp++;
        }
    }

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

        <td bgcolor="#CCCCCC" width="55%" colspan="6" nobr="nobr" align="right"  >Total</td>
        <td bgcolor="#CCCCCC" width="5%" align="right"  ><?php echo sprintf("%.3f", $totht); ?></td>
        <?php foreach ($tf as $y) {//debug($y);die; ?>
            <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $y['base']); ?></td> 
            <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $y['montant']); ?></td>
        <?php } ?>
        <td bgcolor="#CCCCCC" width="5%" align="right"  ><?php echo sprintf("%.3f", $tottimbre); ?></td>
        <td bgcolor="#CCCCCC" width="5%" align="right"  ><?php echo sprintf("%.3f", $tottotalttc); ?></td>
    </tr>
</table>
<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
header("Content-type: application/vnd.ms-excel");
//header("Content-Type: application/force-download");
//header("Content-Type: application/download");
header("Content-Disposition: attachment; filename=Listefactureexonore.xls");
?>