<div class="row">
<!--    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Historiquesuggcddes/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    -->
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Historique Suggestion Commande'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Date'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Utilisateur_id'); ?></th>
	         <th><?php echo $this->Paginator->sort('Deviprospect_id'); ?></th>
		<th><?php echo $this->Paginator->sort('Lignedeviprospect_id'); ?></th>
	         
		
	         
		<th><?php echo $this->Paginator->sort('Reference'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Quantite'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Prix'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Prixhtva'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Tva'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Remise'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fodec'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalht'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Totalttc'); ?></th>
		
			<!--<th class="actions" align="center"></th>-->
        </tr></thead><tbody>
	<?php foreach ($historiquesuggcddes as $historiquesuggcdde): ?>
        <tr <?php if(h($historiquesuggcdde['Historiquesuggcdde']['supp'])==1){?> style='background-color:#D2322D '<?php } ?>>
		<td style="display:none"><?php echo h($historiquesuggcdde['Historiquesuggcdde']['id']); ?></td>
		<td ><?php echo h($historiquesuggcdde['Historiquesuggcdde']['date']); ?></td>
		<td >
			<?php echo $this->Html->link($historiquesuggcdde['Utilisateur']['name'], array('controller' => 'utilisateurs', 'action' => 'view', $historiquesuggcdde['Utilisateur']['id'])); ?>
		</td>
                <td >
			<?php echo $this->Html->link($historiquesuggcdde['Deviprospect']['numero'], array('controller' => 'deviprospects', 'action' => 'view', $historiquesuggcdde['Deviprospect']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($historiquesuggcdde['Lignedeviprospect']['id'], array('controller' => 'lignedeviprospects', 'action' => 'view', $historiquesuggcdde['Lignedeviprospect']['id'])); ?>
		</td>
		
		<td ><?php echo h($historiquesuggcdde['Historiquesuggcdde']['reference']); ?></td>
		<td ><?php echo h($historiquesuggcdde['Historiquesuggcdde']['quantite']); ?></td>
		<td ><?php echo h($historiquesuggcdde['Historiquesuggcdde']['prix']); ?></td>
		<td ><?php echo h($historiquesuggcdde['Historiquesuggcdde']['prixhtva']); ?></td>
		<td ><?php echo h($historiquesuggcdde['Historiquesuggcdde']['tva']); ?></td>
		<td ><?php echo h($historiquesuggcdde['Historiquesuggcdde']['remise']); ?></td>
		<td ><?php echo h($historiquesuggcdde['Historiquesuggcdde']['fodec']); ?></td>
		<td ><?php echo h($historiquesuggcdde['Historiquesuggcdde']['totalht']); ?></td>
		<td ><?php echo h($historiquesuggcdde['Historiquesuggcdde']['totalttc']); ?></td>
<!--		<td align="center">
			<?php //echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $historiquesuggcdde['Historiquesuggcdde']['id']),array('escape' => false)); ?>
			<?php //echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $historiquesuggcdde['Historiquesuggcdde']['id']),array('escape' => false)); ?>
			<?php// echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $historiquesuggcdde['Historiquesuggcdde']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $historiquesuggcdde['Historiquesuggcdde']['id'])); ?>
		</td>-->
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


