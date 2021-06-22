'use strict';

function ajaxRequest(type, url, callback, data = null){
    let xhr;
  
    xhr = new XMLHttpRequest(); //crée la requette xhr http
    if (type == 'GET' && data != null)
      url += '?' + data;
    xhr.open(type, url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  
    
    xhr.onload = () =>  {
      switch (xhr.status){
        case 200:
        case 201:
          //console.log(xhr.responseText);
          callback(JSON.parse(xhr.responseText));
          break;
        default:
          httpErrors(xhr.status);
      }
    };
  
    // Send XML HTTP request.
    xhr.send(data);
  }