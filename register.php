<?php

$view_page_title = "Register page";
include_once "views/header.php";
include_once "config/config.php";
include_once "libs/auth.php";
include_once "libs/helper.php";

# GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	echo "<h1>get Register page</h1>\n";
	# include register_form
	include "views/register_form.php";
# END if ($_SERVER['REQUEST_METHOD'] === 'GET')
}

# POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	echo "<h1>POST Register page</h1>\n";

	#Init errors array
	$errors = array();

	#Validations
	#check csrf code
	$res_csrf = app\auth\process_csrf($dbConfig, $_POST["csrf_code"]);

	# if func return errors
	if (!empty($res_csrf) && is_array($res_csrf)) {
		# if error db_connect show write now
		if (isset($res_csrf['db_connect'])) {
			h\show_error($res_csrf['db_connect']);
			include_once 'views/footer.php';
			exit();
		} else {
			# if not db_connect error merge with other errors
			$errors = array_merge($errors, $res_csrf);
		}
	}

# check login field
	if (!empty($_POST['login'])) {
		$login = $_POST['login'];
		$login = filter_var($login, FILTER_SANITIZE_STRING);
		$view_login = $login;
		if (strlen($view_login) < 4) {
			$errors['login'] = 'Login is too simple (less then 4 symbols). Try again.';
		}
	} else {
		$errors['nologin'] = 'Login is Empty. Try again.';
	}

# check password field
	if (!empty($_POST['password'])) {
		$password = $_POST['password'];
		$password = filter_var($password, FILTER_SANITIZE_STRING);
		if (strlen($password) < 4) {
			$errors['passwd'] = 'Password is too simple (less then 4 symbols). Try again.';
		} else {
			$view_password = $password;
		}
	} else {
		$errors['nopasswd'] = 'Password is Empty. Try again.';
	}

	# validate login and Password
	if (empty($errors) && !app\auth\validate($view_login, $view_password)) {
		$errors['novalid'] = 'You need to enter a valid username and password.';
	}

	# check if errors in post data
	if (!empty($errors)) {
		# show register_form with errors
		include "views/register_form.php";
	} else
	# if all ok, login, then redirect to profile page
	{
		app\auth\loginme($view_login, $view_password, $secret_word);
		h\redirect_to('profile.php');
	}

# if ($_SERVER['REQUEST_METHOD'] === 'POST')
}

# show footer
include_once 'views/footer.php';

?>
