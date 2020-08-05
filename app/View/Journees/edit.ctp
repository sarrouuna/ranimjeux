<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Journees/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ouvrir  Journée'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Journee',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh', 'enctype' => 'multipart/form-data')); ?>

            <div class="col-md-6">                  
              	<?php //debug($journee);die;
                echo $this->Form->input('id',array('div'=>'form-group','value'=>$journee['Journee']['id'],'between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		//debug($this->request->data);die;
                echo $this->Form->input('depot_id',array('div'=>'form-group','value'=>$journee['Journee']['depot_id'],'between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez Choisir !!') );
		echo $this->Form->input('date_debut',array('label'=>'Date Debut','value'=>date("d/m/Y H:i:s", strtotime(str_replace('-', '/',$journee['Journee']['date_debut']))),'div'=>'form-group','type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control dateTimePickerCustom') );
	?></div><div class="col-md-6"><?php
		echo $this->Form->input('date_fin',array('label'=>'Date Fin','value'=>date("d/m/Y H:i:s", strtotime(str_replace('-', '/',$journee['Journee']['date_fin']))),'div'=>'form-group','type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control dateTimePickerCustom') );
	?>
  </div>  
                                    
        <!-- Autre ligne inventaire-->
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Detail'); ?></h3>
                                    
                                </div>
                                <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Personnel</td>
                                    <td align="center" nowrap="nowrap">Fond</td>
                                    <td align="center" nowrap="nowrap">Réçu le</td>
                                </tr>
                                </thead>
                                <tbody>
                               <?php
                                $k=0;
                                $total=0;
                                 foreach($personnels as $k=>$per){ 
                                     $total+=$ticket[$per['Personnel']['id']][0][0]['Total_TTC'];?>
                                
                                <tr>
                                    <td>
                                        <?php echo $this->Form->input('id',array('label'=>'','div'=>'form-group','type'=>'hidden','name'=>'data[detail]['.$k.'][id]','value'=>@$Fond[$per['Personnel']['id']][0]['Fond']['id'],'between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                        <?php  echo  $per['Personnel']['name'] ; ?>
                                        <?php echo $this->Form->input('personnel_id',array('label'=>'','div'=>'form-group','type'=>'hidden','name'=>'data[detail]['.$k.'][personnel_id]','value'=>$per['Personnel']['id'],'between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                  
                                    </td>
                                   <td>
                                       <?php echo $this->Form->input('fond',array('label'=>'','div'=>'form-group','type'=>'test','name'=>'data[detail]['.$k.'][fond]','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','value'=>@$Fond[$per['Personnel']['id']][0]['Fond']['fond']) );?>
                                   </td>
                                   <td>
                                       <?php echo $this->Form->input('date',array('label'=>'','div'=>'form-group','value'=>date("d/m/Y H:i:s", strtotime(str_replace('-', '/',@$Fond[$per['Personnel']['id']][0]['Fond']['date']))),'name'=>'data[detail]['.$k.'][date]','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control dateTimePickerCustom') );?>
                                   <?php echo $this->Form->input('etat',array('label'=>'','div'=>'form-group','value'=>@$Fond[$per['Personnel']['id']][0]['Fond']['etat'],'name'=>'data[detail]['.$k.'][etat]','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                  
                                   </td>
                                   
                                   
                                     </tr>
                                 <?php } ?>
                                    
                                </tbody>
                                </table>
              	<input type="hidden" value="0" id="index" />
</div>
                                
                            </div>
                        </div>                
</div> 
                                                                       
                              
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary ">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

