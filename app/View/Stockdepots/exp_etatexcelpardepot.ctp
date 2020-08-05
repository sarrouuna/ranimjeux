<script language="JavaScript" type="text/JavaScript">

    function flvFPW1(){

        var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    } 
</script>





<head>

</head>

<table align="center" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" width="100%" >

    <tr bgcolor="#BB010C"  style="color:#FFFFFF; font-family:Arial; font-size:12px;" >
        <th>Code Article</th>
        <th>Réference Article</th>
        <?php foreach ($depotalls as $depot){ ?>
        <th><?php echo $depot['Depot']['designation'] ; ?></th>
        <?php }?>
        <th>Qte ToT</th>
        <th>PR HT</th>
        <th>PR ToT</th>
    </tr>
    <?php
    $total=0;
        foreach ($stockdepots as $stockdepot){ 
            
        $total=$total+($stockdepot[0]['prix']*$stockdepot[0]['qte']);    
            ?>
	<tr>
		
		<td >
			<?php echo $stockdepot['Article']['code'] ; ?>
		</td>
        <td >
			<?php echo  $stockdepot['Article']['name']; ?>
		</td>
                <?php foreach ($depotalls as $d=>$depot){ 
                $obj = ClassRegistry::init('Stockdepot');
                $stckdepot=$obj->find('all',array('conditions'=>array('Stockdepot.article_id'=>$stockdepot['Article']['id'],'Stockdepot.depot_id'=>$depot['Depot']['id']),false));
                ?>
                
                <td align="center">
                <table border="1" width="100%">    
                <?php foreach ($stckdepot as $dep=>$sd){ 
                if($sd['Stockdepot']['quantite']!=0){    
                    ?>
                    <tr>
<!--                        <td><?php echo date("d/m/Y",strtotime(str_replace('/','-',$sd['Stockdepot']['date_exp']))); ?></td>
-->                        <td><?php 
                        $test=strpos($sd['Stockdepot']['quantite'], ".");
                        if($test==true){
                        echo sprintf('%.3f',$sd['Stockdepot']['quantite']);
                        }else{
                        echo $sd['Stockdepot']['quantite'];    
                        }
                        ?></td>
                    </tr>
                <?php }}?></table></td>
                <?php }?>
                
                
                
		<td align="center">
                <?php 
                $test=strpos($stockdepot[0]['qte'], ".");
                if($test==true){
                echo sprintf('%.3f',$stockdepot[0]['qte']);
                }else{
                echo $stockdepot[0]['qte'];    
                }
                ?></td>
                <td align="center"><?php echo number_format($stockdepot[0]['prix'],3,'.',' '); ?></td>
                <td align="center"><?php echo number_format($stockdepot[0]['prix']*$stockdepot[0]['qte'],3,'.',' '); ?></td>
		
	</tr>
<?php } ?>
                          </tbody>
                          <tfoot>
                          <td colspan="<?php echo @$d+3; ?>"><strong>Total</strong></td> 
                          <td align="right" colspan="2"><?php echo number_format($total,3,'.',' ');  ?></td>
                          </tfoot>
	</table>

<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
header("Content-type: application/vnd.ms-excel");
 
header("Content-Disposition: attachment; filename=etatstock.xls");
?>