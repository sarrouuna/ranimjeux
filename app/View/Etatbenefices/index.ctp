<script language="JavaScript" type="text/JavaScript">

    function flvFPW1(){

    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    }

</script>
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
                    if (@$countsos > 1) {
                        echo $this->Form->input('societe_id', array('multiple' => 'true', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Societe', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    }
                    echo $this->Form->input('famille_id', array('id' => 'famille_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Famille', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control select getarticlefamille'));
                    //echo $this->Form->input('article_id', array('id' => 'article_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Article', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('fournisseur_id', array('id' => 'fournisseur_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Fournisseur', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                    <div class="col-dm-6" style="display:inline; position: relative;">
                        <?php
                        echo $this->Form->input('article_id', array('div' => 'form-group', 'index' => '0', 'id' => 'article_id0', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                        echo $this->Form->input('designation', array('div' => 'form-group', 'placeholder' => 'Designation', 'label' => 'Article', 'index' => '0', 'id' => 'designation0', 'champ' => 'designation', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control amineselect', 'type' => 'text'));
                        ?>
                        <div class="form-group" style="display:inline; position: relative;bottom: 24px !important;left: 11px;">
                            <label></label>
                            <div id="res0" champ="res" index="0"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php
//                    debug($this->request->data);
//                    die;
                    echo $this->Form->input('date2', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'type' => 'text', 'label' => "Jusqu'Ã "));
                    echo $this->Form->input('client_id', array('id' => 'client_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Client', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('personnel_id', array('id' => 'personnel_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Agent', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    $p = CakeSession::read('pointdevente');
                    if ($p == 0) {
                        echo $this->Form->input('pointdevente_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    }
                    echo $this->Form->input('exercice_id', array('value' => @$exerciceid, 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'année', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>

                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary " id="aff">Chercher</button>  
                        <a  onClick="flvFPW1(wr + 'Etatbenefices/imprimerrecherche?exercice_id=<?php echo @$exerciceid; ?>&date1=<?php echo @$date1; ?>&date2=<?php echo @$date2; ?>&article_id=<?php echo @$articleid; ?>&pointdevente_id=<?php echo @$pointdeventeid; ?>&famille_id=<?php echo @$familleid; ?>&fournisseur_id=<?php echo @$fournisseurid; ?>&client_id=<?php echo @$clientid; ?>&personnel_id=<?php echo @$personnelid; ?>&societe_id=<?php echo @$societe_id; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>

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
                <h3 class="panel-title"><?php echo __('Etat bénéfices'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="ls-editable-table table-responsive ls-table">
                    <table class="table table-bordered table-striped table-bottomless" id="">
                        <thead>
                            <tr style="background-color:#a49fbf">

                                <th colspan="3"><center><strong><?php echo ('Article'); ?></strong></center></th>
                        <th ><center><strong><?php echo ('Achat'); ?></strong></center></th>
                        <th colspan="3"><center><strong><?php echo ('Vente HT'); ?></strong></center></th>
                        <th colspan="3"><center><strong><?php echo ('Vente TTC'); ?></strong></center></th>
                        </tr>                  
                        <tr style="background-color:#a49fbf">

                            <th style="display:none"><?php echo ('Id'); ?></th>

                            <th style="width:5%"><center><?php echo ('Code'); ?></center></th>

                        <th style="width:38%"><center><?php echo ('Designation'); ?></center></th>

                        <th style="width:5%"><center><?php echo ('Qte V'); ?></center></th>

                        <th style="width:8%"><center><?php echo ('T Achat'); ?></center></th>

                        <th style="width:8%"><center><?php echo ('V HT'); ?></center></th>

                        <th style="width:8%"><center><?php echo ('B HT'); ?></center></th>

                        <th style="width:6%"><center><?php echo ('T HT'); ?></center></th>

                        <th style="width:8%"><center><?php echo ('V TTC'); ?></center></th>

                        <th style="width:8%"><center><?php echo ('B TTC'); ?></center></th>

                        <th style="width:6%"><center><?php echo ('T TTC'); ?></center></th>
                        </tr></thead><tbody>
                            <?php
                            $total_ht = 0;
                            $total_ttc = 0;
                            $total_achat = 0;
                            $obj = ClassRegistry::init('Stockdepot');
                            //debug($etatbenefices);die;
                            foreach ($etatbenefices as $k => $etatbenefice): //debug($etatbenefice);die;
                                $test = strpos($k / 2, ".");
                                if ($test == true) {
                                    $style = "style='background-color:#EAEAEA'";
                                } else {
                                    $style = "style='background-color:white'";
                                }
                                $total_ht = $total_ht + $etatbenefice[0]['ht'];
                                $total_ttc = $total_ttc + $etatbenefice[0]['ttc'];
                                ?>
                                <tr <?php echo $style; ?>>
                                    <td style="display:none"><?php echo ($etatbenefice['tmp']['article_id']); ?></td>
                                    <td ><?php echo ($etatbenefice['tmp']['code']); ?></td>
                                    <td ><?php echo ($etatbenefice['tmp']['name']); ?></td>
                                    <td align="right"><?php echo number_format($etatbenefice[0]['qte']); ?></td>
                                    <td align="right"><?php
                                        
                                        $stckdepot = $obj->find('first', array('conditions' => array('Stockdepot.article_id' => $etatbenefice['tmp']['article_id']), 'recursive'=>-1));
                                        
                                        $prixstock=0;
                                        if($stckdepot != array()){
                                            $prixstock=$stckdepot['Stockdepot']['prix'];
                                        }
                                        $total_achat = $total_achat + ($prixstock * $etatbenefice[0]['qte']);
                                        echo number_format($prixstock * $etatbenefice[0]['qte'], 3, '.', ' ');
                                        ?></td>
                                    <td align="right"><?php echo number_format($etatbenefice[0]['ht'], 3, '.', ' '); ?></td>
                                    <td align="right"><?php echo number_format($etatbenefice[0]['ht'] - ($prixstock * $etatbenefice[0]['qte']), 3, '.', ' '); ?></td>
                                    <?php
                                    $a=number_format(0, 2, '.', ' ') . " %";
                                    if($etatbenefice[0]['ht']!=0){
                                        $a=number_format((((($etatbenefice[0]['ht']) - ($prixstock * $etatbenefice[0]['qte'])) / $etatbenefice[0]['ht']) * 100), 2, '.', ' ') . " %";
                                    }
                                    ?>
                                    <td align="right"><?php echo $a; ?></td>

                                    <td align="right"><?php echo number_format($etatbenefice[0]['ttc'], 3, '.', ' '); ?></td>
                                    <td align="right"><?php echo number_format($etatbenefice[0]['ttc'] - ($prixstock * $etatbenefice[0]['qte']), 3, '.', ' '); ?></td>
                                    <?php
                                    $b=number_format(0, 2, '.', ' ') . " %";
                                    if($etatbenefice[0]['ht']!=0){
                                        $b=number_format((((($etatbenefice[0]['ttc']) - ($prixstock * $etatbenefice[0]['qte'])) / $etatbenefice[0]['ttc']) * 100), 2, '.', ' ') . " %";
                                    }
                                    ?>
                                    <td align="right"><?php echo $b; ?></td>

                                </tr>
<?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">                  
                    <table class="table table-bordered table-striped table-bottomless" id="">
                        <tr>
                            <td colspan="2"><strong><center>Total HT</center></strong></td>
                        </tr> 
                        <tr>
                            <td><strong>Total Achat </strong></td><td><strong><?php echo number_format($total_achat, 3, '.', ' '); ?></strong></td>
                        </tr>
                        <tr>
                            <td><strong>Total HT </strong></td><td><strong><?php echo number_format($total_ht, 3, '.', ' '); ?></strong></td>
                        </tr>
                        <tr>
                            <td><strong>Total Bénéfice </strong></td><td><strong><?php echo number_format($total_ht - $total_achat, 3, '.', ' '); ?></strong></td>
                        </tr>
                        <tr>
                        <?php
                        $sommeht=number_format(0, 3, '.', ' ') . " %";
                        if($total_ttc != 0){
                            $sommeht=number_format((($total_ht - $total_achat) / $total_ht) * 100, 3, '.', ' ') . " %";
                        }
                        ?>
                            <td><strong>Taux Totale </strong></td><td><strong><?php echo $sommeht; ?></strong></td>
                        </tr>
                    </table>      	
                </div> 
                <div class="col-md-6">                  
                    <table class="table table-bordered table-striped table-bottomless" id="">
                        <tr>
                            <td colspan="2"><strong><center>Total TTC</center></strong></td>
                        </tr>
                        <tr>
                            <td><strong>Total Achat </strong></td><td><strong><?php echo number_format($total_achat, 3, '.', ' '); ?></strong></td>
                        </tr>
                        <tr>
                            <td><strong>Total TCC </strong></td><td><strong><?php echo number_format($total_ttc, 3, '.', ' '); ?></strong></td>
                        </tr>
                        <tr>
                            <td><strong>Total Bénéfice </strong></td><td><strong><?php echo number_format($total_ttc - $total_achat, 3, '.', ' '); ?></strong></td>
                        </tr>
                        <tr>
                        <?php
                        $sommettc=number_format(0, 3, '.', ' ') . " %";
                        if($total_ttc != 0){
                            $sommettc=number_format((($total_ttc - $total_achat) / $total_ttc) * 100, 3, '.', ' ') . " %";
                        }
                        ?>
                            <td><strong>Taux Totale </strong></td><td><strong><?php echo $sommettc; ?></strong></td>
                        </tr>
                    </table>      	
                </div>                             

            </div></div></div></div>	


