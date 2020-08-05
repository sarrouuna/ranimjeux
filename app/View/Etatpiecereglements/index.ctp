<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Etatpiecereglements/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Etat piece reglements'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Désignation'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($etatpiecereglements as $etatpiecereglement): ?>
	<tr>
		<td style="display:none"><?php echo h($etatpiecereglement['Etatpiecereglement']['id']); ?>&nbsp;</td>
		<td ><?php echo h($etatpiecereglement['Etatpiecereglement']['name']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $etatpiecereglement['Etatpiecereglement']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $etatpiecereglement['Etatpiecereglement']['id']),array('escape' => false)); ?>
			<?php if(($etatpiecereglement['Etatpiecereglement']['id'] !=1)&&($etatpiecereglement['Etatpiecereglement']['id'] !=2)&&($etatpiecereglement['Etatpiecereglement']['id'] !=3)){ ?>
                        <?php //echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $etatpiecereglement['Etatpiecereglement']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $etatpiecereglement['Etatpiecereglement']['id'])); ?>
                        <?php } ?>
                </td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


