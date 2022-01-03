<?php
  include 'room.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="Sahil Kumar">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>department Management</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />

  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
</head>

<body>
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" href="#">User</a>
    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#">Sửa sau</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Sửa sau</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Sửa sau</a>
        </li>
      </ul>
    </div>
    <form class="form-inline" action="/action_page.php">
      <input class="form-control mr-sm-2" type="text" placeholder="Search">
      <button class="btn btn-primary" type="submit">Search</button>
    </form>
  </nav>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h3 class="text-center text-dark mt-2">Quản Lý Phòng Ban</h3>
        <hr>
        <?php if (isset($_SESSION['response'])) { ?>
        <div class="alert alert-<?= $_SESSION['res_type']; ?> alert-dismissible text-center">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <b><?= $_SESSION['response']; ?></b>
        </div>
        <?php } unset($_SESSION['response']); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <h3 class="text-center text-info">Add Room</h3>
        <form action="room.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="idpb" value="<?= $id; ?>">
          <div class="form-group">
            <input type="text" name="namepb" value="<?= $namepb; ?>" class="form-control" placeholder="Enter  your room" required>
          </div>
          <div class="form-group">
            <input type="text" name="description" value="<?= $description; ?>" class="form-control" placeholder="Enter  your description" required>
          </div>
          <div class="form-group">
            <input type="number" name="numberRoom" value="<?= $numberRoom; ?>"  class="form-control" placeholder="Enter  your number" required>
          </div>
          <div class="form-group">
            <?php if ($update == true) { ?>
            <input type="submit" name="update" class="btn btn-success btn-block" value="Cập Nhật">
            <?php } else { ?>
            <input type="submit" name="add" class="btn btn-primary btn-block" value="Thêm">
            <?php } ?>
          </div>
        </form>
      </div>
      <div class="col-md-8">
        <?php
          $query = 'SELECT * FROM department';
          $conn=open_database();
          $stmt = $conn->prepare($query);

          $stmt->execute();
          $result = $stmt->get_result();
        ?>
        <h3 class="text-center text-info">Phòng Ban</h3>
        <table class="table table-hover" id="data-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Tên Phòng Ban</th>
              <th>Mô Tả</th>
              <th>Số Phòng</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
              <td><?= $row['idpb']; ?></td>
              <td><?= $row['namepb']; ?></td>
              <td><?= $row['description']; ?></td>
              <td><?= $row['numberRoom']; ?></td>
              <td>
                <a href="details_department.php?details_department=<?= $row['idpb']; ?>" class="badge badge-primary p-3">Details</a> |
                <a href="department.php?edit=<?= $row['idpb']; ?>" class="badge badge-success p-3">Edit</a>
              </td> 
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  $(document).ready(function() {
    $('#data-table').DataTable({
      paging: true
    });
  });
  </script>
</body>

</html>