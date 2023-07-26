	<?php
	include_once "config.php";

	class Crud extends Config
	{

		function __construct()
		{
			parent::__construct();
		}


		public function checkLogin($post)
		{
			$email=$this->cleanse($post['email']);
			$password=$this->cleanse($post['password']);
			$query = "SELECT * FROM login WHERE email= '$email' and password='$password'";
			$result = $this->con->query($query);
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				if ($row['role'] === '1') {
					$_SESSION['id'] = $email;
					$_SESSION['dashboard'] = '1';
					header("location:admin/dashboard.php");
				} else {
					$_SESSION['email'] = $email;
					$_SESSION['password'] = $password;
					$_SESSION['login'] = '1';
					header("location:question.php");
				}
			}else{
			 $system_ip = $_SERVER['REMOTE_ADDR'];        // Obtains the IP address
	         $system_name = gethostbyaddr($system_ip);   // Obtains the pc name
	         $system_server=$_SERVER['HTTP_HOST'];      // Obtains server name
	         $question='No Question';
	         $answer='No Answer';
	         $message='Be Warned..Threat Detected! Invalid email or password';
	         $login_time='Not logged in';
	         $logout_time='Not logged out';
	         $status='0';

	         $query="INSERT INTO session_log(email,password,question,answer,message,system_name,system_ip,system_server,login_time,logout_time,status) VALUES('$email','$password','$question','$answer','$message','$system_name','$system_ip','$system_server','$login_time','$logout_time','$status')";
	         $this->con->query($query);
			// $f1 = isset($post['f1']) ? 1: 0;

	         header("location:login.php?msg=$message&type=error");
	     }
	 }


	 public function checkQuestion($post)
	 {
	 	$_SESSION['answer']=$post['answer'];
	 	$email=$_SESSION['email'];
	 	$password=$_SESSION['password'];
	 	$answer=$this->cleanse($post['answer']);
	 	$query = "SELECT * FROM user WHERE answer= '$answer' and email= '$email' and password='$password'";
	 	$result = $this->con->query($query);
	 	if ($result->num_rows > 0) {
	 		$row = $result->fetch_assoc();
	 		$data=$this->displayOneSpecific('login','email',$email);
	 		if ($data['role'] === '1') {
	 			$_SESSION['id'] = $email;
	 			$_SESSION['dashboard'] = '1';
	 			header("location:admin/dashboard.php");
	 		} elseif($data['role'] === '3') {
			 $system_ip = $_SERVER['REMOTE_ADDR'];        // Obtains the IP address
	         $system_name = gethostbyaddr($system_ip);   // Obtains the pc name
	         $system_server=$_SERVER['HTTP_HOST'];		// Obtains server name
	         // $_SESSION['question']=$row['question'];      
	         // $_SESSION['answer']=$row['answer'];
	         // $message='Accurate Answer';
	         $login_time=date("d/m/y @ g:i A");
	         $status='1';
	         $query="UPDATE session_log SET system_name='$system_name',system_ip='$system_ip',system_server='$system_server',login_time='$login_time',status='$status' WHERE question='".$_SESSION['question']."' AND answer='".$_SESSION['answer']."' ";
	         $this->con->query($query);
	         $_SESSION['id'] = $email;
	         $_SESSION['dashboard'] = '1';
	         header("location:user/dashboard.php");
	     }

			// // $this->setval(1,$row['email']);
			// // $this->role($row['role']);

			// return $row;
	 }else{
	 	// $_SESSION['question']=$row['question'];
	 	$email=$_SESSION['email'];
	 	$password=$_SESSION['password'];
			 $system_ip = $_SERVER['REMOTE_ADDR'];        // Obtains the IP address
	         $system_name = gethostbyaddr($system_ip);   // Obtains the pc name
	         $system_server=$_SERVER['HTTP_HOST'];      // Obtains server name
	         $question=$_SESSION['question'];
	         $answer=$_SESSION['answer'];
	         $message='Be Warned..Threat Detected! Invalid Answer';
	         $login_time='Not logged in';
	         $logout_time='Not logged out';
	         $status='0';

	         $query="INSERT INTO session_log(email,password,question,answer,message,system_name,system_ip,system_server,login_time,logout_time,status) VALUES('$email','$password','$question','$answer','$message','$system_name','$system_ip','$system_server','$login_time','$logout_time','$status')";
	         $this->con->query($query);
	         header("location:question.php?msg=$message&type=error");
	     }
	 }




	 public function checkLoginQ()
	 {
	 	if($_SESSION['login']=="")
	 	{
	 		$email='No email';
	 		$password='No password';	
			 $system_ip = $_SERVER['REMOTE_ADDR'];        // Obtains the IP address
	         $system_name = gethostbyaddr($system_ip);   // Obtains the pc name
	         $system_server=$_SERVER['HTTP_HOST'];      // Obtains server name
	         $question='No Question';
	         $answer='No Answer';
	         $message='Be Warned..Threat Detected! Trying to access question page without an email and password';
	         $login_time='Not logged in';
	         $logout_time='Not logged out';
	         $status='0';

	         $query="INSERT INTO session_log(email,password,question,answer,message,system_name,system_ip,system_server,login_time,logout_time,status) VALUES('$email','$password','$question','$answer','$message','$system_name','$system_ip','$system_server','$login_time','$logout_time','$status')";
	         $this->con->query($query);
			// $f1 = isset($post['f1']) ? 1: 0;

	         header("location:login.php?msg=$message&type=error");
	     }
	 }



	 public function checkLoginD()
	 {
	 	if($_SESSION['dashboard']=="")
	 	{
	 		$email='No email';
	 		$password='No password';	
			 $system_ip = $_SERVER['REMOTE_ADDR'];        // Obtains the IP address
	         $system_name = gethostbyaddr($system_ip);   // Obtains the pc name
	         $system_server=$_SERVER['HTTP_HOST'];      // Obtains server name
	         $question='No Question';
	         $answer='No Answer';
	         $message='Be Warned..Threat Detected! Trying to access dashboard page';
	         $login_time='Not logged in';
	         $logout_time='Not logged out';
	         $status='0';

	         $query="INSERT INTO session_log(email,password,question,answer,message,system_name,system_ip,system_server,login_time,logout_time,status) VALUES('$email','$password','$question','$answer','$message','$system_name','$system_ip','$system_server','$login_time','$logout_time','$status')";
	         $this->con->query($query);
			// $f1 = isset($post['f1']) ? 1: 0;

	         header("location:login.php?msg=$message&type=error");
	     }
	 }






	//Display All
	 public function displayAll($table)
	 {
	 	$query = "SELECT * FROM {$table}";
	 	$result = $this->con->query($query);
	 	if ($result->num_rows > 0) {
	 		$data = array();
	 		while ($row = $result->fetch_assoc()) {
	 			$data[] = $row;
	 		}
	 		return $data;
	 	}else{
	 		return 0;
	 	}
	 }



	 public function displayAllWithOrder($table,$orderValue,$orderType)
	 {
	 	$query = "SELECT * FROM {$table} ORDER BY {$orderValue} {$orderType}";
	 	$result = $this->con->query($query);
	 	if ($result->num_rows > 0) {
	 		$data = array();
	 		while ($row = $result->fetch_assoc()) {
	 			$data[] = $row;
	 		}
	 		return $data;
	 	}else{
	 		return 0;
	 	}
	 }


	 public function displayAllSpecific($table,$value,$item)
	 {
	 	$query = "SELECT * FROM {$table} WHERE $value='$item' ";
	 	$result = $this->con->query($query);
	 	if ($result->num_rows > 0) {
	 		$data = array();
	 		while ($row = $result->fetch_assoc()) {
	 			$data[] = $row;
	 		}
	 		return $data;
	 	}else{
	 		return 0;
	 	}
	 }


	 public function displayAllSpecificWithOrder($table,$value,$item,$orderValue,$orderType)
	 {
	 	$query = "SELECT * FROM {$table} WHERE $value='$item' ORDER BY {$orderValue} {$orderType}";
	 	$result = $this->con->query($query);
	 	if ($result->num_rows > 0) {
	 		$data = array();
	 		while ($row = $result->fetch_assoc()) {
	 			$data[] = $row;
	 		}
	 		return $data;
	 	}else{
	 		return 0;
	 	}
	 }



	 public function displayOneSpecific($table,$item,$value)
	 {
	 	$item = $this->cleanse($item);
	 	$value = $this->cleanse($value);
	 	$query = "SELECT * FROM {$table} where $item='$value' ";
	 	$result = $this->con->query($query);
	 	if ($result->num_rows > 0) {
	 		$row = $result->fetch_assoc();
	 		return $row;
	 	}else{
	 		return 0;
	 	}
	 }


	 public function displayOneSpecificWithOrder($table,$item,$value,$orderValue,$orderType)
	 {
	 	$item = $this->cleanse($item);
	 	$value = $this->cleanse($value);
	 	$query = "SELECT * FROM {$table} where $item='$value' ORDER BY {$orderValue} {$orderType}";
	 	$result = $this->con->query($query);
	 	if ($result->num_rows > 0) {
	 		$row = $result->fetch_assoc();
	 		return $row;
	 	}else{
	 		return 0;
	 	}
	 }




	 public function displayWithLimit($table,$limit)
	 {
	 	$query = "SELECT * FROM {table} limit {$limit}";
	 	$result = $this->con->query($query);
	 	if ($result->num_rows > 0) {
	 		$data = array();
	 		while ($row = $result->fetch_assoc()) {
	 			$data[] = $row;
	 		}
	 		return $data;
	 	}else{
	 		return 0;
	 	}
	 }




		//Display Specific
	 public function displayName($value)
	 {
	 	$id = $this->cleanse($value);
	 	$query = "SELECT name FROM login where email='$id' ";
	 	$result = $this->con->query($query);
	 	if ($result->num_rows > 0) {
	 		$row = $result->fetch_assoc();
	 		return $row['name'];
	 	}else{
	 		return "No found records";
	 	}
	 }



	 public function displayOne($table,$value)
	 {
	 	$id = $this->cleanse($value);
	 	$query = "SELECT * FROM {$table} where email='$id' ";
	 	$result = $this->con->query($query);
	 	if ($result->num_rows > 0) {
	 		$row = $result->fetch_assoc();
	 		return $row;
	 	}else{
	 		return 0;
	 	}
	 }

	 public function displayNameById($table,$value)
	 {
	 	$id = $this->cleanse($value);
	 	$query = "SELECT * FROM {$table} where id='$id' ";
	 	$result = $this->con->query($query);
	 	if ($result->num_rows > 0) {
	 		$row = $result->fetch_assoc();
	 		return $row['name'];
	 	}else{
	 		return 0;
	 	}
	 }



	//Counting All
	 public function countAll($table)
	 {
	 	$q=$this->con->query("SELECT id FROM {$table}");
	 	if ($q) {
	 		return $q->num_rows;
	 	} else {
	 		return 0;
	 	}


	 }



	 public function countAllWithTwo($table,$item,$value)
	 {
	 	$q=$this->con->query("SELECT id FROM {$table} where $item='$value' ");
	 	if ($q) {
	 		return $q->num_rows;
	 	} else {
	 		return 0;
	 	}


	 }



	// Inserting



	 public function addUser($value)
	 {

	 	$name = $this->cleanse($post['name']);
	 	$email = $this->cleanse($post['email']);
	 	$phone = $this->cleanse($post['phone']);
	 	$address = $this->cleanse($post['address']);
	 	$password = $this->cleanse($post['password']);
	 	$question= strtolower($this->cleanse($post['question']));
	 	$answer = strtolower($this->cleanse($post['answer']));
	 	$gender = $this->cleanse($post['gender']);

			 $system_ip = $_SERVER['REMOTE_ADDR'];        // Obtains the IP address
	         $system_name = gethostbyaddr($system_ip);   // Obtains the pc name
	         $system_server=$_SERVER['HTTP_HOST'];      // Obtains server name
	         $message='Accurate Answer';
	         $login_time='Not logged in';
	         $logout_time='Not logged out';
	         $status='0';

	         $query="INSERT INTO user(name,email,password,question,answer,gender,phone,address) VALUES('$name','$email','$password','$question','$answer','$gender','$phone','$address')";
	         $query2="INSERT INTO login(name,email,password,role) VALUES('$name','$email','$password','3')";
	         $query3="INSERT INTO session_log(email,password,question,answer,message,system_name,system_ip,system_server,login_time,logout_time,status) VALUES('$email','$password','$question','$answer','$message','$system_name','$system_ip','$system_server','$login_time','$logout_time','$status')";

	         $sql = $this->con->query($query);
	         if ($sql==true) {
	         	header("Location:login.php?msg=Account was created successfully, Please login &type=success");
	         	$this->con->query($query2);
	         	$this->con->query($query3);
	         }else{
	         	header("Location:login.php?msg=Error adding data try again!&type=error");
	         }
	     }



	     public function updateAdmin($value)
	     {

	     	$email=$this->displayOne('session_log','email');
	     	$password=$this->cleanse($post['password']);
	     	$query="UPDATE login SET email='$email',password='$password' WHERE email='$email' ";
	     	$sql=$this->con->query($query);
	     	if ($sql==true) {
	     		header("Location:profile.php?msg=Account was updated successfully&type=success");
	     	}else{
	     		header("Location:profile.php?msg=Error updating account try again!&type=error");
	     	}
	     }

	     public function updateLogout($value)
	     {

	     	$value=$this->displayOneSpecificWithOrder('session_log','email',$value,'id','asc');
	     	$email=$value['email'];
	     	$password=$value['password'];
	     	$question=$value['question'];
	     	$answer=$value['answer'];
	     	$logout_time=date("d/m/y @ g:i A");
	     	$query="UPDATE session_log SET logout_time='$logout_time',status='0' WHERE email='$email' AND password='$password' AND question='$question' AND answer='$answer' AND status='1'";
	     	$this->con->query($query);
	     }




	     public function displayProfile($value)
	     {
	     	$id = $this->cleanse($value);
	     	$query = "SELECT * FROM login where email='$id' ";
	     	$result = $this->con->query($query);
	     	if ($result->num_rows > 0) {
	     		$row = $result->fetch_assoc();
	     		return $row;
	     	}else{
	     		return "No found records";
	     	}
	     }



	//Empty Table
	     public function emptyTable($table,$url) 
	     { 
	     	$id = $this->cleanse($id);
	     	$query = "TRUNCATE {$table}";

	     	$result = $this->con->query($query);

	     	if ($result == true) {
	     		header("Location:$url?msg=Data was successfully deleted&type=success");
	     	} else {
	     		header("Location:$url?msg=Error deleting data&type=error");
	     	}
	     }



	//Delete Items
	     public function delete($id, $table,$url) 
	     { 
	     	$id = $this->cleanse($id);
	     	$query = "DELETE FROM {$table} WHERE id = $id";

	     	$result = $this->con->query($query);

	     	if ($result == true) {
	     		header("Location:$url?msg=Data was successfully deleted&type=success");
	     	} else {
	     		header("Location:$url?msg=Error deleting data&type=error");
	     	}
	     }


	     public function deleteTwoTable($email,$table,$table2,$url) 
	     { 
	     	$email = $this->cleanse($email);
	     	$query = "DELETE FROM {$table} WHERE email= '$email'";
	     	$query2 = "DELETE FROM {$table2} WHERE email= '$email'";

	     	$result = $this->con->query($query);

	     	if ($result == true) {
	     		header("Location:$url?msg=Data was successfully deleted&type=success");
	     		$this->con->query($query2);
	     	} else {
	     		header("Location:$url?msg=Error deleting Data&type=error");
	     	}
	     }


	//Search
	     public function displaySearch($value)
	     {
		//Search box value assigning to $Name variable.
	     	$Name = $this->cleanse($value);
	     	$query = "SELECT * FROM product WHERE pid LIKE '%$Name%'";
	     	$result = $this->con->query($query);
	     	if ($result->num_rows > 0) {
	     		$row = $result->fetch_assoc();
	     		return $row;
	     	}else{
	     		return false;
	     	}
	     }



	     public function cleanse($str)
	     {
	   #$Data = preg_replace('/[^A-Za-z0-9_-]/', '', $Data); /** Allow Letters/Numbers and _ and - Only */
	     	$str = htmlentities($str, ENT_QUOTES, 'UTF-8'); /** Add Html Protection */
	     	$str = stripslashes($str); /** Add Strip Slashes Protection */
	     	if($str!=''){
	     		$str=trim($str);
	     		return mysqli_real_escape_string($this->con,$str);
	     	}
	     }






	     public function greeting()
	     {
	      //Here we define out main variables 
	     	$welcome_string="Welcome!"; 
	     	$numeric_date=date("G"); 

	 //Start conditionals based on military time 
	     	if($numeric_date>=0&&$numeric_date<=11) 
	     		$welcome_string="Good Morning!,"; 
	     	else if($numeric_date>=12&&$numeric_date<=17) 
	     		$welcome_string="Good Afternoon!,"; 
	     	else if($numeric_date>=18&&$numeric_date<=23) 
	     		$welcome_string="Good Evening!,"; 

	     	return $welcome_string;

	     }



	 }

	 ?>

