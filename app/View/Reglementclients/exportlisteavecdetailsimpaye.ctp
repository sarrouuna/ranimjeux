<script language="JavaScript" type="text/JavaScript">
    function flvFPW1(){
    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;
    } 
</script>
<?php
$w = 60 / 7;
?>

<table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" class="table" nobr="true">       
    <tr align="center">
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Date</strong></td> 
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Code Cli</strong></td>                      
        <td bgcolor="#CCCCCC" width="15%" align="center"  ><strong>Nom prenom</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"   ><strong>Nature</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>N° piece</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Net</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Tot REG</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Reste à payer</strong></td>
        <td bgcolor="#CCCCCC" width="25%" align="center"  ><strong>Reglements</strong></td>
    </tr>

    <?php
    $i = 0;
    $totmntimp = 0;
    $totnet = 0;
    $tottotreg = 0;
    $totrestepayer = 0;
    $totreste=0;

    $objbord = ClassRegistry::init('Lignebordereau');
    $ccp = 0;
    $nbpage = 0;

    foreach ($lignefactures as $br) {


//debug($br);die;

        $clt = ClassRegistry::init('Client')->find('first', array('conditions' => array('Client.id' => $br['Reglementclient']['client_id']), 'recursive' => -1));




        //debug($bordereau);debug($numbord);
//debug('aa');die;
        $lignereg = ClassRegistry::init('Lignereglementclient')->find('all', array('conditions' => array('Lignereglementclient.piecereglementclient_id' => $br['Piecereglementclient']['id']), 'recursive' => -1));
//debug($lignereg);die;
        $numreg = '';
        $totreg = 0;
        foreach ($lignereg as $j => $l) {
            $lignepiece = ClassRegistry::init('Piecereglementclient')->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $l['Lignereglementclient']['reglementclient_id']), 'recursive' => 0));
            //debug($lignepiece);
            foreach ($lignepiece as $p) {
                $t = $p['Paiement']['name'] . ' ';

                $totreg = $totreg + floatval($p['Piecereglementclient']['montant']);
                if ($j != 0) {
                    $numreg.= '<br>' . $t . $p['Piecereglementclient']['montant'] . ' ' . $p['Piecereglementclient']['banque'] . ' ' . $p['Piecereglementclient']['num'] . ' Le ' . date("d/m/Y", strtotime(str_replace('-', '/', $p['Piecereglementclient']['echance'])));

                    $i++;
                } else {
                    $numreg.=$t . $p['Piecereglementclient']['montant'] . ' ' . $p['Piecereglementclient']['banque'] . ' ' . $p['Piecereglementclient']['num'] . ' Le ' . date("d/m/Y", strtotime(str_replace('-', '/', $p['Piecereglementclient']['echance'])));
                }
            }
        }
        if (floatval($totreg) == 0) {
            $totreg = '';
        } else {
            $totreg = sprintf("%.3f", $totreg);
        }

        //debug($reg);debug($totreg);die;
    if($reg=='0' || $reg=='Tous' || ($reg=='Regle' && $br['Piecereglementclient']['montant']==$br['Piecereglementclient']['mantantregler']) || ($reg=='Nonregle' && $br['Piecereglementclient']['montant']!=$br['Piecereglementclient']['mantantregler'])){

            $mntcheque = '';
            $numcheque = '';
            $type = '';

            if ($br['Piecereglementclient']['paiement_id'] == 2) {
                
                $type = 'CHEQUE';
            }
            if ($br['Piecereglementclient']['paiement_id'] == 3) {
                
                $type = 'EFFET';
            }

//debug($br);die;


            $reste = sprintf("%.3f", floatval($br['Piecereglementclient']['montant']) - floatval($br['Piecereglementclient']['mantantregler']));
    $totnet = $totnet + floatval($br['Piecereglementclient']['montant']);
    $tottotreg = $tottotreg + floatval($br['Piecereglementclient']['mantantregler']);
    $totreste = $totreste + floatval($reste);
            if ($reste == 0)
                $reste = '';
            ?>

            <tr bgcolor="#FFFFFF" align="center">
                <td width="<?php echo $w; ?>%" align="center"  ><?php echo date("d/m/Y", strtotime(str_replace('-', '/', $br['Piecereglementclient']['datesituation']))); ?></td>
                <td width="<?php echo $w; ?>%" align="center"  ><?php echo $clt['Client']['code']; ?></td>                      
                <td width="15%" align="left"  ><?php echo $clt['Client']['name']; ?></td>
                <td width="<?php echo $w; ?>%" align="center"   ><?php echo $type; ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $numcheque; ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $br['Piecereglementclient']['montant']); ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $br['Piecereglementclient']['mantantregler']; ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $reste; ?></td>
                <td width="25%" align="left"  ><?php echo $numreg; ?></td>
            </tr>
            <?php
        }
    }
    ?>

    <tr align="center">    

        <td bgcolor="#CCCCCC" colspan="5" nobr="nobr" align="right"  >Total</td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $totnet) ; ?></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $tottotreg) ; ?></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $totreste) ; ?></td>
        <td bgcolor="#CCCCCC"  bgcolor="#CCCCCC" width="25%" align="right"  ></td>
    </tr>
</table>

<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
header("Content-type: application/vnd.ms-excel");
//header("Content-Type: application/force-download");
//header("Content-Type: application/download");
header("Content-Disposition: attachment; filename=Listeimpayeavecdetails.xls");
?>