$(document).ready(function() 
{        
	$('label').addClass('col-md-2 control-label');
	$('select').each(function(){
		abc=$(this).attr('class');
		if(abc=='form-control'){
			$(this).addClass('select');
		}
	});
	
	page=$('#page').val();
	if(page==1){
		data='succes';
	notificationCenter(
                'glyphicon glyphicon-ok',
                'alert-success',
                data,
                'bottom right'
            );
	}
       
       
        $('.label').find('label').remove();
        $('.label1').find('label').remove();
        $('.newans').on('click',function(){
            $('.newannee').show();
            $('.ancannee').hide();
            $('#ansnew').val(1);
        })
        $('.ancans').on('click',function(){
            $('.newannee').hide();
            $('.ancannee').show();
            $('#ansnew').val(0);
        })
        $('.serienew').on('click',function(){
            $('.newserie').show();
            $('.ancserie').hide();
            $('#serienew').val(1);
        })
         $('.serieans').on('click',function(){
            $('.newserie').hide();
            $('.ancserie').show();
            $('#serienew').val(0);
        })
       
	});
//fonction uniforme select	
	function uniform_select(val){
          //  alert();
    var $select = $('#'+val).selectize({
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
function ajouter_ligne(table,index){
        ind=Number($('#'+index).val())+1;
        $ttr =$('#'+table).find('.tr').clone(true);
        $ttr.attr('class','');
		i=0;tabb=[];
        $ttr.find('input,select').each(function(){
            tab = $(this).attr('table');
            champ = $(this).attr('champ');
            $(this).attr('index',ind);
            $(this).attr('id',champ+ind);
            $(this).attr('name','data['+tab+']['+ind+']['+champ+']');
			$(this).attr('data-bv-field','data['+tab+']['+ind+']['+champ+']');
            $(this).removeClass('anc');
			 if($(this).is('select')){
				 tabb[i]=champ+ind;
				 i=Number(i)+1;
            }
            $(this).val('');
			
        })
        $ttr.find('i').each(function(){
           $(this).attr('index',ind); 
        });
        $('#'+table).append($ttr);
        $('#'+index).val(ind);
        $('#'+table).find('tr:last').show();
		for(j=0;j<=i;j++){
		uniform_select(tabb[j]);
		}
		
}

function cal(index){
   grammage=$('#gammage'+index).val();
   prixu=$('#prixu'+index).val();
   p=Number(prixu)/1000;
   prix=Number(grammage)*Number(p);
   $('#prix'+index).val(Number(prix).toFixed(3)); 
}
function call(index){
   qte=$('#qte'+index).val();
   prixu=$('#prixuu'+index).val();
   prix=Number(qte)*Number(prixu);
   $('#prixx'+index).val(Number(prix).toFixed(3)); 
}

            