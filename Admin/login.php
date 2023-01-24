<?php

include 'conn.php';

session_start();

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if($select_admin->rowCount() > 0){
      $_SESSION['admin_id'] = $row['id'];
      header('location:product.php');
   }else{
      $message[] = 'incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   <!-- bootstrap 5 version -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- <link rel="stylesheet" href="../css/admin_style.css"> -->
<style>
   /* ************************************************************************* */
/* Login form starts here */
.form-container{
    margin: 100px auto;
    background: #9c27b0;
}
.error{
    color: red;
    font-size: 15px;
}
#login_section{
height: 500px;
background:white;
box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
border-top: 5px solid #9c27b0;
}
#register_section{
  height: auto;
  background:white;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
  border-top: 5px solid palevioletred;
  }
#login_section h1{
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
.custome_sideimg {
    background-image: url('../images/banner1.jpg');
    box-shadow: rgb(99 99 99 / 20%) 0px 2px 8px 0px;
    background-size: 100%; 
    background-repeat: no-repeat;
    background-position: center;
}
.container{
box-shadow: rgb(0 0 0 / 30%) 33px 37px 3px, rgb(255 255 255 / 22%) -28px 33px 8px; 
}
/* Login form starts here */
</style>
</head>
<body id="body-pd">

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
      <h3>login now</h3>
      <p>default username = <span>admin</span> & password = <span>admin</span></p>
      <input type="text" name="name" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" class="btn" name="submit">
   </form>

</section> -->

<section>
		<div class="container">
			<div class="form-container">
				<div class="row g-0">
					<div class="col-xl-12 m-auto">
						<div class="row">
                           
							<div class="col-sm-4 p-0">
                            
								<div class="auth-full-page-content p-4 " id="login_section">
                              
                                <h1 class="ml-3"> <img src="../images/toys.png" alt="logo" height="50px" Width="60px" class="Image">
                                <!-- <img src="..\images\logo.jpg" alt="" width="50px" height="60px"> -->
                                <span >Toy Imagine</span></h1>

                                <form action="" method="post">
										<div class="mb-3">
											<label for="formemail" class="form-label">Username</label>
											<input  class="form-control" type="text" name="name" required placeholder="enter your username" maxlength="20"   oninput="this.value = this.value.replace(/\s/g, '')"> </div>
										<div class="mb-3">
											<label class="form-label" for="formpassword">Password</label>
											<input type="password" class="form-control" name="pass" required placeholder="enter your password" maxlength="20"   oninput="this.value = this.value.replace(/\s/g, '')"> </div>
										<div class="mt-3 d-grid">
											<div class="d-flex justify-content-between">
                                  <input class="btn bg-dark text-white" type="submit" value="login now"  name="submit">
                                 <div class="float-end"> <a href="../Admin/register.php" class="text-muted">Not have account register now?</a> </div>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="col-sm-8 custome_sideimg d-flex flex-column ">
								<article>
									<h2 class="text-center text-black" style=" margin-left: 81px;">Welcome To Our Website</h2> </article>
								<!-- <p class="text-center text-white m">Login to access your admin account</p> -->
							</div>
						</div>
					</div>
					<!--end col -->
				</div>
			</div>
		</div>
      </section>
   
</body>
</html>