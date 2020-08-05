<script>
    window.onload = function () {
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
    };
</script>

<br>
<input type="hidden" id="page" value="transfert"/>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading not_padinng">

                <h3 class="panel-title taille_titre">
                    <a class="btn btn btn-danger a_color" href="<?php echo $this->webroot; ?>Transferts/index"/> <i class="fa fa-reply"></i> Retour </a>
                    <strong><?php echo __('Ajout Transfert'); ?></strong>
                </h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Transfert', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>
                <?php echo $this->Form->input('page', array('value' => 'transfert', 'id' => 'page', 'type' => 'hidden', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire')); ?>

                <div class="col-md-12">
                    <div class="col-md-4">
                        <div id="div_soc_depart" <?php if (($societedepart == 0)) { ?>style="display: none;"<?php } ?>>     
                            <?php
                            echo $this->Form->input('societedepart', array('value' => @$societedepart, 'id' => 'societedepart', 'label' => 'Societe Depart', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select ', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'empty' => 'Veuillez Choisir !!'));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"> 
                            <label class="col-md-2 control-label">Transfert</label>
                            <div class="col-sm-10">    

                                Meme societe <input id="meme" class="typetransfert" type="radio" name="data[Transfert][type]" value="0" <?php
                                if (isset($typetransfert)) {
                                    if (@$typetransfert == 0) {
                                        ?>checked="checked"<?php
                                                        }
                                                    }
                                                    ?>> 
                                Entre societe <input id="entre" class="typetransfert" type="radio" name="data[Transfert][type]" value="1" <?php
                                if (isset($typetransfert)) {
                                    if (@$typetransfert == 1) {
                                        ?>checked="checked"<?php
                                                         }
                                                     }
                                                     ?>> 

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div id="div_soc_arrive" <?php
                        //debug($societearrive);
                        if (($typetransfert == 0)) {
                            ?>style="display: none;" <?php } ?> >    
                             <?php
                             echo $this->Form->input('societearrive', array('value' => @$societearrive, 'id' => 'societearrive', 'label' => 'Societe Arrive', 'div' => 'form-group inputspcial', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select ', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'empty' => 'Veuillez Choisir !!'));
                             ?>
                        </div>  
                    </div>
                </div>

                <input type="hidden" value="0" id="typetransfert" />            
                <div class="form-group " id="bout_act" style="display: none;">
                    <div class="col-lg-9 col-lg-offset-3">
                        <a  class="btn btn-primary act_transfert test_soc_transfert" id="bout_act_tansf">Actualiser</a>
                    </div>
                </div>                        
                <?php if (!empty($societedepart)) { ?>                        
                    <div id="divkbira" class="col-md-12">                      
                        <div class="col-md-3">                  
                            <?php
                            if (($typetransfert == 1)) {
                                echo $this->Form->input('pvdepart', array('id' => 'pvdepart', 'label' => 'Point de Vente Depart', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'empty' => 'Veuillez Choisir !!'));
                            }
                            echo $this->Form->input('depot_id', array('label' => 'Depot Depart', 'div' => 'form-group', 'id' => 'depot_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select inputspcial', 'empty' => 'Veuillez Choisir !!'));
                            echo $this->Form->input('numero', array('value' => $mm, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                            ?>
                        </div>
                        <div class="col-md-3">                  
                            <?php
                            echo $this->Form->input('date', array('div' => 'form-group', 'value' => date("d/m/Y"), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                            echo $this->Form->input('chauffeur', array('label' => 'Chauffeur', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                            ?>
                        </div>
                        <div class="col-md-3"><?php
                            echo $this->Form->input('vehicule', array('label' => 'Véhicule', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                            echo $this->Form->input('trajet', array('label' => 'Parcours', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                            ?>
                        </div> 
                        <div class="col-md-3"><?php
                            if (($typetransfert == 1)) {
                                echo $this->Form->input('pvarrive', array('id' => 'pvarrive', 'label' => 'Point de Vente Arrive', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'empty' => 'Veuillez Choisir !!'));
                            }
                            echo $this->Form->input('depotarrive', array('id' => 'depotarrive', 'label' => 'Depot Arrive', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'empty' => 'Veuillez Choisir !!'));
                            ?>
                        </div> 
                        <!-- Autre ligne commande-->
                        <div class="clear"></div>  
                        <table class="table table-bordered table-striped table-bottomless tablejdid scrollh" id="addtable" style="width:100%" align="center" >
                            <thead>
                                <tr class="entetetab" style="background-color: #c6b9b9;">
                                    <td align="center" nowrap="nowrap" width="33%">Article</td>
                                    <td align="center" nowrap="nowrap" width="35%">Designation</td>
                                    <td align="center" nowrap="nowrap" width="10%"> Quantit&egrave;	 en Stock </td>
                                    <td align="center" nowrap="nowrap" width="10%"> Quantit&egrave;	 </td>
                                    <td align="center" nowrap="nowrap" width="10%"> Remise </td>
                                    <td align="center" width="2%">

                                        <a class="btn btn-danger" onclick="ajouter_ligne_livraison1('addtable', 'index', 'tr')" table='addtable' index='index'  tr="tr" style="
                                           padding: 0px 6px;
                                           "><i class="fa fa-plus-circle"  ></i> </a>

                                    </td>
                                </tr>
                            </thead>
                            <?php $tablesemi = 'Lignetransfert'; ?>
                            <input id="lachaine" type="hidden" value="depot_id,code,designation,quantite,remise" >
                            <input id="interfacetransfert" type="hidden" value="transfert" >
                            <input id="trans_remise" type="hidden" value="1" >
                            <tbody>
                                <tr class="tr" style="display:none;" >
                                    <td style="width:33%" champ="tdarticle" id="">
                                        <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignetransfert','index'=>'','id'=>'','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  articleidbl','empty'=>'Veuillez Choisir !!') );   ?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php
                                            echo $this->Form->input('article_id', array('div' => 'form-group', 'name' => '', 'table' => 'Lignetransfert', 'index' => '', 'id' => '', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                                            echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => 'Lignetransfert', 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                            ?>
                                            <?php echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control codeselect', 'type' => 'text'));
                                            ?><div id="res" champ="rescode" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>

                                        </div>
                                    </td>
                                    <td  style="width:35%" id="" index="" champ="tddesg">
                                        <div class="" style="display:inline; position: relative;">
                                            <?php echo $this->Form->input('designation', array('div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => '', 'table' => 'Lignetransfert', 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text'));
                                            ?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                        </div>
                                    </td>
                                    <td style="width:10%">
                                        <?php echo $this->Form->input('quantitestock', array('readonly' => 'readonly', 'label' => '', 'div' => 'form-group', 'name' => '', 'table' => 'Lignetransfert', 'index' => '', 'id' => 'quantitestock', 'champ' => 'quantitestock', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                    </td>
                                    <td style="width:10%">
                                        <?php echo $this->Form->input('sup', array('name' => '', 'id' => '', 'champ' => 'sup', 'table' => 'Lignetransfert', 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                        <?php echo $this->Form->input('quantite', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignetransfert', 'index' => '', 'id' => '', 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control verifqtetrsf ')); ?>
                                    </td>
                                    <td style="width:10%">
                                        <?php echo $this->Form->input('remise', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignetransfert', 'index' => '', 'id' => '', 'champ' => 'remise', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                    </td>
                                    <td style="width:2%" align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" value="0" id="index" />
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button type="submit" class="btn btn-primary testqtetransfert">Enregistrer</button>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <?php
}?>