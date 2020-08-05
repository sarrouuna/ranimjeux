<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Tracemisejours/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Tracemisejours'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Model'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Id_piece'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Operation'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Utilisateur_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Date'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Heure'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($tracemisejours as $tracemisejour): ?>
	<tr>
		<td style="display:none"><?php echo h($tracemisejour['Tracemisejour']['id']); ?>&nbsp;</td>
		<td ><?php echo h($tracemisejour['Tracemisejour']['model']); ?>&nbsp;</td>
		<td ><?php echo h($tracemisejour['Tracemisejour']['id_piece']); ?>&nbsp;</td>
		<td ><?php echo h($tracemisejour['Tracemisejour']['operation']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($tracemisejour['Utilisateur']['name'], array('controller' => 'utilisateurs', 'action' => 'view', $tracemisejour['Utilisateur']['id'])); ?>
		</td>
		<td ><?php echo h($tracemisejour['Tracemisejour']['date']); ?>&nbsp;</td>
		<td ><?php echo h($tracemisejour['Tracemisejour']['heure']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $tracemisejour['Tracemisejour']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $tracemisejour['Tracemisejour']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $tracemisejour['Tracemisejour']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $tracemisejour['Tracemisejour']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


