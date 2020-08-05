<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Bonreceptions/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation Bon livraison'); ?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo $this->Form->create('Bonreception',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
                           
           <div class="col-md-6">                         
             		 <div class='form-group' style="display: none;">	
                                 <label class='col-md-2 control-label'><?php echo __('Id'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonreception['Bonreception']['id']); ?>'>

                                  </div>
			
		
                                 
</div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Fournisseur'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bonreception['Fournisseur']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>			 <div class='form-group' style="display: none;">	
                                 <label class='col-md-2 control-label'><?php echo __('Utilisateur'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bonreception['Utilisateur']['name']; ?>'>
                                  </div>
			
		 </div>			
         
                                    
                                    
                                         
              					 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Numero'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonreception['Bonreception']['numero']); ?>'>

                                  </div>
			
		
                                 
                                                 </div>		</div>	 
              <div class="col-md-6">               <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h(date("d/m/Y",strtotime(str_replace('-','/',$bonreception['Bonreception']['date'])))); ?>'>

                                  </div>
			
		
                                 
</div>			

        </div>
                                    
                                    
     <!-- Autre ligne bon reception-->
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne de reception'); ?></h3>
                                    
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Article</td>
                                    
                                    <td align="center" nowrap="nowrap"> Quantite </td>
                                    <td align="center" nowrap="nowrap">Prix unitaire</td>    
                                    <td align="center" nowrap="nowrap">Remise %</td>       
                                    <td align="center" nowrap="nowrap">Fodec % </td>
                                    <td align="center" nowrap="nowrap">TVA % </td>    
                                    <td align="center" nowrap="nowrap">Total HT</td>    
                                    <td align="center" nowrap="nowrap">Total TTC</td> 
                                </tr>
                                </thead>
                                <tbody>
                          
                                     <?php
                               
                                            foreach ($lignereceptions as $i=>$lr){
                                                
                                         if (@$lr['Lignereception']['datefabrication']){  $datefabrication=date("d/m/Y",strtotime(str_replace('-','/',$lr['Lignereception']['datefabrication'])));}
                                         if (@$lr['Lignereception']['datevalidite']){   $datevalidite=date("d/m/Y",strtotime(str_replace('-','/',$lr['Lignereception']['datevalidite'])));}
                                    
                                   
                                        ?> 
                                
                                <tr>
                                    <td style="width:12%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $lr['Article']['name'] ?>'>  
                                        </td>
                                   
                                     <td style="width:8%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $lr['Lignereception']['quantite'] ?>'>  
                                    </td>
                                    <td style="width:10%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $lr['Lignereception']['prixhtva'] ?>'>  
                                    </td>
                                    <td style="width:8%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $lr['Lignereception']['remise'] ?>'>  
                                    </td>
                                    <td style="width:7%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $lr['Lignereception']['fodec'] ?>'>  
                                    </td>
                                    <td style="width:8%">
                                        <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $lr['Lignereception']['tva'] ?>'>  
                                    </td>
                                    <td style="width:10%">
                                        <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $lr['Lignereception']['totalht'] ?>'>  
                                    </td>
                                    <td style="width:10%">
                                        <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $lr['Lignereception']['totalttc'] ?>'>  
                                    
                                 <?php } ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value=""  id="index" />
</div>
                            </div>
                        </div>                
</div> 
                                                                                   
                      <div class="col-md-6">  
                           <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Remise'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonreception['Bonreception']['remise']); ?>'>

                                  </div>
			
		
                                 
</div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Tva'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonreception['Bonreception']['tva']); ?>'>

                                  </div>
			
		
                                 
</div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Fodec'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonreception['Bonreception']['fodec']); ?>'>

                                  </div>
			
		
                                 
</div>	
                      </div>
     
                    <div class="col-md-6">
 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Totalht'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonreception['Bonreception']['totalht']); ?>'>

                                  </div>
			
		
                                 
</div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Totalttc'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonreception['Bonreception']['totalttc']); ?>'>

                                  </div>
			
		
                                 
             </div>
                    </div>                                        

                                    
<?php echo $this->Form->end();?>
	
</div></div></div>  
    </div>


	

