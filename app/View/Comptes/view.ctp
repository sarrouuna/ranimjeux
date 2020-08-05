<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Comptes/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation Compte'); ?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo $this->Form->create('Compte',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
                           
           <div class="col-md-6">    <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Banque'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($compte['Compte']['banque']); ?>'>

                                  </div>
			
		
                                 
</div>           <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Type'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($typecomptes[@$compte['Compte']['typecompte_id']]); ?>'>

                                  </div>
			
		
                                 
</div>                     
             		 			</div><div class="col-md-6">     
              		  <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Rib'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($compte['Compte']['rib']); ?>'>

                                  </div>
			
		
                                 
                        </div>
                        <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('solde'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($compte['Compte']['solde']); ?>'>

                                  </div>
			
		
                                 
                        </div>                            
                                                </div>
<?php echo $this->Form->end();?>
	
</div></div></div></div>


	

