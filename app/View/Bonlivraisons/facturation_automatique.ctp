<script>

    function flvFPW1() {

        var v1 = arguments, v2 = v1[2].split(","), v3 = (v1.length > 3) ? v1[3] : false, v4 = (v1.length > 4) ? parseInt(v1[4]) : 0, v5 = (v1.length > 5) ? parseInt(v1[5]) : 0, v6, v7 = 0, v8, v9, v10, v11, v12, v13, v14, v15, v16;
        v11 = new Array("width,left," + v4, "height,top," + v5);
        for (i = 0; i < v11.length; i++) {
            v12 = v11[i].split(",");
            l_iTarget = parseInt(v12[2]);
            if (l_iTarget > 1 || v1[2].indexOf("%") > -1) {
                v13 = eval("screen." + v12[0]);
                for (v6 = 0; v6 < v2.length; v6++) {
                    v10 = v2[v6].split("=");
                    if (v10[0] == v12[0]) {
                        v14 = parseInt(v10[1]);
                        if (v10[1].indexOf("%") > -1) {
                            v14 = (v14 / 100) * v13;
                            v2[v6] = v12[0] + "=" + v14;
                        }
                    }
                    if (v10[0] == v12[1]) {
                        v16 = parseInt(v10[1]);
                        v15 = v6;
                    }
                }
                if (l_iTarget == 2) {
                    v7 = (v13 - v14) / 2;
                    v15 = v2.length;
                } else if (l_iTarget == 3) {
                    v7 = v13 - v14 - v16;
                }
                v2[v15] = v12[1] + "=" + v7;
            }
        }
        v8 = v2.join(",");
        v9 = window.open(v1[0], v1[1], v8);
        if (v3) {
            v9.focus();
        }
        document.MM_returnValue = false;
        return v9;

    }
    function  EW_checkMyForm(type) {
        //event.preventDefault();
        //alert(type);

        if (type == "recherche") {
            var client = $('#BonlivraisonClientId').val();
            if (client == '') {
                bootbox.alert('If faut choisir un client');
                return false;
            } else {
                //alert('helmi');
                //$('#defaultForm').submit();
            }
        }


        if (type == "facture") {
            var pv = $('#pointdevente_id').val() || 0;
            var date = $('#BonlivraisonDate').val();
            var client = $('#BonlivraisonClientId').val();
            if (pv == 0 || date == '__/__/____' || client == '') {
                bootbox.alert('If faut choisir un point de vente et date facture et client');
                return false;
            } else {
                //$('#defaultForm').submit();
            }
        }
    }
    function bnt_disbled(){
        $('#bntfac').hide();
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
    if (@$liens['lien'] == 'bonlivraisons') {
        $add = $liens['add'];
        $edit = $liens['edit'];
        $delete = $liens['delete'];
        $imprimer = $liens['imprimer'];
    }
    if (@$liens['lien'] == 'factureclients') {
        $addindirect = $liens['add'];
    }
}
if ($add == 1) {
    ?>

<?php } ?>
<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Bonlivraison', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('page', array('value' => 'factauto', 'id' => 'page', 'type' => 'hidden', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('pointdevente_id', array('id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('date1', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly ', 'type' => 'text', 'label' => 'Date de'));
                    echo $this->Form->input('clientdebut', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Client début', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('bl_debut', array('label' => 'N° Bl début', 'id' => 'bl_debut', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                    echo $this->Form->input('date', array('id'=>'datefac','div' => 'form-group',  'data[Facture][date]', 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly'));
                    echo $this->Form->input('date2', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'type' => 'text', 'label' => "Jusqu’à "));
                    echo $this->Form->input('clientfin', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Client fin', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('bl_fin', array('label' => 'N° Bl fin', 'id' => 'bl_fin', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                </div>      
                <div class="form-group" >
                    <div class="col-lg-7 col-lg-offset-3">
                        <button onmousemove="EW_checkMyForm('recherche')" type="submit" class="btn btn-primary facturationauto" name="data[Bonlivraison][facture]" value="recherche" id="aff">Chercher</button>  
<!--                        <a class="btn btn-primary" href="<?php echo $this->webroot; ?>Bonlivraisons/facturation_automatique"/>Afficher Tout </a>-->
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Facture'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="ls-editable-table table-responsive ls-table">
                    <table class="table table-bordered table-striped table-bottomless">
                        <thead>
                            <tr>
                                <th style="display:none;" ><?php echo ('id'); ?></th>
                                <th style="text-align:center"></th>
                                <th style="text-align:center">Numero</th>
                                <th style="text-align:center">Client</th>
                                <th style="text-align:center">Date</th>
                                <th style="text-align:center">Remise</th>
                                <th style="text-align:center">Totalht</th>
                                <th style="text-align:center">TVA</th>
                                <th style="text-align:center">Timbre</th>
                                <th style="text-align:center">Totalttc</th>

                            </tr></thead><tbody>
                            <?php
                            if (!empty($facture)) {
                                foreach ($facture as $i => $fac):
//                                    debug($clients);die;
                                    
                                    ?>

                                    <tr>
                                        <td style="display:none"><?php echo h($i); ?></td>
                                        <td align="center"><?php echo h($i + 1); ?></td>
                                        <td align="center">
                                            <?php echo $fac['Factureclient']['numero']; ?>
                                        </td>
                                        <td align="center">
                                            <?php echo $fac['Factureclient']['name']; ?>
                                        </td>

                                        <td align="center"><?php echo h(date("d/m/Y", strtotime(str_replace('-', '/', $fac['Factureclient']['date'])))); ?></td>
                                        <td align="center"><?php echo h($fac['Factureclient']['remise']); ?></td>
                                        <td align="center"><?php echo h($fac['Factureclient']['totalht']); ?></td>
                                        <td align="center"><?php echo h($fac['Factureclient']['tva']); ?></td>
                                        <td align="center"><?php echo h($fac['Factureclient']['timbre_id']); ?></td>
                                        <td align="center"><?php echo h($fac['Factureclient']['totalttc']); ?></td>

                                
                                </tr>
                                <?php
                            endforeach;
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php if (!empty($facture)) { ?>
                        <div class="form-group">
                            <div class="col-lg-7 col-lg-offset-3">
                                <button onclick="bnt_disbled()" type="submit" class="btn btn-primary" name="data[Bonlivraison][facture]" value="facture" id="bntfac">Facturer tout</button> 
                            </div>
                        </div>
                    <?php } ?>
                    <input type="hidden"  value="<?php echo @$i; ?>" id="index"/>   
                    <input type="hidden"  value="bl" id="page"/>    


                    <?php echo $this->Form->end(); ?>                 
                </div></div></div></div></div>	



