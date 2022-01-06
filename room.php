<?php
	include 'database.php';
	$update=false;
	$idpb="";
	$namepb="";
	$description="";
	$numberRoom="";
	if(isset($_POST['add'])){
        $namepb=$_POST['namepb'];
        $description=$_POST['description'];
        $numberRoom=$_POST['numberRoom'];
        if(isset($_POST['add']))
        {
            $sql="INSERT INTO department(namepb,description,numberRoom)VALUES(?,?,?)";
			$conn=open_database();
            $stmt=$conn->prepare($sql);
            $stmt->bind_param("ssi",$namepb,$description,$numberRoom);
            $stmt->execute();
            header('location:department.php');
            $_SESSION['response']="Bạn đã thêm phòng ban thành công";
            $_SESSION['res_type']="success";
	    }
    }
	if(isset($_GET['edit'])){
		$id=$_GET['edit'];

		$query="SELECT * FROM department WHERE idpb=?";
		$conn=open_database();
		$stmt=$conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();
		$result=$stmt->get_result();
		$row=$result->fetch_assoc();
		$idpb=$row['idpb'];
		$namepb=$row['namepb'];
		$description=$row['description'];
		$numberRoom=$row['numberRoom'];
		$update=true;
	}
	if(isset($_POST['update'])){
		$idpb=$_POST['idpb'];
		$namepb=$_POST['namepb'];
		$description=$_POST['description'];
		$numberRoom=$_POST['numberRoom'];
		
		$query="UPDATE department SET namepb=?,description=?,numberRoom=? WHERE idpb=?";
		$conn=open_database();
		$stmt=$conn->prepare($query);
		$stmt->bind_param("sssi",$namepb,$description,$numberRoom, $idpb);
		$stmt->execute();
		$_SESSION['response']="Bạn đã cập nhật thành công";
		$_SESSION['res_type']="primary";
		header('location:department.php');
	}
	if(isset($_GET['details_department'])){
        $idpb=$_GET['details_department'];
        $query= "SELECT * FROM user WHERE idpb=?";
		$conn=open_database();
        $stmt= $conn->prepare($query);
		$stmt->bind_param("i",$idpb);
		$stmt->execute();
		$result=$stmt->get_result();

		//get phong ban hien tai
		$query2= "SELECT * FROM department WHERE idpb=?";
		$stmt2= $conn->prepare($query2);
		$stmt2->bind_param("i",$idpb);
		$stmt2->execute();
		$result2=$stmt2->get_result();
	}

    if(isset($_POST['update_details'])){
		$id=$_POST['id_click'];
		$idpb=$_POST['id_click_pb'];
		$sql="UPDATE user SET position='Nhân viên' WHERE user.idpb = $idpb";
		$conn=open_database();
		$query=$conn->query($sql);

		$position="";
		$position="Trưởng phòng";
		$query="UPDATE user SET position=? WHERE id=?";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("si",$position, $id);
		$stmt->execute();
		$_SESSION['response']="Bạn đã cập nhật Trưởng Phòng Thành công";
		$_SESSION['res_type']="primary";
		header("location:details_department.php?details_department=$idpb");
	}
?>