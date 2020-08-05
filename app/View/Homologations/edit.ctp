<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Homologations/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification AMC'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Homologation',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh','enctype' => 'multipart/form-data')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('numerolot',array('div'=>'form-group','between'=>'<div class="col-sm-10">','readonly'=>'readonly','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	    ?></div><div class="col-md-6">
                
                
           <!--  <div class="form-group">
                <label class="col-md-2" control-label>Articles</label>
                <div class="col-sm-10">
            <select  type="text" id="input-sortable"  class="input-sortable demo-default form-control" multiple="multiple" name="data[Article][article_id][]" >
                <?php// foreach ($articles as $a=>$art){ ?>
                <option value="<?php // echo $a; ?>" <?php // foreach ($articlehomologations as $art_homo){ if($art_homo['Articlehomologation']['article_id']==$a){ ?> selected="selected" <?php // }  }?>    ><?php // echo $art ?></option>
                <?php // } ?>
            </select>
                </div>
                
            </div> -->
       
            <?php
		echo $this->Form->input('fichier',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'file','multiple'=>"true",'id'=>"file-3") );
	    ?>
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

