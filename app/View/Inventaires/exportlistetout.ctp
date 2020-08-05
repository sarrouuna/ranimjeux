<?php

ob_start();
?>
<table align="center" cellpadding="0" cellspacing="0"  style=" width: 100%; font-size: 3mm;" border="1">       
   
    <tr>
        <td height="35px" align="left"  width="12%"><strong>Numero : </strong></td> 
        <td align="left" width="13%"><?php echo $inventaire['Inventaire']['numero']; ?></td>
              <td height="35px" align="center"  width="10%" ><strong>Depot  : </strong></td> 
        <td align="left" width="30%"><?php echo $inventaire['Depot']['designation']; ?></td>
             <td height="35px" align="left" width="10%"><strong>Date : </strong></td>
        <td align="left" width="15%"><?php echo date("d/m/Y", strtotime(str_replace('-', '/', ($inventaire['Inventaire']['date'])))); ?></td>
    </tr> 
    </table>
    <table width="100%" cellpadding="2" cellspacing="0"  style=" width: 100%; font-size: 3mm;" border="1">
    <tr>
        <td align="center"  width="70%"><strong>Article</strong></td>
        <td align="center"  width="10%"><strong>Quantite</strong></td>
        <td align="center"  width="10%"><strong>Valeur</strong></td>
        <td align="center"  width="10%"><strong>ToT Valeur</strong></td>
</tr>
    <?php 
    $tot=0;
    foreach ($ligneinvents as $i=>$af) {
        if(empty($af['Ligneinventaire']['quantite'])){
            $af['Ligneinventaire']['quantite']=0;
        }
        if(empty($af['Ligneinventaire']['coutderevien'])){
            $af['Ligneinventaire']['coutderevien']=0;
        }
     $tot+=$af['Ligneinventaire']['quantite']*$af['Ligneinventaire']['coutderevien'];   
        ?>
        <tr bgcolor="#FFFFFF" align="center">    

            <td width="70%" align="left"  ><?php echo @$af['Ligneinventaire']['code'] . " " . @$af['Ligneinventaire']['designation']; ?></td>    
            <td width="10%" align="center"  ><?php echo @$af['Ligneinventaire']['quantite']; ?></td>
            <td width="10%" align="right"   ><?php echo number_format(@$af['Ligneinventaire']['coutderevien'],3, '.', ' '); ?></td>
            <td width="10%" align="right"  ><?php echo number_format(@$af['Ligneinventaire']['quantite']*@$af['Ligneinventaire']['coutderevien'],3, '.', ' '); ?></td>
        </tr>
    <?php } ?>
        
        

    <tr align="center">    
        <td bgcolor="#CCCCCC"  colspan="3" nobr="nobr" align="right"  >Total</td>
        <td bgcolor="#CCCCCC"  align="right"  ><?php echo number_format(@$tot,3, '.', ' '); ?></td>
        
    </tr>

    

</table>
<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
header("Content-type: application/vnd.ms-excel");
//header("Content-Type: application/force-download");
//header("Content-Type: application/download");
header("Content-Disposition: attachment; filename=inventaire.xls");
?>