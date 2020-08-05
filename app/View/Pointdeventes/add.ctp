<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Pointdeventes/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Ajout Point de vente'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Pointdevente', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('page', array('id'=>'page','value'=>'Pointdevente','type' => 'hidden', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('name', array('label' => 'Designation', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('abriviation', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('adresse', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('tel', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?>
                    <div class="form-group">
                        <label for="FODEC">FODEC</label>
                        <div class="col-sm-10">
                            <input type="radio" name="data[Pointdevente][fodecp]" id="fodecp0" value="0" checked>Non
                            <input type="radio" name="data[Pointdevente][fodecp]" id="fodecp1" value="1">Oui
                            <?php
                            echo $this->Form->input('fodec', array('id' => 'pvfodec', 'style' => 'display:none', 'label' => '', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                            ?>
 <!--<input type="text" name="data[Pointdevente][fodec]" id="pvfodec" class="form-control" style="display: none">-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="RETENUE">RETENUE</label>
                        <div class="col-sm-10">
                            <input type="radio" name="data[Pointdevente][retenuep]" id="retenuep0" value="0" checked>Non
                            <input type="radio" name="data[Pointdevente][retenuep]" id="retenuep1" value="1">Oui
                            <?php
                            echo $this->Form->input('retenue', array('id' => 'pvretenue', 'style' => 'display:none', 'label' => '', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                            ?>
<!--<input name="data[Pointdevente][retenue]" class="form-control" required data-bv-notempty-message="Champ Obligatoire" maxlength="300" type="text" id="pvretenue" data-bv-field="data[Pointdevente][retenue]"  style="display: none">-->
                            <!--<input type="text" name="data[Pointdevente][retenue]" id="pvretenue" class="form-control" style="display: none" required="" data-bv-notempty-message='Champ Obligatoire'>-->
                        </div>
                    </div>
                </div>
                <div class="col-md-6"><?php
                    echo $this->Form->input('societe_id', array('empty' => '--Veuillez choisir--', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('ville', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('personnel_id', array('empty' => 'Veuillez Choisir !!', 'label' => 'Responsable', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?>

                </div>               
                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary btnEnregistrer">Enregistrer</button>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

