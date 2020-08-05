<script>

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}
function  EW_checkMyForm(type) {
    //event.preventDefault();
    //alert(type);
    
    if(type=="recherche"){
    var client=$('#BonlivraisonClientId').val();
    if(client==''){
         bootbox.alert('If faut choisir un client');
         return false;
    }else{
        //alert('helmi');
        //$('#defaultForm').submit();
    }
    }
    
    
    if(type=="facture"){
    var pv=$('#pointdevente_id').val()||0;
    var date=$('#BonlivraisonDate').val(); 
    var client=$('#BonlivraisonClientId').val();
    if(pv==0 || date=='__/__/____' || client==''){
       bootbox.alert('If faut choisir un point de vente et date facture et client');
         return false; 
    }else{
        //$('#defaultForm').submit();
    }
    }
}
</script>
 <?php $add="";$edit="";$delete="";$imprimer="";$addindirect=""; 
$lien=  CakeSession::read('lien_vente');
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='bonlivraisons'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}
if(@$liens['lien']=='factureclients'){
		$addindirect=$liens['add'];	
	}
  
} 
if($add==1){?>

<?php } ?>
<br>
<input value="fac_des_bl" id="page" type="hidden">
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Bonlivraison',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
                    <?php 
                    echo $this->Form->input('date1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly ','type'=>'text','label'=>'Date de') ); 
                    echo $this->Form->input('client_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Client','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                    echo $this->Form->input('pointdevente_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
?>
                </div>
               <div class="col-md-6">
                <?php
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'Ã ") ); 
                echo $this->Form->input('exercice_id',array('value'=>$exerciceid,'empty'=>'veuillez choisir','div'=>'form-group','label'=>'année','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('mois_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Mois','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
 
                </div>      

                <div class="form-group" >
                    <div class="col-lg-9 col-lg-offset-3">
                        <button onmousemove="EW_checkMyForm('recherche')" type="submit" class="btn btn-primary facbl" name="data[Bonlivraison][facture]" value="recherche" id="aff">Chercher</button>  
                 <a class="btn btn-primary" href="<?php echo $this->webroot;?>Bonlivraisons/indexx"/>Afficher Tout </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<br>
<?php 
        if(!empty($bonlivraisons))
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
                $style='style="display: "';    
               echo $this->Form->input('pointdeventee_id',array('empty'=>'veuillez choisir','id'=>'pointdevente_id','data[Facture][pointdevente_id]','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control numspecial select'));
               echo $this->Form->input('date',array('id'=>'datefac','div'=>'form-group','value'=>date("d/m/Y"),'data[Facture][date]','type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
	       echo $this->Form->input('model',array('id'=>'model','type'=>'hidden','value'=>'Factureclient','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
	       echo $this->Form->input('source',array('id'=>'source','type'=>'hidden','value'=>'bl','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
               echo $this->Form->input('pv',array('id'=>'pvv','type'=>'hidden','value'=>$pvv,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
?>
                </div>
               <div class="col-md-6">
                <?php
               // echo $this->Form->input('depott_id',array('empty'=>'veuillez choisir','id'=>'pointdevente_id','data[Facture][pointdevente_id]','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control numspecial select'));
		echo $this->Form->input('numero',array('id'=>'numero','div'=>'form-group','data[Facture][numero]','between'=>'<div class="col-sm-8">','after'=>'</div><a class="NumeroInf" id="aa" '.$style.' /> <i class="fa fa-arrows" ></i></a>','class'=>'form-control') );
                ?>
                    
                <?php 
                echo $this->Form->input('numeroconca',array('id'=>'numeroconca','data[Facture][numeroconca]','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('ttc',array('value'=>$soummebonlivraisons[0][0]['totalttc'],'id'=>'numero','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );?>
                </div>      
                
                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <br><br>
                        <button onmousemove="EW_checkMyForm('facture')" type="submit" class="btn btn btn-danger btnbl" name="data[Bonlivraison][facture]" value="facture" id="aff">Créer une Facture</button> 
                       </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php } ?>

<br>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Bonlivraisons'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless">
                      <thead>
	<tr>
	         
		
	        <th style="display:none;"><?php echo ('id'); ?></th>
                <th><?php echo ('Numero'); ?></th>
                
		<th><?php echo ('Client_id'); ?></th>
	      
	         
		<th><?php echo ('Date'); ?></th>
	         
		
	         	         
		<th><?php echo ('Totalht'); ?></th>
	         
		<th><?php echo ('Totalttc'); ?></th>
                
 <?php  if($addindirect==1){?><th align="center"><center>facture</center></th> <?php  } ?> 
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php 
        if(!empty($bonlivraisons)){
        foreach ($bonlivraisons as $i=>$bonlivraison): ?>

	<tr>
		<td style="display:none"><?php echo h($bonlivraison['Bonlivraison']['id']); ?></td>
                <td ><?php echo h($bonlivraison['Bonlivraison']['numero']); ?></td>
		<td >
            <input type="hidden"  value="<?php echo $bonlivraison['Bonlivraison']['pointdevente_id']; ?>" id='Pointdevente<?php echo $i; ?>' />
            <input type="hidden"  value="<?php echo $bonlivraison['Client']['id']; ?>" id='Client<?php echo $i; ?>' />
			<?php echo $this->Html->link($bonlivraison['Bonlivraison']['name'], array('controller' => 'clients', 'action' => 'view', $bonlivraison['Client']['id'])); ?>
		</td>

		<td ><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',$bonlivraison['Bonlivraison']['date'])))); ?></td>
		
		<td ><?php echo h($bonlivraison['Bonlivraison']['totalht']); ?></td>
		<td ><?php echo h($bonlivraison['Bonlivraison']['totalttc']); ?></td>
                
                <td align="center">
                    <input type="checkbox" checked="checked" id="check<?php echo $i; ?>" value ="<?php echo $bonlivraison['Bonlivraison']['id'] ?>" name="facture[]" ligne="<?php echo $i; ?>" />
                </td> 
               
       
		<td align="center">
			<?php  if($imprimer==1) { ?>
                <a onClick="flvFPW1(wr+'Bonlivraisons/imprimer/'+<?php  echo $bonlivraison['Bonlivraison']['id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
              <?php  } ?>
  </td>
	</tr>
<?php  endforeach;
        }?>
                          </tbody>
	</table>
         <input type="hidden"  value="<?php echo @$i ;?>" id="index"/>   
         <input type="hidden"  value="bl" id="page"/>    
	 

<?php echo $this->Form->end();?>                 
                                </div></div></div></div></div>	


