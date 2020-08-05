<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?><?php echo @$model_ans; ?>/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout '.$desg); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create($model,array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );		
		if(@$entete['Fournisseur']['devise_id']!=1){ 
                echo $this->Form->input('fournisseurid',array('value'=>@$entete['Fournisseur']['name'],'readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fc','class'=>'form-control','type'=>'text') );
                echo $this->Form->input('fournisseur_id',array('value'=>@$entete['Fournisseur']['id'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fc','class'=>'form-control','type'=>'hidden') );
		echo $this->Form->input('importation_id',array('value'=>@$entete['Importation']['id'],'empty'=>'Veuillez Choisir !!','label'=>'Importation','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'importation_id','class'=>'form-control select get_tr_coe') );		
                //echo $this->Form->input('importation_id',array('type'=>'hidden','value'=>@$importation,'label'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'importation_id','class'=>'form-control') );		
		//echo $this->Form->input('impo',array('label'=>'Importation','readonly'=>'readonly','value'=>@$entete['Importation']['name'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                //echo $this->Form->input('coefficient',array('value'=>@$coef,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coef','class'=>'form-control calculcout','type'=>'text') );
                echo $this->Form->input('tr',array('readonly'=>'readonly','value'=>@$tr,'label'=>'Cours Devise','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'tr','class'=>'form-control ','type'=>'text') );
                echo $this->Form->input('coe',array('readonly'=>'readonly','value'=>@$coe,'label'=>'Coefficient','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coe','class'=>'form-control ','type'=>'text') );
                echo $this->Form->input('coefficient',array('value'=>@$tr*@$coe,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coef','class'=>'form-control calculcout','type'=>'hidden') );
                }else{
                echo $this->Form->input('fournisseur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fc','class'=>'form-control select ','empty'=>'Veuillez Choisir !!') );
                }
                if(@$entete[$model_ans]['type']=="direct"){ 
                //echo $this->Form->input('depot_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez Choisir !!') );				
                }else{
                //echo $this->Form->input('depot_id',array('type'=>'hidden','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );				
                //echo $this->Form->input('depotid',array('label'=>'Depot','readonly'=>'readonly','value'=>@$entete['Depot']['designation'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );				
                }
                if(@$entete[$model_ans]['compte_id']!=''){
                      echo $this->Form->input('compte_id',array('type'=>'hidden','value'=>@$entete[$model_ans]['compte_id'],'empty'=>'Veuillez Choisir !!','label'=>'Banque','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		     echo $this->Form->input('compteid',array('readonly'=>'readonly','value'=>$comptes[@$entete[$model_ans]['compte_id']],'label'=>'Banque','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		 }
                ?></div><div class="col-md-6"><?php
                
                echo $this->Form->input('numero',array('value'=>$mm,'label'=>'Numéro Interne','readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ') );
                echo $this->Form->input('date',array('div'=>'form-group','value'=>$day,'between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'text','class'=>'form-control datePickerOnly ') );                
                echo $this->Form->input('type',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'type','class'=>'form-control','type'=>'hidden') );
		
                if(($model=="Bonlivraison")||($model=="Facture")){
                echo $this->Form->input('numero',array('label'=>'Numéro '.$model,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('datefacture',array('label'=>'Date '.$model,'div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );
                }else{
		echo $this->Form->input('depot_id',array('value'=>$entete[$model_ans]['depot_id'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez Choisir !!') );				
                }
                //echo $this->Form->input('typefac',array('value'=>@$entete['Facture']['type'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','type'=>'hidden') );
                ?>
             <input  name="data[<?php echo $model ;?>][devise_id]" type="hidden" value="<?php echo @$entete['Fournisseur']['devise_id'] ; ?>" id="typefrs" />                       
                    
  </div>    
   <!-- Autre ligne fournisseur interne  -->
   <?php
  
       
    if(@$entete['Fournisseur']['devise_id']==1){   ?>
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne de '.$desg); ?></h3>
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
                                    <td align="center" nowrap="nowrap" width="1%" ></td>
                                    <?php if(($model=="Bonlivraison")||($model=="Facture")){ ?>
                                    <td align="center" width="12%"  nowrap="nowrap">Depot</td>
                                    <?php } ?>
                                    <td align="center" width="22%"  nowrap="nowrap">Article</td>
                                    <td align="center" width="8%" nowrap="nowrap"> Qte </td>
                                    <td align="center" width="10%" nowrap="nowrap">Dernier Prix</td>  
                                    <td align="center" width="10%" nowrap="nowrap">Dernier M%</td>  
                                    <td align="center" width="10%" nowrap="nowrap">Prix</td>    
                                    <td align="center" width="10%" nowrap="nowrap">Remise %</td>       
                                    <td align="center" width="8%" nowrap="nowrap">Fodec % </td>
                                    <td align="center" width="8%" nowrap="nowrap">TVA % </td>    
                                    <td align="center" width="1%"></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;">
                                    <td id="" champ="tdaff" index="" >
                                     <span title="changer le prix de vente"> <a style="display:none;" onclick="recap_achat()" href="#reModal_refuser" id="" index="" champ="order" value="0" <button class=' '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                    <?php if(($model=="Bonlivraison")||($model=="Facture")){ ?>
                                    <td>
                                       <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>' ','empty'=>'Veuillez Choisir !!') );?>
                                    
                                    </td>
                                    <?php } ?>
                                    <td champ="tdarticle" id="tdarticle" >
                                        <?php echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'idarticle  editligneinvarticle','empty'=>'Veuillez Choisir !!') );?>
                                       <?php echo $this->Form->input('margeA',array('name'=>'','id'=>'','champ'=>'margeA','table'=>'Lignefacture','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                       <?php echo $this->Form->input('pvA',array('name'=>'','id'=>'','champ'=>'pvA','table'=>'Lignefacture','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                    
                                    </td>
                                   
                                    <td >
                                        <?php echo $this->Form->input('id',array('name'=>'','id'=>'','champ'=>'id','table'=>'Lignefacture','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignefacture','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('prixachatans',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => '','table'=>'Lignefacture','index'=>'0','id'=>'','champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('margeans',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => '','table'=>'Lignefacture','index'=>'0','id'=>'','champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixhtva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php  echo $this->Form->input('fodec',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'fodec','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('ltva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                 
                                      <td align="center"><i index=""  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                     <?php
                               
                                            foreach ($lignes as $i=>$lr){
                                          // debug($lr);die;
                                                //zeinab
                                        $factures = ClassRegistry::init('Lignefacture')->find('first',array(
                                        'conditions'=>array('Facture.fournisseur_id'=>@$entete['Fournisseur']['id'],'Lignefacture.article_id'=>$lr['Article']['id'])
                                        ,'order'=>array('Lignefacture.id'=>'desc')
                                        ,'recursive' =>0));
                                       if(!empty($factures)){ 
                                           $prixff=$factures['Lignefacture']['prixhtva'];
                                           $datef=$factures['Facture']['date'];
                                       }else{
                                           $prixff=0;
                                           $datef='1900-01-01';
                                       }
                                      $receptions = ClassRegistry::init('Lignereception')->find('first',array(
                                          'conditions'=>array('Bonreception.fournisseur_id'=>@$entete['Fournisseur']['id'],'Lignereception.article_id'=>$lr['Article']['id'])
                                          ,'order'=>array('Lignereception.id'=>'desc')
                                          ,'recursive' =>0));
                                       if(!empty($receptions)){ 
                                          $prixrr=$receptions['Lignereception']['prixhtva'];
                                          $dater=$receptions['Bonreception']['date'];
                                      }else{
                                           $prixrr=0;
                                           $dater='1900-01-01';
                                       } 

                                      if($dater>$datef){
                                          $prix_anc=$prixrr;
                                      }
                                      else{
                                           $prix_anc=$prixff;
                                      }
                                        ?> 
                                 <?php if(($model_ans=="Bonlivraison")||($model_ans=="Facture")){ 
                                 $depot=@$lr[$ligne_ans]['depot_id'];
                                 }else{
                                 $depot=@$entete[$model_ans]['depot_id'];    
                                 }
                                ?>
                                <tr class="cc">
                                    <td id="tdaff0" >
                                    <span title="changer le prix de vente"><a  onclick="recap_achat(<?php echo $i; ?>)" href="#reModal_refuser" champ="order" id="order<?php echo $i; ?>" value="<?php echo $i; ?>" <button class='  '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                    <?php if(($model=="Bonlivraison")||($model=="Facture")){ ?>
                                    <td >
                                       <?php echo $this->Form->input('depot_id',array('value'=>@$depot,'div'=>'form-group','label'=>'',  'name' => 'data[Lignefacture]['.$i.'][depot_id]','table'=>'Lignefacture','index'=>$i,'id'=>'depot_id'.$i,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select ','empty'=>'Veuillez choisir !!') );?>               
                                    
                                    </td>
                                    <?php } ?>
                                    <td >
                                       <?php echo $this->Form->input('id',array('value'=>$lr[$ligne_ans]['id'],'name'=>'data[Lignefacture]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignefacture','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('sup',array('name'=>'data[Lignefacture]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignefacture','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control ','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('article_id',array('value'=>$lr['Article']['id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignefacture]['.$i.'][article_id]','table'=>'Lignefacture','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select idarticle editligneinvarticle','empty'=>'Veuillez choisir !!') );?>               
                                       <?php echo $this->Form->input('margeA',array('name'=>'data[Lignefacture]['.$i.'][margeA]','id'=>'margeA'.$i,'champ'=>'margeA','table'=>'Lignefacture','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('pvA',array('name'=>'data[Lignefacture]['.$i.'][pvA]','id'=>'pvA'.$i,'champ'=>'pvA','table'=>'Lignefacture','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                    </td>
                                   
                                     <td >
                                        <?php echo $this->Form->input('quantite',array('value'=>$lr[$ligne_ans]['quantite'],'label'=>'','div'=>'form-group', 'name' => 'data[Lignefacture]['.$i.'][quantite]','table'=>'Lignefacture','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                     </td>
                                     <td >
                                    <?php echo $this->Form->input('prixachatans',array('value'=>sprintf("%01.3f",$prix_anc),'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignefacture]['.$i.'][prixachatans]','table'=>'Lignefacture','index'=>$i,'id'=>'prixachatans'.$i,'champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('margeans',array('value'=>$lr['Article']['marge'],'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignefacture]['.$i.'][margeans]','table'=>'Lignefacture','index'=>$i,'id'=>'margeans'.$i,'champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixhtva',array('value'=>$lr[$ligne_ans]['prixhtva'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][prixhtva]','table'=>'Lignefacture','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('value'=>$lr[$ligne_ans]['remise'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][remise]','type'=>'text','table'=>'Lignefacture','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    
                                    <td >
                                     <?php  echo $this->Form->input('fodec',array('value'=>$lr[$ligne_ans]['fodec'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][fodec]','table'=>'Lignefacture','index'=>$i,'id'=>'fodec'.$i,'champ'=>'fodec','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('ltva',array('value'=>$lr[$ligne_ans]['tva'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][tva]','table'=>'Lignefacture','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td align="center"><i index="<?php echo $i; ?>"  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                 <?php } ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo @$i; ?>"  id="index" />
</div>
                            </div>
                        </div>                
</div> 
    <?php     }else{    ?>                                                    
   <!-- Autre ligne // fournisseur externe  -->                                                                
              <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne de '.$desg); ?></h3>
                                    <a class="btn btn-danger ajouterligne_reception" table='addtableext' index='index'  tr="tr" style="
                                    float: right; 
                                    position: relative;
                                    top: -25px;
                                "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtableext" style="width:100%" align="center" >
                                <thead>
                               <tr>
                                    <td align="center" nowrap="nowrap" width="1%" ></td>
                                    <?php if(($model=="Bonlivraison")||($model=="Facture")){ ?>
                                    <td align="center" width="13%"  nowrap="nowrap">Depot</td>
                                    <?php } ?>
                                    <td align="center" width="20%"  nowrap="nowrap">Article</td>
                                    <?php if(($model !="Bonlivraison")||($model !="Facture")){ ?>
                                    <td align="center" width="8%"  nowrap="nowrap">Réference</td>
                                    <?php } ?>
                                    <td align="center" width="9%" nowrap="nowrap"> Qte </td>
                                    <td align="center" width="8%" nowrap="nowrap">Dernier Prix</td>  
                                    <td align="center" width="8%" nowrap="nowrap">Dernier M%</td>
                                    <td align="center" width="10%" nowrap="nowrap">Prix</td> 
                                    <td align="center" width="8%" nowrap="nowrap">Remise%</td>
                                    <td align="center" width="10%" nowrap="nowrap">CR TTC</td>  
                                    <td align="center" width="5%" nowrap="nowrap">TVA % </td>     
                                    <td align="center" width="1%"></td>
                                </tr>
                                </thead>
                                    <?php $tablesemi='Lignefacture'; ?>
                                    <input id="lachaine" type="hidden" value="depot_id,code,designation,reference,quantite,prix,remise,prixhtva,tva" >
                                <tbody>
                                <tr class="tr" style="display:none;">
                                    <td id="" champ="tdaff" index="" >
                                     <span title="changer le prix de vente"> <a style="display:none;" onclick="recap_achat()" href="#reModal_refuser" id="" index="" champ="order" value="0" <button class=' '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                    <?php if(($model=="Bonlivraison")||($model=="Facture")){ ?>
                                    <td>
                                        <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'','empty'=>'Veuillez Choisir !!') );?>
                                    
                                    </td>
                                    <?php } ?>
                                    <td champ="tdarticle" id="tdarticlee">
                                         <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'idarticle  editligneinvarticle','empty'=>'Veuillez Choisir !!') );?>
                                         <?php echo $this->Form->input('margeA',array('name'=>'','id'=>'','champ'=>'margeA','table'=>'Lignefacture','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                         <?php echo $this->Form->input('pvA',array('name'=>'','id'=>'','champ'=>'pvA','table'=>'Lignefacture','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php
                                            echo $this->Form->input('article_id', array('div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                            echo $this->Form->input('code', array('div' => 'form-group','placeholder'=>'Code','label'=>'', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcodeachat', 'type' => 'text'));
                                            ?>
                                            <!--                                            style="background-color:white;position: absolute; top: -10px;right: -500px; width:500px;z-index: 1000px;"-->
                                            <!--                                            onMouseOut="this.style.visibility = 'hidden';"-->
                                        </div>
                                    </td>
                                    <?php if(($model!="Bonlivraison")||($model!="Facture")){ ?>
                                    <td >
                                     <?php echo $this->Form->input('reference',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'reference','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <?php } ?>
                                    <td >
                                       <?php echo $this->Form->input('id',array('name'=>'','id'=>'','champ'=>'id','table'=>'Lignefacture','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignefacture','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                       <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculcout') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('prixachatans',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => '','table'=>'Lignefacture','index'=>'0','id'=>'','champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('margeans',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => '','table'=>'Lignefacture','index'=>'0','id'=>'','champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                     <?php 
                                        echo $this->Form->input('tttva',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'tttva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('ttc',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'totalttc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('ht',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'totalht','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('prix_anc',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'prix_anc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        
                                        echo $this->Form->input('prixhtva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control CalculPrix') );?>
                                    </td>
                                     <td >
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout'));?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('cout de revien ',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculcout') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('ltva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculcout') );?>
                                    </td>
                                 
                                      <td align="center"><i index=""  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                <tr class="tr" style="display:none;" >

                                    <td colspan="12" id="" index="" champ="tddesg">
                                        <div class="" style="display:inline; position: relative;">
                                            <?php  echo $this->Form->input('designation', array('div' => 'form-group','placeholder'=>'Designation','label'=>'', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselectachat', 'type' => 'text'));
                                            ?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                        </div>
                                    </td>
                                </tr>

                                <?php
                                        $ht=0;
                                        $tva=0;
                                        $ttc=0;
                                        $ttdv=0;
                                            foreach ($lignes as $i=>$lr){
                                        $ttdv=$ttdv+($lr[$ligne_ans]['prix']*$lr[$ligne_ans]['quantite']);        
                                        $ttc=$ttc+($lr[$ligne_ans]['prix']*$lr[$ligne_ans]['quantite']*@$tr*@$coe) ;       
                                        $ht=$ht+(($lr[$ligne_ans]['prix']*$lr[$ligne_ans]['quantite']*@$tr*@$coe)/(1+($lr[$ligne_ans]['tva']/100)));  
                                        $tva=$ttc-$ht; 
                                          
                                            //zeinab
                                              $factures = ClassRegistry::init('Lignefacture')->find('first',array(
                                          'conditions'=>array('Facture.fournisseur_id'=>@$entete['Fournisseur']['id'],'Lignefacture.article_id'=>$lr['Article']['id'])
                                          ,'order'=>array('Lignefacture.id'=>'desc')
                                          ,'recursive' =>0));
                                       if(!empty($factures)){ 
                                           $prixff=$factures['Lignefacture']['prixhtva'];
                                           $datef=$factures['Facture']['date'];
                                       }else{
                                           $prixff=0;
                                           $datef='1900-01-01';
                                       }
                                      $receptions = ClassRegistry::init('Lignereception')->find('first',array(
                                          'conditions'=>array('Bonreception.fournisseur_id'=>@$entete['Fournisseur']['id'],'Lignereception.article_id'=>$lr['Article']['id'])
                                          ,'order'=>array('Lignereception.id'=>'desc')
                                          ,'recursive' =>0));
                                       if(!empty($receptions)){ 
                                          $prixrr=$receptions['Lignereception']['prixhtva'];
                                          $dater=$receptions['Bonreception']['date'];
                                      }else{
                                           $prixrr=0;
                                           $dater='1900-01-01';
                                       } 

                                      if($dater>$datef){
                                          $prix_anc=$prixrr;
                                      }
                                      else{
                                           $prix_anc=$prixff;
                                      }
                                        ?> 
                                 <?php if(($model_ans=="Bonlivraison")||($model_ans=="Facture")){ 
                                 $depot=@$lr[$ligne_ans]['depot_id'];
                                 }else{
                                 $depot=@$entete[$model_ans]['depot_id'];    
                                 }
                                ?>
                                <tr class="cc">
                                    <td id="tdaff0" >
                                    <span title="changer le prix de vente"><a  onclick="recap_achat(<?php echo $i; ?>)" href="#reModal_refuser" champ="order" id="order<?php echo $i; ?>" value="<?php echo $i; ?>" <button class='  '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                    <?php if(($model=="Bonlivraison")||($model=="Facture")){ ?>
                                    <td >
                                       <?php echo $this->Form->input('depot_id',array('value'=>@$depot,'div'=>'form-group','label'=>'','onchange'=>'fuckfocus("select","'.$i.'",this.getAttribute("name"))',  'name' => 'data[Lignefacture]['.$i.'][depot_id]','table'=>'Lignefacture','index'=>$i,'id'=>'depot_id'.$i,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select','empty'=>'Veuillez choisir !!') );?>
                                    </td>
                                    <?php } ?>
                                    <td >
                                       <?php echo $this->Form->input('id',array('value'=>$lr[$ligne_ans]['id'],'name'=>'data[Lignefacture]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignefacture','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('sup',array('name'=>'data[Lignefacture]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignefacture','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control ','label'=>'Nom') );?>
<!--                                       --><?php /*echo $this->Form->input('article_id',array('value'=>$lr['Article']['id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignefacture]['.$i.'][article_id]','table'=>'Lignefacture','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select idarticle editligneinvarticle','empty'=>'Veuillez choisir !!') );*/?>
                                       <?php echo $this->Form->input('margeA',array('name'=>'data[Lignefacture]['.$i.'][margeA]','id'=>'margeA'.$i,'champ'=>'margeA','table'=>'Lignefacture','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('pvA',array('name'=>'data[Lignefacture]['.$i.'][pvA]','id'=>'pvA'.$i,'champ'=>'pvA','table'=>'Lignefacture','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php
                                            echo $this->Form->input('article_id', array('div' => 'form-group','value'=>$lr['Article']['id'], 'name' => 'data['.$tablesemi.']['.$i.'][article_id]', 'table' => $tablesemi, 'index' => $i, 'id' => 'article_id'.$i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                            echo $this->Form->input('code', array('div' => 'form-group','placeholder'=>'Code','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','value'=>$lr['Article']['code'],'label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code'.$i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcodeachat', 'type' => 'text'));
                                            ?>
                                            <!--                                            style="background-color:white;position: absolute; top: -10px;right: -500px; width:500px;z-index: 1000px;"-->
                                            <!--                                            onMouseOut="this.style.visibility = 'hidden';"-->
                                        </div>
                                    </td>
                                    <?php if(($model!="Bonlivraison")||($model!="Facture")){ ?>
                                    <td >
                                     <?php echo $this->Form->input('reference',array('value'=>$lr[$ligne_ans]['reference'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][reference]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'reference'.$i,'champ'=>'reference','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <?php } ?>
                                     <td >
                                        <?php echo $this->Form->input('quantite',array('value'=>$lr[$ligne_ans]['quantite'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','label'=>'','div'=>'form-group', 'name' => 'data[Lignefacture]['.$i.'][quantite]','table'=>'Lignefacture','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                     </td>
                                    <td >
                                    <?php echo $this->Form->input('prixachatans',array('value'=>sprintf("%01.3f",$prix_anc),'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignefacture]['.$i.'][prixachatans]','table'=>'Lignefacture','index'=>$i,'id'=>'prixachatans'.$i,'champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('margeans',array('value'=>$lr['Article']['marge'],'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignefacture]['.$i.'][margeans]','table'=>'Lignefacture','index'=>$i,'id'=>'margeans'.$i,'champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                     <?php 
                                     echo $this->Form->input('ttc',array('value'=>$lr[$ligne_ans]['totalttc'],'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][totalttc]','table'=>'Lignefacture','index'=>$i,'id'=>'totalttc'.$i,'champ'=>'totalttc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                     echo $this->Form->input('ht',array('value'=>$lr[$ligne_ans]['totalht'],'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][totalht]','table'=>'Lignefacture','index'=>$i,'id'=>'totalht'.$i,'champ'=>'totalht','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                     echo $this->Form->input('prix_anc',array('value'=>sprintf("%01.2f",$lr[$ligne_ans]['prix_anc']),'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][prix_anc]','table'=>'Lignefacture','index'=>$i,'id'=>'prix_anc'.$i,'champ'=>'prix_anc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                      
                                     echo $this->Form->input('prixhtva',array('value'=>sprintf("%01.2f",$lr[$ligne_ans]['prix']),'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][prix]','table'=>'Lignefacture','index'=>$i,'id'=>'prix'.$i,'champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control CalculPrix') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('value'=>$lr[$ligne_ans]['remise'],'div'=>'form-group','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][remise]','table'=>'Lignefacture','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                     <td >
                                     <?php 
                                     echo $this->Form->input('cout de revien ',array('value'=>$lr[$ligne_ans]['prixhtva'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][prixhtva]','table'=>'Lignefacture','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                    <td>
                                     <?php echo $this->Form->input('ltva',array('value'=>$lr[$ligne_ans]['tva'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][tva]','table'=>'Lignefacture','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                    <td align="center"><i index="<?php echo $i; ?>"  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                <tr class="cc">
                                    <td colspan="12" id="tddesg<?php echo $i; ?>" index="<?php echo $i; ?>" champ="tddesg">

                                        <div class="" style="display:inline; position: relative;">
                                            <?php  echo $this->Form->input('designation', array('value'=>$lr['Article']['name'],'div' => 'form-group','placeholder'=>'Designation','label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][designation]', 'table' => $tablesemi, 'index' => $i, 'id' => 'designation'.$i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselectachat', 'type' => 'text')); ?>
                                            <div id="res<?php echo $i; ?>" champ="res" index="<?php echo $i; ?>"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                        </div>
                                    </td>
                                </tr>

                                 <?php } ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo @$i; ?>"  id="index" />
</div>
                            </div>
                        </div>                
</div>  
   <?php     }   ?>  
            
                <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="popachat">
                      
                        
                    </div>
                    <br>
                   
                  <a  class="remodal-confirm ls-light-green-btn btn" onclick="validerprixdevente()"><strong>OK</strong></a>                
                </div> 
               
              <div class="col-md-6">                  
              	<?php
                if(@$entete['Fournisseur']['devise_id']!=1){
                $remise=0;
                $tvat=$tva;
                $fodec=0;
                $m_ht=$ht;
                $m_ttc=$ttc;
                $timbre="";
                $m_ht=$ht+(@$entete[$model_ans]['fret']*@$tr*@$coe)-(@$entete[$model_ans]['avoir']*@$tr*@$coe);
                $m_ttc=$ttc+(@$entete[$model_ans]['fret']*@$tr*@$coe)-(@$entete[$model_ans]['avoir']*@$tr*@$coe);
		echo $this->Form->input('mdinitial',array('value'=>sprintf("%01.2f",@$ttdv),'label'=>'Montant devise initial','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'mdi','class'=>'form-control') );
                echo $this->Form->input('fret',array('value'=>@$entete[$model_ans]['fret'],'label'=>'Fret','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','id'=>'fret','class'=>'form-control calculcout') );
		echo $this->Form->input('avoir',array('value'=>@$entete[$model_ans]['avoir'],'label'=>'Avoir','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','id'=>'avoir','class'=>'form-control calculcout') );
		echo $this->Form->input('montantdevise',array('label'=>'Montant devise final','value'=>sprintf("%01.2f",@$ttdv+(@$entete[$model_ans]['fret'])-(@$entete[$model_ans]['avoir'])),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'montantdevise','class'=>'form-control') );
                
                }else{
                $remise=@$entete[$model_ans]['remise'];
                $tvat=@$entete[$model_ans]['tva'];
                $fodec=@$entete[$model_ans]['fodec'];
                $m_ht=@$entete[$model_ans]['totalht'];
                $m_ttc=@$entete[$model_ans]['totalttc'];    
               
		echo $this->Form->input('remise',array('value'=>sprintf("%01.3f",@$remise),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'remise','class'=>'form-control') );
	        echo $this->Form->input('tva',array('label'=>'TVA','value'=>sprintf("%01.3f",@$tvat),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control') );
                echo $this->Form->input('fodec',array('value'=>sprintf("%01.3f",@$fodec),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'fodec','class'=>'form-control') );
                } ?></div><div class="col-md-6"><?php
                echo $this->Form->input('totalht',array('label'=>'Total HT','value'=>sprintf("%01.3f",@$m_ht),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_HT','class'=>'form-control') );
		if(@$entete['Fournisseur']['devise_id']!=1){
                echo $this->Form->input('tva',array('label'=>'TVA','value'=>sprintf("%01.3f",@$tvat),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		}
                echo $this->Form->input('totalttc',array('label'=>'Total TTC','value'=>sprintf("%01.3f",@$m_ttc),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_TTC','class'=>'form-control') );
	        ?>
              </div> 
               
   
                   
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary   ">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

