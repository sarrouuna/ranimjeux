

 <?php $add="";$edit="";$delete="";$imprimer=""; 
$lien=  CakeSession::read('lien_parametrage');
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='societes'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}
} 
?>



<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Societes/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>

<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Societes'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
            <th style="display:none"><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Nom'); ?></th>
	         
		
	         
		<th><?php echo $this->Paginator->sort('Adresse'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Tel'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Mail'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Site'); ?></th>	         
	         
		<th><?php echo $this->Paginator->sort('Fax'); ?></th>
	         
	         
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($societes as $societe): ?>
	<tr>
		<td style="display:none"><?php echo h($societe['Societe']['id']); ?>&nbsp;</td>
		<td ><?php echo h($societe['Societe']['nom']); ?>&nbsp;</td>
		<td ><?php echo h($societe['Societe']['adresse']); ?>&nbsp;</td>
		<td ><?php echo h($societe['Societe']['tel']); ?>&nbsp;</td>
		<td ><?php echo h($societe['Societe']['mail']); ?>&nbsp;</td>
		<td ><?php echo h($societe['Societe']['site']); ?>&nbsp;</td>
		<td ><?php echo h($societe['Societe']['fax']); ?>&nbsp;</td>
		
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $societe['Societe']['id']),array('escape' => false)); ?>
			<?php if($edit==1) {  echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $societe['Societe']['id']),array('escape' => false)); } ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


