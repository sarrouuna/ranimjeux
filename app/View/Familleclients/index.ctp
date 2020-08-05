 <?php $add="";$edit="";$delete="";$imprimer=""; 
$lien=  CakeSession::read('lien_vente');
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='familleclients'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}
} 
if($add==1){?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Familleclients/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>  
</div>
<?php }?>
<br><input type="hidden" id="page" value="1"/>

<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Famille clients'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<td style="display:none"><?php echo $this->Paginator->sort('Id'); ?></td>
		<td align="center"><?php echo $this->Paginator->sort('Code'); ?></td>
		<td align="center"><?php echo $this->Paginator->sort('Designation'); ?></td>
	        <td class="actions" align="center"></td>
        </tr></thead><tbody>
	<?php foreach ($familleclients as $familleclient): ?>
	<tr>
		<td style="display:none"><?php echo h($familleclient['Familleclient']['id']); ?></td>
		<td ><?php echo h($familleclient['Familleclient']['code']); ?></td>
		<td ><?php echo h($familleclient['Familleclient']['name']); ?></td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $familleclient['Familleclient']['id']),array('escape' => false)); ?>
                        <?php if($edit==1){ echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $familleclient['Familleclient']['id']),array('escape' => false)); }?>
                        <?php if($delete==1){ echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $familleclient['Familleclient']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $familleclient['Familleclient']['id'])); }?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


