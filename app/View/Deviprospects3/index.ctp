<?php $add="";$edit="";$delete="";$imprimer="";
$lien=  CakeSession::read('lien_achat');
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='deviprospects'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}

  
} 
if($add==1){?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Deviprospects/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<?php }?>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Suggestion Commande'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fournisseur_id'); ?></th>
	        <th><?php echo $this->Paginator->sort('Importation_id'); ?></th> 
		<th style="display:none"><?php echo $this->Paginator->sort('Utilisateur_id'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Depot_id'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Facture_id'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Etat'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Numero'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Coefficient'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Numeroconca'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Date'); ?></th>
	         
	         
		<th><?php echo $this->Paginator->sort('Tva'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Montant en devise'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalht'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalttc'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Pointdevente_id'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Exercice_id'); ?></th>
                <th class="actions" align="center"></th>
		<th class="actions" align="center"></th>
        </tr>
                      </thead><tbody>
	<?php 
    //debug($deviprospects);
        foreach ($deviprospects as $i=>$deviprospect): ?>
	<tr>
		<td style="display:none"><?php echo h($deviprospect['Deviprospect']['id']); ?></td>
		<td >
			<?php echo $this->Html->link($deviprospect['Fournisseur']['name'], array('controller' => 'fournisseurs', 'action' => 'view', $deviprospect['Fournisseur']['id'])); ?>
		</td>
                <td >
			<?php echo $this->Html->link($deviprospect['Importation']['name'], array('controller' => 'importations', 'action' => 'view', $deviprospect['Importation']['id'])); ?>
		</td>
		<td style="display:none">
			<?php echo $this->Html->link($deviprospect['Utilisateur']['name'], array('controller' => 'utilisateurs', 'action' => 'view', $deviprospect['Utilisateur']['id'])); ?>
		</td>
		<td style="display:none">
			<?php echo $this->Html->link($deviprospect['Depot']['nom'], array('controller' => 'depots', 'action' => 'view', $deviprospect['Depot']['id'])); ?>
		</td>
		<td style="display:none">
			<?php echo $this->Html->link($deviprospect['Facture']['id'], array('controller' => 'factures', 'action' => 'view', $deviprospect['Facture']['id'])); ?>
		</td>
		<td style="display:none"><?php echo h($deviprospect['Deviprospect']['etat']); ?></td>
		<td ><?php echo h($deviprospect['Deviprospect']['numero']); ?></td>
		<td ><?php echo sprintf('%.3f',h($deviprospect['Deviprospect']['coefficient'])); ?></td>
		<td style="display:none"><?php echo h($deviprospect['Deviprospect']['numeroconca']); ?></td>
		<td ><?php echo date("d-m-Y",strtotime(str_replace('/','-',h($deviprospect['Deviprospect']['date'])))); ?></td>
		<td ><?php echo h($deviprospect['Deviprospect']['tva']); ?></td>
		<td ><?php echo h($deviprospect['Deviprospect']['montantdevise']); ?></td>
		<td ><?php echo h($deviprospect['Deviprospect']['totalht']); ?></td>
		<td ><?php echo h($deviprospect['Deviprospect']['totalttc']); ?></td>
		<td style="display:none">
			<?php echo $this->Html->link($deviprospect['Pointdevente']['name'], array('controller' => 'pointdeventes', 'action' => 'view', $deviprospect['Pointdevente']['id'])); ?>
		</td>
		<td style="display:none">
			<?php echo $this->Html->link($deviprospect['Exercice']['name'], array('controller' => 'exercices', 'action' => 'view', $deviprospect['Exercice']['id'])); ?>
		</td>
                <td>
                <?php if(($deviprospect['Deviprospect']['trasfert']==0)&&($deviprospect['Deviprospect']['etat']==1)){?>
                <center>
                <?php echo $this->Html->link("<button class='btn btn-xs btn-danger'><i class='fa fa-check'></i></button>", array('controller'=>'Commandes','action' => 'addfromdevis', $deviprospect['Deviprospect']['id']),array('escape' => false)); ?>
                </center>
                <?php } ?>
                </td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $deviprospect['Deviprospect']['id']),array('escape' => false)); ?>
			<?php if(($deviprospect['Deviprospect']['trasfert']==0)){?>
                        <?php if($edit==1){ echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $deviprospect['Deviprospect']['id']),array('escape' => false)); }?>
                        <?php if($delete==1){echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $deviprospect['Deviprospect']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $deviprospect['Deviprospect']['id'])); }?>
                        <?php } ?>
                <?php if($imprimer==1){ ?>    <a onClick="flvFPW1(wr+'Deviprospects/imprimer/'+<?php  echo  $deviprospect['Deviprospect']['id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a><?php } ?>
                <?php if($imprimer==1){ ?>    <a onClick="flvFPW1(wr+'Deviprospects/exp_etatexcel/'+<?php  echo  $deviprospect['Deviprospect']['id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-red-btn'><i class='fa fa-print'></i></button></a><?php } ?>
                </td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


