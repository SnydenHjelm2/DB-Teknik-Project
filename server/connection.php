<?php

// require_once __DIR__ . '/vendor/autoload.php';

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
// $dotenv->load();

// $host = $_ENV["DB_HOST"];
// $port = $_ENV["DB_PORT"];
// $dbname = $_ENV["DB_NAME"];
// $user = $_ENV["DB_USER"];
// $pwd = $_ENV["DB_PASSWORD"];

$env = json_decode(file_get_contents(__DIR__ . "/../env.json"), true);

$host = $env["DB_HOST"];
$port = $env["DB_PORT"];
$dbname = $env["DB_NAME"];
$user = $env["DB_USER"];
$pwd = $env["DB_PASSWORD"];

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        "$user",
        "$pwd"
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>