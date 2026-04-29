<?php
declare(strict_types=1);

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'diettrack';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}


$defaultAdminUsername = 'admin';
$defaultAdminPassword = 'admin123';

$checkAdminStmt = $conn->prepare("SELECT id FROM admins WHERE username = ? LIMIT 1");
$checkAdminStmt->bind_param('s', $defaultAdminUsername);
$checkAdminStmt->execute();
$checkAdminResult = $checkAdminStmt->get_result();

if ($checkAdminResult->num_rows === 0) {
    $hashedPassword = password_hash($defaultAdminPassword, PASSWORD_DEFAULT);
    $insertAdminStmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $insertAdminStmt->bind_param('ss', $defaultAdminUsername, $hashedPassword);
    $insertAdminStmt->execute();
    $insertAdminStmt->close();
}

$checkAdminStmt->close();
?>
