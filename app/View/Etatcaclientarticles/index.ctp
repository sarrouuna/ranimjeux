
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
        <?php echo $this->Form->create('Recherche',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
              	<?php 
                echo $this->Form->input('exercice1',array('id'=>'exercice1','value'=>$exerciceid1,'empty'=>'veuillez choisir','div'=>'form-group','label'=>'année debut','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
//		if (@$countsos > 1) {
//                echo $this->Form->input('societe_id', array('multiple' => 'true','empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Societe', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
//                }
                echo $this->Form->input('client_id',array('id'=>'client_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Client','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('moi_id',array('id'=>'moi_id','multiple'=>'multiple','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Mois','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
</div>
<div class="col-md-6">
                <?php
                echo $this->Form->input('exercice2',array('id'=>'exercice2','value'=>$exerciceid2,'empty'=>'veuillez choisir','div'=>'form-group','label'=>'année fin','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
		echo $this->Form->input('personnel_id',array('id'=>'personnel_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Personnel','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('pointdevente_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
 
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                    <button type="submit" class="btn btn-primary " id="aff">Chercher</button>  
<!--                    <a  onClick="flvFPW1(wr+'Etatclientarticles/imprimerrecherche?clientid=<?php echo @$clientid;?>&date1=<?php echo @$date1;?>&date2=<?php echo @$date2;?>&familleid=<?php echo @$familleid;?>&pointdeventeid=<?php echo @$pointdeventeid;?>&articleid=<?php echo @$articleid;?>&exerciceid=<?php echo @$exerciceid;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>-->
                   
                   

                    </div>
                </div>
            </div>
<?php echo $this->Form->end();?>
        </div>
    </div>
</div>
<div class="row" style="width:100%">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Etat CA Client/Année'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                                <table class="table table-bordered table-striped table-bottomless" id="">
                      <thead>
	<?php 
        if(!empty($moiid)){
        $comp=$moiid;    
        }else { 
        $comp=$mois;    
        }?>        
                      </thead>
                      <tbody>
        <td>
            <table  border="2" style="width:100%">
                <tr>
                    <td> Mois</td> 
                </tr>
                <tr>
                    <td> CA</td> 
                </tr>
                <tr>
                    <td>Année</td> 
                </tr>
                <tr>
                   <td> Qte <br> CA</td>
                </tr>
                <tr>
                    <td>Écart <br> %</td>
                </tr>
            </table>      
        </td>     
	<?php 
        $tot_annee1=0;
        $tot_annee2=0;
        $tab_annee1=array();
        $tab_annee2=array();
        $ppp=0;
        $b=6;
        foreach ($comp as $m=>$c){ 
            //debug($comp);
        $ppp++;    
        if(!empty($moiid)){    
        $m=$c;
        }
         $tot1a=0;
        $tot2a=0;
        $tot1b=0;
        $tot2b=0;
        $tot1f=0;
        $tot2f=0;
        $qte1b=0;
        $qte2b=0;
        $qte1a=0;
        $qte2a=0;
        $qte1f=0;
        $qte2f=0;
        $tot_bf1=0;
        $tot_bf2=0;
        $qte_bf1=0;
        $qte_bf2=0;
        //debug($m);
        if ($m==$b ){
        ?>
           
        
        <td>
            <table border="2" style="width:100%">
                <tr>
                    <td colspan="2" align="center"><?php echo $mois[$m]; ?></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">CA</td>
                </tr>
                <tr>
                    <td align="center"><?php echo $exercice1s[$exerciceid1]; ?> </td>
                    <td align="center"><?php echo $exercice2s[$exerciceid2];?> </td>
                </tr>
                <tr>
                    <td align="center" nowrap="nowrap">
                    <?php
                    if(!empty($bonlivraisonparprix1s)){
                    foreach ($bonlivraisonparprix1s as $bon){ 
                    if($bon[0]['mois']==$m){ 
                        //debug("d5Al bl 2015");
                    //$qte1b=$bon[0]['quantite'];
                    $tot1b=$bon[0]['total']; 
                    }}}
                    if(!empty($factureclientparprix1s)){
                    foreach ($factureclientparprix1s as $fac){ 
                    if($fac[0]['mois']==$m){
                        //debug("d5Al fac 2015");
                    //$qte1f=$fac[0]['quantite'];
                    $tot1f=$fac[0]['total']; 
                    }}}
                    if(!empty($factureavoirparprix1s)){
                    foreach ($factureavoirparprix1s as $fac){ 
                    if($fac[0]['mois']==$m){
                        //debug("d5Al fac 2015");
                    //$qte1a=$fac[0]['quantite'];
                    $tot1a=$fac[0]['total']; 
                    }}}
                    //$qte_bf1=$qte1b+$qte1f-$qte1a;
                    $tot_bf1=$tot1b+$tot1f-$tot1a;
                    $tot_annee1=$tot_annee1+$tot_bf1;
                    ?>
                    <?php //echo number_format($qte_bf1,3, '.', ' '); ?><br>    
                    <?php echo number_format($tot_bf1,3, '.', ' ');?>
                    <?php 
                    $tab_annee1[$ppp]['mois']=$mois[$m];
                    $tab_annee1[$ppp]['tot']=$tot_bf1;
                    ?>
                    </td>
                    
                    
                    
                    
                    
                    <td align="center" nowrap="nowrap">
                    <?php
                    if(!empty($bonlivraisonparprix2s)){
                    foreach ($bonlivraisonparprix2s as $bon2){ 
                    if($bon2[0]['mois']==$m){
                        //debug("d5Al bl 2016");
                    //$qte2b=$bon2[0]['quantite'];
                    $tot2b=$bon2[0]['total']; 
                    }}}
                    if(!empty($factureclientparprix2s)){
                    foreach ($factureclientparprix2s as $fac2){ 
                    if($fac2[0]['mois']==$m){ 
                        //debug("d5Al fac 2016");
                    //$qte2f=$fac2[0]['quantite'];
                    $tot2f=$fac2[0]['total'];
                    }}}
                    if(!empty($factureavoirparprix2s)){
                    foreach ($factureavoirparprix2s as $fac2){ 
                    if($fac2[0]['mois']==$m){ 
                        //debug("d5Al fac 2016");
                    //$qte2a=$fac2[0]['quantite'];
                    $tot2a=$fac2[0]['total'];
                    }}}
                    //$qte_bf2=$qte2b+$qte2f-$qte2a;
                    $tot_bf2=$tot2b+$tot2f-$tot2a;
                    $tot_annee2=$tot_annee2+$tot_bf2;
                    ?>
                    <?php //echo number_format($qte_bf2,3, '.', ' ');?><br>    
                    <?php echo number_format($tot_bf2,3, '.', ' ')?> 
                     <?php 
                    $tab_annee2[$ppp]['mois']=$mois[$m];
                    $tab_annee2[$ppp]['tot']=$tot_bf2;
                    ?>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="2">
                    <?php  
                    $ecart=$tot_bf2-$tot_bf1;
                    $ecartt=$tot_bf2-$tot_bf1;
                    if($tot_bf1!=0){
                    if($ecart<0){
                    $ecart=0-$ecart;
                    $img='<img class="rounded" src="'.$this->webroot.'img/decroissante.jpg" width="20px" height="20px" />';
                    $p=(($ecart/$tot_bf1)*100)*(-1);
                    }else{
                    $img='<img class="rounded" src="'.$this->webroot.'img/croissante.png" width="20px" height="20px" />';
                    $p=($ecart/$tot_bf1)*100;
                    }    
                    }else{
                    $img='<img class="rounded" src="'.$this->webroot.'img/croissante.png" width="20px" height="20px" />';
                    $p=100;    
                    }
                    ?>
                        <table style="width:100%">
                        
                            <tr >
                                <td colspan="2" align="center" nowrap="nowrap">
                                 <?php if($tot_bf2 !=0){  echo number_format($ecartt,3, '.', ' ');}else{echo "<br><br>";}?>   
                                </td> 
                            </tr>
                            <tr>
                                <td align="center" nowrap="nowrap">
                                 <?php if($tot_bf2 !=0){  echo $img;}?>   
                                </td>
                                <td align="center" nowrap="nowrap">
                                 <?php
                                 if($tot_bf2 !=0){ 
                                 $test=strpos($p, ".");
                                 if($test==true){
                                 echo sprintf('%.2f',$p)."%";
                                 }else{
                                 echo $p."%";    
                                 }
                                 }
                                 ?>   
                                </td>
                            </tr>
                           
                        </table>   
                    </td>   
                </tr>
            </table>       
        </td>
        <tr>
             
        </tr>
        <td>
            <table  border="2" style="width:100%">
                <tr>
                    <td> Mois</td> 
                </tr>
                <tr>
                    <td> CA</td> 
                </tr>
                <tr>
                    <td>Année</td> 
                </tr>
                <tr>
                   <td> Qte <br> CA</td>
                </tr>
                <tr>
                    <td>Écart <br> %</td>
                </tr>
            </table>      
        </td>
        <?php }else{ ?>
           
        
        <td>
            <table border="2" style="width:100%">
                <tr>
                    <td colspan="2" align="center"><?php echo $mois[$m]; ?></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">CA</td>
                </tr>
                <tr>
                    <td align="center"><?php echo $exercice1s[$exerciceid1]; ?> </td>
                    <td align="center"><?php echo $exercice2s[$exerciceid2];?> </td>
                </tr>
                <tr>
                    <td align="center" nowrap="nowrap">
                    <?php
                    if(!empty($bonlivraisonparprix1s)){
                    foreach ($bonlivraisonparprix1s as $bon){ 
                    if($bon[0]['mois']==$m){ 
                        //debug("d5Al bl 2015");
                    //$qte1b=$bon[0]['quantite'];
                    $tot1b=$bon[0]['total']; 
                    }}}
                    if(!empty($factureclientparprix1s)){
                    foreach ($factureclientparprix1s as $fac){ 
                    if($fac[0]['mois']==$m){
                        //debug("d5Al fac 2015");
                    //$qte1f=$fac[0]['quantite'];
                    $tot1f=$fac[0]['total']; 
                    }}}
                    if(!empty($factureavoirparprix1s)){
                    foreach ($factureavoirparprix1s as $fac){ 
                    if($fac[0]['mois']==$m){
                        //debug("d5Al fac 2015");
                    //$qte1a=$fac[0]['quantite'];
                    $tot1a=$fac[0]['total']; 
                    }}}
                    //$qte_bf1=$qte1b+$qte1f-$qte1a;
                    $tot_bf1=$tot1b+$tot1f-$tot1a;
                    $tot_annee1=$tot_annee1+$tot_bf1;
                    ?>
                    <?php //echo number_format($qte_bf1,3, '.', ' '); ?><br>    
                    <?php echo number_format($tot_bf1,3, '.', ' ');?>
                    <?php 
                    $tab_annee1[$ppp]['mois']=$mois[$m];
                    $tab_annee1[$ppp]['tot']=$tot_bf1;
                    ?>
                    </td>
                    
                    
                    
                    
                    
                    <td align="center" nowrap="nowrap">
                    <?php
                    if(!empty($bonlivraisonparprix2s)){
                    foreach ($bonlivraisonparprix2s as $bon2){ 
                    if($bon2[0]['mois']==$m){
                        //debug("d5Al bl 2016");
                    //$qte2b=$bon2[0]['quantite'];
                    $tot2b=$bon2[0]['total']; 
                    }}}
                    if(!empty($factureclientparprix2s)){
                    foreach ($factureclientparprix2s as $fac2){ 
                    if($fac2[0]['mois']==$m){ 
                        //debug("d5Al fac 2016");
                    //$qte2f=$fac2[0]['quantite'];
                    $tot2f=$fac2[0]['total'];
                    }}}
                    if(!empty($factureavoirparprix2s)){
                    foreach ($factureavoirparprix2s as $fac2){ 
                    if($fac2[0]['mois']==$m){ 
                        //debug("d5Al fac 2016");
                    //$qte2a=$fac2[0]['quantite'];
                    $tot2a=$fac2[0]['total'];
                    }}}
                    //$qte_bf2=$qte2b+$qte2f-$qte2a;
                    $tot_bf2=$tot2b+$tot2f-$tot2a;
                    $tot_annee2=$tot_annee2+$tot_bf2;
                    ?>
                    <?php //echo number_format($qte_bf2,3, '.', ' ');?><br>    
                    <?php echo number_format($tot_bf2,3, '.', ' ')?> 
                     <?php 
                    $tab_annee2[$ppp]['mois']=$mois[$m];
                    $tab_annee2[$ppp]['tot']=$tot_bf2;
                    ?>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="2">
                    <?php  
                    $ecart=$tot_bf2-$tot_bf1;
                    $ecartt=$tot_bf2-$tot_bf1;
                    if($tot_bf1!=0){
                    if($ecart<0){
                    $ecart=0-$ecart;
                    $img='<img class="rounded" src="'.$this->webroot.'img/decroissante.jpg" width="20px" height="20px" />';
                    $p=(($ecart/$tot_bf1)*100)*(-1);
                    }else{
                    $img='<img class="rounded" src="'.$this->webroot.'img/croissante.png" width="20px" height="20px" />';
                    $p=($ecart/$tot_bf1)*100;
                    }    
                    }else{
                    $img='<img class="rounded" src="'.$this->webroot.'img/croissante.png" width="20px" height="20px" />';
                    $p=100;    
                    }
                    ?>
                        <table style="width:100%">
                        
                            <tr >
                                <td colspan="2" align="center" nowrap="nowrap">
                                 <?php if($tot_bf2 !=0){  echo number_format($ecartt,3, '.', ' ');}else{echo "<br><br>";}?>   
                                </td> 
                            </tr>
                            <tr>
                                <td align="center" nowrap="nowrap">
                                 <?php if($tot_bf2 !=0){  echo $img;}?>   
                                </td>
                                <td align="center" nowrap="nowrap">
                                 <?php
                                 if($tot_bf2 !=0){ 
                                 $test=strpos($p, ".");
                                 if($test==true){
                                 echo sprintf('%.2f',$p)."%";
                                 }else{
                                 echo $p."%";    
                                 }
                                 }
                                 ?>   
                                </td>
                            </tr>
                           
                        </table>   
                    </td>   
                </tr>
            </table>       
        </td>    
        <?php }}?>    
                       </tbody>
	</table>
                    <table border="2" align="center" style="width:40%">
                        <tr>
                            <td align="center"><?php echo $exercice1s[$exerciceid1]; ?> </td>
                            <td align="center"><?php echo $exercice2s[$exerciceid2];?> </td>   
                        </tr>
                        <tr>
                            <td align="center"><?php echo number_format($tot_annee1,3, '.', ' '); ?> </td>
                            <td align="center"><?php echo number_format($tot_annee2,3, '.', ' ');?> </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2"><?php echo "Écart  ". number_format($tot_annee2-$tot_annee1,3, '.', ' '); ?> </td>
                        </tr>
                        <tr>
                            <?php 
                                $ec=$tot_annee2-$tot_annee1;
                                if($tot_annee1!=0){
                                if($ec<0){
                                $ec=0-$ec;
                                }
                                $pp=($ec/$tot_annee1)*100;
                                }else{
                                $pp=100;    
                                }
                                ?>
                            <td align="center" colspan="2"><?php 
                            $testp=strpos($pp, ".");
                                 if($testp==true){
                                 echo "Pourcentage  ". sprintf('%.2f',$pp)."%";
                                 }else{
                                 echo "Pourcentage  ".$pp."%";    
                                 }
                                 ?> </td>
                        </tr>
                    </table>
                                </div></div></div></div></div>
    
<?php 
$anne='"'.utf8_encode($exercice1s[$exerciceid1]).' '.utf8_encode($exercice2s[$exerciceid2]).'"';

?>
<!-- Main Content Element  Start-->
                    <div class="row" style="display: none;">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Real Time</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="realTimeChart" class="flotChartRealTime">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<div class="row">
<!--    ------------ Production--------------------->
                        <div class="col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title" align="center"><strong>Statistique <?php echo $exercice1s[$exerciceid1]; ?></strong></h3>
                                    
                                </div>
                                <div class="panel-body">
                                    <div id="flotPieChart" class="flotPieChart"></div>
                                    <div class="paiChartAction">
                                        <p id="description"></p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

<!--         -----------------  Vente--------------->
                    <div class="col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title" align="center"><strong>Statistique <?php echo $exercice2s[$exerciceid2]; ?></strong></h3>
                                    
                                </div>
                                <div class="panel-body">
                                    <div id="flotPieChart1" class="flotPieChart"></div>
                                    <div class="paiChartAction">
                                        <p id="description1"></p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


<div class="col-md-4">
    
<div class="row">
                <div class="col-md-12">
                         <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title" align="center"><strong>Statistique "Histogramme" <?php echo $exercice1s[$exerciceid1]; ?>/  <?php echo $exercice2s[$exerciceid2]; ?></strong></h3>
                        </div>
                        <div class="panel-body">
                            <div class="bar_chart_canvas_box">
                                <canvas id="bar_chart_canvas1" height="300" width="600"></canvas>
                            </div>
                            <table align="right" style="width: 50%">
                                <tr>
                                    <td align="right"><strong><?php echo $exercice1s[$exerciceid1]; ?> : &nbsp;</strong></td>
                                    <td align="left"><div style="background-color: #FF7878;height: 15px;width: 20px;"></div></td>
                                </tr><tr>
                                    <td align="right"><strong><?php echo $exercice2s[$exerciceid2]; ?> : &nbsp;</strong></td>
                                    <td align="left"><div style="background-color: #1fb5ad;height: 15px;width: 20px;"></div></td>
                                </tr>
                            </table>
                            
                        </div>
                    </div>

                </div>
            </div>    
    
    
    
    
</div>
                    </div>






    <div class="row">
                <div class="col-md-12">
                         <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title" align="center"><strong>Statistique "Histogramme" <?php echo $exercice1s[$exerciceid1]; ?>/  <?php echo $exercice2s[$exerciceid2]; ?></strong></h3>
                        </div>
                        <div class="panel-body">
                            <div class="bar_chart_canvas_box">
                                <canvas id="bar_chart_canvas" height="300" width="600"></canvas>
                            </div>
                            <table align="right" style="width: 50%">
                                <tr>
                                    <td align="right"><strong><?php echo $exercice1s[$exerciceid1]; ?> : &nbsp;</strong></td>
                                    <td align="left"><div style="background-color: #FF7878;height: 15px;width: 20px;"></div></td>
                                </tr><tr>
                                    <td align="right"><strong><?php echo $exercice2s[$exerciceid2]; ?> : &nbsp;</strong></td>
                                    <td align="left"><div style="background-color: #1fb5ad;height: 15px;width: 20px;"></div></td>
                                </tr>
                            </table>
                            
                        </div>
                    </div>

                </div>
            </div>

                    
    
    <?php 
    //debug($tab_annee1);
    //debug($tab_annee2);
    $fam="";$var="";$tot1=0;$tot2=0;$v="";
    
    $secteur=array();
    $secteur1=array();
    $vente=array();
    
    foreach($tab_annee1 as $k=>$annee1){
        $tot1+=$annee1['tot'];
    }
    foreach($tab_annee2 as $k=>$annee2){
        $tot2+=$annee2['tot'];
    }
    foreach($tab_annee2 as $k=>$annee2){
       $secteur1[$k]['mois']=$annee2['mois'];
       $secteur1[$k]['prc']=($annee2['tot']/$tot2)*100;
    }
    //debug($ligneproductions);die;
    
    foreach($tab_annee1 as $k=>$annee1){
     $vent=0;
     //debug($k);
        foreach ($tab_annee2 as $annee2){
            if($annee2['mois']==$annee1['mois']){
               $vent=$annee2['tot']; 
               $vente[$k]=$annee2['mois'];
            }
        }
            if($k==1){
                $fam.='"'.utf8_encode($annee1['mois']).'"'; 
                 $var.=$annee1['tot']; 
                 $v=$vent;
               }else{
                  $fam.=',"'.utf8_encode($annee1['mois']).'"';
                  $var.=', '.$annee1['tot'];
                  $v.=', '.$vent;
              }
        $secteur[$k]['mois']=$annee1['mois'];
        $secteur[$k]['prc']=($annee1['tot']/$tot1)*100;
             
    }
    foreach ($tab_annee2 as $annee2){
               $b=0;
           foreach ($vente as $ll){ 
            if($annee2['mois']==$ll){
               $b=1;
           }}
           if($b==0){
              $fam.=',"'.utf8_encode($annee2['mois']).'"';
                  $var.=', 0';
                  $v.=', '.$annee2['tot']; 
           }
        }
   
     //debug($secteur);
     //debug($secteur1);die;
        //debug($k);die;
    $z=$k-1;    
    ?>
 
<script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/color.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/chart/chartjs/Chart.min.js"></script>


<script>
<?php 
//$k=1;
//$bonlivraisons=array();
//$bonlivraisons[0]['Client']['name']='aaaa';
//$bonlivraison[0][0]['total_ht']='2000';
//$bonlivraisons[1]['Client']['name']='bbbb';
//$bonlivraison[1][0]['total_ht']='2500';
?>    
var $flotPieChart = $('#flotPieChart');
var pieData = [],
    series = <?php echo $z;?>
<?php foreach($tab_annee1 as $h=>$annee1){ $zz=$h-1;?> 
    pieData[<?php echo $zz;?>] = {
        label: "<?= $annee1['mois'] ?>",  
        data: <?= $annee1['tot'] ?>
   
}
<?php } ?>
var $flotPieChart1 = $('#flotPieChart1');
var pieData1 = [],
    series = <?php echo $z;?>
<?php foreach($tab_annee2 as $hh=>$annee2){ $zzz=$hh-1;?> 
    pieData1[<?php echo $zzz;?>] = {
        label: "<?= $annee2['mois'] ?>",  
        data: <?= $annee2['tot'] ?>
   
}
<?php } ?>
function flot_pie_chart(){
    'use strict';

    $flotPieChart.unbind();

        $("#title").text("PRODUCTION");
        $("#description").text("");

        $.plot($flotPieChart, pieData, {
            series: {
                pie: {
                    show: true,
                    combine: {
                        color: "#999",
                        threshold: 0.05
                    }
                }
            },
            legend: {
                show: false
            },
            colors: [$fillColor2, $lightBlueActive, $redActive, $blueActive, $brownActive, $greenActive]
        });
        $flotPieChart1.unbind();

        $("#title1").text("Vente");
        $("#description1").text("");

        $.plot($flotPieChart1, pieData1, {
            series: {
                pie: {
                    show: true,
                    combine: {
                        color: "#999",
                        threshold: 0.05
                    }
                }
            },
            legend: {
                show: false
            },
            colors: [$fillColor2, $lightBlueActive, $redActive, $blueActive, $brownActive, $greenActive]
        });
}   
    jQuery(document).ready(function($) {
    'use strict';
    chartLoad();
    chartLoads();
});

var sizeId;
$(window).resize(function() {
    clearTimeout(sizeId);
    sizeId= setTimeout(chartSize, 1000);

});
/******** Chart js Data set Start********/
var randomScalingFactor = function(){ return Math.round(Math.random()*10)};
var barChartData = {
    labels : [<?php echo $fam;?>],
    datasets: [
        {
            fillColor: $redActive,
            data: [<?php echo $var;?>]
        },
                {
                    fillColor: $lightGreen,
                     data: [<?php echo $v;?>]
                }
    ]

}

//***************************************************
var barChartData1 = {
    labels : [<?php echo $anne;?>],
    datasets: [
        {
            fillColor: $redActive,
            data: [<?php echo $tot_annee1;?>]
        },
                {
                    fillColor: $lightGreen,
                     data: [<?php echo $tot_annee2;?>]
                }
    ]

}





/******** Chart js Defaults Global Value Set End ********/
var myBar;
var myLine;
var myPie;
var myDoughnut;
var myPolarArea;
var myRadar;
function chartLoad(){
    'use strict';
    var ctx = document.getElementById("bar_chart_canvas").getContext("2d");
    myBar = new Chart(ctx).Bar(barChartData, {responsive : true, barShowStroke: false });
    
    var ctx = document.getElementById("bar_chart_canvas1").getContext("2d");
    myBar = new Chart(ctx).Bar(barChartData1, {responsive : true, barShowStroke: false });
    
    var ctx = document.getElementById("pie-chart-area").getContext("2d");
    myPie = new Chart(ctx).Pie(pieData, {responsive : true});

    var ctx = document.getElementById("doughnut-chart-area").getContext("2d");
    myDoughnut = new Chart(ctx).Doughnut(doughnutData, {responsive : true});

    var ctx = document.getElementById("polar-chart-area").getContext("2d");
    myPolarArea = new Chart(ctx).PolarArea(polarData, {
        responsive:true
    });
    myRadar = new Chart(document.getElementById("radar-chart-area").getContext("2d")).Radar(radarChartData, {responsive: true });
    var ctx = document.getElementById("line-chart-area").getContext("2d");
    myLine  = new Chart(ctx).Line(lineChartData, { responsive: true });
}

function chartSize(){
    //console.log('LOG');
    myLine.destroy();
    myBar.destroy();
    myPie.destroy();
    myDoughnut.destroy();
    myPolarArea.destroy();
    myRadar.destroy();
   // chartLoad();
}
</script>




  


