<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Lignesortidetails/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Lignesortidetails'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Lignesorti_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Stockdepot_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Quantite'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Date'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($lignesortidetails as $lignesortidetail): ?>
	<tr>
		<td style="display:none"><?php echo h($lignesortidetail['Lignesortidetail']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lignesortidetail['Lignesorti']['id'], array('controller' => 'lignesortis', 'action' => 'view', $lignesortidetail['Lignesorti']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($lignesortidetail['Stockdepot']['id'], array('controller' => 'stockdepots', 'action' => 'view', $lignesortidetail['Stockdepot']['id'])); ?>
		</td>
		<td ><?php echo h($lignesortidetail['Lignesortidetail']['quantite']); ?>&nbsp;</td>
		<td ><?php echo h($lignesortidetail['Lignesortidetail']['date']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $lignesortidetail['Lignesortidetail']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $lignesortidetail['Lignesortidetail']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $lignesortidetail['Lignesortidetail']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $lignesortidetail['Lignesortidetail']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


