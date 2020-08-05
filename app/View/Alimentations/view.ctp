<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Alimentations/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation Alimentation caisse'); ?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo $this->Form->create('Alimentation',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
                           
           <div class="col-md-6">    
               		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Numero'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($alimentation['Alimentation']['numero']); ?>'>

                                  </div>
			
		
                                 
</div>	
               		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h(date("d/m/Y",strtotime(str_replace('-','/',$alimentation['Alimentation']['date'])))); ?>'>

                                  </div>
			
		
                                 
</div>	
               		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Montant'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($alimentation['Alimentation']['montant']); ?>'>

                                  </div>
			
		
                                 
</div>	
  			</div><div class="col-md-6">  
                             <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Souche chequier'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $alimentation['Carnetcheque']['numero']; ?>'>
                                  </div>
			
		
                                 
                            </div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Cheque'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $alimentation['Cheque']['numero']; ?>'>
                                  </div>
			
		
                                 
                            </div>	
              		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Echance'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h(date("d/m/Y",strtotime(str_replace('-','/',$alimentation['Alimentation']['echance'])))); ?>'>

                                  </div>
			
		
                                 
</div>	</div>
<?php echo $this->Form->end();?>
	
</div></div></div></div>


	

