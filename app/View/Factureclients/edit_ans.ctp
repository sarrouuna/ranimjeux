<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Factureclients/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<?php $p=CakeSession::read('pointdevente');?>
<?php $users=CakeSession::read('users');
 //debug($users);
 if($users !=12){
     $readonly="readonly";
 }else{
   $readonly="";  
 }
?>     
         
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification Facture client'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Factureclient',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

              <div class="col-md-6">                  
              	<?php
                if($p==0){
                echo $this->Form->input('pointdevente_id',array('id'=>'pointdevente_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select numspecial'));
                }
		echo $this->Form->input('id',array('id'=>'id_fac','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('client_id',array('id'=>'client_id','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select infoclient','empty'=>'Veuillez Choisir !!') );
		echo $this->Form->input('model',array('id'=>'model','type'=>'hidden','value'=>'Factureclient','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                ?>

                  <input id="vente" name="data[Factureclient][vente]" value="<?php echo $this->request->data['Factureclient']['vente']; ?>" type="hidden">
                  <div class="form-group">

                      <label for="asas"></label>
                      <div class="col-sm-10">
                          <!--<label class="radio-inline">-->

                          <input type="radio" name="data[Factureclient][vent]" id="optionsRadios11" value="detail" <?php if($this->request->data['Factureclient']['vente']=='detail'){ ?> checked <?php } ?> >Detail

                          <!-- </label>
                           <label class="radio-inline">-->
                          <input type="radio" name="data[Factureclient][vent]" id="optionsRadios12" value="gros" <?php if($this->request->data['Factureclient']['vente']=='gros'){ ?> checked <?php } ?> >Gros

                          <!-- </label>-->
                      </div>
                  </div>


              </div><div class="col-md-6"><?php
		echo $this->Form->input('date',array('div'=>'form-group','value'=>$date,'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );
                echo $this->Form->input('numero',array('readonly'=>$readonly,'id'=>'numero','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                ?>
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
		echo $this->Form->input('name',array('value'=>$name,'label'=>'Raison Sociale','id'=>'name','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
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
        <!-- Autre ligne facture client-->
                    <div class="row ligne" style="width:105%">
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne facture'); ?></h3>
                                   
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <?php $tablesemi='Lignefactureclient'; ?>
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
                                <tbody>
                               <tr class="tr" style="display:none;" >
                                    <td id="" champ="tdaff" index="" >
                                    <span title="Ancien prix"><a style="display:none;" onclick="recap_rapport()" href="#reModal_refuser" id="" index="" champ="order" value="0" <button class=' '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                   <td >
                                        <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control uniform_select depot_qte_s','empty'=>'Veuillez Choisir !!') );?>
                                    </td>  
                                    <td >
                                        <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'article_id','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control articleidbl','value'=>'Veuillez Choisir un depot !!') );?>
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
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignefactureclient','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('quantitestock',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' =>'','table'=>'Lignefactureclient','index'=>'','id'=>'quantitestock','champ'=>'quantitestock','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>

                                    <td >
                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testqte calculefacture ') );?>
                                    </td>
                                    <td >
                                     <?php 
                                     echo $this->Form->input('prixachat',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'','index'=>'','id'=>'','champ'=>'prixachat','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );
                                     echo $this->Form->input('prix',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeinverseputtc') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'','champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeprix_net_ttc calculefacture') );
                                     echo $this->Form->input('remiseans',array('type'=>'hidden','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'','champ'=>'remiseans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixnet',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'','champ'=>'prixnet','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeremisenet') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('puttc',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'','champ'=>'puttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeprixvente') );
                                     echo $this->Form->input('totalhtans',array('div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'','champ'=>'totalhtans','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('totalht',array('div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'','champ'=>'totalht','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('tva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('totalttc',array('readonly'=>'readonly','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'','champ'=>'totalttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                 
                                      <td align="center"><i index=""  class="fa fa-times supp1" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                 <tr class="tr" style="display:none;" >
                                     
                                    <td colspan="12" id="" index="" champ="tddesg">
                                     <?php //echo $this->Form->input('designation',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'','champ'=>'designation','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php  echo $this->Form->input('designation', array('div' => 'form-group','placeholder'=>'Designation','label'=>'', 'name' => '', 'table' => $tablesemi, 'index' => '', 'id' => '', 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text'));
                                            ?><div id="res" champ="res" index=""  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                        </div>
                                    </td>
                                 </tr>
                                 
                                 
                                  <?php //debug($lignefactureclients);die;
                                  foreach ($lignefactureclients as $i=>$l){  //debug($l);die;

                                      $qtestock=0;
                                      $objStockdepot = ClassRegistry::init('Stockdepot');
                                      $stock = $objStockdepot->find('first',array('conditions'=> array('Stockdepot.article_id' => $l['Lignefactureclient']['article_id'],
                                          'Stockdepot.depot_id' => $l['Lignefactureclient']['depot_id']), 'fields' => array('ifnull(sum(Stockdepot.quantite),0) as qte')));
                                        //debug($stock);die;
                                      $qtestock=$stock[0]['qte']+$l['Lignefactureclient']['quantite'];
                                      ?>
                                
                                <tr class="cc testclientvide" >
                                    <td id="tdaff0" >
                                    <span title="Ancien prix"> <a  onclick="recap_rapport(<?php echo $i; ?>)" href="#reModal_refuser" champ="order" id="order<?php echo $i; ?>" value="<?php echo $i; ?>" <button class='  '><i class='fa fa fa-pencil'></i></a></span>
                                    </td> 
                                    <td>
                                    	 <?php	echo $this->Form->input('depot_id',array('value'=>$l['Depot']['id'],'onchange'=>'fuckfocus("select","'.$i.'",this.getAttribute("name"))','label'=>'','div'=>'form-group', 'name' => 'data[Lignefactureclient]['.$i.'][depot_id]','table'=>'Lignefactureclient','index'=>$i,'id'=>'depot_id'.$i,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select depot_qte_s','empty'=>'Veuillez Choisir !!') );?>
                                    </td> 
                                    
                                    
                                    
<!--                                  <td   champ="tdarticle" id="tdarticle0">
                                         <div class="form-group">
                                         <div class="col-sm-12">    
                                       <select name="data[Lignefactureclient][<?php// echo $i?>][article_id]" table="Lignefactureclient" index="<?php// echo $i?>" id="article_id<?php// echo $i?>" champ="article_id" class="form-control select art">
                                           <option value="" >Veuillez choisir !!</option>
                                           <?php// foreach ($tabqtestock[$l['Depot']['id']]['articles'] as $p=>$frs){?>
                                           <option value="<?php// echo $p ?>" <?php //if($p==$l['Article']['id']){ ?> selected="selected"<?php //} ?> ><?php// echo $tabqtestock[$l['Depot']['id']]['articles'][$p] ?></option>
                                           <?php //} ?>
                                       </select></div></div>
                                    </td>   -->
                                    
                                    
                                    
                                    
                                    <td >
                                       <?php //echo $this->Form->input('article_id',array('value'=>$l['Article']['id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignefactureclient]['.$i.'][article_id]','table'=>'Lignefactureclient','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select articleidbl ','empty'=>'Veuillez choisir !!') );?>
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
                                        <?php echo $this->Form->input('id',array('value'=>$l['Lignefactureclient']['id'],'name'=>'data[Lignefactureclient]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignefactureclient','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'data[Lignefactureclient]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignefactureclient','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('quantitestock',array('readonly'=>'readonly','value'=>@$qtestock,'label'=>'','div'=>'form-group', 'name' => 'data[Lignefactureclient]['.$i.'][quantitestock]','table'=>'Lignefactureclient','index'=>$i,'id'=>'quantitestock'.$i,'champ'=>'quantitestock','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                     </td>
                                     <td >
                                        <?php echo $this->Form->input('quantite',array('value'=>$l['Lignefactureclient']['quantite'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','label'=>'','div'=>'form-group', 'name' => 'data[Lignefactureclient]['.$i.'][quantite]','table'=>'Lignefactureclient','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testqte  calculefacture') );?>
                                    </td>
                                    <td >
                                     <?php //echo $this->Form->input('prixachat',array('value'=>$l['Lignefactureclient']['prixachat'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient]['.$i.'][prixachat]','table'=>'Lignefactureclient','index'=>$i,'id'=>'prixachat'.$i,'champ'=>'prixachat','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                     <?php echo $this->Form->input('prix',array('value'=>$l['Lignefactureclient']['prix'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient]['.$i.'][prixhtva]','table'=>'Lignefactureclient','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prix','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeinverseputtc') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('value'=>$l['Lignefactureclient']['remise'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient]['.$i.'][remise]','table'=>'Lignefactureclient','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeprix_net_ttc calculefacture') );
                                     echo $this->Form->input('remiseans',array('type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient]['.$i.'][remiseans]','table'=>'Lignefactureclient','index'=>$i,'id'=>'remiseans'.$i,'champ'=>'remiseans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  ') );?>
                                    </td>
                                     <td>
                                     <?php echo $this->Form->input('prixnet',array('value'=>@$l['Lignefactureclient']['prixnet'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient]['.$i.'][prixnet]','table'=>'Lignefactureclient','index'=>$i,'id'=>'prixnet'.$i,'champ'=>'prix','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeremisenet') );?>
                                    </td>
                                     <td >
                                     <?php
                                     echo $this->Form->input('puttc',array('value'=>@$l['Lignefactureclient']['puttc'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient]['.$i.'][puttc]','table'=>'Lignefactureclient','index'=>$i,'id'=>'puttc'.$i,'champ'=>'puttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeprixvente') );
                                     echo $this->Form->input('totalhtans',array('value'=>@$l['Lignefactureclient']['totalhtans'],'type'=>'hidden','div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => 'data[Lignefactureclient]['.$i.'][totalhtans]','table'=>'Lignefactureclient','index'=>$i,'id'=>'totalhtans'.$i,'champ'=>'totalhtans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('totalht',array('value'=>$l['Lignefactureclient']['totalht'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => 'data[Lignefactureclient]['.$i.'][totalht]','table'=>'Lignefactureclient','index'=>$i,'id'=>'totalht'.$i,'champ'=>'totalht','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('tva',array('value'=>$l['Lignefactureclient']['tva'],'readonly'=>'readonly','div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient]['.$i.'][tva]','table'=>'Lignefactureclient','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('totalttc',array('readonly'=>'readonly','value'=>$l['Lignefactureclient']['totalttc'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient]['.$i.'][totalttc]','table'=>'Lignefactureclient','index'=>$i,'id'=>'totalttc'.$i,'champ'=>'totalttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td align="center"><i index="<?php echo $i; ?>"  class="fa fa-times supp1" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                <tr class="cc0" >
                                   
                                    <td colspan="12" id="tddesg<?php echo $i; ?>" index="<?php echo $i; ?>">
                                     <?php //echo $this->Form->input('designation',array('value'=>$l['Lignefactureclient']['designation'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient]['.$i.'][designation]','table'=>'Lignefactureclient','index'=>$i,'id'=>'designation'.$i,'champ'=>'designation','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
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
		echo $this->Form->input('remise',array('value'=>$l['Factureclient']['remise'],'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'remise','class'=>'form-control') );
	        echo $this->Form->input('tva',array('label'=>'TVA','value'=>$l['Factureclient']['tva'],'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control') );
		  $lien_vente=  CakeSession::read('lien_vente');
                foreach($lien_vente as $k=>$liens){
                    if(@$liens['lien']=='marge'){
                            $marge=1;
                }}
                if(@$marge==1){ echo $this->Form->input('marge',array('div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'marge','class'=>'form-control') );}

                ?></div><div class="col-md-6"><?php
                echo $this->Form->input('timbre_id',array('div'=>'form-group','value'=>$timbre,'between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'timbre','champ'=>'timbre','class'=>'form-control') );
		echo $this->Form->input('totalht',array('label'=>'Total HT','value'=>$l['Factureclient']['totalht'],'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_HT','class'=>'form-control') );
		echo $this->Form->input('totalttc',array('label'=>'Total TTC','value'=>$l['Factureclient']['totalttc'],'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_TTC','class'=>'form-control') );
	?>
  </div>                       
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary testlignedevente testautorisation testpv test-edit-numerofacture">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

