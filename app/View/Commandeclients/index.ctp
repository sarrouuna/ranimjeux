<script language="JavaScript" type="text/JavaScript">

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}

</script>
<?php $add="";$edit="";$delete="";$imprimer="";$addindirect=""; 
$lien=  CakeSession::read('lien_vente');
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='commandeclients'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}
if(@$liens['lien']=='factureclients'){
		$addindirect=$liens['add'];	
	}
if(@$liens['lien']=='bonlivraisons'){
		$addbonlivraison=$liens['add'];	
	}
  
} 
if($add==1){?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Factureclients/add/Commandeclient/Lignecommandeclient/commandeclient_id"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
<!--        <a class="btn btn btn-danger" href="<?php /*echo $this->webroot;*/?>Commandeclients/add1"/> <i class="fa fa-plus-circle"></i> Ajouter Commande commercial</a>
-->    </div>
   
    
</div>

<?php } ?>
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
		echo $this->Form->input('date1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','label'=>'Date de') ); 
		echo $this->Form->input('dateliv1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','label'=>'Date Livraison de') ); 
                //echo $this->Form->input('client_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Client','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('client_id', array('type'=>'hidden','id' => 'client_id', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                echo $this->Form->input('clientname', array('label'=>'Client','yourid'=>'client_id','id' => 'clientname', 'div' => 'form-group', 'between' => '<div class="col-sm-10"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div>', 'class' => 'form-control autocomplete_name_clients'));
                echo $this->Form->input('pointdevente_id',array('label'=>'Point de Vente','id'=>'lapv','empty'=>'veuillez choisir !!','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
 
                
?>
</div>
<div class="col-md-6">
                <?php
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'a ") ); 
		echo $this->Form->input('dateliv2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'a ") ); 
                echo $this->Form->input('exercice_id',array('value'=>$exerciceid,'empty'=>'veuillez choisir','div'=>'form-group','label'=>'année','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('societe_id',array('id'=>'lasociete','empty'=>'veuillez choisir !!','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
 
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                 <a class="btn btn-primary" href="<?php echo $this->webroot;?>Commandeclients/index"/>Afficher Tout </a>
                      <a  onClick="flvFPW1(wr + 'Commandeclients/imprimerexcel?clientid=<?php echo @$clientid; ?>&date1=<?php echo @$date1; ?>&date2=<?php echo @$date2; ?>&dateliv1=<?php echo @$dateliv1; ?>&dateliv2=<?php echo @$dateliv2; ?>&exerciceid=<?php echo @$exerciceid; ?>&pointdevente_id=<?php echo @$pointdevente_id; ?>&societe_id=<?php echo @$societe_id; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer EXECEL</button> </a>
                       </div>
                </div>
            </div>
<?php echo $this->Form->end();?>
        </div>
    </div>
</div>
<br>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Commandeclients'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo ('Numero'); ?></th>

		<th><?php echo ('Client'); ?></th>
	         
		<th><?php echo ('Date'); ?></th>
                <th><?php echo ('Date Liv'); ?></th>
		<th><?php echo ('Total HT'); ?></th>

		<th><?php echo ('Total TTC'); ?></th>
	         
                 <?php  if(($addindirect==1)||($addbonlivraison==1)){?>
                     <th class="actions" align="center"></th>
                  <?php  } ?>   
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php 
        //debug($commandeclients);
        foreach ($commandeclients as $i=>$commandeclient): 
        $dateliv="";
        if(!empty($commandeclient['Commandeclient']['dateliv'])){
        $dateliv=date("d/m/Y",strtotime(str_replace('-','/',$commandeclient['Commandeclient']['dateliv'])));
        }
        //debug($dateliv);
        ?>

	<tr>
		<td ><?php echo h($commandeclient['Commandeclient']['numero']); ?></td>
                <td >
                    <input type="hidden"  value="commande" id='table'/>
                 <input type="hidden"  value="<?php echo $commandeclient['Commandeclient']['pointdevente_id']; ?>" id='Pointdevente<?php echo $i; ?>' />
                 <input type="hidden"  value="<?php echo $commandeclient['Client']['id']; ?>" id='Client<?php echo $i; ?>' />
			<?php echo $this->Html->link($commandeclient['Client']['name'], array('controller' => 'clients', 'action' => 'view', $commandeclient['Client']['id'])); ?>
		</td>
		<td ><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',$commandeclient['Commandeclient']['date'])))); ?></td>
		<td ><?php echo $dateliv ; ?></td>
		<td ><?php echo h($commandeclient['Commandeclient']['totalht']); ?></td>

		<td ><?php echo h($commandeclient['Commandeclient']['totalttc']); ?></td>

          <?php 
                $test=0;
                $testliv=0;
                 foreach ($commandeclient['Lignecommandeclient'] as $l=>$c){
                    if($c['quantite']!=$c['quantiteliv']){
                        $test=1;
                        }
                    if($c['quantiteliv'] !=0){
                        $testliv=1;
                        }    
                }

                 if($test==1){?>           
                 <td align="center" <?php if($testliv==1){ ?>style="background-color:red !important"<?php } ?>>
                   <input type="checkbox" id="check<?php echo $i; ?>" value ="<?php echo $commandeclient['Commandeclient']['id']?>" name="checkbox[]" ligne="<?php echo $i; ?>" class="blff"/>
                </td> 
          <?php  }else{ ?>  
                  <td align="center"></td>
          <?php  } ?>  
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $commandeclient['Commandeclient']['id']),array('escape' => false)); ?>
                <?php if($commandeclient['Commandeclient']['type']==0) {?>       
                        <?php if(($edit==1)&($test==1)){ echo  $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('controller' =>'Factureclients','action' => 'edit', $commandeclient['Commandeclient']['id'],'Commandeclient','Lignecommandeclient','commandeclient_id'),array('escape' => false)); } ?>
                <?php } else { ?> 
                        <?php //if(($edit==1)&($test==1)){ echo  $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit1', $commandeclient['Commandeclient']['id']),array('escape' => false)); } ?>
                <?php } ?>    
                <?php if(($delete==1)&($commandeclient['Commandeclient']['etat']==0)){ echo  $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $commandeclient['Commandeclient']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $commandeclient['Commandeclient']['id'])); } ?>
		<?php  if($imprimer==1) { ?>
<!--                <a onClick="flvFPW1(wr+'Commandeclients/imprimer/'+<?php  echo  $commandeclient['Commandeclient']['id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>-->
                <a onClick="flvFPW1(wr + 'Factureclients/imprimer/<?php echo $commandeclient['Commandeclient']['id']; ?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("Commandeclient"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("Lignecommandeclient"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("commandeclient_id"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("commandeclients"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("Commande"));?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                    <a onClick="flvFPW1(wr + 'Factureclients/imprimerhaithammatricielle/<?php echo $commandeclient['Commandeclient']['id']; ?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("Commandeclient"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("Lignecommandeclient"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("commandeclient_id"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("commandeclients"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("Commande"));?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs btn-success'><i class='fa fa-print'></i></button></a>
                    <?php  } ?>
<!--<spam title="duplication"><a class="affichediplication"  id="affichediplication" value="<?php echo $commandeclient['Commandeclient']['id'] ?>"><button class='btn btn-xs btn-success'> <i class="fa fa-files-o"></i></button>  </a></spam>-->

</td>
	</tr>
<?php  endforeach; ?>
                          </tbody>
	</table>
	<table>  
         <input type="hidden"  value="<?php echo $i ;?>" id="index"/>    
         <input type="hidden"  value="commande" id="page"/>    
               	 <tr>
	        <td align="center">
            <?php  if($addbonlivraison==1){?>
                 <div class="col-md-12  testcheckbl" style="display:none;">
                <input type="hidden" name="tes" value="0" class="tes"/>
                <input type="hidden" name="tes" value="0" class="tespv"/>
                <input type="hidden" name="nombre" value="<?php echo @$i; ?>" class="nombre"/>
                 <a class="btn btn btn-danger btnbl"  id="commandebonlivraisonadd"> <i class="fa fa-plus-circle"></i> Créer un bon de livraison </a>          
                 </div>         
            <?php  } ?>            
	    
                </td>
                <td align="center">     
            <?php  if($addindirect==1){?>
                 <div class="col-md-12  testcheckfc" style="display:none;">
                <input type="hidden" name="tes" value="0" class="tes"/>
                <input type="hidden" name="tes" value="0" class="tespv"/>
                <input type="hidden" name="nombre" value="<?php echo @$i; ?>" class="nombre"/>
                 <a class="btn btn btn-danger btnbl"  id="factureadd"> <i class="fa fa-plus-circle"></i> Créer une Facture </a>          
                 </div>         
            <?php } ?>  
               	</td>
	          </tr>
                   </table> <br><br><br>
<div class="col-md-6 selectdip" style="display:none;"> 
   <?php echo $this->Form->input('typedipliquation_id',array('label'=>'Type Duplication','id'=>'typedipliquation_id','div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control select','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez Choisir !!') );
            ?>
</div>
<div class="col-md-6 boutselect" style="display:none;">
                <div class="col-md-12  diplique" >
                <input type="hidden" name="tes" value="0" class="tes" id="testvalue"/>
                <input type="hidden" name="tes" value="Commandeclient" class="tes" id="model"/>
                <input type="hidden" name="tes" value="Lignecommandeclient" class="tes" id="ligne"/>
                <input type="hidden" name="tes" value="commandeclient_id" class="tes" id="attr"/>
                 <a class="btn btn btn-danger modeladd"  id="modeladd"> <i class="fa fa-plus-circle"></i> Créer </a>          
                 </div> 

</div> 
                                </div></div></div></div></div>	


