<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Suivicommercials/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('View Suivi Commercial'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Suivicommercial',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
                 //debug($this->request->data);die; 
                if(empty($this->request->data['Suivicommercial']['date'])){
                 $date="";  
                 }else{
                 $date=date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Suivicommercial']['date'])));    
                 }
                 if(empty($this->request->data['Suivicommercial']['daterecu'])){
                 $daterecu="";  
                 }else{
                 $daterecu=date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Suivicommercial']['daterecu'])));    
                 }
                 if(empty($this->request->data['Suivicommercial']['dateinstallation'])){
                 $dateinstallation="";  
                 }else{
                 $dateinstallation=date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Suivicommercial']['dateinstallation'])));    
                 }
		echo $this->Form->input('id',array('type'=>'hidden','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('numero',array('readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('description',array('readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('client',array('readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('1emecontact',array('readonly'=>'readonly','label'=>'1eme contact','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('preparerpar',array('readonly'=>'readonly','label'=>'Preparer par','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('num',array('readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('date',array('readonly'=>'readonly','value'=>$date,'type'=>'text','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ') );
		echo $this->Form->input('totalHT',array('readonly'=>'readonly','type'=>'text','label'=>'Total HT','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('totalTTC',array('readonly'=>'readonly','type'=>'text','label'=>'Total TTC','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('statusuivi_id',array('disabled'=>'disabled','empty'=>'Veuillez Choisir !!','label'=>'Statu Suivi','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('raisondeperde',array('readonly'=>'readonly','label'=>'Raison de perde','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
	?></div><div class="col-md-6"><?php
		echo $this->Form->input('recupar',array('readonly'=>'readonly','label'=>'Recu par','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('numderecu',array('readonly'=>'readonly','label'=>'Num de recu','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('daterecu',array('readonly'=>'readonly','value'=>$daterecu,'type'=>'text','label'=>'Date recu','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ') );
		echo $this->Form->input('inclusuivi_id',array('disabled'=>'disabled','empty'=>'Veuillez Choisir !!','label'=>'Installation inclu','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('dateinstallation',array('readonly'=>'readonly','value'=>$dateinstallation,'type'=>'text', 'label'=>'Date installation','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ') );
		echo $this->Form->input('affaire',array('readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('bureaudetude',array('readonly'=>'readonly','label'=>'Bureau d\'etude','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('entreprise',array('readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('reglement',array('readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		//echo $this->Form->input('devi_id',array('label'=>'Type Suivi','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
	?>
  </div>               

<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

