$(document).ready(function() {



    //supprimer les labels
    page = $('.ipage').val();


    if (page == 'bc') {
        
        $('label').each(function() {
            val = $(this).attr('for');
            if (val == 'qte_piece' || val =="matierepremiere_id" || val =="tva" 
                    || val == "remise" || val == "prix_ht" || val =="prix_unit"
                    || val == "prix_unit0" || val == "qte_piece0" || val == "prix_ht0" || val == "remise0"
                    || val == "tva0") {
                $(this).remove();

            }
        });
    }

//demandes ligne lot vérifier si qte dans le stock est supérieur à celle qui va sortir
    $('.quantite').each(function() {
        n = $('#index').val();
//        alert(n);
        $(this).on('change', function() {

            for (i = 0; i < n; i++) {
                qte_pqt = $('.qte_pqt' + i).attr("value");
                qte_piece = $('.qte_piece' + i).attr("value");

                if (qte_pqt < $(this).val() || qte_piece < $(this).val()) {
                    alert('Vous devez vérifier votre stock!')
                }
            }

        });
    });

    $('.quantite').each(function() {
        $(this).on('keyup', function() {
            $('#submitInventory').removeAttr("disabled");
//            alert('ok');

        });
    });

    $('.quantite').each(function() {
        $(this).on('keyup', function() {
            $('#submitLot').removeAttr("disabled");
//            alert('ok');

        });
    });



//afficher pour chaque fournisseur ses matiéres premiéres BC
    $("#BcFournisseurId").on('change', function() {
//       --- bon commande client adresse -----
// alert();
        $('.adrcli').html("");


        val = $(this).val();


        $.ajax({
            type: "POST",
            url: wr + "Bcs/select/" + val,
            dataType: "html"
        }).done(function(data) {

//            alert(data+'----');
            $('.adrcli').append(data);
            uniform_select('matierepremiere_id');
        });
    })
//afficher pour chaque fournisseur ses matiéres premiéres BL
    $("#BlFournisseurId").on('change', function() {
//       --- bon commande client adresse -----
// alert();
        $('.adrcli').html("");


        val = $(this).val();

//      alert(val);
        $.ajax({
            type: "POST",
            url: wr + "Bls/select_1/" + val,
            dataType: "html"
        }).done(function(data) {

//            alert(data+'----');
            $('.adrcli').append(data);
            uniform_select('matierepremiere_id');
        });
    })




//Vérification MP si un code existe déjà dans la base
    $("#MatierepremiereCode").on('change', function(e) {
//       --- test article -----
//        e.preventDefault();
        code = $('#MatierepremiereCode').val();


        $.ajax({
            type: "POST",
            url: wr + "Matierepremieres/select/" + code,
            dataType: "JSON"
        }).done(function(data) {
            // alert(data);
            if (Number(data) > 0) {
                bootbox.alert("Matiére premiére existante !", function() {
                    notificationCenter(
                            );
                })
            }
//            if (Number(data) == 0) {
//                $('#defaultForm').submit();
//            }
        });

        // alert(url);
    });
//Vérification si un code existe déjà dans la base
    $("#UniteCode").on('change', function(e) {
//       --- test article -----
//        e.preventDefault();
        code = $('#UniteCode').val();


        $.ajax({
            type: "POST",
            url: wr + "Unites/select/" + code,
            dataType: "JSON"
        }).done(function(data) {
            // alert(data);
            if (Number(data) > 0) {
                bootbox.alert("Unité existante !", function() {
                    notificationCenter(
                            );
                })
            }
//            if (Number(data) == 0) {
//                $('#defaultForm').submit();
//            }
        });

        // alert(url);
    });
//Vérification si un code existe déjà dans la base
    $("#EmplacementCode").on('change', function(e) {
//       --- test article -----
//        e.preventDefault();
        code = $('#EmplacementCode').val();


        $.ajax({
            type: "POST",
            url: wr + "Emplacements/select/" + code,
            dataType: "JSON"
        }).done(function(data) {
            // alert(data);
            if (Number(data) > 0) {
                bootbox.alert("Emplacement existant !", function() {
                    notificationCenter(
                            );
                })
            }
//            if (Number(data) == 0) {
//                $('#defaultForm').submit();
//            }
        });

        // alert(url);
    });
//Vérification si un code existe déjà dans la base
    $("#TypestockCode").on('change', function(e) {
//       --- test article -----
//        e.preventDefault();
        code = $('#TypestockCode').val();


        $.ajax({
            type: "POST",
            url: wr + "Typestocks/select/" + code,
            dataType: "JSON"
        }).done(function(data) {
            // alert(data);
            if (Number(data) > 0) {
                bootbox.alert("Emplacement existant !", function() {
                    notificationCenter(
                            );
                })
            }
//            if (Number(data) == 0) {
//                $('#defaultForm').submit();
//            }
        });

        // alert(url);
    });
//Vérification si un code existe déjà dans la base
    $("#MachineNumero").on('change', function(e) {
//       --- test article -----
//        e.preventDefault();
        code = $('#MachineNumero').val();


        $.ajax({
            type: "POST",
            url: wr + "Machines/select/" + code,
            dataType: "JSON"
        }).done(function(data) {
            // alert(data);
            if (Number(data) > 0) {
                bootbox.alert("Machine existante !", function() {
                    notificationCenter(
                            );
                })
            }
//            if (Number(data) == 0) {
//                $('#defaultForm').submit();
//            }
        });

        // alert(url);
    });
//Vérification si un code existe déjà dans la base
    $("#FamilyCode").on('change', function(e) {
//       --- test article -----
//        e.preventDefault();
        code = $('#FamilyCode').val();


        $.ajax({
            type: "POST",
            url: wr + "Families/select/" + code,
            dataType: "JSON"
        }).done(function(data) {
            // alert(data);
            if (Number(data) > 0) {
                bootbox.alert("Famille existante !", function() {
                    notificationCenter(
                            );
                })
            }
//            if (Number(data) == 0) {
//                $('#defaultForm').submit();
//            }
        });

        // alert(url);
    });
//Vérification si un code existe déjà dans la base
    $("#TypeCode").on('change', function(e) {
//       --- test article -----
//        e.preventDefault();
        code = $('#TypeCode').val();


        $.ajax({
            type: "POST",
            url: wr + "Types/select_1/" + code,
            dataType: "JSON"
        }).done(function(data) {
            // alert(data);
            if (Number(data) > 0) {
                bootbox.alert("Type existant !", function() {
                    notificationCenter(
                            );
                })
            }
//            if (Number(data) == 0) {
//                $('#defaultForm').submit();
//            }
        });

        // alert(url);
    });
//Vérification si un code existe déjà dans la base
    $("#ColorCode").on('change', function(e) {
//       --- test article -----
//        e.preventDefault();
        code = $('#ColorCode').val();


        $.ajax({
            type: "POST",
            url: wr + "Colors/select/" + code,
            dataType: "JSON"
        }).done(function(data) {
            // alert(data);
            if (Number(data) > 0) {
                bootbox.alert("Couleur existant !", function() {
                    notificationCenter(
                            );
                })
            }
//            if (Number(data) == 0) {
//                $('#defaultForm').submit();
//            }
        });

        // alert(url);
    });
//Vérification si un code existe déjà dans la base
    $("#FournisseurCode").on('change', function(e) {
//       --- test article -----
//        e.preventDefault();
        code = $('#FournisseurCode').val();


        $.ajax({
            type: "POST",
            url: wr + "Fournisseurs/select/" + code,
            dataType: "JSON"
        }).done(function(data) {
            // alert(data);
            if (Number(data) > 0) {
                bootbox.alert("Fournisseur existant !", function() {
                    notificationCenter(
                            );
                })
            }
//            if (Number(data) == 0) {
//                $('#defaultForm').submit();
//            }
        });

        // alert(url);
    });
//Vérification si un code existe déjà dans la base
    $("#BlNumero").on('change', function(e) {
//       --- test article -----
//        e.preventDefault();
        code = $('#BlNumero').val();


        $.ajax({
            type: "POST",
            url: wr + "Bls/select/" + code,
            dataType: "JSON"
        }).done(function(data) {
            // alert(data);
            if (Number(data) > 0) {
                bootbox.alert("Bon de livraison existant !", function() {
                    notificationCenter(
                            );
                })
            }
//            if (Number(data) == 0) {
//                $('#defaultForm').submit();
//            }
        });

        // alert(url);
    });
//Vérification si un code existe déjà dans la base
    $("#BillNumero").on('change', function(e) {
//       --- test article -----
//        e.preventDefault();
        code = $('#BillNumero').val();


        $.ajax({
            type: "POST",
            url: wr + "Bills/select/" + code,
            dataType: "JSON"
        }).done(function(data) {
            // alert(data);
            if (Number(data) > 0) {
                bootbox.alert("Facture existante !", function() {
                    notificationCenter(
                            );
                })
            }
//            if (Number(data) == 0) {
//                $('#defaultForm').submit();
//            }
        });

        // alert(url);
    });
//Vérification si un code existe déjà dans la base
    $("#InventoryNumero").on('change', function(e) {
//       --- test article -----
        //e.preventDefault();
        code = $('#InventoryNumero').val();


        $.ajax({
            type: "POST",
            url: wr + "Inventories/select/" + code,
            dataType: "JSON"
        }).done(function(data) {
            // alert(data);
            if (Number(data) > 0) {
                bootbox.alert("Inventaire existante !", function() {
                    notificationCenter(
                            );
                })
            }
//            if (Number(data) == 0) {
//                $('#defaultForm').submit();
//            }
        });

        // alert(url);
    });
//Vérification si un code existe déjà dans la base
    $("#LotNumero").on('change', function(e) {
//       --- test article -----
//        e.preventDefault();
        code = $('#LotNumero').val();


        $.ajax({
            type: "POST",
            url: wr + "Lots/select/" + code,
            dataType: "JSON"
        }).done(function(data) {
            // alert(data);
            if (Number(data) > 0) {
                bootbox.alert("Lot existante !", function() {
                    notificationCenter(
                            );
                })
            }
//            if (Number(data) == 0) {
//                $('#defaultForm').submit();
//            }
        });

        // alert(url);
    });


    $('.qte_piece, .mp , .prix_unit, .tva , .remise ').on('keyup', function() {
        calcul_devise();
    });

    $("#typestock").on('change', function() {
        var id;
        id = $(this).val();

//        alert(id);

        if (id == 2) {
//            alert('ok');
            $('label[for="dimension"]').hide();
            $("#dimension").hide();

            $('#tohide').show();
        }

        if (id == 1) {
//            alert('1');
            $('label[for="dimension"]').show();
            $("#dimension").show();

            $('#tohide').hide();
        }
    });


    $('#typestockedit').on('change', function() {
        var id;
        id = $(this).val();



        if (id == 2) {
//            alert('2');
            $('#dimensionedit').hide();
            $("label[for='dimensionedit']").hide();

            $('#tohide').show();
        }
        if (id == 1) {
//            alert('1');
            $("label[for='dimensionedit']").show();
            $('#dimensionedit').show();

            $('#tohide').hide();

        }
    });

    id2 = $('#typestockedit').val();
    if (id2 == 2) {
//        alert('ok');
        $('#dimensionedit').hide();
        $("label[for='dimensionedit']").hide();


        $('#tohide').show();
    } else {

//        alert('MP');
        $('#dimensionedit').show();
        $("label[for='dimensionedit']").show();


        $('#tohide').hide();
    }






//    $(".add_line").click(function() {
//
//        var last_row = $('#matable tr:last');
//        var new_id = parseInt($(last_row).attr('id').split("_")[1]) + 1;
//        $(last_row).clone().insertAfter('#matable tr:last').attr('id', 'row_' + new_id);
//
//    });



//    var qte_prix = 0;
//    var qte = 0;
//    
//    
//    $('#qte_piece').on('blur', function(){
//        qte = $(this).val();
//        
//        console.log(qte);
//    });
//    
//    var prix = $('#prix_unit').val();
//    
//    qte_prix = qte * prix;
//    $('#remise').val(qte_prix);



    $('.piece').each(function() {
        $(this).on('keyup', function() {
            $('#submitsortie').removeAttr("disabled");
//            alert('ok');

        });
    });





    $('.lot').on('click', function() {
        var id = $(this).attr('id').split("_")[1];
        ligne = $(this).attr('ligne');
        ajouter_ligne2('tablot_' + id, 'index', ligne);
    });



    $(".lot_id").on('change', function() {

        var lot = $(this).val();

        var id = $(this).attr('id');

        var ligne = id.split("lot_id")[0];
        var index = id.split("lot_id")[1];

        var matierepremiere_id = $('#' + ligne + 'matierepremiere_id' + index).val();


        var somme_qte_pqt = 0;
        var somme_qte_piece = 0;

        $('.qte_piece').each(function() {
            $(this).on('change', function() {

                var id_qte_piece = $(this).attr('id');

                var index_qte_piece = id_qte_piece.split("qte_piece")[1];


                var qte_piece = $(this).val();

                var lot_id = $('#' + ligne_qte_piece + 'lot_id' + index_qte_piece).val();
                if (Number(ligne_qte_piece) == Number(ligne) && Number(lot_id) == Number(lot)) {
                    somme_qte_piece = Number(somme_qte_piece + qte_piece);
                }


                $.ajax({
                    type: "POST",
                    data: {
                        lot_id: lot,
                        index: index,
                        ligne: ligne,
                        somme_qte_piece: somme_qte_piece,
                        matierepremiere_id: matierepremiere_id
                    },
                    url: wr + "Bonsorties/verifpiece/",
                    dataType: "html",
                    global: false
                }).done(function(data) {
                    if (data != "")
                        alert(data);
                });

            });
        });
        $('.qte_pqt').each(function() {
            $(this).on('change', function() {
                var id_qte_pqt = $(this).attr('id');
                var ligne_qte_pqt = id_qte_pqt.split("qte_pqt")[0];
                var index_qte_pqt = id_qte_pqt.split("qte_pqt")[1];


                var qte_pqt = $(this).val();

                var lot_id = $('#' + ligne_qte_piece + 'lot_id' + index_qte_piece).val();
                if (Number(ligne_qte_pqt) == Number(ligne) && Number(lot_id) == Number(lot)) {
                    somme_qte_pqt = Number(somme_qte_pqt + qte_pqt);
                }



                $.ajax({
                    type: "POST",
                    data: {
                        lot_id: lot,
                        index: index,
                        ligne: ligne,
                        somme_qte_pqt: somme_qte_pqt,
                        matierepremiere_id: matierepremiere_id
                    },
                    url: wr + "Bonsorties/verifpqt/",
                    dataType: "html",
                    global: false
                }).done(function(data) {
                    if (data != "")
                        alert(data);
                });
            });
        });





    });

    $('.qte_pqt').each(function() {
        $(this).on('keyup', function() {
            $('#submitsortie').removeAttr("disabled");
        });
    });
    $('.qte_piece').each(function() {
        $(this).on('keyup', function() {
            $('#submitsortie').removeAttr("disabled");
        });
    });


});



//
//function ajout_ligne(id) {
//
//    alert(id);
//    var last_row = $('#matable tr:last');
////    var new_id = parseInt($(last_row).attr('id').split("_")[1]) + 1;
//    $(last_row).clone().insertAfter('#matable tr:last').attr('id', 'row_' + id + 1);
//
//}
function calcul_devise() {
    index = $('#index').val() || 0;
    var total_ht = 0;
    var total_ttc = 0;
    var total_remise = 0;
    var total_tva = 0;

    total_prix1 = 0;
    for (a = 0; a <= index; a++) {
        prix = $('#prix_unit' + a).val();
        qte = $('#qte_piece' + a).val();
        tva = $('#tva' + a).val();
//        prix_ht = $('#prix_ht' + a).val() || 0;
        remise = $('#remise' + a).val();
        prix_ht = (Number(qte * prix) - Number((qte * prix) * remise / 100)) || 0;
        total_prix1 = ((total_prix1) + Number(prix_ht)) || 0;
        taux_tva = (prix_ht * (tva / 100)) || 0;

        total_tva = (Number(total_tva) + Number(taux_tva)) || 0;
        total_ttc = (Number(total_ttc) + Number(prix_ht) + Number(taux_tva)) || 0;
        total_ttc = Number(total_ttc);
        $('#BlPrixHt').val(Number(total_prix1).toFixed(3));
        $('#BlPrixTtc').val(Number(total_ttc).toFixed(3));
        $('#BlPrixTva').val(Number(total_tva).toFixed(3));

        //Pour Bill
        $('#BillPrixHt').val(Number(total_prix1).toFixed(3));
        $('#BillPrixTtc').val(Number(total_ttc).toFixed(3));
        $('#BillPrixTva').val(Number(total_tva).toFixed(3));
        $('#prix_ht' + a).val(Number(prix_ht).toFixed(3));
    }

}
$(document).ready(function() {
    $('input[type=checkbox]').click(function() {

        val = $(this).val();
        test = $(this).is(':checked');

        console.log(test);
        // test echekbox true
        if (test == true) {

            nbbl = Number($('.btnbs').attr('nb')) + 1;
            $('.btnbs').attr('nb', nbbl);
            console.log('true');
            $('.creationbs').attr('style', '');
            link = $('.btnbs').attr('link') + val + ',';
            $('.btnbs').attr('link', link);

        }

        else {
            nbbl = Number($('.btnbs').attr('nb')) - 1;
            $('.btnbs').attr('nb', nbbl);
            //$('.creationbs').attr('style',''); 
            val = $(this).val();
            v = ',' + val;
            v1 = ',0';
            link = $('.btnbs').attr('link');
            lin = link.replace(v, v1);
            $('.btnbs').attr('link', lin);
        }
        nbbl = Number($('.btnbs').attr('nb'));
        // alert(nbbl);
        if (nbbl == 0) {
            $('.btnbs').attr('link', ',');
            $('.creationbs').attr('style', 'display: none');
        }

    });


    $('.btnbs').on('click', function() {
        link = $(this).attr('link');
        href = $(this).attr('href');
        $(this).attr('href', href + '/' + link);
    });

});


function ajouter_ligne2(table, index, ligne) {

    ind = Number($('#' + index + ligne).val()) + 1;
    indexx = Number($('#indexx').val()) + 1;
    $ttr = $('#' + table).find('.tr').clone(true);
    $ttr.attr('class', '');
    i = 0;
    tabb = [];
    $ttr.find('input,select').each(function() {
        tab = $(this).attr('table');
        champ = $(this).attr('champ');
        $(this).attr('index', ind);
        $(this).attr('id', ligne + champ + ind);
        $(this).attr('name', 'data[' + tab + '][' + indexx + '][' + champ + ']');
        $(this).attr('data-bv-field', 'data[' + tab + '][' + indexx + '][' + champ + ']');
        $(this).removeClass('anc');
        if ($(this).is('select')) {
            tabb[i] = ligne + champ + ind;
            i = Number(i) + 1;
        }
//            $(this).val('');

    })
    $ttr.find('i').each(function() {
        $(this).attr('index', ind);
    });
    $('#' + table).append($ttr);
    $('#' + index + ligne).val(ind);
    $('#indexx').val(indexx);
    $('#' + table).find('tr:last').show();
    for (j = 0; j <= i; j++) {
        uniform_select(tabb[j]);
    }

}


//page bon de livraison créer un lot à partir des BL
$(document).ready(function() {
    $('input[type=checkbox]').click(function() {

        val = $(this).val();
        test = $(this).is(':checked');

        console.log(test);
        // test echekbox true
        if (test == true) {

            nbbl = Number($('.btnlot').attr('nb')) + 1;
            $('.btnlot').attr('nb', nbbl);
            console.log('true');
            $('.creationlot').attr('style', '');
            link = $('.btnlot').attr('link') + val + ',';
            $('.btnlot').attr('link', link);

        }

        else {
            nbbl = Number($('.btnlot').attr('nb')) - 1;
            $('.btnlot').attr('nb', nbbl);
            //$('.creationbs').attr('style',''); 
            val = $(this).val();
            v = ',' + val;
            v1 = ',0';
            link = $('.btnlot').attr('link');
            lin = link.replace(v, v1);
            $('.btnlot').attr('link', lin);
        }
        nbbl = Number($('.btnlot').attr('nb'));
        // alert(nbbl);
        if (nbbl == 0) {
            $('.btnlot').attr('link', ',');
            $('.creationlot').attr('style', 'display: none');
        }

    });


    $('.btnlot').on('click', function() {
        link = $(this).attr('link');
        href = $(this).attr('href');
        $(this).attr('href', href + '/' + link);
    });

});



$(document).ready(function() {
    $('input[type=checkbox]').click(function() {

        val = $(this).val();
        test = $(this).is(':checked');

        console.log(test);
        // test echekbox true
        if (test == true) {

            nbbl = Number($('.btnbill').attr('nb')) + 1;
            $('.btnbill').attr('nb', nbbl);
            console.log('true');
            $('.creationbill').attr('style', '');
            link = $('.btnbill').attr('link') + val + ',';
            $('.btnbill').attr('link', link);

        }

        else {
            nbbl = Number($('.btnbill').attr('nb')) - 1;
            $('.btnbill').attr('nb', nbbl);
            //$('.creationbs').attr('style',''); 
            val = $(this).val();
            v = ',' + val;
            v1 = ',0';
            link = $('.btnbill').attr('link');
            lin = link.replace(v, v1);
            $('.btnbill').attr('link', lin);
        }
        nbbl = Number($('.btnbill').attr('nb'));
        // alert(nbbl);
        if (nbbl == 0) {
            $('.btnbill').attr('link', ',');
            $('.creationbill').attr('style', 'display: none');
        }

    });


    $('.btnbill').on('click', function() {
        link = $(this).attr('link');
        href = $(this).attr('href');
        $(this).attr('href', href + '/' + link);
    });

});