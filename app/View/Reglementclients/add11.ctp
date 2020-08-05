<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Reglementclients/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<?php $p=CakeSession::read('depot');
       if($p==0){
         //$numspecial="";
       }
         ?>
<br>
<input type="hidden" id="page" value="reglementclient">
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ajout règlement client'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Reglementclient',array('autocomplete' => 'off','class'=>'form-horizontal','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">
              	<?php
                if($p==0){
                echo $this->Form->input('pointdevente_id',array('value'=>@$poinvente,'id'=>'pointdevente_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select numspecial'));
                }
		//echo $this->Form->input('client_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'clientid','class'=>'form-control clientreglement select ','required data-bv-notempty-message'=>'Champ Obligatoire','empty'=>'veuillez choisir','value'=>@$client_id) );

                echo $this->Form->input('client_id', array('value'=>@$client_id,'type'=>'hidden','id' => 'client_id', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                echo $this->Form->input('clientname', array('value'=>@$nameclt,'label'=>'Client','yourid'=>'client_id','id' => 'clientname', 'div' => 'form-group', 'between' => '<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div></td><td style="width: 5%;vertical-align: top" id="divreleve"></td></tr></table>', 'class' => 'form-control autocomplete_name_clients_reg'));
                echo $this->Form->input('numeroconca',array('id'=>'numeroconca','type'=>'hidden','value'=>@$mm,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
				echo $this->Form->input('model',array('id'=>'model','type'=>'hidden','value'=>'Reglementclient','div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('personnel_id',array('value'=>@$personnel,'id'=>'personnel_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Personnel','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select'));
//echo $this->Form->input('Retenu',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?></div><div class="col-md-6"><?php
                echo $this->Form->input('Date',array('id'=>'datereg','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly testdate','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text','value'=>date("d/m/Y")) );
                //echo $this->Form->input('Date',array('id'=>'today','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'hidden','value'=>date("d/m/Y")) );
		echo $this->Form->input('numero',array('id'=>'numero','value'=>@$numspecial,'div'=>'form-group','readonly'=>'readonly','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
//echo $this->Form->input('Montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		//echo $this->Form->input('versement',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?>
  </div>
                                    <input type="hidden" value="1"  id="typefrs">
                                    <?php if($client_id!=0 || $facture!=array() || @$impayes!=array()){?>
                                     <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" >
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
                                            <?php foreach($facture as $i=>$fac){//debug($b);die;?>
                                            <tr>
                                                <td style="width:10%;"> <?php echo $fac['Factureclient']['numero']; ?></td>
                                                <td style="width:10%;"><?php echo $fac['Factureclient']['date']; ?></td>
                                                <td><?php echo number_format($fac['Factureclient']['totalttc'],3, '.', ' '); ?></td>
                                                <td><?php echo number_format($fac['Factureclient']['Montant_Regler'],3, '.', ' '); ?></td>
                                                <td style="width:10%;"><?php echo number_format($fac['Factureclient']['totalttc']-$fac['Factureclient']['Montant_Regler'],3, '.', ' '); ?></td>
<!--                                                 <td><input type="text" name="data[Lignereglement][<?php echo $i; ?>][remise]" id="remise<?php echo $i;?>" class="form-control remisel " index="<?php echo $i; ?>" value="0.000">
                                                            -->

                                            <td style="width:15%;">
                                                <table >
                                                <tr>
                                                <td style="width:1%;">
                                                 <input type="checkbox" champ="facture" name="data[Lignereglement][<?php echo $i; ?>][factureclient_id]" id="facture_id<?php echo $i; ?>" index="<?php echo $i; ?>" class="calculereglementclient afficheinputmontantreglementclient" value="<?php echo $fac['Factureclient']['id'] ?>" mnt="<?php echo sprintf("%.3f",$fac['Factureclient']['totalttc']-$fac['Factureclient']['Montant_Regler']); ?>" >
                                                </td>
                                                <td style="width:99%;" align="left">
                                                <?php
                                                echo $this->Form->input('Montanttt',array('style'=>'display:none','index'=>$i,'name'=>'data[Lignereglement]['.$i.'][Montant]','id'=>'Montantregler'.$i,'label'=>'','div'=>'','between'=>'<div class="col-sm-12">','after'=>'','type'=>'text','class'=>'form-control testmontantreglementclient') );
                                                ?>
                                                </td>
                                                </tr>
                                                </table>
                                            </td>
                                            </tr>
                                            <?php }?>

                                        <input type="hidden" name="max" value="<?php echo @$i;?>" id="max">

                                            <tr>
                                                <td align="center" colspan="6" style="background-color: #F2D7D5;"><strong>Impayés</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Numéro</td>
                                                <td>Date</td>
                                                <td>Montant</td>
                                                <td>Montant réglé</td>
                                                <td>Reste</td>
                                                <td ></td>
                                            </tr>
                                            <?php
                                            $reste=0;
                                            //debug($facture);
                                            foreach($impayes as $im=>$fac){if ($fac['Reglementclient']['client_id']==$client_id) {//debug($b);die;
                                                $reste=$fac['Piecereglementclient']['montant']-$fac['Piecereglementclient']['mantantregler'];
                                                ?>
                                            <tr style="width:100%">
                                                <td > <?php echo $fac['Piecereglementclient']['num']; ?></td>
                                                <td ><?php echo date("d/m/Y",strtotime(str_replace('-','/',$fac['Piecereglementclient']['echance']))); ?></td>
                                                <td ><?php echo number_format($fac['Piecereglementclient']['montant'],3, '.', ' '); ?></td>
                                                <td  ><?php echo number_format($fac['Piecereglementclient']['mantantregler'],3, '.', ' '); ?></td>
                                                <td  ><?php echo number_format($reste,3, '.', ' '); ?></td>
                                                <td >
                                                <table >
                                                <tr>
                                                <td style="width:1%;">
                                                <input type="checkbox" champ="piece" name="data[Lignereglementimpaye][<?php echo $im; ?>][piecereglementclient_id]" id="impaye_id<?php echo $im; ?>" index="<?php echo $im; ?>" class="calculereglementclient afficheinputmontantreglementclientimpaye" value="<?php echo $fac['Piecereglementclient']['id'] ?>" mnt="<?php echo $reste; ?>" >
                                                </td>
                                                <td style="width:99%;" align="left">
                                                <?php
                                                echo $this->Form->input('Montanttt',array('style'=>'display:none','index'=>$im,'name'=>'data[Lignereglementimpaye]['.$im.'][Montant]','id'=>'Montantreglerimpaye'.$im,'label'=>'','div'=>'','between'=>'<div class="col-sm-12">','after'=>'','type'=>'text','class'=>'form-control testmontantreglementclientimpaye') );
                                                ?>
                                                </td>
                                                </tr>
                                                </table>
                                                </td>
                                            </tr>
                                            <?php }}?>

                                      		<input type="hidden" name="max" value="<?php echo @$im;?>" id="maximpaye">
											<!--    <tr>
													  <td colspan="4"> Total factures</td>
													  <td colspan="2">
														  <input type="text" name="data[Reglementclient][ttpayer]" id="ttpayer" class="form-control"  value="0.000" readonly>
													  </td>
											  </tr>

												   <tr>
													  <td colspan="4">Montant à payer</td>
													  <td colspan="2">
														  <input type="text" name="data[Reglementclient][Montant]" id="Montant" class="form-control"  value="0.000" readonly>
													  </td>
												  </tr>
												  <tr>
													  <td colspan="4"> Net à payer</td>
													  <td colspan="2">
														  <input type="text" name="data[Reglementclient][netapayer]" id="netapayer" class="form-control netapayer"  value="0.000" readonly>
													  </td>
												  </tr>-->
											<tr>
												<td align="center" colspan="6" bgcolor="#F2D7D5"><strong>Bon Livraison</strong></td>
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
					  //debug($bonliv);die();
					  foreach($bonliv as $j=>$fac){//debug($b);die;?>
						  <tr>
							  <td style="width:10%;"><?php echo $fac['Bonlivraison']['numero']; ?></td>
							  <td style="width:10%;"><?php echo $fac['Bonlivraison']['date']; ?></td>
							  <td><?php echo number_format($fac['Bonlivraison']['totalttc'],3, '.', ' '); ?></td>
							  <td><?php echo number_format($fac['Bonlivraison']['Montant_Regler'],3, '.', ' '); ?></td>
							  <td style="width:10%;"><?php echo number_format($fac['Bonlivraison']['totalttc']-$fac['Bonlivraison']['Montant_Regler'],3, '.', ' '); ?></td>
							  <!--                                                 <td><input type="text" name="data[Lignereglement][<?php echo $j; ?>][remise]" id="remise<?php echo $j;?>" class="form-control remisel " index="<?php echo $j; ?>" value="0.000">
                                                            -->
							  <td style="width:15%;">
								  <table>
									  <tr>
										  <td style="width:1%;">
											  <input type="checkbox" champ="facture" name="data[Lignereglementbonliv][<?php echo $j; ?>][factureclient_id]" id="bonliv_id<?php echo $j; ?>" index="<?php echo $j; ?>" class="calculereglementclient afficheinputmontantreglementclientbonliv" value="<?php echo $fac['Bonlivraison']['id'] ?>" mnt="<?php echo sprintf("%.3f",$fac['Bonlivraison']['totalttc']-$fac['Bonlivraison']['Montant_Regler']);?>" >
										  </td>
										  <td style="width:99%;" align="left">
											  <?php
											  echo $this->Form->input('Montanttt',array('style'=>'display:none','index'=>$j,'name'=>'data[Lignereglementbonliv]['.$j.'][Montant]','id'=>'Montantreglerbonliv'.$j,'label'=>'','div'=>'','between'=>'<div class="col-sm-12">','after'=>'','type'=>'text','class'=>'form-control testmontantreglementclientbonliv calculemontanttotal') );
											  ?>
										  </td>
									  </tr>
								  </table>
							  </td>
						  </tr>
					  <?php }?>
					  <input type="hidden" name="max" value="<?php echo @$j;?>" id="maxbonliv">
					  <!--
					  <input type="hidden" name="max" value="<?php /*echo @$i; */?>" id="max">

					  <tr>
						  <td align="center" colspan="6" style="background-color: #F2D7D5;"><strong>Impayés</strong></td>
					  </tr>
					  <tr>
						  <td>Numéro</td>
						  <td>Date</td>
						  <td>Montant</td>
						  <td>Montant réglé</td>
						  <td>Reste</td>
						  <td ></td>
					  </tr>
					  <?php
/*					  $reste=0;
					  //debug($facture);
					  foreach($impayes as $im=>$fac){if ($fac['Reglementclient']['client_id']==$client_id) {//debug($b);die;
						  $reste=$fac['Piecereglementclient']['montant']-$fac['Piecereglementclient']['mantantregler'];
						  */?>
						  <tr style="width:100%">
							  <td > <?php /*echo $fac['Piecereglementclient']['num']; */?></td>
							  <td ><?php /*echo date("d/m/Y",strtotime(str_replace('-','/',$fac['Piecereglementclient']['echance']))); */?></td>
							  <td ><?php /*echo number_format($fac['Piecereglementclient']['montant'],3, '.', ' '); */?></td>
							  <td  ><?php /*echo number_format($fac['Piecereglementclient']['mantantregler'],3, '.', ' '); */?></td>
							  <td  ><?php /*echo number_format($reste,3, '.', ' '); */?></td>
							  <td >
								  <table >
									  <tr>
										  <td style="width:1%;">
											  <input type="checkbox" champ="piece" name="data[Lignereglementimpaye][<?php /*echo $im; */?>][piecereglementclient_id]" id="impaye_id<?php /*echo $im; */?>" index="<?php /*echo $im; */?>" class="calculereglementclient afficheinputmontantreglementclientimpaye" value="<?php /*echo $fac['Piecereglementclient']['id'] */?>" mnt="<?php /*echo $reste; */?>" >
										  </td>
										  <td style="width:99%;" align="left">
											  <?php
/*											  echo $this->Form->input('Montanttt',array('style'=>'display:none','index'=>$im,'name'=>'data[Lignereglementimpaye]['.$im.'][Montant]','id'=>'Montantreglerimpaye'.$im,'label'=>'','div'=>'','between'=>'<div class="col-sm-12">','after'=>'','type'=>'text','class'=>'form-control testmontantreglementclientimpaye') );
											  */?>
										  </td>
									  </tr>
								  </table>
							  </td>
						  </tr>
					  --><?php /*}}*/?>

					  <tr>
						  <td colspan="4"> Total factures</td>
						  <td colspan="2">
							  <input type="text" name="data[Reglementclient][ttpayer]" id="ttpayer" class="form-control"  value="0.000" readonly>
						  </td>
					  </tr>
					  <tr>
						  <td colspan="4">Montant à payer</td>
						  <td colspan="2">
							  <input type="text" name="data[Reglementclient][Montant]" id="Montant" class="form-control"  value="0.000" readonly>
						  </td>
					  </tr>
					  <tr>
						  <td colspan="4"> Net à payer</td>
						  <td colspan="2">
							  <input type="text" name="data[Reglementclient][netapayer]" id="netapayer" class="form-control netapayer"  value="0.000" readonly>
						  </td>
					  </tr>
                     <tr>
                                                <td colspan="6">
													<table id="table" class="table table-bordered table-striped table-bottomless">
                                                     <input type="hidden" value="0" class="index" id="index">
                                                   <div class="panel-heading">
                                    <h3 class="panel-title">Pièces règlement</h3>
                                    <a class="btn btn-danger ajouterligne" table='table' index='index' tr='type'  style="
                                    float: right;
                                    position: relative;
                                    top: -25px;"> <i class="fa fa-plus-circle" ></i>Ajouter ligne</a>
                                </div></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">
                                        <table>
                                             <tr>
                                                <td >Mode règlement </td>
                                                <td ><?php
                                                 echo $this->Form->input('paiement_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control modereglementclient select',
                                                     'empty'=>'veuillez choisir',
                                                     'label'=>'','index'=>0,'id'=>'paiement_id0','champ'=>'paiement_id','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][paiement_id]'));
                                               ?>
												</td>
                                            </tr>
<!--                                            <tr >
                                                <td name="data[piece][0][trmontantbrut]" id="trmontantbruta0" index="0"  champ="trmontantbruta" table="piece"  style="display:none" class="modecheque">Montant brut</td>
                                                <td name="data[piece][0][trmontantbrut]" id="trmontantbrutb0" index="0"  champ="trmontantbrutb" table="piece"  style="display:none" class="modecheque"><?php
                                                 echo $this->Form->input('montant_brut',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control montantbrut','label'=>'','type'=>'text','index'=>0,'champ'=>'montantbrut','id'=>'montantbrut0','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant_brut]') );
                                               ?> </td>
                                            </tr>
                                            <tr >
                                                <td name="data[piece][0][trtaux]" id="trtauxa0" index="0"  champ="trtauxa" table="piece"  style="display:none" class="modecheque">Taux</td>
                                                <td name="data[piece][0][trtaux]" id="trtauxb0" index="0"  champ="trtauxb" table="piece"  style="display:none" class="modecheque"><?php
                                                 echo $this->Form->input('valeur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'select montantbrut','label'=>'','index'=>0,'champ'=>'taux','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][taux]','id'=>'taux0','empty'=>'Veuillez choisir') );
                                               ?> </td>
                                            </tr>-->
                                            <tr>
                                                <td>Montant</td>
                                                <td  ><?php
                                                 echo $this->Form->input('sup',array('div'=>'form-group','type'=>'hidden','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control mnt','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>0,'champ'=>'sup','id'=>'sup0','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][sup]') );
                                                    echo $this->Form->input('montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control mnt','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>0,'champ'=>'montant','id'=>'montant0','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant]') );
                                                    echo $this->Form->input('favid',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control mnt','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'hidden','index'=>0,'champ'=>'favid','id'=>'favid0','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][favid]') );
                                                 ?> </td>
                                            </tr>
<!--                                            <tr >
                                                <td name="data[piece][0][trmontantnet]" id="trmontantneta0" index="0"  champ="trmontantneta" table="piece"  style="display:none" class="modecheque">Montant Net</td>
                                                <td name="data[piece][0][trmontantnet]" id="trmontantnetb0" index="0"  champ="trmontantnetb" table="piece"  style="display:none" class="modecheque"><?php
                                                 echo $this->Form->input('montant_net',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>0,'id'=>'montantnet0','champ'=>'montantnet','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant_net]') );
                                               ?> </td>
                                            </tr>-->
<!--                                            <tr>
                                                <td >N° recu</td>
                                                <td  ><?php
                                                 echo $this->Form->input('num_recu',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>0,'champ'=>'num_recu','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][num_recu]') );
                                               ?> </td>
                                            </tr>-->
                                            <tr >
                                                <td name="data[piece][0][trechance]" id="trechancea0" index="0"  champ="trechancea" table="piece"  style="display:none" class="modecheque">Echéance</td>
                                                <td name="data[piece][0][trechance]" id="trechanceb0" index="0"  champ="trechanceb" table="piece"  style="display:none" class="modecheque"><?php
                                                 echo $this->Form->input('echance',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly testecheance','id'=>'dateecheance0','label'=>'','type'=>'text','index'=>0,'champ'=>'echance','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][echance]') );
                                               ?> </td>
                                            </tr>
                                             <tr>
                                                <td name="data[piece][0][trnum]" id="trnuma0" index="0"  champ="trnuma" table="piece"  style="display:none" class="modecheque" >Numéro pièce</td>
                                                <td  name="data[piece][0][trnum]" id="trnumb0" index="0"  champ="trnumb" table="piece"  style="display:none" class="modecheque">
                                                <div class='form-group' id="divnumc0" index="0"  champ="divnumc" table="piece"  style="display:none" >
                                                       <label class='col-md-2 control-label'></label>
                                                     <div class='col-sm-10'  name="data[piece][0][trnum]" id="trnumf0" index="0"  champ="trnumf" table="piece" class="modecheque">     </div>
                                                   </div>
                                                   <div class='form-group ' id="divnump0" index="0"  champ="divnump" table="piece"  >
                                                     <div class='col-sm-12'>
                                                     <?php  echo $this->Form->input('num_piece',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>0,'champ'=>'num_piece','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][num_piece]') );?>
                                                     </div>
                                                   </div>
                                                </td>
                                            </tr>
                                             <tr >
                                                <td name="data[piece][0][banque]" id="trbanquea0" index="0"  champ="banquea" table="piece"  style="display:none" class="modecheque" >Banque</td>
                                                <td  name="data[piece][0][banque]" id="trbanqueb0" index="0"  champ="banqueb" table="piece"  style="display:none" class="modecheque"><?php
                                                 echo $this->Form->input('banque',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>0,'champ'=>'banque','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][banque]') );
                                               ?> </td>
                                            </tr>
                                            <tr name="" id="trnameclient0" index="0"  champ="trnameclient" table="" class="">
                                                <td >Client</td>
                                                <td><?php
                                                echo $this->Form->input('nameclient',array('value'=>@$nameclt,'div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>0,'champ'=>'nameclient','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][nameclient]','id'=>'nameclient0') );
                                                ?></td>
                                            </tr>
                                            </table>
                                                    </td>
                                                    <td><i index="0"  class="fa fa-times supreg" style="color: #c9302c;font-size: 22px;"></td>
                                        </tr>

					  <tr  class='type'  style="display: none !important">
						  <td colspan="5">
							  <table>
								  <tr>
									  <td>Mode règlement</td>
									  <td ><?php
										  echo $this->Form->input('paiement_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control modereglementclient ',
											   'empty'=>'veuillez choisir',
											  'label'=>'','index'=>0,'champ'=>'paiement_id','id'=>'paiement_id','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][paiement_id]') );
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
										  echo $this->Form->input('sup',array('div'=>'form-group','type'=>'hidden','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>'','id'=>'','champ'=>'sup','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][sup]') );
										  echo $this->Form->input('montant',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control mnt','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'','index'=>'','id'=>'','champ'=>'montant','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][montant]') );
										  echo $this->Form->input('favid',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control mnt','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'hidden','index'=>'','champ'=>'favid','id'=>'','table'=>'pieceregelemnt','name'=>'data[pieceregelemnt][0][favid]') );
										  ?>
									  </td>
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
										  <div class='form-group ' id="" index="0"  champ="divnump" table="piece">
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
					  </tbody>
													</table>
                                    </table>
                                    </div></div>


<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button id="btnenr" disabled type="submit" class="btn btn-primary testmontanttotalereglementclient testmontantreglersaisi">Enregistrer</button>
                                            </div>
                                        </div>
                                     <?php } ?>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

