<?php 
    include '../components/connection.php' ;

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)){
        header('location: login.php');
    }
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>print works admin panel - dashboard</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>dashboard</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">home</a><span> / dashboard</span>
        </div>
        <section class="dashboard">
                <h1 class="heading">dashboard</h1>
                <div class="box-container">
                    <div class="box">
                        <h3>Welcome !</h3>
                        <p><?= $fetch_profile['name']; ?></p>
                        <a href="profile.php" class="btn">profile</a>
                    </div>
                    <div class="box">
                        <?php 
                            $select_product = $conn->prepare("SELECT * FROM `products`");
                            $select_product->execute();
                            $num_of_products = $select_product->rowCount();
                        ?>
                        <h3><?= $num_of_products; ?></h3>
                        <p>Available products</P>
                        <a href="add_products.php" class="btn">Add new products </a>
                    </div>
                    <div class="box">
                        <?php 
                            $select_active_product = $conn->prepare("SELECT * FROM `products` WHERE status = ?");
                            $select_active_product->execute(['active']);
                            $num_of_active_products = $select_active_product->rowCount();
                        ?>
                        <h3><?= $num_of_active_products; ?></h3>
                        <p>total active products</P>
                        <a href="view_product.php" class="btn">view active products </a>
                    </div>
                    <div class="box">
                        <?php 
                            $select_deactive_product = $conn->prepare("SELECT * FROM `products` WHERE status = ?");
                            $select_deactive_product->execute(['deactive']);
                            $num_of_deactive_products = $select_deactive_product->rowCount();
                        ?>
                        <h3><?= $num_of_deactive_products; ?></h3>
                        <p>total deactive products</P>
                        <a href="view_product.php" class="btn">view deactive products </a>
                    </div>
                    <div class="box">
                        <?php 
                            $select_users = $conn->prepare("SELECT * FROM `users`");
                            $select_users->execute();
                            $num_of_users = $select_users->rowCount();
                        ?>
                        <h3><?= $num_of_users; ?></h3>
                        <p>number of users</P>
                        <a href="user_accounts.php" class="btn">view users </a>
                    </div>
                    <div class="box">
                        <?php 
                            $select_message = $conn->prepare("SELECT * FROM `message` WHERE status='unread'");
                            $select_message->execute();
                            $num_of_message = $select_message->rowCount();
                        ?>
                        <h3><?= $num_of_message; ?></h3>
                        <p>unread messages</P>
                        <a href="unread_message.php" class="btn">view messages </a>
                    </div>
                    <div class="box">
                        <?php 
                            $select_message = $conn->prepare("SELECT * FROM `message` WHERE status='read'");
                            $select_message->execute();
                            $num_of_message = $select_message->rowCount();
                        ?>
                        <h3><?= $num_of_message; ?></h3>
                        <p>read messages</P>
                        <a href="read_message.php" class="btn">view messages </a>
                    </div>
                    <div class="box">
                        <?php 
                            $select_orders = $conn->prepare("SELECT * FROM `orders`");
                            $select_orders->execute();
                            $num_of_orders = $select_orders->rowCount();
                        ?>
                        <h3><?= $num_of_orders; ?></h3>
                        <p>total orders placed</P>
                        <a href="order.php" class="btn">view orders </a>
                    </div>
                </div>
                <div class="recent-wrapper">

    <!-- Recent Orders -->
    <div class="recent-card">
        <h2>Recent Orders</h2>

        <?php
            $select_recent_orders = $conn->prepare("SELECT * FROM `orders` ORDER BY id DESC LIMIT 5");
            $select_recent_orders->execute();
            if($select_recent_orders->rowCount() > 0){
                while($fetch_orders = $select_recent_orders->fetch(PDO::FETCH_ASSOC)){
        ?>
            <div class="recent-item">
                <div>
                    <strong>#<?= $fetch_orders['id']; ?></strong>
                    <span><?= $fetch_orders['name']; ?></span>
                </div>
                <span class="status <?= $fetch_orders['status']; ?>">
                    <?= $fetch_orders['status']; ?>
                </span>
            </div>
        <?php
                }
            } else {
                echo '<p class="empty">No recent orders</p>';
            }
        ?>
    </div>


    <!-- Recent Messages -->
    <div class="recent-card">
    <h2>Recent Messages</h2>

    <?php
        $select_recent_messages = $conn->prepare("SELECT * FROM `message` ORDER BY id DESC LIMIT 5");
        $select_recent_messages->execute();

        if($select_recent_messages->rowCount() > 0){
            while($fetch_message = $select_recent_messages->fetch(PDO::FETCH_ASSOC)){
    ?>
        <div class="recent-item"
             onclick="window.location.href='unread_message.php?highlight=<?= $fetch_message['id']; ?>'">
            <div>
                <strong><?= htmlspecialchars($fetch_message['name']); ?></strong>
                <span><?= htmlspecialchars(substr($fetch_message['message'], 0, 40)); ?>...</span>
            </div>
            <span class="status <?= htmlspecialchars($fetch_message['status']); ?>">
                <?= htmlspecialchars($fetch_message['status']); ?>
            </span>
        </div>
    <?php
            }
        } else {
            echo '<p class="empty">No recent messages</p>';
        }
    ?>
</div>
        </section>
    </div>




     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
     <script type="text/javascript" src="ascript.js"></script>

     <?php include '../components/alert.php'; ?>
</body>
</html>