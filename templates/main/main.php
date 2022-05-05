<?php
/*session_start();*/

if(!defined("IN_CONTROLLER")){
    die ("Error, no se puede llamar a la vista directamente");    
}

if(!isset($_SESSION["user"]) || isset($_POST["closeSession"]) /*|| isset($_POST["deleteAccount"])*/){
    header("Location: /proyecto/templates/login/index.php");
    exit;
} 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Do it - Tick it</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style>
            @import url(/proyecto/templates/main/main.css);
        </style>    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="/proyecto/templates/main/mainFieldValidator.js"></script>        

    </head>
    <body>
        <header>
            <h1>Do it - Tick it</h1>
            <a href = "./profile?lang=<?= $_SESSION["lang"] ?>" ><!--<?= $lang['profile']?>--> <img src="/proyecto/templates/img/profile3.png"  width="50" height="50"> </a>
            <h2><?= $lang['welcome']?> <?= $_SESSION["user"]?></h2> 
            <h3><?= $lang['points']?> <div id='points'></div></h3>
        </header>
        
        <main>        
            <div class="title"><?= $lang['habits']?></div>
            <div id="habits-pannel" class = "pannel">            
                <button type="button" id="newHabit"><?= $lang['newHabit']?></button>            
                <div id="habits">
                </div>
            </div>
            
            <div class="title"><?= $lang['tasks']?></div>
            <div id="task-pannel" class = "pannel">            
                <button type="button" id="newTask"><?= $lang['newTask']?></button>
                <div id="tasks">
                </div>
            </div>

            <div class="title"><?= $lang['dailyTasks']?></div>
            <div id="dailyTask-pannel" class = "pannel">            
                <button type="button" id="newDailyTask"><?= $lang['newDailyTask']?></button>
                <div id="dailyTasks">
                </div>
            </div>

            <div class="title"><?= $lang['rewards']?></div>
            <div id="rewards-pannel" class = "pannel">            
                <button type="button" id="newReward"><?= $lang['newReward']?></button>
                <div id="rewards">
                </div>
            </div>
        </main>
       

        <!--POPUP DE HABITOS-->
        <div class="popup-habit">
            <div class="popup-habit-content">
                <h3><?= $lang['newHabit']?></h3>                                
                <form id="habitForm" action = "" method="POST" onsubmit = "return validateHabit();">
                    <label for="habitName"><?= $lang['name']?> </label>
                    <input type="text" name="habitName" id="habitName" maxlength = 40 required>
                    <!--<div id="habitError"></div><br/>-->
                    <label for="habitType"><?= $lang['type']?> </label>
                    <select name="habitType">
                        <option value=1><?= $lang['positive']?></option>
                        <option value=2><?= $lang['negative']?></option>
                        <option value=3><?= $lang['neutral']?></option>
                    </select> 
                    <label for="habitPoints"><?= $lang['rewardPoints']?> </label>
                    <input type="number" id="habitPoints" name="habitPoints" min="1" value="1" required>
                    <input type="submit" id="createHabit" value="<?= $lang['accept']?>" name="createHabit">
                    <button type="button" id="cancelHabit"><?= $lang['cancel']?></button>                    
                </form>
                <div id="habitError" class="error"></div>
            </div>
        </div>


        <!--POPUP DE TAREAS-->
        <div class="popup-task">
            <div class="popup-task-content">
                <h3><?= $lang['newTask']?></h3>                                
                <form id="taskForm" action = "" method="POST" onsubmit = "return validateTask();">
                    <label for="taskName"><?= $lang['name']?> </label>
                    <input type="text" name="taskName" id="taskName" required>
                    <!--<div id="taskNameError"></div><br/>-->
                    <label for="taskDescription"><?= $lang['description']?> </label>
                    <textarea name="taskDescription" id="taskDescription" maxlength=150></textarea>
                    <!--<div id="taskDescriptionError"></div><br/>-->
                    <label for="taskPoints"><?= $lang['rewardPoints']?> </label>
                    <input type="number" id="taskPoints" name="taskPoints" min="1" value="1" required>
                    <input type="submit" id="createTask" value="<?= $lang['accept']?>" name="createTask">
                    <button type="button" id="cancelTask"><?= $lang['cancel']?></button>                    
                </form>
                
                <div id="taskError" class="error"></div>
            </div>
        </div>

        <!--POPUP DE TAREAS DIARIAS-->        
        <div class="popup-dailyTask">
            <div class="popup-dailyTask-content">
                <h3><?= $lang['newDailyTask']?></h3>                                
                <form id="dailyTaskForm" action = "" method="POST" onsubmit = "return validateDailyTask();">
                    <label for="dailyTaskName"><?= $lang['name']?> </label>
                    <input type="text" name="dailyTaskName" id="dailyTaskName" required>
                    <!--<div id="dailyTaskNameError"></div>-->
                    <label for="dailyTaskDescription"><?= $lang['description']?> </label>
                    <textarea name="dailyTaskDescription" id="dailyTaskDescription" maxlength=150></textarea>
                    <!--<div id="dailyTaskDescriptionError"></div>-->
                    <label for="dailyTaskPoints"><?= $lang['rewardPoints']?> </label>
                    <input type="number" id="dailyTaskPoints" name="dailyTaskPoints" min="1" value="1" required>
                    <input type="submit" id="createDailyTask" value="<?= $lang['accept']?>" name="createDailyTask">
                    <button type="button" id="cancelDailyTask"><?= $lang['cancel']?></button>
                </form>        
                <div id="dailyTaskError" class="error"></div>                  
            </div>
        </div>


        <!--POPUP DE RECOMPENSAS-->
        <div class="popup-reward">
            <div class="popup-reward-content">
                <h3><?= $lang['newReward']?></h3>                                
                <form id="rewardForm" action = "" method="POST" onsubmit = "return validateReward();">
                    <label for="rewardName"><?= $lang['name']?> </label>
                    <input type="text" name="rewardName" id="rewardName" required maxlength = 40>
                    <!--<div id="rewardNameError"></div>-->                                      
                    <label for="rewardPrice"><?= $lang['price']?> </label>
                    <input type="number" id="rewardPrice" name="rewardPrice" min="1" value="1" required>
                    <input type="submit" id="createReward" value="<?= $lang['accept']?>" name="createReward">
                    <button type="button" id="cancelReward"><?= $lang['cancel']?></button>
                </form>    
                <div id="rewardNameError" class="error"></div>
            </div>
        </div>
        
        <script src="/proyecto/templates/main/mainFuncionality.js"></script>
    </body>
</html>