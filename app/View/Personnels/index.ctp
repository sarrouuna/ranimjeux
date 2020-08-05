
 <?php $add="";$edit="";$delete="";$imprimer=""; 
$lien=  CakeSession::read('lien_parametrage');
//debug($lien_stock);die;
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='personnels'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}
} 
if($add==1){?>


<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Personnels/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<?php }?>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Personnels'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th style="display: none;"><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fonction_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Nom et prénom'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Adresse'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Tel'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Mail'); ?></th>
                <th><?php echo $this->Paginator->sort('Societe'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($personnels as $personnel): ?>
	<tr>
		<td style="display:none"><?php echo h($personnel['Personnel']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($personnel['Fonction']['name'], array('controller' => 'fonctions', 'action' => 'view', $personnel['Fonction']['id'])); ?>
		</td>
		<td ><?php echo h($personnel['Personnel']['name']); ?>&nbsp;</td>
		<td ><?php echo h($personnel['Personnel']['adresse']); ?>&nbsp;</td>
		<td ><?php echo h($personnel['Personnel']['tel']); ?>&nbsp;</td>
		<td ><?php echo h($personnel['Personnel']['mail']); ?>&nbsp;</td>
                <td >
			<?php echo $this->Html->link($personnel['Societe']['name'], array('controller' => 'personnels', 'action' => 'view', $personnel['Societe']['id'])); ?>
		</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $personnel['Personnel']['id']),array('escape' => false)); ?>
                        <?php if($edit==1) {echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $personnel['Personnel']['id']),array('escape' => false)); }?>
                        <?php if($delete==1) { echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $personnel['Personnel']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $personnel['Personnel']['id'])); }?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


