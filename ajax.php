<?php
	//DB connection open
	$con = mysqli_connect('localhost','root','','ajax_registration') or die (mysqli_error($con));
	if($_GET['action'] == 'registration'){
		//echo 'registration';	
	}
	//always filter the incoming data
	
	$fname = filter_var($_GET['fname'], FILTER_SANITIZE_STRING);
	$lname = filter_var($_GET['lname'], FILTER_SANITIZE_STRING);
	$uname = filter_var($_GET['uname'], FILTER_SANITIZE_STRING);
	$password = filter_var($_GET['password'], FILTER_SANITIZE_STRING);
	$cpassword = filter_var($_GET['cpassword'], FILTER_SANITIZE_STRING);
	//server side validation
	if($password != $cpassword){
		$data = [
			'status' => 401,
			'msg' =>'password and cpassword does not match'
		];
		
	}else{
		//Build the query
		$sql = "SELECT * FROM user_tbl WHERE username='$uname'";
		
		//Execute the query
		$result = mysqli_query($con,$sql);
		
		$nor = mysqli_num_rows($result);
		if($nor == 0){
			//we can register
			$password = Sha1($password);
			//2. build the query
			$sql = "INSERT INTO user_tbl(fname,lname,uname,password) VALUES ('$fname','$lname','$uname','$password')";
			
			//3. execute the query
			$result = mysqli_query($con,$sql);
			$data = [
				'status'=>200,
				'msg' =>'User registered successfully'
			];
		}else{
			//we cant register
			$data = [
				'status'=>402,
				'msg' =>'username already Exists'
			];
		}
		
	}
	echo Json_encode($data);
	
	if($_GET['action'] == 'login'){
		echo 'login';
	}
	//5. DB connection close
	mysqli_close($con);
?>