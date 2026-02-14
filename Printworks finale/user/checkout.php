<?php
include '../components/connection.php';
session_start();

$user_id = $_SESSION['user_id'] ?? '';

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$notyf_msg = '';

if (isset($_POST['place_order'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $address = filter_var(
        $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['province'] . ', ' . $_POST['postalcode'],
        FILTER_SANITIZE_STRING
    );
    $address_type = filter_var($_POST['address_type'], FILTER_SANITIZE_STRING);
    $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);

    $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $verify_cart->execute([$user_id]);

    if (isset($_GET['get_id'])) {
        $get_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $get_product->execute([$_GET['get_id']]);
        if ($get_product->rowCount() > 0) {
            $fetch_p = $get_product->fetch(PDO::FETCH_ASSOC);

            $insert_order = $conn->prepare("INSERT INTO `orders` (id, user_id, name, number, email, address, address_type, method, product_id, price, qty, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_order->execute([unique_id(), $user_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'], $fetch_p['price'], 1, 'pending']);

            if ($insert_order) {
    // Delete cart
    $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart_id->execute([$user_id]);

    // Set session message
    $_SESSION['success_msg'] = "Your order has been placed successfully!";

    // Redirect to order page
    header('Location: order.php');
    exit;
} else {
                $notyf_msg = "Something went wrong!";
            }
        }
    } elseif ($verify_cart->rowCount() > 0) {
        while ($f_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)) {
            $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_product->execute([$f_cart['product_id']]);
            $fetch_p = $select_product->fetch(PDO::FETCH_ASSOC);

            $insert_order = $conn->prepare("INSERT INTO `orders` (id, user_id, name, number, email, address, address_type, method, product_id, price, qty, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_order->execute([unique_id(), $user_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'], $f_cart['price'], $f_cart['qty'], 'pending']);
        }

        if ($insert_order) {
            // delete cart after order
            $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart_id->execute([$user_id]);

            $notyf_msg = "Your order has been placed successfully!";
        } else {
            $notyf_msg = "Something went wrong!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
<link rel="stylesheet" href="style.css">
<title>Print Works - checkout page</title>
<style>
.place-order-wrapper { text-align: center; margin-top: 20px; }
.input-field label { display: block; margin-bottom: 5px; font-weight: bold; }
.input-field input, .input-field select { width: 100%; padding: 10px; font-size: 16px; margin-bottom: 15px; }
.summary .flex { display: flex; align-items: center; margin-bottom: 15px; }
.summary .flex img { width: 80px; height: 80px; object-fit: cover; margin-right: 15px; }
.grand-total { margin-top: 15px; font-weight: bold; }
</style>
</head>
<body>
<?php include '../components/header.php'; ?>
<div class="main">
    <div class="banner"><h1>Checkout Summary</h1></div>
    <div class="title2"><a href="home.php">home</a><span>/ checkout summary</span></div>
    <section class="checkout">
        <div class="title">
            <img src="../img/download.png" class="logo">
            <h1>Checkout Summary</h1>
            <p>Complete your order below.</p>
        </div>

        <div class="row">
            <form method="post">
                <h3>Billing Details</h3>

                <div class="box">
                    <div class="input-field">
                        <label for="name">Your Name <span>*</span></label>
                        <input type="text" id="name" name="name" required maxlength="50" placeholder="Enter Your Name" class="input">
                    </div>
                    <div class="input-field">
                        <label for="number">Your Number <span>*</span></label>
                        <input type="tel" id="number" name="number" required maxlength="15" placeholder="Enter Your Number" class="input">
                    </div>
                    <div class="input-field">
                        <label for="email">Your Email <span>*</span></label>
                        <input type="email" id="email" name="email" required maxlength="50" placeholder="Enter Your Email" class="input">
                    </div>
                    <div class="input-field">
                        <label for="method">Payment Method <span>*</span></label>
                        <select id="method" name="method" class="input">
                            <option value="cash on collection">Cash on Collection</option>
                            <option value="credit or debit card">Credit/Debit Card</option>
                            <option value="UPI or RuPay">UPI/RuPay</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label for="address_type">Address Type <span>*</span></label>
                        <select id="address_type" name="address_type" class="input">
                            <option value="home">Home</option>
                            <option value="work">Work</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="box">
                    <div class="input-field">
                        <label for="flat">Address Line 01 <span>*</span></label>
                        <input type="text" id="flat" name="flat" required maxlength="50" placeholder="Flat & Building" class="input">
                    </div>
                    <div class="input-field">
                        <label for="street">Address Line 02 <span>*</span></label>
                        <input type="text" id="street" name="street" required maxlength="50" placeholder="Street Name" class="input">
                    </div>
                    <div class="input-field">
                        <label for="city">City <span>*</span></label>
                        <input type="text" id="city" name="city" required maxlength="50" placeholder="City Name" class="input">
                    </div>
                    <div class="input-field">
                        <label for="province">Province <span>*</span></label>
                        <input type="text" id="province" name="province" required maxlength="50" placeholder="Province" class="input">
                    </div>
                    <div class="input-field">
                        <label for="postalcode">Postal Code <span>*</span></label>
                        <input type="text" id="postalcode" name="postalcode" required maxlength="6" placeholder="e.g. 6045" class="input">
                    </div>
                </div>

                <div class="place-order-wrapper">
                    <button type="submit" name="place_order" class="btn">Place Order</button>
                </div>
            </form>

            <div class="summary">
                <h3>My Bag</h3>
                <div class="box-container">
                    <?php  
                    $grand_total = 0;
                    if (isset($_GET['get_id'])) {
                        $select_get = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $select_get->execute([$_GET['get_id']]);
                        while ($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)) {
                            $sub_total = $fetch_get['price'];
                            $grand_total += $sub_total;
                    ?>
                    <div class="flex">
                        <img src="../image/<?= $fetch_get['image']; ?>" class="image">
                        <div>
                            <h3 class="name"><?= $fetch_get['name']; ?></h3>
                            <p class="price"><?= $fetch_get['price']; ?>/-</p>
                        </div>
                    </div>
                    <?php 
                        }
                    } else {
                        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                        $select_cart->execute([$user_id]);
                        if ($select_cart->rowCount() > 0) {
                            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                                $select_products->execute([$fetch_cart['product_id']]);
                                $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
                                $sub_total = ($fetch_cart['qty'] * $fetch_product['price']);
                                $grand_total += $sub_total;
                    ?>
                    <div class="flex">
                        <img src="../image/<?= $fetch_product['image']; ?>" class="image">
                        <div>
                            <h3 class="name"><?= $fetch_product['name']; ?></h3>
                            <p class="price"><?= $fetch_product['price']; ?> x <?= $fetch_cart['qty']; ?></p>
                        </div>
                    </div>
                    <?php 
                            }
                        } else {
                            echo '<p class="empty">Your cart is empty</p>';
                        }
                    }
                    ?>
                </div>
                <div class="grand-total"><span>Total amount payable: </span>R<?= $grand_total ?>/-</div>
            </div>
        </div>
    </section>
<?php include '../components/footer.php'; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
<script>
const notyf = new Notyf({ duration: 5000, position: { x: 'right', y: 'top' } });
<?php if($notyf_msg != ''): ?>
    notyf.success("<?= $notyf_msg; ?>");
<?php endif; ?>
</script>
</body>
</html>
