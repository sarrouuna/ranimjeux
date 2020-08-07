

$(document).ready(function () {


$('.supregg').on('click', function () {
     
    index = $(this).attr('index');

    bootbox.confirm("voulez vous effacer cette enregistrement?", function (result) {
        if (result) {
            // alert(index);
            $('.supregg').each(function () {
                ind = $(this).attr('index');
                console.log(index);
                if (ind == index) {
                    $(this).parent().parent().hide();
                    $('#sup' + index).val(1);
                 
               
                }
            })



        }
        var data = "Confirm result: " + result;
        notificationCenter(
                'glyphicon glyphicon-ok',
                'alert-success',
                data,
                'bottom right'
                );
    });


});
});