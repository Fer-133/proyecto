<?php
//ob_start();
session_start();
if(!isset($_SESSION["lang"])){
    $_SESSION["lang"] = "es";    
} else if (isset($_GET["lang"])) {
    $_SESSION["lang"] = $_GET["lang"];
}


require_once("model.php");
//Busca el nombre del usuario en la base de datos y si lo encuentra devuelve un aviso a login
if(isset($_GET["nuser"])) {
    $name = $_GET["nuser"];    
    if (checkUserDuplicity($name)) {
        echo "Ya existe una cuenta con ese nombre";
    } else {
        return null;
        //echo "";
    }
}

//Busca el orreo en la base de datos y si lo encuentra devuelve un aviso a login
if(isset($_GET["email"])) {
    $email = $_GET["email"];    
    if (checkEmailDuplicity($email)) {
        echo "Ya existe una cuenta con ese email";
    } else {
        echo "";
    }
}


//Es pedido asincronamente desde main para devolver los habitos a main pedidos por ajax
if (isset($_GET["loadHabits"])){    
    $habits = getHabits($_SESSION["user"]);
    
    while ($habit = $habits->fetch_array()){  
        echo "<div class='habit'>";
        echo "<div>";
        echo "<div class='name' value='" . $habit["id"] . "'>" . $habit["name"] . "</div>"; 
        echo "<div>Puntos: <div class='point'>" . $habit["points"] . "</div></div>";         
        echo "</div>";
                
        if ($habit["type"] == 1) {
            echo "<div>";
            echo '<button type="button" class="reinforcement" value="positive"></button>';
            echo "</div>";
        } else if ($habit["type"] == 2) {
            echo "<div>";
            echo '<button type="button" class="reinforcement" value="negative"></button>';
            echo "</div>";
        } else {
            echo "<div>";
            echo '<button type="button" class="reinforcement" value="positive"></button>';
            echo "</div>";
            echo "<div>";            
            echo '<button type="button" class="reinforcement" value="negative"></button>';
            echo "</div>";
        }
        
        
        echo "<div>";
        echo '<button type="button" class="deleteHabit" value=' . $habit["id"] . '></button>';
        echo "</div>";
        
        echo "</div>";
        echo "<br/>";
    }         
}

//Es pedido asincronamente desde main para devolver las tareas a main pedidos por ajax
if (isset($_GET["loadTasks"])){    
    $tasks = getTasks($_SESSION["user"]);    
    while ($task = $tasks->fetch_array()){         
        echo "<div class='task'>";  
        echo "<div>";      
        echo "<div class='name' value='" . $task["id"] . "'>" . $task["name"] . "</div>"; 
        echo "<div class='description'>" . $task["description"] . "</div>";         
        echo "<div>Puntos: <div class='point'>" . $task["points"] . "</div></div>";        
        echo "</div>";
        echo "<div>";
        echo '<button type="button" class="completeTask" value=' . $task["id"] . '></button>';        
        
        echo "</div>";
        echo "<div>";
        
        echo '<button type="button" class="deleteTask" value=' . $task["id"] . '></button>';            
        echo "</div>";
        echo "</div>";
        echo "<br/>";
    }         
}

//Es pedido asincronamente desde main para devolver las tareas diarias a main pedidos por ajax
if (isset($_GET["loadDailyTasks"])){    
    $dailyTasks = getDailyTasks($_SESSION["user"]);    
    while ($dailyTask = $dailyTasks->fetch_array()){         
        echo "<div class='dailyTask'>";        
        echo "<div>";
        echo "<div class='name' value='" . $dailyTask["id"] . "'>" . $dailyTask["name"] . "</div>"; 
        echo "<div class='description'>" . $dailyTask["description"] . "</div>"; 
        echo "<div>Puntos: <div class='point'>" . $dailyTask["points"] . "</div></div>";

        //Si la fecha del ultimo check es menor a la fecha actual se actualiza la tarea
        //diaria para quitarle el check y poder volver a ponerselo el presente dia.
        if ($dailyTask["last_check"] < date('Y-m-d')) {
            updateDailyTask($dailyTask["id"], date('Y-m-d'), 0);
            $dailyTask["checked"] = 0;
        }
        echo "</div>";
        echo "<div>";
        if ($dailyTask["checked"] == 1) {
            echo '<input type="checkbox" class="checkDailyTask" value=' . $dailyTask["id"] . ' checked />';        
        } else {
            echo '<input type="checkbox" class="checkDailyTask" value=' . $dailyTask["id"] . ' />';        
        }        
        echo "</div>";
        echo "<div>";        
        echo '<button type="button" class="deleteDailyTask" value=' . $dailyTask["id"] . '></button>';            
        echo "</div>";
        echo "</div>";
        echo "<br/>";
    }         
}

//Es pedido asincronamente desde main para devolver las recompensas a main pedidos por ajax
if (isset($_GET["loadRewards"])){ 

    $points = getPoints($_SESSION["user"]);
    while ($point = $points->fetch_array()){

        $rewards = getRewards($_SESSION["user"]);    
        while ($reward = $rewards->fetch_array()){        
            echo "<div class='reward'>";
            echo "<div>";
            echo "<div class='name' value='" . $reward["id"] . "'>" . $reward["name"] . "</div>";            
            echo "<div>Precio: <div class='price'>" . $reward["price"] . "</div></div>";
            echo "</div>";

            //echo "<div>";
            if($point["points"] < $reward["price"]) {
                echo '<button type="button" class="buyReward" value=' . $reward["id"] . ' disabled ></button>';
            } else {
                echo '<button type="button" class="buyReward" value=' . $reward["id"] . '></button>';
            }
            /*
            echo "</div>";
            echo "<div>";
            */
            echo '<button type="button" class="deleteReward" value=' . $reward["id"] . '></button>';            
            //echo "</div>";
            echo "</div>";
            echo "<br/>";
        }         
    }
           
}

//Es pedido asincronamente desde main para devolver los puntos del usuario en el apartado de puntos
if (isset($_GET["loadPoints"])) {
    $points = getPoints($_SESSION["user"]);
    while ($point = $points->fetch_array()){
        echo $point["points"];
    }
}

//Es pedido asincronamente desde main para completar la tarea y recibir los puntos
if (isset($_POST["completeTask"])) {
    updatePoints($_SESSION["user"], "positive", $_POST["points"]);
    deleteTask($_POST["id"]);
}

//Es pedido asincronamente desde main para checkear la tarea y recibir los puntos
if (isset($_POST["checkDailyTask"])) {
    $checked = 0;
    if ($_POST["type"] == "positive") {
        $checked = 1;
    }
    updateDailyTask($_POST["id"], date('Y-m-d'), $checked);    
    updatePoints($_SESSION["user"], $_POST["type"], $_POST["points"]);    
}

//Es pedido asincronamente desde main para comprar una recompensa y disminuir los puntos
if (isset($_POST["buyReward"])) {
    updatePoints($_SESSION["user"], "negative", $_POST["price"]);    
}

//Es pedido asincronamente desde main para actualizar los puntos en la base de datos
if (isset($_POST["updatePoints"])) {
    if($_POST["type"]) {
        updatePoints($_SESSION["user"], $_POST["type"], $_POST["points"]);
    }
}


//Es pedido asincronamente desde main para borrar un habito
if (isset($_POST["deleteHabit"])){
    if($_POST["id"]){
        deleteHabit($_POST["id"]);
    }    
}

//Es pedido asincronamente desde main para borrar una tarea
if (isset($_POST["deleteTask"])){
    if($_POST["id"]){
        deleteTask($_POST["id"]);
    }    
}

//Es pedido asincronamente desde main para borrar una tarea diaria
if (isset($_POST["deleteDailyTask"])){
    if($_POST["id"]){
        deleteDailyTask($_POST["id"]);
    }    
}

//Es pedido asincronamente desde main para borrar una recompensa
if (isset($_POST["deleteReward"])){
    if($_POST["id"]){
        deleteReward($_POST["id"]);
    }    
}

//Cerrar la sesion
if (isset($_POST["closeSession"])){
    $_SESSION = array();
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();                
    //header("location: index.php");
    header("location: /proyecto/index.php");    
    exit;
}


if (isset($_POST["deleteAccount"])) {
    deleteAccount($_SESSION["user"]);    
    //header("location: index.php");
    header("location: /proyecto/index.php");
    exit;    
}


//Controladores

//Controlador de index
function index_controller() {
    
    require "templates/login/" . $_SESSION['lang'] . ".php";    
    require "templates/login/login.php";         
    require "validators.php";

    if (!isset($_COOKIE["theme"])) {
        $theme = "light";
    } else {
        $theme = $_COOKIE["theme"];
    }
    
    //Procesamiento del registro de un usuario nuevo
    if(isset($_POST["register"])){
        if (isEmail($_POST["email"]) && checkUserDuplicity($_POST["nuser"])){

            echo "<script type='text/javascript'>alert('Ese nombre de usuario ya existe');</script>";

        } else if (isValidUserName($_POST["nuser"]) && checkEmailDuplicity($_POST["email"])) {

            echo "<script type='text/javascript'>alert('Ya existe una cuenta con ese email');</script>";    

        } else if(isEmail($_POST["email"]) && isValidUserName($_POST["nuser"]) && isValidPass($_POST["npass"]) && strcmp($_POST["npass"], $_POST["cpass"]) === 0) {       
            
            echo "pasa 1";

            register($_POST["nuser"], $_POST["email"], $_POST["npass"], $_SESSION["lang"], $theme);
            $_SESSION["user"] = $_POST["nuser"];

            echo "pasa 2";
            
            header('Location: /proyecto/index.php/main?lang=' . $_SESSION["lang"]);
            
            exit;
        }
    }

    //Procesamiento del inicio de sesion
    if (isset($_POST["logIn"])) {
        if (isValidUserName($_POST["user"]) && isValidPass($_POST["pass"])) {
            if (login($_POST["user"], $_POST["pass"])) {
                /*
                echo "<script type='text/javascript'>alert('Validado');</script>";    
                */
                $_SESSION["user"] = $_POST["user"];

                setcookie("theme", getTheme($_SESSION["user"]));
                
                header('Location: /proyecto/index.php/main?lang=' . getLanguage($_SESSION["user"]));
                
                exit;
            } else {
                echo "<script type='text/javascript'>alert('Usuario o contraseña erroneo');</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('Usuario o contraseña erroneo');</script>";    
        }
    } 
}

//CONTROLADOR DE PRUEBA
function main_controller() { 
    
    require "templates/main/" . $_SESSION['lang'] . ".php";    
    require "validators.php";
    require "templates/main/main.php";  

    //Procesamiento de la creación de un habito
    if (isset($_POST["createHabit"])) {
        if (isValidText($_POST["habitName"])) {
            insertHabit($_POST["habitName"], $_POST["habitType"], $_POST["habitPoints"],$_SESSION["user"]);
        }
    }  
    
    //Procesamiento de la modificacion de un habito
    if (isset($_POST["editHabit"])) {        
        if (isValidText($_POST["newHabitName"])) {
            editHabit($_POST["newHabitName"], $_POST["newHabitType"], $_POST["newHabitPoints"],$_POST["habitId"]);                        
        }
    } 
    

    //Procesamiento de la creación de una tarea
    if (isset($_POST["createTask"])) {
        if (isValidText($_POST["taskName"]) && isValidText($_POST["taskDescription"])) {
            insertTask($_POST["taskName"], $_POST["taskDescription"], $_POST["taskPoints"], $_SESSION["user"]);
        }
    }

    //Procesamiento de la modificacion de una tarea
    if (isset($_POST["editTask"])) {        
        if (isValidText($_POST["newTaskName"]) && isValidText($_POST["newTaskDescription"])) {
            editTask($_POST["newTaskName"], $_POST["newTaskDescription"], $_POST["newTaskPoints"],$_POST["taskId"]);                        
        }
    } 


    //Procesamiento de la creación de una tarea diaria
    if (isset($_POST["createDailyTask"])) {
        if (isValidText($_POST["dailyTaskName"]) && isValidText($_POST["dailyTaskDescription"])) {            
            insertDailyTask($_POST["dailyTaskName"], $_POST["dailyTaskDescription"], $_POST["dailyTaskPoints"], $_SESSION["user"]);
        }
    }

    //Procesamiento de la modificacion de una tarea diaria
    if (isset($_POST["editDailyTask"])) {        
        if (isValidText($_POST["newDailyTaskName"]) && isValidText($_POST["newDailyTaskDescription"])) {
            editDailyTask($_POST["newDailyTaskName"], $_POST["newDailyTaskDescription"], $_POST["newDailyTaskPoints"],$_POST["dailyTaskId"]);                        
        }
    } 


    //Procesamiento de la creación de una recompensa
    if (isset($_POST["createReward"])) {
        if (isValidText($_POST["rewardName"])) {
            insertReward($_POST["rewardName"], $_POST["rewardPrice"], $_SESSION["user"]);
        }
    }

    //Procesamiento de la modificacion de una recompensa
    if (isset($_POST["editReward"])) {
        if (isValidText($_POST["newRewardName"])) {
            editReward($_POST["newRewardName"], $_POST["newRewardPrice"], $_POST["rewardId"]);
        }
    }

}

//CONTROLADOR DE PROFILE
function profile_controller(){
    require "validators.php";
    require "templates/profile/" . $_SESSION['lang'] . ".php";    
    require "templates/profile/profile.php";

    //Procesamiento de la actualización de los datos del usuario
    if(isset($_POST["updateInfo"])){

        if (isEmail($_POST["email"]) && checkEmailDuplicity($_POST["email"])) {

            echo "<script type='text/javascript'>alert('Ya existe una cuenta con ese email');</script>";    

        } else if (!checkCorrectPass($_SESSION["user"], $_POST["apass"])){

            echo "<script type='text/javascript'>alert('Contraseña actual incorrecta');</script>";    
        
        } else if ($_POST["npass"] === "" && $_POST["email"] === ""){

            echo "<script type='text/javascript'>alert('Es necesario actualizar al menos uno de los campos');</script>";    

        } else if(isEmail($_POST["email"]) || $_POST["email"] === "" && isValidPass($_POST["npass"]) || $_POST["npass"] === "" && strcmp($_POST["npass"], $_POST["cpass"]) === 0 ) {       
            
            updateUser($_SESSION["user"], $_POST["email"], $_POST["npass"]);

        }
    }

    //Procesamiento del cambio de opciones de interfaz del usuario
    if(isset($_POST["saveOptions"])){
        saveOptions($_SESSION["user"], $_POST["language"], $_POST["theme"]);
    }

    //Procesamiento del envio de un mensaje a los desarrolladores
    if (isset($_POST["sendMessage"])) {
        if (isValidText($_POST["subject"]) && isValidText($_POST["message"])) {
            insertMessage($_POST["subject"], $_POST["message"],$_SESSION["user"]);
        }
    }    
}

//ob_end_flush();
?>