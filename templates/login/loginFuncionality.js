//Añado Jquery al script

var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);



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

    document.getElementById("nuser").value = "";
    document.getElementById("email").value = "";
    document.getElementById("npass").value = "";
    document.getElementById("cpass").value = "";
}


//Mira en le localStorage si esta seteado el item dark-theme para ponerlo
if(localStorage.getItem('dark-theme')) {
    document.body.classList.add('dark-theme');
    var col = document.getElementById("color");
    col.src = "/proyecto/img/sun.png";    
}

//Al pulsar el boton se cambia el tema de la web de claro a oscuro o viceversa
var color = document.getElementById("color");
color.addEventListener("click", changeColor, false);
function changeColor(){
    document.body.classList.toggle("dark-theme");  
    
    
    if(document.body.classList.contains("dark-theme")) {
        localStorage.setItem('dark-theme', true);    
        var col = document.getElementById("color");
        col.src = "/proyecto/img/sun.png";        

    } else {
        localStorage.removeItem('dark-theme');   
        var col = document.getElementById("color");
        col.src = "/proyecto/img/moon.png";        
    }
}

$(document).ready(function(){
    //Busca nombres de usuario en la base de datos para saber si estos ya se han usado
    $("#nuser").keyup(function(){                    
        if(/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9_.-]{3,15}$/.test($("#nuser").val())){
            $("#nuserError").html("");                        
            $("#nuserError").load("./controllers.php?nuser=" + $("#nuser").val());            
            //$("#nuser").addClass("resultados");                                 
        } else {

            if (window.location.href.slice(-2) == "en") {
                errorMessage = "This field only accepts letters and numbers with a length between 3 and 15 characters.";
            } else {            
                errorMessage = "Este campo sólo admite letras y numeros con una longitud de entre 3 y 15 caracteres.";
            } 

            $("#nuserError").html(errorMessage);
            //$("#nuser").removeClass("resultados");
            $("#nuser").html("");

/*
            if($("#nuserError").html() != ""){
                alert("hola");
                $("#nuser").addClass("fieldError");        
            } else if ($("#nuserError").html() == "") {
                alert("adios");
                $("#email").removeClass("fieldError");
            }
            */
        }         
                  
    });


    //Busca correos electronicos en la base de datos para saber si estos ya se han usado
    $("#email").keyup(function(){                    
        if(/^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/.test($("#email").val())){
            $("#emailError").html("");                        
            $("#emailError").load("./controllers.php?email=" + $("#email").val());
            //$("#email").addClass("resultados");                                 
        } else {

            if (window.location.href.slice(-2) == "en") {            
                errorMessage = "The email address is not correct";
            } else {
                errorMessage = "La dirección email no es correcta";            
            }

            $("#emailError").html(errorMessage);
            //$("#email").removeClass("resultados");
            $("#email").html("");
        }                    
    });
/*
    if($("#nuserError").html() == ""){
        alert("hola");
        $("#nuser").addClass("fieldError");        
    } else {
        $("#email").removeClass("fieldError");
    }
    */
});
