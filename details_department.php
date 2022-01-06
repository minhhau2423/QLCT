<?php
    session_start();
    if ($_SESSION['first']){
        header('Location: changepass.php');
        exit();
    }
    if (!isset($_SESSION['username']) || $_SESSION['position'] != "Giám đốc") {
        header('Location: index.php');
        exit();
    }
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
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- cdn bs4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>

<body>
    <!-- header -->
    <?php include 'header_nosearch.php' ?>
    
    <div class="container ">
    <?php
        if($result2->num_rows>0)
        { 
            while($row2=$result2->fetch_assoc()) {
                ?>
                <table class="table">
                    <tr style="text-align: center; vertical-align:middle;">
                        <td colspan=3><h3 class="font-weight-bold" style="color:#8D4E85; text-transform: uppercase;">PHÒNG <?=$row2['namepb'];?></h3></td></tr>
                    <tr>
                        <td><span>ID: </span><?=$row2['idpb'];?></td>
                        <td><span>SỐ:</span> <?=$row2['numberRoom'];?></td>
                        <td><?=$row2['description'];?><td>
                    </tr>
                </table>
                <?php
            }
        }
    ?>

        <div class="row justify-content-center mt-2">
            <table class="table" style="text-align: center; vertical-align:middle;">
                <thead style="color:#8D4E85; background-color:#E9DCE5;">
                    <tr>
                        <th>Id</th>
                        <th>Tên</th>
                        <th>Vị Trí</th>
                        <th>Chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                if($result->num_rows>0)
                { 
                while($row=$result->fetch_assoc()) {
              ?>
                    <tr>
                        <td><?=$row['id'];?></td>
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
                                <button class="btn" style="border: none; background-color:#8D4E85; color:white;" name="update_details">
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
        </div>
    </div>
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="./main.js?v=1"></script>

</body>

</html>