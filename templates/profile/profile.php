<?php

if(!defined("IN_CONTROLLER")){
    die ("Error, no se puede llamar a la vista directamente");    
}

if(!isset($_SESSION["user"])){
    header("Location: /proyecto/templates/login/index.php");
    exit;
} 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Do it - Tick it - <?= $lang['profile']?></title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style>
            @import url(/proyecto/templates/profile/profile.css);
            @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
         <script src="/proyecto/templates/profile/profileFieldValidator.js"></script>
    </head>
    <body>
    <header>
        <h1><?= $_SESSION["user"]?><?= $lang['thisIsProfile']?></h1>
    </header>
        <div id="main">

            <div id="updateInfo">     
                <h3><?= $lang['updateInfo']?></h3>
                <form action = "" method="POST" onsubmit = "return validateInfoUpdate()">            
                
                    <div id="fieldError" class="error"></div>
                    <input type="email" id="email" name="email" placeholder="<?= $lang['newEmail']?>"/>
                    <div id="emailError" class="error"></div>

                    <input type="password" id="npass" name="npass" placeholder="<?= $lang['newPass']?>"/>
                    <div id="npassError" class="error"></div>

                    <input type="password" id="cpass" name="cpass" placeholder="<?= $lang['confirmPass']?>"/>
                    <div id="cpassError" class="error"></div>

                    <input type="password" id="apass" name="apass" placeholder="<?= $lang['currentPass']?>" required="required"/>
                    <div id="apassError" class="error"></div>

                    <input type="submit" value="<?= $lang['updateInfo']?>" name="updateInfo"/>            
                </form>
            </div>
            
            <div id="contact">            
                <h3><?= $lang['contactTheDevelopers']?></h3>
                <form action = "" method="POST" onsubmit = "return validateMessage()">                    
                    <input type="text" id="subject" name="subject" placeholder="<?= $lang['subject']?>" required/><br>
                    <textarea id="message" name="message" placeholder="<?= $lang['message']?>" rows="10" cols="50" maxlength=500 required></textarea><br>
                    <input type = "submit" value="<?= $lang['send']?>" name="sendMessage"/>
                </form>
                <div id="messageError" class="error"></div>
            </div>

            <div id="options">
                <h3><?= $lang['options']?></h3>
                <form class="options" action = "" method="POST">

                    <label for="language"><?= $lang['language']?> </label>
                    <select name="language" id="language">
                        <option value="es"><?= $lang['spanish']?></option>
                        <option value="en"><?= $lang['english']?></option>                
                    </select>

                    <br/>

                    <label for="theme"><?= $lang['theme']?> </label>
                    <select id="theme" name="theme" id="theme">
                        <option id="light" value="light"><?= $lang['light']?></option>
                        <option id="dark" value="dark"><?= $lang['dark']?></option>                
                    </select>

                    <input type = "submit" value="<?= $lang['save']?>" name="saveOptions"/>

                </form>
            </div>

            <div id="image">
            <h3><?= $lang['uploadImage']?></h3>
                <form class="image" action = "" method="POST" enctype="multipart/form-data">
                    
                    <label for="uploadedImage"><?= $lang['searchImage']?> </label>
                    <input type="file" name="uploadedImage" id="uploadedImage" accept="image/*">

                    <br/>
                    <input type = "submit" value="<?= $lang['saveImage']?>" name="saveImage"/>
                                        
                </form>
            </div>

            <div id="sessionAndAccount">
                <h3><?= $lang['sessionAndAccount']?></h3>
                <form action = "" method="POST">                        
                        <input type = "submit" value="<?= $lang['closeSession']?>" name="closeSession"/>
                        </br>                        
                        <button type="button" id="resetAccount" class="reset"><?= $lang['resetAccount']?></button>
                        </br>
                        <button type="button" id="deleteAccount" class="delete"><?= $lang['deleteAccount']?></button>                        
                </form>
            </div>

        </div>   
        

            <div class="popup-deleteAccount">
                <div class="popup-deleteAccount-content">
                    <h3><?= $lang['deleteAccountSure']?></h3>                                
                    <h4 class="warning"><?= $lang['notReversed']?></h4>
                    <form action = "" method="POST">
                        <input id="confirmDelete" type = "submit" value="<?= $lang['deleteAccount']?>" name="deleteAccount"/>
                        <button type="button" id="cancelDeleted"><?= $lang['cancel']?></button>                        
                    </form>
                </div>
            </div>

            <div class="popup-resetAccount">
                <div class="popup-resetAccount-content">
                    <h3><?= $lang['resetAccountSure']?></h3>                                
                    <h4 class="warning"><?= $lang['notReversed']?></h4>
                    <form action = "" method="POST">
                        <input id="confirmReset" type = "submit" value="<?= $lang['resetAccount']?>" name="resetAccount"/>
                        <button type="button" id="cancelReset"><?= $lang['cancel']?></button>                        
                    </form>
                </div>
            </div>
        
             
        <a href = "./main?lang=<?= $_SESSION["lang"] ?>"><span><?= $lang['return']?></span></a>
        <script src="/proyecto/templates/profile/profileFuncionality.js"></script>
    </body>
</html>