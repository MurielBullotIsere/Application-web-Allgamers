<?php
/**
 * Checks the strength of a password based on predefined criteria.
 *
 * A strong password must meet all of the following conditions:
 *      - At least 8 characters long
 *      - Contains at least one uppercase letter (A-Z)
 *      - Contains at least one lowercase letter (a-z)
 *      - Contains at least one digit (0-9)
 *      - Contains at least one special character (!@#$%^&*(),.?":{}|<>-_)
 *
 * @param string $password The password to evaluate.
 * @return bool Returns true if all criteria are met, false otherwise.
 *
 * @example
 *      checkPasswordStrength('Abc123!@#')  // true  : meets all criteria
 *      checkPasswordStrength('abc123!@#')  // false : missing uppercase
 *      checkPasswordStrength('Abc12345')   // false : missing special character
 *      checkPasswordStrength('Ab1!')       // false : too short
 */
function checkPasswordStrength(string $password): bool
{
    $minLength      = 8;
    $hasUppercase   = (bool) preg_match('/[A-Z]/',              $password);
    $hasLowercase   = (bool) preg_match('/[a-z]/',              $password);
    $hasNumber      = (bool) preg_match('/[0-9]/',              $password);
    $hasSpecialChar = (bool) preg_match('/[!@#$%^&*(),.?":{}|<>\-_]/', $password);

    return strlen($password) >= $minLength
        && $hasUppercase
        && $hasLowercase
        && $hasNumber
        && $hasSpecialChar;
}