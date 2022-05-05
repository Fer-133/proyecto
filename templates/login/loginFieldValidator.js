/*validateUser acepta los parametros u y ur que son los elementos del DOM
referentes al campo usuario y error (del registro o del login), si cumple
la expresión regular devuelve true, sino la cumple devuelve false e introduce
un mensaje de error*/

function validateUser(u, ur) {
    var ok = false;
    var errorMessage = ""    ;
    var user = u;
    var error = ur;
    
    error.innerHTML = "";

    if (/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9_.-]{3,15}$/.test(user)) {
        ok = true;
    } else {

        if (window.location.href.slice(-2) == "en") {
            errorMessage = "This field only accepts letters and numbers with a length between 3 and 15 characters.";
        } else {            
            errorMessage = "Este campo sólo admite letras y numeros con una longitud de entre 3 y 15 caracteres.";
        } 

    }

    if(ok) {
        return true;
    } else {
        error.innerHTML = errorMessage;
        return false;
    }
}


/*validateEmail evalua el campo email, si cumple la expresión regular
devuelve true, sino devuelve false y un mensaje de error*/
function validateEmail() {
    var ok = false;
    var errorMessage = ""    ;
    var email = document.getElementById("email").value;
    var error = document.getElementById("emailError");
    
    error.innerHTML = "";

    if (/^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/.test(email)) {
        ok = true;
    } else {

        if (window.location.href.slice(-2) == "en") {            
            errorMessage = "The email address is not correct";
        } else {
            errorMessage = "La dirección email no es correcta";            
        }
    }

    if(ok) {
        return true;
    } else {
        error.innerHTML = errorMessage;
        return false;
    }
}

/*validateUser acepta los parametros p y pr que son los elementos del DOM
referentes al campo password y passworderror (del registro o del login), si cumple
la expresión regular devuelve true, sino la cumple devuelve false e introduce
un mensaje de error*/
function validatePass(p, pr) {
    var ok = false;
    var errorMessage = ""    ;
    var pass = p;
    var error = pr;
    
    error.innerHTML = "";

    if (/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/.test(pass)) {
        ok = true;
    } else {

        if (window.location.href.slice(-2) == "en") {
            errorMessage = "The password must be composed of uppercase, lowercase and numbers and be between 8 and 16 characters.";            
        } else {
            errorMessage = "La contraseña debe estar compuesta por mayusculas, minusculas y números y estar comprendida entre 8 y 16 caracteres"; 
        }

    }

    if(ok) {
        return true;
    } else {
        error.innerHTML = errorMessage;
        return false;
    }
}

/*validatePassEquality comprueba que la contraseña y su comprobación sean iguales,
si lo son devuelve true, si no lo son devuelve false y un mensaje de error*/
function validatePassEquality() {
    var ok = false;
    var errorMessage = ""    ;
    var npass = document.getElementById("npass").value;
    var cpass = document.getElementById("cpass").value;
    var error = document.getElementById("cpassError");
    
    error.innerHTML = "";

    if (npass.localeCompare(cpass) === 0) {
        ok = true;
    } else {

        if (window.location.href.slice(-2) == "en") {
            errorMessage = "The password doesn't match";
        } else {            
            errorMessage = "La contraseña no coincide";
        }

    }

    if(ok) {
        return true;
    } else {
        error.innerHTML = errorMessage;
        return false;
    }
}

/*validateRegistration devuelve true si todos los campos del registro
cumplen los requisitos y false si no los cumplen*/
function validateRegistration() {  
    var user = document.getElementById("nuser").value;
    var userError = document.getElementById("nuserError");
    var pass = document.getElementById("npass").value;
    var npassError = document.getElementById("npassError");

    var okUser = validateUser(user, userError);
    var okEmail = validateEmail();
    var okPass = validatePass(pass, npassError);
    var okPassEquality = validatePassEquality();
    if (okUser && okEmail && okPass && okPassEquality) {
        return true;
    } else {
        return false;
    }       
}

/*validateSingIn devuelve true si los campos de logIn cumplen los requisitos
y false si no los cumplen*/
function validateLogIn() {  
    var user = document.getElementById("user").value;
    var userError = document.getElementById("userError");
    var pass = document.getElementById("pass").value;
    var passError = document.getElementById("passError");

    var okUser = validateUser(user, userError);    
    var okPass = validatePass(pass, passError);
    
    if (okUser && okPass) {
        return true;
    } else {
        return false;
    }       
}