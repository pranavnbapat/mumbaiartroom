<?php
session_start();

include 'config/common.php';

$msg = '';

/* error messages */
if (isset($_GET['err']) && $_GET['err'] == '1'):
    $msg = 'You have been logged out!';
endif;

if (isset($_GET['err']) && $_GET['err'] == '2'):
    $msg = '<script>sweetAlert("Error","Please log in first!","info");</script>';
endif;
/* error messages */

$url = (!empty($_SERVER['HTTPS'])) ? "https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) : "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

/* log in */
if (isset($_POST['login']) && $_POST['login'] == 'Log in'):
    $rules = array();

    $rules[] = "required,email,Email is required.";
    $rules[] = "valid_email,email,Please enter a valid email address.";
    $rules[] = "length<=50,email,Email should be less than 50 characters.";

    $rules[] = "required,password,Password is required.";
    $rules[] = "length<=50,password,Password should be less than 50 characters.";

    $errors = validateFields($_POST, $rules);

    if (!empty($errors)):
        $error_msgs = '';
        foreach ($errors as $error):
            $error_msgs .= $error . '\n';
        endforeach;
        $msg = '<script>sweetAlert(\'Error\', "' . $error_msgs . '", \'error\');</script>';
    else:
        $get_user = 'SELECT id, email, password, user_key, status, times_logged_in, failed_login_attempts, email_verified, role_id FROM user_master WHERE email = "' . $_POST['email'] . '"';
        $user_res = $mysqli->query($get_user);
        if ($user_res->num_rows > 0):
            $user_row = mysqli_fetch_object($user_res);
            if ($user_row->email_verified == 'N'):
                $insert_log['user_id'] = $user_row->id;
                $insert_log['message'] = 'User tried to log in, but email verification is pending.';
                $insert_log['activity_from'] = get_client_ip();
                $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
                $insert_log['user_platform'] = $browser->getPlatform();
                $insert_log['date_created'] = $curr_date_time;
                insert($mysqli, 'log_user_activity', $insert_log);
                $msg = '<script>sweetAlert(\'Error\', \'Please verify your email address before log in!\', \'info\');</script>';
            elseif ($user_row->status == 'I'):
                $insert_log['user_id'] = $user_row->id;
                $insert_log['message'] = 'User tried to log in, but email approval is pending.';
                $insert_log['activity_from'] = get_client_ip();
                $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
                $insert_log['user_platform'] = $browser->getPlatform();
                $insert_log['date_created'] = $curr_date_time;
                insert($mysqli, 'log_user_activity', $insert_log);
                $msg = '<script>sweetAlert(\'Error\', \'Your email is awaiting approval from the administrator!\', \'info\');</script>';
            elseif ($user_row->email == $_POST['email'] && $user_row->password == crypt(trim($_POST['password']), $user_row->password)):
                $insert_log['user_id'] = $user_row->id;
                $insert_log['message'] = 'User logged in successfully.';
                $insert_log['activity_from'] = get_client_ip();
                $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
                $insert_log['user_platform'] = $browser->getPlatform();
                $insert_log['date_created'] = $curr_date_time;
                insert($mysqli, 'log_user_activity', $insert_log);
                $_SESSION['user_key'] = $user_row->user_key;
                $_SESSION['status'] = $user_row->status;
                $_SESSION['type'] = $user_row->role_id;
                $mysqli->query('UPDATE user_master SET times_logged_in = "' . ($user_row->times_logged_in + 1) . '", last_login_from = "' . get_client_ip() . '", last_login_at = "' . $curr_date_time . '" WHERE id = ' . $user_row->id);
                header('location: index.php');
            else:
                $insert_log['user_id'] = $user_row->id;
                $insert_log['message'] = 'Failed login attempt.';
                $insert_log['activity_from'] = get_client_ip();
                $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
                $insert_log['user_platform'] = $browser->getPlatform();
                $insert_log['date_created'] = $curr_date_time;
                insert($mysqli, 'log_user_activity', $insert_log);
                $update = 'UPDATE user_master SET failed_login_attempts = "' . ($user_row->failed_login_attempts + 1) . '", last_failed_login_from = "' . get_client_ip() . '", last_failed_login_at = "' . $curr_date_time . '", last_failed_login_from = "' . get_client_ip() . '" WHERE id = ' . $user_row->id;
                $mysqli->query($update);
                $msg = '<script>sweetAlert(\'Error\', \'Invalid login credentials!\', \'error\');</script>';
            endif;
        else:
            $msg = '<script>sweetAlert(\'Error\', \'Invalid login credentials!\', \'error\');</script>';
        endif;
    endif;
endif;
/* log in */

/* email verification */
if (isset($_POST['submit']) && $_POST['submit'] == 'Send Verification Email'):
    $rules = array();

    $rules[] = "required,email,Email is required.";
    $rules[] = "valid_email,email,Please enter a valid email address.";
    $rules[] = "length<=50,email,Email should be less than 50 characters.";

    $errors = validateFields($_POST, $rules);

    if (!empty($errors)):
        $error_msgs = '';
        foreach ($errors as $error):
            $error_msgs .= $error . '\n';
        endforeach;
        $msg = '<script>sweetAlert(\'Error\', "' . $error_msgs . '", \'error\');</script>';
    else:
        include 'config/PHPMailer-master/PHPMailerAutoload.php';
        include 'config/email_settings.php';
        $get_user = 'SELECT id, email, fname, lname, user_key FROM user_master WHERE email = "' . trim(strtolower(htmlspecialchars($_POST['email']))) . '"';
        $user_res = $mysqli->query($get_user);
        if ($user_res->num_rows > 0):
            $user_row = mysqli_fetch_object($user_res);
            $msg = 'Verification email has been sent to: ' . $user_row->email;
            $mail->setFrom('webmaster@pranavnbapat.com', 'Admin Team');
            $mail->addAddress($user_row->email, ucfirst($user_row->fname) . ' ' . ucfirst($user_row->lname));
            $mail->Subject = 'Email verification';
            $mail->msgHTML('Dear ' . ucwords($user_row->fname) . ' ' . ucwords($user_row->lname) . '<br /><br />Thank you for registering for admin panel. Please click on the link below to verify your email. <br /><br /><a href="' . $url . '/verify-email.php?rand=' . reset_password() . '&enc=' . $user_row->user_key . '&rand2=' . reset_password() . '">Verify Email</a><br /><br />Please do not reply to this email. Thanks and regards.');
            $mail->send();
            $msg = 'Email verification has been sent to: ' . trim(strtolower($_POST['email']));
            $insert_log['user_id'] = $user_row->id;
            $insert_log['message'] = 'Verification email requested.';
            $insert_log['activity_from'] = get_client_ip();
            $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
            $insert_log['user_platform'] = $browser->getPlatform();
            $insert_log['date_created'] = $curr_date_time;
            insert($mysqli, 'log_user_activity', $insert_log);
        else:
            $msg = "<script>sweetAlert('Error','Email " . trim(strtolower(htmlspecialchars($_POST['email']))) . " does not exists in our database!', 'error');</script>";
        endif;
    endif;
endif;
/* email verification */

/* reset password */
if (isset($_POST['submit']) && $_POST['submit'] == 'Submit'):
    $rules = array();
    $rules[] = "required,email,Email is required.";
    $rules[] = "valid_email,email,Please enter a valid email address.";
    $rules[] = "length<=50,email,Email should be less than 50 characters.";
    $errors = validateFields($_POST, $rules);
    if (!empty($errors)):
        $error_msgs = '';
        foreach ($errors as $error):
            $error_msgs .= $error . '\n';
        endforeach;
        $msg = '<script>sweetAlert(\'Error\', "' . $error_msgs . '", \'error\');</script>';
    else:
        include 'config/PHPMailer-master/PHPMailerAutoload.php';
        include 'config/email_settings.php';
        $get_user = 'SELECT id, email, fname, lname, user_key FROM user_master WHERE email = "' . trim(strtolower(htmlspecialchars($_POST['email']))) . '"';
        $user_res = $mysqli->query($get_user);
        $msg = '';
        if ($user_res->num_rows > 0):
            $user_row = mysqli_fetch_object($user_res);
            $mail->setFrom('webmaster@pranavnbapat.com', 'Admin Team');
            $mail->addAddress($user_row->email, ucfirst($user_row->fname) . ' ' . ucfirst($user_row->lname));
            $mail->Subject = 'DESIRED SYSTEM NAME: Reset password request';
            $mail->msgHTML('Dear ' . ucfirst($user_row->fname) . ' ' . ucfirst($user_row->lname) . ',<br /><br />This email was sent automatically by "DESIRED SYSTEM NAME" in response to your request to recover password. This is done for your protection; only you, the recipient of this email can take the step in the password recovery process.<br /><br />To reset your password and access account, either click on the link below, or copy and paste the link into the address bar of your browser:<br /><a href="' . $url . '/reset_password.php?rand=' . generateUserKey() . '&enc=' . $user_row->user_key . '&rand2=' . generateUserKey() . '">' . $url . '/reset_password.php?rand=' . generateUserKey() . '&enc=' . $user_row->user_key . '&rand2=' . generateUserKey() . '</a><br /><br />If you did not forget your password, please ignore this email.');
            $mail->send();
//        $msg = 'Reset password email has been sent to: ' . $user_row->email;
            $msg = '<script>sweetAlert(\'Success\', \'Reset password email has been sent to: ' . $user_row->email . ' \', \'success\');</script>';
            $insert_log['user_id'] = $user_row->id;
            $insert_log['message'] = 'Reset password request.';
            $insert_log['activity_from'] = get_client_ip();
            $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
            $insert_log['user_platform'] = $browser->getPlatform();
            $insert_log['date_created'] = $curr_date_time;
            insert($mysqli, 'log_user_activity', $insert_log);
        else:
            $msg = '<script>sweetAlert(\'Error\', \'User does not exists!\', \'error\');</script>';
        endif;
    endif;
endif;
/* reset password */

$db->mysqlclose();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="img/favicon.png" />

        <title>Admin Panel</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <link href="css/bootstrap-reset.css" rel="stylesheet" />

        <!--external css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet" />
        <link href="css/style-responsive.css" rel="stylesheet" />

        <link href = "css/sweetalert.css" rel="stylesheet" />
        <script src = "js/sweetalert.min.js"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="login-body">
            <!--<script>swal({title: "Error!", text: "<?php // echo $msg;                                   ?>", type: "error", confirmButtonText: "Cool"});</script>-->
        <div class="container">
            <form class="form-signin" action="" method="post">
                <h2 class="form-signin-heading">sign in now</h2>
                <center style="margin-top: 10px;"><?php echo $msg; ?></center>
                <div class="login-wrap">
                    <input type="text" class="form-control" placeholder="Email" autofocus name="email" autocomplete="on" />
                    <input type="password" class="form-control" placeholder="Password" name="password" />
                    <input type="submit" class="btn btn-lg btn-login btn-block" name="login" value="Log in" />
                </div>
            </form>
        </div>

        <!--js placed at the end of the document so the pages load faster -->
        <script src = "js/jquery.js"></script>
        <script src = "js/bootstrap.min.js"></script>
    </body>
</html>
