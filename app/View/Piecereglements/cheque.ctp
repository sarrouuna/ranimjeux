<script language="JavaScript" type="text/JavaScript">
function flvFPW1(){
var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;
}
</script>
 <?php $add="";$edit="";$delete="";$imprimer=""; 
$lien=  CakeSession::read('lien_achat');
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='piecereglements'){
		//$add=$liens['add'];
		$edit=$liens['edit'];
		//$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}

  
}
//if($add==1){
//    
//}
?>
<br><input type="hidden" id="page" value="1"/>
<div class="row">    
     <div class="col-md-12" >
                            <div class="panel panel-default"> 
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
                                    <ul class="panel-control" style="top: 83px">
                    <li><a class="minus" href="javascript:void(0)"><i class="fa fa-square-o"></i></a></li>
<!--                    <li><a class="refresh" href="javascript:void(0)"><i class="fa fa-refresh"></i></a></li>
                    <li><a class="close-panel" href="javascript:void(0)"><i class="fa fa-times"></i></a></li>-->
                </ul>
                                </div>
                                <div class="panel-body" style="display: none">
        <?php echo $this->Form->create('Piecereglement',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

           <div class="col-md-6">                  
              	<?php 
		
		echo $this->Form->input('Date_debut',array('label'=>'Encaissement du','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text') );
                echo $this->Form->input('Date_deb',array('label'=>'Echéance du','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text') );
		echo $this->Form->input('fournisseur_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Fournisseur','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
	
             
                ?>
                            <div class="form-group">
                            <label>Situation</label>
                               <div class="col-sm-10">
                                <select class="form-control select selectized" placeholder="Veuillez choisir" name="data[Piecereglement][situation]" id="stut" >
                                    <option value="">Veuillez choisir</option>
                                    <option value="En attente">En attente</option>
                                    <option value="Versé"      >Versé</option>
                                    <option value="Préavis"    >Préavis</option>
                                    <option value="Escompte"   >Escompté</option>
                                    <option value="On caissé"       >On caissé</option>
                                    <option value="Impayé"     >Impayé</option>
                                </select>
                             </div></div>
                    
                
                
	</div>
  <div class="col-md-6"> 
       	<?php 
        echo $this->Form->input('Date_fin',array('label'=>'Au','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text') );
        echo $this->Form->input('Date_fn',array('label'=>'Au','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text') );
	echo $this->Form->input('compte_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez choisir') );
//echo $this->Form->input('ligneclient_id',array('div'=>'form-group','label'=>'Adresse','between'=>'<div class="col-sm-10 adrcli">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );       
			
        ?>
  </div>       

                <div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary">Afficher</button> 
                                                 <a href="<?php echo $this->webroot;?>Piecereglements/cheque" class="btn btn-primary">Afficher Tout</a>
                                                 <?php if($imprimer==1){ ?>
<a onClick="flvFPW1(wr+'Piecereglements/imprimercheque?Date_debut=<?php echo @$Date_debut;?>&Date_deb=<?php echo @$Date_deb;?>&situation=<?php echo @$situation;?>&Date_fin=<?php echo @$Date_fin;?>&Date_fn=<?php echo @$Date_fn;?>&fournisseur_id=<?php echo @$fournisseur_id;?>&compte_id=<?php echo @$compte_id;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                                                 <?php
  } 
                                                 ?>
                                         </div>
                                        </div>
 
<?php echo $this->Form->end();?>





</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Caisse chèques'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <input type="hidden" id="date" value="<?php echo date('d/m/Y');?>"/>
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr  bgcolor="#EAEAEA">
	         
		<td align="center"><?php echo $this->Paginator->sort('Fournisseur'); ?></td>
                <td align="center"><?php echo $this->Paginator->sort('Numéro'); ?></td>
                <td align="center"><?php echo $this->Paginator->sort('Encaissement'); ?></td>
		<td align="center"><?php echo $this->Paginator->sort('Echéance'); ?></td>
		<td align="center"><?php echo $this->Paginator->sort('Montant'); ?></td>
                <td align="center"><?php echo $this->Paginator->sort('Compte'); ?></td>
                <td align="center"><?php echo $this->Paginator->sort('Situation'); ?></td>
		<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php 
         //debug($piecereglements);
         $echance='';
         foreach ($piecereglements as $k=>$piece):
         $obj = ClassRegistry::init('Fournisseur');
         $fournisseur = $obj->find('first',array('conditions'=>array('Fournisseur.id'=>$piece['Reglement']['fournisseur_id']),'recursive'=>0));  
         if($piece['Paiement']['id']==7){$echance=$piece['Piecereglement']['nbrmoins'];}else{$echance=h(date("d/m/Y",strtotime(str_replace('-','/',($piece['Piecereglement']['echance'])))));}
?>

	<tr>
		<td><?php echo $fournisseur['Fournisseur']['name']; ?></td>
                <td><?php echo h($piece['Piecereglement']['num']); ?></td>
                <td align="center"><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',($piece['Reglement']['Date']))))); ?></td>
                <td align="center"><?php echo $echance; ?></td>
                <td align="center"><?php echo h($piece['Piecereglement']['montant']); ?></td>
                <td align="center"><?php echo $piece['Compte']['banque'].' '.$piece['Compte']['rib']; ?></td>
                <td><?php echo h($piece['Piecereglement']['situation']); ?></td>
                <td>
                <span title="changer situation"><a onclick="recap1_piecereglement(<?php echo $piece['Piecereglement']['id']; ?>)" href="#reModal_refuser" champ="order" id="order0" value="0" <button class='  '><i class='fa fa fa-pencil'></i></a></span>
                </td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
                    <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="poppiece">
                      
                        
                    </div>
                    <br>
                    <a  class="remodal-confirm ls-light-green-btn btn" onclick="changersituation2()"><strong>OK</strong></a>
                    
                    </div> 
	
                                </div></div></div></div></div>	


