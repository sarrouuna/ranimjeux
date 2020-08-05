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
                    <?php echo $this->Form->input('dateinv', array('label' => 'Date', 'value' => date("d/m/Y"), 'div' => 'form-group', 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly'));
                    ?>
                    <div class="col-dm-6" style="display:inline; position: relative;">
                        <?php echo $this->Form->input('designation', array('div' => 'form-group', 'placeholder' => 'Designation', 'label' => 'Article', 'index' => '0', 'id' => 'designation0', 'champ' => 'designation', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                        <div class="form-group" style="display:inline; position: relative;bottom: 24px !important;left: 11px;">
                            <label></label>
                            <div id="res0" champ="res" index="0"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                        </div>
                    </div>
                    <?php
                    echo $this->Form->input('article_id', array('div' => 'form-group', 'index' => '0', 'id' => 'article_id0', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));

//                    echo $this->Form->input('article_id', array('id' => 'depot_id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
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
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                    <thead>
                                        <tr>
                                            <td align="center" nowrap="nowrap" width="70%">Depot</td>
                                            <td align="center" nowrap="nowrap" width="28%">Quantité</td>
                                            <td align="center" width="2%"></td>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php
                                        foreach ($depot_touts as $i => $af) {
                                            ?> 
                                            <tr>
                                                <td style="width:70%">
                                                    <?php echo $this->Form->input('sup', array('name' => 'data[Ligneinventaire][' . $i . '][sup]', 'id' => 'sup' . $i, 'champ' => 'sup', 'table' => 'Ligneinventaire', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control ', 'label' => 'Nom')); ?>
                                                    <?php echo $this->Form->input('depot_id', array('value' => $af['Depot']['id'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Ligneinventaire][' . $i . '][depot_id]', 'table' => 'Ligneinventaire', 'index' => $i, 'id' => 'depot_id' . $i, 'champ' => 'depot_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control select ', 'empty' => 'Veuillez choisir !!')); ?>
                                                </td>
                                                <td style="width:28%">
                                                    <?php echo $this->Form->input('quantite', array('label' => '', 'div' => 'form-group', 'name' => 'data[Ligneinventaire][' . $i . '][quantite]', 'table' => 'Ligneinventaire', 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                </td>
                                                <td align="center" style="width:2%"><i index="<?php echo $i; ?>"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                            </tr>
                                        <?php } ?> 
                                    </tbody>
                                </table>
                                <input type="hidden" value="0" id="index" />
                            </div>

                        </div>
                    </div>                
                </div> 


                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary testdateexpiration">Enregistrer</button>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

