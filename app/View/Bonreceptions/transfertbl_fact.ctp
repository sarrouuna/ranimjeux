<script language="JavaScript" type="text/JavaScript">

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}



function  EW_checkMyForm(type) {
    //event.preventDefault();
    //alert(type);

    if(type=="recherche"){
        var client=$('#FournisseurId').val();
        if(client==''){
            bootbox.alert('If faut choisir un fournisseur');
            return false;
        }else{
            //alert('helmi');
            //$('#defaultForm').submit();
        }
    }



}

</script>
 <?php $add="";$edit="";$delete="";$imprimer=""; 
$lien=  CakeSession::read('lien_achat');
//debug($lien_achat);die;
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='bonreceptions'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}
        if(@$liens['lien']=='factures'){
		$addindirect=$liens['add'];
		
	}

} 
?>
<br>
<?php echo $this->Form->create('Bonreception',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">

                <div class="col-md-6">
              	<?php
		echo $this->Form->input('date1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>'Date de') );
		echo $this->Form->input('fournisseur_id',array('empty'=>'veuillez choisir','id'=>'FournisseurId','div'=>'form-group','label'=>'Fournisseur','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
               ?>
 </div>
               <div class="col-md-6">
                            <?php
                           echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'Ã ") );
                          // echo $this->Form->input('utilisateur_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Utilisateur','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                           //echo $this->Form->input('be_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Bon d\'entré','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
		//echo $this->Form->input('transf_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Transformation','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                           echo $this->Form->input('exercice_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'année','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                           echo $this->Form->input('avoirazs_id',array('div'=>'form-group','label'=>'BL Avoir','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));

?>
                </div>

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button onmousemove="EW_checkMyForm('recherche')"  type="submit" class="btn btn-primary" name="data[Bonreception][facture]" value="recherche" id="aff">Chercher</button>



                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<br><input type="hidden" id="page" value="fac_des_bl"/>



<br>
<?php
if(!empty($bonreceptions))
{ ?>
    <div class="row" >
        <div class="col-md-12" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo __('Facture'); ?></h3>
                </div>
                <div class="panel-body">

                    <div class="col-md-6">
                        <?php

                        echo $this->Form->input('date',array('id'=>'datefac','div'=>'form-group','value'=>date("d/m/Y"),'data[Facture][date]','type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );
                        echo $this->Form->input('datedeclaration',array('label'=>'Date Déclaration','div'=>'form-group','value'=>date("d/m/Y"),'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire') );
                        echo $this->Form->input('model',array('id'=>'model','type'=>'hidden','value'=>'Facture','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                        echo $this->Form->input('source',array('id'=>'source','type'=>'hidden','value'=>'bl','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                        echo $this->Form->input('ttc',array('label'=>'Total TTC','value'=>@$timbres['Timbre']['timbre'],'id'=>'totalettc','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );

                        //echo $this->Form->input('pv',array('id'=>'pvv','type'=>'hidden','value'=>$pvv,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                        ?>
                        <input type="hidden" id="timbre" value="<?php echo @$timbres['Timbre']['timbre']; ?>" />
                    </div>
                    <div class="col-md-6">
                        <?php
                        echo $this->Form->input('pointdevente_id', array('id' => 'pointdevente_id','empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select inputspcial numspecial'));
                        echo $this->Form->input('model', array('id' => 'model', 'type' => 'hidden', 'value' =>'Facture', 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                        echo $this->Form->input('nature', array('id' => 'nature', 'type' => 'hidden', 'value' =>'achat', 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                        echo $this->Form->input('numero',array('id'=>'numero','div'=>'form-group','data[Facture][numero]','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                        echo $this->Form->input('numeroconca',array('type' => 'hidden','id'=>'numeroconca','value'=>$mm,'data[Facture][numeroconca]','readonly'=>'readonly','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                        echo $this->Form->input('numerofrs', array('data[Facture][numerofrs]','label' => 'Numéro frs', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>',  'class' => 'form-control inputspcial', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                        ?>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button onmousemove="EW_checkMyForm('facture')" type="submit" class="btn btn btn-danger btnbl testnumerofc" name="data[Bonreception][facture]" value="facture" id="aff">Créer une Facture</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php } ?>

<br>

<?php $i="vide"; ?>


<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Bon livraisons'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="">
                      <thead>
	<tr>
	         
		<th style="display:none;" ><?php echo ('Id'); ?></th>
	         
		<th><?php echo ('Numero'); ?></th>
	         
		<th><?php echo ('Fournisseur'); ?></th>
	        <th><?php echo ('Importation'); ?></th>  	         
		<th><?php echo ('Date'); ?></th>
                <th><?php echo ('TTC'); ?></th>
               
		
        <?php if($addindirect==1){?>
               <th><?php echo (''); ?></th>
                  <?php } ?>  
                        <th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php  if(!empty($bonreceptions)){ foreach ($bonreceptions as $i=>$bonreception): ?>
	<tr>
		<td style="display:none"><?php echo h($bonreception['Bonreception']['id']); ?></td>
<td ><?php echo h($bonreception['Bonreception']['numero']); ?></td>
		<td >
                        <input type="hidden"  value="bonreception" id='table'/>
                        <input type="hidden"  value="<?php echo $bonreception['Fournisseur']['id']; ?>" id='Fournisseur<?php echo $i; ?>' />
                        <input type="hidden"  value="<?php echo $bonreception['Importation']['id']; ?>" id='Importation<?php echo $i; ?>' />
                        <?php echo $this->Html->link($bonreception['Fournisseur']['name'], array('controller' => 'fournisseurs', 'action' => 'view', $bonreception['Fournisseur']['id'])); ?>
		</td>
		<td >
                    <?php echo $this->Html->link($bonreception['Importation']['name'], array('controller' => 'importations', 'action' => 'view', $bonreception['Importation']['id'])); ?>
		</td>
		<td ><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',$bonreception['Bonreception']['date'])))); ?></td>
                <td ><?php echo h($bonreception['Bonreception']['totalttc']); ?></td>
               


     <?php if($addindirect==1){
           if (( $bonreception['Bonreception']['facture_id']==0)){ ?>           
                <td align="center">
                    <input type="checkbox"  id="checkbl<?php echo $i; ?>" value ="<?php echo $bonreception['Bonreception']['id'] ?>" name="facture[]" ligne="<?php echo $i; ?>" class="calculetransformationbl" />
                    <input type="hidden" id="ttcfac<?php echo $i; ?>" value="<?php echo $bonreception['Bonreception']['totalttc']; ?>" />
                </td> 
     <?php }else{?>
          <td align="center"> </td> 
     <?php } } ?>       
		<td align="center">
		<!--	<?php /*echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $bonreception['Bonreception']['id']),array('escape' => false)); */?>
                        <?php /*if(($edit==1)&&( $bonreception['Bonreception']['etat']==0)&&( empty($bonreception['Bonreception']['modif']))) {  echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $bonreception['Bonreception']['id']),array('escape' => false)); } */?>
                        <?php /*if(($delete==1)&&( $bonreception['Bonreception']['etat']==0)&&( empty($bonreception['Bonreception']['modif']))) { echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $bonreception['Bonreception']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $bonreception['Bonreception']['id'])); }*/?>
		-->
            <?php if($imprimer==1) { ?>
            <?php if($bonreception['Bonreception']['type']=='service') { ?>
                <a onClick="flvFPW1(wr+'Bonreceptions/imprimerblservice/'+<?php  echo $bonreception['Bonreception']['id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
            <?php } else { ?>


                <a onClick="flvFPW1(wr+'Bonreceptions/imprimer/'+<?php  echo $bonreception['Bonreception']['id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                <a onClick="flvFPW1(wr+'Bonreceptions/imprimerpourdepot/'+<?php  echo $bonreception['Bonreception']['id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs btn-success'><i class='fa fa-print'></i></button></a>
              <?php } } ?>
                </td>
                
	</tr>
<?php  endforeach; ?>
        <?php } ?>
                          </tbody>
	</table>
<input type="hidden" id="indexfac" value="<?php echo @$i; ?>" />	 
  


                                    </div></div>
                            </div>
                        
                        </div></div>


<!-- BL Avoir -->


<?php $ii="vide"; ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Bon livraisons Avoir'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="ls-editable-table table-responsive ls-table">
                    <table class="table table-bordered table-striped table-bottomless" id="">
                        <thead>
                        <tr>

                            <th style="display:none;" ><?php echo ('Id'); ?></th>

                            <th><?php echo ('Fournisseur'); ?></th>

                            <th><?php echo ('Date'); ?></th>

                            <th><?php echo ('Point de vente'); ?></th>


                            <th><?php echo ('Totalttc'); ?></th>

                            <th><?php echo ('Numero'); ?></th>

                            <?php if($addindirect==1){?>
                                <th><?php echo (''); ?></th>
                            <?php } ?>
                            <th class="actions" align="center"></th>
                        </tr></thead><tbody>
                        <?php  if(!empty($avoirs)){  foreach ($avoirs as $ii=>$factureavoir): ?>
                            <tr>
                                <td style="display:none"><?php echo h($factureavoir['Factureavoirfr']['id']); ?></td>
                                <td >
                                    <?php echo $this->Html->link($factureavoir['Fournisseur']['name'], array('controller' => 'fournisseurs', 'action' => 'view', $factureavoir['Fournisseur']['id'])); ?>
                                </td>
                                <td ><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',$factureavoir['Factureavoirfr']['date'])))); ?></td>
                                <td ><?php echo h($factureavoir['Pointdevente']['name']); ?></td>
                                <td ><?php echo h($factureavoir['Factureavoirfr']['totalttc']); ?></td>
                                <td ><?php echo h($factureavoir['Factureavoirfr']['numero']); ?></td>

                                <?php if($addindirect==1){
                                    if (( $factureavoir['Factureavoirfr']['facture_id']==0)){ ?>
                                        <td align="center">
                                            <input type="checkbox"  id="checkavr<?php echo $ii; ?>" value ="<?php echo $factureavoir['Factureavoirfr']['id'] ?>" name="avoir[]" ligne="<?php echo $ii; ?>" class="calculetransformationbl" />
                                            <input type="hidden" id="ttcavr<?php echo $ii; ?>" value="<?php echo $factureavoir['Factureavoirfr']['totalttc']; ?>" />
                                        </td>
                                    <?php }else{?>
                                        <td align="center"> </td>
                                    <?php } } ?>
                                <td align="center">
                                    <?php if($imprimer==1) {
                                        if($factureavoir['Typefacture']['id']==1){
                                            ?>
                                            <a onClick="flvFPW1(wr+'Factureavoirfrs/imprimerfavr/'+<?php  echo $factureavoir['Factureavoirfr']['id'];?>+'/bl','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                                        <?php  } else {?>
                                            <a onClick="flvFPW1(wr+'Factureavoirfrs/imprimerfavf/'+<?php  echo $factureavoir['Factureavoirfr']['id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                                        <?php }} ?>
                                </td>

                            </tr>
                        <?php  endforeach; ?>
                            <?php } ?>
                        </tbody>
                    </table>
<input type="hidden" id="indexavr" value="<?php echo @$ii; ?>" />




                    <?php echo $this->Form->end();?>
                </div></div>
        </div>

    </div></div>
