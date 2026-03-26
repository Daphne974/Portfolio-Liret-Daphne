<?php
$host = "172.16.0.57";
$username   = "javaUser";
$password   = "P@ssword43";
$dbname   = "Cinema";


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo"bravo bg";
} catch (PDOException $e) {
    die("connectionFailled" . $e->getMessage());
}
?>
