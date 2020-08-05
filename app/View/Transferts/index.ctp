<script language="JavaScript" type="text/JavaScript">

    function flvFPW1(){

    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    }
    $(document).ready(function() {

    $(".iframe").colorbox({iframe:true, width:"60%", height:"60%", href: function(){
    return  wr+"Bonlivraisons/choix/"+$(this).attr('id');
    }})
    });
</script>


<?php
$add = "";
$edit = "";
$delete = "";
$imprimer = "";
$lien = CakeSession::read('lien_stock');
foreach ($lien as $k => $liens) {
    //debug($liens);die;
    if (@$liens['lien'] == 'transferts') {
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
            <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Transferts/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
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
                    echo $this->Form->input('date1', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'label' => 'Date de'));
                    echo $this->Form->input('depot_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Depot', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                    echo $this->Form->input('date2', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'type' => 'text', 'label' => "Jusqu'a "));
                    echo $this->Form->input('exercice_id', array('value' => @$exerciceid, 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'année', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>

                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                        <a class="btn btn-primary" href="<?php echo $this->webroot; ?>Transferts/index"/>Afficher Tout </a>
                        <a  onClick="flvFPW1(wr + 'Transferts/imprimerrecherche?&date1=<?php echo @$date1; ?>&date2=<?php echo @$date2; ?>&exerciceid=<?php echo @$exerciceid; ?>&depotid=<?php echo @$depotid; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
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
                <h3 class="panel-title"><?php echo __('Transferts'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="ls-editable-table table-responsive ls-table">
                    <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                        <thead>
                            <tr>

                                <th style="display:none"><?php echo ('Id'); ?></th>

                                <th><?php echo ('Numero'); ?></th>

                                <th><?php echo ('Date'); ?></th>

                                <th style="display:none"><?php echo ('Utilisateur_id'); ?></th>
                                <th><?php echo ('Societe Depart'); ?></th>
                                <th><?php echo ('Societe Arrive'); ?></th>
                                <th><?php echo ('Depot arrive'); ?></th>
                                <th><?php echo ('PV Depart'); ?></th>
                                <th><?php echo ('PV arrive'); ?></th>

                                <th><?php echo ('Facturer'); ?></th>
                                        <!--<th align="center"><?php /* echo ('Facture Vente'); */ ?></th>
                                        <th align="center"><?php /* echo ('Facture Achat'); */ ?></th>-->
                                <th class="actions" align="center"></th>
                            </tr></thead><tbody>
                            <?php
                            //  debug($transferts);
                            foreach ($transferts as $i => $transfert):
//                                debug($transfert);
//                                debug($pointventes);die;
                                $obj = ClassRegistry::init('Depot');
                                $listedepots = $obj->find('first', array('conditions' => array('Depot.id' => $transfert['Transfert']['depotarrive']), 'recursive' => -1));
                                //debug($listedepots) ;                                      
                                ?>
                                <tr>
                                    <td style="display:none"><?php echo h($transfert['Transfert']['id']); ?></td>
                                    <td ><?php echo h($transfert['Transfert']['numero']); ?></td>
                                    <td ><?php echo date("d/m/Y", strtotime(str_replace('/', '/', h($transfert['Transfert']['date'])))); ?></td>
                                    <td style="display:none">
                                        <?php echo $this->Html->link($transfert['Utilisateur']['name'], array('controller' => 'utilisateurs', 'action' => 'view', $transfert['Utilisateur']['id'])); ?>
                                    </td>
                                    <td ><?php echo h($transfert['Societe']['nom']); ?></td>
                                    <td ><?php echo h($transfert['Societearrive']['nom']); ?></td>
                                    <td ><?php echo h($listedepots['Depot']['designation']); ?></td>
                                    <td ><?php echo @$pointventes[$transfert['Transfert']['pvdepart']]; ?></td>
                                    <td ><?php echo @$pointventes[$transfert['Transfert']['pvarrive']]; ?></td>
                                    <td align="center">
                                        <?php if (($transfert['Transfert']['fact']) == 0 && ($transfert['Transfert']['pvdepart']>0)) { ?>
                                            <input type="checkbox" id="check<?php echo $i; ?>" value ="<?php echo $transfert['Transfert']['id'] ?>" name="checkbox[]" ligne="<?php echo $i; ?>" class="abcde"/>
                                            <input type="hidden" id="client<?php echo $i; ?>" value="<?php
                                            echo $transfert['Societe']['id'];
                                            echo'-';
                                            echo $transfert['Societearrive']['id'];
                                            echo'-';
                                            echo $transfert['Transfert']['pvdepart'];
                                            echo'-';
                                            echo $transfert['Transfert']['pvarrive'];
                                            ?>" class="client">
                                               <?php } else echo ''; ?>
                                    </td>

                            <!-- <td align="center">
                                    <?php /*
                                      if($transfert['Transfert']['type'] == 1) {
                                      if ($transfert['Transfert']['fact_vente'] == 0) {
                                      echo $this->Html->link("<button class='btn btn-xs btn-bleue'><i class='fa fa-paper-plane'></i></button>", array('action' => 'facture_vente', $transfert['Transfert']['id']), array('escape' => false));
                                      } else {
                                      echo'<i class="fa fa-check"></i> '; */ ?>
                                             <a onClick="flvFPW1(wr+'Factureclients/imprimer/'+<?php /* echo $transfert['Transfert']['fact_vente']; */ ?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>

                                    <?php /* }
                                      }
                                     */ ?>
                             </td>
                             <td align="center">
                                    <?php /*
                                      if($transfert['Transfert']['type']==1){
                                      if($transfert['Transfert']['fact_achat']==0){
                                      echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-share'></i></button>", array('action' => 'facture_achat', $transfert['Transfert']['id']),array('escape' => false));
                                      }else{
                                      echo'<i class="fa fa-check"></i> '; */ ?>
                                             <a onClick="flvFPW1(wr+'Factures/imprimer/'+<?php /* echo $transfert['Transfert']['fact_achat']; */ ?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>

                                    <?php /* }
                                      }
                                     */ ?>
                             </td>-->
                                    <td align="center">
                                        <?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $transfert['Transfert']['id']), array('escape' => false)); ?>
                                        <?php if ($transfert['Transfert']['fact'] == 0) { ?>
                                            <?php
                                            if ($edit == 1) {
                                                echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $transfert['Transfert']['id']), array('escape' => false));
                                            }
                                            ?>
                                        <?php } ?>
                                        <?php
                                        if ($delete == 1) {
                                            echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $transfert['Transfert']['id']), array('escape' => false, null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $transfert['Transfert']['id']));
                                        }
                                        ?>
                                        <a onClick="flvFPW1(wr + 'Transferts/imprimer/' +<?php echo $transfert['Transfert']['id']; ?>, 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="col-md-12">
                        <input type="hidden" name="tes" value="0" class="tes"/>
                        <input type="hidden" name="nombre" value="<?php echo @$k; ?>" class="nombre"/>
                        <a class="btn btn btn-danger btnbl"  id="datatableadd_facture"> <i class="fa fa-plus-circle"></i> Créer Facture </a>
                        <!--                <a href="#reModal_boncommande_fournisseur" <button class='btn btn-primary btn-round'><i class='fa fa-check'>Créer Bon de Commande Fournisseur</i></a>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


