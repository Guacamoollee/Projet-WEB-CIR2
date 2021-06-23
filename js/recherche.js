'use strict';

$('#boutton').click((event) =>
  {
    console.log(event);
    event.preventDefault();
    if($('#Partir').is(':checked'))
        ajaxRequest('GET', '/php/api/v1/api.php/trajets?destination=%'+$('#addr').val()+'%&isen_depart=%'+$('#depart').val()+'%', info);//aller
    else
        ajaxRequest('GET', '/php/api/v1/api.php/trajets?depart=%'+$('#addr').val()+'%&isen_destinataire=%'+$('#depart').val()+'%', info);//partir
  }
  
);


function info(vaar){
    for(let vaars of vaar){
        
        $('#resultat').append('<p>test: '+vaars.pseudo+ '</p><br>')
        $('#resultat').append(vaars.adresse+'<br>')
        $('#resultat').append(vaars.commune+'<br>')
        $('#resultat').append(vaars.code_postal+'<br>')
        $('#resultat').append(vaars.site_isen+'<br>')
        $('#resultat').append(vaars.date_heure_depart+'<br>')
        $('#resultat').append(vaars.date_heure_arrivee+'<br>')
        $('#resultat').append(vaars.nb_places_max+'<br>')
        $('#resultat').append(vaars.prix+'<br>')
        $('#resultat').append('<input type=submit value=reserver id='+vaars.id_trajet+'></input>')
    }   
    console.log(vaar);
}
