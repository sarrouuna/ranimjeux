<input type="hidden" id="piecereglement_id" name="data[Situationpiecereglement][piecereglement_id]" value="<?php echo $piecereglement_id; ?>">
<?php foreach ($situationpiecereglements as $k=>$situationpiecereglement){ } 
 ?>
<input type="hidden" id="id" name="data[Situationpiecereglement][id]" value="<?php echo @$situationpiecereglement['Situationpiecereglement']['id']; ?>">
<?php if(@$situationpiecereglement['Situationpiecereglement']['date']==""){@$date=date("d/m/Y");}else{$date=date("d/m/Y",strtotime(str_replace('-','/',(@$situationpiecereglement['Situationpiecereglement']['date']))));} ?>
<center>
<table>
        <tr>
            <td colspan="2" align="center"><strong>Changer la Situation</strong> </td>
        </tr>
</table>
    <br>
<table border="0" style="width:80%">
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Date</label></td><td align="center" style="width:40%"><input value="<?php echo $date; ?>" id="datesituation" type="text"  name="data[Situationpiecereglement][date]" class="form-control datePickerOnly"></td>
    </tr>     
   
</table>
    <br>
<table border="0" style="width:80%">     
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Agio</label></td><td align="center" style="width:40%"><input value="<?php echo @$situationpiecereglement['Situationpiecereglement']['agio']; ?>" type="text" id="agiosituation" name="data[Situationpiecereglement][agoi]" class="form-control"></td>
    </tr>   
</table>
     <br>
<table border="0" style="width:80%">     
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Etat</label></td>
        <td align="center" style="width:40%">
	<div class="form-group">
                            <label class="col-sm-2"></label>
                               <div class="col-sm-12">
<!--                                <select class="form-control select selectized" placeholder="Veuillez choisir" name="data[Piecereglement][situation]" id="situation" >
                                    <option value="">Veuillez choisir</option>
                                    <option value="En attente">En attente</option>
                                    <option value="Versé"      >Versé</option>
                                    <option value="Préavis"    >Préavis</option>
                                    <option value="Escompte"   >Escompté</option>
                                    <option value="Payé"       >On caissé</option>
                                    <option value="Impayé"     >Impayé</option>
                                </select>-->
    <?php //debug($situationpiecereglements);die;
    if(empty($situationpiecereglement['Situationpiecereglement']['situation'])) {$situationpiecereglement['Situationpiecereglement']['situation']="En attente";}?>                              
                    <?php
//debug(@$situationpiecereglement['Situationpiecereglement']['etatpiecereglement_id']);
        echo $this->Form->input('etatpiecereglement_id',array('value'=>@$situationpiecereglement['Situationpiecereglement']['etatpiecereglement_id'],'id'=>'situation','name'=>'data[Situationpiecereglement][etatpiecereglement_id]','empty'=>'veuillez choisir','div'=>'form-group','label'=>'','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
        ?>
        </div></div>
        </td>
    </tr>   
</table>
</center>
<br>

