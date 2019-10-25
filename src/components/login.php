<?php
/**
 * Login page front-end
 * Php version 7.2.19
 *
 * @category front-end
 * @package  components
 * @author   Aldo Azali <13516125@std.stei.itb.ac.id>
 * @license  no license
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */

require_once "includes/redirect.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Engima | Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="../assets/login.css" />
        <link rel="stylesheet" href="../assets/style.css">
        <script src="includes/js/login.js"></script>
    </head>
    
    <body>
        <div class="row login-wrapper">
            <div class="login-card">
                <form action="../API/Login.php" method="POST" id="login-form">
                    <div class="card-header">Welcome to <b>Engi</b>ma!</div>
                    <div class="card-body">
                        <div class="text-left">
                            <p><label for="inputEmail">Email</label></p>
                        </div>
                        <div class="text-center">
                            <input type="text" name="email" id="inputEmail" class="input-login" 
                            placeholder="john@doe.com"  
                            onblur="if (!this.value) this.setAttribute('class', 'error-login');" 
                            onclick="this.setAttribute('class', 'input-login');">
                        </div>
                        <div class="text-left">
                            <p><label for="inputPassword">Password</label></p>
                        </div>
                        <div class="text-center">
                            <input type="password" name="password" id="inputPassword" class="input-login"  
                            placeholder="place here" 
                            onblur="if (!this.value) this.setAttribute('class', 'error-login');" 
                            onclick="this.setAttribute('class', 'input-login');">                     
                        </div>
                        <button class="login-button" id="loginButton">Login</button>
                        
                        <div class="text-center">
                            <p>Don't have an account?
                            <a href="register.php">Register Here</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>