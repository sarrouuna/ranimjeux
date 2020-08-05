$(document).ready(function(){
//    $('#ls-editable-table').dataTable( {
//				"oLanguage":{
//				"sSearch":"Recherche",
//				"oPaginate":{
//			"sFirst":"Premiére",
//			"sPrevious":"Précédent",
//			"sNext":"Suivant",
//			"sLast":"Dernier"
//			}
//			}
//		
//		
//		
//		
//	} );
//alert();
//console.log($('.deltebefore').parent().parent());
$('.tire').on('click',function(){
    $('.ls_form').submit();
})
$('.marqueinv').on('change',function(){
    val=$(this).val();
     document.location.href=wr+"Inventaires/add/"+val;
})
 $(".marque").on('change',function(){
  marque_id= $(this).val();
    $.ajax({
            type: "POST",
            data: {
                id: marque_id
               
                
            },
            url: wr+"Familles/marque/",
             dataType : "json",
                global : false
        }).done(function(data){
           // console.log(data.index);
         $('#familletype').html(data.type);
       
         $('#familleindex').html(data.index);
          uniform_select('famille_id0');
          $('.btn-primary').remove('disabled');
          
         // document.location.href=wr+"Ligneproductions/index";
     })
 });
 $(".marquep").on('change',function(){
  marque_id= $(this).val();
    $.ajax({
            type: "POST",
            data: {
                id: marque_id
               
                
            },
            url: wr+"Familles/marquep/",
             dataType : "json",
                global : false
        }).done(function(data){
            console.log(data.typename);
            $('#divarticle_id').html("");
       
         $('#divreference').html("");
          $('#divarticle_id0').html("");
       
         $('#divreference0').html("");
         $('#divarticle_id').html(data.typename);
       
         $('#divreference').html(data.typecode);
          $('#divarticle_id0').html(data.indexname);
       
         $('#divreference0').html(data.indexcode);
         
          uniform_select('article_id0');
          uniform_select('reference0');
          //$('.btn-primary').remove('disabled');
          
         // document.location.href=wr+"Ligneproductions/index";
     })
 });
 $(".selectproduction").on('change',function(){
    
    valeur= $(this).val();
    index=$(this).attr('index');
    champ=$(this).attr('champ');
     marque_id= $('#ProductionMarqueId').val()||0;
     if(marque_id==0){
          bootbox.alert("Marque non choisi  ?");
          
     }
//    if(champ=='article_id'){
//         $.ajax({
//            type: "POST",
//            data: {
//                valeur: valeur, 
//                index: index,
//                marque_id:marque_id
//            },
//            url: wr+"Productions/selectname/",
//             dataType : "html",
//                global : false
//        }).done(function(data){
//            select=data
//           $("#divreference"+index).html("");
//         $("#divreference"+index).html(select);
//          uniform_select("reference"+index);
//     });
//     
//  
//    }
//     if(champ=='reference'){
//          $.ajax({
//            type: "POST",
//            data: {
//                valeur: valeur, 
//                index: index,
//                marque_id:marque_id
//            },
//            url: wr+"Productions/selectreference/",
//             dataType : "html",
//                global : false
//        }).done(function(data){
//            console.log(data);
//            select=data
//           $("#divarticle_id"+index).html("");
//        $("#divarticle_id"+index).html(select);
//          uniform_select("article_id"+index);
//     });
//       
//     }
    
    
 });
// creation du code artcile
 $(".article").on('change',function(){
     
     //alert();
       ArticleFamilleId= $('#ArticleFamilleId').val()||0;
       ArticleModeleId= $('#ArticleModeleId').val()||0;
       ArticleCouleurId= $('#ArticleCouleurId').val()||0;
       ArticleTailleId= $('#ArticleTailleId').val()||0;
       ArticleTypeId= $('#ArticleTypeId').val()||0;
	 
   
 //alert(ArticleFamilleId);
 $.ajax({
            type: "POST",
            data: {
                ArticleFamilleId: ArticleFamilleId, 
                ArticleModeleId: ArticleModeleId,
                ArticleCouleurId:ArticleCouleurId,
                ArticleTailleId:ArticleTailleId,
                ArticleTypeId:ArticleTypeId
                
            },
            url: wr+"Articles/findart/",
             dataType : "html",
                global : false
        }).done(function(data){
            console.log(data);
          //alert(data);
          
         //  code=data;
           $("#ArticleCode").val(data); 
     });

    });
    // fin  code article
    // eliminer les espace avant le champs article
	page=$('.page').val();
        if(page=='production'){
       $('label').each(function(){
           //var ch='article_id';
           val=$(this).attr('for');
           if(val.indexOf('article_id')!=-1||val.indexOf('qte')!=-1||val.indexOf('refreence')!=-1){//alert(val.indexOf('article_id'));
               $(this).remove();
           }
       }
               )
        }
        //  modification dune image dans view reference
 $(".imagereference").on('click', function() {  
    
   $(".imagediv").remove();
  
    });
    // ajout de ligne 
    $(".ajouterligne").on('click', function() { 
       table= $(this).attr('table');//id table
       index= $(this).attr('index');// id max compteur
       tr= $(this).attr('tr'); //class class type
       ind=Number($('#'+index).val())+1;
        $ttr =$('#'+table).find('.'+tr).clone(true);
        $ttr.attr('class','');
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
				 i=Number(i)+1;
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
        $('#'+table).find('tr:last').show();
       // $('#'+table).find('tr:last').attr('style','');
		for(j=0;j<=i;j++){
		uniform_select(tabb[j]);
		}
    });
     // ajout de ligne 
    $(".ajouterligne2").on('click', function() { 
       table= $(this).attr('table');//id table
       index= $(this).attr('index');// id max compteur
       tr= $(this).attr('tr'); //class class type
       ind=Number($('#'+index).val())+1;
        $ttr =$('#'+table).find('.'+tr).clone(true);
        $ttr.attr('class','');
		i=0;tabb=[];
        $ttr.find('input,select,div,td,textarea').each(function(){
            tab = $(this).attr('table');
            champ = $(this).attr('champ');
            $(this).attr('index',ind);
            $(this).attr('id',champ+ind);
            $(this).attr('name','data['+tab+']['+ind+']['+champ+']');
			$(this).attr('data-bv-field','data['+tab+']['+ind+']['+champ+']');
                        if(champ=='article_id'){
                   $(this).attr('onchange',"a(this.value,"+ind+",2)");
               }
                      if(champ=='reference'){
                   $(this).attr('onchange',"a(this.value,"+ind+",1)");
               }
            $(this).removeClass('anc');
			 if($(this).is('select')){
				 tabb[i]=champ+ind;
                                // alert(tabb[i]);
				 i=Number(i)+1;
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
        $('#'+table).find('tr:last').show();
       // $('#'+table).find('tr:last').attr('style','');
		for(j=0;j<=i;j++){
		uniform_select(tabb[j]);
		}
    });
    // ajouter des quantiter a la production
    $('.production').on('keyup',function(){
    valeur=$(this).val();  
     index=$(this).attr('index');  
      val=$('#qte_liv'+index).val();
     // alert(val);
      nb=(Number(valeur)-Number(val));
     // alert(nb);
     $('#qte_nnliv'+index).val(nb);
    
    });
  
    // confirmation du production 
    $('.produit').on('click',function(){
    index= $(this).attr('index');
   
    bootbox.confirm("voulez vous confirmez la production du l'article  ?", function(result) {
        if(result){
    $('.produit').each(function(){
        ind=$(this).attr('index');
        if(ind==index){
            //alert(ind);
            v=$('#sesiproduction'+index).val();
            valeur=Number($('#qte'+ind).val())+Number(v);
            valeur1=Number($('#qte_nnliv'+ind).val())+Number(v);
           $('#qte'+ind).val(valeur);
             id_ligne=$('#id'+ind).val();
             $('#sesiproduction'+index).val('');
             $('#qte'+ind).val(valeur);
             $('#qte_nnliv'+ind).val(valeur1);
            // alert(id_ligne);
             $.ajax({
            type: "POST",
            data: {
                id_ligne: id_ligne,
                valeur:valeur,
                valeur1:valeur1
            },
            url: wr+"Ligneproductions/productionligne/",
             dataType : "html",
                global : false
        })
           
        }
    })
        }
            var data ="Confirm result: "+result;
            notificationCenter(
                'glyphicon glyphicon-ok',
                'alert-success',
                data,
                'bottom right'
            );
        });
   
})
   // production ajouter des packer de livraison 
    $('.liv').on('click',function(){
    index= $(this).attr('index');
    
    bootbox.confirm("voulez vous liver un packer a l'article  ?", function(result) {
        if(result){
    $('.produit').each(function(){
        ind=$(this).attr('index');
        if(ind==index){
            //alert(ind);
            valeur=$('#qte_nnliv'+ind).val();
            anc=$('#qte_liv'+ind).val();
            $('#qte_liv'+ind).val(Number(valeur)+Number(anc));
            $('#qte_nnliv'+ind).val('0');
            id_ligne=$('#id'+ind).val();
          $.ajax({
            type: "POST",
            data: {
                id_ligne: id_ligne,
                qte_liv:valeur
                
            },
            url: wr+"Ligneproductions/livraisonligne/",
             dataType : "html",
                global : false
        })
        }
    })
        }
            var data ="Confirm result: "+result;
            notificationCenter(
                'glyphicon glyphicon-ok',
                'alert-success',
                data,
                'bottom right'
            );
        });
   
})
   // production ajouter des packer de reste a la porudction 
    $('.rest').on('keyup',function(){
    index= $(this).attr('index');
    
    art=$('#article_id'+index).val();
   // bootbox.confirm("voulez vous ajouter un piece a l'article   non packeter?", function(result) {
//        if(result){
    $('.produit').each(function(){
        ind=$(this).attr('index');
        if(ind==index){
            //alert(ind);
            valeur=$('#qte_rest'+ind).val();
            id_ligne=$('#id'+ind).val();
                $.ajax({
            type: "POST",
            data: {
                id_ligne: id_ligne,
                valeur:valeur
                
                
            },
            url: wr+"Ligneproductions/restligne/",
             dataType : "html",
                global : false
        })
      
        }
    })
    
    
//        }
//            var data ="Confirm result: "+result;
//            notificationCenter(
//                'glyphicon glyphicon-ok',
//                'alert-success',
//                data,
//                'bottom right'
//            );
       // });
   
})
  // production ajouter des packer de livraison 
    $('.aceptestcok').on('click',function(){
    index= $(this).attr('index');
     qte_liv=$('#qte_liv'+index).val();
     qte_recu=$('#qte_recu'+index).val();   
     depot_id=$('#depot_id'+index).val(); 
     article_id=$('#article_id'+index).val(); 
       id=$('#id'+index).val(); 
      a=1;
      //alert(qte_liv);
      if(Number(qte_liv)<Number(qte_recu)){
          bootbox.alert("quantiter recu et supperieur a quantiter livre  ?");
       a=0;   
      }
     // alert(a);
        if(!Number(depot_id)&& a!=0){
             bootbox.alert("depot non choisi  ?");
       a=0;   
      }
            //alert(ind);
          if(a==1){
    bootbox.confirm("voulez vous stocker l'article  ?", function(result) {
        if(result){
  
           
            
            
          $.ajax({
            type: "POST",
            data: {
                id: id,
                qte_recu:qte_recu,
                article_id:article_id,
                depot_id:depot_id
                
            },
            url: wr+"Ligneproductions/reculigne/",
             dataType : "html",
                global : false
        }).done(function(data){
          document.location.href=wr+"Ligneproductions/index";
     });
       
    
        }
            var data ="Confirm result: "+result;
            notificationCenter(
                'glyphicon glyphicon-ok',
                'alert-success',
                data,
                'bottom right'
            );
        });
    }
   
})
$('.supg').on('click',function(){
     index= $(this).attr('index');
    bootbox.confirm("voulez vous effacer cette enregistrement?", function(result) {
        if(result){
    $('.supg').each(function(){
        ind=$(this).attr('index');
        if(ind==index){
           $(this).parent().parent().remove();
           //$('#sup'+index).val('1'); 
        }
    })
        }
            var data ="Confirm result: "+result;
            notificationCenter(
                'glyphicon glyphicon-ok',
                'alert-success',
                data,
                'bottom right'
            );
        });
})
// coppyer des donner du data table

$('.collection').on('keyup',function(){
    index=$(this).attr('index');//alert(index);
    index2=$(this).attr('index2');//alert(index2);
    limite=$('#index'+index2).val();
   // alert(limite);
   v=Number($('#LigneLignecollectionx'+index2+'_'+index+'Qte').val()); 
   max=Number($('#LigneLignecollectionx'+index2+'_'+index+'qte_packet').val()); 
   qte_demande=Number($('#Lignecollection'+index2+'Qte_d').val());
   tt1=$('#Lignecollection'+index2+'Qte').val();
    tt=Number(tt1)+Number($(this).val());
   // console.log(tt);
   a=0;
   // teste  qte est stock
    if(v>max && a=='0'){
         tt=Number(tt1);
      bootbox.alert("quantité affecter et supperieur a quantiter dans le stock  ?");  
      $(this).val('0');
      a=1;
    }
    //console.log(tt);
   // alert(tt);
   
 
     
  
   // recopiage du ligne dasn clowne
    tr=$(this).parent().clone();// console.log(tr);
    name='data['+$(this).attr('table')+']['+$(this).attr('index2')+']['+$(this).attr('index')+']['+$(this).attr('champ')+']';
           $('.clown').find('input').each(function(){
             
               if($(this).attr('name')==name){
                   $(this).parent().remove();
                   
               }
           });
           $(tr).find('input').each(function(){
              // alert();
               name2='data['+$(this).attr('table')+']['+$(this).attr('index2')+']['+$(this).attr('index')+']['+$(this).attr('champ')+']';
               id2=''+$(this).attr('table')+''+$(this).attr('index2')+'_'+$(this).attr('index')+''+$(this).attr('champ');
             $(this).attr('name',name2);
             $(this).attr('id',''); 
           });
        
           $('.clown').append(tr);
           tt=0;
                 // suppresion des quantiter 0
     $('.clown').find('input').each(function(){
        inde=$(this).attr('index2');
        champ=$(this).attr('champ');
        
        if(champ=='Qte'){
        val=$(this).val()  
       if(Number(val)==0){
           $(this).parent().remove();
       }
    }
     });
           // parcoure du clown et calcule du quantiter affecter
     $('.clown').find('input').each(function(){
        inde=$(this).attr('index2');
        champ=$(this).attr('champ');
        
        if(champ=='Qte'&&inde==index2){
         console.log($(this).val());   
        console.log(inde);
        tt=Number(tt)+Number($(this).val());
    }
     });
       // test qtett affecter et qte demander
   if(Number(tt)>Number(qte_demande)&& a=='0'){
         tt=Number(tt1);
        // alert(tt1);
          $('#Lignecollection'+index2+'Qte').val(tt);
        bootbox.alert("vous aver depassser la quantiter demander ?");  
         $(this).val('0')
         a=1;
        
     
    }
      $('#Lignecollection'+index2+'Qte').val(tt);  
});
// transformation bc to bl
$('.creebl').on('click',function(){
    val= $(this).val();
    client= $(this).attr('client');
    test=$(this).is(':checked');
    // test echekbox true
    if(test==true){
      // alert(test); 
     client_id=  $('.btnbl').attr('client_id');
     if(client_id==0|| client_id==client){
        $('.btnbl').attr('client_id',client);  
       nbbl= Number($('.btnbl').attr('nb'))+1; 
      $('.btnbl').attr('nb',nbbl); 
      $('.creationbl').attr('style',''); 
      link=$('.btnbl').attr('link')+val+',';
      $('.btnbl').attr('link',link);
     }else {if(client_id!=client){
              bootbox.alert("n est pas le meme client pour les autres Bon de commande  ?");  
//        $(this).is(':checked','false'); 
//        $(this).attr('checked','');
$(this).attr('checked', $(this).is(''));
     }
 }
       
    }else{
       $('.btnbl').attr('client_id',client);  
       nbbl= Number($('.btnbl').attr('nb'))-1; 
      $('.btnbl').attr('nb',nbbl); 
      //$('.creationbl').attr('style',''); 
       val= $(this).val();
       v=','+val;
       v1=',0';
      link=$('.btnbl').attr('link');
      lin=link.replace(v,v1);
      $('.btnbl').attr('link',lin); 
    }
     nbbl= Number($('.btnbl').attr('nb'));
    // alert(nbbl);
     if(nbbl==0){
         $('.btnbl').attr('client_id','0');
         $('.btnbl').attr('link',',');
         $('.creationbl').attr('style','display: none'); 
     }
     
    
})
//submite du bc a transformation bl et affectatio, de link 
$('.btnbl').on('click',function(){
   link=$(this).attr('link');
   href=$(this).attr('href');
   $(this).attr('href',href+'/'+link);
})
// calcule du bl
$('.calcule').on('keyup',function(){
 index=$(this).attr('index');  
 //alert(index);
 qte=$('#Qte'+index).val();
 prix=$('#Prix'+index).val();
 tva=0;
 remise=$('#Remise'+index).val();
 //remise=((Number(prix)*Number(remise1))/100).toFixed(3);
 max=$('#max').val();
 prixu=(Number(prix)-Number(remise)); //alert(prixu);
 TTH=(Number(prixu)*Number(qte)).toFixed(3);
 $('#Total_HT'+index).val(TTH);
 ttremise=0;
 tttva=0;
 ttht=0;
 ttttc=0;
 for(i=0;i<=max;i++){
      qte=$('#Qte'+i).val();//console.log(qte);
 prix=$('#Prix'+i).val();
 tva=0;
 remisel=0;
 
 //remise=$('#Remise'+i).val();//console.log(remise);
 remise=$('#Remise'+i).val(); console.log(remisel);
// remise=((Number(prix)*Number(remise1))/100).toFixed(3);
 Total_HT=$('#Total_HT'+i).val();
 remisel=(Number(remise)*Number(qte));
 ttremise=(Number(ttremise)+Number(remisel)).toFixed(3);//console.log(ttremise);
 pt=((Number(prix)-Number(remise))*Number(qte)).toFixed(3);
 tttva=0;
 ttht=(Number(ttht)+Number(Total_HT)).toFixed(3);
 }
// console.log(ttremise);
 $('#BonlivraisonRemise').val(ttremise);
 //$('#BonlivraisonTva').val(tttva);
 //$('#BonlivraisonTotalHT').val(ttht);
 ttttc=(Number(ttht)+Number(tttva)).toFixed(3);
 $('#BonlivraisonTotalTTC').val(ttttc);
});
// rederction chnagement client 
$('.clientreglement').on('change',function(){
val=$(this).val(); 
//alert(val);
$(location).attr('href',wr+"Reglements/add/"+val);
});
$('.soldeclient').on('change',function(){
val=$(this).val(); 
datedebut=($('#ReglementDateDebut').val()).replace('/','-'); 
datefin=($('#ReglementDateFin').val()).replace('/','-');  
//alert(val);
$(location).attr('href',wr+"/Bonlivraisons/soldeclient/"+val+'/'+datedebut+'/'+datefin);
});
// regelment  selection du bl
$('.chekreglement').on('click',function(){
   // alert();
//   val= $(this).val();
//  mnt=  $(this).attr('mnt')||0;
//  index=  $(this).attr('index');
//    remise=  $('#remise'+index).val()||0;
//    test=$(this).is(':checked');
//    // test echekbox true
//    ttpayer=$('#ttpayer').val();
//    if(test==true){
//     ttpayer=Number(ttpayer)+Number(mnt)-Number(remise);  
//    }else{
//      ttpayer=Number(ttpayer)-Number(mnt)+Number(remise);   
//    }
////      remiset=  $('#remise').val()||0; 
////      ttpayer=ttpayer-remiset;
//    $('#ttpayer').val((ttpayer).toFixed(3));
//    $('#netapayer').val((ttpayer).toFixed(3));
     max= $('#max').val(); //alert();
   ttbl=0;
   //remiseg=$('.remiset').val();
   remise=0;
   for(i=0;i<=max;i++){
      if($('#bonlivraison_id'+i).is(':checked')){//alert();
          remisel=$('#remise'+i).val()||0;
           ttbl=Number($('#bonlivraison_id'+i).attr('mnt'))+Number(ttbl);
           remise=Number(remise)+Number(remisel);
          
      } 
   }
   //console.log(ttbl);
  // console.log(remise);
   ttpayer=Number(ttbl)-Number(remise);
    $('#ttpayer').val((ttpayer).toFixed(3));
   test= $('#typeremise').is(':checked');
   if(test){
   val= $('.remisetc').val();
   $('.remiset').val(val);
   }else{
       val= $('.remisetc').val();
       ttpayer=$('#ttpayer').val();
       valeur=((Number(val)*Number(ttpayer))/100).toFixed(3);
       $('.remiset').val(valeur);
   }
  remiseg=$('.remiset').val();
   ttnpayer=Number(ttpayer)-Number(remiseg);
   
    $('#netapayer').val((ttnpayer).toFixed(3));
    
});
 // remise sur ligne du reglement 
$('.remisel').on('keyup',function(){
//    test= $('#typeremise').is(':checked');
//   if(test){
//   val= $('.remisetc').val();
//   $('.remiset').val(val);
//   }else{
//       val= $('.remisetc').val();
//       ttpayer=$('#ttpayer').val();
//       valeur=((Number(val)*Number(ttpayer))/100).toFixed(3);
//       $('.remiset').val(valeur);
//   }
//  val=$('.remiset').val();
//   max= $('#max').val(); //alert();
//   ttbl=0;
//   remiseg=$('.remiset').val();
//   remise=0;
//   for(i=0;i<=max;i++){
//      if($('#bonlivraison_id'+i).is(':checked')){//alert();
//           ttbl=Number($('#bonlivraison_id'+i).attr('mnt'))+Number(ttbl);
//           remise=Number(remise)+Number($('#remise'+i).val());
//          
//      } 
//   }
//   //console.log(ttbl);
//  // console.log(remise);
//   ttpayer=Number(ttbl)-Number(remise);
//   ttnpayer=Number(ttpayer)-Number(remiseg);
//    $('#ttpayer').val((ttpayer).toFixed(3));
//    $('#netapayer').val((ttnpayer).toFixed(3));
     max= $('#max').val(); //alert();
   ttbl=0;
   //remiseg=$('.remiset').val();
   remise=0;
   for(i=0;i<=max;i++){
      if($('#bonlivraison_id'+i).is(':checked')){//alert();
          remisel=$('#remise'+i).val()||0;
           ttbl=Number($('#bonlivraison_id'+i).attr('mnt'))+Number(ttbl);
           remise=Number(remise)+Number(remisel);
          
      } 
   }
   //console.log(ttbl);
  // console.log(remise);
   ttpayer=Number(ttbl)-Number(remise);
    $('#ttpayer').val((ttpayer).toFixed(3));
   test= $('#typeremise').is(':checked');
   if(test){
   val= $('.remisetc').val();
   $('.remiset').val(val);
   }else{
       val= $('.remisetc').val();
       ttpayer=$('#ttpayer').val();
       valeur=((Number(val)*Number(ttpayer))/100).toFixed(3);
       $('.remiset').val(valeur);
   }
  remiseg=$('.remiset').val();
   ttnpayer=Number(ttpayer)-Number(remiseg);
   
    $('#netapayer').val((ttnpayer).toFixed(3));
});
// remise total pour regelment 
$('.remisetc').on('keyup',function(){
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
//  val=$('.remiset').val();
//      ttpayer=(ttpayer-val).toFixed(3);
//    $('#netapayer').val(ttpayer);
     max= $('#max').val(); //alert();
   ttbl=0;
   //remiseg=$('.remiset').val();
   remise=0;
   for(i=0;i<=max;i++){
      if($('#bonlivraison_id'+i).is(':checked')){//alert();
          remisel=$('#remise'+i).val()||0;
           ttbl=Number($('#bonlivraison_id'+i).attr('mnt'))+Number(ttbl);
           remise=Number(remise)+Number(remisel);
          
      } 
   }
   //console.log(ttbl);
  // console.log(remise);
   ttpayer=Number(ttbl)-Number(remise);
    $('#ttpayer').val((ttpayer).toFixed(3));
   test= $('#typeremise').is(':checked');
   if(test){
   val= $('.remisetc').val();
   $('.remiset').val(val);
   }else{
       val= $('.remisetc').val();
       ttpayer=$('#ttpayer').val();
       valeur=((Number(val)*Number(ttpayer))/100).toFixed(3);
       $('.remiset').val(valeur);
   }
  remiseg=$('.remiset').val();
   ttnpayer=Number(ttpayer)-Number(remiseg);
   
    $('#netapayer').val((ttnpayer).toFixed(3));
    
});
// type remise
$('.typeremise').on('click',function(){
// test= $('#typeremise').is(':checked');
//   if(test){
//   val= $('.remisetc').val();
//   $('.remiset').val(val);
//   }else{
//       val= $('.remisetc').val();
//       ttpayer=$('#ttpayer').val();
//       valeur=((Number(val)*Number(ttpayer))/100).toFixed(3);
//       $('.remiset').val(valeur);
//   }
//  val=$('.remiset').val();
//   ttpayer=(ttpayer-val).toFixed(3);
//    $('#netapayer').val(ttpayer);
     max= $('#max').val(); //alert();
   ttbl=0;
   //remiseg=$('.remiset').val();
   remise=0;
   for(i=0;i<=max;i++){
      if($('#bonlivraison_id'+i).is(':checked')){//alert();
          remisel=$('#remise'+i).val()||0;
           ttbl=Number($('#bonlivraison_id'+i).attr('mnt'))+Number(ttbl);
           remise=Number(remise)+Number(remisel);
          
      } 
   }
   //console.log(ttbl);
  // console.log(remise);
   ttpayer=Number(ttbl)-Number(remise);
    $('#ttpayer').val((ttpayer).toFixed(3));
   test= $('#typeremise').is(':checked');
   if(test){
   val= $('.remisetc').val();
   $('.remiset').val(val);
   }else{
       val= $('.remisetc').val();
       ttpayer=$('#ttpayer').val();
       valeur=((Number(val)*Number(ttpayer))/100).toFixed(3);
       $('.remiset').val(valeur);
   }
  remiseg=$('.remiset').val();
   ttnpayer=Number(ttpayer)-Number(remiseg);
   
    $('#netapayer').val((ttnpayer).toFixed(3));
});
// choix de mode reglement 
$('.modereglement').on('change',function(){
 index= $(this).attr('index');  
 val=$(this).val();  
console.log(index);
 if(Number(val)==1){
    // alert();
   //$('#trechance'+index).attr('class','') ;
   $('#trechancea'+index).hide() ;
   $('#trechanceb'+index).hide() ;
   // $('#trnum'+index).attr('class','') ;
    $('#trnuma'+index).hide() ;
     $('#trnumb'+index).hide() ;
 }else{
    //  alert('aa');
   $('#trechancea'+index).show();
   $('#trechanceb'+index).show();
   //$('#trechance'+index).attr('class','display:none') ;
    $('#trnuma'+index).show() ;
     $('#trnumb'+index).show() ;
    //$('#trnum'+index).attr('class','display:none') ;  
 }
});
// recalcule du montant payer dans le reglement 
$('.mnt').on('keyup',function(){
    v=$('#index').val();//console.log(v);
    tt=0;
    th=0;
    for(i=0;i<=v;i++){
       th= $('#montant'+i).val();  console.log(th);
     tt=Number(tt)+Number(th);  
    }
    console.log(tt);
    $('#Montant').val(tt);
});
});
function a (valeur,index,champ){
    // alert('valeur---'+valeur+'---index---'+index+'---champ---'+champ);
   marque_id= $('#ProductionMarqueId').val()||0;
//   index=$(this).attr('index');
//   champ=$(this).attr('champ');
//   champ=1;
//   if(champ=='article_id'){
//       champ=2;
//   }
//   
//    alert(marque_id);
    if(champ==2){
         $.ajax({
            type: "POST",
            data: {
                valeur: valeur, 
                index: index,
                marque_id:marque_id
            },
            url: wr+"Productions/selectname/",
             dataType : "html",
                global : false
        }).done(function(data){
            select=data
           $("#divreference"+index).html("");
         $("#divreference"+index).html(select);
          uniform_select("reference"+index);
     });
     
  
    }
     if(champ==1){
          $.ajax({
            type: "POST",
            data: {
                valeur: valeur, 
                index: index,
                marque_id:marque_id
            },
            url: wr+"Productions/selectreference/",
             dataType : "html",
                global : false
        }).done(function(data){
            console.log(data);
            select=data
           $("#divarticle_id"+index).html("");
        $("#divarticle_id"+index).html(select);
          uniform_select("article_id"+index);
     });
       
     }
}