<?php
$obj = ClassRegistry::init('Journee');
$fond = ClassRegistry::init('Fond');
$dpo= CakeSession::read('dpo');
 $personnel_id= CakeSession::read('personnel_id');
$jrs=$obj->find('first',array('conditions'=>array('Journee.depot_id'=>$dpo,'Journee.etat'=>0)));
 
   if(!empty($jrs)) {
	   
$fondo=$fond->find('count',array('conditions'=>array('Fond.personnel_id' => $personnel_id,'Fond.journee_id'=>$jrs['Journee']['id'],'Fond.etat'=>0)));
$fondd=$fond->find('first',array('conditions'=>array('Fond.personnel_id' => $personnel_id,'Fond.journee_id'=>$jrs['Journee']['id'],'Fond.etat'=>0)));
                   CakeSession::write('Fond', @$fondd['Fond']['fond']);

  
   }
   else 
   $fond=0;
?> <script language="javascript">
  function Horloge() {
     <?php 
	 
	 if( !empty($jrs) && $fondo!=0)
	 {
	 ?>
	 
document.location="<?php echo $this->webroot;?>Ticketcaisses/add";
 
  <?php 
	 }
	else {
	  
	 ?>
document.location="<?php echo $this->webroot;?>Ticketcaisses/accueil";
<?php }?>
   }
 </script>
<br>
<div class="row" ><body onload='setInterval("Horloge()", 1000);'>
         <br><br>
                  <br><br>

                  <br><br>
         <br><br>
      <br><br>
         <br><br>
         <center >
             <font face="Arial, Helvetica, sans-serif" size="24px" color="#FF0000"> En Attente D'ouvrir Une Journée    </font></center>
</div>
                         
