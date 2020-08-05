<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Bonentres/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout Bon d\'entre'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Bonentre',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('fournisseur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('date',array('div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire') );		
	?></div><div class="col-md-6"><?php
		echo $this->Form->input('numero',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?>
  </div>  
               <!-- Autre ligne entre-->  
            <div class="row ligne " >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne d\'entré'); ?></h3>
                                    <a class="btn btn-danger ajouterligne_reception" table='addtable' index='index'  tr="tr" style="
                                    float: right; 
                                    position: relative;
                                    top: -25px;
                                "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Depot</td>
                                    <td align="center" nowrap="nowrap">Article</td>
                                    <td align="center" nowrap="nowrap">Date de fabrication</td>
                                    <td align="center" nowrap="nowrap">Date de validite</td>
                                    <td align="center" nowrap="nowrap"> Quantite </td>
                                    <td align="center"></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;" >
                                     <td style="width:20">
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignereception','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'') );?>
                                        <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:20%">
                                        <?php echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'select','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:20%">
                                        <?php echo $this->Form->input('datefabrication',array('name'=>'','id'=>'','table'=>'Lignereception','index'=>'0','champ'=>'datefabrication','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','type'=>'text','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire' ) );?>
                                    </td>
                                    <td  style="width:20%">
                                        <?php echo $this->Form->input('datevalidite',array('name'=>'','id'=>'','table'=>'Lignereception','index'=>'','champ'=>'datevalidite','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','type'=>'text','after'=>'</div>','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire' ) );?>
                                    </td>
                                    <td style="width:18%">
                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                 
                                      <td align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                
                                <tr class="cc" >
                                     <td style="width:20%" >
                                        <?php echo $this->Form->input('sup',array('name'=>'data[Lignereception][0][sup]','id'=>'sup0','champ'=>'sup','table'=>'Lignereception','index'=>'0','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][depot_id]','table'=>'Lignereception','index'=>'','id'=>'depot_id0','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:20%" >
                                        <?php echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][article_id]','table'=>'Lignereception','index'=>'','id'=>'article_id0','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:20%">
                                        <?php echo $this->Form->input('datefabrication',array('name'=>'data[Lignereception][0][datefabrication]','id'=>'datefabrication0','table'=>'Lignereception','index'=>'0','champ'=>'datefabrication','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','type'=>'text','after'=>'</div>','class'=>'form-control datePickerOnly testligneinvdate ','required data-bv-notempty-message'=>'Champ Obligatoire' ) );?>
                                    </td>
                                    <td  style="width:20%">
                                        <?php echo $this->Form->input('datevalidite',array('name'=>'data[Lignereception][0][datevalidite]','id'=>'datevalidite0','table'=>'Lignereception','index'=>'0','champ'=>'datevalidite','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','type'=>'text','after'=>'</div>','class'=>'form-control datePickerOnly testligneinvdate ','required data-bv-notempty-message'=>'Champ Obligatoire' ) );?>
                                    </td>
                                     <td style="width:18%">
                                        <?php echo $this->Form->input('quantite',array('label'=>'','div'=>'form-group', 'name' => 'data[Lignereception][0][quantite]','table'=>'Lignereception','index'=>'0','id'=>'quantite0','champ'=>'quantite','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur','required data-bv-notempty-message'=>'Champ Obligatoire') );?>
                                    </td>
                                   
                                    <td align="center"><i index="0"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                </tbody>
                                </table>
              	<input type="hidden" value="0" id="index" />
</div>
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

