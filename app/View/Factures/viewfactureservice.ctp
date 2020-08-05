<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot . '/' . $model . 's'; ?>/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation ' . $model); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create($model,array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
                echo $this->Form->input('pointdevente_id', array('disabled','empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select'));
                echo $this->Form->input('fournisseur_id',array('disabled','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fournisseur','class'=>'form-control','empty'=>'Veuillez Choisir !!') );
                if($model!="Factureavoirfr"){
                echo $this->Form->input('datefacture',array('label'=>'Date','div'=>'form-group','value'=>date("d/m/Y",strtotime(str_replace('-','/',$this->request->data[$model]['datefacture']))),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
                }
                if($model=="Facture" || $model=="Factureavoirfr"){ //debug($this->request->data);die;
                echo $this->Form->input('datedeclaration',array('label'=>'Date declaration','div'=>'form-group','value'=>date("d/m/Y",strtotime(str_replace('-','/',$this->request->data[$model]['datedeclaration']))),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
                }
                ?>
            </div>
            <div class="col-md-6">
                <?php
                echo $this->Form->input('numero',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'numero','class'=>'form-control ') );
		echo $this->Form->input('Controller',array('value'=>'Facture','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'controller','type'=>'hidden') );
	         echo $this->Form->input('date',array('value'=>date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data[$model]['date']))),'label'=>'Date '.$model,'id'=>'date','champ'=>$model,'div'=>'form-group','type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
		if ($model == 'Facture') {
                    echo $this->Form->input('timbre_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'timbre', 'champ' => 'timbre', 'class' => 'form-control calculefactureservice'));
                }
                //echo $this->Form->input('totalttc',array('label'=>'Total TTC','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','class'=>'form-control') );
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
                            $ligne=ClassRegistry::init($ligne_model)->find('first',array('conditions'=>array($ligne_model . '.' . $attribut => $this->request->data[$model]['id'], $ligne_model . '.tva'=>$tva['Tva']['name']),'recursive'=>-1));
                           //   debug($ligne);
                          
                            ?>
                            <tr>
                                <td width="30%">
                                    <?php
                                    echo $this->Form->input('mth', array('readonly' => 'readonly','value'=>@$ligne[$ligne_model]['totalht'],'name' => 'data[' . $tablesemi . '][' . $i . '][mth]', 'div' => 'form-group','label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'mth' . $i, 'champ' => 'mth', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefactureservice'));
                                    echo $this->Form->input('idligne', array('value'=>@$ligne[$ligne_model]['id'],'type'=>'hidden','name' => 'data[' . $tablesemi . '][' . $i . '][id]', 'div' => 'form-group','label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'mth' . $i, 'champ' => 'mth', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefactureservice'));
                                    ?>
                                </td>
                                <td width="10%">
                                    <?php
                                    echo $this->Form->input('tauxtva', array('readonly' => 'readonly','name' => 'data[' . $tablesemi . '][' . $i . '][tauxtva]', 'div' => 'form-group', 'value' =>$tva['Tva']['name'], 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'tauxtva' . $i, 'champ' => 'tauxtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                                    ?>
                                </td>
                                <td width="30%">
                                    <?php
                                    echo $this->Form->input('mtva', array('value'=>@$ligne[$ligne_model]['tttva'],'readonly' => 'readonly','name' => 'data[' . $tablesemi . '][' . $i . '][mtva]', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'mtva' . $i, 'champ' => 'mtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                                    ?>
                                </td>
                                <td width="30%">
                                    <?php 
                                    echo $this->Form->input('mttc', array('value'=>@$ligne[$ligne_model]['totalttc'],'readonly' => 'readonly','name' => 'data[' . $tablesemi . '][' . $i . '][mttc]', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'mttc' . $i, 'champ' => 'mttc', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); 
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
                                <td width="30%">
                                    <?php
                                    echo $this->Form->input('totalht', array('type'=>'text','readonly' => 'readonly', 'div' => 'form-group','label' => '', 'table' => $tablesemi,'id' => 'totth','between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                                    ?>
                                </td>
                                <td width="10%">
                                    
                                </td>
                                <td width="30%">
                                    <?php
                                    echo $this->Form->input('tva', array('type'=>'text','readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi,'id' => 'tottva','between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                                    ?>
                                </td>
                                <td width="30%">
                                    <?php 
                                    echo $this->Form->input('totalttc', array('type'=>'text','readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi,'id' => 'totttc','between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); 
                                    ?>
                                </td>
                            </tr>
                </table> 
                                     <input type="hidden" value="<?php echo @$i; ?>" id="index" />
                              
                                    <br><br>

<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div
</div>

