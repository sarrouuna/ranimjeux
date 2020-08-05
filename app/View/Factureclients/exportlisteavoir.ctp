<script language="JavaScript" type="text/JavaScript">
    function flvFPW1(){
    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;
    } 
</script>
<?php
$w = 0;
if (count($tvas) != 0) {
    $w = 35 / (count($tvas) * 2);
}
?>

<table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" nobr="true">       
    <tr  align="center">
        <td bgcolor="#CCCCCC" width="10%" align="center"  ><strong>N° Avoir</strong></td> 
        <td bgcolor="#CCCCCC" width="5%" align="center"  ><strong>Date</strong></td>
        <td bgcolor="#CCCCCC" width="5%" align="center"  ><strong>Code Cli</strong></td>                      
        <td bgcolor="#CCCCCC" width="10%" align="center"  ><strong>Matricule_Fiscal</strong></td>
        <td bgcolor="#CCCCCC" width="20%" align="center"   ><strong>Nom/Raison</strong></td>
        <?php foreach ($tvas as $t) { //debug($t);die;  ?>
            <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Base <?php echo intval(floatval($t['Tva']['name'])); ?>%</strong></td> 
            <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>TVA <?php echo intval(floatval($t['Tva']['name'])); ?>%</strong></td>
        <?php } ?>


        <td bgcolor="#CCCCCC" width="10%" align="center"  ><strong>Net a payer</strong></td>
        <td bgcolor="#CCCCCC" width="5%" align="center"  ><strong>Timbre</strong></td>


    </tr>
    <?php
    $i = 0;
    $total = 0;
    $totht = 0;
    $totnetapayer = 0;
    $tottimbre = 0;
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
            $f = '';
            foreach ($tvas as $t) { //debug($t);die;
                $exono = $objexo->find('count', array('conditions' => (array('Exonorationclient.client_id' => $br['idclient']
                , 'Exonorationclient.datedu <= ' => $br['date'], 'Exonorationclient.dateau >= ' => $br['date'])), 'recursive' => -1));
                if (floatval($exono) != 0) {
                    $lignefactavoirzero = $objfactavoir->find('all', array('fields' => array('SUM(Lignefactureavoir.totalht) as mtva', 'Lignefactureavoir.tva'), 'conditions' => (array('Lignefactureavoir.factureavoir_id' => $br['id_piece'])), 'recursive' => -1));
                } else {
                    $lignefactavoirzero = $objfactavoir->find('all', array('fields' => array('SUM(Lignefactureavoir.totalht) as mtva', 'Lignefactureavoir.tva'), 'conditions' => (array('Lignefactureavoir.factureavoir_id' => $br['id_piece'], 'Lignefactureavoir.tva' => 0)), 'recursive' => -1));
                }

                if ($lignefactavoirzero[0][0]['mtva'] != NULL) {
                    $f = $lignefactavoirzero[0][0]['mtva'];
                }
                $lignefactavoir = $objfactavoir->find('all', array('fields' => array('SUM(Lignefactureavoir.totalht) as mtva', 'Lignefactureavoir.tva'), 'conditions' => (array('Lignefactureavoir.factureavoir_id' => $br['id_piece'])), 'group' => ['Lignefactureavoir.tva'], 'recursive' => -1));

                if ($lignefactavoir[0][0]['mtva'] != NULL && floatval($exono) == 0) {

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

//    debug($listva);
//    die;
            //debug($br);die;
            $totnetapayer = $totnetapayer + $br['totalttc'];
            $tottimbre = $tottimbre + $br['timbre'];
            ?>

            <tr bgcolor="#FFFFFF" align="center">    
                <td width="10%" align="center" heigth="30px"  ><?php echo $br['numero']; ?></td>
                <td width="5%" align="center"  ><?php echo date("Y-m-d", strtotime(str_replace('/', '-', $br['date']))); ?></td>
                <td width="5%" align="center"  ><?php echo $br['code']; ?></td>                        
                <td width="10%" align="left"  ><?php echo $br['matriculefiscal']; ?></td>
                <td width="20%" align="left"   ><?php echo $br['client']; ?></td>
                ';
                <?php
                //debug($listva);die;
                foreach ($listva as $v) { //debug($v); die; 
                    ?>

                    <td width="<?php echo $w; ?>%" align="right"  ><?php echo $v['base']; ?></td> 
                    <td width="<?php echo $w; ?>%" align="right"  ><?php echo $v['mtva']; ?></td>
                <?php } ?>


                <td width="10%" align="right"  ><?php echo $br['totalttc']; ?></td>
                <td width="5%" align="right"  >-<?php echo $br['timbre']; ?></td>'
                .</tr>
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
        $tf[$l['tva']]['montant'] = $tf[$l['tva']]['montant'] + $l['mtva'];
        $tf[$l['tva']]['base'] = $tf[$l['tva']]['base'] + $l['base'];
        $tf[$l['tva']]['nom'] = $l['nom'];
    }
    ?>

    <tr align="center">    

        <td bgcolor="#CCCCCC" width="50%" colspan="5" nobr="nobr" align="right"  >Total</td>
        <?php foreach ($tf as $y) {//debug($y);die; ?>
            <td bgcolor="#CCCCCC" width="' . $w . '%" align="right"  ><?php echo sprintf("%.3f", $y['base']); ?></td> 
            <td bgcolor="#CCCCCC" width="' . $w . '%" align="right"  ><?php echo sprintf("%.3f", $y['montant']); ?></td>
        <?php } ?>    
        <td bgcolor="#CCCCCC" width="10%" align="right"  ><?php echo sprintf("%.3f", $totnetapayer); ?></td>
        <td bgcolor="#CCCCCC" width="5%" align="right"  >-<?php echo sprintf("%.3f", $tottimbre); ?></td>
    </tr>
</table>

<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
header("Content-type: application/vnd.ms-excel");
//header("Content-Type: application/force-download");
//header("Content-Type: application/download");
header("Content-Disposition: attachment; filename=Listefactureavoir.xls");
?>