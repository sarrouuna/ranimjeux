<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Bonlivraisons/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Consultation Bonlivraison'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Bonlivraison', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                         
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Client'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bonlivraison['Client']['name']; ?>'>
                        </div>



                    </div>			 <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Utilisateur'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bonlivraison['Utilisateur']['name']; ?>'>
                        </div>



                    </div>			 
                </div><div class="col-md-6">  
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Numero'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonlivraison['Bonlivraison']['numero']); ?>'>

                        </div>



                    </div>			 <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo date("d/m/Y", strtotime(str_replace('-', '/',  h($bonlivraison['Bonlivraison']['date'])))) ; ?>'>

                        </div>



                    </div>	</div>




                <!-- Autre ligne livraison-->
                <div class="row ligne" >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Ligne de livraison'); ?></h3>

                            </div>
                            <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                    <thead>
                                        <tr>
                                            <td align="center" nowrap="nowrap">Depot</td>
                                            <td align="center" nowrap="nowrap">Article</td>
                                            <td align="center" nowrap="nowrap"> Quantite </td>
                                            <td align="center" nowrap="nowrap"> Qte livrai </td>
                                            <td align="center" nowrap="nowrap">Prix unitaire</td>    
                                            <td align="center" nowrap="nowrap">Remise %</td>       
                                            <td align="center" nowrap="nowrap">TVA % </td>    
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($lignelivraisons as $i => $l) { 
//                                                 debug($l);die;
                                            ?> 

                                            <tr class="cc" >
                                                <td style="width:15%" >
                                                    <?php echo $this->Form->input('depot_id', array('value' => $l['Depot']['designation'], 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'type' => 'text', 'table' => 'Lignelivraison', 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez choisir !!')); ?>               
                                                </td>
                                                <td style="width:20%"  champ="tdarticle" id="tdarticle0" >
                                                    <?php echo $this->Form->input('article_id', array('value' => $l['Lignelivraison']['designation'], 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'type' => 'text', 'table' => 'Lignelivraison', 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez choisir !!')); ?>               
                                                </td>
                                                <td style="width:12%">
                                                    <?php echo $this->Form->input('quantite', array('value' => $l['Lignelivraison']['quantite'], 'label' => '', 'div' => 'form-group', 'readonly' => 'readonly', 'table' => 'Lignelivraison', 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte  editfacfournisseur', 'required data-bv-notempty-message' => 'Champ Obligatoire')); ?>
                                                </td>
                                                <td style="width:12%">
                                                    <?php echo $this->Form->input('quantitelivrai', array('value' => $l['Lignelivraison']['quantitelivrai'], 'label' => '', 'div' => 'form-group', 'readonly' => 'readonly', 'table' => 'Lignelivraison', 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte  editfacfournisseur', 'required data-bv-notempty-message' => 'Champ Obligatoire')); ?>
                                                </td>
                                                <td style="width:12%">
                                                    <?php echo $this->Form->input('prix', array('value' => $l['Lignelivraison']['prix'], 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'table' => 'Lignelivraison', 'index' => $i, 'id' => 'prixhtva' . $i, 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control editfacfournisseur')); ?>
                                                </td>
                                                <td style="width:12%">
                                                    <?php echo $this->Form->input('remise', array('value' => $l['Lignelivraison']['remise'], 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'table' => 'Lignelivraison', 'index' => $i, 'id' => 'remise' . $i, 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control editfacfournisseur')); ?>
                                                </td>
                                                <td style="width:12%">
                                                    <?php echo $this->Form->input('tva', array('value' => $l['Lignelivraison']['tva'], 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'table' => 'Lignelivraison', 'index' => $i, 'id' => 'tva' . $i, 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control editfacfournisseur')); ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <input type="hidden" value="<?php echo $i; ?>"  id="index" />
                            </div>
                        </div>
                    </div>                
                </div> 












                <div class="col-md-6">     
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Remise'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonlivraison['Bonlivraison']['remise']); ?>'>

                        </div>



                    </div>			 <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Tva'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonlivraison['Bonlivraison']['tva']); ?>'>

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
                        ?> 
                        <div class='form-group'>	
                            <label class='col-md-2 control-label'><?php echo __('Marge'); ?></label>	


                            <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonlivraison['Bonlivraison']['marge']); ?>'>

                            </div>



                        </div>	
<?php } ?>                  </div><div class="col-md-6">  
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Totalht'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonlivraison['Bonlivraison']['totalht']); ?>'>

                        </div>



                    </div>			 <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Totalttc'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonlivraison['Bonlivraison']['totalttc']); ?>'>

                        </div>



                    </div>	</div>
<?php echo $this->Form->end(); ?>

            </div></div></div></div>




