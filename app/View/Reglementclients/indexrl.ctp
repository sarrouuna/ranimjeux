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
$addindirect = "";
$lien = CakeSession::read('lien_vente');
foreach ($lien as $k => $liens) {
    //debug($liens);die;
    if (@$liens['lien'] == 'reglementclients') {
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
            <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Reglementclients/addrl"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
        </div>
    </div>
<?php } ?>
<div class="row">
    <br> <br>  
    <div class="col-md-12" >
        <div class="panel panel-default"> 
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
                    <?php echo $this->Form->create('Reglementclient', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('Date_debut', array('value' => date('d/m/Y'), 'label' => 'Date début', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'type' => 'text'));
                    echo $this->Form->input('client_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'empty' => 'Veuillez choisir', 'id' => 'BoncommandeClientId'));
                    ?></div>
                <div class="col-md-6"> 
                    <?php
                    echo $this->Form->input('Date_fin', array('value' => date('d/m/Y'), 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'type' => 'text'));
                    //echo $this->Form->input('ligneclient_id',array('div'=>'form-group','label'=>'Adresse','between'=>'<div class="col-sm-10 adrcli">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );       
                    ?>
                </div>   

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary">Afficher</button> 
                        <a href="<?php echo $this->webroot; ?>reglementclients/index" class="btn btn-primary">Afficher Tout</a>
                        <?php if ($imprimer == 1) { ?>
                            <a  onClick="flvFPW1(wr + 'Reglementclients/imprimerrecherche?client_id=<?php echo @$client_id; ?>&Date_debut=<?php echo @$Date_debut; ?>&Date_fin=<?php echo @$Date_fin; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                        <?php } ?>
                        <?php
// debug($mar);
                        ?>

                    </div>
                </div>

                <?php echo $this->Form->end(); ?>





            </div>
        </div>
    </div>



</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Règlements libres'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="ls-editable-table table-responsive ls-table">
                    <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                        <thead>
                            <tr>

                                <th style="display:none"><?php echo ('Id'); ?></th>

                                <th><?php echo ('Numero'); ?></th>

                                <th><?php echo ('Client_id'); ?></th>

                                <th><?php echo ('Date'); ?></th>

                                <th><?php echo ('Montant'); ?></th>

                                <th><?php echo ('Montant réglé'); ?></th>

                                <th width="15%" class="actions" align="center"><?php echo ('Actions'); ?></th>
                            </tr></thead><tbody>
                            <?php
                            if (!empty($reglementclients)) {
                                foreach ($reglementclients as $reglementclient): if ($reglementclient['Reglementclient']['type'] == 1) {
                                        ?>
                                        <tr>
                                            <td style="display:none"><?php echo h($reglementclient['Reglementclient']['id']); ?></td>

                                            <td ><?php echo h($reglementclient['Reglementclient']['numero']); ?></td>
                                            <td >
            <?php echo $this->Html->link($reglementclient['Client']['name'], array('controller' => 'clients', 'action' => 'view', $reglementclient['Client']['id'])); ?>
                                            </td>
                                            <td ><?php echo h($reglementclient['Reglementclient']['Date']); ?></td>
                                            <td ><?php echo h($reglementclient['Reglementclient']['Montant']); ?></td>
                                            <td ><?php echo h($reglementclient['Reglementclient']['montantaffecte']); ?></td>
                                            <td align="center">
                                                <?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'viewrl', $reglementclient['Reglementclient']['id']), array('escape' => false)); ?>
                                                <?php if ($edit == 1) { ?><?php echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'editrl', $reglementclient['Reglementclient']['id']), array('escape' => false)); ?><?php } ?>
                                                <?php if ($delete == 1) { ?><?php echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $reglementclient['Reglementclient']['id']), array('escape' => false, null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $reglementclient['Reglementclient']['id'])); ?><?php } ?>
            <?php if ($imprimer == 1) { ?><a onClick="flvFPW1(wr + 'Reglementclients/imprimerview/' +<?php echo $reglementclient['Reglementclient']['id']; ?>, 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a><?php } ?>
                                            </td>
                                        </tr>
        <?php } endforeach;
} ?>
                        </tbody>
                    </table>

                </div></div></div></div></div>	


