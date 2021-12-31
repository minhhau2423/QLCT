<?php
/*  session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    } */

require_once('database.php');
$conn = open_database();
$iduser = '1'; //

$idtp = '1'; //
$idpb = '1'; //
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyệt nghỉ phép</title>
    <!-- cdn bs4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style3.css?v=1">
    <link rel="stylesheet" href="hstyle.css?v=1">
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

    <div class="container">
        <div class="">
            <div id="list" class="hscroll">
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
                        $i = 1;
                        $sql = "SELECT * FROM dayoff WHERE iduser=$iduser ORDER BY id DESC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>
                                    <td><?php echo $row['date']; ?></td>
                                    <td><?php echo $row['reson']; ?></td>
                                    <td><?php echo $row['numday']; ?></td>
                                    <td>
                                        <?php
                                        if ($row['file'] != null) {
                                            $file = explode(',', $row['file']);
                                            foreach ($file as $key => $val) {
                                        ?>
                                                <div class="btn btn-outline-primary" onclick='download("<?php echo $val; ?>")'><?php echo $val; ?></div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    if ($row['status'] == 'approved') {
                                    ?>
                                        <td class="text-success"><?php echo $row['status']; ?></td>

                                    <?php } ?>
                                    <?php
                                    if ($row['status'] == 'refused') {
                                    ?>
                                        <td class="text-danger"><?php echo $row['status']; ?></td>

                                    <?php } ?>
                                    <?php
                                    if ($row['status'] == 'waiting') {

                                    ?>
                                        <td class="text-warning"><?php echo $row['status']; ?></td>

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

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="main.js?v=1"></script>
</body>

</html>