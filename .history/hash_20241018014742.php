<?php
// hash.php

/**
 * Hashes the password using Argon2
 *
 * @param string $password The password to hash
 * @return string The hashed password
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_ARGON2ID);
}
?>
