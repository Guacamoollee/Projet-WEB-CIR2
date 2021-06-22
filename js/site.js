'use strict';

ajaxRequest('GET', '../php/api/v1/api.php/isen', affiche_isen);

function affiche_isen(poll){
    console.log(poll);
    for(let isen of poll){
    $('#depart').append('<option value="'+isen.site_isen+'"> '+isen.site_isen+' </option>' );
    }
}