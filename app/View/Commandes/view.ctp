<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Commandes/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation Commande'); ?></h3>
                                </div>
                                <div class="panel-body">
          <?php echo $this->Form->create('Commande',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	        if(@$this->request->data['Fournisseur']['devise_id']!=1){
                ?>
                <?php
                echo $this->Form->input('fournisseur_id',array('type'=>'hidden','value'=>@$fr,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fc','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('frs',array('label'=>'Fournisseur','readonly'=>'readonly','value'=>@$this->request->data['Fournisseur']['name'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                echo $this->Form->input('importation_id',array('type'=>'hidden','value'=>@$importation,'label'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'importation_id','class'=>'form-control') );		
		echo $this->Form->input('impo',array('label'=>'Importation','readonly'=>'readonly','value'=>@$this->request->data['Importation']['name'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                ?>
                <?php
                echo $this->Form->input('tr',array('readonly'=>'readonly','value'=>@$tr,'label'=>'Cours Devise','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'tr','class'=>'form-control ','type'=>'text') );
                echo $this->Form->input('coe',array('readonly'=>'readonly','value'=>@$coe,'label'=>'Coefficient','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coe','class'=>'form-control ','type'=>'text') );
                echo $this->Form->input('coefficient',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coef','class'=>'form-control calculcout','type'=>'hidden') );
                }else{
                echo $this->Form->input('fournisseur_id',array('disabled'=>'disabled','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fc','class'=>'form-control select artfournisseur','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
                }
          ?></div><div class="col-md-6"><?php
	        echo $this->Form->input('numero',array('div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('depot_id',array('disabled'=>'disabled','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );				
                echo $this->Form->input('date',array('readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','value'=>$day,'type'=>'text','after'=>'</div>','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire') );
          ?>
  </div>  
        <?php  if(@$this->request->data['Fournisseur']['devise_id']==1){   ?>                              <!-- Autre ligne commande-->
                   <div class="row ligne fournisseurinterne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne de Commande'); ?></h3>
                                    
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" width="38%"  nowrap="nowrap">Article</td>
                                    <td align="center" width="10%" nowrap="nowrap"> Qte </td>
                                    <td align="center" width="10%" nowrap="nowrap">Prix</td>    
                                    <td align="center" width="10%" nowrap="nowrap">Remise %</td>       
                                    <td align="center" width="10%" nowrap="nowrap">Fodec % </td>
                                    <td align="center" width="10%" nowrap="nowrap">TVA % </td>    
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;" >
                                    <td  champ="tdarticle" id="tdarticle">
                                        <?php echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'idarticle testligneinv','empty'=>'Veuillez Choisir !!') );?>

                                    </td>
                                   
                                  
                                    <td >
                                 <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignereception','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>

                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php 
                                     echo $this->Form->input('prixhtva',array('value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                     <?php //echo $this->Form->input('prix',array('type'=>'hidden','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'prixx','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php  echo $this->Form->input('fodec',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'fodec','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('tva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                 
                                </tr>
                                 <?php
                               
                                            foreach ($lignecommandes as $i=>$lr){
                                        ?> 
                                <tr class="cc" >
                                    <td  champ="tdarticle" id="tdarticle0" >
                                        <?php echo $this->Form->input('article_id',array('disabled'=>'disabled','value'=>$lr['Lignecommande']['article_id'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][article_id]','table'=>'Lignereception','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testligneinv idarticle select','onchange'=>'tvaart(0)','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                     <td >
                                     <?php echo $this->Form->input('sup',array('name'=>'data[Lignereception]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignereception','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                     <?php echo $this->Form->input('quantite',array('readonly'=>'readonly','value'=>$lr['Lignecommande']['quantite'],'label'=>'','div'=>'form-group', 'name' => 'data[Lignereception]['.$i.'][quantite]','table'=>'Lignereception','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur','required data-bv-notempty-message'=>'Champ Obligatoire') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixhtva',array('readonly'=>'readonly','value'=>$lr['Lignecommande']['prixhtva'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][prixhtva]','table'=>'Lignereception','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prixhtva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                     <?php //echo $this->Form->input('prix',array('type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][prix]','table'=>'Lignereception','index'=>$i,'id'=>'prixx'.$i,'champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('readonly'=>'readonly','value'=>$lr['Lignecommande']['remise'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][remise]','table'=>'Lignereception','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php  echo $this->Form->input('fodec',array('readonly'=>'readonly','value'=>$lr['Lignecommande']['fodec'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][fodec]','table'=>'Lignereception','index'=>$i,'id'=>'fodec'.$i,'champ'=>'fodec','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('tva',array('readonly'=>'readonly','value'=>$lr['Lignecommande']['tva'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][tva]','table'=>'Lignereception','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                </tr>
                                <?php } ?> 
                                </tbody>
                                </table>
              	                <input type="hidden" value="<?php echo $i; ?>" id="index" />
                                </div>
                            </div>
                        </div>                
                    </div>  
                  
        <?php     }else{    ?> 
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne bon de reception'); ?></h3>
                                    
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtableext" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" width="38%"  nowrap="nowrap">Article</td>
                                    <td align="center" width="8%" nowrap="nowrap"> Qte </td>
                                    <td align="center" width="8%" nowrap="nowrap">Prix</td>  
                                    <td align="center" width="8%" nowrap="nowrap">CDR</td>  
                                    <td align="center" width="8%" nowrap="nowrap">TVA % </td>    
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;">
                                    <td  champ="tdarticle" id="tdarticlee" >
                                        <?php echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'idarticle editligneinvarticle','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    
                                    <td >
                                         <?php echo $this->Form->input('id',array('name'=>'','id'=>'','champ'=>'id','table'=>'Lignereception','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignereception','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'') );?>
                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculcout') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixhtva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('cout de revien ',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                   
                                    <td >
                                     <?php echo $this->Form->input('tva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                 
                                </tr>
                                     <?php
                               
                                            foreach ($lignecommandes as $i=>$lr){
                                        ?> 
                                <tr class="cc">
                                    <td >
                                       <?php //echo $this->Form->input('id',array('value'=>$lr['Lignereception']['id'],'name'=>'data[Lignereception]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignereception','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('sup',array('name'=>'data[Lignereception]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignereception','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('article_id',array('disabled'=>'disabled','value'=>$lr['Lignecommande']['article_id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignereception]['.$i.'][article_id]','table'=>'Lignereception','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select idarticle editligneinvarticle','empty'=>'Veuillez choisir !!') );?>               
                                    </td>
                                    
                                     <td >
                                        <?php echo $this->Form->input('quantite',array('readonly'=>'readonly','value'=>$lr['Lignecommande']['quantite'],'label'=>'','div'=>'form-group', 'name' => 'data[Lignereception]['.$i.'][quantite]','table'=>'Lignereception','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr editfacfournisseur') );?>
                                     </td>
                                    <td >
                                     <?php echo $this->Form->input('prixhtva',array('readonly'=>'readonly','value'=>$lr['Lignecommande']['prix'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][prix]','table'=>'Lignereception','index'=>$i,'id'=>'prix'.$i,'champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixhtva',array('readonly'=>'readonly','value'=>$lr['Lignecommande']['prixhtva'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][prixhtva]','table'=>'Lignereception','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr editfacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('tva',array('readonly'=>'readonly','value'=>$lr['Lignecommande']['tva'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][tva]','table'=>'Lignereception','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control editfacfournisseur') );?>
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
        <?php     }   ?> 
                <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('remise',array('div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'remise','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	        echo $this->Form->input('tva',array('label'=>'TVA','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('fodec',array('div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'fodec','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		
                ?>
                </div>
                <div class="col-md-6"><?php
		echo $this->Form->input('totalht',array('label'=>'Total HT','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_HT','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('totalttc',array('label'=>'Total TTC','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_TTC','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	        ?>
                </div> 
                                    

<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

