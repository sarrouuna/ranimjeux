
<br>
<?php
$p = CakeSession::read('depot');
if ($p == 0) {
    //$numspecial="";
    //$mm="";
}
?>
<div class="row"  height="100%">
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading not_padinng">
                <h3 class="panel-title taille_titre">
                    <a class="btn btn btn-danger a_color" href="<?php echo $this->webroot; ?>Factureclients/index"/> <i class="fa fa-reply"></i> Retour </a>
                    <strong><?php echo __('Ajout Facture Avoir'); ?></strong>
                </h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Factureavoir', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                  
                    <?php
                    if ($p == 0) {
                        echo $this->Form->input('pointdevente_id', array('type' => 'hidden', 'value' => @$poinvente, 'id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                        echo $this->Form->input('pointdeventename', array('readonly', 'value' => $pointdeventes[@$poinvente], 'id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control numspecial inputspcial'));
                    }
                    echo $this->Form->input('action', array('id' => 'action', 'type' => 'hidden', 'value' => 'add', 'div' => 'form-group', 'type' => 'hidden', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('depot_id', array('value' => @$dep, 'type' => 'hidden', 'label' => 'Depot ', 'div' => 'form-group', 'id' => 'depot_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control '));
                    echo $this->Form->input('depotname', array('readonly', 'value' => $depots[@$dep], 'label' => 'Depot ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('client_id', array('type' => 'hidden', 'id' => 'client_id', 'value' => $Factureclient[0]['Factureclient']['client_id'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('clientname', array('label' => 'Client', 'readonly', 'value' => $clients[$Factureclient[0]['Factureclient']['client_id']], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('numeroconca', array('id' => 'numeroconca', 'type' => 'hidden', 'value' => @$mm, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('model', array('id' => 'model', 'type' => 'hidden', 'value' => 'Factureavoir', 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    //  echo $this->Form->input('typefacture_id',array('value'=>1,'label'=>'Type facture','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'typefacture_id','class'=>'form-control select typefacture','empty'=>'Veuillez Choisir !!') );
                    ?></div><div class="col-md-6"><?php
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' => date("d/m/Y"), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly inputspcial'));
                    echo $this->Form->input('numero', array('id' => 'numero', 'value' => @$numspecial, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('factureclient_id', array('value' => $Factureclient[0]['Factureclient']['id'], 'type' => 'hidden', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'factureclient_id', 'class' => 'form-control'));
                    echo $this->Form->input('vente', array('id' => 'Vente', 'value' => $Factureclient[0]['Factureclient']['vente'], 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    ?>
                </div>  


                <!-- Autre ligne facture avoir-->
                <div class="row ligne favr"  style="width:100%">
                    <div class="clear"></div>  

                    <table  class="table table-bordered table-striped table-bottomless  " id="addtable" style="width:100%" align="center" >
                        <thead>
                            <tr  class="entetetab" style="background-color: #c6b9b9;">
                                <td align="center" nowrap="nowrap" width="1%" ></td>
                                <td align="center" nowrap="nowrap" width="31%">Article</td>
                                <td align="center" nowrap="nowrap" width="6%">Facture</td>
                                <td align="center" nowrap="nowrap" width="6%"> Qte </td>
                                <td align="center" nowrap="nowrap" width="10%">PUHT</td>    
                                <td align="center" nowrap="nowrap" width="6%">Rem</td>
                                <td align="center" nowrap="nowrap" width="9%">PNHT</td>
                                <td align="center" nowrap="nowrap" width="9%">PUTTC</td> 
                                <td align="center" nowrap="nowrap" width="9%">HT</td>
                                <td align="center" nowrap="nowrap" width="4%">TVA</td>
                                <td align="center" nowrap="nowrap" width="9%">TTC</td>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lignefactureclients as $i => $l) {  //debug($l);die;   ?>

                                <tr class="cc" >
                                    <td id="tdaff<?php echo $i; ?>" style="width:1%">
                                        <span title="Ancien prix"> <a  onclick="recap_rapport(<?php echo $i; ?>)" href="#reModal_refuser" champ="order" id="order<?php echo $i; ?>" value="<?php echo $i; ?>" <button class='  '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                    <td style="width:31%">
                                        <?php //echo $this->Form->input('article_id',array('value'=>$l['Article']['id'],'label'=>'','div'=>'form-group', 'name' => 'data[Lignefactureclient]['.$i.'][article_id]','table'=>'Lignefactureclient','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select  ','empty'=>'Veuillez Choisir !!') );    ?>
                                        <input id="article_id<?php echo $i; ?>" name="data[Lignefactureclient][<?php echo $i; ?>][article_id]" value="<?php echo $l['Article']['id']; ?>" type="hidden">
                                        <input name="data[Lignefactureclient][<?php echo $i; ?>][designation]"  value="<?php echo $l['Article']['name']; ?>" class="form-control" readonly="readonly">
                                    </td>                                
                                    <td style="width:6%">
                                        <?php echo $this->Form->input('id', array('value' => $l['Lignefactureclient']['id'], 'name' => 'data[Lignefactureclient][' . $i . '][id]', 'id' => 'id' . $i, 'champ' => 'id', 'table' => 'Lignefactureclient', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                        <?php echo $this->Form->input('sup', array('name' => 'data[Lignefactureclient][' . $i . '][sup]', 'id' => 'sup' . $i, 'champ' => 'sup', 'table' => 'Lignefactureclient', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                        <?php echo $this->Form->input('quantite', array('value' => $l['Lignefactureclient']['quantite'], 'label' => '', 'div' => 'form-group', 'readonly' => 'readonly', 'table' => 'Lignefactureclient', 'index' => $i, 'id' => 'quantitevendu' . $i, 'champ' => 'quantitevendu', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control   calculefacture')); ?>
                                    </td>
                                    <td style="width:6%">
                                        <?php echo $this->Form->input('quantite', array('value' => 0, 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignefactureclient][' . $i . '][quantite]', 'table' => 'Lignefactureclient', 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqtefactureavoir  calculefacture')); ?>
                                    </td>
                                    <td style="width:10%">
                                        <?php echo $this->Form->input('prixachat', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => '', 'index' => '0', 'id' => 'prixachat0', 'champ' => 'prixachat', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                        <?php echo $this->Form->input('prix', array('readonly', 'value' => $l['Lignefactureclient']['prix'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignefactureclient][' . $i . '][prixhtva]', 'table' => 'Lignefactureclient', 'index' => $i, 'id' => 'prixhtva' . $i, 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeinverseputtc')); ?>
                                    </td>
                                    <td style="width:6%">
                                        <?php echo $this->Form->input('remise', array('readonly', 'value' => $l['Lignefactureclient']['remise'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignefactureclient][' . $i . '][remise]', 'table' => 'Lignefactureclient', 'index' => $i, 'id' => 'remise' . $i, 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacture')); ?>
                                    </td>
                                    <td style="width:9%">
                                        <?php echo $this->Form->input('prixnet', array('readonly', 'value' => @$l['Lignefactureclient']['prixnet'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignefactureclient][' . $i . '][prixnet]', 'table' => 'Lignefactureclient', 'index' => $i, 'id' => 'prixnet' . $i, 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeremisenet')); ?>
                                    </td>
                                    <td style="width:9%">
                                        <?php
                                        echo $this->Form->input('puttc', array('readonly', 'value' => @$l['Lignefactureclient']['puttc'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignefactureclient][' . $i . '][puttc]', 'table' => 'Lignefactureclient', 'index' => $i, 'id' => 'puttc' . $i, 'champ' => 'puttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeprixvente'));
                                        echo $this->Form->input('totalhtans', array('value' => @$l['Lignefactureclient']['prix'], 'type' => 'hidden', 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[Lignefactureclient][' . $i . '][totalhtans]', 'table' => 'Lignefactureclient', 'index' => $i, 'id' => 'totalhtans' . $i, 'champ' => 'totalhtans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                        ?>
                                    </td>
                                    <td style="width:9%">
                                        <?php echo $this->Form->input('totalht', array('value' => 0.000, 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[Lignefactureclient][' . $i . '][totalht]', 'table' => 'Lignefactureclient', 'index' => '0', 'id' => 'totalht0', 'champ' => 'totalht', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                    </td>
                                    <td style="width:4%">
                                        <?php echo $this->Form->input('tva', array('readonly', 'value' => $l['Lignefactureclient']['tva'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignefactureclient][' . $i . '][tva]', 'table' => 'Lignefactureclient', 'index' => $i, 'id' => 'tva' . $i, 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacture')); ?>
                                    </td>
                                    <td style="width:9%">
                                        <?php echo $this->Form->input('totalttc', array('value' => 0.000, 'readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[Lignefactureclient][' . $i . '][totalttc]', 'table' => 'Lignefactureclient', 'index' => $i, 'id' => 'totalttc' . $i, 'champ' => 'totalttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                        <?php echo $this->Form->input('depotcomposee', array('name' => 'data[Lignefactureclient][' . $i . '][depotcomposee]', 'value' => $l['Lignefactureclient']['depotcomposee'], 'id' => 'depotcomposee' . $i, 'champ' => 'depotcomposee', 'table' => 'Lignefactureclient', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                        <?php echo $this->Form->input('type', array('name' => 'data[Lignefactureclient][' . $i . '][type]', 'value' => $l['Lignefactureclient']['composee'], 'id' => 'type' . $i, 'champ' => 'type', 'table' => 'Lignefactureclient', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                        <?php
                                        echo $this->Form->input('prixachatmarge', array('value' => $l['Lignefactureclient']['prixachatmarge'], 'name' => 'data[Lignefactureclient][' . $i . '][prixachatmarge]', 'div' => 'form-group', 'label' => '', 'table' => 'Lignefactureclient', 'index' => $i, 'id' => 'prixachatmarge' . $i, 'champ' => 'prixachatmarge', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                        echo $this->Form->input('margebase', array('type' => 'hidden', 'div' => 'form-group', 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => $l['Lignefactureclient']['margebase'], 'name' => 'data[Lignefactureclient][' . $i . '][margebase]', 'label' => '', 'table' => 'Lignefactureclient', 'index' => $i, 'id' => 'margebase' . $i, 'champ' => 'margebase', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control changerprix calculefacture'));
                                        ?>
                                        <?php echo $this->Form->input('pmp', array('type' => 'hidden', 'value' => @$l['Lignefactureclient']['pmp'], 'type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignefactureclient][' . $i . '][pmp]', 'table' => 'Lignefactureclient', 'index' => $i, 'id' => 'pmp' . $i, 'champ' => 'pmp', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control changerprix'));
                                        ?>
                                    </td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <input type="hidden" value="<?php echo $i; ?>" id="index" />
                    <?php // debug($i);die;      ?>

                </div> 
                <div class="col-md-3">
                    <?php echo $this->Form->input('retenue', array('value' => @$lignefactureclients[0]['Factureclient']['retenue'], 'type' => 'hidden', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'retenue', 'class' => 'form-control inputspcial'));
                    ?>
                    <div class="form-group">
                        <label for="ttretenue" class="col-md-2 control-label">Retenue :<span id="retenuespan"><?php echo @$lignefactureclients[0]['Factureclient']['retenue'] . '%'; ?></span></label>
                        <div class="col-sm-10">
                            <input name="data[Factureavoir][ttretenue]" value=""  readonly="readonly" id="ttretenue" class="form-control inputspcial" type="text">
                        </div>
                    </div>
                    <?php echo $this->Form->input('fodec', array('value' => @$lignefactureclients[0]['Factureclient']['fodec'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'fodec', 'class' => 'form-control inputspcial'));
                    ?>
                    <div class="form-group">
                        <label for="ttfodec" class="col-md-2 control-label">Fodec :<span id="fodecspan"><?php echo @$lignefactureclients[0]['Factureclient']['fodec'] . '%'; ?></span></label>
                        <div class="col-sm-10">
                            <input name="data[Factureavoir][ttfodec]" value=""  readonly="readonly" id="ttfodec" class="form-control inputspcial" type="text">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">                  
                    <?php
                    echo $this->Form->input('remise', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'remise', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('tva', array('label' => 'TVA', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'tva', 'class' => 'form-control inputspcial'));
                    // echo $this->Form->input('timbre_id',array('div'=>'form-group','value'=>$timbre,'between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','id'=>'timbre','champ'=>'timbre','class'=>'form-control calculefacture') );
                    ?>

                </div>

                <div class="col-md-3"><?php
                    echo $this->Form->input('totalht', array('label' => 'Total HT', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_HT', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('totalttc', array('label' => 'Total TTC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control inputspcial'));
                    ?>

                </div>            
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-primary   testpv testmontantavoirfac">Enregistrer</button>
                        </div>
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