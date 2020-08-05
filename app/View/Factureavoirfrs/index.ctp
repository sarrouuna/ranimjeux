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
    //if(@$liens['lien']=='factureavoirfrs'){
    $add = 1;
    $edit = 1;
    $delete = 1;
    $imprimer = 1;
    //}
}
?>
<?php if ($add == 1) { ?>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Factureavoirfrs/add/"/> <i class="fa fa-plus-circle"></i> Ajouter facture avoir financier </a>
            <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Factureavoirfrs/addlibre/"/> <i class="fa fa-plus-circle"></i> Ajouter facture avoir libre </a>
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
                <?php echo $this->Form->create('Factureavoirfr', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('date1', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly ', 'type' => 'text', 'label' => 'Date de'));
                    echo $this->Form->input('fournisseur_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Fournisseur', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    $p = CakeSession::read('pointdevente');
                    if ($p == 0) {

                        echo $this->Form->input('pointdevente_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    }
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                    echo $this->Form->input('date2', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'type' => 'text', 'label' => "Jusqu'a "));
                    echo $this->Form->input('typefacture_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Type facture', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('exercice_id', array('value' => $exerciceid, 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'année', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>

                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                        <a class="btn btn-primary" href="<?php echo $this->webroot; ?>Factureavoirfrs/index"/>Afficher Tout </a>
                        <a  onClick="flvFPW1(wr + 'Factureavoirfrs/imprimerexcel?fournisseurid=<?php echo @$fournisseurid; ?>&typefacture_id=<?php echo @$typefactureid; ?>&date1=<?php echo @$date1; ?>&date2=<?php echo @$date2; ?>&exerciceid=<?php echo @$exerciceid; ?>&pointdevente_id=<?php echo @$pointdevente_id; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer EXECEL</button> </a>
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
                <h3 class="panel-title"><?php echo __('Facture Avoir'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="ls-editable-table table-responsive ls-table">
                    <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                        <thead>
                            <tr>

                                <th style="display:none"><?php echo ('id'); ?></th> 
                                
                                <th><?php echo ('Numero'); ?></th>
                                <th><?php echo ('Numero frs'); ?></th>
                                <th><?php echo ('Fournisseur'); ?></th>

                                <th><?php echo ('Date'); ?></th>

                                <th><?php echo ('Point de vente'); ?></th>


                                <th><?php echo ('Totalttc'); ?></th>

                                

                                <th><?php echo ('Type facture'); ?></th>

                                <th class="actions" align="center"></th>
                            </tr></thead><tbody>
                            <?php
                            foreach ($factureavoirs as $factureavoir):
//     debug($factureavoir);die;
                                ?>
                                <tr>
                                    <td style="display:none"><?php echo h($factureavoir['Factureavoirfr']['id']); ?></td>
                                    <td ><?php echo h($factureavoir['Factureavoirfr']['numero']); ?></td>
                                    <td ><?php echo h($factureavoir['Factureavoirfr']['numerofrs']); ?></td>
                                    <td >
                                        <?php echo $this->Html->link($factureavoir['Fournisseur']['name'], array('controller' => 'fournisseurs', 'action' => 'view', $factureavoir['Fournisseur']['id'])); ?>
                                    </td>		
                                    <td ><?php echo h(date("d/m/Y", strtotime(str_replace('-', '/', $factureavoir['Factureavoirfr']['date'])))); ?></td>
                                    <td ><?php echo h($factureavoir['Pointdevente']['name']); ?></td>
                                    <td ><?php echo h($factureavoir['Factureavoirfr']['totalttc']); ?></td>
                                    
                                    <td >
                                        <?php echo $this->Html->link($factureavoir['Typefacture']['name'], array('controller' => 'typefactures', 'action' => 'view', $factureavoir['Typefacture']['id'])); ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        if ($factureavoir['Typefacture']['id'] == 1) {
                                            echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $factureavoir['Factureavoirfr']['id']), array('escape' => false));
                                        } else {
                                            echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'viewf', $factureavoir['Factureavoirfr']['id']), array('escape' => false));
                                        }
                                        ?>
                                        <?php
                                        if (($edit == 1)) {
                                            if ((($factureavoir['Factureavoirfr']['typefacture_id'] == 2))) {
                                                echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $factureavoir['Factureavoirfr']['id']), array('escape' => false));
                                            } else {
                                                if ((($factureavoir['Factureavoirfr']['libre'] == 0))) {
                                                echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array( 'action' => 'editfactureavoir', $factureavoir['Factureavoirfr']['id']), array('escape' => false));
                                                }else{
                                                echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array( 'action' => 'editlibre', $factureavoir['Factureavoirfr']['id']), array('escape' => false));
                                                }
                                                }
                                        }
                                        ?>
                                        <?php
                                        if (($delete == 1) & ($factureavoir['Factureavoirfr']['etat'] == 0)) {
                                            echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $factureavoir['Factureavoirfr']['id']), array('escape' => false, null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $factureavoir['Factureavoirfr']['id']));
                                        }
                                        ?>
                                        <?php
                                        if ($imprimer == 1) {
                                            if ($factureavoir['Typefacture']['id'] == 1) {
                                                ?>    
                                                <a onClick="flvFPW1(wr + 'Factureavoirfrs/imprimerfavr/' +<?php echo $factureavoir['Factureavoirfr']['id']; ?>, 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                                            <?php } else { ?>    
                                                <a onClick="flvFPW1(wr + 'Factureavoirfrs/imprimerfavf/' +<?php echo $factureavoir['Factureavoirfr']['id']; ?>, 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                                            <!--<a onClick="flvFPW1(wr + 'Factures/imprimerfactureservice/' +<?php echo $factureavoir['Factureavoirfr']['id']; ?> + '/Factureavoirfr/Lignefactureavoirfr/factureavoirfr_id', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>-->

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div></div></div></div></div>	


