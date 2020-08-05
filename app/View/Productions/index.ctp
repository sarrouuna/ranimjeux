<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Productions/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Productions'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Depot arrive'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Qte'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Date'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Numero'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Exercice_id'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Utilisateur_id'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($productions as $production): ?>
	<tr>
		<td style="display:none"><?php echo h($production['Production']['id']); ?></td>
		<td ><?php echo $articles[$production['Production']['nvarticle']]; ?></td>
		<td ><?php echo $depots[$production['Production']['depotarrive']]; ?></td>
		<td ><?php echo h($production['Production']['qte']); ?></td>
		<td ><?php echo h($production['Production']['date']); ?></td>
		<td ><?php echo h($production['Production']['numero']); ?></td>
		<td style="display:none">
			<?php echo $this->Html->link($production['Exercice']['name'], array('controller' => 'exercices', 'action' => 'view', $production['Exercice']['id'])); ?>
		</td>
		<td style="display:none">
			<?php echo $this->Html->link($production['Utilisateur']['name'], array('controller' => 'utilisateurs', 'action' => 'view', $production['Utilisateur']['id'])); ?>
		</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $production['Production']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $production['Production']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $production['Production']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $production['Production']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


