<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Bonentres/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation Bonentre'); ?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo $this->Form->create('Bonentre',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
                           
           <div class="col-md-6">                         
             		 	 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Fournisseur'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bonentre['Fournisseur']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Utilisateur'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bonentre['Utilisateur']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonentre['Bonentre']['date']); ?>'>

                                  </div>
			
		
                                 
</div>	</div><div class="col-md-6">  
                            <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Numero'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonentre['Bonentre']['numero']); ?>'>

                                  </div>
			
		
                                 
                      </div>
              		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Bon de reception'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bonentre['Bonreception']['numero']; ?>'>
                                  </div>
			
		
                                 
                            </div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Facture'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bonentre['Facture']['numero']; ?>'>
                                  </div>
			
		
                                 
                            </div>				</div>
                                    
            <!-- Autre ligne livraison-->
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne d\'entré'); ?></h3>
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Depot</td>
                                    <td align="center" nowrap="nowrap">Article</td>
                                    <td align="center" nowrap="nowrap"> Date validité </td>
                                    <td align="center" nowrap="nowrap"> Quantite </td>
                                    <td align="center" nowrap="nowrap">              
                                    </td>    
                                </tr>
                                </thead>
                                <tbody>
                             
                                  <?php  foreach ($ligneentres as $i=>$l){   ?> 
                                
                                <tr class="cc" >
                                     <td style="width:25%">
                                    	 <?php	echo $this->Form->input('depotid',array('value'=>$l['Depot']['designation'],'label'=>'','readonly'=>'readonly','div'=>'form-group', 'name' => '','table'=>'Lignesorti','index'=>'','id'=>'','champ'=>'','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );?>
                                     </td> 
                                    <td style="width:25%"  champ="tdarticle" id="tdarticle0" >
                                       <?php echo $this->Form->input('articleid',array('value'=>$l['Article']['name'],'div'=>'form-group','label'=>'', 'readonly'=>'readonly', 'name' => '','table'=>'Lignesorti','index'=>'','id'=>'','champ'=>'','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>               
                                    </td> 
                                     <td style="width:23%">
                                        <?php echo $this->Form->input('date',array('value'=>date("d/m/Y",strtotime(str_replace('-','/',$l['Ligneentre']['date']))),'label'=>'','readonly'=>'readonly','div'=>'form-group', 'name' => 'data[Lignesorti]['.$i.'][quantite]','table'=>'','index'=>$i,'id'=>'quantite'.$i,'champ'=>'','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testqte','required data-bv-notempty-message'=>'Champ Obligatoire') );?>
                                    </td>
                                     <td style="width:23%">
                                        <?php echo $this->Form->input('quantite',array('value'=>$l['Ligneentre']['quantite'],'label'=>'','readonly'=>'readonly','div'=>'form-group', 'name' => 'data[Lignesorti]['.$i.'][quantite]','table'=>'Lignesorti','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );?>
                                    </td>
                                </tr>
                                  <?php }?>
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo $i; ?>"  id="index" />
</div>
                            </div>
                        </div>                
</div>                           
                                    
<?php echo $this->Form->end();?>
	
</div></div></div></div>


	

