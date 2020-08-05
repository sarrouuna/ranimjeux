<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Alimentations/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification Alimentation caisse'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Alimentation',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('numero',array('readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('date',array('div'=>'form-group','value'=>$date,'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire') );		
                echo $this->Form->input('montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'text','required data-bv-notempty-message'=>'Champ Obligatoire') );
                ?>
                 
            </div><div class="col-md-6">
                 <?php
                echo $this->Form->input('carnetcheque_id',array('label'=>'Souche chequier','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','index'=>0,'champ'=>'carnetcheque_id','class'=>'form-control select getnumcheque','required data-bv-notempty-message'=>'Champ Obligatoire') );
                ?>
                <div class='form-group' id="divnumc0" index="0"  champ="divnumc" table="piece"   >
                <label class='col-md-2 control-label'> N° chèque </label>
                 <div class='col-sm-10'  name="data[piece][0][trnum]" id="trnumc0" index="0"  champ="trnumc" table="piece" class="modecheque"> 
              	<?php echo $this->Form->input('cheque_id',array('label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') ); ?>
                  </div>
                 </div>
                <?php
		echo $this->Form->input('echance',array('value'=>$echance,'type'=>'text','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','required data-bv-notempty-message'=>'Champ Obligatoire') );
                ?>
  </div>               
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

