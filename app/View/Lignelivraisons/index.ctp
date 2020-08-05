<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Lignelivraisons/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Lignelivraisons'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Bonlivraison_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Quantite'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Datefabrication'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Datevalidite'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Prix'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Remise'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fodec'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Tva'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalht'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalttc'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($lignelivraisons as $lignelivraison): ?>
	<tr>
		<td style="display:none"><?php echo h($lignelivraison['Lignelivraison']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignelivraison['Bonlivraison']['id'], array('controller' => 'bonlivraisons', 'action' => 'view', $lignelivraison['Bonlivraison']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($lignelivraison['Article']['name'], array('controller' => 'articles', 'action' => 'view', $lignelivraison['Article']['id'])); ?>
		</td>
		<td ><?php echo h($lignelivraison['Lignelivraison']['quantite']); ?>&nbsp;</td>
		<td ><?php echo h($lignelivraison['Lignelivraison']['datefabrication']); ?>&nbsp;</td>
		<td ><?php echo h($lignelivraison['Lignelivraison']['datevalidite']); ?>&nbsp;</td>
		<td ><?php echo h($lignelivraison['Lignelivraison']['prix']); ?>&nbsp;</td>
		<td ><?php echo h($lignelivraison['Lignelivraison']['remise']); ?>&nbsp;</td>
		<td ><?php echo h($lignelivraison['Lignelivraison']['fodec']); ?>&nbsp;</td>
		<td ><?php echo h($lignelivraison['Lignelivraison']['tva']); ?>&nbsp;</td>
		<td ><?php echo h($lignelivraison['Lignelivraison']['totalht']); ?>&nbsp;</td>
		<td ><?php echo h($lignelivraison['Lignelivraison']['totalttc']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $lignelivraison['Lignelivraison']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $lignelivraison['Lignelivraison']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $lignelivraison['Lignelivraison']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $lignelivraison['Lignelivraison']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


