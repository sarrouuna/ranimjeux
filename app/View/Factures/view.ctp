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


<?php
$p = CakeSession::read('pointdevente');
if ($p == 0) {
    $numspecial = "";
}
?>
<input type="hidden" value="commande" id="page" />
<input type="hidden" value="0" id="testindex" />
<input type="hidden" value="0" id="arretfonction" />
<input type="hidden" id="sirine" value="0"> 
<!--<input type="hidden" value="1" id="amine" />-->

<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading not_padinng">
                <h3 class="panel-title taille_titre">
                    <a class="btn btn btn-danger a_color" href="<?php echo $this->webroot . '/' . $model . 's'; ?>/index"/> <i class="fa fa-reply"></i> Retour </a>
                    <strong><?php echo __('Modification ' . $model); ?></strong></h3>
            </div>
            <div class="panel-body not_height">
                <?php echo $this->Form->create($model, array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6" >                  
                    <?php
                    $p = CakeSession::read('pointdevente');
                    //debug($p);
                    echo $this->Form->input('id', array('id' => 'id_fac', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('pointdevente', array('id' => 'pointdevente', 'type' => 'hidden', 'value' => $p, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));

                    //if ($p == 0) {
                        echo $this->Form->input('pointdevente_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select inputspcial'));
                   // }
                    echo $this->Form->input('fournisseur_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'fc', 'class' => 'form-control select inputspcial', 'empty' => 'Veuillez Choisir !!'));
                    //echo $this->Form->input('depot_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'depot_id','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
                    echo $this->Form->input('depot_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'depot_id', 'class' => 'form-control select  inputspcial', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('model', array('id' => 'model', 'type' => 'hidden', 'value' => $model, 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
//                echo $this->Form->input('date',array('div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly inputspcial') );		
                    ?>
                    <div class="fournisseurexterne" style="display:none;" >
                        <?php
                        echo $this->Form->input('coefficient', array('value' => 1, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'coef', 'class' => 'form-control calculcout inputspcial', 'type' => 'text'));
                        ?> 
                    </div>  
                </div>
                <div class="col-md-6">
                    <?php
                    if(!empty($this->request->data[$model]['datedeclaration'])){
                    $datedec=    date("d/m/Y", strtotime(str_replace('/', '-', $this->request->data[$model]['datedeclaration'])));
                    }else{
                    $datedec=""    ;
                    }
                    echo $this->Form->input('numero', array('label' => 'Numéro Interne', 'readonly' => 'readonly', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' =>date("d/m/Y", strtotime(str_replace('/', '-', $this->request->data[$model]['date']))), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('Controller', array('value' => 'Facture', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'controller', 'type' => 'hidden', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('datedeclaration',array('label'=>'Date Déclaration','div'=>'form-group','value'=>@$datedec,'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly inputspcial','required data-bv-notempty-message'=>'Champ Obligatoire') );
                    echo $this->Form->input('numerofrs', array('label' => 'Numéro Facture', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'numerofrs', 'class' => 'form-control testnumero inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?>
                </div>

                <div class="clear"></div>              
                <table class="table table-bordered table-striped table-bottomless tablejdid scrollh" id="addtable" style="width:100%" align="center" >
                    <thead>
                        <tr class="entetetab" style="background-color: #c6b9b9;">
                            <td align="center" nowrap="nowrap" width="1%" ></td>
                            <td align="center" nowrap="nowrap" width="9%" >Code Art frs</td>
                            <td align="center" nowrap="nowrap" width="9%">code Art</td>
                            <td align="center" nowrap="nowrap" width="17%">Designation</td>
                            <td align="center" nowrap="nowrap" width="6%"> Qte </td>
                            <td align="center" nowrap="nowrap" width="6%"> Qte B </td>
                            <td align="center" nowrap="nowrap" width="7%">PU HT</td>
                            <td align="center" nowrap="nowrap" width="3%">Rem</td>
                            <td align="center" nowrap="nowrap" width="5%">Marge %</td>
                            <td align="center" nowrap="nowrap" width="7%">P V HT</td> 
                            <td align="center" nowrap="nowrap" width="3%">Fodec</td>
                            <td align="center" nowrap="nowrap" width="3%">TVA</td>
                            <td align="center" nowrap="nowrap" width="5%">Famille</td>
                            <td align="center" nowrap="nowrap" width="8%">Sous famille</td>
                            <td align="center" nowrap="nowrap" width="8%">Sous sous famille</td>
                             <?php if(($model == "Facture") || ($model == "Bonreception")) ?>  <td align="center" nowrap="nowrap" width="2%"> </td>
                            
                            <td align="center" nowrap="nowrap" width="2%" >
                                
                            </td>
                        </tr>
                    </thead>
                    <?php
                    
                    $tablesemi = 'Lignereception'; ?>
                    <input id="lachaine" type="hidden" value="articlefrs_id,code,designation,quantite,qtebonus,prixhtva,remise,marge,prixdeventeht,fodec,tva" >                <tbody>
                        <tr class="tr " style="display:none;" >

                            <td width="1%" id="" champ="tdaff" index="" ><?php ?> </td>
                            <td width="9%">

  <!--<div class='' champ="divartfrs" id="divartfrs0"  name = "" table = "<?php echo $tablesemi; ?>">--> 
                                <?php
                                echo $this->Form->input('existe', array('div' => 'form-group', 'value' => 'Non', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'existe', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control checkartfrs', 'type' => 'hidden'));
                                echo $this->Form->input('articlefrs_id', array('div' => 'form-group', 'placeholder' => 'Code Art Frs', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'articlefrs_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control checkartfrs', 'type' => 'text'));
                                ?>
                                <!--</div>-->
                            </td>
                            <td width="9%">
                                <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table' => $tablesemi,'index'=>'','id'=>'article_id','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control articleidbl','empty'=>'Veuillez Choisir !!') ); ?>
                                <div class="" style="display:inline; position: relative;">
                                    <?php
                                    echo $this->Form->input('article_id', array('div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control findfamille', 'type' => 'hidden'));
//                                    echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                    ?>
                                    <?php echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control codeselect', 'type' => 'text'));
                                    ?><div id="res" champ="rescode" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>

                                </div>
                            </td>
                            <td width="17%">
                                <div class="" style="display:inline; position: relative;">
                                    <?php echo $this->Form->input('designation', array('div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text'));
                                    ?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                </div>
                            </td>
                            <td width="6%">
                                <?php echo $this->Form->input('quantite', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte calculfactureamine ')); ?>
                            </td>
                            <td width="6%">
                                <?php echo $this->Form->input('qtebonus', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'qtebonus', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                            </td>
                            <td width="7%">
                                <?php
                                echo $this->Form->input('prixachat', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixachat', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                echo $this->Form->input('prixhtva', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixhtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculfactureamine calculprixvente'));
                                ?>
                            </td>
                            <td width="3%">
                                <?php
                                echo $this->Form->input('remise', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculfactureamine calculprixvente'));
                                echo $this->Form->input('remiseans', array('type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'remiseans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                ?>
                            </td>
                            <td width="5%">
                                <?php
                                echo $this->Form->input('marge', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'marge', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculprixvente'));
                                ?>
                            </td>
                            <td width="7%">
                                <?php
                                echo $this->Form->input('prixdeventeht', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'prixdeventeht', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculmargee'));
                                ?>
                            </td>

                            <td width="3%">
                                <?php echo $this->Form->input('fodec', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'fodec', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculfactureamine')); ?>
                            </td>

                            <td width="3%">
                                <?php
                                echo $this->Form->input('tva', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculfactureamine'));
                                echo $this->Form->input('totalht', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'totalht', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                echo $this->Form->input('totalttc', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'totalttc', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                ?>
                            </td>

                            <td width="5%">
                                <div class="" style="display:inline; position: relative;">
                                    <?php echo $this->Form->input('famille', array('div' => 'form-group', 'placeholder' => 'Famille', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'famille', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control familleselect', 'type' => 'text'));
                                    ?><div id="resfamille" champ="resfamille" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                </div>
                                <?php
                                echo $this->Form->input('famille_id', array('div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'famille_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                            echo $this->Form->input('famille', array('div' => 'form-group','placeholder'=>'Famille','label'=>'', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'famille', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                ?>
                            </td>

                            <td width="8%">
                                <div class="" style="display:inline; position: relative;">
                                    <?php echo $this->Form->input('sousfamille', array('div' => 'form-group', 'placeholder' => 'Sous Famille', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'sousfamille', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control sousfamilleselect', 'type' => 'text'));
                                    ?><div id="ressousfamille" champ="ressousfamille" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                </div>
                                <?php
                                echo $this->Form->input('sousfamille_id', array('div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'sousfamille_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                            echo $this->Form->input('sousfamille', array('div' => 'form-group','placeholder'=>'Sous famille','label'=>'', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'sousfamille', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                ?>                    </td>
                            <td width="8%">
                                <?php echo $this->Form->input('id', array('name' => '', 'id' => '', 'champ' => 'id', 'table' => $tablesemi, 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                <?php echo $this->Form->input('sup', array('name' => '', 'id' => '', 'champ' => 'sup', 'table' => $tablesemi, 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                <div class="" style="display:inline; position: relative;">
                                    <?php echo $this->Form->input('soussousfamille', array('div' => 'form-group', 'placeholder' => 'Sous Sous Famille', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'soussousfamille', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control soussousfamilleselect', 'type' => 'text'));
                                    ?><div id="ressoussousfamille" champ="ressoussousfamille" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                </div>
                                <?php
                                echo $this->Form->input('soussousfamille_id', array('div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'soussousfamille_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                            echo $this->Form->input('soussousfamille', array('div' => 'form-group','placeholder'=>'Sous sous famille','label'=>'', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'soussousfamille', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                ?>
                            </td>
                            <?php if(($model == "Facture") || ($model == "Bonreception")){ ?>
                                <td width="2%" align="center">
                                     <?php echo $this->Form->input('checkbox', array('checked','name' => '', 'id' => '', 'champ' => 'checkbox', 'table' => $tablesemi, 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'checkbox', 'class' => 'form-control', 'label' => '','style'=>'margin: 0px 0 0')); ?>
                               </td>
                             <?php } ?>
                            <td width="2%" id="" index="" align="right">
                                <i index=""  class="fa fa-times supparticle_achat" style="color: #c9302c;font-size: 25px;"/>
                            </td>

                        </tr>
                        <?php
                        foreach ($lignefactureclients as $i => $l) {
//debug($l);die;
                            $objartfrs = ClassRegistry::init('Articlefournisseur');
                            $artfrs = $objartfrs->find('first', array('conditions' => array('Articlefournisseur.article_id' => $l[$ligne_model]['article_id'])));

                            $objart = ClassRegistry::init('Article');
                            $art = $objart->find('first', array('conditions' => array('Article.id' => $l[$ligne_model]['article_id'])));
                            ?>
                            <tr>

                                <td width="1%" id="tdaff<?php echo $i; ?>" champ="tdaff" index="<?php echo $i; ?>" > </td>
                                <td width="9%">

                                          <!--<div class='' champ="divartfrs" id="divartfrs0"  name = "" table = "<?php echo $tablesemi; ?>">--> 
                                    <?php
                                    echo $this->Form->input('existe', array('name' => 'data[' . $tablesemi . '][' . $i . '][existe]', 'div' => 'form-group', 'value' => 'Non', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'existe' . $i, 'champ' => 'existe', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control checkartfrs', 'type' => 'hidden'));
                                    echo $this->Form->input('articlefrs_id', array('name' => 'data[' . $tablesemi . '][' . $i . '][articlefrs_id]', 'div' => 'form-group', 'value' =>@ $artfrs['Articlefournisseur']['reference'], 'placeholder' => 'Code Art Frs', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'articlefrs_id' . $i, 'champ' => 'articlefrs_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control checkartfrs', 'type' => 'text'));
                                    ?>
                                    <!--</div>-->
                                    </div>
                                </td>
                                <td width="9%">
                                    <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'','table' => $tablesemi,'index'=>'','id'=>'article_id','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control articleidbl','empty'=>'Veuillez Choisir !!') ); ?>
                                    <div class="" style="display:inline; position: relative;">
                                        <?php
                                        echo $this->Form->input('article_id', array('name' => 'data[' . $tablesemi . '][' . $i . '][article_id]', 'div' => 'form-group', 'value' => $l[$ligne_model]['article_id'], 'table' => $tablesemi, 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control findfamille', 'type' => 'hidden'));
//                                        echo $this->Form->input('code', array('name' => 'data[' . $tablesemi . '][' . $i . '][code]', 'div' => 'form-group', 'value' => $l['Article']['code'], 'placeholder' => 'Code', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                        ?>
                                        <?php echo $this->Form->input('code', array('value' => $l['Article']['code'], 'div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control codeselect', 'type' => 'text'));
                                        ?><div id="res" champ="rescode" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>

                                    </div>
                                </td>
                                <td width="17%">
                                    <div class="" style="display:inline; position: relative;">
                                        <?php echo $this->Form->input('designation', array('name' => 'data[' . $tablesemi . '][' . $i . '][designation]', 'div' => 'form-group', 'value' => $l['Article']['name'], 'placeholder' => 'Designation', 'label' => '', 'table' => $tablesemi, 'index' => 'designation' . $i, 'id' => $i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text'));
                                        ?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                    </div>
                                </td>
                                <td width="6%">
                                    <?php echo $this->Form->input('quantite', array('name' => 'data[' . $tablesemi . '][' . $i . '][quantite]', 'div' => 'form-group', 'value' => $l[$ligne_model]['quantite'] - $l[$ligne_model]['qtebonus'], 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte calculfactureamine ')); ?>
                                </td>
                                <td width="6%">
                                    <?php echo $this->Form->input('qtebonus', array('value' => $l[$ligne_model]['qtebonus'], 'name' => 'data[' . $tablesemi . '][' . $i . '][qtebonus]', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'qtebonus' . $i, 'champ' => 'qtebonus', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                </td>
                                <td width="7%">
                                    <?php
                                    echo $this->Form->input('prixachat', array('name' => 'data[' . $tablesemi . '][' . $i . '][prixachat]', 'div' => 'form-group', 'value' => @$l[$ligne_model]['prixachat'], 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'prixachat' . $i, 'champ' => 'prixachat', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                    echo $this->Form->input('prixhtva', array('name' => 'data[' . $tablesemi . '][' . $i . '][prixhtva]', 'div' => 'form-group', 'value' => @$l[$ligne_model]['prix'], 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'prixhtva' . $i, 'champ' => 'prixhtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculfactureamine calculprixvente'));
                                    ?>
                                </td>
                                <td width="3%">
                                    <?php
                                    echo $this->Form->input('remise', array('name' => 'data[' . $tablesemi . '][' . $i . '][remise]', 'div' => 'form-group', 'value' => $l[$ligne_model]['remise'], 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'remise' . $i, 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculfactureamine calculprixvente'));
                                    echo $this->Form->input('remiseans', array('name' => 'data[' . $tablesemi . '][' . $i . '][remiseans]', 'type' => 'hidden', 'value' => @$l[$ligne_model]['remiseans'], 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'remiseans' . $i, 'champ' => 'remiseans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                    ?>
                                </td>
                                <td width="5%">
                                    <?php
                                    echo $this->Form->input('marge', array('value' => @$l[$ligne_model]['marge'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][marge]', 'table' => $tablesemi, 'index' => $i, 'id' => 'marge' . $i, 'champ' => 'marge', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculprixvente'));
                                    ?>
                                </td>
                                <td width="7%">
                                    <?php
                                    echo $this->Form->input('prixdeventeht', array('value' => @$l[$ligne_model]['prixdeventeht'], 'div' => 'form-group', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][prixdeventeht]', 'table' => $tablesemi, 'index' => $i, 'id' => 'prixdeventeht' . $i, 'champ' => 'prixdeventeht', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculmargee'));
                                    ?>
                                </td>

                                <td width="3%">
                                    <?php echo $this->Form->input('fodec', array('name' => 'data[' . $tablesemi . '][' . $i . '][fodec]', 'div' => 'form-group', 'value' => $l[$ligne_model]['fodec'], 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'fodec' . $i, 'champ' => 'fodec', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculfactureamine')); ?>
                                </td>
                                <td width="3%">
                                    <?php
                                    echo $this->Form->input('tva', array('name' => 'data[' . $tablesemi . '][' . $i . '][tva]', 'div' => 'form-group', 'value' => $l[$ligne_model]['tva'], 'label' => '', 'readonly' => 'readonly', 'table' => $tablesemi, 'index' => $i, 'id' => 'tva' . $i, 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                    echo $this->Form->input('totalht', array('name' => 'data[' . $tablesemi . '][' . $i . '][totalht]', 'div' => 'form-group', 'value' => $l[$ligne_model]['totalht'], 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'totalht' . $i, 'champ' => 'totalht', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                    echo $this->Form->input('totalttc', array('name' => 'data[' . $tablesemi . '][' . $i . '][totalttc]', 'div' => 'form-group', 'value' => $l[$ligne_model]['totalttc'], 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'totalttc' . $i, 'champ' => 'totalttc', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                    ?>
                                </td>
                                <td width="5%">
                                    <div class="" style="display:inline; position: relative;">
                                        <?php echo $this->Form->input('famille', array('name' => 'data[' . $tablesemi . '][' . $i . '][famille]', 'div' => 'form-group', 'value' => $art['Famille']['name'], 'placeholder' => 'Famille', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'famille' . $i, 'champ' => 'famille', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control familleselect', 'type' => 'text'));
                                        ?>
                                        <div id="resfamille" champ="resfamille" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                    </div>
                                    <?php
                                    echo $this->Form->input('famille_id', array('name' => 'data[' . $tablesemi . '][' . $i . '][famille_id]', 'div' => 'form-group', 'value' => $art['Famille']['id'], 'table' => $tablesemi, 'index' => $i, 'id' => 'famille_id' . $i, 'champ' => 'famille_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                    ?>
                                </td>
                                <td width="8%">
                                    <div class="" style="display:inline; position: relative;">
                                        <?php echo $this->Form->input('sousfamille', array('name' => 'data[' . $tablesemi . '][' . $i . '][sousfamille]', 'div' => 'form-group', 'value' => $art['Sousfamille']['name'], 'placeholder' => 'Sous Famille', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'sousfamille' . $i, 'champ' => 'sousfamille', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control sousfamilleselect', 'type' => 'text'));
                                        ?><div id="ressousfamille" champ="ressousfamille" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                    </div>
                                    <?php
                                    echo $this->Form->input('sousfamille_id', array('name' => 'data[' . $tablesemi . '][' . $i . '][sousfamille_id]', 'div' => 'form-group', 'value' => $art['Sousfamille']['id'], 'table' => $tablesemi, 'index' => $i, 'id' => 'sousfamille_id' . $i, 'champ' => 'sousfamille_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                            echo $this->Form->input('sousfamille', array('div' => 'form-group','placeholder'=>'Sous famille','label'=>'', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'sousfamille', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                    ?>
                                </td>
                                <td width="8%">
                                    <?php echo $this->Form->input('id', array('value' => $l[$ligne_model]['id'], 'name' => 'data[' . $tablesemi . '][' . $i . '][id]', 'id' => 'id' . $i, 'champ' => 'id', 'table' => $tablesemi, 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                    <?php echo $this->Form->input('sup', array('name' => 'data[' . $tablesemi . '][' . $i . '][sup]', 'id' => 'sup' . $i, 'champ' => 'sup', 'table' => $tablesemi, 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                    <div class="" style="display:inline; position: relative;">
                                        <?php echo $this->Form->input('soussousfamille', array('name' => 'data[' . $tablesemi . '][' . $i . '][soussousfamille]', 'div' => 'form-group', 'value' => $art['Soussousfamille']['name'], 'placeholder' => 'Sous Sous Famille', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'soussousfamille' . $i, 'champ' => 'soussousfamille', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control soussousfamilleselect', 'type' => 'text'));
                                        ?><div id="ressoussousfamille" champ="ressoussousfamille" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                    </div>
                                    <?php
                                    echo $this->Form->input('soussousfamille_id', array('name' => 'data[' . $tablesemi . '][' . $i . '][soussousfamille_id]', 'div' => 'form-group', 'value' => $art['Soussousfamille']['id'], 'table' => $tablesemi, 'index' => $i, 'id' => 'soussousfamille_id' . $i, 'champ' => 'soussousfamille_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                            echo $this->Form->input('soussousfamille', array('div' => 'form-group','placeholder'=>'Sous sous famille','label'=>'', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'soussousfamille', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                    ?>
                                </td>
                                
                                <?php if(($model == "Facture") || ($model == "Bonreception")){ 
                                     $check='';
                                     if($l[$ligne_model]['check']==1) $check='checked="checked"';
                                    ?>
                                <td width="2%" align="center">
                                     <input type="checkbox" name="data[<?php echo $tablesemi; ?>][<?php echo $i; ?>][checkbox]" <?php echo $check; ?>  id="checkbox<?php echo $i; ?>" champ="checkbox"
                                          table="<?php echo $tablesemi; ?>"  index="<?php echo $i; ?>" class="form-control"  value data-bv-field="data[<?php echo $tablesemi; ?>][<?php echo $i; ?>][checkbox]"
                                          onkeypress="fuckfocus('input','<?php echo $i; ?>','data[<?php echo $tablesemi; ?>][<?php echo $i; ?>][checkbox]')"  onfocus="select();" style="margin: -1px 0px -5px;">
                                    <?php //echo $this->Form->input('checkbox', array($check,'value'=>'','name' => 'data[' . $tablesemi . '][' . $i . '][checkbox]',  'champ' => 'checkbox', 'table' => $tablesemi,  'index' => $i, 'id' => 'checkbox' . $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'checkbox', 'class' => 'form-control', 'label' => '')); ?>
                               </td>
                               <?php } ?>
                                <td width="2%" align="right">
                                    <i index="<?php echo $i; ?>"  class="fa fa-times supparticle_achat" style="color: #c9302c;font-size: 25px;"/>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
                if ($lignefactureclients == array()) {
                    ?>
                    <input type="hidden" value="0" id="index" />
                <?php } else { ?>
                    <input type="hidden" value="<?php echo $i; ?>" id="index" />
                <?php } ?>

                <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="pop">


                    </div>
                    <br>
                    <a  class="remodal-confirm ls-light-green-btn btn" ><strong>OK</strong></a>

                </div> 

                <div class="col-md-3">
                    <?php
                    $tvaanc=0;
                    if(floatval($this->request->data[$model]['tvaanc'])!=0){
                        $tvaanc=$this->request->data[$model]['tva'];
                    }
                    echo $this->Form->input('remise', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'remise', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('tva', array('label' => 'TVA', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'tva', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('tvaanc', array('label' => 'TVA manuel','value'=>$tvaanc, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'tvaanc', 'class' => 'form-control inputspcial'));
                    $htanc=0;
                    if(floatval($this->request->data[$model]['totalhtanc'])!=0){
                        $htanc=$this->request->data[$model]['totalht'];
                    }
                   ?>
                </div>
                <div class="col-md-3">                  
                    <?php
                    echo $this->Form->input('fodec', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'fodec', 'class' => 'form-control inputspcial'));
                    if ($model == 'Facture') {
                        echo $this->Form->input('timbre_id', array('div' => 'form-group', 'value' => $timbre, 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'timbre', 'champ' => 'timbre', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    }
                    
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                    echo $this->Form->input('totalht', array('label' => 'Total HT', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_HT', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('totalhtanc', array('label' => 'Total ht manuel','value'=>$htanc, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'totalhtanc', 'class' => 'form-control inputspcial'));

                    $ttcanc=0;
                    if(floatval($this->request->data[$model]['totalttcanc'])!=0){
                        $ttcanc=$this->request->data[$model]['totalttc'];
                    }
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                    echo $this->Form->input('totalttc', array('label' => 'Total TTC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('totalttcanc', array('label' => 'Total TTC manuel','value'=>$ttcanc, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'totalttcanc', 'class' => 'form-control inputspcial'));                    

                    ?>
                        
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

