<?php
/**
 * Checks the strength of a password based on predefined criteria.
 *
 * A strong password must meet the following conditions:
 *      - At least 8 characters long
 *      - Contains at least one uppercase letter
 *      - Contains at least one lowercase letter
 *      - Contains at least one number
 *      - Contains at least one special character (!@#$%^&*(),.?":{}|<>-_)
 *
 * @param string $password The password to check.
 * @return bool Returns true if the password meets all criteria, otherwise false.
 */
function checkPasswordStrength(string $password) {
    $minLength = 8;
    $hasUppercase = preg_match('/[A-Z]/', $password);
    $hasLowercase = preg_match('/[a-z]/', $password);
    $hasNumber = preg_match('/[0-9]/', $password);
    $hasSpecialChar = preg_match('/[!@#$%^&*(),.?":{}|<>-_]/', $password);

    if (strlen($password) < $minLength || !$hasUppercase || !$hasLowercase || !$hasNumber || !$hasSpecialChar) {
        return false;  
    } 
    return true;
}
