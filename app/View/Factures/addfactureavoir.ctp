
<br>
<?php
$p = CakeSession::read('depot');
if ($p == 0) {
    //$numspecial="";
    //$mm="";
}
?>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading not_padinng">
                <h3 class="panel-title taille_titre">
                    <a class="btn btn btn-danger a_color" href="<?php echo $this->webroot; ?>Factures/index"/> <i class="fa fa-reply"></i> Retour </a>
                    <strong><?php echo __('Ajout Facture Avoir'); ?></strong>
                </h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Factureavoirfr', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>
                <div class="col-md-6">                  
                    <?php
//                    debug($facture[0]['facture']['fournisseur_id']);die;
                    if ($p == 0) {
                        echo $this->Form->input('pointdevente_id', array('type' => 'hidden', 'value' => @$poinvente, 'id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                        echo $this->Form->input('pointdeventename', array('readonly', 'value' => $pointdeventes[@$poinvente], 'id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control numspecial inputspcial'));
                    }
                    echo $this->Form->input('action', array('id' => 'action', 'type' => 'hidden', 'value' => 'add', 'div' => 'form-group', 'type' => 'hidden', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('facture_id', array('value' => @$idfc, 'type' => 'hidden', 'div' => 'form-group', 'id' => 'facture_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control '));
                    echo $this->Form->input('depot_id', array('value' => @$dep, 'type' => 'hidden', 'label' => 'Depot ', 'div' => 'form-group', 'id' => 'depot_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control '));
                    echo $this->Form->input('depotname', array('readonly', 'value' => $depots[@$dep], 'label' => 'Depot ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('fournisseur_id', array('type' => 'hidden', 'id' => 'fournisseur_id', 'value' => $facture[0]['Facture']['fournisseur_id'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('fournisseurname', array('label' => 'Fournisseur', 'readonly', 'value' => $fournisseurs[$facture[0]['Facture']['fournisseur_id']], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('numeroconca', array('id' => 'numeroconca', 'type' => 'hidden', 'value' => @$mm, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('model', array('id' => 'model', 'type' => 'hidden', 'value' => 'Factureavoirfr', 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    //  echo $this->Form->input('typefacture_id',array('value'=>1,'label'=>'Type facture','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'typefacture_id','class'=>'form-control select typefacture','empty'=>'Veuillez Choisir !!') );
                    ?></div><div class="col-md-6"><?php
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' => date("d/m/Y"), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly inputspcial'));
                    echo $this->Form->input('numero', array('label' => 'Numéro Interne', 'id' => 'numero', 'value' => @$numspecial, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('numerofrs', array('label' => 'Numéro', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    ?>
                </div>  
                <!-- Autre ligne facture avoir-->
                <div class="row ligne favr"  style="width:100%">
                    <div class="clear"></div>  
                    <table  class="table table-bordered table-striped table-bottomless tablejdid " id="addtable" style="width:100%" align="center" >
                        <thead>
                            <tr  class="entetetab" style="background-color: #c6b9b9;">
                                <td align="center" nowrap="nowrap" width="31%">Article</td>
                                <td align="center" nowrap="nowrap" width="6%">Facture</td>
                                <td align="center" nowrap="nowrap" width="6%"> Qte </td>
                                <td align="center" nowrap="nowrap" width="10%">PUHT</td>    
                                <td align="center" nowrap="nowrap" width="6%">Rem</td>
                                <td align="center" nowrap="nowrap" width="9%">PNHT</td>
                                <td align="center" nowrap="nowrap" width="9%">PUTTC</td> 
                                <td align="center" nowrap="nowrap" width="9%">HT</td>
                                <td align="center" nowrap="nowrap" width="3%">Fodec</td>
                                <td align="center" nowrap="nowrap" width="5%">TVA</td>
                                <td align="center" nowrap="nowrap" width="9%">TTC</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php // debug($lignefactures);die;   ?>
                            <?php
                            foreach ($lignefactures as $i => $l) {
                                //debug($l); 
                                ?>
                                <tr class="cc" >
                                    <td style="width:31%">
                                        <?php //echo $this->Form->input('article_id',array('value'=>$l['Article']['id'],'label'=>'','div'=>'form-group', 'name' => 'data[Lignefacture]['.$i.'][article_id]','table'=>'Lignefacture','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select  ','empty'=>'Veuillez Choisir !!') );       ?>
                                        <input id="article_id<?php echo $i; ?>" name="data[Lignefacture][<?php echo $i; ?>][article_id]" value="<?php echo $l['Article']['id']; ?>" type="hidden">
                                        <input   value="<?php echo $l['Article']['name']; ?>" class="form-control" readonly="readonly">
                                    </td>                                
                                    <td style="width:6%">
                                        <?php echo $this->Form->input('id', array('value' => $l['Lignefacture']['id'], 'name' => 'data[Lignefacture][' . $i . '][id]', 'id' => 'id' . $i, 'champ' => 'id', 'table' => 'Lignefacture', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                        <?php echo $this->Form->input('sup', array('name' => 'data[Lignefacture][' . $i . '][sup]', 'id' => 'sup' . $i, 'champ' => 'sup', 'table' => 'Lignefacture', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                        <?php echo $this->Form->input('quantite', array('value' => $l['Lignefacture']['quantite'] - @$l['Lignefacture']['qtebonus'], 'label' => '', 'div' => 'form-group', 'readonly' => 'readonly', 'table' => 'Lignefacture', 'index' => $i, 'id' => 'quantitett' . $i, 'champ' => 'quantitett', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control   calculefacture')); ?>
                                    </td>
                                    <td style="width:6%">
                                        <?php echo $this->Form->input('quantite', array('value' => 0, 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignefacture][' . $i . '][quantite]', 'table' => 'Lignefacture', 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testfavr  calculfactureamine')); ?>
                                    </td>
                                    <td style="width:10%">
                                        <?php echo $this->Form->input('prix', array('readonly', 'value' => $l['Lignefacture']['prix'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignefacture][' . $i . '][prix]', 'table' => 'Lignefacture', 'index' => $i, 'id' => 'prixhtva' . $i, 'champ' => 'prixhtva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeinverseputtc')); ?>
                                    </td>
                                    <td style="width:6%">
                                        <?php echo $this->Form->input('remise', array('readonly', 'value' => $l['Lignefacture']['remise'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignefacture][' . $i . '][remise]', 'table' => 'Lignefacture', 'index' => $i, 'id' => 'remise' . $i, 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacture')); ?>
                                    </td>
                                    <td style="width:9%">
                                        <?php echo $this->Form->input('prixnet', array('readonly', 'value' => @$l['Lignefacture']['prixnet'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignefacture][' . $i . '][prixnet]', 'table' => 'Lignefacture', 'index' => $i, 'id' => 'prixnet' . $i, 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeremisenet')); ?>
                                    </td>
                                    <td style="width:9%">
                                        <?php
                                        echo $this->Form->input('puttc', array('readonly', 'value' => @$l['Lignefacture']['puttc'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignefacture][' . $i . '][puttc]', 'table' => 'Lignefacture', 'index' => $i, 'id' => 'puttc' . $i, 'champ' => 'puttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeprixvente'));
                                        echo $this->Form->input('totalhtans', array('value' => @$l['Lignefacture']['prix'], 'type' => 'hidden', 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[Lignefacture][' . $i . '][totalhtans]', 'table' => 'Lignefacture', 'index' => $i, 'id' => 'totalhtans' . $i, 'champ' => 'totalhtans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                        ?>
                                    </td>
                                    <td style="width:9%">
                                        <?php echo $this->Form->input('totalht', array('value' => $l['Lignefacture']['totalht'], 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[Lignefacture][' . $i . '][totalht]', 'table' => 'Lignefacture', 'index' => $i, 'id' => 'totalht' . $i, 'champ' => 'totalht', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                    </td>
                                    <td width="3%">
                                        <?php echo $this->Form->input('fodec', array('value' => $l['Lignefacture']['fodec'], 'readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignefacture][' . $i . '][fodec]', 'table' => 'Lignefacture', 'index' => $i, 'id' => 'fodec' . $i, 'champ' => 'fodec', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                    </td>
                                    <td style="width:5%">
                                        <?php echo $this->Form->input('tva', array('readonly', 'value' => $l['Lignefacture']['tva'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignefacture][' . $i . '][tva]', 'table' => 'Lignefacture', 'index' => $i, 'id' => 'tva' . $i, 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacture')); ?>
                                    </td>
                                    <td style="width:9%">
                                        <?php echo $this->Form->input('totalttc', array('readonly' => 'readonly', 'value' => $l['Lignefacture']['totalttc'], 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[Lignefacture][' . $i . '][totalttc]', 'table' => 'Lignefacture', 'index' => $i, 'id' => 'totalttc' . $i, 'champ' => 'totalttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                    </td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <input type="hidden" value="<?php echo $i; ?>" id="index" />
                    <?php // debug($i);die;       ?>
                </div> 

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('remise', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'remise', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('tva', array('label' => 'TVA', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'tva', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('timbre_id', array('div' => 'form-group','between' => '<div class="col-sm-10">', 'type' => 'text','after' => '</div>', 'id' => 'timbre', 'champ' => 'timbre', 'class' => 'form-control inputspcial calculefacture'));
                    ?>

                </div>

                <div class="col-md-6"><?php
                    echo $this->Form->input('totalht', array('label' => 'Total HT', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_HT', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('totalttc', array('label' => 'Total TTC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control inputspcial'));
                    ?>
                </div>   
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
                                                <?php echo $this->Form->input('facture_id', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Imputationfacture', 'index' => '', 'id' => '', 'champ' => 'factureclient_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testdoublefacture_et_getreste ', 'empty' => 'Veuillez Choisir !!')); ?>
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
                        <button type="submit" class="btn btn-primary testpv testmontanttotaleimputationfr">Enregistrer</button>
                    </div>
                </div>


                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
</div>

<div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
    <div id="pop">
    </div>
    <br>
    <a  class="remodal-confirm ls-light-green-btn btn" ><strong>OK</strong></a>
</div> 