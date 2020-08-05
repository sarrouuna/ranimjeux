<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Lignedevis/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Lignedevis'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Devi_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Qauntite'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Prix'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Remise'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fodec'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Tva'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalht'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalttc'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($lignedevis as $lignedevi): ?>
	<tr>
		<td style="display:none"><?php echo h($lignedevi['Lignedevi']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignedevi['Devi']['id'], array('controller' => 'devis', 'action' => 'view', $lignedevi['Devi']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($lignedevi['Article']['name'], array('controller' => 'articles', 'action' => 'view', $lignedevi['Article']['id'])); ?>
		</td>
		<td ><?php echo h($lignedevi['Lignedevi']['qauntite']); ?>&nbsp;</td>
		<td ><?php echo h($lignedevi['Lignedevi']['prix']); ?>&nbsp;</td>
		<td ><?php echo h($lignedevi['Lignedevi']['remise']); ?>&nbsp;</td>
		<td ><?php echo h($lignedevi['Lignedevi']['fodec']); ?>&nbsp;</td>
		<td ><?php echo h($lignedevi['Lignedevi']['tva']); ?>&nbsp;</td>
		<td ><?php echo h($lignedevi['Lignedevi']['totalht']); ?>&nbsp;</td>
		<td ><?php echo h($lignedevi['Lignedevi']['totalttc']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $lignedevi['Lignedevi']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $lignedevi['Lignedevi']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $lignedevi['Lignedevi']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $lignedevi['Lignedevi']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


