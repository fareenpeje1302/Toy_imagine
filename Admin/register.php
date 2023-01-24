<?php

include 'conn.php';

session_start();

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
   $select_admin->execute([$name]);

   if($select_admin->rowCount() > 0){
      $message[] = 'Admin already exist!';
      
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
        
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `admins`(name, password) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);
         $message[] = 'new admin registered successfully!';
         // echo "new admin registered successfully!";
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register admin</title>
 <!-- bootstrap 5 version -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- <link rel="stylesheet" href="../css/admin_style.css"> -->
<style>
   /* ************************************************************************* */
/* Login form starts here */
.form-container{
    margin: 100px auto;
    background: palevioletred;
}
.error{
    color: red;
    font-size: 15px;
}

#register_section{
  height: auto;
  background:white;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
  border-top: 5px solid palevioletred;
  }
#register_section h1{
    font-family: var(--font-beau);
}
.login_div{
height:100vh;
}

.img_div {
  padding: 10px;
  border: solid 1px gray;
  width: 120px;
  height: 119px;
  margin-bottom: 15px;
}
.customefeature_image {
  display: none;
  padding: 10px;
  text-align: center;
}
.customefeature_image img {
  width: 50%;
  padding: 5px;
  border-radius: 3px;
  height: 50%;
  object-fit: cover;
  border: 1px solid black;
  text-align: center;
}
.custome_sideimg{
    background-image: url(https://cdn.shopify.com/s/files/1/0071/4755/2866/files/custom-block-parallax_1920x.jpg?v=1632796574);
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    background-size: 180%;
    background-repeat: no-repeat;
    background-position: center;
}
.container{
/* box-shadow: rgb(0 0 0 / 30%) 33px 37px 3px, rgb(255 255 255 / 22%) -28px 33px 8px;  */
}
/* Login form starts here */
</style>
</head>
<body>
<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>


<!-- <section class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" class="btn" name="submit">
   </form>

</section> -->
<section>
<div class="container">
			<div class="row mt-5 g-0">
				<div class="col-xl-6 m-auto">
					<div class=" p-4 " id="register_section">
                            <!-- <h1 class="ml-3"> <img src="assets/images/logo.png" alt="" width="50px" height="60px"><span >Amilyas</span></h1> -->
                            <h1>Register Now</h1>
									 <form action="" method="post">
                                <div class="mb-3">		
                                    <label for="formemail" class="form-label">Username</label>
								    <input  class="form-control" type="text" name="name" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">		 
                                </div>
                                <div class="mb-3">
									<label class="form-label" for="formpassword">Password</label>
									<input class="form-control" type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')"> 
                                </div>
								<div class="mb-3">
									<label class="form-label" for="formpassword">Confirm Password</label>
									<input class="form-control"  type="password" name="cpass" required placeholder="confirm your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')"> 
                                </div>
								<div class="mt-3 d-grid">
											<div class="d-flex justify-content-between">
                                 <input type="submit" value="register now" class="btn bg-dark text-white" name="submit">
												<div class="float-end"> <a href="login.php" class="text-muted">Already have  login account now?</a> </div>
											</div>
										</div>
									</form>
					</div>			
				</div><!-- end col -->	
			</div>
		</div>

      </section>









<script src="../js/admin_script.js"></script>
   
</body>

</html>