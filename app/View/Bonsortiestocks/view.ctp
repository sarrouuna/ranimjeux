<script>
    $(document).ready(function ()
    {
        $('select').each(function () {
            $(this).attr('disabled', true);
        });
        $('input').each(function () {
            $(this).attr('readonly', true);
            $(this).removeClass('datePickerOnly');
        });
        $('textarea').each(function () {
            $(this).attr('readonly', true);
        });
    });
</script>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Bonsortiestocks/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Consultation Bonsortiestock'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Bonsortiestock', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                  
                    <?php // debug($bonsortiestock);die;
                    echo $this->Form->input('page', array('value' => 'bonsortiestock', 'id' => 'page', 'type' => 'hidden', 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('id', array('div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('numero', array('value'=>$bonsortiestock['Bonsortiestock']['numero'],'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('remarque', array('value'=>$bonsortiestock['Bonsortiestock']['remarque'],'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?></div><div class="col-md-6"><?php
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' => date("d/m/Y", strtotime(str_replace('/', '-', $bonsortiestock['Bonsortiestock']['date']))), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control ', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    if ($validation == 1 ) {
                        echo $this->Form->input('personnel_id', array('type' => 'hidden', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'fc', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    } else {
                        echo $this->Form->input('personnel_id', array('value'=>$bonsortiestock['Bonsortiestock']['personnel_id'],'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'fc', 'class' => 'form-control select', 'empty' => 'Veuillez Choisir !!'));
                    }
                    echo $this->Form->input('verif', array('id' => 'verif', 'type' => 'hidden', 'value' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                </div>   

                <div class="col-md-12" >
                    <div class="panel panel-default" >
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo __('Ligne de Bon Sortie'); ?></h3>
                           
                        </div>
                        <div class="panel-body" >
                            <table class="table table-bordered table-striped table-bottomless " id="addtable" style="width:100%" align="center" >
                                <thead>
                                    <tr>
                                        <td align="center" nowrap="nowrap" width="20%">Depot</td>
                                        <td align="center" nowrap="nowrap" width="20%">Article</td>
                                        <td align="center" nowrap="nowrap" width="40%">Designation</td>
                                        <td align="center" nowrap="nowrap" width="10%"> Quantité en Stock </td>
                                        <td align="center" nowrap="nowrap" width="10%"> Quantité </td>

                                    </tr>
                                </thead>
                                <?php $tablesemi = 'Lignetransfert'; ?>
                                <input id="lachaine" type="hidden" value="depot_id,code,designation,quantite" >
                                <input id="interfacetransfert" type="hidden" value="transfert" >
                                <tbody>


                                    <?php
//debug($lignetransferts);die;
                                    foreach ($lignetransferts as $i => $l) {

                                        $objArticle = ClassRegistry::init('Article');
                                        $article = $objArticle->find('first', array('conditions' => array('Article.id' => $l['Lignebonsortiestock']['article_id']), 'recursive' => -1));

                                        $obj = ClassRegistry::init('Stockdepot');
                                        $stckdepot = $obj->find('first', array('conditions' => array('Stockdepot.article_id' => $l['Lignebonsortiestock']['article_id'], 'Stockdepot.depot_id' => $l['Lignebonsortiestock']['depot_id']), false));
                                        ?> 
                                        <tr class="cc<?php echo $i; ?>" >
                                            <td style="width:20%">
                                                <?php echo $this->Form->input('depot_id', array('value' => $l['Lignebonsortiestock']['depot_id'], 'onchange' => 'fuckfocus("select","' . $i . '",this.getAttribute("name"))', 'name' => 'data[Lignetransfert][' . $i . '][depot_id]', 'index' => $i, 'id' => 'depot_id' . $i, 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control select depot_qte_s', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'empty' => 'Veuillez Choisir !!')); ?>
                                            </td>
                                            <td style="width:20%" champ="tdarticle" id="tdarticle<?php echo $i; ?>" >
                                                <?php //  echo $this->Form->input('article_id',array('value'=>$l['Lignebonsortiestock']['article_id'],'name' => 'data[Lignetransfert]['.$i.'][article_id]','index'=>$i,'id'=>'article_id'.$i,'label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select articleidbl','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!','onchange'=>'qteart('.$i.')') ); ?>
                                                <div class="" style="display:inline; position: relative;">
                                                    <?php
                                                    echo $this->Form->input('article_id', array('div' => 'form-group', 'value' => $article['Article']['id'], 'name' => 'data[' . $tablesemi . '][' . $i . '][article_id]', 'table' => $tablesemi, 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                                    echo $this->Form->input('code', array('div' => 'form-group', 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'placeholder' => 'Code', 'value' => $article['Article']['code'], 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                                    ?>
                                                    <!--                                            style="background-color:white;position: absolute; top: -10px;right: -500px; width:500px;z-index: 1000px;"-->
                                                    <!--                                            onMouseOut="this.style.visibility = 'hidden';"-->
                                                </div>
                                            </td>
                                            <td style="width:40%" id="tddesg<?php echo $i; ?>" index="<?php echo $i; ?>" champ="tddesg">
                                                <div class="" style="display:inline; position: relative;">
                                                    <?php echo $this->Form->input('designation', array('value' => $article['Article']['name'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][designation]', 'table' => $tablesemi, 'index' => $i, 'id' => 'designation' . $i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                                    <div id="res<?php echo $i; ?>" champ="res" index="<?php echo $i; ?>"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                                </div>
                                            </td>
                                            <td style="width:10%">
                                                <?php if ($validation == 0 || $validation == 2) echo $this->Form->input('quantitestock', array('readonly' => 'readonly', 'value' => @$stckdepot['Stockdepot']['quantite'], 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignetransfert][' . $i . '][quantitestock]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'quantitestock' . $i, 'champ' => 'quantitestock', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                <?php if ($validation == 1) echo $this->Form->input('quantitestock', array('readonly' => 'readonly', 'value' => @$stckdepot['Stockdepot']['quantite'] + $l['Lignebonsortiestock']['quantite'], 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignetransfert][' . $i . '][quantitestock]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'quantitestock' . $i, 'champ' => 'quantitestock', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td style="width:10%">
                                                <?php echo $this->Form->input('sup', array('name' => 'data[Lignetransfert][' . $i . '][sup]', 'id' => 'sup' . $i, 'champ' => 'sup', 'table' => 'Lignetransfert', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                                <?php echo $this->Form->input('quantite', array('value' => $l['Lignebonsortiestock']['quantite'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignetransfert][' . $i . '][quantite]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control verifqtetrsf')); ?>
                                            </td>

                                        </tr>



                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                            <input type="hidden" value="<?php echo $i; ?>" id="index" />

                        </div>
                    </div>
                </div>                
            </div> 
            <?php echo $this->Form->end(); ?>

        </div></div></div></div>




