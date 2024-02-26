<?php
session_start();
require_once '../config/db.php';

$username = $_POST['username'];
$password = $_POST['password'];

if (!$username) {
    echo json_encode(array("status" => "error", "msg" => "Please enter your username"));
} else if (!preg_match('/^[a-zA-Z0-9.]+$/', $username)) {
    echo json_encode(array("status" => "error", "msg" => "Please enter Username A-Z, a-z, or 0-9 only."));
} else if (!$password) {
    echo json_encode(array("status" => "error", "msg" => "Please enter your password"));
} else if (strlen($_POST['password']) < 8) {
    echo json_encode(array("status" => "error", "msg" => "Please enter a password with more than 8 characters"));
} else {
    try {
        $stmt = $conn->prepare("SELECT * FROM table_user WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $hashedPassword = $row['password'];

            if ($username == $row['username']) {
                if (password_verify($password, $hashedPassword)) {
                    if ($row['role'] == 'admin') {
                        $_SESSION['admin_id'] = $row['userID'];
                        echo json_encode(array("status" => "success", "msg" => "Login successful"));
                    } else {
                        $_SESSION['user_id'] = $row['userID'];
                        echo json_encode(array("status" => "success", "msg" => "Login successful"));
                    }
                    
                } else {
                    echo json_encode(array("status" => "error", "msg" => "Password wrong!"));
                }
            } else {
                echo json_encode(array("status" => "error", "msg" => "Username wrong!"));
            }
        } else {
            echo json_encode(array("status" => "error", "msg" => "No Data in System!"));
        }
    } catch (PDOException $e) {
        echo json_encode(array("status" => "error", "msg" => "Something went wrong please try again!"));
    }
}
?>
