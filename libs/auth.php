<?php

namespace app\auth;

function test() {
	return 'test app\auth\test()';
}

function validate($login = "", $passwd = "") {
	# todo request to db select login and hashed password
	# and return true or false
	return true;
}

function loginme($login = "", $passwd = "", $secret_word) {
	if (validate($login, $passwd)) {
		// setcookie('user', $login . ',' . md5($login . $secret_word), time() + 60 * 2, '/reg/', $_SERVER["HTTP_HOST"], false, true);
		setcookie('user', $login . ',' . md5($login . $secret_word), time() + 60 * 2);
	}
}

function logout_me() {
	// if (isset($_COOKIE['user'])) {
	// unset($_COOKIE['user']);
	// error_log(">>>>>>>>>> Cookie deleting");
	return setcookie('user', '', 0);
	// setcookie('login');
	// return true;
	// } else {
	// return false;
	// }
}

#todo
function validate_date($user, $pass) {
	$db = new PDO('sqlite:/databases/users');
// Подготовка и выполнение
	$st = $db->prepare('SELECT password, last_access
		FROM users WHERE user LIKE ?');
	$st->execute(array($user));
	if ($ob = $st->fetchObject()) {
		if ($ob->password == $pass) {
			$now = time();
			if (($now - $ob->last_access) > (15 * 60)) {
				return false;
			} else {
// Обновление времени последнего обращения
				$st2 = $db->prepare('UPDATE users SET last_access = "now"
		WHERE user LIKE ?');
				$st2->execute(array($user));
				return true;
			}
		}
	}
	return false;
}

function check_logged_in($secret_word) {
	unset($username);
	if (isset($_COOKIE['user'])) {
		list($c_username, $cookie_hash) = explode(',', $_COOKIE['user']);

		if (md5($c_username . $secret_word) == $cookie_hash) {
			$username = $c_username;
			return true;
		} else {
			# bad session
			unset($_COOKIE['user']);
			return false;
		}
	} else {
		return false;
	}
}

function process_csrf($dbConfig, $token) {
	$errors = array();

	if (empty($dbConfig)) {
		$errors['dbConfig'] = 'dbConfig option is empty.';
		return $errors;
	}
	# db init
	try {
		$con = "mysql:host=" . $dbConfig['host'] . ";dbname=" . $dbConfig['dbname'];
		$db = new \PDO($con, $dbConfig['user'], $dbConfig['passwd']);
		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$db->beginTransaction();
	} catch (\PDOException $e) {
		$errors['db_connect'] = 'Can\'t connect to DataBase. Error Message:' . $e->getMessage();
		// echo '<div id=\"iderrors\">Can\'t connect to DataBase. Error Message: </div>' . $e->getMessage();
		error_log('>>> Can\'t connect to DataBase. Error Message: ' . $e->getMessage());
		// include_once 'views/footer.php';
		// exit();
		return $errors;
	}

	# check csrf code
	if (isset($token)) {
		$csrf_code = $token;
		$csrf_code = filter_var($csrf_code, FILTER_SANITIZE_STRING);

		$stmt = $db->prepare('SELECT csrf FROM CSRF_codes WHERE csrf = :csrf');
		$stmt->bindParam("csrf", $csrf_code);
		$stmt->execute();

		if (count($stmt->fetchAll())) {
			$errors['submitted'] = 'This form has already been submitted!';
			$db->rollBack();
			return $errors;
		} else {
			# if all OK, insert csrf code in table
			$stmt = $db->prepare('INSERT INTO CSRF_codes (csrf) VALUES (:csrf)');
			$stmt->bindParam("csrf", $csrf_code);
			$stmt->execute();
			$db->commit();
		}
	} else {
		$errors['nocsrf'] = 'no reuired field csrf. Try again.';
		return $errors;
	}
}

function gen_csrf_code() {
	return uniqid();
}

function register_me() {
	return true;
}

?>