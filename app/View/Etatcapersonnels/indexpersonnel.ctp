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
        if ($liens['lien'] == 'etatpointdeventes') {
            $imprimer = $liens['imprimer'];
        }
    }
}

?>

<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche Par Personnel'); ?></h3>
            </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Recherche',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
              	<?php 
		echo $this->Form->input('date1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly ','type'=>'text','label'=>'Date de') ); 
      
         
               echo $this->Form->input('personnel_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Personnel','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));

?>
</div>
<div class="col-md-6">
                <?php
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'Ã ") ); 
               echo $this->Form->input('exercice_id',array('value'=>$exerciceid,'empty'=>'veuillez choisir','div'=>'form-group','label'=>'année','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
?>
 
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
<!--                 <a class="btn btn-primary" href="<?php //echo $this->webroot;?>/index"/>Afficher Tout </a>-->
                 

                    </div>
                </div>
            </div>
<?php echo $this->Form->end();?>
        </div>
    </div>
</div>
<div class="col-md-12" >
    <div class="col-md-6"> 
        <div class="panel panel-default">
        <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('CA'); ?></h3>
            </div><div class="panel-body">
<table class="table">       
                                                   <thead>
                                                      <tr bgcolor="#EAEAEA">
                                                          <th ><center> Personnel </center></th>
                                                          <th><center>CA HT</center></th> 
                                                     <th><center>CA TTC</center></th> 
                                                          <th><center>%CA </center></th>
                                                           
                                                         
                                                      </tr>
                                                   </thead>
                                                   <tbody>
	                                           <?php 
                                                   $somm=0;
                                                   foreach ($tab as $k=>$action): 
                                                       $somm=$somm+$action['tot'];
                                                       ?>
	<tr>
		<td><strong><?php echo $action['Pname']; ?></strong></td>
		<td align="right"><?php echo number_format($action['tot'],3, '.', ' '); ?></td>
                 <td align="right"><?php echo number_format($action['totttc'],3, '.', ' '); ?></td>
                <td align="right"><?php echo number_format($action['por'],3, '.', ' '); ?>%</td>
                
                
		
		
	</tr>
                                                   <?php  endforeach; ?>
        <tr>
               <td><strong> Total</strong></td>
               <td  align="right"><?php 
               echo number_format($totaleBLF,3, '.', ' ');
              // echo number_format($somm,3, '.', ' '); ?></td>
               <td  align="right"><?php 
               echo number_format($totaleBLFttc,3, '.', ' ');
              // echo number_format($somm,3, '.', ' '); ?></td>
      
       </tr>
                                                    </tbody>
	                                        </table>
                                                  </div></div></div>    
<div class="row" style="display: none">
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
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Statistiques </h3>
                                </div>
                                <div class="panel-body">
                                    <div id="flotPieChart" class="flotPieChart"></div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
 </div>
<?php //$k=1;
//$bonlivraisons=array();
//$bonlivraisons[0]['Client']['name']='aaaa';
//$bonlivraison[0][0]['total_ht']='2000';
//$bonlivraisons[1]['Client']['name']='bbbb';
//$bonlivraison[1][0]['total_ht']='2500';
?>
<script>

var $flotPieChart = $('#flotPieChart');
var pieData = [],
    series = <?php echo $k;?>
<?php foreach ($tab as $h=>$action){ ?> 
    pieData[<?php echo $h;?>] = {
        label: "<?= $action['Pname'].' CA : '.$action['tot']; ?>",  
        data: <?= $action['por'] ?>
   
}
<?php } ?>
    function flot_pie_chart(){
    'use strict';

    $flotPieChart.unbind();

        $("#title").text("Combined Slice");
        $("#description").text("Multiple slices less than a given percentage (5% in this case) of the pie can be combined into a single, larger slice.");

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
            colors: [$greenActive,$blueActive,$redActive,$fillColor2, $lightBlueActive, $brownActive]
        });
}



</script>

  

