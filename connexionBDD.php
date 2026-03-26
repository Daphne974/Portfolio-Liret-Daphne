<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "172.16.0.57";
$username   = "webuser";
$password   = "P@ssword55";
$database   = "Cinema";

try {
    $dsn = "mysql:host=$servername;dbname=$database;charset=utf8mb4";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Gestion erreurs
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch en tableau associatif
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Vraies requêtes préparées
    ];

    $conn = new PDO($dsn, $username, $password, $options);

    return $conn;

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
