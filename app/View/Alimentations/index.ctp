<?php $add="";$edit="";$delete="";$imprimer=""; 
$lien=  CakeSession::read('lien_finance');
//debug($lien_achat);die;
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='alimentations'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}
       
} 
if($add==1){?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Alimentations/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    <?php }?>
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Alimentations caisse'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
		<th><?php echo $this->Paginator->sort('Numero'); ?></th>
                
		<th><?php echo $this->Paginator->sort('Date'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Souche chequier'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Cheque_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Echance'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Montant'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($alimentations as $alimentation): ?>
	<tr>
		<td >
			<?php echo $this->Html->link($alimentation['Alimentation']['numero'], array('controller' => 'alimentations', 'action' => 'view', $alimentation['Alimentation']['id'])); ?>
                </td>

                <td ><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',$alimentation['Alimentation']['date'])))); ?>&nbsp;</td>

                <td >
			<?php echo $this->Html->link($alimentation['Carnetcheque']['numero'], array('controller' => 'carnetcheques', 'action' => 'view', $alimentation['Carnetcheque']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($alimentation['Cheque']['numero'], array('controller' => 'cheques', 'action' => 'view', $alimentation['Cheque']['id'])); ?>
		</td>
		<td ><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',$alimentation['Alimentation']['echance'])))); ?>&nbsp;</td>
		<td ><?php echo h($alimentation['Alimentation']['montant']); ?>&nbsp;</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $alimentation['Alimentation']['id']),array('escape' => false)); ?>
                        <?php if($edit==1){ echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $alimentation['Alimentation']['id']),array('escape' => false)); }?>
                        <?php if($delete==1){ echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $alimentation['Alimentation']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $alimentation['Alimentation']['id'])); }?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


