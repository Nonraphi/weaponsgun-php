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
    <link rel="stylesheet" href="add.css">
    <link rel="icon" href="../public/img/logo.png " type="image/gif">
    <title>Edit Page</title>
</head>

<body>
    <div class="mt-5 d-flex justify-content-center">
        <h1>Edit Page</h1>
    </div>
    <div class="form-add mt-5 d-flex justify-content-center">
        <form action="update.php" method="post" id="editform" enctype="multipart/form-data">
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
                    foreach ($rows as $row) { ?>
                        <option value="<?= $row['typeID']; ?>" <?= ($data['type'] == $row['typeID']) ? 'selected' : '' ?>><?= $row['typeName']; ?></option>
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
                    foreach ($rows as $row) { ?>
                        <option value="<?= $row['typebulletID']; ?>" <?= ($data['type'] == $row['typebulletID']) ? 'selected' : '' ?>><?= $row['typebulletName']; ?></option>
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
                <div class="image-container">
                    <img src="../crud/uploads/<?= $data['imggun']; ?>" id="previewImg" alt="" onclick="closePopup()">
                </div>
            </div>
            <div class="mt-3 mb-5">
                <a class="btn btn-danger" href="../admin.php">Go Back</a>
                <button type="submit" name="update" class="btn btn-warning">Update</button>
            </div>
        </form>
        <div id="imgModal" class="modal">
            <img class="modal-content" id="imgModalContent">
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        }

        document.getElementById('previewImg').onclick = function() {
            var modal = document.getElementById("imgModal");
            var modalImg = document.getElementById("imgModalContent");

            modal.style.display = "block";
            modalImg.src = this.src;

            // เพิ่มปุ่มปิดเฉพาะเมื่อยังไม่มีปุ่มปิด
            if (!modal.querySelector(".close")) {
                var closeBtn = document.createElement("span");
                closeBtn.innerHTML = "CLOSE";
                closeBtn.className = "close";
                modal.appendChild(closeBtn);

                // เมื่อคลิกที่ปุ่มปิด
                closeBtn.onclick = function() {
                    modal.style.display = "none";
                    closeBtn.remove(); // ลบปุ่มปิด
                }
            }
        }

        $(document).ready(function() {
            $("#editform").submit(function(e) {
                e.preventDefault();

                let formUrl = $(this).attr("action");
                let reqMethod = $(this).attr("method");
                let formData = new FormData(this);

                $.ajax({
                    url: formUrl,
                    type: reqMethod,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        let result = JSON.parse(data);
                        if (result.status == "success") {
                            Swal.fire("Success!", result.msg, "success").then(function() {
                                window.location.href = "../admin.php";
                            });
                        } else {
                            console.log(result);
                            Swal.fire("Error!", result.msg, "error");
                        }
                    }
                })
            })
        })
    </script>
</body>

</html>