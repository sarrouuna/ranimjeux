<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Lignevalides/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Lignevalides'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Ligneworkflow_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Id_piece'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Document_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Personnel_id'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($lignevalides as $lignevalide): ?>
	<tr>
		<td style="display:none"><?php echo h($lignevalide['Lignevalide']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignevalide['Ligneworkflow']['id'], array('controller' => 'ligneworkflows', 'action' => 'view', $lignevalide['Ligneworkflow']['id'])); ?>
		</td>
		<td ><?php echo h($lignevalide['Lignevalide']['id_piece']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignevalide['Document']['name'], array('controller' => 'documents', 'action' => 'view', $lignevalide['Document']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($lignevalide['Personnel']['name'], array('controller' => 'personnels', 'action' => 'view', $lignevalide['Personnel']['id'])); ?>
		</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $lignevalide['Lignevalide']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $lignevalide['Lignevalide']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $lignevalide['Lignevalide']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $lignevalide['Lignevalide']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


