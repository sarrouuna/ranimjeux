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
    <title>Younes Coif</title>
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/pace.css">
    <script src="<?php echo $this->webroot;?>assets/js/pace.min.js"></script>
    <link href="<?php echo $this->webroot;?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/validationEngine.jquery.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/bootstrapValidator.css">
    <link href="<?php echo $this->webroot;?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo $this->webroot;?>assets/css/responsive.css" rel="stylesheet">
    <link href="<?php echo $this->webroot;?>assets/css/responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/selectize.bootstrap3.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/fluidbox.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/bootstrap-magnify.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/dndTable.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/tsort.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/jquery.toolbars.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/jquery.remodal.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/tab.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/accordion.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/bootstrap-progressbar-3.1.1.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/fileinput.min.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/jquery.datetimepicker.css">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>assets/css/plugins/accordion.css">
    <script src="<?php echo $this->webroot;?>assets/js/jquery-1.10.2.min.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/ion.sound.js"></script>
    
<body class="pace-done black-color">
<!--Navigation Top Bar Start-->
<nav class="navigation">
<?php // echo $this->element('nav'); ?>
</nav>
<!--Navigation Top Bar End-->
<section id="main-container">
<!--Left navigation section start-->
  <?php // echo $this->element('Stock'); ?> 
  <?php // echo $this->element('Parametrage'); ?>              
<!--Left navigation section end-->


<!--Left navigation section start-->
  
 



 <?php if (in_array(strtolower($this->params['controller']), array(
      'familles','sousfamilles','soussousfamilles','articles','unites','tags','inventaires','depots','homologations','stockdepots','transferts','bonreceptionstocks','bonsortiestocks','etatstockmins','etatfuturcommandes'
      ,'personnels','utilisateurs','fonctions','societes','pointdeventes','exercices','workflows','etatworkflows','tracemisejours'
      ,'reglements','piecereglements','fournisseurs','famillefournisseurs','bonreceptions','factures','commandes','bonentres','relevefournisseurs','importations','namepiecejointes','deviprospects','namesituations','situations','engagementfournisseurs','etatpiecereglements'
      ,'reglementclients','piecereglementclients','clients','bonlivraisons','factureclients','factureavoirs','commandeclients','devis','bonsortis','familleclients','sousfamilleclients','zones','pays','releves','affectations','etatsoldecommandeclients','etathistoriquearticles','etatligneventes'
      ,'bordereaus','lignebordereaus','comptes','versements','sortiecaissees','caissees','carnetcheques','alimentations','caisseinternes','retenue','retenuefournisseur','etatvente','etatachat','engagementcomptes'
      ,'etatclients','etatclientarticles','etatarticles','etatpointdeventes','etatcaarticles','etatcaclientarticles','etatcapersonnels'
      ,'accueils','etatretenues','variationtauxdechanges','fichetechniques','productions','recouvrements','traitecredits','factureavoirfrs','etatbenefices','historiquesuggcddes','copiestockdepots','bonecarts','suivicommercials','journees','cartefidelites','promotions','ticketcaisses','fondcaisses'
       ))): ?>
                    <?php 
//                if($this->params['controller']=="accueils"){
//                $this->params['user']=CakeSession::read('users');
//                $this->params['pointdevente']=CakeSession::read('pointdevente');
//                $this->params['depot']=CakeSession::read('depot');
//                $this->params['stock']="stk";
//                $this->params['lien_stock']=CakeSession::read('lien_stock');
//                $this->params['parametrage']="par";
//                $this->params['lien_parametrage']=CakeSession::read('lien_parametrage');
//                $this->params['achat']="ach";
//                $this->params['lien_achat']=CakeSession::read('lien_achat');
//                $this->params['vente']="vnt";
//                $this->params['lien_vente']=CakeSession::read('lien_vente');
//                $this->params['finance']="fnc";
//                $this->params['lien_finance']=CakeSession::read('lien_finance');
//                $this->params['stat']="stat";
//                $this->params['lien_stat']=CakeSession::read('lien_stat');
//                $this->params['defaultmenu']=CakeSession::read('defaultmenu');    
//                }
    
                    
                    //debug($this->params['user']);
                    ini_set('session.cookie_path',$this->webroot.'/'.$this->params['controller'].'/'.$this->params['action']);
                    //echo $this->element('menu'); ?> 
                <?php endif; ?>
<!--Left navigation section end-->



<!--Page main section start-->
<section  >
<div id="main-content">
<div class="container-fluid">
             <?php 
            
             echo $this->element('nav'); ?>
    <br>    <br>    <br>    <div id="preloader"><img src="<?php echo $this->webroot;?>/img/preloader.gif" alt="Loading..."/></div>



            <?php 
           if (in_array(strtolower($this->params['controller']), array(
      'familles','sousfamilles','soussousfamilles','articles','unites','tags','inventaires','depots','homologations','stockdepots','transferts','bonreceptionstocks','bonsortiestocks','etatstockmins','etatfuturcommandes'
      ,'personnels','utilisateurs','fonctions','societes','pointdeventes','exercices','workflows','etatworkflows','tracemisejours'
      ,'reglements','piecereglements','fournisseurs','famillefournisseurs','bonreceptions','factures','commandes','bonentres','relevefournisseurs','importations','namepiecejointes','deviprospects','namesituations','situations','engagementfournisseurs','etatpiecereglements'
      ,'reglementclients','piecereglementclients','clients','bonlivraisons','factureclients','factureavoirs','commandeclients','devis','bonsortis','familleclients','sousfamilleclients','zones','pays','releves','affectations','etatsoldecommandeclients','etathistoriquearticles','etatligneventes'
      ,'bordereaus','lignebordereaus','comptes','versements','sortiecaissees','caissees','carnetcheques','alimentations','caisseinternes','retenue','retenuefournisseur','etatvente','etatachat','engagementcomptes'
      ,'etatclients','etatclientarticles','etatarticles','etatpointdeventes','etatcaarticles','etatcaclientarticles','etatcapersonnels'
      ,'accueils','etatretenues','variationtauxdechanges','fichetechniques','productions','recouvrements','traitecredits','factureavoirfrs','etatbenefices','historiquesuggcddes','copiestockdepots','bonecarts','suivicommercials'
      ,'affaires' ,'journees','cartefidelites','promotions','ticketcaisses','fondcaisses'))): 
    
 //CakeSession::delete('C');
 //CakeSession::delete('v');
 
 
 //debug($this->params);
                    if($this->params['controller']!=CakeSession::read('Controller')){
                        CakeSession::delete('recherche');
                    }
                    CakeSession::write('Controller',$this->params['controller']); 
                    CakeSession::write('view',$this->params['action']);
                    CakeSession::write('url',$this->params['url']);
                    CakeSession::write('webroot',$this->webroot);
                    //debug(CakeSession::read('Controller'));
                    //debug(CakeSession::read('view'));
                    //debug(CakeSession::read('recherche'));  
            
    echo $this->fetch('content'); 
    endif; ?>
        </div>
    </div>

<!--Page main section end -->
<!--Right hidden  section start-->

<!--Right hidden  section end -->
</section>
</section>
<script>var wr = '<?php echo $this->webroot ?>'; </script>
<script src="<?php echo $this->webroot;?>assets/js/jquery.min.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/kinda.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/thermeco.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/wajdi.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/bilel.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/thhelmi.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/ansar.js"></script>
<script src="<?php echo $this->webroot;?>assets/js/haitham.js"></script>
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
     <script src="<?php echo $this->webroot;?>assets/js/bootstrap-magnify.js"></script>
    <script src="<?php echo $this->webroot;?>assets/js/jquery.fluidbox.js"></script>
     <script src="<?php echo $this->webroot;?>assets/js/pages/demo.magnify.js"></script>
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
    <script src="<?php echo $this->webroot;?>assets/js/jquery.remodal.js"></script>
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
    <script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/chart/flot/jquery.flot.js"></script>
    <script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/chart/flot/jquery.flot.pie.js"></script>
    <script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/chart/flot/jquery.flot.resize.js"></script>
    <script type="text/javascript" src="<?php echo $this->webroot;?>assets/js/pages/demo.flotchart.js"></script>
    <script type="text/javascript">
(function($){$(window).load(function(){$("#preloader").delay(0).fadeOut(0);});})(jQuery);
</script>
</body>
</html>