<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Reglements/index"/> <i class="fa fa-reply"></i> Retour </a>
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
                <?php echo $this->Form->create('Reglement', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('numeroconca', array('label' => 'Numéro', 'readonly' => 'readonly', 'div' => 'form-group', 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('fournisseur_id', array('type' => 'hidden', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('fournisseur', array('readonly' => 'readonly', 'div' => 'form-group', 'value' => $fournisseur, 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?>
                    
                </div><div class="col-md-6"><?php
                    echo $this->Form->input('Date', array('div' => 'form-group', 'value' => $date, 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'text', 'class' => 'form-control datePickerOnly ', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                     echo $this->Form->input('designation', array('label' => 'Designation', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control '));
                   ?>
                    <?php if (($devisefournisseur != 1) && ($this->request->data['Reglement']['libre'] == 1)) { ?>
                        <div id="divimportation" >
                            <?php
                            echo $this->Form->input('importation_id', array('id' => 'importation_id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control getinfoimportation select ', 'empty' => 'veuillez choisir'));
                            ?>
                        </div>
                    <?php } ?>  
                    <div class="form-group"> 
                        <input type="hidden" name="data[Reglement][devisefournisseur]"  value="<?php echo @$devisefournisseur; ?>" id="devisefournisseur">
                        <label class="col-md-2 control-label">Règlement Libre</label>
                        <div class="col-sm-10">    

                            NON <input type="radio" name="data[Reglement][libre]" value="0" <?php if ($this->request->data['Reglement']['libre'] == 0) { ?> checked="checked" <?php } ?> class="libreFR"> 
                            OUI <input type="radio" name="data[Reglement][libre]" value="1" <?php if ($this->request->data['Reglement']['libre'] == 1) { ?> checked="checked" <?php } ?> class="libreFR"> 
                            <input type="hidden"  value="<?php echo @$this->request->data['Reglement']['libre']; ?>" id="inputlibre">
                        </div></div>
                </div>    

                <div class="panel-body">
                    <div class="ls-editable-table table-responsive ls-table">
                        <table class="table table-bordered table-striped table-bottomless" id="table">
                            <thead id="thead">
                                <tr>
                                   <?php  $n=7;
                                   if ($devisefournisseur != 1) { $n=9;} ?> 
                                    <td align="center" colspan="<?php echo $n; ?>" bgcolor="#F2D7D5"><strong>Factures</strong></td>
                                </tr>
                                <tr>
                                    <td>N° Interne</td>
                                    <td>N° Facture</td>
                                    <td>Date</td>
                                    <td>Total TTC</td>
                                    <?php if ($devisefournisseur != 1) { ?>
                                        <td>Total en devise</td>
                                        <td>T C</td>
                                    <?php } ?>
                                    <td>Montant réglé</td>
                                    <td>Reste</td>

                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //debug($facture);die;
                                $total=0;
                                foreach ($facture as $f => $fac) {
                                     $MntReg='';
				$lignereglementfac=ClassRegistry::init('Lignereglement')->
				find('first',array('conditions'=>array('Lignereglement.facture_id'=>$fac['Facture']['id'],
				'Lignereglement.reglement_id'=>$id),'recursive'=>0));  
 
                                    if (!empty($lignereglementfac)) {
                                       
                                                $MntReg=$lignereglementfac['Lignereglement']['Montant'];
                                                
                                                if ($devisefournisseur == 1) {
                                                    $montant_regler = ($fac['Facture']['Montant_Regler']) - $lignereglementfac['Lignereglement']['Montant'];
													//debug($fac['Facture']['numerofrs']);
													//debug("1");
                                                    
                                                } else {
                                                    $taux = $lignereglementfac['Lignereglement']['tauxchange'];
                                                    //debug($taux);die;
                                                    $variationtauxdechange = ClassRegistry::init('Variationtauxdechange')->find('first', array('conditions' => array('Variationtauxdechange.reglement_id' => $this->request->data['Reglement']['id']), 'recursive' => 0));
                                                    if (!empty($variationtauxdechange)) {
                                                        if ($variationtauxdechange['Variationtauxdechange']['type'] == 'Perte') {
                                                            $variation = $variationtauxdechange['Variationtauxdechange']['montant'];
                                                        } else {
                                                            $variation = $variationtauxdechange['Variationtauxdechange']['montant'] * (-1);
                                                        }
                                                    } else {
                                                        $variation = 0;
                                                    }
                                                    $montant_regler = ($fac['Facture']['Montant_Regler'] * $fac['Importation']['tauxderechenge']) - ($lignereglementfac['Lignereglement']['Montant']);
                                                    //debug($fac['Facture']['Montant_Regler']*$fac['Importation']['tauxderechenge']);
                                                    //debug($lignereglement['Montant']);
                                                    //debug($variation);
													//debug($fac['Facture']['numerofrs']);
													//debug("2");
                                                }
                                            
                                    } else {
                                        $taux = $fac['Importation']['tauxderechenge'];
                                        //debug($taux);die;
                                        $variationtauxdechange = ClassRegistry::init('Variationtauxdechange')->find('first', array('conditions' => array('Variationtauxdechange.reglement_id' => $this->request->data['Reglement']['id']), 'recursive' => 0));
                                        if (!empty($variationtauxdechange)) {
                                            if ($variationtauxdechange['Variationtauxdechange']['type'] == 'Perte') {
                                                $variation = 0 - $variationtauxdechange['Variationtauxdechange']['montant'];
                                            } else {
                                                $variation = $variationtauxdechange['Variationtauxdechange']['montant'];
                                            }
                                        } else {
                                            $variation = 0;
                                        }
                                        $montant_regler =$fac['Facture']['Montant_Regler'];
										//debug($fac['Facture']['numerofrs']);
										//debug("4");
                                    }

                                    if ($devisefournisseur == 1) {
                                        $reste = sprintf('%.3f', $fac['Facture']['totalttc'] - $montant_regler);
                                    } else {
                                        $reste = sprintf('%.3f', ($fac['Facture']['totaldevise'] * $taux) - $montant_regler);
                                    }
                                    $test = 0;
                                    $tot = 0;
                                    foreach ($this->request->data['Piecereglement'] as $l => $piecereglement) {
                                        $tot = $tot + $piecereglement['montant'];
                                        if ($piecereglement['paiement_id'] == 5) {
                                            $test = 1;
                                        }
                                    }
                                    if ($test == 1) {
                                        $montant_a_payer = $retenue['Piecereglement']['montant'];
                                        $net_a_payer = $retenue['Piecereglement']['montant_net'];
                                    } else {
                                        $montant_a_payer = $tot;
                                        $net_a_payer = 0;
                                    }
                                    if ($fac['Facture']['type'] == "Service") {
                                        $fac['Facture']['importation_id'] = 0;
                                    }
									
									//debug($montant_regler);
									//debug($reste);
									
                                    ?>
                                    <tr id="trfacture<?php echo $f; ?>">
                                        <td> <?php echo $fac['Facture']['numerofrs']; ?></td>
                                        <td> <?php echo $fac['Facture']['numero']; ?></td>
                                        <td><?php echo $fac['Facture']['date']; ?></td>
                                        <td><?php echo $fac['Facture']['totalttc']; ?></td>
                                        <?php if ($devisefournisseur != 1) { ?>
                                            <td><?php echo $fac['Importation']['montantachat']; ?></td>
                                    <input type="hidden"  value="<?php echo $fac['Importation']['montantachat']; ?>" id="montantachat">
                                    <input type="hidden"  value="<?php echo @$montant_regler; ?>" id="Montant_Regler">
                                    <td><input  type="text" value="<?php echo @$taux; ?>" class="form-control calculer_m_apayer" id="tc" size="3" name="data[Lignereglement][<?php echo $f; ?>][tauxchange]"></td>
                                <?php } ?>
                                <td><?php echo sprintf('%.3f', @$montant_regler); ?></td>
                                <td><span id="spanreste"><?php echo sprintf('%.3f', $reste); ?></span></td>
                                <input type="hidden" name="" id="devise<?php echo $f; ?>" class="form-control"  value="<?php echo @$reste; ?>" >
                                <td style="display:none;">
                                    <input type="checkbox" <?php if (@$facreg[@$fac['Facture']['id']] == 1) { ?> checked="checked"<?php } ?> name="data[Lignereglement][<?php echo $f; ?>][importation_id]" id="importation_id<?php echo $f; ?>" index="<?php echo $f; ?>" class="" value="<?php echo $fac['Facture']['importation_id'] ?>" >
                                </td>
                                <td style="width:15%;">
                                    <table >
                                    <tr> 
                                    <td style="width:1%;">
                                         <input type="checkbox"<?php if (@$facreg[@$fac['Facture']['id']] == 1) { ?> checked="checked"<?php } ?> name="data[Lignereglement][<?php echo $f; ?>][facture_id]" id="facture_id<?php echo $f; ?>" index="<?php echo $f; ?>" class="chekreglement calculereglement afficheinputmontantreglementclient" value="<?php echo $fac['Facture']['id'] ?>" mnttounssi="<?php echo $fac['Facture']['totalttc']; ?>" mnt="<?php echo $reste; ?>" compte="<?php echo $fac['Facture']['compte_id']; ?>">
                                    </td>
                                    
                                    <td style="width:99%;" align="left">
                                        <?php if (@$facreg[@$fac['Facture']['id']] == 1) { 
                                            $total+=$reste;
                                            $style="display:yesy";}else{$style="display:none";}?> 
                                        <?php echo $this->Form->input('Montanttt',array('value'=>$MntReg,'style'=>$style,'index'=>$f,'name'=>'data[Lignereglement]['.$f.'][Montant]','id'=>'Montantregler'.$f,'label'=>'','div'=>'','between'=>'<div class="col-sm-12">','after'=>'','type'=>'text','class'=>'form-control testmontantreglementclient') ); ?>
                                    </td>  
                                    </tr>
                                    </table>
                                 </td>    
                                </tr>
                            <?php } ?>
                            <input type="hidden" name="max" value="<?php echo @$f; ?>" id="max">
                                <tr style="width:100%" id="thead2">
                                    <td align="center" colspan="7" style="background-color: #F2D7D5;"><strong>Impayés</strong></td>
                                </tr>
                                <tr style="width:100%" id="thead3">
                                    <td colspan="2" >Numéro</td>
                                    <td>Date</td>
                                    <td>Montant</td>
                                    <td>Montant réglé</td>
                                    <td>Reste</td>
                                    <td ></td>
                                </tr>
                                              <?php   //debug($facture);die;
                                             // $total=0;  //debug($impayes);die;
                                              $i=0;
                                        foreach($impayes as $i=>$fac){ 
                                           // debug($fac['Piecereglement']['num']);die;
                                                if(@$fac['Piecereglement']['reglement']==$id){        
                                                    $lignereglement=ClassRegistry::init('Lignereglement')->find('first',array('conditions'=>array('Lignereglement.piecereglement_id'=>$fac['Piecereglement']['id'],'Lignereglement.reglement_id'=>$id),'recursive'=>0));  
                                                    $mpayer=$lignereglement['Lignereglement']['Montant'];
                                                }else{
                                                    $mpayer='';    
                                                }          
                                            ?>
                                            <tr id="trfactureimp<?php echo $i; ?>">
                                                <td  colspan="2" > <?php echo $fac['Piecereglement']['num']; ?></td>
                                                <td ><?php echo date("d/m/Y",strtotime(str_replace('-','/',$fac['Piecereglement']['echance']))); ?></td>
                                                <td ><?php echo $fac['Piecereglement']['montant']; ?></td>
                                                <td ><?php echo number_format($fac['Piecereglement']['mantantregler']-$mpayer,3, '.', ' '); ?></td>
                                                <td ><?php echo number_format(($fac['Piecereglement']['montant']-$fac['Piecereglement']['mantantregler'])+$mpayer,3, '.', ' '); ?></td>
                                                <td style="width:15%;">
                                                <table >
                                                <tr> 
                                                <td style="width:1%;">
                                                 <input champ="piece" type="checkbox"<?php if(@$fac['Piecereglement']['reglement']==$id){?> checked="checked"<?php $total=$total+$fac['Piecereglement']['montant']; } ?> name="data[Lignereglementimpaye][<?php echo $i; ?>][piecereglement_id]" id="impaye_id<?php echo $i; ?>" index="<?php echo $i; ?>" class="calculereglementclient afficheinputmontantreglementclientimpaye" value="<?php echo $fac['Piecereglement']['id'] ?>" mnt="<?php echo ($fac['Piecereglement']['montant']-$fac['Piecereglement']['mantantregler'])+$mpayer; ?>" >
                                                </td>
                                                <td style="width:99%;" align="left">
                                                <?php if(@$fac['Piecereglement']['reglement']==$id){$style="display:yes";}else{$style="display:none";} ?>    
                                                <?php
                                                //debug($lignereglement);
                                                echo $this->Form->input('Montanttt',array('value'=>@$mpayer,'style'=>$style,'index'=>$i,'name'=>'data[Lignereglementimpaye]['.$i.'][Montant]','id'=>'Montantreglerimpaye'.$i,'label'=>'','div'=>'','between'=>'<div class="col-sm-12">','after'=>'','type'=>'text','class'=>'form-control testmontantreglementclientimpaye') );
                                                ?>
                                                </td>    
                                                </tr>
                                                </table>
                                                </td>
                                                
                                           </tr>
                                            <?php  }?>
                                        <input type="hidden" name="max" value="<?php echo $i; ?>" id="maximpaye"> 
                            
                            
                            
                            
                            
                            

                            <?php
                            if ($devisefournisseur == 1) {
                                $colspan = 4;
                            } else {
                                $colspan = 6;
                            }
                            ?> 
                            <tr id="totalefacture">
                                <td colspan="<?php echo $colspan; ?>"> Total factures</td>
                                <td colspan="3">
                                    <?php $total; ?>
                                    <input type="text" name="data[Reglement][ttpayer]" id="ttpayer" class="form-control"  value="<?php echo sprintf('%.3f', $total); ?>" readonly>
                                </td> 
                            </tr>

                            <tr id="montantpayer">
                                <td colspan="<?php echo $colspan; ?>">Montant à payer</td>
                                <td colspan="3">
                                    <input type="text" name="data[Reglement][Montant]" id="Montant" class="form-control"  value="<?php echo sprintf('%.3f', @$this->request->data['Reglement']['Montant']); ?>" readonly>
                                </td>
                            </tr>
                            <tr id="netapayer">
                                <td colspan="<?php echo $colspan; ?>"> Net à payer</td>
                                <td colspan="3">
                                    <input type="text" name="data[Reglement][netapayer]" id="netapayer" class="form-control netapayer"  value="<?php echo @$net_a_payer ?>" readonly>
                                </td>
                            </tr>
                            <input type="hidden" value="<?php echo $devisefournisseur; ?>"  id="typefrs"> 
                            <?php
                            if ($devisefournisseur == 1) {
                                $colspan = 7;
                            } else {
                                $colspan = 9;
                            }
                            ?> 
                            <tr>
                                <td colspan="<?php echo $colspan; ?>">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Pièces règlement</h3>
                                        <a class="btn btn-danger ajouterligne" table='table' index='index' tr='type'  style="
                                           float: right; 
                                           position: relative;
                                           top: -25px;"> <i class="fa fa-plus-circle"  ></i>Ajouter ligne</a>
                                    </div></td>
                            </tr>
                            <?php
                            if ($devisefournisseur == 1) {
                                $colspan = 2;
                            } else {
                                $colspan = 4;
                            }
                            ?>         
                            <tr  class='type'  style="display: none !important"> 
                                <td colspan="8" style="vertical-align: top;">
                                    <table>
                                        <tr>
                                            <td >Mode règlement </td>  
                                            <td ><?php
                                                echo $this->Form->input('paiement_id', array('empty' => 'choix', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control modereglement  ',
                                                    // 'empty'=>'veuillez choisir',
                                                    'label' => '', 'index' => 0, 'champ' => 'paiement_id', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][paiement_id]'));
                                                ?> 
                                                <?php echo $this->Form->input('sup', array('name' => '', 'id' => '', 'champ' => 'sup', 'table' => 'pieceregelemnt', 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                            </td>

                                        </tr>
                                        <tr >
                                            <td name="data[piece][0][trmontantbrut]" id="" index="0"  champ="trmontantbruta" table="piece"  style="display:none" class="modecheque">Montant brut</td>  
                                            <td name="data[piece][0][trmontantbrut]" id="" index="0"  champ="trmontantbrutb" table="piece"  style="display:none" class="modecheque"><?php
                                                echo $this->Form->input('montant_brut', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control montantbrut', 'label' => '', 'type' => 'text', 'index' => 0, 'champ' => 'montantbrut', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][montant_brut]'));
                                                ?> </td>  
                                        </tr>
                                        <tr >
                                            <td name="data[piece][0][trtaux]" id="" index="0"  champ="trtauxa" table="piece"  style="display:none" class="modecheque">Taux</td>  
                                            <td name="data[piece][0][trtaux]" id="" index="0"  champ="trtauxb" table="piece"  style="display:none" class="modecheque"><?php
                                                echo $this->Form->input('valeur_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'montantbrut', 'label' => '', 'index' => 0, 'champ' => 'taux', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][taux]', 'empty' => 'Veuillez choisir'));
                                                ?> </td>  
                                        </tr>
                                        <tr>
                                            <td >Montant</td>  
                                            <td  ><?php
                                                echo $this->Form->input('montant', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control mnt', 'label' => '', 'index' => 0, 'champ' => 'montant', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][montant]'));
                                                ?> </td>  
                                        </tr>
                                        <tr >
                                            <td name="data[piece][0][trmontantnet]" id="" index="0"  champ="trmontantneta" table="piece"  style="display:none" class="modecheque">Montant Net</td>  
                                            <td name="data[piece][0][trmontantnet]" id="" index="0"  champ="trmontantnetb" table="piece"  style="display:none" class="modecheque"><?php
                                                echo $this->Form->input('montant_net', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'label' => '', 'type' => 'text', 'index' => 0, 'champ' => 'montantnet', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][montant_net]'));
                                                ?> </td>  
                                        </tr>
<!--                                            <tr>
                                            <td >N° recu</td>  
                                            <td  ><?php
                                        echo $this->Form->input('num_recu', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control ', 'label' => '', 'index' => 0, 'champ' => 'num_recu', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][num_recu]'));
                                        ?> </td>  
                                        </tr>-->

                                        <tr >
                                            <td name="data[piece][0][trechance]" id="" index="0"  champ="trechancea" table="piece"  style="display:none" class="modecheque">Echéance</td>  
                                            <td name="data[piece][0][trechance]" id="" index="0"  champ="trechanceb" table="piece"  style="display:none" class="modecheque"><?php
                                                echo $this->Form->input('echance', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control ', 'label' => '', 'type' => 'text', 'index' => 0, 'champ' => 'echance', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][echance]'));
                                                ?> </td>  
                                        </tr>
                                        <!-- //***************************************************--->
                                        <tr><td name="data[piece][0][trcarnetnum]" id="" index="0"  champ="trcarnetnuma" table="piece"  style="display:none" class="modecheque" >Numéro de carnet</td>  
                                            <td  name="data[piece][0][trcarnetnum]" id="" index="0"  champ="trcarnetnumb" table="piece"  style="display:none" class="modecheque"><?php
                                                echo $this->Form->input('carnetcheque_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control  getnumcheque  ', 'empty' => 'veuillez choisir',
                                                    'label' => '', 'index' => 0, 'champ' => 'carnetcheque_id', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][carnetcheque_id]'));
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
                                                    <div class='col-sm-12' ><?php echo $this->Form->input('num_piece', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control ', 'label' => '', 'type' => 'text', 'index' => 0, 'champ' => 'num_piece', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][num_piece]')); ?></div>
                                                </div>
                                            </td>  
                                        </tr>
                                        <tr >
                                            <td name="data[piece][0][trbanque]" id="" index="0"  champ="trbanquea" table="piece"  style="display:none" class="modecheque" >Compte</td>  
                                            <td  name="data[piece][0][trBanque]" id="" index="0"  champ="trbanqueb" table="piece"  style="display:none" class="modecheque"><?php
                                                echo $this->Form->input('compte_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => '', 'empty' => 'veuillez choisir',
                                                    'label' => '', 'index' => 0, 'champ' => 'compte_id', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][compte_id]'));
                                                ?> </td>  
                                        </tr>
                                        <?php if ($devisefournisseur != 1) { ?>  
                                            <tr style="display:none" id="" champ="tr_regle_fournisseur" index="">
                                                <td>Reglé Fournisseur</td>  
                                                <td>
                                                    <?php echo $this->Form->input('regle_id', array('table' => 'pieceregelemnt', 'name' => '', 'index' => '', 'champ' => 'regle_id', 'id' => '', 'div' => 'form-group', 'label' => '', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => '')); ?>
                                                </td>
                                            </tr>
                                        <?php } ?>  
                                    </table>
                                    <?php if ($devisefournisseur != 1) { ?>                         
                                        <div class="row ligne" id="" index="" champ="tablepaiement" style="display:none;">

                                            <div class="col-md-12" >
                                                <div class="panel panel-default" >
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title"><?php echo __('Situation'); ?></h3>
                                                        <a class="btn btn-danger ajouter_ligne_situation_reglement" id="" champ="bouttonajoutlignepetit" table='addtablec' indexc='indexc' index='' style="
                                                           float: right; 
                                                           position: relative;
                                                           top: -25px;
                                                           "><i class="fa fa-plus-circle"  ></i> Ajouter Situation</a>
                                                    </div>
                                                    <div class="panel-body">
                                                        <table class="table table-bordered table-striped table-bottomless" id="" champ="addtablec" index="" style="width:100%" align="center" >
                                                            <thead>
                                                                <tr>
                                                                    <td align="center" nowrap="nowrap">Situation</td>
                                                                    <td align="center" nowrap="nowrap">Nouveau Echéance</td>
                                                                    <td align="center" nowrap="nowrap">Nbr Jours </td>
                                                                    <td align="center" nowrap="nowrap">Montant</td>
                                                                    <td align="center"></td>
                                                                    <td align="center"></td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="trstituation" style="display:none;" champ="trstituation">
                                                                    <td style="width:25%">
                                                                        <?php echo $this->Form->input('supp', array('name' => '', 'id' => '', 'champ' => 'supp', 'table' => 'etatpieceregelemnt', 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                                                        <?php
                                                                        echo $this->Form->input('etatpiecereglement_id', array('empty' => 'choix', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control affichesituation_virment_lc',
                                                                            'label' => '', 'index' => '', 'id' => '', 'champ' => 'etatpiecereglement_id', 'table' => 'etatpieceregelemnt', 'name' => ''));
                                                                        ?>
                                                                    </td>
                                                                    <td style="width:25%">
                                                                        <?php echo $this->Form->input('echancenf', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'etatpieceregelemnt', 'index' => '', 'id' => '', 'champ' => 'echancenf', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                                                    </td>

                                                                    <td style="width:24%">
                                                                        <?php echo $this->Form->input('nbrjour', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'etatpieceregelemnt', 'index' => '', 'id' => '', 'champ' => 'nbrjour', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                                                    </td>
                                                                    <td style="width:25%">
                                                                        <?php echo $this->Form->input('montant', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'etatpieceregelemnt', 'index' => '', 'id' => '', 'champ' => 'montant', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                                    </td>
                                                                    <td align="center"> <input type="radio" name="" champ="contactchoisi"  index="" checked="checked"></td>

                                                                    <td align="center"><i ligne="" index="" champ="croix_sup" id="" class="fa fa-times supsituationreg" style="color: #c9302c;font-size: 22px;"></td>
                                                                </tr>


                                                            </tbody>
                                                        </table>
                                                        <input type="hidden" value="0" id="" champ="indexc" />
                                                    </div>
                                                </div>
                                            </div>                
                                        </div> 
                                    <?php } ?>      
                                </td>

                                <td><i index=""  class="fa fa-times supreg" style="color: #c9302c;font-size: 22px;"></td>
                            </tr>



                            <?php
                            $read = "";
                            foreach ($piecesreg as $i => $piece) { 
//debug($piece); 
                                ?> 
                                <?php
                                if ($devisefournisseur != 1) {
                                    $read = 'readonly';
                                }
                                //debug($read);
                                $montantcredit = $piece['Piecereglement']['montant'];
                                ?>
                                <tr>
                                    <td colspan="8" style="vertical-align: top;">
                                        <table>
                                            <tr>
                                                <td >Mode règlement </td>  
                                                <td ><?php
                                                    echo $this->Form->input('paiement_id', array('value' => @$piece['Piecereglement']['paiement_id'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control modereglement select  ',
                                                        'label' => '', 'index' => $i, 'id' => 'paiement_id' . $i, 'champ' => 'paiement_id', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][' . $i . '][paiement_id]'));
                                                    ?>
                                                    <?php echo $this->Form->input('id', array('value' => @$piece['Piecereglement']['id'], 'name' => 'data[pieceregelemnt][' . $i . '][id]', 'id' => 'id' . $i, 'champ' => 'id', 'table' => 'pieceregelemnt', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
    <?php echo $this->Form->input('sup', array('name' => 'data[pieceregelemnt][' . $i . '][sup]', 'id' => 'sup' . $i, 'champ' => 'sup', 'table' => 'pieceregelemnt', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>

                                                </td>  
                                            </tr>
                                            <tr  id="trmontantbrut<?php echo $i ?>"   >
                                                <td <?php if ($piece['Piecereglement']['paiement_id'] != 5) { ?>   style="display:none" <?php } ?> name="data[piece][<?php echo $i ?>][trmontantbrut]" id="trmontantbruta<?php echo $i ?>" index="<?php echo $i ?>"  champ="trmontantbruta" table="piece"   class="modecheque">Montant brut</td>  
                                                <td <?php if ($piece['Piecereglement']['paiement_id'] != 5) { ?>   style="display:none" <?php } ?> name="data[piece][<?php echo $i ?>][trmontantbrut]" id="trmontantbrutb<?php echo $i ?>" index="<?php echo $i ?>"  champ="trmontantbrutb" table="piece"   class="modecheque"><?php
                                                    echo $this->Form->input('montant_brut', array('value' => $piece['Piecereglement']['montant_brut'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control editmontantbrut', 'label' => '', 'type' => 'text', 'index' => $i, 'champ' => 'montantbrut', 'id' => 'montantbrut' . $i, 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][' . $i . '][montant_brut]'));
                                                    ?> </td>  
                                            </tr>
                                            <tr   id="trtaux<?php echo $i ?>"  >
                                                <td <?php if ($piece['Piecereglement']['paiement_id'] != 5) { ?>   style="display:none" <?php } ?> name="data[piece][<?php echo $i ?>][trtaux]" id="trtauxa<?php echo $i ?>" index="<?php echo $i ?>"  champ="trtauxa" table="piece"  class="modecheque">Taux</td>  
                                                <td <?php if ($piece['Piecereglement']['paiement_id'] != 5) { ?>   style="display:none" <?php } ?> name="data[piece][<?php echo $i ?>][trtaux]" id="trtauxb<?php echo $i ?>" index="<?php echo $i ?>"  champ="trtauxb" table="piece"  class="modecheque"><?php
                                                    echo $this->Form->input('valeur_id', array('value' => $piece['Piecereglement']['to_id'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'select editmontantbrut', 'label' => '', 'index' => $i, 'champ' => 'taux', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][' . $i . '][taux]', 'id' => 'taux' . $i, 'empty' => 'Veuillez choisir'));
                                                    ?> </td>  
                                            </tr>
                                            <tr>
                                                <td>Montant</td>  
                                                <td  ><?php
                                                    echo $this->Form->input('montant', array('value' => $piece['Piecereglement']['montant'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control mnt', 'label' => '', 'index' => $i, 'champ' => 'montant', 'id' => 'montant' . $i, 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][' . $i . '][montant]'));
                                                    //echo $this->Form->input('montantdevise',array('value'=>$piece['Piecereglement']['montantdevise'],'type'=>'hidden','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','label'=>'','index'=>$i,'champ'=>'montantdevise','id'=>'montantdevise'.$i,'table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][montantdevise]') );   
                                                    ?> 
                                                </td>  
                                            </tr>
                                            <tr   id="trmontantnet<?php echo $i ?>" >
                                                <td <?php if ($piece['Piecereglement']['paiement_id'] != 5) { ?>   style="display:none" <?php } ?> name="data[piece][<?php echo $i ?>][trmontantnet]" id="trmontantneta<?php echo $i ?>" index="<?php echo $i ?>"  champ="trmontantneta" table="piece"  class="modecheque">Montant Net</td>  
                                                <td <?php if ($piece['Piecereglement']['paiement_id'] != 5) { ?>   style="display:none" <?php } ?> name="data[piece][<?php echo $i ?>][trmontantnet]" id="trmontantnetb<?php echo $i ?>" index="<?php echo $i ?>"  champ="trmontantnetb" table="piece"   class="modecheque"><?php
                                                    echo $this->Form->input('montant_net', array('value' => $piece['Piecereglement']['montant_net'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'label' => '', 'type' => 'text', 'index' => $i, 'id' => 'montantnet' . $i, 'champ' => 'montantnet', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][' . $i . '][montant_net]'));
                                                    ?> </td>  
                                            </tr>                                         
                                            <tr   id="trechances<?php echo $i ?>" >
                                                <td <?php if (($piece['Piecereglement']['paiement_id'] == 1) || ($piece['Piecereglement']['paiement_id'] == 5) || ($piece['Piecereglement']['paiement_id'] == 7)) { ?>   style="display:none" <?php } ?> name="data[piece][<?php echo $i ?>][trechance]" id="trechancea<?php echo $i ?>" index="[<?php echo $i ?>"  champ="trechancea" table="piece"   class="modecheque">Echéance</td>  
                                                <td <?php if (($piece['Piecereglement']['paiement_id'] == 1) || ($piece['Piecereglement']['paiement_id'] == 5) || ($piece['Piecereglement']['paiement_id'] == 7)) { ?>   style="display:none" <?php } ?> name="data[piece][<?php echo $i ?>][trechance]" id="trechanceb<?php echo $i ?>" index="[<?php echo $i ?>"  champ="trechanceb" table="piece"  class="modecheque"><?php
                                                    echo $this->Form->input('echance', array('value' => date("d/m/Y", strtotime(str_replace('-', '/', $piece['Piecereglement']['echance']))), 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'label' => '', 'type' => 'text', 'id' => 'echance' . $i, 'index' => $i, 'champ' => 'echance', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][' . $i . '][echance]'));
                                                    ?> </td>  
                                            </tr>
                                            <!-- //***************************************************--->
                                            <tr  id="trcarnetnum<?php echo $i ?>" >
                                                <td <?php if ($piece['Piecereglement']['paiement_id'] != 2) { ?>   style="display:none" <?php } ?> name="data[piece][<?php echo $i ?>][trcarnetnum]" id="trcarnetnuma<?php echo $i ?>" index="<?php echo $i ?>"  champ="trcarnetnuma" table="piece"   class="modecheque" >Numéro de carnet</td>  
                                                <td <?php if ($piece['Piecereglement']['paiement_id'] != 2) { ?>   style="display:none" <?php } ?>  name="data[piece][<?php echo $i ?>][trcarnetnum]" id="trcarnetnumb<?php echo $i ?>" index="<?php echo $i ?>"  champ="trcarnetnumb" table="piece"   class="modecheque"><?php
                                                    echo $this->Form->input('carnetcheque_id', array('value' => $piece['Piecereglement']['carnetcheque_id'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select getnumcheque  ', 'empty' => 'veuillez choisir',
                                                        'label' => '', 'index' => $i, 'champ' => 'carnetcheque_id', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][' . $i . '][carnetcheque_id]'));
                                                    ?></td>
                                            </tr>
                                            <!-- //***************************************************--->
                                            <tr   id="trnums<?php echo $i ?>"  >
                                                <td <?php if (($piece['Piecereglement']['paiement_id'] == 1) || ($piece['Piecereglement']['paiement_id'] == 7)) { ?>   style="display:none" <?php } ?> name="data[piece][<?php echo $i ?>][trnum]" id="trnuma<?php echo $i ?>" index="<?php echo $i ?>"  champ="trnuma" table="piece"  class="modecheque" >Numéro pièce</td>  

                                                <td <?php if (($piece['Piecereglement']['paiement_id'] == 1) || ($piece['Piecereglement']['paiement_id'] == 7)) { ?>   style="display:none" <?php } ?>  name="data[piece][<?php echo $i ?>][trnum]" id="trnumb0" index="<?php echo $i ?>"  champ="trnumb" table="piece"   class="modecheque">
                                                    <div class='form-group' id="divnumc<?php echo $i ?>" index="<?php echo $i ?>"  champ="divnumc" table="piece"  <?php if ($piece['Piecereglement']['paiement_id'] != 2) { ?>   style="display:none" <?php } ?>  >
                                                        <label class='col-md-2 control-label'></label>       
                                                        <div class="col-sm-10" id="trnumc<?php echo $i ?>" index="<?php echo $i ?>"  champ="trnumc" table="piece" >   
                                                            <select name="data[pieceregelemnt][<?php echo $i ?>][cheque_id]" table="Articlefournisseur" index="<?php echo $i ?>" id="cheque_id<?php echo $i ?>" champ="cheque_id" class="form-control select">
                                                                <option value="" >Veuillez choisir !!</option>
                                                                <?php
                                                                foreach ($piece['Carnetcheque']['Cheque'] as $cheq) {
                                                                    if (($cheq['etat'] == '0') || ($cheq['id'] == $piece['Piecereglement']['cheque_id'])) {
                                                                        ?>
                                                                        <option value="<?php echo $cheq['id'] ?>" <?php if ($cheq['id'] == $piece['Piecereglement']['cheque_id']) { ?> selected="selected"<?php } ?> ><?php echo $cheq['numero'] ?></option>
                                                                    <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select></div> 
                                                    </div>
                                                    <div class='form-group ' id="divnump<?php echo $i ?>" index="<?php echo $i ?>"  champ="divnump" table="piece"  <?php if ($piece['Piecereglement']['paiement_id'] == 2) { ?>   style="display:yes;" <?php } ?> >
                                                        <div class='col-sm-12'>
                                                        <?php echo $this->Form->input('num_piece', array('value' => $piece['Piecereglement']['num'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control ', 'label' => '', 'type' => 'text', 'index' => $i, 'id' => 'num_piece' . $i, 'champ' => 'num_piece', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][' . $i . '][num_piece]')); ?>
                                                        </div>
                                                    </div>
                                                </td>   
                                            </tr>
                                            <tr  id="trbanques<?php echo $i ?>" >
                                                <td <?php if (($piece['Piecereglement']['paiement_id'] == 2) || ($piece['Piecereglement']['paiement_id'] == 5)) { ?>   style="display:none" <?php } ?> name="data[piece][<?php echo $i ?>][banque]" id="trbanquea<?php echo $i ?>" index="<?php echo $i ?>"  champ="banquea" table="piece"  class="modecheque" >Compte</td>  
                                                <td <?php if (($piece['Piecereglement']['paiement_id'] == 2) || ($piece['Piecereglement']['paiement_id'] == 5)) { ?>   style="display:none" <?php } ?>  name="data[piece][<?php echo $i ?>][banque]" id="trbanqueb<?php echo $i ?>" index="<?php echo $i ?>"  champ="banqueb" table="piece"  class="modecheque"><?php
                                                    // echo $this->Form->input('banque',array('value'=>$piece['Piecereglement']['banque'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>$i,'champ'=>'banque','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][banque]') );   

                                                    echo $this->Form->input('compte_id', array('value' => $piece['Piecereglement']['compte_id'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select', 'empty' => 'veuillez choisir',
                                                        'label' => '', 'id' => 'compte_id' . $i, 'index' => $i, 'champ' => 'compte_id', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][' . $i . '][compte_id]'));
                                                    ?> </td>  
                                            </tr>
                                                    <?php if ($devisefournisseur != 1) { ?>     
                                                <tr   id="tr_regle_fournisseur<?php echo $i; ?>">
                                                    <td>Reglé Fournisseur</td>  
                                                    <td>
                                                        <?php
                                                        if ($piece['Piecereglement']['reglefournisseur'] == 0) {
                                                            echo $this->Form->input('regle_id', array('name' => 'data[pieceregelemnt][' . $i . '][regle_id]', 'index' => $i, 'champ' => 'regle_id', 'id' => 'regle_id' . $i, 'div' => 'form-group', 'label' => '', 'between' => '<div class="col-sm-10 adrcli">', 'after' => '</div>', 'class' => 'form-control'));
                                                        } else {
                                                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <strong>Fournisseur Reglé par un montant égal à :" . @$piece['Piecereglement']['montantfrs'] . "</strong>";
                                                            //$this->request->data[pieceregelemnt][$i][regle_id]=2;
                                                            echo $this->Form->input('regle_id', array('type' => 'hidden', 'value' => 3, 'name' => 'data[pieceregelemnt][' . $i . '][regle_id]', 'index' => $i, 'champ' => 'regle_id', 'id' => 'regle_id' . $i, 'div' => 'form-group', 'label' => '', 'between' => '<div class="col-sm-10 adrcli">', 'after' => '</div>', 'class' => 'form-control'));
                                                        }
                                                        ?>
                                                    </td>
                                                </tr> 
                                        <?php } ?> 
                                        </table>

    <?php if ($devisefournisseur != 1) { ?>                         
                                            <div class="row ligne" id="tablepaiement<?php echo $i; ?>" >

                                                <div class="col-md-12" >
                                                    <div class="panel panel-default" >
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><?php echo __('Situation'); ?></h3>
                                                            <a class="btn btn-danger ajouter_ligne_situation_reglement" table='addtablec' indexc='indexc' index='<?php echo $i; ?>' style="
                                                               float: right; 
                                                               position: relative;
                                                               top: -25px;
                                                               "><i class="fa fa-plus-circle"  ></i> Ajouter Situation</a>
                                                        </div>
                                                        <div class="panel-body">
                                                            <table class="table table-bordered table-striped table-bottomless" id="addtablec<?php echo $i; ?>" style="width:100%" align="center" >
                                                                <thead>
                                                                    <tr>
                                                                        <td align="center" nowrap="nowrap">Situation</td>
                                                                        <td align="center" nowrap="nowrap">Nouveau Echéance</td>
                                                                        <td align="center" nowrap="nowrap">Nbr Jours </td>
                                                                        <td align="center" nowrap="nowrap">Montant</td>
                                                                        <td align="center"></td>
                                                                        <td align="center"></td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="trstituation" style="display:none;">
                                                                        <td style="width:25%">
                                                                            <?php echo $this->Form->input('supp', array('name' => '', 'id' => '', 'champ' => 'supp', 'table' => 'etatpieceregelemnt', 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                                                            <?php
                                                                            echo $this->Form->input('etatpiecereglement_id', array('empty' => 'choix', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => ' affichesituation_virment_lc ',
                                                                                'label' => '', 'index' => '', 'id' => '', 'champ' => 'etatpiecereglement_id', 'table' => 'etatpieceregelemnt', 'name' => ''));
                                                                            ?>
                                                                        </td>
                                                                        <td style="width:25%">
                                                                            <?php echo $this->Form->input('echancenf', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'etatpieceregelemnt', 'index' => '', 'id' => '', 'champ' => 'echancenf', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                                                        </td>

                                                                        <td style="width:24%">
                                                                            <?php echo $this->Form->input('nbrjour', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'etatpieceregelemnt', 'index' => '', 'id' => '', 'champ' => 'nbrjour', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                                                        </td>
                                                                        <td style="width:25%">
        <?php echo $this->Form->input('montant', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'etatpieceregelemnt', 'index' => '', 'id' => '', 'champ' => 'montant', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control mnt')); ?>
                                                                        </td>
                                                                        <td align="center"> <input type="radio" name="" champ="contactchoisi"  index="" checked="checked"></td>

                                                                        <td align="center"><i ligne="0" index="" champ="croix_sup" id=""  class="fa fa-times supsituationreg" style="color: #c9302c;font-size: 22px;"></td>
                                                                    </tr>
                                                                    <?php
                                                                    $sutiationpieces = ClassRegistry::init('Situationpiecereglement')->find('all', array('conditions' => array('Situationpiecereglement.piecereglement_id' => $piece['Piecereglement']['id']), 'recursive' => 0, 'order' => array('Situationpiecereglement.id' => 'asc')));
                                                                    foreach ($sutiationpieces as $k => $sutiationpiece) {
                                                                        ?>  
                                                                        <tr>
                                                                            <td style="width:25%">
                                                                                <?php echo $this->Form->input('id', array('value' => @$sutiationpiece['Situationpiecereglement']['id'], 'name' => 'data[Situation][' . $i . '][etatpieceregelemnt][' . $k . '][id]', 'id' => $i . 'id' . $k, 'champp' => 'id', 'table' => 'etatpieceregelemnt', 'index' => $k, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                                                                <?php echo $this->Form->input('supp', array('name' => 'data[Situation][' . $i . '][etatpieceregelemnt][' . $k . '][supp]', 'id' => $i . 'supp' . $k, 'champp' => 'sup', 'table' => 'etatpieceregelemnt', 'index' => $k, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                                                                <?php
                                                                                echo $this->Form->input('etatpiecereglement_id', array('value' => @$sutiationpiece['Situationpiecereglement']['etatpiecereglement_id'], 'empty' => 'choix', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control affichesituation_virment_lc select',
                                                                                    'label' => '', 'index' => $k, 'id' => $i . 'etatpiecereglement_id' . $k, 'champ' => 'etatpiecereglement_id', 'table' => 'etatpieceregelemnt', 'name' => 'data[Situation][' . $i . '][etatpieceregelemnt][' . $k . '][etatpiecereglement_id]'));
                                                                                ?> 
                                                                            </td>
                                                                            <td style="width:25%">
                                                                                <?php echo $this->Form->input('echancenf', array('value' => date("d/m/Y", strtotime(str_replace('-', '/', @$sutiationpiece['Situationpiecereglement']['date']))), 'label' => '', 'div' => 'form-group', 'name' => 'data[Situation][' . $i . '][etatpieceregelemnt][' . $k . '][echancenf]', 'table' => 'etatpieceregelemnt', 'index' => $i, 'id' => $i . 'echancenf' . $k, 'champ' => 'echancenf', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control datePickerOnly')); ?>
                                                                            </td>
                                                                            <td style="width:24%">
                                                                                <?php echo $this->Form->input('nbrjour', array('value' => @$sutiationpiece['Situationpiecereglement']['nbrjour'], 'name' => 'data[Situation][' . $i . '][etatpieceregelemnt][' . $k . '][nbrjour]', 'id' => $i . 'nbrjour' . $k, 'table' => 'etatpieceregelemnt', 'index' => $k, 'champ' => 'nbrjour', 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                                            </td>
                                                                            <td style="width:25%">
            <?php echo $this->Form->input('montant', array('value' => @$sutiationpiece['Situationpiecereglement']['montant'], 'name' => 'data[Situation][' . $i . '][etatpieceregelemnt][' . $k . '][montant]', 'id' => $i . 'montant' . $k, 'table' => 'etatpieceregelemnt', 'index' => $k, 'champ' => 'montant', 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control mnt')); ?>
                                                                            </td>

                                                                            <td> <input id="<?php echo $i; ?>contactchoisi<?php echo $k; ?>" <?php if (@$sutiationpiece['Situationpiecereglement']['etatpiecereglement_id'] == $piece['Piecereglement']['etatpiecereglement_id']) { ?> checked="checked"  <?php } ?> type="radio" name="data[contactchoisi][<?php echo $i; ?>]" value="<?php echo $k; ?>" index="<?php echo $k; ?>" checked="checked"></td>
                                                                            <td align="center"><i ligne="<?php echo $i; ?>" index="<?php echo $k; ?>" champ="croix_sup" id="<?php echo $i; ?>croix_sup<?php echo $k; ?>" class="fa fa-times supsituationreg" style="color: #c9302c;font-size: 22px;"></td>
                                                                        </tr>
        <?php } ?> 
                                                                <input type="hidden" value="<?php echo $k; ?>" id="indexc<?php echo $i; ?>" />
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>	
                                                </div>
                                            </div>    

    <?php } ?>                        





                                    </td>
                                    <td>
                                        <i index="<?php echo $i ?>"  class="fa fa-times supreg" style="color: #c9302c;font-size: 22px;"/>
                                    </td>



                                </tr> 
<?php } ?>     
                            <input type="hidden" value="<?php echo @$i; ?>" class="index" id="index">
                            </tbody>
                        </table>
                    </div></div>
                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button id="btnenr" type="submit" class="btn btn-primary testmontanttotalereglementclient testtabledetraite testlignereglement ">Enregistrer</button>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

