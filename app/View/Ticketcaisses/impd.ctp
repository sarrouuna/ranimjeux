<?php 
//debug($ticketcaiss);die;
//debug($ligneticketcaiss);die;
//debug($reglement);die;
$this->layout=null;
setlocale(LC_TIME, 'fra_fra');
$dat=strftime('%A %d %B %Y, %H:%M'); 
date_default_timezone_set('Africa/Tunis');
//debug($dat);die;
?>
<style type="text/css">
 @media print {
@page{ 
  margin: 2mm 15mm 2mm 10mm;
  padding: 0mm; 

}
}
</style>
<table width="220px" cellpadding="2" cellspacing="0">
    <tr > 
        <td width="100%" align="center" ><img src="<?php echo $this->webroot ?>img/logoimp.png" width='150px'  > </td>
    </tr>  
    <tr>
        <td width="100%" align="center" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo utf8_encode($dat) ?></td>
    </tr>
</table>

<table width="220px" cellpadding="2" cellspacing="0">
<tr height="25px">
    <td width="20%"><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Numero</strong></td>
    <td width="80%" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ticketcaiss['Ticketcaiss']['Numero']?></strong></td>
    <td></td>
</tr>
<tr height="25px">
    <td   colspan="2" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Client Comptant</strong></td>
 </tr>
 </table>

<table width="220px" cellpadding="2" cellspacing="0">
    <tr >
        <td width="100%" align="center" >----------------------------------------</td>
    </tr>  
</table>
<table width="220px" cellpadding="2" cellspacing="0">  
<tr height="10px">
    <td width="55%" align="left" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Article</strong></td>
    <td width="15%" align="center" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Qté</strong></td>
    <td width="25%" align="center" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Prix</strong></td>
    <td width="25%" align="center" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">TOTAL</strong></td>
</tr>
</table>
<table width="220px" cellpadding="2" cellspacing="0">
    <tr >
        <td width="100%" align="center" >----------------------------------------</td>
    </tr>  
</table>
<table width="220px" cellpadding="2" cellspacing="0">
<?php 
foreach($ligneticketcaiss as $k=>$ligne){
 $desCompsants='';
 if($ligne['Ticketcaisseligne']['composant_id']!=0)
 {
 $objacc = ClassRegistry::init('Composant');
                $Composants = $objacc->find('all',array(
                    'conditions'=>array('Composant.id'=>$ligne['Ticketcaisseligne']['composant_id'])
                    ,'recursive'=>-1));
 					$desCompsants=' : '.@$Composants[0]['Composant']['Designation'];
 
 }

	?>
<tr height="30px">
<td width="55%" align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ligne['Article']['Designation'].$desCompsants;?></td>
<td width="15%" align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ligne['Ticketcaisseligne']['qte'];?></td>
<td width="25%" align="center" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php if($ligne['Article']['Promotion']==0) echo $ligne['Ticketcaisseligne']['prix'];else echo '';?></td>
<td width="25%" align="right" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ligne['Ticketcaisseligne']['montant'];?></td>
</tr>

<?php 
if(!empty($ligne['Ticketcaisselignepromo']))
{
	foreach($ligne['Ticketcaisselignepromo'] as $k=>$promo){

	
	?>
<tr height="30px"> 
<td colspan="4" align="center">
<table width="60%"><tr>
 <td width="35%" align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $promo ['qteparlot'];?> / Lot</td>
  <td width="15%" align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $promo ['qtecmd'];?></td>

 <td width="25%" align="right" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $promo ['prixunite'];?></td>
</tr></table>
</td></tr>




<?php } }}?>


</table>
<table width="220px" cellpadding="2" cellspacing="0">
    <tr >
        <td width="100%" align="center" >----------------------------------------</td>
    </tr>  
</table>

<table width="220px" cellpadding="2" cellspacing="0">  
<tr height="30px">
<td width="50%" align="left" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Net à Payer :</strong></td>
<td width="50%" align="right" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ticketcaiss['Ticketcaiss']['Total_TTC'] ?></strong></td>
</tr>
<tr height="30px">
<td width="50%" align="left" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Reçu :</strong></td>
<td width="50%" align="right" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ticketcaiss['Ticketcaiss']['Montant_Payer'] ?></strong></td>
</tr>
<tr height="30px">
<td width="50%" align="left" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Reste :</strong></td>
<td width="50%" align="right" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ticketcaiss['Ticketcaiss']['Rest'] ?></strong></td>
</tr>
<?php if($ticketcaiss['Ticketcaiss']['cartefidelite_id']!=0){?>
<tr height="30px">
<td width="50%" align="left" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Point :</strong></td>
<td width="50%" align="right" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ticketcaiss['Ticketcaiss']['point'] ?>&nbsp; pts</strong></td>
</tr>
<?php }?>
</table>

<table width="220px" cellpadding="2" cellspacing="0">
    <tr >
        <td width="100%" align="center" >----------------------------------------</td>
    </tr>
    <tr>
        <td width="100%" align="center" >*** Merci pour votre visite ***</td>
    </tr>  
</table>

<br /><br />
 <script>print();   </script>
