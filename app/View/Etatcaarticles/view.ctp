
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- Viewport metatags -->
    <meta name="HandheldFriendly" content="true" />
    <meta name="MobileOptimized" content="320" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- iOS webapp metatags -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />

    <!-- iOS webapp icons -->
    <link rel="apple-touch-icon-precomposed" href="<?php echo $this->webroot;?>assets/images/ios/fickle-logo-72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->webroot;?>assets/images/ios/fickle-logo-72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->webroot;?>assets/images/ios/fickle-logo-114.png" />

    <!-- TODO: Add a favicon -->
    <link rel="shortcut icon" href="<?php echo $this->webroot;?>assets/images/ico/fab.ico">

    <title>Fickle - Chart js</title>

    <!--Page loading plugin Start -->
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/pace.css">
    <script src="<?php echo $this->webroot;?>assets/js/pace.min.js"></script>
    <!--Page loading plugin End   -->

    <!-- Plugin Css Put Here -->
    <link href="<?php echo $this->webroot;?>assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Plugin Css End -->
    <!-- Custom styles Style -->
    <link href="<?php echo $this->webroot;?>assets/css/style.css" rel="stylesheet">
    <!-- Custom styles Style End-->

    <!-- Responsive Style For-->
    <link href="<?php echo $this->webroot;?>assets/css/responsive.css" rel="stylesheet">
    <!-- Responsive Style For-->

    <!-- Custom styles for this template -->


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="">
<!--Navigation Top Bar Start-->

<!--Navigation Top Bar End-->

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!--Top header start-->
                    <h3 class="ls-top-header">Chart js</h3>
                    <!--Top header end -->

                    <!--Top breadcrumb start -->
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-home"></i></a></li>
                        <li><a href="#">Charts</i></a></li>
                        <li class="active">Chart js</li>
                    </ol>
                    <!--Top breadcrumb start -->
                </div>
            </div>
            <!-- Main Content Element  Start-->
            <div class="row">
                <div class="col-md-12">


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Bar Chart</h3>
                        </div>
                        <div class="panel-body">
                            <div class="bar_chart_canvas_box">
                                <canvas id="bar_chart_canvas" height="300" width="600"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">

                <div class="col-md-3 col-sm-6 col-xs-12 col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Doughnut</h3>
                        </div>
                        <div class="panel-body">
                            <div class="doughnut-chart-area-box">
                                <canvas id="doughnut-chart-area" width="200" height="200"/>
                            </div>

                            <div class="doughnutChartCanvasDataView">
                                <ul>
                                    <li><span class="textColor"></span> Product A - 20</li>
                                    <li><span class="greenActive"></span> Product B - 50</li>
                                    <li><span class="fillColor4"></span> Product C - 100</li>
                                    <li><span class="lightBlueActive"></span> Product D - 40</li>
                                    <li><span class="redActive"></span> Product E - 120</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Radar</h3>
                        </div>
                        <div class="panel-body">
                            <div class="radar-chart-area-box">
                                <canvas id="radar-chart-area" width="200" height="200"/>
                            </div>
                            <div class="radarChartCanvasDataView">
                                <ul>
                                    <li><span class="redActive"></span> Person ABC</li>
                                    <li><span class="fillColor4"></span> Person XYZ</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Polar</h3>
                        </div>
                        <div class="panel-body">
                            <div class="polar-chart-area-box">
                                <canvas id="polar-chart-area" width="200" height="200"/>
                            </div>
                            <div class="polarAreaChartCanvasDataView">
                                <ul>
                                    <li><span class="greenActive"></span> Product A - 0.6</li>
                                    <li><span class="fillColor5"></span> Product B - 0.8</li>
                                    <li><span class="fillColor6"></span> Product C - 0.7</li>
                                    <li><span class="fillColor4"></span> Product D - 0.9</li>
                                    <li><span class="fillColor7"></span> Product E - 0.7</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Pie</h3>
                        </div>
                        <div class="panel-body">
                            <div class="pie-chart-area-box">
                                <canvas id="pie-chart-area" width="200" height="200"></canvas>
                            </div>

                            <div class="pieChartCanvasDataView">
                                <ul>
                                    <li><span class="fillColor6"></span> Product A - 30</li>
                                    <li><span class="lightBlueActive"></span> Product B - 50</li>
                                    <li><span class="defultColor"></span> Product C - 20</li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Line Chart</h3>
                        </div>
                        <div class="panel-body">
                            <div class="line-chart-area-box">
                                <canvas id="line-chart-area" height="300" width="600"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Main Content Element  End-->

        </div>
    </div>



</section>
<!--Page main section end -->
<!--Right hidden  section start-->
<section id="right-wrapper">
    <!--Right hidden  section close icon start-->
    <div class="close-right-wrapper">
        <a href="javascript:void(0)"><i class="fa fa-times"></i></a>
    </div>
    <!--Right hidden  section close icon end-->

    <!--Tab navigation start-->
    <ul class="nav nav-tabs" id="setting-tab">
        <li class="active"><a href="#chatTab" data-toggle="tab"><i class="fa fa-comment-o"></i> Chat</a></li>
        <li><a href="#settingTab" data-toggle="tab"><i class="fa fa-cogs"></i> Setting</a></li>
    </ul>
    <!--Tab navigation end -->

    <!--Tab content start-->
    <div class="tab-content">
        <div class="tab-pane active" id="chatTab">
            <div class="nano">
                <div class="nano-content">
                    <div class="chat-group chat-group-fav">
                        <h3 class="ls-header">Favorites</h3>
                        <a href="javascript:void(0)">
                            <span class="user-status is-online"></span>
                            Catherine J. Watkins
                            <span class="badge badge-lightBlue">1</span>
                        </a>
                        <a href="javascript:void(0)">
                            <span class="user-status is-idle"></span>
                            Fernando G. Olson
                        </a>
                        <a href="javascript:void(0)">
                            <span class="user-status is-busy"></span>
                            Susan J. Best
                        </a>
                        <a href="javascript:void(0)">
                            <span class="user-status is-offline"></span>
                            Brandon S. Young
                        </a>
                    </div>
                    <div class="chat-group chat-group-coll">
                        <h3 class="ls-header">Colleagues</h3>
                        <a href="javascript:void(0)">
                            <span class="user-status is-offline"></span>
                            Brandon S. Young
                        </a>
                        <a href="javascript:void(0)">
                            <span class="user-status is-idle"></span>
                            Fernando G. Olson
                        </a>
                        <a href="javascript:void(0)">
                            <span class="user-status is-online"></span>
                            Catherine J. Watkins
                            <span class="badge badge-lightBlue">3</span>
                        </a>

                        <a href="javascript:void(0)">
                            <span class="user-status is-busy"></span>
                            Susan J. Best
                        </a>

                    </div>
                    <div class="chat-group chat-group-social">
                        <h3 class="ls-header">Social</h3>
                        <a href="javascript:void(0)">
                            <span class="user-status is-online"></span>
                            Catherine J. Watkins
                            <span class="badge badge-lightBlue">5</span>
                        </a>
                        <a href="javascript:void(0)">
                            <span class="user-status is-busy"></span>
                            Susan J. Best
                        </a>
                    </div>
                </div>
            </div>

            <div class="chat-box">
                <div class="chat-box-header">
                    <h5>
                        <span class="user-status is-online"></span>
                        Catherine J. Watkins
                    </h5>
                </div>

                <div class="chat-box-content">
                    <div class="nano nano-chat">
                        <div class="nano-content">

                            <ul>
                                <li>
                                    <span class="user">Catherine</span>
                                    <p>Are you here?</p>
                                    <span class="time">10:10</span>
                                </li>
                                <li>
                                    <span class="user">Catherine</span>
                                    <p>Whohoo!</p>
                                    <span class="time">10:12</span>
                                </li>
                                <li>
                                    <span class="user">Catherine</span>
                                    <p>This message is pre-queued.</p>
                                    <span class="time">10:15</span>
                                </li>
                                <li>
                                    <span class="user">Catherine</span>
                                    <p>Do you like it?</p>
                                    <span class="time">10:20</span>
                                </li>
                                <li>
                                    <span class="user">Catherine</span>
                                    <p>This message is pre-queued.</p>
                                    <span class="time">11:00</span>
                                </li>
                                <li>
                                    <span class="user">Catherine</span>
                                    <p>Hi, you there ?</p>
                                    <span class="time">12:00</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


            </div>
            <div class="chat-write">
                <textarea class="form-control autogrow" placeholder="Type your message"></textarea>
            </div>
        </div>

        <div class="tab-pane" id="settingTab">

            <div class="setting-box">
                <h3 class="ls-header">Account Setting</h3>
                <div class="setting-box-content">
                    <ul>
                        <li><span class="pull-left">Online status: </span><input type="checkbox" class="js-switch-red" checked/></li>
                        <li><span class="pull-left">Show offline contact: </span><input type="checkbox" class="js-switch-light-blue" checked/></li>
                        <li><span class="pull-left">Invisible mode: </span><input class="js-switch" type="checkbox" checked></li>
                        <li><span class="pull-left">Log all message:</span><input class="js-switch-light-green" type="checkbox" checked></li>
                    </ul>
                </div>
            </div>
            <div class="setting-box">
                <h3 class="ls-header">Maintenance</h3>
                <div class="setting-box-content">
                    <div class="easy-pai-box">
                                <span class="easyPieChart" data-percent="90">
                                    <span class="easyPiePercent"></span>
                                </span>
                    </div>
                    <div class="easy-pai-box">
                        <button class="btn btn-xs ls-red-btn js_update">Update Data</button>
                    </div>
                </div>
            </div>

            <div class="setting-box">
                <h3 class="ls-header">Progress</h3>
                <div class="setting-box-content">

                    <h5>File uploading</h5>
                    <div class="progress">
                        <div class="progress-bar ls-light-blue-progress six-sec-ease-in-out"
                             aria-valuetransitiongoal="10"></div>
                    </div>

                    <h5>Plugin setup</h5>
                    <div class="progress progress-striped active">
                        <div class="progress-bar six-sec-ease-in-out ls-light-green-progress"
                             aria-valuetransitiongoal="20"></div>
                    </div>
                    <h5>Post New Article</h5>
                    <div class="progress progress-striped active">
                        <div class="progress-bar ls-yellow-progress six-sec-ease-in-out"
                             aria-valuetransitiongoal="80"></div>
                    </div>
                    <h5>Create New User</h5>
                    <div class="progress progress-striped active">
                        <div class="progress-bar ls-red-progress six-sec-ease-in-out"
                             aria-valuetransitiongoal="100"></div>
                    </div>
                </div>
            </div>
        </div>
    
<!--Right hidden  section end -->
<div id="change-color">
    <div id="change-color-control">
        <a href="javascript:void(0)"><i class="fa fa-magic"></i></a>
    </div>
    <div class="change-color-box">
        <ul>
            <li class="default active"></li>
            <li class="red-color"></li>
            <li class="blue-color"></li>
            <li class="light-green-color"></li>
            <li class="black-color"></li>
            <li class="deep-blue-color"></li>
        </ul>
    </div>
</div>
</section>

<!--Layout Script start -->
<script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/color.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/lib/jquery-1.11.min.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/multipleAccordion.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/lib/jquery.easing.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/jquery.nanoscroller.min.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/switchery.min.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/bootstrap-switch.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/jquery.easypiechart.min.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/bootstrap-progressbar.min.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/pages/layout.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/chart/chartjs/Chart.min.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/pages/chartjs.js"></script>

</body>
</html>