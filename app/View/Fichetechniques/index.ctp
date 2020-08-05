<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Fichetechniques/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Fichetechniques'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Date'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Numero'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Exercice_id'); ?></th>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Utilisateur_id'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($fichetechniques as $fichetechnique): ?>
	<tr>
		<td style="display:none"><?php echo h($fichetechnique['Fichetechnique']['id']); ?></td>
		<td >
			<?php echo $this->Html->link($articles[$fichetechnique['Fichetechnique']['nvarticle']], array('controller' => 'articles', 'action' => 'view', $fichetechnique['Fichetechnique']['nvarticle'])); ?>
		</td>
		<td ><?php echo  date("d-m-Y",strtotime(str_replace('/','-',$fichetechnique['Fichetechnique']['date'])));?></td>
		<td ><?php echo h($fichetechnique['Fichetechnique']['numero']); ?></td>
		<td style="display:none">
			<?php echo $this->Html->link($fichetechnique['Exercice']['name'], array('controller' => 'exercices', 'action' => 'view', $fichetechnique['Exercice']['id'])); ?>
		</td>
		<td style="display:none">
			<?php echo $this->Html->link($fichetechnique['Utilisateur']['name'], array('controller' => 'utilisateurs', 'action' => 'view', $fichetechnique['Utilisateur']['id'])); ?>
		</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $fichetechnique['Fichetechnique']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $fichetechnique['Fichetechnique']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $fichetechnique['Fichetechnique']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $fichetechnique['Fichetechnique']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


