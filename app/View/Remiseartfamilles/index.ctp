<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Remiseartfamilles/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Remiseartfamilles'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Famille_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Remise'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($remiseartfamilles as $remiseartfamille): ?>
	<tr>
		<td style="display:none"><?php echo h($remiseartfamille['Remiseartfamille']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($remiseartfamille['Article']['name'], array('controller' => 'articles', 'action' => 'view', $remiseartfamille['Article']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($remiseartfamille['Famille']['name'], array('controller' => 'familles', 'action' => 'view', $remiseartfamille['Famille']['id'])); ?>
		</td>
		<td ><?php echo h($remiseartfamille['Remiseartfamille']['remise']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $remiseartfamille['Remiseartfamille']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $remiseartfamille['Remiseartfamille']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $remiseartfamille['Remiseartfamille']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $remiseartfamille['Remiseartfamille']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


