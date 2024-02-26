<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
  header("location: ../index.php");
}

if (isset($_GET['delete'])) {
  $user_id = $_GET['delete'];
  $userstmt = $conn->query("DELETE FROM table_user WHERE userID = $user_id");
  $userstmt->execute();

  if ($userstmt) {
    echo "<script>alert('Data has been deleted successfully');</script>";
    $_SESSION['success'] = "Data has been deleted successfully";
    header("refresh:1; url=user.php");
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
    margin: 2rem 0 0 0;
    align-items: center;
    border-bottom: aliceblue solid .1px;
  }

  .head-text h1 {
    margin: 50px 0 10px 0;
    text-align: center;
    width: 300px;
  }

  ul {
    margin: .5rem 0 3rem 0;
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

      &.content-user {
        color: #FFB60F;
        font-weight: 700;
        text-align: center;
        border-bottom: #FFB60F solid 2px;
        text-shadow: 0px 0px 8px rgba(255, 182, 15, 1);
      }
    }
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
      <h1>USER</h1>
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
    </div>
    <div class="btn-add">
      <?php $stmt = $conn->query("SELECT COUNT(*) as countUser FROM table_user 
                            GROUP BY userID");
      $stmt->execute();
      $count = $stmt->rowCount();
      ?>
      <p>มีผู้ใช้ทั้งหมด <?= $count; ?> คน</p>
    </div>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th class="text-center" scope="col">#</th>
        <th class="text-center" scope="col">Image</th>
        <th class="text-center" scope="col">FirstName</th>
        <th class="text-center" scope="col">LastName</th>
        <th class="text-center" scope="col">E-mail</th>
        <th class="text-center" scope="col">Username</th>
        <th class="text-center" scope="col">Password</th>
        <th class="text-center" scope="col">Role</th>
        <th class="text-center" scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $page = isset($_GET['page']) ? $_GET['page'] : 1;
      $records_per_page = 10;
      $offset = ($page - 1) * $records_per_page;

      $stmt = $conn->query("SELECT * FROM table_user ORDER BY userID LIMIT $offset, $records_per_page");
      $stmt->execute();
      $users = $stmt->fetchAll();

      if (!$users) {
        echo "<tr><td colspan='6' class = 'text-center'>No User found</td></tr>";
      } else {
        foreach ($users as $user) {;

      ?>
          <tr>
            <th class="text-center" scope="row"><?= $user['userID']; ?></th>
            <td class="text-center"><?= $user['imgUser']; ?></td>
            <td class="text-center"><?= $user['firstName']; ?></td>
            <td class="text-center"><?= $user['lastName']; ?></td>
            <td class="text-center"><?= $user['email']; ?></td>
            <td class="text-center"><?= $user['username']; ?></td>
            <td class="text-center"><?= $user['password']; ?></td>
            <td class="text-center"><?= $user['role']; ?></td>
            <td class="text-center">
              <a href="?delete=<?= $user['userID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure ?');">Delete</a>
            </td>
          </tr>
      <?php }
      } ?>
    </tbody>
  </table>

  <div class="pagination">
    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $records_per_page = 10;
    $offset = ($page - 1) * $records_per_page;

    $stmt_count = $conn->query("SELECT COUNT(*) AS total FROM table_comment");
    $total_records = $stmt_count->fetch()['total'];
    $total_pages = ceil($total_records / $records_per_page);

    $start_page = max(1, $page - 1); // หน้าแรกที่จะแสดง
    $end_page = min($total_pages, $start_page + 2); // หน้าสุดท้ายที่จะแสดง

    $previous = $page - 1;
    $next = $page + 1;
    ?>
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