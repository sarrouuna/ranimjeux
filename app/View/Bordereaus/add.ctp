<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Bordereaus/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<?php $p=CakeSession::read('pointdevente');?>
<div class="row">    
  
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout Bordereau'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Bordereau',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
       <div class="col-md-6">                  
              	<?php 
		
                echo $this->Form->input('Date_deb',array('label'=>'Echéance du','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
	
             
                ?>
            
                
	</div>
  <div class="col-md-6"> 
       	<?php 
        echo $this->Form->input('Date_fn',array('label'=>'Au','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
			
        ?>
  </div>   
            <div class="col-md-6">                  
              	<?php
                echo $this->Form->input('pointdevente_id',array('value'=>@$poinvente,'id'=>'pointdevente_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select numspecial'));
		//echo $this->Form->input('numero',array('readonly'=>'readonly','value'=>@$mm,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		if($factoring==0){
                echo $this->Form->input('compte_id',array('value'=>@$compte_id,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
                 }
                if($factoring==1){
                echo $this->Form->input('comptefactoring',array('value'=>$comptefactoring,'label'=>'Compte factoring','readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
                echo $this->Form->input('comptefactoring_id',array('value'=>$comptefactoringid,'label'=>'Compte factoring','readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'hidden') );
                echo $this->Form->input('compte_id',array('div'=>'form-group','label'=>'Compte bancaire','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
                echo $this->Form->input('garantie',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calcultotalfactoring','id'=>'garantie','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
                }
           ?></div>
          <div class="col-md-6"><?php
		echo $this->Form->input('date',array('div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire') );		
                echo $this->Form->input('paiement_id',array('id'=>'paiement_id','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
                if($factoring==1){
                echo $this->Form->input('agio',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calcultotalfactoring','id'=>'agio','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
                }                ?>
            <?php if(($factoring==0)&&(@$paiementid==3)){?>
                                        <div class="form-group">
                                        <label class="col-md-2 control-label">Situation</label>    
                                        <div class="col-sm-10">
                                        <select class="select" id="situation" name="data[Bordereau][situation]">
                                            <option value="">Choix</option>
                                            <option value="Versé">Versé à l'encaissement</option>
                                            <option value="Versé à escompte"   >Versé à l'escompte</option>
                                        </select>
                                        </div>
                                        </div>
            <?php } ?>
             
         </div> 
                                    <div class="form-group">
                                        <div class="col-lg-9 col-lg-offset-3 ">
                                            <button type="submit" name="data[Bordereau][recherche]" id='btn_recherche' class="btn btn-primary cl_btn_recherche">Afficher</button> 
                                                 
                                         </div>
                                    </div>
           <!-- Autre ligne bordereau-->
           <div class="row ligne lb"  <?php if(empty($cheques)){ ?>style="display: none"<?php } ?> >
                        
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
                                    <td align="center" nowrap="nowrap">Echeance</td>
                                    <td align="center" nowrap="nowrap">Montant</td>    
                                    <td align="center" nowrap="nowrap"></td>
                                    

                                </tr>
                                </thead>
                                <tbody>
                                    
                                <?php if(!empty($cheques)){ foreach ($cheques as $i=>$cheque){    if($cheque['Piecereglementclient']['situation']=="En attente"){  ?> 
                                
                                <tr class="cc" >
                                   <td style="width:23%">
                                        <?php echo $this->Form->input('piecereglementclient_id',array('type'=>'hidden','value'=>$cheque['Piecereglementclient']['id'],'label'=>'','div'=>'form-group', 'name' => 'data[lignebordereau]['.$i.'][piecereglementclient_id]','table'=>'lignebordereau','index'=>$i,'id'=>'piecereglementclient_id'.$i,'champ'=>'piecereglementclient_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));?>
                                        <?php echo $this->Form->input('client_id',array('readonly'=>'readonly','value'=>$cheque['Reglementclient']['client_id'],'div'=>'form-group','label'=>'', 'name' => 'data[lignebordereau]['.$i.'][client_id]','table'=>'lignebordereau','index'=>$i,'id'=>'client_id'.$i,'champ'=>'client_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  ','type'=>'hidden') );?>
                                        <?php echo $this->Form->input('clientid',array('readonly'=>'readonly','value'=>$cheque['Piecereglementclient']['nameclient'],'div'=>'form-group','label'=>'', 'name' => '','table'=>'lignebordereau','index'=>$i,'id'=>'client_id'.$i,'champ'=>'client_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','type'=>'text') );?>
                                    </td>
                                    <td style="width:19%" champ="tdpiece" id="tdpiece">
                                        <?php echo $this->Form->input('numpiece',array('readonly'=>'readonly','value'=>$cheque['Piecereglementclient']['num'],'label'=>'','div'=>'form-group', 'name' => 'data[lignebordereau]['.$i.'][numpiece]','table'=>'lignebordereau','index'=>$i,'id'=>'piecereglementclient_id'.$i,'champ'=>'piecereglementclient_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','type'=>'text'));?>
                                    </td>
                                    <td style="width:19%">
                                        <?php echo $this->Form->input('banque',array('readonly'=>'readonly','value'=>$cheque['Piecereglementclient']['banque'],'div'=>'form-group','label'=>'', 'name' => 'data[lignebordereau]['.$i.'][banque]','table'=>'lignebordereau','index'=>$i,'id'=>'banque'.$i,'champ'=>'banque','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:10%">
                                        <?php echo $this->Form->input('echeance',array('readonly'=>'readonly','value'=>date("d/m/Y",strtotime(str_replace('-','/',$cheque['Piecereglementclient']['echance']))),'div'=>'form-group','label'=>'', 'name' => 'data[lignebordereau]['.$i.'][echance]','table'=>'lignebordereau','index'=>$i,'id'=>'echance'.$i,'champ'=>'echance','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','type'=>'text') );?>
                                    </td>
                                    <td style="width:14%">
                                     <?php echo $this->Form->input('Montant',array('readonly'=>'readonly','value'=>$cheque['Piecereglementclient']['montant'],'div'=>'form-group','label'=>'', 'name' => 'data[lignebordereau]['.$i.'][montant]','table'=>'lignebordereau','index'=>$i,'id'=>'montant'.$i,'champ'=>'montant','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    
                                    <td style="width:1%" align='center'> <input type="checkbox" name="data[lignebordereau][<?php echo $i ;?>][ok]" index="<?php echo $i ;?>" class="calculmontantbordereaux" value="1" id='chekbox<?php echo $i ;?>'></td>
                                    
                                </tr>
                                <?php }}} ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo $i; ?>" id="index" />
</div>
                            </div>
                        </div>                
</div>                    
            <div class="col-md-6 lb" <?php if(empty($cheques)){ ?>style="display: none"<?php } ?>><?php
            //echo $this->Form->input('compte_id',array('value'=>$compte_id,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','readonly'=>'readonly','after'=>'</div>','class'=>'form-control ') );              
            echo $this->Form->input('Montant',array('label'=>'Montant total','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'total','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire') );              
                ?>
            </div>     
            <div class="col-md-6 lb" <?php if(empty($cheques)){ ?>style="display: none"<?php } ?>><?php if($factoring==1){
            echo $this->Form->input('montantverse',array('label'=>'Montant factoring','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'totalfactoring','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire') ); }             
                ?>
            </div>  
<div class="form-group lb" <?php if(empty($cheques)){ ?>style="display: none"<?php } ?>>
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" name="data[Bordereau][enregistrer]" id='btn_enregistrer' class="btn btn-primary cl_btn_enregistrer cl_mousse_enregistrer testligneedit testlignefacture">Enregistrer</button>
                                            </div>
                                        </div>
 <?php echo $this->Form->end();?>   
</div>
                            </div>
                        </div>
</div>

