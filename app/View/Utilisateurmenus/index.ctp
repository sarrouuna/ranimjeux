<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Utilisateurmenus/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Utilisateurmenus'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Utilisateur_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Menu_id'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($utilisateurmenus as $utilisateurmenu): ?>
	<tr>
		<td style="display:none"><?php echo h($utilisateurmenu['Utilisateurmenu']['id']); ?>&nbsp;</td>
		<td >
			<?php echo $this->Html->link($utilisateurmenu['Utilisateur']['name'], array('controller' => 'utilisateurs', 'action' => 'view', $utilisateurmenu['Utilisateur']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($utilisateurmenu['Menu']['name'], array('controller' => 'menus', 'action' => 'view', $utilisateurmenu['Menu']['id'])); ?>
		</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $utilisateurmenu['Utilisateurmenu']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $utilisateurmenu['Utilisateurmenu']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $utilisateurmenu['Utilisateurmenu']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $utilisateurmenu['Utilisateurmenu']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


