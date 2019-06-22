<?php
include 'config/common.php';

$msg = '';

if (isset($_GET['enc']) && $_GET['enc'] != ''):
    include 'config/PHPMailer-master/PHPMailerAutoload.php';
    include 'config/email_settings.php';
    $get_user = 'SELECT id, email, fname, lname, password FROM user_master WHERE user_key = "' . trim($_GET['enc']) . '"';
    $user_res = $mysqli->query($get_user);
    if ($user_res->num_rows > 0):
        $user_row = mysqli_fetch_object($user_res);
        $new_pass = reset_password();
        $update = 'UPDATE user_master SET password = "' . sha1($new_pass) . '" WHERE user_key = "' . trim($_GET['enc']) . '"';
        $mysqli->query($update);
        $msg = 'Your password has been reset and sent to ' . $user_row->email;
        $mail->setFrom('webmaster@pranavnbapat.com', 'Admin Team');
        $mail->addAddress($user_row->email, ucfirst($user_row->fname) . ' ' . ucfirst($user_row->lname));
        $mail->Subject = 'DESIRED SYSTEM NAME: Password has been reset';
        $mail->msgHTML('Dear ' . ucfirst($user_row->fname) . ' ' . ucfirst($user_row->lname) . ',<br /><br /> As per your request, we have reset your password. Your new password is: ' . $new_pass . ' <br /><br />Please do not reply to this email. It won\'t be answered. Thank you.');
        $mail->send();

        $insert_log['user_id'] = $user_row->id;
        $insert_log['message'] = 'New password sent';
        $insert_log['activity_from'] = get_client_ip();
        $insert_log['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $insert_log['date_created'] = $curr_date_time;
        insert($mysqli, 'log_user_activity', $insert_log);
    else:
        $msg = 'Something went wrong.';
    endif;
endif;
$db->mysqlclose();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="img/favicon.png">

        <title>Admin Panel</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/style-responsive.css" rel="stylesheet" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="login-body">
        <div class="container">
            <h3 class="form-signin-heading"><?php echo $msg; ?></h3>
        </div>
    </body>
</html>