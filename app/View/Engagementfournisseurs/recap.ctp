<input type="hidden" id="piecereglement_id" name="data[Situationpiecereglement][piecereglement_id]" value="<?php echo $piecereglement_id; ?>">
<input type="hidden" id="resultat" name="" value="<?php echo $result; ?>">
<center>
<table>
        <tr>
            <td colspan="2" align="center"><strong>Changer la Situation</strong> </td>
        </tr>
</table>
    <br>
    
<table border="0" style="width:80%">
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Date</label></td>
        <td align="center" style="width:50%">
	<?php echo $this->Form->input('echancenf',array('value'=>date("d/m/Y"),'label'=>'','div'=>'form-group', 'name' => 'data[Situationpiecereglement][date]','table'=>'etatpieceregelemnt','index'=>'0','id'=>'datesituation','champ'=>'datesituation','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text') );?>
<!--        <input value="<?php echo date("d/m/Y"); ?>" id="datesituation" type="text"  name="data[Situationpiecereglement][date]" class="form-control datePickerOnly">-->
        </td>
    </tr>     
   
</table>
    <br>
<!--<table border="0" style="width:80%">     
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Agio</label></td><td align="center" style="width:40%"><input value="<?php echo @$situationpiecereglement['Situationpiecereglement']['agio']; ?>" type="text" id="agiosituation" name="data[Situationpiecereglement][agoi]" class="form-control"></td>
    </tr>   
</table>-->
     <br>
<table border="0" style="width:80%">     
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Etat</label></td><td align="center" style="width:50%">
	<?php	
        echo $this->Form->input('etatpiecereglement_id',array('id'=>'etatpiecereglement_id','name'=>'data[Situationpiecereglement][etatpiecereglement_id]','empty'=>'veuillez choisir','div'=>'form-group','label'=>'','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select ','onchange'=>'affichediv_situation_frs_externe()'));
        ?>
        </td>
        
    </tr>   
</table>
<?php if($result==2)  { ?>     
     <br><br>
<div id="div_situation_frs_externe" style="display: none;">     
<table border="0" style="width:80%">     
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Nbr jours</label></td><td align="center" style="width:50%">
        <?php echo $this->Form->input('nbrjour',array('name'=>'','id'=>'nbrjour','table'=>'etatpieceregelemnt','index'=>'0','champ'=>'nbrjour','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','onkeyup'=>'affiche_bouttonok_situation_frs_externe') );?>
        </td>
    </tr>   
</table>
    <br><br>
<table border="0" style="width:80%">     
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Nouveau échance</label></td><td align="center" style="width:50%">
	<?php echo $this->Form->input('echancenf',array('label'=>'','div'=>'form-group', 'name' => '','table'=>'etatpieceregelemnt','index'=>'0','id'=>'echancenf','champ'=>'echancenf','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control datePickerOnly','onkeyup'=>'affiche_bouttonok_situation_frs_externe()') );?>

        </td>
    </tr>   
</table>
    <br><br>
<table border="0" style="width:80%">     
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Montant</label></td><td align="center" style="width:50%">
	<?php echo $this->Form->input('montant',array('name'=>'','id'=>'montant','table'=>'etatpieceregelemnt','index'=>'0','champ'=>'montant','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ','onkeyup'=>'affiche_bouttonok_situation_frs_externe()') );?>
        </td>
    </tr>   
</table>
</div>
   
<div id="divcredit" style="display: none;">
<table border="0" style="width:80%">     
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Nbr Mois</label></td><td align="center" style="width:50%">
        <?php echo $this->Form->input('nbrmois',array('name'=>'','id'=>'nbrmois','table'=>'etatpieceregelemnt','index'=>'0','champ'=>'nbrmois','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','onkeyup'=>'affiche_bouttonok_situation_frs_externe()') );?>
        </td>
    </tr>   
</table>   
<br><br>
<table border="0" style="width:80%">     
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Montant</label></td><td align="center" style="width:50%">
        <?php echo $this->Form->input('montantc',array('name'=>'','id'=>'montantc','table'=>'etatpieceregelemnt','index'=>'0','champ'=>'montantc','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','onkeyup'=>'affiche_bouttonok_situation_frs_externe()') );?>
        </td>
    </tr>   
</table>   
</div>        
</center>
<br>
<?php } ?>
<br>
        <label id="labelcredit" style="display:none;">il faut convertir une seul piece de reglement</label>