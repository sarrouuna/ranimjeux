<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Commandes/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout Bon livraison'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Bonreception',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

           <div class="col-md-6">                  
              	<?php  //debug($fournisseurs);die;echo __('Fournisseur');
                if($p==0){
                echo $this->Form->input('pointdevente_id',array('value'=>@$bonreception[0]['pointdevente_id'],'empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select'));
                }
		//echo $this->Form->input('fournisseur_id',array('value'=>$bonreception[0]['fournisseur_id'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fc','class'=>'form-control select  artfournisseur','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
                echo $this->Form->input('fournisseur_id',array('type'=>'hidden','value'=>@$bonreception[0]['fournisseur_id'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fc','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('frs',array('label'=>'Fournisseur','readonly'=>'readonly','value'=>@$name,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                
                if(@$devise!=1){
                ?>
                <?php
		//echo $this->Form->input('importation_id',array('value'=>$bonreception[0]['importation_id'],'label'=>'Importation','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'importation_id','class'=>'form-control select get_tr_coe','empty'=>'Veuillez Choisir !!') );		
                echo $this->Form->input('importation_id',array('type'=>'hidden','value'=>@$bonreception[0]['importation_id'],'label'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'importation_id','class'=>'form-control') );		
		echo $this->Form->input('impo',array('label'=>'Importation','readonly'=>'readonly','value'=>@$impo,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                ?>
                <?php
                echo $this->Form->input('tr',array('readonly'=>'readonly','value'=>@$tr,'label'=>'Cours Devise','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'tr','class'=>'form-control ','type'=>'text') );
                echo $this->Form->input('coe',array('readonly'=>'readonly','value'=>sprintf('%.2f',@$coe),'label'=>'Coefficient','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coe','class'=>'form-control ','type'=>'text') );
                echo $this->Form->input('coefficient',array('value'=>@$tr*@$coe,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coef','class'=>'form-control calculcout','type'=>'hidden') );
                }
                 if($bonreception['Commande']['compte_id']!=''){
                      echo $this->Form->input('compte_id',array('type'=>'hidden','value'=>$bonreception['Commande']['compte_id'],'empty'=>'Veuillez Choisir !!','label'=>'Banque','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		     echo $this->Form->input('compteid',array('readonly'=>'readonly','value'=>$comptes[$bonreception['Commande']['compte_id']],'label'=>'Banque','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		 }
		//echo $this->Form->input('depot_id',array('id'=>'depot_id','value'=>@$bonreception[0]['depot_id'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );				
                ?></div><div class="col-md-6"><?php
		echo $this->Form->input('numeroconca',array('label'=>'Numéro Interne','value'=>$mm,'readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('date',array('div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire') );		
		echo $this->Form->input('Controller',array('value'=>'Bonreception','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'controller','type'=>'hidden','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('numero',array('label'=>'Numéro BL','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'numero','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire') );
                echo $this->Form->input('datefacture',array('label'=>'Date BL','div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire') );
                ?>
              </div>  
               <input type="hidden"  value="<?php echo @$devise ; ?>" id="typefrs" name="data[Bonreception][devise_id]"/>                            
                                    
            <!-- Autre ligne fournisseur interne  -->
   <?php  if(@$devise==1){   ?>
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne bon de livraison'); ?></h3>
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
                                    <td align="center" width="11%"  nowrap="nowrap">Dep</td>
                                    <td align="center" width="22%"  nowrap="nowrap">Art</td>
                                    <td align="center" width="8%" nowrap="nowrap"> Qte </td>
                                    <td align="center" width="10%" nowrap="nowrap">Date Exp</td>
                                    <td align="center" width="8%" nowrap="nowrap">Der Prix</td>  
                                    <td align="center" width="8%" nowrap="nowrap">Der M%</td>  
                                    <td align="center" width="10%" nowrap="nowrap">Prix</td>    
                                    <td align="center" width="7%" nowrap="nowrap">Rem %</td>       
                                    <td align="center" width="7%" nowrap="nowrap">Fodec % </td>
                                    <td align="center" width="7%" nowrap="nowrap">TVA % </td>    
                                    <td align="center" width="1%"></td>
                                </tr>
                                </thead>
                                    <?php $tablesemi='Lignedeviprospect'; ?>
                                    <input id="lachaine" type="hidden" value="depot_id,code,designation,quantite,prixhtva,remise,fodec,tva" >
                                <tbody>
                                <tr class="tr" style="display:none;">
                                    <td id="" champ="tdaff" index="" >
                                     <span title="changer le prix de vente"> <a style="display:none;" onclick="recap_achat()" href="#reModal_refuser" id="" index="" champ="order" value="0" <button class=' '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                    <td>
                                       <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>' ','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td champ="tdarticle" id="tdarticle">
                                       <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'idarticle  editligneinvarticle','empty'=>'Veuillez Choisir !!') );?>
                                     <?php echo $this->Form->input('margeA',array('name'=>'','id'=>'','champ'=>'margeA','table'=>'Lignedeviprospect','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'') );?>
                                       <?php echo $this->Form->input('pvA',array('name'=>'','id'=>'','champ'=>'pvA','table'=>'Lignedeviprospect','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'') );?>
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
                                        <?php echo $this->Form->input('id',array('name'=>'','id'=>'','champ'=>'id','table'=>'Lignedeviprospect','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignedeviprospect','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'') );?>
                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                    <td><input table='Lignedeviprospect' champ='date_exp'  index='' id='' value="" class="form-control" ></td>
                                    <td >
                                    <?php echo $this->Form->input('prixachatans',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => '','table'=>'Lignedeviprospect','index'=>'0','id'=>'','champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('margeans',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => '','table'=>'Lignedeviprospect','index'=>'0','id'=>'','champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixhtva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                     <?php //echo $this->Form->input('prix',array('type'=>'hidden','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'prixx','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php  echo $this->Form->input('fodec',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'fodec','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('tva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
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
                               
                                            foreach ($lignebonreceptions as $i=>$lr){//debug($lr);die;
                                                $objArticle = ClassRegistry::init('Article');
                                                $article = $objArticle->find('first',array('conditions'=> array('Article.id' => $lr[0]['article_id']),'recursive'=>-1));

                                                $factures = ClassRegistry::init('Lignefacture')->find('first',array(
                                          'conditions'=>array('Facture.fournisseur_id'=>@$bonreception[0]['fournisseur_id'],'Lignefacture.article_id'=>$lr[0]['article_id'])
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
                                          'conditions'=>array('Bonreception.fournisseur_id'=>@$bonreception[0]['fournisseur_id'],'Lignereception.article_id'=>$lr[0]['article_id'])
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
                                       <?php echo $this->Form->input('depot_id',array('value'=>@$bonreception[0]['depot_id'],'onchange'=>'fuckfocus("select","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'',  'name' => 'data[Lignedeviprospect]['.$i.'][depot_id]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'depot_id'.$i,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select','empty'=>'Veuillez choisir !!') );?>
                                    
                                    </td>
                                    <td >
                                       <?php //echo $this->Form->input('id',array('value'=>$lr['Lignedeviprospect']['id'],'name'=>'data[Lignedeviprospect]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignedeviprospect','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('sup',array('name'=>'data[Lignedeviprospect]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignedeviprospect','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                       <?php //echo $this->Form->input('article_id',array('value'=>$lr[0]['article_id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignedeviprospect]['.$i.'][article_id]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select idarticle editligneinvarticle','empty'=>'Veuillez choisir !!') );?>
                                       <?php echo $this->Form->input('margeA',array('name'=>'data[Lignedeviprospect]['.$i.'][margeA]','id'=>'margeA'.$i,'champ'=>'margeA','table'=>'Lignedeviprospect','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('pvA',array('name'=>'data[Lignedeviprospect]['.$i.'][pvA]','id'=>'pvA'.$i,'champ'=>'pvA','table'=>'Lignedeviprospect','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php
                                            echo $this->Form->input('article_id', array('div' => 'form-group','value'=>$article['Article']['id'], 'name' => 'data['.$tablesemi.']['.$i.'][article_id]', 'table' => $tablesemi, 'index' => $i, 'id' => 'article_id'.$i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                            echo $this->Form->input('code', array('div' => 'form-group','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','placeholder'=>'Code','value'=>$article['Article']['code'],'label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code'.$i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                            ?>
                                            <!--                                            style="background-color:white;position: absolute; top: -10px;right: -500px; width:500px;z-index: 1000px;"-->
                                            <!--                                            onMouseOut="this.style.visibility = 'hidden';"-->
                                        </div>
                                    </td>
                                    <td >
                                        <?php echo $this->Form->input('quantite',array('value'=>$lr[0]['quantite'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','label'=>'','div'=>'form-group', 'name' => 'data[Lignedeviprospect]['.$i.'][quantite]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control editfacfournisseur') );?>
                                    </td>
                                    <td>
                                     <?php echo $this->Form->input('date_exp',array('label'=>'','div'=>'form-group','id'=>'date_exp'.$i,'name'=>'data[Lignedeviprospect]['.$i.'][date_exp]','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control datePickerOnly') ); ?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('prixachatans',array('value'=>$prix_anc,'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignedeviprospect]['.$i.'][prixachatans]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'prixachatans'.$i,'champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('margeans',array('value'=>$lr[0]['marge'],'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignedeviprospect]['.$i.'][margeans]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'margeans'.$i,'champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixhtva',array('value'=>$lr[0]['prixhtva']/$lr[0]['quantite'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][prixhtva]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control editfacfournisseur') );?>
                                     <?php //echo $this->Form->input('prix',array('value'=>$lr['Lignedeviprospect']['prix'],'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][prix]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'prixx'.$i,'champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('value'=>$lr[0]['remise']/$lr[0]['quantite'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][remise]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control editfacfournisseur') );?>
                                    </td>
                                    
                                    <td >
                                     <?php  echo $this->Form->input('fodec',array('value'=>$lr[0]['fodec'],'div'=>'form-group','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][fodec]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'fodec'.$i,'champ'=>'fodec','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control editfacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('tva',array('value'=>$lr[0]['tva'],'div'=>'form-group','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][tva]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control editfacfournisseur') );?>
                                    </td>
                                    <td align="center"><i index="<?php echo $i; ?>"  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                                <tr class="cc"  >

                                                    <td colspan="12" id="tddesg<?php echo $i; ?>" index="<?php echo $i; ?>" champ="tddesg">
                                                        <div class="" style="display:inline; position: relative;">
                                                            <?php  echo $this->Form->input('designation', array('value'=>$article['Article']['name'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div' => 'form-group','placeholder'=>'Designation','label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][designation]', 'table' => $tablesemi, 'index' => $i, 'id' => 'designation'.$i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                                            <div id="res<?php echo $i; ?>" champ="res" index="<?php echo $i; ?>"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
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
    <?php     }else{    ?>                                                    
   <!-- Autre ligne // fournisseur externe  -->  
            <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne bon de livraison'); ?></h3>
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
                                    <td align="center" width="1%"></td>
                                   <td align="center" width="10%"  nowrap="nowrap">Depot</td>
                                    <td align="center" width="20%"  nowrap="nowrap">Article</td>
                                    <td align="center" width="10%" nowrap="nowrap"> Qte </td>
                                    <td align="center" width="10%" nowrap="nowrap">Date Exp</td>
                                    <td align="center" width="7%" nowrap="nowrap">Der Prix</td>  
                                    <td align="center" width="7%" nowrap="nowrap">Der M%</td>
                                    <td align="center" width="10%" nowrap="nowrap">Prix</td> 
                                    <td align="center" width="7%" nowrap="nowrap">Rem%</td>
                                    <td align="center" width="10%" nowrap="nowrap">CR TTC</td>  
                                    <td align="center" width="7%" nowrap="nowrap">TVA % </td>    
                                    <td align="center" width="1%"></td>
                                </tr>
                                </thead>
                                    <?php $tablesemi='Lignedeviprospect'; ?>
                                    <input id="lachaine" type="hidden" value="depot_id,code,designation,quantite,prix,remise,prixhtva,tva" >
                                <tbody>
                                <tr class="tr" style="display:none;">
                                    <td id="" champ="tdaff" index="" >
                                     <span title="changer le prix de vente"> <a style="display:none;" onclick="recap_achat()" href="#reModal_refuser" id="" index="" champ="order" value="0" <button class=' '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td  champ="tdarticle" id="tdarticlee" >
                                        <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'idarticle editligneinvarticle','empty'=>'Veuillez Choisir !!') );?>
                                        <?php echo $this->Form->input('margeA',array('name'=>'','id'=>'','champ'=>'margeA','table'=>'Lignedeviprospect','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'') );?>
                                        <?php echo $this->Form->input('pvA',array('name'=>'','id'=>'','champ'=>'pvA','table'=>'Lignedeviprospect','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'') );?>
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
                                         <?php echo $this->Form->input('id',array('name'=>'','id'=>'','champ'=>'id','table'=>'Lignedeviprospect','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignedeviprospect','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'') );?>
                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculcout') );?>
                                    </td>
                                    <td><input table='Lignereception' champ='date_exp'  index='' id='' value="" class="form-control" ></td>
                                    <td >
                                    <?php echo $this->Form->input('prixachatans',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => '','table'=>'Lignedeviprospect','index'=>'0','id'=>'','champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('margeans',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => '','table'=>'Lignedeviprospect','index'=>'0','id'=>'','champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td>
                                     <?php 
                                        echo $this->Form->input('tttva',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'tttva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('ttc',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'totalttc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('ht',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'totalht','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('prix_anc',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'prix_anc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        
                                        echo $this->Form->input('prixhtva',array('value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control CalculPrix'));?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout'));?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('cout de revien ',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                   
                                    <td >
                                     <?php echo $this->Form->input('tva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
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
                                        foreach ($lignebonreceptions as $i=>$lr){
                                            $objArticle = ClassRegistry::init('Article');
                                            $article = $objArticle->find('first',array('conditions'=> array('Article.id' => $lr['Lignecommande']['article_iddd']),'recursive'=>-1));
                                            //zeinab
                                        $ttdv=$ttdv+($lr[0]['prix']/$lr[0]['quantite']*$lr[0]['quantite']);        
                                        $ttc=$ttc+($lr[0]['prix']/$lr[0]['quantite']*$lr[0]['quantite']*@$tr*@$coe) ;       
                                        $ht=$ht+(($lr[0]['prix']/$lr[0]['quantite']*$lr[0]['quantite']*@$tr*@$coe)/(1+($lr[0]['tva']/100)));  
                                        $tva=$ttc-$ht;  
                                        
                                        $factures = ClassRegistry::init('Lignefacture')->find('first',array(
                                          'conditions'=>array('Facture.fournisseur_id'=>@$bonreception[0]['fournisseur_id'],'Lignefacture.article_id'=>$lr[0]['article_id'])
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
                                          'conditions'=>array('Bonreception.fournisseur_id'=>@$bonreception[0]['fournisseur_id'],'Lignereception.article_id'=>$lr[0]['article_id'])
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
                                       <?php echo $this->Form->input('depot_id',array('value'=>@$bonreception[0]['depot_id'],'onchange'=>'fuckfocus("select","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'',  'name' => 'data[Lignedeviprospect]['.$i.'][depot_id]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'depot_id'.$i,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select','empty'=>'Veuillez choisir !!') );?>
                                    
                                    </td>
                                    <td >
                                       <?php //echo $this->Form->input('id',array('value'=>$lr['Lignedeviprospect']['id'],'name'=>'data[Lignedeviprospect]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignedeviprospect','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('sup',array('name'=>'data[Lignedeviprospect]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignedeviprospect','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                       <?php //echo $this->Form->input('article_id',array('value'=>$lr[0]['article_id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignedeviprospect]['.$i.'][article_id]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select idarticle editligneinvarticle','empty'=>'Veuillez choisir !!') );?>
                                       <?php echo $this->Form->input('margeA',array('name'=>'data[Lignedeviprospect]['.$i.'][margeA]','id'=>'margeA'.$i,'champ'=>'margeA','table'=>'Lignedeviprospect','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('pvA',array('name'=>'data[Lignedeviprospect]['.$i.'][pvA]','id'=>'pvA'.$i,'champ'=>'pvA','table'=>'Lignedeviprospect','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php
                                            echo $this->Form->input('article_id', array('div' => 'form-group','value'=>$article['Article']['id'], 'name' => 'data['.$tablesemi.']['.$i.'][article_id]', 'table' => $tablesemi, 'index' => $i, 'id' => 'article_id'.$i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                            echo $this->Form->input('code', array('div' => 'form-group','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','placeholder'=>'Code','value'=>$article['Article']['code'],'label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code'.$i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                            ?>
                                            <!--                                            style="background-color:white;position: absolute; top: -10px;right: -500px; width:500px;z-index: 1000px;"-->
                                            <!--                                            onMouseOut="this.style.visibility = 'hidden';"-->
                                        </div>
                                    </td>
                                    <td >
                                        <?php echo $this->Form->input('quantite',array('value'=>$lr[0]['quantite'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','label'=>'','div'=>'form-group', 'name' => 'data[Lignedeviprospect]['.$i.'][quantite]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr editfacfournisseur') );?>
                                    </td>
                                    <td>
                                     <?php echo $this->Form->input('date_exp',array('label'=>'','div'=>'form-group','id'=>'date_exp'.$i,'name'=>'data[Lignereception]['.$i.'][date_exp]','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control datePickerOnly') ); ?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('prixachatans',array('value'=>sprintf("%01.2f",$prix_anc),'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignedeviprospect]['.$i.'][prixachatans]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'prixachatans'.$i,'champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('margeans',array('value'=>sprintf("%01.2f",$lr[0]['marge']),'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignedeviprospect]['.$i.'][margeans]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'margeans'.$i,'champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                     <?php 
                                       // echo $this->Form->input('tttva',array('type'=>'hidden','value'=>$lr[0]['tttva']/$lr[0]['quantite'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][tttva]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'tttva'.$i,'champ'=>'tttva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('ttc',array('value'=>$lr[0]['totalttc'],'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][totalttc]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'totalttc'.$i,'champ'=>'totalttc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('ht',array('value'=>$lr[0]['totalht'],'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][totalht]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'totalht'.$i,'champ'=>'totalht','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('prix_anc',array('value'=>sprintf("%01.2f",$lr[0]['prix']/$lr[0]['quantite']),'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][prix_anc]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'prix_anc'.$i,'champ'=>'prix_anc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                      
                                     echo $this->Form->input('prixhtva',array('value'=>sprintf("%01.2f",$lr[0]['prix']/$lr[0]['quantite']),'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][prix]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'prix'.$i,'champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control CalculPrix') );?>
                                    </td>
                                     <td >
                                     <?php
                                     echo $this->Form->input('remise',array('value'=>0,'div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][remise]','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','table'=>'Lignedeviprospect','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixhtva',array('value'=>sprintf("%01.6f",($lr[0]['prixhtva']/$lr[0]['quantite'])),'div'=>'form-group','label'=>'','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))', 'name' => 'data[Lignedeviprospect]['.$i.'][prixhtva]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr editfacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('tva',array('value'=>$lr[0]['tva'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][tva]','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','table'=>'Lignedeviprospect','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control editfacfournisseur') );?>
                                    </td>
                                    <td align="center"><i index="<?php echo $i; ?>"  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                            <tr class="cc"  >

                                                <td colspan="12" id="tddesg<?php echo $i; ?>" index="<?php echo $i; ?>" champ="tddesg">
                                                    <div class="" style="display:inline; position: relative;">
                                                        <?php  echo $this->Form->input('designation', array('value'=>$article['Article']['name'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div' => 'form-group','placeholder'=>'Designation','label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][designation]', 'table' => $tablesemi, 'index' => $i, 'id' => 'designation'.$i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                                        <div id="res<?php echo $i; ?>" champ="res" index="<?php echo $i; ?>"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
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
           <?php     }   ?>  
                <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="popachat">
                      
                        
                    </div>
                    <br>
                   
                  <a  class="remodal-confirm ls-light-green-btn btn" onclick="validerprixdevente()"><strong>OK</strong></a>                
                </div> 
              <div class="col-md-6">                  
              	<?php
                if(@$devise!=1){
                $remise=0;
                $tvat=$tva;
                $fodec=0;
                $m_ht=$ht+(@$bonreception[0]['fret']*@$tr*@$coe)-(@$bonreception[0]['avoir']*@$tr*@$coe);
                $m_ttc=$ttc+(@$bonreception[0]['fret']*@$tr*@$coe)-(@$bonreception[0]['avoir']*@$tr*@$coe);
                }else{
                $remise=@$bonreception[0]['remise'];
                $tvat=@$bonreception[0]['tva'];
                $fodec=@$bonreception[0]['fodec'];
                $m_ht=@$bonreception[0]['totalht'];
                $m_ttc=@$bonreception[0]['totalttc'];    
                }
                if(@$devise!=1){
		echo $this->Form->input('mdinitial',array('value'=>sprintf("%01.2f",@$ttdv),'label'=>'Montant devise initial','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'mdi','class'=>'form-control') );
                echo $this->Form->input('fret',array('value'=>@$bonreception[0]['fret'],'label'=>'Fret','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','id'=>'fret','class'=>'form-control calculcout') );
		echo $this->Form->input('avoir',array('value'=>@$bonreception[0]['avoir'],'label'=>'Avoir','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','id'=>'avoir','class'=>'form-control calculcout') );
		echo $this->Form->input('montantdevise',array('label'=>'Montant devise final','value'=>sprintf("%01.2f",@$ttdv+(@$bonreception[0]['fret'])-(@$bonreception[0]['avoir'])),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'montantdevise','class'=>'form-control') );
                }else{
		echo $this->Form->input('remise',array('value'=>sprintf("%01.3f",@$remise),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'remise','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	        echo $this->Form->input('tva',array('value'=>sprintf("%01.3f",@$tvat),'label'=>'TVA','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('fodec',array('value'=>sprintf("%01.3f",@$fodec),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'fodec','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                }
                ?></div><div class="col-md-6"><?php
		echo $this->Form->input('totalht',array('value'=>sprintf("%01.3f",@$m_ht),'label'=>'Total HT','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_HT','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		if(@$devise!=1){
                    echo $this->Form->input('tva',array('label'=>'TVA','value'=>sprintf("%01.3f",@$tvat),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		}
                echo $this->Form->input('totalttc',array('value'=>sprintf("%01.3f",@$m_ttc),'label'=>'Total TTC','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_TTC','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                ?>
                <input type="hidden" value="<?php echo @$t; ?>"  id="test" />
  </div>                         
                                                                 
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary TestLigneTTFacture  testnumero ">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

