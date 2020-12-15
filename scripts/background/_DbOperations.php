<?php 



	class DbOperations{

		private $con; 

		function __construct(){
			
			require_once '_Response.php';
			require_once '_DBConnect.php';

			$db = new DbConnect();

			$this->con = $db->connect();

		}


		public function createUser($name, $pass, $email , $address , $role){
			$responseObj = new Response();
			if($this->isUserExist($email)){
				$responseObj->setError(true);	
				$responseObj->setMessage('User already exits with this email address');		
			}else{
				// $password = md5($pass);
				
				$stmt = $this->con->prepare("INSERT INTO `users`(`user_fname`, `user_email`, `user_pass`, `user_address`, `user_role`) VALUES (?,?,?,?,?);");
				$stmt->bind_param("sssss",$name,$email,$pass,$address,$role);

				if($stmt->execute()){
					$responseObj->setError(false);	
					$responseObj->setMessage('Account created successfully');		
					$responseObj->setContent($this->getLoggedUserInfo($email,$pass));
				}else{
					$responseObj->setError(true);	
					$responseObj->setMessage('Error occured while creating account');	
				}
			}
			return $responseObj;
		}
		
		public function orderLaptop($email, $ids, $price){
			$response = array();
			
			$id = $this->getUID($email);
				
				$stmt = $this->con->prepare("INSERT INTO orders (`user_id`, `price`, `order_date`, `items`) VALUES (?,?,?,?);");
				// $date = round(microtime(true) * 1000);
				$date = date('m/d/Y h:i:s a', time());
				$stmt->bind_param("ssss",$id,$price,$date,$ids);

				if($stmt->execute()){
					$response['error'] = false;
					$response['message'] = 'Order Completed';
				}else{
					$response['error'] = true;
					$response['message'] = 'Error occured while making an order';
				}
			return $response;
		}
		
		public function sendMessage($name, $email, $message , $subject){
			$response = array();
			
			$stmt = $this->con->prepare("INSERT INTO messages (`name`, `email`, `subject`, `message`, `timestamp`) VALUES (?,?,?,?,?);");
			$res = round(microtime(true) * 1000);
			$stmt->bind_param("sssss",$name,$email,$subject,$message,$res);

			if($stmt->execute()){
				$response['error'] = false;
				$response['message'] = 'Message Sent Successfully';
			}else{
				$response['error'] = true;
				$response['message'] = 'Error occured while sending message';
			}
		
			return $response;
		}
		
		public function userLogin($email, $pass){
			//$password = md5($pass);
			$responseObj = new Response();
			$stmt = $this->con->prepare("SELECT user_id,user_fname,user_role,user_address FROM users WHERE user_email='$email' AND user_pass='$pass'");
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($ID,$name,$role,$address);
			if($stmt->num_rows) {
				$res = $stmt->fetch();
				$temp = array();
				$temp['user_id'] = $ID;
				$temp['user_fname'] = $name;
				$temp['user_role'] = $role;
				$temp['user_address'] = $address;

				$responseObj->setMessage('Welcome '.$name);	
				$responseObj->setMessage('Log in Successful');	
				$responseObj->setContent($temp);	
			}else{
				if($this->isUserExist($email)){
					$responseObj->setMessage('The password that you have entered is incorrect.');				
				}else{
					$responseObj->setMessage('The email address does not match any account');				
				}
				$responseObj->setError(true);	
			}
			
			return $responseObj; 
		}
		
		private function getLoggedUserInfo($email, $pass){
			$password = md5($pass);
			$stmt = $this->con->prepare("SELECT user_id,user_fname,user_role,user_address FROM users WHERE user_email=? AND user_pass=?");
			$stmt->bind_param("ss",$email,$password);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($ID,$name,$role,$address);
			$temp = array();
			if($stmt->num_rows >0) {
				$res = $stmt->fetch();
				$temp['user_id'] = $ID;
				$temp['user_fname'] = $name;
				$temp['user_role'] = $role;
				$temp['user_address'] = $address;
	
			}
			return $temp; 
		}
		
		private function isUserExist($email){
			$stmt = $this->con->prepare("SELECT user_id FROM users WHERE user_email = ?");
			$stmt->bind_param("s", $email);
			$stmt->execute(); 
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}
		
		private function isCategoryExit($name){
			$stmt = $this->con->prepare("SELECT cat_id FROM category WHERE cat_title = ?");
			$stmt->bind_param("s", $name);
			$stmt->execute(); 
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}
		
		// private function validDateUser($email,$password){
		// 	$password = md5($pass);
		// 	$stmt = $this->con->prepare("SELECT ID FROM users WHERE email=? AND password=? AND role=admin");
		// 	$stmt->bind_param("ss", $email,$password);
		// 	$stmt->execute(); 
		// 	$stmt->store_result(); 
		// 	return $stmt->num_rows > 0; 
		// }
		
		public function getAllUsers(){
			$responseObj = new Response();
			$res = array();
			$result = $this->con->query("select * from users order by user_role ASC");
			while($row = $result->fetch_assoc()){
				$temp = array();
				$temp['name'] =  $row['user_fname'];
				$temp['email'] =  $row['user_email'];
				$temp['address'] =  $row['user_address'];
				$temp['ID'] =  $row['user_id'];
				$temp['role'] =  $row['user_role'];
				array_push($res , $temp);
			}
				$responseObj->setError(false);	
				$responseObj->setMessage('success');	
				$responseObj->setContent($res);
			return $responseObj;
		}
		
		public function getAllProducts(){
			$responseObj = new Response();
			$res = array();
			$result = $this->con->query("SELECT * from products p, category c, brands b where p.cat_id = c.cat_id and p.brand_id = b.brand_id ");
			 while($row = $result->fetch_assoc()){
				$temp = array();
				$temp['ID'] =  $row['product_id'];
				$temp['name'] =  $row['product_title'];
				$temp['price'] =  $row['price'];
				$temp['picture'] =  $row['product_img1'];
				$temp['quantity'] =  $row['quantity'];
				$temp['brand'] =  $row['brand_title'];
				$temp['description'] =  $row['product_desc'];
				$temp['Category'] = $row['cat_title'];
				array_push($res , $temp);
			 }
			$responseObj->setError(false);	
			$responseObj->setMessage('success');	
			$responseObj->setContent($res);
			return $responseObj;
		}
		
		public function getAllCategories(){
			$responseObj = new Response();
			$res = array();
			$result = $this->con->query("SELECT * from category");
			while($row = $result->fetch_assoc()){
				$temp = array();
				$temp['ID'] =  $row['cat_id'];
				$temp['Category'] =  $row['cat_title'];
				array_push($res , $temp);
			}
			$responseObj->setError(false);	
			$responseObj->setMessage('success');	
			$responseObj->setContent($res);
			return $responseObj;
		}

		public function getAllBrands(){
			$responseObj = new Response();
			$res = array();
			$result = $this->con->query("SELECT * from brands");
			while($row = $result->fetch_assoc()){
				$temp = array();
				$temp['ID'] =  $row['brand_id'];
				$temp['Brand'] =  $row['brand_title'];
				array_push($res , $temp);
			}
			$responseObj->setError(false);	
			$responseObj->setMessage('success');	
			$responseObj->setContent($res);
			return $responseObj;
		}
		
		public function updateProfile($picAdd, $email){
			$responseObj = new Response();
			$stmt = $this->con->prepare("UPDATE users SET profileAddress=? WHERE email=?");
			$stmt->bind_param('ss', $picAdd, $email);
			$status = $stmt->execute();
			if ($status === false) {
				$responseObj->setError(true);	
				$responseObj->setMessage('Failed to upload profile picture');	
				$responseObj->setContent('false');
			}else{
				$responseObj->setError(false);	
				$responseObj->setMessage('Uploaded successfully');	
				$responseObj->setContent(null);
			}
			return $responseObj;
		}
		
		public function updateCategory($cat, $id){
			$responseObj = new Response();
			$sql = "UPDATE category SET cat_title='$cat' WHERE cat_id='$id'";
			
			
			if ($this->con->query($sql)) {
				$responseObj->setError(false);	
				$responseObj->setMessage('updated successfully');	
				$responseObj->setContent(null);

			}else{
				$responseObj->setError(true);	
				$responseObj->setMessage('Failed to update category');	
				$responseObj->setContent('false');
							}
			return $responseObj;
		}
		
		public function updateProduct($name, $price, $quantity , $image_server_name,$id){
			$responseObj = new Response();
			$sql = "UPDATE products SET product_title='$name',price='$price',product_img1='$image_server_name',quantity='$quantity' WHERE product_id='$id'";
			
			// $stmt->bind_param("ssssi",$name,$price,$image_server_name,$quantity,$id);
			// $status = $stmt->execute();

			if ($this->con->query($sql)) {
				$responseObj->setError(false);	
				$responseObj->setMessage('updated successfully');	
				$responseObj->setContent(null);
			}else{
				$responseObj->setError(true);	
				$responseObj->setMessage('Failed to update product');	
				$responseObj->setContent('false');
				
			}
			return $responseObj;
		}
		
		// public function getAllMessages(){
		// 	$response = array();
		// 	$res = array();
		// 	$result = $this->con->query("SELECT * from messages");
		// 	while($row = $result->fetch_assoc()){
		// 		$temp = array();
		// 		$temp['ID'] =  $row['ID'];
		// 		$temp['name'] =  $row['name'];
		// 		$temp['email'] =  $row['email'];
		// 		$temp['subject'] =  $row['subject'];
		// 		$temp['message'] =  $row['message'];
		// 		$temp['timestamp'] =  $row['timestamp'];
		// 		array_push($res , $temp);
		// 	}
		// 	$response['messages'] = $res;
		// 	return $response;
		// }
		
		public function getAllOrders(){
			$responseObj = new Response();
			$res = array();
			$result = $this->con->query("select o.order_id , o.user_id , o.price , o.order_date , o.items , u.user_fname , u.user_address from orders o join users u where o.user_id = u.user_id");
			while($row = $result->fetch_assoc()){
				$temp = array();
				$temp['ID'] =  $row['order_id'];
				$temp['user_id'] =  $row['user_id'];
				$temp['price'] =  $row['price'];
				$temp['order_date'] =  $row['order_date'];
				$temp['items'] =  $row['items'];
				$temp['user_name'] =  $row['user_fname'];
				$temp['user_address'] =  $row['user_address'];
				array_push($res , $temp);
			}
			$responseObj->setError(false);	
			$responseObj->setMessage('success');	
			$responseObj->setContent($res);
			return $responseObj;
		}
		
		public function addProduct($name, $price, $quantity , $image_server_name,$cat, $brand){
			$responseObj = new Response();
			
				$stmt = $this->con->prepare("INSERT INTO products (`product_title`, `price`, `product_img1`, `quantity`, `brand_id`,`cat_id`) VALUES (?,?,?,?,?,?);");
				$vis = "true";
				$stmt->bind_param("ssssss",$name,$price,$image_server_name,$quantity,$brand,$cat);

				if($stmt->execute()){
					$responseObj->setError(false);	
					$responseObj->setMessage('Added to database');	
				}else{
					$responseObj->setError(true);	
					$responseObj->setMessage('Error occured while adding to database');	
				}
			return $responseObj;
		}
		
		public function deleteProduct($id){
			$stmt = $this->con->prepare("DELETE FROM products WHERE product_id=?");
			$stmt->bind_param("i", $id);
			return $stmt->execute(); 
		}
		
		public function deleteCategory($id){
			$stmt = $this->con->prepare("DELETE FROM category WHERE cat_id=?");
			$stmt->bind_param("i", $id);
			return $stmt->execute(); 
		}

		public function deleteBrand($id){
			$stmt = $this->con->prepare("DELETE FROM brands WHERE brand_id=?");
			$stmt->bind_param("i", $id);
			return $stmt->execute(); 
		}
		
		public function deleteOrder($id){
			$stmt = $this->con->prepare("DELETE FROM orders WHERE order_id=?");
			$stmt->bind_param("i", $id);
			return $stmt->execute(); 
		}
		
		public function addCategory($name){
			$responseObj = new Response();
			
			if($this->isCategoryExit($name)){
				$responseObj->setError(true);	
				$responseObj->setMessage('Category already exits');	
			}else{
			
				$stmt = $this->con->prepare("INSERT INTO category (`cat_title`) VALUES (?);");
				$stmt->bind_param("s",$name);

				if($stmt->execute()){
					$responseObj->setError(false);	
					$responseObj->setMessage('Added to database');	
				}else{
					$responseObj->setError(true);	
					$responseObj->setMessage('Error occurred while adding to database');	
				}
			}
			return $responseObj;
		}
		
		public function getUserOrders($email){
			$id = $this->getUID($email);
			$responseObj = new Response();
			$res = array();
			$stmt = $this->con->prepare("SELECT * from orders where user_id=?");
			$stmt->bind_param("s",$id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($orderID,$userID,$price,$order_date,$items);

			
			if($stmt->num_rows >0) {
				while($row = $stmt->fetch()){
					$temp = array();
					$temp['orderID'] = $orderID;
					$temp['userID'] = $userID;
					$temp['price'] = $price;
					$temp['order_date'] = $order_date;
					$temp['items'] = $items;
					array_push($res , $temp);
				}
				$responseObj->setError(false);	
				$responseObj->setMessage('success');	
				$responseObj->setContent($res);
				return $responseObj;
			}else{
				$responseObj->setError(true);	
				$responseObj->setMessage('none');	
				return $responseObj;
			}
		}
		
		public function getProductByID($id){
			$responseObj = new Response();
			$stmt = $this->con->prepare("SELECT * from products WHERE product_id=?");
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$temp = array();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_NUM)) {
				$temp = array();
				$temp['product_id'] =  $row[0];
				$temp['product_title'] =  $row[4];
				$temp['price'] =  $row[8];
				$temp['product_img1'] =  $row[5];
				$temp['quantity'] =  $row[4];

				$temp['cat_id'] = $row[1];
			}
			 $responseObj->setContent($temp);	
			return $responseObj;
		}
		
		public function getSpecificProductByID($id){
			$responseObj = new Response();
			$result = $this->con->query("SELECT * from products p, category c, brands b WHERE p.product_id='$id' and p.cat_id = c.cat_id and p.brand_id = b.brand_id");
			

			while ($row = $result->fetch_assoc()) {
				$temp = array();
				$temp['ID'] =  $row['product_id'];
				$temp['name'] =  $row['product_title'];
				$temp['price'] =  $row['price'];
				$temp['picture'] =  $row["product_img1"];
				$temp['quantity'] =  $row['quantity'];
				$temp['description'] =  $row['product_desc'];
				$temp['Category'] =  $row['cat_title'];
				$temp['Brand'] = $row['brand_title'];

			}
			 $responseObj->setContent($temp);	
			return $responseObj;
		}
		
		public function getUserDataById($email){
			$id = $this->getUID($email);
			$responseObj = new Response();
			$res = array();
			$stmt = $this->con->prepare("SELECT * from users WHERE user_id=?");
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$temp = array();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_NUM)) {
				$temp['avatar'] = $row[10];
			}
			 $responseObj->setContent($temp);	
			return $responseObj;
		}
		
		public function getUID($email){
			$stmt = $this->con->prepare("SELECT user_id FROM users WHERE user_email=?");
			$stmt->bind_param("s",$email);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($id);
			if($stmt->num_rows >0) {
				$res = $stmt->fetch();
				return $id;
			}else{
				return null;
			}
		}
		
		public function getCategoryIDByName($cat){
			$stmt = $this->con->prepare("SELECT ID FROM category WHERE Category=?");
			$stmt->bind_param("s",$cat);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($id);
			if($stmt->num_rows >0) {
				$res = $stmt->fetch();
				return $id;
			}else{
				return null;
			}
		}
		

	}