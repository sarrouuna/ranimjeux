<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Pointdeventes/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Consultation Point de vente'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Pointdevente', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                         
                    <div class='form-group' style="display: none;">	
                        <label class='col-md-2 control-label'><?php echo __('Id'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($pointdevente['Pointdevente']['id']); ?>'>

                        </div>



                    </div>			
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Designation'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($pointdevente['Pointdevente']['name']); ?>'>

                        </div>



                    </div>	
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Abriviation'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($pointdevente['Pointdevente']['abriviation']); ?>'>

                        </div>



                    </div>			 
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Adresse'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($pointdevente['Pointdevente']['adresse']); ?>'>

                        </div>



                    </div>	
                </div>
                <div class="col-md-6">
                    <?php if ($pointdevente['Pointdevente']['fodec'] != '') { ?>
                        <div class='form-group'>	
                            <label class='col-md-2 control-label'><?php echo __('FODEC'); ?></label>	
                            <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($pointdevente['Pointdevente']['fodec']); ?>'>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($pointdevente['Pointdevente']['retenue'] != '') { ?>
                        <div class='form-group'>	
                            <label class='col-md-2 control-label'><?php echo __('RETENUE'); ?></label>	
                            <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($pointdevente['Pointdevente']['retenue']); ?>'>
                            </div>
                        </div>
                    <?php } ?>
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Ville'); ?></label>	
                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($pointdevente['Pointdevente']['ville']); ?>'>
                        </div>
                    </div>			 
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Responsable'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $pointdevente['Personnel']['name']; ?>'>
                        </div>



                    </div>	</div>
                <?php echo $this->Form->end(); ?>

            </div></div></div></div>




