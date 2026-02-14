<?php
include '../components/connection.php';
session_start();
if (isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id = '';
    }

    if (isset($_POST['logout'])) {
     session_destroy();
     header("Location: login.php");
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <title>Print Works - about us page</title>
</head>
<body>
    <?php include '../components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>about us</h1>
        </div>
        <div class="title2">
            <a href="home.php">home</a><span> / about</span>
        </div>
        <div class="about-category">
            <div class="box">
                <img src="../img/HFB_IMG_1763464965108.jpg" >
                <div class="detail">
                    <span>Sticker sheet</span>
                    <h1>peel-and-stick </h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box" >
                <img src="../img/HFB_IMG_1763485457063.jpg">
                <div class="detail">
                    <span>Customized stickers</span>
                    <h1>weatherproof vinyl</h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="../img/about.png">
                <div class="detail">
                    <span>coffee</span>
                    <h1>lemon teaname</h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="../img/1.webp">
                <div class="detail">
                    <span>coffee</span>
                    <h1>lemon green</h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
        </div>
        <section class="services">
            <div class="title">
                <h1>why choose us?</h1>
                <p>PrintWorks makes your ideas stick; literally! From custom designs to durable vinyl and fun sticker sheets, we deliver high-quality stickers with care and creativity. Perfect for gifts, projects, or branding, our stickers turn everyday items into something special.</p>
            </div>
                <div class="box-container">
                    <div class="box">
                        <img src="../img/icon2.png">
                        <div class="detail">
                            <h3>great savings</h3>
                            <p>Save big on every order. Quality prints without breaking the bank.</p>
                        </div>
                    </div>
                    <div class="box">
                        <img src="../img/icon1.png">
                        <div class="detail">
                            <h3>support</h3>
                            <p>We’re here when you need us. Quick, friendly support every step of the way.</p>
                        </div>
                    </div>
                    <div class="box">
                <img src="../img/icons8-delivery-time-50.png">
                <div class="detail">
                    <h3>Fast Turnaround</h3>
                    <p>Get your prints quickly with our efficient production process, no waiting around. </p>
                </div>
                </div>
                <div class="box">
                    <img src="../img/icon.png">
                    <div class="detail">
                        <h3>Satisfaction Guaranteed</h3>
                        <p>We make sure you love every print. Your satisfaction is our top priority. </p>
                    </div>
                </div>
                </div>
        </section>
        <div class="about">
            <div class="row">
                <div class="img">
                    <img src="../img/3.png">
                </div>
                <div class="detail">
                    <h1>visit our beautiful showroom!</h1>
                    <p>Our studio is a reflection of our passion for creativity and design. Whether you’re looking for custom stickers, personalized prints, or unique designs to brighten your space, PrintWorks brings your ideas to life with style and precision.</p>





                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
        </div>
        <!--<div class="testimonial-container">
            <div class="title">
                <img src="../img/download.png" class="logo">
                <h1>what people say about us</h1>
                <p>lorem ispum dolor sit amet consectetur adipisicing elit.</p>


            </div>
                 <div class="container">
                    <div class="testimonial-item active">
                        <img src="../img/01.jpg">
                        <h1>sara sekoli</h1>
                        <p>lorem ispum dolor sit amet consectetur adipisicing elit.</p>



                    </div>
                    <div class="testimonial-item">
                        <img src="../img/02.jpg">
                        <h1>jhon sekoli</h1>
                        <p>lorem ispum dolor sit amet consectetur adipisicing elit.</p>



                    </div>
                    <div class="testimonial-item">
                        <img src="../img/03.jpg">
                        <h1>leroy sekoli</h1>
                        <p>lorem ispum dolor sit amet consectetur adipisicing elit.</p>



                    </div>
                    <div class="left-arrow" onclick="nextSlide()"><i class="bx bxs-left-arrow-alt"></i></div>
                    <div class="right-arrow" onclick="prevSlide()"><i class="bx bxs-right-arrow-alt"></i></div>
                </div>
        </div>-->
        <?php include '../components/footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>
</html>