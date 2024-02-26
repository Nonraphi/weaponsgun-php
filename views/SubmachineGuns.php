<?php

session_start();
require_once '../config/db.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weapons-Gun</title>
    <link rel="stylesheet" href="../public/css/SubmachineGuns.css">
    <link rel="icon" href="../public/img/logo.png " type="image/gif">
</head>

<body>
    <header>
        <div class="img-logo">
            <a href="../index.php"><img src="../public/img/logo.png" alt=""></a>
        </div>

        <div class="list-weapon">
            <ul>
                <a href="AssaultRifles.php">
                    <li class="list-weapon-gun">AR</li>
                </a>
                <a href="DesignatedMarksmanRifle.php">
                    <li class="list-weapon-gun">DMR</li>
                </a>
                <a href="SubmachineGuns.php">
                    <li class="list-weapon-gun">SMG</li>
                </a>
                <a href="Shotguns.php">
                    <li class="list-weapon-gun">SHOTGUN</li>
                </a>
                <a href="SniperRifles.php">
                    <li class="list-weapon-gun">SR</li>
                </a>
                <a href="LightMachineGuns.php">
                    <li class="list-weapon-gun">LMG</li>
                </a>
                <a href="Pistols.php">
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
    <section>
        <div class="header-content">
            <h1>SubmachineGuns</h1>
        </div>
        <div class="info-item">
            <p>ปืนกลมือ (SMG) ได้รับการออกแบบมาเพื่อความคล่องตัวและการยิงที่รวดเร็ว
                เหมาะอย่างยิ่งสำหรับการหยุดศัตรูในระยะใกล้</p>
        </div>

        <div class="container-content">

            <?php
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $records_per_page = 6;
            $offset = ($page - 1) * $records_per_page;
            
            $stmt = $conn->query("SELECT * FROM table_weapon 
                                JOIN table_type ON table_weapon.type = table_type.typeID 
                                JOIN table_bullet ON table_weapon.bullettype = table_bullet.typebulletID
                                WHERE table_type.typeName = 'SubmachineGuns'
                                LIMIT $offset, $records_per_page");
            $stmt->execute();
            $datas = $stmt->fetchAll();

            if (!$datas) {
                echo 'No Weapons';
            } else {
                foreach ($datas as $data) {;

            ?>
                    <div class="weapon-content">
                        <div class="img-weapon-content">
                            <img width="100%" src="../admin/crud/uploads/<?= $data['imggun']; ?>" alt="">
                        </div>
                        <div class="info-weapon-content">
                            <h3><?= $data['weaponName']; ?></h3>
                            <ul>
                                <li class="info-gun-content">Damage/Shot</li>
                                <li class="info-gun-content"><?= $data['damageshots']; ?></li>
                            </ul>
                            <ul>
                                <li class="info-gun-content">BulletType</li>
                                <li class="info-gun-content"><?= $data['typebulletName']; ?></li>
                            </ul>
                            <ul>
                                <li class="info-gun-content">LoadingBullet</li>
                                <li class="info-gun-content"><?= $data['loadingbullets']; ?></li>
                            </ul>
                            <ul>
                                <li class="info-gun-content">BulletSpeed/Shot</li>
                                <li class="info-gun-content"><?= $data['bulletspeedshots']; ?></li>
                            </ul>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>

    </section>

    <div class="pagination">
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $records_per_page = 6;
        $offset = ($page - 1) * $records_per_page;

        $stmt_count = $conn->query("SELECT COUNT(*) AS total FROM table_weapon WHERE type = 3");
        $total_records = $stmt_count->fetch()['total'];
        $total_pages = ceil($total_records / $records_per_page);

        $start_page = max(1, $page - 1); // หน้าแรกที่จะแสดง
        $end_page = min($total_pages, $start_page + 2); // หน้าสุดท้ายที่จะแสดง

        $previous = $page - 1;
        $next = $page + 1;
        ?>
        <?php if ($page > 1) : ?>
            <a href="?page=1" class="btn btn-secondary">First</a>
            <a href="?page=<?= $previous ?>" class="btn btn-secondary">
                <<</a>
                <?php endif; ?>
                <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                    <?php if ($i == $page) : ?>
                        <a href="?page=<?= $i ?>" class="btn btn-primary"><?= $i ?></a>
                    <?php else : ?>
                        <a href="?page=<?= $i ?>" class="btn btn-secondary"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($page < $total_pages) : ?>
                    <a href="?page=<?= $next ?>" class="btn btn-secondary">>></a>
                    <a href="?page=<?= $total_pages ?>" class="btn btn-secondary">Last</a>
                <?php endif; ?>
    </div>

    <footer-component></footer-component>

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
    </script>
</body>

</html>