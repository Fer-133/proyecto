//Añado Jquery al script
/*
var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);
*/


//Mostrar/esconder popup de registro
document.getElementById("createAccount").addEventListener("click", showRegistration);
document.getElementById("cancel").addEventListener("click", hideRegistration);

function showRegistration() {
    document.querySelector(".popup").style.display = "flex";
}

function hideRegistration() {
    document.querySelector(".popup").style.display = "none";
    document.getElementById("nuserError").innerHTML = "";
    document.getElementById("emailError").innerHTML = "";
    document.getElementById("npassError").innerHTML = "";
    document.getElementById("cpassError").innerHTML = "";
}


//Mira en le localStorage si esta seteado el item dark-theme para ponerlo
if(localStorage.getItem('dark-theme')) {
    document.body.classList.add('dark-theme');
    var col = document.getElementById("color");
    col.src = "/proyecto/templates/img/sun.png";    
}

//Al pulsar el boton se cambia el tema de la web de claro a oscuro o viceversa
var color = document.getElementById("color");
color.addEventListener("click", changeColor, false);
function changeColor(){
    document.body.classList.toggle("dark-theme");  
    
    
    if(document.body.classList.contains("dark-theme")) {

        localStorage.setItem('dark-theme', true);    
        var col = document.getElementById("color");
        col.src = "/proyecto/templates/img/sun.png";        

    } else {

        localStorage.removeItem('dark-theme');   
        var col = document.getElementById("color");
        col.src = "/proyecto/templates/img/moon.png";        
    }

}










/*
//FEEDBACK INSTANTANEO DE NOMBRE DE USUARIO UTILIZADO O NO
$(document).ready(function(){
    $("nuser").keyup(function(){
        if(/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9_.-]{3,15}$/.test($("#nuser").val())) {
            
        }
    });
});
*/