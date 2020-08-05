<script language="JavaScript" type="text/JavaScript">
    function flvFPW1(){
    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;
    }
</script>

<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Factureclients/index"/> <i class="fa fa-reply"></i> Retour </a>
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
<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->create('Factureclient', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Consultation Facture client'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="col-md-4">                  
                    <?php
                    //debug($factureclients);debug($clients);
                    $objp = ClassRegistry::init('Pointdevente');
                    $objc = ClassRegistry::init('Client');

                    $point = $objp->find('first', array('conditions' => array('Pointdevente.id' => $factureclients['Factureclient']['pointdevente_id']), 'recursive' => -1));
                    $clt = $objc->find('first', array('conditions' => array('Client.id' => $factureclients['Factureclient']['client_id']), 'recursive' => -1));
                    echo $this->Form->input('pointdevente_id', array('value' => @$point['Pointdevente']['name'], 'readonly' => 'readonly', 'id' => 'pointdevente_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'type' => 'text', 'class' => 'form-control inputspcial'));
                    ?> <br>
                    <div class="clear"></div>
                    <?php
                    echo $this->Form->input('id', array('id' => 'id_fac', 'value' => $factureclients['Factureclient']['id'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    echo $this->Form->input('client_id', array('value' => @$clt['Client']['name'], 'readonly' => 'readonly', 'id' => 'client_id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial', 'type' => 'text'));
                    ?>
                </div>
                <div class="col-md-4">
                   <?php
                   if ($factureclients['Factureclient']['source'] == 'bl') {
                    echo $this->Form->input('date', array('div' => 'form-group', 'value' => date("d/m/Y", strtotime(str_replace('-', '/', $factureclients['Factureclient']['date']))), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly inputspcial'));
                    echo $this->Form->input('numero', array( 'value' => $factureclients['Factureclient']['numero'], 'id' => 'numero', 'div' => 'form-group', 'between' => '<div class="col-sm-8">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    
                   }  else {
                   ?> 
                    
                    
                    
                    <?php
                    echo $this->Form->input('date', array('readonly' => 'readonly', 'div' => 'form-group', 'value' => date("d/m/Y", strtotime(str_replace('-', '/', $factureclients['Factureclient']['date']))), 'type' => 'text', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                    ?> 
                    <?php
                    echo $this->Form->input('numero', array('value' => $factureclients['Factureclient']['numero'], 'readonly' => 'readonly', 'id' => 'numero', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control inputspcial'));
                   }?>
                </div>   
                <?php if ($factureclients['Factureclient']['source'] == 'bl') { ?>
                    <div class="col-md-4">
                        <center>
                            <a class="btn ls-green-btn btn-round ajoutbl" style="width: 100px"><i class=""></i> Ajouter BL </a>
                            <a class="btn ls-red-btn btn-round suppbl" style="width: 120px"><i class=""></i> Supprimer BL </a>
                        </center><br>
                        <div class="" style="display: none;" id="listeblajout">
                            <table width="100%" ><tr><td width="100%" align="center"> <?php
                                        echo $this->Form->input('blfacture_id', array('label' => 'BL ', 'multiple' => 'multiple', 'div' => 'form-group', 'between' => '<div class="col-sm-6">', 'after' => '</div>', 'id' => 'blfacture_id', 'class' => 'form-control select ', 'empty' => '-- Veuillez choisir --'));
                                        ?>
                                        <!--<button type="submit" style="margin-top: -14px;" class="btn ls-green-btn btn-round" ><i class="fa fa-arrow-circle-up"></i>  </button>-->
                                    </td>
                                    </div></tr>
                            </table>

                        </div>
                        <div class="" style="display: none;" id="listeblsup">
                            <table width="100%"><tr><td width="100%" align="center"> <?php
                                        echo $this->Form->input('blfacturesup_id', array('label' => 'BL Supprimé', 'multiple' => 'multiple', 'div' => 'form-group', 'between' => '<div class="col-sm-6">', 'after' => '</div>', 'id' => 'blfacturesup_id', 'class' => 'form-control select inputspecial', 'empty' => '-- Veuillez choisir --'));
                                        ?>
                                        <!--<button style="margin-top: -14px;" class="btn ls-red-btn btn-round" ><i class="fa fa-arrow-circle-o-down"></i></i>  </button>-->
                                    </td>
                                    </div></tr>
                            </table>

                        </div>

                        <center> <button type="submit" class="btn btn-primary ">Enregistrer</button>


                           



                        </center>
                    </div>
<?php } ?>
                <div class="clear"></div> <br>

                <!-- Autre ligne livraison-->
                <div class="row ligne" >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Ligne de facture Client'); ?>
                                <a onClick="flvFPW1(wr + 'Factureclients/imprimerbl/' +<?php echo $factureclients['Factureclient']['id']; ?>, 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);
                                return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'>Imprimer</button></a>
                                </h3>
                                
                            </div>
                            <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                    <thead>
                                        <tr>
                                            <?php if ($factureclients['Factureclient']['source'] == 'bl') { ?>   
                                                <td align="center" nowrap="nowrap">BL</td>
<?php } ?>
                                            <td align="center" nowrap="nowrap">Depot</td>
                                            <td align="center" nowrap="nowrap">Article</td>
                                            <td align="center" nowrap="nowrap">Quantite </td>
                                            <td align="center" nowrap="nowrap">PUHT</td>    
                                            <td align="center" nowrap="nowrap">Remise %</td> 
                                            <td align="center" nowrap="nowrap">PNHT</td> 
                                            <td align="center" nowrap="nowrap" >HT</td>
                                            <td align="center" nowrap="nowrap" >TVA</td>
                                            <td align="center" nowrap="nowrap" >TTC</td>    
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        //debug($lignefactureclients);
                                        foreach ($lignefactureclients as $i => $l) {

                                            //   debug($l);
                                            ?> 

                                            <tr class="cc" >
                                                    <?php if ($factureclients['Factureclient']['source'] == 'bl') { ?> 
                                                    <td style="width:10%">
                                                    <?php echo $l['Bonlivraison']['numero']; ?>
                                                    </td>
                                                    <?php } ?>
                                                <td style="width:5%">
                                                    <?php echo $l['Depot']['code']; ?></td> 
                                                <td style="width:30%"  >
    <?php echo $l['Article']['code'] . "" . $l['Article']['name']; ?>
                                                </td>
                                                <td style="width:5%">
    <?php echo $l['Lignefactureclient']['quantite']; ?>
                                                </td>
                                                <td style="width:10%">
    <?php echo $l['Lignefactureclient']['prix']; ?>
                                                </td>
                                                <td style="width:5%">
    <?php echo $l['Lignefactureclient']['remise']; ?>
                                                </td>
                                                <td style="width:10%">
    <?php echo $l['Lignefactureclient']['prixnet']; ?>
                                                </td>
                                                <td style="width:10%">
    <?php echo $l['Lignefactureclient']['totalht']; ?>
                                                </td>
                                                <td style="width:5%">
    <?php echo $l['Lignefactureclient']['tva']; ?>
                                                </td>
                                                <td style="width:10%">
    <?php echo $l['Lignefactureclient']['totalttc']; ?>
                                                </td>
                                            </tr>
<?php } ?>
                                    </tbody>
                                </table>
                                <input type="hidden" value="<?php echo @$i; ?>"  id="index" />
                            </div>
                        </div>
                    </div>                
                </div> 
                <br>
                <div class="clear"></div>                                                 
                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('remise', array('value' => $factureclients['Factureclient']['remise'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'remise', 'class' => 'form-control inputspcial'));
                    ?> <br>
                    <div class="clear"></div>
                    <?php
                    echo $this->Form->input('tva', array('label' => 'TVA', 'value' => $factureclients['Factureclient']['tva'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'tva', 'class' => 'form-control inputspcial'));
                    ?>
                </div><div class="col-md-6"><?php
                    echo $this->Form->input('timbre_id', array('value' => $factureclients['Factureclient']['timbre_id'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'after' => '</div>', 'id' => 'timbre', 'champ' => 'timbre', 'class' => 'form-control calculefacture inputspcial'));
                    ?> <br>
                    <div class="clear"></div>
                    <?php
                    echo $this->Form->input('totalht', array('label' => 'Total HT', 'value' => $factureclients['Factureclient']['totalht'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_HT', 'class' => 'form-control inputspcial'));
                    ?> <br>
                    <div class="clear"></div>
                    <?php
                    echo $this->Form->input('totalttc', array('label' => 'Total TTC', 'value' => $factureclients['Factureclient']['totalttc'], 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'text', 'readonly' => 'readonly', 'after' => '</div>', 'id' => 'Total_TTC', 'class' => 'form-control inputspcial'));
                    ?>
                </div>   

<?php echo $this->Form->end(); ?>
            </div></div></div>




