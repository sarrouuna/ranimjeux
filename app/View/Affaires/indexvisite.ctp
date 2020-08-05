
<br><input type="hidden" id="page" value="1"/>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Visite',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
              	<?php 
		echo $this->Form->input('date1',array('value'=>$datelyoum,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly ','type'=>'text','label'=>'Date de') ); 
		echo $this->Form->input('personnel_id',array('empty'=>'veuillez choisir','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('affaire_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Affaire','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
                </div>
                <div class="col-md-6">
                <?php
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'Ã ") ); 
                echo $this->Form->input('entreprisedefluide',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Entreprise de fluide','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('bureaudetude',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Bureau d\'etude','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  

                    </div>
                </div>
            </div>
<?php echo $this->Form->end();?>
        </div>
    </div>
</div>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Visite'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
            <th style="display: none;" ><?php echo ('Id'); ?></th>
            <th ><?php echo ('Affaire'); ?>&nbsp;&nbsp;&nbsp;</th>
            <th ><?php echo ('Personnel'); ?>&nbsp;&nbsp;&nbsp;</th>

            <th ><?php echo ('date'); ?></th>

            <th><?php echo ('lieu'); ?></th>

            <th ><?php echo ('remarque'); ?></th>

		
        </tr></thead><tbody>
	<?php 
        
        foreach ($lisvisites as $visite): 
        
        ?>
	<tr>
		<td style="display: none;"><?php echo h($visite['Visite']['id']); ?></td>
                <td ><?php echo h($visite['Affaire']['numero']." ".$visite['Affaire']['name']); ?></td>
		<td ><?php echo h($visite['Personnel']['name']); ?></td>
                <td ><?php echo h($visite['Visite']['date']); ?></td>
		<td ><?php echo h($visite['Visite']['lieu']); ?></td>
		<td ><?php echo h($visite['Visite']['note']); ?></td>
                
	</tr>
                      
<?php endforeach; ?>
        
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


