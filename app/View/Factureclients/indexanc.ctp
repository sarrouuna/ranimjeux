<script language="JavaScript" type="text/JavaScript">

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}

</script>
 <?php $add="";$edit="";$delete="";$imprimer=""; 
$lien=  CakeSession::read('lien_vente');
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='factureclients'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}
} 
if($add==1){?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Factureclients/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<?php }?>
<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Recherche',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
              	<?php 
		echo $this->Form->input('date1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly ','type'=>'text','label'=>'Date de') ); 
		echo $this->Form->input('client_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Client','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                 echo $this->Form->input('societe_id',array('id'=>'lasociete','empty'=>'veuillez choisir !!','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('pointdevente_id',array('id'=>'lapv','empty'=>'veuillez choisir !!','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));

?>
</div>
<div class="col-md-6">
                <?php
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'Ã ") ); 
                echo $this->Form->input('exercice_id',array('value'=>$exerciceid,'empty'=>'veuillez choisir','div'=>'form-group','label'=>'année','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
?>
 
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                 <a class="btn btn-primary" href="<?php echo $this->webroot;?>Factureclients/index"/>Afficher Tout </a>
                    <?php if($imprimer==1){ ?>
      <a  onClick="flvFPW1(wr+'Factureclients/imprimerrecherche?clientid=<?php echo @$clientid;?>&date1=<?php echo @$date1;?>&date2=<?php echo @$date2;?>&exerciceid=<?php echo @$exerciceid;?>&societe_id=<?php echo @$societe_id;?>&pointdevente_id=<?php echo @$pointdevente_id;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                    <?php }?>
                   

                    </div>
                </div>
            </div>
<?php echo $this->Form->end();?>
        </div>
    </div>
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Factureclients'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th style="display:none"><?php echo ('Id'); ?></th>
                         
		<th><?php echo ('Numero'); ?></th>
	         
		<th><?php echo ('Client_id'); ?></th>
	         	         
		<th><?php echo ('Date'); ?></th>
	         
		<th><?php echo ('Totalht'); ?></th>
	         
		<th><?php echo ('Totalttc'); ?></th>
	
	         
		<th><?php echo ('Facture Avoir'); ?></th>
               
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($factureclients as $factureclient): ?>

	<tr>
		<td style="display:none"><?php echo h($factureclient['Factureclient']['id']); ?></td>
                <td ><?php echo h($factureclient['Factureclient']['numero']); ?></td>
		<td >
                        <?php echo $this->Html->link($factureclient['Factureclient']['name'], array('controller' => 'clients', 'action' => 'view', $factureclient['Client']['id'])); ?>
                </td>
		
		<td ><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',$factureclient['Factureclient']['date'])))); ?></td>
		<td ><?php echo h($factureclient['Factureclient']['totalht']); ?></td>
		<td ><?php echo h($factureclient['Factureclient']['totalttc']); ?></td>
		
                <td align="center">
                <?php  if (($factureclient['Factureclient']['factureavoir_id']==0)&(($factureclient['Factureclient']['etat']==0))){ ?> 
                <?php echo $this->Html->link("<button class='btn btn-xs btn-danger'><i class='fa fa-plus-circle'></i></button> ", array('action' => 'addfactureavoir', $factureclient['Factureclient']['id']),array('escape' => false)); ?>
                <?php } ?>
                </td> 
               

        
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $factureclient['Factureclient']['id']),array('escape' => false)); ?>
                        <?php if($factureclient['Factureclient']['transfert']==0){ if(($edit==1)&($factureclient['Factureclient']['etat']==0)){ echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $factureclient['Factureclient']['id']),array('escape' => false)); } } ?>
                        <?php if($factureclient['Factureclient']['transfert']==0){ if(($delete==1)&($factureclient['Factureclient']['etat']==0)){ echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $factureclient['Factureclient']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $factureclient['Factureclient']['id'])); } } ?>
		<?php  if($imprimer==1) { ?>
                <a onClick="flvFPW1(wr+'Factureclients/imprimer/'+<?php  echo $factureclient['Factureclient']['id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
              <?php  } ?>
<spam title="duplication"><a class="affichediplication"  id="affichediplication" value="<?php echo $factureclient['Factureclient']['id']?>"> <button class='btn btn-xs btn-success'> <i class="fa fa-files-o"></i></button>  </a></spam>
                </td>
	</tr>
<?php  endforeach; ?>
                          </tbody>
	</table><br><br><br>
<div class="col-md-6 selectdip" style="display:none;"> 
   <?php echo $this->Form->input('typedipliquation_id',array('label'=>'Type Duplication','id'=>'typedipliquation_id','div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control select','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
            ?>
</div>
<div class="col-md-6 boutselect" style="display:none;">
                <div class="col-md-12  diplique" >
                <input type="hidden" name="tes" value="0" class="tes" id="testvalue"/>
                <input type="hidden" name="tes" value="Factureclient" class="tes" id="model"/>
                <input type="hidden" name="tes" value="Lignefactureclient" class="tes" id="ligne"/>
                <input type="hidden" name="tes" value="factureclient_id" class="tes" id="attr"/>
                 <a class="btn btn btn-danger modeladd"  id="modeladd"> <i class="fa fa-plus-circle"></i> Créer </a>          
                 </div> 

</div>
	
                                </div></div></div></div></div>	


