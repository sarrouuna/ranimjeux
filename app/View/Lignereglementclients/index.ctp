<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Lignereglementclients/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Lignereglementclients'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Reglementclient_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Montant'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Factureclient_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Remise'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($lignereglementclients as $lignereglementclient): ?>
	<tr>
		<td style="display:none"><?php echo h($lignereglementclient['Lignereglementclient']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignereglementclient['Reglementclient']['id'], array('controller' => 'reglementclients', 'action' => 'view', $lignereglementclient['Reglementclient']['id'])); ?>
		</td>
		<td ><?php echo h($lignereglementclient['Lignereglementclient']['Montant']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignereglementclient['Factureclient']['id'], array('controller' => 'factureclients', 'action' => 'view', $lignereglementclient['Factureclient']['id'])); ?>
		</td>
		<td ><?php echo h($lignereglementclient['Lignereglementclient']['remise']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $lignereglementclient['Lignereglementclient']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $lignereglementclient['Lignereglementclient']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $lignereglementclient['Lignereglementclient']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $lignereglementclient['Lignereglementclient']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


