<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Affectations/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<?php $p=CakeSession::read('depot');
       if($p==0){
         $numspecial="";
       }
         ?>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Affectation règlement client'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Affectation',array('autocomplete' => 'off','class'=>'form-horizontal','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
                if($p==0){
                echo $this->Form->input('pointdevente_id',array('id'=>'pointdevente_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select numspecial'));
                }
		echo $this->Form->input('client_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'clientid','class'=>'form-control affectationreglement select ','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'veuillez choisir','value'=>$client_id) );
		echo $this->Form->input('numeroconca',array('id'=>'numeroconca','type'=>'hidden','value'=>$mm,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('model',array('id'=>'model','type'=>'hidden','value'=>'Reglementclient','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('montant',array('value'=>$avance,'type'=>'text','id'=>'avance','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?></div><div class="col-md-6"><?php
                echo $this->Form->input('Date',array('id'=>'datereg','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly testdate','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text','value'=>date("d/m/Y")) );
                echo $this->Form->input('Date',array('id'=>'today','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'hidden','value'=>date("d/m/Y")) );
		echo $this->Form->input('numero',array('id'=>'numero','value'=>$numspecial,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
//echo $this->Form->input('Montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		//echo $this->Form->input('versement',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?>
  </div>  
                                    <?php if($client_id!=0&&$facture!=array()){?>
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
                                                
                                                  <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($facture as $i=>$fac){//debug($b);die;?>
                                            <tr>
                                                <td> <?php echo $fac['Factureclient']['numero']; ?></td>
                                                <td><?php echo $fac['Factureclient']['date']; ?></td>
                                                <td><?php echo $fac['Factureclient']['totalttc']; ?></td>
                                                <td><?php echo $fac['Factureclient']['Montant_Regler']; ?></td>
                                                 <td><?php echo $fac['Factureclient']['totalttc']-$fac['Factureclient']['Montant_Regler']; ?></td>
<!--                                                 <td><input type="text" name="data[Lignereglement][<?php echo $i; ?>][remise]" id="remise<?php echo $i;?>" class="form-control remisel " index="<?php echo $i; ?>" value="0.000">
                                                            -->
                                             </td>
                                             <td><input type="checkbox" name="data[Lignereglement][<?php echo $i; ?>][factureclient_id]" id="facture_id<?php echo $i; ?>" index="<?php echo $i; ?>" class="chekaffreglement" value="<?php echo $fac['Factureclient']['id'] ?>" mnt="<?php echo $fac['Factureclient']['totalttc']-$fac['Factureclient']['Montant_Regler']; ?>" >
                                           </td>
                                            </tr>
                                            <?php }?>
                                        <input type="hidden" name="max" value="<?php echo $i; ?>" id="max">
                                              
                                        
                                        <tr>
                                                <td colspan="4"> Total factures</td>
                                                <td colspan="2">
                                                    <input type="text" name="data[Affectation][ttpayer]" id="ttpayer" class="form-control testttpayer"  value="0.000" readonly>
                                                </td> 
                                            </tr>
                                            
                                             
                                                                <tr>
                                      
                                       
                                     </tbody>
                                            
                                     
                                    </table>
                                    </div></div>
                                   
                                    
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button id="btnenr" disabled type="submit" class="btn btn-primary testmontant">Enregistrer</button>
                                            </div>
                                        </div>
                                     <?php } ?>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

