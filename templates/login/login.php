<?php
/*session_start();*/
if(!defined("IN_CONTROLLER")){
    die ("Error, no se puede llamar a la vista directamente");    
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Do it - Tick it - Login</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style>
            @import url(/proyecto/templates/login/login.css);
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="/proyecto/templates/login/loginFieldValidator.js"></script>
    </head>
    <body>
        <h1>Do it - Tick it</h1>

        <div class="options">
            <a href="index.php?lang=es"> <img src="/proyecto/templates/img/spanish.png"  width="50" height="34"> </a>
            <a href="index.php?lang=en"> <img src="/proyecto/templates/img/english.png"  width="50" height="34"> </a>
            
            <img id="color" src="/proyecto/templates/img/moon.png" width="30" height="30">
        </div>
        
        <div id="login">
            <form action = "" method="post" onsubmit = "return validateLogIn()">
                <input type="text" id="user" name="user" placeholder="<?= $lang['userField']?>"/>
                <label id="userError" class="error"></label><br/>
                <input type="password" id="pass" name="pass" placeholder="<?= $lang['passField']?>"/>
                <label id="passError" class="error"></label><br/>
                <input type="submit" value="<?= $lang['loginButton']?>" name="logIn" id="logIn"/><br/>
                <button type="button" id="createAccount"><?= $lang['createAccountButton']?></button>
            </form>
        </div>

        <div class="popup">
            <div id="popup-content" class="popup-content">
                <form action = "" method="post" onsubmit = "return validateRegistration()">
                    <input type="text" id="nuser" name="nuser" placeholder="<?= $lang['userName']?>" required="required"/>
                    <div id="nuserError" class="error"></div>
                    
                    <input type="email" id="email" name="email" placeholder="<?= $lang['email']?>" required="required"/>
                    <div id="emailError" class="error"></div>

                    <input type="password" id="npass" name="npass" placeholder="<?= $lang['passField']?>" required="required"/>
                    <div id="npassError" class="error"></div>

                    <input type="password" id="cpass" name="cpass" placeholder="<?= $lang['confirmPassword']?>" required="required"/>
                    <div id="cpassError" class="error"></div>

                    <input type="submit" value="<?= $lang['singUp']?>" name="register"/>
                    <button type="button" id="cancel"><?= $lang['cancel']?></button>
                </form>
            </div>
        </div>    

        <script src="/proyecto/templates/login/loginFuncionality.js"></script> 
    </body>
</html>