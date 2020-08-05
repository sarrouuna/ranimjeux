<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Factureavoirfrs/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Consultation Facture avoir'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Factureavoirfr', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                         
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Fournisseur'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($factureclient['Fournisseur']['name']); ?>'>

                        </div>



                    </div>			 
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Numero Interne'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($factureclient['Factureavoirfr']['numero']); ?>'>

                        </div>



                    </div>	
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Numero'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($factureclient['Factureavoirfr']['numerofrs']); ?>'>

                        </div>



                    </div>

                </div>     <div class="col-md-6">  

                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Type'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($factureclient['Typefacture']['name']); ?>'>

                        </div>



                    </div><div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h(date("d/m/Y", strtotime(str_replace('-', '/', $factureclient['Factureavoirfr']['date'])))); ?>'>

                        </div>



                    </div>		</div>

                <div class="col-md-6 favf " >
                </div>   
                <div class="col-md-6 favf " ><?php
                    echo $this->Form->input('totalttc', array('value' => $factureclient['Factureavoirfr']['totalttc'], 'label' => 'Total TTC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?>
                </div>   
                <table style="width:70%" align="center" border='2' >
                    <thead>
                        <tr>
                            <td align="center" nowrap="nowrap" width="30%" >M HT</td>
                            <td align="center" nowrap="nowrap" width="10%" >TVA %</td>
                            <td align="center" nowrap="nowrap" width="30%">M TVA</td>
                            <td align="center" nowrap="nowrap" width="30%">M TTC</td>

                        </tr>
                    </thead>
                    <?php $tablesemi = 'Lignefactureservice'; ?>
                    <?php
                    foreach ($tvas as $i => $tva) {
                        $ligne = ClassRegistry::init('Lignefactureavoirfr')->find('first', array('conditions' => array('Lignefactureavoirfr.factureavoirfr_id' => $factureclient['Factureavoirfr']['id'], 'Lignefactureavoirfr.tva' => $tva['Tva']['name']), 'recursive' => -1));
//                        debug($factureclient);
                        ?>
                        <tr>
                            <td align='center' width="30%">
                                <?php
                                echo @$ligne['Lignefactureavoirfr']['totalht'];
                                ?>
                            </td>
                            <td align='center' width="10%">
                                <?php
                                echo @$ligne['Lignefactureavoirfr']['tva'];
                                ?>
                            </td>
                            <td align='center' width="30%">
                                <?php
                                echo @$ligne['Lignefactureavoirfr']['totalttc'] - @$ligne['Lignefactureavoirfr']['totalht'];
                                ?>
                            </td>
                            <td align='center' width="30%">
                                <?php
                                echo @$ligne['Lignefactureavoirfr']['totalttc'];
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td width="30%" align='center'>
                            Total HT    
                        </td>
                        <td width="10%">

                        </td>
                        <td width="30%" align='center'>
                            Total TVA    
                        </td>
                        <td width="30%" align='center'>
                            Total TTC    
                        </td>
                    </tr>
                    <tr>
                        <td align="center" width="30%">
                            <?php
                            echo $factureclient['Factureavoirfr']['totalht'];
                            ?>
                        </td>
                        <td align="center" width="10%">

                        </td>
                        <td align="center" width="30%">
                            <?php echo $factureclient['Factureavoirfr']['tva']; ?>
                        </td>
                        <td align="center" width="30%">
                            <?php echo $factureclient['Factureavoirfr']['totalttc']; ?>
                        </td>
                    </tr>
                </table> 
<div style="height: 30px"></div>                <div class="row ligne " >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Imputation Facture Avoir'); ?></h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtablec" style="width:90%" align="center" >
                                    <thead>
                                        <tr>
                                            <td align="center" nowrap="nowrap">Facture</td>
                                            <td align="center" nowrap="nowrap">Reste</td>
                                            <td align="center" nowrap="nowrap">Montant</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($imputationfactureavoirs as $k => $imputationfactureavoir) {
//                                            debug($imputationfactureavoirs);
//                                            die;
                                            ?>
                                            <tr>
                                                <td align="center" style="width:50%">
                                                    <?php echo @$imputationfactureavoir['Facture']['numerofrs']; ?>
                                                </td>
                                                <td align="center" style="width:25%">
                                                    <?php echo @$imputationfactureavoir['Imputationfactureavoirfr']['reste']; ?>
                                                </td>
                                                <td align="center" style="width:24%">
                                                    <?php echo @$imputationfactureavoir['Imputationfactureavoirfr']['montant']; ?>

                                                </td>

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <input type="hidden" value="0" id="indexc" />
                            </div>
                        </div>

                    </div>                
                </div>
                <?php echo $this->Form->end(); ?>

            </div></div></div></div>




