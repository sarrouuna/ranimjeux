<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Tracemodificationprixdeventes/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Tracemodificationprixdeventes'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Utilisateur_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Date'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Heure'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Prixventeans'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Margeans'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Prixventenv'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Margenv'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($tracemodificationprixdeventes as $tracemodificationprixdevente): ?>
	<tr>
		<td style="display:none"><?php echo h($tracemodificationprixdevente['Tracemodificationprixdevente']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($tracemodificationprixdevente['Utilisateur']['name'], array('controller' => 'utilisateurs', 'action' => 'view', $tracemodificationprixdevente['Utilisateur']['id'])); ?>
		</td>
		<td ><?php echo h($tracemodificationprixdevente['Tracemodificationprixdevente']['date']); ?>&nbsp;</td>
		<td ><?php echo h($tracemodificationprixdevente['Tracemodificationprixdevente']['heure']); ?>&nbsp;</td>
		<td ><?php echo h($tracemodificationprixdevente['Tracemodificationprixdevente']['prixventeans']); ?>&nbsp;</td>
		<td ><?php echo h($tracemodificationprixdevente['Tracemodificationprixdevente']['margeans']); ?>&nbsp;</td>
		<td ><?php echo h($tracemodificationprixdevente['Tracemodificationprixdevente']['prixventenv']); ?>&nbsp;</td>
		<td ><?php echo h($tracemodificationprixdevente['Tracemodificationprixdevente']['margenv']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $tracemodificationprixdevente['Tracemodificationprixdevente']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $tracemodificationprixdevente['Tracemodificationprixdevente']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $tracemodificationprixdevente['Tracemodificationprixdevente']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $tracemodificationprixdevente['Tracemodificationprixdevente']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


