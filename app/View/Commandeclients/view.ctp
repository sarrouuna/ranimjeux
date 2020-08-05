<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Commandeclients/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Consultation Commandeclient'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Commandeclient', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                         
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Id'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($commandeclient['Commandeclient']['id']); ?>'>

                        </div>



                    </div>			 <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Client'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $commandeclient['Client']['name']; ?>'>
                        </div>



                    </div>	</div><div class="col-md-6">     
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($commandeclient['Commandeclient']['date']); ?>'>

                        </div>



                    </div>			 <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Numero'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($commandeclient['Commandeclient']['numero']); ?>'>

                        </div>



                    </div>	</div>
                <div class="row ligne" >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Ligne de commande'); ?></h3>

                            </div>
                            <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                    <thead>
                                        <tr>
                                            <td align="center" nowrap="nowrap">Article</td>
                                            <td align="center" nowrap="nowrap"> Quantite </td>
                                            <td align="center" nowrap="nowrap">Prix </td>    
                                            <td align="center" nowrap="nowrap">Remise %</td>       
                                            <td align="center" nowrap="nowrap">TVA % </td>    
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        foreach ($lignecommandeclients as $i => $l) {
//                                            debug($l);die;
                                            ?> 
                                            <tr class="cc" >

                                                <td style="width:52%"  champ="tdarticle" id="tdarticle0" >
                                                    <?php echo $this->Form->input('articleid', array('value' => $l['Lignecommandeclient']['designation'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignecommandeclient][' . $i . '][article_id]', 'table' => 'Lignecommandeclient', 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ', 'type' => 'text', 'readonly' => 'readonly')); ?>               
                                                </td> 

                                                <td style="width:8%">
                                                    <?php echo $this->Form->input('quantite', array('value' => $l['Lignecommandeclient']['quantite'], 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignecommandeclient][' . $i . '][quantite]', 'table' => 'Lignecommandeclient', 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control   ', 'readonly' => 'readonly')); ?>
                                                </td>
                                                <td style="width:16%">
                                                    <?php echo $this->Form->input('prixachat', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => '', 'index' => '0', 'id' => 'prixachat0', 'champ' => 'prixachat', 'type' => 'hidden', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                                    <?php echo $this->Form->input('prix', array('value' => $l['Lignecommandeclient']['prix'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignecommandeclient][' . $i . '][prixhtva]', 'table' => 'Lignecommandeclient', 'index' => $i, 'id' => 'prixhtva' . $i, 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
                                                </td>
                                                <td style="width:16%">
                                                    <?php echo $this->Form->input('remise', array('value' => $l['Lignecommandeclient']['remise'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignecommandeclient][' . $i . '][remise]', 'table' => 'Lignecommandeclient', 'index' => $i, 'id' => 'remise' . $i, 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
                                                </td>

                                                <td style="width:8%">
                                                    <?php echo $this->Form->input('tva', array('value' => $l['Lignecommandeclient']['tva'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignecommandeclient][' . $i . '][tva]', 'table' => 'Lignecommandeclient', 'index' => $i, 'id' => 'tva' . $i, 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
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
                    <?php
                    echo $this->Form->input('remise', array('value' => $l['Commandeclient']['remise'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'remise', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('tva', array('label' => 'TVA', 'value' => $l['Commandeclient']['tva'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'tva', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    $lien_vente = CakeSession::read('lien_vente');
                    foreach ($lien_vente as $k => $liens) {
                        if (@$liens['lien'] == 'marge') {
                            $marge = 1;
                        }
                    }
                    if (@$marge == 1) {
                        echo $this->Form->input('marge', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'marge', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    }
                    ?></div><div class="col-md-6"><?php
                    echo $this->Form->input('totalht', array('label' => 'Total HT', 'value' => $l['Commandeclient']['totalht'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_HT', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('totalttc', array('label' => 'Total TTC', 'value' => $l['Commandeclient']['totalttc'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?>
                </div>  
            </div>

<?php echo $this->Form->end(); ?>

        </div></div></div></div>




