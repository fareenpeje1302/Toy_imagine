<?php

include 'conn.php'; ?>
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
        <header class="header mb-3" id="header">
            <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
            
            <div class="header_img"> 
               <img src="https://i.imgur.com/hczKIze.jpg" alt="">
               <?php
            $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="m-2"><?= $fetch_profile['name']; ?></p>
             </div>
        </header>
        <div class="l-navbar" id="nav-bar">
	<nav class="nav">
		<div>
			<a href="#" class="nav_logo"> <img src="../images/toys.png" alt="logo" height="50px" Width="60px" class="Image"><span class="nav_logo-name">Toy Imagine</span> </a>
			<div class="nav_list">
				<a href="Dashboard.php" class="nav_link active" data-bs-toggle="tooltip" data-bs-placement="right"  title="Dashboard" > <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name" >Dashboard</span> </a>
				<a href="user.php" class="nav_link" data-bs-toggle="tooltip" data-bs-placement="right" title="User"> <i class='bx bx-user nav_icon'></i> <span class="nav_name" >Users</span> </a>
				<a href="message.php" class="nav_link" data-bs-toggle="tooltip" data-bs-placement="right" title="Messages"> <i class='bx bx-message-square-detail nav_icon'></i> <span class="nav_name">Messages</span> </a>
				<a href="order.php" class="nav_link" data-bs-toggle="tooltip" data-bs-placement="right" title="Orders"> <i class='bx bx-bookmark nav_icon'></i> <span class="nav_name">Order</span> </a>
				<a href="product.php" class="nav_link" data-bs-toggle="tooltip" data-bs-placement="right" title="Products"> <i class='bx bx-folder nav_icon'></i> <span class="nav_name">Products</span> </a>
				<a href="admin_account.php" class="nav_link" data-bs-toggle="tooltip" data-bs-placement="right" title="Admins"> <i class='bx bx-user nav_icon'></i><span class="nav_name">Admins</span> </a>
			</div>
		</div>
		<a href="#" class="nav_link"> <a href="logout.php" class="dlt-btn" onclick="return confirm('logout from the website?');"><i class='bx bx-log-out nav_icon'></i> </a></a>
	</nav>
</div>