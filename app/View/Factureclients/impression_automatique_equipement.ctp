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
$lien = CakeSession::read('lien_vente');
foreach ($lien as $k => $liens) {
    //debug($liens);die;
    if (@$liens['lien'] == 'factureclients') {
        $add = $liens['add'];
        $edit = $liens['edit'];
        $delete = $liens['delete'];
        $imprimer = $liens['imprimer'];
    }
}
?>
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
                    echo $this->Form->input('date1', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly ', 'type' => 'text', 'label' => 'Date de'));
                    ?>
                    <div class="autocomplete" style="width:100%;">
                    <?php
                    echo $this->Form->input('numero1', array('id'=>'numero1','yourid'=>'numeroconca1','div' => 'form-group', 'placeholder' => 'veuillez choisir', 'label' => 'Numero debut','between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control  numero_manuel_autocomplete', 'type' => 'text'));
                    echo $this->Form->input('numeroconca1', array('id'=>'numeroconca1','div' => 'form-group','label' => '','between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control  code_manuel_autocomplete', 'type' => 'hidden'));
                    ?>
                    </div>
                    <?php
                    echo $this->Form->input('client_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Client', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('facturationbl_id', array('label' => 'Type Facture', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                    echo $this->Form->input('date2', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'type' => 'text', 'label' => "Jusqu'Ã "));
                    ?>
                    <div class="autocomplete" style="width:100%;">
                    <?php
                    echo $this->Form->input('numero2', array('id'=>'numero2','yourid'=>'numeroconca2','div' => 'form-group', 'placeholder' => 'veuillez choisir', 'label' => 'numero fin','between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control  numero_manuel_autocomplete', 'type' => 'text'));
                    echo $this->Form->input('numeroconca2', array('id'=>'numeroconca2','div' => 'form-group','label' => '','between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control  code_manuel_autocomplete', 'type' => 'hidden'));
                    ?>
                    </div>
                    <?php
                    echo $this->Form->input('exercice_id', array('id' => 'exercice_id', 'value' => $exerciceid, 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'année', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('pv', array('value'=>1,'id'=>'pv','div' => 'form-group','label' => '','between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                    ?>
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                        <a  onClick="flvFPW1(wr + 'Factureclients/imprimerhaithammatricielle_equipement_auto/<?php echo urlencode(Appcontroller::encrypt_decrypt("Factureclient")); ?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("Lignefactureclient")); ?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("factureclient_id")); ?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("factureclients")); ?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("Facture")); ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
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
                <h3 class="panel-title"><?php echo __('Impression automatique Equipement'); ?></h3>
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

                                <th><?php echo ('Totalht'); ?></th>

                                <th><?php echo ('Totalttc'); ?></th>

                            </tr></thead><tbody>
                            <?php
                            $totaleth = 0;
                            $totalettc = 0;
                            if( !empty($factureclients)){
                            foreach ($factureclients as $factureclient):
                                $totaleth = $totaleth + $factureclient['Factureclient']['totalht'];
                                $totalettc = $totalettc + $factureclient['Factureclient']['totalttc'];
                                ?>

                                <tr>
                                    <td style="display:none"><?php echo h($factureclient['Factureclient']['numero']); ?></td>
                                    <td ><?php echo h($factureclient['Factureclient']['numero']); ?></td>
                                    <td >
                                        <?php echo $this->Html->link($factureclient['Factureclient']['name'], array('controller' => 'clients', 'action' => 'view', $factureclient['Factureclient']['client_id'])); ?>
                                    </td>

                                    <td ><?php echo h(date("Y/m/d", strtotime(str_replace('-', '/', $factureclient['Factureclient']['date'])))); ?></td>
                                    <td ><?php echo h($factureclient['Factureclient']['totalht']); ?></td>
                                    <td ><?php echo h($factureclient['Factureclient']['totalttc']); ?></td>

                                </tr>
                            <?php endforeach; } ?>
                        <tfoot>
                        <td><strong>Total HT</strong></td><td><strong><?php echo number_format(@$totaleth, 3, '.', ' '); ?></strong></td><td><strong>Total TTC</strong></td><td colspan="2"><strong><?php echo number_format(@$totalettc, 3, '.', ' '); ?></strong></td>
                        </tfoot>
                        </tbody>
                    </table>

                </div></div></div></div></div>	


