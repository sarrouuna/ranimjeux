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
                <h3 class="panel-title"><?php echo __('Ajout règlement'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Reglement', array('autocomplete' => 'off', 'class' => 'form-horizontal', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('numeroconca', array('label' => 'Numéro', 'value' => @$mm, 'readonly' => 'readonly', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control ', 'index' => 0, 'champ' => 'numero'));
                    echo $this->Form->input('fournisseur_id', array('id'=>'fournisseur_id','div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control fournisseurreglement select ', 'empty' => 'veuillez choisir', 'value' => $fournisseur_id));
                     if ($p == 0) {
                        echo $this->Form->input('pointdevente_id', array('id'=>'pointdevente_id','empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select'));
                    }
                    ?>
                   
                </div><div class="col-md-6"><?php
                    echo $this->Form->input('Date', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'type' => 'text', 'value' => date("d/m/Y")));
                    echo $this->Form->input('designation', array('value' => @$namefournisseur, 'label' => 'Designation', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control '));
                    ?>
                    <div id="divimportation" style="display:none;">
                        <?php
                        echo $this->Form->input('importation_id', array('id' => 'importation_id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control getinfoimportation select ', 'empty' => 'veuillez choisir'));
                        ?>
                    </div>
                    <div class="form-group"> 
                        <input type="hidden" name="data[Reglement][devisefournisseur]"  value="<?php echo @$devisefournisseur; ?>" id="devisefournisseur">
                        <label class="col-md-2 control-label">Règlement Libre</label>
                        <div class="col-sm-10">    

                            NON <input type="radio" name="data[Reglement][libre]" value="0" checked="checked" class="libreFR"> 
                            OUI <input type="radio" name="data[Reglement][libre]" value="1" class="libreFR"> 
                            <input type="hidden"  id="inputlibre">
                    </div></div>
                </div>  
                <?php if ($fournisseur_id != 0) { ?>
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
                                    if (!empty($facture)) {
                                        foreach ($facture as $i => $fac) {
                                            //debug($fac);die;   
                                            if ($devisefournisseur == 1) {
                                                $reste = sprintf('%.3f', $fac['Facture']['totalttc'] - $fac['Facture']['Montant_Regler']);
                                            } else {
                                                $reste = sprintf('%.3f', $fac['Importation']['montantachat'] * $fac['Importation']['tauxderechenge'] - ($fac['Facture']['Montant_Regler'] * $fac['Facture']['tauxchange']));
                                            }
                                            if ($fac['Facture']['type'] == "Service") {
                                                $fac['Facture']['importation_id'] = 0;
                                            }
                                            ?>
                                            <tr id="trfacture<?php echo $i; ?>">
                                                <td><?php echo $fac['Facture']['numerofrs']; ?></td>
                                                <td><?php echo $fac['Facture']['numero']; ?></td>
                                                <td><?php echo $fac['Facture']['date']; ?></td>
                                                <td><?php echo $fac['Facture']['totalttc']; ?></td>
                                        <?php if ($devisefournisseur != 1) { ?>
                                                    <td><?php echo $fac['Importation']['montantachat']; ?></td>
                                            <input type="hidden"  value="<?php echo $fac['Importation']['montantachat']; ?>" id="montantachat">
                                            <input type="hidden"  value="<?php echo ($fac['Facture']['Montant_Regler']); ?>" id="Montant_Regler">
                                            <td><input readonly="readonly" type="text" value="<?php echo $fac['Importation']['tauxderechenge']; ?>" class="form-control calculer_m_apayer" id="tc" size="3" name="data[Lignereglement][<?php echo $i; ?>][tauxchange]"></td>
            <?php } ?>
                                        <td><?php echo sprintf('%.3f', $fac['Facture']['Montant_Regler'] ); ?></td>
                                        <td><span id="spanreste"><?php echo $reste; ?></span></td>
                                        <input type="hidden" name="" id="devise<?php echo $i; ?>" class="form-control"  value="<?php echo @$fac['Facture']['totaldevise']; ?>" >
                                        <div style="display:none;">
                                            <input type="checkbox" name="data[Lignereglement][<?php echo $i; ?>][importation_id]" id="importation_id<?php echo $i; ?>" index="<?php echo $i; ?>" class="" value="<?php echo $fac['Facture']['importation_id'] ?>" >
                                        </div>
                                        <td  style="width:15%;">
                                            <table >
                                            <tr> 
                                            <td style="width:1%;">    
                                              <input type="checkbox" importation="<?php echo $fac['Facture']['importation_id']; ?>" name="data[Lignereglement][<?php echo $i; ?>][facture_id]" id="facture_id<?php echo $i; ?>" index="<?php echo $i; ?>" class="chekreglement calculereglement afficheinputmontantreglementclient" value="<?php echo $fac['Facture']['id'] ?>" mnttounssi="<?php echo $fac['Facture']['totalttc']; ?>" mnt="<?php echo $reste; ?>" compte="<?php echo $fac['Facture']['compte_id']; ?>" >
                                            </td>
                                            <td style="width:99%;" align="left">
                                            <?php
                                            echo $this->Form->input('Montanttt',array('style'=>'display:none','index'=>$i,'name'=>'data[Lignereglement]['.$i.'][Montant]','id'=>'Montantregler'.$i,'label'=>'','div'=>'','between'=>'<div class="col-sm-12">','after'=>'','type'=>'text','class'=>'form-control testmontantreglementclient') );
                                            ?>
                                            </td>    
                                            </tr>
                                            </table>
                                            </td>
                                        </tr>
        <?php }
    } ?>
                                <input type="hidden" name="max" value="<?php echo @$i; ?>" id="max">
                                
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
                                <?php 
                                $im= $reste=0;
                                //debug($facture);
                                foreach($impayes as $im=>$fac){//debug($b);die;
                                    $reste=$fac['Piecereglement']['montant']-$fac['Piecereglement']['mantantregler'];
                                    ?>
                                <tr id="trfactureimp<?php echo $im; ?>">
                                    <td  colspan="2" > <?php echo $fac['Piecereglement']['num']; ?></td>
                                    <td ><?php echo date("d/m/Y",strtotime(str_replace('-','/',$fac['Piecereglement']['echance']))); ?></td>
                                    <td ><?php echo number_format($fac['Piecereglement']['montant'],3, '.', ' '); ?></td>
                                    <td ><?php echo number_format($fac['Piecereglement']['mantantregler'],3, '.', ' '); ?></td>
                                    <td ><?php echo number_format($reste,3, '.', ' '); ?></td>
                                    <td  style="width:15%;">
                                        <table >
                                            <tr> 
                                            <td style="width:1%;">    
                                            <input type="checkbox" champ="piece" name="data[Lignereglementimpaye][<?php echo $im; ?>][piecereglementclient_id]" id="impaye_id<?php echo $im; ?>" index="<?php echo $im; ?>" class="calculereglementclient afficheinputmontantreglementclientimpaye" value="<?php echo $fac['Piecereglement']['id'] ?>" mnt="<?php echo $reste; ?>" >
                                            </td>
                                            <td style="width:99%;" align="left">
                                            <?php
                                            echo $this->Form->input('Montanttt',array('style'=>'display:none','index'=>$im,'name'=>'data[Lignereglementimpaye]['.$im.'][Montant]','id'=>'Montantreglerimpaye'.$im,'label'=>'','div'=>'','between'=>'<div class="col-sm-12">','after'=>'','type'=>'text','class'=>'form-control testmontantreglementclientimpaye') );
                                            ?>
                                            </td>    
                                            </tr>
                                        </table>    
                                    </td>
                                </tr>
                                <?php }?>
                            <input type="hidden" name="max" value="<?php echo $im; ?>" id="maximpaye">
                                
                                
                                
                                
    <?php if ($devisefournisseur == 1) {
        $colspan = 4;
    } else {
        $colspan = 6;
    } ?>  

                                <tr id="totalefacture">
                                    <td colspan="<?php echo $colspan; ?>"> Total factures</td>
                                    <td colspan="3">
                                        <input type="text" name="data[Reglement][ttpayer]" id="ttpayer" class="form-control"  value="0.000" readonly>
                                    </td> 
                                </tr>

                                <tr id="montantpayer">
                                    <td colspan="<?php echo $colspan; ?>">Montant à payer</td>
                                    <td colspan="3">
                                        <input type="text" name="data[Reglement][Montant]" id="Montant" class="form-control"  value="0.000" readonly>
                                    </td>
                                </tr>
                                <tr id="netapayer">
                                    <td colspan="<?php echo $colspan; ?>"> Net à payer</td>
                                    <td colspan="3">
                                        <input type="text" name="data[Reglement][netapayer]" id="netapayer" class="form-control netapayer"  value="0.000" readonly>
                                    </td>
                                </tr>

                                <tr>
    <?php if ($devisefournisseur == 1) {
        $colspan = 7;
    } else {
        $colspan = 9;
    } ?>    
                                    <td colspan="<?php echo $colspan; ?>">
                                        <input type="hidden" value="0" class="index" id="index">
                                        <input type="hidden" value="<?php echo $devisefournisseur; ?>"  id="typefrs">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Pièces règlement</h3>

                                            <a class="btn btn-danger ajouterligne" table='table' index='index' tr='type'  style="
                                               float: right; 
                                               position: relative;
                                               top: -25px;"> <i class="fa fa-plus-circle"  ></i>Ajouter ligne</a>

                                        </div></td>
                                </tr>
    <?php if ($devisefournisseur == 1) {
        $colspan = 2;
    } else {
        $colspan = 4;
    } ?>     
                                <tr  class='type'  style="display: none !important"> 
                                    <td colspan="8" style="vertical-align: top;">
                                        <table>
                                            <tr>
                                                <td >Mode règlement </td>  
                                                <td >
                                                    <?php
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
                                                <td name="data[][0][trtaux]" id="" index="0"  champ="trtauxa" table="piece"  style="display:none" class="modecheque">Taux</td>  
                                                <td name="data[piece][0][trtaux]" ipieced="" index="0"  champ="trtauxb" table="piece"  style="display:none" class="modecheque"><?php
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
        <?php echo $this->Form->input('montant', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'etatpieceregelemnt', 'index' => '', 'id' => '', 'champ' => 'montant', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control mnt')); ?>
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
    <!--                                        <td colspan="<?php echo $colspan; ?>" style="vertical-align: top;"> 
                                    <?php if ($devisefournisseur != 1) { ?>    
                                           <table id="" index="" champ="tablepaiement" style="display:none;">
                                            <tr>
                                                <td >Mode Paiement </td>  
                                                <td ><?php
                                echo $this->Form->input('etatpiecereglement_id', array('empty' => 'choix', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control affichesituation_virment_lc    ',
                                    //'empty'=>'veuillez choisir',
                                    'label' => '', 'index' => "", 'id' => '', 'champ' => 'etatpiecereglement_id', 'table' => 'etatpieceregelemnt', 'name' => ''));
                                ?> </td>  
                                            </tr>
                                             <tr id="" index=""  champ="tragio"   style="display:none" >
                                                <td>Agio</td>  
                                                <td>    
                                        <?php //echo $this->Form->input('agio',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>"",'id'=>'','champ'=>'agio','table'=>'etatpieceregelemnt','name'=>'') );  ?>  
                                                </td>
                                            </tr>
                                            <tr id="" index=""  champ="trnbrjours"   style="display:none" >
                                                <td>Nombre de jours</td>  
                                                <td>    
                                        <?php echo $this->Form->input('nbrjours', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'label' => '', 'type' => 'text', 'index' => "", 'id' => '', 'champ' => 'nbrjours', 'table' => 'etatpieceregelemnt', 'name' => '')); ?>  
                                                </td>
                                            </tr>
                                            <tr id="" index=""  champ="trnbrmoin"   style="display:none" >
                                                <td>Nombre de mois</td>  
                                                <td>    
                                        <?php echo $this->Form->input('nbrmoins', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control tabledemoins', 'label' => '', 'type' => 'text', 'index' => '', 'id' => '', 'champ' => 'nbrmoins', 'table' => 'etatpieceregelemnt', 'name' => '')); ?>  
                                                </td>
                                            </tr>
                                            <tr id="" index=""  champ="trmontant" >
                                                <td >Montant</td>  
                                                <td  ><?php
                                        echo $this->Form->input('montantp', array('readonly' => 'readonly', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'label' => '', 'index' => "", 'champ' => 'montantp', 'id' => '', 'table' => 'etatpieceregelemnt', 'name' => ''));
                                        ?> </td>  
                                            </tr>
                                            <tr id="" index=""  champ="trechance"   style="display:none">
                                                <td>Nouveau Echéance</td>  
                                                <td><?php
                                echo $this->Form->input('echancep', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'label' => '', 'type' => 'text', 'index' => "", 'id' => '', 'champ' => 'echancep', 'table' => 'etatpieceregelemnt', 'name' => ''));
                                ?> 
                                                </td>  
                                            </tr>
                                            <tr id="" index=""  champ="trnum"  style="display:none">
                                                <td>Numéro pièce</td>  
                                                <td>
        <?php echo $this->Form->input('num_piecep', array('readonly' => 'readonly', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control ', 'label' => '', 'type' => 'text', 'index' => "", 'id' => '', 'champ' => 'num_piecep', 'table' => 'etatpieceregelemnt', 'name' => '')); ?>
                                                </td>   
                                            </tr>
                                            <tr id="" index=""  champ="trbanque"   style="display:none;">
                                                <td>Compte</td>  
                                                <td><?php
                                                        echo $this->Form->input('comptedes', array('readonly' => 'readonly', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control ',
                                                            'label' => '', 'index' => "", 'id' => '', 'champ' => 'compte_idp', 'table' => 'etatpieceregelemnt', 'name' => ''));
                                                        ?> </td>  
                                            </tr>
                                            </table>
                                            <div id="" index="" champ="pop"></div>
    <?php } ?>    
                                    </td>            -->
                                    <td><i index=""  class="fa fa-times supreg" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>



                                <tr>
                                    <td colspan="8" style="vertical-align: top;">
                                        <table id="table0" >
                                            <tr>
                                                <td >Mode règlement </td>  
                                                <td ><?php
    echo $this->Form->input('paiement_id', array('empty' => 'choix', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control modereglement select  ',
        //'empty'=>'veuillez choisir',
        'label' => '', 'index' => 0, 'id' => 'paiement_id0', 'champ' => 'paiement_id', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][paiement_id]'));
    ?> 
                                                    <?php echo $this->Form->input('sup', array('name' => 'data[pieceregelemnt][0][sup]', 'id' => 'sup0', 'champ' => 'sup', 'table' => 'pieceregelemnt', 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                                </td>  
                                            </tr>
                                            <tr >
                                                <td name="data[piece][0][trmontantbrut]" id="trmontantbruta0" index="0"  champ="trmontantbruta" table="piece"  style="display:none" class="modecheque">Montant brut</td>  
                                                <td name="data[piece][0][trmontantbrut]" id="trmontantbrutb0" index="0"  champ="trmontantbrutb" table="piece"  style="display:none" class="modecheque"><?php
                                                    echo $this->Form->input('montant_brut', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control montantbrut', 'label' => '', 'type' => 'text', 'index' => 0, 'champ' => 'montantbrut', 'id' => 'montantbrut0', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][montant_brut]'));
                                                    ?> </td>  
                                            </tr>
                                            <tr >
                                                <td name=ta[piece][0][trt"daaux]" id="trtauxa0" index="0"  champ="trtauxa" table="piece"  style="display:none" class="modecheque">Taux</td>  
                                                <td name="data[piece][0][trtaux]" id="trtauxb0" index="0"  champ="trtauxb" table="piece"  style="display:none" class="modecheque"><?php
                                                    echo $this->Form->input('valeur_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'select montantbrut', 'label' => '', 'index' => 0, 'champ' => 'taux', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][taux]', 'id' => 'taux0', 'empty' => 'Veuillez choisir'));
                                                    ?> </td>  
                                            </tr>
                                            <tr>
                                                <td >Montant</td>  
                                                <td  ><?php
                                                    echo $this->Form->input('montant', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control mnt', 'label' => '', 'index' => 0, 'champ' => 'montant', 'id' => 'montant0', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][montant]'));
                                                    echo $this->Form->input('montantdevise', array('type' => 'hidden', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'label' => '', 'index' => 0, 'champ' => 'montantdevise', 'id' => 'montantdevise0', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][montantdevise]'));
                                                    echo $this->Form->input('prixachattounssi', array('type' => 'hidden', 'id' => 'prixachattounssi', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control ', 'label' => '', 'index' => 0, 'champ' => 'prixachattounssi', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][prixachattounssi]'));
                                                    ?> </td>  
                                            </tr>
                                            <tr >
                                                <td name="data[piece][0][trmontantnet]" id="trmontantneta0" index="0"  champ="trmontantneta" table="piece"  style="display:none" class="modecheque">Montant Net</td>  
                                                <td name="data[piece][0][trmontantnet]" id="trmontantnetb0" index="0"  champ="trmontantnetb" table="piece"  style="display:none" class="modecheque"><?php
                                                    echo $this->Form->input('montant_net', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'label' => '', 'type' => 'text', 'index' => 0, 'id' => 'montantnet0', 'champ' => 'montantnet', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][montant_net]'));
                                                    ?> </td>  
                                            </tr>
                                            <tr >
                                                <td name="data[piece][0][trechance]" id="trechancea0" index="0"  champ="trechancea" table="piece"  style="display:none" class="modecheque">Echéance</td>  
                                                <td name="data[piece][0][trechance]" id="trechanceb0" index="0"  champ="trechanceb" table="piece"  style="display:none" class="modecheque"><?php
                                                    echo $this->Form->input('echance', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'label' => '', 'type' => 'text', 'index' => 0, 'id' => 'echance0', 'champ' => 'echance', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][echance]'));
                                                    ?> </td>  
                                            </tr>
                                            <!-- //***************************************************--->
                                            <tr><td name="data[piece][0][trcarnetnum]" id="trcarnetnuma0" index="0"  champ="trcarnetnuma" table="piece"  style="display:none" class="modecheque" >Numéro de carnet</td>  
                                                <td  name="data[piece][0][trcarnetnum]" id="trcarnetnumb0" index="0"  champ="trcarnetnumb" table="piece"  style="display:none" class="modecheque"><?php
                                                        echo $this->Form->input('carnetcheque_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select getnumcheque  ', 'empty' => 'veuillez choisir',
                                                            'label' => '', 'index' => 0, 'champ' => 'carnetcheque_id', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][carnetcheque_id]'));
                                                        ?></td>
                                            </tr>
                                            <!-- //***************************************************--->
                                            <tr >
                                                <td name="data[piece][0][trnum]" id="trnuma0" index="0"  champ="trnuma" table="piece"  style="display:none" class="modecheque" >Numéro pièce</td>  

                                                <td  name="data[piece][0][trnum]" id="trnumb0" index="0"  champ="trnumb" table="piece"  style="display:none" class="modecheque">
                                                    <div class='form-group' id="divnumc0" index="0"  champ="divnumc" table="piece"  style="display:none" >
                                                        <label class='col-md-2 control-label'></label>
                                                        <div class='col-sm-10'  name="data[piece][0][trnum]" id="trnumc0" index="0"  champ="trnumc" table="piece" class="modecheque">     </div>
                                                    </div>
                                                    <div class='form-group ' id="divnump0" index="0"  champ="divnump" table="piece"  style="display:none" >
                                                        <div class='col-sm-12'>
                                        <?php echo $this->Form->input('num_piece', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control ', 'label' => '', 'type' => 'text', 'id' => 'num_piece0', 'index' => 0, 'champ' => 'num_piece', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][num_piece]')); ?>
                                                        </div>
                                                    </div>
                                                </td>   
                                            </tr>
                                            <tr>
                                                <td name="data[piece][0][banque]" id="trbanquea0" index="0"  champ="banquea" table="piece"  style="display:none" class="modecheque" >Compte</td>  
                                                <td  name="data[piece][0][banque]" id="trbanqueb0" index="0"  champ="banqueb" table="piece"  style="display:none" class="modecheque"><?php
                                    echo $this->Form->input('compte_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select', 'empty' => 'veuillez choisir',
                                        'label' => '', 'index' => 0, 'id' => 'compte_id0', 'champ' => 'compte_id', 'table' => 'pieceregelemnt', 'name' => 'data[pieceregelemnt][0][compte_id]'));
                                    ?> </td>  
                                            </tr>
    <?php if ($devisefournisseur != 1) { ?>  
                                                <tr style="display:none" id="tr_regle_fournisseur0">
                                                    <td>Reglé Fournisseur</td>  
                                                    <td>
        <?php echo $this->Form->input('regle_id', array('name' => 'data[pieceregelemnt][0][regle_id]', 'index' => 0, 'champ' => 'regle_id', 'id' => 'regle_id0', 'div' => 'form-group', 'label' => '', 'between' => '<div class="col-sm-10 adrcli">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                    </td>
                                                </tr>
    <?php } ?>  
                                        </table>
    <?php if ($devisefournisseur != 1) { ?>                         
                                            <div class="row ligne" id="tablepaiement0" style="display:none;">

                                                <div class="col-md-12" >
                                                    <div class="panel panel-default" >
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><?php echo __('Situation'); ?></h3>
                                                            <a class="btn btn-danger ajouter_ligne_situation_reglement" table='addtablec' indexc='indexc' index='0' style="
                                                               float: right; 
                                                               position: relative;
                                                               top: -25px;
                                                               "><i class="fa fa-plus-circle"  ></i> Ajouter Situation</a>
                                                        </div>
                                                        <div class="panel-body">
                                                            <table class="table table-bordered table-striped table-bottomless" id="addtablec0" style="width:100%" align="center" >
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
                                                                            <?php echo $this->Form->input('montant', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'etatpieceregelemnt', 'index' => '', 'id' => '', 'champ' => 'montant', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                                        </td>
                                                                        <td align="center"> <input type="radio" name="" champ="contactchoisi"  index="" checked="checked"></td>

                                                                        <td align="center"><i ligne="0" index="" champ="croix_sup" id=""  class="fa fa-times supsituationreg" style="color: #c9302c;font-size: 22px;"></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td style="width:25%">
        <?php echo $this->Form->input('supp', array('name' => 'data[Situation][0][etatpieceregelemnt][0][supp]', 'id' => '0supp0', 'champp' => 'sup', 'table' => 'etatpieceregelemnt', 'index' => '0', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
        <?php
        echo $this->Form->input('etatpiecereglement_id', array('empty' => 'choix', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control affichesituation_virment_lc select',
            'label' => '', 'index' => 0, 'id' => '0etatpiecereglement_id0', 'champ' => 'etatpiecereglement_id', 'table' => 'etatpieceregelemnt', 'name' => 'data[Situation][0][etatpieceregelemnt][0][etatpiecereglement_id]'));
        ?> 
                                                                        </td>
                                                                        <td style="width:25%">
                                        <?php echo $this->Form->input('echancenf', array('label' => '', 'div' => 'form-group', 'name' => 'data[Situation][0][etatpieceregelemnt][0][echancenf]', 'table' => 'etatpieceregelemnt', 'index' => '0', 'id' => '0echancenf0', 'champ' => 'echancenf', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control datePickerOnly')); ?>
                                                                        </td>
                                                                        <td style="width:24%">
        <?php echo $this->Form->input('nbrjour', array('name' => 'data[Situation][0][etatpieceregelemnt][0][nbrjour]', 'id' => '0nbrjour0', 'table' => 'etatpieceregelemnt', 'index' => '0', 'champ' => 'nbrjour', 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                                        </td>
                                                                        <td style="width:25%">
                                        <?php echo $this->Form->input('montant', array('name' => 'data[Situation][0][etatpieceregelemnt][0][montant]', 'id' => '0montant0', 'table' => 'etatpieceregelemnt', 'index' => '0', 'champ' => 'montant', 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                                                        </td>

                                                                        <td> <input type="radio" name="data[contactchoisi][0]" value="0" index="0" checked="checked"></td>
                                                                        <td align="center"><i ligne="0" index="0" champ="croix_sup" id="0croix_sup0" class="fa fa-times supsituationreg" style="color: #c9302c;font-size: 22px;"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <input type="hidden" value="0" id="indexc0" />
                                                        </div>
                                                    </div>
                                                </div>                
                                            </div> 
                                    <?php } ?>                                 </td>
                                        <!--                                        <td colspan="<?php echo $colspan; ?>" style="vertical-align: top;"> 
    <?php if ($devisefournisseur != 1) { ?>     
                                                                                        <table id="tablepaiement0" style="display:none;">
                                                                                        <tr>
                                                                                            <td >Mode Paiement </td>  
                                                                                            <td ><?php
        echo $this->Form->input('etatpiecereglement_id', array('empty' => 'choix', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control affichesituation_virment_lc  select  ',
            //'empty'=>'veuillez choisir',
            'label' => '', 'index' => 0, 'id' => 'etatpiecereglement_id0', 'champ' => 'etatpiecereglement_id', 'table' => 'etatpieceregelemnt', 'name' => 'data[etatpieceregelemnt][0][etatpiecereglement_id]'));
        ?> </td>  
                                                                                        </tr>
                                                                                        <tr id="trnbrjours0" index="0"  champ="trnbrjours" table="piece"  style="display:none" class="modecheque">
                                                                                            <td>Nombre de jours</td>  
                                                                                            <td>    
        <?php echo $this->Form->input('nbrjours', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'label' => '', 'type' => 'text', 'index' => "0", 'id' => 'nbrjours0', 'champ' => 'nbrjours', 'table' => 'etatpieceregelemnt', 'name' => 'data[etatpieceregelemnt][0][nbrjours]')); ?>  
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr id="trnbrmoin0" index="0"  champ="trnbrmoin" table="piece"  style="display:none" class="modecheque">
                                                                                            <td>Nombre de mois</td>  
                                                                                            <td>    
        <?php echo $this->Form->input('nbrmoins', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control tabledemoins', 'label' => '', 'type' => 'text', 'index' => '0', 'id' => 'nbrmoins0', 'champ' => 'nbrmoins', 'table' => 'etatpieceregelemnt', 'name' => 'data[etatpieceregelemnt][0][nbrmoins]')); ?>  
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr id="tragio0" index="0"  champ="tragio"   style="display:none" >
                                                                                            <td>Agio</td>  
                                                                                            <td>    
        <?php //echo $this->Form->input('agio',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>"0",'id'=>'agio0','champ'=>'agio','table'=>'etatpieceregelemnt','name'=>'data[etatpieceregelemnt][0][agio]') );   ?>  
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr id="trmontant0" index="0"  champ="trmontant" table="piece">
                                                                                            <td >Montant</td>  
                                                                                            <td  ><?php
        echo $this->Form->input('montantp', array('readonly' => 'readonly', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'label' => '', 'index' => 0, 'champ' => 'montantp', 'id' => 'montantp0', 'table' => 'etatpieceregelemnt', 'name' => 'data[etatpieceregelemnt][0][montantp]'));
        ?> </td>  
                                                                                        </tr>
                                                                                        <tr id="trechance0" index="0"  champ="trechance"   style="display:none">
                                                                                            <td>Nouveau Echéance</td>  
                                                                                            <td><?php
        echo $this->Form->input('echancep', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'label' => '', 'type' => 'text', 'index' => 0, 'id' => 'echancep0', 'champ' => 'echancep', 'table' => 'etatpieceregelemnt', 'name' => 'data[etatpieceregelemnt][0][echancep]'));
        ?> 
                                                                                            </td>  
                                                                                        </tr>
                                                                                        <tr id="trnum0" index="0"  champ="trnum" table="piece"  style="display:none">
                                                                                            <td>Numéro pièce</td>  
                                                                                            <td>
        <?php echo $this->Form->input('num_piecep', array('readonly' => 'readonly', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control ', 'label' => '', 'type' => 'text', 'index' => 0, 'id' => 'num_piecep0', 'champ' => 'num_piecep', 'table' => 'etatpieceregelemnt', 'name' => 'data[etatpieceregelemnt][0][num_piecep]')); ?>
                                                                                            </td>   
                                                                                        </tr>
                                                                                        <tr id="trbanque0" index="0"  champ="trbanque" table="piece"  style="display:none"  >
                                                                                            <td>Compte</td>  
                                                                                            <td><?php
        echo $this->Form->input('comptedes', array('readonly' => 'readonly', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control ',
            'label' => '', 'index' => 0, 'id' => 'compte_idp0', 'champ' => 'compte_idp', 'table' => 'etatpieceregelemnt', 'name' => 'data[etatpieceregelemnt][0][compte_idp]'));
        ?> </td>  
                                                                                        </tr>
                                                                                        </table>
                                                                                        <div id="pop0" index="0" champ="pop"></div>
    <?php } ?>     
                                                                                </td>    -->
                                    <td>
                                        <i index="0"  class="fa fa-times supreg" style="color: #c9302c;font-size: 22px;"/>
                                    </td>
                                </tr>

                                </tbody>


                            </table>
                        </div></div>


                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button id="btnenr" disabled type="submit" class="btn btn-primary testmontanttotalereglementclient testtabledetraite  testlignereglement btnReglementFrs">Enregistrer</button>
                        </div>
                    </div>
<?php } ?>
<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

