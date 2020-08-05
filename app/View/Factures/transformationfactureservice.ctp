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
                                    <h3 class="panel-title"><?php echo __('Ajout ' . $model); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create($model,array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
                echo $this->Form->input('pointdevente_id', array('value'=>$entete[$model_ans]['pointdevente_id'],'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select'));
                echo $this->Form->input('fournisseur_id',array('value'=>$entete[0]['fournisseur_id'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fournisseur','class'=>'form-control','empty'=>'Veuillez Choisir !!') );
                echo $this->Form->input('datefacture',array('label'=>'Date','div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
		?>
            </div>
            <div class="col-md-6">
                <?php
                echo $this->Form->input('numero',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'numero','class'=>'form-control ') );
		echo $this->Form->input('Controller',array('value'=>'Facture','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'controller','type'=>'hidden') );
	         echo $this->Form->input('date',array('label'=>'Date '.$model,'id'=>'date','champ'=>$model,'div'=>'form-group','type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
		if ($model == 'Facture') {
                    $ttc=$entete[0]['totalttc']+$timbre[1];
                    echo $this->Form->input('timbre_id', array('div' => 'form-group', 'value' => $timbre, 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'timbre', 'champ' => 'timbre', 'class' => 'form-control calculefactureservice'));
                }else{
                    $ttc=$entete[0]['totalttc'];
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
                            $lignes = ClassRegistry::init($ligne_model_ans)->find('first', array(
                                'fields' => array('(' . $ligne_model_ans . '.id) id', 'SUM(' . $ligne_model_ans . '.tttva) tttva', 'SUM(' . $ligne_model_ans . '.totalht) totalht', 'SUM(' . $ligne_model_ans . '.totalttc)totalttc',
                                    '(' . $ligne_model_ans . '.' . $attribut_ans . ')' . $attribut_ans, '(' . $ligne_model_ans . '.id)' . $ligne_model_ans . '_id')
                                , 'conditions' => array($model_ans . '.id in' . $liste, $ligne_model_ans . '.tva'=>(int)$tva['Tva']['name'])
                                , 'recursive' => 0));
                           // debug();
                            ?>
                            <tr>
                                <td width="30%">
                                    <?php
                                    echo $this->Form->input('mth', array('value'=>@$lignes[0]['totalht'],'name' => 'data[' . $tablesemi . '][' . $i . '][mth]', 'div' => 'form-group','label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'mth' . $i, 'champ' => 'mth', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefactureservice'));
                                    ?>
                                </td>
                                <td width="10%">
                                    <?php
                                    echo $this->Form->input('tauxtva', array('readonly' => 'readonly','name' => 'data[' . $tablesemi . '][' . $i . '][tauxtva]', 'div' => 'form-group', 'value' =>$tva['Tva']['name'], 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'tauxtva' . $i, 'champ' => 'tauxtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                                    ?>
                                </td>
                                <td width="30%">
                                    <?php
                                    echo $this->Form->input('mtva', array('value'=>@$lignes[0]['tttva'],'readonly' => 'readonly','name' => 'data[' . $tablesemi . '][' . $i . '][mtva]', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'mtva' . $i, 'champ' => 'mtva', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                                    ?>
                                </td>
                                <td width="30%">
                                    <?php 
                                    echo $this->Form->input('mttc', array('value'=>@$lignes[0]['totalttc'],'readonly' => 'readonly','name' => 'data[' . $tablesemi . '][' . $i . '][mttc]', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi, 'index' => $i, 'id' => 'mttc' . $i, 'champ' => 'mttc', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); 
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
                                    echo $this->Form->input('totalht', array('value'=>$entete[0]['totalht'],'type'=>'text','readonly' => 'readonly', 'div' => 'form-group','label' => '', 'table' => $tablesemi,'id' => 'totth','between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                                    ?>
                                </td>
                                <td width="10%">
                                    
                                </td>
                                <td width="30%">
                                    <?php
                                    echo $this->Form->input('tva', array('value'=>$entete[0]['tva'],'type'=>'text','readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi,'id' => 'tottva','between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                                    ?>
                                </td>
                                <td width="30%">
                                    <?php 
                                    
                                    echo $this->Form->input('totalttc', array('value'=>sprintf("%.3f",$ttc),'type'=>'text','readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'table' => $tablesemi,'id' => 'totttc','between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); 
                                    ?>
                                </td>
                            </tr>
                </table> 
                                     <input type="hidden" value="<?php echo @$i; ?>" id="index" />
                              
                                    <br><br>
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

