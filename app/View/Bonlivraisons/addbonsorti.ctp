<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Bonlivraisons/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout Bon de sortie'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Bonsorti',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('client_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                echo $this->Form->input('numero',array('value'=>$mm,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		?></div><div class="col-md-6"><?php
		echo $this->Form->input('date',array('div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?>
  </div>        
                                    
        <!-- Autre ligne livraison-->
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne de sortie'); ?></h3>
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Depot</td>
                                    <td align="center" nowrap="nowrap">Article</td>
                                    <td align="center" nowrap="nowrap">Qte total en stock</td>
                                    <td align="center" nowrap="nowrap"> Quantite </td>
                                    <td align="center" nowrap="nowrap">              
                               <table class="" id="" style="width:90%" align="center">
                                 <thead>
                                  <tr>
                                    <td align="left" nowrap="nowrap">Qte en stock</td>
                                    <td align="left" nowrap="nowrap">date validité</td>
                                    <td align="left" nowrap="nowrap">Qte</td>
                                 </tr> 
                                </thead>
                               </table>
                                    
                                    </td>    
                                  
                                    <td align="center"></td>
                                </tr>
                                </thead>
                                <tbody>
                             
                                  <?php  foreach ($lignelivraisons as $i=>$l){ 
                                      $q=@$tabqtestock[$l['Depot']['id']][$l['Article']['id']]['qtestock']; ?> 
                                
                                <tr class="cc" >
                                     <td style="width:15%">
                                    	 <?php	echo $this->Form->input('depotid',array('value'=>$l['Depot']['designation'],'label'=>'','readonly'=>'readonly','div'=>'form-group', 'name' => '','table'=>'Lignesorti','index'=>'','id'=>'','champ'=>'','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );?>
                                         <?php echo $this->Form->input('depot_id',array('value'=>$l['Depot']['id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignesorti]['.$i.'][depot_id]','table'=>'Lignesorti','index'=>$i,'id'=>'depot_id'.$i,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','type'=>'hidden') );?>               
                                     </td> 
                                   <!--    <td style="width:25%"  champ="tdarticle" id="tdarticle0">
                                         <div class="form-group">
                                         <div class="col-sm-12">    
                                       <select name="data[Lignesorti][<?php // echo $i?>][article_id]" table="Lignesorti" readonly="readonly" index="<?php // echo $i?>" id="article_id<?php // echo $i?>" champ="article_id" class="form-control select art">
                                           <option value="" >Veuillez choisir !!</option>
                                           <?php //foreach ($tabqtestock[$l['Depot']['id']]['articles'] as $p=>$frs){?>
                                           <option value="<?php //echo $p ?>" <?php // if($p==$l['Article']['id']){ ?> selected="selected"<?php //} ?> ><?php // echo $tabqtestock[$l['Depot']['id']]['articles'][$p] ?></option>
                                           <?php //} ?>
                                       </select></div></div>
                                    </td>  --> 
                                    <td style="width:25%"  champ="tdarticle" id="tdarticle0" >
                                       <?php echo $this->Form->input('articleid',array('value'=>$l['Article']['name'],'div'=>'form-group','label'=>'', 'readonly'=>'readonly', 'name' => '','table'=>'Lignesorti','index'=>'','id'=>'','champ'=>'','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>               
                                       <?php echo $this->Form->input('article_id',array('value'=>$l['Article']['id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignesorti]['.$i.'][article_id]','table'=>'Lignesorti','index'=>$i,'id'=>'article_id'.$i,'champ'=>'articlec_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','type'=>'hidden') );?>               
                                    </td> 
                                     <td style="width:15%">
                                        <?php echo $this->Form->input('id',array('value'=>$l['Lignelivraison']['id'],'name'=>'data[Lignesorti]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignesorti','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'data[Lignesorti]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignesorti','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('quantitestock',array('value'=>$q,'readonly'=>'readonly','label'=>'','div'=>'form-group', 'name' => 'data[Lignesorti]['.$i.'][quantitestock]','table'=>'Lignesorti','index'=>$i,'id'=>'quantitestock'.$i,'champ'=>'quantitestock','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                     <td style="width:12%">
                                        <?php echo $this->Form->input('quantite',array('value'=>$l['Lignelivraison']['quantite']-$l['Lignelivraison']['quantitelivrai'],'label'=>'','readonly'=>'readonly','div'=>'form-group', 'name' => 'data[Lignesorti]['.$i.'][quantite]','table'=>'Lignesorti','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testqte','required data-bv-notempty-message'=>'Champ Obligatoire') );?>
                                    </td>
                               <td style="width:33%"  >
                                   <table>
                                        <?php foreach ($l['Stockdepots'] as $j=>$sd){ $k=(($i+1)*1000)+$j  ?> 
                                <tr>
                                    <td align="center" style="width:35%">
                                <?php echo $this->Form->input('id',array('value'=>$sd['Stockdepot']['id'], 'name' => 'data[Lignesorti]['.$i.'][Stockdepot]['.$j.'][id]','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );    
                                      echo $this->Form->input('qtestock',array('value'=>$sd['Stockdepot']['quantite'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignesorti]['.$i.'][Stockdepot]['.$j.'][qtestock]','readonly'=>'readonly','table'=>'Lignesorti','index'=>$k,'id'=>'qtestk'.$k,'champ'=>'','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                     <td style="width:40%">
                                        <?php echo $this->Form->input('date',array('value'=>date("d/m/Y",strtotime(str_replace('-','/',$sd['Stockdepot']['date']))),'div'=>'form-group','label'=>'', 'name' =>'data[Lignesorti]['.$i.'][Stockdepot]['.$j.'][date]','readonly'=>'readonly','table'=>'Lignesorti','index'=>'','id'=>'','champ'=>'date','between'=>'<div class="col-sm-12">','after'=>'</div>','type'=>'text','class'=>'form-control') );?>
                                    </td>
                                    <td align="center" style="width:25%">
                                     <?php  echo $this->Form->input('qte',array('div'=>'form-group','label'=>'', 'name' => 'data[Lignesorti]['.$i.'][Stockdepot]['.$j.'][quantite]','table'=>'Lignesorti','index'=>$k,'id'=>'quantitedetail'.$k,'champ'=>'quantite','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testdetailqte') );?>
                                    </td>
                                </tr>  
                                <?php } ?>
                                </table>
                                    </td>
                                    <td align="center"><i index="<?php echo @$i; ?>"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                  </tr>
                                  <?php }?>
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo $i; ?>"  id="index" />
</div>
                            </div>
                        </div>                
</div> 
                                                                                
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

