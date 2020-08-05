<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Clients/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<input type="hidden" value="add" id="operation">
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Ajout Client'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Client', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultF', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh', 'enctype' => 'multipart/form-data')); ?>

                <div class="col-md-6">
                    <?php
                    echo $this->Form->input('page', array('type' => 'hidden', 'id' => 'page', 'value' => 'clients', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('pointdevente_id', array('id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select getnumeroclient'));
                    echo $this->Form->input('code', array('id' => 'code', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control testclientexiste', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('name', array('id' => 'name', 'label' => 'Raison social', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('mail', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('tel', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('fax', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('adresse', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('zone_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('siteweb', array('label' => 'Site Web', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('codepostal', array('label' => 'Code Postal', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('banque', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('rib', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('photorib', array('label' => 'Photo Rib', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'file', 'multiple' => "true", 'id' => "file-1"));
                    //debug(CakeSession::read('blocageclient'));
                    if(CakeSession::read('blocageclient')==1){
                    echo $this->Form->input('etat', array('value'=>1,'id' => 'etat', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Etat', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select'));
                    }else{
                    echo $this->Form->input('etat', array('value'=>1,'type'=>'hidden','id' => 'etat','div' => 'form-group', 'label' => 'Etat', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    }
                    echo $this->Form->input('typeclient_id', array('value'=>1,'label' => 'Type Client ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'typeclient_id', 'class' => 'form-control select getsousfamilleclient', 'empty' => 'Veuillez Choisir !!'));
                    ?></div>
                    <div class="col-md-6"><?php
                    echo $this->Form->input('vente', array('empty'=>'Veuillez choisir','label' => 'Type Vente ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('familleclient_id', array('label' => 'Famille ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'familleclient_id', 'class' => 'form-control select getsousfamilleclient', 'empty' => 'Veuillez Choisir !!'));
                    ?>




                    <div class='form-group'>
                        <label class='col-md-2 control-label'><?php echo __('Sous Famille'); ?></label>


                        <div class='col-sm-10' champ="divsousfamilleclient" id="divsousfamilleclient" >     </div>



                    </div>



                    <?php
                    $composantsoc = CakeSession::read('composantsoc');
                    if($composantsoc=="f"){$val=13;}else{$val=2;}
                    echo $this->Form->input('chequejrs', array('label' => 'Max echeance Cheque en jrs', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('traitejrs', array('label' => 'Max echeance Traite en jrs', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));

                    echo $this->Form->input('modeclient_id', array('type'=>'hidden','value'=>2,'label' => 'Autorisation ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'modeclient_id', 'class' => 'form-control ', 'empty' => 'Veuillez Choisir !!'));

                    //echo $this->Form->input('autorisation', array('type' => 'text', 'label' => 'Montant d\'autorisation ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('remise', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('activite', array('label' => 'Activite', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('matriculefiscale', array('id' => 'matriculefiscale', 'label' => 'Matricule fiscale', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control testmatriculefiscale', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('registrecommerce', array('label' => 'Registre de  commerce', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('registrecommercef', array('label' => 'Photo RC', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'file', 'multiple' => "true", 'id' => "file-2"));
                    echo $this->Form->input('patente', array('label' => 'Patente', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'file', 'multiple' => "true", 'id' => "file-4"));
                    echo $this->Form->input('personnel_id', array('value'=>@$val,'label' => 'Agent ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'personnel_id', 'class' => 'form-control select ', 'empty' => 'Veuillez Choisir !!'));
                    //echo $this->Form->input('solde',array('type'=>'text','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                    echo $this->Form->input('avectimbre_id', array('value'=>'Oui','label' => 'Avec timbre ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'avectimbre_id', 'class' => 'form-control select ', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('tva', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
              /*      echo $this->Form->input('Type Clients', array('div' => 'form-group', 'between' => '<div class="col-sm-3">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('Gros', array('type'=>'radio','div' => 'form-group', 'between' => '<div class="col-sm-3">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('Détail', array('type'=>'radio','div' => 'form-group', 'between' => '<div class="col-sm-3">', 'after' => '</div>', 'class' => 'form-control'));*/
                    ?>
				<!--		<td>
						<table>
							<tr>
								<td>Type Clients:</td>
								<td class="col-sm-3">Détail</td>
								<td ><input type="radio" value="detail" name="data[client][typeclient_id]"></td>
								<td class="col-sm-3">Gros</td>
								<td ><input type="radio" value="gros" name="data[client][typeclient_id]"></td>
							</tr>
						</table>
						</td>-->
                </div>

                <!-- Autre contact-->
                <div class="row ligne" >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Contacts'); ?></h3>
                                <a class="btn btn-danger ajouterligne_w" table='addtable' index='index' style="
                                   float: right;
                                   position: relative;
                                   top: -25px;
                                   "><i class="fa fa-plus-circle"  ></i> Ajouter contact</a>
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:90%" align="center" >
                                    <thead>
                                        <tr>
                                            <td align="center" nowrap="nowrap">Nom prénom</td>
                                            <td align="center" nowrap="nowrap">Fonction</td>
                                            <td align="center" nowrap="nowrap">Tel</td>
                                            <td align="center" nowrap="nowrap">Mail</td>
                                            <td align="center"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="tr" style="display:none;">
                                            <td style="width:24%">
                                                <?php echo $this->Form->input('sup', array('name' => '', 'id' => '', 'champ' => 'sup', 'table' => 'Contact', 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                                <?php echo $this->Form->input('name', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Contact', 'index' => '', 'id' => '', 'champ' => 'name', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td style="width:24%">
                                                <?php echo $this->Form->input('fonction', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Contact', 'index' => '', 'id' => '', 'champ' => 'fonction', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td style="width:24%">
                                                <?php echo $this->Form->input('tel', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Contact', 'index' => '', 'id' => '', 'champ' => 'tel', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td style="width:24%">
                                                <?php echo $this->Form->input('mail', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Contact', 'index' => '', 'id' => '', 'champ' => 'mail', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>


                                            <td align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                        </tr>

                                        <tr>
                                            <td style="width:24%">
                                                <?php echo $this->Form->input('sup', array('name' => 'data[Contact][0][sup]', 'id' => 'sup0', 'champ' => 'sup', 'table' => 'Contact', 'index' => '0', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                                <?php echo $this->Form->input('name', array('label' => '', 'div' => 'form-group', 'name' => 'data[Contact][0][name]', 'table' => 'Contact', 'index' => '0', 'id' => 'name0', 'champ' => 'name', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td style="width:24%">
                                                <?php echo $this->Form->input('fonction', array('label' => '', 'div' => 'form-group', 'name' => 'data[Contact][0][fonction]', 'table' => 'Contact', 'index' => '0', 'id' => 'fonction0', 'champ' => 'fonction', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td style="width:24%">
                                                <?php echo $this->Form->input('tel', array('name' => 'data[Contact][0][tel]', 'id' => 'tel0', 'table' => 'Contact', 'index' => '0', 'champ' => 'tel', 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td style="width:24%">
                                                <?php echo $this->Form->input('mail', array('label' => '', 'div' => 'form-group', 'name' => 'data[Contact][0][mail]', 'table' => 'Contact', 'index' => '0', 'id' => 'mail0', 'champ' => 'mail', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td align="center"><i index="0"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" value="0" id="index" />
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row ligne" >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Exonoration TVA'); ?></h3>
                                <a class="btn btn-danger ajouterligne_w" table='addtabletva' index='index' style="
                                   float: right;
                                   position: relative;
                                   top: -25px;
                                   "><i class="fa fa-plus-circle"  ></i> Ajouter exonoration</a>
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtabletva" style="width:90%" align="center" >
                                    <thead>
                                        <tr>
                                            <td align="center" nowrap="nowrap">Numero</td>
                                            <td align="center" nowrap="nowrap">Date debut</td>
                                            <td align="center" nowrap="nowrap">Date fin</td>
<!--                                            <td align="center"></td>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="tr" style="display:none;">
                                            <td style="width:45%">
                                                <?php echo $this->Form->input('sup', array('name' => '', 'id' => '', 'champ' => 'sup', 'table' => 'Exonorationtva', 'index' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'hidden', 'class' => 'form', 'label' => '')); ?>
                                                <?php echo $this->Form->input('numero', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Exonorationtva', 'index' => '', 'id' => '', 'champ' => 'numero', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td style="width:25%">
                                                <?php echo $this->Form->input('datedebut', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Exonorationtva', 'index' => '', 'id' => '', 'champ' => 'datedebut', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td style="width:25%">
                                                <?php echo $this->Form->input('datefin', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Exonorationtva', 'index' => '', 'id' => '', 'champ' => 'datefin', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>



<!--                                            <td align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>-->
                                        </tr>

                                        <tr>
                                            <td style="width:45%">
                                                <?php echo $this->Form->input('sup', array('name' => 'data[Exonorationtva][0][sup]', 'id' => 'sup0', 'champ' => 'sup', 'table' => 'Exonorationtva', 'index' => '0', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                                <?php echo $this->Form->input('numero', array('label' => '', 'div' => 'form-group', 'name' => 'data[Exonorationtva][0][numero]', 'table' => 'Exonorationtva', 'index' => '0', 'id' => 'numero0', 'champ' => 'numero', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td style="width:25%">
                                                <?php echo $this->Form->input('datedebut', array('label' => '', 'div' => 'form-group', 'name' => 'data[Exonorationtva][0][datedebut]', 'table' => 'Exonorationtva', 'index' => '0', 'id' => 'datedebut0', 'champ' => 'datedebut', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control datePickerOnly','type'=>'text')); ?>
                                            </td>
                                            <td style="width:25%">
                                                <?php echo $this->Form->input('datefin', array('name' => 'data[Exonorationtva][0][datefin]', 'id' => 'datefin0', 'table' => 'Exonorationtva', 'index' => '0', 'champ' => 'datefin', 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control datePickerOnly','type'=>'text')); ?>
                                            </td>

<!--                                            <td align="center"><i index="0"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>-->
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" value="0" id="index" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary confirmBox">Enregistrer</button>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

