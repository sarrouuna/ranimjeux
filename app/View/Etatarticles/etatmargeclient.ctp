<!--<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Etatclients/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>-->
<?php
$lien = CakeSession::read('lien_stat');
$imprimer = "";
//debug($lien);die;
if (!empty($lien)) {
    foreach ($lien as $k => $liens) {
        if (@$liens['lien'] == 'etatclients') {
            $imprimer = $liens['imprimer'];
        }
    }
}
?>
<script language="JavaScript" type="text/JavaScript">

    function flvFPW1(){

    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    }
</script>

<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche Par Client'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Recherche', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('date1', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly ', 'type' => 'text', 'label' => 'Date de'));
                    echo $this->Form->input('client_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Client', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('pointdevente_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de Vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    //echo $this->Form->input('factureclient_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Facture Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                    echo $this->Form->input('date2', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly', 'type' => 'text', 'label' => "Jusqu'Ã "));
                    echo $this->Form->input('exercice_id', array('value' => $exerciceid, 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'année', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('personnel_id', array('id' => 'client_id', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Personnel', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    //echo $this->Form->input('fournisseur_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Fournisseur','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                    ?>

                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
<!--                 <a class="btn btn-primary" href="<?php //echo $this->webroot;  ?>/index"/>Afficher Tout </a>-->
                        <?php if ($imprimer == 1) { ?>
                            <a  onClick="flvFPW1(wr + 'Etatarticles/imprimerrecherchec?clientid=<?php echo @$clientid; ?>&date1=<?php echo @$date1; ?>&date2=<?php echo @$date2; ?>&pointdeventeid=<?php echo @$pointdeventeid; ?>&exerciceid=<?php echo @$exerciceid; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);
                                    return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                            <?php } ?>



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
                <h3 class="panel-title"><?php echo __('Marge De Vente Par Clients'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="ls-editable-table table-responsive ls-table">
                    <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                        <thead>



                        <th ><center> Client </center></th>
                        <th><center>Valeur Achat</center></th> 
                        <th><center>Valeur Vente</center></th> 
                        <th><center>B&eacute;n&eacute;fice</center></th> 
                        <th><center>Taux %</center></th>


                        </thead><tbody>
                            <?php
                            $tot = 0;
                            $totpmp = 0;

                            foreach ($tab as $action): //debug($action);die;
                                $tot = $tot + $action[0]['tot'];
                                $totpmp = $totpmp + $action[0]['pmp'];
                                $marge=$action[0]['tot']- $action[0]['pmp'];
                                ?>
                                <tr>
                                    <td><?php echo $action['Tabetatclient']['name']; ?></td>
                                    <td align="right"><?php echo number_format($action[0]['pmp'], 3, '.', ' '); ?></td>
                                    <td align="right"><?php echo number_format($action[0]['tot'], 3, '.', ' '); ?></td>
                                     <td align="right"><?php echo number_format($marge, 3, '.', ' '); ?></td>
                                     <td align="right"><?php echo number_format(($marge/$action[0]['tot'])*100, 3, '.', ' ')."%"; ?></td>
                                   


                                </tr>
    <?php
endforeach;
?>

                        
                        
                        <tfoot>
                        <td  align="right">Total</td>
                        <td  align="right"><?php echo number_format($totpmp,3, '.', ' '); ?></td>
                        <td  align="right"><?php echo number_format($tot,3, '.', ' '); ?></td>
                        <td  align="right"><?php echo number_format($tot-$totpmp,3, '.', ' '); ?></td>
                        <td align="right"><?php echo number_format((($tot-$totpmp)/$tot)*100,3, '.', ' ')."%"; ?></td>
                        </tfoot>
                        
                        
                        </tbody>
                    </table>

                </div></div></div></div></div>	


