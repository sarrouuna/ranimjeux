<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Bordereaus/indexr"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation Retrait');?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo $this->Form->create('Bordereau',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); //debug($bordereau);die;?>
                           
             <div class="col-md-6">                         
             		 		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Observation'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bordereau['Bordereau']['observation']; ?>'>
                                  </div>
			
		
                                 
                            </div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Numero'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bordereau['Bordereau']['numero']); ?>'>

                                  </div>
			
		
                                 
</div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Compte bancaire'); ?></label>	
                                  	
                                  
                            <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bordereau['Compte']['banque'].' '.$bordereau['Compte']['rib']); ?>'>

                                  </div>
			
		
                                 
</div>  
        </div>
             <div class="col-md-6">    
                  
              		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bordereau['Bordereau']['date']); ?>'>

                                  </div>
			
		
                                 
</div>			
                  <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Montant'); ?></label>	
                                  	
                                  
                            <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bordereau['Bordereau']['montantverse']); ?>'>

                                  </div>
                  </div> 
         	 	</div>           
                                      
                                      
              
<?php echo $this->Form->end();?>
	
</div></div></div></div>


	

