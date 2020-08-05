<?php $edit="";
$lien=  CakeSession::read('lien_achat');
foreach($lien as $k=>$liens){
	if(@$liens['lien']=='reglements'){
		$edit=$liens['edit'];
	}
   }
?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Carnetcheques/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation Souche chequier'); ?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo $this->Form->create('Carnetcheque',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
                           
           <div class="col-md-6">       
                <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Banque'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($carnetcheque['Compte']['banque']); ?>'>

                                  </div>
			
		
                                 
      </div>	
               <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Rib'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($carnetcheque['Compte']['rib']); ?>'>

                                  </div>
			
		
                                 
      </div>	<div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Numero'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($carnetcheque['Carnetcheque']['numero']); ?>'>

                                  </div>
			
		
                                 
</div>			 	</div>
                                    <div class="col-md-6">     
                                        <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Debut'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($carnetcheque['Carnetcheque']['debut']); ?>'>

                                  </div>
			
		
                                 
</div>
              		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Nombre'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($carnetcheque['Carnetcheque']['nombre']); ?>'>

                                  </div>
			
		
                                 
</div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Taille'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($carnetcheque['Carnetcheque']['taille']); ?>'>

                                  </div>
			
		
                                 
</div>	</div>
                                    
               <!-- Autre Chèques-->
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Chèques'); ?></h3>
                                    
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap"> N° CHQ</td>
                                    <td align="center" nowrap="nowrap"> Montant </td>
                                    <td align="center" nowrap="nowrap"> Bénificiaire </td>
                                    <td align="center" nowrap="nowrap"> Facture N° </td>
                                    <td align="center" nowrap="nowrap"> Achat N° </td>
                                    <td align="center" nowrap="nowrap"> Retenue N° </td>
                                    <td align="center" nowrap="nowrap"> Emission </td>
                                    <td align="center" nowrap="nowrap"> Encaissement  </td>
                                    <td align="center" nowrap="nowrap"> Situation </td>
                                    <td align="center" nowrap="nowrap"> </td>
                                </tr>
                                </thead>
                                <tbody>
                          
                                     <?php
                               
                                            
                                               foreach ($pieces as $i=>$piece){
                                            

                                        ?> 
                                
                                <tr>
                                        <td align="center" style="width:9%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo @$piece['Piecereglement']['num'] ?>'>  
                                        </td>
                                       
                                        <td align="center" style="width:10%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo @$piece['Piecereglement']['montant'] ?>'>  
                                        </td>
                                         <td align="center" style="width:10%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo @$piece['Reglement']['Fournisseur']['name'] ?>'>  
                                        </td>
                                         <td align="center" style="width:13%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php if($piece['Reglement']['Lignereglement']){foreach ( $piece['Reglement']['Lignereglement'] as $lreg){echo ' '.$factures[$lreg['facture_id']]; }}?>'>  
                                        </td>
                                        <td align="center" style="width:8%">
                                          <input type='text'  class='form-control' id="numeroachat<?php echo $i ?>" class='input' value='<?php echo @$piece['Piecereglement']['numeroachat']?>'>  
                                        </td>
                                         <td align="center" style="width:12%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php if($piece['Reglement']['Piecereglement']){foreach ( $piece['Reglement']['Piecereglement'] as $preg){if($preg['paiement_id']==5){ echo ' '.$preg['num'];} }} ?>'>  
                                         </td>
                                         <td align="center" style="width:12%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo date("d/m/Y",strtotime(str_replace('-','/',@$piece['Reglement']['Date'] )))?>'>  
                                        </td>
                                        <td align="center" style="width:12%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo 'date encai '?>'>  
                                        </td>
                                         <td align="center" style="width:9%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo @$piece['Piecereglement']['situation'] ?>'>  
                                        </td>
                                         <td align="center">			
                                             <?php if($edit==1){ ?>
                                                     <input type="hidden" id="piece_id<?php echo $i ?>" value="<?php echo $piece['Piecereglement']['id']; ?>" class="idpiece"/>
                                                     <a class="btn btn btn-warning editnumeroachat"  indexpiece="<?php echo $i ?>"/> <i class='fa fa-edit'></i> </a>
                                              <?php }  ?>
                                         </td>
                                         </tr> 
                                            <?php }
                                            
                                        foreach ($alimentations as $i=>$alimentation){
                                            
                                        ?> 
                                
                                <tr>
                                        <td align="center" style="width:9%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $alimentation['Cheque']['numero'] ?>'>  
                                        </td>
                                       
                                        <td align="center" style="width:10%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $alimentation['Alimentation']['montant'] ?>'>  
                                        </td>
                                         <td align="center" style="width:10%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo 'Paramed' ?>'>  
                                        </td>
                                         <td align="center" style="width:13%">
                                        </td>
                                        <td align="center" style="width:8%">
                                        </td>
                                         <td align="center" style="width:12%">
                                         </td>
                                         <td align="center" style="width:12%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo date("d/m/Y",strtotime(str_replace('-','/',$alimentation['Alimentation']['date'] )))?>'>  
                                        </td>
                                        <td align="center" style="width:12%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo date("d/m/Y",strtotime(str_replace('-','/',$alimentation['Alimentation']['echance'] )))?>'>  
                                        </td>
                                         <td align="center" style="width:9%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo 'Payé' ?>'>  
                                        </td>
                                         <td align="center">			
                                           
                                         </td>
                                         </tr> 
                                            <?php }         
                                           
                                            foreach ($cheques as $i=>$cheque){
                                               if($cheque['Cheque']['etat']!=1){
                                                  ?>
                                         <tr>
                                        <td align="center" style="width:9%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo ' '.$cheque['Cheque']['numero'] ?>'>  
                                        </td>
                                      
                                        <td align="center" style="width:10%">
                                        </td>
                                         <td align="center" style="width:10%">
                                        </td>
                                         <td align="center" style="width:13%">
                                        </td>
                                         <td align="center" style="width:8%">
                                         </td>
                                         <td align="center" style="width:12%">
                                        </td>
                                         <td align="center" style="width:12%">
                                        </td>
                                         <td align="center" style="width:12%">
                                         </td>
                                         <td align="center" style="width:9%">
                                        </td>
                                        <td align="center" style="width:5%">
                                        </td>
                                               <?php  }}?> 
                                </tbody>
                                </table>
              	<input type="hidden" value=""  id="index" />
</div>
                            </div>
                        </div>                
</div>                                
<?php echo $this->Form->end();?>
	
</div></div></div></div>


	

