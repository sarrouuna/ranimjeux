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
                                    <h3 class="panel-title"><?php echo __('Ajout bon de reception'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Bonreception',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('fournisseur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
		echo $this->Form->input('utilisateur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
		echo $this->Form->input('numero',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('date',array('div'=>'form-group','type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire') );		
		echo $this->Form->input('remise',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?></div><div class="col-md-6"><?php
		echo $this->Form->input('tva',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('fodec',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('totalht',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('totalttc',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?>
  </div>  
                                      <!-- Autre ligne inventaire-->
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne de reception'); ?></h3>
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
                                    <td align="center" nowrap="nowrap">Article</td>
                                    <td align="center" nowrap="nowrap">Quantité</td>
                                    <td align="center" nowrap="nowrap">Date de fabrication</td>
                                    <td align="center" nowrap="nowrap">Date de validite</td>
                                    <td align="center" nowrap="nowrap">N° du lot</td>
                                    <td align="center" nowrap="nowrap">Prix HTVA</td>    
                                    <td align="center" nowrap="nowrap">Remise %</td>       
                                    <td align="center" nowrap="nowrap">Fodec %</td>
                                    <td align="center" nowrap="nowrap">TVA %</td>    
                                    <td align="center" nowrap="nowrap">Total HT</td>       
                                    <td align="center" nowrap="nowrap">Total TTC</td>
                                    <td align="center"></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;">
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignereception','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'') );?>
                                        <?php echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testligneinv ','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('datefabrication',array('name'=>'data[Lignereception][0][datefabrication]','id'=>'','table'=>'Lignereception','index'=>'0','champ'=>'datefabrication','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','type'=>'text','after'=>'</div>','class'=>'form-control  testligneinvdate ','required data-bv-notempty-message'=>'Champ Obligatoire' ) );?>
                                    </td>
                                    <td  style="width:33%">
                                        <?php echo $this->Form->input('datevalidite',array('name'=>'data[Lignereception][0][datevalidite]','id'=>'','table'=>'Lignereception','index'=>'0','champ'=>'datevalidite','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','type'=>'text','after'=>'</div>','class'=>'form-control  testligneinvdate ','required data-bv-notempty-message'=>'Champ Obligatoire' ) );?>
                                    </td>
                                     <td style="width:25%">
                                     <?php echo $this->Form->input('numerolot',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][numerolot]','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'numerolot','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                     <?php echo $this->Form->input('prixhtva',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][prixhtva]','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][remise]','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'remise','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                     <?php  echo $this->Form->input('fodec',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][fodec]','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'fodec','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                     <?php echo $this->Form->input('tva',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][tva]','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'tva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                     <?php echo $this->Form->input('totalht',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][totalht]','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'totalht','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                     <?php echo $this->Form->input('totalttc',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][totalttc]','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'totalttc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                      <td align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                
                                <tr>
                                    <td style="width:33%">
                                        <?php echo $this->Form->input('sup',array('name'=>'data[Lignereception][0][sup]','id'=>'sup0','champ'=>'sup','table'=>'Lignereception','index'=>'0','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][article_id]','table'=>'Lignereception','index'=>'0','id'=>'article_id0','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testligneinv','empty'=>'Veuillez choisir !!','required data-bv-notempty-message'=>'Champ Obligatoire') );?>
                                    </td>
                                    <td style="width:33%">
                                        <?php echo $this->Form->input('quantite',array('label'=>'','div'=>'form-group', 'name' => 'data[Lignereception][0][quantite]','table'=>'Lignereception','index'=>'0','id'=>'quantite0','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('datefabrication',array('name'=>'data[Lignereception][0][datefabrication]','id'=>'datefabrication0','table'=>'Lignereception','index'=>'0','champ'=>'datefabrication','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','type'=>'text','after'=>'</div>','class'=>'form-control datePickerOnly testligneinvdate ','required data-bv-notempty-message'=>'Champ Obligatoire' ) );?>
                                    </td>
                                    <td  style="width:33%">
                                        <?php echo $this->Form->input('datevalidite',array('name'=>'data[Lignereception][0][datevalidite]','id'=>'datevalidite0','table'=>'Lignereception','index'=>'0','champ'=>'datevalidite','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','type'=>'text','after'=>'</div>','class'=>'form-control datePickerOnly testligneinvdate ','required data-bv-notempty-message'=>'Champ Obligatoire' ) );?>
                                    </td>
                                     <td style="width:25%">
                                     <?php echo $this->Form->input('numerolot',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][numerolot]','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'numerolot','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                     <?php echo $this->Form->input('prixhtva',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][prixhtva]','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][remise]','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'remise','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                     <?php  echo $this->Form->input('fodec',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][fodec]','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'fodec','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                     <?php echo $this->Form->input('tva',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][tva]','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'tva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                     <?php echo $this->Form->input('totalht',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][totalht]','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'totalht','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                     <?php echo $this->Form->input('totalttc',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignereception][0][totalttc]','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'totalttc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
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

