<script language="JavaScript" type="text/JavaScript">

    function flvFPW1(){

        var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    } 
</script>





<head>

</head>

<table border="1">
                      <thead>
	<tr>
	       
	        <th><?php echo ('Code'); ?></th> 
                <th><?php echo ('Raison'); ?></th>
                <th><?php echo ('Tel'); ?></th>
		<th><?php echo ('Fax'); ?></th>
		<th><?php echo ('Ville'); ?></th>
		<th><?php echo ('Adresse'); ?></th>
	        <th><?php echo ('Type'); ?></th>
                <th><?php echo ('MF'); ?></th>
                <th><?php echo ('RC'); ?></th>
                <th><?php echo ('Agent'); ?></th>
        </tr></thead><tbody>
	<?php foreach ($listeclients as $article){ 
            //debug($article);die;
            ?>
	<tr>
                <td ><?php echo h($article['Client']['code']); ?></td>
                <td align="left" style="width:30%"><?php echo ($article['Client']['name']); ?></td>
		<td ><?php echo h($article['Client']['tel']); ?></td>
                <td ><?php echo h($article['Client']['fax']); ?></td>
                <td ><?php echo h($article['Zone']['name']); ?></td>
                <td ><?php echo h($article['Client']['adresse']); ?></td>
                <td ><?php echo h($article['Typeclient']['name']); ?></td>
                <td ><?php echo h($article['Client']['matriculefiscale']); ?></td>
                <td ><?php echo h($article['Client']['registrecommerce']); ?></td>
                <td ><?php echo h($article['Personnel']['name']); ?></td> 
	</tr>
        <?php } ?>
                          </tbody>
	</table>

<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
header("Content-type: application/vnd.ms-excel");
 
header("Content-Disposition: attachment; filename=clients.xls");
?>