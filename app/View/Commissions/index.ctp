<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Commissions/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Commissions'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Personnel_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Famille_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Sousfamille_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Soussousfamille_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Montantapartir'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Commission'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($commissions as $commission): ?>
	<tr>
		<td style="display:none"><?php echo h($commission['Commission']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($commission['Personnel']['name'], array('controller' => 'personnels', 'action' => 'view', $commission['Personnel']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($commission['Article']['nom'], array('controller' => 'articles', 'action' => 'view', $commission['Article']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($commission['Famille']['name'], array('controller' => 'familles', 'action' => 'view', $commission['Famille']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($commission['Sousfamille']['name'], array('controller' => 'sousfamilles', 'action' => 'view', $commission['Sousfamille']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($commission['Soussousfamille']['name'], array('controller' => 'soussousfamilles', 'action' => 'view', $commission['Soussousfamille']['id'])); ?>
		</td>
		<td ><?php echo h($commission['Commission']['montantapartir']); ?>&nbsp;</td>
		<td ><?php echo h($commission['Commission']['commission']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $commission['Commission']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $commission['Commission']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $commission['Commission']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $commission['Commission']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


