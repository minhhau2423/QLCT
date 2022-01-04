<?php
	session_start();
	include 'database.php';
	$update=false;
	$id="";
	$name="";
	$username="";
	$password="";
	$phone="";
	$birthday="";
	$photo="";
	$address="";
	$number="";
	$position="";
	if(isset($_POST['add'])){
		$idpb=$_POST['idpb'];
		$name=$_POST['name'];
		$username=$_POST['username'];
		$password=$_POST['password'];
		$phone=$_POST['phone'];
		$birthday=$_POST['birthday'];
		$number=$_POST['number'];
		$position="";
		if(isset($_POST['position'])){
			$position="Admin";
			$idpb=NULL;
		}
		else{
			$position="Nhân viên";
		}
		$photo=$_FILES['image']['name'];
		$address=$_POST['address'];
		$upload="uploads/".$photo;
		$sql="INSERT INTO user(name,username,password,phone,birthday,avatar,address,position,idpb,numofdaysoff)VALUES(?,?,?,?,?,?,?,?,?,?)";
		$conn=open_database();
		$stmt=$conn->prepare($sql);
		$stmt->bind_param("ssssssssii",$name,$username,$password,$phone,$birthday,$upload,$address,$position,$idpb,$number);
		$stmt->execute();
		move_uploaded_file($_FILES['image']['tmp_name'], $upload);
		header('location:user.php');
		$_SESSION['response']="Congratulation! You added successfully";
		$_SESSION['res_type']="success";

	}
	if(isset($_GET['edit'])){
		$id=$_GET['edit'];
		$query="SELECT * FROM user WHERE id=?";
		$conn=open_database();
		$stmt=$conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();
		$result=$stmt->get_result();
		$row=$result->fetch_assoc();

		$id=$row['id'];
		$name=$row['name'];
		$username=$row['username'];
		$password=$row['password'];
		$phone=$row['phone'];
		$birthday=$row['birthday'];
		$photo=$row['avatar'];
		$address=$row['address'];
		$position=$row['position'];
		$idpb=$row['idpb'];
		$number=$row['numofdaysoff'];
		$update=true;
	}


	if(isset($_POST['update'])){
		$id=$_POST['id'];
		$name=$_POST['name'];
		$username=$_POST['username'];
		$phone=$_POST['phone'];
		$birthday=$_POST['birthday'];
		$address=$_POST['address'];
		$position=$_POST['position'];
		//$idpb=$row['idpb'];
		$idpb=$_POST['idpb'];
		//$number=$_POST['number'];
		$number=0;
		if(isset($position)){
			if ($position=="Nhân viên"){
				$number=12;
			}
			if ($position=="Trưởng phòng"){
				$number=15;
			}
		}
		$oldimage=$_POST['oldimage'];

		if(isset($_FILES['image']['name'])&&($_FILES['image']['name']!="")){
			$newimage='uploads/'.$_FILES['image']['name'];
			unlink($oldimage);
			move_uploaded_file($_FILES['image']['tmp_name'], $newimage);
		}
		else{
			$newimage=$oldimage;
		}
		$query="UPDATE user SET name=?,username=?,phone=?,birthday=?,avatar=?,address=?,position=?,idpb=?,numofdaysoff=? WHERE id=?";
		$conn=open_database();
		$stmt=$conn->prepare($query);
		$stmt->bind_param("sssssssiii",$name,$username,$phone,$birthday,$newimage,$address,$position,$idpb, $number, $id);
		$stmt->execute();

		$_SESSION['response']="Bạn đã cập nhật thành công";
		$_SESSION['res_type']="primary";
		header('location:user.php');
	}


	if(isset($_POST['resetpassword'])){
		$id=$_POST['id'];
		$username=$_POST['username'];
		$hashed_password = password_hash($username, PASSWORD_DEFAULT);

		$query="UPDATE user SET password=? WHERE id=?";
		$conn=open_database();
		$stmt=$conn->prepare($query);
		$stmt->bind_param("si",$hashed_password,$id);
		$stmt->execute();

		$_SESSION['response']="Reset mật khẩu thành công";
		$_SESSION['res_type']="primary";
		header('location:user.php');
	}


	if(isset($_GET['details'])){
		$id=$_GET['details'];
		$query="SELECT * FROM user WHERE id=?";
		$conn=open_database();
		$stmt=$conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();
		$result=$stmt->get_result();
		$row=$result->fetch_assoc();

		$vid=$row['id'];
		$vname=$row['name'];
		$vusername=$row['username'];
		$vpassword=$row['password'];
		$vphone=$row['phone'];
		$vbirthday=$row['birthday'];
		$vphoto=$row['avatar'];
		$vaddress=$row['address'];
		$vposition=$row['position'];
		$vnumber=$row['numofdaysoff'];
	}

?>