    <!-- header -->
    <div>
        <nav class="navbar navbar-expand-lg navbar-light h2">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn dashboard">
                    <i class="fas fa-align-left"></i>
                    <span>Menu</span>
                </button>

                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item active">
                        <img
                        <?php
                            $p = $_SESSION['position'];
                            $sql = "SELECT * FROM user WHERE position ='$p'";
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
                        style="object-fit:cover;"
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
    <?php include 'slidebar.php' ?>
    </div>