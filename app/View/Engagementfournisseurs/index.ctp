<script language="JavaScript">

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}
$(document).ready(function() {
   
        $(".iframe").colorbox({iframe:true, width:"60%", height:"60%", href: function(){
                return  wr+"Bonlivraisons/choix/"+$(this).attr('id');
            }})
    });
</script>
<br><input type="hidden" id="page" value="1"/>
<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Engagementfournisseur',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
              	<?php 
		echo $this->Form->input('date1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>'Date de') ); 
		echo $this->Form->input('fournisseur_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Fournisseur','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
</div>
<div class="col-md-6">
<?php
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'Ã ") ); 
		echo $this->Form->input('etatpiecereglement_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Etat','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));

?>
 
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                 <a class="btn btn-primary" href="<?php echo $this->webroot;?>Engagementfournisseurs/index"/>Afficher Tout </a>
                    
                <a  onClick="flvFPW1(wr+'Engagementfournisseurs/imprimerrecherche?fournisseurid=<?php echo @$fournisseurid;?>&date1=<?php echo @$date1;?>&date2=<?php echo @$date2;?>&etatpiecereglementid=<?php echo @$etatpiecereglementid;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                   
                   

                    </div>
                </div>
            </div>
<?php echo $this->Form->end();?>
        </div>
    </div>
</div>
<br><input type="hidden" id="page" value="1"/>
 <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Engagment Fournisseur Externe'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <input type="hidden" id="date" value="<?php echo date('d/m/Y');?>"/>
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr  bgcolor="#EAEAEA">
	         
                <td align="center"><?php echo $this->Paginator->sort('Mode de Paiement'); ?></td>
		<td align="center"><?php echo $this->Paginator->sort('Fournisseur'); ?></td>
                <td align="center"><?php echo $this->Paginator->sort('Encaissement'); ?></td>
		<td align="center"><?php echo $this->Paginator->sort('Echéance'); ?></td>
		<td align="center"><?php echo $this->Paginator->sort('Montant'); ?></td>
                <td align="center"><?php echo $this->Paginator->sort('Montant en Devise'); ?></td>
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
                <td><?php echo $piece['Paiement']['name']; ?></td>
		<td><?php echo $fournisseur['Fournisseur']['name']; ?></td>
                <td align="center"><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',($piece['Reglement']['Date']))))); ?></td>
                <td align="center"><?php echo $echance; ?></td>
                <td align="center"><?php echo h($piece['Piecereglement']['montant']); ?></td>
                <td align="center"><?php echo h($piece['Piecereglement']['montantdevise']); ?></td>
                <td><?php echo h($piece['Piecereglement']['situation']); ?></td>
                <td>
                <span title="changer situation"><a onclick="recap_piecereglement(<?php echo $piece['Piecereglement']['id']; ?>)" href="#reModal_refuser" champ="order" id="order0" value="0" <button class='  '><i class='fa fa fa-pencil'></i></a></span>
                </td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
                    <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="poppiece">
                      
                        
                    </div>
                    <br>
                    <a  class="remodal-confirm ls-light-green-btn btn" onclick="changersituation()"><strong>OK</strong></a>
                    
                    </div> 
	
                                </div></div></div></div></div>	


