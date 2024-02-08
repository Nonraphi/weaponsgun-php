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
    <link rel="stylesheet" href="public/css/index.css">
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
        <div class="ls-button">
            <?php
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $stmt = $conn->query("SELECT * FROM table_user WHERE userID = $user_id");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
                <div class="login-btn">
                    <!-- ปุ่ม Logout -->
                    <a href="login/logout.php"><button type="button" id="logoutButton" onclick="logoutFunction()">Logout</button></a>
                </div>
            <?php
            } else if (isset($_SESSION['admin_id'])) { 
                ?>
                <div class="admin-btn">
                    <!-- ปุ่ม Admin -->
                    <a href="admin/admin.php"><button type="button" id="adminButton" onclick="adminFunction()">Admin</button></a>
                </div>

                <div class="login-btn">
                    <!-- ปุ่ม Logout -->
                    <a href="login/logout.php"><button type="button" id="logoutButton" onclick="logoutFunction()">Logout</button></a>
                </div>
            <?php } else {
            ?>
                <div class="login-btn">
                    <!-- ปุ่ม Login -->
                    <a href="login/login.php"><button type="button" id="addButton">Login</button></a>
                </div>
            <?php
            }
            ?>
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

    <footer>
        <div class="footer-info">
            <p>Copyright 2023 😀</p>
        </div>
    </footer>  

    <script>
        function loginFunction() {
            // ทำสิ่งที่คุณต้องการในกรณี Login
            // ซ่อนปุ่ม Login
            document.getElementById("loginButton").style.display = "none";
            // แสดงปุ่ม Logout
            document.getElementById("logoutButton").style.display = "block";
        }
    </script>
</body>

</html>