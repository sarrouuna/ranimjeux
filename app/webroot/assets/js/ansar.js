$(document).ready(function ()
{
    $('.selectptvente').on('change', function () {
        idfamille = $(this).val();
        modele = 'Utilisateur';
        $.ajax({
            type: "POST",
            data: {
                id: idfamille,
                modele: modele
            },
            url: wr + "pointdeventes/listesocietes/",
            dataType: "json"
        }).done(function (data) {
            //console.log(data);
            $('#divptvt').show();
            $('#divptvente').html('');
            $('#divptvente').html(data.select);
            uniform_select('Pointdevente_id');
            
            //$('#divdepot').show();
            $('#div_depot').html('');
            $('#div_depot').html(data.selectdepot);
            uniform_select('depot_id');
            
            
            
            $('#divsoc').show();
            $('#divsociete').html('');
            $('#divsociete').html(data.selecte);
            uniform_select('Societe_id');
        });

    });
    
    
    $('.testdateexpiration').on('mousemove',function(){
        enreg='oui';
        max=$('#index').val();
        for(i=0;i<=max;i++){
            date_exp=$('#date_exp'+i).val();
            sup=$('#sup'+i).val()||0;
            if(sup!=1){
                if(date_exp=='__/__/____'){
                    enreg='non';
                }
            }
        }
        if(enreg=='non'){
            bootbox.alert('Verifiez Date Expiration !!', function () {});
        }
    }) 	
    
    
    $('.btntras').on('click', function () {
        //alert();
        index = $(this).attr('id');
       //alert(index);
        if (index=="aff") {
            $('#verif').val(0);
        }else
        {
            $('#verif').val(1);
        }
    });
    $('.getfacturefrs').on('change', function () {
        clientid = $('#client_id').val();
        $.ajax({
            type: "POST",
            data: {
                clientid: clientid

            },
            url: wr + "Factureavoirfrs/getfactures/",
            dataType: "html",
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            $('#divfacture').html('');
            $('#divfacture').html(data);
            uniform_select('factureclient_id');
        })
    })

    $('.typefactureans').on('change', function () {
        typefacture_id = $('#typefacture_id').val();
        table = $('.ajouterligne_reception').attr('table');
        index = $('.ajouterligne_reception').attr('index');
        tr = $('.ajouterligne_reception').attr('tr');
        //alert(typefacture_id);
        if (typefacture_id == 1) {
            ajouter_ligne_reception(table, index, tr);
            $('.favr').show();
            $('.favf').show();
            $('.favrchmps').show();
            $('.favrchmpss').show();
            $('#Total_TTC').attr('readonly', true);


        } else if (typefacture_id == 2) {
            //alert("2");
            $('.favf').show();
            $('.favr').hide();
            $('.favrchmps').hide();
            $('.favrchmpss').hide();
            $('#Total_TTC').attr('readonly', false);

        } else {
            // alert("2e");
            $('.favr').hide();
            $('.favf').hide();
            $('.favrchmps').hide();
            $('.favrchmpss').hide();
            $('#Total_TTC').attr('readonly', false);

        }
    })
    $('.removeDisabledButton').on('mousemove', function (event) {

        $('.artdisabled').removeAttr('disabled');
    });

    $('.verifqteavoir').on('keyup', function () {
        //alert();
        index = $(this).attr('index');
        qte = $('#quantite' + index).val() || 0;
        quantitett = $('#quantitett' + index).val() || 0;

        if (Number(qte) > Number(quantitett)) {
            bootbox.alert('Oups!! Quantité > Quantité facture', function () {});
            $('#quantite' + index).val("");
        }
    });
    
       $('.verifqteavoir2').on('keyup', function () {
        //alert();
        index = $(this).attr('index');
        qte = $('#quantite' + index).val() || 0;
        quantitett = $('#quantitestock' + index).val() || 0;

        if (Number(qte) > Number(quantitett)) {
            bootbox.alert('Oups!! Quantité > Quantité facture', function () {});
            $('#quantite' + index).val("");
        }
    });

    $('.verifstock').on('keyup', function () {
        //alert();
        index = $(this).attr('index');
        qte = $('#quantite' + index).val() || 0;
        quantitestock = $('#quantitestock' + index).val() || 0;

        $.ajax({
            type: "POST",
            data: {
                qte: qte,
                quantitestock: quantitestock,
                index: index
            },
            url: wr + "Factureavoirfrs/verifqte/",
            dataType: "html",
            global: false //}l'envoie'
        }).done(function (data) {
            if (data == 0) {
                bootbox.alert('Oups!! Stock insuffusant', function () {});
                // return false;
                $($('#quantitestock' + index)).parent().parent().parent().parent().hide();
                $('#sup' + index).val('1');
            }
        });


    });
});
            