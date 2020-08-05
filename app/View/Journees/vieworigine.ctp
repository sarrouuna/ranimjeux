

<script language="javascript">


    function flvFPW1(){

        var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    } 
 </script>
<fieldset>

    <div class="widget first">
        <div class="head"><h5 class="iList"><?php echo __('Consultation   Journée'); ?></h5></div>
    

    <?php echo $this->Form->create('Journee',array('class'=>'mainForm'));?>
     
                                  	 <div class='rowElem'>	
                                 <label><?php echo __('Dépôt'); ?></label>	
                                  <div class='formRight'>
                                  
			<?php echo 
                                   $Journee['Depot']['Nom'] ; ?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>			 <div class='rowElem'>	
                                 <label><?php echo __('Journée'); ?></label>	
                                  <div  class='formRight'>	
                                  
			<?php echo h($Journee['Journee']['date_debut']); ?> <br /><?php  //echo h($Journee['Journee']['date_fin']); ?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>	
                            
                            
                             <table style="padding-left:145px; padding:45px" cellpadding="0" cellspacing="0"  width="700"  class="tableStatic" >
    <tr align="center">
    <td>Personnel</td>
    <td>Fond</td>
    <td> Réçu le</td>
    <td>Total Caisse</td>
    <td>  </td>
    <td> </td>
    
    
    </tr>
    
<?php
$k=0;
$total=0;
 foreach($personnels as $k=>$per)
{
	$total+=$ticket[$per['Personnel']['id']][0][0]['Total_TTC'];?>
 <tr>
 <td><?php  echo  $per['Personnel']['Name'] ;
 echo $this->Form->input('personnel_id',array('label'=>'','type'=>'hidden','name'=>'data[detail]['.$k.'][personnel_id]','value'=>$per['Personnel']['id'] ) );
 ?>   </td>
 <td><?php  echo  @$Fond[$per['Personnel']['id']][0]['Fond']['fond'] ;
;?>   </td>
<td><?php  echo  @$Fond[$per['Personnel']['id']][0]['Fond']['date'] ;
;?>   </td>
 <td><?php  echo $ticket[$per['Personnel']['id']][0][0]['Total_TTC']  ;  ?>   </td>
 <td> <?php if($Fond[$per['Personnel']['id']][0]['Fond']['etat']==0){?><a href="<?php echo $this->webroot;?>fonds/cloture/<?php echo $Journee['Journee']['id'] ;?>/<?php echo  @$Fond[$per['Personnel']['id']][0]['Fond']['id'] ;?>/<?php  echo $ticket[$per['Personnel']['id']][0][0]['Total_TTC']  ;  ?> ">Clôturer Caisse   </a><?php }?></td>
 <td><!-- <a    onClick="flvFPW1('<?php echo $this->webroot;?>journees/imprimer/<?php echo $Journee['Journee']['id']; ?>/<?php echo  $per['Personnel']['id']?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);   return document.MM_returnValue" href="javascript:;" > Imprimer</a>
  --> </td>
 
</tr>
 
    
    <?php }?>
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
   foreach($ligne[$per['Famillearticle']['id']] as $tt)
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
    <tr><td colspan="3" align="right"> Total Journée :</td><td colspan="2"> <?php echo $total;?></td></tr> 
   <?php if(CakeSession::read('users')==16){?> <tr><td colspan="3" align="right"> Total Bénéfice :</td><td colspan="2"> <?php echo sprintf('%.3f',$totalb); ?></td></tr><?php }?></table>
            <br />   <br />   <br />
            <div  >	
            
    

                                 
                                  <div  >	
  <?php  echo $this->Form->input('id',array('type'=>'hidden','label'=>'','name'=>'data[Journee][id]','value'=>$Journee['Journee']['id'] ) );   ?>               
  <?php  echo $this->Form->input('TotalJournee',array('type'=>'hidden','label'=>'','name'=>'data[Journee][TotalJournee]','value'=>$total ) );   ?>          	 
  <?php  echo $this->Form->input('Benefice',array('type'=>'hidden','label'=>'','name'=>'data[Journee][Benefice]','value'=>$totalb ) );   ?>          	 
        <!-- <input type="button"   value="Imprimer la Journée" class="basicBtn submitForm mb22" onClick="flvFPW1('<?php echo $this->webroot;?>journees/imprimer/<?php echo $Journee['Journee']['id']; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);   return document.MM_returnValue" href="javascript:;" > 
 -->
							
     
	<?php if($Journee['Journee']['etat']==0){?><input type="submit" value="Clôturer la Journée" class="basicBtn submitForm mb22"><?php }?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>	   
                
  <?php echo $this->Form->end();?>
</div>

</fieldset>