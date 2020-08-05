<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Situationpiecereglementclients/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Situationpiecereglementclients'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Date'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Agio'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Piecereglement_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Situation'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Utilisateur_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Datemodification'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($situationpiecereglementclients as $situationpiecereglementclient): ?>
	<tr>
		<td style="display:none"><?php echo h($situationpiecereglementclient['Situationpiecereglementclient']['id']); ?>&nbsp;</td>
		<td ><?php echo h($situationpiecereglementclient['Situationpiecereglementclient']['date']); ?>&nbsp;</td>
		<td ><?php echo h($situationpiecereglementclient['Situationpiecereglementclient']['agio']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($situationpiecereglementclient['Piecereglement']['id'], array('controller' => 'piecereglements', 'action' => 'view', $situationpiecereglementclient['Piecereglement']['id'])); ?>
		</td>
		<td ><?php echo h($situationpiecereglementclient['Situationpiecereglementclient']['situation']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($situationpiecereglementclient['Utilisateur']['name'], array('controller' => 'utilisateurs', 'action' => 'view', $situationpiecereglementclient['Utilisateur']['id'])); ?>
		</td>
		<td ><?php echo h($situationpiecereglementclient['Situationpiecereglementclient']['datemodification']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $situationpiecereglementclient['Situationpiecereglementclient']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $situationpiecereglementclient['Situationpiecereglementclient']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $situationpiecereglementclient['Situationpiecereglementclient']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $situationpiecereglementclient['Situationpiecereglementclient']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


