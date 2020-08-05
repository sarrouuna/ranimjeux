<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Clients/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<input type="hidden" value="edit" id="operation">
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Modification Client'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Client', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultF', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh', 'enctype' => 'multipart/form-data')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('id', array('id' => 'clientid', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control testclientexiste'));
                    echo $this->Form->input('page', array('type' => 'hidden', 'id' => 'page', 'value' => 'clients', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('pointdevente_id', array('id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select getnumeroclient'));
                    echo $this->Form->input('code', array('id' => 'code', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('name', array('id' => 'name', 'label' => 'Raison social', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('mail', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('tel', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('fax', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('zone_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('adresse', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('siteweb', array('label' => 'Site Web', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('codepostal', array('label' => 'Code Postal', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));

                    echo $this->Form->input('banque', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('rib', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('photorib', array('label' => 'Photo Rib', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'file', 'multiple' => "true", 'id' => "file-1"));
                    if(CakeSession::read('blocageclient')==1){
                    echo $this->Form->input('etat', array('id' => 'etat', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Etat', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select'));
                    }
                    echo $this->Form->input('typeclient_id', array('label' => 'Type Client ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'typeclient_id', 'class' => 'form-control select getsousfamilleclient', 'empty' => 'Veuillez Choisir !!'));
                    ?></div>
                <div class="col-md-6"><?php
                    echo $this->Form->input('vente', array('label' => 'Type Vente ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('familleclient_id', array('label' => 'Famille ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'familleclient_id', 'class' => 'form-control select getsousfamilleclient', 'empty' => 'Veuillez Choisir !!'));
                    ?>

                    <div class='form-group sfe' style="display:none" >

                        <label class='col-md-2 control-label'><?php echo __('Sous Famille'); ?></label>	
                        <div class='col-sm-10' champ="divsousfamilleclient" id="divsousfamilleclient" >        </div>

                    </div>  

                    <div class="sf"><?php echo $this->Form->input('sousfamilleclient_id', array('label' => 'Sous Famille', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'sousfamille_id', 'class' => 'form-control select getsoussousfamille', 'empty' => 'Veuillez Choisir !!')); ?></div> 
                    <?php
                    echo $this->Form->input('chequejrs', array('label' => 'Max echeance Cheque en jrs', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('traitejrs', array('label' => 'Max echeance Traite en jrs', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    if(CakeSession::read('blocageclient')==1){
                    echo $this->Form->input('modeclient_id', array('label' => 'Autorisation de vente en crédit', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'modeclient_id', 'class' => 'form-control select ', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('nbrmois', array('type' => 'text', 'label' => 'Nbr Mois', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    }
                    //echo $this->Form->input('autorisation', array('type' => 'text', 'label' => 'Montant d\'autorisation ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('remise', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('activite', array('label' => 'Activite', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('matriculefiscale', array('id' => 'matriculefiscale', 'label' => 'Matricule fiscale', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control testmatriculefiscale', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('registrecommerce', array('label' => 'Registre de  commerce', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('registrecommercef', array('label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'file', 'multiple' => "true", 'id' => "file-2"));
                    echo $this->Form->input('patente', array('label' => 'Patente', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'file', 'multiple' => "true", 'id' => "file-3"));
                    echo $this->Form->input('personnel_id', array('label' => 'Agent ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'personnel_id', 'class' => 'form-control select ', 'empty' => 'Veuillez Choisir !!'));
                    //echo $this->Form->input('solde',array('type'=>'text','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                    echo $this->Form->input('avectimbre_id', array('label' => 'Avec timbre ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'id' => 'avectimbre_id', 'class' => 'form-control select ', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('tva', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
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
                                        <?php
                                        foreach ($contacts as $i => $contact) {
                                            ?>  
                                            <tr>
                                                <td style="width:24%">
                                                    <?php echo $this->Form->input('id', array('value' => $contact['Contact']['id'], 'name' => 'data[Contact][' . $i . '][id]', 'id' => 'id' . $i, 'champ' => 'id', 'table' => 'Contact', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                                    <?php echo $this->Form->input('sup', array('name' => 'data[Contact][' . $i . '][sup]', 'id' => 'sup0', 'champ' => 'sup', 'table' => 'Contact', 'index' => '0', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                                    <?php echo $this->Form->input('name', array('value' => $contact['Contact']['name'], 'label' => '', 'div' => 'form-group', 'name' => 'data[Contact][' . $i . '][name]', 'table' => 'Contact', 'index' => $i, 'id' => 'name' . $i, 'champ' => 'name', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                </td>
                                                <td style="width:24%">
                                                    <?php echo $this->Form->input('fonction', array('value' => $contact['Contact']['fonction'], 'label' => '', 'div' => 'form-group', 'name' => 'data[Contact][' . $i . '][fonction]', 'table' => 'Contact', 'index' => $i, 'id' => 'fonction' . $i, 'champ' => 'fonction', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                </td>
                                                <td style="width:24%">
                                                    <?php echo $this->Form->input('tel', array('value' => $contact['Contact']['tel'], 'name' => 'data[Contact][' . $i . '][tel]', 'id' => 'tel' . $i, 'table' => 'Contact', 'index' => $i, 'champ' => 'tel', 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                </td>
                                                <td style="width:24%">
                                                    <?php echo $this->Form->input('mail', array('value' => $contact['Contact']['mail'], 'label' => '', 'div' => 'form-group', 'name' => 'data[Contact][' . $i . '][mail]', 'table' => 'Contact', 'index' => $i, 'id' => 'mail' . $i, 'champ' => 'mail', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                </td>
                                                <td align="center"><i index="<?php echo $i; ?>"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>

                                            </tr>
                                        <?php } ?> 
                                    </tbody>
                                </table>
                                <input type="hidden" value=<?php echo @$i; ?>  id="index" />
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

                                         <?php
                                        foreach ($exos as $k => $x) {
                                            ?> 
                                        <tr>
                                            <td style="width:45%">
                                                <?php echo $this->Form->input('id', array('value' => $x['Exonorationclient']['id'], 'name' => 'data[Exonorationtva][' . $k . '][id]', 'id' => 'id' . $k, 'champ' => 'id', 'table' => 'Exonorationtva', 'index' => $k, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                <?php echo $this->Form->input('sup', array('name' => 'data[Exonorationtva][' . $k . '][sup]', 'id' => 'sup'. $k, 'champ' => 'sup', 'table' => 'Exonorationtva', 'index' => $k, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                <?php echo $this->Form->input('numero', array('value' => $x['Exonorationclient']['num_exe'],'label' => '', 'div' => 'form-group', 'name' => 'data[Exonorationtva][' . $k . '][numero]', 'table' => 'Exonorationtva', 'index' => $k, 'id' => 'numero'. $k, 'champ' => 'numero', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td style="width:25%">
                                                <?php echo $this->Form->input('datedebut', array('value' => date("d/m/Y", strtotime(str_replace('-', '/',$x['Exonorationclient']['datedu']))),'label' => '', 'div' => 'form-group', 'name' => 'data[Exonorationtva][' . $k . '][datedebut]', 'table' => 'Exonorationtva', 'index' => $k, 'id' => 'datedebut'. $k, 'champ' => 'datedebut', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control datePickerOnly','type'=>'text')); ?>
                                            </td>
                                            <td style="width:25%">
                                                <?php echo $this->Form->input('datefin', array('value' => date("d/m/Y", strtotime(str_replace('-', '/',$x['Exonorationclient']['dateau']))),'name' => 'data[Exonorationtva][' . $k . '][datefin]', 'id' => 'datefin'. $k, 'table' => 'Exonorationtva', 'index' => $k, 'champ' => 'datefin', 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control datePickerOnly','type'=>'text')); ?>
                                            </td>
                                            
<!--                                            <td align="center"><i index="<?php echo @$k; ?>"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>-->
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <input type="hidden" value="<?php echo @$k; ?>" id="index" />
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

