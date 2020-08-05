<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Historiquearticles/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Historiquearticles'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Client'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fournisseur'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Utilisateur'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Date'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Type'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Numero'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Qte'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Pu'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Ptot'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Mode'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($historiquearticles as $historiquearticle): ?>
	<tr>
		<td style="display:none"><?php echo h($historiquearticle['Historiquearticle']['id']); ?>&nbsp;</td>
		<td ><?php echo h($historiquearticle['Historiquearticle']['client']); ?>&nbsp;</td>
		<td ><?php echo h($historiquearticle['Historiquearticle']['fournisseur']); ?>&nbsp;</td>
		<td ><?php echo h($historiquearticle['Historiquearticle']['utilisateur']); ?>&nbsp;</td>
		<td ><?php echo h($historiquearticle['Historiquearticle']['date']); ?>&nbsp;</td>
		<td ><?php echo h($historiquearticle['Historiquearticle']['type']); ?>&nbsp;</td>
		<td ><?php echo h($historiquearticle['Historiquearticle']['numero']); ?>&nbsp;</td>
		<td ><?php echo h($historiquearticle['Historiquearticle']['article']); ?>&nbsp;</td>
		<td ><?php echo h($historiquearticle['Historiquearticle']['qte']); ?>&nbsp;</td>
		<td ><?php echo h($historiquearticle['Historiquearticle']['pu']); ?>&nbsp;</td>
		<td ><?php echo h($historiquearticle['Historiquearticle']['ptot']); ?>&nbsp;</td>
		<td ><?php echo h($historiquearticle['Historiquearticle']['mode']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $historiquearticle['Historiquearticle']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $historiquearticle['Historiquearticle']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $historiquearticle['Historiquearticle']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $historiquearticle['Historiquearticle']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


