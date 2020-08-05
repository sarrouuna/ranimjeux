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
//debug($lien_achat);die;
foreach ($lien as $k => $liens) {
    //debug($liens);die;
    if (@$liens['lien'] == 'factures') {
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
            <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Factures/add/Facture/Lignefacture/facture_id/depense"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
        </div>
    </div>
<?php } ?>
<br>
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
                    echo $this->Form->input('date1', array( 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'type' => 'text', 'label' => 'Date de'));
                    echo $this->Form->input('fournisseur_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Fournisseur', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    if ($countsos > 1) {
                        echo $this->Form->input('societe_id', array('multiple' => 'true', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Societe', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    }
                    echo $this->Form->input('pointdevente_id', array('id' => 'lapv', 'empty' => 'veuillez choisir !!', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                    <div class="" style="display:inline; position: relative;">
                        <?php
                        echo $this->Form->input('fac_id', array('div' => 'form-group', 'index' => '0', 'id' => 'fac_id0', 'champ' => 'fac_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                        echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => 'Code', 'index' => '0', 'id' => 'code0', 'champ' => 'code', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                        ?>
                        <?php
                        ?>
                        <div class="col-dm-6" style="display:inline; position: relative;">
                            <?php echo $this->Form->input('numero', array('div' => 'form-group', 'placeholder' => 'Numero de facture', 'label' => 'N° facture', 'index' => '0', 'id' => 'numfac0', 'champ' => 'numbl', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control numero_facture', 'type' => 'text')); ?>
                            <div class="form-group" style="display:inline; position: relative;bottom: 24px !important;left: 11px;">
                                <label></label>
                                <div id="res0" champ="res" index="0"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php
                    echo $this->Form->input('date2', array( 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'type' => 'text', 'label' => "Jusqu'Ã "));
                    echo $this->Form->input('type_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Type', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('exercice_id', array('value' => $exerciceid, 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'année', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    //echo $this->Form->input('exercice_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'année','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                    ?>

                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                        <a class="btn btn-primary" href="<?php echo $this->webroot; ?>Factures/index"/>Afficher Tout </a>
                        <?php if ($imprimer == 1) { ?>
                            <a  onClick="flvFPW1(wr + 'Factures/imprimerrecherche?fournisseurid=<?php echo @$fournisseurid; ?>&date1=<?php echo @$date1; ?>&date2=<?php echo @$date2; ?>&utilisateurid=<?php echo @$utilisateurid; ?>&typeid=<?php echo @$typeid; ?>&exerciceid=<?php echo @$exerciceid; ?>&fac_id=<?php echo @$fac_id; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                            <a  onClick="flvFPW1(wr + 'Factures/exp_etatexcel?fournisseurid=<?php echo @$fournisseurid; ?>&date1=<?php echo @$date1; ?>&date2=<?php echo @$date2; ?>&utilisateurid=<?php echo @$utilisateurid; ?>&typeid=<?php echo @$typeid; ?>&exerciceid=<?php echo @$exerciceid; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer EXECEL</button> </a>
                        <?php } ?>


                    </div>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Factures'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="ls-editable-table table-responsive ls-table">
                    <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                        <thead>
                            <tr>

                                <th style="display:none;" ><?php echo ('Id'); ?></th>

                                <th><?php echo ('Numero FRS'); ?></th>    
                                <th><?php echo ('Fournisseur'); ?></th>
                                <th><?php echo ('Importation'); ?></th> 	         
                                <th><?php echo ('Date'); ?></th>
                                <th><?php echo ('TTC'); ?></th> 

                                <th><?php echo ('Avoir') . " &nbsp;&nbsp;"; ?></th>
                                <th class="actions" align="center"></th>
                            </tr></thead><tbody>
                            <?php
                            // debug($factures);die;
                            foreach ($factures as $facture):
                                if (empty($facture['Facture']['numero'])) {
                                    $num = $facture['Facture']['numeroconca'];
                                } else {
                                    $num = $facture['Facture']['numero'];
                                }
                                ?>
                                <?php //if($facture['Facture']['exercice_id']==date("Y")){ ?>
                                <tr>
                                    <td style="display:none"><?php echo h($facture['Facture']['id']); ?></td>
                                    <td ><?php echo $facture['Facture']['numero']; ?></td>
                                    <td >
                                        <?php echo $this->Html->link($facture['Fournisseur']['name'], array('controller' => 'fournisseurs', 'action' => 'view', $facture['Fournisseur']['id'])); ?>
                                    </td>
                                    <td >
                                        <?php echo $this->Html->link($facture['Importation']['name'], array('controller' => 'importations', 'action' => 'view', $facture['Importation']['id'])); ?>
                                    </td>
                                    <td ><?php echo h(date("d/m/Y", strtotime(str_replace('-', '/', $facture['Facture']['date'])))); ?></td>
                                    <td ><?php echo h($facture['Facture']['totalttc']); ?></td>
                                    <td align="center">
                                        <?php if (($facture['Facture']['factureavoirfr_id'] == 0)) { ?> 
                                            <?php echo $this->Html->link("<button class='btn btn-xs btn-danger'><i class='fa fa-plus-circle'></i></button> ", array('action' => 'addfactureavoir', $facture['Facture']['id']), array('escape' => false)); ?>
                                        <?php } ?>
                                    </td> 
                                    <td align="center">
                                        <?php
                                        if ($facture['Facture']['type'] == 'service')
                                            echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('controller' => 'Factures', 'action' => 'viewfactureservice', $facture['Facture']['id'], 'Facture', 'Lignefacture', 'facture_id'), array('escape' => false));
                                        else
                                            echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $facture['Facture']['id']), array('escape' => false));
                                        ?>
                                        <?php if ($facture['Facture']['type'] != 'trans_bl') { ?>
                                            <?php
                                            if ($facture['Facture']['transfert'] == 0) {
                                                if (($edit == 1) && ($facture['Facture']['etat'] == 0)) {
                                                    if ($facture['Facture']['type'] == 'service')
                                                        echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('controller' => 'Factures', 'action' => 'editfactureservice', $facture['Facture']['id'], 'Facture', 'Lignefacture', 'facture_id'), array('escape' => false));
                                                    else
                                                        echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('controller' => 'Factures', 'action' => 'edit', $facture['Facture']['id'], 'Facture', 'Lignefacture', 'facture_id'), array('escape' => false));
                                                }
                                            }
                                            ?>
                                        <?php } ?>
                                        <?php
                                        if ($facture['Facture']['transfert'] == 0) {
                                            if (($delete == 1)) {
                                                if ($facture['Facture']['type'] == 'service')
                                                    echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'deletefactureservice', $facture['Facture']['id'], 'Facture', 'Lignefacture', 'facture_id'), array('escape' => false, null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $facture['Facture']['id']));
                                                else
                                                    echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $facture['Facture']['id']), array('escape' => false, null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $facture['Facture']['id']));
                                            }
                                        }
                                        ?>


                                        <?php if ($imprimer == 1) { ?>
                                            <?php if ($facture['Facture']['type'] == 'trans_bl') { ?>
                                                <a onClick="flvFPW1(wr + 'Factures/imprimertrans/' +<?php echo $facture['Facture']['id']; ?>, 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                                            <?php } else if ($facture['Facture']['type'] == 'service') { ?>
                                                <a onClick="flvFPW1(wr + 'Factures/imprimerfactureservice/' +<?php echo $facture['Facture']['id']; ?> + '/Facture/Lignefacture/facture_id', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                                            <?php } else { ?>
                                                <a onClick="flvFPW1(wr + 'Factures/imprimer/' +<?php echo $facture['Facture']['id']; ?>, 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                                                <a onClick="flvFPW1(wr + 'Factures/imprimerbonrecption/' +<?php echo $facture['Facture']['id']; ?>, 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-danger-btn'><i class='fa fa-print'></i></button></a>
                                                <?php if ($facture['Facture']['importation_id'] > 0) { ?>
                                                    <span title="impression en fonction de devise"><a onClick="flvFPW1(wr + 'Factures/imprimerdevise/' +<?php echo $facture['Facture']['id']; ?>, 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-green-btn'><i class='fa fa-print'></i></button></a></span>

                                                <?php } ?>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
<?php endforeach; ?>
                        </tbody>
                    </table>

                </div></div></div></div></div>	


