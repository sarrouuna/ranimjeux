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
<?php $add="";$edit="";$delete="";$imprimer=""; 
$lien=  CakeSession::read('lien_achat');
//debug($lien_achat);die;
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='commandes'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}
        if(@$liens['lien']=='factures'){
		$addindirect=$liens['add'];
		
	}
        if(@$liens['lien']=='bonreceptions'){
		$addbonreception=$liens['add'];
		
	}
} 
if($add==1){?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Commandes/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
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
        <?php echo $this->Form->create('Commande',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
              	<?php 
		echo $this->Form->input('date1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>'Date de') ); 
                
		echo $this->Form->input('fournisseur_id',array('empty'=>'veuillez choisir !!','div'=>'form-group','label'=>'Fournisseur','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));?>
</div>
<div class="col-md-6">
<?php
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'Ã ") ); 
                echo $this->Form->input('validite_id',array('empty'=>'veuillez choisir !!','div'=>'form-group','label'=>'Etat','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
	?>
 
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                 <a class="btn btn-primary" href="<?php echo $this->webroot;?>Commandes/index"/>Afficher Tout </a>
                    <?php if($imprimer==1){ ?>
  <a  onClick="flvFPW1(wr+'Commandes/imprimerrecherche?fournisseurid=<?php echo @$fournisseurid;?>&date1=<?php echo @$date1;?>&date2=<?php echo @$date2;?>&validiteid=<?php echo @$validiteid;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
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
                                    <h3 class="panel-title"><?php echo __('Commandes'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
            <th style="display: none"><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Numero'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fournisseur_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Date'); ?></th>
                 <?php  if(($addindirect==1)||($addbonreception==1)){?>
                     <th><?php echo $this->Paginator->sort(''); ?></th>
                  <?php } ?>   
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php foreach ($commandes as $i=>$commande): ?>
	<tr>
		<td style="display:none"><?php echo h($commande['Commande']['id']); ?>&nbsp;</td>
		<td ><?php echo h($commande['Commande']['numero']); ?>&nbsp;</td>
		<td >
                    <input type="hidden"  value="commande" id='table'/>
	             <input type="hidden"  value="<?php echo $commande['Fournisseur']['id']; ?>" id='Fournisseur<?php echo $i; ?>' />
		    <?php echo $this->Html->link($commande['Fournisseur']['name'], array('controller' => 'fournisseurs', 'action' => 'view', $commande['Fournisseur']['id'])); ?>
		</td>      
		<td ><?php  echo h(date("d/m/Y",strtotime(str_replace('-','/',$commande['Commande']['date'])))); ?>&nbsp;</td>
          <?php    if($commande['Commande']['validite_id']==2){
             if(($addindirect==1)||($addbonreception==1)){?>           
                <td align="center">
                   <input type="checkbox" id="check<?php echo $i; ?>" value ="<?php echo $commande['Commande']['id']?>" name="checkbox[]" ligne="<?php echo $i; ?>" class="abc"/>
                </td> 
          <?php  } }elseif($commande['Commande']['validite_id']==3){ ?>   
                  <td align="center">
		  </td>   
          <?php  }else{ ?>   
                  <td align="center">
                        <?php echo $this->Html->link("<button class='btn btn-xs btn-danger'><i class='fa fa-edit'></i></button>", array('action' => 'validite', $commande['Commande']['id']),array('escape' => false)); ?>
		  </td>   
          <?php  } ?> 
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $commande['Commande']['id']),array('escape' => false)); ?>
                        <?php if(($edit==1)&($commande['Commande']['validite_id']!=3)) { echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $commande['Commande']['id']),array('escape' => false));} ?>
                        <?php if(($delete==1)&($commande['Commande']['validite_id']!=3)) { echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $commande['Commande']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $commande['Commande']['id']));} ?>
             <?php  if($imprimer==1) { ?>
                <a onClick="flvFPW1(wr+'Commandes/imprimer/'+<?php  echo $commande['Commande']['id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
              <?php  } ?>                </td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
                  <table>  
               	 <tr>
	        <td align="center">
            <?php if($addbonreception==1){?>
                 <div class="col-md-12  testcheck" style="display:none;">
                <input type="hidden" name="tes" value="0" class="tes"/>
                <input type="hidden" name="nombre" value="<?php echo @$i; ?>" class="nombre"/>
                 <a class="btn btn btn-danger btnbl"  id="bonreceptionadd"> <i class="fa fa-plus-circle"></i> Créer un bon de reception </a>          
                 </div>         
            <?php } ?>            
	    
                </td>
                <td align="center">     
            <?php  if($addindirect==1){?>
                 <div class="col-md-12  testcheck" style="display:none;">
                <input type="hidden" name="tes" value="0" class="tes"/>
                <input type="hidden" name="nombre" value="<?php echo @$i; ?>" class="nombre"/>
                 <a class="btn btn btn-danger btnbl"  id="datatableadd"> <i class="fa fa-plus-circle"></i> Créer une Facture </a>          
                 </div>         
            <?php } ?>  
               	</td>
	          </tr>
                   </table>                     
                                </div></div></div></div></div>	


