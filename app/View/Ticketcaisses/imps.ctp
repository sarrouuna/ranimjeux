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
<table width="250px" cellpadding="2" cellspacing="0">
    <tr > 
        <td width="100%" align="center" ><img src="<?php echo $this->webroot ?>img/logoimp.png" width='150px'  > </td>
    </tr>  
    <tr>
        <td width="100%" align="center" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $dat ?></td>
    </tr>
</table>


<br />

<table width="250px" cellpadding="2" cellspacing="0">
<tr height="30px">
    <td width="20%"><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Numero</strong></td>
    <td width="80%" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ticketcaiss['Ticketcaiss']['Numero']?></strong></td>
    <td></td>
</tr>
<tr height="30px">
    <td width="20%" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">DATE</strong></td>
    <td width="80%" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo date('d/m/Y', strtotime(str_replace('-', '/',$ticketcaiss['Ticketcaiss']['Date'])))?></strong></td>
</tr>
<tr height="30px">
    <td width="20%" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Client</strong></td>
    <td width="80%" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ticketcaiss['Client']['Raison_Social']?></strong></td>
</tr>
<tr height="30px">
    <td width="20%" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Dépôt</strong></td>
    <td width="80%"  ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ticketcaiss['Depot']['Nom']?></strong></td>
</tr>
</table>

<table width="250px" cellpadding="2" cellspacing="0">
    <tr >
        <td width="100%" align="center" >---------------------------------------------</td>
    </tr>  
</table>
<table width="250px" cellpadding="2" cellspacing="0">  
<tr height="10px">
    <td width="55%" align="center" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Article</strong></td>
    <td width="15%" align="center" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Qté</strong></td>
    <td width="25%" align="center" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Prix</strong></td>
    <td width="25%" align="center" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">TOTAL</strong></td>
</tr>
</table>
<table width="250px" cellpadding="2" cellspacing="0">
    <tr >
        <td width="100%" align="center" >---------------------------------------------</td>
    </tr>  
</table>
<table width="250px" cellpadding="2" cellspacing="0">
<?php 
foreach($ligneticketcaiss as $k=>$ligne){
    //debug($ligne);die;
	?>
<tr height="30px">
<td width="55%" align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ligne['Article']['Designation'];?></td>
<td width="15%" align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ligne['Ticketcaisseligne']['qte'];?></td>
<td width="25%" align="center" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ligne['Ticketcaisseligne']['prix'];?></td>
<td width="25%" align="right" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ligne['Ticketcaisseligne']['montant'];?></td>
</tr>
<?php }?>


</table>
<table width="250px" cellpadding="2" cellspacing="0">
    <tr >
        <td width="100%" align="center" >---------------------------------------------</td>
    </tr>  
</table>

<table width="250px" cellpadding="2" cellspacing="0">  
<tr height="30px">
<td width="50%" align="left" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Total :</strong></td>
<td width="50%" align="right" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ticketcaiss['Ticketcaiss']['Total_TTC'] ?></strong></td>
</tr>
<tr height="30px">
<td width="50%" align="left" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Net à Payer :</strong></td>
<td width="50%" align="right" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ticketcaiss['Ticketcaiss']['Montant_Payer'] ?></strong></td>
</tr>
<tr height="30px">
<td width="50%" align="left" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Rest :</strong></td>
<td width="50%" align="right" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ticketcaiss['Ticketcaiss']['Rest'] ?></strong></td>
</tr>

</table>

<table width="250px" cellpadding="2" cellspacing="0">
    <tr >
        <td width="100%" align="center" >---------------------------------------------</td>
    </tr>
    <tr>
        <td width="100%" align="center" >*** Merci pour votre visite ***</td>
    </tr>  
</table>

<br /><br />
 <script>print(); </script>
