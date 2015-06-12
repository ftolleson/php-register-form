<?php

include "libs/auth.php";

# check cookie if ok then redirect to profile page
app\auth\logout_me();
// $out = app\auth\logout_me() ? "SetCookie OK" : "SetCookie Error";
// echo "<p>Message Logout: " . $out . " </p>";
// error_log('>>> ' . $out . ' <<<');

include_once "libs/auth_route.php";

?>

</body>
</html>