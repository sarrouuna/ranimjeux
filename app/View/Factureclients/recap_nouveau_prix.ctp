<input type="hidden" id="index_kbira" value="<?php echo $index_kbira; ?>">
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
<?php
if ($articlecomposantes != array()) {
    ?>

            calculefacturef();
            index = $(this).attr('index');
            type = $('#type' + index).val() || 0;
            qte = $('#quantite' + index).val() || 0;
            qtestock = $('#quantitestock' + index).val() || 0;
            test_bl(index, qte, qtestock, type);

    <?php
}
?>
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
<?php
$p = CakeSession::read('pointdevente');
if ($p == 0) {
    $numspecial = "";
}
?>
<?php
if ($model == 'Article') {
?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Articles/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<?php
}
?>
<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading not_padinng">
                <h3 class="panel-title taille_titre">
                    <strong><?php echo __('Ajout Composants Article'); ?></strong></h3>
            </div>
            <div class="panel-body ">
                <?php echo $this->Form->create('Article', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-4" >                  
                    <?php
                    echo $this->Form->input('page', array('type' => 'hidden', 'id' => 'page', 'value' => 'recap_nouveau_prix', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));

                    echo $this->Form->input('id', array('value' => @$arts['Article']['id'], 'id' => 'id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('code', array('value' => @$mm, 'id' => 'code', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial articlecode '));
                    echo $this->Form->input('name', array('value' => @$arts['Article']['name'], 'id' => 'des', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('qtevendu', array('value' => @$qtevendu, 'type' => 'text', 'label' => 'Qté vendu', 'id' => 'qtevendu', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('tva', array('value' => @$arts['Article']['tva'], 'label' => 'TVA', 'id' => 'tvaart', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('depot_id', array('value' => @$depot_id, 'id' => 'depot_id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select depot_qte_s inputspcial', 'empty' => 'Veuillez Choisir !!'));
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                    echo $this->Form->input('prixvente', array('type' => 'text', 'readonly' => 'readonly', 'label' => 'Prix HT', 'id' => 'Total_HT', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('prixuttc', array('type' => 'text', 'readonly' => 'readonly', 'label' => 'Prix TTC', 'id' => 'Total_TTC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    ?>
                </div>                    
                <div class="clear"></div>              
                <table class="table table-bordered table-striped table-bottomless tablejdid scrollh" id="addtable" style="width:100%" align="center" >
                    <thead>
                        <tr class="entetetab" style="background-color: #c6b9b9;">
                            <td align="center" nowrap="nowrap" width="1%" ></td>
                            <td align="center" nowrap="nowrap" width="17%">code</td>
                            <td align="center" nowrap="nowrap" width="28%">Article</td>
                            <td align="center" nowrap="nowrap" width="7%"> Qte </td>
                            <td align="center" nowrap="nowrap" width="9%">PUHT</td>    
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
                    <tbody style="height:445px;">
                        <tr class="tr " style="display:none;" >
                            <td width="1%">
                                <span champ="num"></span>
                            </td>
                            <td width="17%">
                                
                                <div class="" style="display:inline; position: relative;">
                                    <?php
                                    echo $this->Form->input('id', array('div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                    echo $this->Form->input('article_id', array('div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                    echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control codeselect', 'type' => 'text'));
                                    ?><div id="res" champ="rescode" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                </div>
                            </td>
                            <td width="28%">
                                <div class="" style="display:inline; position: relative;">
                                    <?php echo $this->Form->input('designation', array('div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text'));
                                    ?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                </div>
                            </td>
                            <td width="7%">
                                <?php echo $this->Form->input('quantite', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calcultvaaa testqte calculefacture')); ?>
                            </td>
                            <td width="9%">
                                <?php
                                echo $this->Form->input('prixachat', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixachat', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                echo $this->Form->input('prix', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixhtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeinverseputtc'));
                                ?>
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
                                <?php echo $this->Form->input('sup', array('name' => '', 'id' => '', 'champ' => 'sup', 'table' => $tablesemi, 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                <?php echo $this->Form->input('quantitestock', array('readonly' => 'readonly', 'label' => '', 'div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => 'quantitestock', 'champ' => 'quantitestock', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                            </td>
                            <td width="1%" id="" champ="tdaff" index="" >
                                <i index=""  class="fa fa-times supp1" style="color: #c9302c;font-size: 15px;"/>
                            </td>

                        </tr>
                        <?php
                        if ($articlecomposantes != array()) {
                            foreach ($articlecomposantes as $k => $articlecomposante) {
                                ?>
                                <tr class="cc<?php echo $k; ?> testclientvide"  >


                                    <td width="1%">
                                        <span champ="num" id="num<?php echo $k; ?>" index="<?php echo $k; ?>"><?php echo $k; ?></span>
                                    </td>
                                    <td width="17%">
                                        <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table' => $tablesemi,'index'=>'','id'=>'article_id','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control articleidbl','empty'=>'Veuillez Choisir !!') );  ?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php
                                            echo $this->Form->input('id', array('value' => $articlecomposante['Articlecomposante']['id'], 'div' => 'form-group', 'name' => 'data[Lignepiece][' . $k . '][id]', 'table' => $tablesemi, 'index' => $k, 'id' => 'id' . $k, 'champ' => 'id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                            echo $this->Form->input('article_id', array('value' => $articlecomposante['Articlecomposante']['composant'], 'div' => 'form-group', 'name' => 'data[Lignepiece][' . $k . '][article_id]', 'table' => $tablesemi, 'index' => $k, 'id' => 'article_id' . $k, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                            echo $this->Form->input('code', array('value' => $articlecomposante['Article']['code'], 'div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => 'data[Lignepiece][' . $k . '][code]', 'table' => $tablesemi, 'index' => $k, 'id' => 'code' . $k, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                            ?>
                                        </div>
                                    </td>
                                    <td width="28%">
                                        <div class="" style="display:inline; position: relative;">
                                            <?php echo $this->Form->input('designation', array('value' => $articlecomposante['Article']['name'], 'div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => 'data[Lignepiece][' . $k . '][designation]', 'table' => $tablesemi, 'index' => $k, 'id' => 'designation' . $k, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text'));
                                            ?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                        </div>
                                    </td>
                                    <td width="7%">
                                        <?php echo $this->Form->input('quantite', array('value' => $articlecomposante['Articlecomposante']['qte'], 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => $k, 'id' => 'quantite' . $k, 'champ' => 'quantite', 'name' => 'data[Lignepiece][' . $k . '][quantite]', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calcultvaaa testqte calculefacture')); ?>
                                    </td>
                                    <td width="9%">
                                        <?php
                                        echo $this->Form->input('prixachat', array('value' => $articlecomposante['Article']['prixachatdevise'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignepiece][' . $k . '][prixachat]', 'table' => $tablesemi, 'index' => $k, 'id' => 'prixachat' . $k, 'champ' => 'prixachat', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                        echo $this->Form->input('prix', array('value' => $articlecomposante['Article']['prixvente'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignepiece][' . $k . '][prixtva]', 'table' => $tablesemi, 'index' => $k, 'id' => 'prixhtva' . $k, 'champ' => 'prixhtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeinverseputtc'));
                                        ?>
                                    </td>
                                    <td width="9%">
                                        <?php
                                        $totalht = $articlecomposante['Articlecomposante']['qte'] * $articlecomposante['Article']['prixvente'];

                                        echo $this->Form->input('puttc', array('value' => $articlecomposante['Article']['prixuttc'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignepiece][' . $k . '][puttc]', 'table' => $tablesemi, 'index' => $k, 'id' => 'puttc' . $k, 'champ' => 'puttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeprixvente'));
                                        echo $this->Form->input('totalhtans', array('value' => number_format($totalht, 3, '.', ''), 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[Lignepiece][' . $k . '][totalhtans]', 'table' => $tablesemi, 'index' => $k, 'id' => 'totalhtans' . $k, 'champ' => 'totalhtans', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                        ?>
                                    </td>
                                    <td width="9%">
                                        <?php
                                        $totalht = $articlecomposante['Articlecomposante']['qte'] * $articlecomposante['Article']['prixvente'];
                                        ?>
                                        <?php echo $this->Form->input('totalht', array('value' => number_format($totalht, 3, '.', ''), 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[Lignepiece][' . $k . '][totalht]', 'table' => $tablesemi, 'index' => $k, 'id' => 'totalht' . $k, 'champ' => 'totalht', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                    </td>
                                    <td width="5%">
                                        <?php echo $this->Form->input('tva', array('value' => $articlecomposante['Article']['tva'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignepiece][' . $k . '][tva]', 'table' => $tablesemi, 'index' => $k, 'id' => 'tva' . $k, 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacture')); ?>
                                    </td>
                                    <td width="9%">
                                        <?php
                                        $totalttc = $articlecomposante['Articlecomposante']['qte'] * $articlecomposante['Article']['prixuttc'];
                                        ?>
                                        <?php echo $this->Form->input('totalttc', array('value' => number_format($totalttc, 3, '.', ''), 'readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignepiece][' . $k . '][totalttc]', 'table' => $tablesemi, 'index' => $k, 'id' => 'totalttc' . $k, 'champ' => 'totalttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                    </td>
                                    <td width="5%">
                                        <?php
                                        $obj = ClassRegistry::init('Stockdepot');
                                        $stock = $obj->find('first', array(
                                            'conditions' => array('Stockdepot.article_id' => $articlecomposante['Articlecomposante']['composant'], 'Stockdepot.depot_id' => @$depot_id),
                                            'recursive' => -1
                                        ));
                                        if ($edit == 1) {
//                                            die;
                                            $stk = $stock['Stockdepot']['quantite'] + $articlecomposante['Articlecomposante']['qte'];
                                        } else {
                                            $stk = @$stock['Stockdepot']['quantite'];
                                        }
//                                        debug($stock);
                                        ?>
                                        <?php echo $this->Form->input('sup', array('name' => 'data[Lignepiece][' . $k . '][sup]', 'id' => 'sup' . $k, 'champ' => 'sup', 'table' => $tablesemi, 'index' => $k, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                        <?php echo $this->Form->input('quantitestock', array('value' => $stk, 'readonly' => 'readonly', 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignepiece][' . $k . '][quantitestock]', 'table' => $tablesemi, 'index' => $k, 'id' => 'quantitestock' . $k, 'champ' => 'quantitestock', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                    </td>
                                    <td width="1%" id="" champ="tdaff" index="<?php echo $k; ?>" >
                                        <i index="<?php echo $k; ?>"  class="fa fa-times supp1" style="color: #c9302c;font-size: 15px;"/>
                                    </td>

                                </tr>
                                <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>
                <?php if ($articlecomposantes != array()) { ?>
                    <input type="hidden" value="<?php echo $k; ?>" id="index" />
                <?php } else { ?>
                    <input type="hidden" value="0" id="index" />
                <?php } ?>
                <div class="form-group">
                    <div class="col-lg-8 col-lg-offset-3">

                        <button type="submit"  class="btn btn-success btnValiderali">Valider</button>
                    </div>



                </div>    
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

