
$(document).ready(function () {

    //*************************************************************************************************************
    $('.cocherarticle').on('click', function () {
        index = $(this).attr('index');
        ligne = $(this).attr('ligne');
        ind = $(this).attr('ind');
        for (i = 0; i <= Number(ligne); i++) {
            for (j = 0; i <= Number(ind); i++) {
                $('#' + index + i).prop('checked', true);
            }
        }
        $('#divcommande').show();
    })
	//****************************************hafedh*****************************************************************
/*
	$(".calculecommercial").on('keyup', function () {
		//alert("aaaaaa")
		prixventeht = $('#prixvente').val();
		prixventettc = $('#prixuttc').val();

		prixcommercialht = (Number(prixventeht) * 10) / 100;
		prixcommercialttc = (Number(prixventettc) * 10) / 100;

		$('#commercialht').val(Number(prixventeht)-prixcommercialht);
		$('#commercialttc').val(Number(prixventeht)-prixcommercialttc);


	})*/
    //*************************************************************************************************************
    $('.decocherarticle').on('click', function () {
        index = $(this).attr('index');
        ligne = $(this).attr('ligne');
        ind = $(this).attr('ind');
        for (i = 0; i <= Number(ligne); i++) {
            for (j = 0; i <= Number(ind); i++) {
                $('#' + index + i).prop('checked', false);
            }
        }
        $('#divcommande').hide();
    })

    //*************************************************************************************************************
    $('.cocheru').on('click', function () {

        index = $(this).attr('index');
        ligne = $(this).attr('ligne');
        ind = $(this).attr('ind');
        for (i = 0; i <= Number(ligne); i++) {
            for (j = 0; i <= Number(ind); i++) {
                $('#' + index + i).prop('checked', true);
            }
        }
    })
    //*************************************************************************************************************
    $('.decocheru').on('click', function () {
        index = $(this).attr('index');
        ligne = $(this).attr('ligne');
        ind = $(this).attr('ind');
        for (i = 0; i <= Number(ligne); i++) {
            for (j = 0; i <= Number(ind); i++) {
                $('#' + index + i).prop('checked', false);
            }
        }
    })
//**************************************************************************************************************



    $(".testautorisation").on('click', function (e) {
    	alert("aaa");
        e.preventDefault();
        client_id = $('#client_id').val();
        ttcglobale = $('#ttcglobale').val();

        if (client_id != "") {
            //alert(client_id);
            $.ajax({
                type: "POST",
                data: {
                    id: client_id,
                },
                url: wr + "Bonlivraisons/getclients/",
                dataType: "json",
                global: false //}l'envoie'
            }).done(function (data) {
            	//alert("aaaa");
                console.log(data.vente);
                auto = data.autorisation;
                modeclientid = data.modeclientid;
                reste = data.valreste;
                solde = data.solde;
                ttcglobale = $('#Total_TTC').val();
                valreste = $('#valreste').val() || 0;
                tot = Number(ttcglobale);
				if(data.vente=='detail'){
					$("#optionsRadios11").prop("checked", true);
					$("#optionsRadios12").prop("checked", false);
				}else{
					$("#optionsRadios12").prop("checked", true);
					$("#optionsRadios11").prop("checked", false);
				}
                //alert(tot);
                //alert(reste);
                //alert(solde);
                //if(auto==1){
                if (modeclientid == 1) {
                    if (Number(tot) > Number(valreste)) {
                        bootbox.alert('ce client dépasse l\'autorisation', function () {});
                        return false
                    } else {
                        $('#defaultForm').submit();
                    }
                } else {
                    $('#defaultForm').submit();
                }

            })

        } else {
            bootbox.alert('Choisir un client SVP', function () {});
        }

    })


//********************************************************************************************************
    // obtenir le  prix et le tva de l'article choisi pour linterface bl ***************************
    $('#client_id').on('change', function () {

        index = $('#index').val();
        //alert(index);
        for (var i = 0; i <= index; i++) {
            j = 1;
            article_id = $('#article_id' + j).val();
            sup = $('#sup' + j).val();
            depot_id = $('#depot_id').val();
            client_id = $('#client_id').val();
            if ((depot_id != '') && (article_id != '') && (sup != 1)) {


                //alert(depot_id+'---'+article_id+'-----'+client_id);


                $.ajax({
                    type: "POST",
                    data: {
                        id: article_id,
                        depotid: depot_id,
                        clientid: client_id,
                    },
                    url: wr + "Bonlivraisons/article/",
                    dataType: "json",
                    global: false //}l'envoie'
                }).done(function (data) {
                    console.log(data);
                    $('#remise' + j).val(data.remise);
                    $('#remiseans' + j).val(data.remise);
                    j++;
                    calculefacture();
                })

            }
        }
    })
    //********************************************************************************************************
    $('.numspecial').on('change', function () {
        pointdevente_id = $('#pointdevente_id').val();
        model = $('#model').val();
        nature = $('#nature').val()||0;
        page = $('#page').val()||0;
        date=$('.datePickerOnly').val();
        if(page=="fac_des_bl"){
        date=$('#datefac').val();
        }
        //alert(pointdevente_id);
        $.ajax({
            type: "POST",
            data: {
                id: pointdevente_id,
                model: model,
                nature: nature,
                date: date,
            },
            url: wr + "Bonlivraisons/getnums/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            $('#numero').val(data.numspecial);
            $('#numeroconca').val(data.mm);
             //** zeinab **//
            $('#aa').show();
        })
    })
    //********************************************************************************************************
    $('.ajouterligne_livraison1').on('click', function () {

        table = $(this).attr('table');
        index = $(this).attr('index');
        tr = $(this).attr('tr');
        ajouter_ligne_livraison1(table, index, tr);
    })
    //********************************************************************************************************



    $('.supp1').on('click', function () {
        index = $(this).attr('index');
        //$('#quantite' + index).val(0);
        $('#sup' + index).val(1);
        $(this).parent().parent().hide();
        $("#tddesg" + index).parent().hide();
        calculefacture();
    })
    //********************************************************************************************************
    $('.supparticle_achat').on('click', function () {
        index = $(this).attr('index');
        $('#sup' + index).val(1);
        $(this).parent().parent().hide();
    })
    //********************************************************************************************************
   $('.infoclientbb').on('change', function () {
  // 	alert("aaaa");
        $('#divreleve').html("");
        client_id = $('#client_id').val();
        max = $('#index').val() || 0;
        $('#valreste').val("");
        //alert(client_id);
        $.ajax({
            type: "POST",
            data: {
                id: client_id,
            },
            url: wr + "Bonlivraisons/getclients/",
            dataType: "json",
            async: false,
            global: false //}l'envoie'
        }).done(function (data) {

            $('#adresse').val(data.adresse);
            //$('#matriculefiscale').val(data.matriculefiscale);
            //$('#matriculefiscale').next().children().children().html('<div data-value="'+data.matriculefiscale+'" class="item">'+data.matriculefiscale+'</div>');
			alert('1');
            $('#name').val(data.name);
            $('#auto').val(data.autor);
            $('#solde').val(data.solde.toFixed(3));
            $('#valreste').val(data.valreste.toFixed(3));
            if(data.typeclientid==null){
            data.typeclientid=1;
            }
            $('#typeclientid').val(data.typeclientid);
            if(data.typeclientid==1){
            $("#Assujettis").prop("checked", true);
            $("#Exoneres").prop("checked", false);
            }else{
            $("#Exoneres").prop("checked", true);
            $("#Assujettis").prop("checked", false);
            }

			if(data.vente=='detail'){
				$("#optionsRadios11").prop("checked", true);
				$("#optionsRadios12").prop("checked", false);
			}else{
				$("#optionsRadios12").prop("checked", true);
				$("#optionsRadios11").prop("checked", false);
			}

            $('#divreleve').html('<a onClick="flvFPW1(\'' + wr + 'Releves/index/'+client_id+'\' ,\'UPLOAD\', \'width=1800,height=800,scrollbars=yes\', 0, 2, 2 ); return document.MM_returnValue;" href=\'javascript:;\'  ><button class=\'btn btn-xs ls-blue-btn\'> <i class=\'fa fa-usd\'></i> </button></a>');
            //$('#blocclient').show();
            //alert(data.typeclientid);
            $('#matriculefiscale').next().children(":first").html ('<div data-value="'+data.matriculefiscale+'" class="item">'+data.matriculefiscale+'</div><input type="text" autocomplete="off" tabindex="" style="width: 111px; opacity: 0; position: absolute; left: -10000px;">');
            $('#client_id').next().children(":first").html ('<div data-value="'+client_id+'" class="item">'+data.name+'</div><input type="text" autocomplete="off" tabindex="" style="width: 111px; opacity: 0; position: absolute; left: -10000px;">');
            uniform_select('matriculefiscale');
            uniform_select('client_id');
        })
    })
    //************************************************************************
    $('.infoclientmatricalefisacale').on('change', function () {
        $('#divreleve').html("");
        client_id = $('#matriculefiscale').val();
        max = $('#index').val() || 0;
        $('#valreste').val("");
        //alert(client_id);
        $.ajax({
            type: "POST",
            data: {
                id: client_id,
            },
            url: wr + "Bonlivraisons/getclients/",
            dataType: "json",
            async: false,
            global: false //}l'envoie'
        }).done(function (data) {

            //for(j=0;j<=max;j++){
            // $('.cc'+j).remove();
            //}
            //$('#index').val(0);
 
alert('2');
            $('#adresse').val(data.adresse);
            $('#matriculefiscale').val(data.matriculefiscale);
            $('#name').val(data.name);
            $('#auto').val(data.autor);
            $('#solde').val(data.solde.toFixed(3));
            $('#valreste').val(data.valreste.toFixed(3));
            if(data.typeclientid==null){
            data.typeclientid=1; 
            }
            $('#typeclientid').val(data.typeclientid);
            if(data.typeclientid==1){
            $("#Assujettis").prop("checked", true);
            $("#Exoneres").prop("checked", false);
            }else{
            $("#Exoneres").prop("checked", true);
            $("#Assujettis").prop("checked", false);
            }
			if(data.vente=='detail'){alert();
				document.getElementById("optionsRadios11").checked=true;
				///$("#optionsRadios11").prop("checked", true);
				$("#optionsRadios12").prop("checked", false);
			}else{
				$("#optionsRadios12").prop("checked", true);
				$("#optionsRadios11").prop("checked", false);
			}
            $('#divreleve').html('<a onClick="flvFPW1(\'' + wr + 'Releves/index/'+client_id+'\' ,\'UPLOAD\', \'width=1800,height=800,scrollbars=yes\', 0, 2, 2 ); return document.MM_returnValue;" href=\'javascript:;\'  ><button class=\'btn btn-xs ls-blue-btn\'> <i class=\'fa fa-usd\'></i> </button></a>');
            //$('#blocclient').show();
            //alert(data.typeclientid);
            $('#matriculefiscale').next().children(":first").html ('<div data-value="'+data.matriculefiscale+'" class="item">'+data.matriculefiscale+'</div><input type="text" autocomplete="off" tabindex="" style="width: 111px; opacity: 0; position: absolute; left: -10000px;">');
            $('#client_id').next().children(":first").html ('<div data-value="'+client_id+'" class="item">'+data.name+'</div><input type="text" autocomplete="off" tabindex="" style="width: 111px; opacity: 0; position: absolute; left: -10000px;">');
            uniform_select('client_id');
            uniform_select('matriculefiscale');
        })
    })
    //************************************************************************
    $('.recalculer_par_typeclient').on('change', function () {
        if ($('#Assujettis').is(':checked')) {
        $('#typeclientid').val("1");
        }
        if ($('#Exoneres').is(':checked')) {
        $('#typeclientid').val("2");
        }
        calculefacture();
    });
    //************************************************************************
    $('.testdepotvide').on('mousemove', function () {

        index = $(this).attr('index');
        //alert(index);
        depot_id = $('#depot_id' + index).val();
        if (depot_id == '') {
            bootbox.alert('choisir un depot SVP', function () {});
            return false
        }

    })
    //************************************************************************
    $('.testclientvide').on('mousemove', function () {
        // alert();
        client_id = $('#client_id').val();
        if (client_id == '') {
            bootbox.alert('choisir un client SVP', function () {});
            return false
        }

    })
    //************************************************************************
    $('.testpv').on('mouseover', function () {
        numero = $('#numero').val();
        clientname = $('#clientname').val();
        if (numero == '') {
            bootbox.alert('choisir une point de vente SVP', function () {});
            return false
        }
        if (clientname == '') {
            bootbox.alert('choisir un client SVP', function () {});
            return false
        }

    })
//*********************************************************************************************************

    $('.testutilisateur').on('keyup', function () {
        val1 = $('#login').val();

        // alert(val1);
        $.ajax({
            type: "POST",
            data: {
                val1: val1

            },
            url: wr + "Utilisateurs/rechercheutilisateur/",
            dataType: "html",
            global: false //}l'envoie'

        }).done(function (data) {
            //alert(data);

            if (data > 0) {
                //$('#service_id option[value="2"]').attr('selected', 'selected');
                $('#login').val("");
                bootbox.alert("choisi autre login", function () {});
                return false;

            }

        })



    })
    //****************************************************************************************************
    $('.testclientexiste').on('keyup', function () {
        val1 = $('#code').val();

        // alert(val1);
        $.ajax({
            type: "POST",
            data: {
                val1: val1

            },
            url: wr + "Clients/rechercheclient/",
            dataType: "html",
            global: false //}l'envoie'

        }).done(function (data) {
            //  alert(data);

            if (data == 1) {
                //$('#service_id option[value="2"]').attr('selected', 'selected');
                $('#code').val("");
                bootbox.alert("choisi autre code", function () {});
                return false;

            }

        })



    })

//****************************************************************************************************
    $('.testarticleexiste').on('blur', function () {
        val1 = $('#code').val();

        // alert(val1);
        $.ajax({
            type: "POST",
            data: {
                val1: val1

            },
            url: wr + "Articles/recherchearticle/",
            dataType: "html",
            global: false //}l'envoie'

        }).done(function (data) {
            //  alert(data);

            if (data == 1) {
                //$('#service_id option[value="2"]').attr('selected', 'selected');
                $('#code').val("");
                bootbox.alert("Merci de saisi un autre code", function () {});
                return false;

            }

        })



    })

//****************************************************************************************************
    $('.calculeremisenet').on('keyup', function (e) {
        var keyCode = e.keyCode || e.which;
        if ((e.keyCode == 9) || (e.keyCode == 16) || (e.keyCode == 13)) {
            //alert();
            return false;
        } else {
            //alert();
            indexI = $(this).attr('index');
            prixnet = $('#prixnet' + indexI).val();
            prixhtva = $('#prixhtva' + indexI).val();
            tva = $('#tva' + indexI).val();

            r = (1 - (Number(prixnet) / Number(prixhtva))) * 100;
            puttc = prixnet * (1 + Number(tva / 100));
            $('#totalhtans' + indexI).val(prixhtva);
            $('#puttc' + indexI).val(puttc.toFixed(3));
            $('#remise' + indexI).val(r);
            calculefacture();
            $('#remise' + indexI).val(r.toFixed(3));
        }
    })

//****************************************************************************************************
    $('.calculeinverseputtc').on('keyup', function (e) {
        var keyCode = e.keyCode || e.which;
        if ((e.keyCode == 9) || (e.keyCode == 16) || (e.keyCode == 13)) {
            return false;
        } else {
            //alert();
            indexI = $(this).attr('index');
            prixhtva = $('#prixhtva' + indexI).val();
            tva = $('#tva' + indexI).val();
            remise = $('#remise' + indexI).val();

            punht = Number(prixhtva) * (1 - Number(remise / 100));
            puttc = punht * (1 + Number(tva / 100));
            $('#puttc' + indexI).val(puttc.toFixed(3));
            $('#totalhtans' + indexI).val(prixhtva);
            $('#prixnet' + indexI).val(punht.toFixed(3));
            calculefacture();
            calculfactureaminee();
        }
    })

//****************************************************************************************************
    $('.calculeprixvente').on('keyup', function (e) {
        var keyCode = e.keyCode || e.which;
        if ((e.keyCode == 9) || (e.keyCode == 16) || (e.keyCode == 13)) {
            return false;
        } else {
            //alert();
            indexI = $(this).attr('index');
            puttc = $('#puttc' + indexI).val();
            totalhtans = $('#totalhtans' + indexI).val();
            tva = $('#tva' + indexI).val();
            qte = $('#quantite' + indexI).val();
            remise = $('#remise' + indexI).val()||0;

            //alert(totalhtans);


            pvnet = Number(puttc) / (1 + (Number(tva) / 100));
            pvbrut=Number(pvnet)*100/(100-Number(remise));




            $('#prixhtva' + indexI).val(pvbrut);
            $('#remise' + indexI).val(remise);
            $('#totalhtans' + indexI).val(pvbrut);
            $('#prixhtva' + indexI).val(pvbrut.toFixed(3));
            $('#prixnet' + indexI).val(pvnet.toFixed(3));
            calculefacture();
        }
    })

//****************************************************************************************************
    $('.calculeremise').on('keyup', function (e) {
        var keyCode = e.keyCode || e.which;
        if ((e.keyCode == 9) || (e.keyCode == 16)) {
            return false;
        } else {
            //alert();
            indexI = $(this).attr('index');
            totalttc = $('#totalttc' + indexI).val();
            tva = $('#tva' + indexI).val();
            qte = $('#quantite' + indexI).val();
            r_ans = $('#remiseans' + indexI).val();
            // alert(r_ans);
            totalht = Number(totalttc) / (1 + (Number(tva) / 100));


            prixuhtva = $('#prixhtva' + indexI).val();

            totalhtans = prixuhtva * qte;
            deff = totalhtans - totalht;
            remise = (deff / totalhtans) * 100


            if (remise > r_ans) {
                // alert();
                ttc = (prixuhtva * qte) * (1 + (tva / 100));
                $('#totalttc' + indexI).val(ttc);
                $('#remise' + indexI).val(r_ans);
                bootbox.alert("vous avez dépassé le remise possible", function () {});

            } else {
                $('#totalht' + indexI).val(totalht.toFixed(3));
                $('#remise' + indexI).val(remise);
                max = $('#index').val();
                ttremise = 0;
                ttfodec = 0;
                tttva = 0;
                ttht = 0;
                tttc = 0;
                tthtachat = 0;
                timbre = $('#timbre').val() || 0;
                for (i = 0; i <= max; i++) {
                    // alert(i);
                    if ($('#sup' + i).val() != 1) {
                        remisee = $('#remise' + i).val() || 0;
                        qte = $('#quantite' + i).val() || 0;
                        tva = $('#tva' + i).val() || 0;
                        prix = $('#prixhtva' + i).val() || 0;
                        fodec = $('#fodec' + i).val() || 0;
                        prixachat = $('#prixachat' + i).val() || 0;

                        remise = (Number(prix) * Number(remisee)) / 100;
                        //prixu= Number(prix)-Number(remise);
                        tht = $('#totalht' + i).val() || 0;
                        //$('#totalht'+i).val(Number(tht).toFixed(3));
                        // $('#totalhtans'+i).val(Number(tht).toFixed(3));
                        thtachat = (((Number(prixachat)) * Number(qte)));
                        fodecl = (tht * (Number(fodec))) / 100;
                        ttva = ((tht + Number(fodecl)) * Number(tva)) / 100;

                        //$('#Total_HT'+i).val(tht);
                        ttht = (Number(ttht) + Number(tht)).toFixed(3);
                        tthtachat = (Number(tthtachat) + Number(thtachat)).toFixed(3);
                        marge = (Number(ttht) - Number(tthtachat)).toFixed(3);//alert(marge);
                        ttfodec = (Number(ttfodec) + Number(fodecl)).toFixed(3);
                        tttva = (Number(tttva) + Number(ttva)).toFixed(3);
                        ttcl = Number(tht) + Number(ttva);
                        //$('#totalttc'+i).val(Number(ttcl).toFixed(3));
                        ttremise = (Number(ttremise) + (Number(remise) * Number(qte))).toFixed(3);

                    }
                }
                tttc = (Number(ttht) + Number(ttfodec) + Number(tttva) + Number(timbre)).toFixed(3);//alert(tttc);
                $('#fodec').val(ttfodec);
                $('#tva').val(tttva);
                $('#remise').val(ttremise);
                $('#Total_HT').val(ttht);
                $('#Total_TTC').val(tttc);
                $('#marge').val(marge);

            }
        }
    })

//****************************************************************************************************
    $('.calculeprixht').on('keyup', function (e) {
        var keyCode = e.keyCode || e.which;
        if ((e.keyCode == 9) || (e.keyCode == 16)) {
            return false;
        } else {
            //alert();
            indexI = $(this).attr('index');

            qte = $('#quantite' + indexI).val();
            remise = $('#remise' + indexI).val() || 0;
            prixhtva = $('#prixhtva' + indexI).val();



            ptht = (Number(prixhtva) * (1 - (Number(remise) / 100))) * qte;
            puttc = $('#puttc' + indexI).val();
            // alert(ptht);

            $('#totalhtans' + indexI).val(prixhtva);


        }

    })

//********************************************************************************************************
    $('.depot_qte_s').on('change', function () {

        max_index = $('#index').val() || 0;
        for (i = 1; i <= max_index; i++) {
            article_id = $('#article_id' + i).val();
            //alert(article_id);
            depot_id = $('#depot_id').val();
            client_id = $('#client_id').val();
            vente = $('#vente').val() || 0;
            sup = $('#sup').val() || 0;
            if (article_id != "") {
                if (sup != 1) {
                    //alert(article_id);
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: wr + "Bonlivraisons/article/" + article_id + "/" + depot_id + "/" + client_id + "/" + vente,
                        dataType: "json",
                        global: false //}l'envoie'
                    }).done(function (data) {
                        console.log("aaa");
                        //alert();
                        //alert(i);
                        $('#quantitestock' + i).val(data.quantitestock);


                    })
                }
            }
        }
    })
//**********************************************************************************************************
    $('.affichediplication').on('click', function () {


        affichediplication = $(this).attr('value');
        //alert(affichediplication);
        $('.selectdip').show();
        $('.boutselect').show();
        $('#testvalue').val(affichediplication);

    });
//************************************************************************************************************

    $('.modeladd').on('click', function () {



        typedipliquation_id = $('#typedipliquation_id').val();
        testvalue = $('#testvalue').val();
        model_ans = $('#model').val();
        ligne_ans = $('#ligne').val();
        attr = $('#attr').val();
        $(this).attr("href", wr + "Devis/diplique/?td=" + typedipliquation_id + '&id=' + testvalue + '&model_ans=' + model_ans + '&ligne_ans=' + ligne_ans + '&attr=' + attr);

    });
//************************************************************************************************************

    $('.confirmBox').on('click', function (e) {

                    e.preventDefault();

        code = $('#code').val();
        name = $('#name').val();
        typeclientid = $('#typeclient_id').val();
        modeclientid = $('#modeclient_id').val();
    //alert(code);
//    alert(name);
//    alert(typeclientid);
//    alert(modeclientid);
        if ((code == '') || (name == '') || (typeclientid == '') || (modeclientid == '')) { //alert('1');
            bootbox.alert("vérifier les champs suivant : code,raison sociale,type client,mode de paiment", function () {});
        } else {
            matriculefiscale = $('#matriculefiscale').val();
            //alert('2 '+matriculefiscale);
            if (matriculefiscale == '') { //alert('3 '+matriculefiscale);
                if (typeclientid == 1) { //alert('4 '+matriculefiscale);
                    bootbox.confirm("Matricule fiscal vide?", function (result) {
                        if (result) { //alert('5 '+matriculefiscale);
                            var html = 'Ok';
                            $('#defaultF').submit();
                        } else {
                            var html = 'Cancel';
                        }

                    });
                } else { //alert('6 '+matriculefiscale);
                    $('#defaultF').submit();
                }
            } else { //alert('7 '+matriculefiscale);
                $('#defaultF').submit();
            }
        }
    });
//*************************************************************************************************************
    $('.verifqtetrsf').on('keyup', function () {
        //alert();
        indexI = $(this).attr('index');
        qte = $('#quantite' + indexI).val();
        quantitestock = $('#quantitestock' + indexI).val() || 0;
        // alert(qte);
        //alert(quantitestock);
        $.ajax({
            type: "POST",
            url: wr + "Utilisateurs/testqtenegatif/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            //alert(data.qtenegatif);
            if (data.qtenegatif == 0) {
                if (Number(qte) > Number(quantitestock)) {
                    bootbox.alert('vous avez dépasseé la qte en stock  !!', function () {});
                    $('#quantite' + indexI).val('');
                }
            }
        })
    })
//*************************************************************************************************************
    $('.blff').on('click', function () {
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
            $('.testcheckbl').show();
            $('.testcheckfc').show();
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
                alert(page);
                if (page == 'devis') {
                    message = 'Il faut choisir des devis pour le meme Client !!';
                }
                if (page == 'commande') {
                    message = 'Il faut choisir des commandes pour le meme Client !!';
                }
                if (page == 'bl') {
                    message = 'Il faut choisir des bons de livraison pour le meme Client !!';
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
            $('.testcheckbl').hide();
            $('.testcheckfc').hide();
        }
    });
//**************************************************************************************************************
    $('.testqteliv').on('keyup', function () {
        //alert();
        index = $(this).attr('index');

        qte = $('#quantite' + index).val();
        quantiteliv = $('#quantiteliv' + index).val();
        //alert(qte);
        // alert(quantiteliv);
        if (Number(qte) < Number(quantiteliv)) {
            bootbox.alert('vous avez dépasseé la qte   !!', function () {});
            $('#quantiteliv' + index).val('');
        }

    })
    //**************************************************************************************************************

    $('.calculefacturetrasformationbl').on('keyup', function () {//alert();
        calculefacturetrasformationbl();

    })

    //************************************************************************
    $('.testlignevente').on('mousemove', function () {
        // alert();
        index = $('#index').val() || 0;
        //alert(index);
        test = 0;
        for (i = 0; i <= Number(index); i++) {
            depot_id = $('#depot_id' + index).val();
            article_id = $('#article_id' + index).val();
            qte = $('#quantite' + index).val();

            if ((depot_id == '') || (article_id == '') || (qte == '')) {
                test = 1;
            }
        }
        //alert(test);
        if (test == 1) {
            bootbox.alert('vérifier les champs des lignes existants', function () {});
            return false
        }
    })
    //************************************************************************
    $('.calculeprix_net_ttc').on('keyup', function (e) {
        //alert(e.keyCode);
        if ((e.keyCode == 9) || (e.keyCode == 16) || (e.keyCode == 13)) {
            return false;
        } else {
            indexI = $(this).attr('index');
            totalhtans = $('#totalhtans' + indexI).val();
            tva = $('#tva' + indexI).val();
            remise = $('#remise' + indexI).val();
            //alert(totalhtans);


            pnet = Number(totalhtans) * (1 - (Number(remise) / 100));
            pttc = Number(pnet) * (1 + (Number(tva) / 100));
            $('#prixnet' + indexI).val(pnet.toFixed(3));
            $('#puttc' + indexI).val(pttc.toFixed(3));
        }
    })

//****************************************************************************************************
    $('.getdevise').on('change', function () {

        fournisseurid = $('#fournisseur_id').val();

        //alert(serviceid);
        $.ajax({
            type: "POST",
            data: {
                fournisseurid: fournisseurid

            },
            url: wr + "Importations/getdevises/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            $('#labeldevise').show();
            $('#order').show();
            $('#divdevise').html('');
            $('#divdevise').html(data.select);
            $('#coeff').val(data.ancien_coeff);
            uniform_select('devise_id');
        })

    })

    //***************************************************************************************************************

    $('.calculecoefficient').on('keyup', function () {
        coe = 0;
        montantachat = $('#montantachat').val() || 0;
        tauxderechenge = $('#tauxderechenge').val() || 0;
        if (Number(tauxderechenge) == 0) {
            tauxderechenge = 1;
        }
        avis = $('#avis').val() || 0;
        transitaire = $('#transitaire').val() || 0;
        ddttva = $('#ddttva').val() || 0;
        assurence = $('#assurence').val() || 0;
        divers = $('#divers').val() || 0;
        fraisfinancie = $('#fraisfinancie').val() || 0;
        magasinage = $('#magasinage').val() || 0;
        //if(tauxderechenge>0){
        pa = (Number(montantachat) * Number(tauxderechenge));
        $('#prixachat').val(pa.toFixed(3));
        tot = (pa + Number(avis) + Number(transitaire) + Number(ddttva) + Number(assurence) + Number(divers) + Number(fraisfinancie) + Number(magasinage)) || 0;
        $('#totale').val(tot.toFixed(3));
        prixachat = $('#prixachat').val() || 0;
        totale = $('#totale').val() || 0;
        coe = Number(tot) / Number(pa);
        $('#coefficien').val(Number(coe));
        $('#c').val(Number(coe).toFixed(3));
        //}

    })

//****************************************************************************************************
    $('.validerdevis').on('click', function (e) {
        e.preventDefault();
        test = $('#test').val();
        //alert(test);
        if (test == 1) {
            bootbox.confirm("vous voulez validé cett suggestion de commade?", function (result) {
                if (result) {
                    var html = 'Ok';
                    $('#valide').val(1);
                    $('#defaultForm').submit();
                } else {
                    var html = 'Cancel';
                    //$('#defaultForm').submit();
                }

            });
        } else {
            $('#defaultForm').submit();
        }
    });
//*************************************************************************************************************
     $('.testnumero').on('mouseover', function () {
        numero = $('#numero').val();
        depot_id = $('#depot_id').val();

        fournisseur = $('#fournisseur').val();
        date = $('#date').val();
        if (numero == '') {
            bootbox.alert('saisi un numéro SVP', function () {});
            return false
        }
        if (depot_id == '') {
            bootbox.alert('Choisi un Dèpot SVP', function () {});
            return false
        }
        //*********** zeinab
        if (fournisseur == '') {
            bootbox.alert('Choisi un fournisseur SVP', function () {});
            return false
        }
        if (date == '__/__/____') {
            champ = $('#date').attr('champ');
            bootbox.alert('le champ Date '+champ+' obligtoire', function () {});
            return false
        }

    })
    //*****************************************************
    $('.calculefactureservice').on('keyup', function () {
        index=$('#index').val()||0;
        totttc=$('#timbre').val()||0;
        totth=0;tottva=0;
        for (i = 0; i <= index; i++) {
        mtva=0;mttc=0;
        mth=$('#mth'+i).val()||0;
        tauxtva=$('#tauxtva'+i).val()||0;
        //alert(" m ht "+mth);alert("taux tva "+tauxtva);
        mtva=(Number(mth)*Number(tauxtva))/100;
        mttc=Number(mth)+(Number(mtva));
        mtva=mtva.toFixed(3);
        mttc=mttc.toFixed(3);
        //alert("m tva "+mtva);
        //alert("m ttc "+mttc);
        $('#mtva'+i).val(mtva);
        $('#mttc'+i).val(mttc);
        totth=Number(totth)+Number(mth);
        tottva=Number(tottva)+Number(mtva);
        totttc=Number(totttc)+Number(mttc);
        }
        totth=totth.toFixed(3);
        tottva=tottva.toFixed(3);
        totttc=totttc.toFixed(3);
        $('#totth').val(totth);
        $('#tottva').val(tottva);
        $('#totttc').val(totttc);
		 $('#Total_TTC').val(totttc);


})
//*********************************************************************************************************
    $('.get_tr_coe').on('change', function () {
        // alert();
        importationid = $('#importation_id').val();

        $.ajax({
            type: "POST",
            data: {
                importationid: importationid

            },
            url: wr + "Importations/getcoes/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {

            console.log(data);
            $('#tr').val(data.tr);
            c = Number(data.coe).toFixed(2);
            $('#coe').val(c);
            $('#tr').attr('readonly', true);
            $('#coe').attr('readonly', true);
            tot = Number(data.tr) * Number(data.coe);
            $('#coef').val(tot);
            calculesuggestion()
        })
    })

//*********************************************************************************************************
    $('.tabledemoins').on('keyup', function () {
        index = $(this).attr('index');
        nbrmoins = $('#nbrmoins' + index).val();
        //alert(index);
        //alert(nbrmoins);
        //alert(serviceid);
        $.ajax({
            type: "POST",
            data: {
                nbrmoins: nbrmoins,
                index: index
            },
            url: wr + "Reglements/recap/",
            dataType: "html",
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            $('#pop' + index).html('');
            $('#pop' + index).html(data);
            for (j = 1; j <= nbrmoins; j++) {
                $('#' + index + 'echancecredit' + j).datetimepicker({
                    timepicker: false,
                    datepicker: true,
                    mask: '39/19/9999',
                    format: 'd/m/Y'});
            }
        })

    })

//***************************************************************************************************************
    $('.testtabledetraite').on('mouseover', function () {
        index = $('#index').val();
        msg = "Vérifier les lignes Credit : ";
        test = 0;
        comp = 0;
        for (i = 0; i <= index; i++) {
            nbrmoins = $('#nbrtr' + i).val();
            //alert('index'+i);
            for (j = 1; j <= nbrmoins; j++) {
                if (($('#' + i + 'num_piececredit' + j).val() == '') || ($('#' + i + 'echancecredit' + j).val() == '') || ($('#' + i + 'montantcredit' + j).val() == '')) {

                    msg = msg + " " + j;

                    //alert(msg);
                    test = 1;
                    comp++;
                }
            }



            //alert(test);

        }
        if (test == 1) {
            bootbox.alert(msg, function () {});
            //return false
        }
        nbrtr = $('#nbrtr' + index).val();
        montant = $('#montant').val() || 0;
        //alert(montant);
        testt = 0;
        tt = 0;
        for (j = 1; j <= nbrtr; j++) {
            th = $('#' + index + 'montantcredit' + j).val() || 0;
            tt = (Number(tt) + Number(th)).toFixed(3);
        }
        if (Number(tt) != Number(montant)) {
            //alert("fer8a");
            testt = 1;
        }
        //alert(testt);
        if (testt == 1) {
            bootbox.alert('Vérifier le montant', function () {});
            return false
        }
    })
//*********************************************************************************************************
    $('.edittabledemoins').on('blur', function () {
        index = $(this).attr('index');
        indexkbira = index;
        nbrmoins = $('#nbrmoins' + index).val();
        nbrtr = $('#nbrtr' + index).val();
        nbrtr_ans = $('#nbrtr_ans' + index).val();
        //alert('nbr mois'+nbrmoins);
        //alert('nbr mois ans'+nbrtr);
        if (Number(nbrmoins) >= Number(nbrtr)) {
//        nbrtr_ans=Number(nbrtr_ans)+1;
//        for(j=nbrtr_ans;j<=nbrtr;j++){
//        $('#tr'+j).remove();
//        }
            p = Number(nbrmoins) - Number(nbrtr);
            p = Number(p);
            table = "tablet";
            index = "nbrtr" + index;
            tr = "tr";
            edittabledemoins(table, index, tr, p, nbrtr, nbrmoins, indexkbira);
        } else {
            k = Number(nbrmoins) + 1;
            for (j = k; j <= nbrtr; j++) {
                $('#tr' + j).remove();
            }
            calculetotalecredit(indexkbira);
            $('#nbrtr' + index).val(nbrmoins);
        }
    })
//*********************************************************************************************************
    $('.testmontant2').on('mouseover', function () {
        v = $('#index').val();
        //alert('index'+v);
        ttpayer = $('#ttpayer').val();
        test = 0;
        tt = 0;
        for (j = 0; j <= v; j++) {
            if ($('#paiement_id' + j).val() == 5) {

                //alert('d5Al'+th);
                // tt=(Number(tt)+Number(th));
                //alert('d5Al'+tt);
                test = 1;
            }
        }
        if (test == 1) {
            for (j = 0; j <= v; j++) {
                th = $('#montant' + j).val() || 0;
                tt = (Number(tt) + Number(th));
            }
            //alert(tt);
            //alert(ttpayer);
            if (Number(tt) != Number(ttpayer)) {
                bootbox.alert('Vérifier le montant à payer', function () {});
                return false
            }
        }
    })
//*********************************************************************************************************
    $('.calculetotalecredit').on('keyup', function () {
        nbrtr = $('#nbrtr').val();
        montant = $('#montant').val() || 0;
        test = 0;
        alert(montant);
        tt = 0;
        for (j = 1; j <= nbrtr; j++) {
            th = $('#montantcredit' + j).val() || 0;
            tt = (Number(tt) + Number(th)).toFixed(3);
            if (tt > montant) {
                $('#montantcredit' + j).val("");
                test = 1;
            }
        }
        if (test == 1) {
            bootbox.alert('Vérifier le montant', function () {});
            return false
        } else {
            $('#total').val(tt);
        }
        //agio = Number(Number(tt) - Number(montant));
        //$('#agio').val(agio);

    })
//*********************************************************************************************************
    $('.getcoutderevient').on('keyup', function () {
        prixachatdevise = $('#prixachatdevise').val() || 0;
        tauxchange = $('#tauxchange').val() || 0;
        coefficient = $('#coefficient').val() || 0;

        coutrevient = Number(prixachatdevise) * Number(tauxchange) * Number(coefficient);

        $('#coutrevient').val(coutrevient.toFixed(3));
    })
//*********************************************************************************************************
    $('.testqtetransfert').on('mousemove', function () {
        index = $('#index').val() || 0;
        depotarrive = $('#depotarrive').val() || 0;
        pvdepart = $('#pvdepart').val() || 0;
        pvarrive = $('#pvarrive').val() || 0;
        test = 0;
        testdepot = 0;
        depot_id = $('#depot_id').val() || 0;
        for (i = 1; i <= Number(index); i++) {
            article_id = $('#article_id' + i).val() || 0;
            qte = $('#quantite' + i).val() || 0;
            sup = $('#sup' + i).val() || 0;
            if ((sup == 0) && (article_id > 0)) {
//                alert("sup "+sup);
//                alert("ar "+article_id);
//                alert(i);
                if ((depot_id == 0) || (qte == 0)) {
                    test = 1;
                }
                if (depot_id == depotarrive) {
                    testdepot = 1;
                }
            }
        }
        if ($('#entre').prop('checked')) {
            entre = 1;
        }
        if ($('#meme').prop('checked')) {
            entre = 0;
        }
        //alert(entre);
        if (entre == 1) {
            if (pvdepart == 0 || pvarrive == 0) {
                bootbox.alert('vérifier les Points de Vente', function () {});
                return false
            }

        }
        if (depotarrive == 0) {
            bootbox.alert('vérifier le champ de depot d\'arrive', function () {});
            return false
        }
        if (test == 1) {
            bootbox.alert('vérifier les champs des lignes existants', function () {});
            return false
        }
        if (testdepot == 1) {
            bootbox.alert('impossible de mettre le depot de sorti et depot d\'arrivèe identiques', function () {});
            return false
        }
        if (test_nb_ligne(index) === false) {
            bootbox.alert("Veuillez remplir au moins une ligne de transfert", function () {
            });
            return false
        }
    })
    //************************************************************************
    $('.libre').on('click', function () {
        index = $('#index').val() || 0;
        max = $('#max').val() || 0;
        devisefournisseur = $('#devisefournisseur').val() || 0;
        $('#ttpayer').val('');
        $('#netpayer').val('');
        $('#Montant').val('');
        for (i = 0; i <= Number(index); i++) {
            $('#montant' + i).val('');
        }
        $('#importation_id').val('');
        if ($(this).prop('checked')) {
            val = $(this).val();
            if (val == 0) {
                $('#thead').show();
                for (i = 0; i <= Number(max); i++) {
                    $('#trfacture' + i).show();
                }
                $('#totalefacture').show();
                $('#montantpayer').show();
                $('#netapayer').show();
                $('#btnenr').prop("disabled", true);
                $('#divimportation').hide();
            } else {
                $('#btnenr').prop("disabled", false);
                $('#thead').hide();
                for (i = 0; i <= Number(max); i++) {
                    $('#trfacture' + i).hide();
                    $('#importation_id' + i).prop('checked', false);
                    $('#facture_id' + i).prop('checked', false);
                }
                $('#totalefacture').hide();
                $('#montantpayer').show();
                if (devisefournisseur != 1) {
                    $('#divimportation').show();
                }
                $('#netapayer').hide();

            }
        }
    });
//*************************************************************************************************************
    $('.getinfoimportation').on('change', function () {
        // alert();
        importationid = $('#importation_id').val();

        $.ajax({
            type: "POST",
            data: {
                importationid: importationid

            },
            url: wr + "Importations/getcoes/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {

            console.log(data);
            //$('#montant0').val(Number(data.prixachat).toFixed(2));
            //$('#Montant').val(Number(data.prixachat).toFixed(2));
            //$('#montantdevise0').val(Number(data.prixachat).toFixed(2));
            //$('#prixachattounssi').val(Number(data.prixachat_tounssi).toFixed(3));
            //$('#montant0').attr('readonly', true);
            //calculetotalecredit();
        })
    })

//*********************************************************************************************************
    $('.libre').on('click', function () {
        if ($(this).prop('checked')) {
            val = $(this).val();
            if (val == 1) {
                $("#inputlibre").val("1");

            } else {
                $("#inputlibre").val("0");

            }
        }
    });
//*********************************************************************************************************
    $('.testlignedevente').on('mousemove', function () {
        // alert();
        indexx = $('#index').val() || 0;
        //depotarrive = $('#depotarrive').val() || 0;
//        alert(indexx);
        test = 0;
        for (index = 1; index <= Number(indexx); index++) {
            if ($('#sup' + index).val() != 1) {
                if ($('#article_id' + index).val() != "") {
                    depot_id = $('#depot_id').val();
                    article_id = $('#article_id' + index).val();
                    qte = $('#quantite' + index).val() || 0;
                    prixhtva = $('#prixhtva' + index).val();
                    prixnet = $('#prixnet' + index).val();
                    puttc = $('#puttc' + index).val();
                    if ((depot_id == '') || (article_id == '') || (qte == 0) || (prixhtva == '') || (prixnet == '') || (puttc == '')) {
                        test = 1;
                    }
                }
            }
        }

        if (test == 1) {
            bootbox.alert('vérifier les champs des lignes existants', function () {});
            return false
        }
    })
    //************************************************************************
    $('.testhistoriquearticle').on('mousemove', function () {
        // alert();
        client_id = $('#client_id').val() || 0;
        personnel_id = $('#personnel_id').val() || 0;
        article_id = $('#article_id0').val() || 0;
        fournisseur_id = $('#fournisseur_id').val() || 0;
        societe_id = $('#societe_id').val() || 0;
        page = $('#page').val() || 0;
        if (page == 'soldeclient') {
            if (societe_id == 0) {
                bootbox.alert('choisir une societé SVP', function () {});
                return false
            }
        }
        if (page == 'historiquearticle') {
            if ((client_id == 0) && (article_id == 0) && (fournisseur_id == 0)) {
                bootbox.alert('choisir un client ,article ou un fournisseur SVP', function () {});
                return false
            }
        }
        if (page == 'soldecommande') {
            if ((client_id == 0) && (article_id == 0)) {
                bootbox.alert('choisir un client ou un article SVP', function () {});
                return false
            }
        }
    })
    //************************************************************************
    $('.test_action_personnel').on('change', function () {
        // alert();
        indexI = $(this).attr('index');
        personnel_id = $('#personnel_id' + indexI).val() || 0;
        typeworkflow_id = $('#typeworkflow_id' + indexI).val() || 0;
        index = $('#index').val() || 0;
        test = 0;
        ligne = 0;
        for (i = 0; i <= Number(index); i++) {
            if ((i != indexI)) {
                if ($('#sup' + i).val() != 1) {
                    if (($('#personnel_id' + i).val() == personnel_id) && ($('#typeworkflow_id' + i).val() == typeworkflow_id)) {
                        test = 1;
                        ligne = i;
                    }
                }
            }
        }
        if (test == 1) {
            //alert(ligne);
            $('#sup' + indexI).val("1");
            $(this).parent().parent().parent().parent().hide();
            table = 'addtable';
            index = 'index';
            tr = 'tr';
            ajouter_ligne_transfert(table, index, tr);
            bootbox.alert('Impossible de affecté un personnel à la mème action autre fois', function () {});
            return false
        }
    })
    //************************************************************************
    $('.test_champ_action_personnel').on('mousemove', function () {
        // alert();
        test = 0;
        testobligatoire = 0;
        if (($('#document_id').val() == 0)) {
            test = 1;
        }
        index = $('#index').val() || 0;
        for (i = 0; i <= Number(index); i++) {
            if ($('#sup' + i).val() != 1) {
                if (($('#personnel_id' + i).val() == 0) || ($('#typeworkflow_id' + i).val() == 0)) {
                    test = 1;
                }
                if (($('#typeworkflow_id' + i).val() == 2) && ($('#obligatoire' + i).val() == 1)) {
                    testobligatoire = 1;
                }
            }
        }
        if (test == 1) {
            bootbox.alert('vérifier les champs des personnels des actions', function () {});
            return false
        }
        if (testobligatoire == 0) {
            bootbox.alert('donner l\'obligation à un personnel au moin ', function () {});
            return false
        }
    })
    //************************************************************************
    $('.obligation').on('click', function () {
        indexI = $(this).attr('index');
        //alert(indexI);
        if ($(this).prop('checked')) {
            $("#obligatoire" + indexI).val("1");
        } else {
            $("#obligatoire" + indexI).val("0");
        }
        //obligatoire=$('#obligatoire'+indexI).val()||0;
        //alert(obligatoire);
    });
//*********************************************************************************************************
    $('.testcocher').on('click', function () {
        test = 0;
        ligne = $('#ligne').val() || 0;
        for (i = 0; i <= Number(ligne); i++) {
            if ($('#check' + i).is(':checked')) {
                test = 1;
            }
        }
        if (test == 1) {
            $('#divcommande').show();
        } else {
            $('#divcommande').hide();
        }
    })
    //************************************************************************
    $('.commander').on('click', function () {

        if ($('#interne').is(':checked')) {
            type = "vous voulez passer cette commande sur un fournisseur interne";
        }
        if ($('#externe').is(':checked')) {
            type = "vous voulez passer cette commande sur un fournisseur externe";
        }
        //alert(type);
        bootbox.confirm(type, function (result) {
            if (result) {
                var html = 'Ok';
                //alert();
                ch = "";
                ligne = $('#ligne').val() || 0;
                for (i = 0; i <= Number(ligne); i++) {
                    if ($('#check' + i).is(':checked')) {
                        ch = ch + $('#check' + i).val() + ",";
                    }
                }
                //alert(ch);
                if ($('#interne').is(':checked')) {
                    window.location.href = wr + "Commandes/addfrometatstock/" + ch;
                }
                if ($('#externe').is(':checked')) {
                    window.location.href = wr + "Deviprospects/addindirect/" + ch;
                }
            } else {
                var html = 'Cancel';
            }
        })
    })
    //************************************************************************
    $('.testfamille').on('mouseover', function () {
        familleclient_id = $('#familleclient_id').val() || 0;
        if (familleclient_id == 0) {

            bootbox.alert('vérifier les champs existants', function () {});
            return false

        }
    })
//*********************************************************************************************************
    $('.testligneinventaire').on('mouseover', function () {
        depot_id = $('#depot_id').val() || 0;
        test = 0;
        if (depot_id == 0) {

            bootbox.alert('vérifier le champ depot', function () {});
            return false

        }
        index = $('#index').val() || 0;
        for (i = 0; i <= Number(index); i++) {
            if ($('#sup' + i).val() != 1) {
                if (($('#article_id' + i).val() == '') || ($('#quantite' + i).val() == '') || ($('#coutderevien' + i).val() == '')) {
//                    bootbox.alert('vérifier les champs existants', function () {});
//                    return false;
                }
            }
        }

    })
//*********************************************************************************************************
    $('.testnumerocarnetcheque').on('mouseover', function () {
        numero = $('#numero').val();  //alert(numero);
        controller = $('#controller').val(); // alert(controller);
        $.ajax({
            type: "POST",
            data: {
                numero: numero,
                controller: controller
            },
            url: wr + "Bonreceptions/testnumero/",
            dataType: "html",
            global: false //}l'envoie'
        }).done(function (data) {
            if (data == 1) {
                bootbox.alert('le numéro existe dans la base de donnée  !!', function () {});
            }
        })
    })
//************************************************************************
    $('.testcaisse').on('mouseover', function () {
        moi_id = $('#moi_id').val() || 0;
        if (moi_id == 0) {
            bootbox.alert('le mois obligtoire  !!', function () {});
        }
    })
//************************************************************************
    $('.testdevisefrs').on('mouseover', function () {
        devise_id = $('#devise_id').val() || 0;
        if (devise_id == 0) {
            bootbox.alert('le champ devise obligtoire  !!', function () {});
        }
    })
//************************************************************************
    $('.getarticlefamille').on('change', function () {

        familleid = $('#famille_id').val();

        //alert(serviceid);
        $.ajax({
            type: "POST",
            data: {
                familleid: familleid

            },
            url: wr + "Etatcaarticles/getarticlefamilles/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data.select);
            //$('#article_id').parent().parent().html('');
            $('#article_id').parent().parent().html(data.select);
            uniform_select('article_id');
        })

    })

    //***************************************************************************************************************
    $('.testetatcaarticle').on('mouseover', function () {
        article_id = $('#article_id').val() || 0;
        exercice1 = $('#exercice1').val() || 0;
        exercice2 = $('#exercice2').val() || 0;
        famille_id = $('#famille_id').val() || 0;
        client_id = $('#client_id').val() || 0;
        personnel_id = $('#personnel_id').val() || 0;
        if (((famille_id != 0) && (client_id != 0) && (personnel_id != 0)) || ((client_id != 0) && (personnel_id != 0)) || ((famille_id != 0) && (client_id != 0)) || ((famille_id != 0) && (personnel_id != 0))) {
            bootbox.alert('il suffit de choisir un seul choix famille ,client ou personnel   !!', function () {});
        }
        if (exercice1 == 0) {
            bootbox.alert('le champ année début obligtoire  !!', function () {});
        }
        if (exercice2 == 0) {
            bootbox.alert('le champ année fin obligtoire  !!', function () {});
        }
        if (article_id == 0) {
            bootbox.alert('le champ article obligtoire  !!', function () {});
        }
    })
//************************************************************************
    $('.testetatcapaersonnel').on('mouseover', function () {
        personnel_id = $('#personnel_id').val() || 0;

        if (personnel_id == 0) {
            bootbox.alert('le champ personnel obligtoire  !!', function () {});
        }
    })
//************************************************************************
    $('.aff_divparametrage').on('click', function () {
        //alert();
        $('#divparametrage').show();
        $('#divstock').hide();
        $('#divachat').hide();
        $('#divvente').hide();
        $('#divfinance').hide();
        $('#divstat').hide();
        //$('#divparametrage').css('background', 'red');
    })
//************************************************************************
    $('.aff_divstock').on('click', function () {
        //alert();
        $('#divparametrage').hide();
        $('#divstock').show();
        $('#divachat').hide();
        $('#divvente').hide();
        $('#divfinance').hide();
        $('#divstat').hide();
        //$('#divstock').css('background', 'gray');
    })
//************************************************************************
    $('.aff_divachat').on('click', function () {
        //alert();
        $('#divparametrage').hide();
        $('#divstock').hide();
        $('#divachat').show();
        $('#divvente').hide();
        $('#divfinance').hide();
        $('#divstat').hide();
        // $('#divachat').css('background', '#b1822b');
    })
//************************************************************************
    $('.aff_divvente').on('click', function () {
        //alert();
        $('#divparametrage').hide();
        $('#divstock').hide();
        $('#divachat').hide();
        $('#divvente').show();
        $('#divfinance').hide();
        $('#divstat').hide();
        // $('#divvente').css('background', 'green');
    })
//************************************************************************
    $('.aff_divfinance').on('click', function () {
        //alert();
        $('#divparametrage').hide();
        $('#divstock').hide();
        $('#divachat').hide();
        $('#divvente').hide();
        $('#divfinance').show();
        $('#divstat').hide();
        // $('#divfinance').css('background', '#077aa7');
    })
//************************************************************************
    $('.aff_divstat').on('click', function () {
        //alert();
        $('#divparametrage').hide();
        $('#divstock').hide();
        $('#divachat').hide();
        $('#divvente').hide();
        $('#divfinance').hide();
        $('#divstat').show();
        // $('#divstat').css('background', '#3F51B5');
    })
//************************************************************************
    $('.cl_btn_enregistrer').on('click', function () {
        //alert();
        $('#btn_enregistrer').val("1");
        $('#btn_recherche').val("0");
        paiement_id = $('#paiement_id').val() || 0;
        situation = $('#situation').val() || 0;
        if (paiement_id == 3) {
            if (situation == 0) {
                bootbox.alert('le champ situation obligtoire  !!', function () {});
            }
        }
    })
//************************************************************************
    $('.cl_btn_recherche').on('click', function () {
        //alert();
        $('#btn_enregistrer').val("0");
        $('#btn_recherche').val("1");

    })
//************************************************************************
    $('.cl_mousse_enregistrer').on('mouseover', function () {
        index = $('#index').val() || 0;
        paiement_id = $('#paiement_id').val() || 0;
        situation = $('#situation').val() || 0;
        if (paiement_id == 3) {
            if (situation == 0) {
                bootbox.alert('le champ situation obligtoire  !!', function () {});
            }
        }
        test = 0;
        for (i = 0; i <= Number(index); i++) {
            if ($('#chekbox' + i).is(':checked')) {
                test = 1;
            }
        }
        if (test == 0) {
            bootbox.alert('choisir une piece au moin  !!', function () {});
        }
    })
//************************************************************************
    $('.calculmontantbordereaux').on('click', function () {
        index = $('#index').val() || 0;
        // alert(index);
        somme = 0;
        for (i = 0; i <= Number(index); i++) {
            //alert();
            if ($('#chekbox' + i).prop('checked')) {
                montant = $('#montant' + i).val();
                somme = Number(montant) + Number(somme);
                total = $('#total').val(somme.toFixed(3));
            }
        }
        garantie = $('#garantie').val() || 0;
        agio = $('#agio').val() || 0;
        totalfactoring = Number(somme) - Number(garantie) - Number(agio);
        $('#totalfactoring').val(totalfactoring.toFixed(3));
    })
//************************************************************************
    $('.testimportation').on('mouseover', function () {
        fournisseur_id = $('#fournisseur_id').val() || 0;
        devise_id = $('#devise_id').val() || 0;
        if (fournisseur_id == 0) {
            bootbox.alert('le champ Fournisseur obligtoire  !!', function () {});
        }
        if (devise_id == 0) {
            bootbox.alert('le champ devise obligtoire  !!', function () {});
        }
    })
//************************************************************************
    $('.testchoisicompte').on('mouseover', function () {
        compte_id = $('#compte_id').val() || 0;

        if (compte_id == 0) {
            bootbox.alert('le champ compte obligtoire  !!', function () {});
        }
    })
//************************************************************************
    $('.calculer_m_apayer').on('keyup', function () {
        //alert();
        ind = $(this).attr('index');
        tc = $('#tc' + ind).val() || 0;
        montantachat = $('#montantachat' + ind).val() || 0;
        Montant_Regler = $('#Montant_Regler' + ind).val() || 0;
        //alert(tc);
        //alert(montantachat);
        //alert(Montant_Regler);
        reste = Number(tc) * (Number(montantachat) - Number(Montant_Regler));
        //alert(mpayer);
        //reste=Number(mpayer)-Number(Montant_Regler);
        $('#ttpayer').val(reste.toFixed(3));
        //alert(reste);
        $('#spanreste' + ind).html(reste.toFixed(3));
    })
    //************************************************************************
    $('.affichesituation_virment_lc').on('change', function () {
        index = $(this).attr('index');
        val = $(this).val();
        $('#nbrjours' + index).val("");
        $('#nbrmoins' + index).val("");
        $('#montantp' + index).val($('#montant' + index).val());
        $('#echancep' + index).val($('#echance' + index).val());
        $('#num_piecep' + index).val($('#num_piece' + index).val());
        //$('#compte_idp'+index).val($('#compte_id'+index).val());
        compte = $('#compte_id' + index).next().children().children().html();
        //alert($('#compte_id'+index).val());
        //$('#compte_idp'+index).next().children().children().html(compte);
        $('#compte_idp' + index).val(compte);
        if (Number(val) == 1) {
            $('#trmontant' + index).hide();
            $('#pop' + index).html('');
            $('#trmontant' + index).show();
            $('#tragio' + index).hide();
            $('#trnbrjours' + index).hide();
            $('#trnbrmoin' + index).hide();
            $('#trechance' + index).hide();
            $('#trbanque' + index).hide();
            $('#trnum' + index).hide();
        }
        if (Number(val) == 3) {
            $('#pop' + index).html('');
            $('#trmontant' + index).show();
            $('#trnbrjours' + index).hide();
            $('#tragio' + index).hide();
            $('#trnbrmoin' + index).hide();
            $('#trechance' + index).show();
            $('#trbanque' + index).show();
            $('#trnum' + index).show();
        }
        if (Number(val) == 5) {
            $('#pop' + index).html('');
            $('#trmontant' + index).show();
            $('#trnbrjours' + index).hide();
            $('#tragio' + index).hide();
            $('#trnbrmoin' + index).hide();
            $('#trechance' + index).show();
            $('#trbanque' + index).show();
            $('#trnum' + index).show();
        }
        if (Number(val) == 7) {
            $('#pop' + index).html('');
            $('#trmontant' + index).show();
            $('#trnbrjours' + index).show();
            $('#tragio' + index).show();
            $('#trnbrmoin' + index).hide();
            $('#trechance' + index).show();
            $('#trbanque' + index).show();
            $('#trnum' + index).show();
        }
        if (Number(val) == 8) {
            $('#pop' + index).html('');
            $('#trmontant' + index).show();
            $('#trnbrjours' + index).show();
            $('#tragio' + index).show();
            $('#trnbrmoin' + index).hide();
            $('#trechance' + index).show();
            $('#trbanque' + index).show();
            $('#trnum' + index).show();
        }
        if (Number(val) == 9) {
            $('#trmontant' + index).show();
            $('#trnbrjours' + index).hide();
            $('#trnbrmoin' + index).show();
            $('#tragio' + index).hide();
            $('#trechance' + index).hide();
            $('#trbanque' + index).hide();
            $('#trnum' + index).hide();
        }

    })

//*********************************************************************************************************
    $('input').keypress(function (e) {
        if (e.keyCode == 13) { // KeyCode de la touche entrée
            e.preventDefault();
            //$('#defaultForm').check();
            //alert('Hey ! Tu as appuyé sur la touche entrée !!');
        }
    });
//*********************************************************************************************************
    $('.afficherbouttonsituation').on('click', function () {
        test = 0;
        index = $('#index').val();
        listpiece = "";
        totale = 0;
        //alert(index);
        for (i = 0; i <= Number(index); i++) {
            if ($('#chec_piece_id' + i).is(':checked')) {
                //alert("d5al");
                test = 1;
                //alert();
                //alert($('#chec_piece_id' + i).attr('montant'));
                totale = totale + Number($('#chec_piece_id' + i).attr('montant'));
                listpiece = listpiece + $('#chec_piece_id' + i).val() + ",";

            }
        }
        //alert(test);
        if (test == 1) {
            //alert();
            $('#changer').show();
            $('#changer').val(listpiece);
            //alert(totale);
            $('#totalpiececlient').html("Total : " + separateurMillier((totale.toFixed(3))));
        } else {
            $('#changer').hide();
            ('#totalpiececlient').html("");
        }
        //alert( $('#changer').val());

    })

    //*************************************************************************************************************
//    $('.testlignereglement').on('mousemove', function () {
//        // alert();
//        index = $('#index').val() || 0;
//        typefrs = $('#typefrs').val();
//        test = 0;
//        testt = 0;
//        for (i = 0; i <= Number(index); i++) {
//            paiement_id = $('#paiement_id' + i).val();
//            montant = $('#montant' + i).val();
//            etatpiecereglement_id = $('#etatpiecereglement_id' + i).val() || 0;
//            //alert(etatpiecereglement_id);
//            if ($('#sup' + index).val() != 1) {
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
//
//                    }
//                }
//            }
//        }
//
//        if (test == 1) {
//            bootbox.alert('vérifier les champs des lignes existants', function () {});
//        }
//
//        //alert(index);
//        //alert(testt);
////        if (testt == 1) {
////            //alert();
////            bootbox.alert('Choisi un mode de paiement', function () {});
////        }
//
//    })
//*************************************************************************************************************
    $('.testaffectationfacture_montant').on('mousemove', function () {
        v = $('#index').val() || 0;//alert(v)//console.log(v);
        typefrs = $('#typefrs').val() || 0;
        ttpayer = $('#ttpayer').val() || 0;

        val = $("#inputlibre").val() || 0;
        reg_libre = $("#page").val() || 0;
        //alert("libre"+val);

        tt = 0;
        i = 0;
        for (i = 0; i <= v; i++) {
            th = $('#montant' + i).val() || 0;
            //alert(th);
            tt = (Number(tt) + Number(th)).toFixed(3);
        }
        if ((Number(tt) > Number(ttpayer)) && (reg_libre != "reg_libre")) {
            if (val == 0) {
                bootbox.alert('vous dépassez le montant à payer', function () {});
                return false
            }
        }
    })
//*************************************************************************************************************
    $('.test-edit-numerofacture').on('mouseover', function () {
        numero = $('#numero').val() || 0;
        id_fac = $('#id_fac').val() || 0;
        model = $('#model').val() || 0;

        $.ajax({
            type: "POST",
            data: {
                numero: numero,
                id_fac: id_fac,
                model: model

            },
            url: wr + "Factureclients/testeditnumerofactures/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            if (data.test == 1) {
                bootbox.alert('le numéro exist', function () {});
                return false
            }
        })

    })
//*************************************************************************************************************
    $('.ajouter_ligne_situation_reglement').on('click', function () {
        index = $(this).attr('index');
        table = $(this).attr('table');
        indexc = $(this).attr('indexc');
        ajouter_ligne_situation_reglement(table, index, indexc);
    })
//*************************************************************************************************************
    $('.supsituationreg').on('click', function () {
        ligne = $(this).attr('ligne');
        index = $(this).attr('index');
        indextot = $('#indexc' + ligne).val() || 0;
        //alert("1");
        if (Number(indextot) == Number(index)) {
            //alert("2");
            checked = Number(index) - 1;
            //alert("3");
            $('#' + ligne + 'contactchoisi' + index).prop("checked", false);
            $('#' + ligne + 'contactchoisi' + checked).prop("checked", true);
            //alert("4");
        }
        //alert("5");
        $(this).parent().parent().hide();
        //alert("6");
        $('#' + ligne + 'supp' + index).val(1);
        //alert("7");
        $('#indexc' + ligne).val(checked);
    })
//*************************************************************************************************************
    $('.afficheblockproduction').on('change', function () {
        nvarticle = $('#nvarticle').val();
        window.location.href = wr + "Productions/add/" + nvarticle + "/";
    })
//*************************************************************************************************************
    $('.calculeqteutiliserparod').on('keyup', function () {
        qtefabriquer = $('#qtefabriquer').val();
        index = $('#index').val() || 0;
        //alert(qtefabriquer);
        //alert(index);
        for (j = 0; j <= index; j++) {
            qte = $('#qtehid' + j).val() || 0;
            tt = (Number(qte) * Number(qtefabriquer));
            $('#qte' + j).val(tt);
        }


    })
//*********************************************************************************************************
    $('.testchampsproduction').on('mouseover', function () {
        depotarrive = $('#depotarrive').val() || 0;
        index = $('#index').val() || 0;
        test = 0;
        if (depotarrive == 0) {
            bootbox.alert('le champs Depot arrive obligtoire  !!');
        }
        for (j = 0; j <= index; j++) {
            depot_id = $('#depot_id' + j).val() || 0;
            if (depot_id == 0) {
                test = 1
            }
        }
        if (test == 1) {
            bootbox.alert('les champs depots sortie obligtoire  !!', function () {});
        }
    })
//*********************************************************************************************************
    $('.articlecommandecomercial').on('change', function () {
        //  alert();
        // fournisseur_id== $('#fc').val();

        index = $(this).attr('index');
        article_id = $('#article_id' + index).val();
        client_id = $('#client_id').val();
        //alert(depot_id+'---'+article_id+'-----'+client_id);

        $.ajax({
            type: "POST",
            data: {
                id: article_id,
                clientid: client_id,
            },
            url: wr + "Bonlivraisons/articlecommandecomercial/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            $('#tva' + index).val(data.tva);
            $('#puttc' + index).val(data.prixttc);
            $('#prixhtva' + index).val(data.prix);
            $('#prixnet' + index).val(data.prix);
            $('#totalhtans' + index).val(data.prix);
            $('#quantitestock' + index).val(data.quantitestock);
            $('#designation' + index).val(data.des);
            $('#remise' + index).val(data.remise);
            $('#remiseans' + index).val(data.remise);
            calculefacture();

            $('#order' + index).show();


        })
    })
//**********************************************************************************************************
    $('input').on('keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode == 9) {
            e.preventDefault();
            return false;
        }
    });
//*********************************************************************************************************
    $(".testpvu").on('mousemove', function (e) {
        e.preventDefault();
        pv_id = $(this).val();
        //alert(pv_id);
        if (pv_id != "") {
            //alert(client_id);
            $.ajax({
                type: "POST",
                data: {
                    id: pv_id,
                },
                url: wr + "Pointdeventes/testpvutilisers/",
                dataType: "json",
                global: false //}l'envoie'
            }).done(function (data) {
                console.log(data);
                count = data.var;

                if (count != 0) {
                    bootbox.alert('Impossible de supprimer', function () {});
                    return false
                } else {
                    $('#defaultForm').submit();
                }

            })

        }

    })


//********************************************************************************************************
    $('.afficheinputmontantreglementclient').on('click', function () {
        index = $(this).attr('index');
        if ($('#facture_id' + index).is(':checked')) {
            $('#Montantregler' + index).show();
        } else {
            $('#Montantregler' + index).hide();
        }
    })
//********************************************************************************************************
    $('.afficheinputmontantreglementclientimpaye').on('click', function () {
        index = $(this).attr('index');
        if ($('#impaye_id' + index).is(':checked')) {
            $('#Montantreglerimpaye' + index).show();
        } else {
            $('#Montantreglerimpaye' + index).hide();
        }
    })
//********************************************************************************************************
    $('.testmontantreglementclient').on('keyup', function () {
        index = $(this).attr('index');
        reste = Number($('#facture_id' + index).attr('mnt'));
        montant = Number($('#Montantregler' + index).val());
        if(Number(montant)>Number(reste)){
            $('#Montantregler' + index).val("");
            bootbox.alert('Impossible de dépasser le reste', function () {});
            return false
        }

    })
//*********************************************************************************************************
    $('.testmontantreglementclientimpaye').on('keyup', function () {
        index = $(this).attr('index');
        reste = Number($('#impaye_id' + index).attr('mnt'));
        montant = Number($('#Montantreglerimpaye' + index).val());
        //alert(reste)
        //alert(montant)
        if(Number(montant)>Number(reste)){
            $('#Montantreglerimpaye' + index).val("");
            bootbox.alert('Impossible de dépasser le reste', function () {});
            return false
        }

    })
//*********************************************************************************************************
   $('.testmontanttotalereglementclient').on('mouseover', function () {
        max= $('#max').val();
        maximpaye= $('#maximpaye').val();
        Montant= $('#Montant').val();
        montantregler=0;
        test=0;
        for(i=0;i<=max;i++){
        if($('#facture_id'+i).is(':checked')){//alert();
        if($('#Montantregler'+i).val() ==""){
        test=1;
        }
        //alert(Number($('#Montantregler'+i).val()));
        montantregler=Number(Number(montantregler)+Number($('#Montantregler'+i).val())).toFixed(3);

        }
        }
        for(i=0;i<=maximpaye;i++){
        if($('#impaye_id'+i).is(':checked')){//alert();
        if($('#Montantreglerimpaye'+i).val() ==""){
        test=1;
        }
        //alert(Number($('#Montantregler'+i).val()));
        montantregler=Number(Number(montantregler)+Number($('#Montantreglerimpaye'+i).val())).toFixed(3);

        }
        }
        //alert(montantregler);
        //alert(Montant);
        if(Number(montantregler)>Number(Montant)){
        bootbox.alert('Impossible de dépasser le montant :'+Montant, function () {});

        }
        if(test==1){
        bootbox.alert('vérifier les champs', function () {});
        return false
        }
})
//*********************************************************************************************************
    $('.supstockalert').on('click', function () {
        index = $(this).attr('index');
        //$('#quantite' + index).val(0);
        $('#supstock' + index).val(1);
        $(this).parent().parent().hide();
    })
//*********************************************************************************************************
    $('.refrechepage').on('mousemove', function () {
        //alert();
        index = $('#testindex').val();
        test = $('#sirine').val();
        if (test == 1) {
            uniform_select('article_id' + index);
            $('#sirine').val("0");
        }

    })
//*********************************************************************************************************
    $('.affichediplicationfrs').on('click', function () {


        affichediplication = $(this).attr('value');
        //alert(affichediplication);
        $('.selectdip').show();
        $('.boutselect').show();
        $('#testvalue').val(affichediplication);

    });
//************************************************************************************************************
    $('.modeladdfrs').on('click', function () {
        typedipliquation_id = $('#typedipliquation_id').val();
        testvalue = $('#testvalue').val();
        model_ans = $('#model').val();
        ligne_ans = $('#ligne').val();
        attr = $('#attr').val();
        $(this).attr("href", wr + "Deviprospects/diplique/?td=" + typedipliquation_id + '&id=' + testvalue + '&model_ans=' + model_ans + '&ligne_ans=' + ligne_ans + '&attr=' + attr);

    });
//************************************************************************************************************
    $('.calculereglementclient').on('click', function () {
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
//**********************************************************************************************
    $('.ligneinventaireparfamille').on('change', function () {
        val = $('#famille_id').val() || 0;
        if (val != 0) {
            $(location).attr('href', wr + "Inventaires/addparfamille/" + val);
        }
    });
//**********************************************************************************************
    $('.afficherdivtypesuivi').on('change', function () {
        val = $('#typedevisclient_id').val() || 0;
        if (val == 2) {
            $('#divtypesuivi').show();
            $('#divtypesuivi1').show();
        } else {
            $('#divtypesuivi').hide();
            $('#divtypesuivi1').hide();
        }
    });
//**********************************************************************************************
    $('.testtypedevis').on('mousemove', function () {
        val = $('#typedevisclient_id').val() || 0;
        if (val == 0) {
            bootbox.alert('choisi le type de devis', function () {});
        }
        if (val == 2) {
            typesuivitdevi_id = $('#typesuivitdevi_id').val() || 0;
            if (typesuivitdevi_id == 0) {
                bootbox.alert('choisi le type de suivi ou changer le type devis normal', function () {});
            }
        }
    })
//*********************************************************************************************************
    $('.testmere').on('click', function () {
        if ($(this).prop('checked')) {
            val = $(this).val();
            if (val == 1) {
                $.ajax({
                    type: "POST",
                    data: {

                    },
                    url: wr + "Societes/testmeres/",
                    dataType: "json",
                    global: false //}l'envoie'
                }).done(function (data) {
                    console.log(data);
                    count = data.var;
                    if (count != 0) {
                        $('.btn').prop("disabled", true);
                        bootbox.alert('Impossible d\'ajouter une autre Societe mère', function () {});
                        return false
                    } else {
                        $('.btn').prop("disabled", false);
                    }
                })
            } else {
                $('.btn').prop("disabled", false);
            }
        }
    });
//*********************************************************************************************************
    $('.typetransfert').on('click', function () {
        if ($(this).prop('checked')) {

            val = $(this).val();
            if (val == 1) {
                $('#div_soc_depart').show();
                $('#div_soc_arrive').show();
            } else {
                $('#div_soc_depart').show();
                $('#div_soc_arrive').hide();
            }
            $('#bout_act').show();
            $('#typetransfert').val(val);
        }
    });
//*************************************************************************************************************
    $('.act_transfert').on('click', function () {
        societedepart = $('#societedepart').val() || 0;
        societearrive = $('#societearrive').val() || 0;
        typetransfert = $('#typetransfert').val() || 0;
        window.location.href = wr + "Transferts/add/" + societedepart + "/" + societearrive + "/" + typetransfert + "/";
    })
//*************************************************************************************************************
    $('.test_soc_transfert').on('mousemove', function () {
        societedepart = $('#societedepart').val() || 0;
        societearrive = $('#societearrive').val() || 0;
        if (societedepart == societearrive) {
            bootbox.alert('Impossible de choisir  la meme  Societe ', function () {});
            $('#bout_act_tansf').prop("disabled", true);
        } else {
            $('#bout_act_tansf').prop("disabled", false);
        }
    })
//*************************************************************************************************************
    $('.edit_act_transfert').on('click', function () {

        id = $('#id').val() || 0;
        societedepart = $('#societedepart').val() || 0;
        societearrive = $('#societearrive').val() || 0;
        typetransfert = $('#typetransfert').val() || 0;
        window.location.href = wr + "Transferts/edit/" + id + "/" + societedepart + "/" + societearrive + "/" + typetransfert + "/";
    })
//*************************************************************************************************************
    $('.getcommissionsur').on('change', function () {
        index = $(this).attr('index');
        commissionsur = $('#commissionsur' + index).val();
        //alert(index);
        //alert(commissionsur);
        $.ajax({
            type: "POST",
            data: {
                commissionsur: commissionsur,
                index: index,
            },
            url: wr + "Personnels/getcommissionsurs/",
            dataType: "json",
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            //alert(data.select);
            $('#valeur' + data.index).parent().parent().html(data.select);
            uniform_select('valeur' + data.index);
        })
    })
//**********************************************************************************************************
    $('.calculetransformationbl').on('click', function () {
        totalebl = 0;
        totaleavr = 0;
        totalefac = 0;
        timbre = $('#timbre').val() || 0;
        indexavr = $('#indexavr').val() || 0;
        indexfac = $('#indexfac').val() || 0;
        //alert("indexfac "+indexfac);
        //alert("indexavr "+indexavr);

        if (indexfac != "vide") {
            for (i = 0; i <= indexfac; i++) {
                if ($('#checkbl' + i).is(':checked')) {
                    //alert("ttcfac "+$('#ttcfac'+i).val()||0);
                    totalebl = Number(totalebl) + Number($('#ttcfac' + i).val() || 0);
                }
            }
        }
        //alert("totalebl "+totalebl);
        if (indexavr != "vide") {
            for (i = 0; i <= indexavr; i++) {
                if ($('#checkavr' + i).is(':checked')) {
                    totaleavr = Number(totaleavr) + Number($('#ttcavr' + i).val() || 0);
                }
            }
        }
        //alert("totaleavr "+totaleavr);
        totalefac = Number(totalebl) - Number(totaleavr) + Number(timbre);
        //alert("totalefac "+totalefac);
        $('#totalettc').val(totalefac.toFixed(3));
    });
//**********************************************************************************************************
$('.testqtefactureavoir').on('keyup', function () {
        index=$(this).attr('index');
        qte=$('#quantite'+index).val();
        qtev=$('#quantitevendu'+index).val();
        //alert(qte)
        //alert(qtev)
        if(Number(qte)>Number(qtev)){
        $('#quantite'+index).val("0");
        bootbox.alert('Impossible de dépasser la qte vendu', function () {});
        return false
        }

    })
//*********************************************************************************************************
$('.testmontantavoirfac').on('click',function(e){
    e.preventDefault();
    index_totale = $('#index').val();
    Total_TTC = $('#Total_TTC').val();
    factureclient_id = $('#factureclient_id').val();
    action = $('#action').val()||0;
    id = $('#id').val()||0;
    //alert(action);
    $.ajax({
            type: "POST",
            //async:false,
            url: wr+"Factureclients/getreste/"+factureclient_id+"/"+action+"/"+id,
             dataType : "json",
             global : false //}l'envoie'
      }).done(function(data){
            console.log(data);
            //$('#reste'+index).val(Number(data.reste).toFixed(3));
            //alert(Number(data.reste));
            //alert(Number(Total_TTC));
            if(Number(data.reste)<Number(Total_TTC)){
            bootbox.alert('le montant du facture avoir dépasse le reste du facture client ', function () {});
            }else{
               // alert();
            $('#defaultForm').submit();
            }
     })
});
//**************************************************************************
$('.facturationauto').on('change',function(){

    index=$(this).attr('index');
    //alert(index);

    if($(this).prop('checked')){
    test="automatique";
    //alert(test);
    }else{
    test="non";
    //alert(test);
    }

    $.ajax({
            type: "POST",
            async:false,
            url: wr+"Bonlivraisons/facturationautos/"+test+"/"+index,
             dataType : "json",
             global : false //}l'envoie'
    })
  });
//**********************************************************************************************************
$('.imputereglement').on('change',function(){

    index=$(this).attr('index');
    //alert(index);

    if($(this).prop('checked')){
    test=1;
    }else{
    test=0;
    }

    $.ajax({
            type: "POST",
            async:false,
            url: wr+"Reglementclients/imputereglements/"+test+"/"+index,
            dataType : "json",
            global : false //}l'envoie'
    })
  });
//**********************************************************************************************************
$('.imputereglementfrs').on('change',function(){

    index=$(this).attr('index');
    //alert(index);

    if($(this).prop('checked')){
    test=1;
    }else{
    test=0;
    }

    $.ajax({
            type: "POST",
            async:false,
            url: wr+"Reglements/imputereglements/"+test+"/"+index,
            dataType : "json",
            global : false //}l'envoie'
    })
  });
//**********************************************************************************************************
$('.bloquerclient').on('change',function(){

    index=$(this).attr('index');
    //alert(index);

    if($(this).prop('checked')){
    test=2;
    }else{
    test=1;
    }

    $.ajax({
            type: "POST",
            async:false,
            url: wr+"Clients/bloquerclients/"+test+"/"+index,
            dataType : "json",
            global : false //}l'envoie'
    })
  });
//**********************************************************************************************************
$('.numero_manuel_autocomplete').on('focus', function () {
    valinput=$(this).val();
    //alert(valinput);
    id=$(this).attr('id');
    yourid=$(this).attr('yourid');

    autocomplete_numerofactureclients(id,yourid);

});
//**********************************************************************************************************
$('.code_manuel_autocomplete').on('focus', function () {
    valinput=$(this).val();
    //alert(valinput);
    index=$(this).attr('index');
    id=$(this).attr('id');
    yourid=$(this).attr('yourid');
    if(valinput==""){
    autocomplete_codearticles(id,yourid,index);
    }
});
//**********************************************************************************************************
$('.designation_manuel_autocomplete').on('focus', function () {
    valinput=$(this).val();
    //alert(valinput);
    index=$(this).attr('index');
    id=$(this).attr('id');
    yourid=$(this).attr('yourid');
    if(valinput==""){
    autocomplete_designationarticles(id,yourid,index);
    }
});
//**********************************************************************************************************
$('.index_code_manuel_autocomplete').on('focus', function () {
    valinput=$(this).val();
    //alert(valinput);
    index=$(this).attr('index');
    id=$(this).attr('id');
    yourid=$(this).attr('yourid');
    //if(valinput==""){
    autocomplete_index_codearticles(id,yourid,index);
    //}
});
//**********************************************************************************************************
$('.index_designation_manuel_autocomplete').on('focus', function () {
    valinput=$(this).val();
    //alert(valinput);
    index=$(this).attr('index');
    id=$(this).attr('id');
    yourid=$(this).attr('yourid');
    //if(valinput==""){
    autocomplete_index_designationarticles(id,yourid,index);
   //}
});
//**********************************************************************************************************
$('.autocomplete_name_clients').on('focus', function () {
    valinput=$(this).val();
    id=$(this).attr('id');
    yourid=$(this).attr('yourid');
    autocomplete_name_clients(id,yourid);
});
//**********************************************************************************************************
$('.autocomplete_name_clients_reg').on('focus', function () {
    valinput=$(this).val();
    id=$(this).attr('id');
    yourid=$(this).attr('yourid');
    page=$("#page").val()||0;
    autocomplete_name_clients_reg(id,yourid,page);
});
//**********************************************************************************************************
$('.autocomplete_matriculefiscale_clients').on('focus', function () {
    valinput=$(this).val();
    id=$(this).attr('id');
    yourid=$(this).attr('yourid');
    autocomplete_matriculefiscale_clients(id,yourid);
});
//************************************************************************************************************
//$(".testdu3mois").on('change', function (e) {
//        //e.preventDefault();
//        client_id = $('#client_id').val();
//        if (client_id != "") {
//            $.ajax({
//                type: "POST",
//                data: {
//                    client_id: client_id,
//                },
//                url: wr + "Factureclients/testdu3mois/",
//                dataType: "json",
//                global: false //}l'envoie'
//            }).done(function (data) {
//                console.log(data);
//                if (data.Factureclients+data.piecereglements > 0 && data.modeclient==2) {
//                        bootbox.alert('ce client possède <strong>'+data.Factureclients+'</strong> facture(s) non réglée(s) et '+data.piecereglements+' impayé(s) avant la date <strong>'+data.date_first_day+'</strong><br> pour vérifer ,veuillez cliquer sur ce <a TARGET=_BLANK href="'+wr+'Recouvrements/index/'+client_id+'"><strong>lien</strong></a> ', function () {});
//                        return false
//                }
//
//            })
//
//        } else {
//            bootbox.alert('Choisir un client SVP', function () {});
//        }
//
//    })
//************************************************************************************************************
$('.testtimbre').on('change',function(){
    typedipliquation = $('#typedipliquation').val()||0;
    client_id = $('#client_id').val();
    page=$('#page').val();
    if((typedipliquation==1 || typedipliquation==4)||(typedipliquation==0 &&(page=="Factureclient"||page=="Devi"))){
        $.ajax({
        type: "POST",
        data: {
                client_id: client_id
            },
        url: wr + "Factureclients/gettimbre/",
        dataType: "json",
    }).done(function (data) {
    $('#timbre').val(data.timbre);
    calculefacture();
    })
    }else{
    $('#timbre').val("0");
    calculefacture();
    }
  });
  //************************************************************************************************************
  $('.autocomplete_numero_bls').on('focus', function () {
    valinput=$(this).val();
    id=$(this).attr('id');
    yourid=$(this).attr('yourid');
    autocomplete_numero_bls(id,yourid);
});
//**********************************************************************************************************
$('.autocomplete_numero_facs').on('focus', function () {
    valinput=$(this).val();
    id=$(this).attr('id');
    yourid=$(this).attr('yourid');
    autocomplete_numero_facs(id,yourid);
});
//**********************************************************************************************************
$('.fermercarnetcheque').on('change',function(){
    index=$(this).attr('index');
    if($(this).prop('checked')){
    test=0;
    }else{
    test=1;
    }
    $.ajax({
            type: "POST",
            async:false,
            url: wr+"Carnetcheques/fermercarnetcheque/"+test+"/"+index,
             dataType : "json",
             global : false //}l'envoie'
    })
  });
//**********************************************************************************************************
})



function modifierchamptestindex(index) {
    $('#testindex').val(index);
}
function modifierchamptestindex_recap_nouveau_prix(index) {
//    alert(index);
    $('#testindex').val(index);
}
function test_situation_frs_externe() {
    etatpiecereglement_id = $('#etatpiecereglement_id').val();
    if ((etatpiecereglement_id == "")) {
        $('#boutton_ok').hide();
    } else {
        $('#boutton_ok').show();
    }
    if ((etatpiecereglement_id == 7) || (etatpiecereglement_id == 8) || (etatpiecereglement_id == 10)) {
        if (($('#nbrjour').val() == "") || ($('#echancenf').val() == "__/__/____") || ($('#montant').val() == "")) {
            $('#boutton_ok').hide();
        } else {
            $('#boutton_ok').show();
        }
    }


    if ((etatpiecereglement_id == 9)) {
        if ($('#nbrmois').val() == "") {
            $('#boutton_ok').hide();
        } else {
            $('#boutton_ok').show();
        }
    }

}
function affiche_bouttonok_situation_frs_externe() {
    etatpiecereglement_id = $('#etatpiecereglement_id').val();
    //alert();

    if ((etatpiecereglement_id == 7) || (etatpiecereglement_id == 8) || (etatpiecereglement_id == 10)) {
        if (($('#nbrjour').val() == "") || ($('#echancenf').val() == "__/__/____") || ($('#montant').val() == "")) {
            $('#boutton_ok').hide();
        } else {
            $('#boutton_ok').show();
        }
    }
    if ((etatpiecereglement_id == 9)) {
        if ($('#nbrmois').val() == "") {
            $('#boutton_ok').hide();
        } else {
            $('#boutton_ok').show();
        }
    }
}
function affichediv_situation_frs_externe() {
//alert();
    etatpiecereglement_id = $('#etatpiecereglement_id').val();
    count_tab = $('#resultat').val();

    //alert(count_tab);

    if ((etatpiecereglement_id == "")) {
        $('#boutton_ok').hide();
    } else {
        $('#boutton_ok').show();
    }
    //alert(etatpiecereglement_id);
    if ((etatpiecereglement_id == 7) || (etatpiecereglement_id == 8) || (etatpiecereglement_id == 10)) {
        $('#div_situation_frs_externe').show();
    } else {
        $('#div_situation_frs_externe').hide();
    }


    if ((etatpiecereglement_id == 9)) {
        if (count_tab == 2) {
            $('#divcredit').show();
        } else {
            $('#boutton_ok').hide();
            $('#labelcredit').show();
        }
    } else {
        $('#divcredit').hide();
        $('#boutton_ok').show();
        $('#labelcredit').hide();
    }
}
function temps(date) {
    var d = new Date(date[2], date[1] - 1, date[0]);
    return d.getTime();
}
function nbrjour(index) {
    datedebut = $('#datedebut' + index).val();
    datefin = $('#datefin' + index).val();
    if (datefin != '__/__/____') {
        var debut = temps(datedebut.split("/"));
        var fin = temps(datefin.split("/"));
        var nb = (fin - debut) / (1000 * 60 * 60 * 24);
        nb = Number(nb) + 1;
        $('#nbrjour' + index).val(Number(nb));
    }
}
function calculetotalecredit(index) {
    //alert();
    //index=$('#index').val();
    nbrtr = $('#nbrtr' + index).val();
    montant = $('#montant').val() || 0;
    //alert(montant);
    test = 0;
    tt = 0;
    for (j = 1; j <= nbrtr; j++) {
        th = $('#' + index + 'montantcredit' + j).val() || 0;
        tt = (Number(tt) + Number(th)).toFixed(3);
        if (Number(tt) > Number(montant)) {
            $('#' + index + 'montantcredit' + j).val("");
            test = 1;
        }
    }
    //alert(tt);
    if (test == 1) {
        bootbox.alert('Vérifier le montant', function () {});
        return false
    } else {
        $('#' + index + 'total').val(tt);
    }
    //agio = Number(Number(tt) - Number(montant)).toFixed(3);
    //$('#' + index + 'agio').val(agio);

}
function ajouter_ligne_livraison1(table, index) {
    ind = Number($('#' + index).val()) + 1;

    $ttr = $('#' + table).find('.tr').clone(true);
    //console.log($ttr);
    $ttr.attr('class', 'cc' + ind);
    i = 0;
    tabb = [];
    $ttr.find('input,select,a,td,div,span').each(function () {

        if ($(this).attr('champ') == 'tva') {
            $(this).attr('readonly', 'readonly');
        }
        //*****************


        tab = $(this).attr('table');
        champ = $(this).attr('champ');
        $(this).attr('index', ind);
        $(this).attr('id', champ + ind);
        $(this).attr('name', 'data[' + tab + '][' + ind + '][' + champ + ']');
        $(this).attr('data-bv-field', 'data[' + tab + '][' + ind + '][' + champ + ']');
        lename = $(this).attr('name');
        page = $('#page').val();
		yourid = $(this).attr('yourid');
		if(yourid!=""){
        $(this).attr('yourid', yourid+ ind);
        }
//        alert();
        if (page == 'suggestioncommande' || page == 'commande') {
            if (champ == 'tdaff') {
                fournisseur_id = $('#fc').val();
                //$(this).html("<span title='ajouter article'><a  onClick=flvFPW1(wr+'Deviprospects/recapajoutarticle?index="+ind+",'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue' href='javascript:;' ><i class='fa fa-plus-circle'></i></a></span>");
                $(this).html('<a onClick="modifierchamptestindex(' + ind + '),flvFPW1(\'' + wr + 'Deviprospects/recapajoutarticle/' + ind + '/achat\' ,\'UPLOAD\', \'width=1200,height=1150,scrollbars=yes\', 0, 2, 2 ); return document.MM_returnValue;" href=\'javascript:;\'  >  <i class=\'glyphicon glyphicon-plus modifierchamptestindex\' index=' + ind + ' style="color: #cc0000"></i></a>');
                //$(this).attr('onclick','recap_ajout_article('+ind+')')
            }
        }
        if (champ == 'nv-art') {
                $(this).html('<a onClick="modifierchamptestindex(' + ind + '),flvFPW1(\'' + wr + 'Deviprospects/recapajoutarticle/' + ind  + '/vente\' ,\'UPLOAD\', \'width=1200,height=1150,scrollbars=yes\', 0, 2, 2 ); return document.MM_returnValue;" href=\'javascript:;\'  >  <i class=\'glyphicon glyphicon-plus modifierchamptestindex\' index=' + ind + ' style="color: #cc0000"></i></a>');
        }
        //*************************************************************************
        // if ((($(this).is('input')) || ($(this).is('select')))) {
        //     if ($(this).attr('type') != 'hidden') {
        //         if ($(this).attr('readonly') != 'readonly') {
        //             if (nextid != '') {
        //                 // alert();
        //                 currentid = $(this).attr('id');
        //                 alert(" next id " + nextid + " ***  current id " + currentid);
        //                 alert(mb);
        //                 //$('#' +nextid).attr('inputnext',currentid);
        //                 tabb_id[mb]=nextid;
        //                 tabb_nextid[mb]=currentid;
        //                 mb++;
        //                 alert(tabb_id[mb]);
        //                 alert(tabb_nextid[mb]);
        //
        //             }
        //             nextid = $(this).attr('id');
        //
        //         }}}


        if ((($(this).is('input')) || ($(this).is('select')))) {

            //alert($(this).attr('champ'));
            if ($(this).attr('type') != 'hidden') {
                if ($(this).attr('readonly') != 'readonly') {

                    // if (nextid != '') {
                    //     // alert();
                    //     currentid = $(this).attr('id');
                    //     alert(" next id " + nextid + " ***  current id " + currentid);
                    //     alert("index next valeur " + $('#' + nextid).attr('index'));
                    //     $('#' + nextid).attr('inputnext', currentid);
                    //     alert("attr " + $('#' + nextid).attr('inputnext'));
                    //
                    // }
                    // nextid = $(this).attr('id');
                    //
                    //
                    // /!*
                    //
                    // $(this).attr('ordreinput', mb);
                    // if($(this).attr('champ')=='code'){
                    //     mb++;
                    //     mbcode=mb;
                    //
                    // }
                    // mb++;
                    // if($(this).attr('champ')=='designation'){
                    //     $(this).attr('ordreinput', mbcode);
                    //
                    // }*!/
//                    if ($(this).attr('champ') == 'depot_id') {
//                        $(this).attr('onchange', 'fuckfocus("select","'+ind+'","'+lename+'")');
//                    } else {
                    $(this).attr('onkeypress', 'fuckfocus("input","' + ind + '","' + lename + '")');
                    $(this).attr('onFocus', 'select();');
                    // }

                }

            }
        }




        //************************************************************************
        if (champ == 'article_id') {
            $(this).attr('onchange', 'art(' + ind + ')')
        }

        if ($("#page").val() == 'commandecommercial') {
            if (champ == 'article_id') {
                $(this).attr('onchange', 'articlecommandecomercial(' + ind + ')')
            }
        }
        if (champ == 'order') {
            $(this).attr('onclick', 'recap_rapport(' + ind + ')')
        }
        if (champ == 'nouveauart') {
            article_id = $('#article_id' + ind).val() || 0;
//            alert(article_id);


            $(this).html('<a onClick="modifierchamptestindex_recap_nouveau_prix(' + ind + '),flvFPW1(\'' + wr + 'Factureclients/recap_nouveau_prix/' + ind + '/' + article_id + '\' ,\'UPLOAD\', \'width=1200,height=600,scrollbars=yes\', 0, 2, 2 ); return document.MM_returnValue;" href=\'javascript:;\'  >  <i class=\'glyphicon glyphicon-plus modifierchamptestindex_recap_nouveau_prix\' index=' + ind + ' style="color: #0080FF"></i></a>');

        }
        if (champ == 'num') {
            //alert("222");
            num = Number(ind);
            $(this).html(num);
        }





        //**********************************************************************
        //$(this).removeClass('anc');
        if ($(this).is('select')) {
            tabb[i] = champ + ind;
            i = Number(i) + 1;
        }

        $(this).val('');
  if (champ == 'quantite') {
$(this).val('1');	  
  }
    })


    //alert(tabb_id);

    $ttr.find('i').each(function () {
        $(this).attr('index', ind);
    });
    $('#' + table).append($ttr);
    $('#' + index).val(ind);
    $('.cc' + ind).show();

    for (j = 0; j <= i; j++) {

        uniform_select(tabb[j]);
    }
    $('#ldate' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});
    // for (m = 0; m <= mb; m++) {
    //     $('#'+tabb_id[m][id]).attr('inputnext',tabb_id[m][nextid]);
    // }
    //uniform_select('depot_id' + ind);

    //$('#depot_id'+ind).next().children().children().focus();
    //scrolldown();

}
function recap_importation() {
    fournisseur_id = $("#fournisseur_id").val();


    $.ajax({
        type: "POST",
        data: "fournisseur_id=" + fournisseur_id

        ,
        url: wr + "Importations/recap/",
        dataType: "HTML"
    }).done(function (data) {

        $('#importation_par_frs').html(data);
        //window.location.href=wr+"Rapports/etat";

    });
}
function recap_nouveau_prix(index) {

    $.ajax({
        type: "POST",
        data: "&index=" + index
        ,
        url: wr + "Factureclients/recap_nouveau_prix/",
        dataType: "HTML"
    }).done(function (data) {
        $('#pop').html(data);

    });
}
function recap_rapport(index) {
    client_id = $("#client_id").val();
    article_id = $("#article_id" + index).val();
    $('#pop').html("");
    $(".remodal-confirm").hide();
    $.ajax({
        type: "POST",
//        data: "client_id=" + client_id
//                + "&article_id=" + article_id
//                + "&index=" + index
//        ,
        url: wr + "Bonlivraisons/recap/"+index+"/"+client_id+"/"+article_id,
        dataType: "HTML"
    }).done(function (data) {
		if(client_id!=0){
        $('#pop').html(data);
        //window.location.href=wr+"Rapports/etat";
		}

    });
}
function recap_situation_piece_frs(piece_id) {
    $("#boutton_ok").hide();
    $.ajax({
        type: "POST",
        data: "piece_id=" + piece_id

        ,
        url: wr + "Piecereglements/recapansiensituation/",
        dataType: "HTML"
    }).done(function (data) {
        $('#pop').html("");
        $('#popp').html(data);
        //window.location.href=wr+"Rapports/etat";
    });
}
function recap_ajout_article(index) {
    $.ajax({
        type: "POST",
        data: "index=" + index
        ,
        url: wr + "Deviprospects/recapajoutarticle/",
        dataType: "HTML"
    }).done(function (data) {
        $('#poparticle').html(data);
        uniform_select('famille_id');
        uniform_select('unite_id');
        uniform_select('typeetatarticle_id');
        uniform_select('typestockarticle_id');
        uniform_select('tag_id');
        //window.location.href=wr+"Rapports/etat";
    });
}
function recap_piecereglement() {
    listepiece = $("#changer").val();
    //alert(listepiece);
    $('#boutton_ok').attr('onclick', 'changersituation()');
    $('#boutton_ok').attr('onmouseover', 'test_situation_frs_externe()');
    $.ajax({
        type: "POST",
        data: "index=" + listepiece
        ,
        url: wr + "Engagementfournisseurs/recap/",
        dataType: "HTML"
    }).done(function (data) {
        $('#popp').html("");
        $('#pop').html(data);
        $('#datesituation').datetimepicker({
            timepicker: false,
            datepicker: true,
            mask: '39/19/9999',
            format: 'd/m/Y'
        });
        $('#echancenf').datetimepicker({
            timepicker: false,
            datepicker: true,
            mask: '39/19/9999',
            format: 'd/m/Y'
        });
        uniform_select('etatpiecereglement_id');
    });
}
function recap1_piecereglement(index) {
    $('#boutton_ok').attr('onclick', 'changersituation2()');
    $.ajax({
        type: "POST",
        data: "index=" + index
        ,
        url: wr + "Piecereglements/recap/",
        dataType: "HTML"
    }).done(function (data) {
        $('#poppiece').html(data);
        uniform_select('#stut');
        $('#datesituation').datetimepicker({
            timepicker: false,
            datepicker: true,
            mask: '39/19/9999',
            format: 'd/m/Y'});
    });
}
function recap_achat(index) {
    article_id = $("#article_id" + index).val();
    tableligne = $("#tableligne").val();
    //alert(article_id);

    $.ajax({
        type: "POST",
        data: "article_id=" + article_id
                + "&index=" + index
                + "&tableligne=" + tableligne
        ,
        url: wr + "Bonreceptions/recap/",
        dataType: "HTML"
    }).done(function (data) {

        $('#popachat').html(data);
        ajouter_ligne_reception('tablehelmi', 'indexhelmi', 'trhelmi');
        //window.location.href=wr+"Rapports/etat";

    });
}
function recap_piecereglementclient() {
    //alert();
    listepiece = $("#changer").val();
    //alert(listepiece);
    $.ajax({
        type: "POST",
        data: "index=" + listepiece
        ,
        url: wr + "Piecereglementclients/recap/",
        dataType: "HTML"
    }).done(function (data) {
        $('#poppiece').html(data);
        uniform_select('compte_id');
        uniform_select('situation_id');
        $('#datesituation').datetimepicker({
            timepicker: false,
            datepicker: true,
            mask: '39/19/9999',
            format: 'd/m/Y'});
    });
}
function changertout(index_radio) {

    //alert(index);
    index = $("#index_kbira").val();

    prix_ans = $("#prix_ans" + index_radio).val();
    prixnet_ans = $("#prixnet_ans" + index_radio).val();
    puttc_ans = $("#puttc_ans" + index_radio).val();
    totalhtans_ans = $("#totalhtans_ans" + index_radio).val();
    remise_ans = $("#remise_ans" + index_radio).val();
    tva_ans = $("#tva_ans" + index_radio).val();
    totalht_ans = $("#totalht_ans" + index_radio).val();
    totalttc_ans = $("#totalttc_ans" + index_radio).val();

    article_id_ans = $("#id_ans" + index_radio).val();
    code_ans = $("#code_ans" + index_radio).val();
    name_ans = $("#name_ans" + index_radio).val();
    quantite_ans = $("#quantite_ans" + index_radio).val();

    prixachatmarge = $("#coutrevient" + index_radio).val();
    margebase = $("#marge" + index_radio).val();
    margebaseorigine = $("#marge" + index_radio).val();

    composee_ans = $("#composee_ans" + index_radio).val();

    $.ajax({
        type: "POST",
        data: "article_id_ans=" + article_id_ans
        ,
        url: wr + "Articles/getarticlehistorique/",
        dataType: "json",
        async:false
    }).done(function (data) {







    $('#code' + index).val(code_ans);
    $('#designation' + index).val(name_ans.replace( '1*2*2*1*2',"'").replace( '1*2**1*2','"'));
    $('#article_id' + index).val(article_id_ans);
    $('#quantite' + index).val(quantite_ans);

    $('#type' + index).val(composee_ans);

    $('#prixachatmarge' + index).val(prixachatmarge);
    $('#margebase' + index).val(margebase);
    $('#margebaseorigine' + index).val(margebaseorigine);

    $('#prixhtva' + index).val(prix_ans);
    $('#prixnet' + index).val(prixnet_ans);
    $('#puttc' + index).val(puttc_ans);
    $('#totalhtans' + index).val(prix_ans);
    $('#remise' + index).val(remise_ans);
    $('#tva' + index).val(data.tva);
    $('#totalht' + index).val(totalht_ans);
    $('#totalttc' + index).val(totalttc_ans);
    calculefacture();
    $(".remodal-close").click();
    //$('.remodal').modal('hide');

    // temchi
    // $('#poppa').parent().hide();
    //$('#poppa').parent().remove();
 });
}
function calculerprixdevente(index_kbira, i) {

    //alert(i);
    //alert(index_kbira);
    prixhtva = $("#prixhtva" + index_kbira).val() || 0;
    if (i == 1) {
        marge = $("#marge").val() || 0;
        pv = Number(prixhtva) * (1 + (Number(marge) / 100));
        $("#prixvente").val(pv.toFixed(3));
    } else {
        prixvente = $("#prixvente").val() || 0;
        m = ((Number(prixvente) - Number(prixhtva)) / Number(prixhtva)) * 100;
        $("#marge").val(m.toFixed(3));
    }

}
function validerprixdevente() {
    bootbox.confirm("vous voulez validé le nouveau prix de vente?", function (result) {
        if (result) {
            var html = 'Ok';
            index_kbira = $("#index_kbira").val();
            marge = $("#marge").val() || 0;
            prixvente = $("#prixvente").val() || 0;
            $('#margeA' + index_kbira).val(marge);
            $('#pvA' + index_kbira).val(prixvente);
        } else {
            var html = 'Cancel';
        }

    });
}
function get_tr_coe() {
    importationid = $('#importation_id').val();

    $.ajax({
        type: "POST",
        data: {
            importationid: importationid

        },
        url: wr + "Importations/getcoes/",
        dataType: "json",
        global: false //}l'envoie'
    }).done(function (data) {

        console.log(data);
        $('#tr').val(data.tr);
        c = Number(data.coe).toFixed(2);
        $('#coe').val(c);
        $('#tr').attr('readonly', true);
        $('#coe').attr('readonly', true);
        tot = Number(data.tr) * Number(data.coe);
        $('#coef').val(tot);
        calculesuggestion();
    })

}
function edittabledemoins(table, index, tr, p, nbrtr, nbrmoins, indexkbira) {
    //alert('p'+p);
    nbrtr = Number(nbrtr) + 1;
    for (ii = nbrtr; ii <= nbrmoins; ii++) {
        ind = Number(ii);
        //alert('ind'+ind);
        $ttr = $('#' + table).find('.tr').clone(true);
        $ttr.attr('class', '');
        //champtr=$ttr.attr('champ');
        // alert('champ '+$ttr);
        $ttr.attr('id', 'tr' + ind);
        i = 0;
        tabb = [];
        //$('#tr').remove();
        $ttr.find('input,select,span,tr,td').each(function () {
            tab = $(this).attr('table');
            champ = $(this).attr('champ');
            $(this).attr('index', ind);
            $(this).attr('id', indexkbira + champ + ind);
            $(this).attr('name', 'data[credits][' + indexkbira + '][' + tab + '][' + ind + '][' + champ + ']');
            $(this).attr('data-bv-field', 'data[' + tab + '][' + ind + '][' + champ + ']');
            if (champ == "n") {
                $(this).html(ind);
            }
            if (champ == 'montantcredit') {
                $(this).attr('onkeyup', 'calculetotalecredit(' + indexkbira + ')')
            }
            $(this).removeClass('anc');
            if ($(this).is('select')) {
                tabb[i] = champ + ind;
                i = Number(i) + 1;
            }

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
        calculetotalecredit(indexkbira);
        $('#echancecredit' + ind).datetimepicker({
            timepicker: false,
            datepicker: true,
            mask: '39/19/9999',
            format: 'd/m/Y'});

    }

}
function changersituation() {
    bootbox.confirm("vous voulez validé la nouvelle situation?", function (result) {
        if (result) {
            var html = 'Ok';
            piecereglement_id = $("#piecereglement_id").val();
            id = $("#id").val() || 0;
            datesituation = $("#datesituation").val() || 0;
            etatpiecereglement_id = $("#etatpiecereglement_id").val() || 0;
            echancenf = $("#echancenf").val() || 0;
            if (etatpiecereglement_id == 9) {
                montant = $("#montantc").val() || 0;
            } else {
                montant = $("#montant").val() || 0;
            }
            nbrmois = $("#nbrmois").val() || 0;
            nbrjours = $("#nbrjour").val() || 0;

            $.ajax({
                type: "POST",
                data: "piecereglement_id=" + piecereglement_id
                        + "&id=" + id
                        + "&date=" + datesituation
                        + "&nbrjour=" + nbrjours
                        + "&etatpiecereglement_id=" + etatpiecereglement_id
                        + "&echancenf=" + echancenf
                        + "&montant=" + montant
                        + "&nbrmoins=" + nbrmois
                ,
                url: wr + "Engagementfournisseurs/misajourrecap/",
                dataType: "HTML"
            }).done(function (data) {
            });
            etatpiecereglement_id = $("#etatpiecereglement_id").val() || 0;
            //alert(etatpiecereglement_id);
            if ((etatpiecereglement_id == 9)) {
                nbrmois = $("#nbrmois").val() || 0;
                piecereglement_id = $("#piecereglement_id").val();
                montantc = $("#montantc").val() || 0;
                //alert("9");
                //alert(nbrmois);
                window.location.href = wr + "Reglements/recap/" + nbrmois + "/" + piecereglement_id + "/" + montantc + "/";
            } else {
                //alert("!9");
                window.location.href = wr + "Bordereaus/indexpf";
            }
        } else {
            var html = 'Cancel';
        }

    });




}
function changersituation2() {
    bootbox.confirm("vous voulez validé la nouvelle situation?", function (result) {
        if (result) {
            var html = 'Ok';
            piecereglement_id = $("#piecereglement_id").val();
            id = $("#id").val() || 0;
            datesituation = $("#datesituation").val() || 0;
            agiosituation = $("#agiosituation").val() || 0;
            stut = $("#situation").val();
            $.ajax({
                type: "POST",
                data: "piecereglement_id=" + piecereglement_id
                        + "&id=" + id
                        + "&date=" + datesituation
                        + "&agio=" + agiosituation
                        + "&etatpiecereglement_id=" + stut
                ,
                url: wr + "Engagementfournisseurs/misajourrecap/",
                dataType: "HTML"
            }).done(function (data) {
            });
            //window.location.href=wr+"Piecereglements/index";
        } else {
            var html = 'Cancel';
        }

    });




}
function affichetr(index) {
    type = $("#ligne" + index).val();
    //alert(type);
    if (type == 0) {
        $("#trr" + index).show();
        $("#trrr" + index).show();
        $("#trrrr" + index).show();
        $("#ligne" + index).val(1);
    } else {
        $("#trr" + index).hide();
        $("#trrr" + index).hide();
        $("#trrrr" + index).hide();
        $("#ligne" + index).val(0);
    }
}
function changersituationclient() {

    bootbox.confirm("vous voulez validé la nouvelle situation?", function (result) {
        if (result) {
            var html = 'Ok';
            piecereglement_id = $("#piecereglement_id").val();
            id = $("#id").val() || 0;
            datesituation = $("#datesituation").val() || 0;
            agiosituation = $("#agiosituation").val() || 0;
            compte = $("#compte_id").val();
            stut = $("#situation_id").val();
            $.ajax({
                type: "POST",
                data: "piecereglementclient_id=" + piecereglement_id
                        + "&id=" + id
                        + "&date=" + datesituation
                        + "&agio=" + agiosituation
                        + "&compte_id=" + compte
                        + "&situation=" + stut
                ,
                url: wr + "Piecereglementclients/misajourrecap/",
                dataType: "HTML"
            }).done(function (data) {
            });
            window.location.href = wr + "Bordereaus/indexpc";
        } else {
            var html = 'Cancel';
        }

    });
}
function testcompte() {
    compte_id = $('#compte_id').val() || 0;
    if (compte_id == 0) {
        $('#labelcompte').show();
        $('#boutton_ok').hide();
    }
    datesituation = $('#datesituation').val() || 0;
    if (datesituation == "__/__/____") {
        $('#labeldate').show();
        $('#boutton_ok').hide();
    }

}
function afficheboutton_ok() {
    compte_id = $('#compte_id').val() || 0;
    if (compte_id != 0) {
        $('#labelcompte').hide();
        $('#boutton_ok').show();
    }
}
function afficheboutton_okdate() {
    datesituation = $('#datesituation').val() || 0;
    if (datesituation != "__/__/____") {
        $('#labeldate').hide();
        $('#boutton_ok').show();
    }
}
function  articlecommandecomercial(index) {
    ///alert(index);
    article_id = $('#article_id' + index).val();
    client_id = $('#client_id').val();
    //  alert(article_id);
    //  alert('depooo ='+depot_id);

    $.ajax({
        type: "POST",
        data: {
            id: article_id,
            client_id: client_id
        },
        url: wr + "Bonlivraisons/articlecommandecomercial/",
        dataType: "json",
        global: false //}l'envoie'
    }).done(function (data) {
        //alert(data);
        $('#tva' + index).val(data.tva);
        $('#puttc' + index).val(data.prixttc);
        $('#prixhtva' + index).val(data.prix);
        $('#prixnet' + index).val(data.prix);
        $('#totalhtans' + index).val(data.prix);
        $('#quantitestock' + index).val(data.quantitestock);
        $('#designation' + index).val(data.des);
        $('#remise' + index).val(data.remise);
        $('#remiseans' + index).val(data.remise);
        calculefacture();
        $('#order' + index).show();
    })
}
function completdevis() {


    id = $("#id").val();
    delaidelivraison = $("#delaidelivraison").val();
    validite = $("#validite").val();
    modedepaiement = $("#modedepaiement").val();
    $.ajax({
        type: "POST",
        data: "&id=" + id
                + "&delaidelivraison=" + delaidelivraison
                + "&validite=" + validite
                + "&modedepaiement=" + modedepaiement

        ,
        url: wr + "Devis/misajourrecap/",
        dataType: "HTML"
    }).done(function (data) {

    });
    $('#bout_imp').show();


}
function recap_devi(id) {
    //alert();
    $.ajax({
        type: "POST",
        data: "id=" + id

        ,
        url: wr + "Devis/recap/",
        dataType: "HTML"
    }).done(function (data) {

        $('#pop').html(data);


    });
}
function recap_reglement_client(id) {
    //alert();
    $.ajax({
        type: "POST",
        data: "id=" + id

        ,
        url: wr + "Factureclients/recap_reglement/",
        dataType: "HTML"
    }).done(function (data) {
        // alert(id);
        $('#pop').html(data);


    });
}
function recap_reglementclient(id) {
    //alert();
    $.ajax({
        type: "POST",
        data: "id=" + id

        ,
        url: wr + "Reglementclients/recap/",
        dataType: "HTML"
    }).done(function (data) {

        $('#pop').html(data);


    });
}
function separateurMillier(num) {
    return ("" + num).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, function ($1) {
        return $1 + " "
    });
}
function enregisterarticle() {


    id = $("#id").val();
    delaidelivraison = $("#delaidelivraison").val();
    validite = $("#validite").val();
    modedepaiement = $("#modedepaiement").val();
    $.ajax({
        type: "POST",
        data: "&id=" + id
                + "&delaidelivraison=" + delaidelivraison
                + "&validite=" + validite
                + "&modedepaiement=" + modedepaiement

        ,
        url: wr + "Devis/misajourrecap/",
        dataType: "HTML"
    }).done(function (data) {

    });
    $('#bout_imp').show();


}
function autocomplete_numerofactureclients(inp_name,inp_id) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
    inp=document.getElementById(inp_name);
    id=document.getElementById(inp_id);
    pv=document.getElementById('pv').value;
    console.log(inp);console.log(pv);
  var currentFocus,sommedeslignedata;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      sommedeslignedata=0;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      a.setAttribute("style", "left: 218px;");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
        $.ajax({
        type: "POST",
        data: {
                val: val,
                pv:pv
            },
        url: wr+"factureclients/listefactureclients/",
        dataType : "JSON"
        }).done(function(data){
            sommedeslignedata=data.Factureclients.length;
            //console.log(sommedeslignedata);
            for (i = 0; i < data.Factureclients.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            //if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
              /*create a DIV element for each matching element:*/
              b = document.createElement("DIV");

              if(i===0){
              b.setAttribute("class", "option autocomplete-active");
              currentFocus++;
              }else{
              b.setAttribute("class", "option");
              }
              /*make the matching letters bold:*/
              //b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML = data.Factureclients[i]['Factureclient']['numero'];
              /*insert a input field that will hold the current array item's value:*/
              b.innerHTML += "<input type='hidden' value='" + data.Factureclients[i]['Factureclient']['numero']+ "'>";
              b.innerHTML += "<input type='hidden' value='" + data.Factureclients[i]['Factureclient']['numeroconca']+"'>";
              /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  ///console.log(this.getElementsByTagName("input")[1].value);
                  inp.value = this.getElementsByTagName("input")[0].value;
                  id.value = this.getElementsByTagName("input")[1].value;
                  /*close the list of autocompleted values,
                  (or any other open lists of autocompleted values:*/
                  closeAllLists();
              });
              a.appendChild(b);
            //}
            }
        });
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
//      console.log(currentFocus);
//      console.log(sommedeslignedata);


      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/

        if(currentFocus!=sommedeslignedata-1){
        currentFocus++;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        if(currentFocus!=0){
        currentFocus--;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  function setActiveOption  ( scroll, animate) {
            var height_menu, height_item, y;
            var scroll_top, scroll_bottom;
            var self = this;
            $option="div.option";
            $dropdown_content="div.autocomplete-items";
            $activeOption="div.option.autocomplete-active";
            //$('.div.option.autocomplete-active').removeClass('autocomplete-active');
            //$('.div.option.autocomplete-active') = null;
            //$option = $($option);
            //if (!$option.length) return;
            //self.$activeOption = $('.div.option').addClass('autocomplete-active');
            somme=0;
            if (scroll || !isset(scroll)) {
                aaaaa =80;
                height_menu = $('.autocomplete-items').height();
                //console.log("height_menu "+height_menu);
                height_item = $('.autocomplete-active').outerHeight();
                //console.log("height_item "+height_item);
                scroll = $('.autocomplete-items').scrollTop() || 0;
                //console.log("scroll "+scroll);
                var nav = $('.autocomplete-active');
                if (nav.length) {
                var contentNav = nav.offset().top;
                }
                var nav1 = $('.autocomplete-items');
                if (nav1.length) {
                var contentNav1 = nav1.offset().top;
                }
                y = contentNav - contentNav1 + scroll;
                //console.log("y "+y);
                scroll_top = y;
                scroll_bottom = y - (height_menu-80) + height_item;
                //console.log("scroll_bottom "+scroll_bottom);
                somme= (y + height_item) - ((height_menu - 80) + scroll);
                //console.log("7esba  "+somme );
                if (y + height_item > (height_menu - 80) + scroll) {
                    //console.log("1++++++++++++");
                    //console.log("scroll_bottom "+scroll_bottom);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_bottom}, animate ? 80 : 0);
                } else if (y !== scroll) {
                    if (y < scroll+10) {
                    //console.log("2++++++++++++");
                    //console.log("scroll_top "+scroll_top);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_top-100}, animate ? 150 : 0);
                }}
//console.log("*****************************************");
            }
        }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      //closeAllLists(e.target);
  });
}

function autocomplete_codearticles(inp_name,inp_id,index) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
    inp=document.getElementById(inp_name);
    id=document.getElementById(inp_id);
    console.log(inp);
  var currentFocus,sommedeslignedata;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      sommedeslignedata=0;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
        $.ajax({
        type: "POST",
        url: wr+"articles/listecodearticles/"+val,
        dataType : "JSON"
        }).done(function(data){
            sommedeslignedata=data.Articles.length;
            //console.log(sommedeslignedata);
            for (i = 0; i < data.Articles.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            //if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
              /*create a DIV element for each matching element:*/
              b = document.createElement("DIV");

              if(i===0){
              b.setAttribute("class", "option autocomplete-active");
              currentFocus++;
              }else{
              b.setAttribute("class", "option");
              }
              /*make the matching letters bold:*/
              //b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML = data.Articles[i]['Article']['code'];
              /*insert a input field that will hold the current array item's value:*/
              b.innerHTML += "<input type='hidden' value='" + data.Articles[i]['Article']['code']+ "'>";
              b.innerHTML += "<input type='hidden' value='" + data.Articles[i]['Article']['id']+"'>";
              /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  ///console.log(this.getElementsByTagName("input")[1].value);
                  inp.value = this.getElementsByTagName("input")[0].value;
                  id.value = this.getElementsByTagName("input")[1].value;
                  //alert(id.value);
                  /*close the list of autocompleted values,
                  (or any other open lists of autocompleted values:*/
                  closeAllLists();
                  if(id.value!=""){
                  articleidbl(index);
                  $('#quantite' + index).focus();
              }
              });
              a.appendChild(b);

            //}
            }
        });
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
//      console.log(currentFocus);
//      console.log(sommedeslignedata);


      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/

        if(currentFocus!=sommedeslignedata-1){
        currentFocus++;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        if(currentFocus!=0){
        currentFocus--;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
          articleidbl(index);
          $('#quantite' + index).focus();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  function setActiveOption  ( scroll, animate) {
            var height_menu, height_item, y;
            var scroll_top, scroll_bottom;
            var self = this;
            $option="div.option";
            $dropdown_content="div.autocomplete-items";
            $activeOption="div.option.autocomplete-active";
            //$('.div.option.autocomplete-active').removeClass('autocomplete-active');
            //$('.div.option.autocomplete-active') = null;
            //$option = $($option);
            //if (!$option.length) return;
            //self.$activeOption = $('.div.option').addClass('autocomplete-active');
            somme=0;
            if (scroll || !isset(scroll)) {
                aaaaa =80;
                height_menu = $('.autocomplete-items').height();
                //console.log("height_menu "+height_menu);
                height_item = $('.autocomplete-active').outerHeight();
                //console.log("height_item "+height_item);
                scroll = $('.autocomplete-items').scrollTop() || 0;
                //console.log("scroll "+scroll);
                var nav = $('.autocomplete-active');
                if (nav.length) {
                var contentNav = nav.offset().top;
                }
                var nav1 = $('.autocomplete-items');
                if (nav1.length) {
                var contentNav1 = nav1.offset().top;
                }
                y = contentNav - contentNav1 + scroll;
                //console.log("y "+y);
                scroll_top = y;
                scroll_bottom = y - (height_menu-80) + height_item;
                //console.log("scroll_bottom "+scroll_bottom);
                somme= (y + height_item) - ((height_menu - 80) + scroll);
                //console.log("7esba  "+somme );
                if (y + height_item > (height_menu - 80) + scroll) {
                    //console.log("1++++++++++++");
                    //console.log("scroll_bottom "+scroll_bottom);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_bottom}, animate ? 80 : 0);
                } else if (y !== scroll) {
                    if (y < scroll+10) {
                    //console.log("2++++++++++++");
                    //console.log("scroll_top "+scroll_top);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_top-100}, animate ? 150 : 0);
                }}
//console.log("*****************************************");
            }
        }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}
function autocomplete_designationarticles(inp_name,inp_id,index) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
    inp=document.getElementById(inp_name);
    id=document.getElementById(inp_id);
    console.log(inp);
  var currentFocus,sommedeslignedata;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      sommedeslignedata=0;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
        $.ajax({
        type: "POST",
        url: wr+"articles/listearticles/"+val,
        dataType : "JSON"
        }).done(function(data){
            sommedeslignedata=data.Articles.length;
            console.log(sommedeslignedata);
            for (i = 0; i < data.Articles.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            //if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
              /*create a DIV element for each matching element:*/
              b = document.createElement("DIV");

              if(i===0){
              b.setAttribute("class", "option autocomplete-active");
              currentFocus++;
              }else{
              b.setAttribute("class", "option");
              }
              /*make the matching letters bold:*/
              //b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML = data.Articles[i]['Article']['name'];
              /*insert a input field that will hold the current array item's value:*/
              b.innerHTML += "<input type='hidden' value='" + data.Articles[i]['Article']['name']+ "'>";
              b.innerHTML += "<input type='hidden' value='" + data.Articles[i]['Article']['id']+"'>";
              /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  ///console.log(this.getElementsByTagName("input")[1].value);
                  inp.value = this.getElementsByTagName("input")[0].value;
                  id.value = this.getElementsByTagName("input")[1].value;
                  articleidbl(index);
                  /*close the list of autocompleted values,
                  (or any other open lists of autocompleted values:*/
                  closeAllLists();
                  if(id.value!=""){
                  articleidbl(index);
                  $('#quantite' + index).focus();
                  }
              });
              a.appendChild(b);
            //}
            }
        });
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
//      console.log(currentFocus);
//      console.log(sommedeslignedata);


      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/

        if(currentFocus!=sommedeslignedata-1){
        currentFocus++;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        if(currentFocus!=0){
        currentFocus--;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        articleidbl(index);
        $('#quantite' + index).focus();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  function setActiveOption  ( scroll, animate) {
            var height_menu, height_item, y;
            var scroll_top, scroll_bottom;
            var self = this;
            $option="div.option";
            $dropdown_content="div.autocomplete-items";
            $activeOption="div.option.autocomplete-active";
            //$('.div.option.autocomplete-active').removeClass('autocomplete-active');
            //$('.div.option.autocomplete-active') = null;
            //$option = $($option);
            //if (!$option.length) return;
            //self.$activeOption = $('.div.option').addClass('autocomplete-active');
            somme=0;
            if (scroll || !isset(scroll)) {
                aaaaa =80;
                height_menu = $('.autocomplete-items').height();
                //console.log("height_menu "+height_menu);
                height_item = $('.autocomplete-active').outerHeight();
                //console.log("height_item "+height_item);
                scroll = $('.autocomplete-items').scrollTop() || 0;
                //console.log("scroll "+scroll);
                var nav = $('.autocomplete-active');
                if (nav.length) {
                var contentNav = nav.offset().top;
                }
                var nav1 = $('.autocomplete-items');
                if (nav1.length) {
                var contentNav1 = nav1.offset().top;
                }
                y = contentNav - contentNav1 + scroll;
                //console.log("y "+y);
                scroll_top = y;
                scroll_bottom = y - (height_menu-80) + height_item;
                //console.log("scroll_bottom "+scroll_bottom);
                somme= (y + height_item) - ((height_menu - 80) + scroll);
                //console.log("7esba  "+somme );
                if (y + height_item > (height_menu - 80) + scroll) {
                    //console.log("1++++++++++++");
                    //console.log("scroll_bottom "+scroll_bottom);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_bottom}, animate ? 80 : 0);
                } else if (y !== scroll) {
                    if (y < scroll+10) {
                    //console.log("2++++++++++++");
                    //console.log("scroll_top "+scroll_top);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_top-100}, animate ? 150 : 0);
                }}
//console.log("*****************************************");
            }
        }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

function autocomplete_index_codearticles(inp_name,inp_id,index) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
    inp=document.getElementById(inp_name);
    id=document.getElementById(inp_id);
    console.log(inp);
  var currentFocus,sommedeslignedata;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      sommedeslignedata=0;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      //a.setAttribute("style", "left: 218px;");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
        $.ajax({
        type: "POST",
        data: {
            val: val

        },
        url: wr+"articles/index_listecodearticles/",
        dataType : "JSON"
        }).done(function(data){
            sommedeslignedata=data.Articles.length;
            //console.log(sommedeslignedata);
            for (i = 0; i < data.Articles.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            //if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
              /*create a DIV element for each matching element:*/
              b = document.createElement("DIV");

              if(i===0){
              b.setAttribute("class", "option autocomplete-active");
              currentFocus++;
              }else{
              b.setAttribute("class", "option");

              }
              /*make the matching letters bold:*/
              //b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML = data.Articles[i]['Article']['code'];
              /*insert a input field that will hold the current array item's value:*/
              b.innerHTML += "<input type='hidden' value='" + data.Articles[i]['Article']['code']+ "'>";
              b.innerHTML += "<input type='hidden' value='" + data.Articles[i]['Article']['id']+"'>";
              /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  ///console.log(this.getElementsByTagName("input")[1].value);
                  inp.value = this.getElementsByTagName("input")[0].value;
                  id.value = this.getElementsByTagName("input")[1].value;
                  //alert(id.value);
                  /*close the list of autocompleted values,
                  (or any other open lists of autocompleted values:*/
                  closeAllLists();
                  if(id.value!=""){
                  detailarticle(this.getElementsByTagName("input")[1].value,index);
              }
              });
              a.appendChild(b);

            //}
            }
        });
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
//      console.log(currentFocus);
//      console.log(sommedeslignedata);


      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/

        if(currentFocus!=sommedeslignedata-1){
        currentFocus++;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        if(currentFocus!=0){
        currentFocus--;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
          articleidbl(index);
          $('#quantite' + index).focus();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  function setActiveOption  ( scroll, animate) {
            var height_menu, height_item, y;
            var scroll_top, scroll_bottom;
            var self = this;
            $option="div.option";
            $dropdown_content="div.autocomplete-items";
            $activeOption="div.option.autocomplete-active";
            //$('.div.option.autocomplete-active').removeClass('autocomplete-active');
            //$('.div.option.autocomplete-active') = null;
            //$option = $($option);
            //if (!$option.length) return;
            //self.$activeOption = $('.div.option').addClass('autocomplete-active');
            somme=0;
            if (scroll || !isset(scroll)) {
                aaaaa =80;
                height_menu = $('.autocomplete-items').height();
                //console.log("height_menu "+height_menu);
                height_item = $('.autocomplete-active').outerHeight();
                //console.log("height_item "+height_item);
                scroll = $('.autocomplete-items').scrollTop() || 0;
                //console.log("scroll "+scroll);
                var nav = $('.autocomplete-active');
                if (nav.length) {
                var contentNav = nav.offset().top;
                }
                var nav1 = $('.autocomplete-items');
                if (nav1.length) {
                var contentNav1 = nav1.offset().top;
                }
                y = contentNav - contentNav1 + scroll;
                //console.log("y "+y);
                scroll_top = y;
                scroll_bottom = y - (height_menu-80) + height_item;
                //console.log("scroll_bottom "+scroll_bottom);
                somme= (y + height_item) - ((height_menu - 80) + scroll);
                //console.log("7esba  "+somme );
                if (y + height_item > (height_menu - 80) + scroll) {
                    //console.log("1++++++++++++");
                    //console.log("scroll_bottom "+scroll_bottom);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_bottom}, animate ? 80 : 0);
                } else if (y !== scroll) {
                    if (y < scroll+10) {
                    //console.log("2++++++++++++");
                    //console.log("scroll_top "+scroll_top);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_top-100}, animate ? 150 : 0);
                }}
//console.log("*****************************************");
            }
        }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}
function autocomplete_index_designationarticles(inp_name,inp_id,index) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
    inp=document.getElementById(inp_name);
    id=document.getElementById(inp_id);
    console.log(inp);
  var currentFocus,sommedeslignedata;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      sommedeslignedata=0;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      //a.setAttribute("style", "left: 218px;");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
        $.ajax({
        type: "POST",
        data: {
            val: val
        },
        url: wr+"articles/index_listearticles/",
        async: true,
        dataType : "JSON"
        }).done(function(data){
            sommedeslignedata=data.Articles.length;
            //console.log(sommedeslignedata);
            for (i = 0; i < data.Articles.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            //if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
              /*create a DIV element for each matching element:*/
              b = document.createElement("DIV");

              if(i===0){
              b.setAttribute("class", "option autocomplete-active");
              currentFocus++;
              }else{
              b.setAttribute("class", "option");
              }
              /*make the matching letters bold:*/
              //b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML = data.Articles[i]['Article']['name'];
              /*insert a input field that will hold the current array item's value:*/
              b.innerHTML += "<input type='hidden' value='" + data.Articles[i]['Article']['name']+ "'>";
              b.innerHTML += "<input type='hidden' value='" + data.Articles[i]['Article']['id']+"'>";
              /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  ///console.log(this.getElementsByTagName("input")[1].value);
                  inp.value = this.getElementsByTagName("input")[0].value;
                  id.value = this.getElementsByTagName("input")[1].value;
                  articleidbl(index);
                  /*close the list of autocompleted values,
                  (or any other open lists of autocompleted values:*/
                  closeAllLists();
                  if(id.value!=""){
                  detailarticle(this.getElementsByTagName("input")[1].value,index);
                  }
              });
              a.appendChild(b);
            //}
            }
        });
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
//      console.log(currentFocus);
//      console.log(sommedeslignedata);


      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/

        if(currentFocus!=sommedeslignedata-1){
        currentFocus++;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        if(currentFocus!=0){
        currentFocus--;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        articleidbl(index);
        $('#quantite' + index).focus();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  function setActiveOption  ( scroll, animate) {
            var height_menu, height_item, y;
            var scroll_top, scroll_bottom;
            var self = this;
            $option="div.option";
            $dropdown_content="div.autocomplete-items";
            $activeOption="div.option.autocomplete-active";
            //$('.div.option.autocomplete-active').removeClass('autocomplete-active');
            //$('.div.option.autocomplete-active') = null;
            //$option = $($option);
            //if (!$option.length) return;
            //self.$activeOption = $('.div.option').addClass('autocomplete-active');
            somme=0;
            if (scroll || !isset(scroll)) {
                aaaaa =80;
                height_menu = $('.autocomplete-items').height();
                //console.log("height_menu "+height_menu);
                height_item = $('.autocomplete-active').outerHeight();
                //console.log("height_item "+height_item);
                scroll = $('.autocomplete-items').scrollTop() || 0;
                //console.log("scroll "+scroll);
                var nav = $('.autocomplete-active');
                if (nav.length) {
                var contentNav = nav.offset().top;
                }
                var nav1 = $('.autocomplete-items');
                if (nav1.length) {
                var contentNav1 = nav1.offset().top;
                }
                y = contentNav - contentNav1 + scroll;
                //console.log("y "+y);
                scroll_top = y;
                scroll_bottom = y - (height_menu-80) + height_item;
                //console.log("scroll_bottom "+scroll_bottom);
                somme= (y + height_item) - ((height_menu - 80) + scroll);
                //console.log("7esba  "+somme );
                if (y + height_item > (height_menu - 80) + scroll) {
                    //console.log("1++++++++++++");
                    //console.log("scroll_bottom "+scroll_bottom);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_bottom}, animate ? 80 : 0);
                } else if (y !== scroll) {
                    if (y < scroll+10) {
                    //console.log("2++++++++++++");
                    //console.log("scroll_top "+scroll_top);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_top-100}, animate ? 150 : 0);
                }}
//console.log("*****************************************");
            }
        }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}
function detailarticle(article_id,index) {
    $.ajax({
        type: "POST",
        url: wr + "Articles/detailarticles/" + article_id,
        dataType: "json",
        global: false
    }).done(function (data) {
        $('#code' + index).val("");
        $('#designation' + index).val("");
        if (Number(article_id) != 0) {
            $('#code' + index).val(data.code);
            $('#designation' + index).val(data.des);
        }
    })
}

function autocomplete_name_clients(inp_name,inp_id) {//alert();
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
    inp=document.getElementById(inp_name);
    id=document.getElementById(inp_id);
  var currentFocus,sommedeslignedata;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      sommedeslignedata=0;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      //a.setAttribute("style", "left: 218px;");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
        $.ajax({
        type: "POST",
        data: {
            val: val
        },
        url: wr+"clients/listeclients/",
        async: true,
        dataType : "JSON"
        }).done(function(data){
            sommedeslignedata=data.Clients.length;
            //console.log(sommedeslignedata);
            for (i = 0; i < data.Clients.length; i++) {
              b = document.createElement("DIV");
              if(i===0){
              b.setAttribute("class", "option autocomplete-active");
              currentFocus++;
              }else{
              b.setAttribute("class", "option");
              }
              /*make the matching letters bold:*/
              //b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML = data.Clients[i]['Client']['code']+" "+data.Clients[i]['Client']['name'];
              /*insert a input field that will hold the current array item's value:*/
              b.innerHTML += "<input type='hidden' value='" + data.Clients[i]['Client']['code']+" "+data.Clients[i]['Client']['name']+ "'>";
              b.innerHTML += "<input type='hidden' value='" + data.Clients[i]['Client']['id']+"'>";
              /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  ///console.log(this.getElementsByTagName("input")[1].value);
                  inp.value = this.getElementsByTagName("input")[0].value;
                  id.value = this.getElementsByTagName("input")[1].value;
                  closeAllLists();
                  if(id.value!=""){
                  infoclientbb(this.getElementsByTagName("input")[1].value);
                  }
              });
              a.appendChild(b);
            //}
            }
        });
  });
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
//      console.log(currentFocus);
//      console.log(sommedeslignedata);


      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/

        if(currentFocus!=sommedeslignedata-1){
        currentFocus++;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        if(currentFocus!=0){
        currentFocus--;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();

        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  function setActiveOption  ( scroll, animate) {
            var height_menu, height_item, y;
            var scroll_top, scroll_bottom;
            var self = this;
            $option="div.option";
            $dropdown_content="div.autocomplete-items";
            $activeOption="div.option.autocomplete-active";
            //$('.div.option.autocomplete-active').removeClass('autocomplete-active');
            //$('.div.option.autocomplete-active') = null;
            //$option = $($option);
            //if (!$option.length) return;
            //self.$activeOption = $('.div.option').addClass('autocomplete-active');
            somme=0;
            if (scroll || !isset(scroll)) {
                aaaaa =80;
                height_menu = $('.autocomplete-items').height();
                //console.log("height_menu "+height_menu);
                height_item = $('.autocomplete-active').outerHeight();
                //console.log("height_item "+height_item);
                scroll = $('.autocomplete-items').scrollTop() || 0;
                //console.log("scroll "+scroll);
                var nav = $('.autocomplete-active');
                if (nav.length) {
                var contentNav = nav.offset().top;
                }
                var nav1 = $('.autocomplete-items');
                if (nav1.length) {
                var contentNav1 = nav1.offset().top;
                }
                y = contentNav - contentNav1 + scroll;
                //console.log("y "+y);
                scroll_top = y;
                scroll_bottom = y - (height_menu-80) + height_item;
                //console.log("scroll_bottom "+scroll_bottom);
                somme= (y + height_item) - ((height_menu - 80) + scroll);
                //console.log("7esba  "+somme );
                if (y + height_item > (height_menu - 80) + scroll) {
                    //console.log("1++++++++++++");
                    //console.log("scroll_bottom "+scroll_bottom);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_bottom}, animate ? 80 : 0);
                } else if (y !== scroll) {
                    if (y < scroll+10) {
                    //console.log("2++++++++++++");
                    //console.log("scroll_top "+scroll_top);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_top-100}, animate ? 150 : 0);
                }}
//console.log("*****************************************");
            }
        }
  document.addEventListener("click", function (e) {//alert();
      closeAllLists(e.target);
  });
}
function autocomplete_matriculefiscale_clients(inp_name,inp_id) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
    inp=document.getElementById(inp_name);
    id=document.getElementById(inp_id);
  var currentFocus,sommedeslignedata;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      sommedeslignedata=0;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      //a.setAttribute("style", "left: 218px;");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
        $.ajax({
        type: "POST",
        data: {
            val: val
        },
        url: wr+"clients/listematriculefiscaleclients/",
        async: true,
        dataType : "JSON"
        }).done(function(data){
            sommedeslignedata=data.Clients.length;
            //console.log(data.Clients);
            for (i = 0; i < data.Clients.length; i++) {
              b = document.createElement("DIV");
              if(i===0){
              b.setAttribute("class", "option autocomplete-active");
              currentFocus++;
              }else{
              b.setAttribute("class", "option");
              }
              /*make the matching letters bold:*/
              //b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML = data.Clients[i]['Client']['matriculefiscale'];
              /*insert a input field that will hold the current array item's value:*/
              b.innerHTML += "<input type='hidden' value='" + data.Clients[i]['Client']['matriculefiscale']+ "'>";
              b.innerHTML += "<input type='hidden' value='" + data.Clients[i]['Client']['id']+"'>";
              /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  ///console.log(this.getElementsByTagName("input")[1].value);
                  inp.value = this.getElementsByTagName("input")[0].value;
                  id.value = this.getElementsByTagName("input")[1].value;
                  closeAllLists();
                  if(id.value!=""){
                  infoclientbb(this.getElementsByTagName("input")[1].value);
                  }
              });
              a.appendChild(b);
            //}
            }
        });
  });
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
//      console.log(currentFocus);
//      console.log(sommedeslignedata);


      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/

        if(currentFocus!=sommedeslignedata-1){
        currentFocus++;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        if(currentFocus!=0){
        currentFocus--;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();

        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  function setActiveOption  ( scroll, animate) {
            var height_menu, height_item, y;
            var scroll_top, scroll_bottom;
            var self = this;
            $option="div.option";
            $dropdown_content="div.autocomplete-items";
            $activeOption="div.option.autocomplete-active";
            //$('.div.option.autocomplete-active').removeClass('autocomplete-active');
            //$('.div.option.autocomplete-active') = null;
            //$option = $($option);
            //if (!$option.length) return;
            //self.$activeOption = $('.div.option').addClass('autocomplete-active');
            somme=0;
            if (scroll || !isset(scroll)) {
                aaaaa =80;
                height_menu = $('.autocomplete-items').height();
                //console.log("height_menu "+height_menu);
                height_item = $('.autocomplete-active').outerHeight();
                //console.log("height_item "+height_item);
                scroll = $('.autocomplete-items').scrollTop() || 0;
                //console.log("scroll "+scroll);
                var nav = $('.autocomplete-active');
                if (nav.length) {
                var contentNav = nav.offset().top;
                }
                var nav1 = $('.autocomplete-items');
                if (nav1.length) {
                var contentNav1 = nav1.offset().top;
                }
                y = contentNav - contentNav1 + scroll;
                //console.log("y "+y);
                scroll_top = y;
                scroll_bottom = y - (height_menu-80) + height_item;
                //console.log("scroll_bottom "+scroll_bottom);
                somme= (y + height_item) - ((height_menu - 80) + scroll);
                //console.log("7esba  "+somme );
                if (y + height_item > (height_menu - 80) + scroll) {
                    //console.log("1++++++++++++");
                    //console.log("scroll_bottom "+scroll_bottom);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_bottom}, animate ? 80 : 0);
                } else if (y !== scroll) {
                    if (y < scroll+10) {
                    //console.log("2++++++++++++");
                    //console.log("scroll_top "+scroll_top);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_top-100}, animate ? 150 : 0);
                }}
//console.log("*****************************************");
            }
        }
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}
function infoclientbb(client_id) {
	//alert("aaaa")
        $('#divreleve').html("");
        $('#valreste').val("");
        page = $('#page').val() || 0;
        $.ajax({
            type: "POST",
            data: {
                id: client_id,
            },
            url: wr + "Bonlivraisons/getclients/",
            dataType: "json",
            async: true,
            global: false //}l'envoie'
        }).done(function (data) {
			//alert(data.vente);
			if(data.vente=='detail'){
				$("#optionsRadios11").prop("checked", true);
				$("#optionsRadios12").prop("checked", false);
			}else{
				$("#optionsRadios12").prop("checked", true);
				$("#optionsRadios11").prop("checked", false);
			}
			if (data.Factureclients+data.piecereglements > 0  && (page=="Factureclient" || page=="Bonlivraison")) {
            if(data.modeclient==2){
          //  $('#clientname').val("");
            // $('#client_id').val("");
            $('.message').html('ce client possède <strong>'+data.Factureclients+'</strong> facture(s) non réglée(s) et '+data.piecereglements+' impayé(s) avant la date <strong>'+data.date_first_day+'</strong><br> pour vérifer ,veuillez cliquer sur ce <a TARGET=_BLANK href="'+wr+'Recouvrements/index/'+client_id+'"><strong>lien</strong></a> ', function () {});
            return false
            }else{
            if(data.avectimbreid=='Non'){
                $('#timbre').val('0');
            }
           //alert(data.vente);
alert('3');
            $('#adresse').val(data.adresse);
            $('#clientname').val(data.name);
            $('#name').val(data.name);
            $('#auto').val(data.autor);
            $('#solde').val(data.solde.toFixed(3));
            $('#valreste').val(data.valreste.toFixed(3));
            if(data.typeclientid==null){
            data.typeclientid=1;
            }
            $('#typeclientid').val(data.typeclientid);
            if(data.typeclientid==1){
            $("#Assujettis").prop("checked", true);
            $("#Exoneres").prop("checked", false);
            }else{
            $("#Exoneres").prop("checked", true);
            $("#Assujettis").prop("checked", false);
            }
				if(data.vente=='detail'){
					$("#optionsRadios11").prop("checked", true);
					$("#optionsRadios12").prop("checked", false);
				}else{
					$("#optionsRadios12").prop("checked", true);
					$("#optionsRadios11").prop("checked", false);
				}
            $('#matriculefiscale').val(data.matriculefiscale);
            $('#divreleve').html('<a onClick="flvFPW1(\'' + wr + 'Releves/index/'+client_id+'\' ,\'UPLOAD\', \'width=1800,height=800,scrollbars=yes\', 0, 2, 2 ); return document.MM_returnValue;" href=\'javascript:;\'  ><button class=\'btn btn-xs ls-blue-btn\'> <i class=\'fa fa-usd\'></i> </button></a>');

            }
            }else{
            if(data.avectimbreid=='Non'){
                $('#timbre').val('0');
            }
            $('#adresse').val(data.adresse);
            $('#clientname').val(data.name); alert('s');
            $('#name').val(data.name);
            $('#auto').val(data.autor);
            $('#solde').val(data.solde.toFixed(3));
            $('#valreste').val(data.valreste.toFixed(3));
            if(data.typeclientid==null){
            data.typeclientid=1;
            }
            $('#typeclientid').val(data.typeclientid);
            if(data.typeclientid==1){
            $("#Assujettis").prop("checked", true);
            $("#Exoneres").prop("checked", false);
            }else{
            $("#Exoneres").prop("checked", true);
            $("#Assujettis").prop("checked", false);
            }
            $('#matriculefiscale').val(data.matriculefiscale);
            $('#divreleve').html('<a onClick="flvFPW1(\'' + wr + 'Releves/index/'+client_id+'\' ,\'UPLOAD\', \'width=1800,height=800,scrollbars=yes\', 0, 2, 2 ); return document.MM_returnValue;" href=\'javascript:;\'  ><button class=\'btn btn-xs ls-blue-btn\'> <i class=\'fa fa-usd\'></i> </button></a>');
        }
        })
        }

function autocomplete_numero_bls(inp_name,inp_id) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
    inp=document.getElementById(inp_name);
    id=document.getElementById(inp_id);
  var currentFocus,sommedeslignedata;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      sommedeslignedata=0;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      //a.setAttribute("style", "left: 218px;");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
        $.ajax({
        type: "POST",
        data: {
            val: val
        },
        url: wr+"bonlivraisons/numerobl_autocomplete/",
        async: true,
        dataType : "JSON"
        }).done(function(data){
            sommedeslignedata=data.bonlivraisons.length;
            //console.log(sommedeslignedata);
            for (i = 0; i < data.bonlivraisons.length; i++) {
              b = document.createElement("DIV");
              if(i===0){
              b.setAttribute("class", "option autocomplete-active");
              currentFocus++;
              }else{
              b.setAttribute("class", "option");
              }
              /*make the matching letters bold:*/
              //b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML = data.bonlivraisons[i]['Bonlivraison']['numero'];
              /*insert a input field that will hold the current array item's value:*/
              b.innerHTML += "<input type='hidden' value='" + data.bonlivraisons[i]['Bonlivraison']['numero']+ "'>";
              b.innerHTML += "<input type='hidden' value='" + data.bonlivraisons[i]['Bonlivraison']['id']+"'>";
              /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  ///console.log(this.getElementsByTagName("input")[1].value);
                  inp.value = this.getElementsByTagName("input")[0].value;
                  id.value = this.getElementsByTagName("input")[1].value;
                  closeAllLists();
                  if(id.value!=""){
                  infoclientbb(this.getElementsByTagName("input")[1].value);
                  }
              });
              a.appendChild(b);
            //}
            }
        });
  });
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
//      console.log(currentFocus);
//      console.log(sommedeslignedata);


      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/

        if(currentFocus!=sommedeslignedata-1){
        currentFocus++;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        if(currentFocus!=0){
        currentFocus--;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();

        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  function setActiveOption  ( scroll, animate) {
            var height_menu, height_item, y;
            var scroll_top, scroll_bottom;
            var self = this;
            $option="div.option";
            $dropdown_content="div.autocomplete-items";
            $activeOption="div.option.autocomplete-active";
            //$('.div.option.autocomplete-active').removeClass('autocomplete-active');
            //$('.div.option.autocomplete-active') = null;
            //$option = $($option);
            //if (!$option.length) return;
            //self.$activeOption = $('.div.option').addClass('autocomplete-active');
            somme=0;
            if (scroll || !isset(scroll)) {
                aaaaa =80;
                height_menu = $('.autocomplete-items').height();
                //console.log("height_menu "+height_menu);
                height_item = $('.autocomplete-active').outerHeight();
                //console.log("height_item "+height_item);
                scroll = $('.autocomplete-items').scrollTop() || 0;
                //console.log("scroll "+scroll);
                var nav = $('.autocomplete-active');
                if (nav.length) {
                var contentNav = nav.offset().top;
                }
                var nav1 = $('.autocomplete-items');
                if (nav1.length) {
                var contentNav1 = nav1.offset().top;
                }
                y = contentNav - contentNav1 + scroll;
                //console.log("y "+y);
                scroll_top = y;
                scroll_bottom = y - (height_menu-80) + height_item;
                //console.log("scroll_bottom "+scroll_bottom);
                somme= (y + height_item) - ((height_menu - 80) + scroll);
                //console.log("7esba  "+somme );
                if (y + height_item > (height_menu - 80) + scroll) {
                    //console.log("1++++++++++++");
                    //console.log("scroll_bottom "+scroll_bottom);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_bottom}, animate ? 80 : 0);
                } else if (y !== scroll) {
                    if (y < scroll+10) {
                    //console.log("2++++++++++++");
                    //console.log("scroll_top "+scroll_top);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_top-100}, animate ? 150 : 0);
                }}
//console.log("*****************************************");
            }
        }
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}
function autocomplete_numero_facs(inp_name,inp_id) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
    inp=document.getElementById(inp_name);
    id=document.getElementById(inp_id);
  var currentFocus,sommedeslignedata;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      sommedeslignedata=0;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      //a.setAttribute("style", "left: 218px;");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
        $.ajax({
        type: "POST",
        data: {
            val: val
        },
        url: wr+"factureclients/numerofac_autocomplete/",
        async: true,
        dataType : "JSON"
        }).done(function(data){
            sommedeslignedata=data.factureclients.length;
            //console.log(sommedeslignedata);
            for (i = 0; i < data.factureclients.length; i++) {
              b = document.createElement("DIV");
              if(i===0){
              b.setAttribute("class", "option autocomplete-active");
              currentFocus++;
              }else{
              b.setAttribute("class", "option");
              }
              /*make the matching letters bold:*/
              //b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML = data.factureclients[i]['Factureclient']['numero'];
              /*insert a input field that will hold the current array item's value:*/
              b.innerHTML += "<input type='hidden' value='" + data.factureclients[i]['Factureclient']['numero']+ "'>";
              b.innerHTML += "<input type='hidden' value='" + data.factureclients[i]['Factureclient']['id']+"'>";
              /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  ///console.log(this.getElementsByTagName("input")[1].value);
                  inp.value = this.getElementsByTagName("input")[0].value;
                  id.value = this.getElementsByTagName("input")[1].value;
                  closeAllLists();
                  if(id.value!=""){
                  infoclientbb(this.getElementsByTagName("input")[1].value);
                  }
              });
              a.appendChild(b);
            //}
            }
        });
  });
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
//      console.log(currentFocus);
//      console.log(sommedeslignedata);


      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/

        if(currentFocus!=sommedeslignedata-1){
        currentFocus++;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        if(currentFocus!=0){
        currentFocus--;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();

        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  function setActiveOption  ( scroll, animate) {
            var height_menu, height_item, y;
            var scroll_top, scroll_bottom;
            var self = this;
            $option="div.option";
            $dropdown_content="div.autocomplete-items";
            $activeOption="div.option.autocomplete-active";
            //$('.div.option.autocomplete-active').removeClass('autocomplete-active');
            //$('.div.option.autocomplete-active') = null;
            //$option = $($option);
            //if (!$option.length) return;
            //self.$activeOption = $('.div.option').addClass('autocomplete-active');
            somme=0;
            if (scroll || !isset(scroll)) {
                aaaaa =80;
                height_menu = $('.autocomplete-items').height();
                //console.log("height_menu "+height_menu);
                height_item = $('.autocomplete-active').outerHeight();
                //console.log("height_item "+height_item);
                scroll = $('.autocomplete-items').scrollTop() || 0;
                //console.log("scroll "+scroll);
                var nav = $('.autocomplete-active');
                if (nav.length) {
                var contentNav = nav.offset().top;
                }
                var nav1 = $('.autocomplete-items');
                if (nav1.length) {
                var contentNav1 = nav1.offset().top;
                }
                y = contentNav - contentNav1 + scroll;
                //console.log("y "+y);
                scroll_top = y;
                scroll_bottom = y - (height_menu-80) + height_item;
                //console.log("scroll_bottom "+scroll_bottom);
                somme= (y + height_item) - ((height_menu - 80) + scroll);
                //console.log("7esba  "+somme );
                if (y + height_item > (height_menu - 80) + scroll) {
                    //console.log("1++++++++++++");
                    //console.log("scroll_bottom "+scroll_bottom);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_bottom}, animate ? 80 : 0);
                } else if (y !== scroll) {
                    if (y < scroll+10) {
                    //console.log("2++++++++++++");
                    //console.log("scroll_top "+scroll_top);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_top-100}, animate ? 150 : 0);
                }}
//console.log("*****************************************");
            }
        }
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}
function autocomplete_name_clients_reg(inp_name,inp_id,page) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
    inp=document.getElementById(inp_name);
    id=document.getElementById(inp_id);
  var currentFocus,sommedeslignedata;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      sommedeslignedata=0;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      //a.setAttribute("style", "left: 218px;");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
        $.ajax({
        type: "POST",
        data: {
            val: val
        },
        url: wr+"clients/listeclients/",
        async: true,
        dataType : "JSON"
        }).done(function(data){
            sommedeslignedata=data.Clients.length;
            //console.log(sommedeslignedata);
            for (i = 0; i < data.Clients.length; i++) {
              b = document.createElement("DIV");
              if(i===0){
              b.setAttribute("class", "option autocomplete-active");
              currentFocus++;
              }else{
              b.setAttribute("class", "option");
              }
              /*make the matching letters bold:*/
              //b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML = data.Clients[i]['Client']['code']+" "+data.Clients[i]['Client']['name'];
              /*insert a input field that will hold the current array item's value:*/
              b.innerHTML += "<input type='hidden' value='" + data.Clients[i]['Client']['code']+" "+data.Clients[i]['Client']['name']+ "'>";
              b.innerHTML += "<input type='hidden' value='" + data.Clients[i]['Client']['id']+"'>";
              /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  ///console.log(this.getElementsByTagName("input")[1].value);
                  inp.value = this.getElementsByTagName("input")[0].value;
                  id.value = this.getElementsByTagName("input")[1].value;
                  closeAllLists();
                  if(id.value!=""){
                  if(page !="index_reglementclient"){
                  redirection_reglement_client(this.getElementsByTagName("input")[1].value);
                  }
                  }
              });
              a.appendChild(b);
            //}
            }
        });
  });
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
//      console.log(currentFocus);
//      console.log(sommedeslignedata);


      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/

        if(currentFocus!=sommedeslignedata-1){
        currentFocus++;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        if(currentFocus!=0){
        currentFocus--;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();

        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  function setActiveOption  ( scroll, animate) {
            var height_menu, height_item, y;
            var scroll_top, scroll_bottom;
            var self = this;
            $option="div.option";
            $dropdown_content="div.autocomplete-items";
            $activeOption="div.option.autocomplete-active";
            //$('.div.option.autocomplete-active').removeClass('autocomplete-active');
            //$('.div.option.autocomplete-active') = null;
            //$option = $($option);
            //if (!$option.length) return;
            //self.$activeOption = $('.div.option').addClass('autocomplete-active');
            somme=0;
            if (scroll || !isset(scroll)) {
                aaaaa =80;
                height_menu = $('.autocomplete-items').height();
                //console.log("height_menu "+height_menu);
                height_item = $('.autocomplete-active').outerHeight();
                //console.log("height_item "+height_item);
                scroll = $('.autocomplete-items').scrollTop() || 0;
                //console.log("scroll "+scroll);
                var nav = $('.autocomplete-active');
                if (nav.length) {
                var contentNav = nav.offset().top;
                }
                var nav1 = $('.autocomplete-items');
                if (nav1.length) {
                var contentNav1 = nav1.offset().top;
                }
                y = contentNav - contentNav1 + scroll;
                //console.log("y "+y);
                scroll_top = y;
                scroll_bottom = y - (height_menu-80) + height_item;
                //console.log("scroll_bottom "+scroll_bottom);
                somme= (y + height_item) - ((height_menu - 80) + scroll);
                //console.log("7esba  "+somme );
                if (y + height_item > (height_menu - 80) + scroll) {
                    //console.log("1++++++++++++");
                    //console.log("scroll_bottom "+scroll_bottom);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_bottom}, animate ? 80 : 0);
                } else if (y !== scroll) {
                    if (y < scroll+10) {
                    //console.log("2++++++++++++");
                    //console.log("scroll_top "+scroll_top);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_top-100}, animate ? 150 : 0);
                }}
//console.log("*****************************************");
            }
        }
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}
function redirection_reglement_client(client_id){
pointdevente_id=$('#pointdevente_id').val()||0;
personnel_id=$('#personnel_id').val()||0;
if(client_id!=0)
$(location).attr('href',wr+"Reglementclients/add/"+client_id+"/"+pointdevente_id+"/"+personnel_id);
}

function autocomplete_name_liste_clients(inp_name,inp_id,page) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
    inp=document.getElementById(inp_name);
    id=document.getElementById(inp_id);
  var currentFocus,sommedeslignedata;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      sommedeslignedata=0;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      //a.setAttribute("style", "left: 218px;");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
        $.ajax({
        type: "POST",
        data: {
            val: val
        },
        url: wr+"clients/listeclients/",
        async: true,
        dataType : "JSON"
        }).done(function(data){
            sommedeslignedata=data.Clients.length;
            //console.log(sommedeslignedata);
            for (i = 0; i < data.Clients.length; i++) {
              b = document.createElement("DIV");
              if(i===0){
              b.setAttribute("class", "option autocomplete-active");
              currentFocus++;
              }else{
              b.setAttribute("class", "option");
              }
              /*make the matching letters bold:*/
              //b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML = data.Clients[i]['Client']['code']+" "+data.Clients[i]['Client']['name'];
              /*insert a input field that will hold the current array item's value:*/
              b.innerHTML += "<input type='hidden' value='" + data.Clients[i]['Client']['code']+" "+data.Clients[i]['Client']['name']+ "'>";
              b.innerHTML += "<input type='hidden' value='" + data.Clients[i]['Client']['id']+"'>";
              /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  ///console.log(this.getElementsByTagName("input")[1].value);
                  inp.value = this.getElementsByTagName("input")[0].value;
                  id.value = this.getElementsByTagName("input")[1].value;
                  closeAllLists();
                  if(id.value!=""){
                  if(page !="index_reglementclient"){
                  redirection_reglement_client(this.getElementsByTagName("input")[1].value);
                  }
                  }
              });
              a.appendChild(b);
            //}
            }
        });
  });
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
//      console.log(currentFocus);
//      console.log(sommedeslignedata);


      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/

        if(currentFocus!=sommedeslignedata-1){
        currentFocus++;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        if(currentFocus!=0){
        currentFocus--;
        setActiveOption  (true, true)
        addActive(x);
        }
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();

        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  function setActiveOption  ( scroll, animate) {
            var height_menu, height_item, y;
            var scroll_top, scroll_bottom;
            var self = this;
            $option="div.option";
            $dropdown_content="div.autocomplete-items";
            $activeOption="div.option.autocomplete-active";
            //$('.div.option.autocomplete-active').removeClass('autocomplete-active');
            //$('.div.option.autocomplete-active') = null;
            //$option = $($option);
            //if (!$option.length) return;
            //self.$activeOption = $('.div.option').addClass('autocomplete-active');
            somme=0;
            if (scroll || !isset(scroll)) {
                aaaaa =80;
                height_menu = $('.autocomplete-items').height();
                //console.log("height_menu "+height_menu);
                height_item = $('.autocomplete-active').outerHeight();
                //console.log("height_item "+height_item);
                scroll = $('.autocomplete-items').scrollTop() || 0;
                //console.log("scroll "+scroll);
                var nav = $('.autocomplete-active');
                if (nav.length) {
                var contentNav = nav.offset().top;
                }
                var nav1 = $('.autocomplete-items');
                if (nav1.length) {
                var contentNav1 = nav1.offset().top;
                }
                y = contentNav - contentNav1 + scroll;
                //console.log("y "+y);
                scroll_top = y;
                scroll_bottom = y - (height_menu-80) + height_item;
                //console.log("scroll_bottom "+scroll_bottom);
                somme= (y + height_item) - ((height_menu - 80) + scroll);
                //console.log("7esba  "+somme );
                if (y + height_item > (height_menu - 80) + scroll) {
                    //console.log("1++++++++++++");
                    //console.log("scroll_bottom "+scroll_bottom);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_bottom}, animate ? 80 : 0);
                } else if (y !== scroll) {
                    if (y < scroll+10) {
                    //console.log("2++++++++++++");
                    //console.log("scroll_top "+scroll_top);
                    $('.autocomplete-items').stop().animate({scrollTop: scroll_top-100}, animate ? 150 : 0);
                }}
//console.log("*****************************************");
            }
        }
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}
