<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Namesituations/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation Situation'); ?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo $this->Form->create('Namesituation',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
                           
           <div class="col-md-6">                         
             		 <div class='form-group' style="display:none">	
                                 <label class='col-md-2 control-label'><?php echo __('Id'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($namesituation['Namesituation']['id']); ?>'>

                                  </div>
			
		
                                 
</div>	     
              		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Désignation'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($namesituation['Namesituation']['name']); ?>'>

                                  </div>
			
		
                                 
</div>	</div><div class="col-md-6"> 
 <div class="form-group"><label for="ReservationDate" class="col-md-2 control-label">Personnel</label><div class="col-sm-10" style="width: 66%">
         <select disabled="disabled" multiple name='data[Namesituation][personnel_id][]' champ='personnel_id' id='personnel_id' class='form-control select' onchange='' >
                <option value=''>choix</option>
                <?php foreach($personnels as $v){ ?>
                <option value="<?php echo $v['Personnel']['id'] ; ?>" <?php if(!empty($situationpersonnels)){foreach($situationpersonnels as $l){ if($l['Situationpersonnel']['personnel_id']==$v['Personnel']['id']){ ?> selected="selected"<?php }}} ?>><?php echo $v['Personnel']['name']; ?></option>
                <?php } ?>
                </select>
                </div></div>   
    
    
    
</div>
<?php echo $this->Form->end();?>
	
</div></div></div></div>


	

