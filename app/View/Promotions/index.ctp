<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Promotions/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Promotions'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
            <th style="display: none"><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		
	         <th>Numero</th>
                 <th>Designation</th>
		<th><?php echo $this->Paginator->sort('Date debut'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Date fin'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($promotions as $promotion): ?>
	<tr>
		<td style="display:none"><?php echo h($promotion['Promotion']['id']); ?></td>
		<td ><?php echo h($promotion['Promotion']['numero']); ?></td>
                <td ><?php echo h($promotion['Promotion']['designation']); ?></td>
		<td ><?php echo h($promotion['Promotion']['datedebut']); ?></td>
		<td ><?php echo h($promotion['Promotion']['datefin']); ?></td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $promotion['Promotion']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $promotion['Promotion']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $promotion['Promotion']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $promotion['Promotion']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


