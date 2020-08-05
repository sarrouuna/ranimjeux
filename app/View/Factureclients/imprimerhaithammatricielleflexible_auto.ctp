<?php
function chifre_en_lettre($montant, $devise1, $devise2)
{
 if(($devise1==1)) $dev1='Dinars';
 if(($devise1==2)) $dev1='Dollars';
 if(($devise1==3)) $dev1='Euro';
 if(($devise1==1)) $dev2='Millimes';
 if(($devise1==2)) $dev2='Cents';
 if(($devise1==3)) $dev2='Centimes';
 $valeur_entiere=intval($montant);
 $valeur_decimal=(($montant-intval($montant))*1000);
 $dix_c=($valeur_decimal%100/10);
 $cent_c=intval($valeur_decimal%1000/100);
 $unite_c=$valeur_decimal%10;
 $unite[1]=$valeur_entiere%10;
 $dix[1]=intval($valeur_entiere%100/10);
 $cent[1]=intval($valeur_entiere%1000/100);
 $unite[2]=intval($valeur_entiere%10000/1000);
 $dix[2]=intval($valeur_entiere%100000/10000);
 $cent[2]=intval($valeur_entiere%1000000/100000);
 $unite[3]=intval($valeur_entiere%10000000/1000000);
 $dix[3]=intval($valeur_entiere%100000000/10000000);
 $cent[3]=intval($valeur_entiere%1000000000/100000000);
 //echo $unite_c;
 $chif=array('', 'Un', 'Deux', 'Trois', 'Quatre', 'Cinq', 'Six', 'Sept', 'Huit', 'Neuf', 'Dix', 'Onze', 'Douze', 'Treize', 'Quatorze', 'Quinze', 'Seize', 'Dix-sept', 'Dix-huit', 'Dix-neuf');
  $secon_c='';
  $trio_c='';
 for($i=1; $i<=3; $i++){
  $prim[$i]='';
  $secon[$i]='';
  $trio[$i]='';
  if($dix[$i]==0){
   $secon[$i]='';
   $prim[$i]=$chif[$unite[$i]];
  }
  else if($dix[$i]==1){
   $secon[$i]='';
   $prim[$i]=$chif[($unite[$i]+10)];
  }
  else if($dix[$i]==2){
   if($unite[$i]==1){
   $secon[$i]='Vingt et';
   $prim[$i]=$chif[$unite[$i]];
   }
   else {
   $secon[$i]='Vingt';
   $prim[$i]=$chif[$unite[$i]];
   }
  }
  else if($dix[$i]==3){
   if($unite[$i]==1){
   $secon[$i]='Trente et';
   $prim[$i]=$chif[$unite[$i]];
   }
   else {
   $secon[$i]='Trente';
   $prim[$i]=$chif[$unite[$i]];
   }
  }
  else if($dix[$i]==4){
   if($unite[$i]==1){
   $secon[$i]='Quarante et';
   $prim[$i]=$chif[$unite[$i]];
   }
   else {
   $secon[$i]='Quarante';
   $prim[$i]=$chif[$unite[$i]];
   }
  }
  else if($dix[$i]==5){
   if($unite[$i]==1){
   $secon[$i]='Cinquante et';
   $prim[$i]=$chif[$unite[$i]];
   }
   else {
   $secon[$i]='Cinquante';
   $prim[$i]=$chif[$unite[$i]];
   }
  }
  else if($dix[$i]==6){
   if($unite[$i]==1){
   $secon[$i]='Soixante et';
   $prim[$i]=$chif[$unite[$i]];
   }
   else {
   $secon[$i]='Soixante';
   $prim[$i]=$chif[$unite[$i]];
   }
  }
  else if($dix[$i]==7){
   if($unite[$i]==1){
   $secon[$i]='Soixante et';
   $prim[$i]=$chif[$unite[$i]+10];
   }
   else {
   $secon[$i]='Soixante';
   $prim[$i]=$chif[$unite[$i]+10];
   }
  }
  else if($dix[$i]==8){
   if($unite[$i]==1){
   $secon[$i]='Quatre-vingts et';
   $prim[$i]=$chif[$unite[$i]];
   }
   else {
   $secon[$i]='Quatre-vingts';
   $prim[$i]=$chif[$unite[$i]];
   }
  }
  else if($dix[$i]==9){
   if($unite[$i]==1){
   $secon[$i]='Quatre-vingts et';
   $prim[$i]=$chif[$unite[$i]+10];
   }
   else {
   $secon[$i]='Quatre-vingts';
   $prim[$i]=$chif[$unite[$i]+10];
   }
  }
  if($cent[$i]==1) $trio[$i]='Cent';
  else if($cent[$i]!=0 || $cent[$i]!='') $trio[$i]=$chif[$cent[$i]] .' Cents';
 }
 $v="";
 
$chif2=array('', 'Dix', 'Vingt', 'Trente', 'Quarante', 'Cinquante', 'Soixante', 'Soixante-dix', 'Quatre-vingts', 'Quatre-vingt-dix');
 $secon_c=$chif2[$dix_c];
 if($cent_c==1) $trio_c='Cent';
 else if($cent_c!=0 || $cent_c!='') $trio_c=$chif[$cent_c] .' Cents';
 
 if(($cent[3]==0 || $cent[3]=='') && ($dix[3]==0 || $dix[3]=='') && ($unite[3]==1)) 
  $v=$v.' '. $trio[3]. '  ' .$secon[3]. ' ' . $prim[3]. ' Million ';
 else if(($cent[3]!=0 && $cent[3]!='') || ($dix[3]!=0 && $dix[3]!='') || ($unite[3]!=0 && $unite[3]!=''))
  $$v=$v.' '. $trio[3]. ' ' .$secon[3]. ' ' . $prim[3]. ' Millions ';
 else
  $v=$v.' '. $trio[3]. ' ' .$secon[3]. ' ' . $prim[3];
 
 if(($cent[2]==0 || $cent[2]=='') && ($dix[2]==0 || $dix[2]=='') && ($unite[2]==1)) 
  $v=$v.' '. ' Mille ';
 else if(($cent[2]!=0 && $cent[2]!='') || ($dix[2]!=0 && $dix[2]!='') || ($unite[2]!=0 && $unite[2]!=''))
  $v=$v.' '. $trio[2]. ' ' .$secon[2]. ' ' . $prim[2]. ' Milles ';
 else
  $v=$v.' '. $trio[2]. ' ' .$secon[2]. ' ' . $prim[2];
 
 $v=$v. $trio[1]. ' ' .$secon[1]. ' ' . $prim[1];
 
 $v=$v. ' '. $dev1 .' ' ;
 
 if(($cent_c=='0' || $cent_c=='') && ($dix_c=='0' || $dix_c==''))
  $v=$v.' '. ' et z&eacute;ro '. $dev2;
 else
  $v=$v.' et '.round( $valeur_decimal,0). ' ' . $dev2;
return $v;
} 

$lborder='border="0"';
ob_start();
//$ModelSociete = ClassRegistry::init('Societe');
//$soc = $ModelSociete->find('first',array('conditions'=>array('Societe.id'=>1),'recursive'=>-1));
$styl_cadr='style="border-left:1px solid black;border-right:1px solid black;"';
?>
<style type="text/css">
    .div1 { color: #000000; width: 90mm; margin: 1mm; border: solid 1px black; border-radius: 3mm;font-size: 3.3mm;padding:3mm; -moz-border-radius: 1mm; vertical-align: middle }
    .div2 { color: #000000; width: 96mm; margin: 1mm; border: solid 1px black; border-radius: 3mm;font-size: 3.3mm;padding-top:3mm;padding-bottom:3mm; -moz-border-radius: 1mm; vertical-align: middle }
    .divfooter1 { color: #000000; width: 49mm; height: 30mm; margin: 1mm; border: solid 1px black; border-radius: 3mm;font-size: 3.5mm;padding-top:3mm; -moz-border-radius: 1mm; }
    .divfooter11 { color: #000000; width: 40mm; height: 20mm; margin: 1mm; border: solid 1px black; border-radius: 3mm;font-size: 3.5mm;padding:3mm; -moz-border-radius: 1mm; }
    .divfooter2 { color: #000000;  height: 15mm; margin: 1mm; border: solid 1px black; border-radius: 3mm;font-size: 3.5mm;padding:3mm; -moz-border-radius: 1mm; }
    .style_th { vertical-align: middle;border-bottom: solid 1px #000000;text-align: center;height: 6mm;border-left:solid 1px black; }
    .style_th1 { vertical-align: middle;border-bottom: solid 1px #000000;text-align: center;height: 6mm; }
    .style_td { border-left: solid 1px #000000;}
    .style_td1 { padding-left: 2mm;height: 5mm}
</style>

<?php  
foreach ($factureclients as $i=>$factureclient){  ?>


<page backtop="78mm" backbottom="110mm" pagegroup="new">
   <page_header style="margin-top: 31mm;" >
    <table <?php echo $lborder ?> cellspacing="0"   style=" width: 100%; margin: 1mm; font-size: 3.5mm;">
        <tr>
            <td style="width: 55%;">
                <table cellspacing="0" style=" width: 100%; margin: 1mm; font-size: 3.3mm; ">
                    <tr><td align="center" style="font-size:5mm;padding-left: 17mm;"><strong ><?php echo $designation ;?> <?php echo @$factureclient[$model]['numero'] ?></strong></td></tr>
                    <tr><td style="height: 4mm;" ></td></tr>
                    <tr><td style="padding-left: 30mm;height: 5mm;" ><?php echo date("d/m/Y", strtotime(str_replace('-', '/',  @$factureclient[$model]['date']))) ?></td></tr>
                    <tr><td style="padding-left: 35mm;height: 3mm;" ><?php echo @$factureclient['Client']['code'] ?></td></tr>
                    <tr><td style="padding-left: 60mm;height: 5mm;" ><strong>N&deg; Page: [[page_cu]]/[[page_nb]] </strong></td></tr>
                </table>
                
            </td>
            
            <td style="width: 45%;">
                <table cellspacing="0" style=" width: 100%; margin: 1mm; font-size: 3.3mm; ">
                    <tr><td style="width: 100%;height: 6mm;" colspan="2"><strong style="font-size:4mm;"><?php echo @$factureclient[$model]['name'] ?></strong></td></tr>
                    <tr><td style="width: 100%;height: 6mm;" colspan="2">&nbsp;<?php echo @$factureclient['Client']['adresse'] ?></td></tr>
                    <tr>
                        <td style="width: 40%;height: 6mm;"><?php echo @$factureclient['Client']['tel'] ?></td>
                        <td style="width: 60%;height: 6mm;"><?php echo @$factureclient['Client']['matriculefiscale'] ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td style="height: 2mm;" colspan="2" ></td></tr>
    </table>
    
  
    </page_header>
    
    
    
    <table cellspacing="0" <?php echo $lborder ?>  style=" width: 100%; margin-left: 3mm; font-size: 3.5mm;">
        
        <?php 
       // debug($lignefactureclients);die;
         $kk=0;$bl=0;
         $objj = ClassRegistry::init('Lignefactureclient');
         $ligne=$objj->find('all',array('conditions'=>array('Lignefactureclient.factureclient_id'=>$factureclient['Factureclient']['id']),'recursive'=>0, 'order' => array('Bonlivraison.numero' => 'asc')));
        foreach ($ligne as $i=>$lr){
        $kk++;
        if ($lr['Lignefactureclient']['bonlivraison_id']!=$bl){     ?>
        
            <tr>
                <td style="width: 14%;height: 5mm"></td>
                <td style="width: 41%;"><strong><?php echo $lr['Bonlivraison']['numero'];?></strong></td>
                <td style="width: 8%;" align="center"></td>
                <td style="width: 11%; " align="right"></td>
                <td style="width: 6%;" align="center"></td>
                <td style="width: 6%;" align="center"></td>
                <td style="width: 11%;" align="right"></td>
            </tr>
        <?php
        $kk++;
        }     
        $bl=$lr['Lignefactureclient']['bonlivraison_id'];
        
            ?>
            <tr>
                <td style="width: 14%;height: 5mm"><?php echo substr(@$lr['Article']['code'],0,13) ?></td>
                <td style="width: 41%;"><?php echo substr(@$lr['Lignefactureclient']['designation'],0,35) ?></td>
                <td style="width: 8%;" align="center"><?php echo @$lr['Lignefactureclient']['quantite'] ?></td>
                <td style="width: 11%; " align="right"><?php echo @$lr['Lignefactureclient']['prix'] ?>&nbsp;</td>
                <td style="width: 6%;" align="center"><?php echo number_format(@$lr['Lignefactureclient']['tva'],2, '.', ' '); ?></td>
                <td style="width: 6%;" align="center"><?php echo number_format(@$lr['Lignefactureclient']['remise'],2, '.', ' ') ?></td>
                <td style="width: 11%;" align="right"><?php echo number_format(@$lr['Lignefactureclient']['totalht'],3, '.', ' ') ?></td>
            </tr>
        <?php } ?>
    </table>
    
    
</page>


<page_footer >
    <table cellspacing="0" <?php echo $lborder ?> style="width: 100%; margin: 1mm;font-size: 4mm; ">
        <tr>
            <td  style="width: 50%;vertical-align: central;" >
                <br><br>
                <table style="width: 100%;" border="0">
                    <?php $obj = ClassRegistry::init($ligne_model);
                    $lignefactureclientstva = $obj->find('all',array('fields'=>array(
                    'SUM(('.$ligne_model.'.totalht*'.$ligne_model.'.tva)/100)  mtva'
                    ,'SUM('.$ligne_model.'.totalht) totalht'
                    ,'AVG('.$ligne_model.'.tva) tva'),
                    'conditions'=>array($ligne_model.'.'.$attribut => $factureclient[$model]['id'])
                    ,'group'=>array($ligne_model.'.tva')       
                    ));
                    $tva=0;
                    foreach ($lignefactureclientstva as $i=>$lr){ ?>
                        <tr>
                            <td style="width: 31%;" align="center"><strong><?php echo number_format($lr[0]['totalht'],3, '.', ' ') ?></strong></td>
                            <td style="width: 22%;" align="center"><strong><?php echo sprintf('%.0f',$lr[0]['tva']); ?>%</strong></td>
                            <td style="width: 50%;" align="center"><strong><?php echo number_format($lr[0]['mtva'],3, '.', ' ') ?></strong></td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
            
            
            
            <td  style="width: 45%;" align="right">
                <table style="width: 100%;font-size: 3.6mm;">
                    <tr><td style="width: 100%;" ><strong><?php echo number_format($factureclient[$model]['totalht']+$factureclient[$model]['remise'],3, '.', ' ') ?></strong>&nbsp;&nbsp;</td></tr>
                    <tr><td><strong><?php echo number_format($factureclient[$model]['remise'],3, '.', ' ') ?></strong>&nbsp;&nbsp;</td></tr>
                    <tr><td ><strong><?php echo number_format($factureclient[$model]['totalht'],3, '.', ' ') ?></strong>&nbsp;&nbsp;</td></tr>
<!--                    <tr><td>&nbsp;</td></tr>-->
                    <tr><td style="height: 3mm"><strong><?php echo number_format($factureclient[$model]['tva'],3, '.', ' ') ?></strong>&nbsp;&nbsp;</td></tr>
<!--                    <tr><td>&nbsp;</td></tr>-->
                    <tr><td style="height: 8.5mm;vertical-align:bottom;"><strong><?php echo number_format($factureclient[$model]['timbre_id'],3, '.', ' ') ?></strong>&nbsp;&nbsp;</td></tr>
                    <tr><td style="height: 7mm;font-size: 5mm;vertical-align: top;"><strong><?php echo number_format($factureclient[$model]['totalttc'],3, '.', ' ') ?></strong>&nbsp;&nbsp;</td></tr>
                    
                </table>
            </td>
                
        </tr>
        <?php 
        if($factureclient[$model]['typeclient_id']==2){
        $exono = ClassRegistry::init('Exonorationclient')->find('first', array('conditions' => (array(
        'Exonorationclient.client_id' => @$factureclient['Client']['id'], 
        'Exonorationclient.datedu <= ' => $factureclient[$model]['date'], 
        'Exonorationclient.dateau >= ' => $factureclient[$model]['date'])), 
        'recursive' => -1));
        }
        ?>
        <tr>
            <td colspan="2" style="vertical-align: top;" >
                <strong style="font-size:5mm;margin-left: 20mm;">Arreter la présente Facture Client à  la somme de :</strong><br>
                <strong style="font-size:4mm;margin-left: 15mm;"><?php echo chifre_en_lettre($factureclient[$model]['totalttc'], 1, 1); ?></strong><br>
                <?php if($factureclient[$model]['typeclient_id']==2){ 
                  if(!empty($exono)){  
                    ?>
                <strong style="font-size:5mm;margin-left: 20mm;">N° Exo : <?php echo $exono['Exonorationclient']['num_exe'] ?> 
                Du : <?php echo date("d/m/Y", strtotime(str_replace('-', '/',  $exono['Exonorationclient']['datedu']))) ?> 
                Au : <?php echo date("d/m/Y", strtotime(str_replace('-', '/',  $exono['Exonorationclient']['dateau']))) ?>
                </strong>
                <?php }} ?>
            </td>           
        </tr>
        
        <tr><td colspan="2" style="height: 50mm;" ></td></tr>
        
        
    </table>
    
</page_footer>
  
    
<?php } ?>    
    
    
    
    <?php
    $content = ob_get_clean();
    APP::import("Vendor", "html2pdf/html2pdf");
    try
    {
        $html2pdf = new HTML2PDF('P', 'PA4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $html2pdf->Output('FC_matricielle.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
    ?>