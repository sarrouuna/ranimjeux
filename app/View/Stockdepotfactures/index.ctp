<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Stockdepotfactures/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Stockdepotfactures'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Factureclient_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Stockdepot_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Qte'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($stockdepotfactures as $stockdepotfacture): ?>
	<tr>
		<td style="display:none"><?php echo h($stockdepotfacture['Stockdepotfacture']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($stockdepotfacture['Factureclient']['name'], array('controller' => 'factureclients', 'action' => 'view', $stockdepotfacture['Factureclient']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($stockdepotfacture['Stockdepot']['id'], array('controller' => 'stockdepots', 'action' => 'view', $stockdepotfacture['Stockdepot']['id'])); ?>
		</td>
		<td ><?php echo h($stockdepotfacture['Stockdepotfacture']['qte']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $stockdepotfacture['Stockdepotfacture']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $stockdepotfacture['Stockdepotfacture']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $stockdepotfacture['Stockdepotfacture']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $stockdepotfacture['Stockdepotfacture']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


