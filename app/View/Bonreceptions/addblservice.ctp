<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Bonreceptions/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout BL Service'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Bonreception',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		        echo $this->Form->input('fournisseur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'importFournisseurId','class'=>'form-control','empty'=>'Veuillez Choisir !!') );
                ?>
                <div class="fournisseurexterne" style="display:none;" >
                    <div class='form-group' >
                        <label class='col-md-2 control-label' id="labeldevise" ><?php echo __('Importation'); ?></label>
                        <div class='col-sm-10' champ="divimpor" id="divimpor" >     </div>
                    </div>
                </div>
                <?php
		        echo $this->Form->input('date',array('div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );
                echo $this->Form->input('note',array('type'=>'textarea','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'note','class'=>'form-control ') );
                ?></div><div class="col-md-6"><?php
                echo $this->Form->input('numero',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'numero','class'=>'form-control ') );
		echo $this->Form->input('Controller',array('value'=>'Facture','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'controller','type'=>'hidden') );
		echo $this->Form->input('totalttc',array('label'=>'Total TTC','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','class'=>'form-control') );
                ?>
            </div>  
                              

<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary testnumero ">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div
</div>

