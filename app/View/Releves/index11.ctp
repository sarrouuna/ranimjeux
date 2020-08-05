
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
                echo $this->Form->input('client_id',array('id'=>'client_id','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez choisir..') );			
	        
	?></div>
  <div class="col-md-6"> 
       	<?php 
        echo $this->Form->input('date2',array('label'=>'Date fin','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
        echo $this->Form->input('personnel_id',array('id'=>'personnel_id','label'=>'Personnel','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez choisir..') );
        //echo $this->Form->input('exercice_id',array('value'=>@$exerciceid,'empty'=>'veuillez choisir','div'=>'form-group','label'=>'année','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
?>
  </div>   

                <div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3" >
                                                <button  id="breleve" type="submit" class="btn btn-primary testhistoriquearticle" >Afficher</button> 
       <a  onClick="flvFPW1(wr+'Releves/imprimerrecherche?date1=<?php echo @$date1;?>&date2=<?php echo @$date2;?>&name=<?php echo @$name;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                                            </div>
                                        </div>
 
<?php echo $this->Form->end();?>

</div>
                            </div>
                        </div>

<?php 
//debug($factureavoirs);die;
                //debug($factureavoirs);die;
                foreach ($factureavoirs as $factureavoir) {
                //$tablignedevis['numclt']=$factureavoir['Client']['code'];
                $tablignedevis['client_id']=$factureavoir['Factureavoir']['client_id'];
                $tablignedevis['date']=$factureavoir['Factureavoir']['date'];
                $tablignedevis['numero']=$factureavoir['Factureavoir']['numero'];
                $tablignedevis['type']="Factureavoir";
                $tablignedevis['debit']="";
                $tablignedevis['credit']=$factureavoir['Factureavoir']['totalttc'];
                $tablignedevis['impaye']="";
                $tablignedevis['reglement']="";
                $tablignedevis['avoir']=$factureavoir['Factureavoir']['totalttc'];
                $tablignedevis['solde']=0-$factureavoir['Factureavoir']['totalttc'];
                $tablignedevis['exercice_id']=$factureavoir['Factureavoir']['exercice_id'];
                $tablignedevis['typ']="FR";
                $obj = ClassRegistry::init('Relefe');
                $obj->create();
                $obj->save($tablignedevis);
                }
                foreach ($bonlivraisons as $bonlivraison) {
                //$tablignelivraisons['numclt']=$bonlivraison['Client']['code'];
                $tablignelivraisons['client_id']=$bonlivraison['Bonlivraison']['client_id'];
                $tablignelivraisons['date']=$bonlivraison['Bonlivraison']['date'];
                $tablignelivraisons['numero']=$bonlivraison['Bonlivraison']['numero'];
                $tablignelivraisons['type']="Bonlivraison";
                $tablignelivraisons['debit']=$bonlivraison['Bonlivraison']['totalttc'];
                $tablignelivraisons['credit']="";
                $tablignelivraisons['impaye']="";
                $tablignelivraisons['reglement']=$bonlivraison['Bonlivraison']['Montant_Regler'];
                $tablignelivraisons['avoir']="";
                 $tablignelivraisons['typ']="BL";
                $tablignelivraisons['solde']=$bonlivraison['Bonlivraison']['totalttc']-$bonlivraison['Bonlivraison']['Montant_Regler'];
                $tablignelivraisons['exercice_id']=$bonlivraison['Bonlivraison']['exercice_id'];
                $obj = ClassRegistry::init('Relefe');
                $obj->create();
                $obj->save($tablignelivraisons);
                }
                foreach ($factureclients as $factureclient) {
                //$tablignefactureclients['numclt']=$factureclient['Client']['code'];
                $tablignefactureclients['client_id']=$factureclient['Factureclient']['client_id'];
                $tablignefactureclients['date']=$factureclient['Factureclient']['date'];
                $tablignefactureclients['numero']=$factureclient['Factureclient']['numero'];
                $tablignefactureclients['type']="Facture";
                $tablignefactureclients['debit']=$factureclient['Factureclient']['totalttc'];
                $tablignefactureclients['credit']="";
                $tablignefactureclients['impaye']="";
                $tablignefactureclients['reglement']=$factureclient['Factureclient']['Montant_Regler'];
                $tablignefactureclients['avoir']="";
                $tablignefactureclients['solde']=$factureclient['Factureclient']['totalttc']-$factureclient['Factureclient']['Montant_Regler'];
                $tablignefactureclients['exercice_id']=$factureclient['Factureclient']['exercice_id'];
                $tablignefactureclients['typ']="Fac";
                $obj = ClassRegistry::init('Relefe');
                $obj->create();
                $obj->save($tablignefactureclients);
                }



                foreach ($reglementlibres as $reglementlibre) {
                //$tablignereglementlibres['numclt']=$reglementlibre['Client']['code'];
                $tablignereglementlibres['client_id']=$reglementlibre['Reglementclient']['client_id'];
                $tablignereglementlibres['date']=$reglementlibre['Reglementclient']['Date'];
                $tablignereglementlibres['numero']=$reglementlibre['Reglementclient']['numero'];
                $liste="";
                $obj = ClassRegistry::init('Piecereglementclient');
                $Piecereglementclients=$obj->find('all', array('conditions'=>array('Piecereglementclient.reglementclient_id'=>$reglementlibre['Reglementclient']['id']),'recursive'=>-1 ));
                foreach ($Piecereglementclients as $k=>$Piece) {
                if($k==0){
                $liste=$liste."".$Piece['Piecereglementclient']['num'];
                }else{
                $liste=$liste.",".$Piece['Piecereglementclient']['num'];
                }
                }
                $tablignereglementlibres['type']=$liste;
                $tablignereglementlibres['debit']="";
                $tablignereglementlibres['credit']=$reglementlibre['Reglementclient']['Montant'];
                $tablignereglementlibres['impaye']="";
                $tablignereglementlibres['reglement']=$reglementlibre['Reglementclient']['montantaffecte'];
                $tablignereglementlibres['avoir']="";
                $tablignereglementlibres['solde']=$reglementlibre['Reglementclient']['montantaffecte']-$reglementlibre['Reglementclient']['Montant'];
                $tablignereglementlibres['exercice_id']=$reglementlibre['Reglementclient']['exercice_id'];
                 $tablignereglementlibres['typ']="Reg";
              $objr = ClassRegistry::init('Relefe');
//                $objr->create();
//                $objr->save($tablignereglementlibres);
                
                  if($reglementlibre['Reglementclient']['emi']!='052'){
                $objr->create();
                $objr->save($tablignereglementlibres);
                }
                
                
                
                } 


                foreach ($piecereglements as $piecereglement) {
                //$tablignepiecereglements['numclt']=$piecereglement['Client']['code'];
                $tablignepiecereglements['client_id']=$piecereglement['Reglementclient']['client_id'];
                $tablignepiecereglements['date']=$piecereglement['Reglementclient']['Date'];
                $tablignepiecereglements['numero']=$piecereglement['Reglementclient']['numero'];
                $tablignepiecereglements['type']=$piecereglement['Piecereglementclient']['num'];
                $tablignepiecereglements['debit']=$piecereglement['Piecereglementclient']['montant'];
                $tablignepiecereglements['credit']="";
                $tablignepiecereglements['impaye']=$piecereglement['Piecereglementclient']['montant'];
                $tablignepiecereglements['reglement']="";
                $tablignepiecereglements['avoir']="";
                $tablignepiecereglements['solde']=$piecereglement['Piecereglementclient']['montant'];
                $tablignepiecereglements['exercice_id']=$piecereglement['Reglementclient']['exercice_id'];
                $tablignepiecereglements['typ']="Reg";
                $objr = ClassRegistry::init('Relefe');
                $objr->create();
                $objr->save($tablignepiecereglements);
                }



     $obreq = ClassRegistry::init('Relefe');
     $relefes=$obreq->find('all', array('order'=>array('Relefe.date,Relefe.typ'=>'asc'),
     //'conditions' => array('Relefe.client_id'=>$clientid,@$c1,@$c2,@$c4,@$c5),    
     'recursive'=>0 ));
     
     if(!empty($clientid)){
     $clientttt=ClassRegistry::init('Client');
        $client=$clientttt->find('first', array('conditions' => array('Client.id'=>$clientid),'recursive'=>0 ));
        
        $soldeint=$client['Client']['solde']+$solde;
        
     }
     //debug($relefes);die;







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
    <td style="background-color: #F2D7D5;" align="center"><strong> Période </strong></td>    <td colspan="4" bgcolor="#F2D7D5" align="center"><strong><?php  echo @$date1; ?></strong></td><td align="center" colspan="4" bgcolor="#F2D7D5" ><strong><?php  echo @$date2; ?></strong></td>
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
                          <tr style="border:2px solid black;">
	         
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>Date</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5"><strong><center>N° Piece</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>Libellé Piece</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>Dédit</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>Crédit</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>Impayé</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>Règlement</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>Avoir</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>Solde</center></strong></th>
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
        $sld=$soldeint;
        foreach ($relefes as $i=>$relefe){ 
        $totdebitt=$totdebitt+@$relefe['Relefe']['debit'];
        $totcreditt=$totcreditt+@$relefe['Relefe']['credit'];
        $totimpayert=$totimpayert+@$relefe['Relefe']['impaye'];
        $totregt=$totregt+@$relefe['Relefe']['reglement'];
        $totavoirt=$totavoirt+@$relefe['Relefe']['avoir'];
        $totsoldet=$totsoldet+@$relefe['Relefe']['solde'];
        
        
        if($relefe['Relefe']['debit']!=null) {
           // debug("debit");die;
         $sld=$sld+$relefe['Relefe']['debit'];
        }   else{
            // debug("credit");die;
             $sld=$sld-$relefe['Relefe']['credit'];
        } 
        ?>




<?php if ($relefe['Client']['id']!=$clt_id){ ?>
<?php if($i!=0){ 
         ?>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<tr>
    <td colspan="3" style="background-color: #F2D7D5;" align="center"><strong> Total  </strong></td>    
    <td  align="right"><strong><?php  echo @$totdebit; ?></strong></td>
    <td  align="right"><strong><?php  echo @$totcredit; ?></strong></td>
    <td  align="right"><strong><?php  echo @$totimpayer; ?></strong></td>
    <td  align="right"><strong><?php  echo @$totreg; ?></strong></td>
    <td  align="right"><strong><?php  echo @$totavoir; ?></strong></td>
    <td  align="right"><strong><?php  echo @$totsolde; ?></strong></td>
</tr>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<?php   $totdebit=0;
        $totcredit=0;
        $totimpayer=0;
        $totreg=0; 
        $totavoir=0;
        $totsolde=0;
}?> 
<tr>
    <td style="background-color: #F2D7D5;" align="center"><strong> Client </strong></td>    <td colspan="8"  ><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo @$relefe['Client']['code']."  ".@$relefe['Client']['name']; ?></strong></td>
</tr>
<tr>
    <td style="background-color: #F2D7D5;" align="center" colspan="3"><strong> Solde départ </strong></td>
    <td   align="right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php  if($soldeint>=0) {echo @$soldeint;} else {echo " ";} ?></strong></td>
     <td   align="right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php  if($soldeint<0) {echo @$soldeint*(-1);} else {echo " ";} ?></strong></td>
     <td align="right"></td><td></td><td></td>
      <td   align="right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php  if($soldeint<0) {echo @$soldeint*(-1);} else {echo @$soldeint;} ?></strong></td>
</tr>
<?php } 
$clt_id=$relefe['Client']['id'];
?>


	<tr>
		<td align="center"><?php echo date("d-m-Y",strtotime(str_replace('/','-',@$relefe['Relefe']['date'])))  ;?></td>
		<td align="center"><?php echo @$relefe['Relefe']['numero'] ;?></td>
                <td align="left"><?php echo @$relefe['Relefe']['type'] ;?></td>
                <td align="right"><?php echo @$relefe['Relefe']['debit'] ;?></td>
                <td align="right"><?php echo @$relefe['Relefe']['credit'] ;?></td>
                <td align="right"><?php echo @$relefe['Relefe']['impaye'] ;?></td>
                <td align="right"><?php echo @$relefe['Relefe']['reglement'];?></td>
                <td align="right"><?php echo @$relefe['Relefe']['avoir'] ;?></td>
                <td align="right"><?php   echo sprintf('%.3f',@$sld) ;?></td>
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
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totdebit); ?></strong></td>
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totcredit); ?></strong></td>
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totimpayer); ?></strong></td>
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totreg); ?></strong></td>
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totavoir); ?></strong></td>
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totsolde+@$soldeint); ?></strong></td>
</tr>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<tr>
    <td colspan="3" style="background-color: #F2D7D5;" align="center"><strong> Total Général </strong></td>    
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totdebitt); ?></strong></td>
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totcreditt); ?></strong></td>
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totimpayert); ?></strong></td>
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totregt); ?></strong></td>
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totavoirt); ?></strong></td>
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totsoldet+@$soldeint); ?></strong></td>
</tr>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


