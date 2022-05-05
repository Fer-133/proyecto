<?php
//require_once("modelo.php");
const IN_CONTROLLER = true;
require_once("controllers.php");
/*require_once("model.php");*/

//Se analiza la url solicitada
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode("/", $path);
$URI = $segments[count($segments)-1];

//Se llama al controlador determinado dependiendo de la uri solicitada
if ($URI == "index.php") {
    index_controller();
} else if ($URI == "main"){    
    main_controller();
} else if ($URI == "profile") {
    profile_controller();
} else {
    header('Status: 404 Not Found');
    echo "<html><body><h1>La página a la que intenta acceder no existe</h1></body></html>";
}
?>