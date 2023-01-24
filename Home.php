<?php

include 'Admin/conn.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

 include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Website delevoping by Team Idiots</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <!-- bootstrap 5 version -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--bootstrap 4 version link-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <!-- fontawesome 5 version -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include './components/header.php'; ?>

<div class="home-bg">

<section class="home">
   <div class="">
      <!-- <div class="para-content-two"> 
         <h1 class="text-black">Milancélos</h1>
         <p>Lorem ipsum dolor sit amet . Lorem, ipsum dolor sit<p>
         <a href="shop.php" class="bg-black text-white p-2 btn btn-dark" style="width:103px;margin-left: 186px;">shop now</a>
      </div>-->
         </div>
</section>

</div>

<section class="category">

   <h1 class="heading">shop by category</h1>

   <div class="swiper category-slider">
      <div class="swiper-wrapper">
         <a href="category.php?category=ring" class="swiper-slide slide">
         <img src="images/toys.png" alt="ring" width="100px" height="150px">
            <h3>Soft Toy</h3>
         </a>
         <a href="category.php?category=necklace" class="swiper-slide slide">
         <img src="images/toys.png" alt="ring" width="100px" height="150px">
            <h3>Electric Toy</h3>
         </a>
         <a href="category.php?category=nosering" class="swiper-slide slide">
            <img src="images/toys.png" alt=""  width="100px" height="150px">
            <h3>Musical Instrument</h3>
         </a>
         <a href="category.php?category=earring" class="swiper-slide slide">
            <img src="images/toys.png" alt=""  width="100px" height="150px">
            <h3>Sports</h3>
         </a>
         <a href="category.php?category=bracelet" class="swiper-slide slide">
         <img src="images/toys.png" alt=""  width="100px" height="150px">
            <h3>Remote Control</h3>
         </a>
         <a href="category.php?category=stone" class="swiper-slide slide">
            <img src="images/toys.png" alt=""  width="100px" height="150px">
            <h3>Outdoor</h3>
         </a>
      </div>
      <div class="swiper-pagination"></div>
   </div>

</section>
<!-- paralax effect -->
<!-- 2 section -->
<div class="position-relative">
			<div class="parallax">
         <!-- <div class="float-right mt-5">
            <h1 class="text-black fs-1 ">Milancélos</h1>
            <p>Lorem ipsum dolor sit amet . Lorem, ipsum dolor sit<p>
            <a href="shop.php" class="bg-black text-white p-2 btn btn-dark" style="width:103px">shop now</a>
         </div> -->
			</div>
		</div>
<section class="home-products">

   <h1 class="heading">latest products</h1>

   <div class="swiper products-slider">

   <div class="swiper-wrapper"style="padding-top: 13px;">

   <?php
     $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="swiper-slide slide">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_02']; ?>">
      <button class="fa-regular fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quickview.php?pid=<?= $fetch_product['id']; ?>" class="fa-regular fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <div class="price"><span>₹</span><?= $fetch_product['price']; ?><span>/-</span></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

   <div class="swiper-pagination"></div>

   </div>

 </section> 
<!--<div class="main-sub-content">
			<div class="my-5">
				<h6 class="text-center"><a href="https://www.instagram.com/" class="mr-2 fs-2"><i
                            class="fa-brands fa-instagram"></i></a> #Image Gallery</h6>
				<p class="text-center">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
			</div>
			<div class="owl-container mx-1">
               <div class="owl-carousel  owl-theme" id="image">
                  <div class="item"><img src="https://cdn.shopify.com/s/files/1/0071/4755/2866/files/instagram-1_ace2bf31-5089-4a3b-950e-12faa1a08dad.jpg?v=1632799210" alt="">
               </div>
					<div class="item">
						<a href=""><img src="https://cdn.shopify.com/s/files/1/0071/4755/2866/files/instagram-2_9a47698c-c5b2-4caf-ba8a-2e7a8b17a4ca.jpg?v=1632799220" alt=""></a>
					</div>
					<div class="item">
						<a href=""><img src="https://cdn.shopify.com/s/files/1/0071/4755/2866/files/instagram-3_de8c73ca-be89-4f0e-bc0e-3149e75df69c.jpg?v=1632799233" alt=""></a>
					</div>
					<div class="item">
						<a href=""><img src="https://cdn.shopify.com/s/files/1/0071/4755/2866/files/instagram-4_83d76e6c-9357-428a-8d1d-0bb2f4f7665f.jpg?v=1632799245" alt=""></a>
					</div>
					<div class="item">
						<a href=""><img src="https://cdn.shopify.com/s/files/1/0071/4755/2866/files/instagram-5_f246aba2-aa3d-4033-8d36-ea4a67798ca0.jpg?v=1632799263" alt=""></a>
					</div>
					<div class="item">
						<a href=""><img src="https://cdn.shopify.com/s/files/1/0071/4755/2866/files/instagram-6_ab25c8fb-bfa2-4539-be8c-d2ae6cbd64c1.jpg?v=1632799501" alt=""></a>
					</div>
				</div>
			</div>
		</div>-->









<?php include'./components/footer.php'; ?>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
    },
});

 var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});

var swiper = new Swiper(".products-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>