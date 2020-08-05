<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Importations/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout Importation'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Importation',array('type'=>'file','autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('name',array('label'=>'Désignation','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('numero',array('readonly'=>'readonly','value'=>$mm,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
	        echo $this->Form->input('date',array('div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
	        echo $this->Form->input('dateliv',array('label'=>'Date livraison prévue','div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
                echo $this->Form->input('fournisseur_id',array('id'=>'fournisseur_id','empty'=>'Veuillez Choisir !!','div'=>'form-group','between'=>'<div class="col-sm-8">','after'=>'</div>','class'=>'form-control select getdevise','between'=>'<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12">','after'=>'</div></td><td style="width: 5%;vertical-align: top"><span title="Ancien prix"><a style="display:none;"  onclick="recap_importation()" href="#reModal_refuser" champ="order" id="order" value="0" <button class="  "><i class="fa fa fa-pencil"></i></a></span></td></tr></table>') );
		?>
                
                
                <div class='form-group' >	
                    <label class='col-md-2 control-label' id="labeldevise" style="display:none;"><?php echo __('Devise'); ?></label>	
                                  
			
                                  <div class='col-sm-10' champ="divdevise" id="divdevise" >     </div>
			
		
                                 
                </div> 
                <?php
                //echo $this->Form->input('devise_id',array('empty'=>'Veuillez Choisir !!','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('montantachat',array('type'=>'text','id'=>'montantachat','label'=>'Montant Achat','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo $this->Form->input('tauxderechenge',array('type'=>'text','id'=>'tauxderechenge','label'=>'Cours Devise','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo $this->Form->input('prixachat',array('id'=>'prixachat','type'=>'hidden','label'=>'Prix d\'achat','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo $this->Form->input('totale',array('type'=>'text','id'=>'totale','readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
                ?></div><div class="col-md-6"><?php
                echo"<table><tr><td>";
		echo $this->Form->input('avis',array('type'=>'text','id'=>'avis','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('value'=>@$this->request->data['Importation']['fournisseuravis'],'name'=>'data[Importation][fournisseuravis]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td></tr><tr><td>";
                echo $this->Form->input('transitaire',array('type'=>'text','id'=>'transitaire','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('value'=>@$this->request->data['Importation']['fournisseurtransitaire'],'name'=>'data[Importation][fournisseurtransitaire]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td></tr><tr><td>";
                echo $this->Form->input('ddttva',array('type'=>'text','id'=>'ddttva','label'=>'DD&TVA','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('value'=>@$this->request->data['Importation']['fournisseurddttva'],'name'=>'data[Importation][fournisseurddttva]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td></tr><tr><td>";
                echo $this->Form->input('assurence',array('type'=>'text','label'=>'assurance','id'=>'assurence','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('value'=>@$this->request->data['Importation']['fournisseurassurence'],'name'=>'data[Importation][fournisseurassurence]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td></tr><tr><td>";
                echo $this->Form->input('divers',array('type'=>'text','id'=>'divers','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('value'=>@$this->request->data['Importation']['fournisseurdivers'],'name'=>'data[Importation][fournisseurdivers]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td></tr><tr><td>";
                echo $this->Form->input('fraisfinancie',array('type'=>'text','id'=>'fraisfinancie','label'=>'Frais Financiers','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('value'=>@$this->request->data['Importation']['fournisseurfraisfinancie'],'name'=>'data[Importation][fournisseurfraisfinancie]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td></tr><tr><td>";
                echo $this->Form->input('magasinage',array('type'=>'text','id'=>'magasinage','label'=>'Magasinage','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
                echo $this->Form->input('fournisseur',array('value'=>@$this->request->data['Importation']['fournisseurmagasinage'],'name'=>'data[Importation][fournisseurmagasinage]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td></tr></table>";
                //echo $this->Form->input('coefficien',array('type'=>'text','type'=>'text','readonly'=>'readonly','id'=>'coefficien','label'=>'Coefficient','div'=>'form-group','between'=>'<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12">','after'=>'</div></td><td style="width: 5%;vertical-align: top"><input type="radio" name="data[Importation][Coefficientchoisi]"  value="0" '.$c.'></td></tr></table>','class'=>'form-control calculecoefficient') );
		//echo $this->Form->input('coeff',array('type'=>'text','type'=>'text','id'=>'coeff','label'=>'Ancien Coefficient','div'=>'form-group','between'=>'<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12">','after'=>'</div></td><td style="width: 5%;vertical-align: top"><input type="radio" name="data[Importation][Coefficientchoisi]"  value="1" '.$ac.'></td></tr></table>','class'=>'form-control ') );
                
                ?>
                </div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                <?php
		echo $this->Form->input('coefficien',array('id'=>'coefficien','type'=>'hidden','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('c',array('type'=>'text','readonly'=>'readonly','id'=>'c','label'=>'Coefficient','div'=>'form-group','between'=>'<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12">','after'=>'</div></td><td style="width: 5%;vertical-align: top"><input checked="checked" type="radio" name="data[Importation][Coefficientchoisi]" value="0" ></td></tr></table>','class'=>'form-control calculecoefficient') );
		echo $this->Form->input('coeff',array('type'=>'text','id'=>'coeff','label'=>'Ancien Coefficient','div'=>'form-group','between'=>'<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12">','after'=>'</div></td><td style="width: 5%;vertical-align: top"><input type="radio" name="data[Importation][Coefficientchoisi]" value="1" ></td></tr></table>','class'=>'form-control ') );
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
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Piecejointe','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('namepiecejointe_id',array('empty'=>'choix','div'=>'form-group','label'=>'', 'name' => '','table'=>'Piecejointe','index'=>'','id'=>'','champ'=>'namepiecejointe_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'') );?>
                                </td>
                                <td>
                                        <?php echo $this->Form->input('piece',array('name' => '','table'=>'Piecejointe','index'=>'','id'=>'','champ'=>'piece','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'file','multiple'=>"true") ); ?>       
                                    
									
				</td>
                                   
                                    <td align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>

                                     

                                <tr>
                                <td>
                                        <?php echo $this->Form->input('sup',array('name'=>'data[Piecejointe][0][sup]','id'=>'sup0','champ'=>'sup','table'=>'Piecejointe','index'=>'0','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                         
			                <?php echo $this->Form->input('namepiecejointe_id',array('empty'=>'choix','div'=>'form-group','label'=>'', 'name' => 'data[Piecejointe][0][namepiecejointe_id]','table'=>'Piecejointe','index'=>'0','id'=>'name','champ'=>'name','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                </td>
                                <td>
                                        <?php echo $this->Form->input('piece',array('name' => 'data[Piecejointe][0][piece]','table'=>'Piecejointe','index'=>'0','champ'=>'piece','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'file','multiple'=>"true",'id'=>"piece0") ); ?>       
                                    
                                       
					  
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
                                    
<!-- ***********************************************************************************************-->

<div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Situation Importation'); ?></h3>
                                    <a class="btn btn-danger ajouterligne_c" table='addtablec' index='indexc' style="
                                    float: right; 
                                    position: relative;
                                    top: -25px;
                                "><i class="fa fa-plus-circle"  ></i> Ajouter Situation</a>
                                </div>
                                <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtablec" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Situation</td>
                                    <td align="center" nowrap="nowrap">Date début</td>
                                    <td align="center" nowrap="nowrap">Date fin</td>
                                    <td align="center" nowrap="nowrap">Nbr Jours </td>
                                    <td align="center"></td>
                                    <td align="center"></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;">
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('supp',array('name'=>'','id'=>'','champ'=>'supp','table'=>'Situation','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'') );?>
                                        <?php echo $this->Form->input('namesituation_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Situation','index'=>'','id'=>'','champ'=>'namesituation_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('datedebut',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Situation','index'=>'','id'=>'','champ'=>'datedebut','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('datefin',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Situation','index'=>'','id'=>'','champ'=>'datefin','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:24%">
                                        <?php echo $this->Form->input('nbrjour',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Situation','index'=>'','id'=>'','champ'=>'nbrjour','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td align="center"> <input type="radio" name="" champ="contactchoisi"  index=""></td>
                                
                                    <td align="center"><i index=""  class="fa fa-times supsituation" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                
                                <tr>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('supp',array('name'=>'data[Situation][0][supp]','id'=>'supp0','champp'=>'sup','table'=>'Situation','index'=>'0','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('namesituation_id',array('div'=>'form-group','label'=>'', 'name' => 'data[Situation][0][namesituation_id]','table'=>'Situation','index'=>'0','id'=>'namesituation_id0','champ'=>'namesituation_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'','empty'=>'Veuillez choisir !!') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('datedebut',array('label'=>'','div'=>'form-group', 'name' => 'data[Situation][0][datedebut]','table'=>'Situation','index'=>'0','id'=>'datedebut0','champ'=>'datedebut','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control datePickerOnly','onblur'=>'nbrjour(0)') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('datefin',array('name'=>'data[Situation][0][datefin]','id'=>'datefin0','table'=>'Situation','index'=>'0','champ'=>'datefin','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control datePickerOnly','onblur'=>'nbrjour(0)') );?>
                                    </td>
                                    <td style="width:24%">
                                        <?php echo $this->Form->input('nbrjour',array('name'=>'data[Situation][0][nbrjour]','id'=>'nbrjour0','table'=>'Situation','index'=>'0','champ'=>'nbrjour','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                   <td> <input type="radio" name="data[contactchoisi]" value="0" index="0"></td>
                                    <td align="center"><i index="0"  class="fa fa-times supsituation" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                </tbody>
                                </table>
              	<input type="hidden" value="0" id="indexc" />
</div>
                            </div>
                        </div>                
</div> 


<!-- ***********************************************************************************************-->


 <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="importation_par_frs">
                      
                        
                    </div>
                    <br>
                   <a  class="remodal-confirm ls-light-green-btn btn" ><strong>OK</strong></a>
                    
               </div> 
                                    
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary testimportation" >Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

