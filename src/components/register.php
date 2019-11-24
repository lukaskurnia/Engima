<?php
/**
 * Register page front-end
 * Php version 7.2.19
 *
 * @category front-end
 * @package  components
 * @author   Aldo Azali <13516125@std.stei.itb.ac.id>
 * @license  no license
 * @link     https://gitlab.informatika.org/if3110-2019-01-k03-03/tugas-besar-1-2019
 */

// require_once "includes/redirect.php";
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Engima | Register</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="../assets/register.css" />
    </head>
    
    <body>
        <div class="row register-wrapper">
            <div class="register-card">
                <form action="../API/Register.php" method="POST" id="register-form" 
                enctype="multipart/form-data" autocomplete="off">
                    <div class="card-header">Welcome to <b>Engi</b>ma!</div>
                    <div class="card-body">
                        <div class="text-left">
                            <p><label for="username">Username</label></p>
                        </div>
                        <div class="text-center">
                            <input type="text" id="username" name="username" class="input-register" 
                            placeholder="joe.johndoe">
                        </div>
                        <div id="usernameMessage" class="text-left message-text">
                            Username is not valid
                        </div>
                        <div class="text-left">
                            <p><label for="email">Email Address</label></p>
                        </div>
                        <div class="text-center">
                            <input type="text" id="email" name="email" class="input-register" 
                            placeholder="john@doe.com">
                        </div>
                        <div id="emailMessage" class="text-left message-text">
                            Email is not valid
                        </div>
                        <div class="text-left">
                            <p><label for="phone_number">Phone Number</label></p>
                        </div>
                        <div class="text-center">
                            <input type="tel" id="phone_number" name="phone_number" 
                            class="input-register" placeholder="+62813xxxxxxx">
                        </div>
                        <div id="phoneMessage" class="text-left message-text">
                            Length must be >=9 and <=12
                        </div>
                        <div class="text-left">
                            <p><label for="password">Password</label></p>
                        </div>
                        <div class="text-center">
                            <input type="password" id="password" name="password" class="input-register"
                            placeholder="make as strong as possible">                     
                        </div>
                        <div class="text-left">
                            <p><label for="confirm_password">Confirm Password</label></p>
                        </div>
                        <div class="text-center">
                            <input type="password" id="confirm_password" name="confirm_password" 
                            class="input-register" placeholder="same as above">                     
                        </div>
                        <div id="confirmPassMessage" class="text-left message-text">
                            This field doesn't match with the field above
                        </div>
                        <div class="text-left">
                            <p><label for="profile_picture">Profile Picture</label></p>
                        </div>
                        <div class="text-center">
                            <input id="imageFile" type="file" name="file" hidden>  
                            <input readonly id="profile_picture" type="textbox" 
                            class="button-control" name="profile_picture">
                            <input id="customButton" type="button" class="browse-button" value="Browse">  
                        </div>

                        <button class="register-button" type="submit" name="submit">register</button>
                        
                        <div class="text-center">
                            <p>Already have an account?
                            <a href="login.php">Login Here</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <script src="includes/js/register.js"></script>
    </body>
</html>