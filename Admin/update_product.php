<?php

include 'conn.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $cat = $_POST['category'];
   $cat = filter_var($cat, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `products` SET name = ?, details = ?,price = ?, cat_name=? WHERE id = ?");
   $update_product->execute([$name, $details ,$price, $cat, $pid]);

   $message[] = 'product updated successfully!';

   $old_image_01 = $_POST['old_image_01'];
   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   if(!empty($image_01)){
      if($image_size_01 > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
         $update_image_01->execute([$image_01, $pid]);
         move_uploaded_file($image_tmp_name_01, $image_folder_01);
         unlink('../uploaded_img/'.$old_image_01);
         $message[] = 'image 01 updated successfully!';
      }
   }

   $old_image_02 = $_POST['old_image_02'];
   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   if(!empty($image_02)){
      if($image_size_02 > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image_02 = $conn->prepare("UPDATE `products` SET image_02 = ? WHERE id = ?");
         $update_image_02->execute([$image_02, $pid]);
         move_uploaded_file($image_tmp_name_02, $image_folder_02);
         unlink('../uploaded_img/'.$old_image_02);
         $message[] = 'image 02 updated successfully!';
      }
   }

   $old_image_03 = $_POST['old_image_03'];
   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$image_03;

   if(!empty($image_03)){
      if($image_size_03 > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image_03 = $conn->prepare("UPDATE `products` SET image_03 = ? WHERE id = ?");
         $update_image_03->execute([$image_03, $pid]);
         move_uploaded_file($image_tmp_name_03, $image_folder_03);
         unlink('../uploaded_img/'.$old_image_03);
         $message[] = 'image 03 updated successfully!';
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
   <title>Update Product</title>
   <!-- bootstrap 5 version -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body id="body-pd">
<?php include 'header.php' ?>
    <div class="content">
        <section class="update-product container">
            <h1 class="heading">Update Product</h1>
                <?php
                    $update_id = $_GET['update'];
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                    $select_products->execute([$update_id]);
                    if($select_products->rowCount() > 0){
                    while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
                ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                        <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
                        <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
                        <input type="hidden" name="old_image_03" value="<?= $fetch_products['image_03']; ?>">
                        <div class="image-container">
                            <div class="main-image">
                                <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                            </div>
                            <div class="sub-image">
                                <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                                <img src="../uploaded_img/<?= $fetch_products['image_02']; ?>" alt="">
                                <img src="../uploaded_img/<?= $fetch_products['image_03']; ?>" alt="">
                            </div>
                        </div>
                      <div class="row">
                        <div class="col-6">
                            <span>UPDATE NAME</span>
                            <input type="text" name="name" required class="box" maxlength="100" placeholder="enter product name" value="<?= $fetch_products['name']; ?>">
                        </div>
                        <div class="col-6">
                            <span>UPDATE PRICE</span>
                            <input type="number" name="price" required class="box" min="0" max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['price']; ?>">
                        </div>
                        <div class="col-6">
                            <span>UPDATE CATEGORY</span>
                            <input type="text" name="category" required class="box" maxlength="100" placeholder="enter product category" value="<?= $fetch_products['cat_name']; ?>">
                        </div>
                        <div class="col-6">
                            <span>UPDATE IMAGE 01</span>
                            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                        </div>
                        <div class="col-6">
                            <span>UPDATE IMAGE 02</span>
                            <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                        </div>
                        <div class="col-6">
                            <span>UPDATE IMAGE 03</span>
                            <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                        </div>
                      </div>
                            <span>UPDATE DESCRIPTION</span>
                            <textarea name="details" class="box" required cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>

                        <div class="row">
                            <div class="col-6"><input type="submit" name="update" class="btn" value="update"></div> 
                            <div class="col-6"><a href="product.php" class="btn">go back</a></div> 
                        </div>
                   
                    </form>
                    <?php
                        }
                        }else{
                        echo '<p class="empty">no product found!</p>';
                     }
                    ?>
        </section>
    </div>
   <?php include 'footer.php' ?>

 
