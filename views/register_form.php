<?php
include_once __SITE_PATH . '/libs/auth.php';
include_once __SITE_PATH . '/libs/helper.php';

$view_login = isset($view_login) ? htmlentities($view_login) : '';
$view_password = isset($view_password) ? strlen(htmlentities($password)) : '';

if (!empty($errors)) {
	echo "<div id=\"id_errors\"><pre>";
	var_dump($errors);
	echo "</pre></div>\n";
}

?>

<form action="<?php echo $_SERVER['SCRIPT_NAME'];?>" method="post" enctype="multipart/form-data">
  <?php // gen token csrf ?>
  <input type="hidden" name="csrf_code" value="<?php h\show(app\auth\gen_csrf_code());?>">

  <div class="field">
    <label for="first_name">First Name</label><br>
    <input type="text" name="first_name" id="id_first_name" value="<?php h\show($view_first_name);?>" />
  </div>
  <div class="field">
    <label for="last_name">Last Name</label><br>
    <input type="text" name="last_name" id="id_last_name" value="<?php h\show($view_last_name);?>" />
  </div>
  <div class="field">
    <label for="login">Login</label><br>
    <input type="text" name="login" id="id_login" value="<?php h\show($view_login);?>" />
  </div>
  <div class="field">
    <label for="password">Password</label><br>
    <input type="password" name="password" id="id_password" value="<?php h\show($view_password);?>" />
  </div>
  <div class="field">
    <label for="email">Email</label><br>
    <input type="text" name="email" id="id_email" value="<?php h\show($view_email);?>" />
  </div>
  <div class="field">
    <label for="photo">Select image to upload:</label><br>
    <!-- <input type="text" name="photo" id="id_photo" value="<?php echo $view_photo;?>" /> -->
    <input type="file" name="photo" id="id_photo">
  </div>

  <div class="actions">
    <input type="submit" name="commit" value="Register" />
  </div>
</form>