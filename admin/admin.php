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

if (isset($_GET['search'])) {
  // Store the search term in session variable
  $_SESSION['search_term'] = $_GET['search'];
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
    align-items: center;
    height: 150px;
    padding: 0 2rem;
    margin: 2rem 0 0 0;
    border-bottom: aliceblue solid .1px;
  }

  .head-text h1 {
    margin: 50px 0 10px 0;
    text-align: center;
    width: 300px;
  }

  .head-text p {
    text-align: center;
    margin: 20px 0 75px 0;
  }

  ul {
    margin: .5rem 0 .2rem 0;
    padding-left: 0;
    display: flex;
    justify-content: space-around;
    list-style: none;
    width: 100%;

    & a {
      text-decoration: none;
    }

    & li {
      display: flex;
      align-items: end;
      cursor: pointer;
      padding: 0 10px;

      &.content-dash {
        color: #FFB60F;
        font-weight: 700;
        text-align: center;
        border-bottom: #FFB60F solid 2px;
        text-shadow: 0px 0px 8px rgba(255, 182, 15, 1);
      }
    }
  }

  .btn-add-group {
    width: 310px;
  }

  .btn-add {
    display: flex;
    justify-content: center;
  }

  .search-box form {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1rem;

  }

  .search-box input[type="text"] {
    border: 2px solid #FFB60F;
    border-radius: 5px;
    padding: 0.5rem;
    width: 220px;
  }

  .search-box button {
    background-color: #FFB60F;
    color: #1E1E3F;
    border: none;
    border-radius: 5px;
    padding: 0.5rem 1rem;
    cursor: pointer;
  }

  .search-box button:hover {
    background-color: #e0a800;
  }


  .pagination {
    display: flex;
    justify-content: center;
    margin: 5rem 0;

  }

  .pagination .btn {
    margin: 0 5px;
  }

  .pagination .btn-primary {
    background-color: #1E1E3F;
    border-color: #1E1E3F;
    color: #FFB60F;
    text-shadow: 0px 0px 8px rgba(255, 182, 15, 1);
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
  }

  .pagination .btn-secondary {
    background-color: #3A3A3A;
    border-color: #3A3A3A;
    color: #e0a800;
    text-shadow: 0px 0px 12px rgba(224, 168, 0, 0.8);
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
  }

  .pagination .btn-primary:hover {
    background-color: rgba(255, 255, 255, 0.2);
    border-color: #ccc;
    color: #FFB60F;
    transition: .2s;
  }

  .pagination .btn-secondary:hover {
    background-color: rgba(255, 255, 255, 0.2);
    border-color: #ccc;
    color: #e0a800;
    transition: .2s;
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
      <ul>
        <a href="admin.php">
          <li class="content-dash">DASHBOARD</li>
        </a>
        <a href="massage.php">
          <li class="content-com">COMMENT</li>
        </a>
        <a href="user.php">
          <li class="content-user">USER</li>
        </a>
      </ul>
      <?php $stmt = $conn->query("SELECT COUNT(*) as countGun FROM table_weapon 
                            GROUP BY weaponID");
      $stmt->execute();
      $count = $stmt->rowCount();
      ?>
      <p>มีอาวุธทั้งหมด <?= $count; ?> กระบอก</p>
    </div>
    <div class="btn-add-group">
      <div class="btn-add">
        <a href="../admin/crud/add.php">
          <button type="button" class="btn btn-success">Add+</button>
        </a>
      </div>
      <div class="search-box">
        <form action="" method="GET">
          <input class="form-control" type="text" placeholder="Search Weapons" aria-label="Search Weapons" name="search" value="<?php echo isset($_SESSION['search_term']) ? $_SESSION['search_term'] : ''; ?>">
          <button type="submit" class="btn btn-primary">Search</button>
        </form>
      </div>
    </div>
  </div>
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

    <table class="table mt-2 ">
      <thead>
        <tr>
          <th class="text-center" scope="col">#</th>
          <th class="text-center" scope="col">WeaponsName</th>
          <th class="text-center" scope="col">Image</th>
          <th class="text-center" scope="col">Type</th>
          <th class="text-center" scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $records_per_page = 6;
        $offset = ($page - 1) * $records_per_page;

        if (isset($_GET['search'])) {
          $search = $_GET['search'];
          $stmt = $conn->prepare("SELECT * FROM table_weapon 
                                JOIN table_type ON table_weapon.type = table_type.typeID 
                                JOIN table_bullet ON table_weapon.bullettype = table_bullet.typebulletID 
                                WHERE weaponName LIKE :search
                                OR table_bullet.typebulletName LIKE :search
                                OR table_type.typeName LIKE :search
                                ORDER BY table_weapon.weaponID
                                LIMIT $offset, $records_per_page");
          $stmt->bindValue(':search', "%$search%");
        } else {
          // หากไม่มีการส่งคำค้นหามา ให้ดึงข้อมูลทั้งหมดเหมือนเดิม
          $stmt = $conn->query("SELECT * FROM table_weapon 
                                JOIN table_type ON table_weapon.type = table_type.typeID 
                                JOIN table_bullet ON table_weapon.bullettype = table_bullet.typebulletID 
                                ORDER BY table_weapon.weaponID
                                LIMIT $offset, $records_per_page");
        }
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
              <td class="text-center">
                <a href="../admin/crud/view.php?weaponID=<?= $weapon['weaponID']; ?>" class="btn btn-primary">Views</a>
                <a href="../admin/crud/edit.php?weaponID=<?= $weapon['weaponID']; ?>" class="btn btn-warning">Edit</a>
                <a href="?delete=<?= $weapon['weaponID']; ?>" class="btn btn-danger" onclick="return confirm('You want to delete <?= $weapon['weaponName']; ?> right?');">Delete</a>
              </td>
            </tr>
        <?php }
        } ?>
      </tbody>
    </table>

  <?php
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $records_per_page = 6;
  $offset = ($page - 1) * $records_per_page;

  if (isset($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%'; // Add wildcards to search term
    $stmt_count = $conn->prepare("SELECT COUNT(*) AS total FROM table_weapon WHERE weaponName LIKE :search");
    $stmt_count->bindParam(':search', $search, PDO::PARAM_STR);

    // Update the query to filter by search term
    $stmt = $conn->prepare("SELECT * FROM table_weapon WHERE weaponName LIKE :search LIMIT :offset, :records_per_page");
    $stmt->bindParam(':search', $search, PDO::PARAM_STR);
  } else {
    $stmt_count = $conn->query("SELECT COUNT(*) AS total FROM table_weapon");

    // No search term, retrieve all records
    $stmt = $conn->prepare("SELECT * FROM table_weapon LIMIT :offset, :records_per_page");
  }

  // Bind parameters for LIMIT clause
  $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
  $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);

  $stmt_count->execute();
  $stmt->execute();

  $total_records = $stmt_count->fetch()['total'];
  $total_pages = ceil($total_records / $records_per_page);

  $start_page = max(1, $page - 1);
  $end_page = min($total_pages, $start_page + 2);

  $previous = $page - 1;
  $next = $page + 1;
  ?>

  <div class="pagination">
    <?php if ($page > 1) : ?>
      <a href="?page=1" class="btn <?php echo $page == 1 ? 'btn-primary' : 'btn-secondary'; ?>">First</a>
      <a href="?page=<?= $previous ?>" class="btn btn-secondary">
        <<</a>
        <?php endif; ?>
        <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
          <a href="?page=<?= $i ?>" class="btn <?= $i == $page ? 'btn-primary' : 'btn-secondary'; ?>"><?= $i ?></a>
        <?php endfor; ?>
        <?php if ($page < $total_pages) : ?>
          <a href="?page=<?= $next ?>" class="btn btn-secondary">>></a>
          <a href="?page=<?= $total_pages ?>" class="btn <?php echo $page == $total_pages ? 'btn-primary' : 'btn-secondary'; ?>">Last</a>
        <?php endif; ?>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>