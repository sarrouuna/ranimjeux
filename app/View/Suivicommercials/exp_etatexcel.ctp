<script language="JavaScript" type="text/JavaScript">

    function flvFPW1(){

        var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    } 
</script>

<table border="1">
    
    <tr>
        <td style="background-color:white" colspan="3"></td>
        <td style="background-color:#F739B4"><center>1er contact</center></td>
        <td style="background-color:#FABC00" colspan="5"><center>OFFRE DE PRIX</center></td>
        <td style="background-color:#white" colspan="2"></td>
        <td style="background-color:#4CC3FA" colspan="3"><center>CONFIRMATION</center></td>
        <td style="background-color:#1B8B36" colspan="2"><center>INSTALLATION</center></td>
        <td style="background-color:#F094ED"><center>AFFAIRE</center></td>
        <td style="background-color:#F900F1"><center>BUREAU D'ETUDE</center></td>
        <td style="background-color:#242869"><center>ENTREPRISE</center></td>
        <td style="background-color:#white"></td>
    </tr>
    
    
    
	<tr>
	         
		
	         
		<th><?php echo ('Numero'); ?></th>
	         
		<th ><?php echo ('Description'); ?></th>
	         
		<th><?php echo ('Client'); ?></th>
	         
		<th ><?php echo ('1er contact'); ?></th>
	         
		<th ><?php echo ('Preparer par'); ?></th>
	         
		<th ><?php echo ('Num'); ?></th>
	         
		<th><?php echo ('Date'); ?></th>
	         
		<th><?php echo ('Total HT'); ?></th>
	         
		<th><?php echo ('Total TTC'); ?></th>
	         
		<th ><?php echo ('Statu suivi'); ?></th>
	         
		<th ><?php echo ('Raison de perde'); ?></th>
	         
		<th ><?php echo ('Recu par'); ?></th>
	         
		<th ><?php echo ('Num de recu'); ?></th>
	         
		<th ><?php echo ('Date recu'); ?></th>
	         
		<th ><?php echo ('Inclu suivi'); ?></th>
	         
		<th ><?php echo ('Date d\'installation'); ?></th>
	         
		<th ><?php echo ('Affaire'); ?></th>
	         
		<th ><?php echo ('Bureau d\'etude'); ?></th>
	         
		<th ><?php echo ('Entreprise'); ?></th>
	         
		<th ><?php echo ('Reglement'); ?></th>
	         
		
			
        </tr>
    <tbody>
	<?php foreach ($suivicommercials as $suivicommercial): ?>
	<tr>
		
		<td ><?php echo h($suivicommercial['Suivicommercial']['numero']); ?></td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['description']); ?></td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['client']); ?></td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['1emecontact']); ?></td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['preparerpar']); ?></td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['num']); ?></td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['date']); ?></td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['totalHT']); ?></td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['totalTTC']); ?></td>
		<td >
			<?php echo $this->Html->link($suivicommercial['Statusuivi']['name'], array('controller' => 'statusuivis', 'action' => 'view', $suivicommercial['Statusuivi']['id'])); ?>
		</td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['raisondeperde']); ?></td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['recupar']); ?></td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['numderecu']); ?></td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['daterecu']); ?></td>
		<td >
			<?php echo $this->Html->link($suivicommercial['Inclusuivi']['name'], array('controller' => 'inclusuivis', 'action' => 'view', $suivicommercial['Inclusuivi']['id'])); ?>
		</td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['dateinstallation']); ?></td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['affaire']); ?></td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['bureaudetude']); ?></td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['entreprise']); ?></td>
		<td ><?php echo h($suivicommercial['Suivicommercial']['reglement']); ?></td>
		
		
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>


<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
header("Content-type: application/vnd.ms-excel");
 
header("Content-Disposition: attachment; filename=Suivi_commercial_".$typesuivitdevis[$typesuivitdevi_id].".xls");
?>