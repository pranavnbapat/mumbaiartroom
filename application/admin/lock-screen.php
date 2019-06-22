<?php
session_start();

include './config/common.php';

if ($_SESSION['user_key'] == ''):
    header('location: login.php?err=2');
endif;

$_SESSION['is_locked'] = 'Y';

$update['is_locked'] = 'Y';
update($mysqli, 'user_master', $update, $_SESSION['user_key'], 'user_key');

$msg = '';

/* get user info */
$get_user_info = 'SELECT fname, gender, lname, avatar FROM user_master WHERE user_key = "' . $_SESSION['user_key'] . '"';
$user_info_res = $mysqli->query($get_user_info);
if ($user_info_res->num_rows > 0):
    $user_info_row = mysqli_fetch_object($user_info_res);
    $fname = $user_info_row->fname;
    $lname = $user_info_row->lname;
    if ($user_info_row->avatar == ''):
        if ($user_info_row->gender == 'm'):
            $avatar = 'img/avatar/business_user.png';
        else:
            $avatar = 'img/avatar/female_business_user.png';
        endif;
    else:
        $avatar = 'img/avatar/' . $user_info_row->avatar;
    endif;
endif;
/* get user info */

if (isset($_POST['submit'])):
    $unlock_user = 'SELECT password FROM user_master WHERE user_key = "' . $_SESSION['user_key'] . '"';
    $unlock_user_res = $mysqli->query($unlock_user);
    $unlock_user_row = mysqli_fetch_object($unlock_user_res);
//	var_dump($_SESSION);
    if (crypt(trim($_POST['password']), $unlock_user_row->password) == $unlock_user_row->password):
        $_SESSION['is_locked'] = 'N';
        $update['is_locked'] = 'N';
        update($mysqli, 'user_master', $update, $_SESSION['user_key'], 'user_key');
        header('location:' . $_SESSION['last_page']);
    else:
        $msg = '<span class="locked">Wrong Password.</span>';
    endif;
endif;
$db->mysqlclose();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="img/favicon.png" />

        <title>Lock Screen</title>

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

    <body class="lock-screen" onload="startTime()">
        <div class="lock-wrapper">
            <div id="time"></div>
            <div class="lock-box text-center">
                <img src="<?php echo $avatar; ?>" alt="lock avatar" style="width:75px; height:75px;" />
                <h1><?php echo $fname . ' ' . $lname; ?></h1>
                <span class="locked">Your account has been locked due to inactivity. Please enter your password to unlock</span><br />
                <?php echo $msg; ?>
                <form role="form" class="form-inline" action="" method="post">
                    <div class="form-group col-lg-12">
                        <input type="password" placeholder="Password" id="exampleInputPassword2" class="form-control lock-input" name="password" />
                        <button class="btn btn-lock" type="submit" value="submit" name="submit">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            function startTime()
            {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                // add a zero in front of numbers<10
                m = checkTime(m);
                s = checkTime(s);
                document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
                t = setTimeout(function () {
                    startTime()
                }, 500);
            }

            function checkTime(i)
            {
                if (i < 10)
                {
                    i = "0" + i;
                }
                return i;
            }
        </script>
    </body>
</html>
