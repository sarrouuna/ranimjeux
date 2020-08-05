<script language="JavaScript" type="text/JavaScript">

    function flvFPW1(){

        var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    } 
</script>





<head>

</head>

<table align="center" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" width="100%" >

    <tr align="center">
                       <th bgcolor="#CCCCCC" width="19%" align="center"  height="30px" ><strong>Client</strong></th>
                        <th bgcolor="#CCCCCC" width="10%" align="center"  ><strong>Date</strong></th>
                        <th bgcolor="#CCCCCC" width="14%" align="center"  ><strong>Numero</strong></th>
                        <th bgcolor="#CCCCCC" width="17%" align="center"  ><strong>Montant</strong></th>
                        <th bgcolor="#CCCCCC" width="17%" align="center"  ><strong>Reste a impute</strong></th>
                              
                   </tr>
    <?php
    $i=0; $ttc=$ht=0;$ttoimp=0;
       foreach ($reglements as $br){  
         $ttc=$ttc+$br['Reglementclient']['Montant'];
         $ttoimp=$ttoimp+($br['Reglementclient']['Montant'] - $br['Reglementclient']['montantaffecte']);
        ?>
        <tr bgcolor="#FFFFFF" align="center">    
        <td width="19%" nobr="nobr" align="left" height="30px" ><?php  echo $br['Client']['name'];?></td>
        <td width="10%" nobr="nobr" align="center"  ><?php  echo date("d/m/Y",strtotime(str_replace('-','/',$br['Reglementclient']['Date'])));?></td>
        <td width="14%" nobr="nobr" align="center"  ><?php  echo $br['Reglementclient']['numero'];?></td>
        <td width="17%" nobr="nobr" align="center"  ><?php  echo $br['Reglementclient']['Montant'];?></td>
        <td width="17%" nobr="nobr" align="center"  ><?php  echo sprintf("%.3f", $br['Reglementclient']['Montant'] - $br['Reglementclient']['montantaffecte']);?></td>
    </tr>
    
    <?php }?>
    <tr align="center"> 
        <td bgcolor="#CCCCCC"  colspan="3" nobr="nobr" align="right"  ><strong>Total</strong></td>
         <td bgcolor="#CCCCCC"  nobr="nobr" align="center"  ><strong><?php echo sprintf("%.3f",$ttc);?></strong></td>
         
         <td bgcolor="#CCCCCC"  nobr="nobr" align="center"  ><strong><?php echo sprintf("%.3f",$ttoimp);?></strong></td>
    </tr>
</table>

<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
header("Content-type: application/vnd.ms-excel");
 
header("Content-Disposition: attachment; filename=reglement.xls");
?>