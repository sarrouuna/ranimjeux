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
                <h3 class="panel-title"><?php echo __('Modifier Facture avoir'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Factureavoirfr', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>
                <div class="col-md-6">                  
                    <?php
                    if ($p == 0) {
                        echo $this->Form->input('pointdevente_id', array('id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select numspecial'));
                    }
                    echo $this->Form->input('action', array('id' => 'action', 'type' => 'hidden', 'value' => 'edit', 'div' => 'form-group', 'type' => 'hidden', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('id', array('id' => 'id', 'type' => 'hidden', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control ', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('fournisseur_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'fournisseur_id', 'class' => 'form-control select ', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' =>date("d/m/Y", strtotime(str_replace('/', '-', $this->request->data['Factureavoirfr']['date']))), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?>

                </div>  
                <!-- Autre ligne facture avoir-->

                <div class="col-md-6" ><?php
                    echo $this->Form->input('numero', array('readonly' => 'readonly', 'label' => 'Numéro Interne ', 'id' => 'numero', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('numeroconca', array('id' => 'numeroconca', 'type' => 'hidden', 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('model', array('id' => 'model', 'type' => 'hidden', 'value' => 'Factureavoirfr', 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('numerofrs', array('label' => 'Numero', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('timbre_id', array('div' => 'form-group','between' => '<div class="col-sm-10">', 'type' => 'text','after' => '</div>', 'id' => 'timbre', 'champ' => 'timbre', 'class' => 'form-control  calculefactureservice'));
                    echo $this->Form->input('totalttc', array('readonly' => 'readonly', 'label' => 'Total TTC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
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
                    <?php
                    foreach ($tvas as $i => $tva) {
                        $ligne = ClassRegistry::init('Lignefactureavoirfr')->find('first', array('conditions' => array('Lignefactureavoirfr.factureavoirfr_id' => $this->request->data['Factureavoirfr']['id'], 'Lignefactureavoirfr.tva' => $tva['Tva']['name']), 'recursive' => -1));
                        ?>
                        <tr>
                            <td width="30%">
                                <?php
                                echo $this->Form->input('idl', array('type' => 'hidden', 'value' => @$ligne['Lignefactureavoirfr']['id'], 'name' => 'data[' . $tablesemi . '][' . $i . '][id]', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'idl' . $i, 'champ' => 'idl', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                echo $this->Form->input('mth', array('value' => @$ligne['Lignefactureavoirfr']['totalht'], 'name' => 'data[' . $tablesemi . '][' . $i . '][totalht]', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'mth' . $i, 'champ' => 'mth', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefactureservice'));
                                ?>
                            </td>
                            <td width="10%">
                                <?php
                                echo $this->Form->input('tauxtva', array('value' => @$ligne['Lignefactureavoirfr']['tva'], 'readonly' => 'readonly', 'name' => 'data[' . $tablesemi . '][' . $i . '][tva]', 'div' => 'form-group', 'value' => $tva['Tva']['name'], 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'tauxtva' . $i, 'champ' => 'tauxtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                                ?>
                            </td>
                            <td width="30%">
                                <?php
                                echo $this->Form->input('mtva', array('value' => @$ligne['Lignefactureavoirfr']['totalttc'] - @$ligne['Lignefactureavoirfr']['totalht'], 'readonly' => 'readonly', 'name' => 'data[' . $tablesemi . '][' . $i . '][mtva]', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'mtva' . $i, 'champ' => 'mtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                                ?>
                            </td>
                            <td width="30%">
                                <?php
                                echo $this->Form->input('mttc', array('value' => @$ligne['Lignefactureavoirfr']['totalttc'], 'readonly' => 'readonly', 'name' => 'data[' . $tablesemi . '][' . $i . '][totalttc]', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'mttc' . $i, 'champ' => 'mttc', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
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
                                                <?php echo $this->Form->input('facture_id', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Imputationfacture', 'index' => '', 'id' => '', 'champ' => 'facture_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testdoublefacturefr_et_getreste ', 'empty' => 'Veuillez Choisir !!')); ?>
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
                                        <?php
                                        foreach ($imputationfactureavoirs as $k => $imputationfactureavoir) {
//     debug($imputationfactureavoirs);die;
                                            ?>
                                            <tr>
                                                <td style="width:50%">
                                                    <?php echo $this->Form->input('facture_id', array('value' => @$imputationfactureavoir['Imputationfactureavoirfr']['facture_id'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Imputationfacture][' . $k . '][facture_id]', 'table' => 'Imputationfacture', 'index' => $k, 'id' => 'facture_id' . $k, 'champ' => 'facture_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testdoublefacturefr_et_getreste select', 'empty' => 'Veuillez choisir !!')); ?>
                                                </td>
                                                <td style="width:25%">
                                                    <?php echo $this->Form->input('supfac', array('name' => 'data[Imputationfacture][' . $k . '][supfac]', 'id' => 'supfac' . $k, 'champ' => 'supfac', 'table' => 'Imputationfacture', 'index' => $k, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                                    <?php echo $this->Form->input('reste', array('value' => @$imputationfactureavoir['Imputationfactureavoirfr']['reste'], 'readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => 'data[Imputationfacture][' . $k . '][reste]', 'id' => 'reste' . $k, 'table' => 'Imputationfacture', 'index' => $k, 'champ' => 'reste', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                </td>
                                                <td style="width:24%">
                                                    <?php echo $this->Form->input('montant', array('value' => @$imputationfactureavoir['Imputationfactureavoirfr']['montant'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Imputationfacture][' . $k . '][montant]', 'id' => 'montant' . $k, 'table' => 'Imputationfacture', 'index' => $k, 'champ' => 'montant', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testmontantimputer')); ?>
                                                </td>

                                                <td align="center" style="width:1%"><i index="<?php echo @$k; ?>"  class="fa fa-times supfac" style="color: #c9302c;font-size: 22px;"></td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                                <input type="hidden" value="<?php echo @$k; ?>" id="indexc" />
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

