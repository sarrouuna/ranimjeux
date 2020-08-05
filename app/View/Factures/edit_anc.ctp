<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Factures/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification Facture'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Facture',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
                if($p==0){
                echo $this->Form->input('pointdevente_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select'));
                }
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );		
		if(@$this->request->data['Fournisseur']['devise_id']!=1){ 
                echo $this->Form->input('fournisseurid',array('value'=>@$this->request->data['Fournisseur']['name'],'readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fc','class'=>'form-control','type'=>'text') );
                echo $this->Form->input('fournisseur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fc','class'=>'form-control','type'=>'hidden') );
		echo $this->Form->input('importation_id',array('type'=>'hidden','value'=>@$importation,'label'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'importation_id','class'=>'form-control') );		
		echo $this->Form->input('impo',array('label'=>'Importation','readonly'=>'readonly','value'=>@$this->request->data['Importation']['name'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                //echo $this->Form->input('coefficient',array('value'=>@$coef,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coef','class'=>'form-control calculcout','type'=>'text') );
                echo $this->Form->input('tr',array('readonly'=>'readonly','value'=>@$tr,'label'=>'Cours Devise','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'tr','class'=>'form-control ','type'=>'text') );
                echo $this->Form->input('coe',array('readonly'=>'readonly','value'=>@$coe,'label'=>'Coefficient','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coe','class'=>'form-control ','type'=>'text') );
                echo $this->Form->input('coefficient',array('value'=>@$tr*@$coe,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coef','class'=>'form-control calculcout','type'=>'hidden') );
                }else{
                echo $this->Form->input('coefficient',array('value'=>1,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coef','class'=>'form-control calculcout','type'=>'hidden') );
                echo $this->Form->input('fournisseur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fc','class'=>'form-control select ','empty'=>'Veuillez Choisir !!') );
                }
                if(@$this->request->data['Facture']['type']=="direct"){ 
                //echo $this->Form->input('depot_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez Choisir !!') );				
                }else{
                //echo $this->Form->input('depot_id',array('type'=>'hidden','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );				
                //echo $this->Form->input('depotid',array('label'=>'Depot','readonly'=>'readonly','value'=>@$this->request->data['Depot']['designation'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );				
                }
                if($this->request->data['Facture']['compte_id']!=''){
                      echo $this->Form->input('compte_id',array('type'=>'hidden','value'=>$this->request->data['Facture']['compte_id'],'empty'=>'Veuillez Choisir !!','label'=>'Banque','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		     echo $this->Form->input('compteid',array('readonly'=>'readonly','value'=>$comptes[$this->request->data['Facture']['compte_id']],'label'=>'Banque','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		 }
                ?></div><div class="col-md-6"><?php
                if($datefac=="01/01/1970"){$datefac=date("d/m/Y");}
                echo $this->Form->input('numeroconca',array('label'=>'Numéro Interne','readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ') );
                echo $this->Form->input('date',array('div'=>'form-group','value'=>$day,'between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'text','class'=>'form-control datePickerOnly ') );                
                echo $this->Form->input('type',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coef','class'=>'form-control calculcout','type'=>'hidden') );
		echo $this->Form->input('numero',array('label'=>'Numéro Facture','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('datefacture',array('label'=>'Date Facture','div'=>'form-group','value'=>@$datefac,'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );
                echo $this->Form->input('typefac',array('value'=>@$this->request->data['Facture']['type'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','type'=>'hidden') );
                ?>
             <input  name="data[Facture][devise_id]" type="hidden" value="<?php echo @$this->request->data['Fournisseur']['devise_id'] ; ?>" id="typefrs" />                       
                    
  </div>    
   <!-- Autre ligne fournisseur interne  -->
   <?php
   if($this->request->data['Facture']['type']=="service"){ ?>
     <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modifier facture Service'); ?></h3>
                                    
                                </div>
                                <div class="panel-body">
                                                   
              	<?php 
                $remise=@$this->request->data['Facture']['remise'];
                $tvat=@$this->request->data['Facture']['tva'];
                $fodec=@$this->request->data['Facture']['fodec'];
                $m_ht=@$this->request->data['Facture']['totalht'];
                $m_ttc=@$this->request->data['Facture']['totalttc'];    
                ?>
                <?php
                ?><div class="col-md-6"><?php
		echo $this->Form->input('totalttc',array('label'=>'Total TTC','value'=>sprintf("%01.3f",@$m_ttc),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','id'=>'Total_TTC','class'=>'form-control') );
	        ?>
              </div>                         
   
</div>
                            </div>
                        </div>                
</div>  
   
   <?php }else{
       
    if(@$this->request->data['Fournisseur']['devise_id']==1){   ?>
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne de facture'); ?></h3>
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
                                    <td align="center" width="12%"  nowrap="nowrap">Depot</td>
                                    <td align="center" width="22%"  nowrap="nowrap">Article</td>
                                    <td align="center" width="7%" nowrap="nowrap"> Qte </td>
                                    <td align="center" width="10%" nowrap="nowrap">Dernier Prix</td>  
                                    <td align="center" width="10%" nowrap="nowrap">Dernier M%</td>  
                                    <td align="center" width="10%" nowrap="nowrap">Prix</td>    
                                    <td align="center" width="8%" nowrap="nowrap">Remise %</td>       
                                    <td align="center" width="6%" nowrap="nowrap">Fodec % </td>
                                    <td align="center" width="4%" nowrap="nowrap">TVA % </td>    
                                    <td align="center" width="8%" nowrap="nowrap">Date Expiration</td>    
                                    <td align="center" width="1%"></td>
                                </tr>
                                </thead>
                                    <?php $tablesemi='Lignefacture'; ?>
                                    <input id="lachaine" type="hidden" value="depot_id,code,designation,quantite,prixhtva,remise,fodec,tva" >
                                <tbody>
                                <tr class="tr" style="display:none;">
                                    <td id="" champ="tdaff" index="" >
                                     <span title="changer le prix de vente"> <a style="display:none;" onclick="recap_achat()" href="#reModal_refuser" id="" index="" champ="order" value="0" <button class=' '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                    <td>
                                       <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>' ','empty'=>'Veuillez Choisir !!') );?>
                                    
                                    </td>
                                    <td champ="tdarticle" id="tdarticle" >
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
                                     <?php echo $this->Form->input('tva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td><input table='Lignefacture' champ='date_exp'  index='0' id='' value="" class="form-control" ></td>
                                 
                                      <td align="center"><i index=""  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>

                               <!-- <tr class="tr" style="display:none;" >

                                    <td colspan="12" id="" index="" champ="tddesg">
                                        <div class="" style="display:inline; position: relative;">
                                            <?php /* echo $this->Form->input('designation', array('div' => 'form-group','placeholder'=>'Designation','label'=>'', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselectachat', 'type' => 'text'));
                                            */?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                        </div>
                                    </td>
                                </tr>-->


                                     <?php
                               
                                            foreach ($lignefactures as $i=>$lr){
                                          // debug($lr);die;
                                                //zeinab
                                              $factures = ClassRegistry::init('Lignefacture')->find('first',array(
                                          'conditions'=>array('Facture.fournisseur_id'=>$this->request->data['Fournisseur']['id'],'Lignefacture.article_id'=>$lr['Article']['id'])
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
                                          'conditions'=>array('Bonreception.fournisseur_id'=>$this->request->data['Fournisseur']['id'],'Lignereception.article_id'=>$lr['Article']['id'])
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
                                <tr class="cc">
                                    <td id="tdaff0" >
                                    <span title="changer le prix de vente"><a  onclick="recap_achat(<?php echo $i; ?>)" href="#reModal_refuser" champ="order" id="order<?php echo $i; ?>" value="<?php echo $i; ?>" <button class='  '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                    <td >
                                       <?php echo $this->Form->input('depot_id',array('value'=>@$lr['Lignefacture']['depot_id'],'onchange'=>'fuckfocus("select","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'',  'name' => 'data[Lignefacture]['.$i.'][depot_id]','table'=>'Lignefacture','index'=>$i,'id'=>'depot_id'.$i,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select ','empty'=>'Veuillez choisir !!') );?>
                                    
                                    </td>
                                    <td >
                                       <?php echo $this->Form->input('id',array('value'=>$lr['Lignefacture']['id'],'name'=>'data[Lignefacture]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignefacture','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('sup',array('name'=>'data[Lignefacture]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignefacture','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control ','label'=>'Nom') );?>
                                       <?php //echo $this->Form->input('article_id',array('value'=>$lr['Article']['id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignefacture]['.$i.'][article_id]','table'=>'Lignefacture','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select idarticle editligneinvarticle','empty'=>'Veuillez choisir !!') );?>
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
                                   
                                     <td >
                                        <?php echo $this->Form->input('quantite',array('value'=>$lr['Lignefacture']['quantite'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','label'=>'','div'=>'form-group', 'name' => 'data[Lignefacture]['.$i.'][quantite]','table'=>'Lignefacture','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                     </td>
                                     <td >
                                    <?php echo $this->Form->input('prixachatans',array('value'=>$prix_anc,'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignefacture]['.$i.'][prixachatans]','table'=>'Lignefacture','index'=>$i,'id'=>'prixachatans'.$i,'champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('margeans',array('value'=>$lr['Article']['marge'],'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignefacture]['.$i.'][margeans]','table'=>'Lignefacture','index'=>$i,'id'=>'margeans'.$i,'champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixhtva',array('value'=>$lr['Lignefacture']['prixhtva'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][prixhtva]','table'=>'Lignefacture','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('value'=>$lr['Lignefacture']['remise'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][remise]','type'=>'text','table'=>'Lignefacture','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    
                                    <td >
                                     <?php  echo $this->Form->input('fodec',array('value'=>$lr['Lignefacture']['fodec'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][fodec]','table'=>'Lignefacture','index'=>$i,'id'=>'fodec'.$i,'champ'=>'fodec','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('tva',array('value'=>$lr['Lignefacture']['tva'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][tva]','table'=>'Lignefacture','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td>
                                        <?php 
                                        $date_exp='__/__/____';
                                        if($lr['Lignefacture']['date_exp']!='0000-00-00'){
                                            $date_exp=date("d/m/Y", strtotime(str_replace('-', '/',$lr['Lignefacture']['date_exp'])));
                                        }
                                        
                                        echo $this->Form->input('date_exp',array('label'=>'','div'=>'form-group','id'=>'date_exp'.$i,'value'=>$date_exp,'name'=>'data[Lignefacture]['.$i.'][date_exp]','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control datePickerOnly') ); ?>
                                    </td>
                                    <td align="center"><i index="<?php echo $i; ?>"  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                <tr class="tr">

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
    <?php     }else{    ?>                                                    
   <!-- Autre ligne // fournisseur externe  -->                                                                
              <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne de facture'); ?></h3>
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
                                    <td align="center" width="13%"  nowrap="nowrap">Depot</td>
                                    <td align="center" width="25%"  nowrap="nowrap">Article</td>
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
                                <tbody>
                                <?php $tablesemi='Lignefacture'; ?>
                                <input id="lachaine" type="hidden" value="depot_id,code,designation,quantite,prix,remise,prixhtva,tva" >
                                <tr class="tr" style="display:none;">
                                    <td id="" champ="tdaff" index="" >
                                     <span title="changer le prix de vente"> <a style="display:none;" onclick="recap_achat()" href="#reModal_refuser" id="" index="" champ="order" value="0" <button class=' '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'','empty'=>'Veuillez Choisir !!') );?>
                                    
                                    </td>
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
                                     <?php echo $this->Form->input('tva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefacture','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculcout') );?>
                                    </td>
                                 
                                      <td align="center"><i index=""  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                     <?php
                                        $ht=0;
                                        $tva=0;
                                        $ttc=0;
                                        $ttdv=0;
                                            foreach ($lignefactures as $i=>$lr){
                                        $ttdv=$ttdv+($lr['Lignefacture']['prix']*$lr['Lignefacture']['quantite']);        
                                        $ttc=$ttc+($lr['Lignefacture']['prix']*$lr['Lignefacture']['quantite']*@$tr*@$coe) ;       
                                        $ht=$ht+(($lr['Lignefacture']['prix']*$lr['Lignefacture']['quantite']*@$tr*@$coe)/(1+($lr['Lignefacture']['tva']/100)));  
                                        $tva=$ttc-$ht; 
                                          
                                            //zeinab
                                              $factures = ClassRegistry::init('Lignefacture')->find('first',array(
                                          'conditions'=>array('Facture.fournisseur_id'=>$this->request->data['Fournisseur']['id'],'Lignefacture.article_id'=>$lr['Article']['id'])
                                          ,'order'=>array('Lignefacture.id'=>'desc')
                                          ,'recursive' =>0));
                                       if(!empty($factures)){ 
                                           $prixff=$factures['Lignefacture']['prix'];
                                           $datef=$factures['Facture']['date'];
                                       }else{
                                           $prixff=0;
                                           $datef='1900-01-01';
                                       }
                                      $receptions = ClassRegistry::init('Lignereception')->find('first',array(
                                          'conditions'=>array('Bonreception.fournisseur_id'=>$this->request->data['Fournisseur']['id'],'Lignereception.article_id'=>$lr['Article']['id'])
                                          ,'order'=>array('Lignereception.id'=>'desc')
                                          ,'recursive' =>0));
                                       if(!empty($receptions)){ 
                                          $prixrr=$receptions['Lignereception']['prix'];
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
                                <tr class="cc">
                                    <td id="tdaff0" >
                                    <span title="changer le prix de vente"><a  onclick="recap_achat(<?php echo $i; ?>)" href="#reModal_refuser" champ="order" id="order<?php echo $i; ?>" value="<?php echo $i; ?>" <button class='  '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                    <td >
                                       <?php echo $this->Form->input('depot_id',array('value'=>@$lr['Lignefacture']['depot_id'],'onchange'=>'fuckfocus("select","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'',  'name' => 'data[Lignefacture]['.$i.'][depot_id]','table'=>'Lignefacture','index'=>$i,'id'=>'depot_id'.$i,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select','empty'=>'Veuillez choisir !!') );?>
                                    </td>
                                    <td >
                                       <?php echo $this->Form->input('id',array('value'=>$lr['Lignefacture']['id'],'name'=>'data[Lignefacture]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignefacture','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('sup',array('name'=>'data[Lignefacture]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignefacture','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control ','label'=>'Nom') );?>
                                       <?php //echo $this->Form->input('article_id',array('value'=>$lr['Article']['id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignefacture]['.$i.'][article_id]','table'=>'Lignefacture','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select idarticle editligneinvarticle','empty'=>'Veuillez choisir !!') );?>
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
                                     <td >
                                        <?php echo $this->Form->input('quantite',array('value'=>$lr['Lignefacture']['quantite'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','label'=>'','div'=>'form-group', 'name' => 'data[Lignefacture]['.$i.'][quantite]','table'=>'Lignefacture','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                     </td>
                                    <td >
                                    <?php echo $this->Form->input('prixachatans',array('value'=>sprintf("%01.2f",$prix_anc),'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignefacture]['.$i.'][prixachatans]','table'=>'Lignefacture','index'=>$i,'id'=>'prixachatans'.$i,'champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('margeans',array('value'=>$lr['Article']['marge'],'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignefacture]['.$i.'][margeans]','table'=>'Lignefacture','index'=>$i,'id'=>'margeans'.$i,'champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                     <?php 
                                     echo $this->Form->input('ttc',array('value'=>$lr['Lignefacture']['totalttc'],'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][totalttc]','table'=>'Lignefacture','index'=>$i,'id'=>'totalttc'.$i,'champ'=>'totalttc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                     echo $this->Form->input('ht',array('value'=>$lr['Lignefacture']['totalht'],'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][totalht]','table'=>'Lignefacture','index'=>$i,'id'=>'totalht'.$i,'champ'=>'totalht','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                     echo $this->Form->input('prix_anc',array('value'=>sprintf("%01.2f",$lr['Lignefacture']['prix_anc']),'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][prix_anc]','table'=>'Lignefacture','index'=>$i,'id'=>'prix_anc'.$i,'champ'=>'prix_anc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                      
                                     echo $this->Form->input('prixhtva',array('value'=>sprintf("%01.2f",$lr['Lignefacture']['prix']),'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][prix]','table'=>'Lignefacture','index'=>$i,'id'=>'prix'.$i,'champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control CalculPrix') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('value'=>$lr['Lignefacture']['remise'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][remise]','table'=>'Lignefacture','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                     <td >
                                     <?php 
                                     echo $this->Form->input('cout de revien ',array('value'=>$lr['Lignefacture']['prixhtva'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][prixhtva]','table'=>'Lignefacture','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                    <td>
                                     <?php echo $this->Form->input('tva',array('value'=>$lr['Lignefacture']['tva'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefacture]['.$i.'][tva]','table'=>'Lignefacture','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
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
   <?php     } }  ?>  
            
                <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="popachat">
                      
                        
                    </div>
                    <br>
                   
                  <a  class="remodal-confirm ls-light-green-btn btn" onclick="validerprixdevente()"><strong>OK</strong></a>                
                </div> 
                <?php if($this->request->data['Facture']['type'] !="service"){ ?>
              <div class="col-md-6">                  
              	<?php
                if(@$this->request->data['Fournisseur']['devise_id']!=1){
                $remise=0;
                $tvat=$tva;
                $fodec=0;
                $m_ht=$ht+(@$this->request->data['Facture']['fret']*@$tr*@$coe)-(@$this->request->data['Facture']['avoir']*@$tr*@$coe);
                $m_ttc=$ttc+(@$this->request->data['Facture']['fret']*@$tr*@$coe)-(@$this->request->data['Facture']['avoir']*@$tr*@$coe);
                $timbre="";
                echo $this->Form->input('mdinitial',array('value'=>sprintf("%01.2f",@$ttdv),'label'=>'Montant devise initial','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'mdi','class'=>'form-control') );
                echo $this->Form->input('fret',array('value'=>@$this->request->data['Facture']['fret'],'label'=>'Fret','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','id'=>'fret','class'=>'form-control calculcout') );
		echo $this->Form->input('avoir',array('value'=>@$this->request->data['Facture']['avoir'],'label'=>'Avoir','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','id'=>'avoir','class'=>'form-control calculcout') );
		echo $this->Form->input('montantdevise',array('label'=>'Montant devise final','value'=>sprintf("%01.2f",@$ttdv+(@$this->request->data['Facture']['frette'])-(@$this->request->data['Facture']['avoir'])),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'montantdevise','class'=>'form-control') );
                
                }else{
                $remise=@$this->request->data['Facture']['remise'];
                $tvat=@$this->request->data['Facture']['tva'];
                $fodec=@$this->request->data['Facture']['fodec'];
                $m_ht=@$this->request->data['Facture']['totalht'];
                $m_ttc=@$this->request->data['Facture']['totalttc'];    
               
		echo $this->Form->input('remise',array('value'=>sprintf("%01.3f",@$remise),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'remise','class'=>'form-control') );
	        echo $this->Form->input('tva',array('label'=>'TVA','value'=>sprintf("%01.3f",@$tvat),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control') );
                echo $this->Form->input('fodec',array('value'=>sprintf("%01.3f",@$fodec),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'fodec','class'=>'form-control') );
                } ?></div><div class="col-md-6"><?php
                if(@$this->request->data['Fournisseur']['devise_id']==1){
                if($this->request->data['Facture']['type']=="service"){$timbre="";}
		echo $this->Form->input('Timbre',array('value'=>$timbre,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'timbre','class'=>'form-control') );		
                }
                echo $this->Form->input('totalht',array('label'=>'Total HT','value'=>sprintf("%01.3f",@$m_ht),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_HT','class'=>'form-control') );
		if(@$this->request->data['Fournisseur']['devise_id']!=1){
                       echo $this->Form->input('tva',array('label'=>'TVA','value'=>sprintf("%01.3f",@$tvat),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		}
                echo $this->Form->input('totalttc',array('label'=>'Total TTC','value'=>sprintf("%01.3f",@$m_ttc),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_TTC','class'=>'form-control') );
	        ?>
              </div> 
                <?php } ?>
   
                   
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary testligneedit TestLigneTTFacture testdateexpiration">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

