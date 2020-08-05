<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Stockdepot',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
                    <?php 
                        //echo $this->Form->input('article_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Article','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                    ?>

                    <div class="col-dm-6" style="display:inline; position: relative;">
                        <?php
                        echo $this->Form->input('article_id', array('div' => 'form-group', 'index' => '0', 'id' => 'article_id0', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                        echo $this->Form->input('designation', array('div' => 'form-group','placeholder'=>'Designation','label'=>'Article', 'index' => '0', 'id' => 'designation0', 'champ' => 'designation', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control haithamselect', 'type' => 'text')); ?>
                        <div class="form-group" style="display:inline; position: relative;bottom: 24px !important;left: 11px;">
                            <label></label>
                            <div id="res0" champ="res" index="0"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>

                        </div>
                    </div>

                </div>
               <div class="col-md-6">
                <?php
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly ','type'=>'text','label'=>'Date') ); 
                ?>
 
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                 <a class="btn btn-primary" href="<?php echo $this->webroot;?>etatfuturcommandes/index"/>Afficher Tout </a>
                    <?php //if($imprimer==1){ ?>
                    <?php // }?>
                   

                    </div>
                </div>
            </div>
<?php echo $this->Form->end();?>
        </div>
    </div>
</div>
<br><input type="hidden" id="page" value="1"/>
<html lang="en" xmlns="http://www.w3.org/1999/html"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- Viewport metatags -->
    <meta name="HandheldFriendly" content="true">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- iOS webapp metatags -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- iOS webapp icons -->
    <link rel="apple-touch-icon-precomposed" href="assets/images/ios/fickle-logo-72.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/ios/fickle-logo-72.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/ios/fickle-logo-114.png">

    <!-- TODO: Add a favicon -->
    <link rel="shortcut icon" href="assets/images/ico/fab.ico">

    

    <!--Page loading plugin Start -->
    <link rel="stylesheet" href="assets/css/plugins/pace.css">
    <script src="assets/js/pace.min.js"></script>
    <!--Page loading plugin End   -->

    <!-- Plugin Css Put Here -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Plugin Css End -->
    <!-- Custom styles Style -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- Custom styles Style End-->

    <!-- Responsive Style For-->
    <link href="assets/css/responsive.css" rel="stylesheet">
    <!-- Responsive Style For-->

    <!-- Custom styles for this template -->


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>


  <?php if (!empty($etatfuturcommandes)){ ?>
                    <div class="row" style="width:300%">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">courbe des commandes prochaines</h3>
                                </div>
                                <div class="panel-body no-padding">
                                    <div id="2LineGraph" style="position: relative;top: 200px;">
<svg height="1000"  version="1.1" style="width:3000px"  style="overflow: hidden; position: relative;">
    <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.0.1</desc>
    <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
    
    <text x="43.5" y="650" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; 
    font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; 
    line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">-300</tspan></text>
    <path style="width:3000px" fill="none" stroke="#aaaaaa" d="M56,650H3000" stroke-width="0.5"
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
    
    <text x="43.5" y="600" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; 
    font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; 
    line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">-250</tspan></text>
    <path fill="none" stroke="#aaaaaa" d="M56,600H3000" stroke-width="0.5"
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
    
    <text x="43.5" y="550" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; 
    font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; 
    line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">-200</tspan></text>
    <path fill="none" stroke="#aaaaaa" d="M56,550H3000" stroke-width="0.5"
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
    
    <text x="43.5" y="500" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; 
    font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; 
    line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">-150</tspan></text>
    <path fill="none" stroke="#aaaaaa" d="M56,500H3000" stroke-width="0.5"
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
    
    
    <text x="43.5" y="450" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; 
    font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; 
    line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">-100</tspan></text>
    <path fill="none" stroke="#aaaaaa" d="M56,450H3000" stroke-width="0.5"
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
    
    <text x="43.5" y="400" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; 
    font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; 
    line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">-50</tspan></text>
    <path fill="none" stroke="#aaaaaa" d="M56,400H3000" stroke-width="0.5"
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
    
    <text x="43.5" y="350" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; 
    font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; 
    line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text>
    <path fill="none" stroke="#aaaaaa" d="M56,350H3000" stroke-width="0.5"
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path> 
    
     <?php 
    $position=100;
    foreach ($datefuturcommandes as $datefuturcommande) { ?>
    <text x="<?php echo $position ; ?>" y="350" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; 
    font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; 
    font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal" 
    transform="matrix(1,0,0,1,0,7)">
    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><?php echo date("d/m/Y", strtotime(str_replace('/', '-', $datefuturcommande['Etatfuturcommande']['date']))); ?></tspan></text>
    <?php $position=$position+100;  } ?>
    
    
    
    
    <text x="43.5" y="300" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; 
    font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; 
    line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">50</tspan></text>
    <path fill="none" stroke="#aaaaaa" d="M56,300H3000" stroke-width="0.5"
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
    
    <text x="43.5" y="250" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" 
    fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; 
    font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; 
    font-size: 12px; line-height: normal; font-family: sans-serif;" 
    font-size="12px" font-family="sans-serif" font-weight="normal">
    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">100</tspan></text>
    <path fill="none" stroke="#aaaaaa" d="M56,250H3000" stroke-width="0.5" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
    
    <text x="43.5" y="200" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; 
    font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; 
    font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">150</tspan></text>
    <path fill="none" stroke="#aaaaaa" d="M56,200H3000" stroke-width="0.5" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
    
    
    <text x="43.5" y="150" text-anchor="end" font="10px &quot;Arial&quot;" 
    stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); 
    text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; 
    font-stretch: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" 
    font-size="12px" font-family="sans-serif" font-weight="normal">
    <tspan dy="4.000000000000028" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">200</tspan></text>
    <path fill="none" stroke="#aaaaaa" d="M56,150H3000" stroke-width="0.5" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
    
    <text x="43.5" y="100" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; 
    font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; 
    font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">250</tspan></text>
    <path fill="none" stroke="#aaaaaa" d="M56,100H3000" stroke-width="0.5" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
    
    <text x="43.5" y="50" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; 
    font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 12px; line-height: normal; 
    font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
    <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">300</tspan></text>
    <path fill="none" stroke="#aaaaaa" d="M56,50H3000" stroke-width="0.5" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
    
   
   
    
    
   
    <?php 
    $tab=array();
    $tabq=array();
    $position=100;
    $testdate="";
    $qte=0;
    $qte_en=0;
    $qte_sor=0;
    $comp=0;
    foreach ($etatfuturcommandes as $k=>$etatfuturcommande) {
        if($etatfuturcommande['Etatfuturcommande']['date']!=$testdate){
                if($etatfuturcommande['Etatfuturcommande']['type']=="stock initiale"){
                 $qte=$qte+$etatfuturcommande['Etatfuturcommande']['qte'];
                 $tabq[$comp]="stock initiale ".$etatfuturcommande['Etatfuturcommande']['qte'];
                }
                if($etatfuturcommande['Etatfuturcommande']['type']=="Entrée"){
                 $qte=$qte+$etatfuturcommande['Etatfuturcommande']['qte'];
                 $tabq[$comp]="Entrée ".$etatfuturcommande['Etatfuturcommande']['qte'];
                }
               if($etatfuturcommande['Etatfuturcommande']['type']=="Sortie"){
                 $qte=$qte-$etatfuturcommande['Etatfuturcommande']['qte'];
                 $tabq[$comp]="Sortie ".$etatfuturcommande['Etatfuturcommande']['qte'];
               }  
        foreach ($etatfuturcommandes as $i=>$e) {
         if(($i !=0)&&($i!=$k)){ 
          if($etatfuturcommande['Etatfuturcommande']['date']==$e['Etatfuturcommande']['date']){
               if($e['Etatfuturcommande']['type']=="Entrée"){
                 $qte=$qte+$e['Etatfuturcommande']['qte'];
                 $tabq[$comp]="Entrée ".$etatfuturcommande['Etatfuturcommande']['qte'];
                }
               if($e['Etatfuturcommande']['type']=="Sortie"){
                 $qte=$qte-$e['Etatfuturcommande']['qte'];
                 $tabq[$comp]="Sortie ".$etatfuturcommande['Etatfuturcommande']['qte'];
                }  
          }   
         }  
        }
    //debug($qte);
    if($qte>0){
        $q=350-$qte;
    }else{
        $q=350-$qte;
    }
    
    $tab[$comp]=$q;
    
    ?>
    <circle cx="<?php echo $position ; ?>" cy="<?php  echo $q  ; ?>" r="4" fill="#ff7878" stroke="#ffffff" stroke-width="1" 
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
    </circle>
    <?php 
    $position=$position+100;
    $comp=$comp+1;
    }
    $testdate=$etatfuturcommande['Etatfuturcommande']['date'];
    
    } ?>
    
    <path fill="none"  stroke="#ff7878" d="M100 
        <?php 
        $p=200;
        $pp=220;
        $c=80;
        //debug($tab);
        foreach ($tab as $m=>$t)  {  $n=$m+1;?>
          ,<?php echo $t ; ?>C<?php echo $c ; ?>
          ,<?php echo $t ; ?>
          ,<?php echo $pp ; ?>
          ,<?php echo @$tab[$n] ; ?>
          ,<?php echo $p ; ?>
          
        <?php
        $p=$p+100;
        $pp=$pp+75;
        $c=$c+110;
        } ?>  
        " stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
    </path>     
    <!--<path fill="none" stroke="#ff7878" 
    d="M100
    ,328.9935C
     80.76026772132644
    ,328.39212499999996
    ,142.28080316397933
    ,108.0649091997264
    ,171.04107088530577

    ,109.588C199.88013386066325
    ,108.10978419972645
    ,257.55825981137815
    ,122.2084233926129
    ,286.39732278673563

    ,122.173C315.15759050806207
    ,122.13767339261284
    ,372.67812595071496
    ,260.87165625
    ,122.4383936720414
    " stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
    </path>-->

</svg>
<?php 
$p=50;
foreach ($tab as $m=>$t)  {  $n=$m+1;?>                                        
<div class="morris-hover morris-default-style" style="left: <?php echo $p ; ?>px; top: <?php echo $t+20 ; ?>px;">
<div class="morris-hover-point" style="color: #FF7878">
  Quantité:
  <?php echo 350-$t ; ?><br>
  <?php echo $tabq[$m] ; ?>
</div>

</div>
<?php
$p=$p+100;

} ?>                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

  <?php } ?> 
   
    <!--Layout Script start -->
    <script type="text/javascript" src="assets/js/color.js"></script>
    <script type="text/javascript" src="assets/js/lib/jquery-1.11.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/multipleAccordion.js"></script>

    <!--easing Library Script Start -->
    <script src="assets/js/lib/jquery.easing.js"></script>
    <!--easing Library Script End -->

    <!--Nano Scroll Script Start -->
    <script src="assets/js/jquery.nanoscroller.min.js"></script>
    <!--Nano Scroll Script End -->

    <!--switchery Script Start -->
    <script src="assets/js/switchery.min.js"></script>
    <!--switchery Script End -->

    <!--bootstrap switch Button Script Start-->
    <script src="assets/js/bootstrap-switch.js"></script>
    <!--bootstrap switch Button Script End-->

    <!--easypie Library Script Start -->
    <script src="assets/js/jquery.easypiechart.min.js"></script>
    <!--easypie Library Script Start -->

    <!--bootstrap-progressbar Library script Start-->
    <script src="assets/js/bootstrap-progressbar.min.js"></script>
    <!--bootstrap-progressbar Library script End-->

    <script type="text/javascript" src="assets/js/pages/layout.js"></script>
    <!--Layout Script End -->

    <!--Morris Chart library Script Start -->
    <script src="assets/js/chart/morris.min.js"></script>
    <script src="assets/js/chart/raphael-min.js"></script>
    <!--Morris Chart library Script End -->



    <!--Morris Demo  Script Start-->
    <script src="assets/js/pages/demo.morris.js"></script>
    <!--Morris Demo  Script Start-->

</body></html>
