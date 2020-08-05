<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Ligneentres/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligneentres'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Bonentre_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Depot_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Stockdepot_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Quantite'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Lignereception_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Lignefacture_id'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($ligneentres as $ligneentre): ?>
	<tr>
		<td style="display:none"><?php echo h($ligneentre['Ligneentre']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($ligneentre['Bonentre']['id'], array('controller' => 'bonentres', 'action' => 'view', $ligneentre['Bonentre']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($ligneentre['Article']['name'], array('controller' => 'articles', 'action' => 'view', $ligneentre['Article']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($ligneentre['Depot']['id'], array('controller' => 'depots', 'action' => 'view', $ligneentre['Depot']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($ligneentre['Stockdepot']['id'], array('controller' => 'stockdepots', 'action' => 'view', $ligneentre['Stockdepot']['id'])); ?>
		</td>
		<td ><?php echo h($ligneentre['Ligneentre']['quantite']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($ligneentre['Lignereception']['id'], array('controller' => 'lignereceptions', 'action' => 'view', $ligneentre['Lignereception']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($ligneentre['Lignefacture']['id'], array('controller' => 'lignefactures', 'action' => 'view', $ligneentre['Lignefacture']['id'])); ?>
		</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $ligneentre['Ligneentre']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $ligneentre['Ligneentre']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $ligneentre['Ligneentre']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $ligneentre['Ligneentre']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


