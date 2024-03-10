/*$(window).scroll( function() {
    if($(this).scrollTop() > 50)
    {
        $('.navbar').addClass('backround');
    } else
    {
        $('.navbar').removeClass('backround');
    } 
});

$(window).scroll( function() {
    if($(this).scrollTop() > 50)
    {
        $('#navtext').addClass('navtext');
    } else
    {
        $('#navtext').removeClass('navtext');
    } 
});
$(window).scroll( function() {
    if($(this).scrollTop() > 50)
    {
        $('#navtext2').addClass('navtext');
    } else
    {
        $('#navtext2').removeClass('navtext');
    } 
});
$(window).scroll( function() {
    if($(this).scrollTop() < 50)
    {
        $('.nav-link').addClass('bluetext');
    } else
    {
        $('.nav-link').removeClass('bluetext');
    } 
});*/



jQuery(document).ready(function($){
  //аякс форма обратной связи
  $(".fofm").submit(function() {
    $.ajax({
      type: "POST",
      url: "mail.php",
      data: $(this).serialize()
    }).done(function() {
      $(this).find("input").val("");
      alert("Спасибо за заявку! Скоро мы с вами свяжемся.");
      $(".fofm").modal('hide');
       return false;
    });
   
  });

});


$(document).ready(function () {
            $(".button1").click(function () {
               
              var platej=$("#platej").val();
        var years=$("#years").val();
        if (platej!='' && years!=''){
          var summ=platej*years*12*0.93;
                $("#sum_display").html('<p id="sum_display" >Доступная вам сумма</p><p class="smalldevice" style="font-size: 8em;">'+(Math.floor(summ)).toLocaleString() +' <span style="font-size:0.7em !important;">₽</span></p>');
                $("#inpval").val('Сумма кредита: '+summ);
                 $(".button1").hide();
                $("#summ").show();
                $("#sumbtn").show();
        }
        else {
          alert("Заполните данные!");
        }

                
      });

 });
function recount(){
  $("#summ").hide();
  $(".button1").show();
  $("#slider").val("");
  $("#slider1").val("");
}

$(function() {
        $('.lazy').Lazy();
    });