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
        $('.selectbanq,.selectstut').on('change',function(){
            index=$(this).attr('val');
            banque=$('#banque_id'+index).val();
            situation=$('#stut'+index).val();
            if(((banque!='') && (situation!='En attente'))||((banque=='') && (situation=='En attente'))){
                 $.ajax({
            type: "POST",
            url: wr+"Piecereglements/select/"+banque+"/"+situation+"/"+index,
            dataType : "JSON"
        }).done(function(data){
          
        });
            }
        });
        $('.add').on('click',function(){
        $('.base').hide();
        $('#base').attr('disabled','disabled');
        $('.new').show();
        $('#new').removeAttr('disabled');
        });
        $('.suppp').on('click',function(){
        $('.new').hide();
        $('#new').attr('disabled','disabled');
        $('.base').show();
        $('#base').removeAttr('disabled');
        });
        ion.sound({
            sounds: [
                {name: "beer_can_opening"},
                {name: "bell_ring"}
            ],
            path: wr+"sounds/",
            preload: true,
            volume: 1.0
        });
        $(".liv").on("click", function(){
           // alert('bbbbbbbbbb');
            //ion.sound.play("bell_ring");
            //,{
               // loop: true
            //};
        });
        
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
