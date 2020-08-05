<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Factureavoirs/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout Facture à voir'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Factureavoir',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('client_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
		echo $this->Form->input('date',array('div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire') );		
		?></div><div class="col-md-6"><?php
		echo $this->Form->input('numero',array('value'=>$mm,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('typefacture_id',array('label'=>'Type facture','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'typefacture_id','class'=>'form-control select typefacture','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
	?>
        </div>  
                                    
                                  
                                          <!-- Autre ligne facture avoir-->
                   <div class="row ligne favr" style="display:none;" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne Facture à voir'); ?></h3>
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
                                    <td align="center" nowrap="nowrap">Date validité</td>
                                    <td align="center" nowrap="nowrap"> Quantite </td>
                                    <td align="center" nowrap="nowrap">Prix unitaire</td>    
                                    <td align="center" nowrap="nowrap">Remise %</td>       
                                    <td align="center" nowrap="nowrap">Fodec % </td>
                                    <td align="center" nowrap="nowrap">TVA % </td>    
                                    <td align="center"></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;" >
                                    <td style="width:15%">
                                        <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'depot_id','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control uniform_select','empty'=>'Veuillez Choisir !!') );?>
                                    </td>  
                                    <td style="width:20%" champ="tdarticle" id="tdarticle">
                                        <?php echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'article_id','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'articleidbl','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:14%">
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignefactureavoir','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'') );?>
                                        <?php echo $this->Form->input('datevalidite',array('name'=>'','id'=>'','table'=>'Lignefactureavoir','index'=>'0','champ'=>'datevalidite','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','type'=>'text','after'=>'</div>','class'=>'form-control testligneinvdate','required data-bv-notempty-message'=>'Champ Obligatoire' ) );?>
                                    </td>

                                    <td style="width:9%">
                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                    <td style="width:12%">
                                     <?php 
                                     echo $this->Form->input('prix',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                    <td style="width:10%">
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                    <td style="width:10%">
                                     <?php  echo $this->Form->input('fodec',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'fodec','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                    <td style="width:10%">
                                     <?php echo $this->Form->input('tva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                 
                                      <td align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                </tbody>
                                </table>
              	<input type="hidden" value="0" id="index" />
</div>
                            </div>
                        </div>                
</div> 
                                                             
                 <div class="col-md-6 favr" style="display:none;"><?php
		echo $this->Form->input('remise',array('div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'remise','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	        echo $this->Form->input('tva',array('label'=>'TVA','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		
                ?></div><div class="col-md-6 favr" style="display:none;"><?php
		echo $this->Form->input('fodec',array('div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'fodec','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('totalht',array('label'=>'Total HT','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_HT','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire') );
                ?>
                 </div>  
                <div class="col-md-6 favf " ><?php
                echo $this->Form->input('timbre_id',array('div'=>'form-group','value'=>$timbre,'between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'timbre','champ'=>'timbre','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                ?>
                 </div>   
           
                <div class="col-md-6 favf " ><?php
		echo $this->Form->input('totalttc',array('label'=>'Total TTC','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','id'=>'Total_TTC','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                ?>
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
</div>

