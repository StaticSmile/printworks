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
    <title>Print Works - home page</title>
</head>
<body>
    <?php include '../components/header.php'; ?>
    <div class="main">
        <section class="home-section">
                <div class="slider">
                <div class="slider__slider slide1">
                    <div class="overlay"></div>
                        <div class="slide-detail">
                            
                        </div>
                        <div class="hero-dec-top"></div>
                        <div class="hero-dec-bottom"></div>
                </div>
                <!----------silde ends----------->
                <div class="slider__slider slide2">
                    <div class="overlay"></div>
                        <div class="slide-detail">
                            <h1>Welcome to Pw shop</h1>
                            <p>lorem ispum dolor sit amet consectetur adipisicing elit.</p>
                            <a href="view_products.php" class="btn">shop now</a>
                        </div>
                        <div class="hero-dec-top"></div>
                        <div class="hero-dec-bottom"></div>
                </div>
                <!----------silde ends----------->
                <div class="slider__slider slide3">
                    <div class="overlay"></div>
                        <div class="slide-detail">
                            <h1>lorem ispum dolor sit</h1>
                            <p>lorem ispum dolor sit amet consectetur adipisicing elit.</p>
                            <a href="view_products.php" class="btn">shop now</a>
                        </div>
                        <div class="hero-dec-top"></div>
                        <div class="hero-dec-bottom"></div>
                </div>
                <!----------silde ends----------->
                <div class="slider__slider slide4">
                    <div class="overlay"></div>
                        <div class="slide-detail">
                            <h1>lorem ispum dolor sit</h1>
                            <p>lorem ispum dolor sit amet consectetur adipisicing elit.</p>
                            <a href="view_products.php" class="btn">shop now</a>
                        </div>
                        <div class="hero-dec-top"></div>
                        <div class="hero-dec-bottom"></div>
                </div>
                <!----------silde ends----------->
                <div class="slider__slider slide5">
                    <div class="overlay"></div>
                        <div class="slide-detail">
                            <h1>lorem ispum dolor sit</h1>
                            <p>lorem ispum dolor sit amet consectetur adipisicing elit.</p>
                            <a href="view_products.php" class="btn">shop now</a>
                        </div>
                        <div class="hero-dec-top"></div>
                        <div class="hero-dec-bottom"></div>
                </div>
                <!----------silde ends----------->
                <div class="left-arrow"><i class="bx bxs-left-arrow"></i></div>
                <div class="right-arrow"><i class="bx bxs-right-arrow"></i></div>
            </div>
        </div>
        <!--------------home slider ends here--------------->
        <section class="thumb">
            <div class="box-container">
                <div class="box">
                    <img src="../img/thumb2.jpg">
                    <h3>vinyl stickers</h3>
                    <p>Durable vinyl stickers with bold color—perfect for personalizing anything.</p>
                    <a href="view_products.php"><i class="bx bx-chevron-right"></i></a>
                </div> 
                <div class="box">
                    <img src="../img/thumb0.jpg">
                    <h3>holograpic stickers</h3>
                    <p>Eye-catching holographic stickers with a sleek, color-shifting finish.</p>
                    <a href="view_products.php"><i class="bx bx-chevron-right"></i></a>
                </div>
                <div class="box">
                    <img src="../img/thumb1.jpg">
                    <h3>chrome stickers</h3>
                    <p>A mirror-like metallic shine that catches the light and adds a striking, look to any surface.</p>
                    <a href="view_products.php"><i class="bx bx-chevron-right"></i></a>
                </div>
                <div class="box">
                    <img src="../img/thumb.jpg">
                    <h3>sticker sheet</h3>
                    <p>A convenient sheet of high-quality stickers, ready to peel and use.</p>
                    <a href="view_products.php"><i class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </section>
        
        <section class="shop-category">
            <div class="box-container">
                <div class="box">
                    <img src="../img/FB_IMG_1763485475730.jpg" style="height:50%;" width="90%">
                    <div class="detail">
                        <span>BIG OFFERS</span>
                        <h1>Extra 15% off</h1>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                </div>
                <div class="box" style="50%">
                    <img src="../img/FB_IMG_1763485457063.jpg" style="height:50%;" width="85%">
                    <div class="detail">
                        <span>New in taste</span>
                        <h1>coffee house</h1>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="services">
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
        <!--For brands <section class="brand">
            <div class="box-container">
                <div class="box">
                    <img src="">
                </div>
                <div class="box">
                    <img src="">
                </div>
                <div class="box">
                    <img src="">
                </div>
                <div class="bzox">
                    <img src="">
                </div>
                <div class="box">
                    <img src="">
                </div>
            </div>
        </section>-->
        <?php include '../components/footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>
</html>