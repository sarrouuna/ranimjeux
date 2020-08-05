
<script>
    window.onload = function () {
        calculefacture();
    };
</script>


<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Transferts/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<?php $p = CakeSession::read('pointdevente'); ?>
<?php
$users = CakeSession::read('users');
//debug($users);
if ($users != 12) {
    $readonly = "readonly";
} else {
    $readonly = "";
}
?>     

<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Transfert Facture'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Factureclient', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                  
                    <?php
//                    debug($client);die;
                    echo $this->Form->input('pointdevente_id', array('id' => 'pointdevente_id', 'value' => @$lepv_depart, 'disabled' => 'disabled', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select numspecial'));

                    echo $this->Form->input('id', array('id' => 'id_fac', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('clie', array('value' => $client['Client']['name'], 'readonly' => 'readonly', 'label' => 'Client', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control infoclient', 'empty' => 'Veuillez Choisir !!'));
                    ?>
                    <input value="<?php echo $client['Client']['id'] ?>" type="hidden" name="data[Factureclient][client_id]">
                    <input value="<?php echo @$fr['Fournisseur']['id'] ?>" type="hidden" name="data[Factureclient][fournisseur_id]">
                    <input value="<?php echo $lepv_depart ?>" type="hidden" name="data[Factureclient][lepv_depart]">
                    <input value="<?php echo $lepv_arrive ?>" type="hidden" name="data[Factureclient][lepv_arrive]">
                    <input value="<?php echo $lepv_arrive ?>" type="hidden" name="data[Factureclient][depot_arrive]">

                    <?php
                    echo $this->Form->input('model', array('id' => 'model', 'type' => 'hidden', 'value' => 'Factureclient', 'div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?></div><div class="col-md-6"><?php
                    $date = date('d/m/Y');
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' => $date, 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly'));
                    echo $this->Form->input('numero', array('readonly' => $readonly, 'id' => 'numero', 'value' => @$numspecial, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    //echo $this->Form->input('numero_fact',array('div'=>'form-group','Numero Facture','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                    ?>
                </div>        

                <!-- Autre ligne facture client-->
                <div class="row ligne" style="width:105%">

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Ligne facture'); ?></h3>

                            </div>
                            <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                    <thead>
                                        <tr>
                                           <!--<td align="center" nowrap="nowrap" width="1%" ></td>-->
                                            <td align="center" nowrap="nowrap" width="10%">Depot</td>
                                            <td align="center" nowrap="nowrap" width="15%">Article</td>
                                            <td align="center" nowrap="nowrap" width="7%"> Qte </td>
                                            <td align="center" nowrap="nowrap" width="7%"> Qte Vente</td>
                                            <td align="center" nowrap="nowrap" width="9%">PUHT</td>    
                                            <td align="center" nowrap="nowrap" width="8%">Rem</td>
                                            <td align="center" nowrap="nowrap" width="9%">PNHT</td>
                                            <td align="center" nowrap="nowrap" width="9%">PUTTC</td> 
                                            <td align="center" nowrap="nowrap" width="9%">HT</td>
                                            <td align="center" nowrap="nowrap" width="6%">TVA</td>
                                            <td align="center" nowrap="nowrap" width="9%">TTC</td>
                                            <td align="center" width="1%"></td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        //debug($lignetransferts);die;
                                        foreach ($lignetransferts as $i => $l) {  //debug($l);die;
                                            $tot_qte = 0;
                                            $obj_tick = ClassRegistry::init('Ticketcaisseligne');
                                            $obj_liv = ClassRegistry::init('Lignelivraison');
                                            $obj_fact = ClassRegistry::init('Lignefactureclient');
                                            //debug($date_trans);
                                            $req_tick = $obj_tick->find('first', array('conditions' => array('Ticketcaisseligne.article_id' => $l['Article']['id'], @$cond_ticket, 'Ticketcaiss.Date >= ' . "'" . $date_trans . "'"), 'fields' => array('ifnull(sum(Ticketcaisseligne.qte),0) as qte')));
                                            $req_liv = $obj_liv->find('first', array('conditions' => array('Lignelivraison.article_id' => $l['Article']['id'], @$cond_bl, 'Bonlivraison.date >= ' . "'" . $date_trans . "'"), 'fields' => array('ifnull(sum(Lignelivraison.quantite),0) as qte')));
                                            $req_fact = $obj_fact->find('first', array('conditions' => array('Lignefactureclient.article_id' => $l['Article']['id'], @$cond_fac, 'Factureclient.type' => 'direct', 'Factureclient.date >= ' . "'" . $date_trans . "'"), 'fields' => array('ifnull(sum(Lignefactureclient.quantite),0) as qte')));
                                            //debug($req_tick);
                                            //debug($req_liv);
                                            //debug($req_fact);
                                            $tot_qte = $req_tick[0]['qte'] + $req_liv[0]['qte'] + $req_fact[0]['qte'];
                                            $ht = 0;
                                            $ht = $l['Lignetransfert']['prixht'] * $l['Lignetransfert']['quantite'];
                                            ?>

                                            <tr class="cc" >
                                                <!--<td id="tdaff0" >
                                                <span title="Ancien prix"> <a  onclick="recap_rapport(<?php /* echo $i; */ ?>)" href="#reModal_refuser" champ="order" id="order<?php /* echo $i; */ ?>" value="<?php /* echo $i; */ ?>" <button class='  '><i class='fa fa fa-pencil'></i></a></span>
                                                </td> -->
                                                <td>
                                                    <?php //echo $this->Form->input('depot_id',array('value'=>$l['Depot']['id'],'label'=>'','div'=>'form-group', 'name' => 'data[Lignetransfert]['.$i.'][depot_id]','table'=>'Lignetransfert','index'=>$i,'id'=>'depot_id'.$i,'champ'=>'depot_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select depot_qte_s','empty'=>'Veuillez Choisir !!') ); ?>
                                                    <input value="<?php echo $l['Depot']['nom']; ?>" class="form-control" readonly="readonly">

                                                    <input value="<?php echo $l['Transfert']['id']; ?>" class="form-control" type="hidden" name="data[Lignetransfert][<?php echo $i; ?>][transfert_id]">
                                                    <input value="<?php echo $l['Lignetransfert']['id']; ?>" class="form-control" type="hidden" name="data[Lignetransfert][<?php echo $i; ?>][ligne_id]">
                                                    <input value="<?php echo $l['Depot']['id']; ?>" class="form-control" type="hidden" name="data[Lignetransfert][<?php echo $i; ?>][depot_id]">
                                                </td> 



            <!--                                  <td   champ="tdarticle" id="tdarticle0">
                 <div class="form-group">
                 <div class="col-sm-12">    
               <select name="data[Lignetransfert][<?php // echo $i  ?>][article_id]" table="Lignetransfert" index="<?php // echo $i  ?>" id="article_id<?php // echo $i  ?>" champ="article_id" class="form-control select art">
                   <option value="" >Veuillez choisir !!</option>
                                                <?php // foreach ($tabqtestock[$l['Depot']['id']]['articles'] as $p=>$frs){?>
                   <option value="<?php // echo $p    ?>" <?php //if($p==$l['Article']['id']){    ?> selected="selected"<?php //}    ?> ><?php // echo $tabqtestock[$l['Depot']['id']]['articles'][$p]    ?></option>
                                                <?php //}  ?>
               </select></div></div>
            </td>   -->




                                                <td >
                                                    <?php //echo $this->Form->input('article_id',array('value'=>$l['Article']['id'],'div'=>'form-group','label'=>'',  'name' => 'data[Lignetransfert]['.$i.'][article_id]','table'=>'Lignetransfert','index'=>$i,'id'=>'article_id'.$i,'champ'=>'article_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control select articleidbl ','empty'=>'Veuillez choisir !!') );?>
                                                    <div class="" style="display:inline; position: relative;">
                                                        <?php
                                                        echo $this->Form->input('article_id', array('div' => 'form-group', 'value' => $l['Article']['id'], 'name' => 'data[Lignetransfert][' . $i . '][article_id]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                                                        echo $this->Form->input('code', array('div' => 'form-group', 'placeholder' => 'Code', 'readonly' => 'readonly', 'value' => $l['Article']['nom'], 'label' => '', 'name' => 'data[Lignetransfert][' . $i . '][code]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'code' . $i, 'champ' => 'code', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control haithamcode', 'type' => 'text'));
                                                        ?>

                                                        <!--                                            style="background-color:white;position: absolute; top: -10px;right: -500px; width:500px;z-index: 1000px;"-->
                                                        <!--                                            onMouseOut="this.style.visibility = 'hidden';"-->
                                                    </div>
                                                </td>
                                                <td >
                                                    <?php echo $this->Form->input('sup', array('name' => 'data[Lignetransfert][' . $i . '][sup]', 'id' => 'sup' . $i, 'champ' => 'sup', 'table' => 'Lignetransfert', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'label' => 'Nom')); ?>
                                                    <?php echo $this->Form->input('quantite', array('value' => $l['Lignetransfert']['quantite'], 'label' => '', 'div' => 'form-group', 'name' => 'data[Lignetransfert][' . $i . '][quantite]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'quantite' . $i, 'champ' => 'quantite', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control testqte  calculefacture')); ?>
                                                </td>
                                                <td >
                                                    <?php echo $this->Form->input('quantitevdfvfd', array('value' => $tot_qte, 'label' => '', 'readonly' => 'readonly', 'div' => 'form-group', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                </td>

                                                <td >
                                                    <?php //echo $this->Form->input('prixachat',array('value'=>$l['Lignetransfert']['prixachat'],'div'=>'form-group','label'=>'', 'name' => 'data[Lignetransfert]['.$i.'][prixachat]','table'=>'Lignetransfert','index'=>$i,'id'=>'prixachat'.$i,'champ'=>'prixachat','type'=>'hidden','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') ); ?>
                                                    <?php echo $this->Form->input('prix', array('value' => $l['Lignetransfert']['prix'], 'readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignetransfert][' . $i . '][prixhtva]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'prixhtva' . $i, 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeinverseputtc')); ?>
                                                </td>
                                                <td >
                                                    <?php
                                                    echo $this->Form->input('remise', array('value' => $l['Lignetransfert']['remise'], 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignetransfert][' . $i . '][remise]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'remise' . $i, 'champ' => 'remise', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeprix_net_ttc calculefacture'));
                                                    echo $this->Form->input('remiseans', array('type' => 'hidden', 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignetransfert][' . $i . '][remiseans]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'remiseans' . $i, 'champ' => 'remiseans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  '));
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $this->Form->input('prixnet', array('value' => @$l['Lignetransfert']['prixht'], 'readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignetransfert][' . $i . '][prixnet]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'prixnet' . $i, 'champ' => 'prix', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeremisenet')); ?>
                                                </td>
                                                <td >
                                                    <?php
                                                    echo $this->Form->input('puttc', array('value' => @$l['Lignetransfert']['prixttc'], 'readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignetransfert][' . $i . '][puttc]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'puttc' . $i, 'champ' => 'puttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control  calculeprixvente'));
                                                    echo $this->Form->input('totalhtans', array('value' => @$l['Lignetransfert']['prix'], 'type' => 'hidden', 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[Lignetransfert][' . $i . '][totalhtans]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'totalhtans' . $i, 'champ' => 'totalhtans', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control '));
                                                    ?>
                                                </td>
                                                <td >
                                                    <?php echo $this->Form->input('totalht', array('value' => $ht, 'div' => 'form-group', 'label' => '', 'readonly' => 'readonly', 'name' => 'data[Lignetransfert][' . $i . '][totalht]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'totalht' . $i, 'champ' => 'totalht', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                                </td>
                                                <td >
                                                    <?php echo $this->Form->input('tva', array('value' => $l['Lignetransfert']['tva'], 'readonly' => 'readonly', 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignetransfert][' . $i . '][tva]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'tva' . $i, 'champ' => 'tva', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculefacture')); ?>
                                                </td>
                                                <td >
                                                    <?php echo $this->Form->input('totalttc', array('readonly' => 'readonly', 'value' => 0, 'div' => 'form-group', 'label' => '', 'name' => 'data[Lignetransfert][' . $i . '][totalttc]', 'table' => 'Lignetransfert', 'index' => $i, 'id' => 'totalttc' . $i, 'champ' => 'totalttc', 'type' => 'text', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ')); ?>
                                                </td>
                                                <td align="center"><i index="<?php echo $i; ?>"  class="fa fa-times supp1" style="color: #c9302c;font-size: 22px;"></td>
                                            </tr>

                                        <?php } ?>
                                    </tbody>
                                </table>
                                <input type="hidden" value="<?php echo @$i; ?>"  id="index" />
                                <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                                    <div id="pop">


                                    </div>
                                    <br>
                                    <a  class="remodal-confirm ls-light-green-btn btn" ><strong>OK</strong></a>

                                </div> 
                            </div>
                            <!--                                <a class="btn btn-danger ajouterligne_livraison1" table='addtable' index='index'  tr="tr" style="
                                                                float: left; 
                                                                position: relative;
                                                                top: -35px;
                                                            "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                            -->                            </div>
                    </div>                
                </div> 



                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('remise', array('value' => 0, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'remise', 'class' => 'form-control'));
                    echo $this->Form->input('tva', array('label' => 'TVA', 'value' => 0, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'tva', 'class' => 'form-control'));
                    $lien_vente = CakeSession::read('lien_vente');
                    foreach ($lien_vente as $k => $liens) {
                        if (@$liens['lien'] == 'marge') {
                            $marge = 1;
                        }
                    }
                    if (@$marge == 1) {
                        echo $this->Form->input('marge', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'marge', 'class' => 'form-control'));
                    }
                    ?></div><div class="col-md-6"><?php
                    echo $this->Form->input('timbre_id', array('div' => 'form-group', 'value' => $timbre, 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'timbre', 'champ' => 'timbre', 'class' => 'form-control'));
                    echo $this->Form->input('totalht', array('label' => 'Total HT', 'value' => 0, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_HT', 'class' => 'form-control'));
                    echo $this->Form->input('totalttc', array('label' => 'Total TTC', 'value' => 0, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control'));
                    ?>
                </div>                       
                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary ">Enregistrer</button>
                        <!--testlignedevente testautorisation testpv test-edit-numerofacture-->
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

