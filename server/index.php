<?php

require_once __DIR__ . "/methods.php";

CORS();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];
$params = $_GET;

switch ($url) {
    case "/log-in":
        $user["log-in"]($params);
        break;

    case "/register":
        $user["register"]($params);
        break;

    default:
        sendResp(["error" => "Bad request"], 400);
        break;
}

