<script language="JavaScript">

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}

</script>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Affaires/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification Affaire'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Affaire',array('enctype' => 'multipart/form-data','autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('numero',array('readonly'=>'readonly','label'=>'Num&eacute;ro','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('name',array('readonly'=>'readonly','label'=>'D&eacute;signation','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('date',array('readonly'=>'readonly','div'=>'form-group','value'=>$date,'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );
                echo $this->Form->input('adresse',array('readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('promoteur',array('readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('region_id',array('disabled'=>'disabled','empty'=>'veuillez choisir','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('revendeur',array('readonly'=>'readonly','label'=>'Revendeur','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                ?></div><div class="col-md-6"><?php
		echo $this->Form->input('bureaudetude',array('readonly'=>'readonly','label'=>'bureau d\'&eacute;tude','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('architecte',array('readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('entreprisedebatiment',array('readonly'=>'readonly','label'=>'entreprise de batiment','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('entreprisedefluide',array('readonly'=>'readonly','label'=>'entreprise de fluide','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('contact',array('readonly'=>'readonly','label'=>'premi&eacute;re contact entreprise','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('telcontact',array('readonly'=>'readonly','label'=>'Tel contact ','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('emailcontact',array('readonly'=>'readonly','label'=>'Email contact ','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                ?>
  </div>  
                                    
                                     <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('ajout Pieces Jointes'); ?></h3>
                                    
                                </div>
                                <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:90%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap" width="49%">Désignation</td>
                                    <td align="center" nowrap="nowrap" width="50%">Piece</td>
                                </tr>
                                </thead>
								
								
								
				<tr class="tr" style="display:none;">
                                <td> 
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Piecejointeaffaire','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('namepiecejointe',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Piecejointeaffaire','index'=>'','id'=>'','champ'=>'namepiecejointe','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                        <?php echo $this->Form->input('id',array('empty'=>'choix','div'=>'form-group','label'=>'', 'name' => '','table'=>'Piecejointeaffaire','index'=>'','id'=>'','champ'=>'id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'','type'=>'hidden') );?>
                                </td>
                                <td>
                                        <?php echo $this->Form->input('piece',array('name' => '','table'=>'Piecejointeaffaire','index'=>'','id'=>'','champ'=>'piece','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'file','multiple'=>"true") ); ?>       
                                    
									
				</td>
                                   
                                    <td align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>

                                     <?php foreach ($piecejointes as $i=>$piecejointe) {  ?>

                                <tr>
                                <td>
                                        <?php echo $this->Form->input('sup',array('name'=>'data[Piecejointeaffaire]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Piecejointeaffaire','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('id',array('value'=>$piecejointe['Piecejointeaffaire']['id'],'div'=>'form-group','label'=>'', 'name' => 'data[Piecejointeaffaire]['.$i.'][id]','table'=>'Piecejointeaffaire','index'=>$i,'id'=>'id','champ'=>'id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','type'=>'hidden') );?> 
			                <?php echo $this->Form->input('namepiecejointe',array('readonly'=>'readonly','value'=>$piecejointe['Piecejointeaffaire']['namepiecejointe'],'div'=>'form-group','label'=>'', 'name' => 'data[Piecejointeaffaire]['.$i.'][namepiecejointe]','table'=>'Piecejointeaffaire','index'=>'0','id'=>'name','champ'=>'name','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                </td>
                                <td>
                                        <?php echo $this->Form->input('piece',array('type'=>'hidden','value'=>$piecejointe['Piecejointeaffaire']['piece'],'name' => 'data[Piecejointeaffaire]['.$i.'][piece]','table'=>'Piecejointeaffaire','index'=>'0','champ'=>'piece','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') ); ?>       
                                <center>
                                    <a  onClick="flvFPW1(wr+'files/upload/<?php echo $piecejointe['Piecejointeaffaire']['piece'];?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>                   
				</center>	  
                                </td>
</tr>
                                     <?php } ?>
</tbody>
                                </table>
              	<input type="hidden" value="<?php echo @$i ; ?>" id="index" />
</div>
                            </div>
                        </div>                
</div>   
                                    

<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

