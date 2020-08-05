<?php
$soc = ClassRegistry::init('Societe')->find('first');
$lborder = 'border="0"';
$n='Etat du stock';
if(!empty($namedepot)){
    $n=$n.' du d&eacute;p&ocirc;t '.$namedepot;
}
ob_start();
?>
<table style=" width: 100%;  ">
    <tr>
        <td style=" width: 30%;" align="left" >
        <IMG SRC="../webroot/img/<?php echo $soc["Societe"]["logo"];?>" width="120"  >
        </td>
        <td  style=" width: 70%;">
            <table style=" width: 100%;font-size: 1.5mm;">
                <tr>
                <br> 
                <td height="35px" align="center" ><h3><?php echo @$n; ?></h3></td> 
                </tr> 
            </table>
        </td>
    </tr>
</table>
<br>
 <table border="1" align="center" cellpadding="2" cellspacing="0"  style=" width: 100%;" class="table" >       
   <tr  align="center">
                       <th style=" width: 70%;"  align="center"  height="10px" ><strong>Article</strong></th>
                        <th style=" width: 10%;" align="center"  ><strong>Quantite</strong></th>
                        <th style=" width: 10%;"  align="center"  ><strong>Prix</strong></th>
                        <th style=" width: 10%;" align="center"  ><strong>Prix tot</strong></th>
                       
   </tr>
   <?php 
        $i=0;$total=0;$prixtot=0;
       foreach ($stockdepots as $stockdepot){
            $prixtot=$prixtot+($stockdepot[0]['qte']*$stockdepot[0]['prix']);
            $i++;
            
                $test=strpos($stockdepot[0]['qte'], ".");
                if($test==true){
                $qt= sprintf('%.3f',$stockdepot[0]['qte']);   
                }else{
                $qt= $stockdepot[0]['qte'];    
                }
               ?>
    <tr bgcolor="#FFFFFF" align="center">    
        <td width="70%" nobr="nobr" align="left" height="10px" ><?php  echo $stockdepot['Article']['code']." ".$stockdepot['Article']['name'];?></td>
        <td width="10%" nobr="nobr" align="right"  ><?php  echo $qt ;?></td>
        <td width="10%" nobr="nobr" align="right"  ><?php  echo number_format($stockdepot[0]['prix'],3,'.',' ');?></td>  
        <td width="10%" nobr="nobr" align="right"  ><?php  echo number_format($stockdepot[0]['qte']*$stockdepot[0]['prix'],3,'.',' ');?></td>     
    </tr>      
<?php } ?>


  <tr bgcolor="#FFFFFF" align="center">    
      <td colspan="3" nobr="nobr" align="right" height="10px" >Total</td>
        <td nobr="nobr" align="right"  ><?php  echo number_format($prixtot,3,'.',' ');?></td>
    </tr>
</table>
    

<?php
//die;
//die;
$content = ob_get_clean();

// convert in PDF
//require_once(dirname(__FILE__).'/../html2pdf.class.php');
//require_once('../Vendor/html2pdf.class.php');
//require_once('html2pdf/html2pdf.class.php');
//APP::import("Vendor", "html2pdf");
APP::import("Vendor", "html2pdf/html2pdf");
try {
    $html2pdf = new HTML2PDF('A', 'A4', 'fr');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->Output('etatstock.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}