
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
                echo $this->Form->input('client_id',array('label'=>'client début','id'=>'client_id','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez choisir..') );			
	        
	?></div>
  <div class="col-md-6"> 
       	<?php 
        echo $this->Form->input('date2',array('label'=>'Date fin','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
        echo $this->Form->input('client2_id',array('label'=>'client fin','id'=>'client2_id','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez choisir..') );			
        //echo $this->Form->input('personnel_id',array('id'=>'personnel_id','label'=>'Personnel','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez choisir..') );
        //echo $this->Form->input('exercice_id',array('value'=>@$exerciceid,'empty'=>'veuillez choisir','div'=>'form-group','label'=>'ann�e','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
?>
  </div>   

                <div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3" >
                                                <button  id="breleve" type="submit" class="btn btn-primary " >Afficher</button> 
       <a  onClick="flvFPW1(wr+'Releves/imprimerexcel?date1=<?php echo @$date1;?>&date2=<?php echo @$date2;?>&clientid=<?php echo @$clientid;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
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
                                     <table class="table table-bordered table-striped table-bottomless" id="" style="border:2px solid black;" width="100%">
                <thead>
                <tr style="border:1px solid black;">
                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>Code</center></strong></th>
                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>Client</center></strong></th>
                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>Débit</center></strong></th>
                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>Crédit</center></strong></th>
                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>Solde</center></strong></th>
                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>date</center></strong></th>
                </tr>
                
                </thead><tbody>

    



	<?php //debug($lignecommandes);
        $solde=0;
        $soldetot=0;
        $solder=0;
        $soldetotr=0;
        $arraydate=array();
        foreach ($all_clients as $i=>$all_client){
        $test="";   
        $debit=0;
        $credit=0;
        $solde=0; 
        $clientid= $all_client['Client']['id'];
        $condb3 = 'Bonlivraison.client_id ='.$clientid;
        $condf3 = 'Factureclient.client_id ='.$clientid;
        $condfa3='Factureavoir.client_id ='.$clientid;
        $condr3 = 'Reglementclient.client_id ='.$clientid;    
        $solde=$all_client['Client']['solde'];
        //$solder=$all_client['Client']['solderecouvrement'];
        
        //debug($solder);
        
            $soldeavoir=ClassRegistry::init('Factureavoir')->find('first', array(
            'fields'=>array('sum(Factureavoir.totalttc) as solde','max(Factureavoir.date) as date'),    
            'conditions' => array(@$condfa1,@$condfa2,$condfa3),'recursive'=>0 ));
            //debug($soldeavoir);die;
            if(!empty($soldeavoir)){
                $solde=$solde-$soldeavoir[0]['solde'];
                $credit=$credit+$soldeavoir[0]['solde'];
                $arraydate[1]=$soldeavoir[0]['date'];
                
            }
            $soldebl=ClassRegistry::init('Bonlivraison')->find('first', array(
            'fields'=>array('sum((Bonlivraison.totalttc)) as solde','max(Bonlivraison.date) as date'),    
            'conditions' => array(@$condb1,@$condb2,$condb3,'Bonlivraison.factureclient_id'=>0),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde+$soldebl[0]['solde'];
                $debit=$debit+$soldebl[0]['solde'];
                $arraydate[2]=$soldebl[0]['date'];
            }
            $soldefac=ClassRegistry::init('Factureclient')->find('first', array(
            'fields'=>array('sum((Factureclient.totalttc)) as solde','max(Factureclient.date) as date'),    
            'conditions' => array(@$condf1,@$condf2,$condf3),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde+$soldefac[0]['solde'];
                $debit=$debit+$soldefac[0]['solde'];
                $arraydate[3]=$soldefac[0]['date'];
            }
            $soldereg=ClassRegistry::init('Reglementclient')->find('first', array(
            'fields'=>array('sum((Reglementclient.Montant)) as solde','max(Reglementclient.Date) as date'),    
            'conditions' => array(@$condbb1,@$condbb2,$condr3,"Reglementclient.emi!='052'"),'recursive'=>0 ));
            if(!empty($soldereg)){
                $solde=$solde-$soldereg[0]['solde'];
                $credit=$credit+$soldereg[0]['solde'];
                $arraydate[4]=$soldereg[0]['date'];
            }
            $soldepiece=ClassRegistry::init('Piecereglementclient')->find('first', array(
            'fields'=>array('sum(Piecereglementclient.montant) as solde','max(Piecereglementclient.datesituation) as date'),    
            'conditions' => array(@$condss1,@$condss2,$condr3,'Piecereglementclient.paiement_id in (2,3)','(Piecereglementclient.situation="Impayé" or Reglementclient.emi="052")'),'recursive'=>0 ));
            if(!empty($soldepiece)){
                $solde=$solde+$soldepiece[0]['solde'];
                $debit=$debit+$soldepiece[0]['solde'];
                $arraydate[5]=$soldepiece[0]['date'];
            }
            
            //$soldetot=$soldetot+$solde;
            
            
            //********* recouvrements
//            $rsoldeavoir=ClassRegistry::init('Factureavoir')->find('first', array(
//            'fields'=>array('sum(Factureavoir.totalttc-Factureavoir.montant_regle) as solde'),    
//            'conditions' => array('Factureavoir.totalttc != Factureavoir.montant_regle',@$condfa1,@$condfa2,$condfa3),'recursive'=>0 ));
//            //debug($rsoldeavoir);
//            if(!empty($rsoldeavoir)){
//                $solder=$solder-$rsoldeavoir[0]['solde'];
//            }
//            $rsoldebl=ClassRegistry::init('Bonlivraison')->find('first', array(
//            'fields'=>array('sum((Bonlivraison.totalttc)) as solde'),    
//            'conditions' => array(@$condb1,@$condb2,$condb3,'Bonlivraison.factureclient_id'=>0),'recursive'=>0 ));
//            //debug($rsoldebl);
//            if(!empty($rsoldebl)){
//                $solder=$solder+$rsoldebl[0]['solde'];
//            }
//            $rsoldefac=ClassRegistry::init('Factureclient')->find('first', array(
//            'fields'=>array('sum((Factureclient.totalttc-Factureclient.Montant_Regler)) as solde'),    
//            'conditions' => array('Factureclient.totalttc >Factureclient.Montant_Regler',@$condf1,@$condf2,$condf3),'recursive'=>0 ));
//            //debug($rsoldefac);
//            if(!empty($rsoldefac)){
//                $solder=$solder+$rsoldefac[0]['solde'];
//            }
//            $rsoldereg=ClassRegistry::init('Reglementclient')->find('first', array(
//            'fields'=>array('sum((Reglementclient.Montant-Reglementclient.montantaffecte)) as solde'),    
//            'conditions' => array('Reglementclient.Montant>Reglementclient.montantaffecte',@$condbb1,@$condbb2,$condr3,"Reglementclient.emi!='052'"),'recursive'=>0 ));
//            //debug($rsoldereg);
//            if(!empty($rsoldereg)){
//                $solder=$solder-$rsoldereg[0]['solde'];
//            }
//            $rsoldepiece=ClassRegistry::init('Piecereglementclient')->find('first', array(
//            'fields'=>array('sum(Piecereglementclient.montant-Piecereglementclient.mantantregler) as solde'),    
//            'conditions' => array('Piecereglementclient.montant>Piecereglementclient.mantantregler',@$condss1,@$condss2,$condr3,'Piecereglementclient.paiement_id in (2,3)','Piecereglementclient.situation="Impayé"'),'recursive'=>0 ));
//            //debug($rsoldepiece);
//            if(!empty($rsoldepiece)){
//                $solder=$solder+$rsoldepiece[0]['solde'];
//            }
//            
//            $soldetotr=$soldetotr+$solder;
//            
//            
//            
//         if(abs(@$solde-@$solder )>5.000)   {
//             $test="deff";
//         }
            
            
            
        ?>


	<tr>
		<td align="left" style="border:1px solid black;"><?php echo $all_client['Client']['code']  ;?></td>
		<td align="left" style="border:1px solid black;"><?php echo $all_client['Client']['name']  ;?></td>
                <td align="right" style="border:1px solid black;"><?php echo number_format(@$debit,3, '.', ' ') ;?></td>
                <td align="right" style="border:1px solid black;"><?php echo number_format(@$credit,3, '.', ' ') ;?></td>
                <td align="right" style="border:1px solid black;"><?php echo number_format(@$solde,3, '.', ' ');?></td>
                <td align="right" style="border:1px solid black;"><?php echo date("d/m/Y", strtotime(str_replace('/', '-', max($arraydate))));?></td>
        </tr>
        
<?php } ?>

<!--<tr>
    <td  style="background-color: #F2D7D5;" align="center" colspan="2"><strong> Total Général </strong></td>    
    <td  align="right"><strong><?php  echo number_format(@$soldetot,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$soldetotr,3, '.', ' '); ?></strong></td>
</tr>-->
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


