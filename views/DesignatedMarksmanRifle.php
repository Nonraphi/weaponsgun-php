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
    <link rel="stylesheet" href="../public/css/DesignatedMarksmanRifle.css">
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

        <div class="ls-button">
            <div class="login-btn">
                <a href="../login/login.php"><button type="button">Login</button></a>
            </div>
        </div>
    </header>
    <section>
        <div class="header-content">
            <h1>Designated Marksman Rifle</h1>
        </div>
        <div class="info-item">
            <p>ปืนไรเฟิลนักแม่นปืนที่กำหนด (DMR) เป็นอาวุธปืนสำหรับนักแม่นปืนที่กำหนด
                เหมาะสำหรับเป้าหมายระยะกลางหรือไกลกว่า</p>
        </div>

        <div class="container-content">

        <?php
            $stmt = $conn->query("SELECT * FROM table_weapon 
                                JOIN table_type ON table_weapon.type = table_type.typeID 
                                JOIN table_bullet ON table_weapon.bullettype = table_bullet.typebulletID
                                WHERE table_type.typeName = 'Designated Marksman Rifle'");
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

    <footer>
        <div class="footer-info">
            <p>Copyright 2023 😀</p>
        </div>
    </footer>


</body>

</html>