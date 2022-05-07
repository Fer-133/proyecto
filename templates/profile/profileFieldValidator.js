/*validateEmail evalua el campo email, si cumple la expresión regular
devuelve true, sino devuelve false y un mensaje de error*/
function validateEmail() {
    var ok = false;
    var errorMessage = ""    ;
    var email = document.getElementById("email").value;
    var error = document.getElementById("emailError");
    
    error.innerHTML = "";

    if (/^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/.test(email) || email == "") {
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

    if (/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/.test(pass) || pass == "") {
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

/*atLeastOneFieldUpdated comprueba que se este actualizando al menos uno de los
campos del usuario*/
function atLeastOneFieldUpdated() {
    var npass = document.getElementById("npass").value;
    var cpass = document.getElementById("cpass").value;
    var email = document.getElementById("email").value;
    var error = document.getElementById("fieldError");

    error.innerHTML = "";

    if ((npass == "" && cpass == "") && email == "") {
        error.innerHTML = "Al menos se tiene que actualizar uno de los campos";

        if (window.location.href.slice(-2) == "en") {
            error.innerHTML = "At least one of the fields needs to be updated.";
        }

        return false;
    }

    return true;
}

/*validateText acepta los parametros text y errot que son los elementos del DOM
referentes a distintos textos si cumple
la expresión regular devuelve true, sino la cumple devuelve false e introduce
un mensaje de error*/

function validateText(text, error) {
    var ok = false;
    var errorMessage = "";
    var text = text;
    var error = error;
    
    if (/^[a-zñáéíóúA-ZÑÁÉÍÓÚ0-9\s]*$/.test(text)) {
        ok = true;
    } else {

        if (window.location.href.slice(-2) == "en") {
            errorMessage = "The fields accepts only letters, numbers and spaces.";            
        } else {
            errorMessage = "Los campos sólo admite letras, numeros y espacios.";
        }

    }

    if(ok) {
        return true;
    } else {
        error.innerHTML = errorMessage;
        return false;
    }
}

/*validateInfoUpdate devuelve true si todos los campos de la actualización
cumplen los requisitos y false si no los cumplen*/
function validateInfoUpdate() {    
    var pass = document.getElementById("npass").value;
    var npassError = document.getElementById("npassError");
    
    var okEmail = validateEmail();
    var okPass = validatePass(pass, npassError);
    var okPassEquality = validatePassEquality();
    var okAtLeastOneFieldUpdated = atLeastOneFieldUpdated();
    
    if (okEmail && okPass && okPassEquality && okAtLeastOneFieldUpdated) {
        return true;
    } else {
        return false;
    } 
}


/*ValidateMEssage valida las entradas de los campos de contacto con los desarrolladores*/
function validateMessage(){
    var subject = document.getElementById("subject").value;
    var message = document.getElementById("message").value;
    var error = document.getElementById("messageError");

    var okSubject = validateText(subject, error);
    var okMessage = validateText(message, error);

    if (okSubject && okMessage) {
        if (window.location.href.slice(-2) == "en") {
            alert("Message sent, thanks");
        } else {
            alert("Mensaje enviado, gracias");
        }
        
        return true;               
    } else {
        return false;
    } 
}