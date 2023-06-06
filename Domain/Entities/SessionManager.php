<?php
class UserSession {
    public static function login($user) {
        $_SESSION['user'] = $user;
        header("Location: user/index.php");
        exit;
    }
}
 ?>
