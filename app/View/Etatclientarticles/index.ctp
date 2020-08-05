
<script language="JavaScript" type="text/JavaScript">

    function flvFPW1(){

    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    }

</script>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche par Client/Article'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Recherche', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('date1', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly ', 'type' => 'text', 'label' => 'Date de'));
                    echo $this->Form->input('client_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Client', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    //echo $this->Form->input('article_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Article','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                    echo $this->Form->input('famille_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Famille', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('fournisseur_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Fournisseur', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
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
                    echo $this->Form->input('date2', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'type' => 'text', 'label' => "Jusqu'Ã "));
                    echo $this->Form->input('exercice_id', array('value' => $exerciceid, 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'année', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('pointdevente_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('tag_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Tag', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('personnel_id', array('id' => 'personnel_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Personnel', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>

                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
<!--                 <a class="btn btn-primary" href="<?php //echo $this->webroot;  ?>/index"/>Afficher Tout </a>-->

                        <a  onClick="flvFPW1(wr + 'Etatclientarticles/imprimerrecherche?clientid=<?php echo @$clientid; ?>&date1=<?php echo @$date1; ?>&date2=<?php echo @$date2; ?>&familleid=<?php echo @$familleid; ?>&pointdeventeid=<?php echo @$pointdeventeid; ?>&articleid=<?php echo @$articleid; ?>&exerciceid=<?php echo @$exerciceid; ?>&tagid=<?php echo @$tagid; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>



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
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="ls-editable-table table-responsive ls-table">
                    <table class="table table-bordered ls-editable-table table-responsive ls-table" id="">
                        <thead>
                            <tr>
                                <th style="display: none;"> id</th>
                                <th align="25%"><center> Client </center></th>
                        <th align="25%"><center>Article</center></th>
                        <th align="10%"><center>Quantité</center></th>
                        <th align="20%"><center>CA HT</center></th>  
                        <th align="20%"><center>CA TTC</center></th>  

                        </tr></thead><tbody>
                            <?php
                            $cl = "";
                            $nom = "";
                            $style = "";
                            $kk = 0;
                            foreach ($tab as $k => $action) {
                                $kk++;
                            }
                            $totcl = 0;
                            $totqte = 0;
                            $totaleqte = 0;
                            $totaleca = 0;
                            $totalettc = 0;
                            foreach ($tab as $i => $action) {
                                $totaleqte = $totaleqte + $action[0]['qte'];
                                $totalettc = $totalettc + $action[0]['totalttc'];
                                $totaleca = $totaleca + $action[0]['tot'];
                                if ($cl != $action['Tabetatcaparclientarticle']['clientid']) {
                                    $cl = $action['Tabetatcaparclientarticle']['clientid'];
                                    $nom = @$action['Tabetatcaparclientarticle']['name'];
                                    $style = "style='border-bottom: none !important;'";
                                    if ($i != 0) {
                                        echo "<tr style='background-color:#e0e0e0'><td colspan='2' align='right'><strong>Total</strong></td><td align='left'><strong>" . $totqte . "</strong></td><td align='right'><strong>" . number_format($totcl, 3, '.', ' ') . "</strong></td><td align='right'><strong>" . number_format($totclt, 3, '.', ' ') . "</strong></td><tr>";
                                    }

                                    $totcl = 0;
                                    $totclt = 0;
                                    $totqte = 0;
                                    $totcl = $totcl + $action[0]['tot'];
                                    $totclt = $totclt + $action[0]['totalttc'];
                                    $totqte = $totqte + $action[0]['qte'];
                                } else {
                                    $nom = "";
                                    $style = "style='border: none !important;'";
                                    $totqte = $totqte + $action[0]['qte'];
                                    $totcl = $totcl + $action[0]['tot'];
                                    $totclt = $totclt + $action[0]['totalttc'];
                                }
                                ?>

                                <tr>
                                    <td style="display: none;">
                                        <?php echo $action['Tabetatcaparclientarticle']['clientid']; ?>
                                    </td>    
                                    <td <?php echo $style; ?>>
                                        <strong><?php echo $nom; ?></strong>
                                    </td>
                                    <td >
                                        <?php echo $action['Tabetatcaparclientarticle']['article'] ?>
                                    </td>
                                    <td >
                                        <?php
                                        $test = strpos($action[0]['qte'], ".");
                                        if ($test == true) {
                                            echo number_format($action[0]['qte'], 3, '.', ' ');
                                        } else {
                                            echo $action[0]['qte'];
                                        }
                                        ?>
                                    </td>
                                    <td align="right"><?php echo number_format($action[0]['tot'], 3, '.', ' '); ?></td>
                                    <td align="right"><?php echo number_format($action[0]['totalttc'], 3, '.', ' '); ?></td>


                                </tr>

                            <?php } ?>

                            <tr style="background-color:#e0e0e0"><td colspan='2' align="right"><strong>Total</strong></td><td align="left"><strong><?php echo @$totqte; ?></strong></td><td align="right"><strong><?php echo number_format($totcl, 3, '.', ' '); ?></strong></td><td align="right"><strong><?php echo number_format(@$totclt, 3, '.', ' '); ?></strong></td><tr>

                        </tbody>
<!--                        <tfoot>
                            <tr style="background-color: #428bca">
                                <td colspan="2" align="center"><strong> Total Général</strong></td>
                                <td align="left"><strong><?php // echo number_format($totaleqte, 3, '.', ' '); ?></strong></td>
                                <td align="right"><strong><?php // echo number_format($totaleca, 3, '.', ' '); ?></strong></td>
                                <td align="right"><strong><?php // echo number_format($totalettc, 3, '.', ' '); ?></strong></td>
                            </tr>
                        </tfoot>                  -->
                    </table>

                </div></div></div></div></div>	


