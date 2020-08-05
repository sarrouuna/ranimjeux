<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Bonentres/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification Bonentre'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Bonentre',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('fournisseur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('date',array('div'=>'form-group','value'=>$date,'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire') );		
	?></div><div class="col-md-6"><?php
		echo $this->Form->input('numero',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?>
  </div>        
       <!-- Autre ligne entréé-->
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne d\'entré'); ?></h3>
                                   
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Article</td>
                                    <td align="center" nowrap="nowrap">Date de fabrication</td>
                                    <td align="center" nowrap="nowrap">Date de validite</td>
                                    <td align="center" nowrap="nowrap"> Quantite </td>
                                    <td align="center" nowrap="nowrap">Détail d'entré    </td>

                                    <td align="center"></td>
                                </tr>
                                </thead>
                                <tbody>
                                
                                     <?php
                                            foreach ($lignereceptions as $i=>$lr){ $k=100*$i;
                                        
                                        if ($lr['Lignereception']['datefabrication']){ $datefabrication=date("d/m/Y",strtotime(str_replace('-','/',$lr['Lignereception']['datefabrication'])));}
                                        if ($lr['Lignereception']['datevalidite']){ $datevalidite=date("d/m/Y",strtotime(str_replace('-','/',$lr['Lignereception']['datevalidite'])));}
                                       
                                        ?> 
                                <tr>
                                    <td style="width:15%">
                                       <?php echo $this->Form->input('id',array('value'=>$lr['Lignereception']['id'],'name'=>'data[Lignereception]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Lignereception','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('sup',array('name'=>'data[Lignereception]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Lignereception','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('article_id',array('value'=>$lr['Article']['id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignereception]['.$i.'][article_id]','table'=>'Lignereception','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select idarticle editligneinvarticle','empty'=>'Veuillez choisir !!') );?>               
                                    </td>
                                    <td style="width:15%">
                                        <?php echo $this->Form->input('datefabrication',array('value'=>@$datefabrication,'name'=>'data[Lignereception]['.$i.'][datefabrication]','id'=>'datefabrication'.$i,'table'=>'Lignereception','index'=>$i,'champ'=>'datefabrication','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control datePickerOnly  ','required data-bv-notempty-message'=>'Champ Obligatoire' ) );?>
                                    </td>
                                    <td  style="width:15%">
                                        <?php echo $this->Form->input('datevalidite',array('value'=>@$datevalidite,'name'=>'data[Lignereception]['.$i.'][datevalidite]','id'=>'date'.$i,'table'=>'Lignereception','index'=>$i,'champ'=>'datevalidite','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','type'=>'text','after'=>'</div>','class'=>'form-control  datePickerOnly editligneinvdate','required data-bv-notempty-message'=>'Champ Obligatoire' ) );?>
                                    </td>
                                     <td style="width:10%">
                                        <?php echo $this->Form->input('quantite',array('value'=>$lr['Lignereception']['quantite'],'label'=>'','div'=>'form-group', 'name' => 'data[Lignereception]['.$i.'][quantite]','table'=>'Lignereception','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control editfacfournisseur','required data-bv-notempty-message'=>'Champ Obligatoire') );?>
                                     </td>
                                    <td style="width:42%">
                                         
                                <div class="col-md-12" >
                                    
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable<?php echo $i; ?>" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                   
                                    <td align="center" nowrap="nowrap">Depots</td>
                                    <td align="center" nowrap="nowrap"> Quantite </td>
                                    <td align="center">
                    <a class="btn btn-danger  ajouterligne_be" table='addtable<?php echo $i; ?>' index='index'  tr="tr"><i class="fa fa-plus-circle"  ></i>  </a>
                                    </td>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;">
                                   
                                    <td style="width:50%">
                                        <?php  echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Detail'.$i,'index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'') );?>
                                        <?php echo $this->Form->input('depot_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Detail'.$i,'index'=>'','id'=>'','champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:40%">
                                        <?php echo $this->Form->input('qte',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Detail'.$i,'index'=>'','id'=>'','ligne'=>$i,'champ'=>'qte','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testqtebe') );?>
                                    </td>
                                    <td align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                 <?php  //debug($ligneentres); die;
                                           
                                        foreach ($ligneentres as $e=>$le){ 
                                            
                                                if(!empty($le['Ligneentre']['lignereception_id'])){
                                                $cond=$le['Ligneentre']['lignereception_id']==@$lr['Lignereception']['id'];
                                                }else{
                                                   $cond=($le['Ligneentre']['lignefacture_id']==@$lr['Lignefacture']['id']); 
                                                }   
                                                  
                                        if(@$cond){
                                ?> 
                                <tr>
                                   
                                    <td style="width:50%">
                                       <?php echo $this->Form->input('sup',array('name'=>'data[Lignereception]['.$i.'][Detail]['.$e.'][sup]','id'=>'sup0','champ'=>'sup','table'=>'Lignereception','index'=>$e,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                       <?php echo $this->Form->input('depot_id',array('value'=>$le['Ligneentre']['depot_id'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignereception]['.$i.'][Detail]['.$e.'][depot_id]','table'=>'Lignereception','index'=>$k,'id'=>'depot_id'.$k,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                     <td style="width:40%">
                                        <?php  echo $this->Form->input('qte',array('value'=>$le['Ligneentre']['quantite'],'label'=>'','div'=>'form-group', 'name' => 'data[Lignereception]['.$i.'][Detail]['.$e.'][qte]','ligne'=>$i,'table'=>'Lignereception','index'=>$k,'id'=>'qte'.$k,'champ'=>'qte','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testqtebe ','required data-bv-notempty-message'=>'Champ Obligatoire') );?>
                                     </td>
                                   
                                    <td align="center"><i index="<?php echo $k; ?>"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                            <?php }} ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo $e; ?>"  id="index" />
</div>
                            </div>
                                        
                               
                                        
                                    </td>   
                                    <td align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                 <?php } ?> 
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

