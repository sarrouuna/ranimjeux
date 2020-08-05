<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Reglementclients/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<?php $p=CakeSession::read('depot');
       if($p==0){
         $numspecial="";
       }
         ?>
<?php $users=CakeSession::read('users');
 //debug($users);
 if($users !=12){
     $readonly="readonly";
 }else{
   $readonly="";
 }
?>
<br>
<input type="hidden" id="page" value="reglementclient">
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification Reglementclient'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Reglementclient',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">
              	<?php
                if($p==0){
                echo $this->Form->input('pointdevente_id',array('id'=>'pointdevente_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select numspecial'));
                }
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		//echo $this->Form->input('client_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','id'=>'clientid','required data-bv-notempty-message'=>'Champ Obligatoire') );
                echo $this->Form->input('client_id', array('type'=>'hidden','id' => 'client_id', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                echo $this->Form->input('clientname', array('value'=>@$nameclt,'label'=>'Client','yourid'=>'client_id','id' => 'clientname', 'div' => 'form-group', 'between' => '<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div></td><td style="width: 5%;vertical-align: top" id="divreleve"></td></tr></table>', 'class' => 'form-control autocomplete_name_clients_reg'));


                echo $this->Form->input('Date',array('id'=>'today','value'=>$date,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'hidden','required data-bv-notempty-message'=>'Champ Obligatoire') );
                echo $this->Form->input('personnel_id',array('id'=>'personnel_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Personnel','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select'));
                ?></div><div class="col-md-6"><?php
                echo $this->Form->input('numero',array('readonly'=>$readonly,'id'=>'numero','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		//echo $this->Form->input('Montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'text','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('Date',array('id'=>'datereg','value'=>$date,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly testdate','type'=>'text','required data-bv-notempty-message'=>'Champ Obligatoire') );
                echo $this->Form->input('numeroconca',array('id'=>'numeroconca','type'=>'hidden','value'=>@$mm,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('model',array('id'=>'model','type'=>'hidden','value'=>'Reglementclient','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                               ?>
  </div>
                                    <input type="hidden" value="1"  id="typefrs">
                                     <?php //if($facture!=array()){?>
                                     <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless">
                                        <thead>
                                            <tr>
                                            <td align="center" colspan="6" bgcolor="#F2D7D5"><strong>Factures</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Numéro</td>
                                                <td>Date</td>
                                                <td>Total TTC</td>
                                                <td>Montant réglé</td>
                                                <td>Reste</td>

                                                  <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //debug($facture);die;
                                            foreach($facture as $f=>$fac){
                                            $obj = ClassRegistry::init('Lignereglementclient');
                                            $lignereglementclient=$obj->find('first',array('conditions'=>array('Lignereglementclient.reglementclient_id'=>$this->request->data['Reglementclient']['id'],'Lignereglementclient.factureclient_id'=>$fac['Factureclient']['id']),false));
                                            ?>
                                            <tr>
                                                <td><?php echo $fac['Factureclient']['numero']; ?></td>
                                                <td><?php echo $fac['Factureclient']['date']; ?></td>
                                                <td><?php echo $fac['Factureclient']['totalttc']; ?></td>
                                                <td><?php echo number_format($fac['Factureclient']['Montant_Regler']-@$lignereglementclient['Lignereglementclient']['Montant'],3, '.', ' '); ?></td>
                                                <td><?php echo number_format(($fac['Factureclient']['totalttc']-$fac['Factureclient']['Montant_Regler'])+@$lignereglementclient['Lignereglementclient']['Montant'],3, '.', ' '); ?></td>

                                             <td style="width:15%;">
                                                <table >
                                                <tr>
                                                <td style="width:1%;">
                                                 <input champ="facture" type="checkbox"<?php if(@$facregclient[@$fac['Factureclient']['id']]==1){?> checked="checked"<?php  } ?> name="data[Lignereglement][<?php echo $f; ?>][factureclient_id]" id="facture_id<?php echo $f; ?>" index="<?php echo $f; ?>" class="calculereglementclient afficheinputmontantreglementclient" value="<?php echo $fac['Factureclient']['id'] ?>" mnt="<?php echo sprintf("%.3f",$fac['Factureclient']['totalttc']-$fac['Factureclient']['Montant_Regler']+@$lignereglementclient['Lignereglementclient']['Montant']) ?>" >
                                                </td>
                                                <td style="width:99%;" align="left">
                                                <?php if(@$facregclient[@$fac['Factureclient']['id']]==1){$style="display:yesy";}else{$style="display:none";} ?>
                                                <?php
                                                echo $this->Form->input('Montantreg',array('value'=>@$lignereglementclient['Lignereglementclient']['Montant'],'style'=>$style,'index'=>$f,'name'=>'data[Lignereglement]['.$f.'][Montant]','id'=>'Montantregler'.$f,'label'=>'','div'=>'','between'=>'<div class="col-sm-12">','after'=>'','type'=>'text','class'=>'form-control testmontantreglementclient') );
                                                ?>
                                                </td>
                                                </tr>
                                                </table>
                                             </td>
                                            </tr>
                                            <?php }?>
                                        <input type="hidden" name="max" value="<?php echo @$f; ?>" id="max">
                                            <tr>
                                            <td align="center" colspan="6" style="background-color: #F2D7D5;"><strong>Impayés</strong></td>
                                            </tr>
                                            <tr>
                                                <td >Numéro</td>
                                                <td >Date</td>
                                                <td >Montant</td>
                                                <td>Montant réglé</td>
                                                <td >Reste</td>
                                                <td></td>
                                            </tr>
                                              <?php   //debug($facture);die;
                                              $total=0;
                                                      foreach($impayes as $i=>$fac){

                                            $lignereglement=ClassRegistry::init('Lignereglementclient')->find('first',array('conditions'=>array('Lignereglementclient.piecereglementclient_id'=>$fac['Piecereglementclient']['id'],'Lignereglementclient.reglementclient_id'=>$id),'recursive'=>0));
                                            if(!empty($lignereglement)){
                                            $mpayer=$lignereglement['Lignereglementclient']['Montant'];
                                            }else{
                                            $mpayer=0;
                                            }

                                            ?>
                                            <tr>
                                                <td > <?php echo $fac['Piecereglementclient']['num']; ?></td>
                                                <td ><?php echo date("d/m/Y",strtotime(str_replace('-','/',$fac['Piecereglementclient']['echance']))); ?></td>
                                                <td ><?php echo $fac['Piecereglementclient']['montant']; ?></td>
                                                <td ><?php echo number_format($fac['Piecereglementclient']['mantantregler']-$mpayer,3, '.', ' '); ?></td>
                                                <td ><?php echo number_format(($fac['Piecereglementclient']['montant']-$fac['Piecereglementclient']['mantantregler'])+$mpayer,3, '.', ' '); ?></td>
                                                <td style="width:15%;">
                                                <table >
                                                <tr>
                                                <td style="width:1%;">
                                                 <input champ="piece" type="checkbox"<?php if(!empty($lignereglement)){?> checked="checked"<?php $total=$total+$fac['Piecereglementclient']['montant']; } ?> name="data[Lignereglementimpaye][<?php echo $i; ?>][piecereglementclient_id]" id="impaye_id<?php echo $i; ?>" index="<?php echo $i; ?>" class="calculereglementclient afficheinputmontantreglementclientimpaye" value="<?php echo $fac['Piecereglementclient']['id'] ?>" mnt="<?php echo ($fac['Piecereglementclient']['montant']-$fac['Piecereglementclient']['mantantregler'])+$mpayer; ?>" >
                                                </td>
                                                <td style="width:99%;" align="left">
                                                <?php if(!empty($lignereglement)){$style="display:yes";}else{$style="display:none";} ?>
                                                <?php
                                                //debug($lignereglementclient);
                                                echo $this->Form->input('Montantreg',array('value'=>@$mpayer,'style'=>$style,'index'=>$i,'name'=>'data[Lignereglementimpaye]['.$i.'][Montant]','id'=>'Montantreglerimpaye'.$i,'label'=>'','div'=>'','between'=>'<div class="col-sm-12">','after'=>'','type'=>'text','class'=>'form-control testmontantreglementclientimpaye') );
                                                ?>
                                                </td>
                                                </tr>
                                                </table>
                                                </td>

                                           </tr>
                                            <?php }?>
											<input type="hidden" name="max" value="<?php echo @$i; ?>" id="maximpaye">
											<tr>
												<td align="center" colspan="6" bgcolor="#F2D7D5"><strong>Bon livraison</strong></td>
											</tr>
											<tr>
												<td>Numéro</td>
												<td>Date</td>
												<td>Total TTC</td>
												<td>Montant réglé</td>
												<td>Reste</td>

												<td></td>
											</tr>
					  </thead>
					  <tbody>
					  <?php
					  //debug($this->request->data['Reglementclient']['id']);die;
					  foreach($bonliv as $f=>$fac){
						  $obj = ClassRegistry::init('Lignereglementclient');
						  $lignereglementclient=$obj->find('first',array('conditions'=>array('Lignereglementclient.reglementclient_id'=>$this->request->data['Reglementclient']['id'],'Lignereglementclient.bonlivraison_id'=>$fac['Bonlivraison']['id']),false));
						 // debug($lignereglementclient);die();
						  ?>
						  <tr>
							  <td><?php echo $fac['Bonlivraison']['numero']; ?></td>
							  <td><?php echo $fac['Bonlivraison']['date']; ?></td>
							  <td><?php echo $fac['Bonlivraison']['totalttc']; ?></td>
							  <td><?php echo number_format($fac['Bonlivraison']['Montant_Regler']-@$lignereglementclient['Lignereglementclient']['Montant'],3, '.', ' '); ?></td>
							  <td><?php echo number_format(($fac['Bonlivraison']['totalttc']-$fac['Bonlivraison']['Montant_Regler'])+@$lignereglementclient['Lignereglementclient']['Montant'],3, '.', ' '); ?></td>
							  <td style="width:15%;">
								  <table >
									  <tr>
										  <td style="width:1%;">
											  <input champ="facture" type="checkbox"<?php if(@$facregclient[@$fac['Bonlivraison']['id']]==1){?> checked="checked"<?php  } ?> name="data[Lignereglementbonliv][<?php echo $f; ?>][factureclient_id]" id="bonliv_id<?php echo $f; ?>" index="<?php echo $f; ?>" class="calculereglementclient afficheinputmontantreglementclientbonliv" value="<?php echo $fac['Bonlivraison']['id'] ?>" mnt="<?php echo sprintf("%.3f",$fac['Bonlivraison']['totalttc']-$fac['Bonlivraison']['Montant_Regler']+@$lignereglementclient['Lignereglementclient']['Montant'])?>" >
										  </td>
										  <td style="width:99%;" align="left">
											  <?php if(@$facregclient[@$fac['Bonlivraison']['id']]==1){$style="display:yesy";}else{$style="display:none";} ?>
											  <?php
											  echo $this->Form->input('Montantreg',array('value'=>@$lignereglementclient['Lignereglementclient']['Montant'],'style'=>$style,'index'=>$f,'name'=>'data[Lignereglementbonliv]['.$f.'][Montant]','id'=>'Montantreglerbonliv'.$f,'label'=>'','div'=>'','between'=>'<div class="col-sm-12">','after'=>'','type'=>'text','class'=>'form-control testmontantreglementclientbonliv') );
											  ?>
										  </td>
									  </tr>
								  </table>
							  </td>
						  </tr>
					  <?php }?>
                                        <input type="hidden" name="max" value="<?php echo @$f; ?>" id="maxbonliv">

                                        <tr>
                                                <td colspan="4"> Total factures</td>
                                                <td colspan="2">
                                                    <input type="text" name="data[Reglementclient][ttpayer]" id="ttpayer" class="form-control"  value="<?php echo $totalfacture ?>" readonly>
                                                </td>
                                            </tr>

                                             <tr>
                                                <td colspan="4">Montant à payer</td>
                                                <td colspan="2">
                                                    <input type="text" name="data[Reglementclient][Montant]" id="Montant" class="form-control"  value="<?php echo @$piecesregclient[0]['Reglementclient']['Montant'] ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"> Net à payer</td>
                                                <td colspan="2">
                                                    <input type="text" name="data[Reglementclient][netapayer]" id="netapayer" class="form-control netapayer"  value="<?php echo @$retenue['Piecereglementclient']['montant_net'] ?>" readonly>
                                                </td>
                                            </tr>

                                                                <tr>
                                                <td colspan="6">

                                                   <div class="panel-heading">
                                    <h3 class="panel-title">Pièces règlement</h3>
													   <table id="table" class="table table-bordered table-striped table-bottomless">

                                    <a class="btn btn-danger ajouterligne" table='table' index='index' tr='type'  style="
                                    float: right;
                                    position: relative;
                                    top: -25px;"> <i class="fa fa-plus-circle"  ></i>Ajouter ligne</a>

                                </div></td>
                                            </tr>
                                            <tr  class='type'  style="display: none !important">
                                                <td colspan="5">
                                        <table>
                                             <tr>
                                                <td >Mode règlement </td>
                                                <td ><?php
                                                 echo $this->Form->input('sup',array('type'=>'hidden','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','label'=>'','index'=>'','champ'=>'sup','id'=>'','table'=>'pieceregelemnt','name'=>'') );
                                                 echo $this->Form->input('paiement_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control editmodereglementclient  ',
                                                    // 'empty'=>'veuillez choisir',
                                                     'label'=>'','index'=>0,'id'=>'paiement_id','champ'=>'paiement_id','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][paiement_id]') );
                                               ?> </td>

                                            </tr>
<!--                                            <tr >
                                                <td name="data[piece][0][trmontantbrut]" id="" index="0"  champ="trmontantbruta" table="piece"  style="display:none" class="modecheque">Montant brut</td>
                                                <td name="data[piece][0][trmontantbrut]" id="" index="0"  champ="trmontantbrutb" table="piece"  style="display:none" class="modecheque"><?php
                                                 echo $this->Form->input('montant_brut',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control montantbrut','label'=>'','type'=>'text','index'=>0,'champ'=>'montantbrut','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant_brut]') );
                                               ?> </td>
                                            </tr>
                                            <tr >
                                                <td name="data[piece][0][trtaux]" id="" index="0"  champ="trtauxa" table="piece"  style="display:none" class="modecheque">Taux</td>
                                                <td name="data[piece][0][trtaux]" id="" index="0"  champ="trtauxb" table="piece"  style="display:none" class="modecheque"><?php
                                                 echo $this->Form->input('valeur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'montantbrut','label'=>'','index'=>0,'champ'=>'taux','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][taux]','empty'=>'Veuillez choisir') );
                                               ?> </td>
                                            </tr>-->
                                            <tr>
                                                <td >Montant</td>
                                                <td  ><?php
                                                 echo $this->Form->input('montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control mnt','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>'','champ'=>'montant','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant]') );
                                                 echo $this->Form->input('favid',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'hidden','index'=>'','champ'=>'favid','id'=>'','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][favid]') );
                                                 ?> </td>
                                            </tr>
<!--                                            <tr >
                                                <td name="data[piece][0][trmontantnet]" id="" index="0"  champ="trmontantneta" table="piece"  style="display:none" class="modecheque">Montant Net</td>
                                                <td name="data[piece][0][trmontantnet]" id="" index="0"  champ="trmontantnetb" table="piece"  style="display:none" class="modecheque"><?php
                                                 echo $this->Form->input('montant_net',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>0,'champ'=>'montantnet','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant_net]') );
                                               ?> </td>
                                            </tr>-->
<!--                                            <tr>
                                                <td >N° recu</td>
                                                <td  ><?php
                                                 echo $this->Form->input('num_recu',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>0,'champ'=>'num_recu','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][num_recu]') );
                                               ?> </td>
                                            </tr>-->

                                            <tr >
                                                <td name="data[piece][0][trechance]" id="" index="0"  champ="trechancea" table="piece"  style="display:none" class="modecheque">Echéance</td>
                                                <td name="data[piece][0][trechance]" id="" index="0"  champ="trechanceb" table="piece"  style="display:none" class="modecheque"><?php
                                                 echo $this->Form->input('echance',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control testecheance','label'=>'','type'=>'text','index'=>0,'id'=>'dateecheance','champ'=>'echance','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][echance]') );
                                               ?> </td>
                                            </tr>
                                             <tr >
                                                <td name="data[piece][0][trnum]" id="" index="0"  champ="trnuma" table="piece"  style="display:none" class="modecheque" >Numéro pièce</td>
                                                <td  name="data[piece][0][trnum]" id="" index="0"  champ="trnumb" table="piece"  style="display:none" class="modecheque">
                                                 <div class='form-group' id="" index="0"  champ="divnumc" table="piece"  style="display:none" >
                                                       <label class='col-md-2 control-label'></label>
                                                     <div class='col-sm-10'  name="data[piece][0][trnum]" id="" index="0"  champ="trnumf" table="piece" class="modecheque">     </div>
                                                   </div>
                                                   <div class='form-group ' id="" index="0"  champ="divnump" table="piece"  style="display:none" >
                                                     <div class='col-sm-12'>
                                                     <?php  echo $this->Form->input('num_piece',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>0,'champ'=>'num_piece','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][num_piece]') );?>
                                                     </div>
                                                   </div>
                                                </td>
                                            </tr>
                                             <tr >
                                                <td name="data[piece][0][trbanque]" id="" index="0"  champ="trbanquea" table="piece"  style="display:none" class="modecheque" >Banque</td>
                                                <td  name="data[piece][0][trBanque]" id="" index="0"  champ="trbanqueb" table="piece"  style="display:none" class="modecheque"><?php
                                                 echo $this->Form->input('banque',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>0,'champ'=>'banque','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][banque]') );
                                               ?> </td>
                                            </tr>
                                            <tr name="" id="" index="0"  champ="trnameclient" table=""  class="">
                                                <td >Client</td>
                                                <td><?php
                                                echo $this->Form->input('nameclient',array('value'=>@$nameclt,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>0,'champ'=>'nameclient','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][nameclient]') );
                                                ?></td>
                                            </tr>
                                            </table>
                                                    </td>
                                                    <td><i index=""  class="fa fa-times supreg" style="color: #c9302c;font-size: 22px;"></td>
                                            </tr>

                                    <?php   foreach ($piecesregclient as $i=>$piece){ //debug($piece); ?>

                                            <tr>
                                                <td colspan="5">
                                        <table>
                                             <tr>
                                                <td >Mode règlement </td>
                                                <td ><?php
                                                     echo $this->Form->input('sup',array('type'=>'hidden','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','label'=>'','index'=>$i,'champ'=>'sup','id'=>'sup'.$i,'table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][sup]') );
                                                     echo $this->Form->input('idp',array('type'=>'hidden','value'=>$piece['Piecereglementclient']['id'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','label'=>'','index'=>$i,'champ'=>'montant','id'=>'id'.$i,'table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][id]') );
                                                 echo $this->Form->input('paiement_id',array('value'=>$piece['Piecereglementclient']['paiement_id'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control editmodereglementclient select  ',
                                                     //'empty'=>'veuillez choisir',
                                                     'label'=>'','index'=>$i,'id'=>'paiement_id'.$i,'champ'=>'paiement_id','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][paiement_id]') );
                                               ?> </td>
                                            </tr>
<!--                                            <tr <?php  if($piece['Piecereglementclient']['paiement_id']!=5){?>   style="display:none" <?php }?> id="trmontantbrut<?php echo $i  ?>"   >
                                                 <td name="data[piece][<?php echo $i  ?>][trmontantbrut]" id="trmontantbruta<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trmontantbruta" table="piece"   class="modecheque">Montant brut</td>
                                                 <td name="data[piece][<?php echo $i  ?>][trmontantbrut]" id="trmontantbrutb<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trmontantbrutb" table="piece"   class="modecheque"><?php
                                                   echo $this->Form->input('montant_brut',array('value'=>$piece['Piecereglementclient']['montant_brut'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control editmontantbrut','label'=>'','type'=>'text','index'=>$i,'champ'=>'montantbrut','id'=>'montantbrut'.$i,'table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][montant_brut]') );
                                              ?> </td>
                                            </tr>-->
<!--                                           <tr  <?php  if($piece['Piecereglementclient']['paiement_id']!=5){?>   style="display:none" <?php }?> id="trtaux<?php echo $i  ?>"  >
                                                    <td name="data[piece][<?php echo $i  ?>][trtaux]" id="trtauxa<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trtauxa" table="piece"  class="modecheque">Taux</td>
                                                    <td name="data[piece][<?php echo $i  ?>][trtaux]" id="trtauxb<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trtauxb" table="piece"  class="modecheque"><?php
                                                     echo $this->Form->input('valeur_id',array('value'=>$piece['Piecereglementclient']['to_id'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'select editmontantbrut','label'=>'','index'=>$i,'champ'=>'taux','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][taux]','id'=>'taux'.$i,'empty'=>'Veuillez choisir') );
                                                   ?> </td>
                                             </tr>-->
                                          <tr>
                                                    <td>Montant</td>
                                                    <td  ><?php
                                                     echo $this->Form->input('montant',array('value'=>$piece['Piecereglementclient']['montant'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control mnt','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>$i,'champ'=>'montant','id'=>'montant'.$i,'table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][montant]') );
                                                     echo $this->Form->input('favid',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'hidden','index'=>$i,'champ'=>'favid','id'=>'favid'.$i,'table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][favid]') );
                                                     ?> </td>
                                            </tr>
<!--                                            <tr  <?php  if($piece['Piecereglementclient']['paiement_id']!=5){?>   style="display:none" <?php }?> id="trmontantnet<?php echo $i  ?>" >
                                                    <td name="data[piece][<?php echo $i  ?>][trmontantnet]" id="trmontantneta<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trmontantneta" table="piece"  class="modecheque">Montant Net</td>
                                                    <td name="data[piece][<?php echo $i  ?>][trmontantnet]" id="trmontantnetb<?php echo $i  ?>" index="<?php echo $i  ?>"  champ="trmontantnetb" table="piece"   class="modecheque"><?php
                                                     echo $this->Form->input('montant_net',array('value'=>$piece['Piecereglementclient']['montant_net'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>$i,'id'=>'montantnet'.$i,'champ'=>'montantnet','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][montant_net]') );
                                                   ?> </td>
                                                </tr>  -->
                                            <tr  <?php  if(($piece['Piecereglementclient']['paiement_id']==1)||($piece['Piecereglementclient']['paiement_id']==5)||($piece['Piecereglementclient']['paiement_id']==6)){?>   style="display:none" <?php }?> id="trechance<?php echo $i  ?>" >
                                                    <td name="data[piece][<?php echo $i?>][trechance]" id="trechancea[<?php echo $i?>" index="[<?php echo $i?>"  champ="trechancea" table="piece"   class="modecheque">Echéance</td>
                                                    <td name="data[piece][<?php echo $i?>][trechance]" id="trechanceb[<?php echo $i?>" index="[<?php echo $i?>"  champ="trechanceb" table="piece"  class="modecheque"><?php
                                                     echo $this->Form->input('echance',array('value'=>date("d/m/Y",strtotime(str_replace('-','/',$piece['Piecereglementclient']['echance']))),'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly testecheance','label'=>'','type'=>'text','index'=>$i,'id'=>'dateecheance'.$i,'champ'=>'echance','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][echance]') );
                                                   ?> </td>
                                              </tr>
                                            <tr  <?php  if(($piece['Piecereglementclient']['paiement_id']==1)){?>   style="display:none" <?php }?> id="trnum<?php echo $i  ?>" >
                                                <td name="data[piece][<?php echo $i?>][trnum]" id="trnuma<?php echo $i?>" index="<?php echo $i?>"  champ="trnuma" table="piece"   class="modecheque" >Numéro pièce</td>
                                                <td  name="data[piece][<?php echo $i?>][trnum]" id="trnumb<?php echo $i?>" index="<?php echo $i?>"  champ="trnumb" table="piece"   class="modecheque"><?php
                                                // echo $this->Form->input('num_piece',array('value'=>$piece['Piecereglementclient']['num'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>$i,'champ'=>'num_piece','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][num_piece]') );
                                               ?>
                                                <div class='form-group' id="divnumc<?php echo $i?>" index="<?php echo $i?>"  champ="divnumc" table="piece"  >
                                                       <label class='col-md-2 control-label'></label>
                                                     <div class='col-sm-10'  name="data[piece][<?php echo $i?>][trnum]" id="trnumf<?php echo $i?>" index="<?php echo $i?>"  champ="trnumf" table="piece" class="modecheque">     </div>
                                                   </div>
                                                   <div class='form-group ' id="divnump<?php echo $i?>" index="<?php echo $i?>"  champ="divnump" table="piece"   >
                                                     <div class='col-sm-12'>
                                                     <?php  echo $this->Form->input('num_piece',array('value'=>$piece['Piecereglementclient']['num'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>$i,'champ'=>'num_piece','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][num_piece]') );?>
                                                     </div>
                                                   </div>
                                                </td>
                                            </tr>
                                            <tr  <?php  if(($piece['Piecereglementclient']['paiement_id']==1)||($piece['Piecereglementclient']['paiement_id']==5)||($piece['Piecereglementclient']['paiement_id']==6)){?>   style="display:none" <?php }?> id="trbanque<?php echo $i  ?>" >
                                                <td name="data[piece][<?php echo $i?>][banque]" id="trbanquea<?php echo $i?>" index="<?php echo $i?>"  champ="banquea" table="piece"  class="modecheque" >Banque</td>
                                                    <td  name="data[piece][<?php echo $i?>][banque]" id="trbanqueb<?php echo $i?>" index="<?php echo $i?>"  champ="banqueb" table="piece"  class="modecheque"><?php
                                                     echo $this->Form->input('banque',array('value'=>$piece['Piecereglementclient']['banque'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>$i,'champ'=>'banque','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][banque]') );
                                                 ?> </td>
                                                </tr>
                                            <tr name="" id="" index="<?php echo $i?>"  champ="trnameclient" table=""  class="">
                                                <td >Client</td>
                                                <td><?php
                                                echo $this->Form->input('nameclient',array('value'=>$piece['Piecereglementclient']['nameclient'],'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>$i,'champ'=>'nameclient','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt]['.$i.'][nameclient]') );
                                                ?></td>
                                            </tr>

                                            </table>
                                                    </td>
                                                 <td><i index="<?php echo $i?>"  class="fa fa-times supreg" style="color: #c9302c;font-size: 22px;"></td>
                                        </tr>

                                    <?php  }  ?>
                                     <input type="hidden" value="<?php echo @$i; ?>" class="index" id="index">
                                     </tbody>
				  </table>

                                    </table>
                                    </div></div>
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary testmontanttotalereglementclient ">Enregistrer</button>
                                            </div>
                                        </div>
                                    <?php //} ?>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

