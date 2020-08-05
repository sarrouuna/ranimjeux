<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Reglementclients/indexrpi"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<?php $p=CakeSession::read('depot');
       if($p==0){
         //$numspecial="";
       }
         ?>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout règlement client'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Reglementclient',array('autocomplete' => 'off','class'=>'form-horizontal','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
                if($p==0){
                echo $this->Form->input('pointdevente_id',array('value'=>@$poinvente,'id'=>'pointdevente_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select numspecial'));
                }
		echo $this->Form->input('client_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'clientid','class'=>'form-control clientpieceimp select ','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'veuillez choisir','value'=>$client_id) );
		echo $this->Form->input('numeroconca',array('id'=>'numeroconca','type'=>'hidden','value'=>@$mm,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('model',array('id'=>'model','type'=>'hidden','value'=>'Reglementclient','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
               
//echo $this->Form->input('Retenu',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?></div><div class="col-md-6"><?php
                echo $this->Form->input('Date',array('id'=>'datereg','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly testdate','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text','value'=>date("d/m/Y")) );
                echo $this->Form->input('Date',array('id'=>'today','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'hidden','value'=>date("d/m/Y")) );
		echo $this->Form->input('numero',array('id'=>'numero','value'=>@$numspecial,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'text','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
//echo $this->Form->input('Montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		//echo $this->Form->input('versement',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?>
  </div> 
                                    <input type="hidden" value="1"  id="typefrs">
                                    <?php if($client_id!=0&&$facture!=array()){?>
                                     <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="table">
                                        <thead>
                                            <tr>
                                                <td>Numéro</td>
                                                <td>Date</td>
                                                <td>Montant</td>
                                                <td>Reste</td>
                                                
                                                  <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $reste=0;
                                            //debug($facture);
                                            foreach($facture as $i=>$fac){if ($fac['Reglementclient']['client_id']==$client_id) {//debug($b);die;
                                                $reste=$fac['Piecereglementclient']['montant']-$fac['Piecereglementclient']['mantantregler'];
                                                ?>
                                            <tr style="width:100%">
                                                <td style="width:20%"> <?php echo $fac['Piecereglementclient']['num']; ?></td>
                                                <td style="width:20%"><?php echo date("d/m/Y",strtotime(str_replace('-','/',$fac['Piecereglementclient']['echance']))); ?></td>
                                                <td style="width:20%"><?php echo number_format($fac['Piecereglementclient']['montant'],3, '.', ' '); ?></td>
                                                 <td style="width:20%"><?php echo number_format($reste,3, '.', ' '); ?></td>
                                             </td>
                                             <td style="width:20%"><input type="checkbox" name="data[Lignereglement][<?php echo $i; ?>][piecereglementclient_id]" id="facture_id<?php echo $i; ?>" index="<?php echo $i; ?>" class="chekreglement" value="<?php echo $fac['Piecereglementclient']['id'] ?>" mnt="<?php echo $fac['Piecereglementclient']['montant']-$fac['Piecereglementclient']['mantantregler']; ?>" >
                                           </td>
                                            </tr>
                                            <?php }}?>
                                        <input type="hidden" name="max" value="<?php echo $i; ?>" id="max">
                                              
                                        
                                        <tr>
                                                <td colspan="4"> Total factures</td>
                                                <td colspan="2">
                                                    <input type="text" name="data[Reglementclient][ttpayer]" id="ttpayer" class="form-control"  value="0.000" readonly>
                                                </td> 
                                            </tr>
                                             
                                             <tr>
                                                <td colspan="4">Montant à payer</td>
                                                <td colspan="2">
                                                    <input type="text" name="data[Reglementclient][Montant]" id="Montant" class="form-control"  value="0.000" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"> Net à payer</td>
                                                <td colspan="2">
                                                    <input type="text" name="data[Reglementclient][netapayer]" id="netpayer" class="form-control netapayer"  value="0.000" readonly>
                                                </td>
                                            </tr>
                                             
                                                                <tr>
                                                <td colspan="6">
                                                     <input type="hidden" value="0" class="index" id="index">
                                                   <div class="panel-heading">
                                    <h3 class="panel-title">Pièces règlement</h3>
                                    
                                    <a class="btn btn-danger ajouterligne" table='table' index='index' tr='type'  style="
                                    float: right; 
                                    position: relative;
                                    top: -25px;"> <i class="fa fa-plus-circle"  ></i>Ajouter ligne</a>
                                  
                                </div></td>
                                            </tr>
                                            <tr  class='type'  style="display: none !important"> 
                                                <td colspan="5">
                                        <table>
                                             <tr>
                                                <td >Mode règlement </td>  
                                                <td ><?php 
                                                 echo $this->Form->input('paiement_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control modereglementclient  ',
                                                    // 'empty'=>'veuillez choisir',
                                                     'label'=>'','index'=>0,'champ'=>'paiement_id','id'=>'paiement_id','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][paiement_id]') );   
                                               ?> </td>
                                                
                                            </tr>
<!--                                            <tr >
                                                <td name="data[piece][0][trmontantbrut]" id="" index="0"  champ="trmontantbruta" table="piece"  style="display:none" class="modecheque">Montant brut</td>  
                                                <td name="data[piece][0][trmontantbrut]" id="" index="0"  champ="trmontantbrutb" table="piece"  style="display:none" class="modecheque"><?php 
                                                 echo $this->Form->input('montant_brut',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control montantbrut','label'=>'','type'=>'text','index'=>0,'champ'=>'montantbrut','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant_brut]') );   
                                               ?> </td>  
                                            </tr>
                                            <tr >
                                                <td name="data[piece][0][trtaux]" id="" index="0"  champ="trtauxa" table="piece"  style="display:none" class="modecheque">Taux</td>  
                                                <td name="data[piece][0][trtaux]" id="" index="0"  champ="trtauxb" table="piece"  style="display:none" class="modecheque"><?php 
                                                 echo $this->Form->input('valeur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'montantbrut','label'=>'','index'=>0,'champ'=>'taux','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][taux]','empty'=>'Veuillez choisir') );   
                                               ?> </td>  
                                            </tr>-->
                                            <tr>
                                                <td >Montant</td>  
                                                <td  ><?php 
                                                 echo $this->Form->input('montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control mnt','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>'','id'=>'','champ'=>'montant','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant]') ); 
                                                 echo $this->Form->input('favid',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control mnt','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'hidden','index'=>'','champ'=>'favid','id'=>'','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][favid]') );   
                                                ?>
                                                </td>  
                                            </tr>
<!--                                            <tr >
                                                <td name="data[piece][0][trmontantnet]" id="" index="0"  champ="trmontantneta" table="piece"  style="display:none" class="modecheque">Montant Net</td>  
                                                <td name="data[piece][0][trmontantnet]" id="" index="0"  champ="trmontantnetb" table="piece"  style="display:none" class="modecheque"><?php 
                                                 echo $this->Form->input('montant_net',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>0,'champ'=>'montantnet','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant_net]') );   
                                               ?> </td>  
                                            </tr>-->
<!--                                            <tr>
                                                <td >N° recu</td>  
                                                <td  ><?php 
                                                 echo $this->Form->input('num_recu',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>0,'champ'=>'num_recu','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][num_recu]') );   
                                               ?> </td>  
                                            </tr>-->
                                           
                                            <tr >
                                                <td name="data[piece][0][trechance]" id="" index="0"  champ="trechancea" table="piece"  style="display:none" class="modecheque">Echéance</td>  
                                                <td name="data[piece][0][trechance]" id="" index="0"  champ="trechanceb" table="piece"  style="display:none" class="modecheque"><?php 
                                                 echo $this->Form->input('echance',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control testecheance','label'=>'','type'=>'text','index'=>0,'id'=>'dateecheance','champ'=>'echance','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][echance]') );   
                                               ?> </td>  
                                            </tr>
                                             <tr >
                                                <td name="data[piece][0][trnum]" id="" index="0"  champ="trnuma" table="piece"  style="display:none" class="modecheque" >Numéro pièce</td>  
                                                <td  name="data[piece][0][trnum]" id="" index="0"  champ="trnumb" table="piece"  style="display:none" class="modecheque">
                                                <div class='form-group' id="" index="0"  champ="divnumc" table="piece"  style="display:none" >
                                                       <label class='col-md-2 control-label'></label>
                                                     <div class='col-sm-10'  name="data[piece][0][trnum]" id="" index="0"  champ="trnumf" table="piece" class="modecheque">     </div>
                                                   </div>
                                                   <div class='form-group ' id="" index="0"  champ="divnump" table="piece"   >
                                                     <div class='col-sm-12'>
                                                     <?php  echo $this->Form->input('num_piece',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>0,'champ'=>'num_piece','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][num_piece]') );?>
                                                     </div>
                                                   </div>
                                                </td>  
                                            </tr>
                                             <tr >
                                                <td name="data[piece][0][trbanque]" id="" index="0"  champ="trbanquea" table="piece"  style="display:none" class="modecheque" >Banque</td>  
                                                <td  name="data[piece][0][trBanque]" id="" index="0"  champ="trbanqueb" table="piece"  style="display:none" class="modecheque"><?php 
                                                 echo $this->Form->input('banque',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>0,'champ'=>'banque','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][banque]') );   
                                               ?> </td>  
                                            </tr>
                                            
                                            </table>
                                                    </td>  
                                                    <td><i index=""  class="fa fa-times supreg" style="color: #c9302c;font-size: 22px;"></td>
                                            </tr>
                                                                                  
                                            <tr>
                                                <td colspan="5">
                                        <table>
                                             <tr>
                                                <td >Mode règlement </td>  
                                                <td ><?php 
                                                 echo $this->Form->input('paiement_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control modereglementclient select  ',
                                                     //'empty'=>'veuillez choisir',
                                                     'label'=>'','index'=>0,'id'=>'paiement_id0','champ'=>'paiement_id','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][paiement_id]') );   
                                               ?> </td>  
                                            </tr>
<!--                                            <tr >
                                                <td name="data[piece][0][trmontantbrut]" id="trmontantbruta0" index="0"  champ="trmontantbruta" table="piece"  style="display:none" class="modecheque">Montant brut</td>  
                                                <td name="data[piece][0][trmontantbrut]" id="trmontantbrutb0" index="0"  champ="trmontantbrutb" table="piece"  style="display:none" class="modecheque"><?php 
                                                 echo $this->Form->input('montant_brut',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control montantbrut','label'=>'','type'=>'text','index'=>0,'champ'=>'montantbrut','id'=>'montantbrut0','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant_brut]') );   
                                               ?> </td>  
                                            </tr>
                                            <tr >
                                                <td name="data[piece][0][trtaux]" id="trtauxa0" index="0"  champ="trtauxa" table="piece"  style="display:none" class="modecheque">Taux</td>  
                                                <td name="data[piece][0][trtaux]" id="trtauxb0" index="0"  champ="trtauxb" table="piece"  style="display:none" class="modecheque"><?php 
                                                 echo $this->Form->input('valeur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'select montantbrut','label'=>'','index'=>0,'champ'=>'taux','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][taux]','id'=>'taux0','empty'=>'Veuillez choisir') );   
                                               ?> </td>  
                                            </tr>-->
                                            <tr>
                                                <td>Montant</td>  
                                                <td  ><?php 
                                                 echo $this->Form->input('montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control mnt','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>0,'champ'=>'montant','id'=>'montant0','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant]') );   
                                                 echo $this->Form->input('favid',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control mnt','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'hidden','index'=>0,'champ'=>'favid','id'=>'favid0','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][favid]') );   
                                                 ?> </td>  
                                            </tr>
<!--                                            <tr >
                                                <td name="data[piece][0][trmontantnet]" id="trmontantneta0" index="0"  champ="trmontantneta" table="piece"  style="display:none" class="modecheque">Montant Net</td>  
                                                <td name="data[piece][0][trmontantnet]" id="trmontantnetb0" index="0"  champ="trmontantnetb" table="piece"  style="display:none" class="modecheque"><?php 
                                                 echo $this->Form->input('montant_net',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>0,'id'=>'montantnet0','champ'=>'montantnet','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant_net]') );   
                                               ?> </td>  
                                            </tr>-->
                                            
<!--                                            <tr>
                                                <td >N° recu</td>  
                                                <td  ><?php 
                                                 echo $this->Form->input('num_recu',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>0,'champ'=>'num_recu','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][num_recu]') );   
                                               ?> </td>  
                                            </tr>-->
                                           
                                            <tr >
                                                <td name="data[piece][0][trechance]" id="trechancea0" index="0"  champ="trechancea" table="piece"  style="display:none" class="modecheque">Echéance</td>  
                                                <td name="data[piece][0][trechance]" id="trechanceb0" index="0"  champ="trechanceb" table="piece"  style="display:none" class="modecheque"><?php 
                                                 echo $this->Form->input('echance',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly testecheance','id'=>'dateecheance0','label'=>'','type'=>'text','index'=>0,'champ'=>'echance','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][echance]') );   
                                               ?> </td>  
                                            </tr>
                                             <tr >
                                                <td name="data[piece][0][trnum]" id="trnuma0" index="0"  champ="trnuma" table="piece"  style="display:none" class="modecheque" >Numéro pièce</td>  
                                                <td  name="data[piece][0][trnum]" id="trnumb0" index="0"  champ="trnumb" table="piece"  style="display:none" class="modecheque">
                                                <div class='form-group' id="divnumc0" index="0"  champ="divnumc" table="piece"  style="display:none" >
                                                       <label class='col-md-2 control-label'></label>
                                                     <div class='col-sm-10'  name="data[piece][0][trnum]" id="trnumf0" index="0"  champ="trnumf" table="piece" class="modecheque">     </div>
                                                   </div>
                                                   <div class='form-group ' id="divnump0" index="0"  champ="divnump" table="piece"  >
                                                     <div class='col-sm-12'>
                                                     <?php  echo $this->Form->input('num_piece',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>0,'champ'=>'num_piece','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][num_piece]') );?>
                                                     </div>
                                                   </div>
                                                </td>  
                                            </tr>
                                             <tr >
                                                <td name="data[piece][0][banque]" id="trbanquea0" index="0"  champ="banquea" table="piece"  style="display:none" class="modecheque" >Banque</td>  
                                                <td  name="data[piece][0][banque]" id="trbanqueb0" index="0"  champ="banqueb" table="piece"  style="display:none" class="modecheque"><?php 
                                                 echo $this->Form->input('banque',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>0,'champ'=>'banque','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][banque]') );   
                                               ?> </td>  
                                            </tr>
                                            </table>
                                                    </td>
                                                    <td><i index="0"  class="fa fa-times supreg" style="color: #c9302c;font-size: 22px;"></td>
                                        </tr>
                                       
                                     </tbody>
                                            
                                     
                                    </table>
                                    </div></div>
                                   
                                    
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button id="btnenr" disabled type="submit" class="btn btn-primary ">Enregistrer</button>
                                            </div>
                                        </div>
                                     <?php } ?>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

