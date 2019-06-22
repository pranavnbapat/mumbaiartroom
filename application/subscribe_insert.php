<?php

if (isset($_POST) && isset($_POST['submit'])):
    require_once './config/common.php';
    $insert_array['email'] = trim(htmlspecialchars(addslashes(strtolower(substr($_POST['email'], 0, 99)))));
    $res_check_email = $mysqli->query('SELECT email FROM subscribe WHERE email = "' . $insert_array['email'] . '"');
    if ($res_check_email->num_rows > 0):
        echo 'duplicate';
        return;
    else:
        $insert_array['fname'] = trim(htmlspecialchars(addslashes(substr($_POST['fname'], 0, 49))));
        $insert_array['lname'] = trim(htmlspecialchars(addslashes(substr($_POST['lname'], 0, 49))));
        $insert_array['city'] = trim(htmlspecialchars(addslashes(strtolower(substr($_POST['city'], 0, 49)))));
        $insert_array['date_created'] = date('Y-m-d H:i:s');
        if (insert($mysqli, 'subscribe', $insert_array)):
            echo 'success';
            return;
        else:
            echo 'error';
            return;
        endif;
    endif;
endif;