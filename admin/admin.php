<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
  header("location: ../index.php");
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $deletestmt = $conn->query("DELETE FROM table_weapon WHERE weaponID = $delete_id");
  $deletestmt->execute();

  if ($deletestmt) {
    echo "<script>alert('Data has been deleted successfully');</script>";
    $_SESSION['success'] = "Data has been deleted successfully";
    header("refresh:1; url=admin.php");
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="icon" href="../public/img/logo.png " type="image/gif">
  <title>Admin Page</title>
</head>

<!-- CSS Admin Page -->

<style>
  @import url('https://fonts.googleapis.com/css2?family=Chakra+Petch&family=Kanit:wght@300&family=Nova+Square&display=swap');


  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Chakra Petch', sans-serif;
    color: aliceblue;
  }

  body {
    background-color: #3a3a3a;

  }

  .btn-grp {
    display: flex;
    justify-content: space-between;
    height: 150px;
    padding: 0 4rem;
    margin: 0 2rem;
    align-items: center;
    border-bottom: aliceblue solid .1px;
  }
</style>

<!-- CSS Admin Page -->

<body>
  <div class="btn-grp">
    <div class="btb-b">
      <a href="../index.php"><button type="button" class="btn btn-danger">Back to Site</button></a>
    </div>
    <div class="head-text">
      <h1>DASHBOARD</h1>
    </div>
    <div class="btn-add">
      <a href="../admin/crud/add.php"><button type="button" class="btn btn-success">Add+</button></a>
    </div>
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
  <table class="table">
    <thead>
      <tr>
        <th class="text-center" scope="col">#</th>
        <th class="text-center" scope="col">WeaponsName</th>
        <th class="text-center" scope="col">Image</th>
        <th class="text-center" scope="col">Type</th>
        <th class="text-center" scope="col">BulletType</th>
        <th class="text-center" scope="col">LoadingBullet</th>
        <th class="text-center" scope="col">Damage/Shot</th>
        <th class="text-center" scope="col">BulletSpeed/Shot</th>
        <th class="text-center" scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $stmt = $conn->query("SELECT * FROM table_weapon 
                                JOIN table_type ON table_weapon.type = table_type.typeID 
                                JOIN table_bullet ON table_weapon.bullettype = table_bullet.typebulletID ORDER BY table_weapon.weaponID");
      $stmt->execute();
      $weapons = $stmt->fetchAll();

      if (!$weapons) {
        echo "<tr><td colspan='6' class = 'text-center'>No Data found</td></tr>";
      } else {
        foreach ($weapons as $weapon) {;

      ?>
          <tr>
            <th class="text-center" scope="row"><?= $weapon['weaponID']; ?></th>
            <td class="text-center"><?= $weapon['weaponName']; ?></td>
            <td class="text-center" width="250px"><img width="100%" src="../admin/crud/uploads/<?= $weapon['imggun']; ?>" class="rounded" alt=""></td>
            <td class="text-center"><?= $weapon['typeName']; ?></td>
            <td class="text-center"><?= $weapon['typebulletName']; ?></td>
            <td class="text-center"><?= $weapon['loadingbullets']; ?></td>
            <td class="text-center"><?= $weapon['damageshots']; ?></td>
            <td class="text-center"><?= $weapon['bulletspeedshots']; ?></td>
            <td class="text-center">
              <a href="../admin/crud/edit.php?weaponID=<?= $weapon['weaponID']; ?>" class="btn btn-warning">Edit</a>
              <a href="?delete=<?= $weapon['weaponID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure ?');">Delete</a>
            </td>
          </tr>
      <?php }
      } ?>
    </tbody>
  </table>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>