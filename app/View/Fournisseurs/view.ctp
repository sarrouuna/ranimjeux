<script language="JavaScript" type="text/JavaScript">

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}
$(document).ready(function() {
   
        $(".iframe").colorbox({iframe:true, width:"60%", height:"60%", href: function(){
                return  wr+"Bonlivraisons/choix/"+$(this).attr('id');
            }})
    });
</script>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Fournisseurs/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation Fournisseur'); ?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo $this->Form->create('Fournisseur',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
                           
           <div class="col-md-6">                         
             			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Famille Fournisseur'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $fournisseur['Famillefournisseur']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div> <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Devise'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($fournisseur['Devise']['name']); ?>'>

                                  </div>
			
		
                                 
                        </div> <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Code'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($fournisseur['Fournisseur']['code']); ?>'>

                                  </div>
			
		
                                 
</div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Raison social'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($fournisseur['Fournisseur']['name']); ?>'>

                                  </div>
			
		
                                 
</div>	
           
      <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Adresse'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($fournisseur['Fournisseur']['adresse']); ?>'>

                                  </div>
			
		
                                 
</div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Tel'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($fournisseur['Fournisseur']['tel']); ?>'>

                                  </div>
			
		
                                 
</div>	     
           
           
           </div><div class="col-md-6">     
              		 		 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Fax'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($fournisseur['Fournisseur']['fax']); ?>'>

                                  </div>
			
		
                                 
</div>			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Mail'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($fournisseur['Fournisseur']['mail']); ?>'>

                                  </div>
			
		
                                 
</div>

      <!--            //85555555555555dfghjklmfghjk                      -->    
                            <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Matricule fiscale'); ?></label>	
                                  
			
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $fournisseur['Fournisseur']['matriculefiscale']; ?>'>
                                  </div>
			
		
                                 
                            </div>	
                            <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Registre de  commerce'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($fournisseur['Fournisseur']['registrecommerce']); ?>'>

                                  </div>
	              </div>	
                
  <div class='form-group'>	                
  <label class='col-md-2 control-label'><?php echo __('Registre de  commerce'); ?></label>       
    <div class='col-sm-10'>
    <?php if(!empty($fournisseur['Fournisseur']['registrecommercef'])){ ?>
        <a onClick="flvFPW1(wr+'files/upload/<?php echo $fournisseur['Fournisseur']['registrecommercef'];?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i> Imprimer</button></a>     
    <?php } ?>
    </div>
 </div>	

 <div class='form-group'> <label class='col-md-2 control-label'><?php echo __('Patente'); ?></label>
     <div class='col-sm-10'>
     <?php if(!empty($fournisseur['Fournisseur']['patente'])){ ?>
         <a onClick="flvFPW1(wr+'files/upload/<?php echo $fournisseur['Fournisseur']['patente'];?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i> Imprimer</button></a>     
     <?php } ?>
     </div>
</div>	


</div>
                                    
                                     <!-- Autre contact-->
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Contacts'); ?></h3>
                             
                                </div>
                                <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:90%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Nom prénom</td>
                                    <td align="center" nowrap="nowrap">Fonction</td>
                                    <td align="center" nowrap="nowrap">Tel</td>
                                    <td align="center" nowrap="nowrap">Mail</td>
                                </tr>
                                </thead>
                                <tbody>
                              
                                <?php
                               foreach ($contacts as $i=>$contact){
                                ?>  
                                <tr>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('id',array('value'=>$contact['Contact']['id'],'name'=>'data[Contact]['.$i.'][id]','id'=>'id'.$i,'champ'=>'id','table'=>'Contact','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('sup',array('name'=>'data[Contact]['.$i.'][sup]','id'=>'sup0','champ'=>'sup','table'=>'Contact','index'=>'0','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('name',array('value'=>$contact['Contact']['name'],'label'=>'','div'=>'form-group', 'name' => 'data[Contact]['.$i.'][name]','table'=>'Contact','index'=>$i,'id'=>'name'.$i,'champ'=>'name','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('fonction',array('value'=>$contact['Contact']['fonction'],'label'=>'','div'=>'form-group', 'name' => 'data[Contact]['.$i.'][fonction]','table'=>'Contact','index'=>$i,'id'=>'fonction'.$i,'champ'=>'fonction','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('tel',array('value'=>$contact['Contact']['tel'],'name'=>'data[Contact]['.$i.'][tel]','id'=>'tel'.$i,'table'=>'Contact','index'=>$i,'champ'=>'tel','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                   <td style="width:25%">
                                        <?php echo $this->Form->input('mail',array('value'=>$contact['Contact']['mail'],'label'=>'','div'=>'form-group', 'name' => 'data[Contact]['.$i.'][mail]','table'=>'Contact','index'=>$i,'id'=>'mail'.$i,'champ'=>'mail','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
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
                                    
                                    
                                    
<?php echo $this->Form->end();?>
	
</div></div></div></div>


	

