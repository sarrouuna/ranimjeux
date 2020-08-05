<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Factureclients/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<?php $p=CakeSession::read('depot');
       if($p==0){
         $numspecial="";
         $mm="";
       }
         ?>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout Facture Avoir'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Factureavoir',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
                if($p==0){
                echo $this->Form->input('pointdevente_id',array('id'=>'pointdevente_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select numspecial'));
                }
		echo $this->Form->input('client_id',array('id'=>'client_id','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez Choisir !!') );
		echo $this->Form->input('numeroconca',array('id'=>'numeroconca','type'=>'hidden','value'=>$mm,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('model',array('id'=>'model','type'=>'hidden','value'=>'Factureavoir','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('typefacture_id',array('value'=>1,'label'=>'Type facture','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'typefacture_id','class'=>'form-control select typefacture','empty'=>'Veuillez Choisir !!') );
                ?></div><div class="col-md-6"><?php
		echo $this->Form->input('date',array('div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
		echo $this->Form->input('numero',array('id'=>'numero','value'=>$numspecial,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
	?>
        </div>  
                                    
                                  
                                          <!-- Autre ligne facture avoir-->
                   <div class="row ligne favr"  style="width:180%">
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne Facture à voir'); ?></h3>
                                  
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
                                    <td align="center" width="1%"></td>
                                </tr>
                                </thead>
                                <tbody>
                                    
                                    
                                    <tr class="tr " style="display:none;" >
                                    <td id="" champ="tdaff" index="" >
                                    <span title="Ancien prix"><a style="display:none;" onclick="recap_rapport()" href="#reModal_refuser" id="" index="" champ="order" value="0" <button class=' '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>    
                                    <td >
                                        <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control uniform_select depot_qte_s testclientvide','empty'=>'Veuillez Choisir !!') );?>
                                    </td>  
                                    <td >
                                        <?php echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'article_id','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control articleidbl','empty'=>'Veuillez Choisir !!') );?>
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
                                     echo $this->Form->input('totalhtans',array('div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => '','table'=>'Lignefactureclient','index'=>'','id'=>'','champ'=>'totalhtans','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
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
                                
                                    <tr class="cc0 testclientvide" >
                                    <td id="tdaff0" >
                                    <span title="Ancien prix"><a style="display:none;" onclick="recap_rapport(0)" href="#reModal_refuser" champ="order" id="order0" value="0" <button class='  '><i class='fa fa fa-pencil'></i></a></span>
                                    </td>    
                                    <td >
                                    	 <?php	echo $this->Form->input('depot_id',array('label'=>'','div'=>'form-group', 'name' => 'data[Lignefactureclient][0][depot_id]','table'=>'Lignefactureclient','index'=>'0','id'=>'depot_id0','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select depot_qte_s testclientvide','empty'=>'Veuillez Choisir !!') );?>
                                    </td>  
                                    <td  class="" index="0">
                                        <?php echo $this->Form->input('article_id',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient][0][article_id]','table'=>'Lignefactureclient','index'=>'0','id'=>'article_id0','champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select  articleidbl','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                     <td >
                                        <?php echo $this->Form->input('sup',array('name'=>'data[Lignefactureclient][0][sup]','id'=>'sup0','champ'=>'sup','table'=>'Lignefactureclient','index'=>'0','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('quantitestock',array('readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignefactureclient][0][quantitestock]','table'=>'Lignefactureclient','index'=>'0','id'=>'quantitestock0','champ'=>'quantitestock','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                     <td >
                                        <?php echo $this->Form->input('quantite',array('label'=>'','div'=>'form-group', 'name' => 'data[Lignefactureclient][0][quantite]','table'=>'Lignefactureclient','index'=>'0','id'=>'quantite0','champ'=>'quantite','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control   calculefacture ') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('prixachat',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'','index'=>'0','id'=>'prixachat0','champ'=>'prixachat','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                     <?php echo $this->Form->input('prix',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient][0][prixhtva]','table'=>'Lignefactureclient','index'=>'0','id'=>'prixhtva0','champ'=>'prix','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeinverseputtc') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('remise',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient][0][remise]','table'=>'Lignefactureclient','index'=>'0','id'=>'remise0','champ'=>'remise','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculeprix_net_ttc calculefacture') );
                                     echo $this->Form->input('remiseans',array('type'=>'hidden','div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient][0][remiseans]','table'=>'Lignefactureclient','index'=>'0','id'=>'remiseans0','champ'=>'remiseans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  ') );?>
                                    </td>
                                     <td>
                                     <?php echo $this->Form->input('prixnet',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient][0][prixnet]','table'=>'Lignefactureclient','index'=>'0','id'=>'prixnet0','champ'=>'prix','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeremisenet') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('puttc',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient][0][puttc]','table'=>'Lignefactureclient','index'=>'0','id'=>'puttc0','champ'=>'puttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control  calculeprixvente') );
                                     echo $this->Form->input('totalhtans',array('type'=>'hidden','div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => 'data[Lignefactureclient][0][totalhtans]','table'=>'Lignefactureclient','index'=>'0','id'=>'totalhtans0','champ'=>'totalhtans','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php
                                     echo $this->Form->input('totalht',array('div'=>'form-group','label'=>'','readonly'=>'readonly', 'name' => 'data[Lignefactureclient][0][totalht]','table'=>'Lignefactureclient','index'=>'0','id'=>'totalht0','champ'=>'totalht','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('tva',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient][0][tva]','table'=>'Lignefactureclient','index'=>'0','id'=>'tva0','champ'=>'tva','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control calculefacture') );?>
                                    </td>
                                    <td >
                                     <?php echo $this->Form->input('totalttc',array('readonly'=>'readonly','div'=>'form-group','label'=>'', 'name' => 'data[Lignefactureclient][0][totalttc]','table'=>'Lignefactureclient','index'=>'0','id'=>'totalttc0','champ'=>'totalttc','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td align="center"><i index="0"  class="fa fa-times supp1" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                 
                                </tbody>
                                </table>
              	<input type="hidden" value="0" id="index" />
</div>
                                <a class="btn btn-danger ajouterligne_livraison1" table='addtable' index='index'  tr="tr" style="
                                    float: left; 
                                    position: relative;
                                    top: -35px;
                                "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                            </div>
                        </div>                
</div> 
                <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="pop">
                      
                        
                    </div>
                    <br>
                   <a  class="remodal-confirm ls-light-green-btn btn" ><strong>OK</strong></a>
                    
                </div>                                              
                 <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('remise',array('div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'remise','class'=>'form-control') );
	        echo $this->Form->input('tva',array('label'=>'TVA','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'tva','class'=>'form-control') );
                echo $this->Form->input('timbre_id',array('div'=>'form-group','value'=>$timbre,'between'=>'<div class="col-sm-10">','type'=>'text','after'=>'</div>','id'=>'timbre','champ'=>'timbre','class'=>'form-control calculefacture') );
                ?></div><div class="col-md-6"><?php
		echo $this->Form->input('totalht',array('label'=>'Total HT','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_HT','class'=>'form-control') );
		echo $this->Form->input('totalttc',array('label'=>'Total TTC','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'text','readonly'=>'readonly','after'=>'</div>','id'=>'Total_TTC','class'=>'form-control') );
	?>
       </div>            
                
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary testpv testlignedevente">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
                                           </div>
</div>
                            </div>
                        </div>
</div>

