<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Contacts/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Contacts'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fournisseur_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Client_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Name'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fonction'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Tel'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Mail'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($contacts as $contact): ?>
	<tr>
		<td style="display:none"><?php echo h($contact['Contact']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($contact['Fournisseur']['name'], array('controller' => 'fournisseurs', 'action' => 'view', $contact['Fournisseur']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($contact['Client']['name'], array('controller' => 'clients', 'action' => 'view', $contact['Client']['id'])); ?>
		</td>
		<td ><?php echo h($contact['Contact']['name']); ?>&nbsp;</td>
		<td ><?php echo h($contact['Contact']['fonction']); ?>&nbsp;</td>
		<td ><?php echo h($contact['Contact']['tel']); ?>&nbsp;</td>
		<td ><?php echo h($contact['Contact']['mail']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $contact['Contact']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $contact['Contact']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $contact['Contact']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $contact['Contact']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


