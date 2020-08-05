
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Alimentation caisse'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Reglement',array('autocomplete' => 'off','class'=>'form-horizontal','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
                                     <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        <table style="width:100%"><tr><td style="width:45%">
                                        <table style="width:100%">
                                            <tr><td name="data[piece][0][trcarnetnum]" id="trcarnetnuma0" index="0"  champ="trcarnetnuma" table="piece"   class="modecheque" >Souche chequier</td>  
                                                <td  name="data[piece][0][trcarnetnum]" id="trcarnetnumb0" index="0"  champ="trcarnetnumb" table="piece"   class="modecheque"><?php 
                                                 echo $this->Form->input('carnetcheque_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select getnumcheque  ','empty'=>'veuillez choisir',
                                                     'label'=>'','index'=>0,'champ'=>'carnetcheque_id','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][carnetcheque_id]') );   
                                                 ?></td>
                                            </tr>
                                             <tr>
                                                <td name="data[piece][0][trnum]" id="trnuma0" index="0"  champ="trnuma" table="piece"   class="modecheque" >Numéro pièce</td>  
                                                
                                                <td  name="data[piece][0][trnum]" id="trnumb0" index="0"  champ="trnumb" table="piece"   class="modecheque">
                                                   <div class='form-group' id="divnumc0" index="0"  champ="divnumc" table="piece"   >
                                                       <label class='col-md-2 control-label'></label>
                                                     <div class='col-sm-10'  name="data[piece][0][trnum]" id="trnumc0" index="0"  champ="trnumc" table="piece" class="modecheque">     </div>
                                                   </div>
                                                </td>   
                                            </tr>
                                        </table></td>
                                        <td style="width:10%"> </td>    
                                                <td style="width:45%">     
                                          <table style="width:100%">
                                               <tr >
                                                <td name="data[piece][0][trechance]" id="trechancea0" index="0"  champ="trechancea" table="piece"   class="modecheque">Echéance</td>  
                                                <td name="data[piece][0][trechance]" id="trechanceb0" index="0"  champ="trechanceb" table="piece"   class="modecheque"><?php 
                                                 echo $this->Form->input('echance',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','label'=>'','type'=>'text','index'=>0,'champ'=>'echance','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][echance]') );   
                                               ?> </td>  
                                            </tr>
                                              <tr>
                                                <td >Montant</td>  
                                                <td  ><?php 
                                                 echo $this->Form->input('montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control mnt','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>0,'champ'=>'montant','id'=>'montant0','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant]') );   
                                               ?> </td>  
                                            </tr>
                                            </table>
                                   </td></tr>
                                    </table>
                                          </tbody>
                                    </div></div>
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button id="btnenr" disabled type="submit" class="btn btn-primary testmontant">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

