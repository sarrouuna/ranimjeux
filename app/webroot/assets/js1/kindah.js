function calcul(){
    //                ---- Montant Heure ----
            nb_h=$('#PaieNbheur').val();
            prix_h=$('#PaiePrixheur').val();
            montant_h=Number(nb_h)*Number(prix_h);
            $('#PaieMontantheur').val(Number(montant_h).toFixed(3));
            
    //                ---- Montant jour ----
            nb_j=$('#PaieNbjour').val();
            prix_j=$('#PaiePrixjour').val();
            montant_j=Number(nb_j)*Number(prix_j);
            $('#PaieMontantjour').val(Number(montant_j).toFixed(3));
            
     //                ---- Montant Heure Dimanche ----
            nb_h_dim=$('#PaieNbheurdimanche').val();
            taux=$('#PaieTaux').val();
            montant_h_dim=Number(nb_h_dim)*Number(prix_h)*Number(taux);
            $('#PaieMontanthdtaux').val(Number(montant_h_dim).toFixed(3));
            
    //                ---- Montant Jour Dimanche ----        
            nh_j_dim=$('#PaieNbjourdimanche').val();
            taux=$('#PaieTaux').val();
            montant_j_dim=Number(nh_j_dim)*Number(prix_j)*Number(taux);
            $('#PaieMontantjdtaux').val(Number(montant_j_dim).toFixed(3));
            
    //       ----- Salaire (somme) -----
                salaire=Number(montant_h)+Number(montant_j)+Number(montant_h_dim)+Number(montant_j_dim); 
                $('#PaieSalaire').val(Number(salaire).toFixed(3));
                            
    //      ---------Total Paie  -------
            acompte=$('#PaieAcompteId').val();
            totalPaie=Number(salaire)-Number(acompte);
            $('#PaieTotalpaie').val(Number(totalPaie).toFixed(3));
    //      -------- Reste ---------
            donne=$('#PaieDonne').val();
            reste=Number(totalPaie)-Number(donne);
            $('#PaieReste').val(Number(reste).toFixed(3));
    
    //      ------ Salaire de base ------
            prix_h=$('#PaiePrixheur').val();        
            prix_j=$('#PaiePrixjour').val();
              
}

$(document).ready(function() {
    
    $("#PersonnelType").on('change',function(){
        //alert('aaaa');
        val=$(this).val();
        if(val=='ouvrier'){
            $('#prixh').show();
            $('#prixj').hide();
        }
        if(val=='cadre'){
            $('#prixj').show();
            $('#prixh').hide();
        }
    })
//    
    
    $('#PaiePersonnelId,#PaieMoiId,#PaieAnneeId').on('change',function(){
//              --- recup les prix ----
    personnel=$('#PaiePersonnelId').val()||0;
    mois=$('#PaieMoiId').val()||0;
    annee=$('#PaieAnneeId').val()||0;
    $.ajax({
            type: "POST",
            url: wr+"Paies/select/"+personnel+"/"+mois+"/"+annee,
            dataType : "JSON"
        }).done(function(data){
            console.log(data);
            $('#PaiePrixheur').val(Number(data.heure).toFixed(3));
            $('#PaiePrixjour').val(Number(data.jour).toFixed(3));
            $('#PaieTaux').val(Number(data.sup).toFixed(3));
            $('#PaieAcompteId').val(Number(data.acompte).toFixed(3));
            $('#PaieSalairebase').val(Number(data.salairebase).toFixed(3));
            if(data.type=='ouvrier'){
            $('#houvrier').show();
            $('#jcadre').hide();
        }
        if(data.type=='cadre'){
            $('#jcadre').show();
            $('#houvrier').hide();
        }
            calcul();
        });
   });
    
    $('.calculpaie').on('keyup',function(){
        salairebase=$('#PaieSalairebase').val()||0;
	personnel=$('#PaiePersonnelId').val()||0;
        mois=$('#PaieMoiId').val()||0;
        annee=$('#PaieAnneeId').val()||0;
        jour=$('#PaieNbjour').val()||0;
        heur=$('#PaieNbheur').val()||0;
        if(personnel!=0 && personnel!=0 && personnel!=0){
           $('#aa').show();
        }
        if(personnel==0 || personnel==0 || personnel==0 ){
           $('#aa').hide();
        }
        calcul();
    });
 
     $("#UserType").on('change',function(){
        val=$(this).val();
        if(val=='admin'){
            $('#nom').show();
            $('#anim').hide();
        }
        if(val=='animateur'){
            $('#anim').show();
            $('#nom').hide();
        }
    })

    
});
$('#PersonnelPrixheur').on('keyup',function(){
            Salairebase=$('#PersonnelSalairebase').val()||0;  
            Prixjour=$('#PersonnelPrixjour').val()||0;
            Prixheur=$('#PersonnelPrixheur').val()||0;
            PersonnelType=$('#PersonnelType').val(); 
            if((PersonnelType=='ouvrier')){
               salaire=Number(Prixheur)*208; 
              $('#PersonnelSalairebase').val(Number(salaire).toFixed(3));    
            }
           
 
})
 $('#PersonnelPrixjour').on('keyup',function(){
            Salairebase=$('#PersonnelSalairebase').val()||0;  
            Prixjour=$('#PersonnelPrixjour').val()||0;
            Prixheur=$('#PersonnelPrixheur').val()||0;
            PersonnelType=$('#PersonnelType').val(); 
            if((PersonnelType=='cadre')){
               salaire=Number(Prixjour)*26;
              $('#PersonnelSalairebase').val(Number(salaire).toFixed(3));    
            }
        });
        $('#PersonnelSalairebase').on('keyup',function(){
            Salairebase=$('#PersonnelSalairebase').val()||0;  
            Prixjour=$('#PersonnelPrixjour').val()||0;
            Prixheur=$('#PersonnelPrixheur').val()||0;
            PersonnelType=$('#PersonnelType').val(); 
            if((PersonnelType=='cadre')){
               salaire=Number(Salairebase)/26;
              $('#PersonnelPrixjour').val(Number(salaire).toFixed(3));    
            }
            if((PersonnelType=='ouvrier')){
               salaire=Number(Salairebase)/208;
              $('#PersonnelPrixheur').val(Number(salaire).toFixed(3));    
            }
        });
        
        
        
        $('#remisec').on('keyup',function(){
            solde=$('#tsolde').val()||0;
            remise=$('#remisec').val()||0;
            //typeremise=$('.typeremise').val(); 
            typeremise=$('.tremise:checked').val();
           // alert(solde);
            if((typeremise=='d')){
               netapayer=Number(solde)-Number(remise);
              $('#netapayer').val(Number(netapayer).toFixed(3));    
            }
            if((typeremise=='p')){
               netapayer=Number(solde)-(Number(solde)*(Number(remise)/100));
              $('#netapayer').val(Number(netapayer).toFixed(3));    
            }
        });
        $('.tremise').on('change',function(){
            solde=$('#tsolde').val()||0;
            remise=$('#remisec').val()||0;
            typeremise=$(this).val();
           // alert(remise);
            if((typeremise=='d')){
               netapayer=Number(solde)-Number(remise);
              $('#netapayer').val(Number(netapayer).toFixed(3));
              $('#typpp').val('Dinar');  
            }
            if((typeremise=='p')){
               netapayer=Number(solde)-(Number(solde)*(Number(remise)/100));
              $('#netapayer').val(Number(netapayer).toFixed(3));  
              $('#typpp').val('Pourcentage');
            }
        });