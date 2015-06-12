<?php

include_once "config/config.php";
include_once "libs/auth.php";

// echo "<p>Test is " . app\auth\test() . "</p>\n";

# check cookie if ok then redirect to profile page
if (!app\auth\check_logged_in($secret_word)) {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: login.php");
	exit();
}

$view_page_title = "Profile page";
include_once "views/header.php";

echo "<h1>Profile page.</h1>\n";

// echo "<h3>All OK.</h3>\n";

echo "<div>POST: <pre>";
var_dump($_POST);
echo "</pre></div>\n";

echo "<div>COOKIE: <pre>";
var_dump($_COOKIE);
echo "</pre></div>\n";

// echo "<div><a href='logout.php'>Logout</a></div>\n";

include_once "views/footer.php";

?>