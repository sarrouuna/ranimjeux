
<?php
$add = "";
$edit = "";
$delete = "";
$imprimer = "";
$lien = CakeSession::read('lien_achat');
//debug($lien_achat);die;
foreach ($lien as $k => $liens) {
    //debug($liens);die;
    if (@$liens['lien'] == 'fournisseurs') {
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
            <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Fournisseurs/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
        </div>

    </div>
<?php } ?>
<div class="row">
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Critere d\'affichage'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Fournisseur', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-8">   
                    <?php echo $this->Form->input('fournisseure', array('empty' => 'Veuillez choisir', 'label' => 'Fournisseur : ', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select')); ?>

                </div>
                <div class="col-md-4">
                    <div class="col-lg-9 col-lg-offset-3" >
                        <button   type="submit" class="btn btn-primary" >Afficher</button> 
                        <a href="<?php echo $this->webroot; ?>Clients/index" class="btn btn-primary">Afficher Tout</a>
                    </div>
                </div>

                <div class="form-group">

                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div></div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Fournisseurs'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="ls-editable-table table-responsive ls-table">
                    <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                        <thead>
                            <tr>

                                <th style="display: none;"><?php echo ('Id'); ?></th>

                                <th><?php echo ('Code'); ?></th> 

                                <th><?php echo ('Famille fournisseur_id'); ?></th>

                                <th><?php echo ('Désignation'); ?></th>

                                <th><?php echo ('Adresse'); ?></th>

                                <th><?php echo ('Tel'); ?></th>

                                <th><?php echo ('Fax'); ?></th>

                                <th><?php echo ('Mail'); ?></th>
                                <th class="actions" align="center"></th>
                            </tr></thead><tbody>
                            <?php
                            foreach ($fournisseurs as $fournisseur):
                                $obj1 = ClassRegistry::init('Deviprospect');
                                $nb1 = $obj1->find('count', array('conditions' => array('Deviprospect.fournisseur_id' => $fournisseur['Fournisseur']['id'])));
                                $obj2 = ClassRegistry::init('Commande');
                                $nb2 = $obj2->find('count', array('conditions' => array('Commande.fournisseur_id' => $fournisseur['Fournisseur']['id'])));
                                $obj3 = ClassRegistry::init('Bonreception');
                                $nb3 = $obj3->find('count', array('conditions' => array('Bonreception.fournisseur_id' => $fournisseur['Fournisseur']['id'])));
                                $obj4 = ClassRegistry::init('Facture');
                                $nb4 = $obj4->find('count', array('conditions' => array('Facture.fournisseur_id' => $fournisseur['Fournisseur']['id'])));
                                $obj5 = ClassRegistry::init('Factureavoirfr');
                                $nb5 = $obj5->find('count', array('conditions' => array('Factureavoirfr.fournisseur_id' => $fournisseur['Fournisseur']['id'])));
                                $obj6 = ClassRegistry::init('Reglement');
                                $nb6 = $obj6->find('count', array('conditions' => array('Reglement.fournisseur_id' => $fournisseur['Fournisseur']['id'])));
                                $nbtotale = $nb1 + $nb2 + $nb3 + $nb4 + $nb5 + $nb6;
                                ?>
                                <tr>
                                    <td style="display:none"><?php echo h($fournisseur['Fournisseur']['id']); ?></td>
                                    <td ><?php echo h($fournisseur['Fournisseur']['code']); ?></td>
                                    <td >
                                        <?php echo $this->Html->link($fournisseur['Famillefournisseur']['name'], array('controller' => 'famillefournisseurs', 'action' => 'view', $fournisseur['Famillefournisseur']['id'])); ?>
                                    </td>

                                    <td ><?php echo h($fournisseur['Fournisseur']['name']); ?></td>
                                    <td ><?php echo h($fournisseur['Fournisseur']['adresse']); ?></td>
                                    <td ><?php echo h($fournisseur['Fournisseur']['tel']); ?></td>
                                    <td ><?php echo h($fournisseur['Fournisseur']['fax']); ?></td>
                                    <td ><?php echo h($fournisseur['Fournisseur']['mail']); ?></td>
                                    <td align="center">
                                        <?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $fournisseur['Fournisseur']['id']), array('escape' => false)); ?>
                                        <?php
                                        if ($edit == 1) {
                                            echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $fournisseur['Fournisseur']['id']), array('escape' => false));
                                        }
                                        ?>
                                        <?php
                                        if (($delete == 1) && ($nbtotale == 0)) {
                                            echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $fournisseur['Fournisseur']['id']), array('escape' => false, null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $fournisseur['Fournisseur']['id']));
                                        }
                                        ?>
                                    </td>
                                </tr>
<?php endforeach; ?>
                        </tbody>
                    </table>

                </div></div></div></div></div>	


