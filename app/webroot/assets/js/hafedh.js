$(document).ready(function () {


//**********************calculer prix commercial ht et ttc**************************************************

	$(".calculecommercial").on('keyup', function () {
		//alert("aaaaaa");
		prixventeht = $('#prixvente').val();
		prixventettc = $('#prixuttc').val();

		prixcommercialht = (Number(prixventeht) * 10) / 100;
		prixcommercialttc = (Number(prixventettc) * 10) / 100;

		$('#commercialht').val(Number(prixventeht)+prixcommercialht);
		$('#commercialttc').val(Number(prixventettc)+prixcommercialttc);


	})

//**********************************************************************************************************
/*
	$(".calculeinverseht").on('keyup', function () {
		//alert("aaaaaa");
		prixventeht = $('#commercialht').val();

		prixcommercialht = (Number(prixventeht) * 10) / 100;



		$('#prixvente').val(Number(prixventeht)-prixcommercialht);
	})
*/

//**********************************************************************************************************
	$(".calculeinversettc").on('keyup', function () {
		//alert("aaaaaa");
		prixventettc = $('#commercialttc').val();
		remise = $('#remise').val();
		margepourcentage = $('#margepourcentage').val();

		prixcommercialttc = (Number(prixventettc) * 10) / 100;
		prixcommercialttctva = (Number(prixventettc) * 19) / 100;

		prixuttc=Number(prixventettc)-prixcommercialttc;
		prixvente=prixuttc-prixcommercialttctva;
		coutrevientmarge = (Number(prixvente) * Number(margepourcentage))/ 100;
		coutrevient=prixvente-coutrevientmarge;
		prixuttc10=(Number(prixuttc) * 10) / 100;
		commercialht=prixuttc-prixuttc10;
		prixav_remisetva=(Number(coutrevient) * Number(remise))/ 100;
		prixav_remise=coutrevient+prixav_remisetva;


		$('#prixuttc').val(prixuttc);
		$('#prixvente').val(prixvente);
		$('#tva').val('19');
		//$('#margepourcentage').val('1');
		$('#coutrevient').val(coutrevient);
		$('#commercialht').val(commercialht);
		$('#prixav_remise').val(prixav_remise);

	})

	//******************************************************************************************************
	$('.afficheinputmontantreglementclientbonliv').on('click', function () {
		index = $(this).attr('index');
		if ($('#bonliv_id' + index).is(':checked')) {
			$('#Montantreglerbonliv' + index).show();
		} else {
			$('#Montantreglerbonliv' + index).hide();
		}
	})

//********************************************************************************************************
	$('.testmontantreglementclientbonliv').on('keyup', function () {
		index = $(this).attr('index');
		reste = Number($('#bonliv_id' + index).attr('mnt'));
		montant = Number($('#Montantreglerbonliv' + index).val());
		if(Number(montant)>Number(reste)){
			$('#Montantreglerbonliv' + index).val("");
			bootbox.alert('Impossible de dépasser le reste', function () {});
			return false
		}

	})
	//********************************************************************************************************
	$('.calculemontanttotal').on('keyup', function () {
		index = $(this).attr('index');
		total=0;
		reste = Number($('#bonliv_id' + index).attr('mnt'));
		//montant = Number($('#Montantreglerbonliv' + index).val());


			for(var i=0;i<=index;i++) {
				sup = $('#sup' + i).val() || 0;

				if (sup == 0) {
				montant = Number($('#Montantreglerbonliv' + i).val());
					alert(montant);
					total=total+montant;
				//alert(total);
					$('#montant0').val(total.toFixed(3));

				}}
	})


//********************************************************************************************************
$('.montantbrut1').on('keyup', function () {
	//alert("aaa");
	index=$(this).attr('index');
	montantbrut=$('#montantbrut'+index).val()||0;
	//t=$('#taux'+index).val()||0;
	//alert(t);
		taux=1.5;

	//alert(taux);
	retenue=(montantbrut*(taux/100)).toFixed(3);
	$('#montant'+index).val(retenue);
   // $('#Montant').val(retenue);
	net=(montantbrut-retenue).toFixed(3);
	$('#montantnet'+index).val(net);
	$('#netapayer').val(net);
v=$('#index').val();//alert(v)//console.log(v);
tt=0;
th=0;
i=0;
//for(i=0;i<=v;i++){
while($('#montant'+i).val()!=undefined){
   th= $('#montant'+i).val()||0;  //console.log(th);
 tt=Number(tt)+Number(th);
 i++;
}
 // ttt=Number(tt)+Number(retenue);
 console.log(tt);
 $('#Montant').val((tt).toFixed(3));

 })
//********************************************************************************************************
$('.tvavoir').on('keyup', function () {
	//alert("aaa");
	//index=$(this).attr('index');
	tva=$('#tvavoir').val()||0;
	ttc=$('#Total_TTC').val()||0;
    //alert(tva);
	montant=(Number(ttc) * Number(tva)) / 100;

	total=ttc-montant;
$('#Totalf').val((total).toFixed(3));

		
})


});
