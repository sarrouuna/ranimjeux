<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Lignereceptions/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Lignereceptions'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Bonreception_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Quantite'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Datefabrication'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Datevalidite'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Numerolot'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Prixhtva'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Remise'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fodec'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Tva'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalht'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalttc'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($lignereceptions as $lignereception): ?>
	<tr>
		<td style="display:none"><?php echo h($lignereception['Lignereception']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignereception['Bonreception']['id'], array('controller' => 'bonreceptions', 'action' => 'view', $lignereception['Bonreception']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($lignereception['Article']['name'], array('controller' => 'articles', 'action' => 'view', $lignereception['Article']['id'])); ?>
		</td>
		<td ><?php echo h($lignereception['Lignereception']['quantite']); ?>&nbsp;</td>
		<td ><?php echo h($lignereception['Lignereception']['datefabrication']); ?>&nbsp;</td>
		<td ><?php echo h($lignereception['Lignereception']['datevalidite']); ?>&nbsp;</td>
		<td ><?php echo h($lignereception['Lignereception']['numerolot']); ?>&nbsp;</td>
		<td ><?php echo h($lignereception['Lignereception']['prixhtva']); ?>&nbsp;</td>
		<td ><?php echo h($lignereception['Lignereception']['remise']); ?>&nbsp;</td>
		<td ><?php echo h($lignereception['Lignereception']['fodec']); ?>&nbsp;</td>
		<td ><?php echo h($lignereception['Lignereception']['tva']); ?>&nbsp;</td>
		<td ><?php echo h($lignereception['Lignereception']['totalht']); ?>&nbsp;</td>
		<td ><?php echo h($lignereception['Lignereception']['totalttc']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $lignereception['Lignereception']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $lignereception['Lignereception']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $lignereception['Lignereception']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $lignereception['Lignereception']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


