<?php

if(strpos($_SERVER['SCRIPT_NAME'], 'login.php') || strpos($_SERVER['SCRIPT_NAME'], 'registration.php') || strpos($_SERVER['SCRIPT_NAME'], 'lock-screen.php') || strpos($_SERVER['SCRIPT_NAME'], 'compose-message.php') || strpos($_SERVER['SCRIPT_NAME'], 'about-us.php') || strpos($_SERVER['SCRIPT_NAME'], 'contact-us.php') || strpos($_SERVER['SCRIPT_NAME'], 'contact-us-edit.php') || strpos($_SERVER['SCRIPT_NAME'], 'about-us-edit.php') || strpos($_SERVER['SCRIPT_NAME'], 'timings.php') || strpos($_SERVER['SCRIPT_NAME'], 'timings-edit.php') || strpos($_SERVER['SCRIPT_NAME'], 'my-profile-edit.php')):
    include 'validation-2.3.3.php';
endif;

?>