$(document).ready(function ()
{
    amine = $('#amine').val();
    if (amine == 1) {
        calculfactureaminee();
    }
    $('.haithamcss').hide();
    $('.ajouterligne_haitham').on('click', function () {
        table = $(this).attr('table');
        index = $(this).attr('index');
        ajouterligne_haitham(table, index);
    });

    $('.suphai').on('click', function () {
        index = $(this).attr('index');
        $('.suphai').each(function () {
            ind = $(this).attr('index');
            if (ind == index) {
                //$(this).parent().parent().remove();
                $(this).parent().parent().hide();
                //$('#sup'+index).val(1);
                $('#sup' + index).val(1);
                calculeticket();
            }
        })
    });


    $('#optionsRadios11').on('change', function () {
        $('#vente').val('detail');
        conteur = $('#index').val() || 0;
        for (var i = 0; i <= conteur; i++) {
            if ($('#article_id' + i).val() || 0 != 0) {
                if ($('#sup' + i).val() || 0 != 1) {
                    articleidbl(i);
                }
            }
        }

    });


    $('#optionsRadios12').on('change', function () {
        $('#vente').val('gros');
        conteur = $('#index').val() || 0;
        for (var i = 0; i <= conteur; i++) {
            if ($('#article_id' + i).val() || 0 != 0) {
                if ($('#sup' + i).val() || 0 != 1) {
                    articleidbl(i);
                }
            }
        }
    });






    $('.calculeticket').on('keyup', function () {
        calculeticket();
    });

    // Vente
    $('.haithamcode').on('change', function () {
        //alert();
        index = $(this).attr('index');
        val = $(this).val();//alert(val);
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
//            alert(index);
            $('#designation' + index).val(data.des);
            if (data.reference != undefined) {
                $('#articlefrs_id' + index).val(data.reference);
            }
        });
        if ((page != 'transfert') && (page != 'indexarticle')) {
            findfamille(index);
        }
        if ((page != 'indexarticle')) {
            articleidbl(index);
        }
    });
    
    $('.changerprix').on('keyup', function () {
        index = $(this).attr('index') || 0; //alert(index);
        champ = $(this).attr('champ'); //alert('champ : '+champ);
        
        code=$('#code' + index).val()||0;
        if(code!=''){
        prixachatmarge=$('#prixachatmarge' + index).val()||0;
        maregbase=$('#margebase' + index).val()||0;
        margebaseorigine=$('#margebaseorigine' + index).val()||0;
        //alert('prixachatmarge : '+prixachatmarge);alert('maregbase : '+maregbase);alert('margebaseorigine : '+margebaseorigine);
        if(champ=='margebase'){
            PUHT=Number(prixachatmarge)*((1+Number(maregbase)/100));
           // alert('PUHT : '+PUHT);
            $('#prixhtva' + index).val(Number(PUHT).toFixed(3)); 
            $('#totalhtans' + index).val(Number(PUHT).toFixed(3)); 
            tva = $('#tva' + index).val()||0;
            remise = $('#remise' + index).val()||0;
            punht = Number(PUHT) * (1 - Number(remise / 100));
            puttc = punht * (1 + Number(tva / 100));
            $('#puttc' + index).val(puttc.toFixed(3));
            $('#prixnet' + index).val(punht.toFixed(3));
            //calculefacture();
        }
        if(champ!='margebase'){
            
            PNHT=$('#prixnet' + index).val()||0;
            
           if(prixachatmarge!=0){
            margenew=(Number(PNHT)-Number(prixachatmarge))/(Number(prixachatmarge))*100;
        }else{
           margenew=100; 
        }
            //alert('margenew : '+margenew);
            $('#margebase' + index).val(Number(margenew).toFixed(3));
            //calculefacture();
        }
        calculefacture();
    }
        
    });

    // Select semi automatique Vente
    $('.haithamselect').on('keyup', function () {
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
                        result1 = result1 + "<a class='option' id='" + dd.Article.id + "' style='text-decoration:none;z-index: 1000' href=\"javascript:setQuery1('" + dd.Article.id + "','" + escape(dd.Article.pmp) + "','" + index + "');\"><div class='aa'>"+ dd.Article.code +" " + dd.Article.name + "</div></a>";
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



    // Select semi automatique Achat
    $('.haithamselectachat').on('keyup', function () {
        val = $(this).val();//alert(val);
        index = $(this).attr('index') || 0;
        if (val.length > 2) {
            $('#res' + index).show();
            four = $('#fc').val() || 0;
            result1 = "";
            $.ajax({
                type: "POST",
                url: wr + "Articles/haithamselectachat/" + val + "/" + four,
                dataType: "JSON"
                        /*,
                         data: {
                         val: val,
                         four:four
                         }*/
            }).done(function (data) {

                $.each(data, function (i, item) {
                    $.each(item, function (i, dd) {
                        //alert('aaa');
                        console.log(dd);
                        //console.log(dd[0]);
                        dd[0].nom = dd[0].nom.replace("'", "`");
                        result1 = result1 + "<a class='option' id='" + dd[0].id + "' style='text-decoration:none;z-index: 1000' href=\"javascript:setQuery2('" + dd[0].id + "','" + dd[0].code.replace(/"/g, '1*2**1*2').replace(/'/g, '1*2**1*2') + "','" + escape(dd[0].nom).replace(/"/g, '1*2**1*2').replace(/'/g, '1*2**1*2') + "','" + index + "');\"><div class='aa'>" + dd[0].nom + "</div></a>";
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

    // Achat
    $('.haithamcodeachat').on('change', function () {
        //alert();
        index = $(this).attr('index');
        val = $(this).val();//alert(val);
        four = $('#fc').val() || 0;

        $.ajax({
            type: "POST",
            data: {
                val: val,
                four: four
            },
            url: wr + "Articles/codeachat/" + four,
            dataType: "json",
            async: false,
            global: false //}l'envoie'
        }).done(function (data) {
            console.log(data);
            if (data['id'] == 0) {
                bootbox.alert(" verifier l'article fourniseur !!", function () {});
                $('#article_id' + index).val('');
                $('#designation' + index).val('');
                $('#code' + index).val('');
                $('#code' + index).focus();
            }
            if (data['id'] != 0) {
                $('#article_id' + index).val(data.id);
                $('#designation' + index).val(data.des);
            }

        });
        tvaart(index);

    });



    // Transfert men bon transfert --> facture
    $('.abcde').on('click', function () {
        //alert();
        var table = $(this).parents('table').attr('id');
        var checkedStatus = this.checked;
        //alert(checkedStatus);
        var id = this.id;
        ligne = $(this).attr('ligne');
        //alert('ligne'+'---'+ligne);
        $('.bout').show();
        client = $('#client' + ligne).val();
        //alert(client);
        if ($('.tes').val() == 0) {
            $('.tes').val(client)
        }
        //alert('tes'+'---'+$('.tes').val());

        if (($('.tes').val() != client) && $('.tes').val() != 0) {
            alert('Il faut choisir des Transferts pour les mémes Societes et PV');
            checkedStatus = false;
            //$("#check"+i).attr("disabled", true);
            $(this).attr('checked', $("#check" + ligne).is(''));
            nb = nb + 1;

        }
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

    $('.checkartfrs').on('blur', function () {
        val = $(this).val();//alert(val);
        frs = $('#fc').val() || 0;

        index = $(this).attr('index') || 0;
        if (frs == 0) {
            bootbox.alert(" verifier le fourniseur !!", function () {});
            $('#articlefrs_id' + index).val("");
            return false;
        } else {
            $('#existe' + index).val('Non');
            $.ajax({
                type: "POST",
                url: wr + "Articles/checkartfrs/" + val + "/" + frs,
                dataType: "JSON",

            }).done(function (data) {
                if (Number(data.nb) > 0) {
                    console.log(data);
                    $('#existe' + index).val('Oui');
                    $('#code' + index).val(data.art.Article.code);
                    $('#article_id' + index).val(data.art.Article.id);
                    $('#designation' + index).val(data.art.Article.name);
                    $('#prixhtva' + index).val(data.art.Article.prixav_remise);
                    $('#marge' + index).val(data.art.Article.marge);
                    $('#prixdeventeht' + index).val(data.art.Article.prixvente);
                    $('#remise' + index).val(data.art.Article.remise);
                    $('#fodec' + index).val(data.art.Article.fodec);
                    $('#tva' + index).val(data.art.Article.tva);
                    $('#famille_id' + index).val(data.detailart.Famille.id);
                    $('#famille' + index).val(data.detailart.Famille.name);
                    $('#sousfamille_id' + index).val(data.detailart.Sousfamille.id);
                    $('#sousfamille' + index).val(data.detailart.Sousfamille.name);
                    $('#soussousfamille_id' + index).val(data.detailart.Soussousfamille.id);
                    $('#soussousfamille' + index).val(data.detailart.Soussousfamille.name);
                }
            })
        }
    });


    $('.calculfactureamine').on('keyup', function () {
        calculfactureaminee();
    });

    $('#datatableadd_facture').on('click', function () {
        //alert(client);
//        num_piece=$('#num_piece').val();
//        votre_ref=$('#votre_ref').val();

        var tab = new Array;
        conteur = $('.nombre').val();
        for (var i = 0; i <= conteur; i++) {
            val = ($('#check' + (i)).attr('checked'));//alert(val);
            v = $('#check' + (i)).val();
            if (val == 'checked') {

                tab[i] = v;
            }

        }
        var removeItem = undefined;

        tab = jQuery.grep(tab, function (value) {
            return value != removeItem;
        });
        client = $('.tes').val();
//        alert(tab);
//        alert(num_piece);
//        alert(votre_ref);
        // alert(client);

        //window.location.href=wr+"Boncommandefournisseurs/add_transfert/"+tab+"/"+num_piece+"/"+votre_ref;
        $(this).attr("href", wr + "Transferts/transfert_facture/" + tab)

    });


});



function ajouterligne_haitham(table, index) {
    //alert(index);
    ind = Number($('#' + index).val()) + 1;
    $ttr = $('#' + table).find('.tr').clone(true);
    $ttr.attr('class', 'cc');
    i = 0;
    tabb = [];
    $ttr.find('input,select').each(function () {
        tab = $(this).attr('table');
        champ = $(this).attr('champ');
        $(this).attr('index', ind);
        $(this).attr('id', champ + ind);

        $(this).attr('name', 'data[' + tab + '][' + ind + '][' + champ + ']');
        $(this).attr('data-bv-field', 'data[' + tab + '][' + ind + '][' + champ + ']');
        $(this).removeClass('anc');
        if ($(this).is('select')) {
            tabb[i] = champ + ind;
            i = Number(i) + 1;
        }
        $(this).val('');

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

    $('#date_deb' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});

    $('#date_fin' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});
    $('#date' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});

}




function calculeticket() {  // -------- Ticketcaisses/edit
    max = $('#indexmag').val() || 0;
    total = 0;
    for (i = 0; i <= max; i++) {
        ttc = 0;
        sup = $('#sup' + i).val() || 0;
        if (sup != 1) {
            prix = $('#prix' + i).val() || 0;
            remise = $('#remise' + i).val() || 0;
            qte = $('#qte' + i).val() || 0;
            mnt_remise = ((Number(prix) * Number(remise)) / 100).toFixed(3);
            ttc = ((Number(prix) - Number(mnt_remise)) * Number(qte)).toFixed(3);

            $('#total' + i).val(ttc);
            total = (Number(total) + Number(ttc)).toFixed(3);
        }
    }
    $('#FactureTotal').val(total);
}


// ********** Vente
function setQuery1(id, pmp, index) {//alert(index);
    //alert(index);
    page = $('#page').val() || 0;
   // alert(page);
    $('#article_id' + index).val(id);
   // alert(id);
//    $('#designation' + index).val(des);
//    alert(des);
//    $('#code' + index).val(code);
//    alert(code);
    $("#res" + index).css("visibility", "hidden");
    if (page != 'indexarticle') {
       // alert("11");
        articleidbl(index);
       // alert("22");
    }
    $('#quantite' + index).focus();
    $('#coutderevien' + index).val(pmp);
    /*ouvrirsubmit();*/

    /*setTimeout(function () {
     $('#quantite'+index).focus();
     }, 1);*/
    //$('#quantite'+index).focus();
    //ajouter_ligne_livraison1('addtable', 'index', 'tr');
}
// ********** Achat

function setQuery2(id, code, des, index) {//alert(index);
    $('#article_id' + index).val(id);
    $('#designation' + index).val(des);
    $("#res" + index).css("visibility", "hidden");
    tvaart(index)
    $('#quantite' + index).focus();
    /*ouvrirsubmit();*/
    //$('#quantite'+index).focus();
    //articleidbl (index);
    //ajouter_ligne_livraison1('addtable', 'index', 'tr');
}

// 3andou class  --> 7awweltha fonction w ya3mel appel lilha ;)
function articleidbl(index) {
    //alert("helmi"+index);
    // fournisseur_id== $('#fc').val();
    amine = $('#amine').val() || 0;
    //index=$(this).attr('index');
    article_id = $('#article_id' + index).val() || 0;
    fournisseur_id = $('#fc').val() || 0;
    page = $("#page").val();
    depot_id = $('#depot_id').val() || 0;
    //alert(depot_id);

    client_id = $('#client_id').val() || 0;
    vente = $('#vente').val() || 0;
    trans_remise = $('#trans_remise').val() || 0;
          // alert(article_id);
//           alert(depot_id);
//           alert(client_id);
//           alert(vente);
//           alert(trans_remise);
    $.ajax({
        type: "POST",
        url: wr + "Bonlivraisons/article/" + article_id + "/" + depot_id + "/" + client_id + "/" + vente + "/" + fournisseur_id,
        dataType: "json",
        async: false,
        global: false //}l'envoie'
    }).done(function (data) {
        console.log('data article : '+data);
        //article_id = $('#article_id'+index).val()||0;
//        alert(data.articleid);
//            alert("helmi");
//        alert($('#code' + index).val());
        $('#code' + index).val("");
        $('#pmp' + index).val("");
        $('#tva' + index).val("");
        $('#puttc' + index).val("");
        $('#prixhtva' + index).val("");
        $('#prixnet' + index).val("");
        $('#totalhtans' + index).val("");
        $('#quantitestock' + index).val("");
        $('#designation' + index).val("");
        $('#remise' + index).val("");
        $('#remiseans' + index).val("");
        $('#marge' + index).val("");
        $('#coutrevient' + index).val("");
        $('#order' + index).hide();
        
        
        $('#prixachatmarge' + index).val("");
        $('#maregbase' + index).val("");
        $('#margebaseorigine' + index).val("");
        //$('#quantite'+index).val("");
        if (Number(amine) != 1) {
            calculefacture();
        }
        //alert(data.marge);
        //console.log('data.prixachat '+data.prixachat);
        //console.log('data.marge '+data.marge);
        //console.log('data.margebaseorigine '+data.marge);
        console.log('data.remise '+data.remise);
        
        $('#prixachatmarge' + index).val(data.prixachatmarge);
        $('#margebase' + index).val(data.marge);
        $('#margebaseorigine' + index).val(data.marge);
            
            
        $('#totalht' + index).val("");
        $('#totalttc' + index).val("");
        article_id = $('#article_id' + index).val() || 0;
        //alert(article_id);
        if (Number(article_id) != 0) {
//            alert("helmi");
//             alert("d5al");
            $('#code' + index).val(data.code);
            
            if(data.tvaclient!=null){
             $('#tva' + index).val(data.tvaclient);   
            }else{
             $('#tva' + index).val(data.tva);   
            }
            $('#puttc' + index).val(data.prixttc);
            fournisseur_id = $('#fc').val() || 0;
            //alert(fournisseur_id);
            
            $('#prixnet' + index).val(data.prix);
            $('#totalhtans' + index).val(data.prix);
            $('#quantitestock' + index).val(data.quantitestock);
            $("#pmp" + index).val(data.pmp);
            $('#designation' + index).val(data.des);
            $('#remise' + index).val(data.remise_vente);
            $('#remiseans' + index).val(data.remise);
            //ali

            if (Number(data.composee) == 1) {
                $('#type' + index).val('1');
            } else {
                $('#type' + index).val('0');
            }
            $('#marge' + index).val(data.marge);
            $('#prixdeventeht' + index).val(data.prix);
            //
            if (trans_remise == 1) {
                $('#remise' + index).val(data.remise_transfert);
            }
            
            if (fournisseur_id == 0) {
                //alert('frs');
                $('#prixhtva' + index).val(data.prix);
            } else {
                //alert('helmi');
                if(data.codefrs !=""){
                $('#articlefrs_id' + index).val(data.codefrs);
                }
                $('#prixhtva' + index).val(data.prixachat);
                //alert(data.remise);
                $('#remise' + index).val(data.remise);
            }



            $('#order' + index).show();
            calculefacture();
        }
        if(data.composee==1){
            $('#nouveauart'+index).html('<a onClick="modifierchamptestindex_recap_nouveau_prix('+index+') ,flvFPW1(\'' + wr + 'Factureclients/recap_nouveau_prix/'+index+'/'+data.id+'\' ,\'UPLOAD\', \'width=1800,height=800,scrollbars=yes\', 0, 2, 2 ); return document.MM_returnValue;" href=\'javascript:;\'  > <i class=\"glyphicon glyphicon-plus modifierchamptestindex_recap_nouveau_prix\" index='+index+' style="color: #0080FF"></i></a>');
        }else{
            $('#nouveauart' + index).hide();
        }


    })
}


function fuckfocusmodif(type, index, name) {
    lename = name.split("[")[3];
    champ = lename.split("]")[0];
    index = Number(index);

    alert(event.keyCode);


//    if (champ == "depot_id") {
//        $('#code' + index).focus();
//    }

    $('#' + champ + index).keydown(function (e) {

        if (event.keyCode == 13) {
            //if(type=="input") {
            // alert(index);
            if (champ == "depot_id") {
                $('#code' + index).focus();
            }

            if (champ == "code") {
                $('#quantite' + index).focus();
                //ouvrirsubmit();
            }
            if (champ == "designation") {
                $('#quantite' + index).focus();
                //ouvrirsubmit();
            }
            if (champ == "quantite") {
                $('#prixhtva' + index).focus();
            }
            if (champ == "prixhtva") {
                $('#remise' + index).focus();
            }
            if (champ == "remise") {
                $('#prixnet' + index).focus();
            }
            if (champ == "prixnet") {
                $('#puttc' + index).focus();
            }
            if (champ == "puttc") {
                //ajouter_ligne_livraison1("addtable", "index");
                //blocsubmit();
                index = Number(index) + 1;
                $('#code' + index).focus();
            }
            champ = "";

            //  }


        }
    });




}



function blocsubmit() {
    $('.btn-primary').attr('disabled', 'disabled');
}

function ouvrirsubmit() {
    $('.btn-primary').attr('type', 'submit');
    $('.btn-primary').removeAttr('disabled');
}



function fuckfocus(type, index, name) {
    if (event.keyCode == 13) {
        lename = name.split("[")[3];


        champ = lename.split("]")[0];

        index = Number(index);
        lachaine = $('#lachaine').val() || 0;

        interfacetransfert = $('#interfacetransfert').val() || 0;

        if (interfacetransfert == 0) {

            if (lachaine == 0) {
                if (type == "input") {
                    //$(document).keypress(function (e) {
                    if (event.keyCode == 13) {
                        if (champ == "code") {
                            $('#quantite' + index).focus();
                        }
                        if (champ == "designation") {
                            $('#quantite' + index).focus();
                        }
                        if (champ == "quantite") {

                            $('#prixhtva' + index).focus();
                        }
                        if (champ == "prixhtva") {
                            $('#remise' + index).focus();
                        }
                        if (champ == "remise") {
                            $('#prixnet' + index).focus();
                        }
                        if (champ == "prixnet") {
                            $('#puttc' + index).focus();
                        }
                        if (champ == "puttc") {
                            //ajouter_ligne_livraison1("addtable", "index");
                            index = Number(index) + 1;
                            $('#code' + index).focus();
                        }
                        champ = "";
                    }
                    //});
                } else {
                    $('#code' + index).focus();
                }
            } 
            else {
                next_index=0;
            //alert("D5al lel achat");
            //alert("champ mt3ena houwa "+champ);
                var str_array = lachaine.split(',');
            ///alert("array "+str_array);
            //alert("champ mt3ena houwa "+champ);
                for (var i = 0; i < str_array.length; i++) {
                    champencours = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
                    //alert("champencours 9bal test "+champencours);    
                    //alert("champ mt3ena bal test houwa "+champ);    
                    if (champ == champencours) {

                        //alert("champencours baad test "+champencours);
                        //alert("champ mt3ena baad test houwa "+champ);
                        //alert(str_array.length);
                        //console.log(str_array);
                        if (i < str_array.length - 1) {
                            k = Number(i) + 1;
                        } else {
                            k = 0;
                        }
                        if (type == "input") {
                            if (event.keyCode == 13) {

                                if (k < Number(str_array.length)) {
                                    champnext = str_array[k].replace(/^\s*/, "").replace(/\s*$/, "");
                                    //alert("champencours "+champencours);
                                    //alert("champ "+champ);
                                    //alert("champnext "+champnext);
                                    if (champ == "code") {
                                        $('#quantite' + index).focus();
                                    } else {
                                        if (champ == "designation") {
                                            $('#quantite' + index).focus();
                                        } else {
                                            if (champ == "articlefrs_id") {
                                                code = $('#code' + index).val() || 0;
                                                if (code == 0) {
                                                    $('#code' + index).focus();
                                                } else {
                                                    $('#quantite' + index).focus();
                                                }
                                            } else {
                                                $('#' + champnext + index).focus();
                                            }
                                        }
                                    }
                                    //alert(champ);
                                    if (champ == "soussousfamille") {
                                        //alert(index);
                                        next_index = Number(index) + 1;
                                        //alert(next_index);
                                        $('#articlefrs_id' + next_index).focus();
                                    }

                                    if (k == Number(str_array.length)) {
                                        //alert('e5er ka3ba');
                                        //ajouter_ligne_livraison1("addtable","index");
                                        //ajouter_ligne_reception("addtable", "index", "tr");
                                        //ajouter_ligne_reception("addtableext", "index", "tr");

                                    }
                                    champ = "";
                                }
                            } else {
                                $('#code' + index).focus();
                            }
                        }

                    }
                }
            }

            if (interfacetransfert == 'transfert') {
                var str_array = lachaine.split(',');
                //alert(Number(str_array.length));
                for (var i = 0; i < str_array.length; i++) {
                    //alert(champ);
                    champencours = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
                    if (champ == champencours) {
                        k = Number(i) + 1;

                        //alert(str_array[i]);
                        if (type == "input") {
                            if (event.keyCode == 13) {

                                if (k < Number(str_array.length)) {
                                    champnext = str_array[k].replace(/^\s*/, "").replace(/\s*$/, "");
                                    //alert('champencours '+champencours+' ------------- champnext '+champnext);
                                    $('#' + champnext + index).focus();
                                    if (champ == "code") {
                                        $('#quantite' + index).focus();
                                    }
                                    if (champ == "designation") {
                                        $('#quantite' + index).focus();
                                    }
                                }
                                if (k == Number(str_array.length)) {
                                    //alert('e5er ka3ba');
                                    //ajouter_ligne_livraison1("addtable","index");
                                    ajouter_ligne_transfert("addtable", "index", "tr");

                                }
                                champ = "";
                            }
                        } else {
                            $('#code' + index).focus();
                        }
                    }

                }

            }
        }

    }
}



function scrolldown() {
    $('html, body').animate({scrollTop: $($(this).attr('href')).offset().top}, 500, 'linear');
}
function calculfactureaminee() {
    //alert();
    max = $('#index').val(); //alert(max);
    ttremise = 0;
    ttfodec = 0;
    tttva = 0;
    ttht = 0;
    tttc = 0;
    for (i = 0; i <= max; i++) {
        //alert(i);
        if ($('#sup' + i).val() != 1) { //alert();
            remisee = $('#remise' + i).val() || 0;
            qte = $('#quantite' + i).val() || 0;
            tva = $('#tva' + i).val() || 0;
            prix = $('#prixhtva' + i).val() || 0;
            fodec = $('#fodec' + i).val() || 0;
            timbre = $('#timbre').val() || 0;
            remise = (Number(prix) * Number(remisee)) / 100;
            prixu = Number(prix) - Number(remise);
            tht = (((Number(prixu)) * Number(qte)));
            fodecl = (tht * (Number(fodec))) / 100;
            ttva = ((tht + Number(fodecl)) * Number(tva)) / 100;
            if(tht!=0){
            $('#totalht' + i).val(Number(tht).toFixed(3));
            }
            ttht = (Number(ttht) + Number(tht));
            // ttremise=Number(remise)*Number(qte);
            ttfodec = (Number(ttfodec) + Number(fodecl));
            tttva = (Number(tttva) + Number(ttva));
            ttremise = (Number(ttremise) + (Number(remise) * Number(qte)));

            totalttc = (Number(tht) + Number(fodecl) + Number(ttva));
            if(totalttc!=0){
            $('#totalttc' + i).val(Number(totalttc).toFixed(3));
            }
        }
    }
    if (timbre != 0) {
        tttc = (Number(arrd(ttht,3)) + Number(arrd(ttfodec,3)) + Number(arrd(tttva,3)) + Number(timbre));
    } else {
        tttc = (Number(arrd(ttht,3)) + Number(arrd(ttfodec,3)) + Number(arrd(tttva,3)));
    }
    //alert(ttht);
    $('#fodec').val(Number(arrd(ttfodec,3)).toFixed(3));
    $('#tva').val(Number(arrd(tttva,3)).toFixed(3));
    $('#remise').val(Number(arrd(ttremise,3)).toFixed(3));
    $('#Total_HT').val(Number(arrd(ttht,3)).toFixed(3));
    $('#Total_TTC').val(Number(arrd(tttc,3)).toFixed(3));

}
function findfamille(index) { //alert();
    //index = $(this).attr('index');
    val = $('#article_id' + index).val();//alert(val);

    $.ajax({
        type: "POST",
        data: {
            val: val
        },
        url: wr + "Articles/findfamille/",
        dataType: "json",
        async: false,
        global: false //}l'envoie'
    }).done(function (data) {
        console.log(data);
        $('#famille_id' + index).val(data.detailart.Famille.id);
        $('#famille' + index).val(data.detailart.Famille.name);
        $('#sousfamille_id' + index).val(data.detailart.Sousfamille.id);
        $('#sousfamille' + index).val(data.detailart.Sousfamille.name);
        $('#soussousfamille_id' + index).val(data.detailart.Soussousfamille.id);
        $('#soussousfamille' + index).val(data.detailart.Soussousfamille.name);
    });
}



function arrd(valeur,nb_chiffre){
   valeur=valeur.toString()
   var str_array = valeur.split('.');
   if(str_array.length >1){
   if(str_array[1] !=''){
   var res = str_array[1].substr(0,nb_chiffre);
   //n_v=res.padEnd(nb_chiffre,'0');
   //arrrdi
   var ard = str_array[1].substr(nb_chiffre,1);
   if(ard){
   if((ard>=6) && (ard <=9)) {
   ard=Number(ard)+1;
    //alert(n_v);
   } 
   }
   n_v=res+''+ard;
   //alert(n_v);
   //fin arrdi
   }else{
   n_v=res.padEnd(nb_chiffre,'0');   
   }
   nouveau_montant=str_array[0]+'.'+n_v;
   }else{
   res='';    
   n_v=res.padEnd(nb_chiffre,'0');    
   nouveau_montant=str_array[0]+'.'+n_v;    
   }
   return nouveau_montant;
}