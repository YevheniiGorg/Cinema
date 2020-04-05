
$(".place_cinema.free").click(function () {
    $(this).toggleClass("active");
    if($(".cinema_hall>.row_cinema >.place_cinema ").hasClass("active")){
        $("#buy-form button.btn-primary").addClass("active");
    }else {
        $("#buy-form button.btn-primary").removeClass("active");
    }

});
$("#buy-form").on("beforeSubmit", function (e){
    e.preventDefault();
    e.stopImmediatePropagation();
    var NumArray = [];
    $(".cinema_hall .place_cinema.active").each(function(){
        NumArray.push($(this).attr("data-num"));
    });

    var $form = $(this);
    var _data = {
        'BuyForm[name]':$form.find('[name="BuyForm[name]"]').val(),
        'BuyForm[email]':$form.find('[name="BuyForm[email]"]').val(),
        'BuyForm[array_tickets]':NumArray
    };
    $.ajax({
        type: "POST",
        url: $form.attr('action'),
        data: _data,
        success: function(response) {
            alert(response);
            location.reload();
        },
        error: function(response) {
            console.log(response);
        }
    });
    return false;
});



