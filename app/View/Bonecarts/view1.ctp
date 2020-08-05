<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Bonecarts/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Bon d\'écarts'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th style="display:none"><?php echo ('Id'); ?></th>
	         
		<th style="display:none"><?php echo ('Inventaire_id'); ?></th>
	         
		<th ><?php echo ('Article'); ?></th>
	         
		<th style="display:none"><?php echo ('Depot_id'); ?></th>
	         
		<th ><?php echo ('Qte anc'); ?></th>
	         
		<th ><?php echo ('Qte nv'); ?></th>
	         
		<th ><?php echo ('écart'); ?></th>
	         
		<th ><?php echo ('Prix'); ?></th>
	         
		<th ><?php echo ('Prix tot'); ?></th>
			
        </tr></thead><tbody>
	<?php 
        $tot=0;
        foreach ($bonecarts as $bonecart): 
        $tot=$tot+$bonecart['Bonecart']['prixtot'];   
            ?>
	<tr>
		<td style="display:none"><?php echo h($bonecart['Bonecart']['id']); ?></td>
		<td style="display:none">
			<?php echo $this->Html->link($bonecart['Inventaire']['numero'], array('controller' => 'inventaires', 'action' => 'view', $bonecart['Inventaire']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($bonecart['Article']['nom'], array('controller' => 'articles', 'action' => 'view', $bonecart['Article']['id'])); ?>
		</td>
		<td style="display:none">
			<?php echo $this->Html->link($bonecart['Depot']['nom'], array('controller' => 'depots', 'action' => 'view', $bonecart['Depot']['id'])); ?>
		</td>
		<td><?php echo h($bonecart['Bonecart']['qteanc']); ?></td>
		<td ><?php echo h($bonecart['Bonecart']['qtenv']); ?></td>
		<td ><?php echo h($bonecart['Bonecart']['quantite']); ?></td>
		<td ><?php echo h($bonecart['Bonecart']['prix']); ?></td>
		<td><?php echo h($bonecart['Bonecart']['prixtot']); ?></td>
		
	</tr>
<?php endforeach; ?>
                      <tfoot>
                      <td colspan="5" align="center"><strong>Totale</strong></td><td><strong><?php echo number_format($tot,3, '.', ' ') ?></strong></td>
                      </tfoot>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


