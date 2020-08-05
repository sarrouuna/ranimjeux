$(document).ready(function(){
$('#contact').on('click',function(){
    ajouter_ligne('tabcontact','index');
})
$('.sup').on('click',function(){
    index= $(this).attr('index');
    bootbox.confirm("voulez vous effacer cette enregistrement?", function(result) {
        if(result){
    $('.sup').each(function(){
        ind=$(this).attr('index');
        if(ind==index){
           $(this).parent().parent().hide();
           $('#sup'+index).val('1'); 
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
page=$('.page').val();
        if(page=='commande'){
       $('label').each(function(){
           //var ch='article_id';
           val=$(this).attr('for');
           if(val.indexOf('famille_id')!=-1||val.indexOf('Qte')!=-1||val.indexOf('observation')!=-1){//alert(val.indexOf('article_id'));
               $(this).remove();
           }
       }
               )
        }
$('#verif').on('click',function(){ 
//    ----- verifier les champs de page article -----
       plein1=$('#ArticleFamilleId').val(); 
       if(!plein1) {
           bootbox.alert("choisir famille !", function() {
            notificationCenter( 
            );        
       })
       return false;
   }
       plein2=$('#ArticleModeleId').val(); 
       if(!plein2) {
           bootbox.alert("choisir modele !", function() {
            notificationCenter( 
            );        
       })
       return false;
   }
       plein3=$('#ArticleReferenceId').val(); 
       if(!plein3) {
           bootbox.alert("choisir reference !", function() {
            notificationCenter( 
            );        
       })
       return false;
   }
       plein4=$('#ArticleCouleurId').val(); 
       if(!plein4) {
           bootbox.alert("choisir couleur !", function() {
            notificationCenter( 
            );        
       })
       return false;
   }
   })  
   $("#famille").on('click',function(e){
//       --- test nb famille -----
         e.preventDefault(); 
       val=$('#FamilleName').val();
       val2=$('#FamilleCode').val();//return false; 
       $.ajax({
            type: "POST",
            url: wr+"Familles/select/"+val+"/"+val2,
            dataType : "JSON"
        }).done(function(data){
            if(Number(data[0])>0){ 
            bootbox.alert("Famille existant !", function() {
            notificationCenter( 
            );  
       })
            }else{
             if(Number(data[1])>0){ 
            bootbox.alert("Code existant !", function() {
            notificationCenter( 
            );  
       })
            }   
            }
            if((Number(data[0])==0)&&(Number(data[1])==0)){
                $('#defaultForm').submit();
            } 
        });  
   }) 
   $("#modele").on('click',function(e){
//       --- test nb modele -----
         e.preventDefault(); 
       val=$('#ModeleName').val();
       val2=$('#ModeleCode').val();//return false; 
       $.ajax({
            type: "POST",
            url: wr+"Modeles/select/"+val+"/"+val2,
            dataType : "JSON"
        }).done(function(data){
            if(Number(data[0])>0){ 
            bootbox.alert("Modele existant !", function() {
            notificationCenter( 
            );  
       })
            }else{
             if(Number(data[1])>0){ 
            bootbox.alert("Code existant !", function() {
            notificationCenter( 
            );  
       })
            }   
            }
            if((Number(data[0])==0)&&(Number(data[1])==0)){
                $('#defaultForm').submit();
            } 
        });  
   }) 
//   $("#reference").on('click',function(e){
////       --- test nb reference -----
//         e.preventDefault(); 
//       val=$('#ReferenceReference').val();//return false; 
//       $.ajax({
//            type: "POST",
//            url: wr+"References/select/"+val,
//            dataType : "JSON"
//        }).done(function(data){
//            //alert(data);
//            if(Number(data)>0){ 
//            bootbox.alert("Reference existante !", function() {
//            notificationCenter( 
//            );  
//       })
//            }
//            if(Number(data)==0){
//                $('#defaultForm').submit();
//            } 
//        });  
//   }) 
   $("#couleur").on('click',function(e){
//       --- test nb couleur -----
         e.preventDefault(); 
       val=$('#CouleurName').val();
       val2=$('#CouleurCode').val();//return false; 
       $.ajax({
            type: "POST",
            url: wr+"Couleurs/select/"+val+"/"+val2,
            dataType : "JSON"
        }).done(function(data){
            if(Number(data[0])>0){ 
            bootbox.alert("Couleur existant !", function() {
            notificationCenter( 
            );  
       })
            }else{
             if(Number(data[1])>0){ 
            bootbox.alert("Code existant !", function() {
            notificationCenter( 
            );  
       })
            }   
            }
            if((Number(data[0])==0)&&(Number(data[1])==0)){
                $('#defaultForm').submit();
            } 
        });  
   }) 
   
   $("#taille").on('click',function(e){
//       --- test nb Taille -----
         e.preventDefault(); 
       val=$('#TailleName').val();
       val2=$('#TailleCode').val();//return false; 
       $.ajax({
            type: "POST",
            url: wr+"Tailles/select/"+val+"/"+val2,
            dataType : "JSON"
        }).done(function(data){
            if(Number(data[0])>0){ 
            bootbox.alert("Taille existant !", function() {
            notificationCenter( 
            );  
       })
            }else{
             if(Number(data[1])>0){ 
            bootbox.alert("Code existant !", function() {
            notificationCenter( 
            );  
       })
            }   
            }
            if((Number(data[0])==0)&&(Number(data[1])==0)){
                $('#defaultForm').submit();
            } 
        });  
    }) 
   $("#type").on('click',function(e){
//       --- test nb Type -----
         e.preventDefault(); 
       val=$('#TypeName').val();
       val2=$('#TypeCode').val();//return false; 
       $.ajax({
            type: "POST",
            url: wr+"Types/select/"+val+"/"+val2,
            dataType : "JSON"
        }).done(function(data){
            if(Number(data[0])>0){ 
            bootbox.alert("Type existant !", function() {
            notificationCenter( 
            );  
       })
            }else{
             if(Number(data[1])>0){ 
            bootbox.alert("Code existant !", function() {
            notificationCenter( 
            );  
       })
            }   
            }
            if((Number(data[0])==0)&&(Number(data[1])==0)){
                $('#defaultForm').submit();
            } 
        });  
      }) 
   $("#verif").on('click',function(e){
//       --- test article -----
         e.preventDefault(); 
       fam=$('#ArticleFamilleId').val();
       ref=$('#ArticleReferenceId').val();
       mod=$('#ArticleModeleId').val();
       cou=$('#ArticleCouleurId').val();
       tai=$('#ArticleTailleId').val();
       typ=$('#ArticleTypeId').val();
       
       $.ajax({
            type: "POST",
            url: wr+"Articles/select/"+fam+"/"+ref+"/"+mod+"/"+cou+"/"+tai+"/"+typ, 
            dataType : "JSON"
        }).done(function(data){
           // alert(data);
            if(Number(data)>0){ 
            bootbox.alert("Article existante !", function() {
            notificationCenter( 
            );  
       })
            }
            if(Number(data)==0){
              $('#defaultForm').submit();
            } 
        });  
        
       // alert(url);
   }) 
   
   
   $("#ArticleReference").on('change',function(e){
//       --- test nb taille -----
         e.preventDefault(); 
       val=$(this).val();//return false; 
       //alert(val);
       $.ajax({
            type: "POST",
            url: wr+"Articles/select_1/"+val,
            dataType : "JSON"
        }).done(function(data){
            //alert(data);
            if(Number(data)>0){ 
            bootbox.alert("Référence existante !", function() {
            notificationCenter( 
            ); 
            $("#ArticleReference").val('');
       })
            }
            if(Number(data)==0){
                $('#defaultForm').submit();
            } 
        });  
  
       
       
       
   })
    
    $('.paq').on('keyup',function(){ 
//        index= $(this).attr('index');
  val=$(this).val();
//  index= $(this).attr('index');
  fam= $(this).attr('fam');
  lig= $(this).attr('lig');
  $('#'+fam+'qte'+lig).val(val*12);
//   alert(index); 
    })
 $('.qte').on('keyup',function(){ 
//        index= $(this).attr('index');
  val=$(this).val();
//  index= $(this).attr('index');
  fam= $(this).attr('fam');
  lig= $(this).attr('lig');
  $('#'+fam+'paq'+lig).val(val/12);
//   alert(index); 
    }) 
    
    $('#inventaire_id').on('click',function(){  
  dat=$('#InventaireDate').val(); 
   if(dat=='__/__/____'){
        bootbox.alert("Choisir date !", function() {
            notificationCenter( 
            );  })
   return false;
   }
  val=$('#InventaireDepotId').val(); 
    if(val==''){
        bootbox.alert("Choisir depôt !", function() {
            notificationCenter( 
            );  })
   return false;
   }
        i=0;
    $('.paq').each(function(){
        ind=$(this).val();
        if((ind!='')&&(ind!=0)){ 
            i=1;
        }
    })
    if(i==0){
        bootbox.alert("Veuillez saisir des quantités  !", function() {
            notificationCenter( 
            );  })
   return false;
   }
   })


 $("#BoncommandeClientId").on('change',function(){
//       --- bon commande client adresse -----
//alert();
       $('.adrcli').html("");
       val=$(this).val(); 
       $.ajax({
            type: "POST",
            url: wr+"Boncommandes/select/"+val,
            dataType : "html"
        }).done(function(data){
          $('.adrcli').append(data); 
          uniform_select('BoncommandeLigneclientId');
    });  
   }) 





});

