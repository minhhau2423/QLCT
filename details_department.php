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
    <title>Details User</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="#">Details User</a>
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
    <div class="container ">
        <div class="row justify-content-center p-5">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Tên</th>
                        <th>Vị Trí</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                if($result->num_rows>0)
                { 
                while($row=$result->fetch_assoc()) {
              ?>
                    <tr>
                        <td><?=$row['name'];?></td>
                        <td><?=$row['position'];?></td>
                        
                        <td>
                          <?php
                            if($row['position']!="Trưởng phòng")
                            {
                          ?>
                            <form action="room.php" method="POST">
                                <input type="hidden" name="id_click" value="<?= $row['id']?>">
                                <input type="hidden" name="id_click_pb" value="<?= $row['idpb']?>">
                                <input type="hidden" name="position" value="<?= $row['position']?>">
                                <button class="badge badge-success p-3" name="update_details">
                                    Bổ nhiệm
                                </button>
                            </form>
                          <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
              }
              ?>
                </tbody>
            </table>
            </table>
        </div>
    </div>
</body>

</html>