<script language="javascript">
    function flvFPW1(){
        var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;
    } 
 </script>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Journees/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ouvrir  Journée'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Journee',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh', 'enctype' => 'multipart/form-data')); ?>

            <div class="col-md-6">                  
              	<?php //debug($journee);die;
                echo $this->Form->input('id',array('div'=>'form-group','value'=>$journee['Journee']['id'],'between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		//debug($this->request->data);die;
                echo $this->Form->input('depot_id',array('div'=>'form-group','value'=>$journee['Journee']['depot_id'],'disabled'=>'disabled','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez Choisir !!') );
		echo $this->Form->input('date_debut',array('label'=>'Date Debut','value'=>date("d/m/Y H:i:s", strtotime(str_replace('-', '/',$journee['Journee']['date_debut']))),'div'=>'form-group','type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control dateTimePickerCustom') );
	?></div><div class="col-md-6"><?php
		echo $this->Form->input('date_fin',array('label'=>'Date Fin','value'=>date("d/m/Y H:i:s", strtotime(str_replace('-', '/',$journee['Journee']['date_fin']))),'div'=>'form-group','type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control dateTimePickerCustom') );
	?>
  </div>  
                                    
        <!-- Autre ligne inventaire-->
                   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Detail'); ?></h3>
                                    
                                </div>
                                <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Personnel</td>
                                    <td align="center" nowrap="nowrap">Fond</td>
                                    <td align="center" nowrap="nowrap">Réçu le</td>
                                    <td align="center" nowrap="nowrap">Total Caisse</td>
                                </tr>
                                </thead>
                                <tbody>
                               <?php
                                $k=0;
                                $total=0;
                                 foreach($personnels as $k=>$per){ 
                                     $total+=$ticket[$per['Personnel']['id']][0][0]['Total_TTC'];?>
                                
                                <tr>
                                    <td>
                                        <?php echo $this->Form->input('id',array('label'=>'','div'=>'form-group','type'=>'hidden','name'=>'data[detail]['.$k.'][id]','value'=>@$Fond[$per['Personnel']['id']][0]['Fond']['id'],'between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                        <?php  echo  $per['Personnel']['name'] ; ?>
                                        <?php echo $this->Form->input('personnel_id',array('label'=>'','div'=>'form-group','type'=>'hidden','name'=>'data[detail]['.$k.'][personnel_id]','value'=>$per['Personnel']['id'],'between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                  
                                    </td>
                                   <td>
                                       <?php echo $this->Form->input('fond',array('label'=>'','div'=>'form-group','type'=>'test','name'=>'data[detail]['.$k.'][fond]','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','value'=>@$Fond[$per['Personnel']['id']][0]['Fond']['fond']) );?>
                                   </td>
                                   <td>
                                       <?php echo $this->Form->input('date',array('label'=>'','div'=>'form-group','value'=>date("d/m/Y H:i:s", strtotime(str_replace('-', '/',@$Fond[$per['Personnel']['id']][0]['Fond']['date']))),'name'=>'data[detail]['.$k.'][date]','type'=>'text','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control dateTimePickerCustom') );?>
                                   <?php echo $this->Form->input('etat',array('label'=>'','div'=>'form-group','value'=>@$Fond[$per['Personnel']['id']][0]['Fond']['etat'],'name'=>'data[detail]['.$k.'][etat]','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                  
                                   </td>
                                   <td><?php  echo $ticket[$per['Personnel']['id']][0][0]['Total_TTC']  ;  ?>   </td>
                                   <td> <?php if ($Fond[$per['Personnel']['id']][0]['Fond']['etat'] == 0) { ?><a href="<?php echo $this->webroot; ?>fonds/cloture/<?php echo $journee['Journee']['id']; ?>/<?php echo @$Fond[$per['Personnel']['id']][0]['Fond']['id']; ?>/<?php echo $ticket[$per['Personnel']['id']][0][0]['Total_TTC']; ?> ">Clôturer Caisse   </a><?php } ?></td>
           
                                     </tr>
                                 <?php } ?>
                                     
        <?php
			
		 $k=0; $espt=0;
 $cht=0;
 $cartt=0;
 $tickrest=0;
  $totalb=0;
 foreach($Famillearticles as $k=>$per)
{	
			
			$totalfamille=0;
// debug($ligne[$per['Famillearticle']['id']]); die;

//if(!empty($ligne[$per['Famillearticle']['id']])) 
	{
   foreach($ligne[$per['Famille']['id']] as $tt)
{
 	 $obj = ClassRegistry::init('Article'); 
                $insmoi = $obj->find('all',array(
                    'conditions'=>array('Article.id'=>$tt['Ticketcaisseligne']['article_id'] )  ,'recursive'=>-1));
						$marge=($insmoi[0]['Article']['prix_ttc']-$insmoi[0]['Article']['prix_achat_ttc'])*$tt[0]['sum(`Ticketcaisseligne`.`qte`)'];
  $totalfamille=$totalfamille+$marge;

				//debug($insmoi); die;	
					

   }
	}
 	
     $totalb+=$totalfamille;    
}
?>                             
                                     
                                     <tr><td colspan="3" align="right"><strong> Total Journée :</strong></td><td colspan="2"> <strong><?php echo $total;?></strong></td></tr>                    
                                     <tr><td colspan="3" align="right"><strong> Total Bénéfice :</strong></td><td colspan="2"> <strong><?php echo sprintf('%.3f',$totalb); ?></strong></td></tr>
                  
                                </tbody>
                                </table>
              	<input type="hidden" value="0" id="index" />
</div>
                                
                            </div>
                        </div>                
</div> 
                           
        <input type="hidden" name="data[Journee][TotalJournee]" value="<?php echo $total; ?>">
        <input type="hidden" name="data[Journee][Benefice]" value="<?php echo $totalb; ?>">
        
                     <?php if($journee['Journee']['etat']==0){?>         
        <div class="form-group">
            <div class="col-lg-9 col-lg-offset-3">
                <button type="submit" class="btn btn-primary ">Clôturer la Journée</button>
            </div>
        </div>
        <?php }?>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

