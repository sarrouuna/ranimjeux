<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Promotions/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout Promotion'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Promotion',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php 		
                echo $this->Form->input('numero',array('div'=>'form-group','value'=>$mm,'between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','readonly'=>'readonly','required data-bv-notempty-message'=>'Champ Obligatoire') );
                echo $this->Form->input('datedebut',array('div'=>'form-group','label'=>'Date Debut','value'=>date('d/m/Y'),'between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','required data-bv-notempty-message'=>'Champ Obligatoire') );

	?></div><div class="col-md-6"><?php
                echo $this->Form->input('designation',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('datefin',array('div'=>'form-group','label'=>'Date Fin','value'=>date('d/m/Y'),'between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?>
  </div>          
                                    
                                    

                                    <div class="col-md-12"  >
                                        <div class="panel panel-default" >
                                            <div class="panel-heading" style="background-color: #58ACFA">
                                                <h3 class="panel-title"><?php echo __('Promotion'); ?></h3>
                                               
                                            </div>
                                            <div class="panel-body">
                                                <table class="table table-bordered table-striped table-bottomless" id="addtable" align="center" >
                                                    <thead>
                                                        <tr style="background-color: #900;color: #fff;">
                                                            <td style="width:25%" align="center" nowrap="nowrap">Article</td>
                                                            <td style="width:15%" align="center">Quantite</td>
                                                            <td style="width:15%" align="center">Prix Unitaire (Detail)</td>
                                                            <td style="width:15%" align="center">Prix Unitaire (Gros) </td>
                                                            <td style="width:1%"align="center"></td>
                                                        </tr>
                                                    </thead>
                                                    <?php $tablesemi='Promotionligne'; ?>
                                                    <tbody>
                                                        <tr class="tr" style="display:none;">

                                                            <td  id="" index="" champ="tddesg">
                                                                <div class="" style="display:inline; position: relative;">
                                                                    <?php echo $this->Form->input('sup', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Promotionligne', 'index' => '', 'id' => '', 'champ' => 'sup', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden')); ?>

                                                                    <?php

                                                                    echo $this->Form->input('article_id', array('div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                                                    echo $this->Form->input('designation', array('div' => 'form-group','placeholder'=>'Designation','label'=>'', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text'));
                                                                    ?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                                                </div>
                                                            </td>



                                                            <td><?php echo $this->Form->input('qte', array('div' => 'form-group', 'label' => '','type'=>'text', 'name' => '', 'table' => 'Promotionligne', 'index' => '0', 'id' => '', 'champ' => 'qte', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculemagasininterne')); ?></td>
                                                            <td><?php echo $this->Form->input('prix', array('div' => 'form-group', 'label' => '','type'=>'text', 'name' => '', 'table' => 'Promotionligne', 'index' => '0', 'id' => '', 'champ' => 'prix', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?></td>
                                                            <td><?php echo $this->Form->input('prixgros', array('div' => 'form-group', 'label' => '','type'=>'text', 'name' => '', 'table' => 'Promotionligne', 'index' => '0', 'id' => '', 'champ' => 'prixgros', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?></td>
                                                            <td>
                                                                <i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;">
                                                            </td>
                                                        </tr>


                                                    </tbody>
                                                </table>
                                                <a class="btn btn-danger ajouter_lignetransfert" table='addtable' index='index'  tr="tr" style="
                                    float: lfet;
                                    position: relative;
                                    top: -25px;
                                "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                                                <input type="hidden" value="0" id="index" />
                                            </div>
                                        </div>
                                    </div>                                    


                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

