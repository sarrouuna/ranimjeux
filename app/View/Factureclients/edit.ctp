<script>
    window.onload = function () {
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
        ajouter_ligne_livraison1('addtable', 'index', 'tr');
    };

</script>
<script language="JavaScript">

    function flvFPW1() {

        var v1 = arguments, v2 = v1[2].split(","), v3 = (v1.length > 3) ? v1[3] : false, v4 = (v1.length > 4) ? parseInt(v1[4]) : 0, v5 = (v1.length > 5) ? parseInt(v1[5]) : 0, v6, v7 = 0, v8, v9, v10, v11, v12, v13, v14, v15, v16;
        v11 = new Array("width,left," + v4, "height,top," + v5);
        for (i = 0; i < v11.length; i++) {
            v12 = v11[i].split(",");
            l_iTarget = parseInt(v12[2]);
            if (l_iTarget > 1 || v1[2].indexOf("%") > -1) {
                v13 = eval("screen." + v12[0]);
                for (v6 = 0; v6 < v2.length; v6++) {
                    v10 = v2[v6].split("=");
                    if (v10[0] == v12[0]) {
                        v14 = parseInt(v10[1]);
                        if (v10[1].indexOf("%") > -1) {
                            v14 = (v14 / 100) * v13;
                            v2[v6] = v12[0] + "=" + v14;
                        }
                    }
                    if (v10[0] == v12[1]) {
                        v16 = parseInt(v10[1]);
                        v15 = v6;
                    }
                }
                if (l_iTarget == 2) {
                    v7 = (v13 - v14) / 2;
                    v15 = v2.length;
                } else if (l_iTarget == 3) {
                    v7 = v13 - v14 - v16;
                }
                v2[v15] = v12[1] + "=" + v7;
            }
        }
        v8 = v2.join(",");
        v9 = window.open(v1[0], v1[1], v8);
        if (v3) {
            v9.focus();
        }
        document.MM_returnValue = false;
        return v9;

    }
</script>
<input type="hidden" value="<?php echo $model; ?>" id="page" />
<?php $p = CakeSession::read('pointdevente'); ?>
<?php
$users = CakeSession::read('users');
//debug($users);
if ($users != 12) {
    $readonly = "readonly";
} else {
    $readonly = "";
}
$w1 = 12;
$w2 = 17;
$w3 = 0;
if ($model == 'Factureclient' || $model == 'Bonlivraison') {
    $w1 = 10;
    $w2 = 14;
    $w3 = 5;
}
?>     
<div class="row" >
    <div class="col-md-12" >
                    <?php echo $this->Form->create($model, array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>
        <div class="panel panel-default">
            <div class="panel-heading not_padinng">
                <div class="row">
                    <div class="col-xs-6 text-left pull-left">
                        <div class="panel-title taille_titre ">
                            <a class="btn btn btn-danger a_color" href="<?php echo $this->webroot . '/' . $model . 's'; ?>/index"/> <i class="fa fa-reply"></i> Retour </a>
                            <strong ><?php echo __('Modification ' . $model); ?></strong>
                        </div>
                    </div>
                    <div class="col-xs-6 text-center pull-right">
                        <a  id ="btnChanger" style="float: right;" class="btn btn-warning a_color" /> <i class="fa fa-arrows"></i></a>
                        <div style="display:none;" id="typedipliquationdiv" class="pull-right" style="float: right;">
                            <?php
                            echo $this->Form->input('typedipliquation', array('id' => 'typedipliquation', 'label' => '', 'div' => '', 'between' => '<div class="col-sm-10 ">', 'after' => '</div>', 'class' => 'testtimbre', 'empty' => 'Veuillez Choisir !!'));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body not_height">

                <div class="col-md-4" >                  
                    <?php
                    echo $this->Form->input('id', array('id' => 'id_fac', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    if ($p == 0) {
                        echo $this->Form->input('pointdevente_id', array('id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select numspecial inputspcial fodec_retenue'));
                    }
                    echo $this->Form->input('depot_id', array('id' => 'depot_id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select depot_qte_s inputspcial', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('model', array('id' => 'model', 'type' => 'hidden', 'value' => $model, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' => $date, 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly inputspcial'));
                    //echo $this->Form->input('numero', array('readonly' => $readonly, 'id' => 'numero', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('numero', array( 'id' => 'numero', 'div' => 'form-group', 'between' => '<div class="col-sm-8">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    ?>
                    
                </div>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('client_id', array('type'=>'hidden','id' => 'client_id', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('clientname', array('value'=>$name,'label'=>'Client','yourid'=>'client_id','id' => 'clientname', 'div' => 'form-group', 'between' => '<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div></td><td style="width: 5%;vertical-align: top" id="divreleve"><a onClick="flvFPW1(wr + `Releves/index/'.$this->request->data[$model]['client_id'].'`, `UPLOAD`, `width=1800,height=800,scrollbars=yes`, 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-xs ls-blue-btn"><i class="fa fa-usd"></i></button></a></td></tr></table>', 'class' => 'form-control autocomplete_name_clients  inputspcial'));
                    ?>
                    <?php
                    echo $this->Form->input('adresse', array('readonly' => 'readonly', 'label' => 'Adresse', 'value' => $adresse, 'id' => 'adresse', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('matriculefiscale', array('value'=>$matriculefiscale,'yourid'=>'client_id','label' => 'Matricule Fiscale', 'id' => 'matriculefiscale', 'div' => 'form-group','between' => '<div class="col-sm-10"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div>', 'class' => 'form-control inputspcial autocomplete_matriculefiscale_clients'));
                    echo $this->Form->input('name', array('value' => $name, 'label' => 'Raison Sociale', 'id' => 'name', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('autorisation', array('value' => $autorisation, 'readonly' => 'readonly', 'label' => 'En Cours', 'id' => 'autorisation', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('montantutilise', array('value' => $solde, 'readonly' => 'readonly', 'label' => 'Solde', 'id' => 'solde', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('encour', array('value' => $valreste, 'readonly' => 'readonly', 'label' => 'Reste', 'id' => 'valreste', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('typeclient_id', array('value' => $typeclient_id, 'type' => 'hidden', 'id' => 'typeclientid', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('numbc', array('label'=>'Numero BC', 'id' => 'numbc',  'div' => 'form-group', 'between' => '<div class="col-sm-8">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    ?>
                    <input id="vente" name="data[<?php echo $model; ?>][vente]" value="<?php echo $this->request->data[$model]['vente']; ?>" type="hidden">
                    <div class="form-group">
                        <label for="asas"></label>
                        <div class="col-sm-10">
                            <input type="radio" class="recalculer_par_typeclient" name="data[<?php echo $model; ?>][typeclient_id]" id="Assujettis" value="1" <?php if ($this->request->data[$model]['typeclient_id'] == 1) { ?> checked <?php } ?>>Assujettis
                            <input type="radio" class="recalculer_par_typeclient" name="data[<?php echo $model; ?>][typeclient_id]" id="Exoneres" value="2" <?php if ($this->request->data[$model]['typeclient_id'] == 2) { ?> checked <?php } ?>>Exonérés
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="data[<?php echo $model; ?>][vent]" id="optionsRadios11" value="detail" <?php if ($this->request->data[$model]['vente'] == 'detail') { ?> checked <?php } ?> >Detail
                            <input type="radio" name="data[<?php echo $model; ?>][vent]" id="optionsRadios12" value="gros" <?php if ($this->request->data[$model]['vente'] == 'gros') { ?> checked <?php } ?> >Gros
                        </div>
                    </div>
                    
                      <div class="form-group">
                        <label for="asas"></label>
                        <div class="col-sm-10">
                            <input type="radio" class="recalculer_par_typefodec" name="data[<?php echo $model; ?>][typefodec]"  id="avecfodec" value="avecfodec" <?php if ($this->request->data[$model]['typefodec'] == 'avecfodec') { ?> checked <?php } ?> >Fodec
                             <input type="radio" class="recalculer_par_typefodec" name="data[<?php echo $model; ?>][typefodec]"  id="sansfodec" value="sansfodec" <?php if ($this->request->data[$model]['typefodec'] == 'sansfodec') { ?> checked <?php } ?> >Sans Fodec
             <input type="hidden"   name="data[<?php echo $model; ?>][typefodec]" id="typefodec" value="avecfodec" checked>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" class="recalculer_par_typetimbre"   name="data[<?php echo $model; ?>][typetimbre]" id="timbre1" value="avectimbre" <?php if ($this->request->data[$model]['typetimbre'] == 'avectimbre') { ?> checked <?php } ?> >Timbre
                            <input type="radio" class="recalculer_par_typetimbre"  name="data[<?php echo $model; ?>][typetimbre]" id="timbre2" value="sanstimbre" <?php if ($this->request->data[$model]['typetimbre'] == 'sanstimbre') { ?> checked <?php } ?> >Sans Timbre 
                            
         <input type="hidden"  name="data[<?php echo $model; ?>][typetimbre]" id="typetimbre" value="avectimbre" checked>

							<!--<input type="radio" name="data[<?php /*echo $model; */?>][vent]" id="optionsRadios11" value="detail" <?php /*if(=='detail'){*/?> checked="checked"<?php /*} */?> >Detail
							<input type="radio" name="data[<?php /*echo $model; */?>][vent]" id="optionsRadios12" value="gros" <?php /*if(=='gros'){*/?> checked="checked"<?php /*} */?> >Gros
                     -->   </div>
                    </div>
                </div>
                <div class="clear"></div>     
                <table class="table table-bordered table-striped table-bottomless tablejdid scrollh" id="addtable" style="width:100%" align="center" >
                    <thead>
                        <tr class="entetetab" style="background-color: #c6b9b9;">
                            <td align="center" nowrap="nowrap" width="1%" ></td>
                            <td align="center" nowrap="nowrap" width="1%" ></td>
                            <td align="center" nowrap="nowrap" width="1%" ></td>
                            <td align="center" nowrap="nowrap" width="1%" ></td>
                            <td align="center" nowrap="nowrap" width="<?php echo $w1; ?>%">code</td>
                            <td align="center" nowrap="nowrap" width="<?php echo $w2; ?>%">Article</td>
                            <td align="center" nowrap="nowrap" width="7%"> Qte </td>
                            <?php if ($model == 'Factureclient' || $model == 'Bonlivraison') { ?>
                                <td style="display: none;" align="center" nowrap="nowrap" width="0%">Prix achat</td>
                                <td align="center" nowrap="nowrap" width="<?php echo $w3; ?>%">Marge</td>
<?php } ?>
                            <td align="center" nowrap="nowrap" width="9%">PUHT</td>    
                            <td align="center" nowrap="nowrap" width="5%">Rem</td>
                            <td align="center" nowrap="nowrap" width="9%">PNHT</td>
                            <td align="center" nowrap="nowrap" width="9%">PUTTC</td> 
                            <td align="center" nowrap="nowrap" width="9%">HT</td>
                            <td align="center" nowrap="nowrap" width="5%">TVA</td>
                            <td align="center" nowrap="nowrap" width="9%">TTC</td>
                            <td align="center" nowrap="nowrap" width="5%">stock</td>
                            <td align="center" nowrap="nowrap" width="1%" >
                                <a class="btn btn-danger ajouterligne_livraison1" table='addtable' index='index'  tr="tr" style="
                                   padding: 0px 6px;
                                   "><i class="fa fa-plus-circle"  ></i> </a>
                            </td>
                        </tr>
                    </thead>
<?php $tablesemi = 'Lignepiece'; ?>
                    <tbody>
                        <tr class="tr " style="display:none;" >
                            <td width="1%" id="" champ="nv-art" index="" > 

                            </td>
                            <td width="1%" id="" champ="tdaff" index="">
                                <span title="Ancien prix"><a  onclick="recap_rapport()" href="#reModal_refuser" id="" index="" champ="order" value="0" <button class=' '><i class='fa fa-arrows'></i></a></span>
                            </td>
                            <td width="1%" id="" champ="tdaff" index="" >
                                <span title="Nouveau Article" champ="nouveauart"></span>
                                <span title="Ancien prix"><a style="display:none;" onclick="recap_rapport()" href="#reModal_refuser" id="" index="" champ="order" value="0" <button class=' '><i class='fa fa-arrows'></i></a></span>
                            </td>
                            <td width="1%">
                                <span champ="num"></span>
                            </td>
                            <td width="<?php echo $w1; ?>%">
                                    <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table' => $tablesemi,'index'=>'','id'=>'article_id','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control articleidbl','empty'=>'Veuillez Choisir !!') );   ?>
                                <div class="" style="display:inline; position: relative;">
                                    <?php
                                    echo $this->Form->input('article_id', array('div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                                    echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control alicode', 'type' => 'text'));
//codeselect setQuerycode
                                    ?>
                                    <?php echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ', 'type' => 'text'));
                                    ?><div id="res" champ="rescode" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>

                                </div>
                            </td>
                            <td width="<?php echo $w2; ?>%">
                                <div class="" style="display:inline; position: relative;">
                                <?php echo $this->Form->input('designation', array('div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text'));
                                ?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                </div>
                            </td>
                            <td width="7%">
                                <?php echo $this->Form->input('quantite', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte calculefacture ')); ?>
                                <?php echo $this->Form->input('pmp', array('type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'pmp', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                            </td>
                            <?php if($model=='Factureclient' || $model == 'Bonlivraison'){ ?>
                            <td width="<?php echo $w3; ?>%">
                                <?php
                                echo $this->Form->input('prixachatmarge', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixachatmarge', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                echo $this->Form->input('margebase', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'margebase', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control changerprix calculefacture'));
                                echo $this->Form->input('margebaseorigine', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'margebaseorigine', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                ?>
                            </td>
                            <?php } ?>
                            <td width="9%">
                                <?php
                                echo $this->Form->input('prixachat', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixachat', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                echo $this->Form->input('prix', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixhtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeinverseputtc'));
                                ?>
                            </td>
                            <td width="5%">
                                <?php
                                echo $this->Form->input('remise', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeprix_net_ttc calculefacture'));
                                echo $this->Form->input('remiseans', array('type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'remiseans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                ?>
                            </td>
                            <td width="9%">
                                <?php echo $this->Form->input('prixnet', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixnet', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeremisenet')); ?>
                            </td>
                            <td width="9%">
                                <?php
                                echo $this->Form->input('puttc', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'puttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeprixvente'));
                                echo $this->Form->input('totalhtans', array('div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'totalhtans', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                ?>
                            </td>
                            <td width="9%">
                                <?php echo $this->Form->input('totalht', array('div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'totalht', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                            </td>
                            <td width="5%">
                                <?php echo $this->Form->input('tva', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacture')); ?>
                            </td>
                            <td width="9%">
                                <?php echo $this->Form->input('totalttc', array('readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'totalttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                            </td>
                            <td width="5%">
                                <?php echo $this->Form->input('depotcomposee', array('name' => '', 'id' => '', 'champ' => 'depotcomposee', 'table' => $tablesemi, 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                <?php echo $this->Form->input('type', array('value' => 0, 'name' => '', 'id' => '', 'champ' => 'type', 'table' => $tablesemi, 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                <?php echo $this->Form->input('sup', array('name' => '', 'id' => '', 'champ' => 'sup', 'table' => $tablesemi, 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                <?php echo $this->Form->input('quantitestock', array('readonly' => 'readonly', 'label' => '', 'div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => 'quantitestock', 'champ' => 'quantitestock', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                            </td>
                            <td width="1%" id="" champ="tdaff" index="" >
                                <i index=""  class="fa fa-times supp1" style="color: #c9302c;font-size: 15px;"/>
                            </td>

                        </tr>

                        <?php
                        foreach ($lignefactureclients as $i => $l) {
//                            debug($l);
//                            die;
                            $qtestock = 0;
                            $i = $i + 1;
                            $objStockdepot = ClassRegistry::init('Stockdepot');
                            if (empty($l[$ligne_model]['composee'])) {
                                $stock = $objStockdepot->find('first', array('conditions' => array('Stockdepot.article_id' => $l[$ligne_model]['article_id'],
                                        'Stockdepot.depot_id' => $this->request->data[$model]['depot_id']), 'fields' => array('ifnull(sum(Stockdepot.quantite),0) as qte')));
                                if (($model == "Factureclient") || ($model == "Bonlivraison")) {
                                    $qtestock = $stock[0]['qte'] + $l[$ligne_model]['quantite'];
                                } else {
                                    $qtestock = $stock[0]['qte'];
                                }
                            }

                            ?>
                            <tr class="cc<?php echo $i; ?> testclientvide" >
                                <td width="1%" id="nv-art<?php echo $i; ?>" champ="nv-art" index="<?php echo $i; ?>" > 
                                    <a onClick="flvFPW1(wr + 'Deviprospects/recapajoutarticle/' + <?php echo $i; ?> + '/vente\'/', 'UPLOAD', 'width=1200,height=600,scrollbars=yes', 0, 2, 2);
                                                return document.MM_returnValue" href="javascript:;" > <i class="glyphicon glyphicon-plus" index=<?php echo $i; ?> style="color:#cc0000"></i> </a>

                                </td>
                                <td width="1%" id="tdaff<?php echo $i; ?>" >
                                <span title="Ancien prix"><a  onclick="recap_rapport(<?php echo $i; ?>)" href="#reModal_refuser" champ="order" id="order<?php echo $i; ?>" value="<?php echo $i; ?>" <button class='  '><i class='fa fa-arrows'></i></a></span>
                                </td>
                                <td width="1%" id="tdaff<?php echo $i; ?>" >
                                        <?php if ($l[$ligne_model]['composee'] == 1) { ?>
                                        <span title="Nouveau Article" champ="nouveauart" id="nouveauart<?php echo $i; ?>">
                                            <a onClick="flvFPW1(wr + 'Factureclients/recap_nouveau_prix/<?php echo $i; ?>/<?php echo $l['Article']['id']; ?>/<?php echo $l[$ligne_model]['quantite']; ?>/<?php echo $l[$ligne_model]['depotcomposee']; ?>/<?php echo 1; ?>/', 'UPLOAD', 'width=1200,height=600,scrollbars=yes', 0, 2, 2);
                                                            return document.MM_returnValue" href="javascript:;" > <i class="glyphicon glyphicon-plus" index=<?php echo $i; ?> style="color:#0080FF"></i> </a>
                                        </span>
                                    <?php } else { ?>
                                        <span title="Ancien prix"><a  onclick="recap_rapport(<?php echo $i; ?>)" href="#reModal_refuser" champ="order" id="order<?php echo $i; ?>" value="<?php echo $i; ?>" <button class='  '><i class='fa fa-arrows'></i></a></span>
    <?php } ?>
                                </td>
                                <td width="1%">
                                    <span champ="num" id="num<?php echo $i; ?>" index="<?php echo $i; ?>"><?php echo $i; ?></span>
                                </td>
                                <td width="<?php echo $w1; ?>%"  class="" index="<?php echo $i; ?>">
                                    <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][article_id]','table' => $tablesemi,'index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select  articleidbl','empty'=>'Veuillez Choisir !!') );   ?>
                                    <!--                                    <div class="" style="display:inline; position: relative;">
                                    <?php
//                                        echo $this->Form->input('article_id', array('value' => $l['Article']['id'], 'div' => 'form-group', 'name' => 'data[' . $tablesemi . '][' . $i . '][article_id]', 'table' => $tablesemi, 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                                        echo $this->Form->input('code', array('onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => $l['Article']['code'], 'div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control alicode', 'type' => 'text'));
                                    ?>
                                                                        </div>-->
                                        <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table' => $tablesemi,'index'=>'','id'=>'article_id','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control articleidbl','empty'=>'Veuillez Choisir !!') );   ?>
                                    <div class="" style="display:inline; position: relative;">
                                        <?php
                                        echo $this->Form->input('article_id', array('value' => $l['Article']['id'], 'div' => 'form-group', 'name' => 'data[' . $tablesemi . '][' . $i . '][article_id]', 'table' => $tablesemi, 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                                    echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control alicode', 'type' => 'text'));
                                        ?>
    <?php echo $this->Form->input('code', array('value' => $l['Article']['code'], 'div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control codeselect setQuerycode', 'type' => 'text'));
    ?><div id="res" champ="rescode" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>

                                    </div>
                                </td>
                                <td width="<?php echo $w2; ?>%">
                                    <div class="" style="display:inline; position: relative;">
    <?php echo $this->Form->input('designation', array('onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => $l[$ligne_model]['designation'], 'div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][designation]', 'table' => $tablesemi, 'index' => $i, 'id' => 'designation' . $i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                        <div id="res<?php echo $i; ?>" champ="res" index="<?php echo $i; ?>"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                    </div>
                                </td>
                                <td width="7%">
                                    <?php
                                    if (empty($l[$ligne_model]['composee'])) {
                                        echo $this->Form->input('quantite', array('value' => $l[$ligne_model]['quantite'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'label' => '', 'div' => 'form-group', 'name' => 'data[' . $tablesemi . '][' . $i . '][quantite]', 'table' => $tablesemi, 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte   calculefacture '));
                                    } else {
                                        echo $this->Form->input('quantite', array( 'value' => $l[$ligne_model]['quantite'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'label' => '', 'div' => 'form-group', 'name' => 'data[' . $tablesemi . '][' . $i . '][quantite]', 'table' => $tablesemi, 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte   calculefacture '));
                                    }
                                    ?>

                                </td>
                                <?php if($model=='Factureclient' || $model == 'Bonlivraison'){ 
                                   //debug($l);die;
                                   $margeorigine=$l['Article']['margegros'];
                                   if($l[$model]['vente']=='detail'){
                                       $margeorigine=$l['Article']['marge'];
                                   }
                                    
                                    ?>
                            <td width="<?php echo $w3; ?>%">
                                <?php
                                echo $this->Form->input('prixachatmarge', array('value' => $l[$ligne_model]['prixachatmarge'], 'name' => 'data[' . $tablesemi . '][' . $i . '][prixachatmarge]','div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'prixachatmarge'.$i, 'champ' => 'prixachatmarge', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                echo $this->Form->input('margebase', array('div' => 'form-group','onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))','value' => $l[$ligne_model]['margebase'], 'name' => 'data[' . $tablesemi . '][' . $i . '][margebase]', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'margebase'.$i, 'champ' => 'margebase', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control changerprix calculefacture'));
                                echo $this->Form->input('margebaseorigine', array( 'div' => 'form-group','value'=>$margeorigine, 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'margebaseorigine'.$i, 'name' => 'data[' . $tablesemi . '][' . $i . '][margebaseorigine]', 'champ' => 'margebaseorigine', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                ?>
                            </td>
                            <?php } ?>
                                <td width="9%">
                                    <?php echo $this->Form->input('pmp', array('value' => @$l[$ligne_model]['pmp'], 'type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][pmp]', 'table' => $tablesemi, 'index' => $i, 'id' => 'pmp' . $i, 'champ' => 'pmp', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control changerprix'));
                                    ?>
    <?php echo $this->Form->input('prixachat', array('div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][prixachat]', 'table' => $tablesemi, 'index' => $i, 'id' => 'prixachat' . $i, 'champ' => 'prixachat', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control changerprix')); ?>
                                    <?php echo $this->Form->input('prix', array('onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => $l[$ligne_model]['prix'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][prixhtva]', 'table' => $tablesemi, 'index' => $i, 'id' => 'prixhtva' . $i, 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeinverseputtc changerprix')); ?>
                                </td>
                                <td width="5%">
                                    <?php
                                    echo $this->Form->input('remise', array('onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => $l[$ligne_model]['remise'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][remise]', 'table' => $tablesemi, 'index' => $i, 'id' => 'remise' . $i, 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeprix_net_ttc changerprix calculefacture '));
                                    echo $this->Form->input('remiseans', array('type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][remiseans]', 'table' => $tablesemi, 'index' => $i, 'id' => 'remiseans' . $i, 'champ' => 'remiseans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  '));
                                    ?>
                                </td>
                                <td width="9%">
                                    <?php echo $this->Form->input('prixnet', array('onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => @$l[$ligne_model]['prixnet'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][prixnet]', 'table' => $tablesemi, 'index' => $i, 'id' => 'prixnet' . $i, 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeremisenet changerprix')); ?>
                                </td>
                                <td  width="9%">
                                    <?php
                                    echo $this->Form->input('puttc', array('onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => @$l[$ligne_model]['puttc'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][puttc]', 'table' => $tablesemi, 'index' => $i, 'id' => 'puttc' . $i, 'champ' => 'puttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeprixvente changerprix'));
                                    echo $this->Form->input('totalhtans', array('value' => @$l[$ligne_model]['totalhtans'], 'type' => 'hidden', 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[' . $tablesemi . '][' . $i . '][totalhtans]', 'table' => $tablesemi, 'index' => $i, 'id' => 'totalhtans' . $i, 'champ' => 'totalhtans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                    ?>
                                </td>
                                <td width="9%">
                                    <?php echo $this->Form->input('totalht', array('value' => $l[$ligne_model]['totalht'], 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[' . $tablesemi . '][' . $i . '][totalht]', 'table' => $tablesemi, 'index' => $i, 'id' => 'totalht' . $i, 'champ' => 'totalht', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                </td>
                                <td width="5%">
                                    <?php echo $this->Form->input('tva', array('value' => $l[$ligne_model]['tva'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][tva]', 'table' => $tablesemi, 'index' => $i, 'id' => 'tva' . $i, 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacture')); ?>
                                </td>
                                <td width="9%">
                                    <?php echo $this->Form->input('totalttc', array('value' => $l[$ligne_model]['totalttc'], 'readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][totalttc]', 'table' => $tablesemi, 'index' => $i, 'id' => 'totalttc' . $i, 'champ' => 'totalttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                </td>
                                <td width="5%">
                                    <?php echo $this->Form->input('depotcomposee', array('name' => 'data[' . $tablesemi . '][' . $i . '][depotcomposee]', 'value' => $l[$ligne_model]['depotcomposee'], 'id' => 'depotcomposee' . $i, 'champ' => 'depotcomposee', 'table' => $tablesemi, 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                    <?php echo $this->Form->input('type', array('name' => 'data[' . $tablesemi . '][' . $i . '][type]', 'value' => $l[$ligne_model]['composee'], 'id' => 'type' . $i, 'champ' => 'type', 'table' => $tablesemi, 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                    <?php echo $this->Form->input('id', array('value' => $l[$ligne_model]['id'], 'name' => 'data[' . $tablesemi . '][' . $i . '][id]', 'id' => 'id' . $i, 'champ' => 'id', 'table' => $tablesemi, 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                    <?php echo $this->Form->input('sup', array('name' => 'data[' . $tablesemi . '][' . $i . '][sup]', 'id' => 'sup' . $i, 'champ' => 'sup', 'table' => $tablesemi, 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>

                                    <?php
                                    echo $this->Form->input('quantitestock', array('value' => @$qtestock, 'label' => '', 'div' => 'form-group', 'name' => 'data[' . $tablesemi . '][' . $i . '][quantitestock]', 'table' => $tablesemi, 'index' => $i, 'id' => 'quantitestock' . $i, 'champ' => 'quantitestock', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                                    ?>

                                </td>
                                <td width="1%" id="tdaff<?php echo $i; ?>" >
                                    <i index="<?php echo $i; ?>"  class="fa fa-times supp1" style="color: #c9302c;font-size: 15px;"/>
                                </td> 
                            </tr>
<?php } ?>
                    </tbody>
                </table>

                <input type="hidden" value="<?php echo $i; ?>" id="index" />
                <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="pop">


                    </div>
                    <br>
                    <a  class="remodal-confirm ls-light-green-btn btn" ><strong>OK</strong></a>

                </div> 

                <!--                <div class="col-md-3">
                <?php
//                    echo $this->Form->input('representant', array('label' => 'Représentant', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'representant', 'class' => 'form-control inputspcial'));
//                    echo $this->Form->input('livreur', array('label' => 'Livreur', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'livreur', 'class' => 'form-control inputspcial'));
                ?>
                                </div>-->
                <div class="col-md-3">                  
                    <?php
					
					//debug($this->request->data[$model]);
					$pp = ClassRegistry::init("Pointdevente")->find('first',array('recursive'=>-1,'conditions'=>array('Pointdevente.id'=>$this->request->data[$model]['pointdevente_id'] )));
					 
                    echo $this->Form->input('totalht', array('label' => 'Total HT', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_HT', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('remise', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'remise', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('fodec', array('value' => $this->request->data[$model]['fodec'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'fodec', 'class' => 'form-control inputspcial'));
                     echo $this->Form->input('fodeca', array('value' => $pp['Pointdevente']['fodec'],'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'fodeca', 'class' => 'form-control inputspcial'));
  ?>
                    <div class="form-group">
                        <label for="ttfodec" class="col-md-2 control-label">Fodec :<span id="fodecspan"><?php echo $this->request->data[$model]['fodec'] . '%'; ?></span></label>
                        <div class="col-sm-10">
                            <input value="<?php echo $this->request->data[$model]['ttfodec']; ?>" name="data[<?php echo $model; ?>][ttfodec]" readonly="readonly" id="ttfodec" class="form-control inputspcial" type="text">
                        </div>
                    </div>
                    <?php
                    $lien_vente = CakeSession::read('lien_vente');
                    foreach ($lien_vente as $k => $liens) {
                        if (@$liens['lien'] == 'marge') {
                            $marge = 1;
                        }
                    }
                    if (@$marge == 1) {
                        echo $this->Form->input('marge', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'marge', 'class' => 'form-control inputspcial'));
                    }
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                    echo $this->Form->input('tva', array('label' => 'TVA', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'tva', 'class' => 'form-control inputspcial'));
                                    
				  
				    if ($model == "Factureclient" || $model == "Devi") {
                        echo $this->Form->input('timbre_id', array('div' => 'form-group', 'value' => $this->request->data[$model]['timbre_id'], 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'timbre', 'champ' => 'timbre', 'class' => 'form-control inputspcial'));
						  echo $this->Form->input('timbre', array('label' => 'TVA',   'value' => $timbre, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'timbrea', 'class' => 'form-control '));

                    }else{
                        echo $this->Form->input('timbre_id', array('div' => 'form-group', 'value' => 0, 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'timbre', 'champ' => 'timbre', 'class' => 'form-control inputspcial'));
                     echo $this->Form->input('timbre', array('label' => 'TVA', 'value' => 0, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'timbrea', 'class' => 'form-control '));
 }
                    echo $this->Form->input('retenue', array('value' => $this->request->data[$model]['retenue'], 'type' => 'hidden', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'retenue', 'class' => 'form-control inputspcial'));
                    ?>
                    <div class="form-group">
                        <label for="ttretenue" class="col-md-2 control-label">Retenue :<span id="retenuespan"><?php echo $this->request->data[$model]['retenue'] . '%'; ?></span></label>
                        <div class="col-sm-10">
                            <input value="<?php echo $this->request->data[$model]['ttretenue']; ?>" name="data[<?php echo $model; ?>][ttretenue]" readonly="readonly" id="ttretenue" class="form-control inputspcial" type="text">
                        </div>
                    </div><?php ?>
                </div>
                <div class="col-md-3">
                    <?php
                    echo $this->Form->input('totalttc', array('label' => 'NET à payer', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('newtotalttc', array('label' => 'NET TTC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'New_Total_TTC', 'class' => 'form-control inputspcial newtotalttc'));
                    ?>
                    <?php
                    if ($model != 'Factureclient') {
                        if ($this->request->data[$model]['auto'] == 'automatique') {
                            $check1 = 'checked';
                            $check2 = '';
                        } else {
                            $check1 = '';
                            $check2 = 'checked';
                        }
                        ?>
                        <div class="form-group">
                            <label for="automatique">Facturation :</label>
                            <div class="col-sm-10">
                                <input type="radio" name="data[<?php echo $model; ?>][auto]" id="optionRadios11" value="automatique" <?php echo $check1; ?> >Automatique
                                <input type="radio" name="data[<?php echo $model; ?>][auto]" id="optionRadios12" value="non" <?php echo $check2; ?> >Non
                            </div>
                        </div>
<?php } ?>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-primary  testlignedevente  testpv ">Enregistrer</button>
                        </div>
                    </div>   
                </div>
<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

