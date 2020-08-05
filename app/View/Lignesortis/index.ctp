<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Lignesortis/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Lignesortis'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Bonsorti_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Depot_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Quantite'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Lignelivraison_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Lignefacture_id'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($lignesortis as $lignesorti): ?>
	<tr>
		<td style="display:none"><?php echo h($lignesorti['Lignesorti']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignesorti['Bonsorti']['id'], array('controller' => 'bonsortis', 'action' => 'view', $lignesorti['Bonsorti']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($lignesorti['Article']['name'], array('controller' => 'articles', 'action' => 'view', $lignesorti['Article']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($lignesorti['Depot']['id'], array('controller' => 'depots', 'action' => 'view', $lignesorti['Depot']['id'])); ?>
		</td>
		<td ><?php echo h($lignesorti['Lignesorti']['quantite']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignesorti['Lignelivraison']['id'], array('controller' => 'lignelivraisons', 'action' => 'view', $lignesorti['Lignelivraison']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($lignesorti['Lignefacture']['id'], array('controller' => 'lignefactures', 'action' => 'view', $lignesorti['Lignefacture']['id'])); ?>
		</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $lignesorti['Lignesorti']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $lignesorti['Lignesorti']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $lignesorti['Lignesorti']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $lignesorti['Lignesorti']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


