<?php

include "conn.php";

session_start();

$admin_id = $_SESSION["admin_id"];

if (!isset($admin_id)) {
    header("location:login.php");
}

if (isset($_POST["add_product"])) {
    $name = $_POST["name"];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST["price"];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $cat = $_POST["category"];
    $cat = filter_var($cat, FILTER_SANITIZE_STRING);
    $details = $_POST["details"];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    $image_01 = $_FILES["image_01"]["name"];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_size_01 = $_FILES["image_01"]["size"];
    $image_tmp_name_01 = $_FILES["image_01"]["tmp_name"];
    $image_folder_01 = "../uploaded_img/" . $image_01;

    $image_02 = $_FILES["image_02"]["name"];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_size_02 = $_FILES["image_02"]["size"];
    $image_tmp_name_02 = $_FILES["image_02"]["tmp_name"];
    $image_folder_02 = "../uploaded_img/" . $image_02;

    $image_03 = $_FILES["image_03"]["name"];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_size_03 = $_FILES["image_03"]["size"];
    $image_tmp_name_03 = $_FILES["image_03"]["tmp_name"];
    $image_folder_03 = "../uploaded_img/" . $image_03;

    $select_products = $conn->prepare(
        "SELECT * FROM `products` WHERE name = ?"
    );
    $select_products->execute([$name]);
    if(emptyempty ($_POST["name"])){
        $message[] = "Enter Required Detail!";
    }
    elseif($select_products->rowCount() > 0) {
        $message[] = "product name already exist!";
    } else {
        $insert_products = $conn->prepare(
            "INSERT INTO `products`(name, details, price,cat_name, image_01, image_02, image_03) VALUES(?,?,?,?,?,?,?)"
        );
        $insert_products->execute([
            $name,
            $details,
            $price,
            $cat,
            $image_01,
            $image_02,
            $image_03,
        ]);

        if ($insert_products) {
            if (
                $image_size_01 > 2000000 or
                $image_size_02 > 2000000 or
                $image_size_03 > 2000000
            ) {
                $message[] = "image size is too large!";
            } else {
                move_uploaded_file($image_tmp_name_01, $image_folder_01);
                move_uploaded_file($image_tmp_name_02, $image_folder_02);
                move_uploaded_file($image_tmp_name_03, $image_folder_03);
                $message[] = "new product added!";
            }
        }
    }
}

if (isset($_GET["delete"])) {
    $delete_id = $_GET["delete"];
    $delete_product_image = $conn->prepare(
        "SELECT * FROM `products` WHERE id = ?"
    );
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink("../uploaded_img/" . $fetch_delete_image["image_01"]);
    unlink("../uploaded_img/" . $fetch_delete_image["image_02"]);
    unlink("../uploaded_img/" . $fetch_delete_image["image_03"]);
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
    $delete_wishlist->execute([$delete_id]);
    header("location:product.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- bootstrap 5 version -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body id="body-pd">

<?php include "header.php"; ?>

<div class="content">
    <div class="container">
      <div class="card">
         <div class="card-body">
            <div class="row">
                <section class="add-products">
                    <h1 class="heading">ADD PRODUCT</h1>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="flex">
                                <div class="inputBox">
                                    <span>Product name (required)</span>
                                    <input type="text" class="box" required maxlength="100" placeholder="enter product name" name="name">
                                </div>
                                <div class="inputBox">
                                    <span>Product price (required)</span>
                                    <input type="number" min="0" class="box" required max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" name="price">
                                </div>
                                <div class="inputBox">
                                    <span>Category (required)</span>
                                    <input type="text" min="0" class="box"  placeholder="enter category"  name="category">
                                </div>
                                <div class="inputBox">
                                    <span>Image 01 (required)</span>
                                    <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
                                </div>
                                <div class="inputBox">
                                    <span>Image 02 (required)</span>
                                    <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
                                </div>
                                <div class="inputBox">
                                    <span>Image 03 (required)</span>
                                    <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
                                </div>
                                <div class="inputBox">
                                    <span>Product Details (required)</span>
                                    <textarea name="details" placeholder="enter product details" class="box" required maxlength="500" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <input type="submit" value="add product" class="btn" name="add_product">
                        </form>
                </section>
            </div>
        </div>
   </div>
</div>
    
    <!-- Carousel -->
        <div class="container-fluid Product_Container  vh-100 ">
            <!-- vh-100 -->
            <!-- Start Of CARD -->
            <?php
                    $select_products = $conn->prepare("SELECT * FROM `products`");
                    $select_products->execute();
                    if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="card rounded-3 ">
                <div class="top p-3 d-flex justify-content-between"> <!-- <i class="fa fa-arrow-left"></i> <i class="fa fa-heart-o"></i>  --></div>
                <div id="carouselExampleIndicators1" class="carousel slide p-3 " data-bs-ride="carousel">
                    <div class="carousel-indicators"> 
                        <button type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide-to="1" aria-label="Slide 2"></button> 
                        <button type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide-to="2"  aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active"> <img src="../uploaded_img/<?= $fetch_products["image_01"] ?>" alt=""
                                class="d-block " alt="..."  width="296px" height="296px"> </div>
                        <div class="carousel-item"> <img src="../uploaded_img/<?= $fetch_products["image_02"] ?>" alt="" class="d-block" width="296px" height="296px"
                                alt="..."> </div>
                        <div class="carousel-item"> <img src="../uploaded_img/<?= $fetch_products["image_03"] ?>" alt="" class="d-block"  width="296px" height="296px"
                                alt="..."> </div>
                    </div> 
                    <!-- <button class="carousel-control-prev" type="button"  data-bs-target="#carouselExampleIndicators1" data-bs-slide="prev"> 
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span> 
                    </button> 
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide="next">
                        <span  class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span> 
                    </button> -->
                </div>
                <div class="card2 w-100">
                    <h5><?= $fetch_products["name"] ?></h5>
                    <!-- <p><span>// =$fetch_products['details']; </p> -->
                     <div class="size"> 
                        <h6 class="fw-bold">$<span><?= $fetch_products['price']; ?></span>/-</h6>
                        <!-- <div class="diff_sizes d-flex justify-content-between "> <span>US 6</span> <span>US 7</span>
                            <span>US 8</span> <span>US 9</span> <span>US 10</span>
                        </div> -->
                    </div>
                    <div class="color">
                        <h6 class="mt-2 fw-bold"><span><?= $fetch_products['cat_name']; ?></h6>
                        
                        <!-- <div class="diff_color d-flex gap-3"> <span></span> <span></span> <span></span> </div> -->
                    </div>
                    <div class="d-flex justify-content-between ">
                        <div class="button m-2  w-100"> 
                        <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">UPDATE</a>

                          
                        </div>
                        <div class="button m-2  w-100">
                        <a href="product.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">DELETE</a>
                        </div>
                    </div>
                    
                </div>

            </div>
            <?php }
                    } else {
                    echo '<p class="empty">no products added yet!</p>';
                    }
            ?>
        </div>

    
   
<?php include "footer.php"; ?>
