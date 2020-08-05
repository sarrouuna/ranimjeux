<script>

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}

</script>
<?php $add="";$edit="";$delete="";$imprimer="";$addindirect="";
$lien=  CakeSession::read('lien_vente');
foreach($lien as $k=>$liens) {
    //debug($liens);die;
    if (@$liens['lien'] == 'devis') {
        $add = $liens['add'];
        $edit = $liens['edit'];
        $delete = $liens['delete'];
        $imprimer = $liens['imprimer'];
    }
}
if($add==1){
?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Affaires/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<?php } ?>
<br><input type="hidden" id="page" value="1"/>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
                <ul class="panel-control" style="top: 130px">
                <li><a class="minus" href="javascript:void(0)"><i class="fa fa-square-o"></i></a></li>
                </ul>
            </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Affaire',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
              	<?php 
		echo $this->Form->input('date1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly ','type'=>'text','label'=>'Date de') ); 
                echo $this->Form->input('responsable',array('multiple'=>'multiple','id'=>'responsable','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Responsables','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('promoteur',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Promoteur','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('bureaudetude',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Bureau d\'etude','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('entreprisedefluide',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Entreprise de fluide','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('client',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Client','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
		echo $this->Form->input('region_id',array('empty'=>'veuillez choisir','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('revendeur',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Revendeur','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
                </div>
                <div class="col-md-6">
                <?php
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'Ã ") ); 
                echo $this->Form->input('entreprisedebatiment',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Entreprise de batiment','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('architecte',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Architecte','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('exercice_id',array('multiple'=>'multiple','value'=>@$exerciceid,'empty'=>'veuillez choisir','div'=>'form-group','label'=>'Année','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('affaire',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Affaire','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
		echo $this->Form->input('situation_id',array('empty'=>'veuillez choisir','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('raisondeperde_id',array('empty'=>'Veuillez Choisir !!','label'=>'Raison de perde','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select') );
                echo $this->Form->input('typesuivitdevi_id',array('empty'=>'Veuillez Choisir !!','label'=>'Type Devis','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select') );
                ?>
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                        <a class="btn btn-primary" href="<?php echo $this->webroot;?>Affaires/index"/>Afficher Tout </a>
                        <a  onClick="flvFPW1(wr+'Affaires/exp_etatexcel','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer Excel</button> </a>
                   

                    </div>
                </div>
            </div>
<?php echo $this->Form->end();?>
        </div>
    </div>
</div>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Affaires'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
            <th style="display: none;" ><?php echo ('Id'); ?></th>
            
                <th width="10%"><?php echo ('Numero'); ?>&nbsp;&nbsp;&nbsp;</th>
                
                <th width="10%"><?php echo ('Responsable'); ?>&nbsp;&nbsp;&nbsp;</th>
	         
		<th width="20%"><?php echo ('Name'); ?></th>
        <th width="8%"><?php echo ('Date'); ?></th>
                
                <th width="20%"><?php echo ('Client'); ?></th>
                
                <th width="10%"><?php echo ('type devis'); ?></th>
                
                <th width="10%"><?php echo ('M TOT'); ?></th>
                
                <th width="10%"><?php echo ('M Gagner'); ?></th>
	         
		<th style="display: none;"><?php echo ('Promoteur'); ?></th>
	         
		<th ><?php echo ('Bureau d\'etude'); ?></th>
                
                <th ><?php echo ('Entreprise de fluide'); ?></th>
                
	        <th ><?php echo ('Region'); ?></th> 
                
		<th ><?php echo ('situation'); ?></th>
        <th ><?php echo ('Raison'); ?></th>
        <th ><?php echo ('Note'); ?></th>
	         
		<th style="display: none;"><?php echo ('Entreprise de batiment'); ?></th>
	         
		<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php 
        //debug($lisaffaires);die;
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
		<td style="display: none;"><?php echo h($affaire['Affaire']['id']); ?></td>
		<td ><?php echo h($affaire['Affaire']['numero']); ?></td>
                <td ><?php 
                if(!empty($affaire['Affaire']['responsable'])){
                foreach (explode(',',$affaire['Affaire']['responsable']) as $res){
                if($res !=0)  {  
                echo $responsables[$res]."<br>";    
                }}}
                ?></td>
		<td ><?php echo h($affaire['Affaire']['name']); ?></td>
                <td ><?php echo date("d/m/Y",strtotime(str_replace('/','/',h($affaire['Affaire']['date'])))); ?></td>
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
                echo number_format(@$maxclients[0][0]['tot'],3, '.', ' ') ; @$maxclients[0][0]['tot']; ?></td>
		<td ><?php 
                if(!empty($ganerclients)){
                $total_gagner=$total_gagner+$ganerclients[0]['tot'];    
                echo number_format(@$ganerclients[0]['tot'],3, '.', ' ') ;
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
                <td ><?php     echo @$raisondeperdes[@$affaire['Affaire']['raisondeperde_id']]; ?></td>
                <td ><?php     echo @$affaire['Affaire']['note']; ?></td>
		<td align="center">
                <a  onclick="recap_sutiation_affaire(<?php echo $affaire['Affaire']['id']; ?>)" href="#reModal_refuser" champ="order" id="order<?php echo $affaire['Affaire']['id']; ?>"><button title='Situiation' class='btn btn-xs btn-success'><i class='fa fa-refresh'></i></button></a>
			<?php echo $this->Html->link("<button title='Visite' class='btn btn-xs ls-blue-btn'><i class='fa fa-briefcase'></i></button>", array('action' => 'visite', $affaire['Affaire']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $affaire['Affaire']['id']),array('escape' => false)); ?>
			<?php if($edit==1){ echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $affaire['Affaire']['id']),array('escape' => false)); } ?>
			<?php if($delete==1){ echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $affaire['Affaire']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $affaire['Affaire']['id'])); } ?>
		</td>
	</tr>
                      
<?php endforeach; ?>
        <tfoot>
        <td colspan="5"> Total</td>
        <td><?php echo number_format($totale_tout,3, '.', ' '); ?></td>
        <td><?php echo number_format($total_gagner,3, '.', ' '); ?></td>
        </tfoot>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


<div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="pop">
                      
                        
                    </div>
                    <br>
                    <a  onclick="misajoursituationaffaires()" class="remodal-confirm ls-light-green-btn btn " ><strong>OK</strong></a>
                    
</div>