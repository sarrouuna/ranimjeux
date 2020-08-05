$(document).ready(function ()
{

    $('label').addClass('col-md-2 control-label');
    $('.labelimp').find('label').remove();
    $('select').each(function () {
        abc = $(this).attr('class');
        if (abc == 'form-control') {
            $(this).addClass('select');
        }

    });

    page = $('#page').val();
    if (page == 1) {
        data = 'succes';
        notificationCenter(
                'glyphicon glyphicon-ok',
                'alert-success',
                data,
                'bottom right'
                );
    }
    $('.label').find('label').remove();
    $('.label1').find('label').remove();
    $('.newans').on('click', function () {
        $('.newannee').show();
        $('.ancannee').hide();
        $('#ansnew').val(1);
    })
    $('.ancans').on('click', function () {
        $('.newannee').hide();
        $('.ancannee').show();
        $('#ansnew').val(0);
    })
    $('.serienew').on('click', function () {
        $('.newserie').show();
        $('.ancserie').hide();
        $('#serienew').val(1);
    })
    $('.serieans').on('click', function () {
        $('.newserie').hide();
        $('.ancserie').show();
        $('#serienew').val(0);
    })

});
//fonction uniforme select
function uniform_select(val) {
    //  alert();
    var $select = $('#' + val).selectize({
        create: false,
        onChange: eventHandler('onChange'),
        onItemAdd: eventHandler('onItemAdd'),
        onItemRemove: eventHandler('onItemRemove'),
        onOptionAdd: eventHandler('onOptionAdd'),
        onOptionRemove: eventHandler('onOptionRemove'),
        onDropdownOpen: eventHandler('onDropdownOpen'),
        onDropdownClose: eventHandler('onDropdownClose'),
        onInitialize: eventHandler('onInitialize')
    });
}
//fonction ajouter ligne
function ajouter_ligne(table, index) {
    ind = Number($('#' + index).val()) + 1;

    $ttr = $('#' + table).find('.tr').clone(true);
    $ttr.attr('class', '');
    i = 0;
    tabb = [];
    $ttr.find('input,select').each(function () {
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

function cal(index) {
    grammage = $('#gammage' + index).val();
    prixu = $('#prixu' + index).val();
    p = Number(prixu) / 1000;
    prix = Number(grammage) * Number(p);
    $('#prix' + index).val(Number(prix).toFixed(3));
}
function call(index) {
    qte = $('#qte' + index).val();
    prixu = $('#prixuu' + index).val();
    prix = Number(qte) * Number(prixu);
    $('#prixx' + index).val(Number(prix).toFixed(3));
}
//fonction ajouter ligne reglement
function ajouter_ligne_reglement(table, index, tr) {
//    alert();
    ind = Number($('#' + index).val()) + 1;

    $ttr = $('#' + table).find('.' + tr).clone(true);

    $ttr.attr('class', '');
    i = 0;
    tabb = [];

    $ttr.find('input,select,span').each(function () {
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
        if (champ == 'num') {
//            alert("222");
            num = Number(ind);
            $(this).html(num);
        }

    })
    $ttr.find('i').each(function () {
        $(this).attr('index', ind);
    });
    $('#' + table).append($ttr);
    $('#' + index).val(ind);
    $('#' + table).find('tr:last').show();	//

    for (j = 0; j <= i; j++) {
        uniform_select(tabb[j]);
    }
    uniform_select('depot_id' + ind);
    $('#date' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});

    $('#date_exp' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});


}
var d = new Array();
var a = new Array();
var nsup = 0
var al = 0;
function test_ligne(val, index) {
    if (val == 'sup') {
        a[index] = d[index] = nsup;
        nsup--;
    } else {
        if (val == 'submit') { //alert(val);
            //alert('length= '+d.length);
            for (var i = 0; i < d.length; i++) {
                // alert('ligne '+i+' a = '+a[i]+' d ='+d[i]);
                for (var j = 1; j < d.length; j++) {
                    if ((d[i] != undefined) & (d[j] != undefined) & (a[i] != undefined) & (a[j] != undefined)) {
                        if ((d[i] == d[j]) & (a[i] == a[j]) & (i != j)) {
                            if (al > 0) {
                                //bootbox.alert('impossible d\'inséré 2 fois le meme article ', function (){});
                                al++;
                                //return false;
                            } else {//alert('az');
                                index = $(this).attr('index');
                                $('.supor').each(function () {
                                    ind = $(this).attr('index');
                                    if (ind == index) {
                                        $(this).parent().parent().hide();
                                        $('#sup' + index).val(1);
                                        calculefacturef();
                                    }
                                })
                                a[index] = d[index] = nsup;
                                nsup--;
                            }

                            return false;
                        }
                    }
                }
            }
        } else {
            if (val.length > 9) {
                d[index] = val;
                for (var i = 0; i < d.length + 1; i++) {
                    if ((d[i] == d[index]) & (a[i] == a[index]) & (i != index)) {
                        //bootbox.alert('impossible d\'inséré 2 fois le meme article ', function (){});
                        //return false;
                    }
                }
            } else {
                a[index] = val; //alert(a[index]);

                for (var i = 0; i < a.length + 1; i++) {
                    if ((d[i] == d[index]) & (a[i] == a[index]) & (i != index)) {
                        //bootbox.alert('impossible d\'inséré 2 fois le meme article ', function (){});
                        //return false;
                    }
                }
            }
        }
    }
}

var td = new Array();
var ta = new Array();
var tnsup = 0;
var remp = 0;
function remplirtableau() {
    // alert(ta);
    if (remp == 0) {
        var i = 0;
        while ($('#article_id' + i).val() != undefined) {
            ta[i] = $('#article_id' + i).val();
            td[i] = $('#date' + i).val();
            i++;
        }
        remp++;
    }
}
function edit_ligne(val, index) {
    remplirtableau();
    //alert(index);
    // alert(td) ;
    // alert(ta) ;
    if (val == 'sup') {
        ta[index] = td[index] = tnsup;
        tnsup--;
    } else {
        if (val == 'submit') { //alert(val);
            for (var i = 0; i < td.length; i++) {
                // alert('ligne '+i+' a = '+a[i]+' d ='+d[i]);
                for (var j = 1; j < td.length; j++) {
                    if ((td[i] != undefined) & (td[j] != undefined) & (ta[i] != undefined) & (ta[j] != undefined)) {
                        if ((td[i] == td[j]) & (ta[i] == ta[j]) & (i != j)) {
                            if (al > 0) {
                                // bootbox.alert('impossible d\'inséré 2 fois le meme article ', function (){});
                                //return false;
                            } else {
                                index = $(this).attr('index');
                                $('.supor').each(function () {
                                    ind = $(this).attr('index');
                                    if (ind == index) {
                                        $(this).parent().parent().hide();
                                        $('#sup' + index).val(1);
                                        calculefacturef();
                                    }
                                })
                                ta[index] = td[index] = tnsup;
                                tnsup--;
                            }
                            return false;
                        }
                    }
                }
            }
        } else {
            if (val.length > 9) {
                td[index] = val; //alert(val);
                for (var i = 0; i < d.length + 1; i++) {
                    if ((td[i] == td[index]) & (ta[i] == ta[index]) & (i != index)) {
                        //bootbox.alert('impossible d\'inséré 2 fois le meme article ', function (){});
                        // return false;
                    }
                }
            } else {
                ta[index] = val; //alert(val);

                for (var i = 0; i < ta.length + 1; i++) {
                    if ((td[i] == td[index]) & (ta[i] == ta[index]) & (i != index)) {
                        //bootbox.alert('impossible d\'inséré 2 fois le meme article ', function (){});
                        //return false;
                    }
                }
            }
        }
    }
}
//fonction ajouter ligne reception
function ajouter_ligne_reception(table, index, tr) {
    //alert('table '+table +' ------index '+index+' ------ tr '+tr);
    ind = Number($('#' + index).val()) + 1;    //alert(ind);

    $ttr = $('#' + table).find('.' + tr).clone(true);

    $ttr.attr('class', 'cc' + ind);
    i = 0;
    tabb = [];

    $ttr.find('input,select,td,a,button,div').each(function () {
        tab = $(this).attr('table');
        champ = $(this).attr('champ');
        $(this).attr('index', ind);
        $(this).attr('id', champ + ind);
        $(this).attr('name', 'data[' + tab + '][' + ind + '][' + champ + ']');
        $(this).attr('data-bv-field', 'data[' + tab + '][' + ind + '][' + champ + ']');
        lename = $(this).attr('name');
        if ((($(this).is('input')) || ($(this).is('select')))) {
            if ($(this).attr('type') != 'hidden') {
                if ($(this).attr('readonly') != 'readonly') {
                    if ($(this).attr('champ') == 'depot_id') {
                        $(this).attr('onchange', 'fuckfocus("select","' + ind + '","' + lename + '")');
                    } else {
                        $(this).attr('onkeypress', 'fuckfocus("input","' + ind + '","' + lename + '")');
                    }
                }
            }
        }

        if (champ == 'article_id') {
            $(this).attr('onchange', 'tvaart(' + ind + ')')
            page = $('#page').val();
            if (page == 'transfert') {
                $(this).attr('onchange', 'qtestock(' + ind + ')')
            }
        }
        if (champ == 'order') {
            $(this).attr('onclick', 'recap_achat(' + ind + ')')
        }
        //zeinab
        if (page == 'suggestioncommande' || page == 'commande') {
            if (champ == 'tdaff') {
                fournisseur_id = $('#fc').val();
                //$(this).html("<span title='ajouter article'><a  onClick=flvFPW1(wr+'Deviprospects/recapajoutarticle?index="+ind+",'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue' href='javascript:;' ><i class='fa fa-plus-circle'></i></a></span>");
                $(this).html('<a onClick="modifierchamptestindex(' + ind + '),flvFPW1(\'' + wr + 'Deviprospects/recapajoutarticle/' + ind + '/' + fournisseur_id + '\' ,\'UPLOAD\', \'width=1200,height=1150,scrollbars=yes\', 0, 2, 2 ); return document.MM_returnValue;" href=\'javascript:;\'  >  <i class=\'glyphicon glyphicon-plus modifierchamptestindex\' index=' + ind + ' style="color: #0080FF"></i></a>');
                //$(this).attr('onclick','recap_ajout_article('+ind+')')
            }
        }
        $(this).removeClass('anc');
        if ($(this).is('select')) {
            tabb[i] = champ + ind;
            i = Number(i) + 1;
        }
        $(this).val('');
        if (champ == 'depot_id') {
            depot_id = $('#depot_id0').val();
            $(this).val(depot_id);
        }

    })
    $ttr.find('i').each(function () {
        $(this).attr('index', ind);
    });
    $('#' + table).append($ttr);
    $('#' + index).val(ind);
    //$('#'+table).find('tr:last').show();	//
    $('.cc' + ind).show();

    for (j = 0; j <= i; j++) {
        uniform_select(tabb[j]); //alert(j);
    }
    uniform_select('depot_id' + ind);
    $('#date' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});

    $('#date_exp' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});

    $('#datefabrication' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});
    $('#datevalidite' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});

    $('#depot_id' + ind).next().children().children().focus();

}



function ajouter_ligne_transfert(table, index, tr) {

    ind = Number($('#' + index).val()) + 1;    //alert(ind);

    $ttr = $('#' + table).find('.' + tr).clone(true);

    $ttr.attr('class', 'cc' + ind);
    i = 0;
    tabb = [];

    $ttr.find('input,select,td,div').each(function () {
        tab = $(this).attr('table');
        champ = $(this).attr('champ');
        $(this).attr('index', ind);
        $(this).attr('id', champ + ind);
        $(this).attr('name', 'data[' + tab + '][' + ind + '][' + champ + ']');
        $(this).attr('data-bv-field', 'data[' + tab + '][' + ind + '][' + champ + ']');
        lenom = $(this).attr('name');

        if ((($(this).is('input')) || ($(this).is('select')))) {

            //alert($(this).attr('champ'));
            if ($(this).attr('type') != 'hidden') {
                if ($(this).attr('readonly') != 'readonly') {
                    if ($(this).attr('champ') == 'depot_id') {
                        $(this).attr('onchange', 'fuckfocus("select","' + ind + '","' + lenom + '")');
                    } else {
                        $(this).attr('onkeypress', 'fuckfocus("input","' + ind + '","' + lenom + '")');
                    }
                }

            }
        }





        if (champ == 'article_id') {
            //  $(this).attr('onchange','qtestock('+ind+')')
            page = $('#page').val();
            if (page == 'transfert') {
                //  $(this).attr('onchange','qtestock('+ind+')')
            }
        }

        $(this).removeClass('anc');
        if ($(this).is('select')) {
            tabb[i] = champ + ind;
            i = Number(i) + 1;
        }
        $(this).val('');
        if (champ == 'obligatoire') {
            //alert("d5al");
            $(this).attr('value', '0');
            //alert($(this).val());
        }
    })
    $ttr.find('i').each(function () {
        $(this).attr('index', ind);
    });
    $('#' + table).append($ttr);
    $('#' + index).val(ind);
    //$('#'+table).find('tr:last').show();	//
    $('.cc' + ind).show();


    for (j = 0; j <= i; j++) {
        uniform_select(tabb[j]); //alert(j);
    }
    uniform_select('depot_id' + ind);
    $('#date' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});

    $('#datefabrication' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});
    $('#datevalidite' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});
    $('#date_exp' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});

    $('#depot_id' + ind).next().children().children().focus();
}





function ajouter_ligne_livraisonancien(table, index, tr) {

    ind = Number($('#' + index).val()) + 1;

    $ttr = $('#' + table).find('.' + tr).clone(true);

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
        if (champ = 'article_id') {
            $(this).attr('onchange', 'art(' + ind + ')')
        }
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
    $('#' + table).find('tr:last').show();	//

    for (j = 0; j <= i; j++) {
        uniform_select(tabb[j]); //alert(j);
    }

    $('#date' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});

    $('#datefabrication' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});
    $('#datevalidite' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});

}

function ajouter_ligne_livraison(table, index) {
    ind = Number($('#' + index).val()) + 1;
    $ttr = $('#' + table).find('.tr').clone(true);
    $ttr.attr('class', '');
    i = 0;
    tabb = [];
    $ttr.find('input,select').each(function () {
        tab = $(this).attr('table');
        champ = $(this).attr('champ');
        $(this).attr('index', ind);
        $(this).attr('id', champ + ind);
        $(this).attr('name', 'data[' + tab + '][' + ind + '][' + champ + ']');
        $(this).attr('data-bv-field', 'data[' + tab + '][' + ind + '][' + champ + ']');
        //*************************************************************************
        if (champ = 'article_id') {
            $(this).attr('onchange', 'art(' + ind + ')')
        }

        //**********************************************************************
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
    uniform_select('depot_id' + ind);

}
//****calcul bl
function calculbonlivraison() {
    //alert()
    max = $('#index').val();
    ttremise = 0;
    ttfodec = 0;
    tttva = 0;
    ttht = 0;
    tttc = 0;
    for (i = 0; i <= max; i++) {
        // alert(i);
        if ($('#sup' + i).val() != 1) {
            remisee = $('#remise' + i).val() || 0;
            qte = $('#quantite' + i).val() || 0;
            qtestock = $('#quantitestock' + i).val() || 0;
            // alert(qtestock);
            if (Number(qte) > Number(qtestock)) {
                bootbox.alert('quantité invalide !! ', function () {});

                $('.supor').each(function () {
                    ind = $(this).attr('index');
                    if (ind == i) {
                        $(this).parent().parent().hide();
                        $('#sup' + i).val(1);
                        //  calculefacturef();
                    }
                })
                calculefacturef();
                return false;
            }
            tva = $('#tva' + i).val() || 0;
            prix = $('#prixhtva' + i).val() || 0;
            fodec = $('#fodec' + i).val() || 0;

            remise = (Number(prix) * Number(remisee)) / 100;
            prixu = Number(prix) - Number(remise);
            tht = (((Number(prixu)) * Number(qte)));
            fodecl = (tht * (Number(fodec))) / 100;
            ttva = ((tht + Number(fodecl)) * Number(tva)) / 100;

            //$('#Total_HT'+i).val(tht);
            ttht = (Number(ttht) + Number(tht)).toFixed(3);
            // ttremise=Number(remise)*Number(qte);
            ttfodec = (Number(ttfodec) + Number(fodecl)).toFixed(3);
            tttva = (Number(tttva) + Number(ttva)).toFixed(3);
            ttremise = (Number(ttremise) + (Number(remise) * Number(qte))).toFixed(3);
        }
    }
    tttc = (Number(ttht) + Number(ttfodec) + Number(tttva)).toFixed(3);
    $('#fodec').val(ttfodec);
    $('#tva').val(tttva);
    $('#remise').val(ttremise);
    $('#Total_HT').val(ttht);
    $('#Total_TTC').val(tttc);

} // -------------

//*****fin calcul bl

function calculefacturef() {
    //alert()
    max = $('#index').val();
    //alert("max"+max);
    ttremise = 0;
    ttfodec = 0;
    tttva = 0;
    ttht = 0;
    tttc = 0;
    typefrs = $('#typefrs').val() || 0;
    if ((typefrs == 1) || (typefrs == 0)) {
        for (i = 0; i <= max; i++) {
            //alert(i);
            if ($('#sup' + i).val() != 1) {
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
                ttht = (Number(ttht) + Number(tht));
                ttfodec = (Number(ttfodec) + Number(fodecl));
                tttva = (Number(tttva) + Number(ttva));
                ttremise = (Number(ttremise) + (Number(remise) * Number(qte)));
                //alert("qte"+qte);
                //alert("tva"+tva);
                //alert("prix"+prix);
                //alert("typefrs"+typefrs);
                //alert("tht"+tht);
            }
        }
        //alert(ttht);


        if (timbre != 0) {
            tttc = (Number(ttht) + Number(ttfodec) + Number(tttva) + Number(timbre));
        } else {
            tttc = (Number(ttht) + Number(ttfodec) + Number(tttva));
        }
        $('#fodec').val(ttfodec.toFixed(3));
        $('#tva').val(tttva.toFixed(3));
        $('#remise').val(ttremise.toFixed(3));
        $('#Total_HT').val(ttht.toFixed(3));
        $('#Total_TTC').val(tttc.toFixed(3));
    } else {

        for (i = 0; i <= max; i++) {
            //alert(i);
            if ($('#sup' + i).val() != 1) {



                //remisee=$('#remise'+i).val()||0;
                qte = $('#quantite' + i).val() || 0;
                tva = $('#tva' + i).val() || 0;
                prix = $('#prixhtva' + i).val() || 0;
                //alert(prix);
                //fodec=$('#fodec'+i).val()||0;
                //timbre=$('#timbre').val()||0;
                //typefrs=$('#typefrs').val()||0;
                //remise=(Number(prix)*Number(remisee))/100;
                //prixu= Number(prix)-Number(remise);
                tttc = tttc + (((Number(prix)) * Number(qte)));
                //fodecl=(tht*(Number(fodec)))/100;
                //ttva=((tht+Number(fodecl))*Number(tva))/100;
                //alert(tttc);
                ttht = ttht + (((Number(prix)) * Number(qte)) / Number(1 + (Number(tva) / 100)));
                //alert(ttht);
                //ttfodec=(Number(ttfodec)+Number(fodecl));
                tttva = tttva + (((Number(prix)) * Number(qte)) - (((Number(prix)) * Number(qte)) / Number(1 + (Number(tva) / 100))));
                //ttremise=(Number(ttremise)+(Number(remise)*Number(qte)));
                //alert("qte"+qte);
                //alert("tva"+tva);
                //alert("prix"+prix);
                //alert("typefrs"+typefrs);
                //alert("tht"+tht);
            }
        }

//         if(timbre !=0){
//         tttc=(Number(ttht)+Number(ttfodec)-Number(tttva)+Number(timbre));
//         }else{
//         tttc=(Number(ttht)+Number(ttfodec)-Number(tttva));
        //alert(tttc);
        //}
        //$('#fodec').val(ttfodec.toFixed(3));
        coef = $('#coef').val() || 1;
        if ((Number(coef) == 0) || Number(coef) == "") {
            coef = 1;
        }
        fret = $('#fret').val() || 0;
        avoir = $('#avoir').val() || 0;
        tot_fret = fret * coef;
        tot_avoir = avoir * coef;
        ttht = Number(ttht) + Number(tot_fret) - Number(tot_avoir);
        tttc = Number(tttc) + Number(tot_fret) - Number(tot_avoir);
        $('#tva').val(tttva.toFixed(3));
        //$('#remise').val(ttremise.toFixed(3));
        $('#Total_HT').val(ttht.toFixed(3));
        $('#Total_TTC').val(tttc.toFixed(3));
    }

}

function calculefacture_frs_ext() {
    //alert()
    max = $('#index').val();
    ttremise = 0;
    ttfodec = 0;
    tttva = 0;
    ttht = 0;
    tttc = 0;
    for (i = 0; i <= max; i++) {
        // alert(i);
        if ($('#sup' + i).val() != 1) {
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

            //$('#Total_HT'+i).val(tht);
            ttht = (Number(ttht) + Number(tht));
            // ttremise=Number(remise)*Number(qte);
            ttfodec = (Number(ttfodec) + Number(fodecl));
            tttva = (Number(tttva) + Number(ttva));
            ttremise = (Number(ttremise) + (Number(remise) * Number(qte)));
        }
    }
    if (timbre != 0) {
        tttc = (Number(ttht) + Number(ttfodec) + Number(tttva) + Number(timbre));
    } else {
        tttc = (Number(ttht) + Number(ttfodec) + Number(tttva));
    }
    $('#fodec').val(ttfodec.toFixed(3));
    $('#tva').val(tttva.toFixed(3));
    $('#remise').val(ttremise.toFixed(3));
    $('#Total_HT').val(ttht.toFixed(3));
    $('#Total_TTC').val(tttc.toFixed(3));

}


// -------------

function editfacturef() {
    //alert()
    max = $('#index').val();
    ttremise = 0;
    ttfodec = 0;
    tttva = 0;
    ttht = 0;
    tttc = 0;
    for (i = 0; i <= max; i++) {
        // alert(i);
        if ($('#sup' + i).val() != 1) {
            remisee = $('#remise' + i).val() || 0;
            qte = $('#quantite' + i).val() || 0;
            tva = $('#tva' + i).val() || 0;
            prix = $('#prixhtva' + i).val() || 0;
            fodec = $('#fodec' + i).val() || 0;

            remise = (Number(prix) * Number(remisee)) / 100;
            prixu = Number(prix) - Number(remise);
            tht = (((Number(prixu)) * Number(qte)));
            fodecl = (tht * (Number(fodec))) / 100;
            ttva = ((tht + Number(fodecl)) * Number(tva)) / 100;

            //$('#Total_HT'+i).val(tht);
            ttht = (Number(ttht) + Number(tht));
            // ttremise=Number(remise)*Number(qte);
            ttfodec = (Number(ttfodec) + Number(fodecl));
            tttva = (Number(tttva) + Number(ttva));
            ttremise = (Number(ttremise) + (Number(remise) * Number(qte)));
        }
    }
    tttc = (Number(ttht) + Number(ttfodec) + Number(tttva));
    $('#fodec').val(ttfodec.toFixed(3));
    $('#tva').val(tttva.toFixed(3));
    $('#remise').val(ttremise.toFixed(3));
    $('#Total_HT').val(ttht.toFixed(3));
    $('#Total_TTC').val(tttc.toFixed(3));

}
function calculefacture() {
   // alert();
    max = $('#index').val();
    ttremise = 0;
    ttfodec = 0;
    tttva = 0;
    ttht = 0;
    tttc = 0;
    tthtachat = 0;
    totale_ttc = 0;
   // timbre = $('#timbre').val() || 0;
    typeclientid = $('#typeclientid').val() || 0;
    fodecchoix = $('#typefodec').val() || 0;
    timbrechoix = $('#typetimbre').val() || 0;
 //rt("max " + max);
  if (fodecchoix == "avecfodec") { fodec = $('#fodeca').val() || 0; $('#fodec').val(fodec);   $('#fodecspan').text(fodec + "%"); } else
            	{
					//tva=19;
					/********hafedh*****/
            		 fodec=0;$('#fodec').val(fodec);  
            		 $('#fodecspan').text("0%");
					
					//alert(tva);
            	}
			if (timbrechoix == "avectimbre") { timbre =  $('#timbrea').val() || 0;$('#timbre').val(timbre);  } else
            	{
					//tva=19;
					/********hafedh*****/
            		 timbre=0;
					  $('#timbre').val(timbre); 
            		//alert(tva);
            	}
			 
    for (i = 0; i <= max; i++) {
//        alert('i '+i);
        sup = $('#sup' + i).val() || 0;
        tht = 0;
        ttva = 0;
        fodecl = 0;
        if (sup != 1) {
            //alert("sup "+sup);
            articlee_id = $('#article_id' + i).val() || 0;
            if (Number(articlee_id) > 0) {
//                alert('pass');
                remisee = $('#remise' + i).val() || 0;
                qte = $('#quantite' + i).val() || 0;
                prix = $('#totalhtans' + i).val() || 0;
            if (typeclientid == 2) {tva=0;  } else
            	{
					//tva=19;
					/********hafedh*****/
            		tva = $('#tva1' + i).val() || 0;
            		//alert(tva);
            	}
			//prix=$('#prixhtva'+i).val()||0;
			
			 
               
//                alert(fodec);
                prixachat = $('#prixachat' + i).val() || 0;
                remise = (Number(prix) * Number(remisee)) / 100;
                prixu = Number(prix) - Number(remise);
                //prixutcc=Number(prixu)*(1+( Number(tva)/100));
                tht = (((Number(prixu)) * Number(qte)));
                //$('#prixnet' + i).val(Number(prixu).toFixed(3));
                //$('#puttc' + i).val(Number(prixutcc).toFixed(3));
				//$('#prixnet' + i).val(Number(tht/qte).toFixed(3));
                $('#totalht' + i).val(Number(tht).toFixed(3));
                //alert("3");
                // $('#totalhtans'+i).val(Number(tht).toFixed(3));
                thtachat = (((Number(prixachat)) * Number(qte)));
                fodecl = (tht * (Number(fodec))) / 100;
                ttva = ((tht + Number(fodecl)) * Number(tva)) / 100;
                ttht = (Number(ttht) + Number(tht));
                tthtachat = (Number(tthtachat) + Number(thtachat));
                marge = (Number(ttht) - Number(tthtachat));//alert(marge);
                ttfodec = (Number(ttfodec) + Number(fodecl));
                tttva = (Number(tttva) + Number(ttva));
                ttcl = 0;
                if (typeclientid == 2) {
                    ttcl = Number(tht) + Number(fodecl);
				//	alert('h');
					$('#tva' + i).val(0);

					ttcl = Number(tht) +   Number(fodecl);
		//	 alert($('#tva' ).val());
                } else {
					tva1 = $('#tva1' + i).val() || 0;
					//alert(tva1);
					$('#tva' + i).val(tva1);

					ttcl = Number(tht) + Number(ttva) + Number(fodecl);

                }
                // alert("5");
				//$('#puttc' + i).val(Number(ttcl/qte).toFixed(3));
                $('#totalttc' + i).val(Number(ttcl).toFixed(3));
                $('#puttc' + i).val(Number(ttcl).toFixed(3));
                ttremise = (Number(ttremise) + (Number(remise) * Number(qte)));
                totale_ttc = Number(totale_ttc) + Number($('#totalttc' + i).val() || 0);
            }
        }
    }
    //alert("2");
    if (typeclientid == 2) {
        tttc = (Number(ttht) + Number(ttfodec));//alert(tttc);

    } else {
        tttc = Number(totale_ttc);
    }
    retenue = $("#retenue").val() || 0;
    ttretenue = (tttc * (Number(retenue))) / 100;
    tttc = tttc + ttretenue + Number(timbre);
    $('#ttretenue').val(ttretenue.toFixed(3));
    $('#ttfodec').val(ttfodec.toFixed(3));
    $('#tva').val(tttva.toFixed(3));
    $('#remise').val(ttremise.toFixed(3));
    $('#Total_HT').val(ttht.toFixed(3));
    $('#Total_TTC').val(tttc.toFixed(3));
    //$('#marge').val(marge.toFixed(3));

}// ------


function calculefacturehelmi() {
    //alert()
    max = $('#index').val();
    //alert(max);
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
            ttht = (Number(ttht) + Number(tht));
            tthtachat = (Number(tthtachat) + Number(thtachat));
            marge = (Number(ttht) - Number(tthtachat));//alert(marge);
            ttfodec = (Number(ttfodec) + Number(fodecl));
            tttva = (Number(tttva) + Number(ttva));
            ttcl = Number(tht) + Number(ttva);
            //$('#totalttc'+i).val(Number(ttcl).toFixed(3));
            ttremise = (Number(ttremise) + (Number(remise) * Number(qte)));
        }
    }
    tttc = (Number(ttht) + Number(ttfodec) + Number(tttva) + Number(timbre));//alert(tttc);
    $('#fodec').val(ttfodec.toFixed(3));
    $('#tva').val(tttva.toFixed(3));
    $('#remise').val(ttremise.toFixed(3));
    $('#Total_HT').val(ttht.toFixed(3));
    $('#Total_TTC').val(tttc.toFixed(3));
    $('#marge').val(marge.toFixed(3));

} // ------






function calculefacturetrasformationbl() {
    // alert()
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
            qte = $('#quantiteliv' + i).val() || 0;
            prix = $('#totalhtans' + i).val() || 0;
            tva = $('#tva' + i).val() || 0;
            //prix=$('#prixhtva'+i).val()||0;
            fodec = $('#fodec' + i).val() || 0;
            prixachat = $('#prixachat' + i).val() || 0;

            remise = (Number(prix) * Number(remisee)) / 100;
            prixu = Number(prix) - Number(remise);
            tht = (((Number(prixu)) * Number(qte)));
            $('#totalht' + i).val(Number(tht).toFixed(3));
            // $('#totalhtans'+i).val(Number(tht).toFixed(3));
            thtachat = (((Number(prixachat)) * Number(qte)));
            fodecl = (tht * (Number(fodec))) / 100;
            ttva = ((tht + Number(fodecl)) * Number(tva)) / 100;

            //$('#Total_HT'+i).val(tht);
            ttht = (Number(ttht) + Number(tht));
            tthtachat = (Number(tthtachat) + Number(thtachat));
            marge = (Number(ttht) - Number(tthtachat));//alert(marge);
            ttfodec = (Number(ttfodec) + Number(fodecl));
            tttva = (Number(tttva) + Number(ttva));
            ttcl = Number(tht) + Number(ttva);
            $('#totalttc' + i).val(Number(ttcl).toFixed(3));
            ttremise = (Number(ttremise) + (Number(remise) * Number(qte)));
        }
    }
    tttc = (Number(ttht) + Number(ttfodec) + Number(tttva) + Number(timbre));//alert(tttc);
    $('#fodec').val(ttfodec.toFixed(3));
    $('#tva').val(tttva.toFixed(3));
    $('#remise').val(ttremise.toFixed(3));
    $('#Total_HT').val(ttht.toFixed(3));
    $('#Total_TTC').val(tttc.toFixed(3));
    $('#marge').val(marge.toFixed(3));

} // ------



function ajouter_ligne_situation_reglement(table, index, indexc) {

    ind_kbira = Number(index);
    ind = Number($('#' + indexc + ind_kbira).val()) + 1;

    //alert(ind_kbira);
    //alert(ind);
    //alert(table);
    //alert(ind);
    $ttr = $('#' + table + ind_kbira).find('.trstituation').clone(true);
    $ttr.attr('class', '');
    i = 0;
    tabb = [];
    $ttr.find('input,select,i').each(function () {
        tab = $(this).attr('table');
        champ = $(this).attr('champ');
        $(this).attr('index', ind);
        $(this).attr('id', ind_kbira + champ + ind);
        $(this).attr('name', 'data[Situation][' + ind_kbira + '][' + tab + '][' + ind + '][' + champ + ']');
        $(this).attr('data-bv-field', 'data[Situation][' + ind_kbira + '][' + tab + '][' + ind + '][' + champ + ']');
        $type = $(this).attr('type');
        $(this).val('');
        if ($type == 'radio') {
            $(this).attr('name', 'data[' + champ + '][' + ind_kbira + ']');
            //$(this).attr('value',ind);
            $(this).val(ind);
        }
        if (champ == "croix_sup") {
            $(this).attr('ligne', ind_kbira);
        }


        $(this).removeClass('anc');
        if ($(this).is('select')) {
            tabb[i] = ind_kbira + champ + ind;
            i = Number(i) + 1;
        }
        // $(this).val('');

    })
    //alert(tabb);
    $ttr.find('i').each(function () {
        $(this).attr('index', ind);
    });
    $('#' + table + ind_kbira).append($ttr);
    $('#' + indexc + ind_kbira).val(ind);
    $('#' + table + ind_kbira).find('tr:last').show();
    for (j = 0; j <= i; j++) {
        uniform_select(tabb[j]);
    }
    $('#' + ind_kbira + 'echancenf' + ind).datetimepicker({
        timepicker: false,
        datepicker: true,
        mask: '39/19/9999',
        format: 'd/m/Y'});



}
