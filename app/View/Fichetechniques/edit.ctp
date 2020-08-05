<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Fichetechniques/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification Fichetechnique'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Fichetechnique',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('numero',array('div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('nvarticle',array('label'=>'Article Crée','empty'=>'choix','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select') );
	        ?></div><div class="col-md-6"><?php
	        echo $this->Form->input('date',array('value'=>date("d/m/Y",strtotime(str_replace('/','-',$this->request->data['Fichetechnique']['date']))),'div'=>'form-group','type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
	?>
  </div>
                                    
        <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne fiche technique'); ?></h3>
                                    <a class="btn btn-danger ajouter_lignetransfert" table='addtable' index='index'  tr="tr" style="
                                    float: right; 
                                    position: relative;
                                    top: -25px;
                                "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Article Utilisée</td>
                                    <td align="center" nowrap="nowrap">Qte</td>
                                    <td align="center"></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;" >
                                    <td style="width:49%">
                                        <?php    echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Ligneworkflow','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php    echo $this->Form->input('article_id',array('table'=>'Ligneworkflow','label'=>'','champ'=>'article_id','id'=>'','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:49%">
                                        <?php echo $this->Form->input('qte',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Ligneworkflow','index'=>'','id'=>'','champ'=>'qte','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    
                                    <td align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                <?php foreach ($lignefiches as $i=>$l) { ?>
                                <tr class="cc" >
                                    <td style="width:49%">
                                        <?php    echo $this->Form->input('sup',array('name'=>'data[Ligneworkflow]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Ligneworkflow','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php    echo $this->Form->input('article_id',array('value'=>$l['Lignefichetechnique']['article_id'],'name'=>'data[Ligneworkflow]['.$i.'][article_id]','index'=>$i,'id'=>'article_id'.$i,'label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select ','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:49%" >
                                        <?php echo $this->Form->input('qte',array('value'=>$l['Lignefichetechnique']['qte'],'name'=>'data[Ligneworkflow]['.$i.'][qte]','div'=>'form-group','label'=>'','table'=>'Ligneworkflow','index'=>$i,'id'=>'qte'.$i,'champ'=>'qte','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    
                                    <td align="center"><i index="<?php echo @$i ?>"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo @$i ?>" id="index" />
</div>
                            </div>
                        </div>                
</div>                                 
                                    
                                    
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

