<script language="JavaScript">
function flvFPW1(){
var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;
}
</script>
 <?php $add="";$edit="";$delete="";$imprimer=""; 
$lien=  CakeSession::read('lien_vente');
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='piecereglementclients'){
		//$add=$liens['add'];
		//$edit=$liens['edit'];
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
            <div class="panel-body" <?php if($recherche==1){ ?>style="display: none"<?php } ?>  >
            <?php echo $this->Form->create('Piecereglementclient',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php 
		
		echo $this->Form->input('Date_debut',array('label'=>'Encaissement du','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
                echo $this->Form->input('Date_deb',array('label'=>'Echéance du','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
		echo $this->Form->input('client_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez choisir','id'=>'BoncommandeClientId') );
	
             
                ?>
                            <div class="form-group">
                            <label>Situation</label>
                               <div class="col-sm-10">
                                <select class="form-control select selectized" placeholder="Veuillez choisir" name="data[Piecereglementclient][situation]" id="stut" >
                                    <option value="" >Veuillez choisir</option>
                                    <option value="En attente" <?php if(@$situation=="En attente"){?>selected="selected" <?php } ?>>En attente</option>
                                    <option value="Versé"   <?php if(@$situation=="Versé"){?>selected="selected" <?php } ?>   >Versé</option>
                                    <option value="Préavis"  <?php if(@$situation=="Préavis"){?>selected="selected" <?php } ?>  >Préavis</option>
                                    <option value="Versé à escompte" <?php if(@$situation=="Versé à escompte"){?>selected="selected" <?php } ?>>Versé à l'escompte</option>
                                    <option value="Escompte"  <?php if(@$situation=="Escompte"){?>selected="selected" <?php } ?> >Escompté</option>
                                    <option value="On caissé"  <?php if(@$situation=="On caissé"){?>selected="selected" <?php } ?> >Encaissé</option>
                                    <option value="Impayé"   <?php if(@$situation=="Impayé"){?>selected="selected" <?php } ?>  >Impayé</option>
                                </select>
                             </div></div>
                    
            <?php 
                echo $this->Form->input('numero',array('label'=>'Numero','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'text') );
            ?>    
                
	</div>
  <div class="col-md-6"> 
       	<?php 
        echo $this->Form->input('Date_fin',array('label'=>'Au','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
        echo $this->Form->input('Date_fn',array('label'=>'Au','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
	?>
      <div class="form-group">
      <label class='col-md-2 control-label'>Compte</label>
      <div class='col-sm-10'>
          <select class="select" name="data[Piecereglementclient][compte_id]">
                    <option value="">Veuillez choisir</option>
                    <?php foreach($comptes as $c){?>
                    <option value="<?php echo $c['Compte']['id'] ?>" <?php if(@$c['Compte']['id']==@$compte_id){?>selected="selected" <?php } ?> ><?php echo $c['Compte']['banque'].' '.$c['Compte']['rib']; ?></option>
                   <?php  }
                    ?></select>
      </div></div>  
      <?php
        //echo $this->Form->input('compte_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez choisir') );
	echo $this->Form->input('paiement_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez choisir') );
//echo $this->Form->input('ligneclient_id',array('div'=>'form-group','label'=>'Adresse','between'=>'<div class="col-sm-10 adrcli">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );       
                echo $this->Form->input('montant',array('label'=>'Montant','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'text') );
        ?>
  </div>   

                <div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary">Afficher</button> 
<!--                                                 <a href="<?php echo $this->webroot;?>Bordereaus/indexpc" class="btn btn-primary">Afficher Tout</a>-->
                                                 <?php if($imprimer==1){ ?>
<a onClick="flvFPW1(wr+'Bordereaus/imprimerindexpc?Date_debut=<?php echo @$Date_debut;?>&Date_deb=<?php echo @$Date_deb;?>&situation=<?php echo @$situation;?>&Date_fin=<?php echo @$Date_fin;?>&Date_fn=<?php echo @$Date_fn;?>&client_id=<?php echo @$client_id;?>&compte_id=<?php echo @$compte_id;?>&paiement_id=<?php echo @$paiement_id;?>&numero=<?php echo @$numero;?>&montant=<?php echo @$montant;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
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
                                    <h3 class="panel-title"><?php echo __('Engagement client'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <input type="hidden" id="date" value="<?php echo date('d/m/Y');?>"/>
                                    <div class="ls-editable-table table-responsive ls-table">
                                        <center> <a onclick="recap_piecereglementclient()" class="btn btn btn-danger changersituation"  id="changer" style="display:none;" href="#reModal_refuser"> <i class="fa fa-plus-circle"></i> Changer situation </a>&nbsp;&nbsp;&nbsp;<strong><span id="totalpiececlient"></span></strong></center>      
                  <table class="table table-bordered table-striped table-bottomless" id="">
                      <thead>
	<tr  bgcolor="#EAEAEA">
	         
		<td style="display: none;" ><?php echo 'Echeance'; ?></td>
                <td align="center" width="10%"><?php echo 'Client'; ?></td>
		<td align="center" width="29%"><?php echo 'Client'; ?></td>
                <td align="center" width="20%"><?php echo 'Numero'; ?></td>
                <td align="center" width="10%"><?php echo 'Encaissement'; ?></td>
		<td align="center" width="10%"><?php echo 'Echeance'; ?></td>
		<td align="center" width="10%"><?php echo 'Montant'; ?></td>
                <td align="center" width="10%"><?php echo 'Situation'; ?></td>
                <td align="center" width="1%"><?php echo ''; ?></td>
<!--			<th class="actions" align="center"></th>-->
        </tr></thead><tbody>
	<?php //debug($piecereglementclients);die;
        //sort($piecereglementclients);
        $tot=0;
         foreach ($piecereglementclients as $k=>$piece):
             $tot=$tot+$piece['Piecereglementclient']['montant'];
            // debug($piecereglement);die;
         if(($piece['Piecereglementclient']['echance'] =="1970-01-01")) {
         $date=""; 
         }else{
         if(($piece['Piecereglementclient']['echance'] =="")) {
         $date="";   
         }else{
          $date=date("d/m/Y",strtotime(str_replace('-','/',($piece['Piecereglementclient']['echance']))));   
         }} 
         
         if($piece['Piecereglementclient']['situation'] =="On caissé"){
         $piece['Piecereglementclient']['situation']="Encaissé";
         }
             ?>
	<tr>
		<td style="display: none;" aria-sort="ascending" class="sorting_asc" aria-controls="ls-editable-table"><?php echo $piece['Piecereglementclient']['echance']; ?></td>
		<td><?php echo $piece['Paiement']['name']; ?></td>
                <td><?php echo $piece['Client']['name']; ?></td>
                <td><?php echo $piece['Piecereglementclient']['num']; ?></td>
                <td><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',($piece['Reglementclient']['Date']))))); ?></td>
                <td><?php echo $date; ?></td>
                <td align='center'><?php echo number_format($piece['Piecereglementclient']['montant'],3, '.', ' '); ?></td>
                <td align='center'><?php echo $piece['Piecereglementclient']['situation']; ?></td>
                <td align='center'>
                    <input  type="checkbox" id="chec_piece_id<?php echo $k ;?>" value="<?php echo $piece['Piecereglementclient']['id']?>" montant="<?php echo $piece['Piecereglementclient']['montant']?>" class="afficherbouttonsituation">   
<!--                <span title="changer situation"><a onclick="recap_piecereglementclient(<?php echo $piece['Piecereglementclient']['id']; ?>)" href="#reModal_refuser" champ="order" id="order0" value="0" <button class='  '><i class='fa fa fa-pencil'></i></a></span>-->
                </td>
<!--                <td>
                    <select class="select selectbanq" id="compte_id<?php echo $piece['Piecereglementclient']['id'];?>" val="<?php echo $piece['Piecereglementclient']['id'];?>" >
                    <option value="">Veuillez choisir</option>
                    <?php foreach($comptes as $c){?>
                    <option value="<?php echo $c['Compte']['id'] ?>" <?php if($c['Compte']['id']==$piece['Piecereglementclient']['compte_id']){?>selected="selected" <?php } ?>><?php echo $c['Compte']['banque'].' '.$c['Compte']['rib']; ?></option>
                   <?php  }
                    ?></select>
                    <input type="hidden" value="<?php echo date("d/m/Y",strtotime(str_replace('-','/',($piece['Piecereglementclient']['echance']))));?>" id="echeance<?php echo $piece['Piecereglementclient']['id'];?>" val="<?php echo $piece['Piecereglementclient']['id'];?>" />
                    <?php //echo $this->Form->input('banque_id',array('label'=>'','after'=>'</div>','empty'=>'Veuillez choisir','id'=>'banque_id'.$piecereglement['Piece']['id'],'val'=>$piecereglement['Piece']['id']) ); ?>
                </td>
                 <td>
                    <select  class="select selectstut" id="stut<?php echo $piece['Piecereglementclient']['id'];?>" val="<?php echo $piece['Piecereglementclient']['id'];?>" >
                    <option value="En attente" <?php if($piece['Piecereglementclient']['situation']=='En attente'){?>selected="selected" <?php } ?>>En attente</option>
                    <option value="Versé"      <?php if($piece['Piecereglementclient']['situation']=='Versé'){?>selected="selected" <?php } ?>>Versé</option>
                    <option value="Préavis"    <?php if($piece['Piecereglementclient']['situation']=='Préavis'){?>selected="selected" <?php } ?>>Préavis</option>
                    <option value="Escompte"    <?php if($piece['Piecereglementclient']['situation']=='Escompte'){?>selected="selected" <?php } ?>>Escompte</option>
                    <option value="On caissé"       <?php if($piece['Piecereglementclient']['situation']=='On caissé'){?>selected="selected" <?php } ?>>On caissé</option>
                    <option value="Impayé"     <?php if($piece['Piecereglementclient']['situation']=='Impayé'){?>selected="selected" <?php } ?>>Impayé</option>
                    </select>
                    <?php //echo $this->Form->input('banque_id',array('label'=>'','after'=>'</div>','empty'=>'Veuillez choisir','id'=>'banque_id'.$piecereglement['Piece']['id'],'val'=>$piecereglement['Piece']['id']) ); ?>
                </td>-->
<!--		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $piece['Piecereglementclient']['id']),array('escape' => false)); ?>
			<?php //echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $piecereglement['Piecereglement']['id']),array('escape' => false)); ?>
			<?php //echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $piecereglement['Piecereglement']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $piecereglement['Piecereglement']['id'])); ?>
		</td>-->
	</tr>
        
<?php endforeach; ?>
        <tr>
            <td align="center" colspan="5">Total</td>
            <td align="center">
            <?php echo number_format($tot,3, '.', ' ') ; ?>    
            </td>
        </tr>
                          </tbody>
	</table>
            <input id="index" value="<?php echo $k ;?>" type="hidden">      
                    <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="poppiece">
                      
                        
                    </div>
                    <br>
                    <a  class="remodal-confirm ls-light-green-btn btn " id="boutton_ok" onmouseover="testcompte()" onclick="changersituationclient()"><strong>OK</strong></a>
                    
                    </div> 
	
                                </div></div></div></div></div>	


