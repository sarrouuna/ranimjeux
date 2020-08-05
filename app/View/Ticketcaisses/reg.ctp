 	<script src="<?php echo $this->webroot;?>assets/js/jquery.min.js"></script>
<script language="JavaScript">



function  EW_checkMyForm(EW_this) {
 //alert(Number(document.getElementById('total-hidden-charges').value)+50);
 
 if(document.getElementById('Montant_Payer').value>(Number(document.getElementById('total-hidden-charges').value)+50))
{
	bootbox.alert("Veuillez verifer vore montant   !!!!", function (){});
                return false;
//	alert('Veuillez saisir le montant � payer'); return false; 
} 
 
  
if(document.getElementById('Montant_Payer').value=='0')
{
	bootbox.alert("Veuillez saisir le montant � payer !!!!", function (){});
                return false;
//	alert('Veuillez saisir le montant � payer'); return false; 
} 

 if(Number(document.getElementById('Montant_Payer').value)<Number(document.getElementById('total-hidden-charges').value))
{
	bootbox.alert("Montant Payer inf�rieur au total !!!!", function (){});
                return false;
//	alert('Veuillez saisir le montant � payer'); return false; 
} 
document.getElementById('btnnone').style.display='none';

return true;
}

function mode()
{
var max3=document.getElementById('max').value;
	var pai=0;

for(i=0;i<=max3;i++)
{
	if(document.getElementById('mo'+i).checked==true)
	{
pai=pai+',-'+document.getElementById('mo'+i).value+'-';

check=document.getElementById('mo'+i).value;
	}
}
document.getElementById('paiement_id').value=pai;
 
 if( pai.indexOf('-14-')!= -1 )
 {
 
document.getElementById('modec').style.display='';	

} 
else
{
 document.getElementById('modec').style.display='none';	
  $('#Montant_Piecec').val(0);
}
 
if(pai.indexOf('-2-')!=-1   )
 {
 
document.getElementById('modee').style.display='';	

} 
else
{
 document.getElementById('modee').style.display='none';	
  $('#Montant_Piece').val(0);
}
    if(pai.indexOf('-1-')!= -1    )
 {
 document.getElementById('modefa').style.display='';	
  }  
 else
 {	 
 
 document.getElementById('modefa').style.display='none';	
 $('#Montant').val(0);
	 
 }

     if(pai.indexOf('-15-')!= -1  )
 {
	 
 document.getElementById('modet').style.display='';	
 }
 else
 {	   
 document.getElementById('modet').style.display='none';	

	 $('#Montant_Ticket').val(0); 
 }
   
  
calculereg();
}
$(document).ready(function(e) {
   $('#Montant').focus();
     $.ajax({
           type: "POST",
            url:"<?php echo $this->webroot;?>ticketcaisses/host",
            dataType : "json"
        }).done(function(data){
           $.ajax({
           type: "POST",
            url:"http://"+data[1]+"/pole.php",
            data:"val=<?php echo  $Total_TTC;?>&type=prix&com="+data[0],
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

                 
                            
              	 <div class="col-md-12">
          
         
 <div class="col-md-6"> 
           
                       
                               <?php
	 	echo $this->Form->input('paiement_id',array( 'type'=>'hidden','div'=>'form-group' ,'id'=>'paiement_id','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control','value'=>'-1-' ) );
		//echo $this->Form->input('Numero',array( 'type'=>'','readonly'=>'true','value'=>$mm,'div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control') );
			echo $this->Form->input('Nbre Point',array( 'type'=>'hidden' ,'name'=>'data[Ticketcaisse][point]','readonly'=>'true' ,'value'=>$point,  'div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control') );
			echo $this->Form->input('numerocarte',array( 'id'=>'numerocarte','readonly'=>'true' ,   'div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control') );
			echo $this->Form->input('cartefidelite',array('name'=>'data[Ticketcaisse][cartefidelite_id]','value'=>0,'id'=>'cartefidelite_id','type'=>'hidden' ,   'div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control') );
			?>
            <div id="client" align="center" style="color:#FF0000; font-family:Arial, Helvetica, sans-serif; font-size:16px"></div>
            
            <?php
		echo $this->Form->input('Total_TTC',array( 'readonly'=>'true' ,'value'=>$Total_TTC,'id'=>"total-hidden-charges", 'div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('Montant_Payer',array('readonly'=>true,'id'=>"Montant_Payer",'onkeyup'=>'calculereg()', 'div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('Rest',array( 'readonly'=>'true' ,'value'=>0.000,'id'=>"rest", 'div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control') );
		
	// echo $this->Form->input('mode_id',array('label'=>' Mode ','onchange'=>'mode()','value'=>'1','id'=>'mo','div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>' select form-control','multiple'=>"multiple") );
		
	 
	 ?>    
     
   <div class="col-sm-12" align="center">  <?php 
 
	 foreach ($modes as $key => $m) { ?>
                                    <input  id="mo<?php echo $key?>" name="data[Ticketcaisse][mode_id][]"   onclick="mode()"  type="checkbox" <?php if($m['Paiementcaisse']['id']==1) {?> checked="checked" <?php }?>  value="<?php echo $m['Paiementcaisse']['id']; ?>" style="width:25px; height:25px; position:relative" >  <font style="position:relative" size="2"><?php echo $m['Paiementcaisse']['name']; ?>&nbsp;&nbsp;</font>
                                       
                                    <?php } ?>
                                    <input type="hidden" value="<?php echo $key;?>" id="max" />
                                   </div> <br />     <br />
     <div style="width:100%; " id="modefa" style="display:none"  > 
 <?php

		 echo $this->Form->input('Montant',array('label'=>' Montant Esp&eacute;ce','id'=>'Montant','div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control','onkeyup'=>'calculereg()') );
		
	?>   
         
                         </div>
      
       <div style="width:100%; display:none" id="modee"  > 
 <?php

		echo $this->Form->input('piece',array('label'=>'  Num&eacute;ro Pi&eacute;ce','id'=>'piece','div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control') );
		 echo $this->Form->input('Montant_Piece',array('label'=>' Montant Pi&eacute;ce ','id'=>'Montant_Piece','div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control','onkeyup'=>'calculereg()') );
		
	?>   
         
                         </div>
                          <div style="width:100%; display:none" id="modec"  > 
 <?php

		echo $this->Form->input('piecec',array('label'=>'  Num&eacute;ro Ticket Carte','id'=>'piecec','div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control') );
		 echo $this->Form->input('Montant_Piecec',array('label'=>' Montant  ','id'=>'Montant_Piecec','div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control','onkeyup'=>'calculereg()') );
		
	?>   
         
                         </div>
                           <div style="width:100%; display:none" id="modet"  > 
<?php 
 echo $this->Form->input('Montant_Ticket',array('readonly'=>true,'label'=>' Montant Ticket','id'=>'Montant_Ticket','div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control') );
		

?>
 <table align="75%" style="border:hidden !important" class="table" id="tabcontact">
 
  <tr class="tr" style="border:1px solid rgb(221, 221, 221);display:none" ><td><?php
 	
 echo $this->Form->input('Prix_Ticket',array('label'=>' Prix Ticket ','autofocus','index'=>"0" ,'table'=>'Detailticket','champ'=>"Prix_Ticket" ,'onkeyup'=>'calculereg()','div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'ticket') );?></td>
 <td><?php
		echo $this->Form->input('Nombre_Ticket',array('label'=>' NB:','style'=>'width:45px' ,'table'=>'Detailticket','champ'=>"Nombre_Ticket" ,'value'=>1,'id'=>'Nombre_Ticket','onkeyup'=>'calculereg()','div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>'form-control') );
			
	?>   </td>
      </tr>
      <tr><td><?php
 echo $this->Form->input('Prix_Ticket',array('label'=>' Prix Ticket ','name'=>'data[Detailticket][0][Prix_Ticket]','id'=>'Prix_Ticket0','index'=>"0"  ,'table'=>'Detailticket','champ'=>"Prix_Ticket" ,'onkeyup'=>'calculereg()','div'=>'form-group','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>' ticket form-control') );?></td>
 <td><?php
		echo $this->Form->input('Nombre_Ticket',array('label'=>' NB:','champ'=>"Nombre_Ticket" ,'table'=>'Detailticket','style'=>'width:45px','value'=>1,'id'=>'Nombre_Ticket0','onkeyup'=>'calculereg()','div'=>'form-group','name'=>'data[Detailticket][0][Nombre_Ticket]','between'=>'<div class="col-sm-6">','after'=>'</div>','class'=>' ticket form-control') );
			
	?>   </td>
   
    </tr>
                                                                                     <input type="hidden" id="index" value="0">

       
    
    </table> 
         
                         </div>
                     
                              
                            </div>  
                               
           <div class="col-md-6">
                <div class="detailticketdata">
                    <div id="btnnone">
                        
 <button  onclick="document.myform.submit()" style="height:85px; width:85px" class=" submitForm"  id="butonsubmit"data-style="expand-right" data-size="l"  ><img src="<?php echo $this->webroot;?>img/caisse.png"  /></button>                                            
                    
                       
                             <input type="hidden" name="maxcommande" id='maxcommande' value="0">
   <input type="hidden"  id='ip' value="<?php echo  $ip;?>">
                            <input type="hidden"   id='com' value="<?php echo  $com;?>">
                            
</div></div></div>              <div align="center" style="margin-top:85px; font-size:85px"> 
 
 <span id="totvalue"><?php echo $Total_TTC;?></span></div>
                           
                       
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

