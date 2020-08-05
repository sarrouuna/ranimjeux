<div class="row" style="width:300%; height:500px">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Bar Chart</h3>
                        </div>
                        <div class="panel-body">
                        <div id="c3BarCharts" class="c3" style="max-height: 700px; position: relative;">
                        <svg width="1087" height="1000" style="overflow: hidden;">
                        <defs>
                        <clipPath id="c3-1479482250399-clip">
                            <rect width="2000" height="1000">
                            </rect>
                        </clipPath>
                        <clipPath id="c3-1479482250399-clip-xaxis">
                        <rect x="-31" y="-20" width="1099" height="80"></rect>
                        </clipPath>
                        <clipPath id="c3-1479482250399-clip-yaxis">
                        <rect x="-39" y="-4" width="60" height="274"></rect>
                        </clipPath>
                        </defs>
                        <g transform="translate(40.5,4.5)">
                        <text class="c3-text c3-empty" text-anchor="middle" dominant-baseline="middle" x="518.5" y="133" style="opacity: 0;"></text>
                        <rect class="c3-zoom-rect" width="1037" height="390" style="opacity: 0;"></rect>
                        <g clip-path="url(file:///C:/Users/LENOVO/Desktop/travail/theme/fickle-LTR-THEME/c3js.html#c3-1479482250399-clip)" class="c3-regions"></g>
                        <g clip-path="url(file:///C:/Users/LENOVO/Desktop/travail/theme/fickle-LTR-THEME/c3js.html#c3-1479482250399-clip)" class="c3-grid">
                        <g class="c3-xgrid-lines"></g>
                        <g class="c3-ygrid-lines"></g>
                        <g class="c3-xgrid-focus">
                        <line class="c3-xgrid-focus" x1="312" x2="312" y1="0" y2="500" style="visibility: hidden;"></line>
                        </g>
                        </g>
                        <g clip-path="url(file:///C:/Users/LENOVO/Desktop/travail/theme/fickle-LTR-THEME/c3js.html#c3-1479482250399-clip)" class="c3-chart">
                        <g class="c3-event-rects c3-event-rects-multiple" style="fill-opacity: 0;">
                        <rect x="0" y="0" width="2000" height="1000" class="c3-event-rect"></rect>
                        </g>
                        <!--div mta3 la3wed -->
                        <g class="c3-chart-bars">
                        <!--rouge-->
                        <g class="c3-chart-bar c3-target c3-target-ABCD" style="opacity: 1; pointer-events: none;">
                        <g class=" c3-shapes c3-shapes-ABCD c3-bars c3-bars-ABCD" style="cursor: pointer;">
                        
                        
                        
                        <?php 
                        $position=30;
                        foreach ($tab_annee1 as $h=>$action){
                            //debug($action);
                        ?> 
                        <path transform="translate(<?php echo $position; ?>,124)" class=" c3-shape c3-shape-0 c3-bar c3-bar-0" 
                            d="M21
                            ,390 
                            L21
                            ,<?php echo 390-($action['tot']/1000); ?>
                            L50
                            ,<?php echo 390-($action['tot']/1000); ?>
                            L50
                            ,390 z" 
                            style="stroke: rgb(177, 102, 102); 
                            fill: rgb(177, 102, 102); opacity: 1;">
                        </path>
                        <?php 
                        $position=$position+80; 
                        } ?> 
                        
                        
                        
<!--                        <path transform="translate(0,124)" class=" c3-shape c3-shape-1 c3-bar c3-bar-1" d="M 229,266 L229,145.54545454545456 
                              L284.3333333333333,145.54545454545456 L284.3333333333333,266 z" 
                              style="stroke: rgb(177, 102, 102); fill: rgb(177, 102, 102); opacity: 1;">
                        </path>
                        <path transform="translate(0,124)" class=" c3-shape c3-shape-2 c3-bar c3-bar-2" d="M 436,266 L436,205.77272727272728 
                              L491.3333333333333,205.77272727272728 L491.3333333333333,266 z" 
                              style="stroke: rgb(177, 102, 102); fill: rgb(177, 102, 102); opacity: 1;">
                        </path>
                        <path transform="translate(0,124)" class=" c3-shape c3-shape-3 c3-bar c3-bar-3" d="M 643,266 L643,25.090909090909093 
                              L698.3333333333334,25.090909090909093 L698.3333333333334,266 z" 
                              style="stroke: rgb(177, 102, 102); fill: rgb(177, 102, 102); opacity: 1;">
                        </path>
                        <path transform="translate(0,124)" class=" c3-shape c3-shape-4 c3-bar c3-bar-4" d="M 851,266 L851,175.65909090909093 
                              L906.3333333333334,175.65909090909093 L906.3333333333334,266 z" 
                              style="stroke: rgb(177, 102, 102); fill: rgb(177, 102, 102); opacity: 1;">
                        </path>
                        </g>-->
                        </g>
                        <!--move-->
                        <g class="c3-chart-bar c3-target c3-target-XYZ" style="opacity: 1; pointer-events: none;">
                        <g class=" c3-shapes c3-shapes-XYZ c3-bars c3-bars-XYZ" style="cursor: pointer;">
                        
                        
                        <?php 
                        $position=30;
                        foreach ($tab_annee2 as $h=>$action){ 
                        ?> 
                       <path transform="translate(<?php echo $position; ?>,124)" class=" c3-shape c3-shape-0 c3-bar c3-bar-0" 
                              d="M76
                              ,390 
                              L76
                              ,<?php echo 390-($action['tot']/1000); ?> 
                              L50
                              ,<?php echo 390-($action['tot']/1000); ?>
                              L50
                              ,390 z" 
                              style="stroke: rgb(38, 154, 188); fill: rgb(38, 154, 188); opacity: 1;">
                        </path>
                        <?php 
                        $position=$position+80; 
                        } ?> 
                        
                        
                        
                        
                        
                        
                        
                        
                        
<!--                        <path class=" c3-shape c3-shape-1 c3-bar c3-bar-1" d="M 284.3333333333333,266 
                              L284.3333333333333,175.65909090909093 L339.66666666666663,175.65909090909093 
                              L339.66666666666663,266 z" 
                              style="stroke: rgb(38, 154, 188); fill: rgb(38, 154, 188); opacity: 1;">
                        </path>
                        <path class=" c3-shape c3-shape-2 c3-bar c3-bar-2" d="M 491.3333333333333,266 
                              L491.3333333333333,145.54545454545456 L546.6666666666666,145.54545454545456 
                              L546.6666666666666,266 z" 
                              style="stroke: rgb(38, 154, 188); fill: rgb(38, 154, 188); opacity: 1;">
                        </path>
                        <path class=" c3-shape c3-shape-3 c3-bar c3-bar-3" d="M 698.3333333333334,266 
                              L698.3333333333334,85.31818181818184 L753.6666666666667,85.31818181818184 
                              L753.6666666666667,266 z" 
                              style="stroke: rgb(38, 154, 188); fill: rgb(38, 154, 188); opacity: 1;">
                        </path>
                        <path class=" c3-shape c3-shape-4 c3-bar c3-bar-4" d="M 906.3333333333334,266 
                              L906.3333333333334,145.54545454545456 L961.6666666666667,145.54545454545456 
                              L961.6666666666667,266 z" 
                              style="stroke: rgb(38, 154, 188); fill: rgb(38, 154, 188); opacity: 1;">
                        </path>-->
                        </g>
                        </g>
                        </g>
                        <!-- ma3andha 7atta da5el  -->
                        <g class="c3-chart-lines">
                        <g class="c3-chart-line c3-target c3-target-ABCD" style="opacity: 1; pointer-events: none;">
                        <g class=" c3-shapes c3-shapes-ABCD c3-lines c3-lines-ABCD"></g>
                        <g class=" c3-shapes c3-shapes-ABCD c3-areas c3-areas-ABCD"></g>
                        <g class=" c3-selected-circles c3-selected-circles-ABCD"></g>
                        <g class=" c3-shapes c3-shapes-ABCD c3-circles c3-circles-ABCD" style="cursor: pointer;">
                        </g>
                        </g>
                        <g class="c3-chart-line c3-target c3-target-XYZ" style="opacity: 1; pointer-events: none;">
                        <g class=" c3-shapes c3-shapes-XYZ c3-lines c3-lines-XYZ"></g>
                        <g class=" c3-shapes c3-shapes-XYZ c3-areas c3-areas-XYZ"></g>
                        <g class=" c3-selected-circles c3-selected-circles-XYZ"></g>
                        <g class=" c3-shapes c3-shapes-XYZ c3-circles c3-circles-XYZ" style="cursor: pointer;"></g>
                        </g>
                        <g class="c3-chart-line c3-target c3-target-MNOP" style="opacity: 1; pointer-events: none;">
                        <g class=" c3-shapes c3-shapes-MNOP c3-lines c3-lines-MNOP"></g>
                        <g class=" c3-shapes c3-shapes-MNOP c3-areas c3-areas-MNOP"></g>
                        <g class=" c3-selected-circles c3-selected-circles-MNOP"></g>
                        <g class=" c3-shapes c3-shapes-MNOP c3-circles c3-circles-MNOP" style="cursor: pointer;"></g>
                        </g>
                        </g>
                        <!-- ma3andha 7atta da5el  -->
                        <g class="c3-chart-arcs" transform="translate(518.5,128)">
                        <text class="c3-chart-arcs-title" style="text-anchor: middle; opacity: 0;"></text>
                        <g class="c3-chart-arc c3-target c3-target-ABCD">
                        <g class=" c3-shapes c3-shapes-ABCD c3-arcs c3-arcs-ABCD"></g>
                        <text dy=".35em" class="" transform="translate(-16.954649603771678,95.79111783883371)" 
                              style="opacity: 0; text-anchor: middle; pointer-events: none;">32.7%
                        </text>
                        </g>
                        <g class="c3-chart-arc c3-target c3-target-XYZ" style="opacity: 1;">
                        <g class=" c3-shapes c3-shapes-XYZ c3-arcs c3-arcs-XYZ"></g>
                        <text dy=".35em" class="" transform="translate(88.57461149356186,-40.22358261970931)" 
                              style="opacity: 0; text-anchor: middle; pointer-events: none;">36.4%
                        </text>
                        </g>
                        <g class="c3-chart-arc c3-target c3-target-MNOP" style="opacity: 1;">
                        <g class=" c3-shapes c3-shapes-MNOP c3-arcs c3-arcs-MNOP"></g>
                        <text dy=".35em" class="" transform="translate(-80.20851457630724,-55.04536846513346)" 
                              style="opacity: 0; text-anchor: middle; pointer-events: none;">30.9%
                        </text>
                        </g>
                        </g>
                        <!-- ma3andha 7atta da5el  -->
                        <g class="c3-chart-texts">
                        <g class="c3-chart-text c3-target c3-target-ABCD" style="opacity: 1; pointer-events: none;">
                        <g class=" c3-texts c3-texts-ABCD"></g>
                        </g>
                        <g class="c3-chart-text c3-target c3-target-XYZ" style="opacity: 1; pointer-events: none;">
                        <g class=" c3-texts c3-texts-XYZ"></g>
                        </g>
                        <g class="c3-chart-text c3-target c3-target-MNOP" style="opacity: 1; pointer-events: none;">
                        <g class=" c3-texts c3-texts-MNOP"></g>
                        </g>
                        </g>
                        </g>
                        <!-- div mta3 l'axe d'abssice  -->
                        <g class="c3-axis c3-axis-x" clip-path="url(file:///C:/Users/LENOVO/Desktop/travail/theme/fickle-LTR-THEME/c3js.html#c3-1479482250399-clip-xaxis)" transform="translate(0,390)" style="visibility: visible; opacity: 1;">
                        <text class="c3-axis-x-label"  dy="-0.5em" dx="-0.5em" x="2000" style="text-anchor: end;">
                        </text>
                        <?php if(!empty($moiid)){
                        $comp=$moiid;
                        $axb=0;
                        foreach ($moiid as $m){ $axb=$axb+90;?>
                        <g class="tick" transform="translate(<?php echo $axb; ?>, 0)" style="opacity: 5;">
                        <line y2="6" x1="0" x2="0"></line>
                        <text y="9" x="0" dy=".71em" style="text-anchor: middle; display: block;"><?php echo $mois[$m]; ?></text>
                        </g>
                        <?php }}  else { 
                        $comp=$mois;
                        $axb=0;
                        ?>
                        <?php  foreach ($mois as $m){ $axb=$axb+80;?>
                        <g class="tick" transform="translate(<?php echo $axb; ?>, 0)" style="opacity: 5;">
                        <line y2="6" x1="0" x2="0"></line>
                        <text y="9" x="0" dy=".71em" style="text-anchor: middle; display: block;"><?php echo $m; ?></text>
                        </g>
                        <?php }}?> 
                        <path class="domain" d="M0,6V0H1500V6"></path>
                        </g>
                        <!-- div mta3 l'axe d'ordonnée  -->
                        <g class="c3-axis c3-axis-y" clip-path="url(file:///C:/Users/LENOVO/Desktop/travail/theme/fickle-LTR-THEME/c3js.html#c3-1479482250399-clip-yaxis)" transform="translate(0,0)" style="visibility: visible; opacity: 1;">
                        <text class="c3-axis-y-label" transform="rotate(-90)" dy="1.2em" dx="-0.5em" x="0" style="text-anchor: end;"></text>
                        
                        
                        
                        <g class="tick" transform="translate(0,390)" style="opacity: 1;">
                        <line x2="-6" y2="0"></line>
                        <text x="-9" y="0" dy=".32em" style="text-anchor: end;">0</text>
                        </g>
                        
                        <g class="tick" transform="translate(0,360)" style="opacity: 1;">
                        <line x2="-6" y2="0"></line>
                        <text x="-9" y="0" dy=".32em" style="text-anchor: end;">50</text>
                        </g>
                        
                        <g class="tick" transform="translate(0,330)" style="opacity: 1;">
                        <line x2="-6" y2="0"></line>
                        <text x="-9" y="0" dy=".32em" style="text-anchor: end;">100</text>
                        </g>
                        
                        <g class="tick" transform="translate(0,300)" style="opacity: 1;">
                        <line x2="-6" y2="0"></line>
                        <text x="-9" y="0" dy=".32em" style="text-anchor: end;">150</text>
                        </g>
                        
                        <g class="tick" transform="translate(0,270)" style="opacity: 1;">
                        <line x2="-6" y2="0"></line>
                        <text x="-9" y="0" dy=".32em" style="text-anchor: end;">200</text>
                        </g>
                        
                        <g class="tick" transform="translate(0,240)" style="opacity: 1;">
                        <line x2="-6" y2="0"></line>
                        <text x="-9" y="0" dy=".32em" style="text-anchor: end;">250</text>
                        </g>
                        
                        <g class="tick" transform="translate(0,210)" style="opacity: 1;">
                        <line x2="-6" y2="0"></line>
                        <text x="-9" y="0" dy=".32em" style="text-anchor: end;">300</text>
                        </g>
                        
                        <g class="tick" transform="translate(0,180)" style="opacity: 1;">
                        <line x2="-6" y2="0"></line>
                        <text x="-9" y="0" dy=".32em" style="text-anchor: end;">350</text>
                        </g>
                        
                        <g class="tick" transform="translate(0,150)" style="opacity: 1;">
                        <line x2="-6" y2="0"></line>
                        <text x="-9" y="0" dy=".32em" style="text-anchor: end;">400</text>
                        </g>
                        
                        <g class="tick" transform="translate(0,120)" style="opacity: 1;">
                        <line x2="-6" y2="0"></line>
                        <text x="-9" y="0" dy=".32em" style="text-anchor: end;">450</text>
                        </g>
                        
                        <g class="tick" transform="translate(0,90)" style="opacity: 1;">
                        <line x2="-6" y2="0"></line>
                        <text x="-9" y="0" dy=".32em" style="text-anchor: end;">500</text>
                        </g>
                        
                        <g class="tick" transform="translate(0,60)" style="opacity: 1;">
                        <line x2="-6" y2="0"></line>
                        <text x="-9" y="0" dy=".32em" style="text-anchor: end;">550</text>
                        </g>
                        
                        <g class="tick" transform="translate(0,30)" style="opacity: 1;">
                        <line x2="-6" y2="0"></line>
                        <text x="-9" y="0" dy=".32em" style="text-anchor: end;">600</text>
                        </g>
                        
                        <g class="tick" transform="translate(0,0)" style="opacity: 1;">
                        <line x2="-6" y2="0"></line>
                        <text x="-9" y="0" dy=".32em" style="text-anchor: end;">Mille</text>
                        </g>
                        
                        <path class="domain" d="M-6,1H0V395H-6"></path>
                        </g>
                        <!-- ma3andha 7atta da5el  -->
                        <g class="c3-axis c3-axis-y2" transform="translate(1037,0)" style="visibility: hidden; opacity: 1;">
                        <text class="c3-axis-y2-label" transform="rotate(-90)" dy="-0.5em" dx="-0.5em" x="0" style="text-anchor: end;"></text>
                        <g class="tick" transform="translate(0,266)" style="opacity: 1;">
                        <line x2="6" y2="0"></line>
                        <text x="9" y="0" dy=".32em" style="text-anchor: start;">0</text>
                        </g>
                        <g class="tick" transform="translate(0,240)" style="opacity: 1;">
                        <line x2="6" y2="0"></line>
                        <text x="9" y="0" dy=".32em" style="text-anchor: start;">0.1</text>
                        </g>
                        <g class="tick" transform="translate(0,213)" style="opacity: 1;">
                        <line x2="6" y2="0"></line>
                        <text x="9" y="0" dy=".32em" style="text-anchor: start;">0.2</text>
                        </g>
                        <g class="tick" transform="translate(0,187)" style="opacity: 1;">
                        <line x2="6" y2="0"></line>
                        <text x="9" y="0" dy=".32em" style="text-anchor: start;">0.3</text>
                        </g>
                        <g class="tick" transform="translate(0,160)" style="opacity: 1;">
                        <line x2="6" y2="0"></line>
                        <text x="9" y="0" dy=".32em" style="text-anchor: start;">0.4</text>
                        </g>
                        <g class="tick" transform="translate(0,134)" style="opacity: 1;">
                        <line x2="6" y2="0"></line>
                        <text x="9" y="0" dy=".32em" style="text-anchor: start;">0.5</text>
                        </g>
                        <g class="tick" transform="translate(0,107)" style="opacity: 1;">
                        <line x2="6" y2="0"></line>
                        <text x="9" y="0" dy=".32em" style="text-anchor: start;">0.6</text>
                        </g>
                        <g class="tick" transform="translate(0,81)" style="opacity: 1;">
                        <line x2="6" y2="0"></line>
                        <text x="9" y="0" dy=".32em" style="text-anchor: start;">0.7</text>
                        </g>
                        <g class="tick" transform="translate(0,54)" style="opacity: 1;">
                        <line x2="6" y2="0"></line>
                        <text x="9" y="0" dy=".32em" style="text-anchor: start;">0.8</text>
                        </g>
                        <g class="tick" transform="translate(0,28)" style="opacity: 1;">
                        <line x2="6" y2="0"></line>
                        <text x="9" y="0" dy=".32em" style="text-anchor: start;">0.9</text>
                        </g>
                        <g class="tick" transform="translate(0,1)" style="opacity: 1;">
                        <line x2="6" y2="0"></line>
                        <text x="9" y="0" dy=".32em" style="text-anchor: start;">1</text>
                        </g>
                        <path class="domain" d="M6,1H0V266H6"></path>
                        </g>
                        </g>
                        <!-- ma3andha 7atta da5el  -->
                        <g transform="translate(20.5,300.5)" style="visibility: hidden;">
                        <g clip-path="url(file:///C:/Users/LENOVO/Desktop/travail/theme/fickle-LTR-THEME/c3js.html#c3-1479482250399-clip)" class="c3-chart">
                        <g class="c3-chart-bars"></g>
                        <g class="c3-chart-lines"></g>
                        </g>
                        <g clip-path="url(file:///C:/Users/LENOVO/Desktop/travail/theme/fickle-LTR-THEME/c3js.html#c3-1479482250399-clip)" class="c3-brush" style="pointer-events: all; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                        <rect class="background" x="0" width="1037" height="0" style="visibility: hidden; cursor: crosshair;"></rect>
                        <rect class="extent" x="0" width="0" height="0" style="cursor: move;"></rect>
                        <g class="resize e" transform="translate(0,0)" style="cursor: ew-resize; display: none;">
                        <rect x="-3" width="6" height="0" style="visibility: hidden;"></rect>
                        </g>
                        <g class="resize w" transform="translate(0,0)" style="cursor: ew-resize; display: none;">
                        <rect x="-3" width="6" height="0" style="visibility: hidden;"></rect>
                        </g>
                        </g>
                        <g class="c3-axis-x" transform="translate(0,0)" clip-path="url(file:///C:/Users/LENOVO/Desktop/travail/theme/fickle-LTR-THEME/c3js.html#c3-1479482250399-clip-xaxis)" style="opacity: 1;">
                        <g class="tick" transform="translate(104, 0)" style="opacity: 1;">
                        <line y2="6" x1="0" x2="0"></line>
                        <text y="9" x="0" dy=".71em" style="text-anchor: middle; display: block;">2010</text>
                        </g>
                        <g class="tick" transform="translate(312, 0)" style="opacity: 1;">
                        <line y2="6" x1="0" x2="0"></line>
                        <text y="9" x="0" dy=".71em" style="text-anchor: middle; display: block;">2011</text>
                        </g>
                        <g class="tick" transform="translate(519, 0)" style="opacity: 1;">
                        <line y2="6" x1="0" x2="0"></line>
                        <text y="9" x="0" dy=".71em" style="text-anchor: middle; display: block;">2012</text>
                        </g>
                        <g class="tick" transform="translate(726, 0)" style="opacity: 1;">
                        <line y2="6" x1="0" x2="0"></line>
                        <text y="9" x="0" dy=".71em" style="text-anchor: middle; display: block;">2013</text>
                        </g>
                        <g class="tick" transform="translate(934, 0)" style="opacity: 1;">
                        <line y2="6" x1="0" x2="0"></line>
                        <text y="9" x="0" dy=".71em" style="text-anchor: middle; display: block;">2014</text>
                        </g>
                        <path class="domain" d="M0,6V0H1037V6"></path>
                        </g>
                        </g>
                        <!-- ma3andha 7atta da5el  -->
                        <g transform="translate(0,450)">
                        <g class="c3-legend-item c3-legend-item-ABCD" 
                           style="visibility: visible; cursor: pointer;">
                        <text x="457.5" y="9" style="pointer-events: none;"><?php echo $exercice1s[$exerciceid1]; ?></text>
                        <rect class="c3-legend-item-event" x="439.5" y="-7" 
                              style="fill-opacity: 0;" width="70" height="20">
                        </rect>
                        <rect class="c3-legend-item-tile" x="443.5" y="0" width="10" height="10" 
                              style="pointer-events: none; fill: rgb(177, 102, 102);">
                        </rect>
                        </g>
                        <g class=" c3-legend-item c3-legend-item-XYZ" 
                           style="visibility: visible; cursor: pointer; opacity: 1;">
                        <text x="527.5" y="9" style="pointer-events: none;"><?php echo $exercice2s[$exerciceid2]; ?></text>
                        <rect class="c3-legend-item-event" x="509.5" y="-7" 
                              style="fill-opacity: 0;" width="60" height="20">
                        </rect>
                        <rect class="c3-legend-item-tile" x="513.5" y="0" width="10" height="10" 
                              style="pointer-events: none; fill: rgb(38, 154, 188);">
                        </rect>
                        </g>
                        
                        </g>
                        </svg>
                        <!-- ma3andha 7atta da5el  -->
                        <div style="position: absolute; pointer-events: none; z-index: 10; 
                             display: none; top: 114.5px; left: 372.5px;">
                            <table class="c3-tooltip">
                                <tbody>
                                    <tr>
                                        <th colspan="2">2011</th>
                                    </tr>
                                    <tr class="c3-tooltip-name-ABCD">
                                        <td class="name">
                                            <span style="background-color:#B16666"></span>ABCD
                                        </td>
                                        <td class="value">200</td>
                                    </tr>
                                    <tr class="c3-tooltip-name-XYZ">
                                        <td class="name">
                                            <span style="background-color:#269abc"></span>XYZ
                                        </td>
                                        <td class="value">150</td>
                                    </tr>
                                    <tr class="c3-tooltip-name-MNOP">
                                        <td class="name">
                                            <span style="background-color:#1fb5ad"></span>MNOP
                                        </td>
                                        <td class="value">100</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>