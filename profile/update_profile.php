<?php
session_start();
require_once "../config/db.php";


    $userID = $_POST['userID'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];

    $stmt = $conn->prepare('SELECT COUNT(*) FROM table_user WHERE email = :email AND userID != :userID');
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $emailExists = $stmt->fetchColumn();

    $stmt = $conn->prepare('SELECT COUNT(*) FROM table_user WHERE username = :username AND userID != :userID');
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $usernameExists = $stmt->fetchColumn();

    if (hasWhitespace($firstname) || hasWhitespace($lastname) || hasWhitespace($email) || hasWhitespace($username)) {
        echo json_encode(array("status" => "error", "msg" => "Please remove spaces from the input fields"));
    } else if (!$firstname) {
        echo json_encode(array("status" => "error", "msg" => "Please enter your firstname"));
    } else if (!$lastname) {
        echo json_encode(array("status" => "error", "msg" => "Please enter your lastname"));
    } else if (!preg_match('/^[a-zA-Z]+$/', $firstname) || !preg_match('/^[a-zA-Z]+$/', $lastname)) {
        echo json_encode(array("status" => "error", "msg" => "Please enter FirstName or LastName with A-Z or a-z only."));
    } else if (!$email) {
        echo json_encode(array("status" => "error", "msg" => "Please enter your E-mail"));
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array("status" => "error", "msg" => "Please enter a valid email address"));
    } else if ($emailExists) {
        echo json_encode(array("status" => "error", "msg" => "This Email is Already Exists!"));
    } else if (!$username) {
        echo json_encode(array("status" => "error", "msg" => "Please enter your username"));
    } else if (!preg_match('/^[a-zA-Z0-9.]+$/', $username)) {
        echo json_encode(array("status" => "error", "msg" => "Please enter Username A-Z, a-z, or 0-9 only."));
    } else if ($usernameExists) {
        echo json_encode(array("status" => "error", "msg" => "This Username is Already Exists!"));
    } else {
        $sql = $conn->prepare("UPDATE table_user SET 
                                    firstName = :firstname, lastName = :lastname, email = :email, 
                                    username = :username
                                    WHERE userID = :userID");
        $sql->bindParam(":userID", $userID);
        $sql->bindParam(":firstname", $firstname);
        $sql->bindParam(":lastname", $lastname);
        $sql->bindParam(":email", $email);
        $sql->bindParam(":username", $username);
        $sql->execute();

        if ($sql) {
            echo json_encode(array("status" => "success", "msg" => "Update Account Successfully!"));
        } else {
            echo json_encode(array("status" => "error", "msg" => "Something was Wrong!"));
        }
    }


function hasWhitespace($input) {
    return preg_match('/\s/', $input);
}
?>
