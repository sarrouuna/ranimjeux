<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <script type='application/javascript'>
	window.timer = (function()
	{
		var impl = { } ;
		impl.reference = null;
		impl.start = function() { impl.reference = new Date };
		impl.setReference = function() { impl.reference = arguments[0] } ;
		impl.getElapsedTime = function()
		{
			var now = new Date ;
			var elapsed = Math.round((now.getTime() - this.reference.getTime()) / 1000) ;

			return { days: 0
				, hours: 0
				, minutes: 0
				, seconds: elapsed
			} ;
		} ;

		var proto = function() {};
		proto.prototype = impl;
		return proto ;
	})();

	var init = function()
	{
		var clock = new timer ;
		clock.setReference(new Date) ;
		var element = document.getElementById('clock') ;

		var fn = function() {
			var elapsed = clock.getElapsedTime() ;
			element.textContent = elapsed.seconds + ' secondes' ;
			setTimeout(fn, 1000);
		}
		fn();
	}

	addEventListener('load', init) ;
	</script>
  </head>
  <body>
    Depuis <span id='clock'></span>
  </body>
</html>

<style >
.MsgAlert
{
left:40%;
top:40%;
position:relative;
width:200px;
background:url(gfx/content00.gif) repeat-y;
cursor:default;
}

.header
{
 margin-top:-20%;
} 

.bottom 
{
margin-top:3%;
}

.MsgAlert p 
{
margin-top: 0%; 
font-family:Arial; 
font-size:14px;
 text-align:center; 
color:white; 
padding-left:10px; 
padding-right:10px;
} 

.MsgAlert input 
{
margin-top: 3%;
border:none;
height:24px;
width:80px;
background:url(gfx/boutton_valider.gif);
cursor: pointer;
}

.MsgAlert input:hover 
{
margin-top: 3%;
border:none;
height:24px;
width:80px;
background:url(gfx/boutton_valider_hover.gif);
cursor:pointer;
} 
 </style>

 
 
 <script src="<?php echo $this->webroot;?>assets/js/jquery.min.js"></script>
<script language="JavaScript">



function  EW_checkMyForm(EW_this) {
  if(document.getElementById('maxcommande').value=='0')
{
	bootbox.alert("Veuillez selectioner au moins un article  !!!!", function (){});
             $('.ghazi').focus();
			    return false;
	//alert('Il faut au moins un article S�lectionn�'); return false; 
	
} 
document.getElementById('btnnone').style.display='none';

return true;
}
  
$(document).ready(function(e) {
     $.ajax({
           type: "POST",
            url:"<?php echo $this->webroot;?>ticketcaisses/host",
            dataType : "json"
        }).done(function(data){
		
           $.ajax({
           type: "POST",
            url:"http://"+data[1]+"/pole.php",
            data:"type=welcome&com="+data[0],
            dataType : "HTML"
        }).done(function(data){
          
        });
        });
 
});	
	
 
</script>  
 
 <div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Passation Caisse '); ?></h3>
                                    <span style="text-align:right; padding-left:950px; font-family:Arial, Helvetica, sans-serif; color:#F00; font-size:14px" >Fond Caisse <?php echo  date('d/m/Y');?> : <?php echo   $fond; ?></span>
                                </div>
                                
                

                                <div class="panel-body" >
         <?php echo $this->Form->create('Ticketcaisse',array('onload'=>'cal()','autocomplete' => 'off','class'=>'submitForm form-horizontal ls_form','onSubmit'=>"return EW_checkMyForm(this)",'id'=>'myform defaultForm ','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

                 
                                    <input type="hidden" id="TicketcaisseEnattente" name="data[Ticketcaisse][enattente]" champ='enattente' table='Ticketcaisse'  value="0">     
              	 <div class="col-md-12">
          
          
           <div class="col-md-9">
                <div class="detailticketdata">
                    <div class="semidetailticketdata">
                        <ul class="ligneticketdata" id="commandlistitems"></ul>

                       
                        <table    style="width: 100%; border:none" cellpadding="8" cellspacing="8">
                            <input type="hidden" name="maxcommande" id='maxcommande' value="0">
   <input type="hidden"  id='ip' value="<?php echo  $ip;?>">
                            <input type="hidden"   id='com' value="<?php echo  $com;?>">
                            <tr >	
                                <td colspan="5">
                                    <table>

                                        <tr id="inputcodebarre" style="display:'';" > 
                                            <td  align="left" nowrap="nowrap">  
                                                <?php echo $this->Form->input('name', array('style' => 'width:400px', 'id' => 'nameart', 'empty' => 'Veuillez Choisir un Article', 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ghazi')); ?>
                                            </td>
                                            <td> 
                                                <img src="<?php echo $this->webroot; ?>img/rech.png"   class="afficheselect"  />
                                            </td>
                                        </tr>
                                        <tr id="select" style="display:none;" >
                                            <td  align="left" nowrap="nowrap">  
                                                <?php echo $this->Form->input('article_id', array('style' => "width:400px;", 'empty' => 'Veuillez Choisir un Article', 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control ghazi select'));?>
                                            </td>
                                            <td> 
                                                <img src="<?php echo $this->webroot; ?>img/code.png" class="afficheinput"    />
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                        <!--<td align="left"> <input  id="balance" name="data[Ticketcaisse][balance] "   onclick="document.getElementById('nameart').focus()"    type="checkbox"    value="1" style="width:25px; height:25px; position:relative" >Balance</td>-->
                                <td></td>
                                <td align="center"   colspan="2" id="btnnone">    
                                    <button    onclick=" alert(); document.myform.submit() " style="height:85px; width:85px" 
                                               class=" submitForm btn btn-default"  id="butonsubmit" data-style="expand-right" data-size="l"  >
                                        <img src="<?php echo $this->webroot; ?>img/caisse.png"  /></button>                                            
                                </td>

                                <td>
<?php
$ModelTicketcaisse = ClassRegistry::init('Ticketcaisse');
$ModelTicketcaisseligne = ClassRegistry::init('Ticketcaisseligne');
$exist_attente = $ModelTicketcaisse->find('count', array('conditions' => array('Ticketcaisse.enattente' => 1)));
//debug($exist_attente);
if ($exist_attente == 0) {
    ?>
                                        <button    id="mettreenattente"  >
                                            <img src="<?php echo $this->webroot; ?>img/attente.png" style="height:70px; width:70px"   />
                                            <span>Mettre En Attente</span>
                                        </button>   
<?php
}

if ($exist_attente != 0) {
    $ticket_attente = $ModelTicketcaisse->find('first', array('conditions' => array('Ticketcaisse.enattente' => 1)));
    $nbligne = $ModelTicketcaisseligne->find('count', array('conditions' => array('Ticketcaisseligne.ticketcaisse_id' => $ticket_attente['Ticketcaisse']['id'])));
    //debug($ticket_attente);
    ?>
                                    <input type="hidden" name="data[Ticketcaisse][ticket_repr]" id="ticket_repr" value="<?php echo $ticket_attente['Ticketcaisse']['id']; ?>">
                                        <input type="hidden" id="nbligne" value="<?php echo $nbligne; ?>">
                                        <input type="hidden" id="ttc" value="<?php echo $ticket_attente['Ticketcaisse']['Total_TTC']; ?>">

                                        <div id="btnreprendre" >
                                            <img src="<?php echo $this->webroot; ?>img/rep.png" style="height:70px; width:70px" id="rep"  />
                                            <span>Reprendre</span>
                                        </div>

<?php } ?>



                                </td>                   


                            </tr>
                        </table>
                        <br /><br /> <div style="width:100%; height:400px; overflow: scroll;"  >

                            <table class="commande table" id='commande' style="width: 100%; border:none" cellpadding="8" cellspacing="8">

                                <tr class='th'>
                                    <td align='center' style="background-color: #FE9A2E;color: #000">Article</td>
                                    <td align='center' style="background-color: #FE9A2E;color: #000">Prix</td>
                                    <td align='center' style="background-color: #FE9A2E;color: #000">Qt&eacute;</td>
                                    <td align='center' style="background-color: #FE9A2E;color: #000">Total</td>
                                    <td align='center' style="background-color: #FE9A2E;color: #000" width="10%"> </td>
                                   <!-- <td align='center'></td>-->
                                    <td align='center' style="background-color: #FE9A2E;color: #000"></td>

                             <!--  <td colspan="3" align="right"> <font face="Arial, Helvetica, sans-serif" color="#FF0000" size="3"><b><i>Total :</i></b> <span id="totvalue">0.000</span></font>
</td>-->

                                </tr>

                                
                                
                                <tfoot id="tab_recap">
                                    
                                </tfoot>
                                
                                
                                
                                
                                <tr class="type"  id="type"  champ='type' table='Lignecommande' index=''  style="display: none; height:85px">

                                    <td champ='td' index='' align='left'><div champ="divproduit"></div> 


                                        <input type="hidden" champ='des' table='Lignecommande' index='' value="0">
                                        <input type="hidden" champ='produit' table='Lignecommande' index='' value="0">
                                        <input type="hidden" champ='composant_id' table='Lignecommande' index='' value="0">
                                        <input   table='Lignecommande' type='hidden'champ='ttprix'   index='' style="width:75px; text-align:center"  class="form-control"   />
                                        <input   table='Lignecommande' type='hidden'champ='ttqte' value="1"  index=''  style="width:75px; text-align:center"   class="form-control"   />

                                        <input   table='Lignecommande' type='hidden' champ='ttcmd' index=''  style="width:75px; text-align:center"   class="form-control"   />

                                    </td>
                                    <td align='right'> <div champ="divprix"></div>  <input type="hidden"  champ='prix' table='Lignecommande' index='' value="0"></td>
                                    <td align='center'> <!--<div champ="divqte" ></div>  -->
                                        <input type="" champ='qte' table='Lignecommande' readonly="readonly" index='' style="width:80px" value="1" class="form-control qtt" onkeyup="calcule()">   <input type="hidden" champ='anc' table='Lignecommande' readonly="readonly" index='' style="width:80px" value="" class="form-control anc"  > <input type="hidden" champ='promotion' table='Lignecommande' index='' style="width:50px" value="0" class="form-control" > </td>
                                    <td align='right'> <div champ="divtotal"></div>  <input type="hidden" champ='total' table='Lignecommande' index='' value="0"></td>
                                    <td align='center' champ='plus'   index='' >
    <!--                                    <div   style="width:45px; height:35px ; padding-top:8px"  index='0' class="plus  btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i></div> -->
                                    </td>
                                                                 <!--<td align='center'  champ='moin'   index='0'> <div     style="width:45px; height:35px;  padding-top:8px" index='0' class="moin btn btn-xs btn-warning"><i class="glyphicon glyphicon-minus"></i></div> </td>-->
                                    <td align='center'  champ='sup1'   index=''> <div    style="width:45px; height:35px; padding-top:8px" index='' class=" sup1 btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></div>  </td>

                                </tr> 


                            </table>
                        
                        </div>
               <div id="promo" champ='promo'  colspan="7"  style="display:'hidden'"  ></div>         
                       
</div></div></div>
 <div class="col-md-3" align="center" style="margin-top:175px; font-size:85px"> 
 
     <span id="totvalue" style="color: #819FF7">0.000</span>
 
 
           
                       
                               <?php
	 	echo $this->Form->input('paiement_id',array( 'type'=>'hidden','div'=>'form-group' ,'id'=>'paiement_id','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control','value'=>'-1-' ) );
	//	echo $this->Form->input('Numero',array( 'type'=>'','readonly'=>'true','value'=>$mm,'div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('Total_TTC',array( 'type'=>'hidden' ,'value'=>0,'id'=>"total-hidden-charges", 'div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control') );
		//echo $this->Form->input('Montant_Payer',array( 'value'=>0.000,'readonly'=>true,'id'=>"Montant_Payer",'onkeyup'=>'calcule()', 'div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control') );
	//	echo $this->Form->input('Rest',array( 'readonly'=>'true' ,'value'=>0.000,'id'=>"rest", 'div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control') );
		
	// echo $this->Form->input('mode_id',array('label'=>' Mode ','onchange'=>'mode()','value'=>'1','id'=>'mo','div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>' select form-control','multiple'=>"multiple") );
		
	 
	 ?>    
     
     <br />     <br />
      
      
        
                           
                           
                     
                              
                            </div>  
                               
                       
                           
                       
                        </div>





                       
                       
                    </div>


         
                <div class="ticket_remerciment" style="display: none;">*** Merci pour votre visite ***</div>

                <div class="totcontainer">
                    <!--                    <div class="total_lib_caisse">Total <div id="totvalue" class="totvalue"></div></div>
                                        <div class="total_lib_caisse" style="display: none">Pay� <div id="totpaye" class="totvalue"></div></div>
                                        <div class="total_lib_caisse" style="display: none">Rendu <div id="totrendu" class="totvalue"></div></div>-->
                </div>
            </div>
           <?php
		// ticker
        ?>
           
  </div>       
                                      

<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

