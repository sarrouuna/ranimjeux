<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Situationpiecereglements/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Situationpiecereglements'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Date'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Agio'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Etatpiecereglement_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Piecereglement_id'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($situationpiecereglements as $situationpiecereglement): ?>
	<tr>
		<td style="display:none"><?php echo h($situationpiecereglement['Situationpiecereglement']['id']); ?>&nbsp;</td>
		<td ><?php echo h($situationpiecereglement['Situationpiecereglement']['date']); ?>&nbsp;</td>
		<td ><?php echo h($situationpiecereglement['Situationpiecereglement']['agio']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($situationpiecereglement['Etatpiecereglement']['name'], array('controller' => 'etatpiecereglements', 'action' => 'view', $situationpiecereglement['Etatpiecereglement']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($situationpiecereglement['Piecereglement']['id'], array('controller' => 'piecereglements', 'action' => 'view', $situationpiecereglement['Piecereglement']['id'])); ?>
		</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $situationpiecereglement['Situationpiecereglement']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $situationpiecereglement['Situationpiecereglement']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $situationpiecereglement['Situationpiecereglement']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $situationpiecereglement['Situationpiecereglement']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


