<section id="left-navigation">
<!--Left navigation user details start-->
<?php 
$logo=  CakeSession::read('logo');
?>
<div class="">
     <img src="<?php echo $this->webroot;?>img/<?php echo $logo;?>" alt="" style="width: 200px;height: 89px;"/>
<!--    <div class="user-online-status"><span class="user-status is-online  "></span> </div>-->
</div>
<?php 
$stock=  CakeSession::read('stock');
$parametrage=  CakeSession::read('parametrage');
$achat=  CakeSession::read('achat');
$vente=  CakeSession::read('vente'); 
$finance=  CakeSession::read('finance'); 
$stat=  CakeSession::read('stat');

$menus_par=  CakeSession::read('lien_parametrage');
$menu_par=$menus_par[0]['lien'];
//debug($menu_par);die;

$menus_stk=CakeSession::read('lien_stock');
$menu_stk=$menus_stk[0]['lien'];

$menus_ach=CakeSession::read('lien_achat');
$menu_ach=$menus_ach[0]['lien'];

$menus_vnt=CakeSession::read('lien_vente');
$menu_vnt=$menus_vnt[0]['lien'];
if ($menu_vnt=='marge'){ $menu_vnt=$menus_vnt[1]['lien'];}

$menus_fnc=CakeSession::read('lien_finance');
$menu_fnc=$menus_fnc[0]['lien'];

$menus_stat=CakeSession::read('lien_stat');
$menu_stat=$menus_stat[0]['lien'];
?>
<ul class="social-icon">
     <?php  if(@$parametrage=='par'){?>
    <li><a   class="aff_divparametrage"><i ><span title="Parametrage"><img src="<?php echo $this->webroot;?>assets/images/ico/fab.ico" alt="" width="20px"/></span></i></a></li>
    <?php } ?>
     <?php  if(@$stock=='stk'){?>
    <li><a   class="aff_divstock"><i ><span title="Stock"><img src="<?php echo $this->webroot;?>assets/images/depot.png" alt="" width="20px"/></span></i></a></li>
    <?php } ?>  
   
    <?php  if(@$achat=='ach'){ ?>
    <li><a  class="aff_divachat"><i ><span title="Achat"><img src="<?php echo $this->webroot;?>assets/images/achat.png" alt="" width="20px"/></span></i></a></li>
    <?php } ?>  
    
     <?php  if(@$vente=='vnt'){ ?>
    <li><a  class="aff_divvente"><i ><span title="Vente"><img src="<?php echo $this->webroot;?>assets/images/vente.png" alt="" width="20px"/></span></i></a></li>
     <?php } ?>
     <?php  if(@$finance=='fnc'){?>  
    <li><a  class="aff_divfinance"><i ><span title="Finance"><img src="<?php echo $this->webroot;?>assets/images/finance.png" alt="" width="20px"/></span></i></a></li>
     <?php } ?> 
   <?php  if(@$stat=='stat'){?>
    <li><a  class="aff_divstat"><i ><span title="Statistique"><img src="<?php echo $this->webroot;?>assets/images/telechargement.png" alt="" width="20px"/></span></i></a></li>
     <?php } ?> 
</ul>

<div class="phone-nav-box visible-xs">
    <a class="phone-logo" href="index.html" title="">
        <h1>Gestion de stock</h1>
    </a>
    <a class="phone-nav-control" href="javascript:void(0)">
        <span class="fa fa-bars"></span>
    </a>
    <div class="clearfix"></div>
</div>
<!--Phone Navigation Menu icon start-->

<!--Left navigation start-->




<ul class="mainNav" id="divparametrage"
<?php if (in_array(strtolower($this->params['controller']), array('personnels','utilisateurs','fonctions','societes','pointdeventes','exercices','workflows','etatworkflows'))){ ?>
<?php }else{ ?> 
style="display:none;"
<?php } ?>
    >
     <?php 
$lien_parametrage=  CakeSession::read('lien_parametrage');
//debug($lien_parametrage);die;

$n=0;
foreach($lien_parametrage as $k=>$liens){
    if(@$liens['lien']=='societes'){
		$societe=1;
	}
	if(@$liens['lien']=='personnels'){
		$personnel=1;
	}
        if(@$liens['lien']=='fonctions'){
		$fonction=1;
	}
        if(@$liens['lien']=='utilisateurs'){
		$utilisateur=1;
	}  
        if(@$liens['lien']=='pointdeventes'){
		$pointdevente=1;
	} 
        if(@$liens['lien']=='exercices'){
		$exercice=1;
	}
        if(@$liens['lien']=='workflows'){
		$workflow=1;
	} 
        if(@$liens['lien']=='etatworkflows'){
		$etatworkflow=1;
	} 
}    
   ?> 

    <?php if(@$societe==1){?>   

<li class="">
    <a class="" href="<?php echo $this->webroot;?>Societes/index">
          <i ><img src="<?php echo $this->webroot;?>assets/images/societe.png" alt="" width="15px"/></i></i> <span>Societes</span>
    </a>
</li>
 <?php } ?>
 <?php if(@$fonction==1){?>   

<li class="">
    <a class="" href="<?php echo $this->webroot;?>Fonctions/index">
         <i class="fa fa-edit"></i></i> <span>Fonctions</span>
    </a>
</li>
 <?php } ?>
 <?php if(@$personnel==1){?>   
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Personnels/index">
        <i ><img src="<?php echo $this->webroot;?>assets/images/client.png" alt="" width="15px"/></i> <span>Personnels</span>
    </a>
</li> 
<?php } ?>
 <?php if(@$utilisateur==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Utilisateurs/index">
        <i ><img src="<?php echo $this->webroot;?>assets/images/client.png" alt="" width="15px"/></i> <span>Utilisateurs</span>
    </a>
</li>
<?php } ?>
<?php if(@$pointdevente==1){?>   

<li class="">
    <a class="" href="<?php echo $this->webroot;?>Pointdeventes/index">
         <i class="fa fa-edit"></i></i> <span>Points De Ventes</span>
    </a>
</li>
 <?php } ?>
<?php if(@$exercice==1){?>   

<li class="">
    <a class="" href="<?php echo $this->webroot;?>Exercices/index">
         <i class="fa fa-edit"></i></i> <span>Exercices</span>
    </a>
</li>
 <?php } ?>
<?php if(@$workflow==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>workflows/index">
       <i class="fa fa-edit"></i> <span>Ordres de travail</span>
    </a>
</li>
<?php  } ?>
<?php if(@$etatworkflow==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>etatworkflows/index">
       <i class="fa fa-edit"></i> <span>Etat d'ordres de travail</span>
    </a>
</li>
<?php  } ?>
</ul>


<ul  class="mainNav" id="divstock" 
<?php if (in_array(strtolower($this->params['controller']), array('familles','sousfamilles','soussousfamilles','articles','unites','tags','inventaires','depots','homologations','stockdepots','transferts','bonreceptionstocks','bonsortiestocks','etatstockmins','etatfuturcommandes'))){ ?>
<?php }else{ ?> 
style="display:none;"
<?php } ?>     
 >
<?php
$lien_stock=  CakeSession::read('lien_stock');
$n=0;
foreach($lien_stock as $k=>$liens){
	
        if(@$liens['lien']=='articles'){
		$article=1;
	}
        if(@$liens['lien']=='familles'){
		$famille=1;
	}
        if(@$liens['lien']=='sousfamilles'){
		$sousfamille=1;
	}
        if(@$liens['lien']=='soussousfamilles'){
		$soussousfamille=1;
	}
        if(@$liens['lien']=='tags'){
		$tag=1;
	}
        if(@$liens['lien']=='unites'){
		$unite=1;
	}
         if(@$liens['lien']=='inventaires'){
		$inventaire=1;
	}
         if(@$liens['lien']=='depots'){
		$depot=1;
	}
       
         if(@$liens['lien']=='stockdepots'){
		$stockdepot=1;
	}
        if(@$liens['lien']=='transferts'){
		$transfert=1;
	}
        if(@$liens['lien']=='bonreceptionstocks'){
		$bonreceptionstock=1;
	}
        if(@$liens['lien']=='bonsortiestocks'){
		$bonsortiestock=1;
	}
        if(@$liens['lien']=='etatstockmins'){
		$etatstockmin=1;
	}
        if(@$liens['lien']=='etatfuturcommandes'){
		$etatfuturcommande=1;
	}
}    
   ?> 
    
<?php if(@$transfert==1){?>   
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Transferts/index">
     <i><img src="<?php echo $this->webroot;?>assets/images/depoticon.png" alt="" width="15px"/></i> <span>Transferts</span>  
    </a>
</li>
 <?php } ?>    
 <?php if(@$bonreceptionstock==1){?>   
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Bonreceptionstocks/index">
     <i><img src="<?php echo $this->webroot;?>assets/images/depoticon.png" alt="" width="15px"/></i> <span>Bon recéption</span>  
    </a>
</li>
 <?php } ?> 
<?php if(@$bonsortiestock==1){?>   
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Bonsortiestocks/index">
     <i><img src="<?php echo $this->webroot;?>assets/images/depoticon.png" alt="" width="15px"/></i> <span>Bon Sortie</span>  
    </a>
</li>
 <?php } ?> 
 <?php if(@$famille==1){?>   
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Familles/index">
    <i><img src="<?php echo $this->webroot;?>assets/images/famille.png" alt="" width="15px"/></i> <span>Familles</span>  
    </a>
</li>
 <?php } ?>
<?php if(@$sousfamille==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Sousfamilles/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/famille.png" alt="" width="15px"/></i> <span>Sous familles</span>
    </a>
</li> 
 <?php } ?>
<?php if(@$soussousfamille==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Soussousfamilles/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/famille.png" alt="" width="15px"/></i> <span>Sous sous familles</span>
    </a>
</li> 
<?php } ?>
<?php if(@$unite==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Unites/index">
        <i class="fa fa-edit"></i> <span>Unites</span>
    </a>
</li> 
<?php } ?>
<?php if(@$tag==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Tags/index">
        <i class="fa fa-edit"></i> <span>Tags</span>
    </a>
</li>
<?php } ?>
<?php if(@$article==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Articles/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/article.png" alt="" width="15px"/></i> <span>Articles</span>
    </a>
</li> 
<?php } ?>

<?php if(@$inventaire==1){?>   
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Inventaires/index">
     <i><img src="<?php echo $this->webroot;?>assets/images/inventaire.png" alt="" width="15px"/></i> <span>Inventaires</span>  
    </a>
</li>
 <?php } ?>
<?php if(@$depot==1){?>   
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Depots/index">
     <i><img src="<?php echo $this->webroot;?>assets/images/depoticon.png" alt="" width="15px"/></i> <span>Dépots</span>  
    </a>
</li>
 <?php } ?>

<?php  if(@$stockdepot==1){?>   
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Stockdepots/index">
     <i><img src="<?php echo $this->webroot;?>assets/images/depoticon.png" alt="" width="15px"/></i> <span>Etat de stock</span>  
    </a>
</li>
 <?php } ?>
<?php  if(@$etatstockmin==1){?>   
<li class="">
    <a class="" href="<?php echo $this->webroot;?>etatstockmins/index">
     <i><img src="<?php echo $this->webroot;?>assets/images/depoticon.png" alt="" width="15px"/></i> <span>Etat de stock Min</span>  
    </a>
</li>
 <?php } ?>
<?php  if(@$etatfuturcommande==1){?>   
<li class="">
    <a class="" href="<?php echo $this->webroot;?>etatfuturcommandes/index">
     <i><img src="<?php echo $this->webroot;?>assets/images/depoticon.png" alt="" width="15px"/></i> <span>Etat Futur Stock</span>  
    </a>
</li>
 <?php } ?>
</ul>


<ul class="mainNav" id="divachat" 
<?php if (in_array(strtolower($this->params['controller']), array('reglements','piecereglements','fournisseurs','famillefournisseurs','bonreceptions','factures','commandes','bonentres','relevefournisseurs','importations','namepiecejointes','deviprospects','namesituations','situations','engagementfournisseurs','etatpiecereglements'))){ ?>
<?php }else{ ?> 
style="display:none;"
<?php } ?>     
>
    
<?php 
$lien_achat=  CakeSession::read('lien_achat');
$n=0;
foreach($lien_achat as $k=>$liens){
	if(@$liens['lien']=='famillefournisseurs'){
		$famillefournisseur=1;
	}
        if(@$liens['lien']=='fournisseurs'){
		$fournisseur=1;
	}
        if(@$liens['lien']=='bonreceptions'){
		$bonreception=1;
	}
          if(@$liens['lien']=='factures'){
		$facture=1;
	}
         if(@$liens['lien']=='commandes'){
		$commande=1;
	}
        if(@$liens['lien']=='relevefournisseurs'){
		$relevefournisseur=1;
	}
         if(@$liens['lien']=='reglements'){
		$reglement=1;
	}
         if(@$liens['lien']=='piecereglements'){
		$piecereglement=1;
	}
        if(@$liens['lien']=='importations'){
		$importation=1;
	}
        if(@$liens['lien']=='namepiecejointes'){
		$namepiecejointe=1;
	}
         if(@$liens['lien']=='deviprospects'){
		$deviprospect=1;
	}
        if(@$liens['lien']=='namesituations'){
		$namesituation=1;
	}
        if(@$liens['lien']=='engagementfournisseurs'){
		$engagementfournisseur=1;
	}
        if(@$liens['lien']=='etatpiecereglements'){
		$etatpiecereglement=1;
	}
}    
   ?> 
<?php if(@$famillefournisseur==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Famillefournisseurs/index">
       <i ><img src="<?php echo $this->webroot;?>assets/images/famille.png" alt="" width="15px"/></i> <span>Famille fournisseurs</span>
    </a>
</li> 
<?php } ?>
<?php if(@$fournisseur==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Fournisseurs/index">
        <i ><img src="<?php echo $this->webroot;?>assets/images/client.png" alt="" width="15px"/></i> <span>Fournisseurs</span>
    </a>
</li> 
<?php } ?>
<?php if(@$deviprospect==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Deviprospects/index">
       <i ><img src="<?php echo $this->webroot;?>assets/images/commande.png" alt="" width="15px"/></i> <span>Suggestion Commande</span>
    </a>
</li>
<?php } ?>
<?php if(@$commande==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Commandes/index">
       <i ><img src="<?php echo $this->webroot;?>assets/images/commande.png" alt="" width="15px"/></i> <span>Commandes</span>
    </a>
</li>
<?php } ?>
<?php if(@$bonreception==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Bonreceptions/index">
        <i ><img src="<?php echo $this->webroot;?>assets/images/bon.png" alt="" width="15px"/></i> <span>Bon de Livraison</span>
    </a>
</li>
<?php } ?>
<?php if(@$facture==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Factures/index">
       <i ><img src="<?php echo $this->webroot;?>assets/images/facture.jpg" alt="" width="15px"/></i> <span>Factures</span>
    </a>
</li>
<?php } ?>

<?php if(@$bonreception==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Bonreceptions/historique">
        <i ><img src="<?php echo $this->webroot;?>assets/images/historique.png" alt="" width="15px"/></i> <span>Historiques</span>
    </a>
</li>
<?php } ?>

<?php if(@$reglement==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Reglements/index">
        <i class="fa fa-edit"></i> <span>Règlements </span>
    </a>
</li>
<?php } ?>
<?php if(@$piecereglement==1){?> 
<li>
            <a href="#">
                <i class="fa fa-money"></i>
                <span>Etat de caisse</span>
            <b><i class="fa fa-caret-up"></i></b></a>
<ul style="display: block;">
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Piecereglements/index_all">
        <i class="fa fa-money"></i> <span>Engagement Fournisseur</span>
    </a>
</li>    
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Piecereglements/cheque">
        <i class="fa fa-money"></i> <span>Etat des chèques</span>
    </a>
</li>
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Piecereglements/traite">
        <i class="fa fa-money"></i> <span>Etat des traites</span>
    </a>
</li>
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Piecereglements/index">
        <i class="fa fa-money"></i> <span>Engagement Fournisseur Interne</span>
    </a>
</li>
<?php if (@$engagementfournisseur == 1) { ?>
            <li class="">
                <a class="" href="<?php echo $this->webroot; ?>engagementfournisseurs/index">
                    <i ><img src="<?php echo $this->webroot; ?>assets/images/commande.png" alt="" width="15px"/></i> <span>Engagement Fournisseur Externe</span>
                </a>
            </li>
<?php  } ?>
</ul>
</li>
<?php } ?>
<?php if (@$relevefournisseur == 1) { ?>
            <li class="">
                <a class="" href="<?php echo $this->webroot; ?>Relevefournisseurs/index">
                    <i ><img src="<?php echo $this->webroot; ?>assets/images/commande.png" alt="" width="15px"/></i> <span>Etat de solde fournisseur</span>
                </a>
            </li>
<?php  } ?>
<?php if (@$importation == 1) { ?>
            <li class="">
                <a class="" href="<?php echo $this->webroot; ?>Importations/index">
                    <i ><img src="<?php echo $this->webroot; ?>assets/images/commande.png" alt="" width="15px"/></i> <span>Importation</span>
                </a>
            </li>
<?php  } ?> 
<?php if (@$namepiecejointe == 1) { ?>
            <li class="">
                <a class="" href="<?php echo $this->webroot; ?>namepiecejointes/index">
                    <i ><img src="<?php echo $this->webroot; ?>assets/images/commande.png" alt="" width="15px"/></i> <span>Piece jointe</span>
                </a>
            </li>
<?php  } ?>
<?php if (@$namesituation == 1) { ?>
            <li class="">
                <a class="" href="<?php echo $this->webroot; ?>namesituations/index">
                    <i ><img src="<?php echo $this->webroot; ?>assets/images/commande.png" alt="" width="15px"/></i> <span>Situation</span>
                </a>
            </li>
<?php  } ?>  
 
<?php if (@$etatpiecereglement == 1) { ?>
            <li class="">
                <a class="" href="<?php echo $this->webroot; ?>etatpiecereglements/index">
                    <i ><img src="<?php echo $this->webroot; ?>assets/images/commande.png" alt="" width="15px"/></i> <span>Etat Piece Reglement</span>
                </a>
            </li>
<?php  } ?>            
</ul>


<ul class="mainNav" id="divvente" 
<?php if (in_array(strtolower($this->params['controller']), array('reglementclients','piecereglementclients','clients','bonlivraisons','factureclients','factureavoirs','commandeclients','devis','bonsortis','familleclients','sousfamilleclients','zones','pays','releves','affectations','etatsoldecommandeclients','etathistoriquearticles','etatligneventes'))){ ?>
<?php }else{ ?> 
style="display:none;"
<?php } ?>    
>
<?php 
$lien_vente=  CakeSession::read('lien_vente');
$n=0;
foreach($lien_vente as $k=>$liens){
	
        if(@$liens['lien']=='clients'){
		$client=1;
	}
        if(@$liens['lien']=='bonlivraisons'){
		$bonlivraison=1;
	}
          if(@$liens['lien']=='factureclients'){
		$factureclient=1;
	}
         if(@$liens['lien']=='commandeclients'){
		$commandeclient=1;
	}
         if(@$liens['lien']=='devis'){
		$devi=1;
	}
          if(@$liens['lien']=='releves'){
		$releve=1;
	}
         if(@$liens['lien']=='familleclients'){
		$familleclient=1;
	}
         if(@$liens['lien']=='sousfamilleclients'){
		$sousfamilleclient=1;
	}
         if(@$liens['lien']=='zones'){
		$zone=1;
	}
         if(@$liens['lien']=='factureavoirs'){
		$factureavoir=1;
	}
        if(@$liens['lien']=='reglementclients'){
		$reglementclient=1;
	}
         if(@$liens['lien']=='piecereglementclients'){
		$piecereglementclient=1;
	}
        if(@$liens['lien']=='pays'){
		$pay=1;
	}
        if(@$liens['lien']=='etatsoldecommandeclients'){
		$etatsoldecommandeclient=1;
	}
        if(@$liens['lien']=='etathistoriquearticles'){
		$historiquearticle=1;
	}
        if(@$liens['lien']=='etatligneventes'){
		$etatlignevente=1;
	}
        } 
   ?> 

    
    <li>
            <a href="#">
                <i><img src="<?php echo $this->webroot;?>assets/images/client.png" alt="" width="15px"/></i>
                <span>Info Client</span>
            <b><i class="fa"></i></b></a>
            <ul style="display: block;">
                <?php if(@$client==1){?> 
               <li class="">
    <a class="" href="<?php echo $this->webroot;?>Clients/index">
        <i ><img src="<?php echo $this->webroot;?>assets/images/client.png" alt="" width="15px"/></i> <span>Client</span>
    </a>
</li> 
<?php } ?>
<?php  if(@$familleclient==1){?> 
    <li class="">
    <a class="" href="<?php echo $this->webroot;?>Familleclients/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/famille.png" alt="" width="15px"/></i> <span> Famille Client</span>
    </a>
</li>
<?php  } ?>
<?php   if(@$sousfamilleclient==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Sousfamilleclients/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/famille.png" alt="" width="15px"/></i> <span>Sous Famille Client</span>
    </a>
</li>
<?php  } ?>
            </ul>
</li>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
<!--<li class="">
    <a class="" href="<?php echo $this->webroot;?>Clients/index">
        <i ><img src="<?php echo $this->webroot;?>assets/images/client.png" alt="" width="15px"/></i> <span>Client</span>
    </a>
</li> -->

<?php // if(@$familleclient==1){?> 
<!--<li class="">
    <a class="" href="<?php echo $this->webroot;?>Familleclients/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/famille.png" alt="" width="15px"/></i> <span> Famille Client</span>
    </a>
</li>-->
<?php // } ?>
<?php   //if(@$sousfamilleclient==1){?> 
<!--<li class="">
    <a class="" href="<?php echo $this->webroot;?>Sousfamilleclients/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/famille.png" alt="" width="15px"/></i> <span>Sous Famille Client</span>
    </a>
</li>-->
<?php  //} ?>

<li>
            <a href="#">
                <i><img src="<?php echo $this->webroot;?>assets/images/icons/gmap-2.png" alt="" width="15px"/></i>
                <span>Pays & Zones</span>
            <b><i class="fa"></i></b></a>
            <ul style="display: block;">
               <?php  if(@$pay==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Pays/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/icons/gmap-2.png" alt="" width="15px"/></i> <span>Pays</span>
    </a>
</li>
<?php  } ?>
<?php  if(@$zone==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Zones/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/icons/gmap-2.png" alt="" width="15px"/></i> <span>Zone</span>
    </a>
</li>
<?php  } ?>

            </ul>
</li>















<?php  //if(@$pay==1){?> 
<!--<li class="">
    <a class="" href="<?php echo $this->webroot;?>Pays/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/icons/gmap-2.png" alt="" width="15px"/></i> <span>Pays</span>
    </a>
</li>-->
<?php // } ?>
<?php // if(@$zone==1){?> 
<!--<li class="">
    <a class="" href="<?php echo $this->webroot;?>Zones/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/icons/gmap-2.png" alt="" width="15px"/></i> <span>Zone</span>
    </a>
</li>-->
<?php  //} ?>

<?php if(@$devi==1){?> 

<li>
            <a href="#">
               <i><img src="<?php echo $this->webroot;?>assets/images/devis.png" alt="" width="15px"/></i>  <span>Devis </span>
         </a>
            <ul style="display: block;">
                <li class="">
    <a class="" href="<?php echo $this->webroot;?>Devis/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/devis.png" alt="" width="15px"/></i> <span>Devis </span>
    </a>
</li>
    <li class="">
    <a class="" href="<?php echo $this->webroot;?>Devis/indexx">
         <i><img src="<?php echo $this->webroot;?>assets/images/devis.png" alt="" width="15px"/></i> <span>Factures Proforma</span>
    </a>
</li>

            </ul>
</li>


<?php } ?>
<?php if(@$commandeclient==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Commandeclients/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/commande.png" alt="" width="15px"/></i> <span>Commande</span>
    </a>
</li>
<?php } ?>

<?php if(@$bonlivraison==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Bonlivraisons/index">
       <i><img src="<?php echo $this->webroot;?>assets/images/bon.png" alt="" width="15px"/></i> <span>Bon de livraison</span>
    </a>
</li>
<?php } ?>
<?php if(@$factureclient==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Factureclients/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/facture.jpg" alt="" width="15px"/></i> <span>Facture</span>
    </a>
</li>
<?php } ?>

<?php if(@$factureavoir==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Factureavoirs/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/facture.jpg" alt="" width="15px"/></i> <span>Facture Avoir</span>
    </a>
</li>
<?php } ?>
<?php if(@$reglementclient==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Reglementclients/index">
        <i class="fa fa-edit"></i> <span>Règlements </span>
    </a>
</li>
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Reglementclients/indexrl">
        <i class="fa fa-edit"></i> <span>Règlements libres</span>
    </a>
</li>
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Reglementclients/indexrpi">
        <i class="fa fa-edit"></i> <span>Règlements des Impayés</span>
    </a>
</li>
<?php //} ?>
<?php // if(@$affectation==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Affectations/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/bon.png" alt="" width="15px"/></i> <span>Affectations Reglements</span>
    </a>
</li>
<?php  } ?>
<?php if(@$piecereglementclient==1){?>
<li>
            <a href="#">
                <i class="fa fa-money"></i>
                <span>Etat de caisse</span>
            <b><i class="fa"></i></b></a>
            
    <ul style="display: block;">
    <li class="">
    <a class="" href="<?php echo $this->webroot;?>Piecereglementclients/cheque">
        <i class="fa fa-money"></i> <span>Etat des chèques</span>
    </a>
    </li>
    <li class="">
    <a class="" href="<?php echo $this->webroot;?>Piecereglementclients/traite">
        <i class="fa fa-money"></i> <span>Etat des traites</span>
    </a>
    </li>
    <li class="">
    <a class="" href="<?php echo $this->webroot;?>Piecereglementclients/index">
        <i class="fa fa-money"></i> <span>Engagement Client</span>
    </a>
    </li>
    </ul>
</li>
<?php } ?>
<?php if (@$releve == 1) { ?>
            <li class="">
                <a class="" href="<?php echo $this->webroot; ?>Releves/index">
                    <i ><img src="<?php echo $this->webroot; ?>assets/images/commande.png" alt="" width="15px"/></i> <span>Etat de solde client</span>
                </a>
            </li>
<?php  } ?>
<?php if(@$etatsoldecommandeclient==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Etatsoldecommandeclients/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/facture.jpg" alt="" width="15px"/></i> <span>Solde Commandes Clients</span>
    </a>
</li>
<?php } ?> 
<?php if(@$historiquearticle==1){?>   

<li class="">
    <a class="" href="<?php echo $this->webroot;?>Etathistoriquearticles/index">
         <i><img src="<?php echo $this->webroot;?>assets/images/commande.png" alt="" width="15px"/></i></i> <span>Historique Article</span>
    </a>
</li>
 <?php } ?>
<?php if(@$etatlignevente==1){?>   

<li class="">
    <a class="" href="<?php echo $this->webroot;?>Etatligneventes/index">
         <i><img src="<?php echo $this->webroot;?>assets/images/commande.png" alt="" width="15px"/></i></i> <span>Vente Journalier</span>
    </a>
</li>
 <?php } ?>
</ul>


<ul class="mainNav" id="divfinance" 
<?php if (in_array(strtolower($this->params['controller']), array('bordereaus','lignebordereaus','comptes','versements','sortiecaissees','caissees','carnetcheques','alimentations','caisseinternes','retenue','retenuefournisseur','etatvente','etatachat','engagementcomptes'))){ ?>
<?php }else{ ?> 
style="display:none;"
<?php } ?>    
>
<?php
$lien_finance=  CakeSession::read('lien_finance');
$n=0;
foreach($lien_finance as $k=>$liens){
	
        if(@$liens['lien']=='comptes'){
		$compte=1;
	}
        if(@$liens['lien']=='bordereaus'){
		$bordereau=1;
	}
        if(@$liens['lien']=='versements'){
		$versement=1;
	}
        if(@$liens['lien']=='sortiecaissees'){
		$sortiecaissee=1;
	}
   
        if(@$liens['lien']=='caissees'){
		$caisse=1;
	}
         if(@$liens['lien']=='retenue'){
		$retenue=1;
	}
        if(@$liens['lien']=='retenuefournisseur'){
		$retenuefournisseur=1;
	}
        if(@$liens['lien']=='etatvente'){
		$etatvente=1;
	}
        if(@$liens['lien']=='etatachat'){
		$etatachat=1;
	}
         if(@$liens['lien']=='carnetcheques'){
		$carnetcheque=1;
	}
         if(@$liens['lien']=='alimentations'){
		$alimentation=1;
	}
         if(@$liens['lien']=='interne'){
		$interne=1;
	}
}    
   ?> 
<?php  if(@$compte==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Comptes/index">
        <i ><img src="<?php echo $this->webroot;?>assets/images/compte.png" alt="" width="15px"/></i> <span>Compte</span>
    </a>
</li> 
<?php } ?>
<?php  if(@$compte==1){?>
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Engagementcomptes/index">
        <i ><img src="<?php echo $this->webroot;?>assets/images/compte.png" alt="" width="15px"/></i> <span>Engagement Compte</span>
    </a>
</li> 
<?php } ?>
<?php  if(@$carnetcheque==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Carnetcheques/index">
        <i ><img src="<?php echo $this->webroot;?>assets/images/cheques.jpg" alt="" width="15px"/></i> <span>Souche chequier</span>
    </a>
</li>
<?php } ?>
<?php  if(@$bordereau==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Bordereaus/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/bon.png" alt="" width="15px"/></i> <span>Bordereau</span>
    </a>
</li>
<?php } ?>
<?php  if(@$piecereglement==1){?>
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Bordereaus/indexpf">
        <i><img src="<?php echo $this->webroot;?>assets/images/bon.png" alt="" width="15px"/></i> <span>Engagement Fournisseur</span>
    </a>
</li>
<?php } ?>
<?php  if(@$piecereglementclient==1){?>
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Bordereaus/indexpc">
        <i><img src="<?php echo $this->webroot;?>assets/images/bon.png" alt="" width="15px"/></i> <span>Engagement Client</span>
    </a>
</li>
<?php } ?>
<?php  if(@$bordereau==1){?>
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Bordereaus/indexr">
        <i><img src="<?php echo $this->webroot;?>assets/images/bon.png" alt="" width="15px"/></i> <span>Retrait</span>
    </a>
</li>
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Bordereaus/tabledebord">
        <i><img src="<?php echo $this->webroot;?>assets/images/bon.png" alt="" width="15px"/></i> <span>Tableau de bord</span>
    </a>
</li>
<?php   } ?>
<?php  if(@$alimentation==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Alimentations/index">
        <i ><img src="<?php echo $this->webroot;?>assets/images/cheques.jpg" alt="" width="15px"/></i> <span>Alimentation caisse</span>
    </a>
</li>
<?php   } ?>
<?php  if(@$sortiecaissee==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Sortiecaissees/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/sortiecaisse.jpg" alt="" width="15px"/></i> <span>Sortie caisse</span>
    </a>
</li>
<?php   } ?>
<?php if(@$interne==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Caissees/interne">
        <i><img src="<?php echo $this->webroot;?>assets/images/caisse.png" alt="" width="15px"/></i> <span>Caisse interne</span>
    </a>
</li>
<?php   } ?>

<?php if(@$versement==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Versements/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/versement.png" alt="" width="15px"/></i> <span>Versement</span>
    </a>
</li>
<?php   } ?>
<?php   if(@$caisse==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Caissees/index">
        <i><img src="<?php echo $this->webroot;?>assets/images/caisse.png" alt="" width="15px"/></i> <span>Caisse</span>
    </a>
</li>
<?php   } ?>
<?php  if(@$retenue==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Caissees/retenue">
        <i><img src="<?php echo $this->webroot;?>assets/images/retenue.png" alt="" width="15px"/></i> <span>Retenue clients</span>
    </a>
</li>
<?php   } ?>
<?php  if(@$retenuefournisseur==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Caissees/retenuefournisseur">
        <i><img src="<?php echo $this->webroot;?>assets/images/retenue.png" alt="" width="15px"/></i> <span>Retenue fournisseurs</span>
    </a>
</li>
<?php   } ?>
<?php  if(@$etatvente==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Caissees/etatvente">
        <i><img src="<?php echo $this->webroot;?>assets/images/etatvente.png" alt="" width="15px"/></i> <span>Etat des Ventes </span>
    </a>
</li>
<?php   } ?>
<?php  if(@$etatachat==1){?> 
<li class="">
    <a class="" href="<?php echo $this->webroot;?>Caissees/etatachat">
        <i><img src="<?php echo $this->webroot;?>assets/images/etatvente.png" alt="" width="15px"/></i> <span>Etat des Achats </span>
    </a>
</li>
<?php   } ?>
</ul>


<ul class="mainNav" id="divstat" 
<?php if (in_array(strtolower($this->params['controller']), array('etatclients','etatclientarticles','etatarticles','etatpointdeventes','etatcaarticles','etatcaclientarticles','etatcapersonnels'))){ ?>
<?php }else{ ?> 
style="display:none;"
<?php } ?>      
>
     <?php 
$lien_parametrage=  CakeSession::read('lien_stat');
//debug($lien_parametrage);die;
$n=0;
foreach(@$lien_parametrage as $k=>$liens){
    if(@$liens['lien']=='etatclientarticles'){
		$etatclientarticle=1;
	}
	if(@$liens['lien']=='etatclients'){
		$etatclient=1;
	}
        if(@$liens['lien']=='etatarticles'){
		$etatarticle=1;
	}
        if(@$liens['lien']=='etatpointdeventes'){
		$etatpointdevente=1;
	}
        if(@$liens['lien']=='historiquearticles'){
		$historiquearticle=1;
	}
        if(@$liens['lien']=='etatcaarticles'){
		$etatcaarticle=1;
	}
        if(@$liens['lien']=='etatcaclientarticles'){
		$etatcaclientarticle=1;
	}
        if(@$liens['lien']=='etatcapersonnels'){
		$etatcapersonnel=1;
	}
}    
   ?> 
    <?php if(@$etatclient==1){?>   

<li class="">
    <a class="" href="<?php echo $this->webroot;?>Etatclients/index">
          <i ><img src="<?php echo $this->webroot;?>assets/images/commande.png" alt="" width="15px"/></i></i> <span>CA Par Client</span>
    </a>
</li>
 <?php } ?>
 <?php if($etatarticle==1){?>   

<li class="">
    <a class="" href="<?php echo $this->webroot;?>Etatarticles/index">
         <i><img src="<?php echo $this->webroot;?>assets/images/commande.png" alt="" width="15px"/></i></i> <span>CA Par Article</span>
    </a>
</li>
 <?php } ?>
 <?php if($etatpointdevente==1){?>   

<li class="">
    <a class="" href="<?php echo $this->webroot;?>Etatpointdeventes/index">
         <i><img src="<?php echo $this->webroot;?>assets/images/commande.png" alt="" width="15px"/></i></i> <span>CA Par Point De Vente</span>
    </a>
</li>
 <?php } ?>
 <?php if(@$etatclientarticle==1){?>   

<li class="">
    <a class="" href="<?php echo $this->webroot;?>Etatclientarticles/index">
         <i><img src="<?php echo $this->webroot;?>assets/images/commande.png" alt="" width="15px"/></i></i> <span>CA Par Client/Article</span>
    </a>
</li>
 <?php } ?>
<?php if(@$etatcaarticle==1){?>   

<li class="">
    <a class="" href="<?php echo $this->webroot;?>Etatcaarticles/index">
         <i><img src="<?php echo $this->webroot;?>assets/images/commande.png" alt="" width="15px"/></i></i> <span>CA Par Article/Exercice</span>
    </a>
</li>
 <?php } ?>
<?php if(@$etatcaclientarticle==1){?>   

<li class="">
    <a class="" href="<?php echo $this->webroot;?>Etatcaclientarticles/index">
         <i><img src="<?php echo $this->webroot;?>assets/images/commande.png" alt="" width="15px"/></i></i> <span>CA Par Client/Exercice</span>
    </a>
</li>
 <?php } ?>
<?php if(@$etatcapersonnel==1){?>   

<li class="">
    <a class="" href="<?php echo $this->webroot;?>Etatcapersonnels/index">
         <i><img src="<?php echo $this->webroot;?>assets/images/commande.png" alt="" width="15px"/></i></i> <span>CA Par personnel</span>
    </a>
</li>
 <?php } ?>
 
</ul>

</section>