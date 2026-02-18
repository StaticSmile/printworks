<?php
// Start session only if none exists
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Determine if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
?>
<link rel="stylesheet" href="style.css">
<header class="header">
    <div class="flex">
        <a href="home.php" class="logo"><img src="../img/Hitube_0ohvgx7d0b_2026_02_07_16_02_52(1).jpg" alt="Logo" style="height:55px; width:auto; object-fit:contain; display:block;"></a>
        
        <nav class="navbar">
            <a href="home.php">home</a>
            <a href="view_products.php">products</a>
            <a href="order.php">orders</a>
            <a href="about.php">about us</a>
            <a href="contact.php">contact us</a>
        </nav>

        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>
            <?php
                $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                $count_wishlist_items->execute([$user_id]);
                $total_wishlist_items = $count_wishlist_items->rowCount(); 
            ?>
            <a href="wishlist.php" class="cart-btn">
    <i class="bx bxs-heart"><sup><?= $total_wishlist_items ?></sup></i>
</a>
            <?php
                $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $count_cart_items->execute([$user_id]);
                $total_cart_items = $count_cart_items->rowCount(); 
            ?>
            <a href="cart.php" class="cart-btn"><i class="bx bxs-cart"><sup><?= $total_cart_items?></sup></i></a>
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 2rem;"></i>
        </div>

        <div class="user-box">
            <?php if ($is_logged_in): ?>
                <p>Username: <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span></p>
                <p>Email: <span><?php echo htmlspecialchars($_SESSION['user_email']); ?></span></p>
                
                <form method="post">
                    <button type="submit" name="logout" class="logout-btn">Log Out</button>
                </form>
            <?php else: ?>
                <a href="login.php" class="btn">Login</a>
                <a href="register.php" class="btn">Register</a>
            <?php endif; ?>
        </div>
    </div>
</header>