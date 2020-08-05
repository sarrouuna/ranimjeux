$(document).ready(function ()
{
    
     $('.setQuerycode').on('blur', function () {
          code=$(this).val()||0;
          index= $(this).attr('index');
          id=0;
          $.ajax({
            type: "POST",
            data: {
                code: code
            },
            async: false,
            url: wr + "Bonlivraisons/codearticle/" ,
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            id=data.id;
            if(id==0){
                $('#quantite' + index).val('');
                $('#Designation' + index).val('');
                $('#designation' + index).val('');
                $('#prixhtva' + index).val('');
                $('#remise' + index).val('');
                $('#prixnet' + index).val('');
                $('#puttc' + index).val('');
                $('#tva' + index).val('');
                $('#quantitestock' + index).val('');
                 $('#quantite' + index).focus();
            }else{
                setQuerycode(id, code, index);
            }
        })
         
     })
    $('.NumeroInf').on('click', function () {
        num=$('#numero').val()||0;
         $('#aa').hide();
        if(num!=0){
            pointdevente_id = $('#pointdevente_id').val();
            model = $('#model').val();
            nature = $('#nature').val()||0;

            //alert(pointdevente_id);
            $.ajax({
                type: "POST",
                data: {
                    id: pointdevente_id,
                    model: model,
                    nature: nature,
                    num: num,
                },
                url: wr + "Bonlivraisons/getlesnums/",
                dataType: "json",
                global: false //}l'envoie'
            }).done(function (data) { 
                if(data.verif==0){
                     $('#aa').show();
                    bootbox.alert('Aucun numero', function () {});
                    return false;
                }else{
                    $('#div_num').html(data.select);
                   
                }
//                $('#numero').val(data.numspecial);
//                $('#numeroconca').val(data.mm);
            })
        }else{
            $('#aa').show();
                    bootbox.alert('choisir une point de vente SVP', function () {});
                    return false;
        }
    })
    
     $(".calculcoutrevient").on('keyup', function () {
        champ= $(this).attr('champ');
        remise = $("#remise").val() || 0; 
        if(champ=='coutrevient'){
            prix = $("#coutrevient").val() || 0;
            puttc = Number(prix) / (1 - (Number(remise) / 100));
            $("#prixav_remise").val(puttc.toFixed(3));
        }else{
            prix = $("#prixav_remise").val() || 0;
            puttc = Number(prix) * (1 - (Number(remise) / 100));
             $("#coutrevient").val(puttc.toFixed(3));
        }
        calculputtc();
        calculmarge();
    });
    
    //************************************************************************ 
    $('.libreFR').on('click', function () {
        index = $('#index').val() || 0;
        max = $('#max').val() || 0;
        maximp = $('#maximpaye').val() || 0;
        devisefournisseur = $('#devisefournisseur').val() || 0;
        $('#ttpayer').val('');
        $('#netpayer').val('');
        //$('#Montant').val('');
        for (i = 0; i <= Number(index); i++) {
           // $('#montant' + i).val('');
        }
        $('#importation_id').val('');
        if ($(this).prop('checked')) {
            val = $(this).val();
            if (val == 0) {
                $('#thead').show();
                $('#thead2').show();
                $('#thead3').show();
                for (i = 0; i <= Number(max); i++) {
                    $('#trfacture' + i).show();
                }
                for (i = 0; i <= Number(maximp); i++) {
                    $('#trfactureimp' + i).show();
                }
                $('#totalefacture').show();
                //$('#montantpayer').show();
                $('#netapayer').show();
                $('#btnenr').prop("disabled", true);
                $('#divimportation').hide();
            } else {
                $('#btnenr').prop("disabled", false);
                $('#thead').hide();
                $('#thead2').hide();
                $('#thead3').hide();
                for (i = 0; i <= Number(max); i++) {
                    $('#trfacture' + i).hide();
                    $('#importation_id' + i).prop('checked', false);
                    $('#facture_id' + i).prop('checked', false);
                    $('#Montantregler'+i).val('');
                    $('#Montantregler'+i).hide();
                }
                for (i = 0; i <= Number(maximp); i++) {
                    $('#trfactureimp' + i).hide();
                    $('#impaye_id' + i).prop('checked', false);
                    $('#Montantreglerimpaye'+i).val('');
                    $('#Montantreglerimpaye'+i).hide();
                }
                $('#totalefacture').hide();
                $('#netapayer').hide();
                //$('#montantpayer').show();
                if (devisefournisseur != 1) {
                    $('#divimportation').show();
                }
                

            }
        }
    });
    
     $('.libreFR').on('click', function () {
        if ($(this).prop('checked')) {
            val = $(this).val();
            if (val == 1) {
                $("#inputlibre").val("1");

            } else {
                $("#inputlibre").val("0");

            }
        }
    });
    
     $('.calculereglement').on('click', function () {
        testt = false;
        ttbl = 0;
        ttpayer = 0;
        max = $('#max').val();
        for (i = 0; i <= max; i++) {
            if ($('#facture_id' + i).is(':checked')) {//alert();
                testt = true;
                ttbl = Number($('#facture_id' + i).attr('mnt')) + Number(ttbl);
            }
        }
        maximpaye = $('#maximpaye').val();
        for (i = 0; i <= maximpaye; i++) {
            if ($('#impaye_id' + i).is(':checked')) {//alert();
                testt = true;
                ttbl = Number($('#impaye_id' + i).attr('mnt')) + Number(ttbl);
            }
        }
        if (testt == true) {
            $('#btnenr').prop("disabled", false);
        } else {
            $('#btnenr').prop("disabled", true);
        }
        ttpayer = Number(ttbl);
        $('#ttpayer').val((ttpayer).toFixed(3));
        $('#netpayer').val((ttpayer).toFixed(3));
        index = $(this).attr('index');
        if ($(this).attr('champ') == "facture") {
            $('#Montantregler' + index).focus();
        } else {
            $('#Montantreglerimpaye' + index).focus();
        }

    });
    //**************************************************************
 })
 
 function changerNumero(){
     //alert('ff');
     selectnum = $('#selectnum').val();
     num1 = "'"+selectnum+"'"; 
     num2= num1.split("/");
     num3  = parseInt(num2[1]);   
     $('#numero').val(selectnum);
     $('#numeroconca').val(num3); 
     $('#div_num').html('<br>');
     $('#aa').show();
 }
 
 function calculputtc() {
//        alert();
        prixachat = $("#coutrevient").val() || 0;
        margepourcentage = $("#margepourcentage").val() || 0;
        prixvente = $("#prixvente").val() || 0;
        tva = $("#tva").val() || 0;
        prixventee = Number(prixachat) + (Number(prixachat) * (Number(margepourcentage) / 100));
//        $("#prixvente").val(prixventee.toFixed(3));
        puttc = Number(prixventee) * (1 + (Number(tva) / 100));
        $("#prixuttc").val(puttc.toFixed(3));

    }
    
 function calculmarge(){ 
         prixachat = $('#coutrevient').val(); //alert (prixachat);
         margepourcentage = $('#margepourcentage').val(); //alert (margepourcentage);
         prixvente = $('#prixvente').val(); //alert (prixvente);
         if((margepourcentage!=0)&(prixachat!=0)){
         prixvente=Number(prixachat)+ (Number(prixachat)*(Number(margepourcentage)/100));
          $('#prixvente').val(prixvente.toFixed(3));
        }
         
    }