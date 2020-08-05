 <?php $add="";$edit="";$delete="";$imprimer=""; 
$lien=  CakeSession::read('lien_parametrage');
//debug($lien_stock);die;
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='pointdeventes'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}
} 
if($add==1){?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Pointdeventes/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
     <?php } ?> 
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Point de ventes'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Id'); ?></th>
	        <th>Designation</th> 
		<th><?php echo $this->Paginator->sort('Abriviation'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Adresse'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Ville'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Responsable'); ?></th>
                <th><?php echo $this->Paginator->sort('Societe'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php //debug($pointdeventes);
        foreach ($pointdeventes as $pointdevente): ?>
	<tr>
		<td style="display:none"><?php echo h($pointdevente['Pointdevente']['id']); ?></td>
                <td ><?php echo h($pointdevente['Pointdevente']['name']); ?></td>
		<td ><?php echo h($pointdevente['Pointdevente']['abriviation']); ?></td>
		<td ><?php echo h($pointdevente['Pointdevente']['adresse']); ?></td>
		<td ><?php echo h($pointdevente['Pointdevente']['ville']); ?></td>
		<td >
			<?php echo $this->Html->link($pointdevente['Personnel']['name'], array('controller' => 'personnels', 'action' => 'view', $pointdevente['Personnel']['id'])); ?>
		</td>
                <td >
			<?php echo $this->Html->link($pointdevente['Societe']['name'], array('controller' => 'personnels', 'action' => 'view', $pointdevente['Societe']['id'])); ?>
		</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $pointdevente['Pointdevente']['id']),array('escape' => false)); ?>
                        <?php if($edit==1) { echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $pointdevente['Pointdevente']['id']),array('escape' => false));} ?>
                        <?php  if($delete==1) {echo $this->Form->postLink("<button value=".$pointdevente['Pointdevente']['id']." class='btn btn-xs btn-danger testpvutiliser'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $pointdevente['Pointdevente']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $pointdevente['Pointdevente']['id']));} ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


