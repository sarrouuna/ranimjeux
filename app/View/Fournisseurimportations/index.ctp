<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Fournisseurimportations/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Fournisseurimportations'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fournisseur_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Montant'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Importation_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Name'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($fournisseurimportations as $fournisseurimportation): ?>
	<tr>
		<td style="display:none"><?php echo h($fournisseurimportation['Fournisseurimportation']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($fournisseurimportation['Fournisseur']['name'], array('controller' => 'fournisseurs', 'action' => 'view', $fournisseurimportation['Fournisseur']['id'])); ?>
		</td>
		<td ><?php echo h($fournisseurimportation['Fournisseurimportation']['montant']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($fournisseurimportation['Importation']['name'], array('controller' => 'importations', 'action' => 'view', $fournisseurimportation['Importation']['id'])); ?>
		</td>
		<td ><?php echo h($fournisseurimportation['Fournisseurimportation']['name']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $fournisseurimportation['Fournisseurimportation']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $fournisseurimportation['Fournisseurimportation']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $fournisseurimportation['Fournisseurimportation']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $fournisseurimportation['Fournisseurimportation']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


