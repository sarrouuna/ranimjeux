<script language="JavaScript" type="text/JavaScript">

    function flvFPW1(){

        var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    } 
</script>

<table border="2">
                      <thead>
	<tr>
	         
           
            
                <th width="10%"><?php echo ('Numero'); ?>&nbsp;&nbsp;&nbsp;</th>
                
                <th width="10%"><?php echo ('Responsable'); ?>&nbsp;&nbsp;&nbsp;</th>
	         
		<th width="20%"><?php echo ('Name'); ?></th>
                
                <th width="20%"><?php echo ('Client'); ?></th>
                
                <th width="10%"><?php echo ('type devis'); ?></th>
                
                <th width="10%"><?php echo ('M TOT'); ?></th>
                
                <th width="10%"><?php echo ('M Gagner'); ?></th>
	         
		<th style="display: none;"><?php echo ('Promoteur'); ?></th>
	         
		<th ><?php echo ('Bureau d\'etude'); ?></th>
                
                <th ><?php echo ('Entreprise de fluide'); ?></th>
                
	        <th ><?php echo ('Region'); ?></th> 
                
		<th ><?php echo ('situation'); ?></th>
	         
		<th style="display: none;"><?php echo ('Entreprise de batiment'); ?></th>
	         
		
        </tr></thead><tbody>
	<?php 
        //debug($affaires);die;
        $totale_tout=0;
        $total_gagner=0;
        foreach ($lisaffaires as $affaire): 
        $clients=ClassRegistry::init('Devis')->find('all',array('conditions'=>array('Devis.affaire_id'=>$affaire['Affaire']['id']), 'group' => array('Devis.name')));
        //debug($clients);
        $typedevis=ClassRegistry::init('Devis')->find('all',array(
        'fields' => array('Devis.typesuivitdevi_id')    
        ,'conditions'=>array('Devis.affaire_id'=>$affaire['Affaire']['id'])
        , 'group' => array('Devis.typesuivitdevi_id'),'recursive' => 0));
        $maxclients=ClassRegistry::init('Devis')->find('all',array(
            'fields' => array('Devis.name','SUM(Devis.totalttc)  tot')
            ,'conditions'=>array('Devis.affaire_id'=>$affaire['Affaire']['id'],'Devis.eliminermontant'=>0)
            ,'group' => array('Devis.name')
            ,'order' => array('tot' => 'desc')
            ,'limit' => 1
            ));
        $ganerclients=ClassRegistry::init('Suivicommercial')->find('first',array(
            'fields' => array('SUM(Suivicommercial.totalttc)  tot')
            ,'conditions'=>array('Suivicommercial.affaire_id'=>$affaire['Affaire']['id'],'Suivicommercial.statusuivi_id'=>3)
            //,'group' => array('Suivicommercial.client')
            ,'recursive' => -1
            )); 
        $situations=ClassRegistry::init('Suivicommercial')->find('count',array(
            //'fields' => array('Suivicommercial.client','SUM(Suivicommercial.totalttc)  tot')
            'conditions'=>array('Suivicommercial.affaire_id'=>$affaire['Affaire']['id'])
            ));
        $situationperdus=ClassRegistry::init('Suivicommercial')->find('count',array(
            //'fields' => array('Suivicommercial.client','SUM(Suivicommercial.totalttc)  tot')
            'conditions'=>array('Suivicommercial.affaire_id'=>$affaire['Affaire']['id'],'Suivicommercial.statusuivi_id'=>2)
            ));
        $situationgangers=ClassRegistry::init('Suivicommercial')->find('count',array(
            //'fields' => array('Suivicommercial.client','SUM(Suivicommercial.totalttc)  tot')
            'conditions'=>array('Suivicommercial.affaire_id'=>$affaire['Affaire']['id'],'Suivicommercial.statusuivi_id'=>3)
            ));
        //debug($affaire['Affaire']['name']);
        //debug($ganerclients);
        ?>
	<tr>
		
            <td ><?php echo $affaire['Affaire']['numero']."/".$affaire['Affaire']['exercice_id']; ?></td>
                <td ><?php 
                if(!empty($affaire['Affaire']['responsable'])){
                foreach (explode(',',$affaire['Affaire']['responsable']) as $res){
                if($res !=0)  {  
                echo $responsables[$res]."<br>";    
                }}}
                ?></td>
		<td ><?php echo h($affaire['Affaire']['name']); ?></td>
                <td ><?php 
                foreach ($clients as $client){ 
                //$nomclients=ClassRegistry::init('Client')->find('first',array('conditions'=>array('Client.id'=>$client['Devis']['client_id'])));
                echo $this->Html->link($client['Devis']['name'], array('controller' => 'devis', 'action' => 'index', $client['Devis']['name'],$affaire['Affaire']['id']))."<br>"; 
                }?></td>
                <td ><?php 
                if(!empty($typedevis)){
                foreach ($typedevis as $typedevi){ 
                $gettypedevis=ClassRegistry::init('Typesuivitdevi')->find('first',array('conditions'=>array('Typesuivitdevi.id'=>$typedevi['Devis']['typesuivitdevi_id'])));
                if(!empty($gettypedevis)){
                echo $gettypedevis['Typesuivitdevi']['name']."<br>";
                }}}?></td>
                <td ><?php 
                if(empty($maxclients)){
                $maxclients[0][0]['tot']=0;    
                }
                $totale_tout=$totale_tout+@$maxclients[0][0]['tot'];
                echo number_format( @$maxclients[0][0]['tot'],3, ',', ' '); ?></td>
		<td ><?php 
                if(!empty($ganerclients)){
                $total_gagner=$total_gagner+$ganerclients[0]['tot'];    
                echo number_format(@$ganerclients[0]['tot'],3, ',', ' ');
                }else{
                echo  0;    
                }?></td>
		<td style="display: none;"><?php echo h($affaire['Affaire']['promoteur']); ?></td>
		<td ><?php echo h($affaire['Affaire']['bureaudetude']); ?></td>
                <td ><?php echo h($affaire['Affaire']['entreprisedefluide']); ?></td>
                <td ><?php echo h($affaire['Region']['name']); ?></td>
		<td ><?php
                if(($situations==$situationperdus)&&($situations!=0)){
                ClassRegistry::init('Affaire')->updateAll(array('Affaire.situation_id' =>2), array('Affaire.id' =>$affaire['Affaire']['id']));
                $raisonperdus=ClassRegistry::init('Suivicommercial')->find('first',array(
                'conditions'=>array('Suivicommercial.affaire_id'=>$affaire['Affaire']['id'])
                ,'recursive' => -1
                ));
                ClassRegistry::init('Affaire')->updateAll(array('Affaire.raisondeperde_id' =>$raisonperdus['Suivicommercial']['raisondeperde_id']), array('Affaire.id' =>$affaire['Affaire']['id']));
                echo 'Perdu';
                }else{
                if($situationgangers>0){
                ClassRegistry::init('Affaire')->updateAll(array('Affaire.situation_id' =>3), array('Affaire.id' =>$affaire['Affaire']['id']));
                    echo 'Gagner';
                }
                else{
                ClassRegistry::init('Affaire')->updateAll(array('Affaire.situation_id' =>1), array('Affaire.id' =>$affaire['Affaire']['id']));
                 echo 'En cours';    
                }
                }
                ?></td>
		<td style="display: none;"><?php echo h($affaire['Affaire']['entreprisedebatiment']); ?></td>
		
		
	</tr>
                      
<?php endforeach; ?>
        <tfoot>
        <td colspan="5"> Total</td>
        <td><?php echo number_format($totale_tout,3, ',', ' '); ?></td>
        <td><?php echo number_format($total_gagner,3, ',', ' '); ?></td>
        </tfoot>
                          </tbody>
	</table>




<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
header("Content-type: application/vnd.ms-excel");
 
header("Content-Disposition: attachment; filename=affaires.xls");
?>