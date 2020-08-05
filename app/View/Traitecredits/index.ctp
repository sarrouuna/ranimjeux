
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Traite credits'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th style="display:none"><?php echo ('Id'); ?></th>
	         
	         
		<th><?php echo ('Fournisseur'); ?></th>
	         
		<th><?php echo ('Importation'); ?></th>
                
		<th><?php echo ('Piece reglement'); ?></th>
	         
<!--		<th><?php echo ('Num piece'); ?></th>
	         
		<th><?php echo ('Echance'); ?></th>
	         
		<th><?php echo ('Montant'); ?></th>-->
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($traitecredits as $traitecredit): 
        $obj = ClassRegistry::init('Situationpiecereglement');
        $pieces = $obj->find('first', array( 'conditions' => array('Situationpiecereglement.etatpiecereglement_id' =>9,'Situationpiecereglement.piecereglement_id  ' => $traitecredit['Piecereglement']['id']),'order'=>array('Situationpiecereglement.id'=>'desc')));    
        //debug($pieces);die;    
        ?>
	<tr>
		<td style="display:none"><?php echo h($traitecredit['Traitecredit']['id']); ?></td>
		

		<td >
			<?php echo $this->Html->link($traitecredit['Fournisseur']['name'], array('controller' => 'fournisseurs', 'action' => 'view', $traitecredit['Fournisseur']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($traitecredit['Importation']['name'], array('controller' => 'importations', 'action' => 'view', $traitecredit['Importation']['id'])); ?>
		</td>
                <td>
			<?php echo $this->Html->link($pieces['Situationpiecereglement']['montant'], array('controller' => 'piecereglements', 'action' => 'view', $traitecredit['Piecereglement']['id'])); ?>
		</td>
<!--		<td ><?php echo h($traitecredit['Traitecredit']['num_piececredit']); ?></td>
		<td ><?php echo h($traitecredit['Traitecredit']['echancecredit']); ?></td>
		<td ><?php echo h($traitecredit['Traitecredit']['montantcredit']); ?></td>-->
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $traitecredit['Piecereglement']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $traitecredit['Piecereglement']['id']),array('escape' => false)); ?>
			<?php //echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $traitecredit['Piecereglement']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $traitecredit['Traitecredit']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


