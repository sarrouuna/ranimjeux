<?php $add="";$edit="";$delete="";$imprimer=""; 
$lien=  CakeSession::read('lien_finance');
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='versements'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}
       
} 
if($add==1){?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Versements/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<?php }?>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Versements'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Numero'); ?></th>

                
                <th><?php echo $this->Paginator->sort('observation'); ?></th>
                 
		<th><?php echo $this->Paginator->sort('Banque'); ?></th>
	         

		<th><?php echo $this->Paginator->sort('Date'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Montant'); ?></th>
	         
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($versements as $versement): ?>
	<tr>
		<td ><?php echo h($versement['Versement']['numero']); ?></td>
                <td ><?php echo h($versement['Versement']['observation']); ?></td>
		
                <td ><?php echo h($versement['Compte']['banque']); ?></td>
		
		<td ><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',$versement['Versement']['date'])))); ?></td>
		<td ><?php echo h($versement['Versement']['montant']); ?></td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $versement['Versement']['id']),array('escape' => false)); ?>
                        <?php if($edit==1) { echo $this->Html->link("<button class='btn btn-xs btn-danger'><i class='fa fa-check'></i></button>", array('action' => 'valider', $versement['Versement']['id']),array('escape' => false)); }?>
                        <?php if(($versement['Versement']['etat']==0)&($edit==1)){ echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $versement['Versement']['id']),array('escape' => false));} ?>
                        <?php if($delete==1) { echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $versement['Versement']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $versement['Versement']['id']));} ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


