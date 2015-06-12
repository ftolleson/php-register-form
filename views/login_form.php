<?php
include_once __SITE_PATH . '/libs/auth.php';
include_once __SITE_PATH . '/libs/helper.php';

$view_login = isset($view_login) ? h\check($view_login) : '';
$view_password = isset($view_password) ? str_repeat("*", strlen(h\check($view_password))) : '';

if (!empty($errors)) {
	echo "<div id=\"id_errors\"><pre>";
	var_dump($errors);
	echo "</pre></div>\n";
}

?>

<form action="<?php echo $_SERVER['SCRIPT_NAME'];?>" method="post">
  <?php // gen token csrf ?>
  <input type="hidden" name="csrf_code" value="<?php h\show(app\auth\gen_csrf_code());?>">
  <div class="field">
    <label for="login">Login</label><br>
    <input type="text" name="login" id="id_login" value="<?php h\show($view_login);?>" />
  </div>
  <div class="field">
    <label for="password">Password</label><br>
    <input type="password" name="password" id="id_password" value="<?php h\show($view_password);?>" />
  </div>
  <div class="actions">
    <input type="submit" name="commit" value="Login" />
  </div>
</form>