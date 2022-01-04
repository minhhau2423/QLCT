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
  <!-- Our Custom CSS -->
  <link rel="stylesheet" href="style.css">
  <!-- cdn bs4 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />

</head>

<body>
      <!-- header -->
      <div>
        <nav class="navbar navbar-expand-lg navbar-light h2">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn dashboard">
                    <i class="fas fa-align-left"></i>
                    <span>Menu</span>
                </button>
                <div class="hsearch_container">
                    <input type="text" placeholder="Tìm kiếm..." id="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>

                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <!-- <li class="nav-item active">
                            <img
                            <?php
                                // $sql = "SELECT * FROM user WHERE id =$truongphong";
                                // $tmp=$conn->query($sql);
                                // if ($tmp->num_rows > 0) {
                                //     $us = $tmp->fetch_assoc();
                                // }
                                // if($us['avatar']!=null){
                                //     $avt = $us['avatar'];
                                //     echo "src='uploads/$avt'";
                                // }else{
                                //     $tmp='avt_tmp.jpg';
                                //     echo "src='images/$tmp'";
                                // }
                            ?>
                            class="rounded-circle" height="32" width="32"
                            alt="Avatar"
                            loading="lazy" />
                        </li> -->
                        <li class="nav-item">
                            <button onclick="location.href='logout.php'">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- slidebar -->
        <nav id="sidebar">
            <div id="dismiss">
                <i class="fas fa-arrow-left"></i>
            </div>

            <div class="sidebar-header">
                <img id="logonmenu" src="images/logo.png" alt="" srcset="">
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="./user.php">Quản lý nhân viên</a>
                </li>
                <li class="active">
                    <a href="./department.php">Quản lý phòng ban</a>
                </li>
                <li>
                    <a href="#homeSubmenu">Quản lý công việc</a>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Nghỉ phép</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="./duyetnghiphep.php">Duyệt nghỉ phép</a>
                        </li>
                        <li>
                            <a href="./nghiphep.php">Xin nghỉ phép</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="./profile.php">Thông tin cá nhân</a>
                </li>
            </ul>
        </nav>
    </div>

  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h3 class="text-center text-dark mt-2 font-weight-bold">QUẢN LÝ PHÒNG BAN</h3>
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
        <h3 class="text-center text-info">Thêm phòng ban</h3>
        <form action="room.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="idpb" value="<?= $id; ?>">
          <div class="form-group">
            <input type="text" name="namepb" value="<?= $namepb; ?>" class="form-control" placeholder="Tên phòng ban" required>
          </div>
          <div class="form-group">
            <input type="text" name="description" value="<?= $description; ?>" class="form-control" placeholder="Mô tả" required>
          </div>
          <div class="form-group">
            <input type="number" name="numberRoom" value="<?= $numberRoom; ?>"  class="form-control" placeholder="Số phòng" required>
          </div>
          <div class="form-group">
            <?php if ($update == true) { ?>
            <input type="submit" name="update" class="btn btn-block" style="background-color:#8D4E85; color: white;" value="Cập Nhật">
            <?php } else { ?>
            <input type="submit" name="add" class="btn btn-block" style="border: none; background-color:#8D4E85; color: white;" value="Thêm">
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
        <table class="table table-hover" style="text-align: center;" id="data-table">
          <thead>
            <tr>
              <th>Id</th>
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
                <a href="details_department.php?details_department=<?= $row['idpb']; ?>" 
                    class="btn" style="border: none; background-color:#E9DCE5; color:#8D4E85;">Xem</a>
                <a href="department.php?edit=<?= $row['idpb']; ?>" 
                    class="btn" style="border: none; background-color:#8D4E85; color:white;">Sửa</a>
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

  <!-- jQuery CDN - Slim version (=without AJAX) -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script type="text/javascript" src="./main.js?v=1"></script>

</body>

</html>