<!DOCTYPE html>
<html>
<head>
<title><?php echo isset($view_page_title) ? $view_page_title : "Main page";?></title>
</head>
<body>
<!-- header -->

<?php

include_once "config/config.php";
include_once "libs/auth.php";

$site_path = realpath(dirname(dirname(__FILE__)));
define('__SITE_PATH', $site_path);

# check cookie if ok then redirect to profile page
$aout = explode('/', $_SERVER['SCRIPT_NAME']);
$sname = $aout[count($aout) - 1];

# check cookie if ok then redirect to profile page
if (app\auth\check_logged_in($secret_word) && $sname != 'profile.php') {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: profile.php");
	exit();
}

echo "<p>Script name is " . $sname . "</p>\n";
if (!app\auth\check_logged_in($secret_word)) {
	if ($sname == 'login.php') {
		echo "<div><a href='register.php'>Register</a></div>\n";}
	if ($sname == 'register.php') {
		echo "<div><a href='login.php'>Login</a></div>\n";}
	if ($sname != 'register.php' && $sname != 'login.php') {
		echo "<div><a href='login.php'>Login</a> <a href='register.php'>Register</a></div>\n";}
} else {
	// echo "<div><a href='logout.php'>Logout</a></div>\n";
	echo "<div><a href='logout.php' onclick='document.cookie =\"user=; expires=Thu, 01 Jan 1970 00:00:01 GMT;\";'>Logout</a></div>\n";
}

# show session and cookies
echo "<div>COOKIE: <pre>";
var_dump($_COOKIE);
echo "</pre></div>\n";

?>