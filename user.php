<?php
  if(!isset($_SESSION)) 
  { 
    session_start(); 
  } 
  if ($_SESSION['first']){
      header('Location: changepass.php');
      exit();
  }
  if (!isset($_SESSION['username']) || $_SESSION['position'] != "Giám đốc") {
      header('Location: index.php');
      exit();
  }
  $_SESSION['position'];
  $idpb="";
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
  <!-- Our Custom CSS -->
  <link rel="stylesheet" href="style.css">
  <!-- cdn bs4 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />
</head>

<body>
    <!-- header -->
    <?php include 'header.php' ?>

  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h3 class="text-center text-dark mt-2 font-weight-bold">QUẢN LÝ NHÂN VIÊN</h3>
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
      <div class="col-md-3 card p-3">
        <h3 style="color:#8D4E85;" class="text-center">Thêm nhân viên</h3>
        <form action="account.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $id; ?>">
          <div class="form-group">
            <input type="text" name="name" value="<?= $name; ?>" class="form-control" placeholder="Họ tên" required>
          </div>
          <div class="form-group">
            <input type="text" name="username" value="<?= $username; ?>" class="form-control" placeholder="Tên đăng nhập" required>
          </div>
          <div class="form-group">
            <input type="tel" name="phone" value="<?= $phone; ?>" class="form-control" placeholder="Số điện thoại" required>
          </div>
          <div class="form-group">
            <input type="date" name="birthday" value="<?= $birthday; ?>" class="form-control" placeholder="Ngày sinh" required>
          </div>
          <div class="form-group">
            <input type="hidden" name="oldimage" value="<?= $photo; ?>">
            <input type="file" name="image" class="custom-file" accept="image/*">
            <?php
              if($photo!=null){
                  ?>
                    <img src="uploads/<?= $photo; ?>" width="120" class="img-thumbnail">
                  <?php
              }
            ?>
            
          </div>
          <div class="form-group">
            <input type="text" name="address" value="<?= $address; ?>" class="form-control" placeholder="Địa chỉ" required>
          </div>
          <input type="checkbox" value="<?= $position; ?>" name="position" id="position">
          <span class="checkmark">Admin</span>

          <br>
          <br>
          <select  class="custom-select" style="height: auto;"  id="selectnv" name="idpb" required >
              <option disabled>--Chọn Phòng Ban--</option>
              <?php  
                  $sql = "SELECT * FROM department";
          
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                        ?>
                          <option value=<?=$row['idpb']?> <?php if($idpb!=null && $idpb==$row['idpb']){ echo 'selected';}  ?> ><?=$row['namepb']?></option>
                        <?php  
                      }
                  }
              ?>
           </select>
          <br>
          <br>
          <div class="form-group">
            <input type="text" name="position" value="<?= $position; ?>" class="form-control" placeholder="Chức vụ" required>
          </div>
          <div class="form-group">
            <input type="number" name="number" value="<?= $number; ?>" class="form-control" placeholder="Số ngày nghỉ" readonly>
          </div>
          <div class="form-group">
            <?php if ($update == true) { ?>
              <input type="submit" name="resetpassword" class="btn" style="border: none; background-color:#E9DCE5; color:#8D4E85; margin-bottom:20px; float:right;" value="Reset mật khẩu">
            <input type="submit" name="update" class="btn btn-block" style="border: none; background-color:#8D4E85; color:white;" value="Lưu">
            <?php } else { ?>
            <input type="submit" name="add" class="btn btn-block" style="border: none; background-color:#8D4E85; color:#E9DCE5;" value="Thêm">
            <?php } ?>
          </div>
        </form>
      </div>
      <div class="col-md-9">
        <?php
          $query = 'SELECT * FROM user, department WHERE user.idpb=department.idpb AND user.position<>"Giám đốc"' ;
     
          $stmt = $conn->prepare($query);
          $stmt->execute();
          $result = $stmt->get_result();
        ?>
        <h3 style="color:#8D4E85;" class="text-center">Danh sách nhân viên</h3>
        <table class="table table-hover" id="data-table">
          <thead>
            <tr>
              <th>Id</th>
              <th>Avatar</th>
              <th>Họ tên</th>
              <th>Số điện thoại</th>
              <th>Chức vụ</th>
              <th>Phòng Ban</th>
              <th>Chức năng</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
              <td><?= $row['id']; ?></td>
              <td><img src="uploads/<?=$row['avatar'];?>" width="50px" height="50px" style="object-fit:cover;"></td>
              <td><?= $row['name']; ?></td>
              <td><?= $row['phone']; ?></td>
              <td><?= $row['position']; ?></td>
              <td><?= $row['namepb']; ?></td>
              <td>
                <a href="details.php?details=<?= $row['id']; ?>" class="btn" style="border: none; background-color:#E9DCE5; color:#8D4E85;">Xem</a>
                <a href="user.php?edit=<?= $row['id']; ?>" class="btn" style="border: none; background-color:#8D4E85; color:white;">Sửa</a>
              </td> 
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
      <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="./main.js?v=1"></script>
</body>

</html>