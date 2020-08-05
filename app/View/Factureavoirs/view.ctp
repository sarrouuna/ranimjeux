<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Factureavoirs/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification Facture à voir'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Factureavoir',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6"> <div class='form-group'>                 
                                    <label class='col-md-2 control-label'><?php echo __('Client'); ?></label>	
               <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $factureavoir['Client']['name']; ?>'>
               </div> </div><div class='form-group'>
               <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>				
               <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h(date("d/m/Y",strtotime(str_replace('-','/',$factureavoir['Factureavoir']['date'])))); ?>'>
               </div></div>
			<?php
               echo $this->Form->input('designation', array('label' => 'Designation','readonly'=>'readonly', 'div' => 'form-group','between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'designation', 'class' => 'form-control'));
               echo $this->Form->input('observation', array('label' => 'Observation','readonly'=>'readonly', 'type'=>'textarea', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'observation', 'class' => 'form-control'));
            ?>
                                
		</div><div class="col-md-6"><div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Numero'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($factureavoir['Factureavoir']['numero']); ?>'>

                                  </div>
			
		
                                 
</div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Typefacture'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $factureavoir['Typefacture']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>
        </div>  
                                    
            <?php if($typefacture==1){ ?>                      
                                          <!-- Autre ligne facture avoir-->
                   <div class="row ligne favr"  >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne Facture à voir'); ?></h3>
                                   
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Depot</td>
                                    <td align="center" nowrap="nowrap">Article</td>
                                    <td align="center" nowrap="nowrap"> Quantite </td>
                                    <td align="center" nowrap="nowrap">Prix unitaire</td>    
                                    <td align="center" nowrap="nowrap">Remise %</td>       
                                    <td align="center" nowrap="nowrap">TVA % </td>    
                                </tr>
                                </thead>
                                <tbody>
                             
                                <?php
                                            foreach ($Lignefactureavoirs as $i=>$lfav){
                                 ?> 
                                <tr class="cc" >
                                     <td style="width:22%">
                                        <?php echo $this->Form->input('id',array('value'=>$lfav['Lignefactureavoir']['id'],'name'=>'data[Lignefactureavoir]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignefactureavoir','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'data[Lignefactureavoir]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignefactureavoir','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                    	<?php echo $this->Form->input('depotid',array('value'=>$lfav['Depot']['designation'],'label'=>'','div'=>'form-group','readonly'=>'readonly', 'name' => 'data[Lignefactureavoir]['.$i.'][depot_id]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'depot_id'.$i,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );?>
                                    </td>  
                                    <td style="width:22%" >
                                        <?php echo $this->Form->input('articleid',array('value'=>$lfav['Article']['name'],'div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => 'data[Lignefactureavoir]['.$i.'][article_id]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  articleidbl','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                     <td style="width:14%">
                                        <?php echo $this->Form->input('quantite',array('value'=>$lfav['Lignefactureavoir']['quantite'],'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignefactureavoir]['.$i.'][quantite]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control   editfacfournisseur','required data-bv-notempty-message'=>'Champ Obligatoire') );?>
                                    </td>
                                    <td style="width:14%">
                                     <?php echo $this->Form->input('prix',array('value'=>$lfav['Lignefactureavoir']['prix'],'readonly'=>'readonly','div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureavoir]['.$i.'][prix]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prix','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control editfacfournisseur') );?>
                                    </td>
                                    <td style="width:14%">
                                     <?php
                                     echo $this->Form->input('remise',array('value'=>$lfav['Lignefactureavoir']['remise'],'readonly'=>'readonly','div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureavoir]['.$i.'][remise]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control editfacfournisseur') );?>
                                    </td>
                                    
                                    <td style="width:14%">
                                     <?php echo $this->Form->input('tva',array('value'=>$lfav['Lignefactureavoir']['tva'],'div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => 'data[Lignefactureavoir]['.$i.'][tva]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control editfacfournisseur') );?>
                                    </td>
                                </tr>
                                 <?php } ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo @$i; ?>"  id="index" /></div>
                            </div>
                        </div>                
                       </div> 
                                                             
                 <div class="col-md-6 favr" > <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Remise'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($factureavoir['Factureavoir']['remise']); ?>'>

                                  </div>
                     </div>
		<div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Tva'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($factureavoir['Factureavoir']['tva']); ?>'>

                                  </div>
			
		
                                 
</div>		
                                 
</div>	<div class="col-md-6">     
              		 	 		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Totalht'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($factureavoir['Factureavoir']['totalht']); ?>'>

                                  </div>
			
		
                                 
</div>					</div>
            <?php }  ?>  
                 
                                           <div class="col-md-6 favf " > <div class='form-group'>	
                         
                                 <label class='col-md-2 control-label'><?php echo __('Timbre'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($factureavoir['Timbre']['timbre']); ?>'>

                                  </div>                
                 </div>	
                 </div> 
                                           <div class="col-md-6 favf " > <div class='form-group'>	
                  
                        <label class='col-md-2 control-label'><?php echo __('totalht'); ?></label>	
                                  	
                                  
                                      <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($factureavoir['Factureavoir']['totalht']); ?>'>
                          
                                                            </div>   
                                                            </div>   
                                                            </div>   
                                                            <div class="col-md-6 favf "> <div class='form-group'>	 
                                                             <label class='col-md-2 control-label'><?php echo __('tva'); ?></label>	
                                  	                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($factureavoir['Factureavoir']['tva']); ?>'>
                          
                                                            </div> 
                                                            </div> 
                                                                    </div> 
                                                            <div class="col-md-6 favf " > <div class='form-group'>	 
                                                            <label class='col-md-2 control-label'><?php echo __('Totalttc'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($factureavoir['Factureavoir']['totalttc']); ?>'>

                                                            </div> 
                                  </div>                
                 </div>	
                 </div>   
<?php echo $this->Form->end();?>
                                           </div>
</div>
                            </div>
                        </div>
</div>

                                  