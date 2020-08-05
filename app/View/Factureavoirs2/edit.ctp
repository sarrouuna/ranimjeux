<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Factureavoirs/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification Facture à voir'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Factureavoir',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php //debug($factureclients);die;
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );		
		echo $this->Form->input('client_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'client_id','class'=>'form-control select getfactures','empty'=>'Veuillez Choisir !!') );
		echo $this->Form->input('date',array('value'=>$date,'div'=>'form-group','type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
		?></div><div class="col-md-6"><?php
		echo $this->Form->input('numero',array('div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('typefacture_id',array('type'=>'hidden','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                ?>
                     <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Factures'); ?></label>	
                                  <div class='col-sm-10' champ="divfacture" id="divfacture" >  
                                  <select name="data[Factureavoir][factureclient_id]" table="Factureavoir" index="0" id="factureclient_id" champ="factureclient_id" class="form-control select">
                                         <option value="" >Veuillez choisir !!</option>
                                         <?php foreach ($factureclients as $fc){ ?>
                                         <option value="<?php echo $fc['Factureclient']['id'] ?>" <?php if($fc['Factureclient']['id']==$factureclient){ ?> selected="selected"<?php } ?> ><?php echo $fc['Factureclient']['numero']  ?></option>
                                         <?php } //}?>
                                  </select>
                                  </div>
                    </div>         
                </div>  
                                    
            <?php if($typefacture==1){ ?>                      
                                          <!-- Autre ligne facture avoir-->
                   <div class="row ligne favr" style="width:180%" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne Facture à voir'); ?></h3>
                                   <?php  if($this->request->data['Factureavoir']['factureclient_id']==null){ ?>
                                    <a class="btn btn-danger ajouterligne_reception" table='addtable' index='index'  tr="tr" style="
                                    float: right; 
                                    position: relative;
                                    top: -25px;
                                   "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a> <?php } ?>
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
                                    <td align="center" nowrap="nowrap" width="10%">PUHT</td>    
                                    <td align="center" nowrap="nowrap" width="8%">Rem</td>
                                    <td align="center" nowrap="nowrap" width="9%">PNHT</td>
                                    <td align="center" nowrap="nowrap" width="9%">PUTTC</td> 
                                    <td align="center" nowrap="nowrap" width="9%">HT</td>
                                    <td align="center" nowrap="nowrap" width="6%">TVA</td>
                                    <td align="center" nowrap="nowrap" width="9%">TTC</td>
                                    <?php  if($this->request->data['Factureavoir']['factureclient_id']==null){ ?>
                                    <td align="center" width="1%"></td> <?php } ?>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;" >
                                    <td id="" champ="tdaff" index="" >
                                    <span title="Ancien prix"><a style="display:none;" onclick="recap_rapport()" href="#reModal_refuser" id="" index="" champ="order" value="0" <button class=' '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>
                                    <td >
                                        <?php echo $this->Form->input('id',array('name'=>'','id'=>'','champ'=>'id','table'=>'Lignefactureavoir','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Lignefactureavoir','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'depot_id','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control uniform_select depot_qte_s testclientvide','empty'=>'Veuillez Choisir !!') );?>
                                    </td>  
                                    <td  >
                                        <?php echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'article_id','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control articleidbl','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td >
                                        <?php echo $this->Form->input('quantitestock',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' =>'','table'=>'Lignefactureavoir','index'=>'','id'=>'quantitestock','champ'=>'quantitestock','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    

                                    <td >
                                        <?php echo $this->Form->input('quantite',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                    <td >
                                     <?php 
                                     echo $this->Form->input('prixachat',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'prixachat','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );
                                     echo $this->Form->input('prix',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'prixhtva','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeinverseputtc') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeprix_net_ttc calculefacture') );
                                     echo $this->Form->input('remiseans',array('type'=>'hidden','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'remiseans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td>
                                     <?php echo $this->Form->input('prixnet',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'prixnet','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeremisenet') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('puttc',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'puttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeprixvente') );
                                     echo $this->Form->input('totalhtans',array('div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'totalhtans','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('totalht',array('div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'totalht','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('tva',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                 <td >
                                     <?php echo $this->Form->input('totalttc',array('readonly'=>'readonly','div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureavoir','index'=>'','id'=>'','champ'=>'totalttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td> 
                                     <?php  if($this->request->data['Factureavoir']['factureclient_id']==null){ ?>
                                      <td align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                     <?php } ?>
</tr>
                                <?php
                               
                                            foreach ($Lignefactureavoirs as $i=>$lfav){
                                $objstk = ClassRegistry::init('Stockdepot');
                                $relefes=$objstk->find('first', array('conditions'=>array('Stockdepot.article_id'=>$lfav['Lignefactureavoir']['article_id'],'Stockdepot.depot_id'=>$lfav['Lignefactureavoir']['depot_id']),'recursive'=>-1 ));
                                 if($this->request->data['Factureavoir']['factureclient_id']!=null){
                                $objlig = ClassRegistry::init('Lignefactureclient');
                                $lg=$objlig->find('first', array('conditions'=>array('Lignefactureclient.factureclient_id'=>$this->request->data['Factureavoir']['factureclient_id'],'Lignefactureclient.depot_id'=>$lfav['Lignefactureavoir']['depot_id'],'Lignefactureclient.article_id'=>$lfav['Lignefactureavoir']['article_id']),'recursive'=>-1 ));  
                                 $qtestk=@$lg['Lignefactureclient']['quantite'];
                                 $classqte="verifqteavoir2";
                                  $classdisab="";
                                  
                                    $disab="";
                                 }else{
                                   $qtestk=@$relefes['Stockdepot']['quantite']-$lfav['Lignefactureavoir']['quantite'];
                                $classqte="";  $classdisab="";   $disab="";
                                   }
                                ?> 
                                <tr class="cc" >
                                    <td id="tdaff0" >
                                    <span title="Ancien prix"> <a  onclick="recap_rapport(<?php echo $i; ?>)" href="#reModal_refuser" champ="order" id="order<?php echo $i; ?>" value="<?php echo $i; ?>" <button class='  '><i class='fa fa fa-pencil'></i></a></span>
                                    </td> 
                                    <td >
                                        <?php echo $this->Form->input('id',array('value'=>$lfav['Lignefactureavoir']['id'],'name'=>'data[Lignefactureavoir]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignefactureavoir','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'data[Lignefactureavoir]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignefactureavoir','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control ','label'=>'Nom') );?>
                                    	<?php echo $this->Form->input('depot_id',array('value'=>$lfav['Depot']['id'],'disabled'=>$disab,'label'=>'','div'=>'form-group', 'name' => 'data[Lignefactureavoir]['.$i.'][depot_id]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'depot_id'.$i,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control depot_qte_s testclientvide select '.$classdisab,'empty'=>'Veuillez Choisir !!') );?>
                                    </td>  
                                    <td>
                                        <?php echo $this->Form->input('article_id',array('value'=>$lfav['Article']['id'],'disabled'=>$disab,'div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureavoir]['.$i.'][article_id]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select articleidbl '.$classdisab,'empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                     <td >
                                        <?php echo $this->Form->input('quantitestock',array('value'=>@$qtestk,'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignefactureavoir]['.$i.'][quantitestock]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'quantitestock'.$i,'champ'=>'quantitestock','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td >
                                        <?php echo $this->Form->input('quantite',array('value'=>$lfav['Lignefactureavoir']['quantite'],'label'=>'','div'=>'form-group', 'name' => 'data[Lignefactureavoir]['.$i.'][quantite]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control   calculefacture '.$classqte) );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixachat',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureavoir]['.$i.'][prixachat]','table'=>'Lignefactureavoir','index'=>$i,'type'=>'hidden','id'=>'prixachat'.$i,'champ'=>'prixachat','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                     <?php echo $this->Form->input('prix',array('value'=>$lfav['Lignefactureavoir']['prix'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureavoir]['.$i.'][prixhtva]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'prixhtva'.$i,'champ'=>'prix','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeinverseputtc') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('value'=>$lfav['Lignefactureavoir']['remise'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureavoir]['.$i.'][remise]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'remise'.$i,'champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeprix_net_ttc calculefacture') );
                                     echo $this->Form->input('remiseans',array('type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureavoir]['.$i.'][remiseans]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'remiseans'.$i,'champ'=>'remiseans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  ') );?>
                                    </td>
                                     <td>
                                     <?php echo $this->Form->input('prixnet',array('value'=>$lfav['Lignefactureavoir']['prixnet'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureavoir]['.$i.'][prixnet]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'prixnet'.$i,'champ'=>'prix','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeremisenet') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('puttc',array('value'=>$lfav['Lignefactureavoir']['puttc'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureavoir]['.$i.'][puttc]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'puttc'.$i,'champ'=>'puttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeprixvente') );
                                     echo $this->Form->input('totalhtans',array('value'=>$lfav['Lignefactureavoir']['totalhtans'],'type'=>'hidden','div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => 'data[Lignefactureavoir]['.$i.'][totalhtans]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'totalhtans'.$i,'champ'=>'totalhtans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('totalht',array('value'=>$lfav['Lignefactureavoir']['totalht'],'div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => 'data[Lignefactureavoir]['.$i.'][totalht]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'totalht'.$i,'champ'=>'totalht','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td>
                                     <?php echo $this->Form->input('tva',array('value'=>$lfav['Lignefactureavoir']['tva'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureavoir]['.$i.'][tva]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'tva'.$i,'champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                     <td >
                                     <?php echo $this->Form->input('totalttc',array('value'=>$lfav['Lignefactureavoir']['totalttc'],'readonly'=>'readonly','div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureavoir]['.$i.'][totalttc]','table'=>'Lignefactureavoir','index'=>$i,'id'=>'totalttc'.$i,'champ'=>'totalttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                     <?php  if($this->request->data['Factureavoir']['factureclient_id']==null){ ?>
                                    <td align="center"><i index="<?php echo $i; ?>"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                     <?php } ?>
</tr>
                                 <?php } ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo @$i; ?>"  id="index" /></div>
                <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="pop">
                      
                        
                    </div>
                    <br>
                   <a  class="remodal-confirm ls-light-green-btn btn" ><strong>OK</strong></a>
                    
               </div>
                            </div>
                        </div>                
                       </div> 
                                                             
                 <div class="col-md-6 favr" ><?php
		echo $this->Form->input('remise',array('div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'remise','class'=>'form-control') );
	        echo $this->Form->input('tva',array('label'=>'TVA','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control') );
		
                ?></div><div class="col-md-6 favr" ><?php
		echo $this->Form->input('totalht',array('label'=>'Total HT','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_HT','class'=>'form-control') );
                ?>
                 </div>  
                  
            <?php }  ?>  
                <div class="col-md-6 favf " ><?php
                echo $this->Form->input('timbre_id',array('value'=>$timbre,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','id'=>'timbre','champ'=>'timbre','class'=>'form-control calculefacture') );
		echo $this->Form->input('totalttc',array('label'=>'Total TTC','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_TTC','class'=>'form-control') );
                ?>
                 </div>   
                 <div class="col-md-6 favf " ><?php
                ?>
                 </div>     
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary removeDisabledButton testlignedevente">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
                                           </div>
</div>
                            </div>
                        </div>
</div>

                                  