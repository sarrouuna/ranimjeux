<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Situations/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Situations'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Namesituation_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Datedebut'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Datefin'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Nbrjour'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Importation_id'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($situations as $situation): ?>
	<tr>
		<td style="display:none"><?php echo h($situation['Situation']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($situation['Namesituation']['name'], array('controller' => 'namesituations', 'action' => 'view', $situation['Namesituation']['id'])); ?>
		</td>
		<td ><?php echo h($situation['Situation']['datedebut']); ?>&nbsp;</td>
		<td ><?php echo h($situation['Situation']['datefin']); ?>&nbsp;</td>
		<td ><?php echo h($situation['Situation']['nbrjour']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($situation['Importation']['name'], array('controller' => 'importations', 'action' => 'view', $situation['Importation']['id'])); ?>
		</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $situation['Situation']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $situation['Situation']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $situation['Situation']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $situation['Situation']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


