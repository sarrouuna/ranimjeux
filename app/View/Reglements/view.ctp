<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Reglements/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>

<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation règlement fournisseur '); ?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo $this->Form->create('Reglement',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
                           
           <div class="col-md-6">                         
             			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Fournisseur'); ?></label>	
                                  
			<?php  //debug($reglement);die;?>
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $reglement['Fournisseur']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>	
                
           </div><div class="col-md-6"> 
                                	 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo date("d/m/Y",strtotime(str_replace('-','/',($reglement['Reglement']['Date'])))); ?>'>

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
                                          <tr>
                                                <td>Numéro</td>
                                                <td>Date</td>
                                                <td>Total TTC</td>
                                                <td>Montant réglé</td>
                                                 <td>Reste</td>
                                                
                                            </tr>
                                          <tr><td align="center" colspan="5" bgcolor="#F2D7D5"><strong>Factures</strong></td></tr>
                                           
                                            <?php //debug($reglement['Lignereglement']);die;
                                            foreach ($reglement['Lignereglement'] as $l){ //debug($l);die;
                                              if ($l['facture_id']!='') { //debug($l);die; ?>
                                            <tr>
                                                <td> <?php echo $l['Facture']['numero']; ?></td>
                                                <td><?php echo  date("d/m/Y",strtotime(str_replace('-','/',$l['Facture']['date']))); ?></td>
                                                <td><?php echo $l['Facture']['totalttc']; ?></td>
                                                <td><?php echo $l['Facture']['Montant_Regler']; ?> </td>
                                                <td><?php echo $l['Facture']['totalttc']-$l['Facture']['Montant_Regler']; ?></td>
                                                
                                            </tr>
                                            <?php }}?>
                                            <tr> <td align="center" colspan="5" bgcolor="#F2D7D5"><strong>Impayés</strong></td></tr>
                                            
                                            <?php //debug($reglement['Lignereglement']);die;
                                            foreach ($reglement['Lignereglement'] as $l){ 
                                              if ($l['piecereglement_id']!='' && $l['piecereglement_id']!=0) { 
                                                 $fac=ClassRegistry::init('Piecereglement')->find('first',array('conditions'=>array('Piecereglement.id'=>$l['piecereglement_id']),'recursive'=>0));  
                                                    
                                          //  debug($fac['Piecereglement']['num']);die; ?>
                                            <tr>
                                                <td> <?php echo $fac['Piecereglement']['num']; ?></td>
                                                <td><?php echo  date("d/m/Y",strtotime(str_replace('-','/',$fac['Piecereglement']['echance']))); ?></td>
                                                <td><?php echo $fac['Piecereglement']['montant']; ?></td>
                                                <td><?php echo $fac['Piecereglement']['mantantregler']; ?> </td>
                                                <td><?php echo $fac['Piecereglement']['montant']-$fac['Piecereglement']['mantantregler']; ?></td>
                                                
                                            </tr>
                                            <?php }}?>
                                             <tr>
                                                <td colspan="4" >Total</td>
                                                <td><?php echo h($reglement['Reglement']['Montant']); ?></td>
                                            </tr>
                                            
                                           
                                             <tr>
                                                <td colspan="4" >Net à payer </td>
                                                <td><?php echo h($reglement['Reglement']['Montant']); ?></td>
                                            </tr>
                                             
                                        </table>
                                    </div></div></div></div></div>
                                       
     <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Pièces règlement fournisseur'); ?></h3>
                                </div>
                                <div class="panel-body">
                                 
                                    <div class="ls-editable-table table-responsive ls-table">
                                
                                            
                                            <?php  foreach($pieceregement as $i=>$lp ){ //debug($lp);die;
                                                $montantcredit=$lp['Piecereglement']['montant'];
                                                ?>
                                        <table class="table table-bordered table-striped table-bottomless" id="table">
                                            <tr>
                                                <td colspan="4"> Mode règlement</td>
                                                <td> <?php echo $lp['Paiement']['name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"> Montant</td>
                                                <td><?php echo $lp['Piecereglement']['montant']; ?></td>
                                            </tr>
                                            
                                            <?php if($lp['Paiement']['id']!=1 && $lp['Paiement']['id']!=5) {?>
                                            <?php if($lp['Paiement']['id']!=7 ) {?>
                                             <tr>
                                                <td colspan="4"> Echéance</td>
                                                <td><?php echo date("d/m/Y",strtotime(str_replace('-','/',$lp['Piecereglement']['echance']))); ?></td>
                                            </tr>
                                            <?php } ?>
                                             <tr>
                                                <td colspan="4"> Numéro pièce</td>
                                                <td><?php echo $lp['Piecereglement']['num']; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"> Banque</td>
                                             <td>
                                              <?php echo $this->Html->link($lp['Compte']['banque'], array('controller' => 'utilisateurs', 'action' => 'view', $lp['Compte']['id'])); ?>
                                             </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"> Rib</td>
                                             <td>
                                              <?php echo $this->Html->link($lp['Compte']['rib'], array('controller' => 'utilisateurs', 'action' => 'view', $lp['Compte']['id'])); ?>
                                             </td>
                                            </tr>
                                            <?php }?>
                                            <?php if($lp['Paiement']['id']==5){?>
                                             <tr>
                                                <td colspan="4"> Montant Brut</td>
                                                <td><?php echo $lp['Piecereglement']['montant_brut']; ?></td>
                                            </tr>
                                             <tr>
                                                <td colspan="4"> Montant Net</td>
                                                <td><?php echo $lp['Piecereglement']['montant_net']; ?></td>
                                            </tr>
                                            
                                            <?php }?>
                                             <?php if($lp['Paiement']['id']==7 ) {?>
                                             <tr>
                                                <td colspan="4"> Nbr Moins</td>
                                                <td><?php echo $lp['Piecereglement']['nbrmoins']; ?></td>
                                            </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table> <br>
                                            <?php } ?>
                                         <?php if($lp['Paiement']['id']==7 ) {?>
                                        <table  style="width: 100%;" border="1" align="center" id="tablet">
                                            <tr bgcolor="#F2D7D5">
                                                <td><center>N°</center></td>    
                                                <td><center>Numéro de piéce</center></td>
                                                <td><center>Echéance</center></td>
                                                <td><center>Montant</center></td>
                                            </tr>
                                                <?php 
                                                $totale=0;
                                                $agio=0;
                                                foreach ($credit as $n=>$c){ $m=$n+1;
                                                $totale=$totale+$c['Traitecredit']['montantcredit'];
                                                $agio=$totale-$montantcredit;
                                                ?>
                                            <tr id="trr<?php echo $m;?>">
                                                <td ><?php echo $m; ?></td>    
                                                <td >
                                                <?php  echo $this->Form->input('num_piececredit',array('readonly'=>'readonly','value'=>@$c['Traitecredit']['num_piececredit'],'div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>$m,'id'=>'num_piececredit'.$m,'champ'=>'num_piececredit','table'=>'traitecredits','name'=>'data[traitecredits]['.$m.'][num_piececredit]') );  ?>  
                                                </td>
                                                <td >
                                                <?php  echo $this->Form->input('echancecredit',array('readonly'=>'readonly','value'=>date("d/m/Y",strtotime(str_replace('/','-',@$c['Traitecredit']['echancecredit']))),'div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>$m,'id'=>'echancecredit'.$m,'champ'=>'echancecredit','table'=>'traitecredits','name'=>'data[traitecredits]['.$m.'][echancecredit]') );  ?>  
                                                </td>
                                                <td >
                                                <?php  echo $this->Form->input('montantcredit',array('readonly'=>'readonly','value'=>@$c['Traitecredit']['montantcredit'],'div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>$m,'id'=>'montantcredit'.$m,'champ'=>'montantcredit','table'=>'traitecredits','name'=>'data[traitecredits]['.$m.'][montantcredit]') );  ?>  
                                                </td>
                                            </tr>
                                                <?php } ?>
                                            <tr>
                                                <td align="center" colspan="3"><label><strong>Total</strong></label></td><td align="center"><input type="text" id="total" class="form-control" readonly="readonly" value="<?php echo sprintf('%.3f',$totale); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td align="center" colspan="3"><label><strong>Agio</strong></label></td><td align="center"><input type="text" id="agio" class="form-control" readonly="readonly" value="<?php echo sprintf('%.3f',$agio); ?>"></td>
                                            </tr>
                                            </table>
                                        <?php } ?>
              			</div>
                                 </div>
<?php echo $this->Form->end();?>
	
</div></div></div>



	

