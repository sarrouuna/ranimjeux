<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Lignefactureavoirfrs/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Lignefactureavoirfrs'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Factureavoirfr_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Depot_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Quantite'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Prix'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Prixnet'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Puttc'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalhtans'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Remise'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fodec'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Tva'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalht'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalttc'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($lignefactureavoirfrs as $lignefactureavoirfr): ?>
	<tr>
		<td style="display:none"><?php echo h($lignefactureavoirfr['Lignefactureavoirfr']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignefactureavoirfr['Factureavoirfr']['id'], array('controller' => 'factureavoirfrs', 'action' => 'view', $lignefactureavoirfr['Factureavoirfr']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($lignefactureavoirfr['Depot']['nom'], array('controller' => 'depots', 'action' => 'view', $lignefactureavoirfr['Depot']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($lignefactureavoirfr['Article']['nom'], array('controller' => 'articles', 'action' => 'view', $lignefactureavoirfr['Article']['id'])); ?>
		</td>
		<td ><?php echo h($lignefactureavoirfr['Lignefactureavoirfr']['quantite']); ?>&nbsp;</td>
		<td ><?php echo h($lignefactureavoirfr['Lignefactureavoirfr']['prix']); ?>&nbsp;</td>
		<td ><?php echo h($lignefactureavoirfr['Lignefactureavoirfr']['prixnet']); ?>&nbsp;</td>
		<td ><?php echo h($lignefactureavoirfr['Lignefactureavoirfr']['puttc']); ?>&nbsp;</td>
		<td ><?php echo h($lignefactureavoirfr['Lignefactureavoirfr']['totalhtans']); ?>&nbsp;</td>
		<td ><?php echo h($lignefactureavoirfr['Lignefactureavoirfr']['remise']); ?>&nbsp;</td>
		<td ><?php echo h($lignefactureavoirfr['Lignefactureavoirfr']['fodec']); ?>&nbsp;</td>
		<td ><?php echo h($lignefactureavoirfr['Lignefactureavoirfr']['tva']); ?>&nbsp;</td>
		<td ><?php echo h($lignefactureavoirfr['Lignefactureavoirfr']['totalht']); ?>&nbsp;</td>
		<td ><?php echo h($lignefactureavoirfr['Lignefactureavoirfr']['totalttc']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $lignefactureavoirfr['Lignefactureavoirfr']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $lignefactureavoirfr['Lignefactureavoirfr']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $lignefactureavoirfr['Lignefactureavoirfr']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $lignefactureavoirfr['Lignefactureavoirfr']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


