<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Affaires/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout Affaire'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Affaire',array('enctype' => 'multipart/form-data','autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('numero',array('value'=>@$mm,'readonly'=>'readonly','label'=>'Num&eacute;ro','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		//echo $this->Form->input('name',array('label'=>'D&eacute;signation','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
               echo $this->Form->input('responsable',array('multiple'=>'multiple','id'=>'responsable','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Responsables','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
                <div class="" style="display:inline; position: relative;">
                        <?php
                        echo $this->Form->input('name', array('label'=>'D&eacute;signation','id' => 'Designation', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control selectidd', 'type' => 'text'));
                      //  echo $this->Form->input('listdesignation_id', array('between' => '<div class="formRightn">', 'type' => 'text', 'label' => '', 'dataix' => '0',  'name' => 'data[Bonlivraisonvente][client_id]', 'class' => 'selectidd', 'id' => 'Designation', 'after' => '</div><div class="fix"></div>'));
                        ?>
                        <div id="res" champ="res" style="background-color:#e0e0e0;position: absolute; top: -10px;left: 200px; width:350px;z-index: 999" class="prop" onMouseMove="this.style.visibility = 'visible';" onMouseOut="this.style.visibility = 'hidden';">
                        </div>
                        <textarea style="display: none" name="data[Bonlivraisonvente][client_id]" cols="50" id="designation"></textarea>
                </div>
                
                <?php
                echo $this->Form->input('date',array('div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
                echo $this->Form->input('adresse',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('promoteur',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('region_id',array('empty'=>'veuillez choisir','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('revendeur',array('label'=>'Revendeur','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('note',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                ?></div><div class="col-md-6"><?php
                echo $this->Form->input('bureaudetude', array('label'=>'bureau d\'&eacute;tude','id' => 'bureaudetude', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control selectbureauetude', 'type' => 'text'));
		//echo $this->Form->input('bureaudetude',array('id' =>'bureaudetude','label'=>'bureau d\'&eacute;tude','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control selectbureauetude') );
                ?>
                <div id="resb" champ="resb" style="background-color:#e0e0e0;position: absolute; top: 205px;left: 900px; width:350px;z-index: 999" class="prop" onMouseMove="this.style.visibility = 'visible';" onMouseOut="this.style.visibility = 'hidden';">
                </div>
                <textarea style="display: none" name="data[Bonlivraisonvente][client_id]" cols="50" id="designation"></textarea>    
                <?php    
		echo $this->Form->input('architecte',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('entreprisedebatiment',array('label'=>'entreprise de batiment','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('entreprisedefluide',array('label'=>'entreprise de fluide','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('contact',array('label'=>'premi&eacute;re contact entreprise','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('telcontact',array('label'=>'Tel contact ','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('emailcontact',array('label'=>'Email contact ','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                ?>
  </div>
                                    
          <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('ajout Pieces Jointes'); ?></h3>
                                    <a class="btn btn-danger ajouterligne_w" table='addtable' index='index' style="
                                    float: right; 
                                    position: relative;
                                    top: -25px;
                                "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                                </div>
                                <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:90%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap" width="49%">Désignation</td>
                                    <td align="center" nowrap="nowrap" width="49%">Piece</td>
                                    <td align="center" width="1%"></td>
                                </tr>
                                </thead>
								
								
								
				<tr class="tr" style="display:none;">
                                <td> 
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Piecejointeaffaire','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('namepiecejointe',array('empty'=>'choix','div'=>'form-group','label'=>'', 'name' => '','table'=>'Piecejointeaffaire','index'=>'','id'=>'','champ'=>'namepiecejointe_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                </td>
                                <td>
                                        <?php echo $this->Form->input('piece',array('name' => '','table'=>'Piecejointeaffaire','index'=>'','id'=>'','champ'=>'piece','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'file','multiple'=>"true") ); ?>       
                                    
									
				</td>
                                   
                                    <td align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>

                                     

                                <tr>
                                <td>
                                        <?php echo $this->Form->input('sup',array('name'=>'data[Piecejointeaffaire][0][sup]','id'=>'sup0','champ'=>'sup','table'=>'Piecejointeaffaire','index'=>'0','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                         
			                <?php echo $this->Form->input('namepiecejointe',array('div'=>'form-group','label'=>'', 'name' => 'data[Piecejointeaffaire][0][namepiecejointe]','table'=>'Piecejointeaffaire','index'=>'0','id'=>'name','champ'=>'name','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                </td>
                                <td>
                                        <?php echo $this->Form->input('piece',array('name' => 'data[Piecejointeaffaire][0][piece]','table'=>'Piecejointeaffaire','index'=>'0','champ'=>'piece','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'file','multiple'=>"true",'id'=>"piece0") ); ?>       
                                    
                                       
					  
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

