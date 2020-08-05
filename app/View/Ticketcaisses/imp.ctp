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
<script src="<?php echo $this->webroot;?>assets/js/jquery.min.js"></script>
<script>
$(document).ready(function() {
  $("body").keypress(function(event) {
 if(event.which==32) { 
     window.close();
       }
})
});
</script>
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
    <td width="20%"><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Caisse</strong></td>
    <td width="80%" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ticketcaiss['Utilisateur']['login']?></strong></td>
    <td></td>
</tr>
<tr height="25px">

    <td   colspan="2" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">
    <?php 
	
	 $Cartefidelite = ClassRegistry::init('Cartefidelite');
  $Cartefidelite = $Cartefidelite->find('all',array( 'conditions'=>array('Cartefidelite.id'=>$ticketcaiss['Ticketcaiss']['cartefidelite_id']),'recursive'=>-1));   
 if($ticketcaiss['Ticketcaiss']['cartefidelite_id']!=0)
 { echo "Client : ".$Cartefidelite[0]['Cartefidelite']['nomprenom']; } else echo "Client Comptant";
?>
    
    </strong></td>
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
    //debug($ligne);die;
 $objpromo = ClassRegistry::init('Ticketcaisselignepromo');
                $countpromo = $objpromo->find('count',array(
                    'conditions'=>array(
                        'Ticketcaisselignepromo.ticketcaisse_id'=>$ligne['Ticketcaisseligne']['ticketcaisse_id']
                        ,'Ticketcaisselignepromo.ticketcaisseligne_id'=>$ligne['Ticketcaisseligne']['id']
                        ,'Ticketcaisselignepromo.article_id'=>$ligne['Ticketcaisseligne']['article_id'])
                    ,'recursive'=>-1));
 
if(empty($ligne['Ticketcaisselignepromo'])){
	?>
    <tr height="30px">
    <td width="55%" align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ligne['Article']['name'];?></td>
    <td width="15%" align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ligne['Ticketcaisseligne']['qte'];?></td>
    <td width="25%" align="center" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php if($countpromo==0) echo $ligne['Ticketcaisseligne']['prix'];else echo '';?></td>
    <td width="25%" align="right" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ligne['Ticketcaisseligne']['montant'];?></td>
    </tr>

<?php }
if(!empty($ligne['Ticketcaisselignepromo']))
{
	foreach($ligne['Ticketcaisselignepromo'] as $k=>$promo){

	
	?>
<tr height="30px"> 
    <td width="55%" align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $ligne['Article']['name']; ?></td>
    <td width="15%" align="left" style="font-family:Arial, Helvetica, sans-serif;font-size:10px">
        <?php 
        $qq=$promo ['qtecmd']*$promo ['qteparlot'];
        echo $qq;?>
    </td>
    <td width="25%" align="center" style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $promo ['prixunite'];?></td>
    <td width="25%" align="right" style="font-family:Arial, Helvetica, sans-serif;font-size:10px">
        <?php
        $tt=0;
        $tt=$promo ['prixunite']*$qq;
        echo sprintf('%.3f',$tt);
        ?>
    </td>
</tr>




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
<tr height="30px">
<td width="50%" align="left" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px">Cumule :</strong></td>
<td width="50%" align="right" ><strong style="font-family:Arial, Helvetica, sans-serif;font-size:10px"><?php echo $Cartefidelite[0]['Cartefidelite']['cumul'] ?>&nbsp; pts</strong></td>
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
 <script>print();  
     window.onfocus=function(){ window.close();}
 </script>
