<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Reglementclients/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>

<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation règlement client '); ?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo $this->Form->create('Reglementclient',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
                           
           <div class="col-md-6"> 
               <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Numero'); ?></label>	
                                  
			<?php  //debug($reglement);die;?>
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $reglement['Reglementclient']['numero']; ?>'>
                                  </div>
			
		
                                 
                            </div>	
             			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Client'); ?></label>	
                                  
			<?php  //debug($reglement);die;?>
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $reglement['Client']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>	
                
           </div><div class="col-md-6"> 
                                	 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo date("d/m/Y",strtotime(str_replace('-','/',($reglement['Reglementclient']['Date'])))); ?>'>

                                  </div>
			
		
                                 
                                         </div> </div>
                                </div></div></div></div>
                                   <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Factures  réglées '); ?></h3>
                                </div>
                                <div class="panel-body">
                                 
                                    <div class="ls-editable-table table-responsive ls-table">
                                <table class="table table-bordered table-striped table-bottomless" id="table">
                                    <thead>
                                            <tr>
                                                <td>Numéro</td>
                                                <td>Date</td>
                                                <td>Total TTC</td>
                                                <td>Montant réglé</td>
                                                 <td>Reste</td>
                                                
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            <?php //debug($reglement['Lignereglement']);die;
                                            foreach ($reglement['Lignereglementclient'] as $l){ //debug($l);die; ?>
                                            <tr>
                                                <td> <?php echo $l['Factureclient']['numero']; ?></td>
                                                <td><?php echo  date("d/m/Y",strtotime(str_replace('-','/',$l['Factureclient']['date']))); ?></td>
                                                <td><?php echo $l['Factureclient']['totalttc']; ?></td>
                                                <td><?php echo $l['Factureclient']['Montant_Regler']; ?> </td>
                                                <td><?php echo $l['Factureclient']['totalttc']-$l['Factureclient']['Montant_Regler']; ?></td>
                                                
                                            </tr>
                                            <?php }?>
                                             <tr>
                                                <td colspan="4" >Total</td>
                                                <td><?php echo h($reglement['Reglementclient']['Montant']); ?></td>
                                            </tr>
                                            
                                           
                                             <tr>
                                                <td colspan="4" >Net à payer </td>
                                                <td><?php echo h($reglement['Reglementclient']['Montant']); ?></td>
                                            </tr>
                                             
                                        </tbody></table>
                                    </div></div></div></div></div>
                                       
                                   <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Pièces règlement client'); ?></h3>
                                </div>
                                <div class="panel-body">
                                 
                                    <div class="ls-editable-table table-responsive ls-table">
                                
                                            
                                            <?php foreach($pieceregement as $i=>$lp ){ //debug($lp);die;?>
                                        <table class="table table-bordered table-striped table-bottomless" id="table">
                                            <tr>
                                                <td colspan="4"> Mode règlement</td>
                                                <td> <?php echo $lp['Paiement']['name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"> Montant</td>
                                                <td><?php echo $lp['Piecereglementclient']['montant']; ?></td>
                                            </tr>
                                            
                                            <?php if($lp['Paiement']['id']!=1 && $lp['Paiement']['id']!=5&& $lp['Paiement']['id']!=6){?>
                                             <tr>
                                                <td colspan="4"> Echéance</td>
                                                <td><?php echo date("d/m/Y",strtotime(str_replace('-','/',$lp['Piecereglementclient']['echance']))); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"> Banque</td>
                                                <td><?php echo $lp['Piecereglementclient']['banque']; ?></td>
                                            </tr>
                                            <?php }?>
                                              <?php if($lp['Paiement']['id']!=1 ){?>
                                             <tr>
                                                <td colspan="4"> Numéro pièce</td>
                                                <td><?php echo $lp['Piecereglementclient']['num']; ?></td>
                                            </tr>
                                            <?php }?>
                                            <?php if($lp['Paiement']['id']==5){?>
                                             <tr>
                                                <td colspan="4"> Montant Brut</td>
                                                <td><?php echo $lp['Piecereglementclient']['montant_brut']; ?></td>
                                            </tr>
                                             <tr>
                                                <td colspan="4"> Montant Net</td>
                                                <td><?php echo $lp['Piecereglementclient']['montant_net']; ?></td>
                                            </tr>
                                            
                                            <?php }?>
                                            </tbody>
                                        </table> <br>
                                            <?php } ?>
                                        
              			</div>
                                 </div>
<?php echo $this->Form->end();?>
	
</div></div></div></div>


	

