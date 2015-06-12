<?php

namespace app\validate;

function check_string($val = '', $field_name = '', $min_len = 0, $max_len = 0) {
	$errors = array();

	// error_log('>>> [check_string] val is ' . $val . ', field_name is ' . $field_name . ', min_len is ' . $min_len . ', max_len is ' . $max_len);

	if (empty($field_name) || !is_string($field_name)) {
		$errors['field_name'] = "Field name is empty or not string";
		return $errors;
	}

	if (!is_string($val)) {
		$errors['val'] = $field_name . " is not string";
		return $errors;
	}

	if (!is_int($min_len) || !is_int($max_len)) {
		$errors['min_max'] = "min or max length of string is not integer";
		return $errors;
	}

	if (empty($val)) {
		$errors['val'] = "Value of " . $field_name . " is empty.";
	} else {
		# if val not empty
		if ($val !== filter_var($val, FILTER_SANITIZE_STRING)) {
			$errors['val'] = "Value of " . $field_name . " with disabled special chars.";
		} else
		# if without spec chars
		{
			if ($max_len !== 0 && strlen($val) > $max_len) {
				$errors['val'] = "Value of " . $field_name . " is bigger then " . $max_len;
			}
			if ($min_len !== 0 && strlen($val) < $min_len) {
				$errors['val'] = "Value of " . $field_name . " is less then " . $min_len;
			}
		}
	}
	return $errors;
}

function check_login($val, $field_name, $min_len = 0, $max_len = 0) {
	$errors = check_string($val, $field_name, $min_len, $max_len);
	if (empty($errors)) {
		if (!preg_match("/^[a-zA-Z ]*$/", $val)) {
			$errors['val'] = "Only letters and white space allowed";
		}
	}
	return $errors;
}

function check_first_name($val, $min_len = 0, $max_len = 0) {
	$errors = check_string($val, 'first name', $min_len, $max_len);
	return $errors;
}

function check_last_name($val, $min_len = 0, $max_len = 0) {
	$errors = check_string($val, 'last name', $min_len, $max_len);
	return $errors;
}

function check_passwd($val, $min_len = 0, $max_len = 0) {
	$errors = check_string($val, 'password', $min_len, $max_len);
	return $errors;
}

?>