<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Bordereaus/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Validation Bordereau'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Bordereau',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

           <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('numero',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('compte_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
	     if($factoring==1){
                echo $this->Form->input('factoring_id',array('label'=>'Compte factoring','readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                   echo $this->Form->input('garantie',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
                 }
            ?></div><div class="col-md-6"><?php
		echo $this->Form->input('date',array('div'=>'form-group','value'=>$date,'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire') );		
                echo $this->Form->input('paiement_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
                if($factoring==1){
                echo $this->Form->input('agio',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
                echo $this->Form->input('montantverse',array('label'=>'Montant Vers�','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'totalfactoring','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire') );             
                
                }     
                ?>
         </div>   
         <!-- Autre ligne bordereau-->
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne de bordereau'); ?></h3>
                                    
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    
                                    <td align="center" nowrap="nowrap">Client</td>
                                    <td align="center" nowrap="nowrap">Numero pièce</td>
                                    <td align="center" nowrap="nowrap">Banque</td>
                                    <td align="center" nowrap="nowrap">Montant</td>    
                                    <td align="center" nowrap="nowrap"> Valider</td>
                                    <td align="center" nowrap="nowrap"> Situation</td>
                                </tr>
                                </thead>
                                <tbody>
                               
                                
                                
                                 <?php foreach ($lignebordereaus as $i=>$lb){ //debug($lb) ;die; ?> 
                                 
                                <tr class="cc" >
                                   <td style="width:19%">
                                       <?php echo $this->Form->input('id',array('value'=>$lb['Lignebordereau']['id'],'name'=>'data[lignebordereau]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'lignebordereau','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('client_id',array('readonly'=>'readonly','value'=>$lb['Lignebordereau']['client_id'],'div'=>'form-group','label'=>'', 'name' => 'data[lignebordereau]['.$i.'][client_id]','table'=>'lignebordereau','index'=>$i,'id'=>'client_id'.$i,'champ'=>'client_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  ','type'=>'hidden') );?>
                                        <?php echo $this->Form->input('clientid',array('readonly'=>'readonly','value'=>@$clients[$lb['Lignebordereau']['client_id']],'div'=>'form-group','label'=>'', 'name' => '','table'=>'lignebordereau','index'=>$i,'id'=>'client_id'.$i,'champ'=>'client_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','type'=>'text') );?>
                                    </td>
                                     <td style="width:19%" champ="tdpiece" id="tdpiece">
                                        <?php echo $this->Form->input('numpiece',array('readonly'=>'readonly','value'=>$lb['Lignebordereau']['numpiece'],'label'=>'','div'=>'form-group', 'name' => 'data[lignebordereau]['.$i.'][numpiece]','table'=>'lignebordereau','index'=>$i,'id'=>'numpiece'.$i,'champ'=>'numpiece','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text'));?>
                                     </td>
                                    <td style="width:19%">
                                        <?php echo $this->Form->input('banque',array('readonly'=>'readonly','value'=>$lb['Lignebordereau']['banque'],'div'=>'form-group','label'=>'', 'name' => 'data[lignebordereau]['.$i.'][banque]','table'=>'lignebordereau','index'=>$i,'id'=>'banque'.$i,'champ'=>'banque','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:19%">
                                     <?php echo $this->Form->input('montant',array('readonly'=>'readonly','value'=>$lb['Lignebordereau']['montant'],'div'=>'form-group','label'=>'', 'name' => 'data[lignebordereau]['.$i.'][montant]','table'=>'lignebordereau','index'=>$i,'id'=>'montant'.$i,'champ'=>'montant','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                   <td style="width:5%"> <input type="checkbox" <?php if(@$lb['Lignebordereau']['etat']==1){?> checked="checked"<?php } ?> name="data[lignebordereau][<?php echo $i; ?>][etat]"  value="1"></td>
                                 <td style="width:19%">
                            <div class="form-group">
                               <div class="col-sm-12">
                                <select class="form-control select selectized" placeholder="Veuillez choisir" name="data[lignebordereau][<?php echo $i; ?>][Piecereglementclient][situation]" id="stut" >
                                     <option value="<?php echo $lb['Piecereglementclient']['situation'] ?>" <?php if($lb['Piecereglementclient']['situation']){ ?> selected="selected"<?php } ?> ><?php echo $lb['Piecereglementclient']['situation'] ?></option>
                                    <option value="">Veuillez choisir</option>
                                    <option value="En attente">En attente</option>
                                    <option value="Versé"      >Versé</option>
                                    <option value="Préavis"    >Préavis</option>
                                    <option value="Payé"    >Payé</option>
                                    <option value="Impayé"  >Impayé</option>
                                    <option value="Escompté"  >Escompté</option>
                                </select>
                             </div></div>
                       	</div>
                                </td>   
                            </tr>
                 <?php } ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo $i; ?>"  id="index" />
</div>
                            </div>
                        </div>                
</div> 
                                       <div class="col-md-6">                  
              	              <?php      ?></div><div class="col-md-6"><?php
		echo $this->Form->input('Montant',array('label'=>'Montant total','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'total','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?>
  </div>                                   
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary">Valider</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

