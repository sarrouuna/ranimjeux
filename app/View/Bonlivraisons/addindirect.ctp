

<script>
 window.onload = function() {
    // alert();
 calculefacturetrasformationbl();

};
</script>

<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Commandeclients/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
 <?php $p=CakeSession::read('pointdevente');

         ?>
<div class="row" >

                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout Bonlivraison'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Bonlivraison',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
<div class="col-md-6">
           <?php
            if($p==0){
              $numspecial="";
            }
                if($p==0){
                $pntv="";
                echo $this->Form->input('pointdevente_id',array('value'=>$pntv,'id'=>'pointdevente_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select numspecial'));
                }
		echo $this->Form->input('client_id',array('id'=>'client_id','value'=>@$clientid[0]['client_id'],'empty'=>'choix','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select infoclient') );
                echo $this->Form->input('numeroconca',array('id'=>'numeroconca','type'=>'hidden','value'=>$mm,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('model',array('id'=>'model','type'=>'hidden','value'=>'Bonlivraison','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                ?></div><div class="col-md-6"><?php
		echo $this->Form->input('date',array('div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );
		echo $this->Form->input('numero',array('id'=>'numero','value'=>$numspecial,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                ?>
                </div>
                    <div class="col-md-12" id="blocclient" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Info de client'); ?></h3>
                                </div>
                                <div class="panel-body">                <!-- Autre ligne commande-->
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
              </div></div></div>                              <!-- Autre ligne livraison-->
                   <div class="row ligne" style="width:180%">

                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne de livraison'); ?></h3>

                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap" width="1%" ></td>
                                    <td align="center" nowrap="nowrap" width="10%">Depot</td>
                                    <td align="center" nowrap="nowrap" width="15%">Article</td>
                                    <td align="center" nowrap="nowrap" width="5%">stock</td>
                                    <td align="center" nowrap="nowrap" width="6%"> Qte </td>
                                    <td align="center" nowrap="nowrap" width="7%"> Qte liv </td>
                                    <td align="center" nowrap="nowrap" width="9%">PUHT</td>
                                    <td align="center" nowrap="nowrap" width="8%">Rem</td>
                                    <td align="center" nowrap="nowrap" width="9%">PNHT</td>
                                    <td align="center" nowrap="nowrap" width="9%">PUTTC</td>
                                    <td align="center" nowrap="nowrap" width="9%">HT</td>
                                    <td align="center" nowrap="nowrap" width="5%">TVA</td>
                                    <td align="center" nowrap="nowrap" width="9%">TTC</td>
                                    <td align="center" width="1%"></td>
                                </tr>
                                </thead>

                                    <?php $tablesemi='Lignelivraison'; ?>

                                <tbody>
                               <tr class="tr" style="display:none;" >
                                    <td id="" champ="tdaff" index="" >
                                    <span title="Ancien prix"><a style="display:none;" onclick="recap_rapport()" href="#reModal_refuser" id="" index="" champ="order" value="0" <button class=' '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                    <td >
                                        <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignelivraison','index'=>'','id'=>'','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control uniform_select depot_qte_s','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td  champ="tdarticle" id="tdarticle">
                                        <?php //echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignelivraison','index'=>'','id'=>'article_id','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control articleidbl','value'=>'Veuillez Choisir un depot !!') );?>
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
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignelivraison','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('quantitestock',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' =>'','table'=>'Lignelivraison','index'=>'','id'=>'quantitestock','champ'=>'quantitestock','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>

                                    <td >
                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignelivraison','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testqte calculefacture ') );?>
                                    </td>
                                    <td >
                                        <?php echo $this->Form->input('quantiteliv',array('label'=>'','div'=>'form-group', 'name' => '','table'=>'Lignelivraison','index'=>'','id'=>'','champ'=>'quantiteliv','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testqteliv  calculefacturetrasformationbl') );?>
                                    </td>

                                    <td >
                                     <?php
                                     echo $this->Form->input('prixachat',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'','index'=>'','id'=>'','champ'=>'prixachat','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );
                                     echo $this->Form->input('prix',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignelivraison','index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeinverseputtc') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignelivraison','index'=>'','id'=>'','champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeprix_net_ttc calculefacture') );
                                     echo $this->Form->input('remiseans',array('type'=>'hidden','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignelivraison','index'=>'','id'=>'','champ'=>'remiseans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixnet',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignelivraison','index'=>'','id'=>'','champ'=>'prixnet','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeremisenet') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('puttc',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignelivraison','index'=>'','id'=>'','champ'=>'puttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeprixvente') );
                                     echo $this->Form->input('totalhtans',array('div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => '','table'=>'Lignelivraison','index'=>'','id'=>'','champ'=>'totalhtans','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('totalht',array('div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => '','table'=>'Lignelivraison','index'=>'','id'=>'','champ'=>'totalht','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('tva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignelivraison','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('totalttc',array('readonly'=>'readonly','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignelivraison','index'=>'','id'=>'','champ'=>'totalttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>

                                      <td align="center"><i index=""  class="fa fa-times supp1" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                <tr class="tr" style="display:none;" >

                                    <td colspan="10">
                                     <?php echo $this->Form->input('designation',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignelivraison','index'=>'','id'=>'','champ'=>'designation','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                 </tr>
                                <?php
                                     //debug($lignelivraisons);die;
                                            foreach ($lignelivraisons as $i=>$l){
                                    if($l[0]['quantite']<>$l[0]['quantiteliv']) {

                                        $qtestock=0;
                                        $objStockdepot = ClassRegistry::init('Stockdepot');
                                        $stock = $objStockdepot->find('first',array('conditions'=> array('Stockdepot.article_id' => $l['Lignecommandeclient']['article_iddd'],
                                            'Stockdepot.depot_id' => $l['Lignecommandeclient']['depot_id']), 'fields' => array('ifnull(sum(Stockdepot.quantite),0) as qte')));
//debug($stock);die;
                                        $qtestock=$stock[0]['qte']+$l[0]['quantite'];

                                        $objArticle = ClassRegistry::init('Article');
                                        $article = $objArticle->find('first',array('conditions'=> array('Article.id' => $l['Lignecommandeclient']['article_iddd']),'recursive'=>-1));

                                        ?>
                                <tr class="cc testclientvide" >
                                    <td id="tdaff0" >
                                   <span title="Ancien prix"> <a  onclick="recap_rapport(<?php echo $i; ?>)" href="#reModal_refuser" champ="order" id="order<?php echo $i; ?>" value="<?php echo $i; ?>" <button class='  '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                    <td>
                                    	 <?php	echo $this->Form->input('depot_id',array('value'=>$l[0]['depot_id'],'onchange'=>'fuckfocus("select","'.$i.'",this.getAttribute("name"))','label'=>'','div'=>'form-group', 'name' => 'data[Lignelivraison]['.$i.'][depot_id]','table'=>'Lignelivraison','index'=>$i,'id'=>'depot_id'.$i,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select depot_qte_s','empty'=>'Veuillez Choisir !!') );?>
                                    </td>



                                  <td  >
                             <?php //echo $this->Form->input('article_id',array('value'=>$l[0]['article_id'],'label'=>'','div'=>'form-group', 'name' => 'data[Lignelivraison]['.$i.'][article_id]','table'=>'Lignelivraison','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select articleidbl','empty'=>'Veuillez Choisir !!') );?>
                                      <div class="" style="display:inline; position: relative;">
                                          <?php
                                          echo $this->Form->input('article_id', array('div' => 'form-group','value'=>$article['Article']['id'], 'name' => 'data['.$tablesemi.']['.$i.'][article_id]', 'table' => $tablesemi, 'index' => $i, 'id' => 'article_id'.$i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                          echo $this->Form->input('code', array('div' => 'form-group','readonly'=>'readonly','placeholder'=>'Code','value'=>$article['Article']['code'],'label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][code]', 'table' => $tablesemi, 'index' => $i, 'id' => 'code'.$i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                          ?>
                                          <!--                                            style="background-color:white;position: absolute; top: -10px;right: -500px; width:500px;z-index: 1000px;"-->
                                          <!--                                            onMouseOut="this.style.visibility = 'hidden';"-->
                                      </div>
                                    </td>




                               <!--     <td style="width:15%"  champ="tdarticle" id="tdarticle0" >
                                       <?php //echo $this->Form->input('article_id',array('value'=>$l['Article']['id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignelivraison]['.$i.'][article_id]','table'=>'Lignelivraison','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select art','empty'=>'Veuillez choisir !!') );?>
                                    </td> -->
                                     <td >
                                        <?php echo $this->Form->input('id',array('value'=>$l['Lignecommandeclient']['id'],'name'=>'data[Lignelivraison]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignelivraison','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'data[Lignelivraison]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignelivraison','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('quantitestock',array('readonly'=>'readonly','value'=>@$qtestock,'label'=>'','div'=>'form-group', 'name' => 'data[Lignelivraison]['.$i.'][quantitestock]','table'=>'Lignelivraison','index'=>$i,'id'=>'quantitestock'.$i,'champ'=>'quantitestock','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                     </td>
                                     <td >
                                        <?php echo $this->Form->input('quantite',array('readonly'=>'readonly','value'=>$l[0]['quantite']-$l[0]['quantiteliv'],'label'=>'','div'=>'form-group', 'name' => 'data[Lignelivraison]['.$i.'][quantite]','table'=>'Lignelivraison','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testqte  calculefacture') );?>
                                    </td>
                                    <td >
                                        <?php echo $this->Form->input('quantiteliv',array('value'=>$l[0]['quantite']-$l[0]['quantiteliv'],'onkeypress'=>'fuckfocus("input","'.$i.'","data[Lignelivraison]['.$i.'][quantite]")','label'=>'','div'=>'form-group', 'name' => 'data[Lignelivraison]['.$i.'][quantiteliv]','table'=>'Lignelivraison','index'=>$i,'id'=>'quantiteliv'.$i,'champ'=>'quantiteliv','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testqteliv  calculefacturetrasformationbl') );?>
                                    </td>
                                    <td >
                                     <?php //echo $this->Form->input('prixachat',array('value'=>$l['Lignelivraison']['prixachat'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignelivraison]['.$i.'][prixachat]','table'=>'Lignelivraison','index'=>$i,'id'=>'prixachat'.$i,'champ'=>'prixachat','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                     <?php echo $this->Form->input('prix',array('value'=>  sprintf("%.3f",$l[0]['prix']/$l[0]['quantite']),'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignelivraison]['.$i.'][prixhtva]','table'=>'Lignelivraison','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prix','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeinverseputtc') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('value'=>$l[0]['remise']/$l[0]['quantite'],'div'=>'form-group','label'=>'','onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))', 'name' => 'data[Lignelivraison]['.$i.'][remise]','table'=>'Lignelivraison','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeprix_net_ttc calculefacture') );
                                     echo $this->Form->input('remiseans',array('type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignelivraison]['.$i.'][remiseans]','table'=>'Lignelivraison','index'=>$i,'id'=>'remiseans'.$i,'champ'=>'remiseans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  ') );?>
                                    </td>
                                    <td>
                                     <?php echo $this->Form->input('prixnet',array('value'=>$l[0]['prixnet']/$l[0]['quantite'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignelivraison]['.$i.'][prixnet]','table'=>'Lignelivraison','index'=>$i,'id'=>'prixnet'.$i,'champ'=>'prix','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeremisenet') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('puttc',array('value'=>$l[0]['puttc']/$l[0]['quantite'],'onkeypress'=>'fuckfocus("input","'.$i.'",this.getAttribute("name"))','div'=>'form-group','label'=>'', 'name' => 'data[Lignelivraison]['.$i.'][puttc]','table'=>'Lignecommande','index'=>$i,'id'=>'puttc'.$i,'champ'=>'puttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeprixvente') );
                                     echo $this->Form->input('totalhtans',array('value'=>$l[0]['prix']/$l[0]['quantite'],'type'=>'hidden','div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => 'data[Lignelivraison]['.$i.'][totalhtans]','table'=>'Lignecommande','index'=>$i,'id'=>'totalhtans'.$i,'champ'=>'totalhtans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('totalht',array('value'=>$l[0]['totalht'],'div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => 'data[Lignelivraison]['.$i.'][totalht]','table'=>'Lignelivraison','index'=>$i,'id'=>'totalht'.$i,'champ'=>'totalht','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('ltva',array('value'=>$l[0]['tva'],'div'=>'form-group','readonly'=>'readonly','label'=>'', 'name' => 'data[Lignelivraison]['.$i.'][tva]','table'=>'Lignelivraison','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('totalttc',array('readonly'=>'readonly','value'=>$l[0]['totalttc'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignelivraison]['.$i.'][totalttc]','table'=>'Lignelivraison','index'=>$i,'id'=>'totalttc'.$i,'champ'=>'totalttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td align="center"><i index="<?php echo $i; ?>"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                               <tr class="cc0" >

                                    <td colspan="10">
                                     <?php //echo $this->Form->input('designation',array('value'=>$l['Lignelivraison']['designation'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignelivraison]['.$i.'][designation]','table'=>'Lignelivraison','index'=>$i,'id'=>'designation'.$i,'champ'=>'designation','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                        <div class="" style="display:inline; position: relative;">
                                            <?php  echo $this->Form->input('designation', array('value'=>$article['Article']['name'],'readonly'=>'readonly','div' => 'form-group','placeholder'=>'Designation','label'=>'', 'name' => 'data['.$tablesemi.']['.$i.'][designation]', 'table' => $tablesemi, 'index' => $i, 'id' => 'designation'.$i, 'champ' => 'designation', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                                            <div id="res<?php echo $i; ?>" champ="res" index="<?php echo $i; ?>"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                                        </div>
                                    </td>
                                    </tr>
                                            <?php }} ?>
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
		echo $this->Form->input('remise',array('value'=>$clientid[0]['remise'],'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'remise','class'=>'form-control') );
	        echo $this->Form->input('tva',array('value'=>$clientid[0]['tva'],'label'=>'TVA','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control') );
		  $lien_vente=  CakeSession::read('lien_vente');
                foreach($lien_vente as $k=>$liens){
                    if(@$liens['lien']=='marge'){
                            $marge=1;
                }}
                if(@$marge==1){ echo $this->Form->input('marge',array('div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'marge','class'=>'form-control') );}

                ?></div><div class="col-md-6"><?php
		echo $this->Form->input('totalht',array('value'=>$clientid[0]['totalht'],'label'=>'Total HT','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_HT','class'=>'form-control ') );
		echo $this->Form->input('totalttc',array('value'=>$clientid[0]['totalttc'],'label'=>'Total TTC','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_TTC','class'=>'form-control') );
	?>
  </div>
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary testlignedevente testautorisation testpv ">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

