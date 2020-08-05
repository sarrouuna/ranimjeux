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
                <h3 class="panel-title"><?php echo __('Ajout Inventaire'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Inventaire', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh', 'enctype' => 'multipart/form-data')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('page', array('type' => 'hidden', 'value' => 'inventaire', 'id' => 'page', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('depot_id', array('id' => 'depot_id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('dateinv', array('label' => 'Date', 'value' => date("d/m/Y"), 'div' => 'form-group', 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly'));
                    ?></div><div class="col-md-6"><?php
                    echo $this->Form->input('numero', array('readonly' => 'readonly', 'div' => 'form-group', 'value' => $mm, 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                </div>  

                <!-- Autre ligne inventaire-->
                <div class="row ligne" >
                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Ligne inventaire'); ?></h3>

                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless tablejdid scrollh" id="addtable" style="width:100%" align="center"  >
                                    <thead>
                                        <tr>
                                            <td align="center" width="1%"></td>
                                            <td align="center" nowrap="nowrap" width="15%">code</td>
                                            <td align="center" nowrap="nowrap" width="47%">Article</td>
                                            <td align="center" nowrap="nowrap" width="15%">Quantité</td>
                                            <td align="center" nowrap="nowrap" width="20%">Cout de revient</td>
                                            <td align="center" width="2%"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="tr" style="display:none;">
                                            <td width="1%">
                                                <span champ="num"></span>
                                            </td>
                                            <td style="width:15%">
                                                <?php echo $this->Form->input('sup', array('name' => '', 'id' => '', 'champ' => 'sup', 'table' => 'Ligneinventaire', 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                                <?php
                                                echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => 'Ligneinventaire', 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control invcode', 'type' => 'text'));
                                                ?>
                                            </td>
                                            <td style="width:47%">
                                                <?php echo $this->Form->input('article_id', array('type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Ligneinventaire', 'index' => '', 'id' => '', 'champ' => 'article_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testligneinv ')); ?>
                                                <?php echo $this->Form->input('designation', array('div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => '', 'table' => 'Ligneinventaire', 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                            </td>
                                            <td style="width:15%">
                                                <?php echo $this->Form->input('quantite', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Ligneinventaire', 'index' => '', 'id' => '', 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testlr')); ?>
                                            </td>
                                            <td style="width:20%">
                                                <?php echo $this->Form->input('coutderevien', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Ligneinventaire', 'index' => '', 'id' => '', 'champ' => 'coutderevien', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                            </td>
                                            <td align="center" style="width:2%"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                        </tr>

                                    </tbody>
                                </table>
                                <input type="hidden" value="0" id="index" />
                            </div>
                            <a class="btn btn-danger ajouterligne_inv" table='addtable' index='index'  tr="tr" style="
                               float: lfet; 
                               position: relative;
                               top: -25px;
                               "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                        </div>
                    </div>                
                </div> 


                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary ">Enregistrer</button>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

