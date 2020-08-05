<script>
    window.onload = function () {
        for (var i = 1; i <= 50; i++) {
            ajouter_ligne_livraison1('addtable', 'index', 'tr');
        }

    };
</script>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Inventaires/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Modification Inventaire'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Inventaire', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                  
                    <?php
//                    debug($this->request->data);die;
                    echo $this->Form->input('id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('depot_id', array('type' => 'hidden', 'id' => 'depot_id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('depotnom', array('readonly', 'value' => $depots[$this->request->data['Inventaire']['depot_id']], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('dateinv', array('label' => 'Date', 'value' => $day, 'div' => 'form-group', 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly'));
                    ?></div><div class="col-md-6"><?php
                    echo $this->Form->input('numero', array('readonly' => 'readonly', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('typeinv', array('label' => 'Type Inventaire','empty'=>'Veuillez choisir','id' => 'type', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                </div>  
                <!-- ajouter ligne-->
                <div class="row ligne" >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Ajout ligne'); ?></h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless tablejdid scrollh" id="addtable" style="width:100%" align="center"  >
                                    <thead>
                                        <tr>
                                            <td align="center" width="6%"></td>
                                            <td align="center" nowrap="nowrap" width="15%">code</td>
                                            <td align="center" nowrap="nowrap" width="47%">Article</td>
                                            <td align="center" nowrap="nowrap" width="15%">Quantité</td>
                                            <td align="center" nowrap="nowrap" width="15%">Cout de revient</td>
                                            <td align="center" width="2%"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="tr" style="display:none;">
                                            <td width="6%">
                                                <span champ="num"></span>
                                            </td>
                                            <td style="width:15%">
                                                <?php echo $this->Form->input('sup', array('name' => '', 'id' => '', 'champ' => 'sup', 'table' => 'Ligneinventaire', 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                                <?php
//                                                echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => 'Ligneinventaire', 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control invcode', 'type' => 'text'));
                                                ?>
                                                <div class="" style="display:inline; position: relative;">
                                                    <?php echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => 'Ligneinventaire', 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control codeselect setQuerycode', 'type' => 'text'));
                                                    ?><div id="res" champ="rescode" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                                </div>
                                            </td>
                                            <td style="width:47%">
                                                <?php echo $this->Form->input('article_id', array('type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Ligneinventaire', 'index' => '', 'id' => '', 'champ' => 'article_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testligneinv ')); ?>
                                                <div class="" style="display:inline; position: relative;">
                                                    <?php echo $this->Form->input('designation', array('div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => '', 'table' => 'Ligneinventaire', 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                                    <div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                                </div>
                                            </td>
                                            <td style="width:15%">
                                                <?php echo $this->Form->input('quantite', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Ligneinventaire', 'index' => '', 'id' => '', 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testlr')); ?>
                                            </td>
                                            <td style="width:15%">
                                                <?php echo $this->Form->input('coutderevien', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Ligneinventaire', 'index' => '', 'id' => '', 'champ' => 'coutderevien', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                            </td>
                                            <td align="center" style="width:2%"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>


                                        </tr>
                                        <?php
                                     //   if($valide==1)
									 {
                                        if (!empty($ligneinvents)) {
                                            foreach ($ligneinvents as $i => $af) {

                                                $i++;
                                                ?> 
                                                <tr>
                                                    <td width="6%">
                                                        <span champ="num" id="num<?php echo $i; ?>" index="<?php echo $i; ?>"><?php echo $i; ?></span>
                                                    </td>
                                                    <td style="width:15%">
                                                        <?php echo $this->Form->input('id', array('value' => $af['Ligneinventaire']['id'], 'name' => 'data[Ligneinventaire][' . $i . '][id]', 'id' => 'id' . $i, 'champ' => 'id', 'table' => 'Ligneinventaire', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                                        <?php echo $this->Form->input('sup', array('name' => 'data[Ligneinventaire][' . $i . '][sup]', 'id' => 'sup' . $i, 'champ' => 'sup', 'table' => 'Ligneinventaire', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control ', 'label' => 'Nom')); ?>
                                                        <?php // echo $this->Form->input('code', array('value' => $af['Ligneinventaire']['code'], 'div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => 'data[Ligneinventaire][' . $i . '][code]', 'table' => 'Ligneinventaire', 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control invcode', 'type' => 'text')); ?>
                                                        <div class="" style="display:inline; position: relative;">
                                                            <?php echo $this->Form->input('code', array('value' => $af['Ligneinventaire']['code'], 'div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => 'data[Ligneinventaire][' . $i . '][code]', 'table' => 'Ligneinventaire', 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control codeselect setQuerycode', 'type' => 'text'));
                                                            ?><div id="res" champ="rescode" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                                        </div>


                                                    </td>
                                                    <td style="width:47%">
                                                        <?php echo $this->Form->input('article_id', array('value' => $af['Ligneinventaire']['article_id'], 'type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => 'data[Ligneinventaire][' . $i . '][article_id]', 'table' => 'Ligneinventaire', 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testligneinv editligneinvarticle')); ?>
                                                        <div class="" style="display:inline; position: relative;">
                                                            <?php echo $this->Form->input('designation', array('value' => $af['Ligneinventaire']['designation'], 'div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => 'data[Ligneinventaire][' . $i . '][designation]', 'table' => 'Ligneinventaire', 'index' => $i, 'id' => 'designation' . $i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                                            <div id="res<?php echo $i; ?>" champ="res" index="<?php echo $i; ?>"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                                        </div>
                                                    </td>
                                                    <td style="width:15%">
                                                        <?php echo $this->Form->input('quantite', array('value' => $af['Ligneinventaire']['quantite'], 'label' => '', 'div' => 'form-group', 'name' => 'data[Ligneinventaire][' . $i . '][quantite]', 'table' => 'Ligneinventaire', 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                    </td>
                                                    <td style="width:15%">
                                                        <?php echo $this->Form->input('coutderevien', array('value' => $af['Ligneinventaire']['coutderevien'], 'name' => 'data[Ligneinventaire][' . $i . '][coutderevien]', 'id' => 'coutderevien' . $i, 'table' => 'Ligneinventaire', 'index' => $i, 'champ' => 'coutderevien', 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'type' => 'text', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                    </td>

                                                    <td align="center" style="width:2%"><i index="<?php echo $i; ?>"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>

                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            $i = 0;
                                        }}
                                        ?> 
                                    </tbody>
                                </table>
                                <input type="hidden" value="<?php echo @$i; ?>"   id="index" />
                            </div>
                            <a class="btn btn-danger ajouterligne_inv" table='addtable' index='index' tr="tr" style="
                               float: lfet; 
                               position: relative;
                               top: -25px;
                               "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                        </div>
                    </div>                
                </div>             



                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary btnEditInventaire  <?php if ($valide == 1) { ?>testligneinventaire testdateexpiration<?php } ?> " >Enregistrer</button>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

