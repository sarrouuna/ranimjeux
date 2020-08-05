<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Lignebonsortiestocks/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Lignebonsortiestocks'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Depot_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Quantite'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Bonsortiestock_id'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($lignebonsortiestocks as $lignebonsortiestock): ?>
	<tr>
		<td style="display:none"><?php echo h($lignebonsortiestock['Lignebonsortiestock']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignebonsortiestock['Depot']['nom'], array('controller' => 'depots', 'action' => 'view', $lignebonsortiestock['Depot']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($lignebonsortiestock['Article']['nom'], array('controller' => 'articles', 'action' => 'view', $lignebonsortiestock['Article']['id'])); ?>
		</td>
		<td ><?php echo h($lignebonsortiestock['Lignebonsortiestock']['quantite']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignebonsortiestock['Bonsortiestock']['id'], array('controller' => 'bonsortiestocks', 'action' => 'view', $lignebonsortiestock['Bonsortiestock']['id'])); ?>
		</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $lignebonsortiestock['Lignebonsortiestock']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $lignebonsortiestock['Lignebonsortiestock']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $lignebonsortiestock['Lignebonsortiestock']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $lignebonsortiestock['Lignebonsortiestock']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


