$(document).ready(function ()
{

    $('.qtestockedit').on('change', function () {
        qteartedit();
    })

    $('.trasfertdepot').on('change', function () {
        index = $(this).attr('index');
        //alert(index);
        depot_id = $('#depot_id' + index).val();
        //alert(depot_id);
        $.ajax({
            type: "POST",
            data: {
                id: depot_id,
                index: index,

            },
            url: wr + "Transferts/stockdepot/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            //$('#tdarticle'+index).html('');
            //$('#tdarticle'+index).html(data.select);
            //uniform_select('article_id'+index);
            // ajouter_ligne_reception('addtable','index','tr');

        })
    })


    //  // obtenir la  liste des article por le fournisseur choisi  pour l'interface add commande ***************************
    $('.artfournisseurcommande').on('change', function () { //alert();
        index = $('#index').val();

        $('.cc').remove();
        $('#fodec').val(0);
        $('#tva').val(0);
        $('#remise').val(0);
        $('#Total_HT').val(0);
        $('#Total_TTC').val(0);
        n++;

        if (n > 1)
        {
            $('#fodec').val(0);
            $('#tva').val(0);
            $('#remise').val(0);
            $('#Total_HT').val(0);
            $('#Total_TTC').val(0);
        }
        fournisseur_id = $('#fc').val();
        // alert(fournisseur_id);
        $.ajax({
            type: "POST",
            data: {
                id: fournisseur_id//,
            },
            url: wr + "Bonreceptions/artfour/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {

            $('#tdarticle').html('');
            $('#tdarticle').html(data.selectf);

            ajouter_ligne_reception('addtable', 'index', 'tr')



        })
    })



    $('.testnumero').on('blur', function () {
        numero = $('#numerofrs').val();  //alert(numero);
        controller = $('#model').val();  //alert(controller);
		fournisseur_id = $('#fc').val();  //alert(fournisseur_id);
        $.ajax({
            type: "POST",
            data: {
                numero: numero,
                controller: controller,
				fournisseur_id:fournisseur_id
            },
            url: wr + "Bonreceptions/testnumero/",
            dataType: "html",
            global: false //}l'envoie'
        }).done(function (data) {
            if (data == 1) {
				$('#numerofrs').val("");
                bootbox.alert('le numéro existe', function () {});
            }
        })
    })
    // obtenir les pieces du client choisi ***************************
    $('.piecesclient').on('change', function () {
        index = $(this).attr('index');
        client_id = $('#client_id' + index).val();
        //  alert(index);  alert(client_id);

        $.ajax({
            type: "POST",
            data: {
                id: client_id,
                index: index
            },
            url: wr + "Bordereaus/piecesclient/",
            dataType: "html",
            global: false
        }).done(function (data) {

            $('#piecereglementclient_id' + index).parent().html(data);

            uniform_select('piecereglementclient_id' + index);
        })
    })
    //******pour edit bodereau******************
    $('.getpiece').on('change', function () {
        index = $(this).attr('index');
        piecereglementclient_id = $('#piecereglementclient_id' + index).val();
        $.ajax({
            type: "POST",
            data: {
                id: piecereglementclient_id,
            },
            url: wr + "Bordereaus/getpiece/",
            dataType: "json",
            global: false
        }).done(function (data) {
            total = 0;
            $('#banque' + index).val(data.banque);
            $('#montant' + index).val(data.montant);

            max = $('#index').val(); //alert(max);
            for (i = 0; i <= max; i++) {
                // alert(i);
                if ($('#sup' + i).val() != 1) {
                    montant = $('#montant' + i).val() || 0;// alert(montant);
                    total = (Number(total) + Number(montant)).toFixed(3);
                }
            }
            $('#total').val(total);
        })
    })

    $('.getfactures').on('change', function () {
        clientid = $('#client_id').val();
//         alert(clientid);
        $.ajax({
            type: "POST",
            data: {
                clientid: clientid
            },
            url: wr + "Factureavoirs/getfactures/",
            dataType: "html",
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            $('#divfacture').html('');
            $('#divfacture').html(data);
            uniform_select('factureclient_id');
        })
    })

    $('.testnum').on('blur', function () {
        numero = $('#numero').val(); // alert(numero);
        $.ajax({
            type: "POST",
            data: {
                numero: numero
            },
            url: wr + "Carnetcheques/testnum/",
            dataType: "html",
            global: false //}l'envoie'
        }).done(function (data) {
            if (data == 1) {
                bootbox.alert('le numéro du Carnet de cheque existe dans la base de donnée  !!', function () {});
            }

        })
    })
    //****controle de saisi ligneentre .......
    $('.testle').on('change', function () {
        index = $(this).attr('index');
        ligne = $(this).attr('ligne');    //alert('index'+index+'ligne'+ligne);
        articleid = $('#article_id' + ligne).val();  //alert('aaaaaaa'+articleid);
        datevalidite = $('#datevalidite' + index).val();  //alert(datevalidite);
        var tab = new Array();
        $.ajax({
            type: "POST",
            data: {
                articleid: articleid

            },
            url: wr + "Articles/testligneentre/",
            global: false //}l'envoie'
        }).done(function (data) {
            //alert(data);
            if ((data == 1) & (datevalidite == "__/__/____")) {
                bootbox.alert('la date de validité est obligatoire  !!', function () {});
            }
        })
    })
    //****controle de saisi br , facture .......
    $('.testlr').on('change', function () {
        index = $(this).attr('index');    //alert(index);
        articleid = $('#article_id' + index).val();  //alert('aaaaaaa'+articleid);
        numerolot = $('#numerolot' + index).val();  //alert(numerolot);
        datevalidite = $('#datevalidite' + index).val();  //alert(datevalidite);
        var tab = new Array();
        $.ajax({
            type: "POST",
            data: {
                articleid: articleid

            },
            url: wr + "Articles/testlignereception/",
            global: false //}l'envoie'
        }).done(function (data) {
            //alert(data);
            if ((data == 11) & (datevalidite == "__/__/____") & (numerolot == '')) {
                bootbox.alert('le numéro de lot et la date de validité sont obligatoire  !!', function () {});
            } else {
                if ((data == 10) & (numerolot == '')) {
                    bootbox.alert('le numéro de lot est obligatoire  !!', function () {});
                }
                if ((data == 11) & (numerolot == '') & (datevalidite != "__/__/____")) {
                    bootbox.alert('le numéro de lot est obligatoire  !!', function () {});
                }
                if ((data == 01) & (datevalidite == "__/__/____")) {
                    bootbox.alert('la date de validité est obligatoire  !!', function () {});
                }
                if ((data == 11) & (datevalidite == "__/__/____") & (numerolot != '')) {
                    bootbox.alert('la date de validité est obligatoire  !!', function () {});
                }
            }
        })
    })
    $('.getsousfamille').on('change', function () {
        familleid = $('#famille_id').val();  // alert(familleid);
        $('.sfe').show();
        $('.ssfe').hide();
        $('.sf').hide();
        $('.ssf').hide();
        $.ajax({
            type: "POST",
            data: {
                familleid: familleid

            },
            url: wr + "Articles/getsousfamille/",
            dataType: "html",
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            $('#divsousfamille').html('');
            $('#divsousfamille').html(data);
            uniform_select('sousfamille_id');
        })
    })
    // function getsoussousfamille(){pour l'edit de la sous famille de l'article
    $('.getsoussousfamille').on('change', function () {
        sousfamilleid = $('#sousfamille_id').val(); //alert (sousfamilleid);
        $('.ssf').hide();
        $('.ssfe').show();
        $.ajax({
            type: "POST",
            data: {
                sousfamilleid: sousfamilleid

            },
            url: wr + "Articles/getsoussousfamille/",
            dataType: "html",
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            $('#divsoussousfamille').html('');
            $('#divsoussousfamille').html(data);
            uniform_select('soussousfamille_id');
        })
    })

    $('.getsousfamilleclient').on('change', function () {
        familleclientid = $('#familleclient_id').val();
        //alert(familleclientid);
        $('.sfe').show();
        $('.sf').hide();
        $.ajax({
            type: "POST",
            data: {
                familleclientid: familleclientid

            },
            url: wr + "Clients/getsousfamilleclient/",
            dataType: "html",
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            $('#divsousfamilleclient').html('');
            $('#divsousfamilleclient').html(data);
            uniform_select('sousfamilleclient_id');
        })
    })



    $('.typefacture').on('change', function () {
        typefacture_id = $('#typefacture_id').val();
        table = $('.ajouterligne_reception').attr('table');
        index = $('.ajouterligne_reception').attr('index');
        tr = $('.ajouterligne_reception').attr('tr');
        //alert(typefacture_id);
        if (typefacture_id == 1) {
            ajouter_ligne_reception(table, index, tr);
            $('.favr').show();
            $('.favf').show();

        } else if (typefacture_id == 2) {
            $('.favf').show();
            $('.favr').hide();
        } else {
            $('.favr').hide();
            $('.favf').hide();
        }
    })
    $('.createlist').on('change', function () {
        index = $(this).attr('index');   // alert(index);
        numerolot = $('#numerolot' + index).val();  //alert(numerolot);
        tabnum[Number(index)] = numerolot;
        $.ajax({
            type: "POST",
            data: {
                tabnum: tabnum,
                index: index
            },
            url: wr + "Homologations/numlist/",
            dataType: "html",
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            $('#tdnumero').html('');
            $('#tdnumero').html(data);
        })
    })

    //  // obtenir la  liste des article pour le depot choisi  pour l'interface add bonlivraison ***************************
    $('.stockdepot').on('change', function () {

        index = $(this).attr('index');
        //alert(index);
        depot_id = $('#depot_id' + index).val();
        // alert(depot_id);
        $.ajax({
            type: "POST", //{
            data: {
                id: depot_id,
                index: index
            },
            url: wr + "Bonlivraisons/stockdepot/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            $('#article_id' + index).parent().html(data.select);

            uniform_select('article_id' + index);
        })
    })
    //  // obtenir la  liste des article pour le depot choisi  pour l'interface addindirect bonlivraison ***************************
    $('.stockdepotindirect').on('change', function () {

        index = $(this).attr('index');
        article_id = $('#articlec_id' + index).val();
        depot_id = $('#depot_id' + index).val();
        // alert(depot_id);
        $.ajax({
            type: "POST", //{
            data: {
                id: article_id,
                index: index,
                depotid: depot_id
            },
            url: wr + "Bonlivraisons/article/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {

            $('#tva' + index).val(data.tva);
            $('#prixhtva' + index).val(data.prix);
            $('#quantitestock' + index).val(data.quantitestock);
            if ($('#quantite' + index).val() > data.quantitestock) {
                bootbox.alert('Quantite en stock  insuffusante veuillez choisir un aute depot ou modifier la quantité !!', function () {});
            }
            calculefacture();
        })
    })
    //  // obtenir la  liste des article pour le depot choisi  pour l'interface edit bonlivraison ***************************
    $('.stockdepotedit').on('change', function () {//alert();
        index = $(this).attr('index');
        n++;
        if (n > 0)
        {
            //alert('nombre de modif du depot='+n);
            $('.cc').remove();
            $('#fodec').val(0);
            $('#tva').val(0);
            $('#remise').val(0);
            $('#Total_HT').val(0);
            $('#Total_TTC').val(0);
        }
        depot_id = $('#depot_id').val();
        //  alert(depot_id);
        $.ajax({
            type: "POST", //{
            data: {
                id: depot_id//,
                        // index:index
                        //  name: name
            },
            url: wr + "Bonlivraisons/stockdepot/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            // $('#devise_id'+index).parent().html(data.select);

            //   uniform_select('devise_id'+index);

            $('#tdarticle0').html('');
            $('#tdarticle0').html(data.select);
            $('#tdarticle').html('');
            $('#tdarticle').html(data.selectf);
            //console.log(data.select);
            uniform_select('article_id0');
        })
    })
    // obtenir le  prix et le tva de l'article choisi pour linterface bl ***************************
    $('.articleidbl').on('change', function () {
        //  alert();
        // fournisseur_id== $('#fc').val();
//        alert();
        index = $(this).attr('index');
        article_id = $('#article_id' + index).val() || 0;
        depot_id = $('#depot_id').val();
        client_id = $('#client_id').val();
        vente = $('#vente').val() || 0;
        trans_remise = $('#trans_remise').val() || 0;


        $.ajax({
            type: "POST",
            data: {
                id: article_id,
                depotid: depot_id,
                clientid: client_id,
                vente: vente,
            },
            url: wr + "Bonlivraisons/article/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            //article_id = $('#article_id'+index).val()||0;
            //alert(data.articleid);

            //alert();
            $('#code' + index).val("");
            $('#tva' + index).val("");
            $('#puttc' + index).val("");
            $('#prixhtva' + index).val("");
            $('#prixnet' + index).val("");
            $('#totalhtans' + index).val("");
            $('#quantitestock' + index).val("");
            $('#designation' + index).val("");
            $('#remise' + index).val("");
            $('#remiseans' + index).val("");
            $('#order' + index).hide();
            $('#quantite' + index).val("");
            calculefacture();
            $('#totalht' + index).val("");
            $('#totalttc' + index).val("");
            if (article_id != 0) {
                // alert("d5al");
                $('#code' + index).val(data.code);
                $('#tva' + index).val(data.tva);
                $('#puttc' + index).val(data.prixttc);
                $('#prixhtva' + index).val(data.prix);
                $('#prixnet' + index).val(data.prix);
                $('#totalhtans' + index).val(data.prix);
                $('#quantitestock' + index).val(data.quantitestock);
                $('#designation' + index).val(data.des);
                $('#remise' + index).val(data.remise);
                $('#remiseans' + index).val(data.remise);
                if (trans_remise == 1) {
                    $('#remise' + index).val(data.remise_transfert);
                }
                $('#order' + index).show();
                calculefacture();
            }
        })
    })
    ////////////////////////////////////////////////////




    ///////////////////////////////////////////////////////////////
    // obtenir le  prix et le tva de l'article choisi pour l interface devi  ***************************
    $('.articleiddevi').on('change', function () {

        index = $(this).attr('index');
        article_id = $('#article_id' + index).val();

        $.ajax({
            type: "POST",
            data: {
                id: article_id,

            },
            url: wr + "Devis/article/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            //alert(data);
            $('#tva' + index).val(data.tva);
            $('#prixhtva' + index).val(data.prix);
            $('#prixachat' + index).val(data.prixachat);

            calculefacturef();
        })
    })



    // obtenir le  tva de l'article choisi ***************************
    $('.idarticle').on('change', function () {

        index = $(this).attr('index');
        article_id = $('#article_id' + index).val();
        ta[index] = article_id;
        // alert(article_id);
        fournisseur_id = $('#fc').val();
        // alert(fournisseur_id);
        $.ajax({
            type: "POST",
            data: {
                id: article_id
                , fid: fournisseur_id
            },
            url: wr + "Bonreceptions/gettva/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            // alert(data.tva);
            $('#tva' + index).val(data.tva);
            $('#prixhtva' + index).val(data.prix);
            $('#prix' + index).val(data.prix);
            $('#prix_anc' + index).val(data.prix);
            $('#idart' + index).val(data.idart);
        })
    })

    //***************** Transfert bon livraison vers facture client
    $('.blf').on('click', function () {
        //alert();
        ligne = $(this).attr('ligne');
        index = $('#index').val();
        test = 0;
        for (i = 0; i <= Number(index); i++) {
            if ($('#check' + i).is(':checked')) {
                test = 1;
            }

        }
        if (test == 1) {
            //alert(index);
            $('.testcheck').show();
            //$('.testcheckfc').show();
            //alert(ligne);
            client = $('#Client' + ligne).val();
            Pointdevente = $('#Pointdevente' + ligne).val();
            if ($('.tes').val() == 0) {
                $('.tes').val(client);
            }
            if ($('.tespv').val() == 0) {
                $('.tespv').val(Pointdevente);
            }
            if (($('.tes').val() != client) && $('.tes').val() != 0) {
                page = $('#page').val() || 0;
                if (page == 'devis') {
                    message = 'Il faut choisir des devis pour le meme Client !!';
                }
                if (page == 'commande') {
                    message = 'Il faut choisir des commandes pour le meme Client !!';
                }
                if (page == 'bl') {
                    message = 'Il faut choisir des bons de livraison pour le meme Client et type de vente !!';
                }

                bootbox.alert(message, function () {});
                return false;
            }
            if (($('.tespv').val() != Pointdevente) && $('.tespv').val() != 0) {
                page = $('#page').val() || 0;
                if (page == 'devis') {
                    message = 'Il faut choisir des devis pour le meme Point de vente !!';
                }
                if (page == 'commande') {
                    message = 'Il faut choisir des commandes pour le meme Point de vente !!';
                }
                if (page == 'bl') {
                    message = 'Il faut choisir des bons de livraison pour le meme Point de vente !!';
                }

                bootbox.alert(message, function () {});
                return false;
            }
        }
        if (test == 0) {
            //alert("fera8");
            $('.tes').val(0);
            $('.tespv').val(0);
            $('.testcheck').hide();
            //$('.testcheckfc').hide();
        }
    });
    //********bonlivraisons/index*******************
    //********commandeclient/index cree un bl*******************
    $('#facbonlivraisonadd').on('click', function () {

        //alert(client);
        var tab = new Array;
        conteur = $('.nombre').val();

        for (var i = 0; i <= conteur; i++) {
            val = ($('#check' + i).attr('checked'));//alert(val);
            //var x = ($('#check'+(i)).checked;
            v = $('#check' + i).val();

            if ($('#check' + i).is(':checked')) {
                //alert(v);
                tab[i] = v;
            }

        }
        var removeItem = undefined;

        tab = jQuery.grep(tab, function (value) {
            return value != removeItem;
        });
        client = $('.tes').val();
        table = $('#table').val();
        if (table == 'commande') {
            tab = 'commande;' + tab;
        }
        //alert(tab);
        //$(this).attr("href",wr+"Courses/transfertordre/"+client+"/"+tab)
//        $(this).attr("href", wr + "Factureclients/addindirect/" + tab)
        $(this).attr("href", wr + "Factureclients/transformation/Factureclient/Lignefactureclient/factureclient_id/" + tab + "/Bonlivraison/Lignelivraison/bonlivraison_id/")


    });
    //------------------** Fin livraison **--
    //*******************************pour Devise index*************************************************************
    //********commandeclient/index cree un commande*******************
    $('#cammandeadd').on('click', function () {

        //alert(client);
        var tab = new Array;
        conteur = $('.nombre').val();

        for (var i = 0; i <= conteur; i++) {
            val = ($('#check' + i).attr('checked'));//alert(val);
            //var x = ($('#check'+(i)).checked;
            v = $('#check' + i).val();

            if ($('#check' + i).is(':checked')) {
                //alert(v);
                tab[i] = v;
            }

        }
        var removeItem = undefined;

        tab = jQuery.grep(tab, function (value) {
            return value != removeItem;
        });
        client = $('.tes').val();

        $(this).attr("href", wr + "Factureclients/transformation/Commandeclient/Lignecommandeclient/commandeclient_id/" + tab + "/Devi/Lignedevi/devi_id/")


    });
    $('#devibonlivraisonadd').on('click', function () {

        //alert(client);
        var tab = new Array;
        conteur = $('.nombre').val();

        for (var i = 0; i <= conteur; i++) {
            val = ($('#check' + i).attr('checked'));//alert(val);
            //var x = ($('#check'+(i)).checked;
            v = $('#check' + i).val();

            if ($('#check' + i).is(':checked')) {
                //alert(v);
                tab[i] = v;
            }

        }
        var removeItem = undefined;

        tab = jQuery.grep(tab, function (value) {
            return value != removeItem;
        });
        client = $('.tes').val();

        // $(this).attr("href",wr+"Bonlivraisons/addbonindirect/"+tab)
        $(this).attr("href", wr + "Factureclients/transformation/Bonlivraison/Lignelivraison/bonlivraison_id/" + tab + "/Devi/Lignedevi/devi_id/")
    });
    $('#devifactureadd').on('click', function () {

        //alert(client);
        var tab = new Array;
        conteur = $('.nombre').val();

        for (var i = 0; i <= conteur; i++) {
            val = ($('#check' + i).attr('checked'));//alert(val);
            //var x = ($('#check'+(i)).checked;
            v = $('#check' + i).val();

            if ($('#check' + i).is(':checked')) {
                //alert(v);
                tab[i] = v;
            }

        }
        var removeItem = undefined;

        tab = jQuery.grep(tab, function (value) {
            return value != removeItem;
        });
        client = $('.tes').val();

        //$(this).attr("href",wr+"Factureclients/addfacfromdeviseindirect/"+tab)
        $(this).attr("href", wr + "Factureclients/transformation/Factureclient/Lignefactureclient/factureclient_id/" + tab + "/Devi/Lignedevi/devi_id/")

    });
    //------------------** Fin Devise index  **---------------------------------------------------------------
    $('#commandebonlivraisonadd').on('click', function () {

        //alert(client);
        var tab = new Array;
        conteur = $('.nombre').val();
        //alert(conteur);
        for (var i = 0; i <= conteur; i++) {
            val = ($('#check' + i).attr('checked'));
            //var x = ($('#check'+(i)).checked;
            v = $('#check' + i).val();

            if ($('#check' + i).is(':checked')) {
                //alert(v);
                tab[i] = v;
            }

        }
        var removeItem = undefined;

        tab = jQuery.grep(tab, function (value) {
            return value != removeItem;
        });
        //alert(tab);
        client = $('.tes').val();

        //$(this).attr("href",wr+"Bonlivraisons/addindirect/"+tab)

        $(this).attr("href", wr + "Factureclients/transformation/Bonlivraison/Lignelivraison/bonlivraison_id/" + tab + "/Commandeclient/Lignecommandeclient/commandeclient_id/")

    });
    //------------------** Fin commande bl **--
    //********commandeclient/index cree un bl*******************
    $('#factureadd').on('click', function () {

        //alert(client);
        var tab = new Array;
        conteur = $('.nombre').val();

        for (var i = 0; i <= conteur; i++) {
            val = ($('#check' + i).attr('checked'));//alert(val);
            //var x = ($('#check'+(i)).checked;
            v = $('#check' + i).val();

            if ($('#check' + i).is(':checked')) {
                //alert(v);
                tab[i] = v;
            }

        }
        var removeItem = undefined;

        tab = jQuery.grep(tab, function (value) {
            return value != removeItem;
        });
        client = $('.tes').val();

        //$(this).attr("href",wr+"Factureclients/addfacindirect/"+tab)
        $(this).attr("href", wr + "Factureclients/transformation/Factureclient/Lignefactureclient/factureclient_id/" + tab + "/Commandeclient/Lignecommandeclient/commandeclient_id/")

    });
    //*********fin commandeclient--->>>>>>facturelient
    //***************** Transfert bon reception vers facture
     $('.abc').on('click', function () {
        //alert();
        $('.testcheck').show();
        var table = $(this).parents('table').attr('id');
        var checkedStatus = this.checked;
        //alert(checkedStatus);
        var id = this.id;
        ligne = $(this).attr('ligne');
        //alert('ligne'+'---'+ligne)
        $('.bout').show();
        client = $('#Fournisseur' + ligne).val();
        importation = $('#Importation' + ligne).val() || -1;
         //*******zeinab
        type = $('#type' + ligne).val();

        //alert(importation);
        if ($('.tes').val() == 0) {
            $('.tes').val(client)
        }
        //alert('tes'+'---'+$('.tes').val());
        if ($('.tess').val() == 0) {
            $('.tess').val(importation)
        }
         //*******zeinab
        if ($('.tesss').val() == 0) {
                    $('.tesss').val(type)
                }
        //*******
        if (($('.tes').val() != client) && $('.tes').val() != 0) {
            table = $('#table').val();
            if (table == 'commande') {
                message = 'Il faut choisir des commandes pour le meme Fournisseur et meme Type !!'
            } else {
                message = 'Il faut choisir des bons de receptions pour le meme Fournisseur et meme Type !!'
            }

            bootbox.alert(message, function () {});
            return false;
            checkedStatus = false;
            //$("#check"+i).attr("disabled", true);
            $(this).attr('checked', $("#check" + ligne).is(''));
            nb = nb + 1;

        }

        if (($('.tess').val() != importation) && $('.tess').val() != 0) {
            table = $('#table').val();
            if (table == 'commande') {
                message = 'Il faut choisir des commandes pour le meme Importation !!'
            } else {
                message = 'Il faut choisir des bons de receptions pour le meme Importation !!'
            }

            bootbox.alert(message, function () {});
            return false;
            checkedStatus = false;
            //$("#check"+i).attr("disabled", true);
            $(this).attr('checked', $("#check" + ligne).is(''));
            nb = nb + 1;

        }
        //*******zeinab
        if (($('.tesss').val() != type) && $('.tesss').val() != 0) {
            table = $('#table').val();
            if (table == 'commande') {
                message = 'Il faut choisir des commandes pour le meme Type !!'
            } else {
                message = 'Il faut choisir des bons de receptions pour le meme Type !!'
            }

            bootbox.alert(message, function () {});
            return false;
            checkedStatus = false;
            //$("#check"+i).attr("disabled", true);
            $(this).attr('checked', $("#check" + ligne).is(''));
            nb = nb + 1;

        }
       //******************

        this.checked = checkedStatus;
        if (this.checked) {
            $(this).attr('checked', $(this).is(':checked'));
            nb = nb + 1;

        } else {
            $(this).attr('checked', $(this).is(''));
            nb = nb - 1;

        }

        if (nb == 0) {
            $('.tes').val(0);
            $('.bout').hide();
        }
    });
    //}
    //***** bonreceptions/index
    $('#datatableadd').on('click', function () {

        //alert(client);
        var tab = new Array;
        conteur=$('.nombre').val();
        //alert(conteur);
        for(var i =0; i<=conteur; i++){
            val= ($('#check'+i).attr('checked'));
            //var x = ($('#check'+(i)).checked;
            v=$('#check'+i).val();

            if($('#check'+i).is(':checked')){
               //alert(v);
                tab[i] = v;
            }

        } var removeItem = undefined;

        tab = jQuery.grep(tab, function(value) {
            return value != removeItem;
        });
        //alert(tab);
        //$(this).attr("href",wr+"Courses/transfertordre/"+client+"/"+tab)
         //$(this).attr("href",wr+"Bonreceptions/addindirect/"+tab)
                 $(this).attr("href",wr+"Factures/transformation/Facture/Lignefacture/facture_id/"+tab+"/Commande/Lignecommande/commande_id/")



    });
    //-----------------*fin facture*------------------
      $('#bonreceptionadd').on('click', function () {

        //alert(client);
       var tab = new Array;
        conteur=$('.nombre').val();
        //alert(conteur);
        for(var i =0; i<=conteur; i++){
            val= ($('#check'+i).attr('checked'));
            //var x = ($('#check'+(i)).checked;
            v=$('#check'+i).val();

            if($('#check'+i).is(':checked')){
               //alert(v);
                tab[i] = v;
            }

        } var removeItem = undefined;

        tab = jQuery.grep(tab, function(value) {
            return value != removeItem;
        });
        //alert(tab);
        //$(this).attr("href",wr+"Courses/transfertordre/"+client+"/"+tab)
         //$(this).attr("href",wr+"Bonreceptions/addindirect/"+tab)
                 $(this).attr("href",wr+"Factures/transformation/Bonreception/Lignereception/bonreception_id/"+tab+"/Commande/Lignecommande/commande_id/")



    });
    //------------------** Fin reception **--
    $('#receptionfacture').on('click', function () {

        //alert(client);
        var tab = new Array;
        conteur=$('.nombre').val();
       //alert(conteur);
        for(var i =0; i<=conteur; i++){
            val= ($('#check'+i).attr('checked'));
            //var x = ($('#check'+(i)).checked;
            v=$('#check'+i).val();

            if($('#check'+i).is(':checked')){
               //alert(v);
                tab[i] = v;
            }

        } var removeItem = undefined;

        tab = jQuery.grep(tab, function(value) {
            return value != removeItem;
        });
        //alert(tab);
        //$(this).attr("href",wr+"Courses/transfertordre/"+client+"/"+tab)
         //$(this).attr("href",wr+"Bonreceptions/addindirect/"+tab)

         //************ zeinab
         type=$('#type').val();
         if(type=='service')
            $(this).attr("href",wr+"Factures/transformation/Facture/Lignefacture/facture_id/"+tab+"/Bonreception/Lignereception/bonreception_id/")
         else
            $(this).attr("href",wr+"Factures/transformationfactureservice/Facture/Lignefacture/facture_id/"+tab+"/Bonreception/Lignereception/bonreception_id/")
        //********************
    });

    var n = 0;
    //  // obtenir la  liste des article por le fournisseur choisi  pour l'interface bonreception ***************************
    $('.artfournisseur').on('change', function () { //alert();
        index = $(this).attr('index');
        page = $('#page').val() || 0;
        max = $('#index').val() || 0;
        if (page != "suggestioncommandeindirect") {

            for (j = 0; j <= max; j++) {
                $('.cc' + j).remove();
            }

            $('#fodec').val(0);
            $('#tva').val(0);
            $('#remise').val(0);
            $('#Total_HT').val(0);
            $('#Total_TTC').val(0);
            $('#index').val(0);
            n++;

            if (n > 1)
            {
                //alert('nombre de modif du fournisseur='+n);
                //$('.cc').remove();
                $('#fodec').val(0);
                $('#tva').val(0);
                $('#remise').val(0);
                $('#Total_HT').val(0);
                $('#Total_TTC').val(0);
            }
        }
        fournisseur_id = $('#fc').val();
        // alert(fournisseur_id);
        $.ajax({
            type: "POST",
            data: {
                id: fournisseur_id//,
            },
            url: wr + "Bonreceptions/artfour/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            //console.log(data);
            // alert('0');
            $('#tr').val(1);
            $('#coe').val(1);
            $('#coef').val(1);

            if (data.devise != "1") {
                $('#typefrs').val(data.devise);
                $('.fournisseurexterne').show();
                $('.fournisseurinterne').hide();
                /* $('#article_id0').html('');
                 $('#article_id0').html(data.select); */
                $('#divimpor').html('');
                $('#divimpor').html(data.selecti);
                uniform_select('importation_id');
                $('#importation_id').addClass('calculcout');
                //alert('1');
                if (page != "suggestioncommandeindirect") {
                    //alert('1.1');
                    ajouter_ligne_reception('addtableext', 'index', 'tr'); //addtableext
                }
            } else {
                $('.fournisseurexterne').hide();
                $('.fournisseurinterne').show();

                /* $('#article_id0').html('');
                 $('#article_id0').html(data.select);
                 $('#tdarticle').html('');
                 $('#tdarticle').html(data.selectf);*/
                // alert('2');
                ajouter_ligne_reception('addtable', 'index', 'tr');

            }


        })
    })


    //  // obtenir la  liste des article por le fournisseur choisi pour l'interface facture ***************************
    $('.artfournisseurfacture').on('change', function () {//alert();
        index = $(this).attr('index');
        n++;
        if (n > 1)
        {
            //alert('nombre de modif du fournisseur='+n);
            $('.cc').remove();
            $('#fodec').val(0);
            $('#tva').val(0);
            $('#remise').val(0);
            $('#Total_HT').val(0);
            $('#Total_TTC').val(0);
        }
        fournisseur_id = $('#fc').val();

        $.ajax({
            type: "POST",
            data: {
                id: fournisseur_id
            },
            url: wr + "Factures/artfour/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {

            if (data.devise != "1") {

                $('.fournisseurexterne').show();
                $('.fournisseurinterne').remove();

            } else {
                $('.fournisseurexterne').remove();
                $('.fournisseurinterne').show();
            }

            $('#tdarticle0').html('');
            $('#tdarticle0').html(data.select);
            $('#tdarticle').html('');
            $('#tdarticle').html(data.selectf);
            //console.log(data.select);
            uniform_select('article_id0');

        })
    })




    $(".testfavr").on('change', function () {
        index = $(this).attr('index');
        qte = $('#quantite' + index).val();
        qtestock = $('#quantitett' + index).val();
        //alert(qtestock+'o'+qte);
        test_bl(index, qte, qtestock);
    })
    $(".testqte").on('change', function () {
        index = $(this).attr('index');
        type = $('#type' + index).val() || 0;
        qte = $('#quantite' + index).val() || 0;
        qtestock = $('#quantitestock' + index).val() || 0;
        model = $('#model').val();
//        alert(model);
        if (model == 'Bonlivraison' || model == 'Factureclient') {
            typedipliquation = $('#typedipliquation option:selected').text();
            if(typedipliquation == 'Bonlivraison' || typedipliquation == 'Factureclient' || typedipliquation == 'Veuillez Choisir !!' ){
                test_bl(index, qte, qtestock, type);
            }
        }


    })
    $(".testdetailqte").on('change', function () {
        index = $(this).attr('index');
        qte = $('#quantitedetail' + index).val();
        qtestock = $('#qtestk' + index).val();
        test_bs(index, qte, qtestock);
        //alert(index+' o '+qtestock+' o '+qte);

    })
    $(".testdetailqte").on('blur', function () {
        index = $(this).attr('index');
        i = ((Number(index) - Number(index) % 1000) / 1000) - 1;
        // alert(i);
        qtedetail = Number(0);
        qtett = $('#quantite' + i).val();
        compteur = (Number(index) - Number(index) % 1000);
        //alert(index+'*****'+compteur);
        while ($('#quantitedetail' + compteur).val() != undefined) {
            qtedetail = Number(qtedetail) + Number($('#quantitedetail' + compteur).val());
            compteur++;
        }
        //alert(i+' o '+qtedetail+' o '+qtett);
        if (qtedetail > qtett) {

            bootbox.alert('Quantite invalide !!!', function () {});
            $('#quantitedetail' + index).val(0);
        }


    })

    $(".testqtebe").on('change', function () {
        summ = 0;
        index = $(this).attr('index');
        summ = 0;
        ind = Number(index);
        ligne = $(this).attr('ligne');    //alert('index'+index+'ligne'+ligne);
        if (tabe[ligne] == undefined) {
            tabe[ligne] = 0;
        }
        qtett = $('#quantite' + ligne).val();
        qte = $('#qte' + index).val();
        compteur = Number(ligne) * 100 + Number(index);
        tabq[ligne] = qtett;
        tabe[compteur] = Number(qte);
        for (i = Number(ligne) * 100; i <= (Number(ligne) + 1) * 100; i++) {
            if (tabe[i] != undefined) {
                summ = Number(summ) + Number(tabe[i]);
            }
        }
        tabqe[ligne] = summ;
        // alert('tabq= '+tabq[ligne]+' somme= '+summ);

        if (ligne == 0) {
            if (summ > tabq[ligne]) {
                bootbox.alert('Vous avez dépassez la quantité reçu !!', function () {});
                $('#qte' + index).val(0);
            }
        } else {

            if (summ > tabq[ligne]) {
                bootbox.alert('Vous avez dépassez la quantité reçu !!', function () {});
                $('#qte' + index).val(0);
            }

            if (tabqe[line] < tabq[line]) {
                bootbox.alert('Vous n\'avez pas entré la quantité totale reçu dans la ligne précédente !!', function () {});
            }
        }
    })
    $(".testallqte").on('mousemove', function () {

        for (i = 0; i <= tabq.length; i++) {

            if (tabqe[line] < tabq[i]) {
                bootbox.alert('Vous n\'avez pas entré la quantité totale reçu dans la ligne ' + i + ' !!', function () {});
            }
        }
    })

    $('.calculefacfournisseur').on('keyup', function () {//alert();
        calculefacturef();
    })
    $('.editfacfournisseur').on('keyup', function () {//alert();
        calculefacturef();
    })
    $('.editfacfournisseur').on('change', function () {//alert();
        calculefacturef();
    })

    $('.calculefacture').on('keyup', function () {//alert();
        calculefacture();
    })
    $('.editfacture').on('keyup', function () {//alert();
        calculefacture();
    })
    $('.editfacture').on('change', function () {//alert();
        calculefacture();
    })
    $('.ajouterligne_w').on('click', function () {
        table = $(this).attr('table');
        index = $(this).attr('index');
        ajouter_ligne(table, index);
    })
    $('.ajouterligne_c').on('click', function () {
        table = $(this).attr('table');
        index = $(this).attr('index');
        ajouter_ligne(table, index);
    })
    $('.ajouterligne_famille').on('click', function () {

        table = $(this).attr('table');
        index = $(this).attr('index');
        ajouter_ligne(table, index);
    })
    $('.ajouterligne_inv').on('click', function () {

        table = $(this).attr('table');
        index = $(this).attr('index');
        tr = $(this).attr('tr');
        ajouter_ligne_reglement(table, index, tr);
    })

    $(".testligneinv").on('change', function () {
        valarticle = $(this).val();
        index = $(this).attr('index');
        //alert(val);
        test_ligne(valarticle, index);
    })
    $(".testligneinvdate").on('blur', function () {
        valdate = $(this).val();
        index = $(this).attr('index');
        //alert(val);
        test_ligne(valdate, index);
    })
    $(".testligneinvdate").on('change', function () {
        valdate = $(this).val();
        index = $(this).attr('index');
        //alert(val);
        test_ligne(valdate, index);
    })

    $(".testlignesubmit").on('mousemove', function () {
        var val = 'submit';
        // alert(index);
        test_ligne(val);
    })
    $(".testligneedit").on('mousemove', function () {
        var val = 'submit';
        // alert(index);
        edit_ligne(val);
    })
    $(".ajouterligne_inv").on('mousemove', function () {
        var val = 'submit';
        // alert(index);
        test_ligne(val);
    })
    $(".ajouterligne_reception").on('mousemove', function () {
        var val = 'submit';
        // alert(index);
        test_ligne(val, index);
    })
    $(".ajouterligne_inv").on('mousemove', function () {
        var val = 'submit';
        // alert(index);
        edit_ligne(val);
    })
    $(".ajouterligne_reception").on('mousemove', function () {
        var val = 'submit';
        // alert(index);
        edit_ligne(val);
    })

    $('.supor').on('click', function () {
        index = $(this).attr('index');
        var sup = 'sup';
        test_ligne(sup, index);
    })
    $('.supor').on('click', function () {
        index = $(this).attr('index');
        var sup = 'sup';
        edit_ligne(sup, index);
    })
    //zeinab
    $(".testlignesubmit").on('mousemove', function () {
        var val = 'submit';
        // alert(index);
        test_ligne(val);
    })
//**********************************************************************
//zeinab
    $('.TestLigneTTFacture').on('mousemove', function () {
        index = $('#index').val(); //alert(" ind  : "+index);
        pointvente = $('#BonreceptionPointdeventeId').val();
        //alert(pointvente);
        if (pointvente == '') {
            bootbox.alert('Point de vente est obligatoire !! ', function () {});
            return false;
        }
        var today = DateLyoum();

        //alert(today);
        for (i = 0; i <= Number(index); i++) {
            if ($('#sup' + i).val() != 1) {
                // alert(i);
                depot = $('#depot_id' + i).val();   //alert('depot'+depot);
                article = $('#article_id' + i).val();   //alert('article'+article);
                qte = $('#quantite' + i).val();   //alert('qte'+qte);
                prix = $('#prixhtva' + i).val();   //alert('prix'+prix);
                tva = $('#tva' + i).val();          // alert('tvaa'+tva);
                date_exp = $('#date_exp' + i).val();  //alert('date_exp '+date_exp);
                if (depot == '' || article == '' || qte == '' || prix == '' || prix == 0.000 || tva == '' || date_exp == '__/__/____' || date_exp == '00/00/0000') {
                    bootbox.alert('les champs:Date Exp , depot, article, quantite, prix et TVA sont obligatoires!! ', function () {});
                    return false;
                }
                var exp = temps(date_exp.split("/"));
                var tod = temps(today.split("/"));
                var nb = (exp - tod) / (1000 * 60 * 60 * 24);
                if (nb <= 0) {
                    bootbox.alert('Date Expiration invalide !! ', function () {});
                    return false;
                }

            }
        }

    })

    $('.TestLigneTTCdde').on('mousemove', function () {
        depot = $('#CommandeDepotId').val();
        pointvente = $('#CommandePointdeventeId').val();

        if (depot == '') {
            bootbox.alert('Depot est obligatoire !! ', function () {});
            return false;
        }
        if (pointvente == '') {
            bootbox.alert('Point de vente est obligatoire !! ', function () {});
            return false;
        }
        index = $('#index').val(); //alert(index);
        for (i = 0; i <= Number(index); i++) {
            if ($('#sup' + i).val() != 1) {
                article = $('#article_id' + i).val();   //alert('article'+article);
                qte = $('#quantite' + i).val();   //alert('qte'+qte);
                prix = $('#prixhtva' + i).val();   //alert('prix'+prix);
                tva = $('#tva' + i).val();          // alert('tvaa'+tva);
                if (article == '' || qte == '' || prix == '' || tva == '') {
                    bootbox.alert('les champs: article, quantite, prix et TVA sont obligatoires!! ', function () {});
                    return false;
                }
            }
        }

    })
//**********************************************************************


    $('.editligneinvarticle').on('change', function () {
        // ind=Number($('#'+index).val())+1;
        //alert(ind);
        valarticle = $(this).val();
        index = $(this).attr('index');
        edit_ligne(valarticle, index);
    })

    $('.editligneinvdate').on('blur', function () {
        //ind=Number($('#'+index).val())+1;
        // alert(ind);
        valarticle = $(this).val();
        index = $(this).attr('index');
        edit_ligne(valarticle, index);
    })
    $('.editligneinvdate').on('change', function () {
        //ind=Number($('#'+index).val())+1;
        // alert(ind);
        valarticle = $(this).val();
        index = $(this).attr('index');
        edit_ligne(valarticle, index);
    })
    $('.supor').on('click', function () {
        // alert();
        index = $(this).attr('index');
        $('.supor').each(function () {
            ind = $(this).attr('index');
            if (ind == index) {
                $(this).parent().parent().hide();
                $("#tddesg" + index).parent().hide();
                $('#sup' + index).val(1);
                calculefacture();
            }
        })
    })

    $('.supsituation').on('click', function () {
        // alert();
        index = $(this).attr('index');
        // alert(index);
        $('.supsituation').each(function () {
            ind = $(this).attr('index');
            if (ind == index) {
                $(this).parent().parent().hide();
                $('#supp' + index).val(1);
            }
        })
    })



    $('.suporc').on('click', function () {
        // alert();
        index = $(this).attr('index');
        // alert(index);
        $('.suporc').each(function () {
            ind = $(this).attr('index');
            if (ind == index) {
                $(this).parent().parent().hide();
                $('#sup' + index).val(1);
                calculefacture();
            }
        })
    })

    $('.suporf').on('click', function () {
        // alert();
        index = $(this).attr('index');
        // alert(index);
        $('.suporf').each(function () {
            ind = $(this).attr('index');
            if (ind == index) {
                $(this).parent().parent().hide();
                $('#sup' + index).val(1);

            }
        })
    })

    $('.supbor').on('click', function () {
        // alert();
        index = $(this).attr('index');
        $('.supbor').each(function () {
            ind = $(this).attr('index');
            if (ind == index) {
                $(this).parent().parent().hide();
                $('#sup' + index).val(1);
                calculmontant();
            }
        })
    })

    $(".ajouterligne_inv").on('mousemove', function () {
        remplirtableau();
    })
    $('.editligneinvarticle').on('change', function () {
        remplirtableau();
    })
    $('.editligneinvdate').on('change', function () {
        remplirtableau();
    })
    $('.testligneedit').on('mousemove', function () {
        remplirtableau();
    })
    $('.testtotal').on('keyup', function () {
        testlignereception(0);
    })
    $('.testtotal').on('keyup', function () {
        testlignefacture(0);
    })
    $('.ajouterligne_reception').on('click', function () {

        table = $(this).attr('table');
        index = $(this).attr('index');
        tr = $(this).attr('tr');
        ajouter_ligne_reception(table, index, tr);
    })

    $('.ajouter_lignetransfert').on('click', function () {

        table = $(this).attr('table');
        index = $(this).attr('index');
        tr = $(this).attr('tr');
        ajouter_ligne_transfert(table, index, tr);
    })

    $('.ajouterligne_be').on('click', function () {

        table = $(this).attr('table');
        index = $(this).attr('index');
        tr = $(this).attr('tr');
        ajouter_ligne_reception(table, index, tr);
    })

    $('.ajouterligne_livraison').on('click', function () {

        table = $(this).attr('table');
        index = $(this).attr('index');
        tr = $(this).attr('tr');
        ajouter_ligne_livraison(table, index, tr);
    })
    $('.testlignereception').on('mousemove', function () {
        val = $('#Total_HT').val();
        var i = 0;
        while ($('#article_id' + i).val() != undefined) {

            if ($('#article_id' + i).val() == 0) {
                // alert('la case '+i+'est vide');
                $('.supor').each(function () {

                    $('#sup' + i).parent().parent().hide();
                    $('#sup' + i).val(1);
                    calculefacturef();

                })
            }
            i++;
        }
        testlignereception(val);
    })
    $('.testlignefacture').on('mousemove', function () {
        val = $('#Total_HT').val();
        var i = 0;
        while ($('#article_id' + i).val() != undefined) {

            if ($('#article_id' + i).val() == 0) {
                // alert('la case '+i+'est vide');
                $('.supor').each(function () {

                    $('#sup' + i).parent().parent().hide();
                    $('#sup' + i).val(1);
                    calculefacture();

                })
            }
            i++;
        }
        testlignefacture(val);
    })
    $('.art').on('change', function () {
        ind = $(this).attr('index');
        art(ind);
    })


    $('.suporfacturefrs').on('click', function () {
        index = $(this).attr('index');
        //alert(index);
        $('#sup' + index).val(1);
        calculefacturef();
        $(this).parent().parent().hide();
        $("#tddesg" + index).parent().hide();
    })

    $('.artfac').on('change', function () {
        ind = $(this).attr('index');
        artfac(ind);
    })

    //liste des point de vente

    $('.choixposte').on('click', function () {
        if ($(this).prop('checked')) {
            val = $(this).val();
            if (val == 1) {

                $('.pointdevente').show();
            } else {

                $('.pointdevente').hide();
            }
        }
    });
})
function test_bs(index, qte, qtestock) {
    if (Number(qte) > Number(qtestock)) {
        bootbox.alert('Quantite invalide !!', function () {});

        $('#quantitedetail' + index).val(0);
    }
}
function test_bl(index, qte, qtestock, type) {
    $.ajax({
        type: "POST",
        url: wr + "Utilisateurs/testqtenegatif/",
        dataType: "json",
        global: false //}l'envoie'
    }).done(function (data) {
        //alert(data.qtenegatif);
        if (data.qtenegatif == 0) {
            if (Number(qte) > Number(qtestock)) {
//                alert(type);
                if (type == 0) {
                    bootbox.alert('Quantite invalide !', function () {});
                    $('#quantite' + index).val(0);
                    calculefacturef();
                } else {
                    calculefacturef();
                }
            }
        }
    })
}

function  tvaart(index) {
    //alert(index);
    article_id = $('#article_id' + index).val();
    //alert(article_id);

    fournisseur_id = $('#fc').val();
    //alert(fournisseur_id);

    $.ajax({
        type: "POST",
        data: {
            id: article_id
            , fid: fournisseur_id
        },
        url: wr + "Bonreceptions/getarticles/",
        dataType: "json",
        global: false //}l'envoie'
    }).done(function (data) {
        // alert(data.tva);
        coef = $('#coef').val() || 1;
        coutrevien = Number(coef) * Number(data.prix);

        $('#prixachat' + index).val(data.prix);
        $('#marge' + index).val(data.marge);
        //zeinab
        $('#margeans' + index).val(data.marge);
        $('#prixachatans' + index).val(data.prixanc);

        $('#code' + index).val(data.code);
        $('#tva' + index).val(data.tva);
        $('#prixhtva' + index).val(coutrevien.toFixed(3));
        $('#prix' + index).val(data.prix);
        $('#prix_anc' + index).val(data.prix);
        $('#reference' + index).val(data.ref);
        $('#idart' + index).val(data.idart);
        $('#order' + index).show();
    })
}
function testlignereception(val) {
    calculefacturef(); //alert(val);
    ttht = $('#Total_HT').val();
    if ((val == 0) & (ttht == 0)) {
        bootbox.alert('il n\'existe aucune ligne valide !!', function () {});
        return false;
    }
}
function testlignefacture(val) {
    calculefacture(); //alert(val);
    ttht = $('#Total_HT').val();
    if ((val == 0) & (ttht == 0)) {
        bootbox.alert('il n\'existe aucune ligne valide !!', function () {});
        return false;
    }
}
function  art(index) {
    ///alert(index);
    article_id = $('#article_id' + index).val();
    depot_id = $('#depot_id' + index).val();
    //  alert(article_id);
    //  alert('depooo ='+depot_id);

    $.ajax({
        type: "POST",
        data: {
            id: article_id,
            depotid: depot_id
        },
        url: wr + "Bonlivraisons/article/",
        dataType: "json",
        global: false //}l'envoie'
    }).done(function (data) {
        //alert(data);
        $('#tva' + index).val(data.tva);
        $('#prixhtva' + index).val(data.prix);
        $('#quantitestock' + index).val(data.quantitestock);
        $('#prixachat' + index).val(data.prixachat);
        $('#designation' + index).val(data.des);
        $('#totalttc' + index).val(data.prixttc);
        $('#totalht' + index).val(data.prix);
    })
}


function  artcode(index) {
     alert(index);
    article_id = $('#article_id' + index).val();
    depot_id = $('#depot_id' + index).val();
    //  alert(article_id);
    //  alert('depooo ='+depot_id);

    $.ajax({
        type: "POST",
        data: {
            id: article_id,
            depotid: depot_id
        },
        url: wr + "Bonlivraisons/articlecode/",
        dataType: "json",
        global: false //}l'envoie'
    }).done(function (data) {
        //alert(data);
        $('#tva' + index).val(data.tva);
        $('#prixhtva' + index).val(data.prix);
        $('#quantitestock' + index).val(data.quantitestock);
        $('#prixachat' + index).val(data.prixachat);
        $('#designation' + index).val(data.des);
        $('#totalttc' + index).val(data.prixttc);
        $('#totalht' + index).val(data.prix);
    })
}
function  artfac(index) {
    // alert(index);
    article_id = $('#article_id' + index).val();
    //  alert(article_id);

    $.ajax({
        type: "POST",
        data: {
            id: article_id
        },
        url: wr + "Factureclients/article/",
        dataType: "json",
        global: false //}l'envoie'
    }).done(function (data) {
        //alert(data);
        $('#tva' + index).val(data.tva);
        $('#prixhtva' + index).val(data.prix);
    })
}
function getsoussousfamille() {
    sousfamilleid = $('#sousfamille_id').val(); //alert (sousfamilleid);
    $('.ssfe').show();
    $.ajax({
        type: "POST",
        data: {
            sousfamilleid: sousfamilleid

        },
        url: wr + "Articles/getsoussousfamille/",
        dataType: "html",
        global: false //}l'envoie'
    }).done(function (data) {
        console.log(data);
        $('#divsoussousfamille').html('');
        $('#divsoussousfamille').html(data);
        uniform_select('soussousfamille_id');
    })
}
function  getpiece(index) {
    piecereglementclient_id = $('#piecereglementclient_id' + index).val();
    //foreach()
    var i = 0;
    var b = 0;
    while (i < index) {
        if ($('#piecereglementclient_id' + index).val() == $('#piecereglementclient_id' + i).val()) {
            b = 1;
        }
        i++;
    }
    if (b == 1) {
        bootbox.alert('impossible d\'insérer  deux ligne avec la meme  piece', function () {});
        $('#sup' + index).parent().parent().hide();
        $('#sup' + index).val(1);
    } else {
        $.ajax({
            type: "POST",
            data: {
                id: piecereglementclient_id,
            },
            url: wr + "Bordereaus/getpiece/",
            dataType: "json",
            global: false
        }).done(function (data) {

            $('#banque' + index).val(data.banque);
            $('#montant' + index).val(data.montant);
            calculmontant();
        })
    }
}
function  calculmontant() {
    total = 0;
    max = $('#index').val(); //alert(max);
    for (i = 0; i <= max; i++) {
        // alert(i);
        if ($('#sup' + i).val() != 1) {
            montant = $('#montant' + i).val() || 0;// alert(montant);
            total = (Number(total) + Number(montant)).toFixed(3);
        }
    }
    $('#total').val(total);
}


function  qteart(index) {
    //index= $(this).attr('index');
    article_id = $('#article_id' + index).val();
    depot_id = $('#depot_id' + index).val();
    //alert(article_id);
    //alert(article_id);

    $.ajax({
        type: "POST",
        data: {
            id: article_id,
            depotid: depot_id
        },
        url: wr + "Bonlivraisons/article/",
        dataType: "json",
        global: false //}l'envoie'
    }).done(function (data) {
        //alert(data);
        $('#tva' + index).val(data.tva);
        $('#prixhtva' + index).val(data.prix);
        $('#quantitestock' + index).val(data.quantitestock);
        $('#prixachat' + index).val(data.prixachat);

    })
}
function  qteartedit() {
    index = $('#index').val();
    article_id = $('#article_id' + index).val();
    depot_id = $('#depotdepart1').val();
    //alert(index);
    // alert(article_id);

    $.ajax({
        type: "POST",
        data: {
            id: article_id,
            depotid: depot_id
        },
        url: wr + "Bonlivraisons/article/",
        dataType: "json",
        global: false //}l'envoie'
    }).done(function (data) {
        //alert(data);
        $('#tva' + index).val(data.tva);
        $('#prixhtva' + index).val(data.prix);
        $('#quantitestock' + index).val(data.quantitestock);
        $('#prixachat' + index).val(data.prixachat);

    })
}
function qtestock(index) {
    article_id = $('#article_id' + index).val();
    depotdepart = $('#depotdepart').val();
    $.ajax({
        type: "POST",
        data: {
            id: article_id,
            depotid: depotdepart
        },
        url: wr + "Bonlivraisons/article/",
        dataType: "json",
        global: false //}l'envoie'
    }).done(function (data) {
        $('#quantitestock' + index).val(data.quantitestock);

    })
}



var tabnum = new Array();
var tabq = new Array();
var tabe = new Array();
var tabqe = new Array();

function DateLyoum() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!

    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    //var today = dd+'/'+mm+'/'+yyyy;
    var today = dd + '/' + mm + '/' + yyyy;
    return today
}

//function convertdate(datechoix) {
//    alert("datechoix "+datechoix)
//  var today = new Date(datechoix);
//    var dd = today.getDate();
//    var mm = today.getMonth()+1; //January is 0!
//
//    var yyyy = today.getFullYear();
//    if(dd<10){
//        dd='0'+dd;
//    }
//    if(mm<10){
//        mm='0'+mm;
//    }
//    //var today = dd+'/'+mm+'/'+yyyy;
//    var datechoix = yyyy+'/'+mm+'/'+dd;
//    return datechoix
//}
function convertDate(inputFormat) {
    alert("inputFormat " + inputFormat)
    function pad(s) {
        return (s < 10) ? '0' + s : s;
    }
    var d = new Date(inputFormat);
    datechoix = [pad(d.getDate()), pad(d.getMonth() + 1), d.getFullYear()].join('/');
    return   datechoix;
}


/*
 .col-lg-offset-3{margin-left:50%}
 .panel{margin-bottom:20px;
 ,.col-sm-12,.col-md-12,.col-lg-12{position:relative;
 */
