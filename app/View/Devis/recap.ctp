<div>     
                    <table border="0" style="width:100%">     
                        <tr style="width:100%">
                            <td align="left" style="width:20%">Délai de livraison </td><td align="center" style="width:50%">
                            <?php echo $this->Form->input('delaidelivraison ',array('value'=>@$delaidelivraison,'name'=>'','id'=>'delaidelivraison','table'=>'etatpieceregelemnt','index'=>'0','champ'=>'Delaidelivraison','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                            <?php echo $this->Form->input('id ',array('value'=>@$id,'type'=>'hidden','name'=>'','id'=>'id','table'=>'etatpieceregelemnt','index'=>'0','champ'=>'id','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                            </td>
                        </tr>   
                    </table>
                        <br><br>
                    <table border="0" style="width:100%">     
                        <tr style="width:100%">
                            <td align="left" style="width:20%">Validité de l'offre</td><td align="center" style="width:50%">
                            <?php echo $this->Form->input('validite',array('value'=>@$validite,'label'=>'','div'=>'form-group', 'name' => '','table'=>'etatpieceregelemnt','index'=>'0','id'=>'validite','champ'=>'Validite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>

                            </td>
                        </tr>   
                    </table>
                        <br><br>
                    <table border="0" style="width:100%">     
                        <tr style="width:100%">
                            <td align="left" style="width:20%">Mode de paiement</td><td align="center" style="width:50%">
                            <?php echo $this->Form->input('modedepaiement',array('value'=>@$modedepaiement,'name'=>'','id'=>'modedepaiement','table'=>'etatpieceregelemnt','index'=>'0','champ'=>'modedepaiement','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                            </td>
                        </tr>   
                    </table>
                    </div>   

<br><br>
                   <button class="remodal-confirm ls-light-green-btn btn" onClick="completdevis()">Enr</button>
                   <a style="display: none;" id="bout_imp" onClick="flvFPW1(wr+'Devis/imprimer/'+<?php  echo  @$id;?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue"  class="remodal-confirm ls-light-green-btn btn" ><strong>Imprimer</strong></a>
                   <a onClick="flvFPW1(wr+'Devis/imprimer/'+<?php  echo  @$id;?>+'/1','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue"  class="remodal-confirm ls-light-green-btn btn" ><strong>passe</strong></a>
                          