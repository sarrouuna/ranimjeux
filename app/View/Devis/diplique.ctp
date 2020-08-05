



<!--<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php //echo $this->webroot;?><?php //echo $x;?>"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>-->
<?php $p=CakeSession::read('pointdevente');?>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout '.$x); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Devi',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
                if($p==0){
                echo $this->Form->input('pointdevente_id',array('name'=>'data['.$x.'][pointdevente_id]','id'=>'pointdevente_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select numspecial'));
                }
		echo $this->Form->input('client_id',array('name'=>'data['.$x.'][client_id]','value'=>$clientid,'id'=>'client_id','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select infoclient','empty'=>'Veuillez Choisir !!') );
		echo $this->Form->input('numeroconca',array('name'=>'data['.$x.'][numeroconca]','id'=>'numeroconca','type'=>'hidden','value'=>$mm,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('model',array('name'=>'data['.$x.'][model]','id'=>'model','type'=>'hidden','value'=>$x,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		if($model=="Devi"){
                echo $this->Form->input('typedevisclient_id',array('label'=>'Type Devis','id'=>'typedevisclient_id','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select afficherdivtypesuivi','empty'=>'Veuillez Choisir !!') );
                 ?>
               <div id="divtypesuivi1" style="display: none;">    
                <?php
                echo $this->Form->input('1erecontact',array('label'=>'1ere contact','id'=>'1erecontact','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('description',array('label'=>'Description','id'=>'discription','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('recupar',array('label'=>'Recu par','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('numderecu',array('label'=>'Num de recu','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('daterecu',array('type'=>'text','label'=>'Date recu','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );
                ?>
                </div> 
                <?php
                }
                ?></div><div class="col-md-6"><?php
		echo $this->Form->input('date',array('name'=>'data['.$x.'][date]','div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
		echo $this->Form->input('numero',array('name'=>'data['.$x.'][numero]','value'=>@$numspecial,'id'=>'numero','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                if($model=="Devi"){
                ?>
                <div id="divtypesuivi" style="display: none;">    
                <?php    
                echo $this->Form->input('typesuivitdevi_id',array('label'=>'Type Suivi','id'=>'typesuivitdevi_id','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select ','empty'=>'Veuillez Choisir !!') );
		echo $this->Form->input('statusuivi_id',array('value'=>1,'empty'=>'Veuillez Choisir !!','label'=>'Statu Suivi','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('raisondeperde',array('label'=>'Raison de perde','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('inclusuivi_id',array('empty'=>'Veuillez Choisir !!','label'=>'Installation inclu','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('dateinstallation',array('type'=>'text', 'label'=>'Date installation','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );
		echo $this->Form->input('affaire',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('bureaudetude',array('label'=>'Bureau d\'etude','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('entreprise',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('reglement',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		?>
                </div>
                <?php } ?>    
                </div>
                       <div class="col-md-12" id="blocclient" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Info de client'); ?></h3>
                                </div>
                                <div class="panel-body">
              <div class="col-md-6"> 
              	<?php
		echo $this->Form->input('adresse',array('name'=>'data['.$x.'][adresse]','readonly'=>'readonly','label'=>'Adresse','value'=>$adresse,'id'=>'adresse','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('matriculefiscale',array('name'=>'data['.$x.'][matriculefiscale]','label'=>'Matricule Fiscale','value'=>$matriculefiscale,'id'=>'matriculefiscale','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('name',array('name'=>'data['.$x.'][name]','value'=>$name,'label'=>'Raison Sociale','id'=>'name','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                ?>
              </div>
              <div class="col-md-6">
		<?php
		echo $this->Form->input('autorisation',array('name'=>'data['.$x.'][autorisation]','value'=>$autorisation,'readonly'=>'readonly','label'=>'En Cours','id'=>'autorisation','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('montantutilise',array('name'=>'data['.$x.'][montantutilise]','value'=>$solde,'readonly'=>'readonly','label'=>'Solde','id'=>'solde','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('encour',array('name'=>'data['.$x.'][encour]','value'=>$valreste,'readonly'=>'readonly','label'=>'Reste','id'=>'valreste','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('typeclientid',array('value'=>$typeclient_id,'type'=>'hidden','id'=>'typeclientid','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                ?>	 
              </div>
              </div></div></div>        
                                    
        <!-- Autre ligne devi-->
                   <div class="row ligne" style="width:105%">
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne de '.$x); ?></h3>
                                    <a class="btn btn-danger ajouterligne_livraison1" table='addtable' index='index'  tr="tr" style="
                                    float: right; 
                                    position: relative;
                                    top: -25px;
                                "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                   <td align="center" nowrap="nowrap" width="10%">Depot</td>
                                    <td align="center" nowrap="nowrap" width="15%">Article</td>
                                    <td align="center" nowrap="nowrap" width="7%">stock</td>
                                    <td align="center" nowrap="nowrap" width="7%"> Qte </td>
                                    <td align="center" nowrap="nowrap" width="10%">PUHT</td>    
                                    <td align="center" nowrap="nowrap" width="8%">Rem</td>
                                    <td align="center" nowrap="nowrap" width="9%">PNHT</td>
                                    <td align="center" nowrap="nowrap" width="9%">PUTTC</td> 
                                    <td align="center" nowrap="nowrap" width="9%">HT</td>
                                    <td align="center" nowrap="nowrap" width="6%">TVA</td>
                                    <td align="center" nowrap="nowrap" width="9%">TTC</td>
                                    <td align="center" width="1%"></td>
                                </tr>
                                </thead>
                                    <?php $tablesemi=$ligne; ?>
                                <tbody>
                               <tr class="tr" style="display:none;" >
                                    <td >
                                        <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>$ligne,'index'=>'','id'=>'','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control uniform_select depot_qte_s','empty'=>'Veuillez Choisir !!') );?>
                                    </td>  
                                    <td >
                                        <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>$ligne,'index'=>'','id'=>'article_id','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control articleidbl','value'=>'Veuillez Choisir un depot !!') );?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php
                                            echo $this->Form->input('article_id', array('div' => 'form-group', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                            echo $this->Form->input('code', array('div' => 'form-group','placeholder'=>'Code','label'=>'', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                            ?>
                                            <!--                                            style="background-color:white;position: absolute; top: -10px;right: -500px; width:500px;z-index: 1000px;"-->
                                            <!--                                            onMouseOut="this.style.visibility = 'hidden';"-->
                                        </div>
                                    </td>
                                    <td >
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>$ligne,'index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('quantitestock',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' =>'','table'=>$ligne,'index'=>'','id'=>'quantitestock','champ'=>'quantitestock','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>

                                    <td >
                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>$ligne,'index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculefacture ') );?>
                                    </td>
                                    <td >
                                     <?php 
                                     echo $this->Form->input('prixachat',array('div'=>'form-group','label'=>'', 'name' => '','table'=>$ligne,'index'=>'','id'=>'','champ'=>'prixachat','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );
                                     echo $this->Form->input('prix',array('div'=>'form-group','label'=>'', 'name' => '','table'=>$ligne,'index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeinverseputtc') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => '','table'=>$ligne,'index'=>'','id'=>'','champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );
                                     echo $this->Form->input('remiseans',array('type'=>'hidden','div'=>'form-group','label'=>'', 'name' => '','table'=>$ligne,'index'=>'','id'=>'','champ'=>'remiseans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixnet',array('div'=>'form-group','label'=>'', 'name' => '','table'=>$ligne,'index'=>'','id'=>'','champ'=>'prixnet','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeremisenet') );?>
                                    </td>
                                     <td >
                                     <?php
                                     echo $this->Form->input('puttc',array('div'=>'form-group','label'=>'', 'name' => '','table'=>$ligne,'index'=>'','id'=>'','champ'=>'puttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeprixvente') );
                                     echo $this->Form->input('totalhtans',array('div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => '','table'=>$ligne,'index'=>'','id'=>'','champ'=>'totalhtans','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('totalht',array('readonly'=>'readonly','div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => '','table'=>$ligne,'index'=>'','id'=>'','champ'=>'totalht','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('tva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>$ligne,'index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('totalttc',array('readonly'=>'readonly','div'=>'form-group','label'=>'', 'name' => '','table'=>$ligne,'index'=>'','id'=>'','champ'=>'totalttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                 
                                      <td align="center"><i index=""  class="fa fa-times supp1" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                 <tr class="tr" style="display:none;" >
                                     
                                    <td colspan="12">
                                     <?php //echo $this->Form->input('designation',array('div'=>'form-group','label'=>'', 'name' => '','table'=>$ligne,'index'=>'','id'=>'','champ'=>'designation','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php  echo $this->Form->input('designation', array('div' => 'form-group','placeholder'=>'Designation','label'=>'', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text'));
                                            ?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                        </div>
                                    </td>
                                 </tr>
                                  <?php //debug($lignedevis);
                                  foreach ($lignedevis as $i=>$l){ //debug($l);die;
                                  $qtestock=0;
                                  $objStockdepot = ClassRegistry::init('Stockdepot');
                                  $stock = $objStockdepot->find('first',array('conditions'=> array('Stockdepot.article_id' => $l[$ligne_ans]['article_id'],
                                  'Stockdepot.depot_id' => $l[$ligne_ans]['depot_id']), 'fields' => array('ifnull(sum(Stockdepot.quantite),0) as qte')));
                                  //debug($stock);die;
                                  $qtestock=$stock[0]['qte']+$l[$ligne_ans]['quantite'];
                                      ?>
                                
                               <tr class="cc" >
                                     <td>
                                    	 <?php	echo $this->Form->input('depot_id',array('value'=>$l['Depot']['id'],'onchange'=>'fuckfocus("select","'.$i.'",this.getAttribute("name"))','label'=>'','div'=>'form-group', 'name' => 'data['.$ligne.']['.$i.'][depot_id]','table'=>'Lignedevi','index'=>$i,'id'=>'depot_id'.$i,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select depot_qte_s','empty'=>'Veuillez Choisir !!') );?>
                                    </td> 
                                    <td >
                                       <?php //echo $this->Form->input('article_id',array('value'=>$l['Article']['id'],'div'=>'form-group','label'=>'',  'name' => 'data['.$ligne.']['.$i.'][article_id]','table'=>'Lignedevi','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select articleidbl','empty'=>'Veuillez choisir !!') );?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php
                                            echo $this->Form->input('article_id', array('div' => 'form-group','value'=>$l['Article']['id'], 'name' => 'data['.$tablesemi.']['.$i.'][article_id]', 'table' => $tablesemi, 'index' => $i, 'id' => 'article_id'.$i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                            echo $this->Form->input('code', array('div' => 'form-group','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','placeholder'=>'Code','value'=>$l['Article']['code'],'label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code'.$i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                            ?>
                                            <!--                                            style="background-color:white;position: absolute; top: -10px;right: -500px; width:500px;z-index: 1000px;"-->
                                            <!--                                            onMouseOut="this.style.visibility = 'hidden';"-->
                                        </div>
                                    </td> 
                                     <td >
                                        <?php echo $this->Form->input('id',array('value'=>$l[$ligne_ans]['id'],'name'=>'data['.$ligne.']['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignedevi','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'data['.$ligne.']['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignedevi','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('quantitestock',array('readonly'=>'readonly','value'=>@$qtestock,'label'=>'','div'=>'form-group', 'name' => 'data['.$ligne.']['.$i.'][quantitestock]','table'=>'Lignedevi','index'=>$i,'id'=>'quantitestock'.$i,'champ'=>'quantitestock','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                     </td>
                                     <td >
                                        <?php echo $this->Form->input('quantite',array('value'=>$l[$ligne_ans]['quantite'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','label'=>'','div'=>'form-group', 'name' => 'data['.$ligne.']['.$i.'][quantite]','table'=>'Lignedevi','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control   calculefacture') );?>
                                    </td>
                                    <td >
                                     <?php //echo $this->Form->input('prixachat',array('value'=>$l['Lignedevi']['prixachat'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignedevi]['.$i.'][prixachat]','table'=>'Lignedevi','index'=>$i,'id'=>'prixachat'.$i,'champ'=>'prixachat','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                     <?php echo $this->Form->input('prix',array('value'=>$l[$ligne_ans]['prix'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data['.$ligne.']['.$i.'][prixhtva]','table'=>'Lignedevi','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prix','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeinverseputtc') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('value'=>$l[$ligne_ans]['remise'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data['.$ligne.']['.$i.'][remise]','table'=>'Lignedevi','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );
                                     echo $this->Form->input('remiseans',array('type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data['.$ligne.'][0][remiseans]','table'=>'Lignedevi','index'=>$i,'id'=>'remiseans'.$i,'champ'=>'remiseans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  ') );?>
                                    </td>
                                    <td>
                                     <?php echo $this->Form->input('prixnet',array('value'=>@$l[$ligne_ans]['prixnet'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data['.$ligne.']['.$i.'][prixnet]','table'=>'Lignedevi','index'=>$i,'id'=>'prixnet'.$i,'champ'=>'prix','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeremisenet') );?>
                                    </td>
                                     <td >
                                     <?php
                                     echo $this->Form->input('puttc',array('value'=>@$l[$ligne_ans]['puttc'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data['.$ligne.']['.$i.'][puttc]','table'=>'Lignedevi','index'=>$i,'id'=>'puttc'.$i,'champ'=>'puttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeprixvente') );
                                     echo $this->Form->input('totalhtans',array('value'=>@$l[$ligne_ans]['totalhtans'],'type'=>'hidden','div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => 'data['.$ligne.']['.$i.'][totalhtans]','table'=>'Lignedevi','index'=>$i,'id'=>'totalhtans'.$i,'champ'=>'totalhtans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('totalht',array('readonly'=>'readonly','value'=>$l[$ligne_ans]['totalht'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => 'data['.$ligne.']['.$i.'][totalht]','table'=>'Lignedevi','index'=>$i,'id'=>'totalht'.$i,'champ'=>'totalht','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('tva',array('value'=>$l[$ligne_ans]['tva'],'div'=>'form-group','label'=>'','readonly'=>'readonly','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))', 'name' => 'data['.$ligne.']['.$i.'][tva]','table'=>'Lignedevi','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('totalttc',array('readonly'=>'readonly','value'=>$l[$ligne_ans]['totalttc'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data['.$ligne.']['.$i.'][totalttc]','table'=>'Lignedevi','index'=>$i,'id'=>'totalttc'.$i,'champ'=>'totalttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td align="center"><i index="<?php echo $i; ?>"  class="fa fa-times supp1" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                <tr class="cc0" >
                                   
                                    <td colspan="12" id="tddesg<?php echo $i; ?>" index="<?php echo $i; ?>">
                                     <?php //echo $this->Form->input('designation',array('value'=>$l[$ligne_ans]['designation'],'div'=>'form-group','label'=>'', 'name' => 'data['.$ligne.']['.$i.'][designation]','table'=>'Lignedevi','index'=>$i,'id'=>'designation'.$i,'champ'=>'designation','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php  echo $this->Form->input('designation', array('value'=>$l['Article']['name'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div' => 'form-group','placeholder'=>'Designation','label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][designation]', 'table' => $tablesemi, 'index' => $i, 'id' => 'designation'.$i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
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
                                                                          
                                    
                                    
    <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('remise',array('name'=>'data['.$x.'][remise]','value'=>$l[$model_ans]['remise'],'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'remise','class'=>'form-control') );
	        echo $this->Form->input('tva',array('name'=>'data['.$x.'][tva]','label'=>'TVA','value'=>$l[$model_ans]['tva'],'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control') );
		  $lien_vente=  CakeSession::read('lien_vente');
                foreach($lien_vente as $k=>$liens){
                    if(@$liens['lien']=='marge'){
                            $marge=1;
                }}
                if(@$marge==1){ echo $this->Form->input('marge',array('name'=>'data['.$x.'][marge]','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'marge','class'=>'form-control') );}

                ?></div><div class="col-md-6"><?php
		echo $this->Form->input('totalht',array('name'=>'data['.$x.'][totalht]','label'=>'Total HT','value'=>$l[$model_ans]['totalht'],'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_HT','class'=>'form-control') );
		echo $this->Form->input('totalttc',array('name'=>'data['.$x.'][totalttc]','label'=>'Total TTC','value'=>$l[$model_ans]['totalttc'],'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_TTC','class'=>'form-control') );
	?>
  </div>                              
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary testpv ">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

