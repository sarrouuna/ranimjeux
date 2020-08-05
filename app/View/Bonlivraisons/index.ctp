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
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Factureclients/add/Bonlivraison/Lignelivraison/bonlivraison_id"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
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
                    echo $this->Form->input('date1', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly ', 'type' => 'text', 'label' => 'Date de'));
                    echo $this->Form->input('client_id', array('type'=>'hidden','id' => 'client_id', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('clientname', array('label'=>'Client','yourid'=>'client_id','id' => 'clientname', 'div' => 'form-group', 'between' => '<div class="col-sm-10"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div>', 'class' => 'form-control autocomplete_name_clients'));
                    echo $this->Form->input('societe_id', array('id' => 'lasociete', 'empty' => 'veuillez choisir !!', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('pointdevente_id', array('label'=>'Point de Vente','id' => 'lapv', 'empty' => 'veuillez choisir !!', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('order_id', array('label'=>'Order par','id' => 'order', 'empty' => 'veuillez choisir !!', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                    echo $this->Form->input('date2', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'type' => 'text', 'label' => "Jusqu'Ã "));
                    echo $this->Form->input('exercice_id', array('value' => $exerciceid, 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'année', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
//                    echo $this->Form->input('numero', array('id'=>'numbl', 'empty' => 'veuillez choisir !!', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control numero_bl'));
                    echo $this->Form->input('facturer', array('value'=>2,'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Bl facturée', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                    
                    
                    <?php
                    echo $this->Form->input('bl_id', array('type'=>'hidden','id' => 'bl_id', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('blnumero', array('label'=>'Numero','yourid'=>'bl_id','id' => 'blnumero', 'div' => 'form-group', 'between' => '<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div></td><td style="width: 5%;vertical-align: top" id="divreleve"></td></tr></table>', 'class' => 'form-control autocomplete_numero_bls'));
                    ?>
                    
                    

<!--                    <div class="" style="display:inline; position: relative;">
                        <?php
                        //echo $this->Form->input('bl_id', array('div' => 'form-group', 'index' => '0', 'id' => 'bl_id0', 'champ' => 'bl_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
//                        echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'label' => 'Code', 'index' => '0', 'id' => 'code0', 'champ' => 'code', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                        ?>
                        <?php
                        ?>
                        <div class="col-dm-6" style="display:inline; position: relative;">
                            <?php //echo $this->Form->input('numero', array('div' => 'form-group', 'placeholder' => 'Numero BL', 'label' => 'Numero', 'index' => '0', 'id' => 'numbl0', 'champ' => 'numbl', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control numero_bl', 'type' => 'text')); 
                            ?>
                            <div class="form-group" style="display:inline; position: relative;bottom: 24px !important;left: 11px;">
                                <label></label>
                                <div id="res0" champ="res" index="0"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>
                            </div>
                        </div>
                    </div>-->
                    

                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                        <a class="btn btn-primary" href="<?php echo $this->webroot; ?>Bonlivraisons/index"/>Afficher Tout </a>
                        <?php if ($imprimer == 1) { ?>
                            <a  onClick="flvFPW1(wr + 'Bonlivraisons/imprimerrecherche?clientid=<?php echo @$clientid; ?>&date1=<?php echo @$date1; ?>&date2=<?php echo @$date2; ?>&exerciceid=<?php echo @$exerciceid; ?>&societe_id=<?php echo @$societe_id; ?>&pointdevente_id=<?php echo @$pointdevente_id; ?>&facturer=<?php echo @$val; ?>&order=<?php echo @$order_id; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                            <a  onClick="flvFPW1(wr + 'Bonlivraisons/imprimerexcel?clientid=<?php echo @$clientid; ?>&date1=<?php echo @$date1; ?>&date2=<?php echo @$date2; ?>&exerciceid=<?php echo @$exerciceid; ?>&societe_id=<?php echo @$societe_id; ?>&pointdevente_id=<?php echo @$pointdevente_id; ?>&facturer=<?php echo @$val; ?>&order=<?php echo @$order_id; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer EXECEL</button> </a>
                        <?php } ?>


                    </div>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Bonlivraisons'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="ls-editable-table table-responsive ls-table">
                    <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                        <thead>
                            <tr>


                                <th style="display:none;"><?php echo ('id'); ?></th>
                                <th><?php echo ('Numero'); ?></th>

                                <th><?php echo ('Client '); ?></th>
                                <th><?php echo ('Vente'); ?></th>


                                <th><?php echo ('Date'); ?></th>



                                <th><?php echo ('Total HT'); ?></th>

                                <th><?php echo ('Total TTC'); ?></th>
                                <th><?php echo ('Facture'); ?></th>
                                <th class="actions" align="center"></th>
                                
<!--                                <th class="actions" align="center">Facturation auto</th>
-->                                <th class="actions" align="center"></th>
                            </tr></thead><tbody>
                            <?php foreach ($bonlivraisons as $i => $bonlivraison): ?>

                                <tr>
                                    <td style="display:none"><?php echo h($bonlivraison['Bonlivraison']['date']); ?></td>
                                    <td ><?php echo h($bonlivraison['Bonlivraison']['numero']); ?></td>
                                    <td >
                                        <input type="hidden"  value="<?php echo $bonlivraison['Bonlivraison']['pointdevente_id']; ?>" id='Pointdevente<?php echo $i; ?>' />
                                        <input type="hidden"  value="<?php echo $bonlivraison['Client']['id']; echo '-'; ?>" id='Client<?php echo $i; ?>' />
                                               <?php echo $this->Html->link($bonlivraison['Bonlivraison']['name'], array('controller' => 'clients', 'action' => 'view', $bonlivraison['Client']['id'])); ?>
                                    </td>
                                    <td ><?php echo h($bonlivraison['Bonlivraison']['vente']); ?></td>
                                    <td ><?php echo h(date("d/m/Y", strtotime(str_replace('-', '/', $bonlivraison['Bonlivraison']['date'])))); ?></td>
                                    <td ><?php echo h($bonlivraison['Bonlivraison']['totalht']); ?></td>
                                    <td ><?php echo h($bonlivraison['Bonlivraison']['totalttc']); ?></td>
                                    <td ><?php echo h(@$bonlivraison['Factureclient']['numero']); ?></td>
                                    <td align="center">
                                        <?php if (($bonlivraison['Bonlivraison']['factureclient_id'] == 0)) { ?>           

                                            <input type="checkbox" id="check<?php echo $i; ?>" value ="<?php echo $bonlivraison['Bonlivraison']['id'] ?>" name="checkbox[]" ligne="<?php echo $i; ?>" class="blf"/>


                                         <a href="<?php echo $this->webroot;?>Reglementclients/add/<?php echo $bonlivraison['Bonlivraison']['client_id'];?>/<?php echo $bonlivraison['Bonlivraison']['pointdevente_id'];?>/0/0/<?php echo $bonlivraison['Bonlivraison']['id'];?>"     ><button class='btn ls-red-btn btn-round'><i class='fa fa-plus'></i>  Réglement</button></a>
                                        <?php } ?>  
                                    </td>
                                    
                                    
                                    <!--<td align="center">
                                        <?php if (($bonlivraison['Bonlivraison']['factureclient_id'] == 0)) { ?>           

                                            <input type="checkbox"  <?php if ($bonlivraison['Bonlivraison']['auto']=="automatique"){ ?>checked <?php }?> index ="<?php echo $bonlivraison['Bonlivraison']['id'] ?>"   class="facturationauto"/>

                                        <?php } ?>  
                                    </td>-->

                                    <td align="center">
                                        <?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $bonlivraison['Bonlivraison']['id']), array('escape' => false)); ?>
                                        <?php
                                        if (empty($bonlivraison['Bonlivraison']['factureclient_id'])) {
                                            if (($edit == 1) & ($bonlivraison['Bonlivraison']['etat'] == 0)) {

                                                echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('controller' => 'Factureclients', 'action' => 'edit', $bonlivraison['Bonlivraison']['id'], 'Bonlivraison', 'Lignelivraison', 'bonlivraison_id'), array('escape' => false));
                                            }
                                            ?>
                                            <?php
                                            if (($delete == 1) & ($bonlivraison['Bonlivraison']['etat'] == 0)) {
                                                echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $bonlivraison['Bonlivraison']['id']), array('escape' => false, null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $bonlivraison['Bonlivraison']['id']));
                                            }
                                        }
                                        ?>
                                        <?php
                                            $pointdevente = ClassRegistry::init('Pointdevente')->find('first', array('conditions' => array('Pointdevente.id' => $bonlivraison['Bonlivraison']['pointdevente_id']), 'recursive' => -1));

										if ($imprimer == 1) { ?>
<!--                                            <a onClick="flvFPW1(wr + 'Bonlivraisons/imprimer/' +<?php echo $bonlivraison['Bonlivraison']['id']; ?>, 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>-->
                                            <a onClick="flvFPW1(wr + 'Factureclients/imprimer/<?php echo $bonlivraison['Bonlivraison']['id']; ?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("Bonlivraison"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("Lignelivraison"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("bonlivraison_id"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("bonlivraisons"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("Bon de livraison"));?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                                        <a onClick="flvFPW1(wr + 'Factureclients/<?php echo $pointdevente['Pointdevente']['lienimpression']; ?>/<?php echo $bonlivraison['Bonlivraison']['id']; ?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("Bonlivraison"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("Lignelivraison"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("bonlivraison_id"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("bonlivraisons"));?>/<?php echo urlencode(Appcontroller::encrypt_decrypt("Bon de livraison"));?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs btn-success'><i class='fa fa-print'></i></button></a>
                                        <?php } ?>
            <!--<spam title="duplication"><a class="affichediplication"  id="affichediplication" value="<?php echo $bonlivraison['Bonlivraison']['id'] ?>"> <button class='btn btn-xs btn-success'> <i class="fa fa-files-o"></i></button>  </a></spam>-->
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <input type="hidden"  value="<?php echo $i; ?>" id="index"/>   
                    <input type="hidden"  value="bl" id="page"/>    
                    <?php if ($addindirect == 1) { ?>
                        <br>
                        <div class="col-md-12  testcheck" style="display:none;">
                            <input type="hidden" name="tes" value="0" class="tespv"/>
                            <input type="hidden" name="tes" value="0" class="tes"/>
                            <input type="hidden" name="nombre" value="<?php echo @$i; ?>" class="nombre"/>
                            <a class="btn btn btn-danger btnbl"  id="facbonlivraisonadd"> <i class="fa fa-plus-circle"></i> Créer une Facture </a>          
                        </div>         
                    <?php } ?>  <br><br><br>
                    <div class="col-md-6 selectdip" style="display:none;"> 
                        <?php echo $this->Form->input('typedipliquation_id', array('label' => 'Type Duplication', 'id' => 'typedipliquation_id', 'div' => 'form-group', 'between' => '<div class="col-sm-6">', 'after' => '</div>', 'class' => 'form-control select', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'empty' => 'Veuillez Choisir !!'));
                        ?>
                    </div>
                    <div class="col-md-6 boutselect" style="display:none;">
                        <div class="col-md-12  diplique" >
                            <input type="hidden" name="tes" value="0" class="tes" id="testvalue"/>
                            <input type="hidden" name="tes" value="Bonlivraison" class="tes" id="model"/>
                            <input type="hidden" name="tes" value="Lignelivraison" class="tes" id="ligne"/>
                            <input type="hidden" name="tes" value="bonlivraison_id" class="tes" id="attr"/>
                            <a class="btn btn btn-danger modeladd"  id="modeladd"> <i class="fa fa-plus-circle"></i> Créer </a>          
                        </div> 

                    </div>                 
                </div></div></div></div></div>	


