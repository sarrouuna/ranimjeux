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


ob_start();
$ModelSociete = ClassRegistry::init('Societe');
$soc = $ModelSociete->find('first');

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
<!--backbottom="50mm"-->
<page backtop="43mm"   >
    <page_header>
        <span style="font-size: 6mm;margin-left: 35mm"><strong>STE TUNISIENNE D'EQUIPEMENT MODERNE</strong></span>
        
        
        <table style=" width: 100%">
            <tr>
                <td style=" width: 40%;">
                    <table cellspacing="0" style=" width: 100%; margin: 1mm; border: solid 1px black; border-radius: 3mm;font-size: 3.3mm; -moz-border-radius: 1mm; vertical-align: middle ">
                        <tr>
                            <td class="style_td1" style="width: 100%;">
                                <br><span style="font-size: 6mm;margin-left: 25mm"><strong>SOTEM</strong></span>
                                <br><?php echo $soc['Societe']['adresse']; ?>
                                <br><strong>CODE TVA : </strong><?php echo $soc['Societe']['codetva']; ?>
                                <br><strong>TEL : </strong><?php echo $soc['Societe']['tel']; ?>
                                <br><strong>RIB : </strong><?php echo $soc['Societe']['rib']; ?>
                                <br><strong>RC : </strong><?php echo $soc['Societe']['rc']; ?>
                                <br><br>
                            </td>
                        </tr>
                    </table>
                </td>
                
                <td style=" width: 60%;">
                    <table style=" width: 100%">
                        <tr>
                            <td style="width: 20%;"></td>
                            <td style="width: 80%;">
                                <table cellspacing="0" style=" width: 100%; margin: 1mm; border: solid 1px black; border-radius: 3mm;font-size: 3.3mm; -moz-border-radius: 1mm; vertical-align: middle ">
                                    <tr>
                                        <td class="style_td1" style="width: 35%;">Facture N°</td>
                                        <td class="style_td" style="width: 35%;"><?php echo $factureclient['Factureclient']['numero'] ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 98%;" colspan="2">
                                <table cellspacing="0" style=" width: 100%; margin: 1mm; border: solid 1px black; border-radius: 3mm;font-size: 3.3mm; -moz-border-radius: 1mm; vertical-align: middle ">
                                    <tr>
                                        <td class="style_td1"  style="width: 100%;padding-top: 5mm">
                                            <strong>Code Client : </strong><?php echo $factureclient['Client']['code']; ?>
                                            <br><strong>Client : </strong><?php echo $factureclient['Client']['name']; ?>
                                            <br><strong>Adresse : </strong><?php echo $factureclient['Client']['adresse']; ?>
                                            <br><strong>Ville : </strong><?php echo $zone['Zone']['name']; ?>
                                            <br><strong>Mat.Fisc : </strong> <?php echo $factureclient['Client']['matriculefiscale']; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                    </table>
                    
                </td>
            </tr>
        </table>
        
        
         
        
        
         
    </page_header>
    
    
    
  

    
    <table cellspacing="0" style=" width: 100%; margin: 1mm; border: solid 1px black; border-radius: 3mm;font-size: 3.0mm; -moz-border-radius: 1mm; vertical-align: middle ">
        <thead>
            <tr>
                <th class="style_th1" style="width: 15%;">Code Art</th>
                <th class="style_th" style="width: 56%;">Designation</th>
                <th class="style_th" style="width: 5%;">Qte</th>
                <th class="style_th" style="width: 7%;">Prix U</th>
                <th class="style_th" style="width: 5%;">TVA</th>
                <th class="style_th" style="width: 5%;">REM</th>
                <th class="style_th" style="width: 7%;">TOTAL HT</th>
            </tr>
        </thead>
       
         <?php 
         //debug($lignefactureclients);die;
         $bl=0;
         foreach ($lignefactureclients as $i=>$lr){        
             if($lr['Lignefactureclient']['remise'] !=0){
                    $remise=sprintf('%.0f',$lr['Lignefactureclient']['remise']);
                }else{
                   $remise="" ;
                }
             
                if ($lr['Lignefactureclient']['bonlivraison_id']!=$bl){  
                ?>
            <tr>
                <td class="style_td1" style="width: 15%;"></td>
                <td class="style_td" style="width: 56%;font-size: 4.0mm">
                    <strong>&nbsp;&nbsp;&nbsp;<?php echo $lr['Bonlivraison']['numero'] ?>
                     DU : <?php echo date("d/m/Y", strtotime(str_replace('-', '/',  $lr['Bonlivraison']['date']))) ?>
                    </strong></td>
                <td class="style_td" style="width: 5%;"></td>
                <td class="style_td" style="width: 7%;"></td>
                <td class="style_td" style="width: 5%;"></td>
                <td class="style_td" style="width: 5%;"></td>
                <td class="style_td" style="width: 7%;"></td>
            </tr>
        <?php } 
         $bl=$lr['Lignefactureclient']['bonlivraison_id']; 
        
        ?>
            
            <tr>
                <td class="style_td1" style="width: 15%;"><?php echo $lr['Article']['code']; ?></td>
                <td class="style_td" style="width: 56%;"><?php echo $lr['Lignefactureclient']['designation']; ?></td>
                <td class="style_td" style="width: 5%;text-align: center;"><?php echo $lr['Lignefactureclient']['quantite']; ?></td>
                <td class="style_td" style="width: 7%;text-align: right;"><?php echo number_format($lr['Lignefactureclient']['prix'],3, '.', ' '); ?></td>
                <td class="style_td" style="width: 5%;text-align: center;"><?php echo $lr['Lignefactureclient']['tva']; ?></td>
                <td class="style_td" style="width: 5%;text-align: center;"><?php echo $remise; ?></td>
                <td class="style_td" style="width: 7%;text-align: right;"><?php echo number_format($lr['Lignefactureclient']['totalht'],3, '.', ' '); ?></td>
            </tr>
         <?php } ?>
           
    </table>
    
    
      <table style="width: 100%;" >
            <tr>
                <td style="width: 75%">
                    <table style="width: 98%;">
                        <tr>
                        
                        <td style="width: 70%;vertical-align: top;padding-top: 1mm;">
                            <table cellspacing="0" style="width: 95%;border: solid 1px black; border-radius: 3mm;font-size: 3.0mm; -moz-border-radius: 1mm;">
                                <tr >
                                    <td class="style_th1" style="width: 33%;text-align: center;height: 6mm;"><strong>BASES HT</strong></td>
                                    <td class="style_th" style="width: 34%;text-align: center;border-bottom:  solid 1px black;border-r: solid 1px #000000;"><strong>TVA</strong></td>
                                    <td class="style_th" style="width: 33%;text-align: center;border-bottom:  solid 1px black;border-left: solid 1px #000000;"><strong>MONTANT TVA</strong></td>
                                </tr>
                                <?php 
                               $tva=0;
                                foreach ($lignefactureclientstva as $i=>$lr){
                                    $tot_tva=$tot_tva+$lr[0]['mtva'];
                                    $mnt=0;$mnt_ttc=0;
                                    $mnt=($lr['Lignefactureclient']['totalht']*$lr['Lignefactureclient']['tva'])/100;
                                    $mnt_ttc=$lr['Lignefactureclient']['totalht']+$mnt;
                                    $long=$long-6;
                                    ?>
                                <tr>
                                    <td class="style_td1" style="height: 6mm;width: 33%;text-align: center;"><?php echo number_format($lr[0]['totalht'],3, '.', ' '); ?></td>
                                    <td class="style_td" style="width: 34%;text-align: center;"><?php echo sprintf('%.0f',$lr[0]['tva']); ?> %</td>
                                    <td class="style_td" style="width: 33%;text-align: center;"><?php echo number_format($lr[0]['mtva'],3, '.', ' ')  ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td class="style_td1" style="height: 6mm;width: 33%;text-align: center;">TOTAL</td>
                                    <td class="style_td" style="width: 34%;text-align: center;"></td>
                                    <td class="style_td" style="width: 33%;text-align: center;"><?php echo number_format($tot_tva,3, '.', ' ') ?></td>
                                </tr>
                            </table>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="2" style="width: 100%;">
                            <table cellspacing="0" style="width: 95%;border: solid 1px black; border-radius: 3mm;font-size: 3.7mm; -moz-border-radius: 1mm;">
                                <tr >
                                    <td class="" style="width: 100%;text-align: center;height: 18mm;">
                                        Arreter la présente Facture à la somme de  : 
                                        <br><strong><?php echo chifre_en_lettre($factureclient['Factureclient']['totalttc'], 1, 1)  ?></strong>
                                    </td>
                                </tr>
                            </table>
                           
                        </td>
                        
                    </tr>
                    </table>
                </td>
                <td  style="width: 30%">
                    <?php 
                    $ttc_sans_timbre=$factureclient['Factureclient']['totalttc']-$factureclient['Factureclient']['timbre_id'];
                    if($ttc_sans_timbre==$factureclient['Factureclient']['totalht']){
                    $factureclient['Factureclient']['tva']=0;    
                    }
                    $total_ht_avant_remise=$factureclient['Factureclient']['totalht']+$factureclient['Factureclient']['remise'];
                    ?>
                    <table style="width: 98%;">
                        <tr>
                            <td style="vertical-align: top;">
                                <div class="divfooter11">
                                    <table >
                                        <tr>
                                            <td>Total HT :</td>
                                            <td style="text-align: right;height: 6mm;"><?php echo number_format($total_ht_avant_remise,3, '.', ' '); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total remise :</td>
                                            <td style="text-align: right;height: 6mm;"><?php echo number_format($factureclient['Factureclient']['remise'],3, '.', ' '); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total NET :</td>
                                            <td style="text-align: right;height: 6mm;"><?php echo number_format($factureclient['Factureclient']['totalht'],3, '.', ' '); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total TVA :</td>
                                            <td style="text-align: right;height: 6mm;"><?php echo number_format($factureclient['Factureclient']['tva'],3, '.', ' '); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Timbre :</td>
                                            <td style="text-align: right;height: 6mm;"><?php echo number_format($factureclient['Factureclient']['timbre_id'],3, '.', ' '); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total TTC :</td>
                                            <td style="text-align: right;"><?php echo number_format($factureclient['Factureclient']['totalttc'],3, '.', ' '); ?></td>
                                        </tr>
                                    </table>  
                                </div>
                            </td>
                        </tr>
                       
                    </table>
                </td>
            </tr>
            
        </table>
  
  
<page_footer >
       
    
</page_footer>
    
</page>



        <?php
    $content = ob_get_clean();

    // convert in PDF
    //require_once(dirname(__FILE__).'/../html2pdf.class.php');
    //require_once('../Vendor/html2pdf.class.php');
    //require_once('html2pdf/html2pdf.class.php');
    //APP::import("Vendor", "html2pdf");
    APP::import("Vendor", "html2pdf/html2pdf");
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $html2pdf->Output('Factureclient.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
