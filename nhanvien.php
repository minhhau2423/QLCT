<?php
session_start();
if ($_SESSION['first']) {
    header('Location: changepass.php');
    exit();
}
if (!isset($_SESSION['username']) || $_SESSION['position'] != "Nhân viên") {
    header('Location: index.php');
    exit();
}

require_once('database.php');
$conn = open_database();

$phongban = $_SESSION['idpb'];
$nhanvien =  $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhân viên</title>

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style.css?v=1">
   

    <!-- cdn bs4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">

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
                            <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle" height="32" alt="Avatar" loading="lazy" />
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
                    <a href="#homeSubmenu">Quản lý công việc</a>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Nghỉ phép</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
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

    <div class="wrapper">
        <!-- Page Content  -->
        <div class="row">
            <div class="col-12 col-sm-4 col-md-3 col-lg-2" id="left-bar">
                <div class="hsidebar-filter hsidebar-filter-active" id="all">Tất cả</div>
                <div class="hsidebar-filter" id="new">Mới</div>
                <div class="hsidebar-filter" id="inprogress">Đang tiến hành</div>
                <div class="hsidebar-filter" id="waiting">Đang đợi</div>
                <div class="hsidebar-filter" id="rejected">Làm lại</div>
                <div class="hsidebar-filter" id="success">Đã hoàn thành</div>
                <hr />
            </div>
            <div class="col-12 col-sm-8 col-md-9 col-lg-10">
                <div id="list" class="hscroll">
                    <!-- load danh sach task -->
                    <?php
                    $sql = "SELECT * FROM task WHERE idnv =" . $nhanvien . " AND status!='canceled' ORDER BY idtask DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row['status'] == "completed") {
                                echo "<div class='hnotice hnotice-success' onclick='" . "location.href=\"cttasknv.php?id=" . $row['idtask'] . "\"" . "'>";
                            }
                            if ($row['status'] == "new") {
                                echo "<div class='hnotice hnotice-new' onclick='" . "location.href=\"cttasknv.php?id=" . $row['idtask'] . "\"" . "'>";
                            }
                            if ($row['status'] == "rejected") {
                                echo "<div class='hnotice hnotice-rejected' onclick='" . "location.href=\"cttasknv.php?id=" . $row['idtask'] . "\"" . "'>";
                            }
                            if ($row['status'] == "waiting") {
                                echo "<div class='hnotice hnotice-waiting' onclick='" . "location.href=\"cttasknv.php?id=" . $row['idtask'] . "\"" . "'>";
                            }
                            if ($row['status'] == "inprogress") {
                                echo "<div class='hnotice hnotice-inprogress' onclick='" . "location.href=\"cttasknv.php?id=" . $row['idtask'] . "\"" . "'>";
                            }
                            $sqltp = "SELECT * FROM user WHERE id =" . $row['idtp'] . "";
                            $tp = $conn->query($sqltp)->fetch_assoc();
                            $sqlnv = "SELECT * FROM user WHERE id =" . $row['idnv'] . "";
                            $tmpnv = $conn->query($sqlnv);
                            if ($tmpnv->num_rows > 0) {
                                $nv = $tmpnv->fetch_assoc();
                                echo "<span class='htask_name'>" . $nv['name'] . "</span>
                                        <strong class='htask_status'>" . $row['status'] . "</strong>
                                        <div class='htask_title'>" . $row['title'] . "</div>
                                        <div class='htask_detail'>" . $row['content'] . "</div>";
                            }
                            echo "</div>";
                        }
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['submit'])) {
        $mess = "";
        $Dir = "files/";
        $file = $_FILES['filedelivered']['name'];
        $newName = array();
        $fileName = "";
        /*  $fileName = implode("," ,$file); */
        if (isset($_POST['idnv']) && isset($_POST['content']) && isset($_POST['title']) && isset($_POST['deadline'])) {
            if ($file[0] != null) {
                foreach ($file as $key => $val) {
                    $salt = time();
                    array_push($newName, $salt . "_" . $val);
                    $path = $Dir . $salt . "_" . $val;
                    move_uploaded_file($_FILES['filedelivered']['tmp_name'][$key], $path);
                }
                $fileName = implode(",", $newName);
            }
            $sql = "INSERT INTO  task (idnv,idtp,status,content,title,deadline,filedelivered) 
            VALUES ('" . $_POST['idnv'] . "','" . $truongphong . "','new','" . $_POST['content'] . "','" . $_POST['title'] . "','" . $_POST['deadline'] . "','" . $fileName . "')";

            if ($conn->query($sql) === FALSE) {
                $mess = "Thêm không thành công";
            } else {
                echo ("<meta http-equiv='refresh' content='0'>");
            }
        }
    }
    ?>

    <!-- Modal -->
    <div class="modal fade" id="addtask-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tạo nhiện vụ mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="needs-validation" id="form-add-task" enctype="multipart/form-data" novalidate>
                        <div class="form-group">
                            <label for="">Nhân viên</label>
                            <select class="custom-select" style="height: auto;" id="selectnv" name="idnv" required>
                                <option value="" selected disabled>--Chọn nhân viên--</option>
                                <?php
                                $sql = "SELECT * FROM user WHERE idpb=" . $phongban . " AND id!=" . $truongphong . "";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback ">
                                Chưa chọn nhân viên nhận task
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Tiêu đề</label>
                            <input type="text" class="form-control" name="title" required>
                            <div class="invalid-feedback">
                                Chưa đặt tiêu đề cho task
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Nội dung</label>
                            <textarea type="text" class="form-control" name="content" required></textarea>
                            <div class="invalid-feedback">
                                Chưa đặt nội dung cho task
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Hạn nộp</label>
                            <input type="date" class="form-control" name="deadline" id="deadline" required>
                            <div class="invalid-feedback">
                                Chưa đặt deadline cho task
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Tệp đính kèm</label>
                            <input type="file" class=" custom-file-input" id="filepost" multiple hidden name="filedelivered[]" onchange="updateList()">
                            <label for="filepost" class="btn btn-primary btn-sm form-control">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 20px;"></i>
                            </label>
                            <div id="fileList"></div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary" name="submit">Tạo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="./main.js?v=1"></script>


</body>

</html>