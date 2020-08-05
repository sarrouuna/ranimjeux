


<?php
$testreglement=ClassRegistry::init('Societe')->find('first');
?>

<!DOCTYPE html>
<html lang="en">
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
    <link rel="apple-touch-icon-precomposed" href="<?php echo $this->webroot;?>/assets/images/ios/fickle-logo-72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->webroot;?>/assets/images/ios/fickle-logo-72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->webroot;?>/assets/images/ios/fickle-logo-114.png" />

    <!-- TODO: Add a favicon -->
    <link rel="shortcut icon" href="<?php echo $this->webroot;?>/assets/images/ico/fab.ico">

    <title><?php echo $testreglement['Societe']['nom']; ?></title>

    <!--Page loading plugin Start -->
    <link rel="stylesheet" href="<?php echo $this->webroot;?>/assets/css/plugins/pace.css">
    <script src="<?php echo $this->webroot;?>/assets/js/pace.min.js"></script>
    <!--Page loading plugin End   -->

    <!-- Plugin Css Put Here -->
    <link href="<?php echo $this->webroot;?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>/assets/css/plugins/bootstrap-switch.min.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>/assets/css/plugins/ladda-themeless.min.css">

    <link href="<?php echo $this->webroot;?>/assets/css/plugins/humane_themes/bigbox.css" rel="stylesheet">
    <link href="<?php echo $this->webroot;?>/assets/css/plugins/humane_themes/libnotify.css" rel="stylesheet">
    <link href="<?php echo $this->webroot;?>/assets/css/plugins/humane_themes/jackedup.css" rel="stylesheet">

    <!-- Plugin Css End -->
    <!-- Custom styles Style -->
    <link href="<?php echo $this->webroot;?>/assets/css/style.css" rel="stylesheet">
    <!-- Custom styles Style End-->

    <!-- Responsive Style For-->
    <link href="<?php echo $this->webroot;?>/assets/css/responsive.css" rel="stylesheet">
    <!-- Responsive Style For-->

    <!-- Custom styles for this template -->


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-screen" >

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="login-box">
                    <div class="login-content">
                        <div class="">
                            <i class="glyphicon"><img src="<?php echo $this->webroot;?>img/<?php echo $testreglement['Societe']['logo'] ; ?>" alt="" style="vertical-align: top !important; width: 260px;height: 150px;"/></i>

                        </div>
<!--                        <h3>Identify Yourself</h3>-->
                         <h1 style="font-size: 15px !important">ERP <?php echo $testreglement['Societe']['nom'];?></h1>
                         <div class="social-btn-login" style="margin-top: 40%;">
<!--                            <ul>
                                <li><a href="javascript:void(0)"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-github"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-bitbucket"></i></a></li>
                            </ul>-->
                            <!--<button class="btn ls-dark-btn rounded"><i class="fa fa-facebook"></i></button>
                            <button class="btn ls-dark-btn rounded"><i class="fa fa-twitter"></i></button>
                            <button class="btn ls-dark-btn rounded"><i class="fa fa-linkedin"></i></button>
                            <button class="btn ls-dark-btn rounded"><i class="fa fa-google-plus"></i></button>
                            <button class="btn ls-dark-btn rounded"><i class="fa fa-github"></i></button>
                            <button class="btn ls-dark-btn rounded"><i class="fa fa-bitbucket"></i></button>-->
                        </div>
                    </div>
 <?php echo $this->Form->create('Utilisateur',array('class'=>'mainForm','autocomplete'=>'off'));?>
                    <div class="login-form">
                        <form id="form-login" action="#" class="form-horizontal ls_form" >
                            <div class="input-group ls-group-input">
                                <input class="form-control" id="mpt" type="text" placeholder="Login" name="login" value=""  />
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            </div>
                              <script> document.getElementById('mpt').focus(); </script>

                            <div class="input-group ls-group-input">

                                <input type="password" placeholder="Mot de passe" name="password"
                                       class="form-control" value="" />
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            </div>


                            <div class="input-group ls-group-input login-btn-box">
                                <button class="btn ls-dark-btn ladda-button col-md-12 col-sm-12 col-xs-12" data-style="slide-down">
                                    <span class="ladda-label"><i class="fa fa-key"></i></span>
                                </button>


                            </div>
                        </form>
                    </div>
                      <?php echo $this->Form->end();?>
                    <div class="forgot-pass-box">
                        <form action="#" class="form-horizontal ls_form">
                            <div class="input-group ls-group-input">
                                <input class="form-control" type="text" placeholder="someone@mail.com">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            </div>
                            <div class="input-group ls-group-input login-btn-box">
                                <button class="btn ls-dark-btn col-md-12 col-sm-12 col-xs-12">
                                    <i class="fa fa-rocket"></i> Send
                                </button>

                                <a class="login-view" href="javascript:void(0)">Login</a> & <a class="" href="registration.html">Registration</a>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
   <p class="copy-right big-screen hidden-xs hidden-sm">
        <span>&#169;</span> MTD application <span class="footer-year">2018</span>
    </p>
</section>

</body>
<script src="<?php echo $this->webroot;?>/assets/js/lib/jquery-2.1.1.min.js"></script>
<script src="<?php echo $this->webroot;?>/assets/js/lib/jquery.easing.js"></script>
<script src="<?php echo $this->webroot;?>/assets/js/bootstrap-switch.min.js"></script>
<!--Script for notification start-->
<script src="<?php echo $this->webroot;?>/assets/js/loader/spin.js"></script>
<script src="<?php echo $this->webroot;?>/assets/js/loader/ladda.js"></script>
<script src="<?php echo $this->webroot;?>/assets/js/humane.min.js"></script>
<!--Script for notification end-->

<script src="<?php echo $this->webroot;?>/assets/js/pages/login.js"></script>
</html>
