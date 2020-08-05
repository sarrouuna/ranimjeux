<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Liens/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Liens'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Utilisateurmenu_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Lien'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Add'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Edit'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Delete'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Imprimer'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($liens as $lien): ?>
	<tr>
		<td style="display:none"><?php echo h($lien['Lien']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($lien['Utilisateurmenu']['id'], array('controller' => 'utilisateurmenus', 'action' => 'view', $lien['Utilisateurmenu']['id'])); ?>
		</td>
		<td ><?php echo h($lien['Lien']['lien']); ?>&nbsp;</td>
		<td ><?php echo h($lien['Lien']['add']); ?>&nbsp;</td>
		<td ><?php echo h($lien['Lien']['edit']); ?>&nbsp;</td>
		<td ><?php echo h($lien['Lien']['delete']); ?>&nbsp;</td>
		<td ><?php echo h($lien['Lien']['imprimer']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $lien['Lien']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $lien['Lien']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $lien['Lien']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $lien['Lien']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


