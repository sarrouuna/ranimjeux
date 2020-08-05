<script language="JavaScript" type="text/JavaScript">

    function flvFPW1(){

    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    }
</script>
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
<br>
<?php
$p = CakeSession::read('depot');
if ($p == 0) {
    $numspecial = "";
    $mm = "";
}
?>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading not_padinng">
                <h3 class="panel-title taille_titre">
                    <a class="btn btn btn-danger a_color" href="<?php echo $this->webroot; ?>Factureavoirfrs/index"/> <i class="fa fa-reply"></i> Retour </a>
                    <strong><?php echo __('Ajout Facture Avoir'); ?></strong>
                </h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Factureavoirfr', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>
                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('page', array('value' => 'factureavoirfr', 'id' => 'page', 'type' => 'hidden', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    if ($p == 0) {
                        echo $this->Form->input('pointdevente_id', array('id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select numspecial inputspcial'));
                    }
                    echo $this->Form->input('depot_id', array('label' => 'Depot', 'div' => 'form-group', 'id' => 'depot_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select inputspcial', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('fournisseur_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    ?></div><div class="col-md-6"><?php
                    echo $this->Form->input('numeroconca', array('id' => 'numeroconca', 'type' => 'hidden', 'value' => $mm, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('model', array('id' => 'model', 'type' => 'hidden', 'value' => 'Factureavoirfr', 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('typefacture_id', array('value' => 1, 'label' => 'Type facture', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'typefacture_id', 'class' => 'form-control select typefactureans inputspcial', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' => date("d/m/Y"), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly inputspcial'));
                    echo $this->Form->input('numero', array('id' => 'numero', 'value' => $numspecial, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    ?>
                </div>  


                <!-- Autre ligne facture avoir-->

                <table class="table table-bordered table-striped table-bottomless tablejdid scrollh" id="addtable" style="width:100%" align="center" >
                    <thead>
                        <tr class="entetetab" style="background-color: #c6b9b9;">
                            <td align="center" nowrap="nowrap" width="30%">Article</td>
                            <td align="center" nowrap="nowrap" width="6%">stock</td>
                            <td align="center" nowrap="nowrap" width="6%"> Qte </td>
                            <td align="center" nowrap="nowrap" width="10%">PUHT</td>    
                            <td align="center" nowrap="nowrap" width="6%">Rem</td>
                            <td align="center" nowrap="nowrap" width="9%">PNHT</td>
                            <td align="center" nowrap="nowrap" width="9%">PUTTC</td> 
                            <td align="center" nowrap="nowrap" width="9%">HT</td>
                            <td align="center" nowrap="nowrap" width="4%">TVA</td>
                            <td align="center" nowrap="nowrap" width="9%">TTC</td>
                            <td align="center" width="2%">
                                <a class="btn btn-danger ajouterligne_livraison1" table='addtable' index='index'  tr="tr" style="
                                   padding: 0px 6px;
                                   "><i class="fa fa-plus-circle"  ></i> </a> 
                            </td>
                        </tr>
                    </thead>
                    <?php $tablesemi = 'Lignefactureclient'; ?>
                    <tbody>


                        <tr class="tr " style="display:none;" >
<!--                            <td   width="11%">
                            <?php // echo $this->Form->input('depot_id', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignefactureclient', 'index' => '', 'id' => '', 'champ' => 'depot_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control uniform_select depot_qte_s testclientvide', 'empty' => 'Veuillez Choisir !!'));   ?>
                            </td>-->
                            
                            <td style="width:30%">
                                <!--                                        --><?php /* echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'article_id','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control articleidbl','empty'=>'Veuillez Choisir !!') ); */ ?>
                                <div class="" style="display:inline; position: relative;">
                                    <?php
                                    echo $this->Form->input('article_id', array('div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                    echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                    ?>
                                    <!--                                            style="background-color:white;position: absolute; top: -10px;right: -500px; width:500px;z-index: 1000px;"-->
                                    <!--                                            onMouseOut="this.style.visibility = 'hidden';"-->
                                </div>

                            </td>
                            <td style="width:6%">
                                <?php echo $this->Form->input('sup', array('name' => '', 'id' => '', 'champ' => 'sup', 'table' => 'Lignefactureclient', 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                <?php echo $this->Form->input('quantitestock', array('readonly' => 'readonly', 'label' => '', 'div' => 'form-group', 'name' => '', 'table' => 'Lignefactureclient', 'index' => '', 'id' => 'quantitestock', 'champ' => 'quantitestock', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                            </td>

                            <td style="width:6%">
                                <?php echo $this->Form->input('quantite', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignefactureclient', 'index' => '', 'id' => '', 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte calculefacture  verifstock')); ?>
                            </td>
                            <td style="width:10%">
                                <?php
                                echo $this->Form->input('prixachat', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => '', 'index' => '', 'id' => '', 'champ' => 'prixachat', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                echo $this->Form->input('prix', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignefactureclient', 'index' => '', 'id' => '', 'champ' => 'prixhtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeinverseputtc'));
                                ?>
                            </td>
                            <td style="width:6%">
                                <?php
                                echo $this->Form->input('remise', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignefactureclient', 'index' => '', 'id' => '', 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeprix_net_ttc calculefacture'));
                                echo $this->Form->input('remiseans', array('type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignefactureclient', 'index' => '', 'id' => '', 'champ' => 'remiseans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                ?>
                            </td>
                            <td style="width:9%">
                                <?php echo $this->Form->input('prixnet', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignefactureclient', 'index' => '', 'id' => '', 'champ' => 'prixnet', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeremisenet')); ?>
                            </td>
                            <td style="width:9%">
                                <?php
                                echo $this->Form->input('puttc', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignefactureclient', 'index' => '', 'id' => '', 'champ' => 'puttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeprixvente'));
                                echo $this->Form->input('totalhtans', array('div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => '', 'table' => 'Lignefactureclient', 'index' => '', 'id' => '', 'champ' => 'totalhtans', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                ?>
                            </td>
                            <td style="width:9%">
                                <?php echo $this->Form->input('totalht', array('div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => '', 'table' => 'Lignefactureclient', 'index' => '', 'id' => '', 'champ' => 'totalht', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                            </td>
                            <td style="width:4%">
                                <?php echo $this->Form->input('tva', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignefactureclient', 'index' => '', 'id' => '', 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacture')); ?>
                            </td>
                            <td style="width:9%">
                                <?php echo $this->Form->input('totalttc', array('readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignefactureclient', 'index' => '', 'id' => '', 'champ' => 'totalttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                            </td>

                            <td align="right" style="width:2%"><i index=""  class="fa fa-times supp1" style="color: #c9302c;font-size: 22px;"></td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" value="0" id="index" />
                <div class="favrchmps col-md-4" style="display:yes;">                  
                    <?php
                    echo $this->Form->input('remise', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'remise', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('tva', array('label' => 'TVA', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'tva', 'class' => 'form-control inputspcial'));
                    //echo $this->Form->input('timbre_id',array('div'=>'form-group','value'=>$timbre,'between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'timbre','champ'=>'timbre','class'=>'form-control') );
                    ?>
                </div>
                <div class="col-md-4"><div class="favrchmpss" style="display:yes;"> <?php
                    echo $this->Form->input('totalht', array('label' => 'Total HT', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_HT', 'class' => 'form-control inputspcial'));
                    ?></div><?php echo $this->Form->input('totalttc', array('label' => 'Total TTC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control inputspcial'));
                    ?>
                </div>            
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-primary testpv">Enregistrer</button>
                        </div>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
</div>

