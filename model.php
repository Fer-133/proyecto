<?php

//Funcion para conectar con la base de datos
function dbConnection(){
    @$mysqli = new mysqli("localhost", "otro", "otro", "doit_tickit");
    if($mysqli->connect_errno){
        return null;
    } else {
        $mysqli->set_charset("utf8");
        return $mysqli;
    }
}

//checkUserDuplicity comprueba que el nombre de usuario no sea uno que ya esta en uso.
function checkUserDuplicity($userName) {
    $mysqli = dbConnection();
    $sql = "SELECT * FROM users WHERE userName = '$userName'";
    if ($result = $mysqli->query($sql)) {
        if ($result->num_rows > 0) {
            return true;
        }
    }
    return false;
}

//checkEmailDuplicity comprueba que el email no sea uno que ya esta en uso
function checkEmailDuplicity($email) {
    $mysqli = dbConnection();
    $sql = "SELECT * FROM users WHERE email = '$email'";
    if ($result = $mysqli->query($sql)) {
        if ($result->num_rows > 0) {
            return true;
        }
    }
    return false;
}

//checkCorrectPass comprueba que se esta utilizando la contraseña de usuario correcta
function checkCorrectPass($user, $pass) {
    $mysqli = dbConnection();
    $pass = crypt($pass, "123pass");
    $sql = "SELECT password FROM users WHERE userName = '$user'";
    if ($result = $mysqli->query($sql)) {
        if ($result->num_rows > 0) {
            while ($user = $result->fetch_array()){
                if ($pass === $user["password"]) {
                    return true;
                }
            } 
        }
    }
    return false;
}

//updateUser actualiza los datos del usuario
function updateUser($user, $email, $password) {
    $mysqli = dbConnection(); 

    if ($email === "") {
        $password = crypt($password, "123pass");   
        $sql = "UPDATE users SET password = '$password' WHERE userName='$user'";        

    } else if ($password === "") {
    
        $sql = "UPDATE users SET email = '$email'  WHERE userName='$user'";        

    } else {
    
        $password = crypt($password, "123pass");   
        $sql = "UPDATE users SET password = '$password', email = '$email'  WHERE userName='$user'";
    }

    echo "Pasa";
    $mysqli->query($sql);
}

//Register guarda un nuevo usuario en la base de datos
function register($userName, $email, $password, $language, $theme){
    $mysqli = dbConnection();
    $password = crypt($password, "123pass");
    $id = uniqid();
    $sql = "INSERT INTO users VALUES ('$id', '$userName', '$email', '$password', 0, '$language', '$theme')";
    $mysqli->query($sql);

    if ($mysqli->error) {
        echo "<script type='text/javascript'>alert('INSERCCION INCORRECTA');</script>";
    } else {
        if ($mysqli->affected_rows == 0) {
            echo "<script type='text/javascript'>alert('NO SE HA INSERTADO NINGUN REGISTRO');</script>";
        } else {
            echo "<script type='text/javascript'>alert('USUARIO REGISTRADO');</script>";
        }
    }    
}

//login compruebo del login
function login($user, $pass) {
    $mysqli = dbConnection();
    $pass = crypt($pass, "123pass");
    $sql = "SELECT * FROM users WHERE userName = '$user' AND password = '$pass'";
    if ($result = $mysqli->query($sql)) {
        if ($result->num_rows > 0) {
            return true;
        }
    }
    return false;
}

//getLanguage obtiene el leguaje del usuario
function getLanguage($user) {
    $mysqli = dbConnection();    
    $sql = "SELECT language FROM users WHERE userName = '$user'";
    if ($results = $mysqli->query($sql)) {
        if ($results->num_rows > 0) {
            while ($result = $results->fetch_array()){
                return $result["language"];
            }
        }
    }
    return false;
}

//getTheme obtiene el tema del usuario
function getTheme($user) {
    $mysqli = dbConnection();    
    $sql = "SELECT theme FROM users WHERE userName = '$user'";
    if ($results = $mysqli->query($sql)) {
        if ($results->num_rows > 0) {
            while ($result = $results->fetch_array()){
                return $result["theme"];
            }
        }
    }
    return false;
}

//saveOptions guardas las opciones del tema del usuario
function saveOptions($user, $language, $theme) {
    $mysqli = dbConnection();    
    $sql = "UPDATE users SET language = '$language', theme = '$theme' WHERE userName='$user'";
    $mysqli->query($sql);
    return false;
}



//Inserta un nuevo habito en la base de datos
function insertHabit($name, $type, $points, $owner) {
    $id = uniqid("asf");
    $mysqli = dbConnection();
    $sql = "INSERT INTO habits VALUES ('$id', '$name', '$type', '$points', '$owner')";
    $mysqli->query($sql);
}

//Modifica un habito en la base de datos
function editHabit($name, $type, $points, $id) {    
    $mysqli = dbConnection();  
    $sql = "UPDATE habits SET name = '$name', type = '$type', points = '$points' WHERE id = '$id'";
    $mysqli->query($sql);   
}


//Devuelve todos los habitos de un usuario
function getHabits($owner) {
    $mysqli = dbConnection();
    $sql = "SELECT id, name, type, points FROM habits WHERE owner = '$owner'";
    if ($result = $mysqli->query($sql)) {
        return $result;
    }
    return null;
}

//Borra el habito pasado por parametro de la base de datos
function deleteHabit($id) {
    $mysqli = dbConnection();
    $sql = "DELETE FROM `habits` WHERE id = '$id'";
    $mysqli->query($sql);
}


//Obtiene los puntos del usuario
function getPoints($userName) {
    $mysqli = dbConnection();
    $sql = "SELECT points FROM users WHERE userName = '$userName'";
    if ($result = $mysqli->query($sql)) {
        return $result;
    }
    return null;
}

//Modifica los puntos del usuario
function updatePoints($user, $type, $amount) {
    $mysqli = dbConnection(); 
    $sql = "";
    if (strcmp($type, "positive") === 0) {
        $sql = "UPDATE users SET points = points + '$amount' WHERE userName='$user'";	   
    } else if (strcmp($type, "negative") === 0) {
        $sql = "UPDATE users SET points = points - '$amount' WHERE userName='$user'";	   
    }    
    $mysqli->query($sql);
}

//Inserta una nueva tarea en la base de datos
function insertTask($name, $description, $points, $owner) {
    $id = uniqid("asf");
    $mysqli = dbConnection();
    $sql = "INSERT INTO tasks VALUES ('$id', '$name', '$description', '$points', '$owner')";
    $mysqli->query($sql);
}

//Modifica una tarea en la base de datos
function editTask($name, $description, $points, $id) {    
    $mysqli = dbConnection();  
    $sql = "UPDATE tasks SET name = '$name', description = '$description', points = '$points' WHERE id = '$id'";
    $mysqli->query($sql);   
}

//Devuelve todas las tareas de un usuario
function getTasks($owner) {
    $mysqli = dbConnection();
    $sql = "SELECT id, name, description, points FROM tasks WHERE owner = '$owner'";
    if ($result = $mysqli->query($sql)) {
        return $result;
    }
    return null;
}

//Borra la tarea pasado por parametro de la base de datos
function deleteTask($id) {
    $mysqli = dbConnection();
    $sql = "DELETE FROM `tasks` WHERE id = '$id'";
    $mysqli->query($sql);
}

//Inserta una nueva tarea diaria en la base de datos
function insertDailyTask($name, $description, $points, $owner) {
    $id = uniqid("asf");
    $lastCheck = date('Y-m-d');
    echo $lastCheck;
    $mysqli = dbConnection();
    $sql = "INSERT INTO daily_tasks VALUES ('$id', '$name', '$description', '$points', '$lastCheck', 0, '$owner')";
    $mysqli->query($sql);
}


//Modifica una tarea en la base de datos
function editDailyTask($name, $description, $points, $id) {    
    $mysqli = dbConnection();  
    $sql = "UPDATE daily_tasks SET name = '$name', description = '$description', points = '$points' WHERE id = '$id'";
    $mysqli->query($sql);   
}


//Devuelve todas las tareas diarias de un usuario
function getDailyTasks($owner) {
    $mysqli = dbConnection();
    $sql = "SELECT id, name, description, points, last_check, checked FROM daily_tasks WHERE owner = '$owner'";
    if ($result = $mysqli->query($sql)) {
        return $result;
    }
    return null;
}

//Actualiza una tarea diaria
function updateDailyTask($id, $last_check, $checked) {        
    $mysqli = dbConnection(); 
    $sql = "UPDATE daily_tasks SET last_check = '$last_check', checked = '$checked' WHERE id='$id'";	   
    $mysqli->query($sql);       
}

//Borra la tarea pasado por parametro de la base de datos
function deleteDailyTask($id) {
    $mysqli = dbConnection();
    $sql = "DELETE FROM `daily_tasks` WHERE id = '$id'";
    $mysqli->query($sql);
}

//Inserta una nueva recompensa en la base de datos
function insertReward($name, $price, $owner) {
    $id = uniqid("asf");
    $mysqli = dbConnection();
    $sql = "INSERT INTO rewards VALUES ('$id', '$name', '$price', '$owner')";
    $mysqli->query($sql);    
}

//modifica una recompensa en la base de datos
function editReward($name, $price, $id) {    
    $mysqli = dbConnection();
    $sql = "UPDATE rewards SET name = '$name', price = '$price' WHERE id = '$id'";    
    $mysqli->query($sql);    
}

//Devuelve todas las recompensas de un usuario
function getRewards($owner) {
    $mysqli = dbConnection();
    $sql = "SELECT id, name, price FROM rewards WHERE owner = '$owner'";
    if ($result = $mysqli->query($sql)) {
        return $result;
    }
    return null;
}

//Borra la recompensa pasado por parametro de la base de datos
function deleteReward($id) {
    $mysqli = dbConnection();
    $sql = "DELETE FROM `rewards` WHERE id = '$id'";
    $mysqli->query($sql);
}

//Borra la cuenta del usuario asi como la información relacionada con el
function deleteAccount($name) {
    $mysqli = dbConnection();
    $sql = "DELETE FROM users WHERE userName = '$name'";
    $mysqli->query($sql);
}

//Inserta un nuevo mensaje en la base de datos
function insertMessage($subject, $message, $owner) {    
    $id = uniqid("hgf");
    $mysqli = dbConnection();
    $sql = "INSERT INTO messages VALUES ('$id', '$subject', '$message', '$owner')";
    $mysqli->query($sql);    
}
?>