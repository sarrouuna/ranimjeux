
$(document).ready(function(){
    
//*************************
  $('.editmodereglementclient').on('change',function(){
 index= $(this).attr('index');  
 val=$(this).val(); // alert(val);
console.log(index);
 if(Number(val)==1){
    // alert();
   //$('#trechance'+index).attr('class','') ;
   $('#trmontantbruta'+index).hide() ;
   $('#trmontantbrutb'+index).hide() ;
   $('#trmontantneta'+index).hide() ;
   $('#trmontantnetb'+index).hide() ;
   $('#trtauxa'+index).hide() ;
   $('#trtauxb'+index).hide() ;
   $('#trechancea'+index).hide() ;
   $('#trechanceb'+index).hide() ;
   $('#trbanquea'+index).hide();
   $('#trbanqueb'+index).hide();
   // $('#trnum'+index).attr('class','') ;
   $('#trnuma'+index).hide() ;
   $('#trnumb'+index).hide() ;
   $('#banque_idb'+index).hide() ;     // modifiction amin pr pag mpreglement
   $('#banque_ida'+index).hide() ;// modifiction amin
   $('#trcarnetnuma'+index).hide() ;
   $('#trcarnetnumb'+index).hide() ;
   $('#divnumc'+index).hide() ;
   $('#divnump'+index).hide() ;
   
   $('#trechance'+index).hide();
 }else if (Number(val)==5) {
    // alert(index);
   $('#trmontantbruta'+index).show();
   $('#trmontantbrutb'+index).show();
   $('#trmontantneta'+index).show();
   $('#trmontantnetb'+index).show();
   $('#trtauxa'+index).show();
   $('#trtauxb'+index).show();
    $('#trmontantnet'+index).show();
    $('#trtaux'+index).show(); 
    $('#trmontantbrut'+index).show();
    $('#trechance'+index).hide() ;
   $('#trechancea'+index).hide() ;
   $('#trechanceb'+index).hide() ;
   $('#trbanquea'+index).hide();
   $('#trbanqueb'+index).hide();
   // $('#trnum'+index).attr('class','') ;
    $('#trnum'+index).show() ;
    $('#trnuma'+index).show() ;
    $('#trnumb'+index).show() ;
    $('#banque_idb'+index).hide() ;     // modifiction amin pr pag mpreglement
    $('#banque_ida'+index).hide() ;
    $('#trcarnetnuma'+index).hide() ;
    $('#trcarnetnumb'+index).hide() ;
    $('#trcarnetnuma'+index).hide() ;
    $('#trcarnetnumb'+index).hide() ;
    $('#divnumc'+index).hide() ;
    $('#divnump'+index).show() ;
    $('#num_piece'+index).show() ;
     ttpayer=$('#ttpayer').val();
    $('#montantbrut'+index).val(ttpayer);
     
 }else if (Number(val)==6) {
    
      
      
   $('#trmontantbruta'+index).hide();
   $('#trmontantbrutb'+index).hide();
   $('#trmontantneta'+index).hide();
   $('#trmontantnetb'+index).hide();
   $('#trtauxa'+index).hide();
   $('#trtauxb'+index).hide();
    $('#trmontantnet'+index).hide();
    $('#trtaux'+index).hide(); 
    $('#trmontantbrut'+index).hide();
    $('#trechance'+index).hide() ;
   $('#trechancea'+index).hide() ;
   $('#trechanceb'+index).hide() ;
   $('#trbanquea'+index).hide();
   $('#trbanqueb'+index).hide();
   // $('#trnum'+index).attr('class','') ;
    $('#trnum'+index).show() ;
    $('#trnuma'+index).show() ;
    $('#trnumb'+index).show() ;
    $('#banque_idb'+index).hide() ;     // modifiction amin pr pag mpreglement
    $('#banque_ida'+index).hide() ;
    $('#trcarnetnuma'+index).hide() ;
    $('#trcarnetnumb'+index).hide() ;
    $('#trcarnetnuma'+index).hide() ;
    $('#trcarnetnumb'+index).hide() ;
    $('#divnumc'+index).show() ;
    $('#divnump'+index).hide() ;
    clientid=$('#clientid').val();
     // alert(index);
     // alert(clientid);
      getfactureavoirs(index,clientid);
     
 }else{
    // alert(index);
    $('#trmontantbruta'+index).hide() ;
   $('#trmontantbrutb'+index).hide() ;
   $('#trmontantneta'+index).hide() ;
   $('#trmontantnetb'+index).hide() ;
   $('#trtauxa'+index).hide() ;
   $('#trtauxb'+index).hide() ;
   //******************
   $('#trbanque'+index).show();
    $('#trechance'+index).show();
    $('#trnum'+index).show() ;
   //******************
   $('#trcarnetnuma'+index).hide() ;
   $('#trcarnetnumb'+index).hide() ;
   $('#divnumc'+index).hide() ;
   $('#trechancea'+index).show();
   $('#trechanceb'+index).show();
   $('#trbanquea'+index).show();
   $('#trbanqueb'+index).show();
   //$('#trechance'+index).attr('class','display:none') ;
    $('#trnum'+index).show() ;
    $('#trnuma'+index).show() ;
    $('#trnumb'+index).show() ;
    $('#divnumc'+index).hide() ;
    $('#divnump'+index).show() ;
 }
});
    
//***********************    
    $('.editmodereglement').on('change',function(){
 index= $(this).attr('index');  
 val=$(this).val(); // alert(val);
console.log(index);
 if(Number(val)==1){
    // alert();
   //$('#trechance'+index).attr('class','') ;
   $('#trmontantbruta'+index).hide() ;
   $('#trmontantbrutb'+index).hide() ;
   $('#trmontantneta'+index).hide() ;
   $('#trmontantnetb'+index).hide() ;
   $('#trtauxa'+index).hide() ;
   $('#trtauxb'+index).hide() ;
   $('#trechancea'+index).hide() ;
   $('#trechanceb'+index).hide() ;
   $('#trbanquea'+index).hide();
   $('#trbanqueb'+index).hide();
   // $('#trnum'+index).attr('class','') ;
   $('#trnuma'+index).hide() ;
   $('#trnumb'+index).hide() ;
   $('#banque_idb'+index).hide() ;     // modifiction amin pr pag mpreglement
   $('#banque_ida'+index).hide() ;// modifiction amin
   $('#trcarnetnuma'+index).hide() ;
   $('#trcarnetnumb'+index).hide() ;
   $('#divnumc'+index).hide() ;
   $('#divnump'+index).hide() ;
   
   $('#trechance'+index).hide();
 }else if (Number(val)==2){
    //alert(index);
   $('#trmontantbruta'+index).hide() ;
   $('#trmontantbrutb'+index).hide() ;
   $('#trmontantneta'+index).hide() ;
   $('#trmontantnetb'+index).hide() ;
   $('#trtauxa'+index).hide() ;
   $('#trtauxb'+index).hide() ;
   $('#trechancea'+index).show();
   $('#trechanceb'+index).show();
   $('#trbanquea'+index).hide();
   $('#trbanqueb'+index).hide();
   $('#banque_idb'+index).hide() ;          // modifiction amin  
   $('#banque_ida'+index).hide() ;          // modifiction amin   
   $('#trnuma'+index).show() ;
   $('#trnumb'+index).show() ;
   /////************
    $('#trechance'+index).show();
    $('#trnum'+index).show();
    $('#trcarnetnum'+index).show();
    
    //ajouter select carnet
   $('#trcarnetnuma'+index).show() ;
   $('#trcarnetnumb'+index).show() ;
   $('#divnumc'+index).hide() ;
   $('#divnump'+index).show() ;
   
 }else if (Number(val)==5) {
    // alert(index);
   $('#trmontantbruta'+index).show();
   $('#trmontantbrutb'+index).show();
   $('#trmontantneta'+index).show();
   $('#trmontantnetb'+index).show();
   $('#trtauxa'+index).show();
   $('#trtauxb'+index).show();
    $('#trmontantnet'+index).show();
    $('#trtaux'+index).show(); 
    $('#trmontantbrut'+index).show();
    $('#trechance'+index).hide() ;
   $('#trechancea'+index).hide() ;
   $('#trechanceb'+index).hide() ;
   $('#trbanquea'+index).hide();
   $('#trbanqueb'+index).hide();
   // $('#trnum'+index).attr('class','') ;
   $('#trnuma'+index).show() ;
   $('#trnumb'+index).show() ;
    $('#banque_idb'+index).hide() ;     // modifiction amin pr pag mpreglement
    $('#banque_ida'+index).hide() ;
    $('#trcarnetnuma'+index).hide() ;
    $('#trcarnetnumb'+index).hide() ;
    $('#trcarnetnuma'+index).hide() ;
    $('#trcarnetnumb'+index).hide() ;
    $('#divnumc'+index).hide() ;
    $('#divnump'+index).show() ;
     ttpayer=$('#ttpayer').val();
    $('#montantbrut'+index).val(ttpayer);
     
 }else{
    // alert(index);
    $('#trmontantbruta'+index).hide() ;
   $('#trmontantbrutb'+index).hide() ;
   $('#trmontantneta'+index).hide() ;
   $('#trmontantnetb'+index).hide() ;
   $('#trtauxa'+index).hide() ;
   $('#trtauxb'+index).hide() ;
   //******************
   $('#trbanque'+index).show();
    $('#trechance'+index).show();
    $('#trnum'+index).show() ;
   //******************
   $('#trcarnetnuma'+index).hide() ;
   $('#trcarnetnumb'+index).hide() ;
   $('#divnumc'+index).hide() ;
   $('#trechancea'+index).show();
   $('#trechanceb'+index).show();
   $('#trbanquea'+index).show();
   $('#trbanqueb'+index).show();
   //$('#trechance'+index).attr('class','display:none') ;
    $('#trnuma'+index).show() ;
    $('#trnumb'+index).show() ;
    $('#divnump'+index).show() ;
    //$('#trnum'+index).attr('class','display:none') ;  
 }
});

/////////////////////////select banque / select situation  fournisseur/////////////////////
$('.selectbanq1,.selectstut1').on('change',function(){
            index=$(this).attr('val');
            societe=$('#compte_id'+index).val();
            situation=$('#stut'+index).val();
            date=$('#date').val();
            datecheque=$('#echeance'+index).val();
            if(datecheque>date){
                var r = confirm("Echéance supérieur à la date d'aujourd'hui!");
                if (r == true) {
                 if(((societe!='') && (situation!='En attente'))||((societe=='') && (situation=='En attente'))){
                 $.ajax({
            type: "POST",
            url: wr+"Piecereglements/select/"+societe+"/"+situation+"/"+index,
            dataType : "JSON"
                }).done(function(data){
          
               });
            }
                } 
            }else{ 
            if(((societe!='') && (situation!='En attente'))||((societe=='') && (situation=='En attente'))){
                 $.ajax({
            type: "POST",
            url: wr+"Piecereglements/select/"+societe+"/"+situation+"/"+index,
            dataType : "JSON"
        }).done(function(data){
          
        });
            }}
        });
        
/////////////////////////select banque / select situation  client/////////////////////
$('.selectbanq,.selectstut').on('change',function(){
            index=$(this).attr('val');
            societe=$('#compte_id'+index).val();
            situation=$('#stut'+index).val();
            date=$('#date').val();
            datecheque=$('#echeance'+index).val();
            alert();
            window.location.href=wr+"Bordereaus/indexpc/#reModal_refuser";
            $.ajax({
            type: "POST",
            data:"index="+index
                   ,
            url: wr+"Piecereglementclients/recap/",
            dataType : "HTML"
            }).done(function(data){
            $('#poppiece').html(data);
            uniform_select('#stut');
            $('#datesituation').datetimepicker({
            timepicker: false,
            datepicker:true,
            mask:'39/19/9999',
            format:'d/m/Y'});
            }); 
            
            if(datecheque>date){
                var r = confirm("Echéance supérieur à la date d'aujourd'hui!");
                if (r == true) {
                 if(((societe!='') && (situation!='En attente'))||((societe=='') && (situation=='En attente'))){
                 $.ajax({
            type: "POST",
            url: wr+"Piecereglementclients/select/"+societe+"/"+situation+"/"+index,
            dataType : "JSON"
                }).done(function(data){
          
               });
            }
                } 
            }else{ 
            if(((societe!='') && (situation!='En attente'))||((societe=='') && (situation=='En attente'))){
                 $.ajax({
            type: "POST",
            url: wr+"Piecereglementclients/select/"+societe+"/"+situation+"/"+index,
            dataType : "JSON"
        }).done(function(data){
          
        });
            }}
        });
        
///////////////////////////////////////////////////////////////////////////////////
    
$(".ajouterligne").on('click', function() { 
       table= $(this).attr('table');//id table
       index= $(this).attr('index');// id max compteur
       tr= $(this).attr('tr'); //class class type
       ind=Number($('#'+index).val())+1;
       $ttr =$('#'+table).find('.'+tr).clone(true);
       $ttr.attr('class','cc'); //amin
       i=0;tabb=[];
       //alert(ind);
       $ttr.find('a,input,select,div,td,textarea,tr,table').each(function(){
           
            tab = $(this).attr('table');
            champ = $(this).attr('champ');
            if(champ !="trstituation"){
            $(this).attr('index',ind);
            $(this).attr('id',champ+ind);
            $(this).attr('name','data['+tab+']['+ind+']['+champ+']');
	    $(this).attr('data-bv-field','data['+tab+']['+ind+']['+champ+']');
            $(this).removeClass('anc');
			 if($(this).is('select')){
                            if(champ !="etatpiecereglement_id"){ 
				 tabb[i]=champ+ind;
                                // alert(tabb[i]);
                                //----------- Amin
				 i=Number(i)+1;
                            } 
                                 if(champ=='matierepremiere_id'){
                                     nompage=$('.nompage').val();
                                     four=$('#'+nompage+'FournisseurId').val()||0;
                                     $(this).attr('onchange','cal_prix('+four+','+ind+')');
                                 }
                                  if(champ=='bouttonajoutlignepetit'){
                                  $(this).attr('index',ind);    
                                 }
                                 // ----------
            }
          //  $(this).val('');
        
        }		
        })
        $ttr.find('i').each(function(){
           $(this).attr('index',ind); 
        });//alert();console.log($ttr);
        //alert(table);
       // console.log($ttr);
        //console.log($('#'+table).find('tr:last'));
        $ttr.attr('style','');
        $('#'+table).append($ttr);
        $('#'+index).val(ind);
        $('#echance'+ind).datetimepicker({
        timepicker: false,
        datepicker:true,
        mask:'39/19/9999',
        format:'d/m/Y'
    });
        $('#'+table).find('tr:last').show();
       // $('#'+table).find('tr:last').attr('style','');
		for(j=0;j<=i;j++){
		uniform_select(tabb[j]);
		}
    $('.trstituation').hide();     

    });
    
////////////////////////////Règlement client///////////////////////////
$('.clientreglement').on('change',function(){
val=$('#client_id').val()||0; 
pointdevente_id=$('#pointdevente_id').val()||0;
//alert(val);
if(val!=0)
$(location).attr('href',wr+"Reglementclients/add/"+val+"/"+pointdevente_id);

});
////////////////////////////Règlement client///////////////////////////
$('.affectationreglement').on('change',function(){
val=$('.affectationreglement').val()||0; 

//alert(val);
if(val!=0)
$(location).attr('href',wr+"Affectations/add/"+val);

});
////////////////////////////Règlement piece impaye///////////////////////////
$('.clientpieceimp').on('change',function(){
val=$('.clientpieceimp').val()||0; 
pointdevente_id=$('#pointdevente_id').val()||0;
//alert(val);
if(val!=0)
$(location).attr('href',wr+"Reglementclients/addrpi/"+val+"/"+pointdevente_id);

});
////////////////////////////Règlement fournisseur///////////////////////////
$('.fournisseurreglement').on('change',function(){
    
val=$('.fournisseurreglement').val()||0; 


if(val!=0)
$(location).attr('href',wr+"Reglements/add/"+val);

});


//////////////////////////////Règlement client////////////////////////////////////////
$('.chekreglement').on('click',function(){
     $("#inputlibre").val("0");
     max= $('#max').val();
     typefrs= $('#typefrs').val();
     //alert(typefrs);
     ttbl=0;
     ttdv=0;
     remise=0;
     testt=false;
     ttounsi=0;
    imp= $(this).attr('importation');
    ind= $(this).attr('index');
    //alert(imp);
    testimp=0;
    for(i=0;i<=max;i++){
      if($('#facture_id'+i).is(':checked')){ 
          //alert(i);
          //alert($('#facture_id'+i).attr('importation'));
              if($('#facture_id'+i).attr('importation')!=imp){
                  testimp=8;
                  id=i;
              }
      }
	    //zeinab
	compte= $(this).attr('compte')||0;
	if(compte!=0){
	 index=$('#index').val();
	 if($('#facture_id'+i).is(':checked')){ 
	 typefrs=$('#typefrs').val();
     i= $(this).attr('index');
	 nom_compte= $('#NonCompte'+i).val(); 
	 if(typefrs !=1){
        $('#tablepaiement'+index).show();
        $('#tr_regle_fournisseur'+index).show();
   
       $('#trmontantbruta'+index).hide() ;
       $('#trmontantbrutb'+index).hide() ;
       $('#trmontantneta'+index).hide() ;
       $('#trmontantnetb'+index).hide() ;
       $('#trtauxa'+index).hide() ;
       $('#trtauxb'+index).hide() ;
           //******************
       $('#trcarnetnuma'+index).hide() ;
       $('#trcarnetnumb'+index).hide() ;
       $('#divnumc'+index).hide() ;
       $('#trechancea'+index).show();
       $('#trechanceb'+index).show();
       $('#trbanquea'+index).show();
	   
       $('#trbanqueb'+index).show();
	   
       $('#banque_idb'+index).show() ;         
       $('#banque_ida'+index).show() ;         
       $('#trnuma'+index).show() ;
       $('#trnumb'+index).show() ;
       $('#divnump'+index).show() ;
	  //alert(compte);
	   $.ajax({
            type: "POST",
            data: {
                compte_id: compte,
				ind: index,
				
            },
            url: wr+"Reglements/compte/",
             dataType : "json",
             global : false //}l'envoie'
      }).done(function(data){ 
	          console.log(data.select);
              $('#compte_id'+index).parent().html(data.select);
               uniform_select('compte_id'+index);

         
     })  
	   
	}
	
	
	 }else{
		   compt='';
		  $.ajax({
            type: "POST",
            data: {
                compte_id: compt,
		ind: index,
				
            },
            url: wr+"Reglements/compte/",
             dataType : "json",
             global : false //}l'envoie'
      }).done(function(data){ 
	          console.log(data.select);
              $('#compte_id'+index).parent().html(data.select);
               uniform_select('compte_id'+index);
     })  
      }	
  }
	  
	  
	  //**********
    } 
    //alert(testimp);
    if(testimp==8){
               //$('#facture_id'+id).prop('checked', false); 
               bootbox.alert('cette fature sur une importation différente', function (){});
               return false
    } 
    for(i=0;i<=max;i++){
      if($('#facture_id'+i).is(':checked')){//alert();
          testt=true;
          ttbl=Number($('#facture_id'+i).attr('mnt'))+Number(ttbl);
          ttounsi=Number($('#facture_id'+i).attr('mnttounssi'))+Number(ttounsi);
          if(typefrs !=1){
          ttdv=Number($('#devise'+i).val())+Number(ttdv);
          }
        $('#importation_id'+i).prop('checked', true);   
      }else{
       $('#importation_id'+i).prop('checked', false);   
      }
    }
   if (testt===true){
       $('#tc'+ind).attr('readonly', false);
       $('#btnenr').prop("disabled", false);
   } else {
       $('#tc'+ind).attr('readonly', true);
       $('#btnenr').prop("disabled", true);
   }
   ttpayer=Number(ttbl);
   $('#ttpayer').val((ttpayer).toFixed(3));
   $('#netpayer').val((ttpayer).toFixed(3));
 
   if(typefrs !=1){
   //tc = $('#tc').val()||0;
   ///montantachat = $('#montantachat').val()||0;
   //mpayer=Number(tc)*Number(montantachat);    
   //$('#ttpayer').val((mpayer).toFixed(3));
   //$('#netpayer').val((mpayer).toFixed(3));    
   //$('#Montant').val((mpayer).toFixed(3));
   //$('#montantdevise0').val((ttdv).toFixed(2));
   //$('#prixachattounssi').val((ttounsi).toFixed(2));
   //$('#montant0').val((ttpayer).toFixed(2));
   //$('#montant0').attr('readonly', true);
   calculetotalecredit();
   }
   v=$('#index').val();
   index=0;
   test=0;
   for(j=0;j<=v;j++){
   if($('#paiement_id'+j).val()==5)  {
         index=j;
         test=1;
   }   
   }
   if(test==1){
       //alert("d5Al");
       //facmontantbrut(index);
   }
   
});
/////////////////////////////////////////////////////////////////
$('.modereglementclient').on('change',function(){
 index= $(this).attr('index');  //alert(index);
 val=$(this).val();  
console.log(index);
 if(Number(val)==1 ||Number(val)==8){
    // alert();
   //$('#trechance'+index).attr('class','') ;
   $('#trmontantbruta'+index).hide() ;
   $('#trmontantbrutb'+index).hide() ;
   $('#trmontantneta'+index).hide() ;
   $('#trmontantnetb'+index).hide() ;
   $('#trtauxa'+index).hide() ;
   $('#trtauxb'+index).hide() ;
   $('#trechancea'+index).hide() ;
   $('#trechanceb'+index).hide() ;
   $('#trbanquea'+index).hide();
   $('#trbanqueb'+index).hide();
   // $('#trnum'+index).attr('class','') ;
    $('#trnuma'+index).hide() ;
     $('#trnumb'+index).hide() ;
      $('#banque_idb'+index).hide() ;     // modifiction amin pr pag mpreglement
     $('#banque_ida'+index).hide() ;// modifiction amin
 }else if (Number(val)==2){
     
   $('#trmontantbruta'+index).hide() ;
   $('#trmontantbrutb'+index).hide() ;
   $('#trmontantneta'+index).hide() ;
   $('#trmontantnetb'+index).hide() ;
   $('#trtauxa'+index).hide() ;
   $('#trtauxb'+index).hide() ;
   $('#trechancea'+index).show();
   $('#trechanceb'+index).show();
   $('#trbanquea'+index).show();
   $('#trbanqueb'+index).show();
   $('#banque_idb'+index).show() ;          // modifiction amin
   $('#banque_ida'+index).show() ;    
   $('#trnuma'+index).show() ;
   $('#trnumb'+index).show() ;
    //ajouter select carnet
   $('#trcarnetnuma'+index).show() ;
   $('#trcarnetnumb'+index).show() ;
   $('#divnumc'+index).hide() ;
   $('#divnump'+index).show() ;
   
 }else if (Number(val)==5) {
   $('#trmontantbruta'+index).show();
   $('#trmontantbrutb'+index).show();
   $('#trmontantneta'+index).show();
   $('#trmontantnetb'+index).show();
   $('#trtauxa'+index).show();
   $('#trtauxb'+index).show();
   
    $('#trechancea'+index).hide() ;
    $('#trechanceb'+index).hide() ;
   $('#trbanquea'+index).hide();
   $('#trbanqueb'+index).hide();
   // $('#trnum'+index).attr('class','') ;
    $('#trnuma'+index).show() ;
    $('#trnumb'+index).show() ;
    $('#banque_idb'+index).hide() ;     // modifiction amin pr pag mpreglement
    $('#banque_ida'+index).hide() ;
    $('#trcarnetnuma'+index).hide() ;
    $('#trcarnetnumb'+index).hide() ;
     ttpayer=$('#ttpayer').val();
    $('#montantbrut'+index).val(ttpayer);
    
 }else if (Number(val)==6) {
     
     
    
   $('#trmontantbruta'+index).hide();
   $('#trmontantbrutb'+index).hide();
   $('#trmontantneta'+index).hide();
   $('#trmontantnetb'+index).hide();
   $('#trtauxa'+index).hide();
   $('#trtauxb'+index).hide();
    $('#trmontantnet'+index).hide();
    $('#trtaux'+index).hide(); 
    $('#trmontantbrut'+index).hide();
    $('#trechance'+index).hide() ;
   $('#trechancea'+index).hide() ;
   $('#trechanceb'+index).hide() ;
   $('#trbanquea'+index).hide();
   $('#trbanqueb'+index).hide();
   // $('#trnum'+index).attr('class','') ;
    $('#trnuma'+index).show() ;
    $('#trnumb'+index).show() ;
    $('#banque_idb'+index).hide() ;     // modifiction amin pr pag mpreglement
    $('#banque_ida'+index).hide() ;
    $('#trcarnetnuma'+index).hide() ;
    $('#trcarnetnumb'+index).hide() ;
    $('#trcarnetnuma'+index).hide() ;
    $('#trcarnetnumb'+index).hide() ;
   // $('#divnumc'+index).hide() ;
   // $('#divnump'+index).hide() ;
     clientid=$('.clientreglement').val();
      //alert(index);
      //alert(clientid);
      getfactureavoirs(index,clientid);
     
 }else{
    //  alert('aa');
    $('#trmontantbruta'+index).hide() ;
   $('#trmontantbrutb'+index).hide() ;
   $('#trmontantneta'+index).hide() ;
   $('#trmontantnetb'+index).hide() ;
   $('#trtauxa'+index).hide() ;
   $('#trtauxb'+index).hide() ;
   //******************
   $('#trcarnetnuma'+index).hide() ;
   $('#trcarnetnumb'+index).hide() ;
   $('#divnumc'+index).hide() ;
   $('#trechancea'+index).show();
   $('#trechanceb'+index).show();
   $('#trbanquea'+index).show();
   $('#trbanqueb'+index).show();
   $('#banque_idb'+index).show() ;          // modifiction amin
   $('#banque_ida'+index).show() ;          // modifiction amin
   //$('#trechance'+index).attr('class','display:none') ;
    $('#trnuma'+index).show() ;
    $('#trnumb'+index).show() ;
    $('#divnump'+index).show() ;
    //$('#trnum'+index).attr('class','display:none') ;  
 }
});
/////////////////////////////////////////////////////////////////
$('.modereglement').on('change',function(){
 index= $(this).attr('index');
 val=$(this).val();
 typefrs=$('#typefrs').val();
 //$('#montant'+index).val('');
 nb=0;
// if(index!=0){
//     for(j=0;j<=i;j++){
//       if($('#paiement_id'+j).val()==5)  {
//         nb++;  
//       }
//     }
//     if(nb>1){
//      $('#btnenr').prop("disabled", true);
//        bootbox.alert('interdit de choisi le mode retenue une autre fois', function (){});
//        return false   
//     }else{
//       $('#btnenr').prop("disabled", false);  
//     }
// }
//alert(val);alert(index);
console.log(index);
 if(Number(val)==1){
    // alert();
   //$('#trechance'+index).attr('class','') ;
   $('#trmontantbruta'+index).hide() ;
   $('#trmontantbrutb'+index).hide() ;
   $('#trmontantneta'+index).hide() ;
   $('#trmontantnetb'+index).hide() ;
   $('#trtauxa'+index).hide() ;
   $('#trtauxb'+index).hide() ;
   $('#trnbrmoins'+index).hide();
   $('#trechancea'+index).hide() ;
   $('#trechanceb'+index).hide() ;
   $('#trbanquea'+index).show();
   $('#trbanqueb'+index).show();
   // $('#trnum'+index).attr('class','') ;
   $('#trnuma'+index).hide() ;
   $('#trnumb'+index).hide() 
   $('#banque_idb'+index).hide() ;     // modifiction amin pr pag mpreglement
   $('#banque_ida'+index).hide() ;// modifiction amin
   $('#trcarnetnuma'+index).hide() ;
   $('#trcarnetnumb'+index).hide() ;
 }
 else if (Number(val)==2){
//      alert('cheque');


   $('#trmontantbruta'+index).hide() ;
   $('#trmontantbrutb'+index).hide() ;
   $('#trmontantneta'+index).hide() ;
   $('#trmontantnetb'+index).hide() ;
   $('#trtauxa'+index).hide() ;
   $('#trtauxb'+index).hide() ;
   $('#trechancea'+index).show();
   $('#trechanceb'+index).show();
   $('#trbanquea'+index).hide();
   $('#trbanqueb'+index).hide();
   $('#banque_idb'+index).hide() ;          // modifiction amin  
   $('#banque_ida'+index).hide() ;          // modifiction amin   
   $('#trnuma'+index).show() ;
   $('#trnumb'+index).show() ;
    //ajouter select carnet trnumb0
   $('#trcarnetnuma'+index).show() ;
   $('#trcarnetnumb'+index).show() ;
   $('#divnumc'+index).show() ;
   $('#divnump'+index).show() ;
   
 }
 else if (Number(val)==5) {
   $('#pop').html('');
   $('#trmontantbruta'+index).show();
   $('#trmontantbrutb'+index).show();
   $('#trmontantneta'+index).show();
   $('#trmontantnetb'+index).show();
   $('#trtauxa'+index).show();
   $('#trtauxb'+index).show();
   $('#trnbrmoins'+index).hide();
    $('#trechancea'+index).show() ;
    $('#trechanceb'+index).show() ;
   $('#trbanquea'+index).hide();
   $('#trbanqueb'+index).hide();
   // $('#trnum'+index).attr('class','') ;
    $('#trnuma'+index).show() ;
    $('#trnumb'+index).show() ;
    $('#divnump'+index).show() ;
    $('#banque_idb'+index).hide() ;     // modifiction amin pr pag mpreglement
    $('#banque_ida'+index).hide() ;
    $('#trcarnetnuma'+index).hide() ;
    $('#trcarnetnumb'+index).hide() ;
    ttpayer=$('#ttpayer').val();
    $('#montantbrut'+index).val(ttpayer);
     
 }
 else{
    //  alert('aa');
   //$('#pop').html('');
   if(typefrs !=1){
       if((Number(val)==4)||(Number(val)==6)){
       $('#tablepaiement'+index).show();
       $('#tr_regle_fournisseur'+index).show();
       }
   }
   $('#trmontantbruta'+index).hide() ;
   $('#trmontantbrutb'+index).hide() ;
   $('#trmontantneta'+index).hide() ;
   $('#trmontantnetb'+index).hide() ;
   $('#trtauxa'+index).hide() ;
   $('#trtauxb'+index).hide() ;
   //******************
   $('#trcarnetnuma'+index).hide() ;
   $('#trcarnetnumb'+index).hide() ;
   $('#divnumc'+index).hide() ;
   $('#trechancea'+index).show();
   $('#trechanceb'+index).show();
   $('#trbanquea'+index).show();
   $('#trbanqueb'+index).show();
   $('#banque_idb'+index).show() ;          // modifiction amin
   $('#banque_ida'+index).show() ;          // modifiction amin
   //$('#trechance'+index).attr('class','display:none') ;
    $('#trnuma'+index).show() ;
    $('#trnumb'+index).show() ;
    $('#divnump'+index).show() ;
    //$('#trnum'+index).attr('class','display:none') ;  
 }
 
 if(Number(val)==7){
      //alert('aa');
   $('#trmontantbruta'+index).hide() ;
   $('#trmontantbrutb'+index).hide() ;
   $('#trmontantneta'+index).hide() ;
   $('#trmontantnetb'+index).hide() ;
   $('#trtauxa'+index).hide() ;
   $('#trtauxb'+index).hide() ;
   $('#trechancea'+index).hide() ;
   $('#trechanceb'+index).hide() ;
   $('#trbanquea'+index).show();
   $('#trbanqueb'+index).show();
   
   $('#trnbrmoins'+index).show();
   $('#trnuma'+index).hide() ;
   $('#trnumb'+index).hide() 
   $('#banque_idb'+index).hide() ;     // modifiction amin pr pag mpreglement
   $('#banque_ida'+index).hide() ;// modifiction amin
   $('#trcarnetnuma'+index).hide() ;
   $('#trcarnetnumb'+index).hide() ;
 }
 
 
 
});

/////////////////////////////////////////////////////////////////
$('.mnt').on('keyup ',function(){
    //alert("hay");
    v=$('#index').val()||0;//alert(v)//console.log(v);
    typefrs= $('#typefrs').val()||0;
    ttpayer= $('#ttpayer').val()||0;
    //alert("index"+v);
    //alert("type fournisseur"+typefrs);
    
     val=$("#inputlibre").val()||0;  
     reg_libre=$("#page").val()||0; 
    //alert("libre"+val);
    
    tt=0;
    i=0;
    for(i=0;i<=v;i++){
       th= $('#montant'+i).val()||0; 
       //alert(th);
       tt=(Number(tt)+Number(th)).toFixed(3);  
    }
    if((Number(tt)>Number(ttpayer))&&(reg_libre!="reg_libre")){
        if(val==0){
        //tt=(Number(tt)-Number(th)).toFixed(3);      
        $('#Montant').val(Number(tt).toFixed(3));    
        //$('#btnenr').prop("disabled", true);
        //$(this).val("");
        //bootbox.alert('vous dépassez le montant à payer', function (){});
        //return false
    }
    else{
    //$('#btnenr').prop("disabled", false);   
    $('#Montant').val(Number(tt).toFixed(3));
    }
    }
    else{
    //$('#btnenr').prop("disabled", false);   
    $('#Montant').val(Number(tt).toFixed(3));
    }
});
//***edit************
$('.editmnt').on('keyup change',function(){
    v=$('#index').val(); //alert(v);//console.log(v);
    tt=0;
    th=0;
   i=0;
    while($('#montant'+i).val()!=undefined){
       th= $('#montant'+i).val()||0;  //console.log(th);
     tt=Number(tt)+Number(th);  
     i++;
    }
    console.log(tt);
    $('#Montant').val((tt).toFixed(3));
});
/////////////////////////////////////////////////////////////
 $('.editmontantbrut').on('keyup change',function(){
        index=$(this).attr('index');
        montantbrut=$('#montantbrut'+index).val()||0; 
        t=$('#taux'+index).val()||0;
        //alert(t);
        if (t==='1') {taux=1.5};
        if (t==='2') {taux=5};
        if (t==='3') { taux=15};
        //alert(taux);
        retenue=(montantbrut*(taux/100)).toFixed(3);
        $('#montant'+index).val(retenue);
       // $('#Montant').val(retenue);
        net=(montantbrut-retenue).toFixed(3);
        $('#montantnet'+index).val(net);
        $('#netapayer').val(net);
    v=$('#index').val();//alert(v)//console.log(v);
    tt=0;
    th=0;
    i=0;
    //for(i=0;i<=v;i++){
    while($('#montant'+i).val()!=undefined){
       th= $('#montant'+i).val()||0;  //console.log(th);
     tt=Number(tt)+Number(th);  
     i++;
    }
   // ttt=Number(tt)+Number(retenue);
    console.log(tt);
    $('#Montant').val((tt).toFixed(3));
        
    });
    ///////////////////////////********
    $('.montantbrut').on('keyup change',function(){
           index=$(this).attr('index');
        montantbrut=$('#montantbrut'+index).val()||0; 
        t=$('#taux'+index).val()||0;
        //alert(t);
        if (t==='1') {taux=1.5};
        if (t==='2') {taux=5};
        if (t==='3') { taux=15};
        //alert(taux);
        retenue=(montantbrut*(taux/100)).toFixed(3);
        $('#montant'+index).val(retenue);
       // $('#Montant').val(retenue);
        net=(montantbrut-retenue).toFixed(3);
        $('#montantnet'+index).val(net);
        $('#netapayer').val(net);
    v=$('#index').val();//alert(v)//console.log(v);
    tt=0;
    th=0;
    i=0;
    //for(i=0;i<=v;i++){
    while($('#montant'+i).val()!=undefined){
       th= $('#montant'+i).val()||0;  //console.log(th);
     tt=Number(tt)+Number(th);  
     i++;
    }
   // ttt=Number(tt)+Number(retenue);
    console.log(tt);
    $('#Montant').val((tt).toFixed(3));
        
    });

//////////////////////////////////////////////////////////////////
$('.supreg').on('click',function(){
    ind= $(this).attr('index');
    $('#sup'+ind).val(1);
    $(this).parent().parent().hide();
    $('#btnenr').prop("disabled", false); 
    v=$('#index').val();//console.log(v);
    tt=0;
    th=0;
    for(i=0;i<=v;i++){
    if($('#sup'+i).val() != 1)  {  
    th= $('#montant'+i).val()||0;  //console.log(th);
    tt=Number(tt)+Number(th);  
    }}
    console.log(tt);
    $('#Montant').val(tt);
        });

//////////////////////////////////////////////////////////////////
  $('.testmontant').on('click',function(){
    netapayer = $('#netapayer').val(); //alert (netapayer);
    ttpayer = $('#ttpayer').val(); //alert (ttpayer);
    montantapayer = $('#Montant').val();
    
     if(Number(netapayer)!='0.000'){
            if (Number(montantapayer) > Number(ttpayer)){
                     bootbox.alert('Montant a payer superieur Total a payer !!', function (){});
                return false;
            }else {
                if(Number(montantapayer) < Number(ttpayer)){
                 bootbox.alert('Montant a payer inferieur Total a payer !!', function (){});
                return false;
              }
            }
        }else {
            if (Number(montantapayer) > Number(ttpayer)){
                     bootbox.alert('Montant a payer superieur Total a payer !!', function (){});
                return false;
            }
        }    
    
        });  
     //controle  num piece 
      $('.getnumcheque').on('change',function(){
          index=$(this).attr('index'); //alert('indexxxx'+index);
          //numero = $('#carnetcheque_id'+index).val(); 
          carnetcheque_id=$(this).val(); //alert(carnetcheque_id);
           $.ajax({
            type: "POST",
            data: {
                carnetcheque_id:carnetcheque_id,
                index:index
            },
            url: wr+"Carnetcheques/getnumcheque/",
             dataType : "html",
             global : false //}l'envoie'
      }).done(function(data){
          
          $('#trnumc'+index).html('');
            $('#trnumc'+index).html(data);
             
            uniform_select('cheque_id'+index);
         
     }) 
     })
	});
 function  getfactureavoirs(index,clientid){//a faire  !!!!!!!!
         ///alert(index);   
    $.ajax({
            type: "POST",
            data: {
                index: index,
                clientid: clientid
            },
            url: wr+"Reglementclients/getfactureavoirs/",
             dataType : "html",
             global : false //}l'envoie'
      }).done(function(data){
           $('#divnumc'+index).show() ;
           
          $('#trnumf'+index).html('');
            $('#trnumf'+index).html(data);
             
            uniform_select('num_piece'+index);
     })   
     }
  function   getmontantfav(index){
      factureavoir_id = $('#factureavoir_id'+index).val();
      //alert(factureavoir_id);
       $.ajax({
            type: "POST",
            data: {
                id: factureavoir_id
            },
            url: wr+"Factureavoirs/getmontantfav/",
             dataType : "json",
             global : false //}l'envoie'
      }).done(function(data){
        //alert(data);
            $('#montant'+index).val(data.montant);
            $('#favid'+index).val(data.factureavoir_id);
            
             v=$('#index').val(); //alert(v);//console.log(v);
                tt=0;
                th=0;
               i=0;
                while($('#montant'+i).val()!=undefined){
                   th= $('#montant'+i).val()||0;  //console.log(th);
                 tt=Number(tt)+Number(th);  
                 i++;
                }
                console.log(tt);
                $('#Montant').val((tt).toFixed(3));

                 })   
  }
  
  
  
  function   facmontantbrut(index){
        //alert("fi wesset fonction");
        ttpayer=$('#ttpayer').val();
        $('#montantbrut'+index).val(ttpayer);
        montantb=$('#montantbrut'+index).val()||0; 
        t=$('#taux'+index).val()||0;
        if (t==0) {taux=0};
        if (t==1) {taux=1.5};
        if (t==2) {taux=5};
        if (t==3) {taux=15};
        //alert(t);
        //alert(taux);
        //alert(montantb);
        retenue=Number(ttpayer)*(Number(taux)/100);
        //alert(retenue);
        $('#montant'+index).val(retenue.toFixed(3));
       // $('#Montant').val(retenue);
        net=(montantb-retenue).toFixed(3);
        //$('#montantnet'+index).val(net);
        $('#netapayer').val(net);
    v=$('#index').val();//alert(v)//console.log(v);
    tt=0;
    th=0;
    i=0;
    //for(i=0;i<=v;i++){
    while($('#montant'+i).val()!=undefined){
       th= $('#montant'+i).val()||0;  //console.log(th);
     tt=Number(tt)+Number(th);  
     i++;
    }
   // ttt=Number(tt)+Number(retenue);
    console.log(tt);
    $('#Montant').val((tt).toFixed(3));
        
    }
      
    
    
