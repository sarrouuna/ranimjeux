<script language="JavaScript" type="text/JavaScript">

    function flvFPW1(){

        var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    } 
</script>
 <table  id="" style="border:2px solid black;" width="100%">
                <thead>
                <tr style="border:1px solid black;">
                 <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>code</center></strong></th>   
                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>client</center></strong></th>
                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>solde</center></strong></th>
                </tr>
                
                </thead><tbody>

    



	<?php //debug($all_clients);die;
        $solde=0;
        $soldetot=0;
        foreach ($all_clients as $i=>$all_client){
            
        $clientid= $all_client['Client']['id'];
        $condb3 = 'Bonlivraison.client_id ='.$clientid;
        $condf3 = 'Factureclient.client_id ='.$clientid;
        $condfa3='Factureavoir.client_id ='.$clientid;
        $condr3 = 'Reglementclient.client_id ='.$clientid;    
        $solde=$all_client['Client']['solde'];    
        
            $soldeavoir=ClassRegistry::init('Factureavoir')->find('first', array(
            'fields'=>array('sum(Factureavoir.totalttc) as solde'),    
            'conditions' => array(@$condfa1,@$condfa2,$condfa3),'recursive'=>0 ));
            //debug($soldeavoir);die;
            if(!empty($soldeavoir)){
                $solde=$solde-$soldeavoir[0]['solde'];
            }
            $soldebl=ClassRegistry::init('Bonlivraison')->find('first', array(
            'fields'=>array('sum((Bonlivraison.totalttc)) as solde'),    
            'conditions' => array(@$condb1,@$condb2,$condb3,'Bonlivraison.factureclient_id'=>0),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde+$soldebl[0]['solde'];
            }
            $soldefac=ClassRegistry::init('Factureclient')->find('first', array(
            'fields'=>array('sum((Factureclient.totalttc)) as solde'),    
            'conditions' => array(@$condf1,@$condf2,$condf3),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde+$soldefac[0]['solde'];
            }
            $soldereg=ClassRegistry::init('Reglementclient')->find('first', array(
            'fields'=>array('sum((Reglementclient.Montant)) as solde'),    
            'conditions' => array(@$condbb1,@$condbb2,$condr3,"Reglementclient.emi!='052'"),'recursive'=>0 ));
            if(!empty($soldereg)){
                $solde=$solde-$soldereg[0]['solde'];
            }
            $soldepiece=ClassRegistry::init('Piecereglementclient')->find('first', array(
            'fields'=>array('sum(Piecereglementclient.montant) as solde'),    
            'conditions' => array(@$condss1,@$condss2,$condr3,'Piecereglementclient.paiement_id in (2,3)','(Piecereglementclient.situation="Impayé" or Reglementclient.emi="052")'),'recursive'=>0 ));
            if(!empty($soldepiece)){
                $solde=$solde+$soldepiece[0]['solde'];
            }
            
            $soldetot=$soldetot+$solde;
        ?>


	<tr>
		<td align="left" style="border:1px solid black;"><?php echo $all_client['Client']['code']  ;?></td>
		<td align="left" style="border:1px solid black;"><?php echo $all_client['Client']['name']  ;?></td>
                <td align="right" style="border:1px solid black;"><?php echo @$solde ;?></td>
	</tr>
        
<?php } ?>

<tr>
    <td  style="background-color: #F2D7D5;" align="center"><strong> Total Général </strong></td>    
    <td  align="right"><strong><?php  echo @$soldetot; ?></strong></td>
</tr>
                          </tbody>
	</table>





<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel.php'));
header("Content-type: application/vnd.ms-excel");
 
header("Content-Disposition: attachment; filename=relevegeneral.xls");
?>