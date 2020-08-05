


<fieldset>

    <div class="widget first">
        <div class="head"><h5 class="iList"><?php echo __('Consultation   Ticketcaisseligne'); ?></h5></div>
    

    <?php echo $this->Form->create('Ticketcaisseligne',array('class'=>'mainForm'));?>
        		 <div class='rowElem'>	
                                 <label><?php echo __('Id'); ?></label>	
                                  <div  class='formRight'>	
                                  
			<?php echo h($ticketcaisseligne['Ticketcaisseligne']['id']); ?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>			 <div class='rowElem'>	
                                 <label><?php echo __('Ticketcaisse'); ?></label>	
                                  <div class='formRight'>
                                  
			<?php echo 
                                  $this->Html->link($ticketcaisseligne['Ticketcaisse']['id'], array('controller' => 'ticketcaisses', 'action' => 'view', $ticketcaisseligne['Ticketcaisse']['id'])); ?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>			 <div class='rowElem'>	
                                 <label><?php echo __('Article'); ?></label>	
                                  <div class='formRight'>
                                  
			<?php echo 
                                  $this->Html->link($ticketcaisseligne['Article']['Designation'], array('controller' => 'articles', 'action' => 'view', $ticketcaisseligne['Article']['id'])); ?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>			 <div class='rowElem'>	
                                 <label><?php echo __('Prix'); ?></label>	
                                  <div  class='formRight'>	
                                  
			<?php echo h($ticketcaisseligne['Ticketcaisseligne']['prix']); ?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>			 <div class='rowElem'>	
                                 <label><?php echo __('Qte'); ?></label>	
                                  <div  class='formRight'>	
                                  
			<?php echo h($ticketcaisseligne['Ticketcaisseligne']['qte']); ?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>			 <div class='rowElem'>	
                                 <label><?php echo __('Montant'); ?></label>	
                                  <div  class='formRight'>	
                                  
			<?php echo h($ticketcaisseligne['Ticketcaisseligne']['montant']); ?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>	
  <?php echo $this->Form->end();?>
</div>

</fieldset>