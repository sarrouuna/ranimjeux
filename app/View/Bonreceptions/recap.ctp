<script>
    function view(){
       // window.location.href='<?php //echo $this->webroot; ?>articles/view/1';
    }
</script>
<input type="hidden" id="index_kbira" value="<?php echo $index_kbira; ?>">
<ul class="nav nav-tabs icon-tab">
<li class="active"><a href="#article" data-toggle="tab" ><i class="fa fa-home"></i> <span>Fiche Article</span></a></li>
<li class="param"><a href="#prixvente" data-toggle="tab"><i class="fa fa-gears"></i> <span>Changer Prix de Vente & Marge</span></a></li>
</ul>
<div class="tab-content tab-border">
<div class="tab-pane fade in active" id="article">
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
                                 <label class='col-md-2 control-label'><?php echo __('Unité'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $article['Unite']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>	
           <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Code'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($article['Article']['code']); ?>'>

                                  </div>
			
		
                                 
</div>		
       <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Désignation'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($article['Article']['name']); ?>'>

                                  </div>
			
		
                                 
</div>	              
                            
           
                                    
                                    
                                    
                                      
              		 			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Stock Alert'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($article['Article']['stockalert']); ?>'>

                                  </div>
			
		
                                 
</div>	
         <div class="form-group">
                <label class="col-md-2" control-label><?php echo __('Tags'); ?></label>
                  <div class="col-sm-10"><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $taglist ?>'>
                  </div>	   
              </div>                                
            </div>   <div class="col-md-6">                            
                                        
                                        <div class='form-group'>	
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
             
         
            </div>

            	

                            </div>
<?php echo $this->Form->end();?>
	
</div></div></div>
</div> 
<div class="tab-pane fade in param" id="prixvente">
<center>
<table>
        <tr>
            <td colspan="2" align="center"><strong>Changer le prix de vente</strong> </td>
        </tr>
</table>
    <br>
<table border="0" style="width:80%">
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Marge</label></td><td align="center" style="width:40%"><input type="text" id="marge" value="<?php echo $marge; ?>" onkeyup="calculerprixdevente(<?php echo $index_kbira; ?>,1)"></td>
    </tr>     
   
</table>
    <br>
<table border="0" style="width:80%">     
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Prix de Vente</label></td><td align="center" style="width:40%"><input type="text" id="prixvente" value="<?php echo $pv; ?>" onkeyup="calculerprixdevente(<?php echo $index_kbira; ?>,2)"></td>
    </tr>   
</table>
</center>
<br>
</div>
</div>
