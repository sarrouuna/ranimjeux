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
        calculefacture();
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
?>     
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading not_padinng">
                <h3 class="panel-title taille_titre">
                    <a class="btn btn btn-danger a_color" href="<?php echo $this->webroot . '/' . $model_ans . 's'; ?>/index"/> <i class="fa fa-reply"></i> Retour </a>
                    <strong><?php echo __('Transformation vers  ' . $model); ?></strong></h3>
            </div>
            <div class="panel-body not_height">
                <?php echo $this->Form->create($model, array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-4" >                  
                    <?php
//                    debug($entete);die;
                    //echo $this->Form->input('id',array('id'=>'id_fac','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                    if ($p == 0) {
                        echo $this->Form->input('pointdevente_id', array('value' => $entete[$model_ans]['pointdevente_id'], 'id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select numspecial inputspcial fodec_retenue'));
                    }
                    echo $this->Form->input('model_ans', array('id' => 'model_ans', 'type' => 'hidden', 'value' => $model_ans, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('depot_id', array('value' => $entete[$model_ans]['depot_id'], 'id' => 'depot_id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select depot_qte_s inputspcial', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('numeroconca', array('id' => 'numeroconca', 'type' => 'hidden', 'value' => $mm, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('model', array('id' => 'model', 'type' => 'hidden', 'value' => $model, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' => date("d/m/Y"), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly inputspcial'));
                    echo $this->Form->input('numero', array('value' => $numspecial, 'readonly' => $readonly, 'id' => 'numero', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('client_id', array('value' => $entete[0]['client_id'],'type'=>'hidden','id' => 'client_id', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('clientname', array('value'=>$name,'label'=>'Client','yourid'=>'client_id','id' => 'clientname', 'div' => 'form-group', 'between' => '<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div></td><td style="width: 5%;vertical-align: top" id="divreleve"><a onClick="flvFPW1(wr + `Releves/index/'.$entete[0]['client_id'].'`, `UPLOAD`, `width=1800,height=800,scrollbars=yes`, 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-xs ls-blue-btn"><i class="fa fa-usd"></i></button></a></td></tr></table>', 'class' => 'form-control autocomplete_name_clients  inputspcial'));
                    ?>
                    <?php
                    //echo $this->Form->input('client_id', array('value' => $entete[0]['client_id'], 'id' => 'client_id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select infoclientbb inputspcial', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('adresse', array('readonly' => 'readonly', 'label' => 'Adresse', 'value' => $adresse, 'id' => 'adresse', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('matriculefiscale', array('value'=>$matriculefiscale,'yourid'=>'client_id','label' => 'Matricule Fiscale', 'id' => 'matriculefiscale', 'div' => 'form-group','between' => '<div class="col-sm-10"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div>', 'class' => 'form-control inputspcial autocomplete_matriculefiscale_clients'));
                    //echo $this->Form->input('matriculefiscale', array('label' => 'Matricule Fiscale', 'value' => $matriculefiscale, 'id' => 'matriculefiscale', 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('name', array('value' => $name, 'label' => 'Raison Sociale', 'id' => 'name', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('autorisation', array('value' => $autorisation, 'readonly' => 'readonly', 'label' => 'En Cours', 'id' => 'autorisation', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('montantutilise', array('value' => $solde, 'readonly' => 'readonly', 'label' => 'Solde', 'id' => 'solde', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('encour', array('value' => $valreste, 'readonly' => 'readonly', 'label' => 'Reste', 'id' => 'valreste', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('typeclient_id', array('value' => $typeclient_id, 'type' => 'hidden', 'id' => 'typeclientid', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                    <input id="vente" name="data[<?php echo $model; ?>][vente]" value="<?php echo $entete[$model_ans]['vente']; ?>" type="hidden">
                    <div class="form-group">
                        <label for="asas"></label>
                        <div class="col-sm-10">
                            <input type="radio" class="recalculer_par_typeclient" name="data[<?php echo $model; ?>][typeclient_id]" id="Assujettis" value="1" <?php if ($entete[$model_ans]['typeclient_id'] == 1) { ?> checked <?php } ?>>Assujettis
                            <input type="radio" class="recalculer_par_typeclient" name="data[<?php echo $model; ?>][typeclient_id]" id="Exoneres" value="2" <?php if ($entete[$model_ans]['typeclient_id'] == 2) { ?> checked <?php } ?>>Exonérés
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="data[<?php echo $model; ?>][vent]" id="optionsRadios11" value="detail" <?php if ($entete[$model_ans]['vente'] == 'detail') { ?> checked <?php } ?> >Detail
                            <input type="radio" name="data[<?php echo $model; ?>][vent]" id="optionsRadios12" value="gros" <?php if ($entete[$model_ans]['vente'] == 'gros') { ?> checked <?php } ?> >Gros
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <!--                <div style="height:370px;overflow:scroll;"> -->
                <table class="table table-bordered  table-bottomless tablejdid scrollh" id="addtable" style="width:100%" align="center" >
                    <thead>
                        <tr class="entetetab" style="background-color: #c6b9b9;">
                            <td align="center" nowrap="nowrap" width="1%" ></td>
                            <td align="center" nowrap="nowrap" width="1%" ></td>
                            <td align="center" nowrap="nowrap" width="1%" ></td>
                            <td align="center" nowrap="nowrap" width="12%">code</td>
                            <td align="center" nowrap="nowrap" width="18%">Article</td>
                            <?php if ($model_ans == "Commandeclient") { ?>
                                <td align="center" nowrap="nowrap" width="3%"> Qte </td>
                                <td align="center" nowrap="nowrap" width="4%"> Qte Liv </td>
                            <?php } else { ?>
                                <td align="center" nowrap="nowrap" width="7%"> Qte </td>
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
                            <td width="1%" id="" champ="tdaff" index="" >
                                <span title="Nouveau Article" champ="nouveauart"></span>
                                <span title="Ancien prix"><a style="display:none;" onclick="recap_rapport()" href="#reModal_refuser" id="" index="" champ="order" value="0" <button class=' '><i class='fa fa-arrows'></i></a></span>
                            </td>
                            <td width="1%" >
                                <span champ="num"></span>
                            </td>
                            <td width="12%">
                                <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table' => $tablesemi,'index'=>'','id'=>'article_id','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control articleidbl','empty'=>'Veuillez Choisir !!') ); ?>
                                <div class="" style="display:inline; position: relative;">
                                    <?php
                                    echo $this->Form->input('article_id', array('div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                                    echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control alicode', 'type' => 'text'));
                                    ?>
                                    <?php echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control codeselect', 'type' => 'text'));
                                    ?><div id="res" champ="rescode" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>

                                </div>
                            </td>
                            <td width="18%">
                                <div class="" style="display:inline; position: relative;">
                                    <?php echo $this->Form->input('designation', array('div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text'));
                                    ?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                </div>
                            </td>

                            <?php if ($model_ans == "Commandeclient") { ?>
                                <td width="3%">
                                    <?php echo $this->Form->input('quantiteans', array('readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'quantiteans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                </td>
                                <td width="4%">
                                    <?php echo $this->Form->input('quantite', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte calculefacture ')); ?>
                                </td>
                            <?php } else { ?>
                                <td width="7%">
                                    <?php echo $this->Form->input('quantite', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte calculefacture ')); ?>
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
                                <?php echo $this->Form->input('type', array('value' => 0, 'name' => '', 'id' => '', 'champ' => 'type', 'table' => $tablesemi, 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                <?php echo $this->Form->input($ligne_model_ans . '_id', array('name' => '', 'id' => '', 'champ' => $ligne_model_ans . '_id', 'table' => $tablesemi, 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                <?php echo $this->Form->input($attribut_ans, array('name' => '', 'id' => '', 'champ' => $attribut_ans, 'table' => $tablesemi, 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                <?php echo $this->Form->input('sup', array('name' => '', 'id' => '', 'champ' => 'sup', 'table' => $tablesemi, 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                <?php echo $this->Form->input('quantitestock', array('readonly' => 'readonly', 'label' => '', 'div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => 'quantitestock', 'champ' => 'quantitestock', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                            </td>
                            <td width="1%" id="" champ="tdaff" index="" >
                                <i index=""  class="fa fa-times supp1" style="color: #c9302c;font-size: 15px;"/>
                            </td>

                        </tr>

                        <?php
                        $att_ans = 0;
                        foreach ($lignes as $i => $l) {
//debug($l);die;
                            $qtestock = 0;
                            $i = $i + 1;
                            $objStockdepot = ClassRegistry::init('Stockdepot');
                            $stock = $objStockdepot->find('first', array('conditions' => array('Stockdepot.article_id' => $l[$ligne_model_ans]['article_id'],
                                    'Stockdepot.depot_id' => $entete[$model_ans]['depot_id']), 'fields' => array('ifnull(sum(Stockdepot.quantite),0) as qte')));
                            $qtestock = $stock[0]['qte'];
                            $model_article = ClassRegistry::init('Article');
                            $req_article = $model_article->find('first', array('conditions' => array('Article.id' => $l[$ligne_model_ans]['article_id'])));
                            $req_model_ans = ClassRegistry::init($model_ans)->find('first', array('conditions' => array($model_ans . '.id' => $l[$ligne_model_ans][$attribut_ans])));
                            ?>

                            <?php if ($l[$ligne_model_ans][$attribut_ans] != $att_ans) { ?>
                                <tr style="background-color: #dbabab;"> 

                                    <td align="left"  colspan="14" style="padding: 0px 30px;"><strong><?php echo $model_ans . ' : ' . $req_model_ans[$model_ans]['numero']; ?></strong></td>

                                    </td> 
                                </tr>
                                <?php
                            }
                            $att_ans = $l[$ligne_model_ans][$attribut_ans];
                            ?>            




                            <tr class="cc<?php echo $i; ?> testclientvide" >
                                <td width="1%" id="nv-art<?php echo $i; ?>" champ="nv-art" index="<?php echo $i; ?>" > 
                                    <a onClick="flvFPW1(wr + 'Deviprospects/recapajoutarticle/' + <?php echo $i; ?> + '/vente\'/', 'UPLOAD', 'width=1200,height=600,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" > <i class="glyphicon glyphicon-plus" index=<?php echo $i; ?> style="color:#cc0000"></i> </a>

                                </td>
                                <td id="tdaff0" width="1%">
                                    <span title="Ancien prix"><a  onclick="recap_rapport(<?php echo $i; ?>)" href="#reModal_refuser" champ="order" id="order<?php echo $i; ?>" value="<?php echo $i; ?>" <button class='  '><i class='fa fa-arrows'></i></a></span>
                                </td>
                                <td width="1%">
                                    <span champ="num" id="num<?php echo $i; ?>" index="<?php echo $i; ?>"><?php echo $i; ?></span>
                                </td>
                                <td width="12%" class="" index="<?php echo $i; ?>">
                                    <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][article_id]','table' => $tablesemi,'index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select  articleidbl','empty'=>'Veuillez Choisir !!') );?>
                                    <div class="" style="display:inline; position: relative;">
                                        <?php
                                        echo $this->Form->input('article_id', array('readonly' => 'readonly', 'value' => $req_article['Article']['id'], 'div' => 'form-group', 'name' => 'data[' . $tablesemi . '][' . $i . '][article_id]', 'table' => $tablesemi, 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                        echo $this->Form->input('code', array('readonly' => 'readonly', 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => $req_article['Article']['code'], 'div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control alicode', 'type' => 'text'));
                                        ?>
                                    </div>
                                </td>
                                <td width="18%">
                                    <div class="" style="display:inline; position: relative;">
                                        <?php echo $this->Form->input('designation', array('readonly' => 'readonly', 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => $req_article['Article']['name'], 'div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][designation]', 'table' => $tablesemi, 'index' => $i, 'id' => 'designation' . $i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                        <div id="res<?php echo $i; ?>" champ="res" index="<?php echo $i; ?>"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                    </div>
                                </td>
                                <?php if ($model_ans == "Commandeclient") { ?>
                                    <td width="3%">
                                        <?php echo $this->Form->input('quantiteans', array('value' => $l[$ligne_model_ans]['quantite'], 'readonly' => 'readonly', 'label' => '', 'div' => 'form-group', 'name' => 'data[' . $tablesemi . '][' . $i . '][quantiteans]', 'table' => $tablesemi, 'index' => $i, 'id' => 'quantiteans' . $i, 'champ' => 'quantiteans', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                    </td>
                                    <td width="4%">
                                        <?php echo $this->Form->input('quantite', array('value' => $l[$ligne_model_ans]['quantite'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'label' => '', 'div' => 'form-group', 'name' => 'data[' . $tablesemi . '][' . $i . '][quantite]', 'table' => $tablesemi, 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte   calculefacture ')); ?>
                                    </td>
                                <?php } else { ?>
                                    <td width="7%">
                                        <?php echo $this->Form->input('quantite', array('value' => $l[$ligne_model_ans]['quantite'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'label' => '', 'div' => 'form-group', 'name' => 'data[' . $tablesemi . '][' . $i . '][quantite]', 'table' => $tablesemi, 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte   calculefacture ')); ?>
                                    </td>
                                <?php } ?>

                                <td width="9%">
                                    <?php echo $this->Form->input('prixachat', array('readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][prixachat]', 'table' => $tablesemi, 'index' => $i, 'id' => 'prixachat' . $i, 'champ' => 'prixachat', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                    <?php echo $this->Form->input('prix', array('readonly' => 'readonly', 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => sprintf('%.3f', $l[$ligne_model_ans]['prix']), 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][prixhtva]', 'table' => $tablesemi, 'index' => $i, 'id' => 'prixhtva' . $i, 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeinverseputtc')); ?>
                                </td>
                                <td width="5%">
                                    <?php
                                    echo $this->Form->input('remise', array('readonly' => 'readonly', 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => $l[$ligne_model_ans]['remise'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][remise]', 'table' => $tablesemi, 'index' => $i, 'id' => 'remise' . $i, 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeprix_net_ttc calculefacture'));
                                    echo $this->Form->input('remiseans', array('readonly' => 'readonly', 'type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][remiseans]', 'table' => $tablesemi, 'index' => $i, 'id' => 'remiseans' . $i, 'champ' => 'remiseans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  '));
                                    ?>
                                </td>
                                <td width="9%">
                                    <?php echo $this->Form->input('prixnet', array('readonly' => 'readonly', 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => @$l[$ligne_model_ans]['prixnet'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][prixnet]', 'table' => $tablesemi, 'index' => $i, 'id' => 'prixnet' . $i, 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeremisenet')); ?>
                                </td>
                                <td width="9%">
                                    <?php
                                    echo $this->Form->input('puttc', array('readonly' => 'readonly', 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => @$l[$ligne_model_ans]['puttc'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][puttc]', 'table' => $tablesemi, 'index' => $i, 'id' => 'puttc' . $i, 'champ' => 'puttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeprixvente'));
                                    echo $this->Form->input('totalhtans', array('value' => @$l[$ligne_model_ans]['prix'], 'type' => 'hidden', 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[' . $tablesemi . '][' . $i . '][totalhtans]', 'table' => $tablesemi, 'index' => $i, 'id' => 'totalhtans' . $i, 'champ' => 'totalhtans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                    ?>
                                </td>
                                <td width="9%">
                                    <?php echo $this->Form->input('totalht', array('value' => $l[$ligne_model_ans]['totalht'], 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[' . $tablesemi . '][' . $i . '][totalht]', 'table' => $tablesemi, 'index' => $i, 'id' => 'totalht' . $i, 'champ' => 'totalht', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                </td>
                                <td width="5%">
                                    <?php echo $this->Form->input('tva', array('readonly' => 'readonly', 'value' => $l[$ligne_model_ans]['tva'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][tva]', 'table' => $tablesemi, 'index' => $i, 'id' => 'tva' . $i, 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacture')); ?>
                                </td>
                                <td width="9%">
                                    <?php echo $this->Form->input('totalttc', array('value' => $l[$ligne_model_ans]['totalttc'], 'readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][totalttc]', 'table' => $tablesemi, 'index' => $i, 'id' => 'totalttc' . $i, 'champ' => 'totalttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                </td>
                                <td width="5%">
                                    <?php echo $this->Form->input('type', array('value' => $l[$ligne_model_ans]['composee'], 'name' => 'data[' . $tablesemi . '][' . $i . '][type]', 'id' => 'type' . $i, 'champ' => 'type', 'table' => $tablesemi, 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control')); ?>
                                    <?php echo $this->Form->input($ligne_model_ans . '_id', array('value' => $l[$ligne_model_ans][$ligne_model_ans . '_id'], 'name' => 'data[' . $tablesemi . '][' . $i . '][' . $ligne_model_ans . '_id]', 'id' => $ligne_model_ans . '_id' . $i, 'champ' => $ligne_model_ans . '_id', 'table' => $tablesemi, 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                    <?php echo $this->Form->input($attribut_ans, array('value' => $l[$ligne_model_ans][$attribut_ans], 'name' => 'data[' . $tablesemi . '][' . $i . '][' . $attribut_ans . ']', 'id' => $attribut_ans . $i, 'champ' => $attribut_ans, 'table' => $tablesemi, 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                    <?php echo $this->Form->input('sup', array('name' => 'data[' . $tablesemi . '][' . $i . '][sup]', 'id' => 'sup' . $i, 'champ' => 'sup', 'table' => $tablesemi, 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                    <?php echo $this->Form->input('quantitestock', array('value' => @$qtestock, 'readonly' => 'readonly', 'label' => '', 'div' => 'form-group', 'name' => 'data[' . $tablesemi . '][' . $i . '][quantitestock]', 'table' => $tablesemi, 'index' => $i, 'id' => 'quantitestock' . $i, 'champ' => 'quantitestock', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                </td>
                                <td width="1%" id="tdaff<?php echo $i; ?>" >
                                    <i index="<?php echo $i; ?>"  class="fa fa-times supp1" style="color: #c9302c;font-size: 15px;"/>
                                </td> 
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <!--                </div>    -->
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
                    echo $this->Form->input('totalht', array('value' => $entete[0]['totalht'], 'label' => 'Total HT', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_HT', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('remise', array('value' => $entete[0]['remise'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'remise', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('fodec', array('value' => $entete[$model_ans]['fodec'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'fodec', 'class' => 'form-control inputspcial'));
                    ?>
                    <div class="form-group">
                        <label for="ttfodec" class="col-md-2 control-label">Fodec :<span id="fodecspan"><?php echo $entete[$model_ans]['fodec'] . '%'; ?></span></label>
                        <div class="col-sm-10">
                            <input value="<?php echo $entete[$model_ans]['ttfodec']; ?>" name="data[<?php echo $model; ?>][ttfodec]" readonly="readonly" id="ttfodec" class="form-control inputspcial" type="text">
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
                    echo $this->Form->input('tva', array('value' => $entete[0]['tva'], 'label' => 'TVA', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'tva', 'class' => 'form-control inputspcial'));
                    if ($model == "Factureclient") {
                        if ($avectimbre == 'Non') {
                        $timbre['Timbre']['timbre'] =0;   
                        }else{
                            //debug($entete);
                        $entete[0]['totalttc']=$entete[0]['totalttc']+$timbre['Timbre']['timbre'];    
                        }
                        echo $this->Form->input('timbre_id', array('div' => 'form-group', 'value' => $timbre['Timbre']['timbre'], 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'timbre', 'champ' => 'timbre', 'class' => 'form-control inputspcial'));
                    }
                    echo $this->Form->input('retenue', array('value' => $entete[$model_ans]['retenue'], 'type' => 'hidden', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'retenue', 'class' => 'form-control inputspcial'));
                    ?>
                    <div class="form-group">
                        <label for="ttretenue" class="col-md-2 control-label">Retenue :<span id="retenuespan"><?php echo $entete[$model_ans]['retenue'] . '%'; ?></span></label>
                        <div class="col-sm-10">
                            <input value="<?php echo $entete[$model_ans]['ttretenue']; ?>" name="data[<?php echo $model; ?>][ttretenue]" readonly="readonly" id="ttretenue" class="form-control inputspcial" type="text">
                        </div>
                    </div><?php
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
//                                        debug($entete);die;
                    echo $this->Form->input('totalttc', array('value' => $entete[0]['totalttc'], 'label' => 'NET à payer', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('newtotalttc', array('label' => 'NET TTC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'New_Total_TTC', 'class' => 'form-control inputspcial newtotalttc'));
                    
                    ?>
                    <?php
                    if($entete[$model_ans]['auto'] == 'automatique'){
                        $check1 = 'checked';
                        $check2 = '';
                    }else{
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
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-primary <?php if($model=='Factureclient' || $model == 'Bonlivraison'){ ?> testdu3mois <?php } ?> testlignedevente  testpv btnEnregistrerTransClt">Enregistrer</button>
                        </div>
                    </div>    
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

