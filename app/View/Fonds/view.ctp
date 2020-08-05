


<fieldset>

    <div class="widget first">
        <div class="head"><h5 class="iList"><?php echo __('Consultation   Fond'); ?></h5></div>
    

    <?php echo $this->Form->create('Fond',array('class'=>'mainForm'));?>
        		 <div class='rowElem'>	
                                 <label><?php echo __('Id'); ?></label>	
                                  <div  class='formRight'>	
                                  
			<?php echo h($Fond['Fond']['id']); ?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>			 <div class='rowElem'>	
                                 <label><?php echo __('Utilisateur'); ?></label>	
                                  <div class='formRight'>
                                  
			<?php echo 
                                   $Fond['Utilisateur']['Login'] ; ?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>			 <div class='rowElem'>	
                                 <label><?php echo __('Fond'); ?></label>	
                                  <div  class='formRight'>	
                                  
			<?php echo h($Fond['Fond']['fond']); ?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>	
  <?php echo $this->Form->end();?>
</div>

</fieldset>