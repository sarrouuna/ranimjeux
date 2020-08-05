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
                                    <h3 class="panel-title"><?php echo __('Modification Ordre'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Workflow',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('document_id',array('id'=>'document_id','empty'=>'Veuillez Choisir !!','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
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
                                    <td align="center" nowrap="nowrap"> Banque </td>
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
                                     <td align="center" style="width:1%">
                                   </td>
                                    <td align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                <?php 
                                //zeinab
                                $anc=0;
                                foreach ($ligneworkflows as $i=>$l){
                                  if($l['Ligneworkflow']['banque']==1){
                                      $anc=$i;
                                  }  
                                    ?> 
                                <tr class="cc" >
                                    <td style="width:49%">
                                        <?php    echo $this->Form->input('sup',array('name'=>'data[Ligneworkflow]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Ligneworkflow','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php    echo $this->Form->input('typeworkflow_id',array('value'=>$l['Ligneworkflow']['typeworkflow_id'],'name'=>'data[Ligneworkflow]['.$i.'][typeworkflow_id]','index'=>$i,'id'=>'typeworkflow_id'.$i,'label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select test_action_personnel','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:49%" >
                                        <?php echo $this->Form->input('personnel_id',array('value'=>$l['Ligneworkflow']['personnel_id'],'name'=>'data[Ligneworkflow]['.$i.'][personnel_id]','div'=>'form-group','label'=>'','table'=>'Ligneworkflow','index'=>$i,'id'=>'personnel_id'.$i,'champ'=>'personnel_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select test_action_personnel','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td align="center" style="width:1%">
                                    <input type="checkbox" index="<?php echo $i;?>" <?php if($l['Ligneworkflow']['obligatoire']==1){ ?> checked="checked" <?php } ?>  class="obligation">
                                    <?php    echo $this->Form->input('obligatoire',array('value'=>$l['Ligneworkflow']['obligatoire'],'name'=>'data[Ligneworkflow]['.$i.'][obligatoire]','id'=>'obligatoire'.$i,'champ'=>'obligatoire','table'=>'Ligneworkflow','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td align="center" style="width:1%">
                                        
                                        <input type="radio" name='banque' value='<?php echo $i;?>' id='bq<?php echo $i;?>' index="<?php echo $i;?>" <?php if($l['Ligneworkflow']['banque']==1){  ?> checked="checked" <?php } ?>  class="TestBanque">
                                        
                                     <?php    echo $this->Form->input('banque',array('type'=>'hidden','value'=>$l['Ligneworkflow']['banque'],'name'=>'data[Ligneworkflow]['.$i.'][banque]','id'=>'banque'.$i,'champ'=>'banque','table'=>'Ligneworkflow','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );?>
                                   
                                    </td>
                                    <td align="center"><i index="<?php echo $i;?>"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo $i;?>" id="index" />
                <input type="hidden" value="<?php echo $anc;?>" id="bq_anc" />
</div>
                            </div>
                        </div>                
</div>                           
                                    
                                    
                                    
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary test_champ_action_personnel ">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

