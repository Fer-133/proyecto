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

        if (strcmp($_SESSION["lang"], "es")){
            echo "There is already an account with that name."; 
        } else {
            echo "Ya existe una cuenta con ese nombre.";
        }
        //echo "Ya existe una cuenta con ese nombre";
    } else {
        return null;
        //echo "";
    }
}

//Busca el orreo en la base de datos y si lo encuentra devuelve un aviso a login
if(isset($_GET["email"])) {
    $email = $_GET["email"];    
    if (checkEmailDuplicity($email)) {
        if (strcmp($_SESSION["lang"], "es")){
            echo "There is already an account with that email."; 
        } else {
            echo "Ya existe una cuenta con ese email.";
        }
        //echo "Ya existe una cuenta con ese email";
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
    header("location: /proyecto/index.php");    
    exit;
}

//Borra la cuenta
if (isset($_POST["deleteAccount"])) {
    deleteAccount($_SESSION["user"]);     
    header("location: /proyecto/index.php");
    exit;    
}

//Reinicia la cuenta
if (isset($_POST["resetAccount"])) {
    resetAccount($_SESSION["user"]);
}

//Controladores

//Controlador de index
function index_controller() {
    
    require "templates/login/" . $_SESSION['lang'] . ".php";    
    require "templates/login/login.php";         
    require "validators.php";
/*
    if (!isset($_COOKIE["theme"])) {
        $theme = "light";
    } else {
        $theme = $_COOKIE["theme"];
    }
*/
    //Procesamiento del registro de un usuario nuevo
    if(isset($_POST["register"])){
        if (isEmail($_POST["email"]) && checkUserDuplicity($_POST["nuser"])){

            if (strcmp($_SESSION["lang"], "es")){
                echo "<script type='text/javascript'>alert('There is already an account with that name');</script>";
            } else {
                echo "<script type='text/javascript'>alert('Ese nombre de usuario ya existe');</script>";
            }
            //echo "<script type='text/javascript'>alert('Ese nombre de usuario ya existe');</script>";

        } else if (isValidUserName($_POST["nuser"]) && checkEmailDuplicity($_POST["email"])) {

            if (strcmp($_SESSION["lang"], "es")){
                echo "<script type='text/javascript'>alert('There is already an account with that email');</script>";
            } else {
                echo "<script type='text/javascript'>alert('Ya existe una cuenta con ese email');</script>";
            }

            //echo "<script type='text/javascript'>alert('Ya existe una cuenta con ese email');</script>";    

        } else if(isEmail($_POST["email"]) && isValidUserName($_POST["nuser"]) && isValidPass($_POST["npass"]) && strcmp($_POST["npass"], $_POST["cpass"]) === 0) {       
            
            register($_POST["nuser"], $_POST["email"], $_POST["npass"], $_SESSION["lang"], "no");
            $_SESSION["user"] = $_POST["nuser"];
            //setcookie("theme", $theme);
            
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
                
                if (strcmp($_SESSION["lang"], "es")){
                    echo "<script type='text/javascript'>alert('Wrong username or password');</script>";
                } else {
                    echo "<script type='text/javascript'>alert('Usuario o contrase??a erroneo');</script>";
                }

                //echo "<script type='text/javascript'>alert('Usuario o contrase??a erroneo');</script>";
            }
        } else {
            if (strcmp($_SESSION["lang"], "es")){
                echo "<script type='text/javascript'>alert('Wrong username or password');</script>";
            } else {
                echo "<script type='text/javascript'>alert('Usuario o contrase??a erroneo');</script>";
            }    
        }
    } 
}

//CONTROLADOR DE MAIN
function main_controller() { 

    if(getAvatarExtension($_SESSION["user"])){
        $_SESSION["avatar"] = "yes";
        $_SESSION["avatarExtension"] = getAvatarExtension($_SESSION["user"]);
    }
    
    require "templates/main/" . $_SESSION['lang'] . ".php";    
    require "validators.php";
    require "templates/main/main.php";  

    //Procesamiento de la creaci??n de un habito
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
    

    //Procesamiento de la creaci??n de una tarea
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


    //Procesamiento de la creaci??n de una tarea diaria
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


    //Procesamiento de la creaci??n de una recompensa
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

    //Procesamiento de la actualizaci??n de los datos del usuario
    if(isset($_POST["updateInfo"])){

        if (isEmail($_POST["email"]) && checkEmailDuplicity($_POST["email"])) {

            if (strcmp($_SESSION["lang"], "en")){
                echo "<script type='text/javascript'>alert('Ya existe una cuenta con ese email');</script>";    
            } else {
                echo "<script type='text/javascript'>alert('An account already exists with this email address');</script>";    
            }
            

        } else if (!checkCorrectPass($_SESSION["user"], $_POST["apass"])){
            
            if (strcmp($_SESSION["lang"], "en")){
                echo "<script type='text/javascript'>alert('Contrase??a actual incorrecta');</script>";     
            } else {
                echo "<script type='text/javascript'>alert('Incorrect current password');</script>";    
            }   
        
        } else if ($_POST["npass"] === "" && $_POST["email"] === ""){

            if (strcmp($_SESSION["lang"], "en")){
                echo "<script type='text/javascript'>alert('Es necesario actualizar al menos uno de los campos');</script>";
            } else {
                echo "<script type='text/javascript'>alert('It is necessary to update at least one of the fields');</script>";    
            }   

        } else if(isEmail($_POST["email"]) || $_POST["email"] === "" && isValidPass($_POST["npass"]) || $_POST["npass"] === "" && strcmp($_POST["npass"], $_POST["cpass"]) === 0 ) {       
            
            if(updateUser($_SESSION["user"], $_POST["email"], $_POST["npass"])){
                if (strcmp($_SESSION["lang"], "en")){
                    echo "<script type='text/javascript'>alert('Informaci??n actualizada correctamente');</script>";
                } else {
                    echo "<script type='text/javascript'>alert('Info updated correctly');</script>";    
                }  
            }

        }
    }

    //Procesamiento del cambio de opciones de interfaz del usuario
    if(isset($_POST["saveOptions"])){
        saveOptions($_SESSION["user"], $_POST["language"], $_POST["theme"]);
    }


    //Procesamiento de la subida de la imagen de avatar
    if(isset($_POST["saveImage"])) {

        $error = "";
        
        $path = $_FILES["uploadedImage"]["name"];
        $ext = "." . pathinfo($path, PATHINFO_EXTENSION);
        
        $target_dir = "./uploads/";        
        $target_file = $target_dir . $_SESSION["user"] . $ext;
        $target_delete = $target_dir . $_SESSION["user"];
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Se comprueba si lo que se quiere subir es una imagen
        if(isset($_POST["saveImage"]) && $_FILES["uploadedImage"]["error"] != 4) {
            $check = getimagesize($_FILES["uploadedImage"]["tmp_name"]);
            if($check !== false) {
                //echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                //echo "File is not an image.";
                
                if (strcmp($_SESSION["lang"], "es")){
                    $error = "File is not an image. ";
                } else {
                    $error = "El archivo no es una imagen. ";
                }
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        /*
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        */

        // Se comprueba el tama??o de la imagen a subit
        if ($_FILES["uploadedImage"]["size"] > 50000 && $uploadOk != 0) {
            //echo "Sorry, your file is too large.";

            if (strcmp($_SESSION["lang"], "es")){
                $error = $error . "Your file is too large, the maximum size is 50kb. ";
            } else {
                $error = $error . "La imagen que quieres subir es muy pesada, el tama??o maximo es de 50kb. ";
            }
            $uploadOk = 0;
        }

        // Se comprueba que el formato del archivo a subir sea el de una imagen
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $uploadOk != 0) {
            //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

            if (strcmp($_SESSION["lang"], "es")){
                $error = $error . "Only JPG, JPEG, PNG & GIF files are allowed. ";
            } else {
                $error = $error . "Solo se admiten archivos JPG, JPEG, PNG y GIF. ";
            }
            $uploadOk = 0;
        }

        // Si uploadOk es igual a 0 no se sube la imagen
        if ($uploadOk == 0) {
            //echo "Sorry, your file was not uploaded.";
            if (strcmp($_SESSION["lang"], "es")){
                $error = $error . "Sorry, your picture was not uploaded.";
            } else {
                $error = $error . "Tu imagen no se ha subido.";
            }

            echo "<script type='text/javascript'>alert('$error');</script>"; 
        // Si todo es correcto se sube la imagen
        } else {

            @unlink($target_delete . ".png");
            @unlink($target_delete . ".jpg");
            @unlink($target_delete . ".jpeg");
            @unlink($target_delete . ".gif");
            if (move_uploaded_file($_FILES["uploadedImage"]["tmp_name"], $target_file)) {

                if (strcmp($_SESSION["lang"], "es")){
                    echo "<script type='text/javascript'>alert('Avatar changed successfully.');</script>"; 
                } else {
                    echo "<script type='text/javascript'>alert('Avatar cambiado correctamente.');</script>"; 
                }
                //echo "The file ". htmlspecialchars( basename( $_FILES["uploadedImage"]["name"])). " has been uploaded.";
                setAvatarExtension($_SESSION["user"], $ext);
            } else {
                //echo "Sorry, there was an error uploading your file.";
                if (strcmp($_SESSION["lang"], "es")){
                    echo "<script type='text/javascript'>alert('Sorry, there was an error uploading your file.');</script>"; 
                } else {
                    echo "<script type='text/javascript'>alert('Ha habido un error al subir su archivo.');</script>"; 
                }
            }
        }
    }

    //Procesamiento del envio de un mensaje a los desarrolladores
    if (isset($_POST["sendMessage"])) {
        if (isValidTextMessage($_POST["subject"]) && isValidTextMessage($_POST["message"])) {
            insertMessage($_POST["subject"], $_POST["message"],$_SESSION["user"]);
        }
    }    
}

//ob_end_flush();
?>