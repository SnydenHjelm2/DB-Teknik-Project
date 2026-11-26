<?php 

require_once __DIR__ . "/connection.php";

function CORS() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: *");
}

function sendResp($data, $code) {
    header("Content-Type: application/json");
    http_response_code($code);
    echo json_encode($data);
    exit();
}

$user = [
    "log-in" => function($params) {
        global $pdo;
        $username = $params["username"] ?? null;
        $password = $params["password"] ?? null;

        if (!$username || !$password) return sendResp(["error" => "Missing attributes"], 400);

        try {
            $stmt = $pdo->prepare(
                "SELECT * FROM projekt.test WHERE username = :username AND password = :password"
            );

            $stmt->execute([
                "username" => $username,
                "password" => $password
            ]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) throw new Exception("User not found");

            return sendResp($user, 200);
        } catch (Throwable $e) {
            $msg = $e->getMessage();
            if ($msg === "User not found") return sendResp(["error" => $msg], 404);
            else if ($msg === "Missing attributes") return sendResp(["error" => $msg], 400);

            error_log($e->getMessage());
            return sendResp(["error" => "Connection error"], 500);
        }
    },

    "register" => function($params) {
        global $pdo;
        $username = $params["username"] ?? null;
        $password = $params["password"] ?? null;

        if (!$username || !$password) return sendResp(["error" => "Missing attributes"], 400);

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO projekt.test (username, password, admin) 
                VALUES (:username, :password, :admin)"
            );

            $stmt->execute([
                "username" => $username,
                "password" => $password,
                "admin" => 0
            ]);

            return sendResp(["success" => "User created"], 201);
        } catch (Throwable $e) {
            $msg = $e->getMessage();
            if ($msg === "User not found") return sendResp(["error" => $msg], 404);
            else if ($msg === "Missing attributes") return sendResp(["error" => $msg], 400);

            error_log($e->getMessage());
            return sendResp(["error" => "Connection error"], 500);
        }
    }
];