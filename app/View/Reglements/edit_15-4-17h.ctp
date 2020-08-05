<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Reglements/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification Reglements'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Reglement',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('fournisseur',array('div'=>'form-group','value'=>$fournisseur,'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?></div><div class="col-md-6"><?php
		echo $this->Form->input('Date',array('div'=>'form-group','value'=>$date,'between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'text','class'=>'form-control datePickerOnly ','required data-bv-notempty-message'=>'Champ Obligatoire') );
	      //echo $this->Form->input('Montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?>
  </div>    
                 <?php if($facture!=array()){?>
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
                                            <?php foreach($facture as $f=>$fac){//debug($b);die;?>
                                            <tr>
                                                <td> <?php echo $fac['Facture']['numero']; ?></td>
                                                <td><?php echo $fac['Facture']['date']; ?></td>
                                                <td><?php echo $fac['Facture']['totalttc']; ?></td>
                                                <td><?php echo $fac['Facture']['Montant_Regler']-$fac['Facture']['Montant_Regler']; ?></td>
                                                 <td><?php echo $fac['Facture']['totalttc']; ?></td>
<!--                                                 <td><input type="text" name="data[Lignereglement][<?php echo $f; ?>][remise]" id="remise<?php echo $f;?>" class="form-control remisel " index="<?php echo $f; ?>" value="0.000">
                                                            -->
                                             </td>
                                           <td><input type="checkbox"<?php if(@$facreg[@$fac['Facture']['id']]==1){?> checked="checked"<?php  } ?> name="data[Lignereglement][<?php echo $f; ?>][facture_id]" id="facture_id<?php echo $f; ?>" index="<?php echo $f; ?>" class="chekreglement" value="<?php echo $fac['Facture']['id'] ?>" mnt="<?php echo $fac['Facture']['totalttc']-$fac['Facture']['Montant_Regler']; ?>" >
                                           </td>
                                            </tr>
                                            <?php }?>
                                        <input type="hidden" name="max" value="<?php echo $f; ?>" id="max">
                                              
                                        
                                        <tr>
                                                <td colspan="4"> Total factures</td>
                                                <td colspan="2">
                                                    <input type="text" name="data[Reglement][ttpayer]" id="ttpayer" class="form-control"  value="<?php echo $totalfacture ?>" readonly>
                                                </td> 
                                            </tr>
                                             
                                             <tr>
                                                <td colspan="4">Montant à payer</td>
                                                <td colspan="2">
                                                    <input type="text" name="data[Reglement][Montant]" id="Montant" class="form-control"  value="<?php echo $piecesreg[0]['Reglement']['Montant'] ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"> Net à payer</td>
                                                <td colspan="2">
                                                    <input type="text" name="data[Reglement][netapayer]" id="netapayer" class="form-control netapayer"  value="0.000" readonly>
                                                </td>
                                            </tr>
                                             
                                                                <tr>
                                                <td colspan="6">
                                                     
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
                                                <td>Mode règlement </td>  
                                                <td ><?php 
                                                 echo $this->Form->input('paiement_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control modereglement  ',
                                                     'label'=>'','index'=>0,'champ'=>'paiement_id','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][paiement_id]') );   
                                               ?> </td>
                                                
                                            </tr>
                                            <tr >
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
                                            </tr>
                                            <tr>
                                                <td >Montant</td>  
                                                <td  ><?php 
                                                 echo $this->Form->input('montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control mnt','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>0,'champ'=>'montant','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant]') );   
                                               ?> </td>  
                                            </tr>
                                            <tr >
                                                <td name="data[piece][0][trmontantnet]" id="" index="0"  champ="trmontantneta" table="piece"  style="display:none" class="modecheque">Montant Net</td>  
                                                <td name="data[piece][0][trmontantnet]" id="" index="0"  champ="trmontantnetb" table="piece"  style="display:none" class="modecheque"><?php 
                                                 echo $this->Form->input('montant_net',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>0,'champ'=>'montantnet','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant_net]') );   
                                               ?> </td>  
                                            </tr>
<!--                                            <tr>
                                                <td >N° recu</td>  
                                                <td  ><?php 
                                                 echo $this->Form->input('num_recu',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>0,'champ'=>'num_recu','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][num_recu]') );   
                                               ?> </td>  
                                            </tr>-->
                                           
                                            <tr >
                                                <td name="data[piece][0][trechance]" id="" index="0"  champ="trechancea" table="piece"  style="display:none" class="modecheque">Echéance</td>  
                                                <td name="data[piece][0][trechance]" id="" index="0"  champ="trechanceb" table="piece"  style="display:none" class="modecheque"><?php 
                                                 echo $this->Form->input('echance',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>0,'champ'=>'echance','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][echance]') );   
                                               ?> </td>  
                                            </tr>
                     <!-- //***************************************************--->
                                            <tr><td name="data[piece][0][trcarnetnum]" id="" index="0"  champ="trcarnetnuma" table="piece"  style="display:none" class="modecheque" >Numéro de carnet</td>  
                                                <td  name="data[piece][0][trcarnetnum]" id="" index="0"  champ="trcarnetnumb" table="piece"  style="display:none" class="modecheque"><?php 
                                                 echo $this->Form->input('carnetcheque_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control  getnumcheque  ','empty'=>'veuillez choisir',
                                                     'label'=>'','index'=>0,'champ'=>'carnetcheque_id','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][carnetcheque_id]') );   
                                                 ?></td>
                                            </tr>
                       <!-- //***************************************************--->
                                             <tr >
                                                <td name="data[piece][0][trnum]" id="" index="0"  champ="trnuma" table="piece"  style="display:none" class="modecheque" >Numéro pièce</td>  
                                                <td  name="data[piece][0][trnum]" id="" index="0"  champ="trnumb" table="piece"  style="display:none" class="modecheque">
                                                 <div class='form-group' id="" index="0"  champ="divnumc" table="piece"  style="display:none" >
                                                    <label class='col-md-2 control-label'></label>
                                                    <div class='col-sm-10' name="data[piece][0][trnum]" id="" index="0"  champ="trnumc" table="piece"   class="modecheque">     </div>
                                                 </div>
                                                 <div class='form-group' id="" index="0"  champ="divnump" table="piece"  style="display:none" >
                                                    <div class='col-sm-12' ><?php echo $this->Form->input('num_piece',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>0,'champ'=>'num_piece','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][num_piece]') );?></div>
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
                                                              
                                       
                                                   
                                <?php   foreach ($piecesreg as $i=>$piece){ ?> 
                                        
                                                <tr>
                                            <td colspan="5">
                                            <table>
                                                <tr>
                                                    <td >Mode règlement </td>  
                                                    <td ><?php 
                                                     echo $this->Form->input('paiement_id',array('value'=>$piece['Piecereglement']['paiement_id'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control modereglement select  ',
                                                         'label'=>'','index'=>$i,'id'=>'paiement_id'.$i,'champ'=>'paiement_id','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][paiement_id]') );   
                                                   ?> </td>  
                                                </tr>                                                
                                                <tr>
                                                    <td>Montant</td>  
                                                    <td  ><?php 
                                                     echo $this->Form->input('montant',array('value'=>$piece['Piecereglement']['montant'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control mnt','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>$i,'champ'=>'montant','id'=>'montant'.$i,'table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][montant]') );   
                                                   ?> </td>  
                                                </tr>
                                                <tr <?php  if($piece['Piecereglement']['paiement_id']!=5){?>   style="display:none" <?php }?>   >
                                                    <td name="data[piece][<?php echo $i  ?>][trmontantbrut]" id="trmontantbruta<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trmontantbruta" table="piece"  style="display:none" class="modecheque">Montant brut</td>  
                                                    <td name="data[piece][<?php echo $i  ?>][trmontantbrut]" id="trmontantbrutb<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trmontantbrutb" table="piece"  style="display:none" class="modecheque"><?php 
                                                     echo $this->Form->input('montant_brut',array('value'=>$piece['Piecereglement']['montantbrut'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control montantbrut','label'=>'','type'=>'text','index'=>$i,'champ'=>'montantbrut','id'=>'montantbrut'.$i,'table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][montant_brut]') );   
                                                   ?> </td>  
                                                </tr>
                                                <tr  <?php  if($piece['Piecereglement']['paiement_id']!=5){?>   style="display:none" <?php }?>  >
                                                    <td name="data[piece][<?php echo $i  ?>][trtaux]" id="trtauxa<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trtauxa" table="piece"  style="display:none" class="modecheque">Taux</td>  
                                                    <td name="data[piece][<?php echo $i  ?>][trtaux]" id="trtauxb<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trtauxb" table="piece"  style="display:none" class="modecheque"><?php 
                                                     echo $this->Form->input('valeur_id',array('value'=>$piece['Piecereglement']['taux'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'select montantbrut','label'=>'','index'=>$i,'champ'=>'taux','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][taux]','id'=>'taux'.$i,'empty'=>'Veuillez choisir') );   
                                                   ?> </td>  
                                                </tr>
                                               
                                                <tr  <?php  if($piece['Piecereglement']['paiement_id']!=5){?>   style="display:none" <?php }?>  >
                                                    <td name="data[piece][<?php echo $i  ?>][trmontantnet]" id="trmontantneta<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trmontantneta" table="piece"  style="display:none" class="modecheque">Montant Net</td>  
                                                    <td name="data[piece][<?php echo $i  ?>][trmontantnet]" id="trmontantnetb<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trmontantnetb" table="piece"  style="display:none" class="modecheque"><?php 
                                                     echo $this->Form->input('montant_net',array('value'=>$piece['Piecereglement']['montantnet'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>$i,'id'=>'montantnet'.$i,'champ'=>'montantnet','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][montant_net]') );   
                                                   ?> </td>  
                                                </tr>
                                                <tr  <?php  if(($piece['Piecereglement']['paiement_id']==1)||($piece['Piecereglement']['paiement_id']==5)){?>   style="display:none" <?php }?>  >
                                                    <td name="data[piece][[<?php echo $i?>][trechance]" id="trechancea[<?php echo $i?>" index="[<?php echo $i?>"  champ="trechancea" table="piece"   class="modecheque">Echéance</td>  
                                                    <td name="data[piece][[<?php echo $i?>][trechance]" id="trechanceb[<?php echo $i?>" index="[<?php echo $i?>"  champ="trechanceb" table="piece"  class="modecheque"><?php 
                                                     echo $this->Form->input('echance',array('value'=>date("d/m/Y",strtotime(str_replace('-','/',$piece['Piecereglement']['echance']))),'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','label'=>'','type'=>'text','index'=>$i,'champ'=>'echance','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][echance]') );   
                                                   ?> </td>  
                                                </tr>
                 <!-- //***************************************************--->
                                                <tr <?php  if($piece['Piecereglement']['paiement_id']!=2){?>   style="display:none" <?php }?>  >
                                                    <td name="data[piece][<?php echo $i?>][trcarnetnum]" id="trcarnetnuma<?php echo $i?>" index="<?php echo $i?>"  champ="trcarnetnuma" table="piece"   class="modecheque" >Numéro de carnet</td>  
                                                    <td  name="data[piece][<?php echo $i?>][trcarnetnum]" id="trcarnetnumb<?php echo $i?>" index="<?php echo $i?>"  champ="trcarnetnumb" table="piece"   class="modecheque"><?php 
                                                     echo $this->Form->input('carnetcheque_id',array('value'=>$piece['Piecereglement']['carnetcheque_id'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select getnumcheque  ','empty'=>'veuillez choisir',
                                                         'label'=>'','index'=>0,'champ'=>'carnetcheque_id','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][carnetcheque_id]') );   
                                                     ?></td>
                                                </tr>
                 <!-- //***************************************************--->
                                                 <tr <?php  if(($piece['Piecereglement']['paiement_id']==1)||($piece['Piecereglement']['paiement_id']==5)){?>   style="display:none" <?php }?>>
                                                    <td name="data[piece][<?php echo $i?>][trnum]" id="trnuma<?php echo $i?>" index="<?php echo $i?>"  champ="trnuma" table="piece"   class="modecheque" >Numéro pièce</td>  

                                                    <td  name="data[piece][<?php echo $i?>][trnum]" id="trnumb<?php echo $i?>" index="<?php echo $i?>"  champ="trnumb" table="piece"   class="modecheque">
                                                      <div class='form-group' id="divnumc<?php echo $i?>" index="<?php echo $i?>"  champ="divnumc" table="piece" <?php  if($piece['Piecereglement']['paiement_id']!=2){?>   style="display:none" <?php }?>   >
                                                           <label class='col-md-2 control-label'></label>
                                                         <div class='col-sm-10'  name="data[piece][<?php echo $i?>][trnum]" id="trnumc<?php echo $i?>" index="<?php echo $i?>"  champ="trnumc" table="piece" class="modecheque">     </div>
                                                       </div>
                                              
                                                    <div class="form-group"  <?php  if($piece['Piecereglement']['paiement_id']!=2){?>   style="display:none" <?php }?>  >
                                                    <label class='col-md-2 control-label'></label>       
                                                    <div class="col-sm-10" id="trnumc<?php echo $i?>" index="<?php echo $i?>"  champ="trnumc" table="piece" >   
                                                        <select name="data[pieceregelemnt][<?php echo $i?>][cheque_id]" table="Articlefournisseur" index="<?php echo $i?>" id="cheque_id<?php echo $i?>" champ="cheque_id" class="form-control select">
                                                           <option value="" >Veuillez choisir !!</option>
                                                           <?php foreach ($piece['Carnetcheque']['Cheque'] as $cheq){ if(($cheq['etat']=='0')||($cheq['id']==$piece['Piecereglement']['cheque_id'])){?>
                                                           <option value="<?php echo $cheq['id'] ?>" <?php if($cheq['id']==$piece['Piecereglement']['cheque_id']){ ?> selected="selected"<?php } ?> ><?php echo $cheq['numero']  ?></option>
                                                           <?php } }?>
                                                       </select></div></div>
                                           
                                                  </td>   
                                                </tr>
                                                <tr <?php if(($piece['Piecereglement']['paiement_id']!=3)||($piece['Piecereglement']['paiement_id']!=4)){?>   style="display:none" <?php }?>>
                                                    <td name="data[piece][<?php echo $i?>][banque]" id="trbanquea<?php echo $i?>" index="<?php echo $i?>"  champ="banquea" table="piece"  class="modecheque" >Banque</td>  
                                                    <td  name="data[piece][<?php echo $i?>][banque]" id="trbanqueb<?php echo $i?>" index="<?php echo $i?>"  champ="banqueb" table="piece"  class="modecheque"><?php 
                                                     echo $this->Form->input('banque',array('value'=>$piece['Carnetcheque']['banque'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>0,'champ'=>'banque','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][banque]') );   
                                                 ?> </td>  
                                                </tr>
                                                </table>
                                                        </td>
                                                        <td><i index="<?php echo $i?>"  class="fa fa-times supreg" style="color: #c9302c;font-size: 22px;"></td>
                                            </tr>        

                                <?php  }  ?>                                            
                                       <input type="hidden" value="<?php echo $i; ?>" class="index" id="index">
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

