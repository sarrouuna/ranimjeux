
<script language="JavaScript" type="text/JavaScript">
function flvFPW1(){
var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;
}
</script>

<br><input type="hidden" id="page" value="soldeclient"/>
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
                                <div class="panel-body">
        <?php echo $this->Form->create('Recherche',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php 
		echo $this->Form->input('date1',array('label'=>'Date début','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
                echo $this->Form->input('societe_id',array('id'=>'societe_id','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez choisir..') );			
                echo $this->Form->input('client_id', array('type'=>'hidden','id' => 'client_id', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                echo $this->Form->input('clientname', array('label'=>'Client','yourid'=>'client_id','id' => 'clientname', 'div' => 'form-group', 'between' => '<div class="col-sm-10"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div>', 'class' => 'form-control autocomplete_name_clients'));
                ?>
            </div>
            <div class="col-md-6"> 
                <?php 
                echo $this->Form->input('date2',array('label'=>'Date fin','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
                echo $this->Form->input('personnel_id',array('id'=>'personnel_id','label'=>'Personnel','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez choisir..') );
                echo $this->Form->input('bl_id',array('label'=>'Bon Livraison','id'=>'bl_id','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire'/*,'empty'=>'Veuillez choisir..'*/) );			
             //echo $this->Form->input('exercice_id',array('value'=>@$exerciceid,'empty'=>'veuillez choisir','div'=>'form-group','label'=>'année','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
            </div>   

                <div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3" >
                                                <button  id="breleve" type="submit" class="btn btn-primary testhistoriquearticle" >Afficher</button> 
       <a  onClick="flvFPW1(wr+'Releves/imprimerrecherche?date1=<?php echo @$date1;?>&date2=<?php echo @$date2;?>&name=<?php echo @$name;?>&societeid=<?php echo @$societeid;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                                            </div>
                                        </div>
 
<?php echo $this->Form->end();?>

</div>
                            </div>
                        </div>

<?php 

?>
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Etat de solde client'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                                     <table class="table table-bordered table-striped table-bottomless" id="" style="border:2px solid black;">
                      <thead>
<!--<tr>
    <td style="background-color: #F2D7D5;" align="center"><strong> Solde Intial </strong></td>    <td colspan="8" bgcolor="#F2D7D5" align="center" ><strong><?php  echo @$soldeint; ?></strong></td>
</tr>--><strong>
<tr><td colspan="9" style="height: 10px;" ></td></tr>                          
<?php if(!empty($date1)||!empty($date2)){  ?>                     
<tr>
    <td style="background-color: #F2D7D5;" align="center"><strong> Période </strong></td>    <td colspan="4" bgcolor="#F2D7D5" align="center"><strong><?php  echo date("d/m/Y", strtotime(str_replace('-', '/',@$date1))); ?></strong></td><td align="center" colspan="4" bgcolor="#F2D7D5" ><strong><?php  echo date("d/m/Y", strtotime(str_replace('-', '/',@$date2))); ?></strong></td>
</tr><strong>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<!--**************************************************************************************************************-->    
<?php } ?>
<?php if(!empty($name)){  ?>                     
<tr>
    <td style="background-color: #F2D7D5;" align="center"><strong> Agent </strong></td>    <td colspan="8" bgcolor="#F2D7D5" ><strong><?php  echo @$name; ?></strong></td>
</tr><strong>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<!--**************************************************************************************************************-->    
<?php } ?>
                <tr style="border:1px solid black;" >
	         
                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>Date</center></strong></th>
                <th style="border:1px solid black;" bgcolor="#F2D7D5"><strong><center>N° Piece</center></strong></th>
                <th style="border:1px solid black;width: 30%;" bgcolor="#F2D7D5" ><strong><center>Libellé Piece</center></strong></th>
                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>Dédit</center></strong></th>
                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>Crédit</center></strong></th>
                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>Impayé</center></strong></th>
                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>Règlement</center></strong></th>
                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>Avoir</center></strong></th>
                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>Solde</center></strong></th>
                </tr><tr><td colspan="9" style="height: 10px;" ></td></tr> </thead><tbody>

    



	<?php //debug($lignecommandes);
        $totdebit=0;
        $totcredit=0;
        $totimpayer=0;
        $totreg=0; 
        $totavoir=0;
        $totsolde=0;
        $totdebitt=0;
        $totcreditt=0;
        $totimpayert=0;
        $totregt=0; 
        $totavoirt=0;
        $totsoldet=0;
        $clt_id=0;
        $soldeencours=0;
        //$sld=$soldeint;
        foreach ($relefes as $i=>$relefe){  ?>
<?php if ($relefe['Client']['id']!=$clt_id){ ?>
<?php if($i!=0){ 
         ?>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<tr>
    <td colspan="3" style="background-color: #F2D7D5;" align="center"><strong> Total  </strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totdebit,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totcredit,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totimpayer,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totreg,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totavoir,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totsoldet,3, '.', ' '); ?></strong></td>
</tr>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<?php   $totdebit=0;
        $totcredit=0;
        $totimpayer=0;
        $totreg=0; 
        $totavoir=0;
        $totsolde=0;
        $sld=0;
}
$client=ClassRegistry::init('Client')->find('first', array('conditions' => array('Client.id'=>$relefe['Client']['id']),'recursive'=>0 ));
        $condb3 = 'Bonlivraison.client_id ='.$relefe['Client']['id'];
        $condf3 = 'Factureclient.client_id ='.$relefe['Client']['id'];
        $condfa3='Factureavoir.client_id ='.$relefe['Client']['id'];
        $condr3 = 'Reglementclient.client_id ='.$relefe['Client']['id'];
        $condtr3 = 'Transfert.societearrive ='.$client['Client']['societe_id'];    
        $solde=0;
            $soldeavoir=ClassRegistry::init('Factureavoir')->find('first', array(
            'fields'=>array('sum(Factureavoir.totalttc) as solde'),    
            'conditions' => array(@$condfas,$condfa3,$condfa6),'recursive'=>0 ));
            if(!empty($soldeavoir)){
                $solde=$solde-$soldeavoir[0]['solde'];
            }
            $soldebl=ClassRegistry::init('Bonlivraison')->find('first', array(
            'fields'=>array('sum((Bonlivraison.totalttc)) as solde'),    
            'conditions' => array(@$condbs,$condb3,$condb6,'Bonlivraison.factureclient_id'=>0),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde+$soldebl[0]['solde'];
                
            }
            $soldefac=ClassRegistry::init('Factureclient')->find('first', array(
            'fields'=>array('sum((Factureclient.totalttc)) as solde'),    
            'conditions' => array(@$condfs,$condf3,$condf6),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde+$soldefac[0]['solde'];
                
            }
            $soldereg=ClassRegistry::init('Reglementclient')->find('first', array(
            'fields'=>array('sum((Reglementclient.Montant)) as solde'),    
            'conditions' => array(@$condbbs,$condr3,$condr6,"Reglementclient.emi!='052'"),'recursive'=>0 ));
            if(!empty($soldereg)){
                $solde=$solde-$soldereg[0]['solde'];
            }
            $soldepiece=ClassRegistry::init('Piecereglementclient')->find('first', array(
            'fields'=>array('sum(Piecereglementclient.montant) as solde'),    
            'conditions' => array(@$condbbs,$condr3,$condr6,'Piecereglementclient.paiement_id in (2,3)','Piecereglementclient.situation="Impayé"'),'recursive'=>0 ));
            if(!empty($soldepiece)){
                $solde=$solde+$soldepiece[0]['solde'];
                
            }
            $soldetransfert=ClassRegistry::init('Transfert')->find('first', array(
            'fields'=>array('sum(Transfert.totttc) as solde'),    
            'conditions' => array(@$condtrs,$condtr3,$condtr6,'Transfert.fact_vente=0'),'recursive'=>0 ));
            if(!empty($soldetransfert)){
                $solde=$solde+$soldetransfert[0]['solde'];
                
            }    
            $soldeint=$client['Client']['solde']+$solde;
            $totsolde=$totsolde+$soldeint;
            $sld=$soldeint;
            
            $soldeencours=$soldeencours+$soldeint;
            
            if($relefe['Relefe']['debit']!=null) {
        $sld=$sld+$relefe['Relefe']['debit'];
        }else{
        $sld=$sld-$relefe['Relefe']['credit'];
        } 
        $totsoldet=$totsoldet+@$sld;
        
        


?> 
<tr>
    <td style="background-color: #F2D7D5;" align="center"><strong> Client </strong></td>    <td colspan="8"  ><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo @$relefe['Client']['code']."  ".@$relefe['Client']['name']; ?></strong></td>
</tr>
<tr>
    <td style="background-color: #F2D7D5;" align="center" colspan="3"><strong> Solde départ </strong></td>
    <td   align="right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php  if($soldeint>=0) {echo number_format(@$soldeint,3, '.', ' ');} else {echo " ";} ?></strong></td>
     <td   align="right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php  if($soldeint<0) {echo @$soldeint*(-1);} else {echo " ";} ?></strong></td>
     <td align="right"></td><td></td><td></td>
      <td   align="right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php  if($soldeint<0) {echo @$soldeint*(-1);} else {echo number_format(@$soldeint,3, '.', ' ');} ?></strong></td>
</tr>
<?php } 
$clt_id=$relefe['Client']['id'];


        
        $totdebitt=$totdebitt+@$relefe['Relefe']['debit'];
        $totcreditt=$totcreditt+@$relefe['Relefe']['credit'];
        $totimpayert=$totimpayert+@$relefe['Relefe']['impaye'];
        $totregt=$totregt+@$relefe['Relefe']['reglement'];
        $totavoirt=$totavoirt+@$relefe['Relefe']['avoir'];
        
        $soldeencours=$soldeencours+@$relefe['Relefe']['solde'];

        
        //debug($sld);
?>


	<tr>
		<td align="center" style="width: 97px;"><?php echo date("d/m/Y",strtotime(str_replace('/','-',@$relefe['Relefe']['date'])))  ;?></td>
		<td align="center" style="width: 138px;"><?php echo @$relefe['Relefe']['numero'] ;?></td>
                <td align="left" style="width: 198px;"><?php echo @$relefe['Relefe']['type'] ;?></td>
                <td align="right" style="width: 118px;"><?php echo number_format(@$relefe['Relefe']['debit'],3, '.', ' ') ;?></td>
                <td align="right" style="width: 106px;"><?php echo number_format(@$relefe['Relefe']['credit'],3, '.', ' ') ;?></td>
                <td align="right" style="width: 105px;"><?php echo number_format(@$relefe['Relefe']['impaye'],3, '.', ' ') ;?></td>
                <td align="right" style="width: 105px;"><?php echo number_format(@$relefe['Relefe']['reglement'],3, '.', ' ');?></td>
                <td align="right" style="width: 96px;"><?php echo number_format(@$relefe['Relefe']['avoir'],3, '.', ' ') ;?></td>
                <td align="right" style="width: 117px;"><?php echo number_format(@$soldeencours,3, '.', ' ') ;?></td>
	</tr>
        <?php 
        $totdebit=$totdebit+@$relefe['Relefe']['debit'];
        $totcredit=$totcredit+@$relefe['Relefe']['credit'];
        $totimpayer=$totimpayer+@$relefe['Relefe']['impaye'];
        $totreg=$totreg+@$relefe['Relefe']['reglement'];
        $totavoir=$totavoir+@$relefe['Relefe']['avoir'];
        $totsolde=$totsolde+@$relefe['Relefe']['solde'];
        ?>
<?php } ?>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<tr>
    <td colspan="3" style="background-color: #F2D7D5;" align="center"><strong> Total  </strong></td>    
    <td  align="right"><strong><?php  echo number_format(@$totdebit,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totcredit,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totimpayer,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totreg,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totavoir,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totsolde,3, '.', ' '); ?></strong></td>
</tr>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<tr>
    <td colspan="3" style="background-color: #F2D7D5;" align="center"><strong> Total Général </strong></td>    
    <td  align="right"><strong><?php  echo number_format(@$totdebitt,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totcreditt,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totimpayert,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totregt,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totavoirt,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totsolde,3, '.', ' '); ?></strong></td>
</tr>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


