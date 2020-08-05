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
                                    <h3 class="panel-title"><?php echo __('Modification Commande'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Commande',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
                if($p==0){
                echo $this->Form->input('pointdevente_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select'));
                }
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
	        if(@$this->request->data['Fournisseur']['devise_id']!=1){
                ?>
                <?php
                echo $this->Form->input('fournisseur_id',array('type'=>'hidden','value'=>@$fr,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fc','class'=>'form-control') );
		echo $this->Form->input('frs',array('label'=>'Fournisseur','readonly'=>'readonly','value'=>@$this->request->data['Fournisseur']['name'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('importation_id',array('type'=>'hidden','value'=>@$importation,'label'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'importation_id','class'=>'form-control') );		
		echo $this->Form->input('impo',array('label'=>'Importation','readonly'=>'readonly','value'=>@$this->request->data['Importation']['name'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                ?>
                <?php
                echo $this->Form->input('tr',array('readonly'=>'readonly','value'=>@$tr,'label'=>'Cours Devise','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'tr','class'=>'form-control ','type'=>'text') );
                echo $this->Form->input('coe',array('readonly'=>'readonly','value'=>@$coe,'label'=>'Coefficient','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coe','class'=>'form-control ','type'=>'text') );
                echo $this->Form->input('coefficient',array('value'=>@$tr*@$coe,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coef','class'=>'form-control calculcout','type'=>'hidden') );
                }else{
                echo $this->Form->input('fournisseur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fc','class'=>'form-control select ','empty'=>'Veuillez Choisir !!') );
                }
                 if($this->request->data['Commande']['compte_id']!=''){
                      echo $this->Form->input('compte_id',array('type'=>'hidden','value'=>$this->request->data['Commande']['compte_id'],'empty'=>'Veuillez Choisir !!','label'=>'Banque','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		     echo $this->Form->input('compteid',array('readonly'=>'readonly','value'=>$comptes[$this->request->data['Commande']['compte_id']],'label'=>'Banque','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		 }
                 
                
          ?></div><div class="col-md-6"><?php
	        echo $this->Form->input('numero',array('div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('depot_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez Choisir !!') );				
                echo $this->Form->input('date',array('div'=>'form-group','between'=>'<div class="col-sm-10">','value'=>$day,'type'=>'text','after'=>'</div>','class'=>'form-control datePickerOnly') );
		echo $this->Form->input('dateliv',array('label'=>'Date de livraison','div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
                ?>
             <input type="hidden" name="data[devise]" value="<?php echo @$this->request->data['Fournisseur']['devise_id'] ; ?>" id="typefrs" />                       
  </div>  
        <?php  if(@$this->request->data['Fournisseur']['devise_id']==1){   ?>                              <!-- Autre ligne commande-->
                   <div class="row ligne fournisseurinterne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne de Commande'); ?></h3>
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
                                    <td align="center" width="30%"  nowrap="nowrap">Article</td>
                                    <td align="center" width="10%" nowrap="nowrap"> Qte </td>
                                    <td align="center" width="10%" nowrap="nowrap">Dernier Prix</td>  
                                    <td align="center" width="10%" nowrap="nowrap">Dernier M%</td>  
                                    <td align="center" width="10%" nowrap="nowrap">Prix</td>    
                                    <td align="center" width="10%" nowrap="nowrap">Remise %</td>       
                                    <td align="center" width="10%" nowrap="nowrap">Fodec % </td>
                                    <td align="center" width="9%" nowrap="nowrap">TVA % </td>    
                                    <td align="center" width="1%"></td>
                                </tr>
                                </thead>
                                    <?php $tablesemi='Lignereception'; ?>
                                    <input id="lachaine" type="hidden" value="code,designation,quantite,prixhtva,remise,fodec,tva" >
                                <tbody>
                                <tr class="tr" style="display:none;" >
                                    <td  champ="tdarticle" id="tdarticle">
                                        <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'idarticle testligneinv','empty'=>'Veuillez Choisir !!') );?>
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
                                    <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignereception','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                    <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('prixachatans',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => '','table'=>'Lignereception','index'=>'0','id'=>'','champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('margeans',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => '','table'=>'Lignereception','index'=>'0','id'=>'','champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
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
                                     <?php echo $this->Form->input('ltva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
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
                               
                                            foreach ($lignecommandes as $i=>$lr){ //debug($lr);die;
                                                
                                                  //zeinab
                                              $factures = ClassRegistry::init('Lignefacture')->find('first',array(
                                          'conditions'=>array('Facture.fournisseur_id'=>$this->request->data['Fournisseur']['id'],'Lignefacture.article_id'=>$lr['Lignecommande']['article_id'])
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
                                          'conditions'=>array('Bonreception.fournisseur_id'=>$this->request->data['Fournisseur']['id'],'Lignereception.article_id'=>$lr['Lignecommande']['article_id'])
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
                                <tr class="cc" >
                                    <td  champ="tdarticle" id="tdarticle0" >
                                        <?php //echo $this->Form->input('article_id',array('value'=>$lr['Lignecommande']['article_id'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][article_id]','table'=>'Lignereception','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testligneinv idarticle select','onchange'=>'tvaart(0)','empty'=>'Veuillez Choisir !!') );?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php
                                            echo $this->Form->input('article_id', array('div' => 'form-group','value'=>$lr['Article']['id'], 'name' => 'data['.$tablesemi.']['.$i.'][article_id]', 'table' => $tablesemi, 'index' => $i, 'id' => 'article_id'.$i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                            echo $this->Form->input('code', array('div' => 'form-group','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','placeholder'=>'Code','value'=>$lr['Article']['code'],'label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code'.$i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcodeachat', 'type' => 'text'));
                                            ?>
                                            <!--                                            style="background-color:white;position: absolute; top: -10px;right: -500px; width:500px;z-index: 1000px;"-->
                                            <!--                                            onMouseOut="this.style.visibility = 'hidden';"-->
                                        </div>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('sup',array('name'=>'data[Lignereception]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignereception','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                     <?php echo $this->Form->input('quantite',array('value'=>$lr['Lignecommande']['quantite'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','label'=>'','div'=>'form-group', 'name' => 'data[Lignereception]['.$i.'][quantite]','table'=>'Lignereception','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('prixachatans',array('value'=>$prix_anc,'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignereception]['.$i.'][prixachatans]','table'=>'Lignereception','index'=>$i,'id'=>'prixachatans'.$i,'champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('margeans',array('value'=>$lr['Article']['marge'],'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignereception]['.$i.'][margeans]','table'=>'Lignereception','index'=>$i,'id'=>'margeans'.$i,'champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixhtva',array('value'=>$lr['Lignecommande']['prixhtva'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][prixhtva]','table'=>'Lignereception','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prixhtva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                     <?php //echo $this->Form->input('prix',array('type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][prix]','table'=>'Lignereception','index'=>$i,'id'=>'prixx'.$i,'champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('value'=>$lr['Lignecommande']['remise'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][remise]','table'=>'Lignereception','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php  echo $this->Form->input('fodec',array('value'=>$lr['Lignecommande']['fodec'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][fodec]','table'=>'Lignereception','index'=>$i,'id'=>'fodec'.$i,'champ'=>'fodec','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('ltva',array('value'=>$lr['Lignecommande']['tva'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][tva]','table'=>'Lignereception','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                    <td align="center"><i index="<?php echo $i; ?>"  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                                <tr class="cc" >
                                                    <td colspan="8">
                                                    <div class="" style="display:inline; position: relative;">
                                                        <?php  echo $this->Form->input('designation', array('value'=>$lr['Article']['name'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div' => 'form-group','placeholder'=>'Designation','label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][designation]', 'table' => $tablesemi, 'index' => $i, 'id' => 'designation'.$i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselectachat', 'type' => 'text')); ?>
                                                        <div id="res<?php echo $i; ?>" champ="res" index="<?php echo $i; ?>"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                                    </div>
                                                    </td>
                                                </tr>



                                            <?php } ?>
                                </tbody>
                                </table>
              	                <input type="hidden" value="<?php echo $i; ?>" id="index" />
                                </div>
                            </div>
                        </div> 
                                    <a class="btn btn-danger ajouterligne_reception" table='addtable' index='index'  tr="tr" style="
                                   float: left; 
                                   position: relative;
                                   top: -55px;
                                   left: 15px;
                                "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                    </div>  
                  
        <?php     }else{    ?> 
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne bon de reception'); ?></h3>
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
                                    <td align="center" width="30%"  nowrap="nowrap">Article</td>
                                    <td align="center" width="10%" nowrap="nowrap"> Réference </td>
                                    <td align="center" width="10%" nowrap="nowrap"> Qte </td>
                                    <td align="center" width="10%" nowrap="nowrap">Dernier Prix</td>  
                                    <td align="center" width="5%" nowrap="nowrap">Dernier M%</td>
                                    <td align="center" width="10%" nowrap="nowrap">Prix</td> 
                                    <td align="center" width="8%" nowrap="nowrap">Remise%</td>
                                    <td align="center" width="10%" nowrap="nowrap">CR TTC</td>  
                                    <td align="center" width="6%" nowrap="nowrap">TVA % </td>    
                                    <td align="center" width="1%"></td>
                                </tr>
                                </thead>
                                    <?php $tablesemi='Lignereception'; ?>
                                    <input id="lachaine" type="hidden" value="code,designation,quantite,prix,remise,prixhtva,tva" >
                                <tbody>
                                <tr class="tr" style="display:none;">
                                    <td  champ="tdarticle" id="tdarticlee" >
                                        <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'idarticle editligneinvarticle','empty'=>'Veuillez Choisir !!') );?>
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
                                     <?php echo $this->Form->input('reference',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'reference','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                         <?php echo $this->Form->input('id',array('name'=>'','id'=>'','champ'=>'id','table'=>'Lignereception','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignereception','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculcout') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('prixachatans',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => '','table'=>'Lignereception','index'=>'0','id'=>'','champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('margeans',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => '','table'=>'Lignereception','index'=>'0','id'=>'','champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td>
                                     <?php 
                                        echo $this->Form->input('tttva',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'tttva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('ttc',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'totalttc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('ht',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'totalht','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('prix_anc',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'prix_anc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        
                                        echo $this->Form->input('prixhtva',array('value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control CalculPrix'));?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout'));?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('cout de revien ',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                   
                                    <td >
                                     <?php echo $this->Form->input('ltva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignereception','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
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
                                            foreach ($lignecommandes as $i=>$lr){
                                        $ttdv=$ttdv+($lr['Lignecommande']['prix']*$lr['Lignecommande']['quantite']);        
                                        $ttc=$ttc+($lr['Lignecommande']['prix']*$lr['Lignecommande']['quantite']*@$tr*@$coe) ;       
                                        $ht=$ht+(($lr['Lignecommande']['prix']*$lr['Lignecommande']['quantite']*@$tr*@$coe)/(1+($lr['Lignecommande']['tva']/100)));  
                                        $tva=$ttc-$ht; 
                                        
                                         //zeinab
                                        $factures = ClassRegistry::init('Lignefacture')->find('first',array(
                                          'conditions'=>array('Facture.fournisseur_id'=>$this->request->data['Fournisseur']['id'],'Lignefacture.article_id'=>$lr['Lignecommande']['article_id'])
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
                                          'conditions'=>array('Bonreception.fournisseur_id'=>$this->request->data['Fournisseur']['id'],'Lignereception.article_id'=>$lr['Lignecommande']['article_id'])
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
                                    <td >
                                       <?php //echo $this->Form->input('id',array('value'=>$lr['Lignereception']['id'],'name'=>'data[Lignereception]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignereception','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('sup',array('name'=>'data[Lignereception]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignereception','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control ','label'=>'Nom') );?>
<!--                                       <?php /*echo $this->Form->input('article_id',array('value'=>$lr['Lignecommande']['article_id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignereception]['.$i.'][article_id]','table'=>'Lignereception','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select idarticle editligneinvarticle','empty'=>'Veuillez choisir !!') );*/?>
-->
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
                                     <?php echo $this->Form->input('reference',array('value'=>$lr['Lignecommande']['reference'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][reference]','table'=>'Lignereception','index'=>$i,'id'=>'reference'.$i,'champ'=>'reference','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                     <td >
                                        <?php echo $this->Form->input('quantite',array('value'=>$lr['Lignecommande']['quantite'],'label'=>'','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group', 'name' => 'data[Lignereception]['.$i.'][quantite]','table'=>'Lignereception','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculcout') );?>
                                     </td>
                                    <td >
                                    <?php echo $this->Form->input('prixachatans',array('value'=>$prix_anc,'readonly'=>'readonly','label'=>'','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group', 'name' => 'data[Lignereception]['.$i.'][prixachatans]','table'=>'Lignereception','index'=>$i,'id'=>'prixachatans'.$i,'champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('margeans',array('value'=>$lr['Lignecommande']['margeans'],'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignereception]['.$i.'][margeans]','table'=>'Lignereception','index'=>$i,'id'=>'margeans'.$i,'champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                   
                                    
                                    <td >
                                     <?php 
                                       echo $this->Form->input('tttva',array('type'=>'hidden','value'=>$lr['Lignecommande']['tttva'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][tttva]','table'=>'Lignereception','index'=>$i,'id'=>'tttva'.$i,'champ'=>'tttva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                       echo $this->Form->input('ttc',array('value'=>$lr['Lignecommande']['totalttc'],'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][totalttc]','table'=>'Lignereception','index'=>$i,'id'=>'totalttc'.$i,'champ'=>'totalttc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                       echo $this->Form->input('ht',array('value'=>$lr['Lignecommande']['totalht'],'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][totalht]','table'=>'Lignereception','index'=>$i,'id'=>'totalht'.$i,'champ'=>'totalht','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                       echo $this->Form->input('prix_anc',array('value'=>sprintf("%01.2f",$lr['Lignecommande']['prix_anc']),'name' => 'data[Lignereception]['.$i.'][prix_anc]','type'=>'hidden','div'=>'form-group','label'=>'','table'=>'Lignereception','index'=>$i,'id'=>'prix_anc'.$i,'champ'=>'prix_anc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                       echo $this->Form->input('prixhtva',array('value'=>sprintf("%01.2f",$lr['Lignecommande']['prix']),'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][prix]','table'=>'Lignereception','index'=>$i,'id'=>'prix'.$i,'champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control CalculPrix') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('value'=>$lr['Lignecommande']['remise'],'div'=>'form-group','label'=>'','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))', 'name' => 'data[Lignereception]['.$i.'][remise]','table'=>'Lignereception','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                     
                                    <td >
                                     <?php echo $this->Form->input('prixhtva',array('value'=>sprintf("%01.6f",$lr['Lignecommande']['prixhtva']),'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][prixhtva]','table'=>'Lignereception','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculcout') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('ltva',array('value'=>$lr['Lignecommande']['tva'],'div'=>'form-group','label'=>'','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))', 'name' => 'data[Lignereception]['.$i.'][tva]','table'=>'Lignereception','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                    <td align="center"><i index="<?php echo $i; ?>"  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                <tr class="cc" >

                                    <td colspan="12" id="tddesg<?php echo $i; ?>" index="<?php echo $i; ?>" champ="tddesg">
                                        <div class="" style="display:inline; position: relative;">
                                            <?php  echo $this->Form->input('designation', array('value'=>$lr['Article']['name'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div' => 'form-group','placeholder'=>'Designation','label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][designation]', 'table' => $tablesemi, 'index' => $i, 'id' => 'designation'.$i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselectachat', 'type' => 'text')); ?>
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
                       <a class="btn btn-danger ajouterligne_reception" table='addtableext' index='index'  tr="tr" style="
                                   float: left; 
                                   position: relative;
                                   top: -55px;
                                   left: 15px;
                                "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
</div> 
        <?php     }   ?> 
                <div class="col-md-6">                  
              	<?php
                if(@$this->request->data['Fournisseur']['devise_id']!=1){
                $remise=0;
                $tvat=$tva;
                $fodec=0;
                $m_ht=$ht+(@$this->request->data['Commande']['fret']*@$tr*@$coe)-(@$this->request->data['Commande']['avoir']*@$tr*@$coe);
                $m_ttc=$ttc+(@$this->request->data['Commande']['fret']*@$tr*@$coe)-(@$this->request->data['Commande']['avoir']*@$tr*@$coe);
                }else{
                $remise=@$this->request->data['Commande']['remise'];
                $tvat=@$this->request->data['Commande']['tva'];
                $fodec=@$this->request->data['Commande']['fodec'];
                $m_ht=@$this->request->data['Commande']['totalht'];
                $m_ttc=@$this->request->data['Commande']['totalttc'];    
                }
                if(@$this->request->data['Fournisseur']['devise_id']!=1){
		echo $this->Form->input('mdinitial',array('value'=>sprintf("%01.2f",@$ttdv),'label'=>'Montant devise initial','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'mdi','class'=>'form-control') );
                echo $this->Form->input('fret',array('value'=>@$this->request->data['Commande']['fret'],'label'=>'Fret','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','id'=>'fret','class'=>'form-control calculcout') );
		echo $this->Form->input('avoir',array('value'=>@$this->request->data['Commande']['avoir'],'label'=>'Avoir','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','id'=>'avoir','class'=>'form-control calculcout') );
		echo $this->Form->input('montantdevise',array('label'=>'Montant devise final','value'=>sprintf("%01.2f",@$ttdv+@$this->request->data['Commande']['fret']-@$this->request->data['Commande']['avoir']),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'montantdevise','class'=>'form-control') );
                
                }else{
                echo $this->Form->input('remise',array('value'=>sprintf("%01.3f",@$remise),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'remise','class'=>'form-control') );
		echo $this->Form->input('fodec',array('value'=>sprintf("%01.3f",@$fodec),'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'fodec','class'=>'form-control') );
		    
                }
                
		
                ?>
                </div>
                <div class="col-md-6"><?php
		echo $this->Form->input('totalht',array('value'=>sprintf("%01.3f",@$m_ht),'label'=>'Total HT','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_HT','class'=>'form-control ') );
	        echo $this->Form->input('tva',array('value'=>sprintf("%01.3f",@$tvat),'label'=>'TVA','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control') );
                echo $this->Form->input('totalttc',array('value'=>sprintf("%01.3f",@$m_ttc),'label'=>'Total TTC','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_TTC','class'=>'form-control') );
	        ?>
                </div> 
                                    
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary TestLigneTTCdde">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

