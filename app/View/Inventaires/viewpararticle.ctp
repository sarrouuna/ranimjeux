<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Inventaires/indexpararticle"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('View Inventaire par article'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Inventaire', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh', 'enctype' => 'multipart/form-data')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('id', array('type' => 'hidden', 'value' => $inventaire['Inventaire']['id'], 'id' => 'id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('article_id', array('disabled' => 'disabled', 'value' => $articleinventaires['Ligneinventaire']['article_id'], 'id' => 'article_id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('dateinv', array('readonly' => 'readonly', 'label' => 'Date', 'value' => date("d/m/Y", strtotime(str_replace('/', '-', $inventaire['Inventaire']['date']))), 'div' => 'form-group', 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?></div><div class="col-md-6"><?php
                    echo $this->Form->input('numero', array('readonly' => 'readonly', 'div' => 'form-group', 'value' => $inventaire['Inventaire']['numero'], 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                </div>  

                <!-- Autre ligne inventaire-->
                <div class="row ligne" >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Ligne inventaire'); ?></h3>

                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:90%" align="center" >
                                    <thead>
                                        <tr>
                                            <td align="center" nowrap="nowrap">Depot</td>
                                            <td align="center" nowrap="nowrap">Quantité</td>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php
                                        foreach ($ligneinventaires as $i => $af) {
                                           
                                            ?> 
                                            <tr>
                                                <td style="width:60%">
                                                    <?php echo $this->Form->input('id', array('value' => $af['Ligneinventaire']['id'], 'name' => 'data[Ligneinventaire][' . $i . '][id]', 'id' => 'id' . $i, 'champ' => 'id', 'table' => 'Ligneinventaire', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control ', 'label' => 'Nom')); ?>
                                                    <?php echo $this->Form->input('sup', array('name' => 'data[Ligneinventaire][' . $i . '][sup]', 'id' => 'sup' . $i, 'champ' => 'sup', 'table' => 'Ligneinventaire', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control ', 'label' => 'Nom')); ?>
                                                    <?php echo $this->Form->input('depot_id', array('disabled' => 'disabled', 'value' => $af['Ligneinventaire']['depot_id'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Ligneinventaire][' . $i . '][depot_id]', 'table' => 'Ligneinventaire', 'index' => $i, 'id' => 'depot_id' . $i, 'champ' => 'depot_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control select ', 'empty' => 'Veuillez choisir !!')); ?>
                                                </td>
                                                <td style="width:20%">
                                                    <?php echo $this->Form->input('quantite', array('readonly' => 'readonly', 'value' => $af['Ligneinventaire']['quantite'], 'label' => '', 'div' => 'form-group', 'name' => 'data[Ligneinventaire][' . $i . '][quantite]', 'table' => 'Ligneinventaire', 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                </td>
                                               

                                            </tr>
                                        <?php } ?> 
                                    </tbody>
                                </table>
                                <input type="hidden" value="0" id="index" />
                            </div>

                        </div>
                    </div>                
                </div> 



                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

