'use strict';

ajaxRequest('GET', 'php/apiBDD/v1/api.php/isen', displayPolls);

function displayPolls(poll){
    $('poll-title').html(poll.title + '<span class=badge badge-pill badge-primary float-right">' + poll.participants + '<span>');
}