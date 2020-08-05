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
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Transferts/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Modification Transfert'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Transfert', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>


                <div class="col-md-6">


                </div>
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
                             echo $this->Form->input('societearrive', array('value' => @$societearrive, 'id' => 'societearrive', 'label' => 'Societe Arrive', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'empty' => 'Veuillez Choisir !!'));
                             ?>
                        </div>  
                    </div>
                </div>
                <input type="hidden" value="<?php echo $typetransfert; ?>" id="typetransfert" />
                <input type="hidden" value="<?php echo $id ?>" id="id" />

                <div class="form-group " id="bout_act" >
                    <div class="col-lg-9 col-lg-offset-3">
                        <a  class="btn btn-primary edit_act_transfert test_soc_transfert" id="bout_act_tansf">Actualiser</a>
                    </div>
                </div>                        
                <?php if (!empty($societedepart)) { ?>                        
                    <div id="divkbira" >                 
                        <div class="col-md-3">                  
                            <?php
                            if (($typetransfert == 1)) {
                                echo $this->Form->input('pvdepart', array('id' => 'pvdepart', 'label' => 'Point de Vente Depart', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'empty' => 'Veuillez Choisir !!'));
                            }
                            echo $this->Form->input('depot_id', array('label' => 'Depot Depart', 'div' => 'form-group', 'id' => 'depot_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select inputspcial', 'empty' => 'Veuillez Choisir !!'));
                            echo $this->Form->input('id', array('div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                            echo $this->Form->input('numero', array('div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                            ?>
                        </div>
                        <div class="col-md-3">                  
                            <?php
                            echo $this->Form->input('date', array('value' => date("d/m/Y", strtotime(str_replace('/', '-', $this->request->data['Transfert']['date']))), 'div' => 'form-group', 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                            echo $this->Form->input('chauffeur', array('label' => 'Chauffeur', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?php
                            echo $this->Form->input('vehicule', array('label' => 'Véhicule', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                            echo $this->Form->input('trajet', array('label' => 'Parcours', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                            ?>
                        </div> 
                        <div class="col-md-3">
                            <?php
                            if (($typetransfert == 1)) {
                                echo $this->Form->input('pvarrive', array('id' => 'pvarrive', 'label' => 'Point de Vente Arrive', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'empty' => 'Veuillez Choisir !!'));
                            }
                            echo $this->Form->input('depotarrive', array('id' => 'depotarrive', 'value' => $transferts['Transfert']['depotarrive'], 'label' => 'Depot Arrive', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'empty' => 'Veuillez Choisir !!'));
                            //echo $this->Form->input('depotarrive',array('value'=>$transferts['Transfert']['depotarrive'],'type'=>'hidden','readonly'=>'readonly','label'=>'Depot Arrive','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
                            ?>
                        </div> 
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
                            <input id="lachaine" type="hidden" value="depot_id,code,designation,quantite" >
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

                                <?php
                                //debug($lignefactureclients);die;
                                foreach ($lignetransferts as $i => $l) {  //debug($tabt) ;
                                    $obj = ClassRegistry::init('Stockdepot');
                                    $stckdepot = $obj->find('all'
                                            , array(
                                        'fields' => array('sum(Stockdepot.quantite) as quantite')
                                        , 'conditions' => array('Stockdepot.article_id' => $l['Lignetransfert']['article_id'], 'Stockdepot.depot_id' => $l['Lignetransfert']['depot_id']), false));

                                    $objArticle = ClassRegistry::init('Article');
                                    $article = $objArticle->find('first', array('conditions' => array('Article.id' => $l['Lignetransfert']['article_id']), 'recursive' => -1));
                                    ?> 
                                    <tr class="cc<?php echo $i; ?>" >
                                        <td style="width:33%" champ="tdarticle" id="tdarticle0" >
                                            <?php echo $this->Form->input('idl', array('value' => $l['Lignetransfert']['id'], 'name' => 'data[Lignetransfert][' . $i . '][id]', 'id' => 'id' . $i, 'champ' => 'id', 'table' => 'Lignetransfert', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                            <?php //echo $this->Form->input('article_id',array('value'=>$l['Lignetransfert']['article_id'],'name' => 'data[Lignetransfert]['.$i.'][article_id]','index'=>$i,'id'=>'article_id'.$i,'label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select articleidbl','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );  ?>
                                            <div class="" style="display:inline; position: relative;">
                                                <?php
                                                echo $this->Form->input('article_id', array('div' => 'form-group', 'value' => $article['Article']['id'], 'name' => 'data[Lignetransfert][' . $i . '][article_id]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                                                echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => $article['Article']['code'], 'label' => '', 'name' => 'data[Lignetransfert][' . $i . '][code]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                                ?>
                                                <?php echo $this->Form->input('code', array('value' => $article['Article']['code'], 'div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control codeselect', 'type' => 'text'));
                                                ?><div id="res" champ="rescode" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>


                                            </div>
                                        </td>
                                        <td style="width:35%" id="tddesg<?php echo $i; ?>" index="<?php echo $i; ?>" champ="tddesg">
                                            <div class="" style="display:inline; position: relative;">
                                                <?php echo $this->Form->input('designation', array('value' => $article['Article']['name'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][designation]', 'table' => $tablesemi, 'index' => $i, 'id' => 'designation' . $i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                                <div id="res<?php echo $i; ?>" champ="res" index="<?php echo $i; ?>"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                            </div>
                                        </td>
                                        <td style="width:10%">
                                            <?php echo $this->Form->input('quantitestock', array('value' => $stckdepot[0][0]['quantite'] + $l['Lignetransfert']['quantite'], 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignetransfert][' . $i . '][quantitestock]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'quantitestock' . $i, 'champ' => 'quantitestock', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                        </td>
                                        <td style="width:10%">
                                            <?php echo $this->Form->input('sup', array('name' => 'data[Lignetransfert][' . $i . '][sup]', 'id' => 'sup' . $i, 'champ' => 'sup', 'table' => 'Lignetransfert', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                            <?php echo $this->Form->input('quantite', array('value' => $l['Lignetransfert']['quantite'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignetransfert][' . $i . '][quantite]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                            <?php echo $this->Form->input('prix', array('value' => $l['Lignetransfert']['prixht'], 'name' => 'data[Lignetransfert][' . $i . '][prixht]', 'id' => 'prixht' . $i, 'champ' => 'prixht', 'table' => 'Lignetransfert', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                            <?php echo $this->Form->input('tva', array('value' => $l['Lignetransfert']['tva'], 'name' => 'data[Lignetransfert][' . $i . '][tva]', 'id' => 'tva' . $i, 'champ' => 'tva', 'table' => 'Lignetransfert', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                            <?php echo $this->Form->input('prixttc', array('value' => $l['Lignetransfert']['prixttc'], 'name' => 'data[Lignetransfert][' . $i . '][prixttc]', 'id' => 'prixttc' . $i, 'champ' => 'prixttc', 'table' => 'Lignetransfert', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                        </td>
                                        <td style="width:10%">
                                            <?php echo $this->Form->input('remise', array('value' => $l['Lignetransfert']['remise'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignetransfert][' . $i . '][remise]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'remise' . $i, 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                        </td>
                                        <td style="width:2%" align="center"><i index="<?php echo $i; ?>"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                    </tr>


                                <?php } ?>
                            </tbody>
                        </table>
                        <input type="hidden" value="<?php echo $i; ?>" id="index" />

                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button type="submit" class="btn btn-primary testqtetransfert">Enregistrer</button>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div></div>
<?php } ?>
