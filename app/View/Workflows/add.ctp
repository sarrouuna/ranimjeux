<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Workflows/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout Ordre'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Workflow',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('document_id',array('id'=>'document_id','empty'=>'Veuillez Choisir !!','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
	?></div><div class="col-md-6"><?php
		echo $this->Form->input('commentaire',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
	?>
        </div>  
                                    
                                    
                                    
                     <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne d\'Ordre'); ?></h3>
                                    <a class="btn btn-danger ajouter_lignetransfert" table='addtable' index='index'  tr="tr" style="
                                    float: right; 
                                    position: relative;
                                    top: -25px;
                                "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Action</td>
                                    <td align="center" nowrap="nowrap">Personnel</td>
                                    <td align="center" nowrap="nowrap"> Obligation </td>
                                    <td align="center"></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;" >
                                    <td style="width:49%">
                                        <?php    echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Ligneworkflow','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php    echo $this->Form->input('typeworkflow_id',array('table'=>'Ligneworkflow','label'=>'','champ'=>'typeworkflow_id','id'=>'','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'test_action_personnel','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:49%">
                                        <?php echo $this->Form->input('personnel_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Ligneworkflow','index'=>'','id'=>'','champ'=>'personnel_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'test_action_personnel','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td align="center" style="width:1%">
                                    <input type="checkbox" index="" class="obligation">
                                    <?php  echo $this->Form->input('obligatoire',array('name'=>'','id'=>'','champ'=>'obligatoire','table'=>'Ligneworkflow','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'') );?>
                                    </td>
                                    <td align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                
                                <tr class="cc" >
                                    <td style="width:49%">
                                        <?php    echo $this->Form->input('sup',array('name'=>'data[Ligneworkflow][0][sup]','id'=>'sup0','champ'=>'sup','table'=>'Ligneworkflow','index'=>'0','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php    echo $this->Form->input('typeworkflow_id',array('name'=>'data[Ligneworkflow][0][typeworkflow_id]','index'=>'0','id'=>'typeworkflow_id0','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select test_action_personnel','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:49%" >
                                        <?php echo $this->Form->input('personnel_id',array('name'=>'data[Ligneworkflow][0][personnel_id]','div'=>'form-group','label'=>'','table'=>'Ligneworkflow','index'=>'0','id'=>'personnel_id0','champ'=>'personnel_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select test_action_personnel','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td align="center" style="width:1%">
                                    <input type="checkbox" index="0" class="obligation">
                                    <?php    echo $this->Form->input('obligatoire',array('value'=>'0','name'=>'data[Ligneworkflow][0][obligatoire]','id'=>'obligatoire0','champ'=>'obligatoire','table'=>'Ligneworkflow','index'=>'0','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td align="center"><i index="0"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                </tbody>
                                </table>
              	<input type="hidden" value="0" id="index" />
</div>
                            </div>
                        </div>                
</div>                
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary test_champ_action_personnel">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

