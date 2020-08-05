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
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Bonreceptionstocks/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Consultation Bonreceptionstock'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Bonreceptionstock', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                         
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Id'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonreceptionstock['Bonreceptionstock']['id']); ?>'>

                        </div>



                    </div>			 <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Numero'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonreceptionstock['Bonreceptionstock']['numero']); ?>'>

                        </div>



                    </div>			 <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonreceptionstock['Bonreceptionstock']['date']); ?>'>

                        </div>



                    </div>	</div><div class="col-md-6">     
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Utilisateur'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bonreceptionstock['Utilisateur']['name']; ?>'>
                        </div>



                    </div>			 
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Exercice'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bonreceptionstock['Exercice']['name']; ?>'>
                        </div>



                    </div>	
                </div>
                <div class="row ligne" >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Ligne de Transfert'); ?></h3>
                               
                            </div>
                            <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless " id="addtable" style="width:100%" align="center" >
                                    <thead>
                                        <tr>
                                            <td align="center" nowrap="nowrap" width="30%">Depot</td>
                                            <td align="center" nowrap="nowrap" width="25%">Article</td>
                                            <td align="center" nowrap="nowrap" width="30%">Designation</td>
                                            <td align="center" nowrap="nowrap" width="13%"> Quantité </td>
                                            
                                        </tr>
                                    </thead>
                                    <?php $tablesemi = 'Lignebonreceptionstock'; ?>
                                    <input id="lachaine" type="hidden" value="depot_id,code,designation,quantite" >
                                    <input id="interfacetransfert" type="hidden" value="transfert" >
                                    <tbody>
                                  

                                        <?php
                                        foreach ($lignebonreceptionstocks as $i => $af) {
                                            $objArticle = ClassRegistry::init('Article');
                                            $article = $objArticle->find('first', array('conditions' => array('Article.id' => $af['Lignebonreceptionstock']['article_id']), 'recursive' => -1));
                                            ?>
                                            <tr class="cc<?php echo $i; ?>" >
                                                <td style="width:30%">
                                                    <?php echo $this->Form->input('depot_id', array('value' => $af['Lignebonreceptionstock']['depot_id'], 'onchange' => 'fuckfocus("select","' . $i . '",this.getAttribute("name"))', 'name' => 'data[Lignebonreceptionstock][' . $i . '][depot_id]', 'index' => $i, 'id' => 'depot_id' . $i, 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control select ', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'empty' => 'Veuillez Choisir !!')); ?>
                                                </td>
                                                <td style="width:25%" champ="tdarticle" id="tdarticle0" >
                                                    <?php //echo $this->Form->input('article_id',array('value'=>$af['Lignebonreceptionstock']['article_id'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignebonreceptionstock]['.$i.'][article_id]','table'=>'Lignebonreceptionstock','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select qtestock ','empty'=>'Veuillez Choisir !!') ); ?>
                                                    <div class="" style="display:inline; position: relative;">
                                                        <?php
                                                        echo $this->Form->input('article_id', array('div' => 'form-group', 'value' => $article['Article']['id'], 'name' => 'data[' . $tablesemi . '][' . $i . '][article_id]', 'table' => $tablesemi, 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                                        echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'value' => $article['Article']['code'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                                        ?>
                                                        <!--                                            style="background-color:white;position: absolute; top: -10px;right: -500px; width:500px;z-index: 1000px;"-->
                                                        <!--                                            onMouseOut="this.style.visibility = 'hidden';"-->
                                                    </div>
                                                </td>
                                                 <td style="width:30%" id="tddesg<?php echo $i; ?>" index="<?php echo $i; ?>" champ="tddesg">
                                                    <div class="" style="display:inline; position: relative;">
                                                        <?php echo $this->Form->input('designation', array('value' => $article['Article']['name'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => 'data[' . $tablesemi . '][' . $i . '][designation]', 'table' => $tablesemi, 'index' => $i, 'id' => 'designation' . $i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                                        <div id="res<?php echo $i; ?>" champ="res" index="<?php echo $i; ?>"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                                    </div>
                                                </td>
                                                <td style="width:13%">
                                                    <?php echo $this->Form->input('sup', array('name' => 'data[Lignebonreceptionstock][' . $i . '][sup]', 'id' => 'sup' . $i, 'champ' => 'sup', 'table' => 'Lignebonreceptionstock', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                                    <?php echo $this->Form->input('quantite', array('value' => $af['Lignebonreceptionstock']['quantite'], 'onkeypress' => 'fuckfocus("input","' . $i . '",this.getAttribute("name"))', 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignebonreceptionstock][' . $i . '][quantite]', 'table' => 'Lignebonreceptionstock', 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                                </td>
                                            </tr>
                                           
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <input type="hidden" value="<?php echo $i ?>" id="index" />
                            </div>
                        </div>
                    </div>                
                </div>                            

                <?php echo $this->Form->end(); ?>

            </div></div></div></div>




