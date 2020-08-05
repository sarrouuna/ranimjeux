<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Bonecarts/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<?php if ($bon[0]['Inventaire']['type'] == 1) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo __('Bon d\'écarts'); ?></h3>
                </div>
                <div class="panel-body">
                    <div class="ls-editable-table table-responsive ls-table">
                        <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                            <thead>
                                <tr>

                                    <th style="display:none"><?php echo ('Id'); ?></th>

                                    <th style="display:none"><?php echo ('Inventaire_id'); ?></th>

                                    <th ><?php echo ('Article'); ?></th>

                                    <th style="display:none"><?php echo ('Depot_id'); ?></th>

                                 

                                    <th ><?php echo ('Qte anc'); ?></th>

                                    <th ><?php echo ('Qte nv'); ?></th>

                                    <th ><?php echo ('écart'); ?></th>

                                    <th ><?php echo ('Prix'); ?></th>

                                    <th ><?php echo ('Prix tot'); ?></th>

                                </tr></thead><tbody>
                                <?php
                                $tot = 0;
                                foreach ($bonecarts as $bonecart):
                                    $tot = $tot + $bonecart['Bonecart']['prixtot'];
                                    
                                    ?>
                                    <tr>
                                        <td style="display:none"><?php echo h($bonecart['Bonecart']['id']); ?></td>
                                        <td style="display:none">
                                            <?php echo $this->Html->link($bonecart['Inventaire']['numero'], array('controller' => 'inventaires', 'action' => 'view', $bonecart['Inventaire']['id'])); ?>
                                        </td>
                                        <td >
                                            <?php echo $this->Html->link($bonecart['Article']['nom'], array('controller' => 'articles', 'action' => 'view', $bonecart['Article']['id'])); ?>
                                        </td>
                                        <td style="display:none">
                                            <?php echo $this->Html->link($bonecart['Depot']['nom'], array('controller' => 'depots', 'action' => 'view', $bonecart['Depot']['id'])); ?>
                                        </td>
                                       
                                        <td><?php echo h($bonecart['Bonecart']['qteanc']); ?></td>
                                        <td ><?php echo h($bonecart['Bonecart']['qtenv']); ?></td>
                                        <td ><?php echo h($bonecart['Bonecart']['quantite']); ?></td>
                                        <td ><?php echo h($bonecart['Bonecart']['prix']); ?></td>
                                        <td><?php echo h($bonecart['Bonecart']['prixtot']); ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            <tfoot>
                            <td colspan="5" align="center"><strong>Totale</strong></td><td><strong><?php echo number_format($tot, 3, '.', ' ') ?></strong></td>
                            </tfoot>
                            </tbody>
                        </table>

                    </div></div></div></div></div>	
<?php } ?>

<?php if ($bon[0]['Inventaire']['type'] == 2) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo __('Bon d\'écarts'); ?></h3>
                </div>
                <div class="panel-body">
                    <div class="ls-editable-table table-responsive ls-table">
                        <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                            <thead>
                                <tr>

                                    <th style="display:none"><?php echo ('Id'); ?></th>

                                    <th style="display:none"><?php echo ('Inventaire_id'); ?></th>

                                    <th ><?php echo ('Depot'); ?></th>

                                    <th style="display:none"><?php echo ('Depot_id'); ?></th>
                                    

                                    <th ><?php echo ('Qte anc'); ?></th>

                                    <th ><?php echo ('Qte nv'); ?></th>

                                    <th ><?php echo ('écart'); ?></th>

                                    <th ><?php echo ('Prix'); ?></th>

                                    <th ><?php echo ('Prix tot'); ?></th>

                                </tr></thead><tbody>
                                <?php
                                $totanc = 0;
                                $totnv = 0;
                                $totecart = 0;
                                $totprix = 0;
                                foreach ($bonecarts as $bonecart):
                                   

                                    $totanc = $totanc + $bonecart['Bonecart']['qteanc'];
                                    $totnv = $totnv + $bonecart['Bonecart']['qtenv'];
                                    $totecart = $totecart + $bonecart['Bonecart']['quantite'];
                                    $totprix = $totprix + $bonecart['Bonecart']['prixtot'];
                                    ?>
                                    <tr>
                                        <td style="display:none"><?php echo h($bonecart['Bonecart']['id']); ?></td>
                                        <td style="display:none">
                                            <?php echo $this->Html->link($bonecart['Inventaire']['numero'], array('controller' => 'inventaires', 'action' => 'view', $bonecart['Inventaire']['id'])); ?>
                                        </td>
                                        <td >
                                            <?php echo $this->Html->link($bonecart['Depot']['code'] . ' ' . $bonecart['Depot']['designation'], array('controller' => 'articles', 'action' => 'view', $bonecart['Depot']['id'])); ?>
                                        </td>
                                        <td style="display:none">
                                            <?php echo $this->Html->link($bonecart['Depot']['nom'], array('controller' => 'depots', 'action' => 'view', $bonecart['Depot']['id'])); ?>
                                        </td>
                                       
                                        <td><?php echo h($bonecart['Bonecart']['qteanc']); ?></td>
                                        <td ><?php echo h($bonecart['Bonecart']['qtenv']); ?></td>
                                        <td ><?php echo h($bonecart['Bonecart']['quantite']); ?></td>
                                        <td ><?php echo h($bonecart['Bonecart']['prix']); ?></td>
                                        <td><?php echo h($bonecart['Bonecart']['prixtot']); ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            <tfoot>
                            <td align="center" colspan="1"><strong>Totale</strong></td>
                            <td><strong><?php echo number_format($totanc, 0, '.', ' ') ?></strong></td>
                            <td><strong><?php echo number_format($totnv, 0, '.', ' ') ?></strong></td>
                            <td><strong><?php echo number_format($totecart, 0, '.', ' ') ?></strong></td>
                            <td><strong></strong></td>
                            <td><strong><?php echo number_format($totprix, 3, '.', ' ') ?></strong></td>
                            </tfoot>
                            </tbody>
                        </table>

                    </div></div></div></div></div>	
<?php } ?>
