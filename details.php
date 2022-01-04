<?php
  include 'account.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="author" content="Sahil Kumar">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Details User</title>
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
                        <li class="nav-item active">
                            <img
                            <?php
                                $sql = "SELECT * FROM user WHERE position ='Giám đốc'";
                                $tmp=$conn->query($sql);
                                if ($tmp->num_rows > 0) {
                                    $us = $tmp->fetch_assoc();
                                }
                                if($us['avatar']!=null){
                                    $avt = $us['avatar'];
                                    echo "src='uploads/$avt'";
                                }else{
                                    $tmp='avt_tmp.jpg';
                                    echo "src='images/$tmp'";
                                }
                            ?>
                            class="rounded-circle" height="32" width="32"
                            alt="Avatar"
                            loading="lazy" />
                        </li>
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
                <li class="active">
                    <a href="./user.php">Quản lý nhân viên</a>
                </li>
                <li >
                    <a href="./department.php">Quản lý phòng ban</a>
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


      <div class="container">


        <div class="row justify-content-center">
        <table class="table" style="width:800px; text-align: center;">
          <tr>
            <td colspan=2 ><img src="<?=$vphoto?>"
                style="width:150px;height:150px;border-radius:50%;object-fit:cover;border: solid #8D4E85;" class="img-thumbnail"></td>
          </tr>
          <tr>
            <td class="font-weight-bold">ID</td>
            <td style="background-color:#E9DCE5;"><?= $vid?></td>
          </tr>
          <tr>
            <td style="background-color:#E9DCE5;" class="font-weight-bold">Họ tên</td>
            <td><?= $vname?></td>
          </tr>
          <tr>
            <td class="font-weight-bold">Tên đăng nhập</td>
            <td style="background-color:#E9DCE5;"><?= $vusername?></td>
          </tr>
          <tr>
            <td style="background-color:#E9DCE5;" class="font-weight-bold">Số điện thoại</td>
            <td><?= $vphone?></td>
          </tr>
          <tr>
            <td class="font-weight-bold">Sinh nhật</td>
            <td style="background-color:#E9DCE5;"><?= $vbirthday?></td>
          </tr>
          <tr>
            <td style="background-color:#E9DCE5;" class="font-weight-bold">Địa chỉ</td>
            <td><?= $vaddress?></td>
          </tr>
          <tr>
            <td class="font-weight-bold">Chức vụ</td>
            <td style="background-color:#E9DCE5;"><?= $vposition?></td>
          </tr>
          <tr>
            <td style="background-color:#E9DCE5;" class="font-weight-bold">Số ngày nghỉ</td>
            <td><?= $vnumber?></td>
          </tr>
        </table>
      </div>

        <!-- jQuery CDN - Slim version (=without AJAX) -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script type="text/javascript" src="./main.js?v=1"></script>
</body> 

</html>