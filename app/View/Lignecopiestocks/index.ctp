<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Lignecopiestocks/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Lignecopiestocks'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Copiestockdepot_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Depot_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Quantite'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Prix'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Existe'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($lignecopiestocks as $lignecopiestock): ?>
	<tr>
		<td style="display:none"><?php echo h($lignecopiestock['Lignecopiestock']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignecopiestock['Copiestockdepot']['id'], array('controller' => 'copiestockdepots', 'action' => 'view', $lignecopiestock['Copiestockdepot']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($lignecopiestock['Article']['nom'], array('controller' => 'articles', 'action' => 'view', $lignecopiestock['Article']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($lignecopiestock['Depot']['nom'], array('controller' => 'depots', 'action' => 'view', $lignecopiestock['Depot']['id'])); ?>
		</td>
		<td ><?php echo h($lignecopiestock['Lignecopiestock']['quantite']); ?>&nbsp;</td>
		<td ><?php echo h($lignecopiestock['Lignecopiestock']['prix']); ?>&nbsp;</td>
		<td ><?php echo h($lignecopiestock['Lignecopiestock']['existe']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $lignecopiestock['Lignecopiestock']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $lignecopiestock['Lignecopiestock']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $lignecopiestock['Lignecopiestock']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $lignecopiestock['Lignecopiestock']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


