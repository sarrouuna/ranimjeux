<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Inventaires/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Consultation Inventaire'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Inventaire', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                         
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Id'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($inventaire['Inventaire']['id']); ?>'>

                        </div>



                    </div>			 <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Depot'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $inventaire['Depot']['designation']; ?>'>
                        </div>



                    </div>	</div><div class="col-md-6">     
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h(date("d/m/Y", strtotime(str_replace('-', '/', $inventaire['Inventaire']['date'])))); ?>'>

                        </div>



                    </div>	


                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Numero'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($inventaire['Inventaire']['numero']); ?>'>

                        </div>



                    </div>	</div>


                <!-- ajouter ligne-->
                <div class="row ligne" >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Ajout ligne'); ?></h3>

                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless " id="addtable" style="width:100%" align="center"  >
                                    <thead>
                                        <tr>
                                            <td align="center" width="1%"></td>
                                            <td align="center" nowrap="nowrap" width="15%">code</td>
                                            <td align="center" nowrap="nowrap" width="49%">Article</td>
                                            <td align="center" nowrap="nowrap" width="15%">Quantité</td>
                                            <td align="center" nowrap="nowrap" width="20%">Cout de revient</td>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                          
                                        <?php
                                        if (!empty($ligneinvents)) {
                                            foreach ($ligneinvents as $i => $af) {
                                                $i++;
                                                ?> 
                                                <tr>
                                                    <td width="1%">
                                                        <span champ="num" id="num<?php echo $i; ?>" index="<?php echo $i; ?>"><?php echo $i; ?></span>
                                                    </td>
                                                    <td style="width:15%">
                                                        <?php echo $this->Form->input('id', array('value' => $af['Ligneinventaire']['id'], 'name' => 'data[Ligneinventaire][' . $i . '][id]', 'id' => 'id' . $i, 'champ' => 'id', 'table' => 'Ligneinventaire', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                                        <?php echo $this->Form->input('sup', array('name' => 'data[Ligneinventaire][' . $i . '][sup]', 'id' => 'sup' . $i, 'champ' => 'sup', 'table' => 'Ligneinventaire', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control ', 'label' => 'Nom')); ?>
                                                        <?php echo $this->Form->input('code', array('readonly','value' => $af['Ligneinventaire']['code'], 'div' => 'form-group', 'placeholder' => 'Code', 'label' => '', 'name' => 'data[Ligneinventaire][' . $i . '][code]', 'table' => 'Ligneinventaire', 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control invcode', 'type' => 'text')); ?>

                                                    </td>
                                                    <td style="width:49%">
                                                        <?php echo $this->Form->input('article_id', array('value' => $af['Ligneinventaire']['article_id'], 'type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => 'data[Ligneinventaire][' . $i . '][article_id]', 'table' => 'Ligneinventaire', 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testligneinv editligneinvarticle')); ?>
                                                        <?php echo $this->Form->input('designation', array('readonly','value' => $af['Ligneinventaire']['designation'], 'div' => 'form-group', 'placeholder' => 'Designation', 'label' => '', 'name' => 'data[Ligneinventaire][' . $i . '][designation]', 'table' => 'Ligneinventaire', 'index' => $i, 'id' => 'designation' . $i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                                    </td>
                                                    <td style="width:15%">
                                                        <?php echo $this->Form->input('quantite', array('readonly','value' => $af['Ligneinventaire']['quantite'], 'label' => '', 'div' => 'form-group', 'name' => 'data[Ligneinventaire][' . $i . '][quantite]', 'table' => 'Ligneinventaire', 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                    </td>
                                                    <td style="width:20%">
                                                        <?php echo $this->Form->input('coutderevien', array('readonly','value' => $af['Ligneinventaire']['coutderevien'], 'name' => 'data[Ligneinventaire][' . $i . '][coutderevien]', 'id' => 'coutderevien' . $i, 'table' => 'Ligneinventaire', 'index' => $i, 'champ' => 'coutderevien', 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'type' => 'text', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                    </td>


                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            $i = 0;
                                        }
                                        ?> 
                                    </tbody>
                                </table>
                                <input type="hidden" value="<?php echo @$i; ?>"   id="index" />
                            </div>
                         
                        </div>
                    </div>                
                </div>             

                <?php echo $this->Form->end(); ?>

            </div></div></div></div>




