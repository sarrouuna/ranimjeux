



<div class="panel-body" id="tabfac">
<table  style="width: 100%;" border="1" align="center" >
<tr>
<td colspan="8" bgcolor="#F2D7D5">Situations</td>
</tr>
<tr>
<td>Date Changement</td>
<td>Situation</td>
<td></td>
<td></td>
<td></td>
</tr>
    <?php
$nb=0;
//debug($situationpiecereglements);die;
    foreach ($situationpiecereglements as $situationpiecereglement) { $nb=$nb+1; ?>
        <tr>
            <td align="center"><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',($situationpiecereglement['Situationpiecereglement']['datemodification']))))); ?></td>
            <td ><?php echo $situationpiecereglement['Etatpiecereglement']['name']; ?></td>
            <td >
            <?php if (($situationpiecereglement['Etatpiecereglement']['id']==7)||($situationpiecereglement['Etatpiecereglement']['id']==8)){ ?>
            <?php if (!empty($situationpiecereglement['Situationpiecereglement']['nbrjour'])){ ?>
            <?php echo $situationpiecereglement['Situationpiecereglement']['nbrjour']." Jours"; ?>
            <?php }} ?>
            </td>
            <td >
            <?php if (($situationpiecereglement['Etatpiecereglement']['id']==9)){ ?>
            <?php if (!empty($situationpiecereglement['Situationpiecereglement']['nbrmoins'])){ ?>
            <?php echo $situationpiecereglement['Situationpiecereglement']['nbrmoins']." Mois"; ?>
            <?php }} ?>
            </td>    
            <td ><?php 
            if($situationpiecereglement['Etatpiecereglement']['id']==$piecereglement['Piecereglement']['etatpiecereglement_id']){
            echo '<img class="rounded"  src="'.$this->webroot.'assets/images/Tick1.png" width="20px" height="20px" />';
            }
            ?></td>
        </tr>
    <?php } ?>
</table>
</div>



