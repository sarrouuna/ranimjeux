
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
            
                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary btnInventaire">Enregistrer</button>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

