
<script language="JavaScript" type="text/JavaScript">

    function flvFPW1(){

    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    }

</script>

<?php
$lien = CakeSession::read('lien_stat');
$imprimer = "";
//debug($lien);die;
if (!empty($lien)) {
    foreach ($lien as $k => $liens) {
        if (@$liens['lien'] == 'etatcapersonnels') {
            $imprimer = $liens['imprimer'];
        }
    }
}
?>

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
                    echo $this->Form->input('personnel_id', array('id' => 'personnel_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Personnel', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('client_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Client', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('pointdevente_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('zone_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Zone', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                    echo $this->Form->input('date2', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'type' => 'text', 'label' => "Jusqu'Ã "));
                    echo $this->Form->input('exercice_id', array('value' => $exerciceid, 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'année', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('famille_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Famille', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('fournisseur_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Fournisseur', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>

                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
<!--                 <a class="btn btn-primary" href="<?php //echo $this->webroot; ?>/index"/>Afficher Tout </a>-->
                        <?php if ($imprimer == 1) { ?>
                            <a  onClick="flvFPW1(wr + 'Etatcapersonnels/imprimerrecherche?personnelid=<?php echo @$personnelid; ?>fournisseurid=<?php echo @$fournisseurid; ?>&clientid=<?php echo @$clientid; ?>&date1=<?php echo @$date1; ?>&date2=<?php echo @$date2; ?>&familleid=<?php echo @$familleid; ?>&pointdeventeid=<?php echo @$pointdeventeid; ?>&articleid=<?php echo @$articleid; ?>&exerciceid=<?php echo @$exerciceid; ?>&zoneid=<?php echo @$zoneid; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                        <?php } ?>


                    </div>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Détail par Agent'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="ls-editable-table table-responsive ls-table">
                    <table class="table table-bordered table-striped table-bottomless" id="">
                        <thead>
                            <tr>
                       <th><center> Personnel </center></th>
                        <th><center>Nbr Client</center></th>
                        <th><center>Opération</center></th>
        <!--                <th><center>Client Actif</center></th>-->
        <!--                <th><center>Client Inactif</center></th>   -->
                        <th><center>% op</center></th>  
                        <th><center>Total C A</center></th>
                        <th><center>% C A</center></th> 
                        <th class="actions" align="center"></th>
                        </tr>
                        </thead><tbody>
                            <?php
                            $tab = ClassRegistry::init('Tabetatcaparpersonnel')->find('all', array(
                                'fields' => array('sum(Tabetatcaparpersonnel.tot) as sumtot')));
                            $sum_tot = $tab[0][0]['sumtot'];

                            $kolfilkol = 0;
                            foreach ($personnelss as $i => $personel) {
                                $totpersonnel = 0;
                                ?>                
                                <tr>
                                    <td >
                                        <strong><?php echo $personel['Personnel']['name']; ?></strong>
                                    </td>
                                    <?php
                                    $test = ClassRegistry::init('Client')->find('count', array('conditions' => array('Client.personnel_id' => $personel['Personnel']['id']), 'recursive' => -1));
                                    //debug($test);
                                    $tab = ClassRegistry::init('Tabetatcaparpersonnel')->find('all', array(
                                        'fields' => array('sum(Tabetatcaparpersonnel.tot) as tot')
                                        , 'conditions' => array('Tabetatcaparpersonnel.personnel_id' => $personel['Personnel']['id'])));
                                    if (!empty($tab)) {
                                        $totpersonnel = $tab[0][0]['tot'];
                                    } else {
                                        $totpersonnel = 0;
                                    }
                                    $kolfilkol = $kolfilkol + $totpersonnel;
                                    //debug($tab);
                                    $listeclient = ClassRegistry::init('Client')->find('all', array('conditions' => array('Client.personnel_id' => $personel['Personnel']['id']), 'recursive' => -1));
                                    ?>
                                    <td >
                                    <?php echo $test; ?>
                                    </td>
                                    <?php
                                    $listeclientaffecte = "";
                                    $listeclientnonaffecte = "";
                                    $nb = 0;
                                    $nba = 0;
                                    $nbi = 0;
                                    //zeinab
                                    if ($exerciceid != '') {
                                        $condFc = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
                                        $condBl = 'Bonlivraison.exercice_id =' . $exercices[$exerciceid];
                                    }

                                    //
                                    foreach ($listeclient as $k => $client) {
                                        $testfac = ClassRegistry::init('Factureclient')->find('count', array('conditions' => array(@$condFc, 'Factureclient.client_id' => $client['Client']['id']), 'recursive' => -1));
                                        if ($testfac > 0) {
                                            if ($nba == 0) {
                                                $listeclientaffecte = $listeclientaffecte . " " . $client['Client']['name'];
                                            } else {
                                                $listeclientaffecte = $listeclientaffecte . " ," . $client['Client']['name'];
                                            }
                                            $nb++;
                                            $nba++;
                                        } else {
                                            $testbl = ClassRegistry::init('Bonlivraison')->find('count', array('conditions' => array(@$condBl, 'Bonlivraison.client_id' => $client['Client']['id']), 'recursive' => -1));
                                            if ($testbl > 0) {
                                                if ($nba == 0) {
                                                    $listeclientaffecte = $listeclientaffecte . " " . $client['Client']['name'];
                                                } else {
                                                    $listeclientaffecte = $listeclientaffecte . " ," . $client['Client']['name'];
                                                }
                                                $nb++;
                                                $nba++;
                                            } else {
                                                if ($nbi == 0) {
                                                    $listeclientnonaffecte = $listeclientnonaffecte . " " . $client['Client']['name'];
                                                } else {
                                                    $listeclientnonaffecte = $listeclientnonaffecte . " ," . $client['Client']['name'];
                                                }
                                                $nbi++;
                                            }
                                        }
                                    }
                                    if ($test == 0) {
                                        $por = "";
                                    } else {
                                        $por = ($nb / $test) * 100;
                                    }
                                    if (!empty($totpersonnel)) {
                                        $val = ($totpersonnel / $sum_tot) * 100;
                                    } else {
                                        $val = 0;
                                    }
                                    ?>
                                    <td align="center"><?php echo $nb; ?></td>
                                    <td align="center"><?php echo sprintf("%01.2f", $por); ?></td>
                                    <td align="center"><?php echo number_format($totpersonnel, 3, '.', ' '); ?></td>
                                    <td align="center"><?php echo number_format($val, 3, '.', ' '); ?></td>
                                    <td style="background-color: white !important;" >
                            <center>
                                <input type="hidden" id="ligne<?php echo $i; ?>" value="0"/>
                                <button onclick="affichetr(<?php echo $i; ?>)" class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>
                            </center>
                            </td>
                            </tr>
                            <tr style="display:none;" id="trr<?php echo $i; ?>" >
                                <td style="vertical-align: top;" width="50%" align="lfet" colspan="2"><?php echo "<strong><font color='green'>Client Actif :</font></strong><br>" . $listeclientaffecte; ?></td>
                                <td style="vertical-align: top;" width="50%" align="lfet" colspan="2"><?php echo "<strong><font color='green'>Client Inactif :</font></strong><br>" . $listeclientnonaffecte; ?></td>
                            </tr>
<?php } ?>
                        <tr>
                            <td align="lfet" colspan="4"></td>
                            <td align="center" colspan="1"><?php echo number_format($kolfilkol, 3, '.', ' '); ?></td>
                        </tr>
                    </table>

                </div></div></div></div></div>







