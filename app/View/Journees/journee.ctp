
<?php echo $this->Form->create('Fond',array('class'=>'mainForm'));?>

<!-- Input text fields -->
<fieldset>

    <div class="widget first">
        <div class="head"><h5 class="iList"><?php echo __('Ajout  Journée'); ?></h5></div>

        	<?php
		echo $this->Form->input('depot_id',array('div'=>'rowElem nobg','between'=>'<div class="formRight">','after'=>'</div><div class="fix"></div>') );
		 
		  echo $this->Form->input('date_debut',array('div'=>'rowElem nobg','between'=>'<div class="formRight">','type'=>'text','value'=>date('d/m/Y H:i:s'),'after'=>'</div><div class="fix"></div>') );
				   
	///  echo $this->Form->input('date_fin',array('div'=>'rowElem nobg','between'=>'<div class="formRight">','type'=>'text','after'=>'</div><div class="fix"></div>') );
	?>
    <table style="padding-left:145px; padding:45px" cellpadding="0" cellspacing="0"   class="tableStatic" >
    <tr align="center">
    <td>Personnel</td>
    <td>Fond</td>
    <td> Réçu le</td>
    
    
    </tr>
    
<?php
$k=0;
 foreach($personnels as $k=>$per)
{
	?>
 <tr>
 <td><?php  echo $this->Form->input('name',array('label'=>'','name'=>'data[detail]['.$k.'][name]','value'=>$per['Personnel']['Name'] ) );
 echo $this->Form->input('personnel_id',array('label'=>'','type'=>'hidden','name'=>'data[detail]['.$k.'][personnel_id]','value'=>$per['Personnel']['id'] ) );
 ?>   </td>
 <td><?php  echo $this->Form->input('fond',array('label'=>'','name'=>'data[detail]['.$k.'][fond]','type'=>'text') );
;?>   </td>
<td><?php  echo $this->Form->input('date',array('label'=>'','name'=>'data[detail]['.$k.'][date]','type'=>'text') );
;?>   </td>

</tr>
    
    <?php }?></table>
  <input type="submit" value="Enregistrer" class="basicBtn submitForm mb22">
<div class="fix"></div>
    </div>

</fieldset>
<?php echo $this->Form->end();?>


