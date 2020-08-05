


<div class="table">
    <div class="head"><h5 class="iFrames"><?php echo __('Ticketcaisselignes');?></h5></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                                    <th>id</th>
                                    <th>ticketcaisse_id</th>
                                    <th>article_id</th>
                                    <th>prix</th>
                                    <th>qte</th>
                                    <th>montant</th>
                                    <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
	foreach ($ticketcaisselignes as $ticketcaisseligne): ?>
<tr class='gradeX'>
		<td><?php echo h($ticketcaisseligne['Ticketcaisseligne']['id']); ?></td>
		<td><?php echo h($ticketcaisseligne['Ticketcaisseligne']['ticketcaisse_id']); ?></td>
		<td><?php echo h($ticketcaisseligne['Ticketcaisseligne']['article_id']); ?></td>
		<td><?php echo h($ticketcaisseligne['Ticketcaisseligne']['prix']); ?></td>
		<td><?php echo h($ticketcaisseligne['Ticketcaisseligne']['qte']); ?></td>
		<td><?php echo h($ticketcaisseligne['Ticketcaisseligne']['montant']); ?></td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->image('browse.gif'), array('action' => 'view', $ticketcaisseligne['Ticketcaisseligne']['id']),array('escape' => false)); ?>
			<?php echo $this->Html->link($this->Html->image('edit1.gif'), array('action' => 'edit', $ticketcaisseligne['Ticketcaisseligne']['id']),array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Html->image('delete.png'), array('action' => 'delete', $ticketcaisseligne['Ticketcaisseligne']['id']),array('escape' => false, null), __('Are you sure you want to delete # %s?', $ticketcaisseligne['Ticketcaisseligne']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
 </tbody>        </tbody>
    </table>
</div>
