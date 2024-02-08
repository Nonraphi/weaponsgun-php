<?php
session_start();
require_once "/laragon/www/weapon-gun/config/db.php";
if (!isset($_SESSION['admin_id'])) {
    header("location: ../weapon-gun/index.php");
}

if (isset($_POST['update'])) {
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
        $_SESSION['success'] = "Data has been update Successfully";
        header("location: ../admin.php");
    } else {
        $_SESSION['error'] = "Data has not been update Successfully";
        header("location: ../admin.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="add.css">
    <title>Add Page</title>
</head>

<body>
    <div class="mt-5 d-flex justify-content-center">
        <h1>Edit Page</h1>
    </div>
    <div class="form-add mt-5 d-flex justify-content-center">
        <form action="edit.php" method="post" enctype="multipart/form-data">
            <?php
            if (isset($_GET['weaponID'])) {
                $id = $_GET['weaponID'];
                $stmt = $conn->query("SELECT * FROM table_weapon WHERE weaponID = $id");
                $stmt->execute();
                $data = $stmt->fetch();
            }
            ?>
            <div class="mt-3">
                <label for="Weaponsid" class="form-label">WeaponsID</label>
                <input type="text" readonly value="<?= $data['weaponID'] ?>" class="form-control" name="weaponsid" require>
            </div>
            <div class="mt-3">
                <label for="Weaponsname" class="form-label">WeaponsName</label>
                <input type="text" id="wName" value="<?= $data['weaponName'] ?>" class="form-control" name="weaponsname" require>
                <input type="hidden" value="<?= $data['imggun'] ?>" class="form-control" name="img2" require>
            </div>
            <div class="mt-3">
                <label for="Typename" class="form-label">WeaponsType</label>
                <select class="form-select" name="typename" aria-label="Default select example" require>
                    <option selected>-</option>
                    <?php 
                        $stmt = $conn->prepare("SELECT * FROM table_type order by typeID");
                        $stmt->execute();
                        $rows = $stmt->fetchAll();
                    foreach($rows as $row) { ?>
                      <option value="<?=$row['typeID'];?>"<?= ($data['type'] == $row['typeID']) ? 'selected' : '' ?>><?=$row['typeName'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mt-3">
                <label for="bulletname" class="form-label">BulletType</label>
                <select class="form-select" value="<?= $data['bullettype'] ?>" name="blname" aria-label="Default select example" require>
                    <option selected>-</option>
                    <?php 
                        $stmt = $conn->prepare("SELECT * FROM table_bullet order by typebulletID");
                        $stmt->execute();
                        $rows = $stmt->fetchAll();
                    foreach($rows as $row) { ?>
                      <option value="<?=$row['typebulletID'];?>"<?= ($data['type'] == $row['typebulletID']) ? 'selected' : '' ?>><?=$row['typebulletName'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mt-3">
                <label for="damageshots" class="form-label">Damage/Shots</label>
                <input type="text" id="ds" class="form-control" value="<?= $data['damageshots'] ?>" name="damageshots" require>
            </div>
            <div class="mt-3">
                <label for="loadingbullets" class="form-label">Loading Bullets</label>
                <input type="text" id="ld" class="form-control" value="<?= $data['loadingbullets'] ?>" name="loadingbullets" require>
            </div>
            <div class="mt-3">
                <label for="bulletspeedshots" class="form-label">Bullet Speed/Shots</label>
                <input type="text" id="bs" class="form-control" value="<?= $data['bulletspeedshots'] ?>" name="bulletspeedshots" require>
            </div>
            <div class="mt-3">
                <label for="img" class="form-label">Image</label>
                <input type="file" id="imgInput" name="img" class="form-control">
                <img width="100%" src="../crud/uploads/<?= $data['imggun']; ?>" id="previewImg" alt="">
            </div>
            <div class="mt-3 mb-5">
                <a class="btn btn-danger" href="../admin.php">Go Back</a>
                <button type="submit" name="update" class="btn btn-warning">Update</button>
            </div>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        }
    </script>
</body>

</html>