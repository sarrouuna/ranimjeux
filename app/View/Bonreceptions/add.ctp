<script>
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
    function chargerselectarticle(index, article_id, code, des) {
        alert();
        $('#article_id' + index).next().children().children().html(code + ' ' + des);
        $('#article_id' + index).children().val(article_id);
    }
</script>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Bonreceptions/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<input type="hidden" value="commande" id="page" />
<input type="hidden" value="0" id="testindex" />
<input type="hidden" value="0" id="arretfonction" />
<input type="hidden" id="sirine" value="0"> 
<div class="row" >
    <div class="col-md-12 " >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Ajout Bon livraison'); ?></h3>
            </div>
            <div class="panel-body">
<?php echo $this->Form->create('Bonreception', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => '', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh', 'enctype' => 'multipart/form-data')); ?>

                <div class="col-md-6">                  
<?php
if ($p == 0) {
    echo $this->Form->input('pointdevente_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select'));
}
echo $this->Form->input('fournisseur_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'fc', 'class' => 'form-control select  artfournisseur', 'empty' => 'Veuillez Choisir !!'));
//echo $this->Form->input('depot_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'depot_id','class'=>'form-control','empty'=>'Veuillez Choisir !!') );		
echo $this->Form->input('numero', array('label' => 'Numéro BL', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'numero', 'class' => 'form-control '));
?>
                    <div class="fournisseurexterne" style="display:none;" >
<?php
echo $this->Form->input('coefficient', array('value' => 1, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'coef', 'class' => 'form-control calculcout', 'type' => 'text'));
?>  
                    </div> 
                </div><div class="col-md-6"><?php
echo $this->Form->input('numeroconca', array('label' => 'Numéro Interne', 'value' => $mm, 'readonly' => 'readonly', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control '));
echo $this->Form->input('date', array('div' => 'form-group', 'value' => date("d/m/Y"), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly'));
echo $this->Form->input('Controller', array('value' => 'Bonreception', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'controller', 'type' => 'hidden'));
echo $this->Form->input('datefacture', array('label' => 'Date BL', 'div' => 'form-group', 'value' => date("d/m/Y"), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly'));
?>
                </div>  

                <!-- Autre ligne reception-->
                <div class="row ligne fournisseurinterne" >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Ligne de livraison'); ?></h3>
                                <a class="btn btn-danger ajouterligne_reception" table='addtable' index='index'  tr="tr" style="
                                   float: right; 
                                   position: relative;
                                   top: -25px;
                                   "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                            </div>
                            <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                    <thead>
                                        <tr>
                                            <td align="center" nowrap="nowrap" width="1%" ></td>
                                            <td align="center" width="12%"  nowrap="nowrap">Depot</td>
                                            <td align="center" width="22%"  nowrap="nowrap">Article</td>
                                            <td align="center" width="8%" nowrap="nowrap"> Qte </td>
                                            <td align="center" width="10%" nowrap="nowrap">Prix Ans</td>  
                                            <td align="center" width="10%" nowrap="nowrap">Marge Ans</td>  
                                            <td align="center" width="10%" nowrap="nowrap">Prix</td>    
                                            <td align="center" width="10%" nowrap="nowrap">Remise %</td>       
                                            <td align="center" width="8%" nowrap="nowrap">Fodec % </td>
                                            <td align="center" width="8%" nowrap="nowrap">TVA % </td>    
                                            <td align="center" width="8%" nowrap="nowrap">Date Expiration</td>    
                                            <td align="center" width="1%"></td>
                                        </tr>
                                    </thead>
                                                <?php $tablesemi = 'Lignereception'; ?>
                                    <input id="lachaine" type="hidden" value="depot_id,code,designation,quantite,prixhtva,remise,fodec,tva" >
                                    <tbody>
                                        <tr class="tr" style="display:none;" >
                                            <td id="" champ="tdaff" index="" >
                                                <span title="changer le prix de vente"> <a style="display:none;" onclick="recap_rapport()" href="#reModal_refuser" id="" index="" champ="order" value="0" <button class=' '><i class='fa fa fa-pencil'></i></a></span>
                                            </td>
                                            <td>
                                                <?php echo $this->Form->input('depot_id', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignereception', 'index' => '', 'id' => '', 'champ' => 'depot_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => '', 'empty' => 'Veuillez Choisir !!')); ?>
                                            </td>
                                            <td  champ="tdarticle" id="tdarticlee">
                                                <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'article_id0','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'idarticle testligneinv','empty'=>'Veuillez Choisir !!') );?>
                                                <div class="" style="display:inline; position: relative;">
<?php
echo $this->Form->input('article_id', array('div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcodeachat', 'type' => 'text'));
?>
                                                    <!--                                            style="background-color:white;position: absolute; top: -10px;right: -500px; width:500px;z-index: 1000px;"-->
                                                    <!--                                            onMouseOut="this.style.visibility = 'hidden';"-->
                                                </div>

                                            </td>
                                            <td >
<?php echo $this->Form->input('margeA', array('name' => '', 'id' => '', 'champ' => 'margeA', 'table' => 'Lignereception', 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
<?php echo $this->Form->input('pvA', array('name' => '', 'id' => '', 'champ' => 'pvA', 'table' => 'Lignereception', 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>

<?php echo $this->Form->input('sup', array('name' => '', 'id' => '', 'champ' => 'sup', 'table' => 'Lignereception', 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
<?php echo $this->Form->input('quantite', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignereception', 'index' => '', 'id' => '', 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testlr calculefacfournisseur')); ?>
                                            </td>
                                            <td >
                                        <?php echo $this->Form->input('prixachatans', array('readonly' => 'readonly', 'label' => '', 'div' => 'form-group', 'name' => '', 'table' => 'Lignereception', 'index' => '0', 'id' => '', 'champ' => 'prixachatans', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td >
                                        <?php echo $this->Form->input('margeans', array('readonly' => 'readonly', 'label' => '', 'div' => 'form-group', 'name' => '', 'table' => 'Lignereception', 'index' => '0', 'id' => '', 'champ' => 'margeans', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td >
                                        <?php echo $this->Form->input('prixhtva', array('value' => '', 'div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignereception', 'index' => '', 'id' => '', 'champ' => 'prixhtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacfournisseur')); ?>
                                            </td>
                                            <td >
                                        <?php echo $this->Form->input('remise', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignereception', 'index' => '', 'id' => '', 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testlr calculefacfournisseur')); ?>
                                            </td>
                                            <td >
<?php echo $this->Form->input('fodec', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignereception', 'index' => '', 'id' => '', 'champ' => 'fodec', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testlr calculefacfournisseur')); ?>
                                            </td>
                                            <td >
<?php echo $this->Form->input('tva', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignereception', 'index' => '', 'id' => '', 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacfournisseur')); ?>
                                            </td>
                                            <td><input table='Lignereception' champ='date_exp'  index='' id='' value="" class="form-control" ></td>
                                            <td align="center"><i index=""  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;"></td>
                                        </tr>
                                        <tr class="tr" style="display:none;" >

                                            <td colspan="12" id="" index="" champ="tddesg">
                                                <div class="" style="display:inline; position: relative;">
                                        <?php echo $this->Form->input('designation', array('div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselectachat', 'type' => 'text'));
                                        ?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                                </div>
                                            </td>
                                        </tr>

<!--                                <tr class="cc" >
     <td id="tdaff0" >
    <span title="changer le prix de vente"><a style="display:none;" onclick="recap_achat(0)" href="#reModal_refuser" champ="order" id="order0" value="0" <button class='  '><i class='fa fa fa-pencil'></i></a></span>
    </td>
    <td>
<?php echo $this->Form->input('depot_id', array('div' => 'form-group', 'label' => '', 'name' => 'data[Lignereception][0][depot_id]', 'table' => 'Lignereception', 'index' => '', 'id' => 'depot_id0', 'champ' => 'depot_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control select', 'empty' => 'Veuillez Choisir !!')); ?>
    </td>
    <td  champ="tdarticle" id="tdarticle0" >
<?php echo $this->Form->input('article_id', array('div' => 'form-group', 'label' => '', 'name' => 'data[Lignereception][0][article_id]', 'table' => 'Lignereception', 'index' => '', 'id' => 'article_id0', 'champ' => 'article_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testligneinv idarticle select', 'onchange' => 'tvaart(0)', 'empty' => 'Veuillez Choisir !!')); ?>
<?php echo $this->Form->input('margeA', array('name' => 'data[Lignereception][0][margeA]', 'id' => 'margeA0', 'champ' => 'margeA', 'table' => 'Lignereception', 'index' => '0', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
<?php echo $this->Form->input('pvA', array('name' => 'data[Lignereception][0][pvA]', 'id' => 'pvA0', 'champ' => 'pvA', 'table' => 'Lignereception', 'index' => '0', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
    </td>
    
    <td >
<?php echo $this->Form->input('sup', array('name' => 'data[Lignereception][0][sup]', 'id' => 'sup0', 'champ' => 'sup', 'table' => 'Lignereception', 'index' => '0', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
<?php echo $this->Form->input('quantite', array('label' => '', 'div' => 'form-group', 'name' => 'data[Lignereception][0][quantite]', 'table' => 'Lignereception', 'index' => '0', 'id' => 'quantite0', 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testlr calculefacfournisseur')); ?>
    </td>
    <td >
<?php echo $this->Form->input('prixachatans', array('readonly' => 'readonly', 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignereception][0][prixachatans]', 'table' => 'Lignereception', 'index' => '0', 'id' => 'prixachatans0', 'champ' => 'prixachatans', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
    </td>
    <td >
<?php echo $this->Form->input('margeans', array('readonly' => 'readonly', 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignereception][0][margeans]', 'table' => 'Lignereception', 'index' => '0', 'id' => 'margeans0', 'champ' => 'margeans', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
    </td>
    <td >
                    <?php echo $this->Form->input('prixhtva', array('div' => 'form-group', 'label' => '', 'name' => 'data[Lignereception][0][prixhtva]', 'table' => 'Lignereception', 'index' => '0', 'id' => 'prixhtva0', 'champ' => 'prixhtva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacfournisseur')); ?>
    </td>
    <td >
                    <?php echo $this->Form->input('remise', array('div' => 'form-group', 'label' => '', 'name' => 'data[Lignereception][0][remise]', 'table' => 'Lignereception', 'index' => '0', 'id' => 'remise0', 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testlr calculefacfournisseur')); ?>
    </td>
    <td >
                    <?php echo $this->Form->input('fodec', array('div' => 'form-group', 'label' => '', 'name' => 'data[Lignereception][0][fodec]', 'table' => 'Lignereception', 'index' => '0', 'id' => 'fodec0', 'champ' => 'fodec', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testlr calculefacfournisseur')); ?>
    </td>
    <td >
                    <?php echo $this->Form->input('tva', array('div' => 'form-group', 'label' => '', 'name' => 'data[Lignereception][0][tva]', 'table' => 'Lignereception', 'index' => '0', 'id' => 'tva0', 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacfournisseur')); ?>
    </td>
    <td align="center"><i index="0"  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;"></td>
</tr>-->
                                    </tbody>
                                </table>
                                <input type="hidden" value="0" id="index" />
                            </div>
                        </div>
                    </div>                
                </div> 
                <input type="hidden" value="Lignereception" id="tableligne" />                      
                <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="popachat">


                    </div>
                    <br>

                    <a  class="remodal-confirm ls-light-green-btn btn" onclick="validerprixdevente()"><strong>OK</strong></a>                
                </div>             



                <div class="col-md-6">                  
<?php
echo $this->Form->input('remise', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'remise', 'class' => 'form-control'));
echo $this->Form->input('tva', array('label' => 'TVA', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'tva', 'class' => 'form-control'));
echo $this->Form->input('fodec', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'fodec', 'class' => 'form-control'));
?></div><div class="col-md-6"><?php
echo $this->Form->input('totalht', array('label' => 'Total HT', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_HT', 'class' => 'form-control '));
echo $this->Form->input('totalttc', array('label' => 'Total TTC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control'));
?>
                </div>  


                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary testlignesubmit TestLigneTTFacture  testnumero testdateexpiration">Enregistrer</button>
                    </div>
                </div>
<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div
</div>

