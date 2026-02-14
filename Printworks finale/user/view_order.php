<?php
include '../components/connection.php';
session_start();

$user_id = $_SESSION['user_id'] ?? '';

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    header('Location: order.php');
    exit;
}

// CANCEL ORDER
if (isset($_POST['cancel'])) {
    $update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
    $update_order->execute(['canceled', $get_id]);
    // redirect to same page to reflect new status
    header("Location: order.php?get_id=$get_id");
    exit;
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
    <title>Print Works - order detail</title>
</head>
<body>
    <?php include '../components/header.php'; ?>
    <div class="main">  
    <div class="banner">
        <h1>order detail</h1>
    </div>
    <div class="title2">
        <a href="home.php">home</a><span>/ order detail</span>
    </div>

    <section class="order-detail">
        <div class="title">
            <h1>order detail</h1>
            <p>Here are the details of your order.</p>
        </div> 

        <div class="box-container">
        <?php 
        $grand_total = 0;
        $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE id = ? LIMIT 1");
        $select_orders->execute([$get_id]);
        if ($select_orders->rowCount() > 0){
            while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)){
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                $select_product->execute([$fetch_order['product_id']]);
                if ($select_product->rowCount() > 0){
                    while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
                        $sub_total = ($fetch_order['price']* $fetch_order['qty']);
                        $grand_total += $sub_total; 
        ?>
            <div class="box">
                <div class="col">
                    <p class="title"><i class="bi bi-calender-full"></i><?= $fetch_order['date']; ?></p>
                    <img src="../image/<?= $fetch_product['image']; ?>" class="image">
                    <p class="price"><?= $fetch_product['price']; ?> x <?= $fetch_order['qty']; ?></p>
                    <h3 class="name"><?= $fetch_product['name']; ?></h3>
                    <p class="grand-total">Total amount payable : <span>R<?= $grand_total; ?></span></p>

                    <div class="order-actions">
                        <?php
                        $check_order = $conn->prepare("SELECT status FROM `orders` WHERE id = ? LIMIT 1");
                        $check_order->execute([$get_id]);
                        $order_status = $check_order->fetchColumn();

                        if ($order_status === 'canceled') { ?>
                            <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn action">order again</a>
                        <?php } else { ?>
                            <form method="post">
                                <button type="submit" name="cancel" class="btn cancel"
                                    onclick="return confirm('Do you want to cancel this order?')">
                                    cancel order
                                </button>
                            </form>
                        <?php } ?>
                    </div>
                </div>

                <div class="col">
                    <p class="title">Billing Address</p>
                    <p class="user"><i class="bi bi-person-bounding-box"></i><?= $fetch_order['name']; ?></p>
                    <p class="user"><i class="bi bi-phone"></i><?= $fetch_order['number']; ?></p>
                    <p class="user"><i class="bi bi-envelope"></i><?= $fetch_order['email']; ?></p>
                    <p class="user"><i class="bi bi-pin-map-fill"></i><?= $fetch_order['address']; ?></p>

                    <p class="title">Status:</p>
                    <p class="order-status <?= strtolower($fetch_order['status']); ?>">
                        <?= ucfirst($fetch_order['status']); ?>
                    </p>
                </div>
            </div>
        <?php
                    }
                } else {
                    echo '<p class="empty">Product not found</p>';
                }
            }
        } else {
            echo '<p class="empty">No order found</p>';
        }
        ?>
        </div>
    </section>
</div>

<?php include '../components/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include '../components/alert.php'; ?>
</body>
</html>