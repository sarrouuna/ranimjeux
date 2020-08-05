<table style="width: 100%;" >
<tr>
    <td bgcolor="#F2D7D5" align="center" ><strong><?php echo "Les Derniéres Importations Avec   :     ".$name; ?></strong></td>
</tr>
<tr >
</table>


<br>

<table  style="width: 100%;" border="1" align="center" >
<tr bgcolor="#F2D7D5">
<td>Désignation</td>
<td>Numero</td>
<td>Date</td>
<td>Devise</td>
<td>M A</td>
<td>C D</td>
<td>Totale</td>
<td>Coefficient</td>

</tr>
    <?php

//debug($importations);
    foreach ($importations as $i=>$importation) {  ?>
    <tr <?php if( $i==0) {?> style="background-color: red;"<?php }?>>
            <td ><?php echo $importation['Importation']['name']; ?></td>
            <td ><?php echo $importation['Importation']['numero']; ?></td>
            <td ><?php echo date("d/m/Y",strtotime(str_replace('/','/',$importation['Importation']['date']))); ?></td>
            <td >
                <?php echo $importation['Devise']['name']; ?>
            </td>
            <td ><?php echo sprintf('%.3f', h($importation['Importation']['montantachat'])); ?></td>
            <td ><?php echo $importation['Importation']['tauxderechenge']; ?></td>
            <td ><?php echo sprintf('%.3f',h($importation['Importation']['totale'])); ?></td>
            <td ><?php echo sprintf('%.3f',h($importation['Importation']['coefficien'])); ?></td>        
        </tr>
    <?php } ?>
</table>



