<?php
session_start();
require_once 'config/db.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weapons-Gun</title>
    <link rel="stylesheet" href="button.css">
    <link rel="icon" href="public/img/logo.png " type="image/gif">

</head>

<body>
    <header>
        <div class="img-logo">
            <a href="index.php"><img src="public/img/logo.png" alt=""></a>
        </div>

        <div class="list-weapon">
            <ul>
                <a href="../weapon-gun/views/AssaultRifles.php">
                    <li class="list-weapon-gun">AR</li>
                </a>
                <a href="../weapon-gun/views/DesignatedMarksmanRifle.php">
                    <li class="list-weapon-gun">DMR</li>
                </a>
                <a href="../weapon-gun/views/SubmachineGuns.php">
                    <li class="list-weapon-gun">SMG</li>
                </a>
                <a href="../weapon-gun/views/Shotguns.php">
                    <li class="list-weapon-gun">SHOTGUN</li>
                </a>
                <a href="../weapon-gun/views/SniperRifles.php">
                    <li class="list-weapon-gun">SR</li>
                </a>
                <a href="../weapon-gun/views/LightMachineGuns.php">
                    <li class="list-weapon-gun">LMG</li>
                </a>
                <a href="../weapon-gun/views/Pistols.php">
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
                                <a href="#">Account Details</a>
                                <a href="#">Comment</a>
                                <?php if (isset($_SESSION['admin_id'])) { ?>
                                    <a href="#">Admin Dashboard</a>
                                <?php } ?>
                                <a href="login/logout.php">Sign Out</a>
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
                    <a href="login/login.php"><button type="button" id="addButton">Login</button></a>
                </div>
            <?php } ?>
        </div>


    </header>

    <div class="text-head">
        <h1>อาวุธที่แนะนำ</h1>
    </div>

    <div class="weapon-card">
        <div class="weapon1-card">
            <div class="weapon-img">
                <img src="public/img/1.webp" alt="">
            </div>
            <div class="weapon-info">
                <h3>AUG</h3>
                <ul>
                    <li class="weapon-info-gun">ดาเมจ/นัด</li>
                    <li class="weapon-info-gun">50</li>
                </ul>
                <ul>
                    <li class="weapon-info-gun">ชนิดกระสุน</li>
                    <li class="weapon-info-gun">5.56mm</li>
                </ul>
                <ul>
                    <li class="weapon-info-gun">การบรรจุกระสุน</li>
                    <li class="weapon-info-gun">30 นัด</li>
                </ul>
                <ul>
                    <li class="weapon-info-gun">ความไวกระสุน/วินาที</li>
                    <li class="weapon-info-gun">800 m/s</li>
                </ul>
            </div>
        </div>

        <div class="weapon1-card">
            <div class="weapon-img">
                <img src="public/img/2.webp" alt="">
            </div>
            <div class="weapon-info">
                <h3>M416</h3>
                <ul>
                    <li class="weapon-info-gun">ดาเมจ/นัด</li>
                    <li class="weapon-info-gun">50</li>
                </ul>
                <ul>
                    <li class="weapon-info-gun">ชนิดกระสุน</li>
                    <li class="weapon-info-gun">5.56mm</li>
                </ul>
                <ul>
                    <li class="weapon-info-gun">การบรรจุกระสุน</li>
                    <li class="weapon-info-gun">30 นัด</li>
                </ul>
                <ul>
                    <li class="weapon-info-gun">ความไวกระสุน/วินาที</li>
                    <li class="weapon-info-gun">800 m/s</li>
                </ul>
            </div>
        </div>

        <div class="weapon1-card">
            <div class="weapon-img">
                <img src="public/img/3.webp" alt="">
            </div>
            <div class="weapon-info">
                <h3>Berly</h3>
                <ul>
                    <li class="weapon-info-gun">ดาเมจ/นัด</li>
                    <li class="weapon-info-gun">50</li>
                </ul>
                <ul>
                    <li class="weapon-info-gun">ชนิดกระสุน</li>
                    <li class="weapon-info-gun">5.56mm</li>
                </ul>
                <ul>
                    <li class="weapon-info-gun">การบรรจุกระสุน</li>
                    <li class="weapon-info-gun">30 นัด</li>
                </ul>
                <ul>
                    <li class="weapon-info-gun">ความไวกระสุน/วินาที</li>
                    <li class="weapon-info-gun">800 m/s</li>
                </ul>
            </div>
        </div>
    </div>

    <footer-component></footer-component>

    <script>
        function loginFunction() {
            // ทำสิ่งที่คุณต้องการในกรณี Login
            // ซ่อนปุ่ม Login
            document.getElementById("loginButton").style.display = "none";
            // แสดงปุ่ม Logout
            document.getElementById("logoutButton").style.display = "block";
        }

        class Footer extends HTMLElement {
            constructor() {
                super();
            }

            connectedCallback() {
                this.innerHTML = ` 
                                    <footer>
                                    <div class="footer-info">
                                        <p>Copyright © 2023 all rights reserved</p>
                                        <p>by JayPondTik Co.,Ltd.</p>
                                    </div>
                                    </footer>
                                    `
            }
        }

        customElements.define('footer-component', Footer);


        const dropbtn = document.getElementById("dropbtn");
        const dropdownContent = document.getElementById("dropdown-content");

        dropbtn.addEventListener("click", function() {
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    </script>

</body>

</html>