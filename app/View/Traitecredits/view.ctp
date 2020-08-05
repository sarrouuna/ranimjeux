<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Traitecredits/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<?php  $i=0; ?>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('View credit'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Traitecredit',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
        <?php
        $obj = ClassRegistry::init('Situationpiecereglement');
        $pieces = $obj->find('first', array( 'conditions' => array('Situationpiecereglement.etatpiecereglement_id' =>9,'Situationpiecereglement.piecereglement_id  ' => $id),'order'=>array('Situationpiecereglement.id'=>'desc')));    
        //debug($pieces);die;
        ?>
                                <input type="hidden" value="<?php echo sprintf('%.3f',@$pieces['Situationpiecereglement']['montant']) ; ?>"  id="montant">
                                <table>            
                                <tr id="trnbrmoin<?php echo $i ?>" index="<?php echo $i ?>"  champ="trnbrmoin" table="piece">
                                                <td>Nombre de mois</td>  
                                                <td>  
                                                <?php  echo $this->Form->input('nbrmoins',array('readonly'=>'readonly','value'=>$pieces['Situationpiecereglement']['nbrmoins'],'div'=>'form-group','between'=>'<table style="width: 70%"><tr><td style="width: 80%"><div class="col-sm-12">','after'=>'</div></td><td align="left" style="width: 20%;vertical-align: top"><span title="valider"><a id=""  champ="ajout" index="" class="btn btn-xs btn-success"><i class="fa fa-plus-circle "></i></a></td></tr></table>','class'=>'form-control edittabledemoins','label'=>'','type'=>'text','index'=>$i,'id'=>'nbrmoins'.$i,'champ'=>'nbrmoins','table'=>'etatpieceregelemnt','name'=>'data[Traitecredit]['.$i.'][nbrmoins]') );  ?>  
                                                </td>
                                </tr>
                                </table>
                                    
                                    
                                    
                                    
                                    <table  style="width: 100%;" border="1" align="center" id="tablet">
                                            <tr bgcolor="#F2D7D5">
                                                <td><center>N°</center></td>    
                                                <td><center>Numéro de piéce</center></td>
                                                <td><center>Echéance</center></td>
                                                <td><center>Montant</center></td>
                                            </tr>
                                                <?php 
                                                $credit=ClassRegistry::init('Traitecredit')->find('all',array('conditions'=>array('Traitecredit.piecereglement_id'=>$id),'order'=>array('Traitecredit.echancecredit'=>'asc'),'recursive'=>0));   
                                                $totale=0;
                                                $agio=0;
                                                foreach ($credit as $n=>$c){ $m=$n+1;
                                                $totale=$totale+$c['Traitecredit']['montantcredit'];
                                                //$agio=$totale-$montantcredit;
                                                ?>
                                            <tr id="tr<?php echo $m;?>">
                                                <td ><?php echo $m; ?></td>    
                                                <td >
                                                <?php  echo $this->Form->input('id',array('value'=>@$c['Traitecredit']['id'],'div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'hidden','index'=>$m,'id'=>$i.'num_piececredit'.$m,'champ'=>'id','table'=>'traitecredits','name'=>'data[credits]['.$i.'][traitecredits]['.$m.'][id]') );  ?>  
                                                <?php  echo $this->Form->input('num_piececredit',array('readonly'=>'readonly','value'=>@$c['Traitecredit']['num_piececredit'],'div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>$m,'id'=>$i.'num_piececredit'.$m,'champ'=>'num_piececredit','table'=>'traitecredits','name'=>'data[credits]['.$i.'][traitecredits]['.$m.'][num_piececredit]') );  ?>  
                                                </td>
                                                <td >
                                                <?php  echo $this->Form->input('echancecredit',array('readonly'=>'readonly','value'=>date("d/m/Y",strtotime(str_replace('/','-',@$c['Traitecredit']['echancecredit']))),'div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>$m,'id'=>$i.'echancecredit'.$m,'champ'=>'echancecredit','table'=>'traitecredits','name'=>'data[credits]['.$i.'][traitecredits]['.$m.'][echancecredit]') );  ?>  
                                                </td>
                                                <td >
                                                <?php  echo $this->Form->input('montantcredit',array('readonly'=>'readonly','value'=>@$c['Traitecredit']['montantcredit'],'div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>$m,'id'=>$i.'montantcredit'.$m,'champ'=>'montantcredit','table'=>'traitecredits','name'=>'data[credits]['.$i.'][traitecredits]['.$m.'][montantcredit]','onkeyup'=>'calculetotalecredit('.$i.')') );  ?>  
                                                </td>
                                            </tr>
                                                <?php } ?>
                                            
                                            <tr id="" champ='tr' class="tr" table='tr' index='' style="display:none;">
                                                <td ><span index="" id="" champ="n"></span></td>    
                                                <td >
                                                <?php  echo $this->Form->input('num_piececredit',array('div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>'','id'=>'','champ'=>'num_piececredit','table'=>'traitecredits','name'=>'') );  ?>  
                                                </td>
                                                <td >
                                                <?php  echo $this->Form->input('echancecredit',array('div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>'','id'=>'','champ'=>'echancecredit','table'=>'traitecredits','name'=>'') );  ?>  
                                                </td>
                                                <td >
                                                <?php  echo $this->Form->input('montantcredit',array('div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>'','id'=>'','champ'=>'montantcredit','table'=>'traitecredits','name'=>'') );  ?>  
                                                </td>
                                            </tr>
                                            </table>
                                            <table style="width: 100%;" border="1" align="center" >
                                            <tr>
                                                <td align="center" style="width: 67.5%;" ><label><strong>Total</strong></label></td><td align="center"><input type="text" id="<?php echo $i; ?>total" class="form-control" readonly="readonly" value="<?php echo sprintf('%.3f',$totale); ?>"></td>
                                            </tr>
<!--                                            <tr>
                                                <td align="center" style="width: 67.5%;" ><label><strong>Agio</strong></label></td><td align="center"><input type="text" id="<?php echo $i; ?>agio" class="form-control" readonly="readonly" value="<?php echo sprintf('%.3f',$agio); ?>"></td>
                                            </tr>-->
                                            </table>    
                                        <input type="hidden" value="<?php echo @$m; ?>"  id="nbrtr<?php echo $i?>">
                                        <input type="hidden" value="<?php echo @$m; ?>"  id="nbrtr_ans<?php echo $i?>">
                                        <input type="hidden" value="<?php echo @$i; ?>"  id="index">
                                        <br>
                                        
<?php echo $this->Form->end();?>                                

</div>
              
                                
                            </div>
                        </div>
</div>

