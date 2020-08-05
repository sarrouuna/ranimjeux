<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Tabetatcaparpersonnels/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Tabetatcaparpersonnels'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Clientid'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Name'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Articleid'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Article'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Qte'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Tot'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Por'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($tabetatcaparpersonnels as $tabetatcaparpersonnel): ?>
	<tr>
		<td style="display:none"><?php echo h($tabetatcaparpersonnel['Tabetatcaparpersonnel']['id']); ?>&nbsp;</td>
		<td ><?php echo h($tabetatcaparpersonnel['Tabetatcaparpersonnel']['clientid']); ?>&nbsp;</td>
		<td ><?php echo h($tabetatcaparpersonnel['Tabetatcaparpersonnel']['name']); ?>&nbsp;</td>
		<td ><?php echo h($tabetatcaparpersonnel['Tabetatcaparpersonnel']['articleid']); ?>&nbsp;</td>
		<td ><?php echo h($tabetatcaparpersonnel['Tabetatcaparpersonnel']['article']); ?>&nbsp;</td>
		<td ><?php echo h($tabetatcaparpersonnel['Tabetatcaparpersonnel']['qte']); ?>&nbsp;</td>
		<td ><?php echo h($tabetatcaparpersonnel['Tabetatcaparpersonnel']['tot']); ?>&nbsp;</td>
		<td ><?php echo h($tabetatcaparpersonnel['Tabetatcaparpersonnel']['por']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $tabetatcaparpersonnel['Tabetatcaparpersonnel']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $tabetatcaparpersonnel['Tabetatcaparpersonnel']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $tabetatcaparpersonnel['Tabetatcaparpersonnel']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $tabetatcaparpersonnel['Tabetatcaparpersonnel']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


