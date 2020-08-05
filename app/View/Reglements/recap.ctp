<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Ajout Credit'); ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong><?php echo number_format(@$montant,3,'.',' '); ?></strong></h3>
            </div>
            
            <div class="panel-body">
<?php echo $this->Form->create('Reglement',array('autocomplete' => 'off','class'=>'form-horizontal','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
<input type="hidden" value="<?php echo sprintf('%.3f',@$montant) ; ?>"  id="montant">
<table  style="width: 100%;" border="1" align="center" >
<tr bgcolor="#F2D7D5">
<td><center>N°</center></td>    
<td><center>Numéro de piéce</center></td>
<td><center>Echéance</center></td>
<td><center>Montant</center></td>
</tr>
    <?php for($i=1;$i<=$nbrmoins;$i++){ ?>
    <tr>
    <td ><?php echo $i; ?></td>    
    <td >
    <?php  echo $this->Form->input('num_piececredit',array('div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>$i,'id'=>$index.'num_piececredit'.$i,'champ'=>'num_piececredit','table'=>'traitecredits','name'=>'data[credits]['.$index.'][traitecredits]['.$i.'][num_piececredit]') );  ?>  
    </td>
    <td >
    <?php  echo $this->Form->input('echancecredit',array('div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control datePickerOnly','label'=>'','type'=>'text','index'=>$i,'id'=>$index.'echancecredit'.$i,'champ'=>'echancecredit','table'=>'traitecredits','name'=>'data[credits]['.$index.'][traitecredits]['.$i.'][echancecredit]') );  ?>  
    </td>
    <td >
    <?php  echo $this->Form->input('montantcredit',array('div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>$i,'id'=>$index.'montantcredit'.$i,'champ'=>'montantcredit','table'=>'traitecredits','name'=>'data[credits]['.$index.'][traitecredits]['.$i.'][montantcredit]','onkeyup'=>'calculetotalecredit('.$index.')') );  ?>  
    </td>
               
    </tr>
    <?php } ?>
    <tr>
        <td align="center" colspan="3"><label><strong>Total</strong></label></td><td align="center"><input type="text" id="<?php echo $index; ?>total" class="form-control" readonly="readonly"></td>
    </tr>
<!--    <tr>
        <td align="center" colspan="3"><label><strong>Agio</strong></label></td><td align="center"><input type="text" id="<?php echo $index; ?>agio" class="form-control" readonly="readonly"></td>
    </tr>-->
</table>


<input type="hidden" value="<?php echo @$i; ?>"  id="nbrtr<?php echo $index; ?>">
<input type="hidden" value="<?php echo @$index; ?>"  id="index">
<br><br>
            <div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button  type="submit" class="btn btn-primary  testtabledetraite ">Enregistrer</button>
                                            </div>
                                        </div>
</div>
<?php echo $this->Form->end();?>
        </div>
    </div>
</div>