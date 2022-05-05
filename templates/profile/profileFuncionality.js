//Añado Jquery al script
var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);

//Mostrar/esconder popup de creacion de nueva recompensa
document.getElementById("deleteAccount").addEventListener("click", showDeleteAccount);
document.getElementById("cancelDeleted").addEventListener("click", hideDeleteAccount);

function showDeleteAccount() {
    document.querySelector(".popup-deleteAccount").style.display = "flex";
}

function hideDeleteAccount() {
    document.querySelector(".popup-deleteAccount").style.display = "none";    
}


//Mira en le localStorage si esta seteado el item dark-theme para ponerlo
//Tambien deja seleccionado en el select el tema que se esta usando
if(localStorage.getItem('dark-theme')) {
    document.body.classList.add('dark-theme');

    document.getElementById("theme").value = "dark";

}else {
    document.getElementById("theme").value = "light";
}




//Al cambiar el tema del select se cambia el tema de la web de claro a oscuro o viceversa
var theme = document.getElementById("theme");
theme.addEventListener("change", changeColor, false);
function changeColor(){

    if(theme.value == "dark") {

        localStorage.setItem('dark-theme', true);            
        document.body.classList.toggle("dark-theme", true);


    } else {

        localStorage.removeItem('dark-theme');           
        document.body.classList.toggle("dark-theme", false);

    }    
}


//Se obtiene el idioma de la url para dejar seleccionado en el select el idioma en uso
if (window.location.href.slice(-2) == "en") {

    document.getElementById("language").value = "en";

} else if (window.location.href.slice(-2) == "es") {

    document.getElementById("language").value = "es";

}


//Al cambiar el idioma del selecr se cambia el idioma de la web
var language = document.getElementById("language");
language.addEventListener("change", changeLanguage, false);
function changeLanguage(){

    if(language.value == "en") {

        document.location.href = "./profile?lang=en";

    } else {

        document.location.href = "./profile?lang=es";

    }    
}