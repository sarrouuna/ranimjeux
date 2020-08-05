<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Bordereaus/indexr"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row">    
  
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout Retrait'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Bordereau',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
      
        <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('numero',array('value'=>$mm,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                echo $this->Form->input('compte_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select compte','id'=>'compte_id','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
	        echo $this->Form->input('date',array('div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire') );		
                ?>
            <div class="form-group">
            <div id="compteversement" style="display: none;">
                <?php
                echo $this->Form->input('compte',array('type'=>'hidden','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','id'=>'compte_id1','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
                ?>
            </div>
            </div>    
        </div>
        <div class="col-md-6" style="display: none" id="divsolde">
              <?php echo $this->Form->input('solde',array('div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'solde','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire') );  ?>
        </div>
        <div class="col-md-6">     
            <?php 
            echo $this->Form->input('montantverse',array('label'=>'Montant','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','type'=>'text','after'=>'</div>','id'=>'totalfactoring','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire') );             
            echo $this->Form->input('observation',array('div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire') );             
            ?>
        </div>    
                                
                          
           
             
<div class="form-group " >
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary  testligneedit testlignefacture">Enregistrer</button>
                                            </div>
                                        </div>
 <?php echo $this->Form->end();?>   
</div>
                            </div>
                        </div>
</div>

