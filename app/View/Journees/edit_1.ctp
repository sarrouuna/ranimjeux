

<script language="javascript">


    function flvFPW1(){

        var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    } 
 </script>
<fieldset>

    <div class="widget first">
        <div class="head"><h5 class="iList"><?php echo __('Modification  Journée'); ?></h5></div>
    

    <?php echo $this->Form->create('Journee',array('class'=>'mainForm'));?>
     
                         
                              
                                  
			 <?php 	echo $this->Form->input('depot_id',array('value'=>$Journee['Depot']['id'],'div'=>'rowElem nobg','between'=>'<div class="formRight">','after'=>'</div><div class="fix"></div>') );
		 ?>
			&nbsp;
		
                               
                            		 
                                 
                                  
			<?php echo $this->Form->input('date_debut',array('div'=>'rowElem nobg','between'=>'<div class="formRight">','type'=>'text','value'=>$Journee['Journee']['date_debut'],'after'=>'</div><div class="fix"></div>') );  ?> <br /><?php  //echo h($Journee['Journee']['date_fin']); ?>
		<?php echo $this->Form->input('date_fin',array('div'=>'rowElem nobg','between'=>'<div class="formRight">','type'=>'text','value'=>$Journee['Journee']['date_fin'],'after'=>'</div><div class="fix"></div>') );  ?> <br /><?php  //echo h($Journee['Journee']['date_fin']); ?>
			&nbsp;
		
                                
                            
                            
                             <table style="padding-left:145px; padding:45px" cellpadding="0" cellspacing="0"  width="700"  class="tableStatic" >
    <tr align="center">
    <td>Personnel</td>
    <td>Fond</td>
    <td> Réçu le</td>
    <td>Total Caisse</td>
    <td> </td>
    
    
    </tr>
    
<?php
$k=0;
$total=0;
 foreach($personnels as $k=>$per)
{
	$total+=$ticket[$per['Personnel']['id']][0][0]['Total_TTC'];?>
 <tr>
 <td><?php  echo $this->Form->input('id',array('label'=>'','type'=>'hidden','name'=>'data[detail]['.$k.'][id]','value'=>@$Fond[$per['Personnel']['id']][0]['Fond']['id']) );
;?> <?php  echo  $per['Personnel']['Name'] ;
 echo $this->Form->input('personnel_id',array('label'=>'','type'=>'hidden','name'=>'data[detail]['.$k.'][personnel_id]','value'=>$per['Personnel']['id'] ) );
 ?>   </td>
 <td>
 
 <?php  echo $this->Form->input('fond',array('label'=>'','name'=>'data[detail]['.$k.'][fond]','value'=>@$Fond[$per['Personnel']['id']][0]['Fond']['fond']) );
;?>  <?php  //echo  @$Fond[$per['Personnel']['id']][0]['Fond']['fond'] ;;?>   </td>
<td><?php  echo $this->Form->input('date',array('value'=>@$Fond[$per['Personnel']['id']][0]['Fond']['date'],'label'=>'','name'=>'data[detail]['.$k.'][date]') );
;?>   <?php // echo  @$Fond[$per['Personnel']['id']][0]['Fond']['date'] ;;?>   </td>
  
  <td>
 
 <?php  echo $this->Form->input('etat',array('type'=>'hidden','name'=>'data[detail]['.$k.'][etat]','value'=>@$Fond[$per['Personnel']['id']][0]['Fond']['etat']) );
;?>  <?php  //echo  @$Fond[$per['Personnel']['id']][0]['Fond']['fond'] ;;?>   </td>
</tr>
 
    
    <?php }?>
 </table>
            <br />   <br />   <br />
            <div  >	
                                
                                  <div  >	
  <?php  echo $this->Form->input('id',array('type'=>'hidden','label'=>'','name'=>'data[Journee][id]','value'=>$Journee['Journee']['id'] ) );   ?>               
  <?php  echo $this->Form->input('TotalJournee',array('type'=>'hidden','label'=>'','name'=>'data[Journee][TotalJournee]','value'=>$total ) );   ?>         
							
     
  <input type="submit" value="Enregistrer" class="basicBtn submitForm mb22">
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>	   
                
  <?php echo $this->Form->end();?>
</div>

</fieldset>