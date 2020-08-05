
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
    
     
 }else if (Number(val)==6) {
    
      clientid=$('.clientreglement').val();
      alert(index);
      alert(clientid);
      getfactureavoirs(index,clientid);
      
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
    $('#trnumb'+index).show() ;trnumc
    $('#divnumc'+index).show() ;
    $('#banque_idb'+index).hide() ;     // modifiction amin pr pag mpreglement
    $('#banque_ida'+index).hide() ;
    $('#trcarnetnuma'+index).hide() ;
    $('#trcarnetnumb'+index).hide() ;
    $('#trcarnetnuma'+index).hide() ;
    $('#trcarnetnumb'+index).hide() ;
   // $('#divnumc'+index).hide() ;
   // $('#divnump'+index).hide() ;
    
     
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
   $('#divnumc'+index).show() ;
   $('#divnump'+index).hide() ;
   
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
       $ttr.find('input,select,div,td,textarea').each(function(){
            tab = $(this).attr('table');
            champ = $(this).attr('champ');
            $(this).attr('index',ind);
            $(this).attr('id',champ+ind);
            $(this).attr('name','data['+tab+']['+ind+']['+champ+']');
	    $(this).attr('data-bv-field','data['+tab+']['+ind+']['+champ+']');
            $(this).removeClass('anc');
			 if($(this).is('select')){
				 tabb[i]=champ+ind;
                                // alert(tabb[i]);
                                //----------- Amin
				 i=Number(i)+1;
                                 if(champ=='matierepremiere_id'){
                                     nompage=$('.nompage').val();
                                     four=$('#'+nompage+'FournisseurId').val()||0;
                                     $(this).attr('onchange','cal_prix('+four+','+ind+')');
                                 }
                                 // ----------
            }
          //  $(this).val('');
			
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
    });
    
////////////////////////////Règlement client///////////////////////////
$('.clientreglement').on('change',function(){
val=$('.clientreglement').val()||0; 

//alert(val);
if(val!=0)
$(location).attr('href',wr+"Reglementclients/add/"+val);

});

////////////////////////////Règlement fournisseur///////////////////////////
$('.fournisseurreglement').on('change',function(){
val=$('.fournisseurreglement').val()||0; 

//alert(val);
if(val!=0)
$(location).attr('href',wr+"Reglements/add/"+val);

});


//////////////////////////////Règlement client////////////////////////////////////////
$('.chekreglement').on('click',function(){

     max= $('#max').val(); //alert();
   ttbl=0;
   //remiseg=$('.remiset').val();
   remise=0;
   testt=false;
   for(i=0;i<=max;i++){
      if($('#facture_id'+i).is(':checked')){//alert();
          testt=true;
        //  remisel=$('#remise'+i).val()||0;
           ttbl=Number($('#facture_id'+i).attr('mnt'))+Number(ttbl);
        //   remise=Number(remise)+Number(remisel);
          
      } 
   }
   if (testt===true){
       $('#btnenr').prop("disabled", false);
   } else {
       $('#btnenr').prop("disabled", true);
   }
   //console.log(ttbl);
  // console.log(remise);
   ttpayer=Number(ttbl);
   $('#ttpayer').val((ttpayer).toFixed(3));
//   test= $('#typeremise').is(':checked');
//   if(test){
//   val= $('.remisetc').val();
//   $('.remiset').val(val);
//   }else{
//       val= $('.remisetc').val();
//       ttpayer=$('#ttpayer').val();
//       valeur=((Number(val)*Number(ttpayer))/100).toFixed(3);
//       $('.remiset').val(valeur);
//   }
    //remiseg=$('.remiset').val();
//    ttnpayer=Number(ttpayer);
//   
//    $('#netapayer').val((ttnpayer).toFixed(3));
    
});
/////////////////////////////////////////////////////////////////
$('.modereglementclient').on('change',function(){
 index= $(this).attr('index');  //alert(index);
 val=$(this).val();  
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
   $('#divnumc'+index).show() ;
   $('#divnump'+index).hide() ;
   
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
     
 }else if (Number(val)==6) {
     
      clientid=$('.clientreglement').val();
      alert(index);
      alert(clientid);
      getfactureavoirs(index,clientid);
    
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
    $('#divnumc'+index).show() ;
    $('#banque_idb'+index).hide() ;     // modifiction amin pr pag mpreglement
    $('#banque_ida'+index).hide() ;
    $('#trcarnetnuma'+index).hide() ;
    $('#trcarnetnumb'+index).hide() ;
    $('#trcarnetnuma'+index).hide() ;
    $('#trcarnetnumb'+index).hide() ;
   // $('#divnumc'+index).hide() ;
   // $('#divnump'+index).hide() ;
    
     
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
   $('#trnumb'+index).hide() 
   $('#banque_idb'+index).hide() ;     // modifiction amin pr pag mpreglement
   $('#banque_ida'+index).hide() ;// modifiction amin
   $('#trcarnetnuma'+index).hide() ;
   $('#trcarnetnumb'+index).hide() ;
 }else if (Number(val)==2){
    //  alert('cheque');
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
    //ajouter select carnet
   $('#trcarnetnuma'+index).show() ;
   $('#trcarnetnumb'+index).show() ;
   $('#divnumc'+index).show() ;
   $('#divnump'+index).hide() ;
   
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
    $('#divnump'+index).show() ;
    $('#banque_idb'+index).hide() ;     // modifiction amin pr pag mpreglement
    $('#banque_ida'+index).hide() ;
    $('#trcarnetnuma'+index).hide() ;
    $('#trcarnetnumb'+index).hide() ;
     
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
$('.mnt').on('keyup change',function(){
    v=$('#index').val();//alert(v)//console.log(v);
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
    $(this).parent().parent().remove();
    v=$('#index').val();//console.log(v);
    tt=0;
    th=0;
    for(i=0;i<=v;i++){
       th= $('#montant'+i).val()||0;  //console.log(th);
    tt=Number(tt)+Number(th);  
    }
    console.log(tt);
    $('#Montant').val(tt);
        });

//////////////////////////////////////////////////////////////////
  $('.testmontant').on('click',function(){
    netapayer = $('#ttpayer').val();
    montantapayer = $('#Montant').val();
    if (Number(montantapayer) > Number(netapayer)){
        alert("Montant à payer > Net à payer !!");
        return false;
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
             
            uniform_select('num_piece'+index);
         
     }) 
     })
	});
 function  getfactureavoirs(index,clientid){
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
         // alert (data);
          $('#trnumc'+index).html('');
          $('#trnumc'+index).html(data);   
            uniform_select('trnumc'+index);
     })   
     }//a faire  !!!!!!!!