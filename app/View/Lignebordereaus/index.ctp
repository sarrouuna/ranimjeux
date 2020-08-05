<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Lignebordereaus/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Lignebordereaus'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Bordereau_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Banque'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Rib'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Montant'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($lignebordereaus as $lignebordereau): ?>
	<tr>
		<td style="display:none"><?php echo h($lignebordereau['Lignebordereau']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignebordereau['Bordereau']['id'], array('controller' => 'bordereaus', 'action' => 'view', $lignebordereau['Bordereau']['id'])); ?>
		</td>
		<td ><?php echo h($lignebordereau['Lignebordereau']['banque']); ?>&nbsp;</td>
		<td ><?php echo h($lignebordereau['Lignebordereau']['rib']); ?>&nbsp;</td>
		<td ><?php echo h($lignebordereau['Lignebordereau']['montant']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $lignebordereau['Lignebordereau']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $lignebordereau['Lignebordereau']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $lignebordereau['Lignebordereau']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $lignebordereau['Lignebordereau']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


