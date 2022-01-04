<?php
    session_start();
    if($_SESSION['first']){
        header('Location: changepass.php');
        exit();  
    }

    require_once('database.php');
    $conn=open_database();

    $phongban = $_SESSION['idpb'];
    $truongphong =  $_SESSION['id'];
    $lastdate="0000-00-00";
    $idyeucau=$_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết yêu cầu</title>
        <!-- cdn bs4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css?v=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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

                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item active">
                            <img
                            src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp"
                            class="rounded-circle"
                            height="32"
                            alt="Avatar"
                            loading="lazy"
                            />
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
                    <a href="./truongphong.php">Quản lý công việc</a>
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
    <?php
        $currentDate = date('Y-m-d');
        if(isset($_POST['dongy'])){
            $sql = "UPDATE dayoff SET status='approved', daterep='$currentDate' WHERE id=$idyeucau";
            if ($conn->query($sql) === TRUE) {
                echo("<meta http-equiv='refresh' content='0'>");
            } else {
            echo "Error updating record: " . $conn->error;
            }
        }
        if(isset($_POST['tuchoi'])){
            $sql = "UPDATE dayoff SET status='refused',daterep=$currentDate WHERE id=$idyeucau";
            if ($conn->query($sql) === TRUE) {
                echo("<meta http-equiv='refresh' content='0'>");
            } else {
            echo "Error updating record: " . $conn->error;
            }
        }
    ?>

    <div class="container hscroll">
    <?php
             $sql = "SELECT * FROM dayoff WHERE id =".$idyeucau."";
             $result = $conn->query($sql);
             if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if($row['status']=="waiting"){
                    echo "<div class='hnotice-ct hnotice-waiting'>";
                }
                if($row['status']=="refused"){
                    echo "<div class='hnotice-ct hnotice-rejected'>";
                }
                if($row['status']=="approved"){
                    echo "<div class='hnotice-ct hnotice-success'>";
                }
                $sqlnv = "SELECT * FROM user WHERE id =".$row['iduser']."";
                $tmpnv=$conn->query($sqlnv);
                if ($tmpnv->num_rows > 0) {
                    $nv = $tmpnv->fetch_assoc();
                }
                echo "  
                        <span style='font-weight: bold;'>YÊU CẦU XIN NGHỈ PHÉP</span>
                        <hr>
                        <div class='task_title'><small>Người gừi</small> ".$nv['name']."
                            <span style='float:right;'>
                                <small>Ngày gửi: </small> ".$row['date']."
                            </span>
                        </div>
                        <hr>
                        <div> <small>Lý do xin nghỉ: </small> ".$row['reson']."</div>
                        <br>";
                if($row['file']!=null){
                    $file = explode(',',$row['file']);
                    foreach($file as $key=>$val){
                       echo "<div class='btn btn-outline-primary mr-2' style='max-width:100%;' onclick='download(\"".$val."\")'><i class='fas fa-paperclip'></i> ".$val." </div>"; 
                    }   
                }
                echo "<form method='POST' action=''>";
                if($row['status']=="waiting"){
                    echo "<div style='height: 50px;'>
                            <button name='tuchoi' type='submit' class='btn btn-danger mt-1 ml-2' style='float: right;' data-toggle='modal' data-target='#lamlai-modal'>Từ chối</button>
                            <button name='dongy' type='submit' class='btn btn-success mt-1' style='float: right;' data-toggle='modal' data-target='#dongy-modal'>Đồng ý</button>
                          </div>";
                }
                echo "</form>";
                echo "</div>";
             }
        ?>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js"
    integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
    integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
    crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
    integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
    crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="main.js?v=1"></script>
</body>
</html>