<?php

session_start();
require_once '../config/db.php';

        $comment = $_POST['message']; // ดึงข้อมูลจาก textarea
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_SESSION['admin_id']; // ดึง user_id หรือ admin_id ขึ้นมา
        $date = date("Y-m-d "); // วันที่ปัจจุบัน

        if (empty($comment)) {
            echo json_encode(array("status" => "error", "msg" => "Error adding comment."));
        } else {
            // เพิ่มข้อมูลลงในฐานข้อมูล
            $stmt = $conn->prepare("INSERT INTO table_comment (comment, date, userID) VALUES (:comment, :date, :userID)");
            $stmt->bindParam(':comment', $comment);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':userID', $userId);
            $stmt->execute();

            if ($stmt) {
                echo json_encode(array("status" => "success", "msg" => "Comment added successfully!"));
            } else {
                echo json_encode(array("status" => "error", "msg" => "Error adding comment."));
            }
        }


?>