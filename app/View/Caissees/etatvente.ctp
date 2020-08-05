<script language="JavaScript" type="text/JavaScript">

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}
$(document).ready(function() {
   
        $(".iframe").colorbox({iframe:true, width:"60%", height:"60%", href: function(){
                return  wr+"Bonlivraisons/choix/"+$(this).attr('id');
            }})
    });
</script>
 <?php //$add="";$edit="";$delete="";$imprimer=""; 
//$lien=  CakeSession::read('lien_finance');
//foreach($lien as $k=>$liens){
    //debug($liens);die;
//	if(@$liens['lien']=='caissees'){
//		$add=$liens['add'];
//		$edit=$liens['edit'];
//		$delete=$liens['delete'];
//		$imprimer=$liens['imprimer'];
//	}
 //       if(@$liens['lien']=='factures'){
//		$addindirect=$liens['add'];
		
//	}
 //       if(@$liens['lien']=='bonentres'){
  //            $addbonentre=$liens['add'];
  //      }
//} ?>
<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Caissee',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','enctype' => 'multipart/form-data')); ?>

                <div class="col-md-6">                  
		   <?php echo $this->Form->input('moi_id',array('id'=>'moi_id','multiple'=>'multiple','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Mois','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));?>
                </div>
               <div class="col-md-6">
                <?php echo $this->Form->input('Annee',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'text','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>"Année ") ); ?>
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary testcaisse" id="aff">Chercher</button>  
                    <?php // if($imprimer==1){ ?>
      <a  onClick="flvFPW1(wr+'Caissees/imprimeretatvente?annee=<?php echo @$annee;?>&moiid=<?php echo @$moiid;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                    <?php //}?>
                   

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
                                    <h3 class="panel-title"><?php echo __('Etat des ventes'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
               
                     <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                      <thead>
	<tr>
		<th><?php echo ('Date'); ?></th>
	         
		<th><?php echo ('Clients'); ?></th>
	         	         
		<th><?php echo ('N° Fre'); ?></th>
	     
		<th><?php echo ('Mnt HT'); ?></th>

                <th><?php echo ('TVA '); ?></th>

                <th><?php echo ('Timbre'); ?></th>

                <th><?php echo ('Mnt TTC '); ?></th>

                <th>
                    <?php echo ('Pièce'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php echo ('Numéro '); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php echo ('Montant'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php echo ('Banque'); ?>
                </th>

                <th><?php echo ('Reste a payer'); ?></th>

        </tr></thead><tbody>
	<?php  $total=0; $reste=0;
              foreach ($factureclients as $factureclient):
                   $total=$total+$factureclient['Factureclient']['totalttc'];
                   $reste=$reste+($factureclient['Factureclient']['totalttc']-$factureclient['Factureclient']['Montant_Regler']);?>
	<tr>
		<td ><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',$factureclient['Factureclient']['date'])))); ?>&nbsp;</td>
                <td >
                <?php echo $this->Html->link($factureclient['Client']['name'], array('controller' => 'clients', 'action' => 'view', $factureclient['Client']['id'])); ?>
                </td>
                <td ><?php $year=explode( '-',$factureclient['Factureclient']['date']);
                echo $this->Html->link($factureclient['Factureclient']['numero'], array('controller' => 'factureclients', 'action' => 'view', $factureclient['Factureclient']['id'])); echo(' / '.$year[0]) ;?>
                 </td>
		<td ><?php echo h($factureclient['Factureclient']['totalht']); ?>&nbsp;</td>
                <td ><?php echo h($factureclient['Factureclient']['tva']); ?>&nbsp;</td>
                <td ><?php echo h($factureclient['Timbre']['timbre']); ?>&nbsp;</td>
		<td ><?php echo h($factureclient['Factureclient']['totalttc']); ?>&nbsp;</td>
		<td >
                 <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                  <?php if(!empty($lignereglementclients[$factureclient['Factureclient']['id']])){foreach($lignereglementclients[$factureclient['Factureclient']['id']][0]['Reglementclient']['Piecereglementclient'] as $piece){ ?>
                   <tr>
		     <td ><?php echo h($paiements[$piece['paiement_id']]); ?>&nbsp;</td>
		     <td ><?php echo h($piece['num']); ?>&nbsp;</td>
		     <td ><?php echo h($piece['montant']); ?>&nbsp;</td>
		     <td ><?php echo h($piece['banque']); ?>&nbsp;</td>
                   </tr>
                  <?php } }?>
                  </table>
                </td>
		<td ><?php echo h($factureclient['Factureclient']['totalttc']-$factureclient['Factureclient']['Montant_Regler']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
           
              <tr>
                
                 <td colspan="4" >
		<center><strong> <?php  echo ('Total :'); ?></strong></center>
                 </td>
                  <td colspan="3"  >
		<center><strong> <?php  echo ($total); ?></strong></center>
                 </td>
                 
                 <td  >
		<center> <strong> <?php  echo ('Reste :'); ?></strong></center> 
                 </td>
                  <td >
		 <strong> <?php  echo ($reste); ?></strong>
                 </td>
                 
              </tr>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


