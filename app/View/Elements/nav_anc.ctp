<audio id="chatAudio"><source src="<?php echo $this->webroot; ?>sounds/notify.ogg" type="audio/ogg"><source src="<?php echo $this->webroot; ?>sounds/notify.mp3" type="audio/mpeg"><source src="<?php echo $this->webroot; ?>sounds/notify.wav" type="audio/wav"></audio>   
  <script>
 $(document).ready(function() 
{
   notification(); 
})







function notification(){
 	  
	  
personnel= $('#user').val(); 

var prevCuisNotif=null;	
if(prevCuisNotif) {
            clearInterval(prevCuisNotif);
        }
prevCuisNotif = setInterval(function () {
$.ajax({
            type: "POST",
            data: {
                personnel: personnel
               
            },
            url: wr+"Deviprospects/notifdevis/",
            dataType : "json",
             global : false
        }).done(function(data){
 	     console.log(data); 
          //alert(data.nbdevis); 
               if((Number(data.nbdevis) > 0) && (Number(data.nbrworkflows) >0)){
                   
                ion.sound.play("bell_ring"); 
                $('#chatAudio')[0].play();
                nb=data.nbdevis;
                $('#spannotif').html(nb);
                var abc="";
            if(data.listedevis.length!=0){
            $.each(data.listedevis, function(i,item) {
               
                // console.log(item.id);
                abc+="<li><a href='<?php echo $this->webroot; ?>Deviprospects/edit/"+item.deviprospects.id+"?t=1'><div class='email-top-content'><strong>Suggestion Commande numéro: "+item.deviprospects.numero+" par fournisseur "+data.fournisseurs[item.deviprospects.fournisseur_id]+" dans la date "+item.deviprospects.date+" leur total est : "+item.deviprospects.totalttc+"</strong></div></a></li>";
            });
            }
            
			
         $('.notification').html(abc);
            }
			
 
		});	
},  2500);

    }
 </script>  
<?php 
$user=CakeSession::read('users');
echo'<input type="hidden" value="'.$user.'" id="user"/> ';
?>   
<div class="container-fluid">
<!--Logo text start-->
<div class="header-logo">
    <a href="#" title="">
        <h1 style="font-size: 15px !important">MTD GROUP</h1>
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
<ul>
    <li>
        <a href="<?php echo $this->webroot;?>Utilisateurs/login">
            <i class="fa fa-power-off"></i>
        </a>
    </li>

</ul>

<?php 

$p=CakeSession::read('users');
//debug($p);die;
$obj = ClassRegistry::init('Utilisateur');
$test = $obj->find('first',array('conditions'=>array('Utilisateur.id'=>$p),'recursive'=>2));
$nom=$test['Utilisateur']['login'];
$pvi=$test['Utilisateur']['pointdevente_id'];
if($pvi==0){
$pvn="Admin";
}else{
$pvn=$test['Pointdevente']['name'];
}
//debug($test);die;
?>
<ul>
    <li class="dropdown">
        
         <center>BienVenu</center><?php echo $nom.' ('.$pvn.')';?>
        
    </li>

</ul>

<ul>
<li class="dropdown">
        <!--All task drop down start-->
        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
            <span class="fa fa-tasks"></span>
            <span class="badge badge-lightBlue"></span>
        </a>
        
        
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
        <div class="dropdown-menu right top-dropDown-1">
            <h4>TOUT LES MENU</h4>
            <ul class="goal-item">
<?php  if(@$parametrage=='par'){?>
    <li><a   class="aff_divparametrage"><i ><span title="Parametrage">
    <div class="goal-user-image">
        <img src="<?php echo $this->webroot;?>assets/images/ico/fab.ico" alt="" width="20px"/>
    </div>
    <div class="goal-content">
    Parametrage
    </div>                
    </span></i></a></li>
<?php } ?>  
<?php  if(@$stock=='stk'){?>
    <li><a   class="aff_divstock"><i ><span title="Stock">
    <div class="goal-user-image">                
        <img src="<?php echo $this->webroot;?>assets/images/depot.png" alt="" width="20px"/>
    </div>
    <div class="goal-content">
    Stock
    </div>                
    </span></i></a></li>
<?php } ?>
<?php  if(@$achat=='ach'){ ?>
    <li><a  class="aff_divachat"><i ><span title="Achat">
    <div class="goal-user-image">
    <img src="<?php echo $this->webroot;?>assets/images/achat.png" alt="" width="20px"/>
    </div>
    <div class="goal-content">
    Achat
    </div>
    </span></i></a></li>
<?php } ?>
<?php  if(@$vente=='vnt'){ ?>
    <li><a  class="aff_divvente"><i ><span title="Vente">
    <div class="goal-user-image">
    <img src="<?php echo $this->webroot;?>assets/images/vente.png" alt="" width="20px"/>
    </div>
    <div class="goal-content">
    Vente
    </div>
    </span></i></a></li>
<?php } ?>
<?php  if(@$finance=='fnc'){ ?>
    <li><a  class="aff_divfinance"><i ><span title="Finance">
    <div class="goal-user-image">
    <img src="<?php echo $this->webroot;?>assets/images/finance.png" alt="" width="20px"/>
    </div>
    <div class="goal-content">
    Finance
    </div>
    </span></i></a></li>
<?php } ?>
<?php  if(@$stat=='stat'){?>
    <li><a  class="aff_divstat"><i ><span title="Statistique">
    <div class="goal-user-image">
    <img src="<?php echo $this->webroot;?>assets/images/telechargement.png" alt="" width="20px"/>
    </div>
    <div class="goal-content">
    Statistique
    </div>
    </span></i></a></li>
<?php } ?>
  
                
   </ul>
        </div>
    </li>
           
<!--Top Navigation End-->

<ul>
<li class="dropdown">
        
        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
            <span class="fa fa-envelope-o"></span>
            <span class="badge badge-red" id="spannotif">0</span>
        </a>

        <div class="dropdown-menu right email-notification" style="height: 500px; overflow-y: scroll;">
            <h4>Notification</h4>
            <ul class="email-top notification">
                
            </ul>
        </div>
        
</li>
</ul>

</div>
</div>