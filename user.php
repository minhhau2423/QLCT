<?php
  include 'account.php';
  $conn=open_database();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="Sahil Kumar">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>User Management</title>
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
    <a class="navbar-brand" href="#">Sửa sau</a>
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
        <h1 class="text-center text-dark mt-2">Quản lý người dùng</h1>
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
        <h3 class="text-center text-info">Thêm người dùng</h3>
        <form action="account.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $id; ?>">
          <div class="form-group">
            <input type="text" name="name" value="<?= $name; ?>" class="form-control" placeholder="Enter your fullname" required>
          </div>
          <div class="form-group">
            <input type="text" name="username" value="<?= $username; ?>" class="form-control" placeholder="Enter your username" required>
          </div>
          <div class="form-group">
            <input type="password" name="password" value="<?= $password;?>" class="form-control" placeholder="Enter your password" required>
          </div>
          <div class="form-group">
            <input type="tel" name="phone" value="<?= $phone; ?>" class="form-control" placeholder="Enter your phone" required>
          </div>
          <div class="form-group">
            <input type="date" name="birthday" value="<?= $birthday; ?>" class="form-control" placeholder="Enter your date" required>
          </div>
          <div class="form-group">
            <input type="hidden" name="oldimage" value="<?= $photo; ?>">
            <input type="file" name="image" class="custom-file">
            <img src="<?= $photo; ?>" width="120" class="img-thumbnail">
          </div>
          <div class="form-group">
            <input type="text" name="address" value="<?= $address; ?>" class="form-control" placeholder="Enter your address" required>
          </div>
          <input type="checkbox" value="<?= $position; ?>" name="position" id="position">
          <span class="checkmark">Admin</span>

          <br>
          <br>
          <select  class="custom-select" style="height: auto;"  id="selectnv" name="idpb" value="<?= $idpb; ?>" required >
              <option value="" selected disabled>--Chọn Phòng Ban--</option>
              <?php  
                  $sql = "SELECT * FROM department";
          
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                          echo "<option value='".$row['idpb']."'>".$row['namepb']."</option>";
                      }
                  }
              ?>
           </select>
          <br>
          <br>
          <div class="form-group">
            <input type="number" name="number" value="<?= $number; ?>" class="form-control" placeholder="Enter your day" required>
          </div>
          <div class="form-group">
            <?php if ($update == true) { ?>
            <input type="submit" name="update" class="btn btn-success btn-block" value="Update User">
            <?php } else { ?>
            <input type="submit" name="add" class="btn btn-primary btn-block" value="Add User">
            <?php } ?>
          </div>
        </form>
      </div>
      <div class="col-md-8">
        <?php
          $query = 'SELECT user.id, user.avatar, user.username,user.phone, user.position,department.namepb  FROM user INNER JOIN department ON user.idpb= department.idpb AND user.position != "admin"';
     
          $stmt = $conn->prepare($query);
          $stmt->execute();
          $result = $stmt->get_result();
        ?>
        <h3 class="text-center text-info">User</h3>
        <table class="table table-hover" id="data-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Avatar</th>
              <th>username</th>
              <th>phone</th>
              <th>position</th>
              <th>Phòng Ban</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
              <td><?= $row['id']; ?></td>
              <td><img src="<?= "uploads/". $row['avatar']; ?>" width="40"></td>
              <td><?= $row['username']; ?></td>
              <td><?= $row['phone']; ?></td>
              <td><?= $row['position']; ?></td>
              <td><?= $row['namepb']; ?></td>
              <td>
                <a href="details.php?details=<?= $row['id']; ?>" class="badge badge-primary p-3">Details</a> |
                <a href="user.php?edit=<?= $row['id']; ?>" class="badge badge-success p-3">Edit</a>
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