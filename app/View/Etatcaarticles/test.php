
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
<nav class="navigation">
<div class="container-fluid">
<!--Logo text start-->
<div class="header-logo">
    <a href="index.html" title="">
        <h1>Fickle</h1>
    </a>
</div>
<!--Logo text End-->
<div class="top-navigation">
<!--Collapse navigation menu icon start -->
<div class="menu-control hidden-xs">
    <a href="javascript:void(0)">
        <i class="fa fa-bars"></i>
    </a>
</div>
<div class="search-box">
    <ul>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
                <span class="fa fa-search"></span>
            </a>
            <div class="dropdown-menu  top-dropDown-1">
                <h4>Search</h4>
                <form>
                    <input type="search" placeholder="what you want to see ?">
                </form>
            </div>

        </li>
    </ul>
</div>

<!--Collapse navigation menu icon end -->
<!--Top Navigation Start-->

<ul>
    <li class="dropdown">
        <!--All task drop down start-->
        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
            <span class="fa fa-tasks"></span>
            <span class="badge badge-lightBlue">3</span>
        </a>
        <div class="dropdown-menu right top-dropDown-1">
            <h4>All Task</h4>
            <ul class="goal-item">
                <li>
                    <a href="javascript:void(0)">
                        <div class="goal-user-image">
                            <img class="rounded" src="assets/images/demo/avatar-80.png" alt="user image" />
                        </div>
                        <div class="goal-content">
                            Wordpress Theme
                            <div class="progress progress-striped active">
                                <div class="progress-bar ls-light-blue-progress six-sec-ease-in-out" aria-valuetransitiongoal="100"></div>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <div class="goal-user-image">
                            <img class="rounded" src="assets/images/demo/avatar-80.png" alt="user image" />
                        </div>
                        <div class="goal-content">
                            PSD Designe
                            <div class="progress progress-striped active">
                                <div class="progress-bar ls-red-progress six-sec-ease-in-out" aria-valuetransitiongoal="40"></div>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <div class="goal-user-image">
                            <img class="rounded" src="assets/images/demo/avatar-80.png" alt="user image" />
                        </div>
                        <div class="goal-content">
                            Wordpress PLugin
                            <div class="progress progress-striped active">
                                <div class="progress-bar ls-light-green-progress six-sec-ease-in-out" aria-valuetransitiongoal="60"></div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="only-link">
                    <a href="javascript:void(0)">View All</a>
                </li>
            </ul>
        </div>
        <!--All task drop down end-->
    </li>
    <li class="dropdown">
        <!--Notification drop down start-->
        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
            <span class="fa fa-bell-o"></span>
            <span class="badge badge-red">6</span>
        </a>

        <div class="dropdown-menu right top-notification">
            <h4>Notification</h4>
            <ul class="ls-feed">
                <li>
                    <a href="javascript:void(0)">
                                        <span class="label label-red">
                                            <i class="fa fa-check white"></i>
                                        </span>
                        You have 4 pending tasks.
                        <span class="date">Just now</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                                        <span class="label label-light-green">
                                            <i class="fa fa-bar-chart-o"></i>
                                        </span>
                        Finance Report for year 2013
                        <span class="date">30 min</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                                        <span class="label label-lightBlue">
                                            <i class="fa fa-shopping-cart"></i>
                                        </span>
                        New order received with
                        <span class="date">45 min</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                                        <span class="label label-lightBlue">
                                            <i class="fa fa-user"></i>
                                        </span>
                        5 pending membership
                        <span class="date">50 min</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                                        <span class="label label-red">
                                            <i class="fa fa-bell"></i>
                                        </span>
                        Server hardware upgraded
                        <span class="date">1 hr</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                                        <span class="label label-blue">
                                            <i class="fa fa-briefcase"></i>
                                        </span>
                        IPO Report for
                        <span class="lightGreen">2014</span>
                        <span class="date">5 hrs</span>
                    </a>
                </li>
                <li class="only-link">
                    <a href="javascript:void(0)">View All</a>
                </li>
            </ul>
        </div>
        <!--Notification drop down end-->
    </li>
    <li class="dropdown">
        <!--Email drop down start-->
        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
            <span class="fa fa-envelope-o"></span>
            <span class="badge badge-red">3</span>
        </a>

        <div class="dropdown-menu right email-notification">
            <h4>Email</h4>
            <ul class="email-top">
                <li>
                    <a href="javascript:void(0)">
                        <div class="email-top-image">
                            <img class="rounded" src="assets/images/demo/avatar-80.png" alt="user image" />
                        </div>
                        <div class="email-top-content">
                            John Doe <div>Sample Mail 1</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <div class="email-top-image">
                            <img class="rounded" src="assets/images/demo/avatar-80.png" alt="user image" />
                        </div>
                        <div class="email-top-content">
                            John Doe <div>Sample Mail 2</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <div class="email-top-image">
                            <img class="rounded" src="assets/images/demo/avatar-80.png" alt="user image" />
                        </div>
                        <div class="email-top-content">
                            John Doe <div> Sample Mail 4</div>
                        </div>
                    </a>
                </li>
                <li class="only-link">
                    <a href="mail.html">View All</a>
                </li>
            </ul>
        </div>
        <!--Email drop down end-->
    </li>
    <li class="hidden-xs">
        <a class="right-sidebar" href="javascript:void(0)">
            <i class="fa fa-comment-o"></i>
        </a>
    </li>
    <li class="hidden-xs">
        <a class="right-sidebar-setting" href="javascript:void(0)">
            <i class="fa fa-cogs"></i>
        </a>
    </li>
    <li>
        <a href="lock-screen.html">
            <i class="fa fa-lock"></i>
        </a>
    </li>
    <li>
        <a href="login.html">
            <i class="fa fa-power-off"></i>
        </a>
    </li>

</ul>
<!--Top Navigation End-->
</div>
</div>
</nav>
<!--Navigation Top Bar End-->
<section id="main-container">

<!--Left navigation section start-->
<section id="left-navigation">
<!--Left navigation user details start-->
<div class="user-image">
    <img src="assets/images/demo/avatar-80.png" alt=""/>
    <div class="user-online-status"><span class="user-status is-online  "></span> </div>
</div>
<ul class="social-icon">
    <li><a href="javascript:void(0)"><i class="fa fa-facebook"></i></a></li>
    <li><a href="javascript:void(0)"><i class="fa fa-twitter"></i></a></li>
    <li><a href="javascript:void(0)"><i class="fa fa-github"></i></a></li>
    <li><a href="javascript:void(0)"><i class="fa fa-bitbucket"></i></a></li>
</ul>
<!--Left navigation user details end-->

<!--Phone Navigation Menu icon start-->
<div class="phone-nav-box visible-xs">
    <a class="phone-logo" href="index.html" title="">
        <h1>Fickle</h1>
    </a>
    <a class="phone-nav-control" href="javascript:void(0)">
        <span class="fa fa-bars"></span>
    </a>
    <div class="clearfix"></div>
</div>
<!--Phone Navigation Menu icon start-->

<!--Left navigation start-->
<ul class="mainNav">
<li>
    <a href="index.html">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
</li>
<li>
    <a href="#">
        <i class="fa fa-envelope-o"></i> <span>Email</span> <span class="badge badge-red">3</span>
    </a>
    <ul>
        <li><a href="mail.html">Inbox</a></li>
        <li><a href="compose-mail.html">Compose Mail</a></li>
    </ul>
</li>
<li class="active">
    <a href="#">
        <i class="fa fa-bar-chart-o"></i> <span>Charts</span>
    </a>
    <ul>
        <li>
            <a href="c3js.html">C3 Chart </a>
        </li>
        <li>
            <a class="active" href="chartjs.html">Chart js</a>
        </li>
        <li><a href="flotchart.html">Flot</a>
        </li>
        <li>
            <a href="morrisjs.html">Morris</a>
        </li>
        <li>
            <a href="sparkline.html">Spark Line</a>
        </li>
    </ul>
</li>
<li>
    <a href="#">
        <i class="fa fa-glass"></i>
        <span>Form Staffs</span>
    </a>
    <ul>
        <li><a href="sample-form.html">Sample Form</a></li>
        <li><a href="form-wizard.html">Form Wizards</a></li>
        <li><a href="form-validation.html">Form Validation</a></li>
        <li><a href="editor.html">Editor</a></li>
    </ul>
</li>
<li>
    <a href="#">
        <i class="fa fa-flag"></i>
        <span>Ui Elements</span>
        <span class="badge badge-red">New</span>
    </a>
    <ul>
        <li><a href="button-switch.html">Button & Switch</a></li>
        <li><a href="checkbox-radio.html">Checkbox & Radio</a></li>
        <li><a href="select-tag.html">Select & Tag</a></li>
        <li><a href="knob-slider.html">Knob & Slider</a></li>
        <li><a href="picker-tool.html">Picker</a></li>
        <li><a href="drag-drop.html">Drag & Drop</a></li>
        <li><a href="ui-elements.html">Elements</a></li>
        <li><a href="tree-view.html">Tree View <span class="badge badge-red">New</span></a></li>

    </ul>
</li>
<li>
    <a href="timeline.html">
        <i class="fa fa-clock-o"></i> <span>TimeLine</span>
    </a>
</li>
<li>
    <a href="table.html">
        <i class="fa fa-table"></i> <span>Table</span>
    </a>
</li>
<li>
    <a href="notification.html">
        <i class="fa fa-bullhorn"></i> <span>Notification</span>
    </a>
</li>
<li>
    <a href="note-task.html">
        <i class="fa fa-pencil"></i> <span>Task & Note</span> <span class="badge badge-red">5</span>
    </a>
</li>
<li>
    <a href="calender.html">
        <i class="fa fa-calendar-o"></i> <span>Calender</span> <span class="badge badge-red">15</span>
    </a>
</li>
<li>
    <a href="#">
        <i class="fa fa-map-marker"></i>
        <span>Maps</span>
    </a>
    <ul>
        <li><a href="googlemap.html">Google Map</a></li>
        <li><a href="vector-maps.html">Vector Map</a></li>
    </ul>
</li>
<li>
    <a href="#">
        <i class="fa fa-image"></i>
        <span>Gallery</span>
    </a>
    <ul>
        <li><a href="four-column-gallery.html">Four Column</a></li>
        <li><a href="three-column-gallery.html">Three Column</a></li>
        <li><a href="two-column-gallery.html">Two Column</a></li>
    </ul>
</li>
<li>
    <a href="#">
        <i class="fa fa-gift"></i>
        <span>Media</span>
        <span class="badge badge-red">New</span>
    </a>
    <ul>
        <li><a href="image-crop.html">Image Cropper</a></li>
        <li><a href="magnify.html">Image Magnify <span class="badge badge-red">New</span></a></li>
        <li><a href="media.html">Media Player <span class="badge badge-red">New</span></a></li>
    </ul>
</li>
<li>
    <a href="#">
        <i class="fa fa-list-alt"></i>
        <span>Pages</span>
    </a>
    <ul>
        <li><a href="<?php echo $this->webroot;?>typography.html">Typography</a></li>
        <li><a href="<?php echo $this->webroot;?>pricing-table.html">Pricing Table</a></li>
        <li><a href="<?php echo $this->webroot;?>profile.html">Profile</a></li>
        <li><a href="<?php echo $this->webroot;?>login.html">Login</a></li>
        <li><a href="<?php echo $this->webroot;?>lock-screen.html">Lock Screen</a></li>
        <li><a href="<?php echo $this->webroot;?>registration.html">Registration</a></li>
        <li><a href="<?php echo $this->webroot;?>coming-soon.html">ComingSoon</a></li>
        <li><a href="<?php echo $this->webroot;?>widget.html">Widgets</a></li>
        <li><a href="<?php echo $this->webroot;?>grid.html">Grids</a></li>
        <li><a href="<?php echo $this->webroot;?>panel.html">Panels</a></li>
        <li><a href="<?php echo $this->webroot;?>404.html">404</a></li>
        <li><a href="<?php echo $this->webroot;?>500.html">500</a></li>
    </ul>
</li>
<li>
    <a href="#">
        <i class="fa fa-flag-o"></i>
        <span>Icons</span>
    </a>
    <ul>
        <li><a href="<?php echo $this->webroot;?>font-awesome.html">Font Awesome</a></li>
        <li><a href="<?php echo $this->webroot;?>glyphicons.html">Glyphicons</a></li>
    </ul>
</li>
<li>
    <a href="#">
        <i class="fa fa-flash"></i>
        <span>Layout</span>
    </a>
    <ul>
        <li><a href="blank.html">Blank Page</a></li>
        <li><a href="minimize-left.html">Minimize Left</a></li>
        <li><a href="maximize-right.html">Maximize Right</a></li>
        <li><a href="with-footer.html">With Footer</a></li>
        <li>
            <a href="#">Color</a>
            <ul>
                <li><a href="red-color.html">Red</a></li>
                <li><a href="blue-color.html">Blue</a></li>
                <li><a href="light-green-color.html">Light Green</a></li>
                <li><a href="black-color.html">Black</a></li>
                <li><a href="deep-blue-color.html">Deep Blue</a></li>
            </ul>
        </li>
    </ul>
</li>
<li>
    <a href="#">
        <i class="fa fa-magnet"></i>
        <span>Multi Level Menu</span>
    </a>
    <ul>
        <li><a href="javascript:void(0)">Page 1</a></li>
        <li>
            <a href="javascript:void(0)">Page 2</a>
            <ul>
                <li><a href="javascript:void(0)">Page 2.1</a></li>
                <li>
                    <a href="javascript:void(0)">Page 2.2</a>
                    <ul>
                        <li><a href="javascript:void(0)">Page 2.2.1</a></li>
                        <li><a href="javascript:void(0)">Page 2.2.2</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)">Page 3</a>
            <ul>
                <li><a href="javascript:void(0)">Page 3.1</a></li>
                <li>
                    <a href="javascript:void(0)">Page 3.2</a>
                    <ul>
                        <li><a href="javascript:void(0)">Page 3.2.1</a></li>
                        <li>
                            <a href="javascript:void(0)">Page 3.2.2</a>
                            <ul>
                                <li><a href="javascript:void(0)">Page 3.2.2.1</a></li>
                                <li><a href="javascript:void(0)">Page 3.2.2.2</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</li>
</ul>
<!--Left navigation end-->
</section>
<!--Left navigation section end-->


<!--Page main section start-->
<section id="min-wrapper">
    <div id="main-content">
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
    </div>
    <!--Tab content -->
</section>
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

<!--easing Library Script Start -->
<script src="<?php echo $this->webroot;?>assets/js/lib/jquery.easing.js"></script>
<!--easing Library Script End -->

<!--Nano Scroll Script Start -->
<script src="<?php echo $this->webroot;?>assets/js/jquery.nanoscroller.min.js"></script>
<!--Nano Scroll Script End -->

<!--switchery Script Start -->
<script src="<?php echo $this->webroot;?>assets/js/switchery.min.js"></script>
<!--switchery Script End -->

<!--bootstrap switch Button Script Start-->
<script src="<?php echo $this->webroot;?>assets/js/bootstrap-switch.js"></script>
<!--bootstrap switch Button Script End-->

<!--easypie Library Script Start -->
<script src="<?php echo $this->webroot;?>assets/js/jquery.easypiechart.min.js"></script>
<!--easypie Library Script Start -->

<!--bootstrap-progressbar Library script Start-->
<script src="<?php echo $this->webroot;?>assets/js/bootstrap-progressbar.min.js"></script>
<!--bootstrap-progressbar Library script End-->

<script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/pages/layout.js"></script>
<!--Layout Script End -->

<!--Chartjs  library Script Start -->
<script src="<?php echo $this->webroot;?>assets/js/chart/chartjs/Chart.min.js"></script>
<!--Chartjs  library Script End -->

<!--Chartjs  demo Script Start -->
<script src="<?php echo $this->webroot;?>assets/js/pages/chartjs.js"></script>
<!--Chartjs  demo Script End -->
</body>
</html>