var READY_STATE_COMPLETE = 4;
var STATUS_RIGTH = 200;
var http_request = null;

function validar() {
//Obtenemos el valor del campo
    var valor = document.getElementById("idtipo").value;
    var regExp = new RegExp('[0-9]{1,5}');

    if(valor == ""){
        document.getElementById('spanIdTipo').innerHTML = "No hay nada introducido";
        document.getElementById('boton').disabled = true;
        document.getElementById('idtipo').focus();
    }
    else {
        document.getElementById('spanIdTipo').innerHTML = '';
        comprobar();
    }
}

function comprobar(){
    http_request = new XMLHttpRequest();
    http_request.onload = success; 
    http_request.open('POST', 'Requests/compTipo.php', true);
    http_request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    http_request.send('idtipo='+encodeURIComponent(idtipo.value)+ '&nocache=' + Math.random());
}
function success(){
    if(http_request.readyState == READY_STATE_COMPLETE){
        if(http_request.status == STATUS_RIGTH){
            if(http_request.responseText.trim() == 'si'){
                document.getElementById('spanIdTipo').innerHTML = '';
                document.getElementById('boton').disabled = false;
            }
            else{
                document.getElementById('idtipo').focus();
                document.getElementById('boton').disabled = true;
                document.getElementById('spanIdTipo').innerHTML = 'Tipo no introducido';
            }
            // Linea para hacer ver qué devuelve la petición
             console.log(http_request.responseText);
        }
    }
}