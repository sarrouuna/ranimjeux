<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Ordres/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout Ordre de paiement'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Ordre',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
                echo $this->Form->input('Date_deb',array('label'=>'Date De','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
		echo $this->Form->input('fournisseur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
		echo $this->Form->input('utilisateur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
		echo $this->Form->input('Montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'total','class'=>'form-control') );
                ?></div><div class="col-md-6"><?php
                echo $this->Form->input('Date_fn',array('label'=>'Jusqu\'Ã','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
		echo $this->Form->input('numero',array('div'=>'form-group','value'=>$mm,'between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('date',array('div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
                ?>
             <div class="form-group">
                                        <div class="col-lg-9 col-lg-offset-3 ">
                                                <button type="submit" class="btn btn-primary ordre">Afficher</button> 
                                                 
                                         </div>
             </div>
  </div>       
                                    
              <!-- Factures-->
              <div class="row ligne ordre"  <?php if(empty($show)){ ?>style="display: none"<?php } ?> >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Factures '); ?></h3>
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    
                                    <td align="center" nowrap="nowrap">Numero</td>
                                    <td align="center" nowrap="nowrap">Date</td>
                                    <td align="center" nowrap="nowrap">Total TTC</td>
                                    <td align="center" nowrap="nowrap">Reste</td>    
                                    <td align="center" nowrap="nowrap">Payer</td>    

                                </tr>
                                </thead>
                                <tbody>
                                    
                                <?php if(!empty($factures)){ foreach ($factures as $i=>$facture){     ?> 
                                
                                <tr class="cc" >
                                   <td style="width:24%">
                                        <?php echo $this->Form->input('id',array('type'=>'hidden','value'=>$facture['Facture']['id'],'label'=>'','div'=>'form-group', 'name' => 'data[Facture]['.$i.'][id]','table'=>'Facture','index'=>$i,'id'=>'id'.$i,'champ'=>'id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));?>
                                        <?php echo $this->Form->input('numero',array('readonly'=>'readonly','value'=>$facture['Facture']['numero'],'div'=>'form-group','label'=>'', 'name' => 'data[Facture]['.$i.'][numero]','table'=>'Facture','index'=>$i,'id'=>'numero'.$i,'champ'=>'numero','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  ','type'=>'text') );?>
                                    </td>
                                     <td style="width:24%" >
                                        <?php  echo $this->Form->input('date',array('readonly'=>'readonly','value'=>date("d/m/Y",strtotime(str_replace('-','/',$facture['Facture']['date']))),'label'=>'','div'=>'form-group', 'name' => 'data[Facture]['.$i.'][date]','table'=>'Facture','index'=>$i,'id'=>'date'.$i,'champ'=>'date','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','type'=>'text'));?>
                                    </td>
                                    <td style="width:24%">
                                        <?php echo $this->Form->input('totalttc',array('label'=>'Total TTC','readonly'=>'readonly','value'=>$facture['Facture']['totalttc'],'div'=>'form-group','label'=>'', 'name' => 'data[Facture]['.$i.'][totalttc]','table'=>'Facture','index'=>$i,'id'=>'totalttcc'.$i,'champ'=>'totalttc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:24%">
                                        <?php echo $this->Form->input('Reste',array('label'=>'Total TTC','readonly'=>'readonly','value'=>($facture['Facture']['totalttc']-$facture['Facture']['Montant_Regler']),'div'=>'form-group','label'=>'', 'name' => 'data[Facture]['.$i.'][totalttc]','table'=>'Facture','index'=>$i,'id'=>'totalttc'.$i,'champ'=>'totalttc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    
                                    <td style="width:4%"> <input type="checkbox" name="data[Facture][<?php echo $i ;?>][ok]" index="<?php echo $i ;?>" class="post" value="1"></td>
                               
                                </tr>
                                <?php  }} ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value="0" id="index" />
</div>
                            </div>
                        </div>                
</div> 
                                                              
                                    
<div  class="form-group ordre" <?php if(empty($show)){ ?>style="display: none"<?php } ?>>
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

