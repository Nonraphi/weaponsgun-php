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
    <title>Account Details</title>
    <link rel="stylesheet" href="profile_info.css">
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

    <h1>Account Details</h1>

    <article>
        <div class="container">
            <div class="box">

            <input type="hidden" readonly value="<?= $data['userID'] ?>" class="form-control" name="userID" require>
                <div class="profile_info">
                    <p>Firstname :</p>
                    <p><?= $row['firstName'] ?></p>
                </div>
                <div class="profile_info">
                    <p>Lastname :</p>
                    <p><?= $row['lastName'] ?></p>
                </div>
                <div class="profile_info">
                    <p>E-mail :</p>
                    <p><?= $row['email'] ?></p>
                </div>
                <div class="profile_info">
                    <p>Username :</p>
                    <p><?= $row['username'] ?></p>
                </div>
                <div class="edit-profile">
                    <a href="edit_profile.php?userID=<?= $row['userID']; ?>"><button type="button" class="btn btn-warning">Edit Profile</button></a>
                </div>
            </div>
        </div>
    </article>

    <footer-component></footer-component>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../footer/footer.js"></script>
    <script>
        const dropbtn = document.getElementById("dropbtn");
        const dropdownContent = document.getElementById("dropdown-content");

        dropbtn.addEventListener("click", function() {
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
                console.log("TEST");
            } else {
                dropdownContent.style.display = "block";
                console.log("Error");
            }
        });
    </script>
</body>

</html>