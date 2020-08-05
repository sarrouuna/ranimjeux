


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
<input type="hidden" value="0" id="testindex" />
<input type="hidden" value="testhelmi" id="page" />
<?php
$p = CakeSession::read('pointdevente');
if ($p == 0) {
    $numspecial = "";
}
?>
<div class="row" >
    <div class="col-md-12" >
        <?php echo $this->Form->create('Factureavoirfr', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>
        <div class="panel panel-default">
            <div class="panel-heading not_padinng">
                <div class="row">
                    <div class="col-xs-6 text-left pull-left">
                        <div class="panel-title taille_titre ">
                            <a class="btn btn btn-danger a_color" href="<?php echo $this->webroot; ?>Factureavoirfrs/index"/> <i class="fa fa-reply"></i> Retour </a>
                            <strong ><?php echo __('Ajout Facture avoir libre'); ?></strong>
                        </div>
                    </div>

                </div>

            </div>
            <div class="panel-body not_height">

                <div class="col-md-4" >                  
                    <?php
                    echo $this->Form->input('id', array('id' => 'id' ,'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('pointdevente_id', array('id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select numspecial inputspcial fodec_retenue'));
                    echo $this->Form->input('action', array('id' => 'action', 'type' => 'hidden', 'value' => 'add', 'div' => 'form-group', 'type' => 'hidden', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('numeroconca', array('id' => 'numeroconca', 'type' => 'hidden', 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('model', array('id' => 'model', 'type' => 'hidden', 'value' => 'Factureavoirfr', 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('numero', array('id' => 'numero', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('numerofrs', array('label'=>'Numero Fournisseur','id' => 'numerofrs', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('fournisseur_id', array('empty' => 'veuillez choisir','id' => 'fournisseur_id','div' => 'form-group ', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select inputspcial'));
                    echo $this->Form->input('depot_id', array('id' => 'depot_id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select depot_qte_s inputspcial', 'empty' => 'Veuillez Choisir !!'));
                    ?>
                    
                </div>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' => date("d/m/Y", strtotime(str_replace('/', '-', $this->request->data['Factureavoirfr']['date']))), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly inputspcial'));
                    echo $this->Form->input('datedeclaration', array('label'=>'date déclaration','div' => 'form-group', 'value' =>date("d/m/Y", strtotime(str_replace('/', '-', $this->request->data['Factureavoirfr']['datedeclaration']))), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly inputspcial'));
                    ?>
                    
                </div>
                
                <div class="clear"></div>              
                <table class="table table-bordered table-striped table-bottomless tablejdid scrollh " id="addtable" style="width:100%" align="center" >
                    <thead>
                        <tr class="entetetab" style="background-color: #c6b9b9;">
                            
                            <td align="center" nowrap="nowrap" width="1%" ></td>
                            <td align="center" nowrap="nowrap" width="1%" ></td>
                            <td align="center" nowrap="nowrap" width="10%">code</td>
                            <td align="center" nowrap="nowrap" width="15%">Article</td>
                            <td align="center" nowrap="nowrap" width="5%"> Qte </td>
                            <td align="center" nowrap="nowrap" width="5%">Marge</td>
                            <td align="center" nowrap="nowrap" width="7%">PUHT</td>    
                            <td align="center" nowrap="nowrap" width="7%">Rem</td>
                            <td align="center" nowrap="nowrap" width="7%">PNHT</td>
                            <td align="center" nowrap="nowrap" width="8%">PUTTC</td> 
                            <td align="center" nowrap="nowrap" width="9%">HT</td>
                            <td align="center" nowrap="nowrap" width="5%">Fodec</td>
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
                            <td width="1%">
                                <span champ="num"></span>
                            </td>
                            <td width="10%">
                                <div class="autocomplete" style="width:100%;">
                                    <?php
                                    echo $this->Form->input('article_id', array('div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                    echo $this->Form->input('code', array('yourid'=>'article_id','div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  code_manuel_autocomplete ', 'type' => 'text'));
                                    ?>
                                </div>
                            </td>
                            <td width="15%">
                                <div class="autocomplete" style="width:100%;">
                                    <?php 
                                    echo $this->Form->input('designation', array('yourid'=>'article_id','div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control designation_manuel_autocomplete ', 'type' => 'text'));
                                    ?>
                                </div>
                            </td>

                            <td width="5%">
                                <?php echo $this->Form->input('quantite', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte calculfactureamine')); ?>
                                <?php echo $this->Form->input('pmp', array('type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'pmp', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>

                            </td>
                            <td width="5%">
                                <?php
                                echo $this->Form->input('prixachatmarge', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixachatmarge', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                echo $this->Form->input('margebase', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'margebase', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control changerprix calculfactureamine'));
                                echo $this->Form->input('margebaseorigine', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'margebaseorigine', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                ?>
                            </td>

                            <td width="7%">
                                <?php
                                echo $this->Form->input('prixachat', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixachat', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                echo $this->Form->input('prix', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixhtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeinverseputtc changerprix'));
                                ?>
                            </td>
                            <td width="7%">
                                <?php
                                echo $this->Form->input('remise', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeprix_net_ttc changerprix calculfactureamine'));
                                echo $this->Form->input('remiseans', array('type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'remiseans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                ?>
                            </td>
                            <td width="7%">
                                <?php echo $this->Form->input('prixnet', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixnet', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeremisenet changerprix')); ?>
                            </td>
                            <td width="8%">
                                <?php
                                echo $this->Form->input('puttc', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'puttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeprixvente changerprix'));
                                echo $this->Form->input('totalhtans', array('div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'totalhtans', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                ?>
                            </td>
                            <td width="9%">
                                <?php echo $this->Form->input('totalht', array('div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'totalht', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                            </td>
                            <td width="5%">
                                <?php echo $this->Form->input('fodec', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'fodec', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculfactureamine')); ?>
                            </td>
                            <td width="5%">
                                <?php echo $this->Form->input('tva', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculfactureamine')); ?>
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
                        <?php
                        //debug($lignefactures);die;
                        foreach ($lignefactures as $i => $l) {
//                            debug($l);
//                            die;
                            $qtestock = 0;
                            $i = $i + 1;
                                $objStockdepot = ClassRegistry::init('Stockdepot');
                                $stock = $objStockdepot->find('first', array('conditions' => array('Stockdepot.article_id' => $l['Lignefactureavoirfr']['article_id'],
                                        'Stockdepot.depot_id' => $this->request->data['Factureavoirfr']['depot_id']), 'fields' => array('ifnull(sum(Stockdepot.quantite),0) as qte')));
                                $qtestock = $stock[0]['qte'] + $l['Lignefactureavoirfr']['quantite'];
                            ?>
                            <tr class="cc<?php echo $i; ?> testclientvide" >
                                <td width="1%" id="nv-art<?php echo $i; ?>" champ="nv-art" index="<?php echo $i; ?>" > 
                                   
                                </td>

                                
                                <td width="1%">
                                    <span champ="num" id="num<?php echo $i; ?>" index="<?php echo $i; ?>"><?php echo $i; ?></span>
                                </td>
                                <td width="10%"  class="" index="<?php echo $i; ?>">

                                    <div class="" style="display:inline; position: relative;">
                                        <?php
                                        echo $this->Form->input('article_id', array('value' => $l['Article']['id'], 'div' => 'form-group', 'name' => 'data[' . $tablesemi . '][' . $i . '][article_id]', 'table' => $tablesemi, 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                                    echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control alicode', 'type' => 'text'));
                                        ?>
                                        <?php echo $this->Form->input('code', array('value' => $l['Article']['code'], 'div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control codeselect setQuerycode', 'type' => 'text'));
                                        ?><div id="res" champ="rescode" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>

                                    </div>
                                </td>
                                <td width="15%">
                                    <div class="" style="display:inline; position: relative;">
                                        <?php echo $this->Form->input('designation', array('onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => $l['Article']['name'], 'div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][designation]', 'table' => $tablesemi, 'index' => $i, 'id' => 'designation' . $i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                        <div id="res<?php echo $i; ?>" champ="res" index="<?php echo $i; ?>"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                    </div>
                                </td>
                                <td width="5%">
                                    <?php
                                    echo $this->Form->input('quantite', array('value' => $l['Lignefactureavoirfr']['quantite'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'label' => '', 'div' => 'form-group', 'name' => 'data[' . $tablesemi . '][' . $i . '][quantite]', 'table' => $tablesemi, 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte   calculfactureamine'));
                                    ?>

                                </td>
                                <?php
                                //debug($l);die;
                                $margeorigine = $l['Article']['marge'];
//                                if ($l['Factureavoir']['vente'] == 'detail') {
//                                    $margeorigine = $l['Article']['marge'];
//                                }
                                ?>
                                <td width="5%">
                                    <?php
                                    echo $this->Form->input('prixachatmarge', array('value' => $l['Article']['coutrevient'], 'name' => 'data[' . $tablesemi . '][' . $i . '][prixachatmarge]', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'prixachatmarge' . $i, 'champ' => 'prixachatmarge', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                    echo $this->Form->input('margebase', array('div' => 'form-group', 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => $l['Article']['marge'], 'name' => 'data[' . $tablesemi . '][' . $i . '][margebase]', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'margebase' . $i, 'champ' => 'margebase', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control changerprix calculfactureamine'));
                                    echo $this->Form->input('margebaseorigine', array('div' => 'form-group', 'value' => $margeorigine, 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'margebaseorigine' . $i, 'name' => 'data[' . $tablesemi . '][' . $i . '][margebaseorigine]', 'champ' => 'margebaseorigine', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                    ?>
                                </td>

                                <td width="7%">
                                    <?php echo $this->Form->input('pmp', array('value' => @$l['Lignefactureavoirfr']['pmp'], 'type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][pmp]', 'table' => $tablesemi, 'index' => $i, 'id' => 'pmp' . $i, 'champ' => 'pmp', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control changerprix'));
                                    ?>
                                    <?php echo $this->Form->input('prixachat', array('div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][prixachat]', 'table' => $tablesemi, 'index' => $i, 'id' => 'prixachat' . $i, 'champ' => 'prixachat', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control changerprix')); ?>
                                    <?php echo $this->Form->input('prix', array('onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => $l['Lignefactureavoirfr']['prix'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][prixhtva]', 'table' => $tablesemi, 'index' => $i, 'id' => 'prixhtva' . $i, 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeinverseputtc changerprix')); ?>
                                </td>
                                <td width="7%">
                                    <?php
                                    echo $this->Form->input('remise', array('onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => $l['Lignefactureavoirfr']['remise'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][remise]', 'table' => $tablesemi, 'index' => $i, 'id' => 'remise' . $i, 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeprix_net_ttc changerprix calculfactureamine'));
                                    echo $this->Form->input('remiseans', array('type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][remiseans]', 'table' => $tablesemi, 'index' => $i, 'id' => 'remiseans' . $i, 'champ' => 'remiseans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  '));
                                    ?>
                                </td>
                                <td width="7%">
                                    <?php echo $this->Form->input('prixnet', array('onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => @$l['Lignefactureavoirfr']['prixnet'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][prixnet]', 'table' => $tablesemi, 'index' => $i, 'id' => 'prixnet' . $i, 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeremisenet changerprix')); ?>
                                </td>
                                <td  width="8%">
                                    <?php
                                    echo $this->Form->input('puttc', array('onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'value' => @$l['Lignefactureavoirfr']['puttc'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][puttc]', 'table' => $tablesemi, 'index' => $i, 'id' => 'puttc' . $i, 'champ' => 'puttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeprixvente changerprix'));
                                    echo $this->Form->input('totalhtans', array('value' => @$l['Lignefactureavoirfr']['totalhtans'], 'type' => 'hidden', 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[' . $tablesemi . '][' . $i . '][totalhtans]', 'table' => $tablesemi, 'index' => $i, 'id' => 'totalhtans' . $i, 'champ' => 'totalhtans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                    ?>
                                </td>
                                <td width="9%">
                                    <?php echo $this->Form->input('totalht', array('value' => $l['Lignefactureavoirfr']['totalht'], 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[' . $tablesemi . '][' . $i . '][totalht]', 'table' => $tablesemi, 'index' => $i, 'id' => 'totalht' . $i, 'champ' => 'totalht', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                </td>
                                <td width="5%">
                                    <?php echo $this->Form->input('lfodec', array('value' => $l['Lignefactureavoirfr']['fodec'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][fodec]', 'table' => $tablesemi, 'index' => $i, 'id' => 'fodec' . $i, 'champ' => 'fodec', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculfactureamine')); ?>
                                </td>
                                <td width="5%">
                                    <?php echo $this->Form->input('tva', array('value' => $l['Lignefactureavoirfr']['tva'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][tva]', 'table' => $tablesemi, 'index' => $i, 'id' => 'tva' . $i, 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculfactureamine')); ?>
                                </td>
                                <td width="9%">
                                    <?php echo $this->Form->input('totalttc', array('value' => $l['Lignefactureavoirfr']['totalttc'], 'readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][totalttc]', 'table' => $tablesemi, 'index' => $i, 'id' => 'totalttc' . $i, 'champ' => 'totalttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                </td>
                                <td width="5%">
                                    <?php //echo $this->Form->input('depotcomposee', array('name' => 'data[' . $tablesemi . '][' . $i . '][depotcomposee]', 'value' => $l['Lignefactureavoirfr']['depotcomposee'], 'id' => 'depotcomposee' . $i, 'champ' => 'depotcomposee', 'table' => $tablesemi, 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                    <?php //echo $this->Form->input('type', array('name' => 'data[' . $tablesemi . '][' . $i . '][type]', 'value' => $l['Lignefactureavoirfr']['composee'], 'id' => 'type' . $i, 'champ' => 'type', 'table' => $tablesemi, 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                    <?php echo $this->Form->input('id', array('value' => $l['Lignefactureavoirfr']['id'], 'name' => 'data[' . $tablesemi . '][' . $i . '][id]', 'id' => 'id' . $i, 'champ' => 'id', 'table' => $tablesemi, 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
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

                <input type="hidden" value="<?php echo $i ; ?>" id="index" />
                <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="pop">


                    </div>
                    <br>
                    <a  class="remodal-confirm ls-light-green-btn btn" ><strong>OK</strong></a>

                </div> 
                
                <div class="col-md-3">
                    <?php
                    echo $this->Form->input('remise', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'remise', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('timbre_id', array('div' => 'form-group','between' => '<div class="col-sm-10">', 'type' => 'text','after' => '</div>', 'id' => 'timbre', 'champ' => 'timbre', 'class' => 'form-control inputspcial calculfactureamine'));
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                    echo $this->Form->input('totalht', array('label' => 'Total HT', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_HT', 'class' => 'form-control inputspcial'));
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                    echo $this->Form->input('fodec', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'fodec', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('tva', array('label' => 'TVA', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'tva', 'class' => 'form-control inputspcial'));
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                    echo $this->Form->input('totalttc', array('label' => 'Total TTC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control inputspcial'));
                    ?>
                </div>



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
                <div class="col-lg-6 col-lg-offset-3">
                    <button type="submit" class="btn btn-primary testpv testmontanttotaleimputationfr">Enregistrer</button>
                </div>
            </div> 
        </div>

        <?php echo $this->Form->end(); ?>
    </div>
</div>

