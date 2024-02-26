<?php

session_start();
require_once '../config/db.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Edit Account</title>
    <link rel="stylesheet" href="edit_profile.css">
    <link rel="icon" href="../public/img/logo.png " type="image/gif">
</head>

<body>
    <header>
        <div class="img-logo">
            <a href="../index.php"><img src="../public/img/logo.png" alt=""></a>
        </div>

        <div class="list-weapon">
            <ul>
                <a href="../views/AssaultRifles.php">
                    <li class="list-weapon-gun">AR</li>
                </a>
                <a href="../views/DesignatedMarksmanRifle.php">
                    <li class="list-weapon-gun">DMR</li>
                </a>
                <a href="../views/SubmachineGuns.php">
                    <li class="list-weapon-gun">SMG</li>
                </a>
                <a href="../views/Shotguns.php">
                    <li class="list-weapon-gun">SHOTGUN</li>
                </a>
                <a href="../views/SniperRifles.php">
                    <li class="list-weapon-gun">SR</li>
                </a>
                <a href="../views/LightMachineGuns.php">
                    <li class="list-weapon-gun">LMG</li>
                </a>
                <a href="../views/Pistols.php">
                    <li class="list-weapon-gun">HANDGUN</li>
                </a>
            </ul>
        </div>

        <div class="drop">
            <?php
            if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
                // ตรวจสอบค่า user_id และ admin_id และกำหนดค่าให้เป็น null ถ้าไม่มี
                $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
                $admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : null;

                // ตรวจสอบค่า user_id และ admin_id ว่ามีค่าไม่ใช่ null หรือไม่
                if ($user_id !== null || $admin_id !== null) {
                    // เรียกข้อมูลผู้ใช้จากฐานข้อมูล (ในที่นี้จำลองการเรียกใช้ข้อมูล)
                    $stmt = $conn->prepare("SELECT * FROM table_user WHERE userID = :user_id OR userID = :admin_id");
                    $stmt->bindParam(':user_id', $user_id);
                    $stmt->bindParam(':admin_id', $admin_id);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // ตรวจสอบว่ามีผลลัพธ์จากการเรียกข้อมูลหรือไม่
                    if ($row) {
            ?>
                        <div class="dropdown">
                            <!-- แสดงชื่อผู้ใช้หรือผู้ดูแลระบบ -->
                            <button id="dropbtn" class="dropbtn"><?= $row['username']; ?></button>
                            <div id="dropdown-content" class="dropdown-content">
                                <a href="../profile/profile_info.php">Account Details</a>
                                <a href="../comment/Comment.php">Comment</a>
                                <?php if (isset($_SESSION['admin_id'])) { ?>
                                    <a href="../admin/admin.php">Admin Dashboard</a>
                                <?php } ?>
                                <a href="../login/logout.php">Sign Out</a>
                            </div>
                        </div>
                <?php
                    } else {
                        // กรณีไม่พบข้อมูลผู้ใช้หรือผู้ดูแลระบบ
                        echo "Error: User data not found!";
                    }
                } else {
                    // กรณี user_id และ admin_id เป็น null
                    echo "Error: User or admin not logged in!";
                }
            } else {
                // กรณีไม่มีการล็อกอิน
                ?>
                <div class="login-btn">
                    <a href="../login/login.php"><button type="button" id="addButton">Login</button></a>
                </div>
            <?php } ?>
        </div>

    </header>

    <h1>Edit Account</h1>

    <article>
        <form action="update_profile.php" method="post" id="editform">
            <!-- เพิ่ม input hidden เพื่อส่งค่า userID -->
            <input type="hidden" name="userID" value="<?= $row['userID'] ?>">
            <div class="container">
                <div class="box">
                    <div class="profile_info">
                        <p>Firstname :</p>
                        <input type="text" class="form-control" value="<?= $row['firstName'] ?>" name="firstname" require>
                    </div>
                    <div class="profile_info">
                        <p>Lastname :</p>
                        <input type="text" class="form-control" value="<?= $row['lastName'] ?>" name="lastname" require>
                    </div>
                    <div class="profile_info">
                        <p>E-mail :</p>
                        <input type="email" class="form-control" value="<?= $row['email'] ?>" name="email" require>
                    </div>
                    <div class="profile_info">
                        <p>Username :</p>
                        <input type="text" class="form-control" value="<?= $row['username'] ?>" name="username" require>
                    </div>
                    <div class="edit-profile">
                        <a class="btn btn-danger" href="profile_info.php">Go Back</a>
                        <button type="submit" name="update" class="btn btn-warning">Update Account</button>
                    </div>
                </div>
            </div>
        </form>
    </article>

    <footer-component></footer-component>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../footer/footer.js"></script>
    <script>
        const dropbtn = document.getElementById("dropbtn");
        const dropdownContent = document.getElementById("dropdown-content");

        dropbtn.addEventListener("click", function() {
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });

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
                                window.location.href = "profile_info.php";
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