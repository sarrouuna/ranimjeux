<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Utilisateurs/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Ajout Utilisateur'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Utilisateur', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('personnel_id', array('empty' => 'choix', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select selectptvente', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?>
                    <div class="form-group"> 
                        <label class="col-md-2 control-label">Poste</label>
                        <div class="col-sm-10">    

                            Admin <input type="radio" name="poste" value="0" id="poste1" class="choixposte" checked="checked"> 
                            Point de vente <input type="radio" name="poste" value="1" id="poste2" class="choixposte">

                        </div></div>
                    <div class="pointdevente" style="display: none;" >
                        <?php
                        //  echo $this->Form->input('pointdevente_id',array('empty'=>'Veuillez choisir','label'=>'Point De Vente','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                        ?>

                        <div class='form-group' id='divptvt'  style='display: none !important'> 
                            <label class='col-md-2 control-label'><?php echo __('Point de vente'); ?></label> 
                            <div class='col-sm-10' champ="Pointdevente_id" id="divptvente" >
                            </div>
                        </div>

                    </div>
                    <div class='form-group' id='divsoc'  style='display: none !important'> 
                        <label class='col-md-2 control-label'><?php echo __('Societe'); ?></label> 
                        <div class='col-sm-10' champ="Societe_id" id="divsociete" >
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="col-md-2 control-label">Stock n&eacute;gative</label>
                        <div class="col-sm-10">    

                            NON <input type="radio" name="stocknegatif" value="0" checked="checked"> 
                            OUI <input type="radio" name="stocknegatif" value="1"> 

                        </div></div>
                    <div class="form-group"> 
                        <label class="col-md-2 control-label">Blocage Client</label>
                        <div class="col-sm-10">    

                            NON <input type="radio" name="blocageclient" value="0" checked="checked"> 
                            OUI <input type="radio" name="blocageclient" value="1"> 

                        </div></div>

                </div><div class="col-md-6"><?php
                    echo $this->Form->input('login', array('id' => 'login', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control testutilisateur', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('password', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?>
<!--                    <div class="pointdevente" style="display: none;" >-->
                    <?php
                   // echo $this->Form->input('depot_id', array('empty' => 'Veuillez choisir', 'label' => 'Depot', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?>
<!--                    </div>-->

                        <?php
                    echo $this->Form->input('composantsoc', array('empty'=>'Veuillez choisir','label'=>'Articles&Clients&Frs','div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>

                    <div class='form-group pointdevente' id='divdepot'  style='display: none !important'> 
                            <label class='col-md-2 control-label'><?php echo __('Depot'); ?></label> 
                            <div class='col-sm-10' champ="depot_id" id="div_depot" >
                            </div>
                    </div>
                </div> 






                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading ">
                                <h3 class="panel-title">Droit d'acces</h3>
                            </div>
                            <div class="panel-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs icon-tab">
                                    <li class="active"><a href="#stock" data-toggle="tab"><i class="fa fa-home"></i> <span>Stock</span></a></li>
                                    <li class="param"><a href="#parametrage" data-toggle="tab"><i class="fa fa-gears"></i> <span>Parametrage</span></a></li>
                                    <li class="param"><a href="#achat" data-toggle="tab"><i class="fa fa-gears"></i> <span>Achat</span></a></li>
                                    <li class="vente"><a href="#vente" data-toggle="tab"><i class="fa fa-gears"></i> <span>Vente</span></a></li>
                                    <li class="finance"><a href="#finance" data-toggle="tab"><i class="fa fa-gears"></i> <span>Finance</span></a></li>
                                    <li class="stat"><a href="#stat" data-toggle="tab"><i class="fa fa-gears"></i> <span>Statistique</span></a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content tab-border">


                                    <div class="tab-pane fade in active" id="stock">
                                        <table  cellpadding="4" cellspacing="1" class="table" width="100%">

                                            <tbody>
                                                <tr>
                                                    <td align="center">Autorisation <input type="checkbox" name="acces[]" id="s1" value="1"></td>
                                                    <td align="center">Ajout</td>
                                                    <td align="center">Modification</td>
                                                    <td align="center">Suppression</td>
                                                    <td align="center">Impression</td>
                                                </tr>
                                                <tr class="articles" >
                                                    <td align="left">Article</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[1][Lien][0][add]" id="s2" value="1">
                                                        <input type="hidden"   name="data[1][Lien][0][lien]"  value="articles">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][0][edit]" id="s3" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][0][delete]" id="s4"  value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][0][imprimer]" id="s5" value="1"></td>
                                                </tr>

                                                <tr class="familles" >
                                                    <td align="left">Familles</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[1][Lien][1][add]" id="s6"  value="1">
                                                        <input type="hidden"   name="data[1][Lien][1][lien]"  value="familles">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][1][edit]" id="s7" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][1][delete]" id="s8" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][1][imprimer]" id="s9" value="1"></td>
                                                </tr>


                                                <tr class="sousfamilles" >
                                                    <td align="left">Sous familles</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[1][Lien][2][add]" id="s10" value="1">
                                                        <input type="hidden"   name="data[1][Lien][2][lien]"  value="sousfamilles">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][2][edit]" id="s11" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][2][delete]" id="s12" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][2][imprimer]" id="s13" value="1"></td>
                                                </tr>
                                                <tr class="soussousfamilles" >
                                                    <td align="left">Sous sous familles</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[1][Lien][3][add]" id="s14" value="1">
                                                        <input type="hidden"   name="data[1][Lien][3][lien]"  value="soussousfamilles">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][3][edit]" id="s15" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][3][delete]" id="s16" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][3][imprimer]" id="s17" value="1"></td>
                                                </tr>
                                                <tr class="unites" >
                                                    <td align="left">Unites</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[1][Lien][4][add]" id="s18" value="1">
                                                        <input type="hidden"   name="data[1][Lien][4][lien]"  value="unites">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][4][edit]" id="s19" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][4][delete]" id="s20" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][4][imprimer]" id="s21" value="1"></td>
                                                </tr>

                                                <tr class="transferts" >
                                                    <td align="left">Transferts</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[1][Lien][10][add]" id="s22" value="1">
                                                        <input type="hidden"   name="data[1][Lien][10][lien]"  value="transferts">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][10][edit]" id="s23" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][10][delete]" id="s24" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][10][imprimer]" id="s25" value="1"></td>
                                                </tr>

                                                <tr class="tags" >
                                                    <td align="left">Tags</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[1][Lien][5][add]" id="s26" value="1">
                                                        <input type="hidden"   name="data[1][Lien][5][lien]"  value="tags">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][5][edit]" id="s27" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][5][delete]" id="s28" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][5][imprimer]" id="s29" value="1"></td>
                                                </tr>
                                                <tr class="inventaires" >
                                                    <td align="left">Inventaires</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[1][Lien][6][add]" id="s30" value="1">
                                                        <input type="hidden"   name="data[1][Lien][6][lien]"  value="inventaires">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][6][edit]" id="s31" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][6][delete]" id="s32" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][6][imprimer]" id="s33" value="1"></td>
                                                </tr>
                                                <tr class="depots" >
                                                    <td align="left">Dépots</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[1][Lien][7][add]" id="s34" value="1">
                                                        <input type="hidden"   name="data[1][Lien][7][lien]"  value="depots">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][7][edit]" id="s35" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][7][delete]" id="s36" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][7][imprimer]" id="s37" value="1"></td>
                                                </tr>

                                                <tr class="stockdepots" >
                                                    <td align="left">Etat de Stock</td>
                                                    <td align="center">
                                                        <input type="hidden"   name="data[1][Lien][9][lien]"  value="stockdepots">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][9][imprimer]" id="s38" value="1"></td>
                                                </tr>
                                                <tr class="bonreceptionstocks" >
                                                    <td align="left">Bon Reception </td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[1][Lien][8][add]" id="s39" value="1">
                                                        <input type="hidden"   name="data[1][Lien][8][lien]"  value="bonreceptionstocks">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][8][edit]" id="s40" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][8][delete]" id="s41" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][8][imprimer]" id="s42" value="1"></td>
                                                </tr>
                                                <tr class="bonsortiestocks" >
                                                    <td align="left">Bon Sortie</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[1][Lien][11][add]" id="s43" value="1">
                                                        <input type="hidden"   name="data[1][Lien][11][lien]"  value="bonsortiestocks">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][11][edit]" id="s44" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][11][delete]" id="s45" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][11][imprimer]" id="s46" value="1"></td>
                                                </tr>
                                                <tr class="etatstockmins" >
                                                    <td align="left">Etat de stock Min</td>
                                                    <td align="center">
                                                        <input type="hidden"   name="data[1][Lien][12][lien]"  value="etatstockmins">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][12][imprimer]" id="s47" value="1"></td>
                                                </tr>
                                                <tr class="etatfuturcommandes" >
                                                    <td align="left">Etat Futur Stock</td>
                                                    <td align="center">
                                                        <input type="hidden"   name="data[1][Lien][13][lien]"  value="etatfuturcommandes">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[1][Lien][13][imprimer]" id="s48" value="1"></td>
                                                </tr>
                                                <tr>
                                            <a  index="s" ligne="5" ind="48" class="cocheru">Tout Cocher</a>/
                                            <a  index="s" ligne="5" ind="48" class="decocheru">Tout Decocher</a>
                                            </tr>
                                            </tbody>
                                        </table>


                                    </div>

                                    <div class="tab-pane fade in param" id="parametrage">
                                        <table  cellpadding="4" cellspacing="1" class="table" width="100%">

                                            <tbody>
                                                <tr>
                                                    <td align="center">Autorisation <input type="checkbox" name="acces[]" id="p1" value="2"></td>
                                                    <td align="center">Ajout</td>
                                                    <td align="center">Modification</td>
                                                    <td align="center">Suppression</td>
                                                    <td align="center">Impression</td>
                                                </tr>
                                                <tr class="societes" >
                                                    <td align="left">Societés</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[2][Lien][0][add]" id="p2" value="1">
                                                        <input type="hidden"   name="data[2][Lien][0][lien]"  value="societes">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][0][edit]" id="p3" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][0][delete]" id="p4" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][0][imprimer]" id="p5" value="1"></td>
                                                </tr>
                                                <tr class="pointdeventes" >
                                                    <td align="left">Points De Ventes</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[2][Lien][4][add]" id="p6" value="1">
                                                        <input type="hidden"   name="data[2][Lien][4][lien]"  value="pointdeventes">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][4][edit]" id="p7" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][4][delete]" id="p8" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][4][imprimer]" id="p9" value="1"></td>
                                                </tr>

                                                <tr class="fonctions" >
                                                    <td align="left">Fonctions</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[2][Lien][1][add]" id="p10" value="1">
                                                        <input type="hidden"   name="data[2][Lien][1][lien]"  value="fonctions">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][1][edit]" id="p11" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][1][delete]" id="p12" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][1][imprimer]" id="p13" value="1"></td>
                                                </tr>


                                                <tr class="personnels" >
                                                    <td align="left">Personnels</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[2][Lien][2][add]" id="p14"  value="1">
                                                        <input type="hidden"   name="data[2][Lien][2][lien]"  value="personnels">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][2][edit]" id="p15" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][2][delete]" id="p16" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][2][imprimer]" id="p17" value="1"></td>
                                                </tr>
                                                <tr class="utilisateurs" >
                                                    <td align="left">Utilisateurs</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[2][Lien][3][add]" id="p18" value="1">
                                                        <input type="hidden"   name="data[2][Lien][3][lien]"  value="utilisateurs">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][3][edit]" id="p19" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][3][delete]" id="p20" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][3][imprimer]" id="p21" value="1"></td>
                                                </tr>
                                                <tr class="exercices" >
                                                    <td align="left">Exercices</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[2][Lien][5][add]" id="p22" value="1">
                                                        <input type="hidden"   name="data[2][Lien][5][lien]"  value="exercices">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][5][edit]" id="p23" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][5][delete]" id="p24" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][5][imprimer]" id="p25" value="1"></td>
                                                </tr>
                                                <tr class="workflows" >
                                                    <td align="left">Ordres de travail</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[2][Lien][6][add]" id="p26" value="1">
                                                        <input type="hidden"   name="data[2][Lien][6][lien]"  value="workflows">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][6][edit]" id="p27" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][6][delete]" id="p28" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][6][imprimer]" id="p29" value="1"></td>
                                                </tr>
                                                <tr class="etatworkflows" >
                                                    <td align="left">Etat d'ordres de travail</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[2][Lien][7][add]" id="p30" value="1">
                                                        <input type="hidden"   name="data[2][Lien][7][lien]"  value="etatworkflows">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][7][edit]" id="p31" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][7][delete]" id="p32" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][7][imprimer]" id="p33" value="1"></td>
                                                </tr>
                                                <tr class="tracemisejours" >
                                                    <td align="left">Historique utilisateur</td>
                                                    <td align="center">

                                                        <input type="hidden"   name="data[2][Lien][8][lien]"  value="tracemisejours">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[2][Lien][8][imprimer]" id="p34" value="1"></td>
                                                </tr>
                                                <tr>
                                            <a  index="p" ligne="5" ind="34" class="cocheru">Tout Cocher</a>/
                                            <a  index="p" ligne="5" ind="34" class="decocheru">Tout Decocher</a>
                                            </tr>
                                            </tbody>
                                        </table>


                                    </div>

                                    <div class="tab-pane fade in param" id="achat">
                                        <table  cellpadding="4" cellspacing="1" class="table" width="100%">

                                            <tbody>
                                                <tr>
                                                    <td align="center">Autorisation <input type="checkbox" name="acces[]" id="a1" value="3"></td>
                                                    <td align="center">Ajout</td>
                                                    <td align="center">Modification</td>
                                                    <td align="center">Suppression</td>
                                                    <td align="center">Impression</td>
                                                </tr>
                                                <tr class="fournisseurs" >
                                                    <td align="left">Fournisseurs</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[3][Lien][0][add]" id="a2" value="1">
                                                        <input type="hidden"   name="data[3][Lien][0][lien]"  value="fournisseurs">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][0][edit]" id="a3" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][0][delete]" id="a4" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][0][imprimer]" id="a5" value="1"></td>
                                                </tr>
                                                <tr class="famillefournisseurs" >
                                                    <td align="left">Famille Fournisseurs</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[3][Lien][1][add]" id="a6" value="1">
                                                        <input type="hidden"   name="data[3][Lien][1][lien]"  value="famillefournisseurs">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][1][edit]" id="a7" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][1][delete]" id="a8" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][1][imprimer]" id="a9" value="1"></td>
                                                </tr>
                                                <tr class="bonreceptions" >
                                                    <td align="left">Bons de Livraisons</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[3][Lien][2][add]" id="a10" value="1">
                                                        <input type="hidden"   name="data[3][Lien][2][lien]"  value="bonreceptions">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][2][edit]" id="a11" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][2][delete]" id="a12" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][2][imprimer]" id="a13" value="1"></td>
                                                </tr>
                                                <tr class="factures" >
                                                    <td align="left">Factures</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[3][Lien][3][add]" id="a14" value="1">
                                                        <input type="hidden"   name="data[3][Lien][3][lien]"  value="factures">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][3][edit]" id="a15" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][3][delete]" id="a16" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][3][imprimer]" id="a17" value="1"></td>
                                                </tr>
                                                <tr class="factureavoirfrs" >
                                                    <td align="left">Factures Avoir</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[3][Lien][14][add]" id="a55" value="1">
                                                        <input type="hidden"   name="data[3][Lien][14][lien]"  value="factureavoirfrs">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][14][edit]" id="a56" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][14][delete]" id="a57" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][14][imprimer]" id="a58" value="1"></td>
                                                </tr>
                                                <tr class="deviprospects" >
                                                    <td align="left">Suggestion Commandes</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[3][Lien][10][add]" id="a39" value="1">
                                                        <input type="hidden"   name="data[3][Lien][10][lien]"  value="deviprospects">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][10][edit]" id="a40" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][10][delete]" id="a41" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][10][imprimer]" id="a42" value="1"></td>
                                                </tr>
                                                <tr class="commandes" >
                                                    <td align="left">Commandes</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[3][Lien][4][add]" id="a18" value="1">
                                                        <input type="hidden"   name="data[3][Lien][4][lien]"  value="commandes">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][4][edit]" id="a19" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][4][delete]" id="a20" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][4][imprimer]" id="a21" value="1"></td>
                                                </tr>
                                                <tr class="relevefournisseurs" >
                                                    <td align="left">Releve fournisseurs</td>
                                                    <td align="center">
                                                        <input type="hidden"   name="data[3][Lien][9][lien]"  value="relevefournisseurs">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][9][imprimer]" id="a25" value="1"></td>
                                                </tr>
                                                <tr class="reglements" >
                                                    <td align="left">Reglement</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[3][Lien][5][add]" id="a26" value="1">
                                                        <input type="hidden"   name="data[3][Lien][5][lien]"  value="reglements">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][5][edit]" id="a27" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][5][delete]" id="a28" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][5][imprimer]" id="a29" value="1"></td>
                                                </tr>
                                                <tr class="piecereglements" >
                                                    <td align="left">Etat de caisse</td>
                                                    <td align="center">
                                                        <input type="hidden"   name="data[3][Lien][6][lien]"  value="piecereglements">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][6][imprimer]" id="a30" value="1"></td>
                                                </tr>
                                                <tr class="importations" >
                                                    <td align="left">Importation</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[3][Lien][7][add]" id="a31" value="1">   
                                                        <input type="hidden"   name="data[3][Lien][7][lien]"  value="importations">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][7][edit]" id="a32" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][7][delete]" id="a33" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][7][imprimer]" id="a34" value="1"></td>
                                                </tr>
                                                <tr class="namepiecejointes" >
                                                    <td align="left">Désignation piece jointe</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[3][Lien][8][add]" id="a35" value="1">   
                                                        <input type="hidden"   name="data[3][Lien][8][lien]"  value="namepiecejointes">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][8][edit]" id="a36" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][8][delete]" id="a37" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][8][imprimer]" id="a38" value="1"></td>
                                                </tr>
                                                <tr class="namesituations" >
                                                    <td align="left">Désignation Situation</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[3][Lien][11][add]" id="a43" value="1">   
                                                        <input type="hidden"   name="data[3][Lien][11][lien]"  value="namesituations">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][11][edit]" id="a44" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][11][delete]" id="a45" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][11][imprimer]" id="a46" value="1"></td>
                                                </tr>
                                                <tr class="engagementfournisseurs" >
                                                    <td align="left">Engagement Fournisseur</td>
                                                    <td align="center">
                                                        <input type="hidden"   name="data[3][Lien][11][lien]"  value="engagementfournisseurs">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][12][imprimer]" id="a50" value="1"></td>
                                                </tr>
                                                <tr class="etatpiecereglements" >
                                                    <td align="left">Etat Piece Reglement</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[3][Lien][13][add]" id="a51" value="1">   
                                                        <input type="hidden"   name="data[3][Lien][13][lien]"  value="etatpiecereglements">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][13][edit]" id="a52" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][13][delete]" id="a53" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[3][Lien][13][imprimer]" id="a54" value="1"></td>
                                                </tr>
                                                <tr>
                                            <a  index="a" ligne="5" ind="58" class="cocheru">Tout Cocher</a>/
                                            <a  index="a" ligne="5" ind="58" class="decocheru">Tout Decocher</a>
                                            </tr>
                                            </tbody>
                                        </table>


                                    </div>

                                    <div class="tab-pane fade in vente" id="vente">
                                        <table  cellpadding="4" cellspacing="1" class="table" width="100%">

                                            <tbody>
                                                <tr>
                                                    <td align="center">Autorisation <input type="checkbox" name="acces[]" id="v1" value="4"></td>
                                                    <td align="center">Ajout</td>
                                                    <td align="center">Modification</td>
                                                    <td align="center">Suppression</td>
                                                    <td align="center">Impression</td>
                                                </tr>
                                                <tr class="clients" >
                                                    <td align="left">Clients</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[4][Lien][0][add]" id="v2" value="1">
                                                        <input type="hidden"   name="data[4][Lien][0][lien]"  value="clients">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][0][edit]" id="v3" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][0][delete]" id="v4" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][0][imprimer]" id="v5" value="1"></td>
                                                </tr>
                                                <tr class="familleclients" >
                                                    <td align="left">Familles clients</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[4][Lien][6][add]" id="v6" value="1">
                                                        <input type="hidden"   name="data[4][Lien][6][lien]"  value="familleclients">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][6][edit]" id="v7" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][6][delete]" id="v8" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][6][imprimer]" id="v9" value="1"></td>
                                                </tr>
                                                <tr class="sousfamilleclients" >
                                                    <td align="left">Sous familless clients</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[4][Lien][7][add]" id="v10" value="1">
                                                        <input type="hidden"   name="data[4][Lien][7][lien]"  value="sousfamilleclients">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][7][edit]" id="v11" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][7][delete]" id="v12" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][7][imprimer]" id="v13" value="1"></td>
                                                </tr>
                                                <tr class="pays" >
                                                    <td align="left">Pays</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[4][Lien][13][add]" id="v14" value="1">
                                                        <input type="hidden"   name="data[4][Lien][13][lien]"  value="pays">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][13][edit]" id="v15" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][13][delete]" id="v16" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][13][imprimer]" id="v17" value="1"></td>
                                                </tr>
                                                <tr class="zones" >
                                                    <td align="left">Zones</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[4][Lien][8][add]" id="v18" value="1">
                                                        <input type="hidden"   name="data[4][Lien][8][lien]"  value="zones">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][8][edit]" id="v19" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][8][delete]" id="v20" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][8][imprimer]" id="v21" value="1"></td>
                                                </tr>
                                                <tr class="bonlivraisons" >
                                                    <td align="left">Bon livraisons</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[4][Lien][1][add]" id="v22" value="1">
                                                        <input type="hidden"   name="data[4][Lien][1][lien]"  value="bonlivraisons">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][1][edit]" id="v23" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][1][delete]" id="v24" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][1][imprimer]" id="v25" value="1"></td>
                                                </tr>
                                                <tr class="factureclients" >
                                                    <td align="left">Factures</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[4][Lien][2][add]" id="v26" value="1">
                                                        <input type="hidden"   name="data[4][Lien][2][lien]"  value="factureclients">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][2][edit]" id="v27" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][2][delete]" id="v28" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][2][imprimer]" id="v29" value="1"></td>
                                                </tr>
                                                <tr class="commandeclients" >
                                                    <td align="left">Commandes</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[4][Lien][3][add]" id="v30" value="1">
                                                        <input type="hidden"   name="data[4][Lien][3][lien]"  value="commandeclients">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][3][edit]" id="v31" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][3][delete]" id="v32" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][3][imprimer]" id="v33" value="1"></td>
                                                </tr>
                                                <tr class="devis" >
                                                    <td align="left">Devis</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[4][Lien][4][add]" id="v34" value="1">
                                                        <input type="hidden"   name="data[4][Lien][4][lien]"  value="devis">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][4][edit]" id="v35" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][4][delete]" id="v36" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][4][imprimer]" id="v37" value="1"></td>
                                                </tr>
                                                <tr class="factureavoirs" >
                                                    <td align="left">Factures à voir</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[4][Lien][9][add]" id="v38" value="1">
                                                        <input type="hidden"   name="data[4][Lien][9][lien]"  value="factureavoirs">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][9][edit]" id="v39" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][9][delete]" id="v40" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][9][imprimer]" id="v41" value="1"></td>
                                                </tr>

                                                <tr class="reglementclients" >
                                                    <td align="left">Reglement clients</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[4][Lien][10][add]" id="v42" value="1">
                                                        <input type="hidden"   name="data[4][Lien][10][lien]"  value="reglementclients">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][10][edit]" id="v43" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][10][delete]" id="v44" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][10][imprimer]" id="v45" value="1"></td>
                                                </tr>
                                                <tr class="piecereglementclients" >
                                                    <td align="left">Etat de caisse</td>

                                                    <td align="center"> 
                                                        <input type="hidden"   name="data[4][Lien][11][lien]"  value="piecereglementclients">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"> </td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][11][imprimer]" id="v46" value="1"></td>
                                                </tr>
                                                <tr class="releves" >
                                                    <td align="left">Etat Solde client</td>
                                                    <td align="center">
                                                        <input type="hidden"   name="data[4][Lien][12][lien]"  value="releves">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][12][imprimer]" id="v47" value="1"></td>
                                                </tr>
                                                <tr class="etatsoldecommandeclients" >
                                                    <td align="left">Etat Solde Commandes Clients</td>
                                                    <td align="center">
                                                        <input type="hidden"   name="data[4][Lien][5][lien]"  value="etatsoldecommandeclients">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][5][imprimer]" id="v48" value="1"></td>
                                                </tr>
                                                <tr class="etathistoriquearticles" >
                                                    <td align="left">Historique Article</td>
                                                    <td align="center">

                                                        <input type="hidden"   name="data[4][Lien][14][lien]"  value="etathistoriquearticles">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][14][imprimer]" id="v49" value="1"></td>
                                                </tr>
                                                <tr class="etatligneventes" >
                                                    <td align="left">Vente Journalier</td>
                                                    <td align="center">

                                                        <input type="hidden"   name="data[4][Lien][15][lien]"  value="etatligneventes">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[4][Lien][15][imprimer]" id="v50" value="1"></td>
                                                </tr>
                                                <tr>
                                            <a  index="v" ligne="5" ind="50" class="cocheru">Tout Cocher</a>/
                                            <a  index="v" ligne="5" ind="50" class="decocheru">Tout Decocher</a>
                                            </tr>
                                            </tbody>
                                        </table>


                                    </div>   

                                    <div class="tab-pane fade in finance" id="finance">
                                        <table  cellpadding="4" cellspacing="1" class="table" width="100%">

                                            <tbody>
                                                <tr>
                                                    <td align="center">Autorisation <input type="checkbox" name="acces[]" id="f1" value="5"></td>
                                                    <td align="center">Ajout</td>
                                                    <td align="center">Modification</td>
                                                    <td align="center">Suppression</td>
                                                    <td align="center">Impression</td>
                                                </tr>
                                                <tr class="comptes" >
                                                    <td align="left">Comptes</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[5][Lien][0][add]" id="f2" value="1">
                                                        <input type="hidden"   name="data[5][Lien][0][lien]"  value="comptes">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][0][edit]" id="f3" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][0][delete]" id="f4" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][0][imprimer]" id="f5" value="1"></td>
                                                </tr>

                                                <tr class="carnetcheques" >
                                                    <td align="left">Souche chequier</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[5][Lien][9][add]" id="f6" value="1">
                                                        <input type="hidden"   name="data[5][Lien][9][lien]"  value="carnetcheques">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][9][edit]" id="f7" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][9][delete]" id="f8" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][9][imprimer]" id="f9" value="1"></td>
                                                </tr>
                                                <tr class="bordereaus" >
                                                    <td align="left">Bordereaus</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[5][Lien][1][add]" id="f10" value="1">
                                                        <input type="hidden"   name="data[5][Lien][1][lien]"  value="bordereaus">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][1][edit]" id="f11" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][1][delete]" id="f12" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][1][imprimer]" id="f13" value="1"></td>
                                                </tr>
                                                <tr class="alimentations" >
                                                    <td align="left">Alimentation caisse</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[5][Lien][10][add]" id="f14" value="1">
                                                        <input type="hidden"   name="data[5][Lien][10][lien]"  value="alimentations">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][10][edit]" id="f15" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][10][delete]" id="f16" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][10][imprimer]" id="f17" value="1"></td>
                                                </tr>
                                                <tr class="versements" >
                                                    <td align="left">Versements</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[5][Lien][2][add]" id="f18" value="1">
                                                        <input type="hidden"   name="data[5][Lien][2][lien]"  value="versements">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][2][edit]" id="f19" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][2][delete]" id="f20" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][2][imprimer]" id="f21" value="1"></td>
                                                </tr>
                                                <tr class="sortiecaissees" >
                                                    <td align="left">Sortie caisse</td>
                                                    <td align="center">
                                                        <input type="checkbox" name="data[5][Lien][3][add]" id="f22" value="1">
                                                        <input type="hidden"   name="data[5][Lien][3][lien]"  value="sortiecaissees">
                                                    </td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][3][edit]" id="f23" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][3][delete]" id="f24" value="1"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][3][imprimer]" id="f25" value="1"></td>
                                                </tr>
                                                <tr class="interne" >
                                                    <td align="left">Caisse interne </td>
                                                    <td align="center">
                                                        <input type="hidden"   name="data[5][Lien][11][lien]"  value="interne">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][11][imprimer]" id="f26" value="1"></td>
                                                </tr>
                                                <tr class="caissees" >
                                                    <td align="left">Caisse</td>
                                                    <td align="center">
                                                        <input type="hidden"   name="data[5][Lien][4][lien]"  value="caissees">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][4][imprimer]" id="f27" value="1"></td>
                                                </tr>
                                                <tr class="retenue" >
                                                    <td align="left">Retenue Clients</td>
                                                    <td align="center">
                                                        <input type="hidden"   name="data[5][Lien][5][lien]"  value="retenue">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][5][imprimer]" id="f28" value="1"></td>
                                                </tr>
                                                <tr class="retenuefournisseur" >
                                                    <td align="left">Retenue Fournisseurs</td>
                                                    <td align="center">
                                                        <input type="hidden"   name="data[5][Lien][6][lien]"  value="retenuefournisseur">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][6][imprimer]" id="f29" value="1"></td>
                                                </tr>
                                                <tr class="etatvente" >
                                                    <td align="left">Etat des ventes</td>
                                                    <td align="center">
                                                        <input type="hidden"   name="data[5][Lien][7][lien]"  value="etatvente">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][7][imprimer]" id="f30" value="1"></td>
                                                </tr>
                                                <tr class="etatachat" >
                                                    <td align="left">Etat des achats</td>
                                                    <td align="center">
                                                        <input type="hidden"   name="data[5][Lien][8][lien]"  value="etatachat">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[5][Lien][8][imprimer]" id="f31" value="1"></td>
                                                </tr>
                                                <tr>
                                            <a  index="f" ligne="5" ind="31" class="cocheru">Tout Cocher</a>/
                                            <a  index="f" ligne="5" ind="31" class="decocheru">Tout Decocher</a>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="tab-pane fade in param" id="stat">
                                        <table  cellpadding="4" cellspacing="1" class="table" width="100%">

                                            <tbody>
                                                <tr>
                                                    <td align="center">Autorisation <input type="checkbox" name="acces[]" id="st1" value="6"></td>
                                                    <td align="center">Ajout</td>
                                                    <td align="center">Modification</td>
                                                    <td align="center">Suppression</td>
                                                    <td align="center">Impression</td>
                                                </tr>
                                                <tr class="etatclients" >
                                                    <td align="left">CA par client</td>
                                                    <td align="center">

                                                        <input type="hidden"   name="data[6][Lien][0][lien]"  value="etatclients">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[6][Lien][0][imprimer]" id="st2" value="1"></td>
                                                </tr>
                                                <tr class="etatarticles" >
                                                    <td align="left">CA par Article</td>
                                                    <td align="center">

                                                        <input type="hidden"   name="data[6][Lien][1][lien]"  value="etatarticles">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[6][Lien][1][imprimer]" id="st3" value="1"></td>
                                                </tr>

                                                <tr class="etatclientarticles" >
                                                    <td align="left">CA par client/Article</td>
                                                    <td align="center">

                                                        <input type="hidden"   name="data[6][Lien][2][lien]"  value="etatclientarticles">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[6][Lien][2][imprimer]" id="st4" value="1"></td>
                                                </tr>


                                                <tr class="etatpointdeventes" >
                                                    <td align="left">CA par Point De Vente</td>
                                                    <td align="center">

                                                        <input type="hidden"   name="data[6][Lien][3][lien]"  value="etatpointdeventes">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[6][Lien][3][imprimer]" id="st5" value="1"></td>
                                                </tr>
                                                <tr class="etatcaarticles" >
                                                    <td align="left">CA par Article/Année</td>
                                                    <td align="center">

                                                        <input type="hidden"   name="data[6][Lien][4][lien]"  value="etatcaarticles">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[6][Lien][4][imprimer]" id="st6" value="1"></td>
                                                </tr>

                                                <tr class="etatcaclientarticles" >
                                                    <td align="left">CA par Client/Année</td>
                                                    <td align="center">

                                                        <input type="hidden"   name="data[6][Lien][5][lien]"  value="etatcaclientarticles">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[6][Lien][5][imprimer]" id="st7" value="1"></td>
                                                </tr>

                                                <tr class="etatcapersonnels" >
                                                    <td align="left">CA par Personnel</td>
                                                    <td align="center">

                                                        <input type="hidden"   name="data[6][Lien][6][lien]"  value="etatcapersonnels">
                                                    </td>
                                                    <td align="center"></td>
                                                    <td align="center"></td>
                                                    <td align="center"><input type="checkbox" name="data[6][Lien][6][imprimer]" id="st8" value="1"></td>
                                                </tr>
                                                <tr>
                                            <a  index="st" ligne="5" ind="8" class="cocheru">Tout Cocher</a>/
                                            <a  index="st" ligne="5" ind="8" class="decocheru">Tout Decocher</a>
                                            </tr>
                                            </tbody>
                                        </table>


                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>






                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>


            </div>
        </div>
    </div>

