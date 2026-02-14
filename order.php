<?php
include '../components/connection.php';
session_start();

if (isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

// ===== SUCCESS MESSAGE FROM CHECKOUT =====
if (isset($_SESSION['success_msg'])) {
$notyf_msg = $_SESSION['success_msg'] ?? '';
unset($_SESSION['success_msg']); // only show once
}

// logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// DELETE canceled orders for guests immediately
$delete_canceled_guest = $conn->prepare(
    "DELETE FROM `orders` WHERE status = 'canceled' AND user_id = ''"
);
$delete_canceled_guest->execute();

// DELETE canceled orders for registered users older than 2 days
if($user_id != ''){
    $delete_canceled_user = $conn->prepare(
        "DELETE FROM `orders` WHERE status = 'canceled' AND user_id = ? AND date < NOW() - INTERVAL 2 DAY"
    );
    $delete_canceled_user->execute([$user_id]);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Print Works - Order Page</title>
</head>
<body>
    <?php include '../components/header.php'; ?>
    <div class="main">  
        <div class="banner">
            <h1>My Orders</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/ Orders</span>
        </div>

        <!-- ===== Orders Section ===== -->
        <section class="products">
            <div class="obox-container">
               <div class="title">
                    <h1>My Orders:</h1>
                    <p>Here are all your recent orders. Canceled orders for registered users are removed after 2 days.</p>
               </div> 

               <div class="box-container">
                    <?php 
                        // SELECT orders but hide canceled older than 2 days for registered users
                        if($user_id != ''){
                            $select_orders = $conn->prepare("
                                SELECT * FROM `orders` 
                                WHERE user_id = ? 
                                AND NOT (status = 'canceled' AND date < NOW() - INTERVAL 2 DAY)
                                ORDER BY date DESC
                            ");
                            $select_orders->execute([$user_id]);
                        } else {
                            $select_orders = $conn->prepare("
                                SELECT * FROM `orders` 
                                WHERE user_id = ''
                                ORDER BY date DESC
                            ");
                            $select_orders->execute();
                        }

                        if ($select_orders->rowCount()>0){
                            while($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)){
                                $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                                $select_products->execute([$fetch_order['product_id']]);
                                if ($select_products->rowCount()>0){
                                    while($fetch_product=$select_products->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <div class="box <?= $fetch_order['status'] == 'canceled' ? 'order-canceled' : '' ?>">
                        <a href="view_order.php?get_id=<?= $fetch_order['id']; ?>">
                            <p class="date"><i class="bi bi-calendar-fill"></i><span><?=$fetch_order['date']; ?></span></p>
                            <img src="../image/<?= $fetch_product['image']; ?>" class="image">
                            <div class="row">
                                <h3 class="name"><?=$fetch_product['name']; ?></h3>
                                <p class="price">Price : R<?= $fetch_order['price']; ?> x <?= $fetch_order['qty']; ?></p>
                                <p class="status" style="color:<?php 
                                    if($fetch_order['status']=='delivered'){echo 'green';}
                                    elseif($fetch_order['status'] == 'canceled'){echo 'red';} 
                                ?>"><?= $fetch_order['status']; ?></p>
                            </div>
                        </a>
                    </div>
                    <?php
                                    }
                                }
                            }
                        } else {
                            echo '<p class="empty">No orders placed yet!</p>';
                        }
                    ?>
               </div>
            </div>
        </section>

        <?php include '../components/footer.php'; ?>
    </div>

    <!-- ===== Scripts ===== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include '../components/alert.php'; // this will display $success_msg[] ?>
    <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
<script>
const notyf = new Notyf({ duration: 5000, position: { x: 'right', y: 'top' } });
<?php if($notyf_msg != ''): ?>
    notyf.success("<?= $notyf_msg; ?>");
<?php endif; ?>
</script>
</body>
</html>
