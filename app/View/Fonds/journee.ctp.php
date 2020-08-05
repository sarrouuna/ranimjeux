
<?php echo $this->Form->create('Fond',array('class'=>'mainForm'));?>

<!-- Input text fields -->
<fieldset>

    <div class="widget first">
        <div class="head"><h5 class="iList"><?php echo __('Ajout  Journée'); ?></h5></div>

        	<?php
		echo $this->Form->input('utilisateur_id',array('div'=>'rowElem nobg','between'=>'<div class="formRight">','after'=>'</div><div class="fix"></div>') );
		echo $this->Form->input('fond',array('type'=>'text','div'=>'rowElem nobg','between'=>'<div class="formRight">','after'=>'</div><div class="fix"></div>') );
		           echo $this->Form->input('date_debut',array('div'=>'rowElem nobg','between'=>'<div class="formRight">','type'=>'text','value'=>date('d/m/Y H:i:s'),'after'=>'</div><div class="fix"></div>') );
				   
				    echo $this->Form->input('date_fin',array('div'=>'rowElem nobg','between'=>'<div class="formRight">','type'=>'text','value'=>date('d/m/Y H:i:s'),'after'=>'</div><div class="fix"></div>') );
	?>

  <input type="submit" value="Enregistrer" class="basicBtn submitForm mb22">
<div class="fix"></div>
    </div>

</fieldset>
<?php echo $this->Form->end();?>


