<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Exonorationclients/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Exonorationclients'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Client_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Datedu'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Dateau'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Num_exe'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($exonorationclients as $exonorationclient): ?>
	<tr>
		<td><?php echo h($exonorationclient['Exonorationclient']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($exonorationclient['Client']['nom'], array('controller' => 'clients', 'action' => 'view', $exonorationclient['Client']['id'])); ?>
		</td>
		<td><?php echo h($exonorationclient['Exonorationclient']['datedu']); ?>&nbsp;</td>
		<td><?php echo h($exonorationclient['Exonorationclient']['dateau']); ?>&nbsp;</td>
		<td><?php echo h($exonorationclient['Exonorationclient']['num_exe']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $exonorationclient['Exonorationclient']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $exonorationclient['Exonorationclient']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $exonorationclient['Exonorationclient']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $exonorationclient['Exonorationclient']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


