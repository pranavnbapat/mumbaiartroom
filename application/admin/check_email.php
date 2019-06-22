<?php

include 'config/common.php';

if (isset($_GET['email']) && $_GET['email'] != ''):
    $check_email = 'SELECT email FROM user_master WHERE email = "' . trim(strtolower(htmlspecialchars($_GET['email']))) . '"';
    $email_res = $mysqli->query($check_email);
    if ($email_res->num_rows > 0):
        echo 0;
    else:
        echo 1;
    endif;
endif;

$db->mysqlclose();
?>