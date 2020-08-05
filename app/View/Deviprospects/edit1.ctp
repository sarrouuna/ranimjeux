<script>
calculefacturef();
</script>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Deviprospects/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>

<?php
//debug($t);die;
if($t==1){
$lignevalides=ClassRegistry::init('Lignevalide')->find('all',array('conditions'=>array('Lignevalide.id_piece'=>$id,'Lignevalide.document_id'=>1),'recursive'=>2));

if(!empty($lignevalides)){
    //debug($lignevalides);
    $valider="";
    foreach ($lignevalides as $valide){
        $valider=$valider."<br> * ".$valide['Personnel']['name']." le ".date("d/m/Y",strtotime(str_replace('/','-',$valide['Lignevalide']['date'])))." à ".$valide['Lignevalide']['heure'];
        if($valide['Lignevalide']['remarque']!=''){  $valider.=' RQ: '.$valide['Lignevalide']['remarque'] ;}
        }
    $validerpar="Cette Suggestion de Commande est validée par :".$valider;    
    }
        else{
        $validerpar="Cette Suggestion de Commande n'est pas validée ";     
        }
        echo "<center>".$validerpar."</center>";
        
}

?>
<br>

<input type="hidden" id="suggCdde" value="suggCdde">
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification Suggestion Commande'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Deviprospect',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

           <div class="col-md-6">                  
              	<?php  //debug($fournisseurs);die;echo __('Fournisseur');
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );		
		echo $this->Form->input('fournisseur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fc','class'=>'form-control select  artfournisseur','empty'=>'Veuillez Choisir !!') );
                if(@$devise!=1){
                ?>
                <div class='form-group' >	
                <label class='col-md-2 control-label' id="labeldevise" ><?php echo __('Importation'); ?></label>
                <div class='col-sm-10' champ="divimpor" id="divimpor" >
                <?php
		echo $this->Form->input('importation_id',array('empty'=>'Veuillez Choisir !!','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'importation_id','class'=>'form-control select get_tr_coe') );		
                ?>
                </div>
                </div> 
                <?php
                echo $this->Form->input('tr',array('readonly'=>'readonly','value'=>@$tr,'label'=>'Cours Devise','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'tr','class'=>'form-control ','type'=>'text') );
                echo $this->Form->input('coe',array('readonly'=>'readonly','value'=>sprintf('%.2f',@$coe),'label'=>'Coefficient','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coe','class'=>'form-control ','type'=>'text') );
                echo $this->Form->input('coefficient',array('value'=>@$tr*@$coe,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'coef','class'=>'form-control calculcout','type'=>'hidden') );
               
                }
                if($b==1){
                   echo $this->Form->input('compte_id',array('empty'=>'Veuillez Choisir !!','label'=>'Banque','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		
                }else if($this->request->data['Deviprospect']['compte_id']!=''){
                    
                      echo $this->Form->input('compteid',array('readonly'=>'readonly','value'=>$comptes[$this->request->data['Deviprospect']['compte_id']],'label'=>'Banque','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		
                }
                ?></div><div class="col-md-6"><?php
		echo $this->Form->input('numero',array('readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('depot_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez Choisir !!') );				
                echo $this->Form->input('date',array('div'=>'form-group','value'=>$day,'between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'text','class'=>'form-control datePickerOnly ') );                
                echo $this->Form->input('valide',array('value'=>0,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'valide','class'=>'form-control ','type'=>'hidden') );
               
                echo $this->Form->input('etat',array('id'=>'verif','type'=>'hidden','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control' ));
             if($t==1){
                echo $this->Form->input('remarque',array('type'=>'textarea','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
             }
                ?>
              </div>  
              <input type="hidden" name="data[devise]" value="<?php echo @$devise ; ?>" id="typefrs" />                       
                                    
            <!-- Autre ligne fournisseur interne  -->
   <?php  if(@$devise==1)
       {   ?>
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne de Suggestion Commande'); ?></h3>
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
                                    <td align="center" width="1%"></td>
                                    <td align="center" width="37%"  nowrap="nowrap">Article</td>
                                    <td align="center" width="10%" nowrap="nowrap"> Qte </td>
                                    <td align="center" width="10%" nowrap="nowrap">Prix</td>    
                                    <td align="center" width="10%" nowrap="nowrap">Remise %</td>       
                                    <td align="center" width="10%" nowrap="nowrap">Fodec % </td>
                                    <td align="center" width="10%" nowrap="nowrap">TVA % </td>    
                                    <td align="center" width="1%"></td>
                                    <td align="center" width="1%"></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;">
                                    <td></td>
                                    <td champ="tdarticle" id="tdarticle">
                                       <?php echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'idarticle  editligneinvarticle','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                   
                                    <td >
                                        <?php echo $this->Form->input('id',array('name'=>'','id'=>'','champ'=>'id','table'=>'Lignedeviprospect','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignedeviprospect','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
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
                                      <td ></td>
                                  </tr>
                                     <?php
                               
                                            foreach ($lignedeviprospects as $i=>$lr){
                                                
                                                //zeinab
                                                $hisorique=ClassRegistry::init('Historiquesuggcdde')->find('all',array('conditions'=>array('Historiquesuggcdde.lignedeviprospect_id'=>$lr['Lignedeviprospect']['id']),'recursive'=>1,'order'=>array('Historiquesuggcdde.date'=>'desc')));
                                                $style='';
                                                $hist=0; 
                                                if($hisorique!=array()){
                                                   $style=" style='background-color:white'";
                                                   $hist=1;
                                                  
                                                }
                                               if($lr['Lignedeviprospect']['remise']==0.000){
                                                    $lr['Lignedeviprospect']['remise']='';
                                                } 
                                        ?> 
                                <tr class="cc">
                                    <td  <?php echo $style;?>><?php echo $i+1; ?></td>
                                    <td  <?php echo $style;?>>
                                       <?php echo $this->Form->input('id',array('value'=>$lr['Lignedeviprospect']['id'],'name'=>'data[Lignedeviprospect]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignedeviprospect','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('sup',array('name'=>'data[Lignedeviprospect]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignedeviprospect','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control ','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('article_id',array('value'=>$lr['Article']['id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignedeviprospect]['.$i.'][article_id]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select idarticle editligneinvarticle','empty'=>'Veuillez choisir !!') );?>               
                                    </td>
                                    
                                     <td  <?php echo $style;?>>
                                        <?php echo $this->Form->input('quantite',array('value'=>$lr['Lignedeviprospect']['quantite'],'label'=>'','div'=>'form-group', 'name' => 'data[Lignedeviprospect]['.$i.'][quantite]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                     </td>
                                    <td  <?php echo $style;?>>
                                     <?php echo $this->Form->input('prixhtva',array('value'=>$lr['Lignedeviprospect']['prixhtva'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][prixhtva]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                     <?php //echo $this->Form->input('prix',array('value'=>$lr['Lignedeviprospect']['prix'],'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][prix]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'prixx'.$i,'champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                    <td  <?php echo $style;?>>
                                     <?php
                                     echo $this->Form->input('remise',array('value'=>$lr['Lignedeviprospect']['remise'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][remise]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                    
                                    <td  <?php echo $style;?>>
                                     <?php  echo $this->Form->input('fodec',array('value'=>$lr['Lignedeviprospect']['fodec'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][fodec]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'fodec'.$i,'champ'=>'fodec','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                    <td  <?php echo $style;?> >
                                     <?php echo $this->Form->input('tva',array('value'=>$lr['Lignedeviprospect']['tva'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][tva]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                    <td  <?php echo $style;?> align="center"><i index="<?php echo $i; ?>"  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;"></td>
                                   <td <?php echo $style;?>>
                                          <?php if($hist==1){ ?>
                                    <span title="Affiche historique"><a  onclick="Affiche(<?php echo $i; ?>)" value="<?php echo $i; ?>" <button class='  '><i class='fa  fa-search'></i></a></span>
                                          <?php } ?>
                                      </td>
                                    </tr>
                                       <?php if($hist==1){ ?>
                                <tr id='histo<?php echo $i; ?>' style='display:none'>
                                    <td colspan="12">
                                        <table class="table table-bordered "  style="width:100%;  background-color:#FFFF" align="center">
                                            <tr>
                                                <th width="15%"  align='center'>&nbsp; Date</th>
                                                <th  width="15%"  align='center'>&nbsp; Utilisateur</th>
                                                <th width="10%"  align='center'>&nbsp; Reference</th>
                                                <th width="22%" align='center'>&nbsp; Qte</th>
                                                <th width="10%" align='center'>&nbsp;  Prix en devis</th>
                                                <th width="8%" align='center'>&nbsp;  Remise%</th>
                                                <th width="9%" align='center'>&nbsp;  CR TTC</th>
                                                <th width="7%"  align='center' >&nbsp;  TVA%</th>
                                            </tr>
                                            <?php foreach ($hisorique as $i=>$historiquesuggcdde){  
                                                 $pers=ClassRegistry::init('Personnel')->find('first',array('conditions'=>array('Personnel.id'=>$historiquesuggcdde['Utilisateur']['personnel_id'])));
                                                 ?>
                                            
                                            
                                            <tr>
                                                <td><?php echo$historiquesuggcdde['Historiquesuggcdde']['date']; ?></td>
                                                <td><?php echo $pers['Personnel']['name']; ?></td>
                                                <td><?php echo$historiquesuggcdde['Historiquesuggcdde']['reference']; ?></td>
                                                <td><?php echo$historiquesuggcdde['Historiquesuggcdde']['quantite']; ?></td>
                                                <td><?php echo$historiquesuggcdde['Historiquesuggcdde']['prix']; ?></td>
                                                <td><?php echo$historiquesuggcdde['Historiquesuggcdde']['remise']; ?></td>
                                                <td><?php echo$historiquesuggcdde['Historiquesuggcdde']['prixhtva']; ?></td>
                                                <td><?php echo$historiquesuggcdde['Historiquesuggcdde']['tva']; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </table> 
                                    </td>
                                </tr> 
                                     
                                     <?php } ?>
                                 <?php } ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo $i; ?>"  id="index" />
</div>
                            </div>
                        </div>                
</div> 
    <?php     }else{  
     ?>                                                    
   <!-- Autre ligne // fournisseur externe  -->  
            <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne de Suggestion Commande'); ?></h3>
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
                                    <td align="center" width="30%"  nowrap="nowrap">Article</td>
                                    <td align="center" width="10%" nowrap="nowrap"> Réference </td>
                                    <td align="center" width="8%" nowrap="nowrap"> Qte </td>
                                    <td align="center" width="10%" nowrap="nowrap">Dernier Prix</td>  
                                    <td align="center" width="5%" nowrap="nowrap">Dernier M%</td>
                                    <td align="center" width="10%" nowrap="nowrap">Prix en devis</td> 
                                    <td align="center" width="8%" nowrap="nowrap">Remise%</td>
                                    <td align="center" width="10%" nowrap="nowrap">CR TTC</td>  
                                    <td align="center" width="5%" nowrap="nowrap">TVA % </td>    
                                    <td align="center" width="1%"></td>
                                    <td align="center" width="1%"></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;">
                                    <td ></td>
                                    <td  champ="tdarticle" id="tdarticlee" >
                                        <?php echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'tvaart editligneinvarticle','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('reference',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'reference','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                         <?php echo $this->Form->input('id',array('name'=>'','id'=>'','champ'=>'id','table'=>'Lignedeviprospect','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignedeviprospect','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculcout') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('prixachatans',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => '','table'=>'Lignedeviprospect','index'=>'0','id'=>'','champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                    <?php echo $this->Form->input('margeans',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => '','table'=>'Lignedeviprospect','index'=>'0','id'=>'','champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    
                                     <td >
                                     <?php 
                                        echo $this->Form->input('tttva',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'tttva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('ttc',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'totalttc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('ht',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'totalht','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('prix_anc',array('type'=>'hidden','value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'prix_anc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                        echo $this->Form->input('prixhtva',array('value'=>'','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control CalculPrix'));?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('cout de revien ',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculefacfournisseur') );?>
                                    </td>
                                   
                                    <td >
                                     <?php echo $this->Form->input('tva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignedeviprospect','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacfournisseur') );?>
                                    </td>
                                 
                                      <td align="center"><i index=""  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                     <?php
                                        $ht=0;
                                        $tva=0;
                                        $ttc=0;
                                        //debug($lignedeviprospects);
                                            foreach ($lignedeviprospects as $i=>$lr){
                                               //zeinab
                                                $hisorique=ClassRegistry::init('Historiquesuggcdde')->find('all',array('conditions'=>array('Historiquesuggcdde.lignedeviprospect_id'=>$lr['Lignedeviprospect']['id']),'recursive'=>1,'order'=>array('Historiquesuggcdde.date'=>'desc')));
                                                $style='';
                                                $hist=0; 
                                                if($hisorique!=array()){
                                                   $style=" style='background-color:white'";
                                                   $hist=1;
                                                  
                                                }
                                                
                                                $ttc=$ttc+$lr['Lignedeviprospect']['totalttc'] ;       
                                                $ht=$ht+$lr['Lignedeviprospect']['totalht'];  
                                                $tva=$ttc-$ht;
                                                if($lr['Lignedeviprospect']['remise']==0.000){
                                                    $lr['Lignedeviprospect']['remise']='';
                                                }
                                        ?> 
                                <tr class="cc">
                                   <td <?php echo $style;?>> <?php echo $i+1;?></td>
                                    <td <?php echo $style;?>>
                                       <?php echo $this->Form->input('id',array('value'=>$lr['Lignedeviprospect']['id'],'name'=>'data[Lignedeviprospect]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignedeviprospect','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('sup',array('name'=>'data[Lignedeviprospect]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignedeviprospect','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control ','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('article_id',array('value'=>$lr['Article']['id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignedeviprospect]['.$i.'][article_id]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>' tvaart editligneinvarticle','empty'=>'Veuillez choisir !!','style'=>'width:400px') );?>               
                                    </td>
                                    <td <?php echo $style;?>>
                                     <?php echo $this->Form->input('reference',array('value'=>$lr['Lignedeviprospect']['reference'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][reference]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'reference'.$i,'champ'=>'reference','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td <?php echo $style;?>>
                                        <?php echo $this->Form->input('quantite',array('value'=>$lr['Lignedeviprospect']['quantite'],'label'=>'','div'=>'form-group', 'name' => 'data[Lignedeviprospect]['.$i.'][quantite]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculcout') );?>
                                    </td>
                                    <td <?php echo $style;?>>
                                    <?php echo $this->Form->input('prixachatans',array('value'=>$lr['Lignedeviprospect']['prixachatans'],'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignedeviprospect]['.$i.'][prixachatans]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'prixachatans'.$i,'champ'=>'prixachatans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td <?php echo $style;?>>
                                    <?php echo $this->Form->input('margeans',array('value'=>$lr['Lignedeviprospect']['margeans'],'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignedeviprospect]['.$i.'][margeans]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'margeans'.$i,'champ'=>'margeans','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                     <td <?php echo $style;?>>
                                     <?php 
                                       echo $this->Form->input('tttva',array('type'=>'hidden','value'=>$lr['Lignedeviprospect']['tttva'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][tttva]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'tttva'.$i,'champ'=>'tttva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                       echo $this->Form->input('ttc',array('value'=>$lr['Lignedeviprospect']['totalttc'],'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][totalttc]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'totalttc'.$i,'champ'=>'totalttc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                       echo $this->Form->input('ht',array('value'=>$lr['Lignedeviprospect']['totalht'],'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][totalht]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'totalht'.$i,'champ'=>'totalht','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                       echo $this->Form->input('prix_anc',array('value'=>sprintf("%01.2f",$lr['Lignedeviprospect']['prix_anc']),'type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][prix_anc]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'prix_anc'.$i,'champ'=>'prix_anc','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
                                       echo $this->Form->input('prixhtva',array('value'=>sprintf("%01.2f",$lr['Lignedeviprospect']['prix']),'div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][prix]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'prix'.$i,'champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control CalculPrix') );?>
                                    </td>
                                    <td <?php echo $style;?>>
                                     <?php
                                     echo $this->Form->input('remise',array('value'=>$lr['Lignedeviprospect']['remise'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][remise]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                    <td <?php echo $style;?>>
                                     <?php echo $this->Form->input('cout de revien',array('value'=>sprintf("%01.6f",$lr['Lignedeviprospect']['prixhtva']),'div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][prixhtva]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testlr calculcout') );?>
                                    </td>
                                    <td <?php echo $style;?>>
                                     <?php echo $this->Form->input('tva',array('value'=>$lr['Lignedeviprospect']['tva'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignedeviprospect]['.$i.'][tva]','table'=>'Lignedeviprospect','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculcout') );?>
                                    </td>
                                    <td align="center" <?php echo $style;?>>
                                        <i index="<?php echo $i; ?>"  class="fa fa-times suporfacturefrs" style="color: #c9302c;font-size: 22px;">
                                      </td>
                                      <td <?php echo $style;?>>
                                          <?php if($hist==1){ ?>
                                    <span title="Affiche historique"><a  onclick="Affiche(<?php echo $i; ?>)" value="<?php echo $i; ?>" <button class='  '><i class='fa  fa-search'></i></a></span>
                                          <?php } ?>
                                      </td>
                                </tr>
                                 <?php if($hist==1){ ?>
                                <tr id='histo<?php echo $i; ?>' style='display:none'>
                                    <td colspan="12">
                                        <table class="table table-bordered "  style="width:100%;  background-color:#FFFF" align="center">
                                            <tr>
                                            <th width="15%"  align='center'>&nbsp; Date</th>
                                            <th  width="15%"  align='center'>&nbsp; Utilisateur</th>
                                            <th width="10%"  align='center'>&nbsp; Reference</th>
                                            <th width="22%" align='center'>&nbsp; Qte</th>
                                            <th width="10%" align='center'>&nbsp;  Prix en devis</th>
                                            <th width="8%" align='center'>&nbsp;  Remise%</th>
                                            <th width="9%" align='center'>&nbsp;  CR TTC</th>
                                            <th width="7%"  align='center' >&nbsp;  TVA%</th>
                                            </tr>
                                            <?php foreach ($hisorique as $i=>$historiquesuggcdde){  
                                                 $pers=ClassRegistry::init('Personnel')->find('first',array('conditions'=>array('Personnel.id'=>$historiquesuggcdde['Utilisateur']['personnel_id'])));
                                                 ?>
                                            
                                            
                                            <tr>
                                                <td><?php echo$historiquesuggcdde['Historiquesuggcdde']['date']; ?></td>
                                                <td><?php echo $pers['Personnel']['name']; ?></td>
                                                <td><?php echo$historiquesuggcdde['Historiquesuggcdde']['reference']; ?></td>
                                                <td><?php echo$historiquesuggcdde['Historiquesuggcdde']['quantite']; ?></td>
                                                <td><?php echo$historiquesuggcdde['Historiquesuggcdde']['prix']; ?></td>
                                                <td><?php echo$historiquesuggcdde['Historiquesuggcdde']['remise']; ?></td>
                                                <td><?php echo$historiquesuggcdde['Historiquesuggcdde']['prixhtva']; ?></td>
                                                <td><?php echo$historiquesuggcdde['Historiquesuggcdde']['tva']; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </table> 
                                    </td>
                                </tr> 
                                     
                                     <?php } ?>
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
		echo $this->Form->input('montantdevise',array('label'=>'Montant devise','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'montantdevise','class'=>'form-control') );
		
                ?></div><div class="col-md-6"><?php
		echo $this->Form->input('totalht',array('value'=>sprintf("%01.3f",@$ht),'label'=>'Total HT','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_HT','class'=>'form-control') );
	        echo $this->Form->input('tva',array('value'=>sprintf("%01.3f",@$tva),'label'=>'TVA','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control') );
                echo $this->Form->input('totalttc',array('value'=>sprintf("%01.3f",@$ttc),'label'=>'Total TTC','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_TTC','class'=>'form-control') );
                ?>
                <input type="hidden" value="<?php echo @$t; ?>"  id="test" />
  </div>                         
                                                                 
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                
                                              
                                                <button type="submit" id="aff2" class="btn btn-primary btntrasBS testligneedit ">Modifier</button>
                                                <button type="submit" id="aff" class="btn btn-primary btntrasBS testligneedit ">Modifier&Publier</button>
                                                <?php if($t==1){ ?>
                                                <button type="submit" id="aff3" class="btn btn-primary btntrasBS testligneedit validerdevis">Valider</button>
                                                <?php } ?>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

