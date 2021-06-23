'use strict';

ajaxRequest('GET', '../php/api/v1/api.php/isen', peuplement_form_isen);

function peuplement_form_isen(site){
    console.log(site);
    for(let isen of site){
    $('#site_isen').append('<option value="'+isen.site_isen+'"> '+isen.site_isen+' </option>' );
    }
}

$('#proposition').submit((event) => {

  //recherche la commune grace au code postal
  //console.log('submit');
  ajaxRequest('GET','../php/api/v1/api.php/communes',(code_insee)=>{

    //console.log('CALLBACK');
    let date_dep = $('#depart').val();
    let date_arv =  $('#arrivee').val();
    let heure_dep = $('#heure_depart').val();
    let heure_arv = $('#heure_arrivee').val();

    let nb_place_max =  $('#depart').val();
    let nb_place_rest = nb_place_max;
    let adr =  $('#adr').val();
      
    let sens = $('#sens_trajet').val();
    let site_isen =  $('#site_isen').val();
    let prix =  $('#prix').val();
    let conducteur =  'MonsieurX';

    if(code_insee == ''){//gestion code postal invalide
      alert("le code postal n'est pas valide");
      return false; //permet de "quiter" et n'efface pas le formulaire
    }

    // console.log('1 '+date_dep);
    // console.log('2 '+date_arv);
    // console.log('3 '+heure_dep);
    // console.log('4 '+heure_arv);
    // console.log('5 '+nb_place_max);
    // console.log('6 '+nb_place_rest);
    // console.log('7 '+adr);
    // console.log('8 '+code_insee[0].code_insee); //si plusieurs ville sur code postal : on prend la 1ère (fait par manque de temps)
    // console.log('9 '+sens);
    // console.log('10 '+site_isen);
    // console.log('11 '+prix);
    // console.log('12 '+conducteur);

    event.preventDefault();    
    ajaxRequest('POST', '../php/api/v1/api.php/trajets', () =>{
        alert('Votre trajet a bien été proposé. Merci pour votre contribution.')  
    }, 
      'date_heure_depart=' + date_dep+' '+heure_dep + 
      ':00&date_heure_arrivee=' + date_dep+' '+heure_dep +
      ':00&nb_places_max=' + nb_place_max +
      '&nb_places_rest=' + nb_place_rest +
      '&prix=' + prix +
      '&adresse=' + adr +
      '&depart_isen=' + sens +
      '&code_insee=' + code_insee[0].code_insee + //si plusieurs ville sur code postal : on prend la 1ère (fait par manque de temps)
      '&site_isen=' + site_isen +
      '&pseudo_conducteur' + conducteur
    );

  },'CodePostal=' + $('#code_postal').val() );

  
});
