$(document).ready(function ()
{
    $('.amineselect').on('keyup', function () {
        val = $(this).val();//alert(val);
        index = $(this).attr('index') || 0;
        if (val.length > 2) {
            $('#res' + index).show();
            result1 = "";
            $.ajax({
                type: "POST",
                data: {
                    val: val,
                },
                url: wr + "Articles/haithamselect/",
                dataType: "JSON"
            }).done(function (data) {

                $.each(data, function (i, item) {
                    $.each(item, function (i, dd) {
                        //alert('aaa');
                        console.log(dd);
                        dd.Article.nom = dd.Article.nom.replace("'", "`");
                        result1 = result1 + "<a class='option' id='" + dd.Article.id + "' style='text-decoration:none;z-index: 1000' href=\"javascript:setamineselect('" + dd.Article.id + "','" + dd.Article.code + "','" + index +"','"+ dd.Article.nom + "');\"><div class='aa'>"+ dd.Article.code +" " + dd.Article.name + "</div></a>";
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

    $('.codeselectindex').on('keyup', function () {
        val = $(this).val();//alert(val);
        index = $(this).attr('index') || 0;
        if (val.length > 1) {
			var obj = $("#rescode" + index);
                obj.html("");
            $('#rescode' + index).show();
            result1 = "";
            $.ajax({
                type: "POST",
				async:false,
                url: wr + "Articles/codeselectindex/" + val,
                dataType: "JSON"
            }).done(function (data) {
				//alert(data.Prix.length);
				//console.log(data.Prix);
                //$.each(data.Prix, function (i, item) {
				for (i = 0; i < data.Prix.length; i++) {
					//alert(i);
					//console.log(data.Prix[i]['Article']['id']);
					//console.log(data.Prix[i][Article]['code']);
					console.log(data.Prix[i].Article.name);
                        result1 = result1 + "<a class='option' id='" + data.Prix[i]['Article']['id'] + "' style='text-decoration:none;z-index: 1000' href=\"javascript:setQuerycodeindex('" + data.Prix[i]['Article']['id'] + "','" + data.Prix[i]['Article']['code'].replace(/'/g, '**123*456**').replace(/"/g, '**123**456**')+ "','" + index + "','" + data.Prix[i]['Article']['name'].replace(/'/g, '**123*456**').replace(/"/g, '**123**456**') + "');\"><div class='aa'>" + data.Prix[i]['Article']['code'] + "</div></a>";
                }
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
    $('.checktimbre').on('change', function () {
        client_id = $('#client_id').val();
        //alert(client_id);
        $.ajax({
            type: "POST",
            data: {
            },
            url: wr + "Clients/checktimbre/"+client_id,
            dataType: "json",
            async: false,
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data.clt.Client);
            if(data.clt.Client.avectimbre_id=='Non'){
                $('#timbre').val('0');
            }
        })
    })
    $('.ajoutbl').on('click', function () { 
        $('#listeblajout').show();
        $('#listeblsup').hide();
    });
    $('.suppbl').on('click', function () { //alert();
        $('#listeblajout').hide();
        $('#listeblsup').show();
    });
    $('.checkexist').on('mousemove', function () { 
        blfacture_id = $('#blfacture_id').val(); //alert(blfacture_id);
        blfacturesup_id = $('#blfacturesup_id').val();//alert(blfacturesup_id);
        
        if((blfacture_id=='' && blfacturesup_id=='') || (blfacture_id==null && blfacturesup_id==null)){
            bootbox.alert('Veuillez choisir des BL à ajouter ou à supprimer avant !', function () {});
                        return false;
        }
    });
    $('.etatfacture').on('click', function () { //alert();
        date1 = $('#date1').val() || 0;
        date2 = $('#date2').val() || 0;
        clientidfacture = $('#clientidfacture').val() || 0;
        anneefacture = $('#anneefacture').val() || 0;
        pvfacture = $('#pvfacture').val() || 0;
        //alert(leid);
        $.ajax({
            type: "POST",
            data: {
                date1: date1,
                date2: date2,
                clientidfacture: clientidfacture,
                anneefacture: anneefacture,
                pvfacture: pvfacture
            },
            url: wr + "Factureclients/etatfacturesession/",
            dataType: "json",
            async: false,
            global: false //}l'envoie'
        }).done(function (data) {
            //window.open(wr+"Newfichepaies/imprimerfichepaienew/","nom_popup","menubar=no,location=no,  status=no, scrollbars=no, menubar=no, width=800, height=800");
        });
    });

    $('.testmatriculefiscale').blur(function (e) {
        matriculefiscale = $('#matriculefiscale').val();
        operation = $('#operation').val();
        if(operation=='edit'){
            clientid = $('#clientid').val();
        }else{
            clientid=0;
        }
        if (matriculefiscale != '') {
            $.ajax({
                type: "POST",
                data: {
                    matriculefiscale: matriculefiscale,
                    clientid:clientid
                },
                url: wr + "Clients/checkmatricule",
                dataType: "json",
                async: false,
                global: false //}l'envoie'
            }).done(function (data) {
                console.log(data.nb);
                if(Number(data.nb) > 0){
                    $(":submit").attr("disabled", true);
                     bootbox.alert("Matricule fiscale existe déjà !!", function () {});
                }else{
                    $(":submit").removeAttr("disabled");
                }
            });
        }
    });

    $('.etatfacture2').on('click', function () { //alert();
        date1 = $('#date1').val() || 0;
        date2 = $('#date2').val() || 0;
        reglement = $('#reglement').val() || 0;
        triage = $('#triage').val() || 0;
        vente = $('#vente').val() || 0;
        clientcode = $('#clientcode').val() || 0;
        zonedetail = $('#zonedetail').val() || 0;
        //alert(triage);
        $.ajax({
            type: "POST",
            data: {
                date1: date1,
                date2: date2,
                reglement: reglement,
                triage: triage,
                vente: vente,
                clientcode: clientcode,
                zonedetail: zonedetail
            },
            url: wr + "Factureclients/etatfacturesession2/",
            dataType: "json",
            async: false,
            global: false //}l'envoie'
        }).done(function (data) {
            //window.open(wr+"Newfichepaies/imprimerfichepaienew/","nom_popup","menubar=no,location=no,  status=no, scrollbars=no, menubar=no, width=800, height=800");
        });
    });

    $('.etatfacturerecette').on('click', function () { //alert();
        datereglement1 = $('#datereglement1').val() || 0;
        dateecheance1 = $('#dateecheance1').val() || 0;
        datebordereau1 = $('#datebordereau1').val() || 0;
        clientcode = $('#clientcode').val() || 0;
        paiement_id = $('#paiement_id').val() || 0;
        encaissement_id = $('#encaissement_id').val() || 0;
        datereglement2 = $('#datereglement2').val() || 0;
        dateecheance2 = $('#dateecheance2').val() || 0;
        datebordereau2 = $('#datebordereau2').val() || 0;
        triagereglement = $('#triagereglement').val() || 0;
        anneereglement = $('#exercice_id').val() || 0;
        pointdevente_id = $('#pointdevente_id').val() || 0;
        //alert(triage);
        $.ajax({
            type: "POST",
            data: {
                datereglement1: datereglement1,
                dateecheance1: dateecheance1,
                datebordereau1: datebordereau1,
                clientcode: clientcode,
                paiement_id: paiement_id,
                encaissement_id: encaissement_id,
                datereglement2: datereglement2,
                dateecheance2: dateecheance2,
                datebordereau2: datebordereau2,
                triagereglement: triagereglement,
                anneereglement: anneereglement,
                pointdevente_id: pointdevente_id
            },
            url: wr + "Reglementclients/etatrecettesession/",
            dataType: "json",
            async: false,
            global: false //}l'envoie'
        }).done(function (data) {
            //window.open(wr+"Newfichepaies/imprimerfichepaienew/","nom_popup","menubar=no,location=no,  status=no, scrollbars=no, menubar=no, width=800, height=800");
        });
    });
    $('.etatdetailachat').on('click', function () { //alert();
        datedebutimpaye = $('#datedebutimpaye').val() || 0;
        reglementimpaye = $('#reglementimpaye').val() || 0;
        datefinimpaye = $('#datefinimpaye').val() || 0;
        triageimpaye = $('#triageimpaye').val() || 0;
        fournisseurimpaye = $('#fournisseurimpaye').val() || 0;
        venteimpaye = $('#venteimpaye').val() || 0;
        pointdeventeachat = $('#pointdeventeachat').val() || 0;
        //alert(triage);
        $.ajax({
            type: "POST",
            data: {
                datedebutimpaye: datedebutimpaye,
                datefinimpaye: datefinimpaye,
                triageimpaye: triageimpaye,
                reglementimpaye: reglementimpaye,
                fournisseurimpaye: fournisseurimpaye,
                venteimpaye: venteimpaye,
                pointdeventeachat: pointdeventeachat
            },
            url: wr + "Factures/etatimpayesession/",
            dataType: "json",
            async: false,
            global: false //}l'envoie'
        }).done(function (data) {
            //window.open(wr+"Newfichepaies/imprimerfichepaienew/","nom_popup","menubar=no,location=no,  status=no, scrollbars=no, menubar=no, width=800, height=800");
        });
    });

    $('.etatimpaye').on('click', function () { //alert();
        datedebutimpaye = $('#datedebutimpaye').val() || 0;
        reglementimpaye = $('#reglementimpaye').val() || 0;
        datefinimpaye = $('#datefinimpaye').val() || 0;
        triageimpaye = $('#triageimpaye').val() || 0;
        exerciceimpaye = $('#exerciceimpaye').val() || 0;
        pointdeventeimpaye = $('#pointdeventeimpaye').val() || 0;
        //alert(pointdeventeimpaye);
        $.ajax({
            type: "POST",
            data: {
                datedebutimpaye: datedebutimpaye,
                datefinimpaye: datefinimpaye,
                triageimpaye: triageimpaye,
                reglementimpaye: reglementimpaye,
                exerciceimpaye: exerciceimpaye,
                pointdeventeimpaye: pointdeventeimpaye
            },
            url: wr + "Reglementclients/etatimpayesession/",
            dataType: "json",
            async: false,
            global: false //}l'envoie'
        }).done(function (data) {
            //window.open(wr+"Newfichepaies/imprimerfichepaienew/","nom_popup","menubar=no,location=no,  status=no, scrollbars=no, menubar=no, width=800, height=800");
        });
    });

    $('.etatachat').on('click', function () { //alert();
        date1 = $('#date1').val() || 0;
        date2 = $('#date2').val() || 0;
        datedec1 = $('#datedec1').val() || 0;
        datedec2 = $('#datedec2').val() || 0;
        clientidfacture = $('#clientidfacture').val() || 0;
        pointdeventeachat = $('#pointdeventeachat').val() || 0;
        //alert(pointdeventeachat);
        $.ajax({
            type: "POST",
            data: {
                date1: date1,
                date2: date2,
                datedec1: datedec1,
                datedec2: datedec2,
                clientidfacture: clientidfacture,
                pointdeventeachat: pointdeventeachat
            },
            url: wr + "Factures/etatfacturesession/",
            dataType: "json",
            async: false,
            global: false //}l'envoie'
        }).done(function (data) {
            //window.open(wr+"Newfichepaies/imprimerfichepaienew/","nom_popup","menubar=no,location=no,  status=no, scrollbars=no, menubar=no, width=800, height=800");
        });
    });

    $('.etatreglemenetachatachat').on('click', function () { //alert();
        date1 = $('#date1').val() || 0;
        date2 = $('#date2').val() || 0;
        clientidfacture = $('#clientidfacture').val() || 0;
        pointdeventeachat = $('#pointdeventeachat').val() || 0;
        //alert(leid);
        $.ajax({
            type: "POST",
            data: {
                date1: date1,
                date2: date2,
                clientidfacture: clientidfacture,
                pointdeventeachat: pointdeventeachat
            },
            url: wr + "Reglements/etatreglibresession/",
            dataType: "json",
            async: false,
            global: false //}l'envoie'
        }).done(function (data) {
            //window.open(wr+"Newfichepaies/imprimerfichepaienew/","nom_popup","menubar=no,location=no,  status=no, scrollbars=no, menubar=no, width=800, height=800");
        });
    });

    $('.testligneachat').on('mousemove', function () {
        // alert();
        indexx = $('#index').val() || 0;
        //depotarrive = $('#depotarrive').val() || 0;
        //alert(indexx);
        test = 0;
        for (index = 1; index <= Number(indexx); index++) {
            if ($('#sup' + index).val() != 1) {
                if ($('#article_id' + index).val() != "") {
                    date_exp = $('#ldate').val();
                    article_id = $('#article_id' + index).val();
                    qte = $('#quantite' + index).val() || 0;
                    prixhtva = $('#prixhtva' + index).val();
                    remise = $('#remise' + index).val();
                    fodec = $('#fodec' + index).val();
                    if ((article_id == '') || (qte == 0) || (prixhtva == '')) {
                        test = 1;
                    }
                }
            }
        }

        if (test == 1) {
            bootbox.alert('vérifier les champs des lignes existants', function () {
            });
            return false
        }
        fc = $('#fc').val();
        if (fc == '') {
            bootbox.alert('Fournisseur obligatoire', function () {
            });
            return false
        }
        depot_id = $('#depot_id').val();
        if (depot_id == '') {
            bootbox.alert('Depot obligatoire', function () {
            });
            return false
        }
    });
    $('.familleselect').on('keyup', function () {
        val = $(this).val();//alert(val);
        index = $(this).attr('index') || 0;
        if (val.length > 2) {
            $('#resfamille' + index).show();
            result1 = "";
            $.ajax({
                type: "POST",
                url: wr + "Familles/familleselect/",
                dataType: "JSON",
                data: {
                    val: val
                }
            }).done(function (data) {

                $.each(data, function (i, item) {
                    $.each(item, function (i, dd) {
                        //alert('aaa');
                        console.log(dd);
                        dd.Famille.name = dd.Famille.name.replace("'", "`");
                        result1 = result1 + "<a class='option' id='" + dd.Famille.id + "' style='text-decoration:none;z-index: 1000' href=\"javascript:setQueryfamille('" + dd.Famille.id + "','" + dd.Famille.code + "','" + escape(dd.Famille.name) + "','" + index + "');\"><div class='aa'>" + dd.Famille.name + "</div></a>";
                    })
                })
                var obj = $("#resfamille" + index);
                obj.html(result1);
                //console.log(obj.html());
                if (result1 != '') {
                    obj.css("visibility", "visible");
                } else {
                    obj.css("visibility", "hidden");
                }

            })
        } else {
            var obj = $("#resfamille" + index);
            obj.css("visibility", "hidden");
        }
    })
    $('.sousfamilleselect').on('keyup', function () {
        val = $(this).val();//alert(val);
        index = $(this).attr('index') || 0;
        if (val.length > 2) {
            $('#ressousfamille' + index).show();
            famille_id = $('#famille_id' + index).val() || 0;
            result1 = "";
            $.ajax({
                type: "POST",
                url: wr + "Sousfamilles/sousfamilleselect/",
                dataType: "JSON",
                data: {
                    val: val,
                    famille_id: famille_id
                }
            }).done(function (data) {

                $.each(data, function (i, item) {
                    $.each(item, function (i, dd) {
                        //alert('aaa');
                        console.log(dd);
                        dd.Sousfamille.name = dd.Sousfamille.name.replace("'", "`");
                        result1 = result1 + "<a class='option' id='" + dd.Sousfamille.id + "' style='text-decoration:none;z-index: 1000' href=\"javascript:setQuerysousfamille('" + dd.Sousfamille.id + "','" + dd.Sousfamille.code + "','" + escape(dd.Sousfamille.name) + "','" + index + "');\"><div class='aa'>" + dd.Sousfamille.name + "</div></a>";
                    })
                })
                var obj = $("#ressousfamille" + index);
                obj.html(result1);
                //console.log(obj.html());
                if (result1 != '') {
                    obj.css("visibility", "visible");
                } else {
                    obj.css("visibility", "hidden");
                }

            })
        } else {
            var obj = $("#ressousfamille" + index);
            obj.css("visibility", "hidden");
        }
    })
    $('.soussousfamilleselect').on('keyup', function () {
        val = $(this).val();//alert(val);
        index = $(this).attr('index') || 0;
        if (val.length > 2) {
            $('#ressoussousfamille' + index).show();
            sousfamille_id = $('#sousfamille_id' + index).val() || 0;
            result1 = "";
            $.ajax({
                type: "POST",
                url: wr + "Soussousfamilles/soussousfamilleselect/",
                dataType: "JSON",
                data: {
                    val: val,
                    sousfamille_id: sousfamille_id
                }
            }).done(function (data) {

                $.each(data, function (i, item) {
                    $.each(item, function (i, dd) {
                        //alert('aaa');
                        console.log(dd);
                        dd.Soussousfamille.name = dd.Soussousfamille.name.replace("'", "`");
                        result1 = result1 + "<a class='option' id='" + dd.Soussousfamille.id + "' style='text-decoration:none;z-index: 1000' href=\"javascript:setQuerysoussousfamille('" + dd.Soussousfamille.id + "','" + dd.Soussousfamille.code + "','" + escape(dd.Soussousfamille.name) + "','" + index + "');\"><div class='aa'>" + dd.Soussousfamille.name + "</div></a>";
                    })
                })
                var obj = $("#ressoussousfamille" + index);
                obj.html(result1);
                //console.log(obj.html());
                if (result1 != '') {
                    obj.css("visibility", "visible");
                } else {
                    obj.css("visibility", "hidden");
                }

            })
        } else {
            var obj = $("#ressoussousfamille" + index);
            obj.css("visibility", "hidden");
        }
    })

    $('.calculprixnet').on('keyup', function () {
        prixhtbrut = $('#prixhtbrut').val() || 0;
        remiseachat = $('#remiseachat').val() || 0;
        remise = Number(prixhtbrut) * Number(remiseachat) / 100;
        prixachatnet = Number(Number(prixhtbrut) - Number(remise)).toFixed(3);
        $('#prixachatnet').val(prixachatnet);
    });
    $('.calculprixventegros').on('keyup', function () {
        prixhtbrut = $('#prixhtbrut').val() || 0;
        margebrutgros = $('#margebrutgros').val() || 0;
        margebrutgross = Number(prixhtbrut) * Number(margebrutgros) / 100;
        prixventegros = Number(Number(prixhtbrut) + Number(margebrutgross)).toFixed(3);
        $('#prixventegros').val(prixventegros);

        //alert(margebrutgros);
        prixachatnet = $('#prixachatnet').val() || 0;
        margenet = 0;
        if (Number(prixachatnet) != 0) {
            margenet = Number(((Number(prixventegros) - Number(prixachatnet)) / Number(prixachatnet)) * 100).toFixed(3);
        }
        if (Number(margebrutgros) == 0)
        {
            margenet = 0;
        }
        $('#margenetgros').val(margenet);
    });
    $('.calculprixventegrosnet').on('keyup', function () {
        prixachatnet = $('#prixachatnet').val() || 0;
        margenetgros = $('#margenetgros').val() || 0;
        margebrutgrosnet = Number(prixachatnet) * Number(margenetgros) / 100;
        prixventegros = Number(Number(prixachatnet) + Number(margebrutgrosnet)).toFixed(3);
        $('#prixventegros').val(prixventegros);

        prixhtbrut = $('#prixhtbrut').val() || 0;
        margebrutt = 0;
        if (Number(prixhtbrut) != 0) {
            margebrutt = Number(((Number(prixventegros) - Number(prixhtbrut)) / Number(prixhtbrut)) * 100).toFixed(3);
        }
        if (Number(margenetgros) == 0)
        {
            margebrutt = 0;
        }
        $('#margebrutgros').val(margebrutt);
        if (Number(margenetgros) == 0) {
            prixhtbrut = $('#prixhtbrut').val() || 0;
            $('#prixventegros').val(prixhtbrut);
        }

    });


    $('.calculprixventedetail').on('keyup', function () {
        prixhtbrut = $('#prixhtbrut').val() || 0;
        margebrutgros = $('#margebrutdetails').val() || 0;
        margebrutgross = Number(prixhtbrut) * Number(margebrutgros) / 100;
        prixventegros = Number(Number(prixhtbrut) + Number(margebrutgross)).toFixed(3);
        $('#prixventedetails').val(prixventegros);

        //alert(margebrutgros);
        prixachatnet = $('#prixachatnet').val() || 0;
        margenet = 0;
        if (Number(prixachatnet) != 0) {
            margenet = Number(((Number(prixventegros) - Number(prixachatnet)) / Number(prixachatnet)) * 100).toFixed(3);
        }
        if (Number(margebrutgros) == 0)
        {
            margenet = 0;
        }
        $('#margenetdetails').val(margenet);
    });

    $('.calculprixventedetailnet').on('keyup', function () {
        prixachatnet = $('#prixachatnet').val() || 0;
        margenetgross = $('#margenetdetails').val() || 0;
        margebrutgrosnet = Number(prixachatnet) * Number(margenetgross) / 100;
        prixventegros = Number(Number(prixachatnet) + Number(margebrutgrosnet)).toFixed(3);
        $('#prixventedetails').val(prixventegros);

        prixhtbrut = $('#prixhtbrut').val() || 0;
        margebrutt = 0;
        if (Number(prixhtbrut) != 0) {
            margebrutt = Number(((Number(prixventegros) - Number(prixhtbrut)) / Number(prixhtbrut)) * 100).toFixed(3);
        }
        if (Number(margenetgross) == 0)
        {
            margebrutt = 0;
        }
        $('#margebrutdetails').val(margebrutt);
        if (Number(margenetgross) == 0) {
            prixhtbrutt = $('#prixhtbrut').val() || 0;
            $('#prixventedetails').val(prixhtbrutt);
        }

    });


    $('.checkjournee').on('mousemove', function (e) {
        //alert();
        //e.preventDefault();
        depot_id = $('#depot_id').val() || 0;
        //alert(depot_id);
        $.ajax({
            type: "POST",
            data: {
                depot_id: depot_id
            },
            url: wr + "Journees/checkjournee/",
            dataType: "json",
            async: false,
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            if (Number(data.nb) != 0) {
                bootbox.alert('Il existe une journee ouverte pour ce depot !!', function () {
                });
                return false;
            }
        });



    });

});
function setQueryfamille(id, code, des, index) {//alert(index);
    //alert(index);
    $('#famille_id' + index).val(id);
    $('#famille' + index).val(des);
    $("#resfamille" + index).css("visibility", "hidden");
    //articleidbl (index);
    $('#sousfamille' + index).focus();

}
function setQuerysousfamille(id, code, des, index) {//alert(index);
    //alert(index);
    $('#sousfamille_id' + index).val(id);
    $('#sousfamille' + index).val(des);
    $("#ressousfamille" + index).css("visibility", "hidden");
    //articleidbl (index);
    $('#soussousfamille' + index).focus();

}
function setQuerysoussousfamille(id, code, des, index) {//alert(index);
    //alert(index);
    $('#soussousfamille_id' + index).val(id);
    $('#soussousfamille' + index).val(des);
    $("#ressoussousfamille" + index).css("visibility", "hidden");
    //articleidbl (index);
    indexn = index + 1;
    $('#articlefrs_id' + indexn).focus();

}      
function setQuerycodeindex(id, code, index,name) {//alert(index);
    //alert(name);
    $('#article_id' + index).val(id);
    //alert(code);
    $('#code' + index).val(code.replace( '**123*456**',"'").replace( '**123**456**','"'));
    $('#designation' + index).val(name.replace( '**123*456**',"'").replace( '**123**456**','"'));
    $("#rescode" + index).css("visibility", "hidden"); 
}  
function setamineselect(id, code, index,name) {//alert(index);
    //alert(index);
    page = $('#page').val() || 0;
   // alert(page);
    $('#article_id' + index).val(id);
   // alert(id);
    $('#code' + index).val(code);
//    alert(des);
    $('#designation' + index).val(name);
//    alert(code);
    $("#res" + index).css("visibility", "hidden");
}   