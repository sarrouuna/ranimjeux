<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Productions/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout Production'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Production',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('nvarticle',array('value'=>@$article_id,'id'=>'nvarticle','label'=>'Article Crée','empty'=>'choix','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select afficheblockproduction') );
		if(!empty($article_id)){
                echo $this->Form->input('depotarrive',array('id'=>'depotarrive','label'=>'Depot Arrive','empty'=>'choix','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select') );
		echo $this->Form->input('qte',array('id'=>'qtefabriquer','type'=>'text','value'=>1,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculeqteutiliserparod') );
	?></div><div class="col-md-6"><?php
	        echo $this->Form->input('numero',array('type'=>'text','value'=>@$mm,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
	        echo $this->Form->input('date',array('div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
                ?>
  </div>  
                                     <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne Production'); ?></h3>
                                    
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td style="width:39%" align="center" nowrap="nowrap">Depot sortie</td>
                                    <td style="width:10%" align="center" nowrap="nowrap">Qte en stock</td>
                                    <td style="width:40%" align="center" nowrap="nowrap">Article Utilisée</td>
                                    <td style="width:10%" align="center" nowrap="nowrap">Qte</td>
                                </tr>
                                </thead>
                                <tbody>
                                
                                <?php foreach ($lignefiches as $i=>$l) { ?>
                                <tr class="cc" >
                                    <td>
                                        <?php    echo $this->Form->input('depot_id',array('name'=>'data[Ligneworkflow]['.$i.'][depot_id]','index'=>$i,'id'=>'depot_id'.$i,'label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select depot_qte_s','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->input('qte',array('readonly'=>'readonly','type'=>'text','name'=>'data[Ligneworkflow]['.$i.'][quantitestock]','div'=>'form-group','label'=>'','table'=>'Ligneworkflow','index'=>$i,'id'=>'quantitestock'.$i,'champ'=>'quantitestock','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td>
                                        <?php    echo $this->Form->input('article_id',array('value'=>$l['Lignefichetechnique']['article_id'],'name'=>'data[Ligneworkflow]['.$i.'][article_id]','id'=>'article'.$i,'champ'=>'article','table'=>'Ligneworkflow','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php    echo $this->Form->input('sup',array('name'=>'data[Ligneworkflow]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Ligneworkflow','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php    echo $this->Form->input('article',array('disabled'=>'disabled','value'=>$l['Lignefichetechnique']['article_id'],'name'=>'data[Ligneworkflow]['.$i.'][article]','index'=>$i,'id'=>'article_id'.$i,'label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select ','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->input('qtehid',array('readonly'=>'readonly','value'=>$l['Lignefichetechnique']['qte'],'type'=>'hidden','name'=>'data[Ligneworkflow]['.$i.'][qtehid]','div'=>'form-group','label'=>'','table'=>'Ligneworkflow','index'=>$i,'id'=>'qtehid'.$i,'champ'=>'qtehid','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                        <?php echo $this->Form->input('qte',array('readonly'=>'readonly','value'=>$l['Lignefichetechnique']['qte'],'type'=>'text','name'=>'data[Ligneworkflow]['.$i.'][qte]','div'=>'form-group','label'=>'','table'=>'Ligneworkflow','index'=>$i,'id'=>'qte'.$i,'champ'=>'qte','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    
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
                                                <button type="submit" class="btn btn-primary testchampsproduction">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>
<?php } ?>
