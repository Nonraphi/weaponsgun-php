<?php

session_start();
require_once "/laragon/www/weapon-gun/config/db.php";


$weaponsname = $_POST['weaponsname'];
$typename = $_POST['typename'];
$blname = $_POST['blname'];
$damageshots = $_POST['damageshots'];
$loadingbullets = $_POST['loadingbullets'];
$bulletspeedshots = $_POST['bulletspeedshots'];
$img = $_FILES['img'];

$allow = array('jpg', 'jpeg', 'png');
$extension = explode(".", $img['name']);
$fileActExt = strtolower(end($extension));
$fileNew = rand() . "." . $fileActExt;
$filePath = "uploads/" . $fileNew;

if (hasWhitespace($weaponsname) || hasWhitespace($damageshots) || hasWhitespace($loadingbullets) || hasWhitespace($bulletspeedshots)) {
    echo json_encode(array("status" => "error", "msg" => "Please remove spaces from the input fields"));
} else if (!$weaponsname) {
    echo json_encode(array("status" => "error", "msg" => "Please enter WeaponsName"));
} else if (!preg_match('/^[a-zA-Z0-9]+$/', $weaponsname)) {
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
    $stmt = $conn->prepare('SELECT COUNT(*) FROM table_weapon WHERE weaponName = ?');
    $stmt->execute([$weaponsname]);
    $wpnameExists = $stmt->fetchColumn();

    if ($wpnameExists) {
        echo json_encode(array("status" => "error", "msg" => "This WeaponName is already in use"));
    } else {
        if (in_array($fileActExt, $allow)) {
            if ($img['size'] > 0 && $img['error'] == 0) {
                if (move_uploaded_file($img['tmp_name'], $filePath)) {
                    
                    $sql = $conn->prepare("INSERT INTO table_weapon(weaponName, type, bullettype, damageshots, loadingbullets, bulletspeedshots, imggun) 
                                            VALUES(:weaponsname, :typename, :blname, :damageshots, :loadingbullets, :bulletspeedshots, :img)");
                    $sql->bindParam(":weaponsname", $weaponsname);
                    $sql->bindParam(":typename", $typename);
                    $sql->bindParam(":blname", $blname);
                    $sql->bindParam(":damageshots", $damageshots);
                    $sql->bindParam(":loadingbullets", $loadingbullets);
                    $sql->bindParam(":bulletspeedshots", $bulletspeedshots);
                    $sql->bindParam(":img", $fileNew);
                    $sql->execute();

                    if ($sql) {

                        echo json_encode(array("status" => "success", "msg" => "Insert Successfully!"));
                    } else {

                        echo json_encode(array("status" => "error", "msg" => "Error!"));
                    }
                }
            }
        }
    }
}
function hasWhiteSpace($input)
{
    return preg_match('/\s/', $input);
}
