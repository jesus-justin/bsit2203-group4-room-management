<?php

$adminPassword = 'admin123'; // Admin password
$hashedPassword = password_hash($adminPassword, PASSWORD_BCRYPT);
echo $hashedPassword;
?>