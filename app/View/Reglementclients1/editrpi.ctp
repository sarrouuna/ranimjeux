<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Reglementclients/indexrpi"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification Reglementclient'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Reglementclient',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('client_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','id'=>'clientid','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('Date',array('id'=>'datereg','value'=>$date,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly testdate','type'=>'text','required data-bv-notempty-message'=>'Champ Obligatoire') );
                echo $this->Form->input('Date',array('id'=>'today','value'=>$date,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'hidden','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?></div><div class="col-md-6"><?php
                echo $this->Form->input('numero',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('Montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'text','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?>
  </div>    
                                    <input type="hidden" value="1"  id="typefrs">
                                     <?php if($facture!=array()){?>
                                     <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="table">
                                        <thead>
                                            <tr>
                                                <td style="width:15%">Numéro</td>
                                                <td style="width:15%">Date</td>
                                                <td style="width:30%">Montant</td>
                                                <td style="width:30%">Reste</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                              <?php   //debug($facture);die;
                                              $total=0;
                                                      foreach($facture as $i=>$fac){ if ($fac['Reglementclient']['client_id']==$client_id) {
                                            if(@$fac['Piecereglementclient']['reglement']==$id){        
                                            $lignereglement=ClassRegistry::init('Lignereglementclient')->find('first',array('conditions'=>array('Lignereglementclient.piecereglementclient_id'=>$fac['Piecereglementclient']['id'],'Lignereglementclient.reglementclient_id'=>$id),'recursive'=>0));  
                                            $mpayer=$lignereglement['Lignereglementclient']['Montant'];
                                            }else{
                                            $mpayer=0;    
                                            }          
                                            ?>
                                            <tr>
                                                <td style="width:25%"> <?php echo $fac['Piecereglementclient']['num']; ?></td>
                                                <td style="width:25%"><?php echo date("d/m/Y",strtotime(str_replace('-','/',$fac['Piecereglementclient']['echance']))); ?></td>
                                                <td style="width:25%"><?php echo $fac['Piecereglementclient']['montant']; ?></td>
                                                <td><?php echo number_format(($fac['Piecereglementclient']['montant']-$fac['Piecereglementclient']['mantantregler'])+$mpayer,3, '.', ' '); ?></td>
                                             <td style="width:25%"><input type="checkbox"<?php if(@$fac['Piecereglementclient']['reglement']==$id){?> checked="checked"<?php $total=$total+$fac['Piecereglementclient']['montant']; } ?> name="data[Lignereglement][<?php echo $i; ?>][piecereglementclient_id]" id="facture_id<?php echo $i; ?>" index="<?php echo $i; ?>" class="chekreglement" value="<?php echo $fac['Piecereglementclient']['id'] ?>" mnt="<?php echo $fac['Piecereglementclient']['montant']; ?>" >
                                           </td>
                                            </tr>
                                            <?php } }?>
                                        <input type="hidden" name="max" value="<?php echo $i; ?>" id="max">
                                              
                                        
                                        <tr>
                                                <td colspan="3"> Total Pieces </td>
                                                <td colspan="2">
                                                    <input type="text" name="data[Reglementclient][ttpayer]" id="ttpayer" class="form-control"  value="<?php echo number_format($total,3, '.', ' ') ?>" readonly>
                                                </td> 
                                            </tr>
                                             
                                             <tr>
                                                <td colspan="3">Montant à payer</td>
                                                <td colspan="2">
                                                    <input type="text" name="data[Reglementclient][Montant]" id="Montant" class="form-control"  value="<?php echo number_format(@$piecesregclient[0]['Reglementclient']['Montant'],3, '.', ' ') ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"> Net à payer</td>
                                                <td colspan="2">
                                                    <input type="text" name="data[Reglementclient][netapayer]" id="netpayer" class="form-control netapayer"  value="<?php echo number_format($total,3, '.', ' ') ?>" readonly>
                                                </td>
                                            </tr>
                                             
                                                                <tr>
                                                <td colspan="5">
                                                    
                                                   <div class="panel-heading">
                                    <h3 class="panel-title">Pièces règlement</h3>
                                    
                                    <a class="btn btn-danger ajouterligne" table='table' index='index' tr='type'  style="
                                    float: right; 
                                    position: relative;
                                    top: -25px;"> <i class="fa fa-plus-circle"  ></i>Ajouter ligne</a>
                                  
                                </div></td>
                                            </tr>
                                            <tr  class='type'  style="display: none !important"> 
                                                <td colspan="4">
                                        <table>
                                             <tr>
                                                <td >Mode règlement </td>  
                                                <td ><?php 
                                                 echo $this->Form->input('paiement_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control editmodereglementclient  ',
                                                    // 'empty'=>'veuillez choisir',
                                                     'label'=>'','index'=>0,'id'=>'paiement_id','champ'=>'paiement_id','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][paiement_id]') );   
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
                                                 echo $this->Form->input('montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control editmnt','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>'','champ'=>'montant','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant]') );   
                                                 echo $this->Form->input('favid',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'hidden','index'=>'','champ'=>'favid','id'=>'','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][favid]') );   
                                                 ?> </td>  
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
                                                   <div class='form-group ' id="" index="0"  champ="divnump" table="piece"  style="display:none" >
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
                                                             
                                    <?php   foreach ($piecesregclient as $i=>$piece){ //debug($piece); ?>        
                                            
                                            <tr>
                                                <td colspan="4">
                                        <table>
                                             <tr>
                                                <td >Mode règlement </td>  
                                                <td ><?php 
                                                 echo $this->Form->input('paiement_id',array('value'=>$piece['Piecereglementclient']['paiement_id'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control editmodereglementclient select  ',
                                                     //'empty'=>'veuillez choisir',
                                                     'label'=>'','index'=>$i,'id'=>'paiement_id'.$i,'champ'=>'paiement_id','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][paiement_id]') );   
                                               ?> </td>  
                                            </tr>
<!--                                            <tr <?php  if($piece['Piecereglementclient']['paiement_id']!=5){?>   style="display:none" <?php }?> id="trmontantbrut<?php echo $i  ?>"   >
                                                 <td name="data[piece][<?php echo $i  ?>][trmontantbrut]" id="trmontantbruta<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trmontantbruta" table="piece"   class="modecheque">Montant brut</td>  
                                                 <td name="data[piece][<?php echo $i  ?>][trmontantbrut]" id="trmontantbrutb<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trmontantbrutb" table="piece"   class="modecheque"><?php 
                                                   echo $this->Form->input('montant_brut',array('value'=>$piece['Piecereglementclient']['montant_brut'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control editmontantbrut','label'=>'','type'=>'text','index'=>$i,'champ'=>'montantbrut','id'=>'montantbrut'.$i,'table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][montant_brut]') );   
                                              ?> </td>  
                                            </tr>
                                           <tr  <?php  if($piece['Piecereglementclient']['paiement_id']!=5){?>   style="display:none" <?php }?> id="trtaux<?php echo $i  ?>"  >
                                                    <td name="data[piece][<?php echo $i  ?>][trtaux]" id="trtauxa<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trtauxa" table="piece"  class="modecheque">Taux</td>  
                                                    <td name="data[piece][<?php echo $i  ?>][trtaux]" id="trtauxb<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trtauxb" table="piece"  class="modecheque"><?php 
                                                     echo $this->Form->input('valeur_id',array('value'=>$piece['Piecereglementclient']['to_id'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'select editmontantbrut','label'=>'','index'=>$i,'champ'=>'taux','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][taux]','id'=>'taux'.$i,'empty'=>'Veuillez choisir') );   
                                                   ?> </td>  
                                             </tr>-->
                                          <tr>
                                                    <td>Montant</td>  
                                                    <td  ><?php 
                                                     echo $this->Form->input('montant',array('value'=>$piece['Piecereglementclient']['montant'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control editmnt','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>$i,'champ'=>'montant','id'=>'montant'.$i,'table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][montant]') );   
                                                     echo $this->Form->input('favid',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'hidden','index'=>$i,'champ'=>'favid','id'=>'favid'.$i,'table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][favid]') );   
                                                     ?> </td>  
                                            </tr>
<!--                                            <tr  <?php  if($piece['Piecereglementclient']['paiement_id']!=5){?>   style="display:none" <?php }?> id="trmontantnet<?php echo $i  ?>" >
                                                    <td name="data[piece][<?php echo $i  ?>][trmontantnet]" id="trmontantneta<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trmontantneta" table="piece"  class="modecheque">Montant Net</td>  
                                                    <td name="data[piece][<?php echo $i  ?>][trmontantnet]" id="trmontantnetb<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trmontantnetb" table="piece"   class="modecheque"><?php 
                                                     echo $this->Form->input('montant_net',array('value'=>$piece['Piecereglementclient']['montant_net'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>$i,'id'=>'montantnet'.$i,'champ'=>'montantnet','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][montant_net]') );   
                                                   ?> </td>  
                                                </tr>  -->
                                            <tr  <?php  if(($piece['Piecereglementclient']['paiement_id']==1)||($piece['Piecereglementclient']['paiement_id']==5)||($piece['Piecereglementclient']['paiement_id']==6)){?>   style="display:none" <?php }?> id="trechance<?php echo $i  ?>" >
                                                    <td name="data[piece][<?php echo $i?>][trechance]" id="trechancea[<?php echo $i?>" index="[<?php echo $i?>"  champ="trechancea" table="piece"   class="modecheque">Echéance</td>  
                                                    <td name="data[piece][<?php echo $i?>][trechance]" id="trechanceb[<?php echo $i?>" index="[<?php echo $i?>"  champ="trechanceb" table="piece"  class="modecheque"><?php 
                                                     echo $this->Form->input('echance',array('value'=>date("d/m/Y",strtotime(str_replace('-','/',$piece['Piecereglementclient']['echance']))),'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly testecheance','label'=>'','type'=>'text','index'=>$i,'id'=>'dateecheance'.$i,'champ'=>'echance','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][echance]') );   
                                                   ?> </td>  
                                              </tr>
                                            <tr  <?php  if(($piece['Piecereglementclient']['paiement_id']==1)){?>   style="display:none" <?php }?> id="trnum<?php echo $i  ?>" >
                                                <td name="data[piece][<?php echo $i?>][trnum]" id="trnuma<?php echo $i?>" index="<?php echo $i?>"  champ="trnuma" table="piece"   class="modecheque" >Numéro pièce</td>  
                                                <td  name="data[piece][<?php echo $i?>][trnum]" id="trnumb<?php echo $i?>" index="<?php echo $i?>"  champ="trnumb" table="piece"   class="modecheque"><?php 
                                                // echo $this->Form->input('num_piece',array('value'=>$piece['Piecereglementclient']['num'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>$i,'champ'=>'num_piece','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][num_piece]') );   
                                               ?> 
                                                <div class='form-group' id="divnumc<?php echo $i?>" index="<?php echo $i?>"  champ="divnumc" table="piece"  >
                                                       <label class='col-md-2 control-label'></label>
                                                     <div class='col-sm-10'  name="data[piece][<?php echo $i?>][trnum]" id="trnumf<?php echo $i?>" index="<?php echo $i?>"  champ="trnumf" table="piece" class="modecheque">     </div>
                                                   </div>
                                                   <div class='form-group ' id="divnump<?php echo $i?>" index="<?php echo $i?>"  champ="divnump" table="piece"   >
                                                     <div class='col-sm-12'>
                                                     <?php  echo $this->Form->input('num_piece',array('value'=>$piece['Piecereglementclient']['num'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>$i,'champ'=>'num_piece','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][num_piece]') );?>
                                                     </div>
                                                   </div>
                                                </td>  
                                            </tr>
                                            <tr  <?php  if(($piece['Piecereglementclient']['paiement_id']==1)||($piece['Piecereglementclient']['paiement_id']==5)||($piece['Piecereglementclient']['paiement_id']==6)){?>   style="display:none" <?php }?> id="trbanque<?php echo $i  ?>" >
                                                <td name="data[piece][<?php echo $i?>][banque]" id="trbanquea<?php echo $i?>" index="<?php echo $i?>"  champ="banquea" table="piece"  class="modecheque" >Banque</td>  
                                                    <td  name="data[piece][<?php echo $i?>][banque]" id="trbanqueb<?php echo $i?>" index="<?php echo $i?>"  champ="banqueb" table="piece"  class="modecheque"><?php 
                                                     echo $this->Form->input('banque',array('value'=>$piece['Piecereglementclient']['banque'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>$i,'champ'=>'banque','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][banque]') );   
                                                 ?> </td>  
                                                </tr>
                                            </tr>
                                            </table>
                                                    </td>
                                                 <td><i index="<?php echo $i?>"  class="fa fa-times supreg" style="color: #c9302c;font-size: 22px;"></td>
                                        </tr>
                                      
                                    <?php  }  ?>         
                                     <input type="hidden" value="<?php echo @$i; ?>" class="index" id="index">
                                     </tbody>
                                            
                                     
                                    </table>
                                    </div></div>
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </div>
                                    <?php } ?>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

