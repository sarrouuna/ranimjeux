<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Bordereaus/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation Bordereau');?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo $this->Form->create('Bordereau',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); //debug($bordereau);die;?>
                           
             <div class="col-md-6">                         
             		 		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Utilisateur'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bordereau['Utilisateur']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Numero'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bordereau['Bordereau']['numero']); ?>'>

                                  </div>
			
		
                                 
</div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Compte bancaire'); ?></label>	
                                  	
                                  
                            <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bordereau['Compte']['banque'].' '.$bordereau['Compte']['rib']); ?>'>

                                  </div>
			
		
                                 
</div>   <?php if($factoring==1){ ?>
	 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Compte factoring'); ?></label>	
                                  	
                                  
                            <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bordereau['Factoring']['banque'].' '.$bordereau['Factoring']['rib']); ?>'>

                                  </div>
			
		
                                 
</div> 
       <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Garantie'); ?></label>	
                                  	
                                  
                            <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bordereau['Bordereau']['garantie']); ?>'>

                                  </div>
			
		
                                 
        </div>  
         <?php } ?>
        </div>
             <div class="col-md-6">    
                    <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Paiement'); ?></label>	
                                  	
                                  
                            <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bordereau['Paiement']['name']); ?>'>

                                  </div>
			
		
                                 
                   </div>
              		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bordereau['Bordereau']['date']); ?>'>

                                  </div>
			
		
                                 
</div>			 <?php if($factoring==1){ ?>
       <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Agio'); ?></label>	
                                  	
                                  
                            <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bordereau['Bordereau']['agio']); ?>'>

                                  </div>
			
		
                                 
        </div> 
                  <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Montant Verse'); ?></label>	
                                  	
                                  
                            <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bordereau['Bordereau']['montantverse']); ?>'>

                                  </div>
                  </div> 
         <?php } ?> 	 	</div>
                                     <!-- Autre ligne bordereau-->
             <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne de bordereau'); ?></h3>
                                   
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    
                                    <td align="center" nowrap="nowrap">Client</td>
                                    <td align="center" nowrap="nowrap">Numero pièce</td>
                                    <td align="center" nowrap="nowrap">Banque</td>
                                    <td align="center" nowrap="nowrap">Montant</td>    
                                </tr>
                                </thead>
                                <tbody>
                                 <?php foreach ($lignebordereaus as $i=>$lb){ //debug($lb);die; ?> 
                                 
                                <tr class="cc" >
                                   <td style="width:25%">
                                        <?php echo $this->Form->input('clientid',array('readonly'=>'readonly','value'=>@$clients[$lb['Lignebordereau']['client_id']],'div'=>'form-group','label'=>'', 'name' => '','table'=>'lignebordereau','index'=>$i,'id'=>'client_id'.$i,'champ'=>'client_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','type'=>'text') );?>
                                    </td>
                                     <td style="width:25%" champ="tdpiece" id="tdpiece">
                                        <?php echo $this->Form->input('numpiece',array('readonly'=>'readonly','value'=>$lb['Lignebordereau']['numpiece'],'label'=>'','div'=>'form-group', 'name' => 'data[lignebordereau]['.$i.'][numpiece]','table'=>'lignebordereau','index'=>$i,'id'=>'numpiece'.$i,'champ'=>'numpiece','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text'));?>
                                     </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('banque',array('value'=>$lb['Lignebordereau']['banque'],'div'=>'form-group','label'=>'', 'name' => 'data[lignebordereau]['.$i.'][banque]','table'=>'lignebordereau','index'=>$i,'id'=>'banque'.$i,'champ'=>'banque','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:25%">
                                     <?php echo $this->Form->input('montant',array('value'=>$lb['Lignebordereau']['montant'],'div'=>'form-group','label'=>'', 'name' => 'data[lignebordereau]['.$i.'][montant]','table'=>'lignebordereau','index'=>$i,'id'=>'montant'.$i,'champ'=>'montant','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    
                                </tr>
                                 <?php } ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo $i; ?>"  id="index" />
</div>
                            </div>
                        </div>                
</div> 
                                      
                                      
                <div class="col-md-10">     
            	        <div class='form-group'>	
                         <label class='col-md-2 control-label'><?php echo __('Montant Total'); ?></label>	
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bordereau['Bordereau']['Montant']); ?>'>
                        </div> </div></div>                         
                                      
<?php echo $this->Form->end();?>
	
</div></div></div></div>


	

