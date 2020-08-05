<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Ordres/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation Ordre de paiement'); ?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo $this->Form->create('Ordre',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
                           
           <div class="col-md-6">                         
             				 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Fournisseur'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $ordre['Fournisseur']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Utilisateur'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $ordre['Utilisateur']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>	 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Montant'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($ordre['Ordre']['Montant']); ?>'>

                                  </div>
			
		
                                 
</div>	
           </div><div class="col-md-6">     
              		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Numero'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($ordre['Ordre']['numero']); ?>'>

                                  </div>
			
		
                                 
</div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($ordre['Ordre']['date']); ?>'>

                                  </div>
			
		
                                 
</div>	</div>
                                    
                                <!-- Factures-->
              <div class="row ligne ordre"   >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Factures '); ?></h3>
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    
                                    <td align="center" nowrap="nowrap">Numero</td>
                                    <td align="center" nowrap="nowrap">Date</td>
                                    <td align="center" nowrap="nowrap">Total TTC</td>
                                    <td align="center" nowrap="nowrap">Reste</td>    

                                </tr>
                                </thead>
                                <tbody>
                                    
                                <?php if(!empty($factures)){ foreach ($factures as $i=>$facture){     ?> 
                                
                                <tr class="cc" >
                                   <td style="width:25%">
                                        <?php echo $this->Form->input('id',array('type'=>'hidden','value'=>$facture['Facture']['id'],'label'=>'','div'=>'form-group', 'name' => 'data[Facture]['.$i.'][id]','table'=>'Facture','index'=>$i,'id'=>'id'.$i,'champ'=>'id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));?>
                                        <?php echo $this->Form->input('numero',array('readonly'=>'readonly','value'=>$facture['Facture']['numero'],'div'=>'form-group','label'=>'', 'name' => 'data[Facture]['.$i.'][numero]','table'=>'Facture','index'=>$i,'id'=>'numero'.$i,'champ'=>'numero','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  ','type'=>'text') );?>
                                    </td>
                                     <td style="width:25%" >
                                        <?php  echo $this->Form->input('date',array('readonly'=>'readonly','value'=>date("d/m/Y",strtotime(str_replace('-','/',$facture['Facture']['date']))),'label'=>'','div'=>'form-group', 'name' => 'data[Facture]['.$i.'][date]','table'=>'Facture','index'=>$i,'id'=>'date'.$i,'champ'=>'date','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','type'=>'text'));?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('totalttc',array('label'=>'Total TTC','readonly'=>'readonly','value'=>$facture['Facture']['totalttc'],'div'=>'form-group','label'=>'', 'name' => 'data[Facture]['.$i.'][totalttc]','table'=>'Facture','index'=>$i,'id'=>'totalttcc'.$i,'champ'=>'totalttc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('Reste',array('label'=>'Total TTC','readonly'=>'readonly','value'=>($facture['Facture']['totalttc']-$facture['Facture']['Montant_Regler']),'div'=>'form-group','label'=>'', 'name' => 'data[Facture]['.$i.'][totalttc]','table'=>'Facture','index'=>$i,'id'=>'totalttc'.$i,'champ'=>'totalttc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    
                                </tr>
                                <?php  }} ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value="0" id="index" />
</div>
                            </div>
                        </div>                
</div>      
                                    
<?php echo $this->Form->end();?>
	
</div></div></div></div>


	

