<script language="JavaScript" type="text/JavaScript">
    function flvFPW1(){
    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;
    } 
</script>
<?php
$w = 70 / 10;
?>




<table border="1" align="center" cellpadding="2" cellspacing="0"  width="100%" >       
    <tr align="center">
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>N° Reg</strong></td> 
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Date</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Code Cli</strong></td>                      
        <td bgcolor="#CCCCCC" width="25%" align="center"  ><strong>Nom prenom</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"   ><strong>N° BORD</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Espece</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Cheque</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Effet</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Retenue</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Virement</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>N° Cheque</strong></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="center"  ><strong>Date ECH</strong></td>


    </tr>

    <?php
    $i = 0;
    $totespece = 0;
    $totcheque = 0;
    $toteffet = 0;
    $totretenue = 0;
    $totvir = 0;

    $objbord = ClassRegistry::init('Lignebordereau');
    $ccp = 0;
    $nbpage = 0;

    foreach ($lignefactures as $br) {

        $clt = ClassRegistry::init('Client')->find('first', array('conditions' => array('Client.id' => $br['Reglementclient']['client_id']), 'recursive' => -1));


        $numbord = 0;

        $bord = $objbord->find('first', array('conditions' => array('Lignebordereau.piecereglementclient_id' => $br['Piecereglementclient']['id']), 'contain' => ('Bordereau'), 'recursive' => 0));
        if ($bord != array()) {
            $numbord = $bord['Bordereau']['numero'];
        }

        //debug($bordereau);debug($numbord);
        if ((($bordereau == 'AvecBordereau') && (floatval($numbord) != 0)) || ($bordereau == 'Tous') || (($bordereau == 'SansBordereau') && ($numbord == 0))) {
//debug('aa');die;



            $i++;
            $mntespece = '';
            $mntcheque = '';
            $mnteffet = '';
            $mntretenue = '';
            $numcheque = '';
            $mntvirement = '';
            if ($br['Piecereglementclient']['paiement_id'] == 1) {
                $mntespece = $br['Piecereglementclient']['montant'];
                $mntcheque = '';
                $mnteffet = '';
                $mntretenue = '';
                $numcheque = '';
                $mntvirement = '';
            }
            if ($br['Piecereglementclient']['paiement_id'] == 2) {
                $mntespece = '';
                $mntcheque = $br['Piecereglementclient']['montant'];
                $mnteffet = '';
                $mntretenue = '';
                $numcheque = $br['Piecereglementclient']['num'];
                $mntvirement = '';
            }
            if ($br['Piecereglementclient']['paiement_id'] == 3) {
                $mntespece = '';
                $mntcheque = '';
                $mnteffet = $br['Piecereglementclient']['montant'];
                $mntretenue = '';
                $numcheque = '';
                $mntvirement = '';
            }
            if ($br['Piecereglementclient']['paiement_id'] == 5 || $br['Piecereglementclient']['paiement_id'] == 8) {
                $mntespece = '';
                $mntcheque = '';
                $mnteffet = '';
                $mntretenue = $br['Piecereglementclient']['montant'];
                $numcheque = '';
                $mntvirement = '';
            }
            if ($br['Piecereglementclient']['paiement_id'] == 4) {
                $mntespece = '';
                $mntcheque = '';
                $mnteffet = '';
                $mntretenue = '';
                $numcheque = '';
                $mntvirement = $br['Piecereglementclient']['montant'];
            }
//debug($br);die;
            $totespece = $totespece + $mntespece;
            $totcheque = $totcheque + $mntcheque;
            $toteffet = $toteffet + $mnteffet;
            $totretenue = $totretenue + $mntretenue;
            $totvir = $totvir + $mntvirement;
            $dateecheance = '';
            if ($br['Piecereglementclient']['echance'] != null && $br['Piecereglementclient']['echance'] != '1970-01-01') {
                $dateecheance = date("d/m/Y", strtotime(str_replace('-', '/', $br['Piecereglementclient']['echance'])));
            }
            ?>



            <tr bgcolor="#FFFFFF" align="center">    
                <td width="<?php echo $w; ?>%" align="center"  ><?php echo $br['Reglementclient']['numero']; ?></td> 
                <td width="<?php echo $w; ?>%" align="center"  ><?php echo date("d/m/Y", strtotime(str_replace('-', '/', $br['Reglementclient']['Date']))); ?></td>
                <td width="<?php echo $w; ?>%" align="center"  ><?php echo $clt['Client']['code']; ?></td>                      
                <td width="25%" align="left"  ><?php echo $clt['Client']['name']; ?></td>
                <td width="<?php echo $w; ?>%" align="center"   ><?php echo $numbord; ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $mntespece; ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $mntcheque; ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $mnteffet; ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $mntretenue; ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $mntvirement; ?></td>
                <td width="<?php echo $w; ?>%" align="right"  ><?php echo $numcheque; ?></td>
                <td width="<?php echo $w; ?>%" align="center"  ><?php echo $dateecheance; ?></td>

            </tr>


        <?php
        }
    }
    ?>


    <tr align="center">    

        <td bgcolor="#CCCCCC" colspan="5" nobr="nobr" align="right"  >Total</td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $totespece); ?></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $totcheque); ?></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $toteffet); ?></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $totretenue); ?></td>
        <td bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ><?php echo sprintf("%.3f", $totvir); ?></td>
        <td  bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ></td>
        <td  bgcolor="#CCCCCC" width="<?php echo $w; ?>%" align="right"  ></td>
    </tr>
</table>

<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Etatrecettesansdetails.xls");
?>