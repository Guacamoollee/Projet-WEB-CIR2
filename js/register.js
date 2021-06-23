'use strict'

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

$('#inscription').submit((event) =>  {
  //event.preventDefault();
  console.log('Test');
  ajaxRequest('POST', '../php/api/v1/api.php/utilisateur', (data)=>{
    console.log('data'+ data);
    console.log('Test');
  },'pseudo=' + $('#pseudo').val() + '&nom=' + $('#nom').val() + '&tel=' + $('#tel').val() + '&mdp=' + $('#mdp').val());
  return false; //empèche le reload de la page
});