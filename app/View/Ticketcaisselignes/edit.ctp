
<?php echo $this->Form->create('Ticketcaisseligne',array('class'=>'mainForm'));?>

<!-- Input text fields -->
<fieldset>

    <div class="widget first">
        <div class="head"><h5 class="iList"><?php echo __('Modification  Ticketcaisseligne'); ?></h5></div>

        	<?php
		echo $this->Form->input('id',array('div'=>'rowElem nobg','between'=>'<div class="formRight">','after'=>'</div><div class="fix"></div>') );
		echo $this->Form->input('ticketcaisse_id',array('div'=>'rowElem nobg','between'=>'<div class="formRight">','after'=>'</div><div class="fix"></div>') );
		echo $this->Form->input('article_id',array('div'=>'rowElem nobg','between'=>'<div class="formRight">','after'=>'</div><div class="fix"></div>') );
		echo $this->Form->input('prix',array('div'=>'rowElem nobg','between'=>'<div class="formRight">','after'=>'</div><div class="fix"></div>') );
		echo $this->Form->input('qte',array('div'=>'rowElem nobg','between'=>'<div class="formRight">','after'=>'</div><div class="fix"></div>') );
		echo $this->Form->input('montant',array('div'=>'rowElem nobg','between'=>'<div class="formRight">','after'=>'</div><div class="fix"></div>') );
	?>


        

        <input type="submit" value="Enregistrer" class="basicBtn submitForm mb22">
<div class="fix"></div>
    </div>

</fieldset>
<?php echo $this->Form->end();?>


