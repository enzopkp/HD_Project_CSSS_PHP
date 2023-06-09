<?php
class ValidationService {
    public static function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format";
        }
        return "";
    }

    public static function validatePassword($password) {
        if (strlen($password) < 8 || strlen($password) > 40) {
            return "Password must be between 8 and 40 characters";
        }
        return "";
    }
}
?>
