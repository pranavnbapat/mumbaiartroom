<?php

date_default_timezone_set("Asia/Kolkata");

/* salt for bcrypt - password encryption */
$salt = substr(strtr(base64_encode(openssl_random_pseudo_bytes(22)), '+', '.'), 0, 22);
/* salt for bcrypt - password encryption */

/* current date time values defined */
$curr_date_time = date('Y-m-d H:i:s');
$curr_date = date('Y-m-d');
$curr_time = date('H:i:s');
/* current date time values defined */

function isValidEmail($email) {
    return preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email);
}

function isValidNumber($variable) {
    return is_numeric($variable);
}

/* get current url */
function url_origin($s, $use_forwarded_host = false) {
    $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true : false;
    $sp = strtolower($s['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
    $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}

function full_url($s, $use_forwarded_host = false) {
    return url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
}
/* get current url */

function get_client_ip() {
    $ipaddress = '';
    if (getenv('REMOTE_ADDR')):
        $ipaddress = getenv('REMOTE_ADDR');
    else:
        $ipaddress = 'UNKNOWN';
    endif;
    return $ipaddress;
}

function reset_password() {
    $new_pass = '';
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    for ($i = 0; $i < 10; $i++) {
        $new_pass .= $characters[rand(0, $charactersLength - 1)];
    }
    return $new_pass;
}

function generateUserKey() {
    $user_key = '';
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    for ($i = 1; $i <= 16; $i++) {
        $user_key .= $characters[rand(0, $charactersLength - 1)];
    }
    return $user_key;
}

function time_to_sec($time) {
    $hours = substr($time, 0, -6);
    $minutes = substr($time, -5, 2);
    $seconds = substr($time, -2);

    return $hours * 3600 + $minutes * 60 + $seconds;
}

function sec_to_time($seconds) {
    $ret = "";

    /* get the days */
    $days = intval(intval($seconds) / (3600 * 24));
    if ($days > 0) {
        $ret .= "$days days ";
    }

    /* get the hours */
    $hours = (intval($seconds) / 3600) % 24;
    if ($hours > 0) {
        $ret .= "$hours hrs ";
    }

    /* get the minutes */
    $minutes = (intval($seconds) / 60) % 60;
    if ($minutes > 0) {
        $ret .= "$minutes min ";
    }

    /* get the seconds */
//	$seconds = intval($seconds) % 60;
//	if ($seconds > 0) {
//		$ret .= "$seconds sec ";
//	}

    return $ret;
}

function isValidURL($url) {
    return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

function generateRandomNumber($n = 12) {
    return rand(0, pow(10, $n));
}

function generateSlug($phrase, $maxLength = 50) {
    $result = strtolower($phrase);

    $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
    $result = trim(preg_replace("/[\s-]+/", " ", $result));
    $result = trim(substr($result, 0, $maxLength));
    $result = preg_replace("/\s/", "-", $result);

    return $result;
}

?>