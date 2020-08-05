<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Lignefactureclients/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Lignefactureclients'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Factureclient_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Quantite'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Prix'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Remise'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fodec'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Tva'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalht'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalttc'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($lignefactureclients as $lignefactureclient): ?>
	<tr>
		<td style="display:none"><?php echo h($lignefactureclient['Lignefactureclient']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignefactureclient['Factureclient']['id'], array('controller' => 'factureclients', 'action' => 'view', $lignefactureclient['Factureclient']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($lignefactureclient['Article']['name'], array('controller' => 'articles', 'action' => 'view', $lignefactureclient['Article']['id'])); ?>
		</td>
		<td ><?php echo h($lignefactureclient['Lignefactureclient']['quantite']); ?>&nbsp;</td>
		<td ><?php echo h($lignefactureclient['Lignefactureclient']['prix']); ?>&nbsp;</td>
		<td ><?php echo h($lignefactureclient['Lignefactureclient']['remise']); ?>&nbsp;</td>
		<td ><?php echo h($lignefactureclient['Lignefactureclient']['fodec']); ?>&nbsp;</td>
		<td ><?php echo h($lignefactureclient['Lignefactureclient']['tva']); ?>&nbsp;</td>
		<td ><?php echo h($lignefactureclient['Lignefactureclient']['totalht']); ?>&nbsp;</td>
		<td ><?php echo h($lignefactureclient['Lignefactureclient']['totalttc']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $lignefactureclient['Lignefactureclient']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $lignefactureclient['Lignefactureclient']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $lignefactureclient['Lignefactureclient']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $lignefactureclient['Lignefactureclient']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


