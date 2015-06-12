<?php

$view_page_title = "Login page";
include_once "views/header.php";
include_once "config/config.php";
include_once "libs/auth.php";
include_once "libs/helper.php";
include_once "libs/validator.php";

# GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	echo "<h1>get Login page</h1>\n";
	# include content login_form
	include "views/login_form.php";
# END if ($_SERVER['REQUEST_METHOD'] === 'GET')
}

# POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	echo "<h1>POST Login page</h1>\n";

	#Init errors array
	$errors = array();

	# Validations
	#check csrf code
	$res_csrf = app\auth\process_csrf($dbConfig, $_POST["csrf_code"]);

	if (!empty($res_csrf) && is_array($res_csrf)) {
		if (isset($res_csrf['db_connect'])) {
			h\show_error($res_csrf['db_connect']);
			include_once 'views/footer.php';
			exit();
		} else {
			$errors = array_merge($errors, $res_csrf);
		}
	}

# check login field
	// if (!empty($_POST['login'])) {
	// 	$login = $_POST['login'];
	// 	$login = filter_var($login, FILTER_SANITIZE_STRING);
	// 	$view_login = $login;
	// 	if (strlen($view_login) < 4) {
	// 		$errors['login'] = 'Login is too short (less then 4 symbols). Try again.';
	// 	}
	// } else {
	// 	$errors['nologin'] = 'Login is Empty. Try again.';
	// }

	//function check_string($val = '', $field_name = '', $min_len = 0, $max_len = 0)
	$view_login = $_POST['login'];
	$res_func = app\validate\check_login($view_login, 'login', 3, 15);
	if (!empty($res_func)) {
		$errors = array_merge($errors, $res_func);
	}

# check password field
	// if (!filter_has_var(INPUT_POST, 'password')) {
	// if (!empty($_POST['password'])) {
	// 	$password = $_POST['password'];
	// 	$password = filter_var($password, FILTER_SANITIZE_STRING);
	// 	if (strlen($password) < 4) {
	// 		$errors['passwd'] = 'Password is too short (less then 4 symbols). Try again.';
	// 	} else {
	// 		$view_password = $password;
	// 	}
	// } else {
	// 	$errors['nopasswd'] = 'Password is Empty. Try again.';
	// }

	$view_password = $_POST['login'];
	$res_func = app\validate\check_password($view_password, 'password', 3, 15);
	if (!empty($res_func)) {
		$errors = array_merge($errors, $res_func);
	}

	# validate login and Password
	if (empty($errors) && !app\auth\validate($view_login, $view_password)) {
		$errors['novalid'] = 'You need to enter a valid username and password.';
	}

	# check if errors in post data
	if (!empty($errors)) {
		# include content login_form
		include "views/login_form.php";
	} else # if all ok login & show profile page
	{
		app\auth\loginme($view_login, $view_password, $secret_word);
		h\redirect_to('profile.php');
	}

# if ($_SERVER['REQUEST_METHOD'] === 'POST')
}

include_once 'views/footer.php';
?>