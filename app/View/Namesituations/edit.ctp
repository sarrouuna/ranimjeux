<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Namesituations/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification Situation'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Namesituation',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('name',array('label'=>'Désignation','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?></div><div class="col-md-6"><?php
		//echo $this->Form->input('personnel_id',array('empty'=>'choix','multiple'=>'multiple','label'=>'Personnel','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?>
        <div class="form-group"><label for="ReservationDate" class="col-md-2 control-label">Personnel</label><div class="col-sm-10" style="width: 66%">
                <select multiple name='data[Namesituation][personnel_id][]' champ='personnel_id' id='personnel_id' class='form-control select' onchange='' >
                <option value=''>choix</option>
                <?php foreach($personnels as $v){ ?>
                <option value="<?php echo $v['Personnel']['id'] ; ?>" <?php if(!empty($situationpersonnels)){foreach($situationpersonnels as $l){ if($l['Situationpersonnel']['personnel_id']==$v['Personnel']['id']){ ?> selected="selected"<?php }}} ?>><?php echo $v['Personnel']['name']; ?></option>
                <?php } ?>
                </select>
                </div></div>
        
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

