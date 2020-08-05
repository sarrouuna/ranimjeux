
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ticket Caisse'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th style="display: none;"><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Numero'); ?></th>
	       <th><?php echo $this->Paginator->sort('Client'); ?></th>
               <th><?php echo $this->Paginator->sort('Depot'); ?></th>
		<th><?php echo $this->Paginator->sort('Date'); ?></th>
		<th><?php echo $this->Paginator->sort('Montant'); ?></th>
                <th><?php echo $this->Paginator->sort('Etat'); ?></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($ticketcaiss as $ticketcaiss): ?>
	<tr>
		<td style="display: none;"><?php echo h($ticketcaiss['Ticketcaiss']['id']); ?></td>
		<td><?php echo h($ticketcaiss['Ticketcaiss']['Numero']); ?></td>
		<td><?php echo h($ticketcaiss['Client']['name']); ?></td>
		<td><?php echo h($ticketcaiss['Depot']['designation']); ?></td>
                <td><?php echo h(date('d/m/Y', strtotime(str_replace('-', '/',$ticketcaiss['Ticketcaiss']['Date'])))); ?></td>
		<td><?php echo h($ticketcaiss['Ticketcaiss']['Total_TTC']); ?></td>
                <td>
                    <?php 
                        if($ticketcaiss['Ticketcaiss']['enattente']==1){
                            echo 'En attente';
                        }else{
                            echo '';
                        }
                    ?>
                </td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $ticketcaiss['Ticketcaiss']['id']),array('escape' => false)); ?>
                        <?php  echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $ticketcaiss['Ticketcaiss']['id']),array('escape' => false)); ?>
                        <?php  echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $ticketcaiss['Ticketcaiss']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $ticketcaiss['Ticketcaiss']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


