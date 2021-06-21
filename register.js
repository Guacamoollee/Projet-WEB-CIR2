$(".connexion").hide();
$(".enregistrement_li").addClass("active");

$(".connexion_li").click(function(){
  $(this).addClass("active");
  $(".enregistrement_li").removeClass("active");
  $(".connexion").show();
   $(".enregistrement").hide();
})

$(".enregistrement_li").click(function(){
  $(this).addClass("active");
  $(".connexion_li").removeClass("active");
  $(".enregistrement").show();
   $(".connexion").hide();
})

/*$('#tweet-add').submit((event) =>
  {
    event.preventDefault();
    ajaxRequest('POST', 'php/api.php/utilisateur', () =>
      {

      },
    //$('#tweet').val('');
  }
);*/