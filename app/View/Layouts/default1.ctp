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
    <link rel="shortcut icon" href="<?php echo $this->webroot;?>assets/images/ico/fab.ico">
    <title>Sotem</title> 
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/pace.css">
    <script src="<?php echo $this->webroot;?>assets/js/pace.min.js"></script>
    <link href="<?php echo $this->webroot;?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/validationEngine.jquery.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/bootstrapValidator.css">
    <link href="<?php echo $this->webroot;?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo $this->webroot;?>assets/css/responsive.css" rel="stylesheet">
    <link href="<?php echo $this->webroot;?>assets/css/responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/selectize.bootstrap3.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/dndTable.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/tsort.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/jquery.toolbars.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/jquery.remodal.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/tab.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/accordion.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/bootstrap-progressbar-3.1.1.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/fileinput.min.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/jquery.datetimepicker.css">
<body class="pace-done black-color">
<!--Navigation Top Bar Start-->
<nav class="navigation">
<?php echo $this->element('nav'); ?>
</nav>
<!--Navigation Top Bar End-->
<section id="main-container">

<!--Left navigation section start-->
  <?php if (in_array(strtolower($this->params['controller']), array('articles','inventaires','ligneproductions','tailles', 'familles','modeles','couleurs','references','types','depots','stockdepots','mouvementstocks','marques'))): ?>
                    <?php echo $this->element('Stock'); ?> 
                <?php endif; ?>
 <?php if (in_array(strtolower($this->params['controller']), array('clients', 'boncommandes', 'bonlivraisons','devis','factures','reglements','collections'))): ?>
                    <?php echo $this->element('Vente'); ?> 
                <?php endif; ?>
<?php if (in_array(strtolower($this->params['controller']), array('productions'))): ?>
                    <?php echo $this->element('production'); ?> 
                <?php endif; ?>
<?php if (in_array(strtolower($this->params['controller']), array('matierepremieres','unites','fournisseurs','mpfournisseurs','deposits','inventories','lineinventories','stockmatierepremieres', 'emplacements', 'colors', 'families', 'machines', 'typestocks', 'types', 'colors',
                    'bcs', 'lcs', 'bl', 'lbls', 'bls', 'bills', 'lbills', 'lots', 'lignelots','demandes','lignedemandes', 'bonsorties', 'lignesorties'
    ))): ?>
                    <?php echo $this->element('Achat'); ?> 
                <?php endif; ?>
<!--Left navigation section end-->


<!--Page main section start-->
<section id="min-wrapper">
<div id="main-content">
<div class="container-fluid">
<?php echo $this->fetch('content'); ?>
</div>
</div>



</section>
<!--Page main section end -->
<!--Right hidden  section start-->

<!--Right hidden  section end -->

</section>
<script>var wr = '<?php echo $this->webroot ?>'; </script>
<script src="<?php echo $this->webroot;?>assets/js/jquery.min.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/kinda.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/kindag.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/kindai.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/kindaa.js"></script>




<script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/color.js"></script>
    <script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/lib/jquery-1.11.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/multipleAccordion.js"></script>
    <script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/jquery-ui.min.js"></script>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>-->
    <script src="<?php echo $this->webroot;?>assets/js/lib/jquery.easing.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/jquery.nanoscroller.min.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/switchery.min.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/bootstrap-switch.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/jquery.easypiechart.min.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/bootstrap-progressbar.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/pages/layout.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/jquery.maskedinput.min.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/jquery.autosize.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/validationEngine/languages/jquery.validationEngine-en.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/validationEngine/jquery.validationEngine.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/bootstrapvalidator/bootstrapValidator.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/pages/formValidation.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/selectize.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/pages/selectTag.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/tsort.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/jquery.tablednd.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/jquery.dragtable.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/editable-table/jquery.dataTables.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/editable-table/jquery.validate.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/editable-table/jquery.jeditable.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/editable-table/jquery.dataTables.editable.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/pages/table.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/bootstrap-rating-input.min.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/jquery.toolbar.min.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/notify.min.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/tabulous.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/jquery.qrcode.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/qrcode.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/jquery.remodal.min.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/bootbox.min.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/pages/uiElements.js"></script>
    
     <script src="<?php echo $this->webroot;?>assets/js/fileinput.min.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/jquery.autosize.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/pages/sampleForm.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/jquery.minicolors.min.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/jquery.datetimepicker.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/pages/pickerTool.js"></script>
     <script src="<?php echo $this->webroot;?>assets/js/pages/fontAwesome.js"></script>
    
</body>
</html>



    <!--Layout Script start -->

    <!--easing Library Script Start -->
    <!--easing Library Script End -->

    <!--Nano Scroll Script Start -->
    <!--Nano Scroll Script End -->

    <!--switchery Script Start -->
    <!--switchery Script End -->

    <!--bootstrap switch Button Script Start-->
    <!--bootstrap switch Button Script End-->

    <!--easypie Library Script Start -->
    <!--easypie Library Script Start -->

    <!--bootstrap-progressbar Library script Start-->
    <!--bootstrap-progressbar Library script End-->

    <!--Layout Script End -->

    <!--Rating Library Script Start -->
    <!--Rating Library Script End -->

    <!--Tooltip Bar Library Script Start -->
    <!--Tooltip Bar Library Script End -->

    <!--Notify notification Library Script Start -->
    <!--Notify notification Library Script End -->

    <!--Tab Library Script Start -->
    <!--Tab Library Script End -->

    <!--Qrcode Library Script Start -->
    <!--Qrcode Library Script End -->


    <!-- Remodal Js Start-->
    <!-- Remodal Js Finished-->

    <!--BootBox script for calender start-->
    <script src="assets/js/bootbox.min.js"></script>
    <!--BootBox script for calender End-->

    <!--Demo ui element Script Start -->
    <script src="assets/js/pages/uiElements.js"></script>
    <!--Demo ui element Script End -->