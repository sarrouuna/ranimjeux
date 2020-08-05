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
                    echo $this->Form->input('action', array('id' => 'action', 'type' => 'hidden', 'value' => 'add', 'div' => 'form-group', 'type' => 'hidden', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('client_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'client_id', 'class' => 'form-control select', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' => date("d/m/Y"), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly'));
                    ?>

                </div>
                <!-- Autre ligne facture avoir-->
                <div class="col-md-6" ><?php
                    $timbre = "";
                    echo $this->Form->input('numero', array('readonly' => 'readonly', 'id' => 'numero', 'value' => $numspecial, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('numeroconca', array('id' => 'numeroconca', 'type' => 'hidden', 'value' => $mm, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('model', array('id' => 'model', 'type' => 'hidden', 'value' => 'Factureavoir', 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('totalttc', array('label' => 'Total TTC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control'));
                    ?>
                </div>
                <div class="row ligne imputations" >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Imputation Facture Avoir'); ?></h3>
								<a class="btn btn-danger ajouterligne_imputation" table='addtablec' index='indexc' style="
                           float: right;
                           position: relative;
                           top: -25px;
                           "><i class="fa fa-plus-circle"  ></i> Ajouter facture</a>

							</div>

							<div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtablec" style="width:90%" align="center" >
                                    <thead>
                                        <tr>
                                            <td align="center" nowrap="nowrap">Facture</td>
                                            <td align="center" nowrap="nowrap">Reste</td>
                                            <td align="center" nowrap="nowrap">Montant</td>
                                            <td align="center"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="tr" style="display:none;">
                                            <td style="width:50%" champ="tdimp">
                                                <?php echo $this->Form->input('factureclient_id', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Imputationfacture', 'index' => '', 'id' => '', 'champ' => 'factureclient_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testdoublefacture_et_getreste ', 'empty' => 'Veuillez Choisir !!')); ?>
                                            </td>
                                            <td style="width:25%">
                                                <?php echo $this->Form->input('supfac', array('name' => '', 'id' => '', 'champ' => 'supfac', 'table' => 'Imputationfacture', 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                                <?php echo $this->Form->input('reste', array('readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Imputationfacture', 'index' => '', 'id' => '', 'champ' => 'reste', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td style="width:24%">
                                                <?php echo $this->Form->input('montant', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Imputationfacture', 'index' => '', 'id' => '', 'champ' => 'montant', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testmontantimputer')); ?>
                                            </td>

                                            <td align="center" style="width:1%"><i index=""  class="fa fa-times supfac" style="color: #c9302c;font-size: 22px;"></td>
                                        </tr>

                                    </tbody>
                                </table>
                                <input type="hidden" value="0" id="indexc" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-6 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary testmontanttotaleimputation">Enregistrer</button>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
</div>

