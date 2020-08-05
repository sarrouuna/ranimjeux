<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Bonsortis/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation Bonsorti'); ?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo $this->Form->create('Bonsorti',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
                           
           <div class="col-md-6">                         
             		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Id'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($bonsorti['Bonsorti']['id']); ?>'>

                                  </div>
			
		
                                 
</div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Client'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bonsorti['Client']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Utilisateur'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bonsorti['Utilisateur']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>	</div><div class="col-md-6">     
              		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Bonlivraison'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bonsorti['Bonlivraison']['numero']; ?>'>
                                  </div>
			
		
                                 
                            </div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Factureclient'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $bonsorti['Factureclient']['numero']; ?>'>
                                  </div>
			
		
                                 
                            </div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h(date("d/m/Y",strtotime(str_replace('-','/',$bonsorti['Bonsorti']['date'])))); ?>'>

                                  </div>
			
		
                                 
</div>	</div>
                                    
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
                                    <td align="center" nowrap="nowrap"> Quantite </td>
                                    <td align="center" nowrap="nowrap">              
                               <table class="" id="" style="width:90%" align="center">
                                 <thead>
                                  <tr>
                                    <td align="left" nowrap="nowrap">date validité</td>
                                    <td align="left" nowrap="nowrap">Qte</td>
                                 </tr> 
                                </thead>
                               </table>
                                    
                                    </td>    
                                </tr>
                                </thead>
                                <tbody>
                             
                                  <?php  foreach ($lignesortis as $i=>$l){  if($l['Lignesorti']['quantite']){//debug($tabqtestock);die; ?> 
                                
                                <tr class="cc" >
                                     <td style="width:20%">
                                    	 <?php	echo $this->Form->input('depotid',array('value'=>$l['Depot']['designation'],'label'=>'','readonly'=>'readonly','div'=>'form-group', 'name' => '','table'=>'Lignesorti','index'=>'','id'=>'','champ'=>'','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );?>
                                         <?php echo $this->Form->input('depot_id',array('value'=>$l['Depot']['id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignesorti]['.$i.'][depot_id]','table'=>'Lignesorti','index'=>$i,'id'=>'depot_id'.$i,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','type'=>'hidden') );?>               
                                     </td> 
                                    <td style="width:25%"  champ="tdarticle" id="tdarticle0" >
                                       <?php echo $this->Form->input('articleid',array('value'=>$l['Article']['name'],'div'=>'form-group','label'=>'', 'readonly'=>'readonly', 'name' => '','table'=>'Lignesorti','index'=>'','id'=>'','champ'=>'','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>               
                                       <?php echo $this->Form->input('article_id',array('value'=>$l['Article']['id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignesorti]['.$i.'][article_id]','table'=>'Lignesorti','index'=>$i,'id'=>'article_id'.$i,'champ'=>'articlec_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','type'=>'hidden') );?>               
                                    </td> 
                                     <td style="width:15%">
                                        <?php echo $this->Form->input('quantite',array('value'=>$l['Lignesorti']['quantite'],'label'=>'','readonly'=>'readonly','div'=>'form-group', 'name' => 'data[Lignesorti]['.$i.'][quantite]','table'=>'Lignesorti','index'=>$i,'id'=>'quantite'.$i,'champ'=>'quantite','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testqte','required data-bv-notempty-message'=>'Champ Obligatoire') );?>
                                    </td>
                               <td style="width:40%"  >
                                   <table>
                                        <?php foreach ($l['Lignesortidetail'] as $j=>$lsd){  ?> 
                                <tr>
                                    
                                     <td style="width:50%">
                                        <?php echo $this->Form->input('date',array('value'=>date("d/m/Y",strtotime(str_replace('-','/',$lsd['date']))),'div'=>'form-group','label'=>'', 'name' =>'','readonly'=>'readonly','table'=>'Lignesorti','index'=>'','id'=>'','champ'=>'date','between'=>'<div class="col-sm-12">','after'=>'</div>','type'=>'text','class'=>'form-control') );?>
                                    </td>
                                    <td align="center" style="width:50%">
                                     <?php  echo $this->Form->input('qte',array('value'=>$lsd['quantite'],'div'=>'form-group','label'=>'', 'name' =>'','readonly'=>'readonly','table'=>'Lignesorti','index'=>'','id'=>'quantitedetail','champ'=>'quantite','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control testdetailqte') );?>
                                    </td>
                                </tr>  
                                <?php } ?>
                                </table>
                                    </td>
                                  </tr>
                                  <?php }}?>
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo $i; ?>"  id="index" />
</div>
                            </div>
                        </div>                
</div>                                
<?php echo $this->Form->end();?>
	
</div></div></div></div>


	

