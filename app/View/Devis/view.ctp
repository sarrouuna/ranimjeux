
<?php if ($type == 1) {
    $x = 'devis';
    $index = 'index';
} else {
    $x = 'facture proforma';
    $index = 'indexx';
} ?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Devis/<?php echo $index ?>"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Consultation ' . $x); ?></h3>
            </div>
            <div class="panel-body">
<?php echo $this->Form->create('Devi', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                         
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Client'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $devi['Client']['name']; ?>'>
                        </div>



                    </div>
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Utilisateur'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($devi['Utilisateur']['name']); ?>'>

                        </div>



                    </div>		
                </div> <div class="col-md-6">    
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Numero'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($devi['Devi']['numero']); ?>'>

                        </div>



                    </div>			 <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($devi['Devi']['date']); ?>'>

                        </div>



                    </div>	</div>		   <div class="row ligne" >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Ligne de ' . $x); ?></h3>

                            </div>
                            <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                    <thead>
                                        <tr>
                                            <td align="center" nowrap="nowrap">Article</td>
                                            <td align="center" nowrap="nowrap"> Quantite </td>
                                            <td align="center" nowrap="nowrap">Prix unitaire</td>    
                                            <td align="center" nowrap="nowrap">Remise %</td>       
                                            <td align="center" nowrap="nowrap">TVA % </td>    
                                            <td align="center"></td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                                <?php foreach ($lignedevis as $i => $l) { 
                                                    
                                                    ?> 

                                            <tr class="cc" >
                                                <td style="width:30%">
                                                    <?php echo $this->Form->input('article_id', array('value' => $l['Lignedevi']['designation'], 'div' => 'form-group', 'readonly' => 'readonly', 'type' => 'text', 'label' => '', 'name' => 'data[Lignedevi][' . $i . '][article_id]', 'table' => 'Lignedevi', 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ', 'empty' => 'Veuillez choisir !!')); ?>               
                                                </td>
                                                <td style="width:16%">
                                                    <?php echo $this->Form->input('quantite', array('value' => $l['Lignedevi']['quantite'], 'label' => '', 'div' => 'form-group', 'readonly' => 'readonly', 'name' => 'data[Lignedevi][' . $i . '][quantite]', 'table' => 'Lignedevi', 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire')); ?>
                                                </td>
                                                <td style="width:16%">
                                                    <?php echo $this->Form->input('prix', array('value' => $l['Lignedevi']['prix'], 'div' => 'form-group', 'readonly' => 'readonly', 'label' => '', 'name' => 'data[Lignedevi][' . $i . '][prixhtva]', 'table' => 'Lignedevi', 'index' => $i, 'id' => 'prixhtva' . $i, 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                                </td>
                                                <td style="width:16%">
    <?php echo $this->Form->input('remise', array('value' => $l['Lignedevi']['remise'], 'div' => 'form-group', 'readonly' => 'readonly', 'label' => '', 'name' => 'data[Lignedevi][' . $i . '][remise]', 'table' => 'Lignedevi', 'index' => $i, 'id' => 'remise' . $i, 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                                </td>
                                                <td style="width:16%">
    <?php echo $this->Form->input('tva', array('value' => $l['Lignedevi']['tva'], 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[Lignedevi][' . $i . '][tva]', 'table' => 'Lignedevi', 'index' => $i, 'id' => 'tva' . $i, 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                                </td>
                                                <td align="center"><i index="<?php echo $i; ?>"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
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
                    echo $this->Form->input('remise', array('value' => $l['Devi']['remise'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'remise', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('tva', array('label' => 'TVA', 'value' => $l['Devi']['tva'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'tva', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    $lien_vente = CakeSession::read('lien_vente');
                    foreach ($lien_vente as $k => $liens) {
                        if (@$liens['lien'] == 'marge') {
                            $marge = 1;
                        }
                    }
                    if (@$marge == 1) {
                        echo $this->Form->input('marge', array('value' => $l['Devi']['marge'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'marge', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    }
                    ?></div><div class="col-md-6"><?php
                    echo $this->Form->input('totalht', array('label' => 'Total HT', 'value' => $l['Devi']['totalht'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_HT', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('totalttc', array('label' => 'Total TTC', 'value' => $l['Devi']['totalttc'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?>
                </div>                              
<?php echo $this->Form->end(); ?>

            </div></div></div></div>




