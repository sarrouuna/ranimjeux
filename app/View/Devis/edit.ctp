


<?php if($type==1){$x='devis';$index='index';}else{$x='facture proforma';$index='indexx';} ?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Devis/<?php echo $index ?>"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<?php $p=CakeSession::read('pointdevente');?>
<?php $users=CakeSession::read('users');
 //debug($users);
 if($users !=12){
     $readonly="readonly";
 }else{
   $readonly="";  
 }
?>    
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification '.$x); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Devi',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
                if($p==0){
                echo $this->Form->input('pointdevente_id',array('id'=>'pointdevente_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select numspecial'));
                }
		echo $this->Form->input('id',array('id'=>'id_fac','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('client_id',array('id'=>'client_id','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select infoclient','empty'=>'Veuillez Choisir !!') );
		echo $this->Form->input('model',array('id'=>'model','type'=>'hidden','value'=>'Devi','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('typedevisclient_id',array('label'=>'Type Devis','id'=>'typedevisclient_id','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select afficherdivtypesuivi','empty'=>'Veuillez Choisir !!') );
                ?>
               <div id="divtypesuivi1" <?php if($this->request->data['Devi']['typedevisclient_id']==1){ ?>style="display: none;" <?Php } ?>>    
                <?php
                 if((empty($suivicommercial['Suivicommercial']['daterecu']))||($suivicommercial['Suivicommercial']['daterecu']=="1970-01-01")){
                 $daterecu="";  
                 }else{
                 $daterecu=date("d/m/Y", strtotime(str_replace('-', '/',@$suivicommercial['Suivicommercial']['daterecu'])));    
                 }
                 if((empty($suivicommercial['Suivicommercial']['dateinstallation']))||($suivicommercial['Suivicommercial']['dateinstallation']=="1970-01-01")){
                 $dateinstallation="";  
                 }else{
                 $dateinstallation=date("d/m/Y", strtotime(str_replace('-', '/',@$suivicommercial['Suivicommercial']['dateinstallation'])));    
                 }
                echo $this->Form->input('1erecontact',array('value'=>@$suivicommercial['Suivicommercial']['1emecontact'],'label'=>'1ere contact','id'=>'1erecontact','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('description',array('value'=>@$suivicommercial['Suivicommercial']['description'],'label'=>'Description','id'=>'discription','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('recupar',array('value'=>@$suivicommercial['Suivicommercial']['recupar'],'label'=>'Recu par','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('numderecu',array('value'=>@$suivicommercial['Suivicommercial']['numderecu'],'label'=>'Num de recu','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('daterecu',array('value'=>@$daterecu,'type'=>'text','label'=>'Date recu','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );
                ?>
                </div> </div><div class="col-md-6"><?php
		echo $this->Form->input('date',array('div'=>'form-group','value'=>$date,'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );
                echo $this->Form->input('numero',array('readonly'=>$readonly,'id'=>'numero','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                ?>
                <div id="divtypesuivi" <?php if($this->request->data['Devi']['typedevisclient_id']==1){ ?>style="display: none;" <?Php } ?>>    
                <?php    
                echo $this->Form->input('typesuivitdevi_id',array('label'=>'Type Suivi','id'=>'typesuivitdevi_id','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select ','empty'=>'Veuillez Choisir !!') );
		echo $this->Form->input('statusuivi_id',array('value'=>@$suivicommercial['Suivicommercial']['statusuivi_id'],'value'=>1,'empty'=>'Veuillez Choisir !!','label'=>'Statu Suivi','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('raisondeperde',array('value'=>@$suivicommercial['Suivicommercial']['raisondeperde'],'label'=>'Raison de perde','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('inclusuivi_id',array('value'=>@$suivicommercial['Suivicommercial']['inclusuivi_id'],'empty'=>'Veuillez Choisir !!','label'=>'Installation inclu','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('dateinstallation',array('value'=>@$dateinstallation,'type'=>'text', 'label'=>'Date installation','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );
		echo $this->Form->input('affaire',array('value'=>@$suivicommercial['Suivicommercial']['affaire'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('bureaudetude',array('value'=>@$suivicommercial['Suivicommercial']['bureaudetude'],'label'=>'Bureau d\'etude','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('entreprise',array('value'=>@$suivicommercial['Suivicommercial']['entreprise'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('reglement',array('value'=>@$suivicommercial['Suivicommercial']['reglement'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		?>
                </div>    
                </div>
                       <div class="col-md-12" id="blocclient" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Info de client'); ?></h3>
                                </div>
                                <div class="panel-body">
              <div class="col-md-6"> 
              	<?php
		echo $this->Form->input('adresse',array('readonly'=>'readonly','label'=>'Adresse','value'=>$adresse,'id'=>'adresse','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('matriculefiscale',array('label'=>'Matricule Fiscale','value'=>$matriculefiscale,'id'=>'matriculefiscale','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('name',array('value'=>@$name,'label'=>'Raison Sociale','id'=>'name','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                ?>
              </div>
              <div class="col-md-6">
		<?php
		echo $this->Form->input('autorisation',array('value'=>$autorisation,'readonly'=>'readonly','label'=>'En Cours','id'=>'autorisation','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('montantutilise',array('value'=>$solde,'readonly'=>'readonly','label'=>'Solde','id'=>'solde','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('encour',array('value'=>$valreste,'readonly'=>'readonly','label'=>'Reste','id'=>'valreste','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
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
                                    
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                   <td align="center" nowrap="nowrap" width="1%" ></td>
                                    <td align="center" nowrap="nowrap" width="10%">Depot</td>
                                    <td align="center" nowrap="nowrap" width="15%">Article</td>
                                    <td align="center" nowrap="nowrap" width="7%">stock</td>
                                    <td align="center" nowrap="nowrap" width="7%"> Qte </td>
                                    <td align="center" nowrap="nowrap" width="9%">PUHT</td>    
                                    <td align="center" nowrap="nowrap" width="8%">Rem</td>
                                    <td align="center" nowrap="nowrap" width="9%">PNHT</td>
                                    <td align="center" nowrap="nowrap" width="9%">PUTTC</td> 
                                    <td align="center" nowrap="nowrap" width="9%">HT</td>
                                    <td align="center" nowrap="nowrap" width="6%">TVA</td>
                                    <td align="center" nowrap="nowrap" width="9%">TTC</td>
                                    <td align="center" width="1%"></td>
                                </tr>
                                </thead>
                                    <?php $tablesemi='Lignedevi'; ?>
                                <tbody>
                               <tr class="tr" style="display:none;" >
                                    <td id="" champ="tdaff" index="" >
                                    <span title="Ancien prix"><a style="display:none;" onclick="recap_rapport()" href="#reModal_refuser" id="" index="" champ="order" value="0" <button class=' '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                    <td >
                                        <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedevi','index'=>'','id'=>'','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control uniform_select depot_qte_s','empty'=>'Veuillez Choisir !!') );?>
                                    </td>  
                                    <td >
                                        <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedevi','index'=>'','id'=>'article_id','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control articleidbl','value'=>'Veuillez Choisir un depot !!') );?>
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
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignedevi','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('quantitestock',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' =>'','table'=>'Lignedevi','index'=>'','id'=>'quantitestock','champ'=>'quantitestock','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>

                                    <td >
                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedevi','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculefacture ') );?>
                                    </td>
                                    <td >
                                     <?php 
                                     echo $this->Form->input('prixachat',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'','index'=>'','id'=>'','champ'=>'prixachat','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );
                                     echo $this->Form->input('prix',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedevi','index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeinverseputtc') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedevi','index'=>'','id'=>'','champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeprix_net_ttc calculefacture') );
                                     echo $this->Form->input('remiseans',array('type'=>'hidden','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedevi','index'=>'','id'=>'','champ'=>'remiseans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixnet',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedevi','index'=>'','id'=>'','champ'=>'prixnet','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeremisenet') );?>
                                    </td>
                                     <td >
                                     <?php
                                     echo $this->Form->input('puttc',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedevi','index'=>'','id'=>'','champ'=>'puttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeprixvente') );
                                     echo $this->Form->input('totalhtans',array('div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => '','table'=>'Lignedevi','index'=>'','id'=>'','champ'=>'totalhtans','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('totalht',array('readonly'=>'readonly','div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => '','table'=>'Lignedevi','index'=>'','id'=>'','champ'=>'totalht','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('ltva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedevi','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('totalttc',array('readonly'=>'readonly','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedevi','index'=>'','id'=>'','champ'=>'totalttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                 
                                      <td align="center"><i index=""  class="fa fa-times supp1" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                 <tr class="tr" style="display:none;" >
                                     
                                    <td colspan="12" id="" index="" champ="tddesg">
                                     <?php //echo $this->Form->input('designation',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedevi','index'=>'','id'=>'','champ'=>'designation','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php  echo $this->Form->input('designation', array('div' => 'form-group','placeholder'=>'Designation','label'=>'', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text'));
                                            ?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                        </div>
                                    </td>
                                 </tr>
                                  <?php //debug($lignedevis);
                                  foreach ($lignedevis as $i=>$l){
                                      $qtestock=0;
                                      $objStockdepot = ClassRegistry::init('Stockdepot');
                                      $stock = $objStockdepot->find('first',array('conditions'=> array('Stockdepot.article_id' => $l['Lignedevi']['article_id'],
                                          'Stockdepot.depot_id' => $l['Lignedevi']['depot_id']), 'fields' => array('ifnull(sum(Stockdepot.quantite),0) as qte')));
//debug($stock);die;
                                      $qtestock=$stock[0]['qte']+$l['Lignedevi']['quantite'];

                                      ?>
                                
                               <tr class="cc testclientvide" >
                                    <td id="tdaff0" >
                                    <span title="Ancien prix"><a  onclick="recap_rapport(<?php echo $i; ?>)" href="#reModal_refuser" champ="order" id="order<?php echo $i; ?>" value="<?php echo $i; ?>" <button class='  '><i class='fa fa fa-pencil'></i></a></span>
                                    </td> 
                                   <td>
                                    	 <?php	echo $this->Form->input('depot_id',array('value'=>$l['Depot']['id'],'onchange'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','label'=>'','div'=>'form-group', 'name' => 'data[Lignedevi]['.$i.'][depot_id]','table'=>'Lignedevi','index'=>$i,'id'=>'depot_id'.$i,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select depot_qte_s','empty'=>'Veuillez Choisir !!') );?>
                                    </td> 
                                    <td >
                                       <?php //echo $this->Form->input('article_id',array('value'=>$l['Article']['id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignedevi]['.$i.'][article_id]','table'=>'Lignedevi','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select articleidbl','empty'=>'Veuillez choisir !!') );?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php
                                            echo $this->Form->input('article_id', array('div' => 'form-group','value'=>$l['Article']['id'], 'name' => 'data['.$tablesemi.']['.$i.'][article_id]', 'table' => $tablesemi, 'index' => $i, 'id' => 'article_id'.$i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                            echo $this->Form->input('code', array('div' => 'form-group','placeholder'=>'Code','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','value'=>$l['Article']['code'],'label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code'.$i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                            ?>
                                            <!--                                            style="background-color:white;position: absolute; top: -10px;right: -500px; width:500px;z-index: 1000px;"-->
                                            <!--                                            onMouseOut="this.style.visibility = 'hidden';"-->
                                        </div>
                                    </td> 
                                     <td >
                                        <?php echo $this->Form->input('id',array('value'=>$l['Lignedevi']['id'],'name'=>'data[Lignedevi]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignedevi','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'data[Lignedevi]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignedevi','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('quantitestock',array('readonly'=>'readonly','value'=>@$qtestock,'label'=>'','div'=>'form-group', 'name' => 'data[Lignedevi]['.$i.'][quantitestock]','table'=>'Lignedevi','index'=>$i,'id'=>'quantitestock'.$i,'champ'=>'quantitestock','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                     </td>
                                     <td >
                                        <?php echo $this->Form->input('quantite',array('value'=>$l['Lignedevi']['quantite'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','label'=>'','div'=>'form-group', 'name' => 'data[Lignedevi]['.$i.'][quantite]','table'=>'Lignedevi','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control   calculefacture') );?>
                                    </td>
                                    <td >
                                     <?php //echo $this->Form->input('prixachat',array('value'=>$l['Lignedevi']['prixachat'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignedevi]['.$i.'][prixachat]','table'=>'Lignedevi','index'=>$i,'id'=>'prixachat'.$i,'champ'=>'prixachat','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                     <?php echo $this->Form->input('prix',array('value'=>$l['Lignedevi']['prix'],'div'=>'form-group','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','label'=>'', 'name' => 'data[Lignedevi]['.$i.'][prixhtva]','table'=>'Lignedevi','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prix','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeinverseputtc') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('lremise',array('value'=>$l['Lignedevi']['remise'],'div'=>'form-group','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','label'=>'', 'name' => 'data[Lignedevi]['.$i.'][remise]','table'=>'Lignedevi','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeprix_net_ttc calculefacture') );
                                     echo $this->Form->input('remiseans',array('type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignedevi][0][remiseans]','table'=>'Lignedevi','index'=>$i,'id'=>'remiseans'.$i,'champ'=>'remiseans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  ') );?>
                                    </td>
                                    <td>
                                     <?php echo $this->Form->input('prixnet',array('value'=>@$l['Lignedevi']['prixnet'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignedevi]['.$i.'][prixnet]','table'=>'Lignedevi','index'=>$i,'id'=>'prixnet'.$i,'champ'=>'prix','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeremisenet') );?>
                                    </td>
                                     <td >
                                     <?php
                                     echo $this->Form->input('puttc',array('value'=>@$l['Lignedevi']['puttc'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignedevi]['.$i.'][puttc]','table'=>'Lignedevi','index'=>$i,'id'=>'puttc'.$i,'champ'=>'puttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeprixvente') );
                                     echo $this->Form->input('totalhtans',array('value'=>@$l['Lignedevi']['totalhtans'],'type'=>'hidden','div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => 'data[Lignedevi]['.$i.'][totalhtans]','table'=>'Lignedevi','index'=>$i,'id'=>'totalhtans'.$i,'champ'=>'totalhtans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('ltotalht',array('readonly'=>'readonly','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','value'=>$l['Lignedevi']['totalht'],'div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => 'data[Lignedevi]['.$i.'][totalht]','table'=>'Lignedevi','index'=>$i,'id'=>'totalht'.$i,'champ'=>'totalht','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('ltva',array('value'=>$l['Lignedevi']['tva'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignedevi]['.$i.'][tva]','table'=>'Lignedevi','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('ltotalttc',array('readonly'=>'readonly','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','value'=>$l['Lignedevi']['totalttc'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignedevi]['.$i.'][totalttc]','table'=>'Lignedevi','index'=>$i,'id'=>'totalttc'.$i,'champ'=>'totalttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td align="center"><i index="<?php echo $i; ?>"  class="fa fa-times supp1" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                <tr class="cc0" >
                                   
                                    <td colspan="12" id="tddesg<?php echo $i; ?>" index="<?php echo $i; ?>">
                                     <?php //echo $this->Form->input('designation',array('value'=>$l['Lignedevi']['designation'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignedevi]['.$i.'][designation]','table'=>'Lignedevi','index'=>$i,'id'=>'designation'.$i,'champ'=>'designation','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php  echo $this->Form->input('designation', array('value'=>$l['Article']['name'],'div' => 'form-group','placeholder'=>'Designation','label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][designation]', 'table' => $tablesemi, 'index' => $i, 'id' => 'designation'.$i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                            <div id="res<?php echo $i; ?>" champ="res" index="<?php echo $i; ?>"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                        </div>
                                    </td>
                                    </tr>
                                  <?php } ?>
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo @$i; ?>"  id="index" />
                 <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="pop">
                      
                        
                    </div>
                    <br>
                   <a  class="remodal-confirm ls-light-green-btn btn" ><strong>OK</strong></a>
                    
               </div> 
</div>
                                <a class="btn btn-danger ajouterligne_livraison1" table='addtable' index='index'  tr="tr" style="
                                    float: left; 
                                    position: relative;
                                    top: -35px;
                                "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                            </div>
                        </div>                
</div> 
                                                                          
                                    
                                    
    <div class="col-md-6">                  
              	<?php
                   if($this->request->data['Devi']['timbre_id']==0){
            $timbre='0.000';
        }
		echo $this->Form->input('remise',array('value'=>$l['Devi']['remise'],'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'remise','class'=>'form-control') );
	        echo $this->Form->input('tva',array('label'=>'TVA','value'=>$l['Devi']['tva'],'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control') );
		  $lien_vente=  CakeSession::read('lien_vente');
                foreach($lien_vente as $k=>$liens){
                    if(@$liens['lien']=='marge'){
                            $marge=1;
                }}
                if(@$marge==1){ echo $this->Form->input('marge',array('div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'marge','class'=>'form-control') );}

                ?></div><div class="col-md-6"><?php
                echo $this->Form->input('timbre_id',array('div'=>'form-group','value'=>$timbre,'between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','id'=>'timbre','champ'=>'timbre','class'=>'form-control calculefacture') );
		echo $this->Form->input('totalht',array('label'=>'Total HT','value'=>$l['Devi']['totalht'],'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_HT','class'=>'form-control') );
		echo $this->Form->input('totalttc',array('label'=>'Total TTC','value'=>$l['Devi']['totalttc'],'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_TTC','class'=>'form-control') );
	?>
  </div>                              
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary  testpv test-edit-numerofacture testtypedevis">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

