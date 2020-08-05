<script language="JavaScript" type="text/JavaScript">
    function flvFPW1(){
    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;
    } 
</script>
<?php
$w = 80 / 10;
?>

<table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" nobr="true">       
    <tr align="center">
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>N° BLF</strong></td> 
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Date</strong></td> 
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Code Frs</strong></td>                      
        <td bgcolor="#CCCCCC" width="20%" align="center"  ><strong>Nom prenom</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"   ><strong>Piece Frs</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Date dec</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Tot HT</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Tot TVA</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Net</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Tot Reg</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Reste à payer</strong></td>
    </tr>

    <?php
    $i = 0;
    $totmntimp = 0;
    $totnet = 0;
    $tottotreg = 0;
    $totrestepayer = 0;
    $totreste=0;
    $totht=0;
    $tottottva=0;

    $ccp = 0;
    $nbpage = 0;
//debug($lignefactures);die;
//debug($bordereau);die;

    foreach ($lignefactures as $br) {


//debug($br);die;

        $clt = ClassRegistry::init('Fournisseur')->find('first', array('conditions' => array('Fournisseur.id' => $br['Factureavoirfr']['fournisseur_id']), 'recursive' => -1));




        //debug($bordereau);debug($numbord);
//debug('aa');die;
        //$lignereg = ClassRegistry::init('Lignereglement')->find('all', array('conditions' => array('Lignereglement.facture_id' => $br['Factureavoirfr']['id']),'fields' => array('sum(Lignereglement.Montant) as totalreg'), 'recursive' => -1));
//debug($br);die;
        $numreg = '';
        $totreg = @$br['Factureavoirfr']['Montant_Regler'];
        $totreg = sprintf("%.3f", $totreg);


        //debug($reg);debug($totreg);die;
        if (floatval($reg == 0) || $reg == 'Tous' || ($reg == 'Regle' && floatval($totreg) != 0) || ($reg == 'Nonregle' && floatval($totreg == 0))) {
            $reste = sprintf("%.3f", floatval($br['Factureavoirfr']['totalttc']) - floatval($totreg));
            $totht = $totnet + floatval($br['Factureavoirfr']['totalht']);
            $tottottva = $totnet + floatval($br['Factureavoirfr']['tva']);
            $totnet = $totnet + floatval($br['Factureavoirfr']['totalttc']);
            $tottotreg = $tottotreg + floatval($totreg);
            $totreste = $totreste + floatval($reste);
            if ($reste == 0)
                $reste = '';

            $datedec = '';
            if (@$br['Factureavoirfr']['datedeclaration'] != NULL && @$br['Factureavoirfr']['datedeclaration'] != '0000-00-00') {
                $datedec = date("d/m/Y", strtotime(str_replace('-', '/', @$br['Factureavoirfr']['datedeclaration'])));
            }
            ?>
            <tr bgcolor="#FFFFFF" align="center">
                <td width="<?php echo $w; ?>%" align="center"  ><?php echo $br['Factureavoirfr']['numero']; ?></td>
                <td width="<?php echo $w; ?>%" align="center"  ><?php echo date("d/m/Y", strtotime(str_replace('-', '/', $br['Factureavoirfr']['date']))); ?></td>
                <td width="<?php echo $w; ?>%" align="center"  ><?php echo $clt['Fournisseur']['code']; ?></td>                      
                <td width="20%" align="left"  ><?php echo $clt['Fournisseur']['name']; ?></td>
                <td width="<?php echo $w; ?>%" align="center"   ><?php echo @$br['Factureavoirfr']['numerofrs']; ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $datedec; ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $br['Factureavoirfr']['totalht']); ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $br['Factureavoirfr']['tva']); ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $br['Factureavoirfr']['totalttc']); ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $totreg; ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $reste; ?></td>
            </tr>

            <?php
        }
    }
    ?>

    <tr align="center">    

        <td bgcolor="#CCCCCC" colspan="6" nobr="nobr" align="right"  >Total</td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo  sprintf("%.3f", $totht) ; ?></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo  sprintf("%.3f", $tottottva) ; ?></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo  sprintf("%.3f", $totnet) ; ?></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo  sprintf("%.3f", $tottotreg) ; ?></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo  sprintf("%.3f", $totreste) ; ?></td>
    </tr>
</table>
<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
header("Content-type: application/vnd.ms-excel");
//header("Content-Type: application/force-download");
//header("Content-Type: application/download");
header("Content-Disposition: attachment; filename=Listefacturesavoir.xls");
?>