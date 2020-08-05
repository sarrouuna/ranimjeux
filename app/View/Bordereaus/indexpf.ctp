<script language="JavaScript">

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}

</script>
<br><input type="hidden" id="page" value="1"/>
<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
                <ul class="panel-control" style="top: 105px;">
                    <li><a class="minus" href="javascript:void(0)"><i class="fa fa-square-o" style="width: 1100px;height: 30px"></i></a></li>
                </ul>
            </div>
            <div class="panel-body" <?php if($recherche==1){ ?>style="display: none"<?php } ?>>
        <?php echo $this->Form->create('Piecereglement',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
              	<?php 
		
		echo $this->Form->input('Date_debut',array('label'=>'Encaissement du','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text') );
                echo $this->Form->input('Date_deb',array('label'=>'Echéance du','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text') );
		echo $this->Form->input('fournisseur_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Fournisseur','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
		echo $this->Form->input('etatpiecereglement_id',array('multiple'=>'multiple','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Etat','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('nacionalitefournisseur_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Type Fournisseur','between'=>'<div class="col-sm-10 adrcli">','after'=>'</div>','class'=>'form-control') );       
                echo $this->Form->input('numero',array('label'=>'Numero','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'text') );
                ?>
                            <!--<div class="form-group">
                            <label>Situation</label>
                               <div class="col-sm-10">
                                <select class="form-control select selectized" placeholder="Veuillez choisir" name="data[Piecereglement][situation]" id="stut" >
                                    <option value="">Veuillez choisir</option>
                                    <option value="En attente">En attente</option>
                                    <option value="Préavis">Préavis</option>
                                    <option value="paye">     Payé</option>
                                    <option value="Impaye">Impayé</option>
                                    <?php foreach($etatpieces as $p){ ?>
                                    <option value="Regle Fournisseur">Reglé Fournisseur</option>
                                    <?php } ?>
                                </select>
                             </div></div>-->
                    
                
                
	</div>
  <div class="col-md-6"> 
       	<?php 
        echo $this->Form->input('Date_fin',array('label'=>'Au','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text') );
        echo $this->Form->input('Date_fn',array('label'=>'Au','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text') );
	echo $this->Form->input('compte_id',array('multiple'=>'multiple','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez choisir') );
	echo $this->Form->input('paiement_id',array('multiple'=>'multiple','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez choisir') );
        echo $this->Form->input('regle_id',array('div'=>'form-group','label'=>'Reglé Fournisseur','between'=>'<div class="col-sm-10 adrcli">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez choisir') );       
        echo $this->Form->input('montant',array('label'=>'Montant','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'text') );
        ?>
  </div>       

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
<!--                 <a class="btn btn-primary" href="<?php echo $this->webroot;?>Bordereaus/indexpf"/>Afficher Tout </a>-->
                    
<a onClick="flvFPW1(wr+'Bordereaus/imprimerindexpf?Date_debut=<?php echo @$Date_debut;?>&Date_deb=<?php echo @$Date_deb;?>&situation=<?php echo @$tt;?>&Date_fin=<?php echo @$Date_fin;?>&Date_fn=<?php echo @$Date_fn;?>&fournisseur_id=<?php echo @$fournisseur_id;?>&compte_id=<?php echo @$c;?>&paiement_id=<?php echo @$p;?>&abc=<?php echo @$abc;?>&nacionalitefournisseur_id=<?php echo @$nacionalitefournisseur_id;?>&numero=<?php echo @$numero;?>&montant=<?php echo @$montant;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                   
                   

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
                                    <h3 class="panel-title"><?php echo __('Engagment Fournisseur'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <input type="hidden" id="date" value="<?php echo date('d/m/Y');?>"/>
                                    <div class="ls-editable-table table-responsive ls-table">
            <center> <a onclick="recap_piecereglement()" class="btn btn btn-danger changersituation"  id="changer" style="display:none;" href="#reModal_refuser"> <i class="fa fa-plus-circle"></i> Changer situation </a>   <strong><span id="totalpiececlient"></span></strong> </center>
                  <table class="table table-bordered table-striped table-bottomless" id="">
                      <thead>
	<tr  bgcolor="#EAEAEA">
                <td align="center"></td> 
	        <td align="center"></td> 
                <td align="center"><?php echo ('Mode de Paiement'); ?></td>
		<td align="center"><?php echo ('Fournisseur'); ?></td>
                <td align="center"><?php echo ('Réglement'); ?></td>
                <td align="center"><?php echo ('Numero'); ?></td>
                <td align="center"><?php echo ('Encaissement'); ?></td>
		<td align="center"><?php echo ('Echéance'); ?></td>
		<td align="center"><?php echo ('Montant'); ?></td>
<!--                <td align="center"><?php echo ('Montant en Devise'); ?></td>-->
                <td align="center"><?php echo ('Compte'); ?></td>
                <td align="center"><?php echo ('Situation'); ?></td>
		<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php 
         //debug($piecereglements);
         $echance='';
         $tot=0;
         foreach ($piecereglements as $k=>$piece):
             //debug($piece['Piecereglement']['echance']);
         if(!empty($piece['Piecereglement']['echance'])){
         $echance=h(date("d/m/Y",strtotime(str_replace('-','/',($piece['Piecereglement']['echance'])))));    
         }else{
         $echance="";    
         }
         $tot=$tot+$piece['Piecereglement']['montant'];    
         $obj = ClassRegistry::init('Fournisseur');
         $fournisseur = $obj->find('first',array('conditions'=>array('Fournisseur.id'=>$piece['Reglement']['fournisseur_id']),'recursive'=>0));  
         //if($piece['Paiement']['id']==7){$echance=$piece['Piecereglement']['nbrmoins'];}
         $test=strpos($k/2,".");
         if($test==true){
          $style="style='background-color:#EAEAEA'";
         }else{
          $style="style='background-color:white'";   
         }
         ?>
	<tr <?php echo $style ; ?>>
                 <td id="tdaff0" >
                <span><?php echo $k+1; ?></span>
                </td>
                <td id="tdaff0" >
                <span title="Ancien situation"><a  onclick="recap_situation_piece_frs(<?php echo $piece['Piecereglement']['id']; ?>)" href="#reModal_refuser" champ="order" id="order<?php echo $k; ?>" value="<?php echo $k; ?>" <button class='  '><i class='fa fa fa-pencil'></i></a></span>
                </td>
                <td>
                    <?php if($piece['Piecereglement']['importation_id'] !=0){ ?>
			<?php echo $this->Html->link($piece['Paiement']['name'], array('controller' => 'importations', 'action' => 'view', $piece['Piecereglement']['importation_id'])); ?>
                    <?php }else { ?>
                    <?php echo $piece['Paiement']['name']; ?>
                    <?php } ?>
                </td>
		<td><?php echo $fournisseur['Fournisseur']['name']; ?></td>
                <td><?php echo $piece['Reglement']['designation']; ?></td>
                <td align="center"><?php echo h($piece['Piecereglement']['num']); ?></td>
                <td align="center"><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',($piece['Reglement']['Date']))))); ?></td>
                <td align="center"><?php echo $echance; ?></td>
                <td align="center"><?php echo h($piece['Piecereglement']['montant']); ?></td>
<!--                <td align="center"><?php echo h($piece['Piecereglement']['montantdevise']); ?></td>-->
                <td align="center"><?php echo $piece['Compte']['banque']; ?></td>
                <td><?php echo h($piece['Piecereglement']['situation'])." ".$piece['Piecereglement']['nbrmoins']; ?></td>
                <td>
                <input  type="checkbox" id="chec_piece_id<?php echo $k ;?>" value="<?php echo $piece['Piecereglement']['id']?>" montant="<?php echo $piece['Piecereglement']['montant']?>" class="afficherbouttonsituation">
                <?php //if($fournisseur['Fournisseur']['devise_id']==1){ ?>
<!--                <span title="changer situation"><a onclick="recap1_piecereglement(//<?php echo $piece['Piecereglement']['id']; ?>)" href="#reModal_refuser" champ="order" id="order0" value="0" <button class='  '><i class='fa fa fa-pencil'></i></a></span>-->
                <?php //} else { ?>
<!--                <span title="changer situation"><a onclick="recap_piecereglement(//<?php echo $piece['Piecereglement']['id']; ?>)" href="#reModal_refuser" champ="order" id="order0" value="0" <button class='  '><i class='fa fa fa-pencil'></i></a></span>-->
                <?php //} ?>
                </td>
	</tr>
<?php endforeach; ?>
        <tr>
            <td align="center" colspan="6"><strong>Total</strong></td>
            <td align="center" colspan="2"><strong>
            <?php echo number_format($tot,3, '.', ' ') ; ?>    
            </strong></td>
        </tr>
                          </tbody>
	</table>
                                        <input id="index" value="<?php echo @$k ;?>" type="hidden"> 
                    <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="pop">
                      
                        
                    </div>
                    <div id="popp">
                      
                        
                    </div>    
                    <br>
                    <a  class="remodal-confirm ls-light-green-btn btn" id="boutton_ok"><strong>OK</strong></a>
                    </div>  
	
                                </div></div></div></div></div>	


