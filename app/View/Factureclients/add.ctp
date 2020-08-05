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
<input type="hidden" value="0" id="testindex" />
<?php
$p = CakeSession::read('pointdevente');
if ($p == 0) {
    $numspecial = "";
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
                            <strong ><?php echo __('Ajout ' . $model); ?></strong>
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
//                                    debug($model);die;
                    $style='style="display: "';
                    if ($p == 0) {
                        $style='style="display:none;"';
                        echo $this->Form->input('pointdevente_id', array('id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select numspecial inputspcial fodec_retenue'));
                    }
                    echo $this->Form->input('depot_id', array('id' => 'depot_id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select depot_qte_s inputspcial', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('numeroconca', array('id' => 'numeroconca', 'type' => 'hidden', 'value' => @$mm, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('model', array('id' => 'model', 'type' => 'hidden', 'value' => $model, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' => date("d/m/Y"), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly inputspcial'));
                    echo $this->Form->input('numero', array( 'id' => 'numero', 'value' => $numspecial, 'div' => 'form-group', 'between' => '<div class="col-sm-8">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    ?>

                </div>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('client_id', array('type'=>'hidden','id' => 'client_id', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('clientname', array('label'=>'Client','yourid'=>'client_id','id' => 'clientname', 'div' => 'form-group', 'between' => '<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div></td><td style="width: 5%;vertical-align: top" id="divreleve"></td></tr></table>', 'class' => 'form-control autocomplete_name_clients  inputspcial'));
                    ?>
					<?php
                    echo $this->Form->input('adresse', array('readonly' => 'readonly', 'label' => 'Adresse', 'id' => 'adresse', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('matriculefiscale', array('yourid'=>'client_id','label' => 'Matricule Fiscale', 'id' => 'matriculefiscale', 'div' => 'form-group','between' => '<div class="col-sm-10"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div>', 'class' => 'form-control inputspcial autocomplete_matriculefiscale_clients'));
                    echo $this->Form->input('name', array('label' => 'Raison Sociale', 'id' => 'name', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
/*                    echo $this->Form->input('message', array('type'=>'textarea','label' => '','id' => 'message', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>','width'=>'70px', 'class' => 'form-control inputspcial message'));*/

                    ?>

                </div>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('autorisation', array('readonly' => 'readonly', 'label' => 'En cours Autorisé', 'id' => 'auto', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('montantutilise', array('readonly' => 'readonly', 'label' => 'Solde', 'id' => 'solde', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('encour', array('readonly' => 'readonly', 'label' => 'Reste', 'id' => 'valreste', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('typeclient_id', array('type' => 'hidden', 'id' => 'typeclientid', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
//                    echo $this->Form->input('typedipliquation', array('label' => 'Changer', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('numbc', array('label'=>'Numero BC', 'id' => 'numbc',  'div' => 'form-group', 'between' => '<div class="col-sm-8">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    ?>
                    <input id="vente" name="data[<?php echo $model; ?>][vente]" value="detail" type="hidden">
                    <div class="form-group">
                        <label for="asas"></label>
                        <div class="col-sm-10">
                            <input type="radio" class="recalculer_par_typeclient" name="data[<?php echo $model; ?>][typeclient_id]" id="Assujettis" value="1" checked>Assujettis
                            <input type="hidden" class="recalculer_par_typeclient" name="data[<?php echo $model; ?>][typeclient_id]" id="Assujettis1" value="1" checked>
                            <input type="radio" class="recalculer_par_typeclient" name="data[<?php echo $model; ?>][typeclient_id]" id="Exoneres" value="2">Exonérés
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="data[<?php echo $model; ?>][vent]" id="optionsRadios11" value="detail">Detail
                            <input type="radio" name="data[<?php echo $model; ?>][vent]" id="optionsRadios12" value="gros">Gros
							<!--<input type="radio" name="data[<?php /*echo $model; */?>][vent]" id="optionsRadios11" value="detail" <?php /*if(=='detail'){*/?> checked="checked"<?php /*} */?> >Detail
							<input type="radio" name="data[<?php /*echo $model; */?>][vent]" id="optionsRadios12" value="gros" <?php /*if(=='gros'){*/?> checked="checked"<?php /*} */?> >Gros
                     -->   </div>
                    </div>
                       <div class="form-group">
                        <label for="asas"></label>
                        <div class="col-sm-10">
                            <input type="radio" class="recalculer_par_typefodec" name="data[<?php echo $model; ?>][typefodec]"  id="avecfodec" value="avecfodec" checked>Fodec
                             <input type="radio" class="recalculer_par_typefodec" name="data[<?php echo $model; ?>][typefodec]"  id="sansfodec" value="sansfodec">Sans Fodec
             <input type="hidden"   name="data[<?php echo $model; ?>][typefodec]" id="typefodec" value="avecfodec" checked>

                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" class="recalculer_par_typetimbre"   name="data[<?php echo $model; ?>][typetimbre]" id="timbre1" value="avectimbre" checked>Timbre
                            <input type="radio" class="recalculer_par_typetimbre"  name="data[<?php echo $model; ?>][typetimbre]" id="timbre2" value="sanstimbre">Sans Timbre 
                            
         <input type="hidden"  name="data[<?php echo $model; ?>][typetimbre]" id="typetimbre" value="avectimbre" checked>

							<!--<input type="radio" name="data[<?php /*echo $model; */?>][vent]" id="optionsRadios11" value="detail" <?php /*if(=='detail'){*/?> checked="checked"<?php /*} */?> >Detail
							<input type="radio" name="data[<?php /*echo $model; */?>][vent]" id="optionsRadios12" value="gros" <?php /*if(=='gros'){*/?> checked="checked"<?php /*} */?> >Gros
                     -->   </div>
                    </div>
                </div>
				<div class="message" style="color: red;" align="center"></div>

                <?php


                //debug($model);die;
                $w1=12;$w2=17;$w3=0;
                if($model=='Factureclient' || $model == 'Bonlivraison'){
                    $w1=10;
                    $w2=14;
                    $w3=5;
                }
                ?>
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
                            <td align="center" nowrap="nowrap" width="5%"> Qte </td>
                            <?php if($model=='Factureclient'  ){ ?>
                            <td style="display: none;" align="center" nowrap="nowrap" width="0%">Prix achat</td>
<!--                            <td align="center" nowrap="nowrap" width="<?php /*echo $w3; */?>%">Marge</td>
-->                            <?php } ?>
                            <td align="center" nowrap="nowrap" width="9%">PUHT</td>
                            <td align="center" nowrap="nowrap" width="7%">Rem</td>
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
                            <td width="1%" id="" champ="tdaff" index="">
                                <span title="Nouveau Article Composé" champ="nouveauart"></span>
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
                           //codeselect setQuerycode         ?>
                                    <?php echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ', 'type' => 'text'));
                                    ?>
									<div id="res" champ="rescode" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                </div>
                            </td>
                            <td width="<?php echo $w2; ?>%">
                                <div class="" style="display:inline; position: relative;">
                                    <?php echo $this->Form->input('designation', array('div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text'));
                                    ?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                </div>
                            </td>

                            <td width="5%">
                                <?php echo $this->Form->input('quantite', array('value'=>'1','div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte calculefacture ')); ?>
                                <?php echo $this->Form->input('pmp', array('type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'pmp', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>

                            </td>
                            <?php if($model=='Factureclient'){ ?>
                            <!--<td width="<?php /*echo $w3; */?>%">-->
                                <?php
                                echo $this->Form->input('prixachatmarge', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixachatmarge', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                echo $this->Form->input('margebase', array('type' => 'hidden','div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'margebase','between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control changerprix calculefacture'));
                                echo $this->Form->input('margebaseorigine', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'margebaseorigine', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                ?>
                        <!--    </td>-->
                            <?php } ?>
                            <td width="9%">
                                <?php
                                echo $this->Form->input('prixachat', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixachat', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                echo $this->Form->input('prix', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixhtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeinverseputtc changerprix'));
                                ?>
                            </td>
                            <td width="7%">
                                <?php
                                echo $this->Form->input('remise', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeprix_net_ttc changerprix calculefacture'));
                                echo $this->Form->input('remiseans', array('type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'remiseans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                ?>
                            </td>
                            <td width="9%">
                                <?php echo $this->Form->input('prixnet', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixnet', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeremisenet changerprix')); ?>
                            </td>
                            <td width="9%">
                                <?php
                                echo $this->Form->input('puttc', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'puttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeprixvente changerprix'));
                                echo $this->Form->input('totalhtans', array('div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'totalhtans', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                ?>
                            </td>
                            <td width="9%">
                                <?php echo $this->Form->input('totalht', array('div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'totalht', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                            </td>
                            <td width="5%">
                                <?php echo $this->Form->input('tva', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacture')); ?>
                                <?php echo $this->Form->input('tva', array('type'=>'hidden','div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'tva1',  'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                            </td>
                            <td width="9%">
                                <?php echo $this->Form->input('totalttc', array('readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'totalttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                            </td>
                            <td width="5%">
                                <?php echo $this->Form->input('depotcomposee', array('name' => '', 'id' => '', 'champ' => 'depotcomposee', 'table' => $tablesemi, 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                <?php echo $this->Form->input('qtevendu', array('name' => '', 'id' => '', 'champ' => 'qtevendu', 'table' => $tablesemi, 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                <?php echo $this->Form->input('type', array('value' => 0, 'name' => '', 'id' => '', 'champ' => 'type', 'table' => $tablesemi, 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                <?php echo $this->Form->input('sup', array('name' => '', 'id' => '', 'champ' => 'sup', 'table' => $tablesemi, 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                <?php echo $this->Form->input('quantitestock', array('readonly' => 'readonly', 'label' => '', 'div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => 'quantitestock', 'champ' => 'quantitestock', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                            </td>

                            <td width="1%" id="" champ="tdaff" index="" >
                                <i index=""  class="fa fa-times supp1" style="color: #c9302c;font-size: 15px;"/>
                            </td>

                        </tr>
        <!--                <tr class="cc0 testclientvide" >

                            <td id="tdaff0" >
                                <span title="Ancien prix"><a style="display:none;" onclick="recap_rapport(0)" href="#reModal_refuser" champ="order" id="order0" value="0" <button class='  '><i class='fa fa-arrows'></i></a></span>
                            </td>
                            <td >
                                <span champ="num" id="num0" index="0">1</span>
                            </td>
                            <td  class="" index="0">
                        <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient][0][article_id]','table' => $tablesemi,'index'=>'0','id'=>'article_id0','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select  articleidbl','empty'=>'Veuillez Choisir !!') );  ?>
                                <div class="" style="display:inline; position: relative;">
                        <?php
                        echo $this->Form->input('article_id', array('div' => 'form-group', 'name' => 'data[' . $tablesemi . '][0][article_id]', 'table' => $tablesemi, 'index' => '0', 'id' => 'article_id0', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                        echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => 'data[' . $tablesemi . '][0][code]', 'table' => $tablesemi, 'index' => '0', 'id' => 'code0', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control alicode', 'type' => 'text'));
                        ?>
                                </div>
                            </td>
                            <td>
                                <div class="" style="display:inline; position: relative;">
                        <?php echo $this->Form->input('designation', array('div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => 'data[' . $tablesemi . '][0][designation]', 'table' => $tablesemi, 'index' => '0', 'id' => 'designation0', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                    <div id="res0" champ="res" index="0"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                </div>
                            </td>
                             <td >
                        <?php echo $this->Form->input('quantite', array('label' => '', 'div' => 'form-group', 'name' => 'data[Lignefactureclient][0][quantite]', 'table' => $tablesemi, 'index' => '0', 'id' => 'quantite0', 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte   calculefacture ')); ?>
                            </td>
                            <td >
                        <?php echo $this->Form->input('prixachat', array('div' => 'form-group', 'label' => '', 'name' => 'data[Lignefactureclient][0][prixachat]', 'table' => $tablesemi, 'index' => '0', 'id' => 'prixachat0', 'champ' => 'prixachat', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                        <?php echo $this->Form->input('prix', array('div' => 'form-group', 'label' => '', 'name' => 'data[Lignefactureclient][0][prixhtva]', 'table' => $tablesemi, 'index' => '0', 'id' => 'prixhtva0', 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeinverseputtc')); ?>
                            </td>
                            <td >
                        <?php
                        echo $this->Form->input('remise', array('div' => 'form-group', 'label' => '', 'name' => 'data[Lignefactureclient][0][remise]', 'table' => $tablesemi, 'index' => '0', 'id' => 'remise0', 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeprix_net_ttc calculefacture'));
                        echo $this->Form->input('remiseans', array('type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignefactureclient][0][remiseans]', 'table' => $tablesemi, 'index' => '0', 'id' => 'remiseans0', 'champ' => 'remiseans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  '));
                        ?>
                            </td>
                             <td>
                        <?php echo $this->Form->input('prixnet', array('div' => 'form-group', 'label' => '', 'name' => 'data[Lignefactureclient][0][prixnet]', 'table' => $tablesemi, 'index' => '0', 'id' => 'prixnet0', 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeremisenet')); ?>
                            </td>
                            <td >
                        <?php
                        echo $this->Form->input('puttc', array('div' => 'form-group', 'label' => '', 'name' => 'data[Lignefactureclient][0][puttc]', 'table' => $tablesemi, 'index' => '0', 'id' => 'puttc0', 'champ' => 'puttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeprixvente'));
                        echo $this->Form->input('totalhtans', array('type' => 'hidden', 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[Lignefactureclient][0][totalhtans]', 'table' => $tablesemi, 'index' => '0', 'id' => 'totalhtans0', 'champ' => 'totalhtans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                        ?>
                            </td>
                            <td >
                        <?php echo $this->Form->input('totalht', array('div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[Lignefactureclient][0][totalht]', 'table' => $tablesemi, 'index' => '0', 'id' => 'totalht0', 'champ' => 'totalht', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                            </td>
                            <td >
                        <?php echo $this->Form->input('tva', array('div' => 'form-group', 'label' => '', 'name' => 'data[Lignefactureclient][0][tva]', 'table' => $tablesemi, 'index' => '0', 'id' => 'tva0', 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacture')); ?>
                        <?php echo $this->Form->input('tva', array('type'=>'hidden','div' => 'form-group', 'label' => '', 'name' => 'data[Lignefactureclient][0][tva1]', 'table' => $tablesemi, 'index' => '0', 'id' => 'tva10', 'champ' => 'tva1',  'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                            </td>
                            <td >
                        <?php echo $this->Form->input('totalttc', array('readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignefactureclient][0][totalttc]', 'table' => $tablesemi, 'index' => '0', 'id' => 'totalttc0', 'champ' => 'totalttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                            </td>
                            <td >
                        <?php echo $this->Form->input('depotcomposee', array('name' => 'data[Lignefactureclient][0][depotcomposee]', 'id' => 'depotcomposee0', 'champ' => 'depotcomposee', 'table' => $tablesemi, 'index' => '0', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                        <?php echo $this->Form->input('qtevendu', array('name' => 'data[Lignefactureclient][0][qtevendu]', 'id' => 'qtevendu0', 'champ' => 'qtevendu', 'table' => $tablesemi, 'index' => '0', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control')); ?>
                        <?php echo $this->Form->input('type', array('value' => 0, 'name' => 'data[Lignefactureclient][0][type]', 'id' => 'type0', 'champ' => 'type', 'table' => $tablesemi, 'index' => '0', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control')); ?>
                        <?php echo $this->Form->input('sup', array('name' => 'data[Lignefactureclient][0][sup]', 'id' => 'sup0', 'champ' => 'sup', 'table' => $tablesemi, 'index' => '0', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                        <?php echo $this->Form->input('quantitestock', array('readonly' => 'readonly', 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignefactureclient][0][quantitestock]', 'table' => $tablesemi, 'index' => '0', 'id' => 'quantitestock0', 'champ' => 'quantitestock', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                            </td>
                            <td id="tdaff0" >
                            <i index="0"  class="fa fa-times supp1" style="color: #c9302c;font-size: 15px;"/>
                            </td>
                        </tr>-->
                    </tbody>
                </table>

                <input type="hidden" value="0" id="index" />
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
                    echo $this->Form->input('totalht', array('label' => 'Total HT', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_HT', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('remise', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'remise', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('fodec', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'fodec', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('fodeca', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'fodeca', 'class' => 'form-control inputspcial'));
                    ?>
                    <div class="form-group">
                        <label for="ttfodec" class="col-md-2 control-label">Fodec :<span id="fodecspan"></span></label>
                        <div class="col-sm-10">
                            <input name="data[<?php echo $model; ?>][ttfodec]" readonly="readonly" id="ttfodec" class="form-control inputspcial" type="text">
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
                        echo $this->Form->input('marge', array('type'=>'hidden','div' => 'form-group', 'between' => '<div class="col-sm-10">', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'marge', 'class' => 'form-control inputspcial'));
                    }
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                    echo $this->Form->input('tva', array('label' => 'TVA', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'tva', 'class' => 'form-control inputspcial'));
                    if ($model == "Factureclient" || $model == "Devi") {
                        echo $this->Form->input('timbre_id', array('div' => 'form-group', 'value' => $timbre, 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'timbre', 'champ' => 'timbre', 'class' => 'form-control inputspcial'));
                                      echo $this->Form->input('timbre', array('label' => 'TVA', 'value' => $timbre, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'timbrea', 'class' => 'form-control '));
  }else{
                        echo $this->Form->input('timbre_id', array('div' => 'form-group', 'value' => 0, 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'timbre', 'champ' => 'timbre', 'class' => 'form-control inputspcial'));
                                     echo $this->Form->input('timbre', array('label' => 'TVA', 'value' =>0, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'timbrea', 'class' => 'form-control '));
   }
                    echo $this->Form->input('retenue', array('type' => 'hidden', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'retenue', 'class' => 'form-control inputspcial'));
                    ?>
                    <div class="form-group">
                        <label for="ttretenue" class="col-md-2 control-label">Retenue :<span id="retenuespan"></span></label>
                        <div class="col-sm-10">
                            <input name="data[<?php echo $model; ?>][ttretenue]" readonly="readonly" id="ttretenue" class="form-control inputspcial" type="text">
                        </div>
                    </div><?php
//                    echo $this->Form->input('ttretenue', array('label'=>'Retenue','div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'ttretenue', 'class' => 'form-control inputspcial'));
                    ?>

                </div>
                <div class="col-md-3">
                    <?php
                    echo $this->Form->input('totalttc', array('label' => 'NET à payer', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('newtotalttc', array('label' => 'NET TTC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'New_Total_TTC', 'class' => 'form-control inputspcial newtotalttc'));
                    ?>
                    <input id="vente" name="data[<?php echo $model; ?>][auto]" value="automatique" type="hidden">
                    <?php if ($model != 'Factureclient') { ?>
                        <div class="form-group">
                            <label for="automatique">Facturation :</label>
                            <div class="col-sm-10">
                                <input type="radio" name="data[<?php echo $model; ?>][auto]" id="optionRadios11" value="automatique" >Automatique
                                <input type="radio" name="data[<?php echo $model; ?>][auto]" id="optionRadios12" value="non" checked>Non
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-primary  testlignedevente  testpv btnEnregistrerPiece">Enregistrer</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

