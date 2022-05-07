//Añado Jquery al script
var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);


//Mostrar/esconder popup de creacion de nuevo habito
document.getElementById("newHabit").addEventListener("click", showHabitCreator);
document.getElementById("cancelHabit").addEventListener("click", hideHabitCreator);

function showHabitCreator() {
    document.querySelector(".popup-habit").style.display = "flex";
}

function hideHabitCreator() {
    document.querySelector(".popup-habit").style.display = "none";
    document.getElementById("habitName").innerHTML = "";    
}

//Mostrar/esconder popup de modificacion de habiton
document.getElementById("cancelHabitEdition").addEventListener("click", hideHabitEditor);
function showHabitEditor() {
    document.querySelector(".popup-habit-editor").style.display = "flex";
    
}

function hideHabitEditor() {
    document.querySelector(".popup-habit-editor").style.display = "none";    
}

//Mostrar/esconder popup de modificacion de tarea
document.getElementById("cancelTaskEdition").addEventListener("click", hideTaskEditor);
function showTaskEditor() {
    document.querySelector(".popup-task-editor").style.display = "flex";
    
}

function hideTaskEditor() {
    document.querySelector(".popup-task-editor").style.display = "none";    
}

//Mostrar/esconder popup de modificacion de tarea diaria
document.getElementById("cancelDailyTaskEdition").addEventListener("click", hideDailyTaskEditor);
function showDailyTaskEditor() {
    document.querySelector(".popup-dailyTask-editor").style.display = "flex";
    
}

function hideDailyTaskEditor() {
    document.querySelector(".popup-dailyTask-editor").style.display = "none";    
}

//Mostrar/esconder popup de modificacion de recompensa
document.getElementById("cancelRewardEdition").addEventListener("click", hideRewardEditor);
function showRewardEditor() {
    document.querySelector(".popup-reward-editor").style.display = "flex";
    
}

function hideRewardEditor() {
    document.querySelector(".popup-reward-editor").style.display = "none";    
}



//Mostrar/esconder popup de creacion de nueva tarea
document.getElementById("newTask").addEventListener("click", showTaskCreator);
document.getElementById("cancelTask").addEventListener("click", hideTaskCreator);

function showTaskCreator() {
    document.querySelector(".popup-task").style.display = "flex";
}

function hideTaskCreator() {
    document.querySelector(".popup-task").style.display = "none";
    document.getElementById("taskName").innerHTML = "";    
    document.getElementById("taskDescription").innerHTML = "";    
}


//Mostrar/esconder popup de creacion de nueva tarea diaria
document.getElementById("newDailyTask").addEventListener("click", showDailyTaskCreator);
document.getElementById("cancelDailyTask").addEventListener("click", hideDailyTaskCreator);

function showDailyTaskCreator() {
    document.querySelector(".popup-dailyTask").style.display = "flex";
}

function hideDailyTaskCreator() {
    document.querySelector(".popup-dailyTask").style.display = "none";
    document.getElementById("dailyTaskName").innerHTML = "";    
    document.getElementById("dailyTaskDescription").innerHTML = "";    
}



//Mostrar/esconder popup de creacion de nueva recompensa
document.getElementById("newReward").addEventListener("click", showRewardCreator);
document.getElementById("cancelReward").addEventListener("click", hideRewardCreator);

function showRewardCreator() {
    document.querySelector(".popup-reward").style.display = "flex";
}

function hideRewardCreator() {
    document.querySelector(".popup-reward").style.display = "none";
    document.getElementById("rewardName").innerHTML = "";    
    document.getElementById("rewardDescription").innerHTML = "";    
}

//MOSTRAR LOS PANELES
$(document).ready(function(){
    $(".title").click(function(){
       $(".pannel").slideUp("normal"); //Cualquier menú desplegado se desplaza hacia arriba, cerrándolo
       $(this).next().slideDown("normal");  //El método next() devuelve el siguiente elemento hermano del elemento seleccionado
    });
  });


//FUNCIONA
//Hace una peticion asincrona para cargar los datos de los habitos, tareas, puntos...
$(document).ready(function(){
    $("#habits").load("../controllers.php?loadHabits").val();
    $("#tasks").load("../controllers.php?loadTasks").val();
    $("#dailyTasks").load("../controllers.php?loadDailyTasks").val();
    $("#points").load("../controllers.php?loadPoints").val();
    $("#rewards").load("../controllers.php?loadRewards").val();

    //Cerrar sesion
    $("#closeSession").click(function(){
        $.post("../controllers.php", {closeSession:""});
    });



    //Borrar la cuenta
    $("#deleteAccount").click(function(){        
        $.post("../controllers.php", {deleteAccount:""});
    });


    //Borrar habito
    $("#habits").on("click", ".deleteHabit", function(){  
        var id = $(this);
        $.post("../controllers.php", {deleteHabit:"", id: id.val()})
        $("#habits").load("../controllers.php?loadHabits").val();        
    });



    //Mostrar modificador de habito
    $("#habits").on("click", ".name", function(){          
        $("#newHabitName").val($(this).text());
        var points = $(this).siblings('div:first').find('div[class="point"]');
        var count = $(this).parent().siblings().length;
        if(count == 3) {
            $("#newHabitType").val('3').change();
        } else {
            if ($(this).parent().siblings('div:first').find('button').val() == "positive") {
                $("#newHabitType").val('1').change();
            } else {
                $("#newHabitType").val('2').change();
            }
        }
        $("#newHabitPoints").val(points.text());
        $("#habitEditionError").text("");
        $("#habitId").val($(this).attr("value"));

        showHabitEditor();
    });

    //Mostrar modificador de tarea
    $("#tasks").on("click", ".name", function(){          
        $("#newTaskName").val($(this).text());

        var points = $(this).siblings().eq(1).find('div[class="point"]');        
        $("#newTaskPoints").val(points.text());

        var description = $(this).siblings('div:first');
        $("#newTaskDescription").val(description.text());

        $("#taskEditionError").text("");
        $("#taskId").val($(this).attr("value"));

        showTaskEditor();
    });

    //Mostrar modificador de tarea diaria
    $("#dailyTasks").on("click", ".name", function(){          
        $("#newDailyTaskName").val($(this).text());

        var points = $(this).siblings().eq(1).find('div[class="point"]');        
        $("#newDailyTaskPoints").val(points.text());

        var description = $(this).siblings('div:first');
        $("#newDailyTaskDescription").val(description.text());

        $("#dailyTaskEditionError").text("");
        $("#dailyTaskId").val($(this).attr("value"));

        showDailyTaskEditor();
    });

    //Mostrar modificador de recompensa
    $("#rewards").on("click", ".name", function(){          
        $("#newRewardName").val($(this).text());

        var price =  $(this).siblings('div:first').find('div[class="price"]');     
        $("#newRewardPrice").val(price.text());

        $("#rewardNameEditionError").text("");
        $("#rewardId").val($(this).attr("value"));

        showRewardEditor();
    });


    //Borrar tarea
    $("#tasks").on("click", ".deleteTask", function(){  
        var id = $(this);
        $.post("../controllers.php", {deleteTask:"", id: id.val()})
        $("#tasks").load("../controllers.php?loadTasks").val();        
    });
    
    //Borrar tarea diaria
    $("#dailyTasks").on("click", ".deleteDailyTask", function(){  
        var id = $(this);
        $.post("../controllers.php", {deleteDailyTask:"", id: id.val()})
        $("#dailyTasks").load("../controllers.php?loadDailyTasks").val();
    });

    //Borrar recompensa
    $("#rewards").on("click", ".deleteReward", function(){  
        var id = $(this);
        $.post("../controllers.php", {deleteReward:"", id: id.val()})
        $("#rewards").load("../controllers.php?loadRewards").val();        
    });

    //Sumar/restar puntos por habitos
    $("#habits").on("click", ".reinforcement", function(){  
        var type = $(this);
        var points = $(this).parent().siblings('div:first').find('div[class="point"]');
        $.post("../controllers.php", {updatePoints:"", type: type.val(), points: points.text()})        
        $("#points").load("../controllers.php?loadPoints").val();
        $("#rewards").load("../controllers.php?loadRewards").val();
    });

    //Completa tarea
    $("#tasks").on("click", ".completeTask", function(){  
        var id = $(this);
        var points = $(this).parent().siblings('div:first').find('div[class="point"]');
        $.post("../controllers.php", {completeTask:"", id: id.val(), points: points.text()})
        $("#tasks").load("../controllers.php?loadTasks").val();        
        $("#points").load("../controllers.php?loadPoints").val();
        $("#rewards").load("../controllers.php?loadRewards").val();
    });

    //Checkear tarea diaria
    $("#dailyTasks").on("change", ".checkDailyTask", function(){  
        var id = $(this);
        var points = $(this).parent().siblings('div:first').find('div[class="point"]');
        var type = "negative";
        if (this.checked) {
            type = "positive";
        } 
        $.post("../controllers.php", {checkDailyTask:"", id: id.val(), type: type, points: points.text()})        
        $("#points").load("../controllers.php?loadPoints").val();
        $("#rewards").load("../controllers.php?loadRewards").val();
    });
    
    //Comprar recompensa
    $("#rewards").on("click", ".buyReward", function(){  
        var id = $(this);
        var price = $(this).parent().find('div[class="price"]');
        $.post("../controllers.php", {buyReward:"", id: id.val(), price: price.text()})        
        $("#points").load("../controllers.php?loadPoints").val();
        $("#rewards").load("../controllers.php?loadRewards").val();
    });


});

//Si esta seteada la cookie de tema oscuro se escoge el tema oscuro
if (getCookie("theme") == "dark") {
    localStorage.setItem('dark-theme', true);    
    /*document.body.classList.add('dark-theme');*/
    document.cookie = "theme=";
} 

//Si esta seteada la cookie de tema claro se escoge el tema claro
if (getCookie("theme") == "light"){
    localStorage.removeItem('dark-theme');
    document.cookie = "theme=";
}


//Mira en le localStorage si esta seteado el item dark-theme para ponerlo
if(localStorage.getItem('dark-theme')) {
    document.body.classList.add('dark-theme');
}


//Con getCookie obtenermos de vuelta el valor de la cookie pasada por parametro
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }