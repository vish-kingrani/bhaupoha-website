<?php
$host = 'localhost'; 


$db   = 'u258586138_Bhau_poha_db';
$user = 'u258586138_Vish_kingrani';         
$pass = 'Roadlyne@123';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // On a live site, it's safer to log errors rather than echo them to the user
     error_log($e->getMessage());
     exit('Database connection failed.'); 
}
?>