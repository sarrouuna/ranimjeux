<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Lignedeviprospects/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Lignedeviprospects'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Deviprospect_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Quantite'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Datefabrication'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Datevalidite'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Numerolot'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Prixhtva'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Prix'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Remise'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fodec'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Tva'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalht'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalttc'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($lignedeviprospects as $lignedeviprospect): ?>
	<tr>
		<td style="display:none"><?php echo h($lignedeviprospect['Lignedeviprospect']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignedeviprospect['Deviprospect']['id'], array('controller' => 'deviprospects', 'action' => 'view', $lignedeviprospect['Deviprospect']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($lignedeviprospect['Article']['nom'], array('controller' => 'articles', 'action' => 'view', $lignedeviprospect['Article']['id'])); ?>
		</td>
		<td ><?php echo h($lignedeviprospect['Lignedeviprospect']['quantite']); ?>&nbsp;</td>
		<td ><?php echo h($lignedeviprospect['Lignedeviprospect']['datefabrication']); ?>&nbsp;</td>
		<td ><?php echo h($lignedeviprospect['Lignedeviprospect']['datevalidite']); ?>&nbsp;</td>
		<td ><?php echo h($lignedeviprospect['Lignedeviprospect']['numerolot']); ?>&nbsp;</td>
		<td ><?php echo h($lignedeviprospect['Lignedeviprospect']['prixhtva']); ?>&nbsp;</td>
		<td ><?php echo h($lignedeviprospect['Lignedeviprospect']['prix']); ?>&nbsp;</td>
		<td ><?php echo h($lignedeviprospect['Lignedeviprospect']['remise']); ?>&nbsp;</td>
		<td ><?php echo h($lignedeviprospect['Lignedeviprospect']['fodec']); ?>&nbsp;</td>
		<td ><?php echo h($lignedeviprospect['Lignedeviprospect']['tva']); ?>&nbsp;</td>
		<td ><?php echo h($lignedeviprospect['Lignedeviprospect']['totalht']); ?>&nbsp;</td>
		<td ><?php echo h($lignedeviprospect['Lignedeviprospect']['totalttc']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $lignedeviprospect['Lignedeviprospect']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $lignedeviprospect['Lignedeviprospect']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $lignedeviprospect['Lignedeviprospect']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $lignedeviprospect['Lignedeviprospect']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


