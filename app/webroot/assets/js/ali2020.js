/* global bootbox */

$(document).ready(function ()
{
    $('.testdoublefacturefr_et_getreste').on('change', function () {
        action = $('#action').val() || 0;
        id = $('#id').val() || 0;
        index = $(this).attr('index');
//        alert(index);
        facture_id = $('#facture_id' + index).val();
        index_totale = $('#indexc').val();
        for (i = 0; i <= index_totale; i++) {
            fac = $('#facture_id' + i).val();
            if (fac != undefined) {
                if (i != index && $('#supfac' + i).val() != 1) {
                    if (facture_id == $('#facture_id' + i).val()) {
                        $(this).parent().parent().parent().parent().hide();
                        $('#supfac' + index).val(1);
                        bootbox.alert('Impossible de répéter une facture deux fois', function () {});
                    }
                }
            }

        }


        $.ajax({
            type: "POST",
            url: wr + "Factures/getreste/" + facture_id + "/" + action + "/" + id,
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            $('#reste' + index).val(Number(data.reste).toFixed(3));

        });
    });
    //**************************************************************************
    $('.testmontanttotaleimputationfr').on('mousemove', function () {
        index_totale = $('#indexc').val();
        Total_TTC = $('#Total_TTC').val();
        tot = 0;
        test = 0;
        for (i = 0; i <= index_totale; i++) {

            if ($('#supfac' + i).val() != 1 && $('#supfac' + i).val() != undefined) {
                //alert(i);
                if (($('#montant' + i).val() == '') || $('#facture_id' + i).val() == '') {
                    test = 1;
                }
                mant = $('#montant' + i).val() || 0;
                if (mant != 0) {
                    //alert("mant"+mant);
                    tot = Number(tot) + Number(mant);
                    //alert(tot.toFixed(3));
                }
            }
        }
//        alert(Number(tot.toFixed(3)));
//        alert(Number(Total_TTC));
        if (Number(tot.toFixed(3)) > Number(Total_TTC)) {
            bootbox.alert('Impossible de dépasser le montant totale du facture avoir', function () {});
        }
        if (test == 1) {
            bootbox.alert('vérifier les champs d\'imputation', function () {});
        }
    });
    //**************************************************************************
    $('.ajouterligne_imputationfr').on('click', function () {
        table = $(this).attr('table');
        index = $(this).attr('index');
        ind = $("#" + index).val() + 1;
        fournisseur_id = $("#fournisseur_id").val() || 0;
        ajouter_ligne_imp(table, index);
        ajouter_list_facturefrs(ind, fournisseur_id);
    });
    //**************************************************************************
    $('.imputationfrs').on('mousemove', function () {
        fournisseur_id = $("#fournisseur_id").val() || 0;
        Total_TTC = $("#Total_TTC").val() || 0;
        if (Number(fournisseur_id) == 0) {
            bootbox.alert("Veuillez choisir un fournisseur!!", function () {
            });
            return false;
        }

        if (Number(Total_TTC) == 0) {
            bootbox.alert("Total TTC doit être supérieur à 0!!", function () {
            });
            return false;
        }
    });
    //**************************************************************************
    $('.testdoublefacture_et_getreste').on('change', function () {
        action = $('#action').val() || 0;
        id = $('#id').val() || 0;
        index = $(this).attr('index');
        factureclient_id = $('#factureclient_id' + index).val();
        index_totale = $('#indexc').val();
        for (i = 0; i <= index_totale; i++) {
            if (i != index && $('#supfac' + i).val() != 1) {
                if (factureclient_id == $('#factureclient_id' + i).val()) {
                    $(this).parent().parent().parent().parent().hide();
                    $('#supfac' + index).val(1);
                    bootbox.alert('Impossible de répéter une facture deux fois', function () {});
                }
            }
        }


        $.ajax({
            type: "POST",
            url: wr + "Factureclients/getreste/" + factureclient_id + "/" + action + "/" + id,
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            $('#reste' + index).val(Number(data.reste).toFixed(3));

        });
    });
    //**************************************************************************
    $('.supfac').on('click', function () {
        index = $(this).attr('index');
        //$('#quantite' + index).val(0);
        $('#supfac' + index).val(1);
        $(this).parent().parent().hide();

    });
    //**************************************************************************
    $('.testmontanttotaleimputation').on('mousemove', function () {
        index_totale = $('#indexc').val();
        Total_TTC = $('#Total_TTC').val();
        tot = 0;
        test = 0;
        for (i = 0; i <= index_totale; i++) {

            if ($('#supfac' + i).val() != 1 && $('#supfac' + i).val() != undefined) {
                //alert(i);
                if (($('#montant' + i).val() == '') || $('#factureclient_id' + i).val() == '') {
                    test = 1;
                }
                mant = $('#montant' + i).val() || 0;
                if (mant != 0) {
                    //alert("mant"+mant);
                    tot = Number(tot) + Number(mant);
                    //alert(tot.toFixed(3));
                }
            }
        }
//        alert(Number(tot.toFixed(3)));
//        alert(Number(Total_TTC));
        if (Number(tot.toFixed(3)) > Number(Total_TTC)) {
            bootbox.alert('Impossible de dépasser le montant totale du facture avoir', function () {});
        }
        if (test == 1) {
            bootbox.alert('vérifier les champs d\'imputation', function () {});
        }
    });
    //**************************************************************************
    $('.testmontantimputer').on('keyup', function () {
        index = $(this).attr('index');
        reste = $('#reste' + index).val() || 0;
        montant = $('#montant' + index).val() || 0;
        if (Number(montant) > Number(reste)) {
            $('#montant' + index).val(0);
            bootbox.alert('Impossible de dépasser le reste du facture', function () {});
        }
    });

    //**************************************************************************
    $('.ajouterligne_imputation').on('click', function () {
        table = $(this).attr('table');
        index = $(this).attr('index');
        ind = $("#" + index).val() + 1;
        client_id = $("#client_id").val() || 0;
//        alert(client_id);
        ajouter_ligne_imp(table, index);
        ajouter_list_factures(ind, client_id);
    });
    //**************************************************************************
    $('.imputations').on('mousemove', function () {
        typefacture_id = $("#typefacture_id").val() || 0;
        client_id = $("#client_id").val() || 0;
        Total_TTC = $("#Total_TTC").val() || 0;
        if (Number(client_id) == 0) {
            bootbox.alert("Veuillez choisir un client!!", function () {
            });
            return false;
        }

        if (Number(Total_TTC) == 0) {
            bootbox.alert("Total TTC doit être supérieur à 0!!", function () {
            });
            return false;
        }
    });
    //**************************************************************************
    $('.numero_facture').on('keyup', function () {
        val = $(this).val();//alert(val);
        index = $(this).attr('index') || 0;
        if (val == '') {
            $('#fac_id' + index).val('');
        }
        //alert(index);
        if (val.length > 2) {
            $('#res' + index).show();
            result1 = "";
            $.ajax({
                type: "POST",
                data: {
                    val: val,
                },
                url: wr + "Factures/numerofac/",
                dataType: "JSON"
            }).done(function (data) {
//                console.log(data);
                $.each(data, function (i, item) {
                    $.each(item, function (i, dd) {
                        //alert('aaa');
//                        console.log(dd);
                        dd.Facture.numero = dd.Facture.numero.replace("'", "`");
                        result1 = result1 + "<a class='option' id='" + dd.Facture.id + "' style='text-decoration:none;z-index: 1000' href=\"javascript:setQuerynumfac('" + dd.Facture.id + "','" + dd.Facture.numero + "','" + index + "');\"><div class='aa'>" + dd.Facture.numero + "</div></a>";
                    })
                })
                var obj = $("#res" + index);
                obj.html(result1);
                //console.log(obj.html());
                if (result1 != '') {
                    obj.css("visibility", "visible");
                } else {
                    obj.css("visibility", "hidden");
                }

            })
        } else {
            var obj = $("#res" + index);
            obj.css("visibility", "hidden");
        }
    })
    //**************************************************************************
    $('.numero_br').on('keyup', function () {

        val = $(this).val();//alert(val);
        index = $(this).attr('index') || 0;
        if (val == '') {
            $('#bl_id' + index).val('');
        }
        //alert(index);
        if (val.length > 2) {
            $('#res' + index).show();
            result1 = "";
            $.ajax({
                type: "POST",
                url: wr + "Bonreceptions/numerobl/" + val,
                dataType: "JSON"
            }).done(function (data) {
//                console.log(data);
                $.each(data, function (i, item) {
                    $.each(item, function (i, dd) {
                        //alert('aaa');
//                        console.log(dd);
                        dd.Bonreception.numero = dd.Bonreception.numero.replace("'", "`");
                        result1 = result1 + "<a class='option' id='" + dd.Bonreception.id + "' style='text-decoration:none;z-index: 1000' href=\"javascript:setQuerynumbl('" + dd.Bonreception.id + "','" + dd.Bonreception.numero + "','" + index + "');\"><div class='aa'>" + dd.Bonreception.numero + "</div></a>";
                    })
                })
                var obj = $("#res" + index);
                obj.html(result1);
                //console.log(obj.html());
                if (result1 != '') {
                    obj.css("visibility", "visible");
                } else {
                    obj.css("visibility", "hidden");
                }

            })
        } else {
            var obj = $("#res" + index);
            obj.css("visibility", "hidden");
        }
    })
    //**************************************************************************
    $('.numero_fac').on('keyup', function () {
        val = $(this).val();//alert(val);
        index = $(this).attr('index') || 0;
        if (val == '') {
            $('#fac_id' + index).val('');
        }
        //alert(index);
        if (val.length > 2) {
            $('#res' + index).show();
            result1 = "";
            $.ajax({
                type: "POST",
                data: {
                    val: val,
                },
                url: wr + "Factureclients/numerofac/",
                dataType: "JSON"
            }).done(function (data) {
//                console.log(data);
                $.each(data, function (i, item) {
                    $.each(item, function (i, dd) {
                        //alert('aaa');
//                        console.log(dd);
                        dd.Factureclient.numero = dd.Factureclient.numero.replace("'", "`");
                        result1 = result1 + "<a class='option' id='" + dd.Factureclient.id + "' style='text-decoration:none;z-index: 1000' href=\"javascript:setQuerynumfac('" + dd.Factureclient.id + "','" + dd.Factureclient.numero + "','" + index + "');\"><div class='aa'>" + dd.Factureclient.numero + "</div></a>";
                    })
                })
                var obj = $("#res" + index);
                obj.html(result1);
                //console.log(obj.html());
                if (result1 != '') {
                    obj.css("visibility", "visible");
                } else {
                    obj.css("visibility", "hidden");
                }

            })
        } else {
            var obj = $("#res" + index);
            obj.css("visibility", "hidden");
        }
    })
    //**************************************************************************
    $('.numero_bl').on('keyup', function () {
        val = $(this).val();//alert(val);
        index = $(this).attr('index') || 0;
        if (val == '') {
            $('#bl_id' + index).val('');
        }
        //alert(index);
        if (val.length > 2) {
            $('#res' + index).show();
            result1 = "";
            $.ajax({
                type: "POST",
                url: wr + "Bonlivraisons/numerobl/" + val,
                dataType: "JSON"
            }).done(function (data) {
//                console.log(data);
                $.each(data, function (i, item) {
                    $.each(item, function (i, dd) {
                        //alert('aaa');
//                        console.log(dd);
                        dd.Bonlivraison.numero = dd.Bonlivraison.numero.replace("'", "`");
                        result1 = result1 + "<a class='option' id='" + dd.Bonlivraison.id + "' style='text-decoration:none;z-index: 1000' href=\"javascript:setQuerynumbl('" + dd.Bonlivraison.id + "','" + dd.Bonlivraison.numero + "','" + index + "');\"><div class='aa'>" + dd.Bonlivraison.numero + "</div></a>";
                    })
                })
                var obj = $("#res" + index);
                obj.html(result1);
                //console.log(obj.html());
                if (result1 != '') {
                    obj.css("visibility", "visible");
                } else {
                    obj.css("visibility", "hidden");
                }

            })
        } else {
            var obj = $("#res" + index);
            obj.css("visibility", "hidden");
        }
    })
//*****************************************************************************
    $(".facturationauto").on('mousemove', function () {
        page = $("#page").val();
        if (page == 'factauto') {
            pointdevente_id = $('#pointdevente_id').val() || 0;
            date = $('#datefac').val() || 0;
            if ((pointdevente_id === 0)) {
                bootbox.alert("Veuillez choisir un point de vente", function () {
                });
                return false;
            }
            if ((date == "__/__/____")) {
                bootbox.alert("Veuillez saisie date", function () {
                });
                return false;
            }
        }
    });
    $(".impressionauto").on('mousemove', function () {
        page = $("#page").val();
        if (page == 'impauto') {
            model = $('#model').val() || 0;
            pointdevente_id = $('#pointdevente_id').val() || 0;
            if ((pointdevente_id === 0)) {
                bootbox.alert("Veuillez choisir un point de vente", function () {
                });
                return false;
            }
            if ((model === 0)) {
                bootbox.alert("Veuillez choisir une pièce", function () {
                });
                return false;
            }
        }

    });
    $('.codeselect').on('keyup', function () {
        val = $(this).val();//alert(val);
        index = $(this).attr('index') || 0;
        if (val.length > 1) {
            $('#rescode' + index).show();
            result1 = "";
            $.ajax({
                type: "POST",
                url: wr + "Articles/codeselect/" + val,
                dataType: "JSON"
            }).done(function (data) {
                $.each(data, function (i, item) {
                    $.each(item, function (i, dd) {
                        result1 = result1 + "<a class='option' id='" + dd.Article.id + "' style='text-decoration:none;z-index: 1000' href=\"javascript:setQuerycode('" + dd.Article.id + "','" + dd.Article.code.replace(/"/g, '1*2**1*2').replace(/'/g, '1*2**1*2') + "','" + index + "');\"><div class='aa'>" + dd.Article.code + "</div></a>";
                    });
                });
                var obj = $("#rescode" + index);
                obj.html(result1);
                if (result1 != '') {
                    obj.css("visibility", "visible");
                } else {
                    obj.css("visibility", "hidden");
                }

            })
        } else {
            var obj = $("#rescode" + index);
            obj.css("visibility", "hidden");
        }
    })
//**************************************************************************
    $(".btnReglementFrs").on('mousemove', function () {
        fournisseur_id = $("#fournisseur_id").val() || 0;
        if (fournisseur_id == 0) {
            bootbox.alert("Veuillez choisir un fournisseur", function () {
            });
            return false;
        }
        pointdevente_id = $("#pointdevente_id").val() || 0;
        if (pointdevente_id == 0) {
            bootbox.alert("Veuillez choisir un point de vente", function () {
            });
            return false;
        }
        index = $('#index').val() || 0;
        typefrs = $('#typefrs').val();
        test = 0;
        testt = 0;
        for (i = 0; i <= Number(index); i++) {
            paiement_id = $('#paiement_id' + i).val();
            montant = $('#montant' + i).val();
            echance = $("#echance" + i).val();
            num_piece = $("#num_piece" + i).val();
            compte_id = $("#compte_id" + i).val() || 0;
            etatpiecereglement_id = $('#etatpiecereglement_id' + i).val() || 0;
            //alert(etatpiecereglement_id);
            if ($('#sup' + i).val() != 1) {
                if (paiement_id == 4 || paiement_id == 3) {
                    if (montant == '' || echance == '__/__/____' || num_piece == '' || compte_id == 0) {
                        bootbox.alert('vérifier les champs des lignes existants', function () {});
                        return false;
                    }
                } else if (paiement_id == 1) {
                    if (montant == '') {
                        bootbox.alert('vérifier les champs des lignes existants', function () {});
                        return false;
                    }
                } else if (paiement_id == 2) {
                    cheque_id = $("#cheque_id" + i).val() || 0;
                    if (montant == '' || echance == '__/__/____') {
                        bootbox.alert('vérifier les champs des lignes existants', function () {});
                        return false;
                    }
                    if (cheque_id == 0 && num_piece == '') {
                        bootbox.alert('vérifier les champs des lignes existants', function () {});
                        return false;
                    }
                } else if (paiement_id == 5) {
                    montantbrut = $("#montantbrut" + i).val();
                    taux = $("#montantbrut" + i).val() || 0;
                    montantnet = $("#montantnet" + i).val() || 0;
                    if (montant == '' || montantbrut == '' || num_piece == '' || taux == 0 || montantnet == 0) {
                        bootbox.alert('vérifier les champs des lignes existants', function () {});
                        return false;
                    }
                } else if (paiement_id == 8) {
                    if (montant == '' || echance == '__/__/____' || num_piece == '' || compte_id == 0) {
                        bootbox.alert('vérifier les champs des lignes existants', function () {});
                        return false;
                    }
                } else {
                    bootbox.alert('vérifier les champs des lignes existants', function () {});
                    return false;
                }
//                if ((paiement_id == '') || (montant == '')) {
//                    test = 1;
//                } else {
//                    if (typefrs != 1) {
//                        if (etatpiecereglement_id == '') {
//                            testt = 1;
//                            //alert();
//                        } else {
//                            testt = 0;
//                        }
//                    }
//                }
            }
        }



    });
    $(".testnumerofc").on('mousemove', function () {
        numero = $('#numero').val();
        if (numero == '') {
            bootbox.alert('saisi un numéro SVP', function () {});
            return false
        }
    });
//**************************************************************************
    $(".test-total-ttc").on('click', function (e) {
        e.preventDefault();
        ttc = $("#Total_TTC").val();
        facture_id = $("#facture_id").val() || 0;
        $.ajax({
            type: "POST",
            url: wr + "Factureavoirfrs/getfacturetotalttc/" + facture_id,
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            if (Number(ttc) > (Number(data.ttc) - Number(data.montant_regler))) {
                bootbox.alert('Montant regler > Total TTC !!', function () {});
                return false;
            } else {
                $('#defaultForm').submit();
            }
        });

    });
//**************************************************************************
    $(".btnTransFrs").on('mousemove', function () {

    });
//**************************************************************************
    $(".calculmargee").on('keyup', function () {
        index = $(this).attr('index');
        prixhtva = $("#prixhtva" + index).val() || 0;
        remise = $("#remise" + index).val() || 0;
        fodec = $("#fodec" + index).val() || 0;
        //alert(prixhtva);alert(remise);alert(fodec);
        prixnet = Number(prixhtva) * (1 - (Number(remise) / 100)) *(1 + (Number(fodec) / 100));
        prixdeventeht = $("#prixdeventeht" + index).val() || 0;
        //alert(prixnet);alert(prixdeventeht);
        marge = (((Number(prixdeventeht) - Number(prixnet))) / Number(prixnet))*100;
        //alert(marge);
        $('#marge' + index).val(marge.toFixed(3));
    });
//**************************************************************************
    $(".calculprixvente").on('keyup', function () {
        index = $(this).attr('index');
        prixhtva = $("#prixhtva" + index).val() || 0;
        remise = $("#remise" + index).val() || 0;
        fodec = $("#fodec" + index).val() || 0;
        marge = $("#marge" + index).val() || 0;
        prixnet = Number(prixhtva) * (1 - (Number(remise) / 100)) *(1 + (Number(fodec) / 100));
        prixdeventeht = Number(prixnet) + (Number(prixnet) * (Number(marge) / 100));
        $("#prixdeventeht" + index).val(prixdeventeht.toFixed(3));
    });
//**************************************************************************
    $(".champsreadonly").on('keyup', function () {
        prixachat = $("#coutrevient").val() || 0;
        if (Number(prixachat) == 0) {
            $("#margepourcentage").prop('readonly', true);
            $("#margepourcentage").val('');
            $("#prixvente").prop('readonly', true);
            $("#prixvente").val('');
            $("#tva").prop('readonly', true);
            $("#tva").val('');
            $("#remise_vente").prop('readonly', true);
            $("#remise_vente").val('');
        } else {
            $("#margepourcentage").prop('readonly', false);
            $("#prixvente").prop('readonly', false);
            $("#tva").prop('readonly', false);
            $("#remise_vente").prop('readonly', false);
        }
    });
//**************************************************************************
    $(".calculmargevente").on('keyup', function () {
        margepourcentage = $("#margepourcentage").val() || 0;
        if (margepourcentage == 0) {
            prixachat = $("#coutrevient").val() || 0;
            prixvente = $("#prixvente").val() || 0;
            if (prixachat != 0 && prixvente != 0) {
                p = ((Number(prixvente) - Number(prixachat)) * 100) / Number(prixachat);
                $('#margepourcentage').val(p.toFixed(3));
            }

        }

    });
//**************************************************************************
    $(".calculputtc").on('keyup', function () {
//        alert();
        prixachat = $("#coutrevient").val() || 0;
        margepourcentage = $("#margepourcentage").val() || 0;
        prixvente = $("#prixvente").val() || 0;
        tva = $("#tva").val() || 0;
        prixventee = Number(prixachat) + (Number(prixachat) * (Number(margepourcentage) / 100));
//        $("#prixvente").val(prixventee.toFixed(3));
        puttc = Number(prixventee) * (1 + (Number(tva) / 100));
        $("#prixuttc").val(puttc.toFixed(3));

    });
//**************************************************************************
    $('.testfacturettc').on('mousemove', function () {
        fournisseur_id = $("#fournisseur_id").val() || 0;

        if (fournisseur_id == 0) {
            bootbox.alert("Veuillez choisir un fournisseur", function () {
            });
            return false;
        }
        facture_id = $("#factureclient_id").val() || 0;
//        alert(facture_id);
        if (facture_id == 0) {
            bootbox.alert("Veuillez choisir une facture", function () {
            });
            return false;
        }
        ttc = $("#Total_TTC").val();
        if (ttc == "") {
            bootbox.alert("Veuillez remplir le total TTC", function () {
            });
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: wr + "Factureavoirfrs/getfacturetotalttc/" + facture_id,
                dataType: "json",
                global: false //}l'envoie'
            }).done(function (data) {
                console.log(data);
                if (Number(ttc) > (Number(data.ttc) - Number(data.montant_regler))) {
                    $("#Total_TTC").val("");
                    return false;
                }

            })
        }
    });
//**************************************************************************
    $('.getfacturefournisseurs').on('change', function () {
        clientid = $('#fournisseur_id').val();
//        alert(clientid);
        $.ajax({
            type: "POST",
            data: {
                clientid: clientid

            },
            url: wr + "Factureavoirfrs/getfactures/",
            dataType: "html",
            global: false //}l'envoie'
        }).done(function (data) {
//            console.log(data);
            $('#divfacture').html('');
            $('#divfacture').html(data);
            uniform_select('factureclient_id');
        })
    })
// test formulaire de bonreception, bonsortie stock 
    $(".btnEnregistrerStk").on('mousemove', function (e) {
        index = $("#index").val();
        page = $("#page").val();
        if (page === 'bonsortiestock') {
            personnel = $("#fc").val() || 0;
            if (personnel == 0) {
                bootbox.alert("Choisi un personnel SVP", function () {
                });
                return false;
            }
        }
        depot_id = $("#depot_id").val() || 0;
        if (depot_id == 0) {
            bootbox.alert("Veuillez choisir un depot", function () {
            });
            return false;
        }
        if (test_nb_ligne(index) === false) {
            bootbox.alert("Veuillez remplir au moins une ligne", function () {
            });
            return false;
        }

        for (i = 1; i <= index; i++) {
            sup = $("#sup" + i).val();
            article_id = $("#article_id" + i).val() || 0;
            quantite = $("#quantite" + i).val() || 0;
            if (sup == "" && article_id > 0) {
                if (quantite == 0) {
                    bootbox.alert('vérifier les champs des lignes existants', function () {});
                    return false;
                }

            }
        }
    });
//**************************************************************************
    $(".btnEnregistrerTransClt").on('mousemove', function (e) {
        index = $("#index").val();
        model = $("#model").val();
        model_ans = $("#model_ans").val();
        // test model ans
        if (model_ans == 'Commandeclient' || model_ans == 'Devi') {
            // test model
            if (model == 'Factureclient' || model == 'Bonlivraison') {
                // test qtenegatif
                $.ajax({
                    type: "POST",
                    url: wr + "Utilisateurs/testqtenegatif/",
                    dataType: "json",
                    global: false //}l'envoie'
                }).done(function (data) {

                    if (data.qtenegatif == 0) {
                        alert('pass2');
                        for (i = 1; i <= index; i++) {
                            sup = $("#sup" + i).val();
                            article_id = $("#article_id" + i).val() || 0;
                            if ((sup == '') && Number(article_id) > 0) {
                                alert(i);
                                quantite = $("#quantite" + i).val() || 0;
                                quantitestock = $("#quantitestock" + i).val() || 0;
                                type = $("#type" + i).val() || 0;
                                if (Number(type) != 1) {
                                    if (Number(quantite) > Number(quantitestock)) {
                                        bootbox.alert('Qte > Qte de stock !!', function () {});
                                        return false;
                                    }
                                }
                            }
                        }
                    }
                })

            }
        }

    })
//**************************************************************************
    $(".btnEditInventaire").on('mousemove', function () {
        index = $("#index").val();
        for (i = 1; i <= index; i++) {
            sup = $("#sup" + i).val();
            article_id = $("#article_id" + i).val() || 0;
            if ((sup == '') && Number(article_id) > 0) {
                code = $("#code" + i).val() || 0;
                designation = $("#designation" + i).val() || 0;
                if (code == 0 && designation == 0) {
                    $("#sup" + i).val(1);
                }
            }

        }
    });
//**************************************************************************
    $(".suppcccc").on('click', function () {
        alert("aaaa");
    });
//**************************************************************************
    $(".btnInventaire").on('click', function () {
        depot = $("#depot_id").val() || 0;
        if (Number(depot) == 0) {
            bootbox.alert('Veuillez choisir un depot !!', function () {});
            return false;
        }
    });
//**************************************************************************
    $('.finddepot').on('keyup', function () {
        val = $(this).val();//alert(val);
        index = $(this).attr('index') || 0;
        societedepart = $("#societedepart").val() || 0;
        if (val.length > 2) {
            $('#resdepot' + index).show();
            result1 = "";
            $.ajax({
                type: "POST",
                url: wr + "Depots/findedepot/" + val + "/" + societedepart,
                dataType: "JSON",

            }).done(function (data) {

                $.each(data, function (i, item) {
                    $.each(item, function (j, dd) {
                        //alert('aaa');
                        console.log(dd);
                        dd.Depot.nom = dd.Depot.designation.replace("'", "`");
                        result1 = result1 + "<a class='option'  id='" + dd.Depot.id + "' style='text-decoration:none;z-index: 1000' href=\"javascript:setQuery1depot('" + dd.Depot.id + "','" + dd.Depot.code + "','" + escape(dd.Depot.nom) + "','" + index + "');\">\n\
                                            <div class='aa'>" + dd.Depot.designation + "</div></a>";
                    })
                })
                var obj = $("#resdepot" + index);
                obj.html(result1);
                //console.log(obj.html());
                if (result1 != '') {
                    obj.css("visibility", "visible");
                } else {
                    obj.css("visibility", "hidden");
                }

            })
        } else {
            var obj = $("#resdepot" + index);
            obj.css("visibility", "hidden");
        }
    });

// inventaire code + designation
    $('.invcode').on('change', function () {
        //alert();
        index = $(this).attr('index');
        val = $(this).val(); //alert(val);
        trans_remise = $('#trans_remise').val() || 0;
        page = $("#page").val();
        $.ajax({
            type: "POST",
            data: {
                val: val
            },
            url: wr + "Articles/code/",
            dataType: "json",
            async: false,
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            $('#article_id' + index).val(data.id);
            $('#designation' + index).val(data.des);
            $('#coutderevien' + index).val(data.pmp);

        });
    });
// Recuperer fodec + retenue 
    $(".fodec_retenue").on('change', function () {
//        alert();
        pvid = $(this).val() || 0;
//        alert(pvid);
        $.ajax({
            type: "POST",
            url: wr + "Pointdeventes/getfodecretenue/" + pvid,
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            //if(empty(data.fodec)){data.fodec=0;}
            //if(empty(data.retenue)){data.retenue=0;}
            //alert(data.fodec);
            //alert(data.retenue);
            $('#fodec').val(data.fodec);
            $('#fodecspan').text(data.fodec + "%");
            $('#retenue').val(data.retenue);
            $('#retenuespan').text(data.retenue + "%");
            calculefacture();
        });


    });
// Controle les champs fodec et retenue du  point de vente 
    $('.btnEnregistrer').on('click', function (e) {
//        alert()
        if ($("#fodecp1:checked").val() == 1) {
            if ($("#pvfodec").val() === '') {
                bootbox.alert('Veuillez remplir le FODEC !!', function () {});
                e.preventDefault();
                return false;
            }

        }
        if ($("#retenuep1:checked").val() == 1) {
            if ($("#pvretenue").val() === '') {
                bootbox.alert('Veuillez remplir le RETENUE !!', function () {});
                e.preventDefault();
                return false;
            }

        }
    });
// Point de vente : afficher fodec + retenue 
    $("input").on("click", function () {
        if ($("#fodecp0:checked").val() == 0) {
            $("#pvfodec").hide();
        }
        if ($("#fodecp1:checked").val() == 1) {
            $("#pvfodec").show();
        }
        if ($("#retenuep0:checked").val() == 0) {
            $("#pvretenue").hide();
        }
        if ($("#retenuep1:checked").val() == 1) {
            $("#pvretenue").show();
        }
    });
//    $("#fodecp0")
// calcule remise

    $(".newtotalttc").on('click', function () {
        index = $("#index").val() || 0;
        for (var i = 1; i <= index; i++) {
            sup = $("#sup" + i).val();
            article_id = $("#article_id" + i).val() || 0;
            if ((sup == '') && Number(article_id) > 0) {
                $("#remise" + i).val(0);
            }
        }
        calculefacture();
    });
    $(".newtotalttc").on('keyup blur', function () {

        totalttc = $("#Total_TTC").val() || 0;
        timbre = $("#timbre").val() || 0;
        newtotalttc = $("#New_Total_TTC").val() || 0;
        diff = Number(totalttc) - Number(newtotalttc);
        division = Number(diff) / (Number(totalttc) - Number(timbre));
        remise = Number(division) * 100;
        index = $("#index").val() || 0;
        if (newtotalttc != 0) {
            for (var i = 1; i <= index; i++) {
                sup = $("#sup" + i).val();
                article_id = $("#article_id" + i).val() || 0;
                if ((sup == '') && Number(article_id) > 0) {
                    $("#remise" + i).val(remise);
                    prixhtva = $('#prixhtva' + i).val() || 0;
                    tva = $('#tva' + i).val() || 0;
                    punht = Number(prixhtva) * (1 - Number(remise / 100));
                    puttc = punht * (1 + Number(tva / 100));
                    $('#puttc' + i).val(puttc.toFixed(3));
                    $('#totalhtans' + i).val(prixhtva);
                    $('#prixnet' + i).val(punht.toFixed(3));
                }
            }
        }
        //calculefacture();

    });
    $(".newtotalttc").on('blur', function () {
        calculefacture();
    });
// recuperer code client
    $('.getnumeroclient').on('change', function (e) {
        page = $("#page").val();
        if (page == 'clients') {
            id = $("#clientid").val() || 0;
            pointdevente_id = $("#pointdevente_id").val() || 0;
            $.ajax({
                type: "POST",
                url: wr + "Clients/getnumero/" + pointdevente_id + "/" + id,
                dataType: "json",
                global: false //}l'envoie'
            }).done(function (data) {
                $('#code').val(data.numero);
            });
        }
    });
// Changer piece
    $("#btnChanger").on('click', function (e) {
        $("#btnChanger").hide();
        $("#typedipliquationdiv").show();
        $("#typedipliquationdiv").children().remove('label');
    });
    /******************************************************************************/
    $('.btnValiderali').on('click', function (e) {
        e.preventDefault();
        page = $("#page").val();
        if (page == 'recap_nouveau_prix') {
            depot_id = $("#depot_id").val() || 0;
            code = $("#code").val() || 0;
            des = $("#des").val() || 0;
            tvaart = $("#tvaart").val() || 0;
            // test depot
            if (Number(depot_id) == 0) {
                bootbox.alert('Veuillez choisir un depot !!', function () {});
                //e.preventDefault();
                return false;
            }
            // test article composant
            index = $("#index").val();
            ind = 0;
            ch = "";
            for (var i = 1; i <= index; i++) {
                sup = $("#sup" + i).val();
                article_id = $("#article_id" + i).val() || 0;
                if ((sup == '') && Number(article_id) > 0) {
                    ind++;
                }
            }
            ok = 0;
            for (var i = 1; i <= index; i++) {
                sup = $("#sup" + i).val();
                article_id = $("#article_id" + i).val() || 0;
                if ((sup == '') && Number(article_id) > 0) {
                    ok++;
                    quantite = $("#quantite" + i).val() || 0;
                    if (ok == 1) {
                        ch = ch + '(' + article_id + ',' + quantite + ',' + ind + ')';
                    } else {
                        ch = ch + ',(' + article_id + ',' + quantite + ',' + ind + ')';
                    }
                }
            }
            $.ajax({
                type: "POST",
                url: wr + "Articlecomposantes/articlecomposant/" + ch + "/" + ind,
                dataType: "json",
                async: false,
                global: false //}l'envoie'
            }).done(function (infos) {
                console.log(infos);
                if (infos.verif == 0) {
                    $("#code").val('');
                    $("#des").val('');
                    $("#tvaart").val('');
                    $.each(infos.article, function (i, item) {
                        $("#id").val(item.id);
                        $("#code").val(item.code);
                        $("#code").prop("readonly", true);
                        $("#des").val(item.name);
                        $("#tvaart").val(item.tva);
                        $("#tvaart").prop("readonly", true);
                    });
                } else {
//                    $.ajax({
//                        type: "POST",
//                        url: wr + "Articles/existencecode/" + code,
//                        dataType: "json",
//                        async: false,
//                        global: false //}l'envoie'
//                    }).done(function (dataa) {
////                        alert('pass');
//                        console.log(dataa);
//                        if (Number(dataa.art) == 1) {
//                            bootbox.alert('Veuillez choisir un autre code !!', function () {});
//                            $("#code").val('');
//                            e.preventDefault();
//                            return false;
//                        }
//                    });

                }
            });
            bootbox.confirm("Article valide!!", function (result) {
                if (result) {
                    depot_id = $("#depot_id").val() || 0;
                    code = $("#code").val() || 0;
                    des = $("#des").val() || 0;
                    tvaart = $("#tvaart").val() || 0;
                    qtevendu = $("#qtevendu").val() || 0;
                    if (Number(code) == 0) {
                        bootbox.hideAll();
                        bootbox.alert('Code déja existe !!', function () {});
                        result.preventDefault();
                        return false;
                    } else if (Number(des) == 0) {
                        bootbox.hideAll();
                        bootbox.alert('Veuillez choisir une désignation !!', function () {});
                        result.preventDefault();
                        return false;
                    } else if (Number(tvaart) == 0) {
                        bootbox.hideAll();
                        bootbox.alert('Veuillez choisir un TVA !!', function () {});
                        result.preventDefault();
                        return false;
                    } else if (Number(qtevendu) == 0) {
                        bootbox.hideAll();
                        bootbox.alert('Veuillez remplir la quantité vendu !!', function () {});
                        result.preventDefault();
                        return false;
                    } else if (test_qtevendu(index, qtevendu) === false) {
                        bootbox.hideAll();
                        bootbox.alert('Stock insuffisant !!', function () {});
                        result.preventDefault();
                        return false;
                    } else if (test_nb_ligne(index) === false) {
                        bootbox.hideAll();
                        bootbox.alert("Veuillez remplir au moins une article composant", function () {
                        });
                        result.preventDefault();
                        return false;
                    } else {
                        var html = 'Ok';
                        $('#defaultForm').submit();
                        calculefacture();
                    }
                } else {
                    var html = 'Cancel';
                }

            });
        }
    });
    /******************************************************************************/
    $('.btnEnregistrerPiece').on('mousemove', function (e) {
//        alert();
        typedipliquation = $('#typedipliquation option:selected').text();
        if (typedipliquation == 'Bonlivraison' || typedipliquation == 'Factureclient') {
            index = $("#index").val();
            for (i = 0; i <= index; i++) {
                sup = $("#sup" + i).val();
                article_id = $("#article_id" + i).val() || 0;
                type = $("#type" + i).val() || 0;
                if (sup != 1 && sup != null && article_id > 0 && type == 0) {
                    qtevendu = $("#quantite" + i).val() || 0;
                    qtestock = $("#quantitestock" + i).val() || 0;
                    $.ajax({
                    type: "POST",
                    url: wr + "Utilisateurs/testqtenegatif/",
                    dataType: "json",
                    global: false //}l'envoie'
                    }).done(function (data) {
                    //alert(data.qtenegatif);
                    if (data.qtenegatif == 0) {
                    if (qtevendu > qtestock) {
                        $("#quantite" + i).val(0);
                        bootbox.alert("Quantité vendu n'est pas valide!!", function () {
                        });
                        result.preventDefault();
                        return false;
                    }}})
                }
            }
        }
    });
    /****/
    $('.alicode').on('change', function () {
//alert();
        index = $(this).attr('index');
        val = $(this).val(); //alert(val);
        trans_remise = $('#trans_remise').val() || 0;
        page = $("#page").val();
        $.ajax({
            type: "POST",
            data: {
                val: val
            },
            url: wr + "Articles/code/",
            dataType: "json",
            async: false,
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            $('#article_id' + index).val(data.id);
            articleidbl(index);
        });
    });
    /**************************/
}
);
function test_nb_ligne(index) {
    nbligne = 0;
    for (i = 0; i <= index; i++) {
        sup = $("#sup" + i).val();
        article_id = $("#article_id" + i).val() || 0;
        if (sup != 1 && sup != null && article_id > 0) {
            nbligne++;
        }
    }
    if (nbligne > 0) {
        return true;
    } else {
        return false;
    }
}
function test_qtevendu(index, qtevendu) {
    $.ajax({
        type: "POST",
        url: wr + "Utilisateurs/testqtenegatif/",
        dataType: "json",
        global: false //}l'envoie'
    }).done(function (data) {

        if (data.qtenegatif == 0) {
            for (i = 0; i <= index; i++) {
                sup = $("#sup" + i).val();
                article_id = $("#article_id" + i).val() || 0;
                if (sup != 1 && sup != null && article_id > 0) {
                    quantite = $("#quantite" + i).val() || 0;
                    quantitestock = $("#quantitestock" + i).val() || 0;
                    somme = Number(quantite) * Number(qtevendu);
                    if (somme > quantitestock) {
                        return false;
                        break;
                    }

                }
            }
            return true;
        }
    });

}
function setQuery1depot(id, code, des, index) {//alert(index);
    //alert(index);
    $('#depot_id' + index).val(id);
    $('#depot' + index).val(des);
    $("#resdepot" + index).css("visibility", "hidden");
    $('#code' + index).focus();
}
function setQuerycode(id, code, index) {//alert(index);
    //alert(index);
    page = $('#page').val() || 0;
    $('#article_id' + index).val(id);
    //alert(code);
    $('#code' + index).val(code);
    $("#rescode" + index).css("visibility", "hidden");
    if (page != 'indexarticle') {
        articleidbl(index);
    }
    $('#quantite' + index).focus();

}
function setQuerynumbl(id, numero, index) {//alert(index);
//    alert(numero);
    $('#bl_id' + index).val(id);
    $('#numbl' + index).val(numero);
    $("#res" + index).css("visibility", "hidden");

}
function setQuerynumfac(id, numero, index) {//alert(index);
//    alert(numero);
    $('#fac_id' + index).val(id);
    $('#numfac' + index).val(numero);
    $("#res" + index).css("visibility", "hidden");

}
function ajouter_list_factures(index, client_id) {
//    alert(client_id);
//     alert(index);
    $.ajax({
        type: "POST",
        data: {
            index: index,
            client_id: client_id
        },
        url: wr + "Factureclients/getfactures/",
        dataType: "json",
        async: false,
        global: false //}l'envoie'
    }).done(function (data) {
        $('#tdimp' + data.index).html('');
        $('#tdimp' + data.index).html(data.select);
        uniform_select('factureclient_id' + data.index);
    });

}
function ajouter_list_facturefrs(index, fournisseur_id) {
//    alert(client_id);
    $.ajax({
        type: "POST",
        data: {
            index: index,
            fournisseur_id: fournisseur_id
        },
        url: wr + "Factures/getfactures/",
        dataType: "json",
        async: false,
        global: false //}l'envoie'
    }).done(function (data) {
        $('#tdimp' + data.index).html('');
        $('#tdimp' + data.index).html(data.select);
        uniform_select('facture_id' + data.index);
    });

}
function ajouter_ligne_imp(table, index) {
    ind = Number($('#' + index).val()) + 1;

    $ttr = $('#' + table).find('.tr').clone(true);
    $ttr.attr('class', '');
    i = 0;
    tabb = [];
    $ttr.find('input,select,td').each(function () {
        tab = $(this).attr('table');
        champ = $(this).attr('champ');
        $(this).attr('index', ind);
        $(this).attr('id', champ + ind);
        $(this).attr('name', 'data[' + tab + '][' + ind + '][' + champ + ']');
        $(this).attr('data-bv-field', 'data[' + tab + '][' + ind + '][' + champ + ']');
        $type = $(this).attr('type');
        $(this).val('');
        if ($type == 'radio') {
            $(this).attr('name', 'data[' + champ + ']');
            //$(this).attr('value',ind);
            $(this).val(ind);
        }
        if ((champ == 'datedebut') || (champ == 'datefin')) {
            $(this).attr('onblur', 'nbrjour(' + ind + ')')
        }

        $(this).removeClass('anc');
        if ($(this).is('select')) {
            tabb[i] = champ + ind;
            i = Number(i) + 1;
        }
        // $(this).val('');

    })
    $ttr.find('i').each(function () {
        $(this).attr('index', ind);
    });
    $('#' + table).append($ttr);
    $('#' + index).val(ind);
    $('#' + table).find('tr:last').show();
    for (j = 0; j <= i; j++) {
        uniform_select(tabb[j]);
    }
    $('#datedebut' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});
    $('#datefin' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});


}
function testdoublefacture_et_getreste(index) {
    action = $('#action').val() || 0;
    id = $('#id').val() || 0;
    factureclient_id = $('#factureclient_id' + index).val();
    index_totale = $('#indexc').val();
    for (i = 0; i <= index_totale; i++) {
        fac = $('#factureclient_id' + i).val();
        if (fac != undefined) {
            if (i != index && $('#supfac' + i).val() != 1) {
                if (factureclient_id == $('#factureclient_id' + i).val()) {
                    $('#tdimp' + index).parent().hide();
                    $('#supfac' + index).val(1);
                    bootbox.alert('Impossible de répéter une facture deux fois', function () {});
                }
            }
        }

    }


    $.ajax({
        type: "POST",
        url: wr + "Factureclients/getreste/" + factureclient_id + "/" + action + "/" + id,
        dataType: "json",
        global: false //}l'envoie'
    }).done(function (data) {
        console.log(data);
        $('#reste' + index).val(Number(data.reste).toFixed(3));

    });

}
//function ajouter_list_factures(index, client_id) {
////    alert(client_id);
//    $.ajax({
//        type: "POST",
//        data: {
//            index: index,
//            client_id: client_id
//        },
//        url: wr + "Factureclients/getfactures/",
//        dataType: "json",
//        async: false,
//        global: false //}l'envoie'
//    }).done(function (data) {
//        $('#tdimp' + data.index).html('');
//        $('#tdimp' + data.index).html(data.select);
//        uniform_select('facture_id' + data.index);
//    });
//
//}
function testdoublefacturefr_et_getreste(index) {
    action = $('#action').val() || 0;
    id = $('#id').val() || 0;

//    index = $(this).attr('index');
    facture_id = $('#facture_id' + index).val();
    index_totale = $('#indexc').val();
    for (i = 0; i <= index_totale; i++) {
        fac = $('#facture_id' + i).val();
        if (fac != undefined) {
            if (i != index && $('#supfac' + i).val() != 1) {
                if (facture_id == $('#facture_id' + i).val()) {
                    $('#tdimp' + index).parent().hide();
                    $('#supfac' + index).val(1);
                    bootbox.alert('Impossible de répéter une facture deux fois', function () {});
                }
            }
        }

    }


    $.ajax({
        type: "POST",
        url: wr + "Factures/getreste/" + facture_id + "/" + action + "/" + id,
        dataType: "json",
        global: false //}l'envoie'
    }).done(function (data) {
        console.log(data);
        $('#reste' + index).val(Number(data.reste).toFixed(3));

    });

}