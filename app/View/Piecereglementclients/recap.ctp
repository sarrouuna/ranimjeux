<input type="hidden" id="piecereglement_id" name="data[Situationpiecereglement][piecereglement_id]" value="<?php echo $piecereglement_id; ?>">
<center>
<table>
        <tr>
            <td colspan="2" align="center"><strong>Changer la Situation</strong> </td>
        </tr>
</table>
    <br>
<table border="0" style="width:80%">
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Date</label></td><td align="center" style="width:40%"><input value="<?php echo date("d/m/Y"); ?>" id="datesituation" type="text"  name="data[Situationpiecereglement][date]" class="form-control datePickerOnly" onkeyup="afficheboutton_okdate()" onblur="afficheboutton_okdate()"></td>
    </tr>     
   
</table>
    <br><label id="labeldate" style="display:none;">date obligatoire</label>
<!--<table border="0" style="width:80%">     
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Agio</label></td><td align="center" style="width:40%"><input value="" type="text" id="agiosituation" name="data[Situationpiecereglement][agoi]" class="form-control"></td>
    </tr>   
</table>-->
     <br>
     <table border="0" style="width:80%">
         <tr style="width:80%">
             <td align="left" style="width:10%"><label>Compte</label><br><br><br></td>
                <td align="center" style="width:40%">
                     <div class="form-group">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-12">
                    <select class="select" id="compte_id" onchange="afficheboutton_ok()">
                    <option value="">Veuillez choisir</option>
                    <?php foreach($comptes as $c){?>
                    <option value="<?php echo $c['Compte']['id'] ?>" <?php if($c['Compte']['id']==@$situationpiecereglement['Situationpiecereglementclient']['compte_id']){?> <?php } ?>><?php echo $c['Compte']['banque'].' '.$c['Compte']['rib']; ?></option>
                    <?php  }?>
                    </select>
                    </div>    
                    <br><br><br>
                    <label id="labelcompte" style="display:none;">Compte obligatoire</label>
                </td>
        </tr> 
        <tr style="width:80%">
            <td align="left" style="width:10%"><label>Etat</label></td>
                 <td align="center" style="width:40%">
                    <div class="form-group">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-12">
                    <select  class="select" id="situation_id">
                    <option value="En attente" <?php if(@$situationpiecereglement['Situationpiecereglementclient']['situation']=='En attente'){?> <?php } ?>>En attente</option>
                    <option value="Versé"      <?php if(@$situationpiecereglement['Situationpiecereglementclient']['situation']=='Versé'){?> <?php } ?>>Versement</option>
                    <option value="Préavis"    <?php if(@$situationpiecereglement['Situationpiecereglementclient']['situation']=='Préavis'){?> <?php } ?>>Préavis</option>
                    <option value="Versé à escompte"   <?php if(@$situationpiecereglement['Situationpiecereglementclient']['situation']=='Versé à l\'escompte'){?> <?php } ?>>Versé à l'escompte</option>
                    <option value="Escompte"   <?php if(@$situationpiecereglement['Situationpiecereglementclient']['situation']=='Escompte'){?> <?php } ?>>Escompte</option>
                    <option value="On caissé"  <?php if(@$situationpiecereglement['Situationpiecereglementclient']['situation']=='On caissé'){?> <?php } ?>>En Caissé</option>
                    <option value="Impayé"     <?php if(@$situationpiecereglement['Situationpiecereglementclient']['situation']=='Impayé'){?> <?php } ?>>Impayé</option>
                    </select>
                    </div>             
                </td>
         </tr>
                </table>
<!--<table border="0" style="width:80%">     
    <tr style="width:80%">
        <td align="left" style="width:10%"><label>Etat</label></td>
        <td align="center" style="width:40%">
	<div class="form-group">
                            <label class="col-sm-2"></label>
                               <div class="col-sm-12">
                                <select class="form-control select selectized" placeholder="Veuillez choisir" name="data[Piecereglement][situation]" id="situation" >
                                    <option value="">Veuillez choisir</option>
                                    <option value="En attente">En attente</option>
                                    <option value="Versé"      >Versé</option>
                                    <option value="Préavis"    >Préavis</option>
                                    <option value="Escompte"   >Escompté</option>
                                    <option value="Payé"       >On caissé</option>
                                    <option value="Impayé"     >Impayé</option>
                                </select>
    <?php //debug($situationpiecereglements);die;
    if(empty($situationpiecereglement['Situationpiecereglement']['situation'])) {$situationpiecereglement['Situationpiecereglement']['situation']="En attente";}?>                              
                    <?php
//debug(@$situationpiecereglement['Situationpiecereglement']['etatpiecereglement_id']);
        //echo $this->Form->input('etatpiecereglement_id',array('value'=>@$situationpiecereglement['Situationpiecereglement']['etatpiecereglement_id'],'id'=>'situation','name'=>'data[Situationpiecereglement][etatpiecereglement_id]','empty'=>'veuillez choisir','div'=>'form-group','label'=>'','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control'));
        ?>
        </div></div>
        </td>
    </tr>   
</table>-->
</center>
<br>

