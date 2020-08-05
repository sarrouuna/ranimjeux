
<script language="JavaScript" >
    function flvFPW1(){
    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;
    }
    function afficheclient(){
        pointdevente_id = $('#pointdevente_id').val()||0;
        if(pointdevente_id==0){
        $('#client_id').val("");
        $('#clientname').val("");    
        $('#clientname').attr('readonly', 'readonly');
        }else{
        $('#client_id').val("");
        $('#clientname').val("");
        $('#clientname').attr('readonly',false);    
        }
    }
</script>

<br><input type="hidden" id="page" value="soldeclient"/>
<div class="row">
    <div class="col-md-12" >
        <div class="panel panel-red">
            <div class="panel-heading">
                <h3 class="panel-title" style="position: relative;">
                    <?php echo __('Recherche'); ?>
                    <ul class="panel-control" style="top:0px;right:0px;">
                        <li><a class="minus active" href="javascript:void(0)"><i class="fa fa-square-o"></i></a></li>
                    </ul>
                </h3>

            </div>
            <div class="panel-body" >
                <?php echo $this->Form->create('Recherche', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('date1', array('label' => 'Date dÃ©but', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'type' => 'text'));
                    echo $this->Form->input('date2', array('label' => 'Date fin', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'type' => 'text'));
                    ?></div>
                <div class="col-md-6"> 
                    <?php
                    $read="readonly";
                    if(isset($this->request->data['Recherche']['clientname'])){
                    if($this->request->data['Recherche']['clientname']!=""){
                        $read="";
                    }
                    }
                    echo $this->Form->input('pointdevente_id', array('label'=>false,'empty' => 'Point de vente','id' => 'pointdevente_id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control','onchange'=>'afficheclient()'));
                    echo $this->Form->input('client_id', array('type'=>'hidden','id' => 'client_id', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('clientname', array('readonly'=>@$read,'label'=>false,'placeholder' => 'Client','yourid'=>'client_id','id' => 'clientname', 'div' => 'form-group', 'between' => '<div class="col-sm-10"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div>', 'class' => 'form-control autocomplete_name_clients'));
                    ?>
                </div>   

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3" >
                        <button  id="breleve" type="submit" class="btn ls-red-btn" >Afficher</button> 
                    </div>
                </div>

<?php echo $this->Form->end(); ?>

            </div>
        </div>
    </div>

<?php ?>
    <div class="col-md-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Etat de solde client'); ?><center><?php echo @$pv_name; ?></center></h3>
            </div>
                    <table class="table table-bordered table-striped" id="" style="border:2px solid black;" width="100%">
                        <thead>
                            <tr style="border:1px solid black;">
                                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>Code</center></strong></th>
                                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>Client</center></strong></th>
                                <th style="border:1px solid black;" bgcolor="#F2D7D5" ><strong><center>Solde</center></strong></th>
                            </tr>

                        </thead><tbody>





<?php
//debug($lignecommandes);
$solde = 0;
$soldetot = 0;
$solder = 0;
$soldetotr = 0;
foreach ($all_clients as $i => $all_client) {
    $test = "";
    $clientid = $all_client['Client']['id'];
    $condb3 = 'Bonlivraison.client_id =' . $clientid;
    $condf3 = 'Factureclient.client_id =' . $clientid;
    $condfa3 = 'Factureavoir.client_id =' . $clientid;
    $condr3 = 'Reglementclient.client_id =' . $clientid;
    
//    $condb4 = 'Bonlivraison.idste =' . $pv_id;
//    $condf4 = 'Factureclient.idste =' . $pv_id;
//    $condfa4 = 'Factureavoir.idste =' . $pv_id;
//    $condr4 = 'Reglementclient.idste =' . $pv_id;
    
    $solde = $all_client['Client']['solde'];
    //$solder = $all_client['Client']['solderecouvrement'];
    //debug($solde);

    $soldeavoir = ClassRegistry::init('Factureavoir')->find('first', array(
        'fields' => array('sum(Factureavoir.totalttc) as solde'),
        'conditions' => array(@$condfa1, @$condfa2, $condfa3, @$condfa4), 'recursive' => -1));
    if (!empty($soldeavoir)) {
        $solde = $solde - $soldeavoir[0]['solde'];
    }
    $soldebl = ClassRegistry::init('Bonlivraison')->find('first', array(
        'fields' => array('sum((Bonlivraison.totalttc)) as solde'),
        'conditions' => array(@$condb1, @$condb2, $condb3, @$condb4, 'Bonlivraison.factureclient_id' => 0), 'recursive' => -1));
    if (!empty($soldebl)) {
        $solde = $solde + $soldebl[0]['solde'];
    }
    $soldefac = ClassRegistry::init('Factureclient')->find('first', array(
        'fields' => array('sum((Factureclient.totalttc)) as solde'),
        'conditions' => array(@$condf1, @$condf2, $condf3, @$condf4), 'recursive' => -1));
    if (!empty($soldebl)) {
        $solde = $solde + $soldefac[0]['solde'];
    }
    $soldereg = ClassRegistry::init('Reglementclient')->find('first', array(
        'fields' => array('sum((Reglementclient.Montant)) as solde'),
        'conditions' => array(@$condbb1, @$condbb2, $condr3, @$condr4 ,"Reglementclient.emi!='052'"), 'recursive' => -1));
    if (!empty($soldereg)) {
        $solde = $solde - $soldereg[0]['solde'];
    }
    $soldepiece = ClassRegistry::init('Piecereglementclient')->find('first', array(
        'fields' => array('sum(Piecereglementclient.montant) as solde'),
        'conditions' => array(@$condbb1, @$condbb2, $condr3, @$condr4, 'Piecereglementclient.paiement_id in (2,3)','Piecereglementclient.situation LIKE "Impay%"'), 'recursive' => 0));
    if (!empty($soldepiece)) {
        $solde = $solde + $soldepiece[0]['solde'];
    }
    $soldetot = $soldetot + $solde;
    ?>


                                <tr>
                                    <td align="left" style="border:1px solid black;" ><?php echo $all_client['Client']['code']; ?></td>
                                    <td align="left" style="border:1px solid black;" ><?php echo $all_client['Client']['name']; ?></td>
                                    <td align="right" style="border:1px solid black;" nowrap="nowrap"><?php echo number_format(@$solde, 3, '.', ' '); ?></td>
                                </tr>

<?php } ?>

                            <tr>
                                <td  style="background-color: #F2D7D5;" align="center" colspan="2"><strong> Total GÃ©nÃ©ral </strong></td>    
                                <td  align="right" nowrap="nowrap"><strong><?php echo number_format(@$soldetot, 3, '.', ' '); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>

                </div></div></div>	


