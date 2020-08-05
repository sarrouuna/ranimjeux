<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Factureavoirfrs/index"/> <i class="fa fa-reply"></i> Retour </a>
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
                <?php echo $this->Form->create('Factureavoirfr', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>
                <div class="col-md-6">                  
                    <?php
                    if ($p == 0) {
                        echo $this->Form->input('pointdevente_id', array('id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select numspecial'));
                    }
                    echo $this->Form->input('fournisseur_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'fournisseur_id', 'class' => 'form-control select ', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' => date("d/m/Y"), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?>

                </div>  
                <!-- Autre ligne facture avoir-->

                <div class="col-md-6" ><?php
                    echo $this->Form->input('action', array('id' => 'action', 'type' => 'hidden', 'value' => 'add', 'div' => 'form-group', 'type' => 'hidden', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('numero', array('label' => 'Numéro Interne ', 'id' => 'numero', 'value' => $numspecial, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('numeroconca', array('id' => 'numeroconca', 'type' => 'hidden', 'value' => $mm, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('model', array('id' => 'model', 'type' => 'hidden', 'value' => 'Factureavoirfr', 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('numerofrs', array('label' => 'Numero', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('timbre_id', array('div' => 'form-group','between' => '<div class="col-sm-10">', 'type' => 'text','after' => '</div>', 'id' => 'timbre', 'champ' => 'timbre', 'class' => 'form-control  calculefactureservice'));
                    echo $this->Form->input('totalttc', array('readonly'=>'readonly','label' => 'Total TTC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?>
                </div> 

                <table style="width:70%" align="center" border='2' >
                    <thead>
                        <tr>
                            <td align="center" nowrap="nowrap" width="30%" >M HT</td>
                            <td align="center" nowrap="nowrap" width="10%" >TVA %</td>
                            <td align="center" nowrap="nowrap" width="30%">M TVA</td>
                            <td align="center" nowrap="nowrap" width="30%">M TTC</td>

                        </tr>
                    </thead>
                    <?php $tablesemi = 'Lignefactureavoirfr'; ?>
                    <?php foreach ($tvas as $i => $tva) { ?>
                        <tr>
                            <td width="30%">
                                <?php
                                echo $this->Form->input('mth', array('name' => 'data[' . $tablesemi . '][' . $i . '][totalht]', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'mth' . $i, 'champ' => 'mth', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefactureservice'));
                                ?>
                            </td>
                            <td width="10%">
                                <?php
                                echo $this->Form->input('tauxtva', array('readonly' => 'readonly', 'name' => 'data[' . $tablesemi . '][' . $i . '][tva]', 'div' => 'form-group', 'value' => $tva['Tva']['name'], 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'tauxtva' . $i, 'champ' => 'tauxtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                                ?>
                            </td>
                            <td width="30%">
                                <?php
                                echo $this->Form->input('mtva', array('readonly' => 'readonly', 'name' => 'data[' . $tablesemi . '][' . $i . '][mtva]', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'mtva' . $i, 'champ' => 'mtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                                ?>
                            </td>
                            <td width="30%">
                                <?php
                                echo $this->Form->input('mttc', array('readonly' => 'readonly', 'name' => 'data[' . $tablesemi . '][' . $i . '][totalttc]', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'mttc' . $i, 'champ' => 'mttc', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td width="30%" align='center'>
                            Total HT    
                        </td>
                        <td width="10%">

                        </td>
                        <td width="30%" align='center'>
                            Total TVA    
                        </td>
                        <td width="30%" align='center'>
                            Total TTC    
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">
                            <?php
                            echo $this->Form->input('totalht', array('type' => 'text', 'readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'id' => 'totth', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                            ?>
                        </td>
                        <td width="10%">

                        </td>
                        <td width="30%">
                            <?php
                            echo $this->Form->input('tva', array('type' => 'text', 'readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'id' => 'tottva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                            ?>
                        </td>
                        <td width="30%">
                            <?php
                            echo $this->Form->input('totalttc', array('type' => 'text', 'readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'id' => 'totttc', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                            ?>
                        </td>
                    </tr>
                </table> 
                <input type="hidden" value="<?php echo @$i; ?>" id="index" />
                <div style="height: 30px"></div>
                <div class="row ligne imputationfrs" >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Imputation Facture Avoir'); ?></h3>
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
                                                <?php echo $this->Form->input('facture_id', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Imputationfacture', 'index' => '', 'id' => '', 'champ' => 'factureclient_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testdoublefacturefr_et_getreste ', 'empty' => 'Veuillez Choisir !!')); ?>
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
                        <a class="btn btn-danger ajouterligne_imputationfr" table='addtablec' index='indexc' style="
                           float: lfet; 
                           position: relative;
                           top: -25px;
                           "><i class="fa fa-plus-circle"  ></i> Ajouter facture</a>
                    </div>                
                </div>
                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary testmontanttotaleimputationfr">Enregistrer</button>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
</div>

