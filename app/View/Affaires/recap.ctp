<input type="hidden" id="affaireid" value="<?php echo $affaire['Affaire']['id']; ?>">
<table style="width: 100%;" >
<tr>
<td bgcolor="#F2D7D5" align="center" ><?php echo "Affaire :".$affaire['Affaire']['name']; ?></td>
</tr>
<tr >
</table>




<table  style="width: 100%;" border="1" align="center" >
<tr>
<td colspan="8" bgcolor="#F2D7D5">DEVIS</td>
</tr>
<tr>
<td>Numéro</td>
<td>Date</td>
<td>Client</td>
<td>TOT_HT</td>
<td>TOT_TTC</td>
<td style="width: 15%;">Situation</td>
<td style="width: 15%;">Raison de perde</td>
</tr>
<?php foreach ($devis as $i=>$devi) {  ?>
        <tr>
            
            <td >
            <input type="hidden" id="devi_id<?php echo $i; ?>" value="<?php echo $devi['Devi']['id']; ?>">
            <?php echo $devi['Devi']['numero']; ?></td>
            <td ><?php echo $devi['Devi']['date']; ?></td>
            <td ><?php echo $devi['Devi']['name']; ?></td>
            <td ><?php echo $devi['Devi']['totalht']; ?></td>
            <td ><?php echo $devi['Devi']['totalttc']; ?></td>
            <td ><?php 
                echo $this->Form->input('statusuivi_id',array('value'=>@$devi['Suivicommercial'][0]['statusuivi_id'],'id'=>'statusuivi_id'.$i,'empty'=>'Veuillez Choisir !!','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-16">','after'=>'</div>','class'=>'form-control') );
	    ?></td>
            <td ><?php 
                echo $this->Form->input('raisondeperde_id',array('value'=>@$devi['Suivicommercial'][0]['raisondeperde_id'],'id'=>'raisondeperde_id'.$i,'empty'=>'Veuillez Choisir !!','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-16">','after'=>'</div>','class'=>'form-control') );
	    ?></td>
        </tr>
    <?php } ?>
</table>
<input type="hidden" id="i_max" value="<?php echo $i; ?>">



