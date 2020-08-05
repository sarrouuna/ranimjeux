<script language="JavaScript">

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}

</script>
<?php $add="";$edit="";$delete="";$imprimer="";
$lien=  CakeSession::read('lien_achat');
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='importations'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}

  
} 
if($add==1){?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Importations/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
</div>
<?php }?>
<br><input type="hidden" id="page" value="1"/>
<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Importation',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
              	<?php 
		echo $this->Form->input('date1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>'Date de') ); 
		echo $this->Form->input('fournisseur_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Fournisseur','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('namesituation_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Situation','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
</div>
<div class="col-md-6">
<?php
                echo $this->Form->input('verif',array('id'=>'verif','type'=>'hidden','value'=>0,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'Ã ") ); 
		echo $this->Form->input('cloture_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Type','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                //echo $this->Form->input('exercice_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'année','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));

?>
 
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
<!--                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                 <a class="btn btn-primary" href="<?php echo $this->webroot;?>Importations/index"/>Afficher Tout </a>-->
                    <button type="submit" class="btn btn-primary btntras" id="aff">Chercher</button>  
                        <button type="submit" class="btn btn-primary btntras" id="afftt">Afficher tout</button>  
             <?php if($imprimer==1){ ?>      <a  onClick="flvFPW1(wr+'Importations/imprimerrecherche?fournisseurid=<?php echo @$fournisseurid;?>&date1=<?php echo @$date1;?>&veriff=<?php echo @$veriff;?>&date2=<?php echo @$date2;?>&clotureid=<?php echo @$clotureid;?>&namesituationid=<?php echo @$namesituationid;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a><?php }?>
                   
                   

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
                                    <h3 class="panel-title"><?php echo __('Importations'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Désignation'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Numero'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Date'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fournisseur_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Devise_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('M A'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('C D'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Prix achat'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Avis'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Transitaire'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Ddttva'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Assurence'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Divers'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('F F'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totale'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Coefficient'); ?></th>
                <th><?php echo $this->Paginator->sort('Situation'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php //debug($importations); 
                 foreach ($importations as $importation): 
                     
        $obj = ClassRegistry::init('Namesituation');
        $test = $obj->find('first',array('conditions'=>array('Namesituation.id'=>$importation['Situation']['namesituation_id']),'recursive'=>-1));     
        //debug($test);             
                     ?>
	<tr>
		<td style="display:none"><?php echo h($importation['Importation']['id']); ?></td>
		<td ><?php echo h($importation['Importation']['name']); ?></td>
		<td ><?php echo h($importation['Importation']['numero']); ?></td>
		<td ><?php echo date("d/m/Y",strtotime(str_replace('/','/',$importation['Importation']['date']))); ?></td>
		<td >
			<?php echo $this->Html->link($importation['Fournisseur']['name'], array('controller' => 'fournisseurs', 'action' => 'view', $importation['Fournisseur']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($importation['Devise']['name'], array('controller' => 'devises', 'action' => 'view', $importation['Devise']['id'])); ?>
		</td>
		<td ><?php echo sprintf('%.3f', h($importation['Importation']['montantachat'])); ?></td>
		<td ><?php echo h($importation['Importation']['tauxderechenge']); ?></td>
		<td style="display:none"><?php echo h($importation['Importation']['prixachat']); ?></td>
		<td style="display:none"><?php echo sprintf('%.3f',h($importation['Importation']['avis'])); ?></td>
		<td style="display:none"><?php echo sprintf('%.3f',h($importation['Importation']['transitaire'])); ?></td>
		<td style="display:none"><?php echo sprintf('%.3f',h($importation['Importation']['ddttva'])); ?></td>
		<td style="display:none"><?php echo sprintf('%.3f',h($importation['Importation']['assurence'])); ?></td>
		<td style="display:none"><?php echo sprintf('%.3f',h($importation['Importation']['divers'])); ?></td>
		<td style="display:none"><?php echo sprintf('%.3f',h($importation['Importation']['fraisfinancie'])); ?></td>
		<td ><?php echo sprintf('%.3f',h($importation['Importation']['totale'])); ?></td>
		<td align="right"><?php echo sprintf('%.3f',h($importation['Importation']['coefficien'])); ?></td>
                <td >
			<?php echo $this->Html->link(@$test['Namesituation']['name'], array('controller' => 'situations', 'action' => 'view', $importation['Situation']['id'])); ?>
		</td>
<!--                <td align="left">&nbsp;<?php echo @$test['Namesituation']['name']; ?></td>-->
		<td align="center">
                    <?php if ($importation['Importation']['etat']==0){ ?>
                    <span title="Cloturer"><?php echo $this->Form->postLink("<button class='btn btn-xs ls-light-green-btn'><i class='fa fa-files-o'></i></button>", array('action' => 'cloture', $importation['Importation']['id']),array('escape' => false,null), __('Veuillez vraiment fermer cette Importation # %s?', $importation['Importation']['id'])); ?></span>
                    <?php } ?>
                        <?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $importation['Importation']['id']),array('escape' => false)); ?>
			<?php if($edit==1){echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $importation['Importation']['id']),array('escape' => false)); }?>
			<?php if($delete==1){echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $importation['Importation']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $importation['Importation']['id'])); }?>
                    <?php if ($importation['Importation']['facturer']==0){ ?>    
                    <?php echo $this->Html->link("<button title='créer les factures' class='btn btn-xs btn-primary'><i class='fa fa-file-archive-o'></i></button>", array('action' => 'view', $importation['Importation']['id'],"t"),array('escape' => false)); ?>
                    <?php } ?>
                </td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


