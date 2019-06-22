<?php

include 'admin_header.php';
include 'admin_footer.php';
//error_reporting(0);

/* get all user info */
//$get_user_info = 'SELECT um.*, urm.role_name FROM user_master um INNER JOIN user_role_master urm ON urm.id = um.role_id WHERE um.user_key = "' . $_SESSION['user_key'] . '"';
//$user_info_res = $mysqli->query($get_user_info);
//$user_info_row = mysqli_fetch_object($user_info_res);
/* get all user info */


/* get random thought */
$thought = '';
$get_thought = 'SELECT thought FROM food_for_thought WHERE status = "A" ORDER BY RAND() LIMIT 0,1';
$thought_res = $mysqli->query($get_thought);
if ($thought_res->num_rows > 0):
	$thought_row = mysqli_fetch_object($thought_res);
	$thought = $thought_row->thought;
else:
	$thought = 'Trust unto God, and he shall lead your path.';
endif;
/* get random thought */


/* Get user avatar */
$avatar = '';
$avatar_alt = 'no image';
if ($user_info_row->gender == 'm'):
	if ($user_info_row->avatar == ''):
		$avatar = 'img/avatar/business_user.png';
	else:
		$avatar = $user_info_row->avatar;
		$avatar_alt = $user_info_row->fname . ' ' . $user_info_row->lname . ' avatar';
	endif;
else:
	if ($user_info_row->avatar == ''):
		$avatar = 'img/avatar/female_business_user.png';
	else:
		$avatar = $user_info_row->avatar;
		$avatar_alt = $user_info_row->fname . ' ' . $user_info_row->lname . ' avatar';
	endif;
endif;
/* Get user avatar */

$template = new Template;
$template->load("templates/my-profile.html");
$template->replace("header", $header);
$template->replace("footer", $footer);
$template->replace("fname", ucfirst($user_info_row->fname));
$template->replace("lname", ucfirst($user_info_row->lname));
$template->replace("email", $user_info_row->email);
$template->replace("avatar", $avatar);
$template->replace("avatar_alt", $avatar_alt);
//$template->replace("dob", ($user_info_row->dob == '') ? "Not Provided" : date_format(date_create($user_info_row->dob), 'd M Y'));
$template->replace("type", ucwords($user_info_row->role_name));
$template->replace("mobile", ($user_info_row->mobile == '') ? "Not Provided" : $user_info_row->mobile);
$template->replace("country", ($user_info_row->country == '') ? "Not Provided" : ucwords($user_info_row->country));
$template->replace("thought", $thought);
$template->publish();
$db->mysqlclose();
?>