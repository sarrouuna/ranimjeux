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
                echo $this->Form->input('fournisseur_id',array('id'=>'client_id','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez choisir..') );			
	?></div>
  <div class="col-md-6"> 
       	<?php 
        echo $this->Form->input('date2',array('label'=>'Date fin','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
        echo $this->Form->input('personnel_id',array('id'=>'personnel_id','label'=>'Personnel','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'Veuillez choisir..') );
        // echo $this->Form->input('exercice_id',array('value'=>@$exerciceid,'empty'=>'veuillez choisir','div'=>'form-group','label'=>'année','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
        ?>
  </div>   

                <div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3" >
                                                <button  id="breleve" type="submit" class="btn btn-primary testhistoriquearticle" >Afficher</button> 
       <a  onClick="flvFPW1(wr+'Relevefournisseurs/imprimerrecherche?date1=<?php echo @$date1;?>&date2=<?php echo @$date2;?>&name=<?php echo @$name;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                                            </div>
                                        </div>
 
<?php echo $this->Form->end();?>

</div>
                            </div>
                        </div>

<?php 

                foreach ($factureavoirs as $factureavoir) {
               // $sld=$sld-$factureavoir['Factureavoirfr']['totalttc'];
                $tablignedevis['fournisseur_id']=$factureavoir['Factureavoirfr']['fournisseur_id'];
                $tablignedevis['date']=$factureavoir['Factureavoirfr']['date'];
                $tablignedevis['numero']=$factureavoir['Factureavoirfr']['numero'];
                $tablignedevis['type']="Factureavoir";
                $tablignedevis['debit']="";
                $tablignedevis['echeance']="";
                $tablignedevis['typ']="FR";
                $tablignedevis['credit']=(-1)*$factureavoir['Factureavoirfr']['totalttc'];
                //$tablignedevis['solde']=$sld;
                $obj = ClassRegistry::init('Relevefournisseur');
                $obj->create();
                $obj->save($tablignedevis);
                }
                foreach ($bonlivraisons as $bonlivraison) {
                //$sld=$sld+$factureavoir['Bonreception']['totalttc'];
                //$tablignelivraisons['numclt']=$bonlivraison['Client']['code'];
                $tablignelivraisons['fournisseur_id']=$bonlivraison['Bonreception']['fournisseur_id'];
                $tablignelivraisons['date']=$bonlivraison['Bonreception']['date'];
                $tablignelivraisons['numero']=$bonlivraison['Bonreception']['numero'];
                $tablignelivraisons['type']="Bonreception";
                $tablignelivraisons['debit']="";
                $tablignelivraisons['credit']=$bonlivraison['Bonreception']['totalttc'];
                $tablignelivraisons['impaye']="";
                $tablignelivraisons['echeance']="";
                $tablignelivraisons['reglement']="";
                $tablignelivraisons['typ']="BL";
                $tablignelivraisons['avoir']="";
                //$tablignelivraisons['solde']=$sld;
                $obj = ClassRegistry::init('Relevefournisseur');
                $obj->create();
                $obj->save($tablignelivraisons);
                }
                foreach ($factureclients as $factureclient) {
               // $sld=$sld+$factureclient['Facture']['totalttc'];
                $tablignefactureclients['fournisseur_id']=$factureclient['Facture']['fournisseur_id'];
                $tablignefactureclients['date']=$factureclient['Facture']['date'];
                $tablignefactureclients['numero']=$factureclient['Facture']['numero'];
                $tablignefactureclients['type']="Facture";
                $tablignefactureclients['debit']="";
                $tablignefactureclients['credit']=$factureclient['Facture']['totalttc'];
                $tablignefactureclients['impaye']="";
                $tablignefactureclients['echeance']="";
                $tablignefactureclients['reglement']="";
                $tablignefactureclients['avoir']="";
                 $tablignefactureclients['typ']="Fac";
               // $tablignefactureclients['solde']=$sld;
                $obj = ClassRegistry::init('Relevefournisseur');
                $obj->create();
                $obj->save($tablignefactureclients);
                }

                foreach ($piecereglements as $piecereglement) {
                // $sld=$sld-$piecereglement['Piecereglement']['montant'];
                //$tablignepiecereglements['numclt']=$piecereglement['Client']['code'];
                $tablignepiecereglements['fournisseur_id']=$piecereglement['Reglement']['fournisseur_id'];
                $tablignepiecereglements['date']=$piecereglement['Reglement']['Date'];
                $tablignepiecereglements['numero']=$piecereglement['Reglement']['numeroconca']." / ".$piecereglement['Reglement']['exercice_id'];
                $tablignepiecereglements['type']="Reglement ".$piecereglement['Paiement']['name'];
                $tablignepiecereglements['debit']=$piecereglement['Piecereglement']['montant'];
                $tablignepiecereglements['credit']="";
                 $tablignepiecereglements['echeance']=$piecereglement['Piecereglement']['echance'];
                $tablignepiecereglements['impaye']="";
                $tablignepiecereglements['reglement']="";
                $tablignepiecereglements['avoir']="";
                $tablignereglementlibres['typ']="Reg";
               // $tablignepiecereglements['solde']=$sld;
                $objr = ClassRegistry::init('Relevefournisseur');
                $objr->create();
                $objr->save($tablignepiecereglements);
                }
                
                  foreach ($piecereglementimps as $piecereglementimp) {
                
                $tablignepiecereglementimps['fournisseur_id']=$piecereglementimp['Reglement']['fournisseur_id'];
                $tablignepiecereglementimps['date']=$piecereglementimp['Reglement']['Date'];
                $tablignepiecereglementimps['numero']=$piecereglementimp['Reglement']['numeroconca']." / ".$piecereglementimp['Reglement']['exercice_id'];
                $tablignepiecereglementimps['type']="Reglement ".$piecereglementimp['Paiement']['name'];
                $tablignepiecereglementimps['debit']=(-1)*$piecereglementimp['Piecereglement']['montant'];
                $tablignepiecereglementimps['credit']="";
                $tablignepiecereglementimps['echeance']=$piecereglementimp['Piecereglement']['echance'];
                $tablignepiecereglementimps['impaye']="";
                $tablignepiecereglementimps['reglement']="";
                $tablignepiecereglementimps['avoir']="";
                $tablignereglementlibres['typ']="Reg";
               // $tablignepiecereglements['solde']=$sld;
                $objr = ClassRegistry::init('Relevefournisseur');
                $objr->create();
                $objr->save($tablignepiecereglementimps);
                }



     $obreq = ClassRegistry::init('Relevefournisseur');
     $relefes=$obreq->find('all', array('order'=>array('Relevefournisseur.date,Relevefournisseur.typ'=>'asc'),'recursive'=>0 ));
     
   //debug($relefesfin);die;

?>
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Etat de solde fournisseur'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                                     <table class="table table-bordered table-striped table-bottomless" id="" style="border:2px solid black;">
                      <thead>
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
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>Libellé Piece</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5"><strong><center>Echéance</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5"><strong><center>N° Piece</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>Dédit</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>Crédit</center></strong></th>
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
        
        $sld=$sldini;
        foreach ($relefes as $i=>$relefe){ 
        if($relefe['Relevefournisseur']['debit']!=null) {
           // debug("debit");die;
         $sld=$sld-$relefe['Relevefournisseur']['debit'];
        }   else{
            // debug("credit");die;
             $sld=$sld+$relefe['Relevefournisseur']['credit'];
        } 
        
            
            
        $totdebitt=$totdebitt+@$relefe['Relevefournisseur']['debit'];
        $totcreditt=$totcreditt+@$relefe['Relevefournisseur']['credit'];
        $totimpayert=$totimpayert+@$relefe['Relevefournisseur']['impaye'];
        $totregt=$totregt+@$relefe['Relevefournisseur']['reglement'];
        $totavoirt=$totavoirt+@$relefe['Relevefournisseur']['avoir'];
        $totsoldet=$totsoldet+@$relefe['Relevefournisseur']['solde'];
        ?>




<?php if ($relefe['Fournisseur']['id']!=$clt_id){ ?>

<tr>
    <td style="background-color: #F2D7D5;" align="center"><strong> Fournisseur </strong></td>    <td colspan="8"  ><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo @$relefe['Fournisseur']['code']."  ".@$relefe['Fournisseur']['name']; ?></strong></td>
</tr>
<!--<tr>
    <td style="background-color: #F2D7D5;" align="center"><strong> Solde initial </strong></td>    <td colspan="8"  ><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo sprintf('%.3f',@$sldini); ?></strong></td>
</tr>-->
<tr>
    <td style="background-color: #F2D7D5;"></td>
    <td style="background-color: #F2D7D5;" align="center"><strong> Solde départ </strong></td> <td style="background-color: #F2D7D5;"></td> <td style="background-color: #F2D7D5;"></td>
    <td   align="right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php  if($sldini<0) {echo @$sldini*(-1);} else {echo " ";} ?></strong></td>
     <td   align="right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php  if($sldini>=0) {echo @$sldini;} else {echo " ";} ?></strong></td>
      <td   align="right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php  if($sldini<0) {echo @$sldini*(-1);} else {echo @$sldini;} ?></strong></td>
</tr>
<?php } 
$clt_id=$relefe['Fournisseur']['id'];
?>


	<tr>
		<td align="center"><?php echo date("d-m-Y",strtotime(str_replace('/','-',@$relefe['Relevefournisseur']['date'])))  ;?></td>
		<td align="center"><?php echo @$relefe['Relevefournisseur']['type'] ;?></td>
                <td align="left"><?php echo @$relefe['Relevefournisseur']['echeance'] ;?></td>
                <td align="right"><?php echo @$relefe['Relevefournisseur']['numero'] ;?></td>
                <td align="right"><?php echo @$relefe['Relevefournisseur']['debit'] ;?></td>
                <td align="right"><?php echo @$relefe['Relevefournisseur']['credit'] ;?></td>
                <td align="right"><?php echo sprintf('%.3f',@$sld) ;?></td>
	</tr>
        <?php 
        $totdebit=$totdebit+@$relefe['Relevefournisseur']['debit'];
        $totcredit=$totcredit+@$relefe['Relevefournisseur']['credit'];
        $totimpayer=$totimpayer+@$relefe['Relevefournisseur']['impaye'];
        $totreg=$totreg+@$relefe['Relevefournisseur']['reglement'];
        $totavoir=$totavoir+@$relefe['Relevefournisseur']['avoir'];
        $totsolde=$totsolde+@$relefe['Relevefournisseur']['solde'];
        //$sldfinal=@$relefe['Relevefournisseur']['solde'];
        ?>
<?php } ?>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<tr>
    <td colspan="4" style="background-color: #F2D7D5;" align="center"><strong> Total  </strong></td>    
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totdebit); ?></strong></td>
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totcredit); ?></strong></td>
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$sld); ?></strong></td>
</tr>
<!--<tr><td colspan="9" style="height: 10px;" ></td></tr>
<tr>
    <td colspan="3" style="background-color: #F2D7D5;" align="center"><strong> Total Général </strong></td>    
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totdebitt); ?></strong></td>
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totcreditt); ?></strong></td>
    <td  align="right"><strong><?php  echo sprintf('%.3f',@$totsoldet); ?></strong></td>
</tr>-->
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	




