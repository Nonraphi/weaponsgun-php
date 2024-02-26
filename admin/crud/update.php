<?php

session_start();
require_once "/laragon/www/weapon-gun/config/db.php";

$weaponID = $_POST['weaponsid'];
$weaponsname = $_POST['weaponsname'];
$typename = $_POST['typename'];
$blname = $_POST['blname'];
$damageshots = $_POST['damageshots'];
$loadingbullets = $_POST['loadingbullets'];
$bulletspeedshots = $_POST['bulletspeedshots'];
$img = $_FILES['img'];

$img2 = $_POST['img2'];
$upload = $_FILES['img']['name'];

if ($upload != '') {
    $allow = array('jpg', 'jpeg', 'png');
    $extension = explode(".", $img['name']);
    $fileActExt = strtolower(end($extension));
    $fileNew = rand() . "." . $fileActExt;
    $filePath = "uploads/" . $fileNew;

    if (in_array($fileActExt, $allow)) {
        if ($img['size'] > 0 && $img['error'] == 0) {
            move_uploaded_file($img['tmp_name'], $filePath);
        }
    }
} else {
    $fileNew = $img2;
}

$stmt = $conn->prepare('SELECT COUNT(*) FROM table_weapon WHERE weaponName = :weaponsname AND weaponID != :weaponID');
$stmt -> bindParam(':weaponsname' , $weaponsname , PDO::PARAM_STR);
$stmt -> bindParam(':weaponID' , $weaponID , PDO::PARAM_INT);
$stmt->execute();
$wpnameExists = $stmt->fetchColumn();

if (hasWhitespace($weaponsname) || hasWhitespace($damageshots) || hasWhitespace($loadingbullets) || hasWhitespace($bulletspeedshots)) {
    echo json_encode(array("status" => "error", "msg" => "Please remove spaces from the input fields"));
} else if (!$weaponsname) {
    echo json_encode(array("status" => "error", "msg" => "Please enter WeaponsName"));
} else if ($wpnameExists) {
    echo json_encode(array("status" => "error", "msg" => "WeaponsName is Already Exists!"));
}else if (!preg_match('/^[a-zA-Z0-9]+$/', $weaponsname)) {
    echo json_encode(array("status" => "error", "msg" => "Please enter A-Z, a-z, or 0-9 only."));
} else if ($typename == '-') {
    echo json_encode(array("status" => "error", "msg" => "Please enter WeaponsType"));
} else if ($blname == '-') {
    echo json_encode(array("status" => "error", "msg" => "Please enter BulletType Weapons"));
} else if (!$damageshots) {
    echo json_encode(array("status" => "error", "msg" => "Please enter Damage Weapons"));
} else if (!preg_match('/^[0-9]+$/', $damageshots)) {
    echo json_encode(array("status" => "error", "msg" => "Please fill in Damage/Shots with numbers only."));
} else if (!$loadingbullets) {
    echo json_encode(array("status" => "error", "msg" => "Please enter Loading Bullets Weapons"));
} else if (!preg_match('/^[0-9]+$/', $loadingbullets)) {
    echo json_encode(array("status" => "error", "msg" => "Please fill in Loading Bullets with numbers only."));
} else if (!$bulletspeedshots) {
    echo json_encode(array("status" => "error", "msg" => "Please enter Bullet Speed Weapons"));
} else if (!preg_match('/^[0-9]+$/', $bulletspeedshots )) {
    echo json_encode(array("status" => "error", "msg" => "Please fill in Bullet Speed/Shots with numbers only."));
} else {

        $sql = $conn->prepare("UPDATE table_weapon SET 
                                weaponName = :weaponsname, type = :typename, bullettype = :blname, 
                                damageshots = :damageshots, loadingbullets = :loadingbullets, bulletspeedshots = :bulletspeedshots, imggun = :img
                                WHERE weaponID = :weaponsid");
        $sql->bindParam(":weaponsid", $weaponID);
        $sql->bindParam(":weaponsname", $weaponsname);
        $sql->bindParam(":typename", $typename);
        $sql->bindParam(":blname", $blname);
        $sql->bindParam(":damageshots", $damageshots);
        $sql->bindParam(":loadingbullets", $loadingbullets);
        $sql->bindParam(":bulletspeedshots", $bulletspeedshots);
        $sql->bindParam(":img", $fileNew);
        $sql->execute();

        if ($sql) {
            echo json_encode(array("status" => "success", "msg" => "Edit Successfully!"));
        } else {
            echo json_encode(array("status" => "error", "msg" => "Error!"));
        }
    }

function hasWhiteSpace($input)
{
    return preg_match('/\s/', $input);
}
