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

/*validateHabit devuelve true si los campos de nuevo habito cumplen los requisitos
y false si no los cumplen*/
function validateHabit() {  
    var habitName = document.getElementById("habitName").value;
    var error = document.getElementById("habitError");   

    var okText = validateText(habitName, error);    
        
    if (okText) {             
        return true;
    } else {
        return false;
    }       
}

/*validateHabitEdition devuelve true si los campos de la modificacion del habito cumplen los requisitos
y false si no los cumplen*/
function validateHabitEdition() {  
    var habitName = document.getElementById("newHabitName").value;
    var error = document.getElementById("habitEditionError");   

    var okText = validateText(habitName, error);    
        
    if (okText) {               
        return true;
    } else {
        return false;
    }       
}

/*validateTask devuelve true si los campos de la nueva tarea cumplen los requisitos
y false si no los cumplen*/
function validateTask() {  
    var taskName = document.getElementById("taskName").value;
    var taskDescription = document.getElementById("taskDescription").value;    
    var error = document.getElementById("taskError");

    var okName = validateText(taskName, error);    
    var okDescription = validateText(taskDescription, error);        
        
    if (okName && okDescription) {            
        return true;
    } else {
        return false;
    }       
}

/*validateTaskEdition devuelve true si los campos de la tarea modificada cumplen los requisitos
y false si no los cumplen*/
function validateTaskEdition() {  
    var taskName = document.getElementById("newTaskName").value;
    var taskDescription = document.getElementById("newTaskDescription").value;    
    var error = document.getElementById("taskEditionError");

    var okName = validateText(taskName, error);    
    var okDescription = validateText(taskDescription, error);        
        
    if (okName && okDescription) {              
        return true;
    } else {
        return false;
    }       
}


/*validateDailyTask devuelve true si los campos de la nueva tarea diaria cumplen los requisitos
y false si no los cumplen*/
function validateDailyTask() {  
    var dailyTaskName = document.getElementById("dailyTaskName").value;
    var dailyTaskDescription = document.getElementById("dailyTaskDescription").value;
    var error = document.getElementById("dailyTaskError");   

    var okName = validateText(dailyTaskName, error);    
    var okDescription = validateText(dailyTaskDescription, error);    
        
    if (okName && okDescription) {             
        return true;
    } else {
        return false;
    }       
}


/*validateDailyTaskEdition devuelve true si los campos de la tarea diaria modificada cumplen los requisitos
y false si no los cumplen*/
function validateDailyTaskEdition() {  
    var dailyTaskName = document.getElementById("newDailyTaskName").value;
    var dailyTaskDescription = document.getElementById("newDailyTaskDescription").value;
    var error = document.getElementById("dailyTaskEditionError");   

    var okName = validateText(dailyTaskName, error);    
    var okDescription = validateText(dailyTaskDescription, error);    
        
    if (okName && okDescription) {           
        return true;
    } else {
        return false;
    }       
}


/*validateReward devuelve true si los campos de la nueva recompensa cumplen los requisitos
y false si no los cumplen*/
function validateReward() {  
    var rewardName = document.getElementById("rewardName").value;
    var errorName = document.getElementById("rewardError");   

    var okName = validateText(rewardName, errorName);    
        
    if (okName) {                
        return true;
    } else {
        return false;
    }       
}

/*validateRewardEdition devuelve true si los campos de la recompensa modificada cumplen los requisitos
y false si no los cumplen*/
function validateRewardEdition() {  
    var rewardName = document.getElementById("newRewardName").value;
    var errorName = document.getElementById("rewardNameEditionError");   

    var okName = validateText(rewardName, errorName);    
        
    if (okName) {               
        return true;
    } else {
        return false;
    }       
}