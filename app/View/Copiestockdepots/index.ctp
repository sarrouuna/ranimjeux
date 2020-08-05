<?php
$add = "";
$edit = "";
$delete = "";
$imprimer = "";
$lien = CakeSession::read('lien_stock');
//debug($lien_stock);die;
foreach ($lien as $k => $liens) {
    //debug($liens);die;
    if (@$liens['lien'] == 'copiestocks') {
        $add = $liens['add'];
        $edit = $liens['edit'];
        $delete = $liens['delete'];
        $imprimer = $liens['imprimer'];
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Copiestockdepots/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>

</div>

<br><input type="hidden" id="page" value="1"/>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Copie stock depots'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="ls-editable-table table-responsive ls-table">
                    <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                        <thead>
                            <tr>

                                <th style="display:none"><?php echo $this->Paginator->sort('Id'); ?></th>

                                <th><?php echo $this->Paginator->sort('Numero'); ?></th>

                                <th><?php echo $this->Paginator->sort('Inventaire_id'); ?></th>

                                <th style="display:none"><?php echo $this->Paginator->sort('Exercice_id'); ?></th>

                                <th><?php echo $this->Paginator->sort('Date'); ?></th>

                                <th><?php echo $this->Paginator->sort('Heure'); ?></th>

                                <th style="display:none"><?php echo $this->Paginator->sort('Utilisateur_id'); ?></th>
                                <th class="actions" align="center"></th>
                            </tr></thead><tbody>
                            <?php foreach ($copiestockdepots as $copiestockdepot): ?>
                                <tr>
                                    <td style="display:none"><?php echo h($copiestockdepot['Copiestockdepot']['id']); ?></td>
                                    <td ><?php echo h($copiestockdepot['Copiestockdepot']['numero']); ?></td>
                                    <td >
                                        <?php echo $this->Html->link($copiestockdepot['Inventaire']['numero'], array('controller' => 'inventaires', 'action' => 'view', $copiestockdepot['Inventaire']['id'])); ?>
                                    </td>
                                    <td style="display:none">
                                        <?php echo $this->Html->link($copiestockdepot['Exercice']['name'], array('controller' => 'exercices', 'action' => 'view', $copiestockdepot['Exercice']['id'])); ?>
                                    </td>
                                    <td ><?php echo h($copiestockdepot['Copiestockdepot']['date']); ?></td>
                                    <td ><?php echo h($copiestockdepot['Copiestockdepot']['heure']); ?></td>
                                    <td style="display:none"><?php echo h($copiestockdepot['Copiestockdepot']['utilisateur_id']); ?></td>
                                    <td align="center">
                                        <?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $copiestockdepot['Copiestockdepot']['id']), array('escape' => false)); ?>
                                        <?php
                                        $obj = ClassRegistry::init('Inventaire');
                                        $inventaires = $obj->find('first', array(
                                            'conditions' => array('Inventaire.id' => $copiestockdepot['Inventaire']['id'], 'Inventaire.valide' => 1))
                                        );
                                        
                                        
                                        if ($edit == 1){
                                        if ($inventaires == array()) {
                                            ?>

                                            <?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $copiestockdepot['Copiestockdepot']['id']), array('escape' => false)); ?>
                                            <?php
                                            //echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $copiestockdepot['Copiestockdepot']['id']), array('escape' => false, null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $copiestockdepot['Copiestockdepot']['id']));
                                        }}
                                        ?>
                                    </td>
                                </tr>
<?php endforeach; ?>
                        </tbody>
                    </table>

                </div></div></div></div></div>	


