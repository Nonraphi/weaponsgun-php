<?php

    session_start();
    require_once "/laragon/www/weapon-gun/config/db.php";

    if (isset($_POST['submit'])) {
        $weaponsname = $_POST['weaponsname'];
        $typename = $_POST['typename'];
        $blname = $_POST['blname'];
        $damageshots = $_POST['damageshots'];
        $loadingbullets = $_POST['loadingbullets'];
        $bulletspeedshots = $_POST['bulletspeedshots'];
        $img = $_FILES['img'];

        $allow = array('jpg' , 'jpeg' , 'png');
        $extension = explode(".",$img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt;
        $filePath = "uploads/".$fileNew;

        if (in_array($fileActExt, $allow)) {
            if ($img['size'] > 0 && $img ['error'] == 0) {
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
                        $_SESSION['success'] = "Success";
                        header("location: add.php");
                    } else {
                        $_SESSION['error'] = "error";
                        header("location: add.php");
                    }
                }
            }
        }
    }
?>