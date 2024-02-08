<?php
session_start();
require_once "/laragon/www/weapon-gun/config/db.php";
if (!isset($_SESSION['admin_id'])) {
    header("location: ../weapon-gun/index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" href="../public/img/logo.png " type="image/gif">
    <link rel="stylesheet" href="add.css">
    <title>Add Page</title>
</head>

<body>
    <div class="mt-5 d-flex justify-content-center">
        <h1>Add Page</h1>
    </div>
    <hr>
    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php } ?>
    <?php if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php } ?>

    <div class="form-add mt-5 d-flex justify-content-center">
        <form action="insert.php" method="post" enctype="multipart/form-data">
            <div class="mt-3">
                <label for="Weaponsname" class="form-label">WeaponsName</label>
                <input type="text" id="wName" class="form-control" name="weaponsname" require>
            </div>
            <div class="mt-3">
                <label for="Typename" class="form-label">WeaponsType</label>
                <select class="form-select" name="typename" aria-label="Default select example" require>
                    <option selected>-</option>
                    <?php 
                        $stmt = $conn->prepare("SELECT * FROM table_type order by typeID");
                        $stmt->execute();
                        $datas = $stmt->fetchAll();
                    foreach($datas as $data) { ?>
                      <option value="<?=$data['typeID'];?>"><?=$data['typeName'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mt-3">
                <label for="bulletname" class="form-label">BulletType</label>
                <select class="form-select" name="blname" aria-label="Default select example" require>
                    <option selected>-</option>
                    <?php 
                        $stmt = $conn->prepare("SELECT * FROM table_bullet order by typebulletID");
                        $stmt->execute();
                        $datas = $stmt->fetchAll();
                    foreach($datas as $data) { ?>
                      <option value="<?=$data['typebulletID'];?>"><?=$data['typebulletName'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mt-3">
                <label for="damageshots" class="form-label">Damage/Shots</label>
                <input type="text" id="ds" class="form-control" name="damageshots" require>
            </div>
            <div class="mt-3">
                <label for="loadingbullets" class="form-label">Loading Bullets</label>
                <input type="text" id="ld" class="form-control" name="loadingbullets" require>
            </div>
            <div class="mt-3">
                <label for="bulletspeedshots" class="form-label">Bullet Speed/Shots</label>
                <input type="text" id="bs" class="form-control" name="bulletspeedshots" require>
            </div>
            <div class="mt-3">
                <label for="img" class="form-label">Image</label>
                <input type="file" id="imgInput" name="img" class="form-control" require>
                <img width="100%" id="previewImg" alt="">
            </div>
            <div class="mt-3 mb-5">
                <a class="btn btn-danger" href="../admin.php">Cancle</a>
                <button type="submit" name="submit" class="btn btn-primary">Add</button>
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