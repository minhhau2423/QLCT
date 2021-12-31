<?php
   /*  session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    } */

    require_once('database.php');
    $conn=open_database();
    $iduser='3';//
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nghỉ phép</title>
        <!-- cdn bs4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style3.css?v=1">
    <link rel="stylesheet" href="hstyle.css?v=1">
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
                            <button>
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
                <img id="logonmenu" src="logo.png" alt="" srcset="">
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="./truongphong.php">Quản lý công việc</a>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Nghỉ phép</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="#">Duyệt nghỉ phép</a>
                        </li>
                        <li>
                            <a href="#">Xin nghỉ phép</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Thông tin cá nhân</a>
                </li>
            </ul>
        </nav>
    </div>

    <?php
        $num=0;
        $sql = "SELECT * FROM user WHERE id=$iduser";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row['position']=='Trưởng phòng'){
                $num=15;
            }
            elseif($row['position']=='Nhân viên'){
                $num=12;
            }
        }

        //
        $numoff=0;
        $sql = "SELECT * FROM dayoff WHERE iduser=$iduser AND status!='refused'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $numoff+=$row['numday'];
            }
        }
    ?>

    <div class="wrapper">
        <div class="row">
            <div class="col-12 col-sm-4 col-md-3 col-lg-2" id="left-bar">
                <?php
                     $sql = "SELECT * FROM dayoff WHERE iduser=$iduser AND status='waiting'";
                     $result = $conn->query($sql);

                     $sql2 = "SELECT * FROM dayoff WHERE iduser=$iduser ORDER BY id DESC";
                     $result2 = $conn->query($sql2);
                     $last="0000-00-00";
                     if($result2->num_rows>0){
                         $tmp=$result2->fetch_assoc();
                         if($tmp['daterep']!=null)
                            $last=$tmp['daterep'];
                     }
                     if (($result->num_rows == 0) && (strtotime(date("Y-m-d")) - strtotime($last))/86400 >= 7) {

                    ?>
                         <div class="hadd-task" data-toggle="modal" data-target="#yeucau-modal">
                            <i class="fas fa-pencil-alt"></i><b class="ml-2">Tạo yêu cầu</b>
                        </div>
                        <?php
                    }
                ?>
               
                <hr/>
                <div >
                    <b class="ml-2" style="color: #8D4E85;">Số ngày nghỉ:</b> <?php echo $num;?>
                    <br>
                    <b class="ml-2" style="color: #8D4E85;">Ngày đã nghỉ:</b> <?php echo $numoff;?>
                    <br>
                    <b class="ml-2" style="color: #8D4E85;">Còn lại:</b> <?php echo $num- $numoff;?>
                </div>
                <hr/>
            </div>
            <div class="col-12 col-sm-8 col-md-9 col-lg-10">
                <div id="list" class="hscroll" >
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ngày yêu cầu</th>
                            <th scope="col">Lý do</th>
                            <th scope="col">Số ngày xin nghỉ</th>
                            <th scope="col">Đính kèm</th>
                            <th scope="col">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i=1;
                                $sql = "SELECT * FROM dayoff WHERE iduser=$iduser ORDER BY id DESC";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {

                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $i;?></th>
                                        <td><?php echo $row['date'];?></td>
                                        <td><?php echo $row['reson'];?></td>
                                        <td><?php echo $row['numday'];?></td>
                                        <td>
                                            <?php
                                                if($row['file']!=null){
                                                    $file = explode(',',$row['file']);
                                                    foreach($file as $key=>$val){
                                            ?>       
                                             <div class="btn btn-outline-primary" onclick='download("<?php echo $val; ?>")'><?php echo $val; ?></div>
                                            <?php 
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <?php
                                            if($row['status']=='approved'){
                                        ?>
                                            <td class="text-success"><?php echo $row['status'];?></td>
                                        
                                        <?php } ?>
                                        <?php
                                            if($row['status']=='refused'){
                                        ?>
                                            <td class="text-danger"><?php echo $row['status'];?></td>
                                        
                                        <?php } ?>
                                        <?php
                                            if($row['status']=='waiting'){
                                                
                                        ?>
                                            <td class="text-warning"><?php echo $row['status'];?></td>
                                        
                                        <?php } ?>
                                    </tr>
                                    <?php
                                        $i++;
                                    }
                                }
                            ?>                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
   
    <?php
    if(isset($_POST['submit'])){
        $mess = "";
        $Dir = "files/";
        $file = $_FILES['file']['name'];
        $newName=array();
        $fileName="";
        if(isset($_POST['reson']) && isset($_POST['numberdayoff']) && isset($_POST['startday'])){
            if($file[0]!=null){
                foreach($file as $key =>$val){
                    $salt = time();
                    array_push($newName, $salt."_".$val);
                    $path = $Dir . $salt."_".$val;
                    move_uploaded_file($_FILES['file']['tmp_name'][$key],$path);
                }
                $fileName = implode("," ,$newName);
            }
            $sql = "INSERT INTO  dayoff (numday,startday,iduser,reson,status,file)
            VALUES ('".$_POST['numberdayoff']."','".$_POST['startday']."','".$iduser."','".$_POST['reson']."','waiting','".$fileName."')";
            if ($conn->query($sql) === FALSE) {
                echo "Error updating record: " . $conn->error;
            }else{
                echo("<meta http-equiv='refresh' content='0'>");
            }
        }     
    }
    ?>

<!-- Modal yêu cầu -->
    <div class="modal fade" id="yeucau-modal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">    
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tạo yêu cầu nghỉ phép</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="needs-validation" enctype="multipart/form-data" id="form-add-task" novalidate>
                        <div class="form-group">
                            <label for="" >Số ngày nghỉ</label>
                            <input type="number" class="form-control" name="numberdayoff" min='1' max='12' required> <!-- max = còn lại -->
                            <div class="invalid-feedback">
                                Chưa nhập số ngày nghỉ
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" >Ngày bắt đầu</label>
                            <input type="date" class="form-control" name="startday" id="deadline" required>
                            <div class="invalid-feedback">
                                Chưa nhập ngày bắt đầu nghỉ
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" >Lý do</label>
                            <textarea type="text" class="form-control" name="reson" required></textarea>
                            <div class="invalid-feedback">
                                Chưa nhập lý do
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" >Thêm đính kèm</label>
                            <input type="file" class=" custom-file-input" id="filepost" multiple hidden name="file[]" onchange="updateList()">
                            <label for="filepost" class="btn btn-primary btn-sm form-control" >
                                <i class="fas fa-cloud-upload-alt" style="font-size: 20px;"></i>
                            </label>
                            <div id="fileList"></div>
                        </div>
                            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary" name="submit" >Gửi</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
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