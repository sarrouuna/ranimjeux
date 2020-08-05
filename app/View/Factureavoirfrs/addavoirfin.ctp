<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Factureavoirs/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<?php
$p = CakeSession::read('depot');
if ($p == 0) {
    $numspecial = "";
}
?>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Ajout Facture à voir'); ?></h3>
            </div>
            <div class="panel-body">
<?php echo $this->Form->create('Factureavoir', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                  
                    <?php
                    if ($p == 0) {
                        echo $this->Form->input('pointdevente_id', array('id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select numspecial'));
                    }
                    echo $this->Form->input('client_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'client_id', 'class' => 'form-control select getfactures', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' => date("d/m/Y"), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly'));
                    ?>
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Factures'); ?></label>	
                        <div class='col-sm-10' champ="divfacture" id="divfacture" >     </div>
                    </div>                
                </div>  
                <!-- Autre ligne facture avoir-->
                <div class="col-md-6" ><?php
                    $timbre = "";
                    echo $this->Form->input('numero', array('id' => 'numero', 'value' => $numspecial, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('numeroconca', array('id' => 'numeroconca', 'type' => 'hidden', 'value' => $mm, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('model', array('id' => 'model', 'type' => 'hidden', 'value' => 'Factureavoir', 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('timbre_id', array('div' => 'form-group', 'value' => $timbre, 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'timbre', 'champ' => 'timbre', 'class' => 'form-control'));
                    echo $this->Form->input('totalttc', array('label' => 'Total TTC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control'));
                    ?>
                </div>       
                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
</div>

