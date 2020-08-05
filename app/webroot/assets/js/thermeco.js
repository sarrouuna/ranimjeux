$(document).ready(function() 
{    
    
    $('#lasociete').on('change',function(){
            societe=$('#lasociete').val();
                
                 $.ajax({
            type: "POST",
            url: wr+"Deviprospects/recup_pointdevente/"+societe,
            dataType : "HTML"
                }).done(function(data){
                   $('#lapv').parent().html(data);
                    uniform_select('lapv');
               });
            
        });
    
    
    $('.chekaffreglement').on('click',function(){

     max= $('#max').val(); //alert();
   ttbl=0;
   //remiseg=$('.remiset').val();
   remise=0;
   testt=false;
   for(i=0;i<=max;i++){
      if($('#facture_id'+i).is(':checked')){//alert();
          testt=true;
           ttbl=Number($('#facture_id'+i).attr('mnt'))+Number(ttbl);
                  
      } 
   }
   
//    avance=$('#avance').val((avance).toFixed(3));//alert(avance)
//         ttpayer=$('#ttpayer').val((ttpayer).toFixed(3));//alert(ttpayer)
//        if (Number(ttpayer) > Number(avance)){
//                     bootbox.alert('Montant des factures superieur Total des reglements libres !!', function (){});
//                return false;
//            }
   
   if (testt===true){
       $('#btnenr').prop("disabled", false);
   } else {
       $('#btnenr').prop("disabled", true);
   }
   //console.log(ttbl);
  // console.log(remise);
   ttpayer=Number(ttbl);
   $('#ttpayer').val((ttpayer).toFixed(3));
   $('#netpayer').val((ttpayer).toFixed(3));
  
});
    
    //////////////////////////////  testttpayer    ////////////////////////////////////////
   $('.testttpayer').on('click',function(){
              avance=$('#avance').val((avance).toFixed(3));//alert(avance)
          ttpayer=$('#ttpayer').val((ttpayer).toFixed(3));//alert(ttpayer)
        if (Number(ttpayer) > Number(avance)){
                     bootbox.alert('Montant des factures superieur Total des reglements libres !!', function (){});
                return false;
            }
   });
    
    $('.compte').on('change',function(){
        //compte_id= $(this).attr('index'); //alert (index);
        compte_id = $('#compte_id').val();// alert (compte_id);
        $.ajax({
            type: "POST",
            data: {
                compte_id:compte_id
            },
            url: wr+"Bordereaus/compte/",
             dataType : "json",
             global : false //}l'envoie'
      }).done(function(data){
        
             $('#divsolde').show();
            // bootbox.alert('Solde'+data+' ****', function (){});
             $('#solde').val((data.solde).toFixed(3));
             $('#compte_id1').parent().html(data.select);
             uniform_select('compte_id11');
             $('#compteversement').show();
         
     }) 
        $('#divsolde').show();
    }) 
    
    
//    $('.calculmontantbordereau').on('click',function(){ 
//         index= $(this).attr('index'); //alert (index);
//         montant = $('#montant'+index).val(); //alert (montant);
//         garantie = $('#garantie').val()||0;
//         agio = $('#agio').val()||0;
//
//         total = $('#total').val()||0;
//         somme=Number(montant)+Number(total);
//         total = $('#total').val(somme.toFixed(3));
//         
//         totalfactoring=Number(somme)-Number(garantie)-Number(agio);
//         $('#totalfactoring').val(totalfactoring.toFixed(3));
//    })
    
     $('.calcultotalfactoring').on('keyup',function(){ 
         garantie = $('#garantie').val()||0;// alert(garantie);
         agio = $('#agio').val()||0;
         total = $('#total').val()||0;
        if(total>0){
         totalfactoring=(Number(total)-Number(garantie)-Number(agio)).toFixed(3);//alert(totalfactoring);
          $('#totalfactoring').val(totalfactoring);
        }
    })
    
    $('.testdate').on('blur',function(){ 
         datereg = $('#datereg').val(); //alert (datereg);
         today = $('#today').val(); //alert (today);
         
        var debut = temps(datereg.split("/"));
        var fin = temps(today.split("/")); //alert(fin);
        var nb = (fin - debut) / (1000 * 60 * 60 * 24); 
        //alert(nb);
        nb = Number(nb)+1;
        //$('#OrdremissionDuree').val(Number(nb));   
        if(nb<0){
             bootbox.alert('date du reglement superieur a la date d\'aujourd\'hui !!', function (){});
             datereg = $('#datereg').val(today);
             return false;
         }
    })  
    $('.testecheance').on('blur',function(){ 
         date1=$('#datereg').val(); //alert(date1);
         index= $(this).attr('index'); //alert (index);
         date = $('#dateecheance'+index).val();// alert (date);
         client_id = $('#clientid').val(); //alert (client_id);
         paiement_id = $('#paiement_id'+index).val(); //alert (paiement_id);
         
            var debut = temps(date1.split("/"));
            var fin = temps(date.split("/"));
            var nb = (fin - debut) / (1000 * 60 * 60 * 24); 
            //alert(nb);
            nb = Number(nb)+1;
                  $.ajax({
            type: "POST",
            data: {
                client_id:client_id,
                paiement_id:paiement_id
            },
            url: wr+"Clients/testecheance/",
             dataType : "html",
             global : false //}l'envoie'
          }).done(function(data){
            if((data!=0)&(data<nb)){
             bootbox.alert('Vous avez depassez l\'echeance autorise  '+data+' jours  !!', function (){});
            $('#dateecheance'+index).val("__/__/____");
            return false;
           }
          }) 
      
      
    })

   $('.calculmarge').on('keyup',function(){ 
         prixachat = $('#coutrevient').val(); //alert (prixachat);
         margepourcentage = $('#margepourcentage').val(); //alert (margepourcentage);
         prixvente = $('#prixvente').val(); //alert (prixvente);
         if((margepourcentage!=0)&(prixachat!=0)){
         prixvente=Number(prixachat)+ (Number(prixachat)*(Number(margepourcentage)/100));
          $('#prixvente').val(prixvente.toFixed(3));
        }
         
    })  
    
     $('.calculmargegros').on('keyup',function(){ 
         prixachat = $('#coutrevient').val(); //alert (prixachat);
         margepourcentage = $('#margepourcentagegros').val(); //alert (margepourcentage);
         prixvente = $('#prixventegros').val(); //alert (prixvente);
         if((margepourcentage!=0)&(prixachat!=0)){
         prixvente=Number(prixachat)+ (Number(prixachat)*(Number(margepourcentage)/100));
          $('#prixventegros').val(prixvente.toFixed(3));
        }
         
    })  
    
     $('.calculmargevgros').on('keyup',function(){ 
         prixachat = $('#coutrevient').val()||0; //alert (prixachat);
         prixvente = $('#prixventegros').val()||0; //alert (prixvente);
         
     
         if((margepourcentage!=0)&(prixvente!=0)){
          p=((Number(prixvente)-Number(prixachat))*100)/Number(prixachat);
          $('#margepourcentagegros').val(p.toFixed(3));
        }
    })  
    
    
    
    
     $('.calculmargev').on('keyup',function(){ 
         prixachat = $('#coutrevient').val()||0; //alert (prixachat);
         prixvente = $('#prixvente').val()||0; //alert (prixvente);
         
     
         if((margepourcentage!=0)&(prixvente!=0)){
          p =((Number(prixvente)-Number(prixachat))*100)/Number(prixachat);
          $('#margepourcentage').val(p.toFixed(3));
        }
    })  
      $('.calculcout').on('keyup',function(e){
          //alert('hgffffffffffffffff');
		  
        var keyCode = e.keyCode || e.which;
       if ((e.keyCode == 9)||(e.keyCode == 16)) {
            return false;
        } else {
         tot=0;                                         
         coef = $('#coef').val()||1;
         if((Number(coef)==0) || Number(coef)==""){
            coef=1;
         }
         //alert("barra "+coef);
         max=$('#index').val();
         for(i=0;i<=max;i++){
         // alert(i);
         if($('#sup'+i).val()!=1){
             quantite=$('#quantite'+i).val()||0;
	     prixx=$('#prix_anc'+i).val()||0;
             coutrevien=(Number(prixx)*Number(coef));
			
			  //zeinab
			  
            remisee=$('#remise'+i).val()||0;
            tva=$('#tva'+i).val()||0;
            remise=(Number(coutrevien)*Number(remisee))/100;
            coutrevien= Number(coutrevien)-Number(remise);
            //totalht=Number( Number(coutrevien) * Number(quantite));
            //totalttc=(totalht*(1+(Number(tva)*0.01)));
            tttc=(((Number(coutrevien))*Number(quantite)));
            ttht=(((Number(coutrevien))*Number(quantite))/Number(1+(Number(tva)/100)));
            tttva=(((Number(coutrevien))*Number(quantite))-(((Number(coutrevien))*Number(quantite))/Number(1+(Number(tva)/100))));
			 $('#totalht'+i).val(ttht.toFixed(3));
			 $('#totalttc'+i).val(tttc.toFixed(3));
			 $('#prixhtva'+i).val(coutrevien.toFixed(6));
                         if((Number(coef)==0) || Number(coef)==""){
                             coef=1;
                         }
                        //alert("d5el "+coef);
			prixdevise=(Number(coutrevien)/Number(coef));//alert(coutrevien+'----'+coef);
                        //alert("prix "+prixdevise);
			$('#prix'+i).val(prixdevise.toFixed(2));
			prix=$('#prix'+i).val()||0;
                         //alert(prix+'-----'+quantite);
                        tot=tot+(prix*quantite);
         }
         }
         $('#mdi').val(tot.toFixed(2));
         fret=$('#fret').val()||0;
         avoir=$('#avoir').val()||0;
         tot=Number(tot)+Number(fret)-Number(avoir);
         $('#montantdevise').val(tot.toFixed(2));
         calculefacturef();  
		}
      })
	  
	  //zeinab
    $('.CalculPrix').on('keyup',function(){
		
		 prix=$(this).val();
		 index= $(this).attr('index'); 
		 $('#prix_anc'+index).val(prix);
		 calculcoutt();
	 })
	 
	  $('.btntrasBS').on('click', function () {
        //alert();
        index = $(this).attr('id');
        if (index=="aff") {
            $('#verif').val(0);
        }
		if (index=="aff2") {
            $('#verif').val(2);
        }
		if (index=="aff3") {
            $('#verif').val(3);
        }
    });
	
	$('.TestBanque').on('click',function(){
		index = $(this).val();
		anc = $('#bq_anc').val();
		$('#banque'+index).val(1);
		$('#banque'+anc).val(0);
		$('#bq_anc').val(index);
	 })
	 
	  $('.btntrasBS').on('click', function () {
        //alert();
        index = $(this).attr('id');
        if (index=="aff") {
            $('#verif').val(0);
        }
		if (index=="aff2") {
            $('#verif').val(2);
        }
		if (index=="aff3") {
            $('#verif').val(0);
        }
		//alert($('#verif').val());
    });
	

     $('.TestOrdreBq').on('mousemove',function (){
		index= $('#index').val(); 
		test=0;
		
		for (i = 0; i <= Number(index); i++) {
		   personnelid = $('#personnel_id'+i).val()||0;  
		   act = $('#typeworkflow_id' + i).val()||0;    
           bq = $('#banque' + i).val()||0; 
            if (($('#sup' + i).val() != 1)&& (bq ==1)) {
				test=1;
				if(act!=2){
					bootbox.alert('Ce personnel n\'a pas le droit d\'affecter une banque!! ', function () {});
					return false;
				}
                
			}
			
		}
		
		if(test==0){
					bootbox.alert('L\'affectation de banque est obligatoire !! ', function () {});
					return false;
				}
		
	 })


	//******************************************************
      
    $('.post').on('click',function(){ 
         index= $(this).attr('index'); //alert (index);
         totalttc = $('#totalttc'+index).val(); //alert (montant);
         total = $('#total').val()||0;
         somme=Number(totalttc)+Number(total);
         total = $('#total').val(somme);
       // $('.lb').show();  
    })
    
     $('.postedit').on('click',function(){ 
         index= $(this).attr('index'); //alert (index);
         totalttc = $('#totalttc'+index).val(); //alert (montant);
         total = $('#total').val()||0;
         somme=Number(total)-Number(totalttc);
         total = $('#total').val(somme);
       // $('.lb').show();  
    })   
      
  //******************************************************************************************************
    
      
      
});
    function temps(date) {
        var d = new Date(date[2], date[1] - 1, date[0]);
        return d.getTime();
    }

    function visite() {
        
        var date1=$('#datereg').val();
        var date =$('#dateecheance').val();
        //alert(date1);
 
        var debut = temps(date1.split("/"));
        var fin = temps(date.split("/"));
        var nb = (fin - debut) / (1000 * 60 * 60 * 24); 
        //alert(nb);
        nb = Number(nb)+1;
        $('#OrdremissionDuree').val(Number(nb));
    }
//    function flvFPW1(){
//        var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;
//    } 
    
    
    
     function calculesuggestion(){
          //alert('hgffffffffffffffff');
         tot=0; 
         coef = $('#coef').val()||1;
         max=$('#index').val();
         for(i=0;i<=max;i++){
         // alert(i);
         if($('#sup'+i).val()!=1){
             quantite=$('#quantite'+i).val()||0;
             prix=$('#prix'+i).val()||0;
             coutrevien=(Number(prix)*Number(coef));
             //$('#Total_HT'+i).val(tht);
             tot=tot+(prix*quantite);
             $('#prixhtva'+i).val(coutrevien.toFixed(6));
             
         }
         }
         $('#montantdevise').val(tot.toFixed(2));
         calculefacturef();  
      }
	  
	  //zeinab
	  
	     function calculcoutt(){
         tot=0; 
         coef = $('#coef').val()||1;
         max=$('#index').val();
         for(i=0;i<=max;i++){
          if($('#sup'+i).val()!=1){
             quantite=$('#quantite'+i).val()||0;
			 prixx=$('#prix_anc'+i).val()||0;
             coutrevien=(Number(prixx)*Number(coef));
			 
			  //zeinab
			  
		    remisee=$('#remise'+i).val()||0;
            tva=$('#tva'+i).val()||0;
            remise=(Number(coutrevien)*Number(remisee))/100;
            coutrevien= Number(coutrevien)-Number(remise);
			
            //totalht=Number( Number(coutrevien) * Number(quantite));
            //totalttc=(totalht*(1+(Number(tva)*0.01)));
			
			tttc=(((Number(coutrevien))*Number(quantite)));
            ttht=(((Number(coutrevien))*Number(quantite))/Number(1+(Number(tva)/100)));
            tttva=(((Number(coutrevien))*Number(quantite))-(((Number(coutrevien))*Number(quantite))/Number(1+(Number(tva)/100))));
             
			 $('#tttva'+i).val(tttva.toFixed(3));
			 $('#totalht'+i).val(ttht.toFixed(3));
			 $('#totalttc'+i).val(tttc.toFixed(3));
			 
			 $('#prixhtva'+i).val(coutrevien.toFixed(6));
			 
			 prix=$('#prix'+i).val()||0;
             tot=tot+(prix*quantite);
         }
         }
         $('#montantdevise').val(tot.toFixed(2));
         calculefacturef();  
      }
	  
	  function Affiche(index){
		   $("#histo" + index).toggle();
	  }