<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Cartefidelites/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Cartefidelites'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
            <th style="display: none"><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Numero'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Nom et Prenom'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('CIN'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Tel'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Mail'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Adresse'); ?></th>
	         
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($cartefidelites as $cartefidelite): ?>
	<tr>
		<td style="display:none"><?php echo h($cartefidelite['Cartefidelite']['id']); ?></td>
		<td ><?php echo h($cartefidelite['Cartefidelite']['numero']); ?></td>
		<td ><?php echo h($cartefidelite['Cartefidelite']['nomprenom']); ?></td>
		<td ><?php echo h($cartefidelite['Cartefidelite']['CIN']); ?></td>
		<td ><?php echo h($cartefidelite['Cartefidelite']['Tel']); ?></td>
		<td ><?php echo h($cartefidelite['Cartefidelite']['Mail']); ?></td>
		
		<td ><?php echo h($cartefidelite['Cartefidelite']['Adresse']); ?></td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $cartefidelite['Cartefidelite']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $cartefidelite['Cartefidelite']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $cartefidelite['Cartefidelite']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $cartefidelite['Cartefidelite']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


