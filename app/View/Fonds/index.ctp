


<div class="table">
    <div class="head"><h5 class="iFrames"><?php echo __('Fonds');?></h5></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                                    <th>id</th>
                                    <th>date</th>
                                    <th>utilisateur_id</th>
                                    <th>Fond</th>
                                    <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
	foreach ($Fonds as $Fond): ?>
<tr class='gradeX'>
		<td><?php echo h($Fond['Fond']['id']); ?></td>
		<td><?php echo h($Fond['Fond']['date']); ?></td>
		<td><?php echo h($Fond['Utilisateur']['Login']); ?></td>
		<td><?php echo h($Fond['Fond']['fond']); ?></td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->image('browse.gif'), array('action' => 'view', $Fond['Fond']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link($this->Html->image('edit1.gif'), array('action' => 'edit', $Fond['Fond']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Html->image('delete.png'), array('action' => 'delete', $Fond['Fond']['id']),array('escape' => false), null, __('Are you sure you want to delete # %s?', $Fond['Fond']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
 </tbody>        </tbody>
    </table>
</div>
