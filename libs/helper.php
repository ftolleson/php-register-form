<?php

// helper namespace
namespace h;

# filter falue
function check($val) {
	return htmlentities($val);
}

function show($val) {
	echo check($val);
}

function show_error($val) {
	echo '<div id=\"iderrors\">' . check($val) . '</div>';
}

function redirect_to($file) {
	if (file_exists($file)) {
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ' . $file);
		exit();
		return true;
	} else {
		return false;
	}
}

?>