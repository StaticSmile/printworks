<?php
include '../components/connection.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

$success_msg = [];
$warning_msg = [];

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

if (isset($_POST['add_to_wishlist'])) {
    $id = unique_id();
    $product_id = $_POST['product_id'];

    $varify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
    $varify_wishlist->execute([$user_id, $product_id]);

    $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $cart_num->execute([$user_id, $product_id]);

    if ($varify_wishlist->rowCount() > 0) {
        $warning_msg[] = 'Product already inside your wishlist';
    } else if ($cart_num->rowCount() > 0) {
        $warning_msg[] = 'Product already inside your cart';
    } else {
        $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (id, user_id, product_id, price) VALUES (?,?,?,?)");
        $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);

        $success_msg[] = 'Product added to wishlist successfully';
    }
}

if (isset($_POST['add_to_cart'])) {
    $id = unique_id();
    $product_id = $_POST['product_id'];
    $qty = filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);

    $varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $varify_cart->execute([$user_id, $product_id]);

    $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $max_cart_items->execute([$user_id]);

    if ($varify_cart->rowCount() > 0) {
        $warning_msg[] = 'Product already inside your cart';
    } else if ($max_cart_items->rowCount() > 20) {
        $warning_msg[] = 'Cart is full';
    } else {
        $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        $insert_cart = $conn->prepare("INSERT INTO `cart` (id, user_id, product_id, price, qty) VALUES (?,?,?,?,?)");
        $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);

        $success_msg[] = 'Product added to cart successfully';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Works - Shop Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <!-- Notyf CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
</head>
<body>
    <?php include '../components/header.php'; ?>

    <div class="main">  
        <div class="banner">
            <h1>shop</h1>
        </div>

        <div class="title2">
            <a href="home.php">home</a><span> / our shop</span>
        </div>

        <section class="products">
            <div class="vbox-container">
                <?php 
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE status='active'");
                $select_products->execute();
                if ($select_products->rowCount() > 0) {
                    while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <form action="" method="post" class="box">
                    <img src="../image/<?= htmlspecialchars($fetch_products['image']); ?>" class="img">
                    <div class="button">
                        <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                        <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                        <a href="view_page.php?pid=<?= htmlspecialchars($fetch_products['id']); ?>" class="bx bxs-show"></a>
                    </div>
                    <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">
                    <div class="flex">
                        <p class="price">R<?= htmlspecialchars($fetch_products['price']); ?>/-</p>
                        <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                    </div>
                    <a href="checkout.php?get_id=<?= htmlspecialchars($fetch_products['id']); ?>" class="btn">buy now</a>
                </form>
                <?php 
                    }
                } else {
                    echo '<p class="empty">No products added yet</p>';
                }
                ?>
            </div>
        </section>
    </div>

    <?php include '../components/footer.php'; ?>

    <!-- Notyf JS -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>

    <!-- Notyf Messages -->
    <script>
        const notyf = new Notyf({
            duration: 3000,
            position: { x: 'right', y: 'top' },
            dismissible: true
        });

        <?php
        if (!empty($success_msg)) {
            foreach ($success_msg as $msg) {
                echo "notyf.success(" . json_encode($msg) . ");";
            }
        }

        if (!empty($warning_msg)) {
            foreach ($warning_msg as $msg) {
                echo "notyf.error(" . json_encode($msg) . ");";
            }
        }
        ?>
    </script>
</body>
</html>
