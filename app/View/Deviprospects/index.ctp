<script language="JavaScript" type="text/JavaScript">

    function flvFPW1(){

    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    }
</script>
<?php
$add = "";
$edit = "";
$delete = "";
$imprimer = "";
$lien = CakeSession::read('lien_achat');
foreach ($lien as $k => $liens) {
    //debug($liens);die;
    if (@$liens['lien'] == 'deviprospects') {
        $add = $liens['add'];
        $edit = $liens['edit'];
        $delete = $liens['delete'];
        $imprimer = $liens['imprimer'];
    }
}
if ($add == 1) {
    ?>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Factures/add/Deviprospect/Lignedeviprospect/deviprospect_id"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
        </div>

    </div>
<?php } ?>
<br><input type="hidden" id="page" value="1"/>


<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Recherche', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('date1', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'type' => 'text', 'label' => 'Date de'));
                    echo $this->Form->input('fournisseur_id', array('empty' => 'veuillez choisir !!', 'div' => 'form-group', 'label' => 'Fournisseur', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    if ($countsos > 1) {
                        echo $this->Form->input('societe_id', array('multiple' => 'true', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Societe', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    }
                    echo $this->Form->input('pointdevente_id', array('id' => 'lapv', 'empty' => 'veuillez choisir !!', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                    echo $this->Form->input('verif', array('id' => 'verif', 'type' => 'hidden', 'value' => 0, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('date2', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'type' => 'text', 'label' => "Jusqu'à "));
                    echo $this->Form->input('importation_id', array('empty' => 'veuillez choisir !!', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('exercice_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'année', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>

                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary btntras" id="aff">Chercher</button>  
                        <button type="submit" class="btn btn-primary btntras" id="afftt">Afficher tout</button>  

                    </div>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Suggestion Commande'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="ls-editable-table table-responsive ls-table">
                    <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                        <thead>
                            <tr>

                                <th style="display:none"><?php echo ('Id'); ?></th>

                                <th><?php echo ('Fournisseur'); ?></th>
                                <th><?php echo ('Importation'); ?></th> 
                                <th style="display:none"><?php echo ('Utilisateur'); ?></th>

                                <th style="display:none"><?php echo ('Depot'); ?></th>

                                <th style="display:none"><?php echo ('Facture'); ?></th>

                                <th style="display:none"><?php echo ('Etat'); ?></th>

                                <th><?php echo ('Numero'); ?></th>

                                <th><?php echo ('Coefficient'); ?></th>

                                <th style="display:none"><?php echo ('Numeroconca'); ?></th>

                                <th><?php echo ('Date'); ?></th>


                                <th><?php echo ('Tva'); ?></th>

                                <th><?php echo ('devise'); ?></th>

                                <th><?php echo ('Totalht'); ?></th>

                                <th><?php echo ('Totalttc'); ?></th>

                                <th style="display:none"><?php echo ('Pointdevente_id'); ?></th>

                                <th style="display:none"><?php echo ('Exercice_id'); ?></th>
                                <th class="actions" align="center"></th>
                                <th class="actions" align="center"></th>
                            </tr>
                        </thead><tbody>
                            <?php
                            //debug($deviprospects);
                            foreach ($deviprospects as $i => $deviprospect):
                                ?>
                                <tr>
                                    <td style="display:none"><?php echo h($deviprospect['Deviprospect']['id']); ?></td>
                                    <td >
                                        <?php echo $this->Html->link($deviprospect['Fournisseur']['name'], array('controller' => 'fournisseurs', 'action' => 'view', $deviprospect['Fournisseur']['id'])); ?>
                                    </td>
                                    <td >
                                        <?php echo $this->Html->link($deviprospect['Importation']['name'], array('controller' => 'importations', 'action' => 'view', $deviprospect['Importation']['id'])); ?>
                                    </td>
                                    <td style="display:none">
                                        <?php echo $this->Html->link($deviprospect['Utilisateur']['name'], array('controller' => 'utilisateurs', 'action' => 'view', $deviprospect['Utilisateur']['id'])); ?>
                                    </td>
                                    <td style="display:none">
                                        <?php echo $this->Html->link($deviprospect['Depot']['nom'], array('controller' => 'depots', 'action' => 'view', $deviprospect['Depot']['id'])); ?>
                                    </td>
                                    <td style="display:none">
                                        <?php echo $this->Html->link($deviprospect['Facture']['id'], array('controller' => 'factures', 'action' => 'view', $deviprospect['Facture']['id'])); ?>
                                    </td>
                                    <td style="display:none"><?php echo h($deviprospect['Deviprospect']['etat']); ?></td>
                                    <td ><?php echo h($deviprospect['Deviprospect']['numero']); ?></td>
                                    <td ><?php echo sprintf('%.3f', h($deviprospect['Deviprospect']['coefficient'])); ?></td>
                                    <td style="display:none"><?php echo h($deviprospect['Deviprospect']['numeroconca']); ?></td>
                                    <td ><?php echo date("d-m-Y", strtotime(str_replace('/', '-', h($deviprospect['Deviprospect']['date'])))); ?></td>
                                    <td ><?php echo h($deviprospect['Deviprospect']['tva']); ?></td>
                                    <td ><?php echo h($deviprospect['Deviprospect']['montantdevise']); ?></td>
                                    <td ><?php echo h($deviprospect['Deviprospect']['totalht']); ?></td>
                                    <td ><?php echo h($deviprospect['Deviprospect']['totalttc']); ?></td>
                                    <td style="display:none">
                                        <?php echo $this->Html->link($deviprospect['Pointdevente']['name'], array('controller' => 'pointdeventes', 'action' => 'view', $deviprospect['Pointdevente']['id'])); ?>
                                    </td>
                                    <td style="display:none">
                                        <?php echo $this->Html->link($deviprospect['Exercice']['name'], array('controller' => 'exercices', 'action' => 'view', $deviprospect['Exercice']['id'])); ?>
                                    </td>
                                    <td>
                                        <?php if (($deviprospect['Deviprospect']['trasfert'] == 0) && ($deviprospect['Deviprospect']['etat'] == 1)) { ?>
                                <center>
                                    <?php echo $this->Html->link("<button class='btn btn-xs btn-danger'><i class='fa fa-check'></i></button>", array('controller' => 'Commandes', 'action' => 'addfromdevis', $deviprospect['Deviprospect']['id']), array('escape' => false)); ?>
                                </center>
                            <?php } ?>
                            </td>
                            <td align="center">
                                <?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $deviprospect['Deviprospect']['id']), array('escape' => false)); ?>
                                <?php if (($deviprospect['Deviprospect']['trasfert'] == 0)) { ?>
                                    <?php
                                    if ($edit == 1) {
                                        echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('controller' => 'Factures', 'action' => 'edit', $deviprospect['Deviprospect']['id'], 'Deviprospect', 'Lignedeviprospect', 'deviprospect_id'), array('escape' => false));
                                    }
                                    ?>
                                    <?php
                                    if ($delete == 1) {
                                        echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $deviprospect['Deviprospect']['id']), array('escape' => false, null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $deviprospect['Deviprospect']['id']));
                                    }
                                    ?>
                                <?php } ?>
                                <?php if ($imprimer == 1) { ?>    <a onClick="flvFPW1(wr + 'Deviprospects/imprimer/' +<?php echo $deviprospect['Deviprospect']['id']; ?>, 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a><?php } ?>
                                <?php if ($imprimer == 1) { ?>    <a onClick="flvFPW1(wr + 'Deviprospects/imprimersansprix/' +<?php echo $deviprospect['Deviprospect']['id']; ?>, 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-yellow-btn'><i class='fa fa-print'></i></button></a><?php } ?>
                                <?php if ($imprimer == 1) { ?>    <a onClick="flvFPW1(wr + 'Deviprospects/exp_etatexcel/' +<?php echo $deviprospect['Deviprospect']['id']; ?>, 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-red-btn'><i class='fa fa-print'></i></button></a><?php } ?>
                            <spam title="duplication"><a class="affichediplicationfrs"  id="affichediplication" value="<?php echo $deviprospect['Deviprospect']['id'] ?>"><button class='btn btn-xs btn-success'> <i class="fa fa-files-o"></i></button>  </a></spam>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table><br><br><br>
                    <div class="col-md-6 selectdip" style="display:none;"> 
                        <?php echo $this->Form->input('typedipliquation_id', array('label' => 'Type Duplication', 'id' => 'typedipliquation_id', 'div' => 'form-group', 'between' => '<div class="col-sm-6">', 'after' => '</div>', 'class' => 'form-control ', 'empty' => 'Veuillez Choisir !!'));
                        ?>
                    </div>
                    <div class="col-md-6 boutselect" style="display:none;">
                        <div class="col-md-12  diplique" >
                            <input type="hidden" name="tes" value="0" class="tes" id="testvalue"/>
                            <input type="hidden" name="tes" value="Deviprospect" class="tes" id="model"/>
                            <input type="hidden" name="tes" value="Lignedeviprospect" class="tes" id="ligne"/>
                            <input type="hidden" name="tes" value="deviprospect_id" class="tes" id="attr"/>
                            <a class="btn btn btn-danger modeladdfrs"  id="modeladd"> <i class="fa fa-plus-circle"></i> Créer </a>          
                        </div> 

                    </div>

                </div></div></div></div></div>	


