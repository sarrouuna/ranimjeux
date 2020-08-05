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
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading not_padinng">

                <h3 class="panel-title taille_titre">
                    <a class="btn btn btn-danger a_color" href="<?php echo $this->webroot; ?>Bonreceptionstocks/index"/> <i class="fa fa-reply"></i> Retour </a>
                    <strong><?php echo __('Modification Bonreceptionstock'); ?></strong>
                </h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Bonreceptionstock', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('page', array('type' => 'hidden', 'id' => 'page', 'value' => 'bonreceptionstock', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('numero', array('div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('depot_id', array('label' => 'Depot ', 'div' => 'form-group', 'id' => 'depot_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select inputspcial', 'empty' => 'Veuillez Choisir !!'));
                    ?></div><div class="col-md-6"><?php
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' => date("d/m/Y", strtotime(str_replace('/', '-', $this->request->data['Bonreceptionstock']['date']))), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('remarque', array('rows' => 3, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?>
                </div>    
                <!-- Autre ligne commande-->
                <div class="row ligne" >


                    <div class="panel-body" >
                        <table class="table table-bordered table-striped table-bottomless tablejdid scrollh" id="addtable" style="width:100%" align="center" >
                            <thead>
                                <tr class="entetetab" style="background-color: #c6b9b9;">
                                    <td align="center" nowrap="nowrap" width="40%">Article</td>
                                    <td align="center" nowrap="nowrap" width="45%">Designation</td>
                                    <td align="center" nowrap="nowrap" width="13%"> Quantité </td>
                                    <td align="center" width="2%">
                                        <a class="btn btn-danger" onclick="ajouter_ligne_livraison1('addtable', 'index', 'tr')" table='addtable' index='index'  tr="tr" style="
                                           padding: 0px 6px;
                                           "><i class="fa fa-plus-circle"  ></i> </a>
                                    </td>
                                </tr>
                            </thead>
                            <?php $tablesemi = 'Lignebonreceptionstock'; ?>
                            <input id="lachaine" type="hidden" value="depot_id,code,designation,quantite" >
                            <input id="interfacetransfert" type="hidden" value="transfert" >
                            <tbody>
                                <tr class="tr" style="display:none;" >

                                    <td style="width:40%" champ="tdarticle" id="">
                                        <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignebonreceptionstock','index'=>'','id'=>'','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'qtestock','empty'=>'Veuillez Choisir !!') );?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php
                                            echo $this->Form->input('article_id', array('div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                                            echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                            ?>
                                            <?php echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control codeselect', 'type' => 'text'));
                                            ?><div id="res" champ="rescode" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>

                                        </div>
                                    </td>
                                    <td style="width:45%" id="" index="" champ="tddesg">
                                        <div class="" style="display:inline; position: relative;">
                                            <?php echo $this->Form->input('designation', array('div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text'));
                                            ?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                        </div>
                                    </td>
                                    <td style="width:13%">
                                        <?php echo $this->Form->input('sup', array('name' => '', 'id' => '', 'champ' => 'sup', 'table' => 'Lignebonreceptionstock', 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                        <?php echo $this->Form->input('quantite', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignebonreceptionstock', 'index' => '', 'id' => '', 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                    </td> 
                                    <td align="center" style="width:2%"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>

                                <?php
//                                                                                            debug($lignebonreceptionstocks);die;
                                foreach ($lignebonreceptionstocks as $i => $af) {
                                    $objArticle = ClassRegistry::init('Article');
                                    $article = $objArticle->find('first', array('conditions' => array('Article.id' => $af['Lignebonreceptionstock']['article_id']), 'recursive' => -1));
                                    ?>
                                    <tr class="cc<?php echo $i; ?>" >


                                        <td style="width:40%" champ="tdarticle" id="tdarticle0" >
                                            <?php //echo $this->Form->input('article_id',array('value'=>$af['Lignebonreceptionstock']['article_id'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignebonreceptionstock]['.$i.'][article_id]','table'=>'Lignebonreceptionstock','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select qtestock ','empty'=>'Veuillez Choisir !!') ); ?>
                                            <div class="" style="display:inline; position: relative;">
                                                <?php
                                                echo $this->Form->input('article_id', array('div' => 'form-group', 'value' => $article['Article']['id'], 'name' => 'data[' . $tablesemi . '][' . $i . '][article_id]', 'table' => $tablesemi, 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                                                echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'value' => $article['Article']['code'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                                ?>
                                                <?php echo $this->Form->input('code', array('value' => $article['Article']['code'], 'div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control codeselect', 'type' => 'text'));
                                                ?><div id="res" champ="rescode" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>

                                            </div>
                                        </td>
                                        <td style="width:45%" id="tddesg<?php echo $i; ?>" index="<?php echo $i; ?>" champ="tddesg">
                                            <div class="" style="display:inline; position: relative;">
                                                <?php echo $this->Form->input('designation', array('value' => $article['Article']['name'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][designation]', 'table' => $tablesemi, 'index' => $i, 'id' => 'designation' . $i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                                <div id="res<?php echo $i; ?>" champ="res" index="<?php echo $i; ?>"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                            </div>
                                        </td>
                                        <td style="width:13%">
                                            <?php echo $this->Form->input('sup', array('name' => 'data[Lignebonreceptionstock][' . $i . '][sup]', 'id' => 'sup' . $i, 'champ' => 'sup', 'table' => 'Lignebonreceptionstock', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                            <?php echo $this->Form->input('quantite', array('value' => $af['Lignebonreceptionstock']['quantite'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignebonreceptionstock][' . $i . '][quantite]', 'table' => 'Lignebonreceptionstock', 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                        </td>
                                        <td align="center" style="width:2%"><i index="<?php echo $i ?> "  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                        <input type="hidden" value="<?php echo $i ?>" id="index" />




                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button type="submit" class="btn btn-primary btnEnregistrerStk">Enregistrer</button>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>


