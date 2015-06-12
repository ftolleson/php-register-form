<?php

include_once "config/config.php";
include_once "libs/auth.php";

# check cookie if ok then redirect to profile page
if (!app\auth\check_logged_in($secret_word)) {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: login.php");
	exit();
} else {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: profile.php");
	exit();
}

?>