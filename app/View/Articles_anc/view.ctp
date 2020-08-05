<script language="JavaScript" type="text/JavaScript">

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}

</script>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Articles/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation Article'); ?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo $this->Form->create('Article',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
                           
           <div class="col-md-6">                         
             		 		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Famille'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $article['Famille']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Sous Famille'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $article['Sousfamille']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Sous Sous Famille'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $article['Soussousfamille']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('UnitÃ©'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $article['Unite']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>	
           <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Code'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($article['Article']['code']); ?>'>

                                  </div>
			
		
                                 
</div>		
       <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('DÃ©signation'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($article['Article']['name']); ?>'>

                                  </div>
			
		
                                 
</div>	              
                            
           </div>
                                    
                                    
                                    
                                    <div class="col-md-6">     
              		 			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Stock Alert'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($article['Article']['stockalert']); ?>'>

                                  </div>
			
		
                                 
</div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Prix D\'achat en devise'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($article['Article']['prixachatdevise']); ?>'>

                                  </div>
                                 
                         </div>	
                         <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Taux De Change'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($article['Article']['tauxchange']); ?>'>

                                  </div>
                                 
                         </div>	
                         <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Coefficient'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($article['Article']['coefficient']); ?>'>

                                  </div>
                                 
                         </div>	
                         <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Cout de revient'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($article['Article']['coutrevient']); ?>'>

                                  </div>
                                 
                         </div>	
                        <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Marge %'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($article['Article']['marge']); ?>'>

                                  </div>
                          </div>	
                        <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Prix De Vente'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($article['Article']['prixvente']); ?>'>

                                  </div>
                          </div>			
                          <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('TVA'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($article['Article']['tva']); ?>'>

                                  </div>
                                 
                         </div>	
                         <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('cout moyen pondéré'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($stockdepots['Stockdepot']['prix']); ?>'>

                                  </div>
                                 
                         </div>	
              <div class="form-group">
                <label class="col-md-2" control-label>Tags</label>
                  <div class="col-sm-10"><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $taglist ?>'>
                  </div>	   
              </div>
         
            </div>

              <div class='form-group'>	                
     <img src="<?php echo $this->webroot;?>files/upload/<?php echo $article['Article']['homologation'];?>" alt="" style="position: relative;left: 100px;"/>
           </div>	

                            </div>
<?php echo $this->Form->end();?>
	
</div></div></div>
    
      <!-- Autre Fournisseur-->
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Article Fournisseur'); ?></h3>
                                    
                                </div>
                                <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:90%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Fournisseur</td>
                                    <td align="center" nowrap="nowrap">Prix</td>
                                    <td align="center" nowrap="nowrap">Reference</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;">
                                    <td style="width:25%">
                                       <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $artfours['Fournisseur']['name'] ?>'>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('prix',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Articlefournisseur','index'=>'','id'=>'','champ'=>'prix','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('reference',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Articlefournisseur','index'=>'','id'=>'','champ'=>'reference','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                   
                                
                                </tr>
                               <?php
                               
                               foreach ($artfours as $i=>$af){
                                   //debug($af);
                                   
                                ?> 
                                <tr>
                                    <td style="width:33%">
                                       <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $af['Fournisseur']['name'] ?>'>  
                                    </td>
                                    <td style="width:33%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $af['Articlefournisseur']['prix'] ?>'>   
                                    </td>
                                    <td style="width:33%">
                                      <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $af['Articlefournisseur']['reference']  ?>'>                              
                                    </td>
                                </tr>
                                <?php } ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value=<?php echo @$i; ?>  id="index" />
</div>
                            </div>
                        </div>                
</div>    
     <!-- Autre client-->
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Remise Client'); ?></h3>
                                 
                                </div>
                                <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtablec" style="width:90%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Client</td>
                                    <td align="center" nowrap="nowrap">Remise</td>
                                </tr>
                                </thead>
                                <tbody>
                               
                               <?php  foreach ($artclient as $c=>$ac){        ?> 

                                <tr>
                                    <td style="width:50%">
                                        <?php echo $this->Form->input('client_id',array('value'=>@$clients[$ac['Articleclient']['client_id']],'div'=>'form-group','label'=>'', 'name' => '','table'=>'Articleclient','index'=>@$c,'id'=>'','champ'=>'client_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','type'=>'text') );?>
                                    </td>
                                    <td style="width:50%">
                                        <?php //echo $this->Form->input('remise',array('name'=>'data[Articleclient][0][remise]','id'=>'remise0','table'=>'Articleclient','index'=>'0','champ'=>'remise','label'=>'','div'=>'form-group','between'=>'<div class="coel-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                        <?php echo $this->Form->input('remise',array('value'=>@$ac['Articleclient']['remise'],'div'=>'form-group','label'=>'', 'name' => 'data[Articleclient]['.$c.'][remise]','id'=>'remise'.$c,'table'=>'Articleclient','index'=>$c,'champ'=>'remise','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                   
                                </tr>
                                <?php } ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo $c; ?>" id="indexc" />
</div>
                            </div>
                        </div>                
</div> 




<div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Remise Famille Client'); ?></h3>
                                 
                                </div>
                                <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtablec" style="width:90%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Famille Client</td>
                                    <td align="center" nowrap="nowrap">Remise</td>
                                </tr>
                                </thead>
                                <tbody>
                               
                               <?php  foreach ($artfamilleclients as $c=>$ar){        ?> 

                                <tr>
                                    <td style="width:50%">
                                        <?php echo $this->Form->input('familleclient_id',array('value'=>@$familleclients[$ar['Remiseartfamille']['familleclient_id']],'div'=>'form-group','label'=>'', 'name' => 'data[Remiseartfamille][0][familleclient_id]','table'=>'Remiseartfamille','index'=>'0','id'=>'familleclient_id0','champ'=>'familleclient_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez choisir !!','type'=>'text') );?>
                                    </td>
                                    <td style="width:50%">
                                        <?php //echo $this->Form->input('remise',array('name'=>'data[Articleclient][0][remise]','id'=>'remise0','table'=>'Articleclient','index'=>'0','champ'=>'remise','label'=>'','div'=>'form-group','between'=>'<div class="coel-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                        <?php echo $this->Form->input('remise',array('value'=>@$ar['Remiseartfamille']['remise'],'div'=>'form-group','label'=>'', 'name' => 'data[Remiseartfamille][0][remise]','id'=>'remise0','table'=>'Remiseartfamille','index'=>'0','champ'=>'remise','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                   
                                </tr>
                                <?php } ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo $c; ?>" id="indexc" />
</div>
                            </div>
                        </div>                
</div>










    </div>


	

