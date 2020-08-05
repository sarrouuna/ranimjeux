<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Lignereglements/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Lignereglements'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Reglement_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Montant'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Facture_id'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($lignereglements as $lignereglement): ?>
	<tr>
		<td style="display:none"><?php echo h($lignereglement['Lignereglement']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignereglement['Reglement']['id'], array('controller' => 'reglements', 'action' => 'view', $lignereglement['Reglement']['id'])); ?>
		</td>
		<td ><?php echo h($lignereglement['Lignereglement']['Montant']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignereglement['Facture']['id'], array('controller' => 'factures', 'action' => 'view', $lignereglement['Facture']['id'])); ?>
		</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $lignereglement['Lignereglement']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $lignereglement['Lignereglement']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $lignereglement['Lignereglement']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $lignereglement['Lignereglement']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


