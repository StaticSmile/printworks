<?php
include '../components/connection.php';
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: login.php?redirect=cart');
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

if (isset($_POST['update_cart'])) {
    $cart_id = filter_var($_POST['cart_id'], FILTER_SANITIZE_STRING);
    $qty = filter_var($_POST['qty'], FILTER_SANITIZE_STRING);

    
    $qty = max(1, min(99, (int)$qty));

    $update_qty = $conn->prepare(
        "UPDATE `cart` SET qty = ? WHERE id = ? AND user_id = ?"
    );
    $update_qty->execute([$qty, $cart_id, $user_id]);

    $success_msg[] = 'Cart quantity updated successfully';
}

if (isset($_POST['delete_item'])) {
    $cart_id = filter_var($_POST['cart_id'], FILTER_SANITIZE_STRING);

    $verify_delete = $conn->prepare(
        "SELECT * FROM `cart` WHERE id = ? AND user_id = ?"
    );
    $verify_delete->execute([$cart_id, $user_id]);

    if ($verify_delete->rowCount() > 0) {
        $delete_cart = $conn->prepare(
            "DELETE FROM `cart` WHERE id = ? AND user_id = ?"
        );
        $delete_cart->execute([$cart_id, $user_id]);
        $success_msg[] = "Cart item deleted successfully";
    } else {
        $warning_msg[] = 'Cart item already deleted';
    }
}


if (isset($_POST['empty_cart'])) {
    $verify_empty = $conn->prepare(
        "SELECT * FROM `cart` WHERE user_id = ?"
    );
    $verify_empty->execute([$user_id]);

    if ($verify_empty->rowCount() > 0) {
        $delete_all = $conn->prepare(
            "DELETE FROM `cart` WHERE user_id = ?"
        );
        $delete_all->execute([$user_id]);
        $success_msg[] = "Cart emptied successfully";
    } else {
        $warning_msg[] = 'Cart is already empty';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <title>Print Works - Cart</title>
</head>
<body>

<?php include '../components/header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>My Cart</h1>
    </div>

    <div class="title2">
        <a href="home.php">Home</a><span> / Cart</span>
    </div>

    <section class="products">
        <h1 class="title">Products Added in Cart</h1>

        <div class="box-container">
            <?php
            $grand_total = 0;

            $select_cart = $conn->prepare(
                "SELECT * FROM `cart` WHERE user_id = ?"
            );
            $select_cart->execute([$user_id]);

            if ($select_cart->rowCount() > 0) {
                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {

                    $select_product = $conn->prepare(
                        "SELECT * FROM `products` WHERE id = ?"
                    );
                    $select_product->execute([$fetch_cart['product_id']]);

                    if ($select_product->rowCount() > 0) {
                        $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);

                        $sub_total = $fetch_cart['qty'] * $fetch_product['price'];
                        $grand_total += $sub_total;
            ?>
            <form method="post" class="box">
                <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">

                <img src="../image/<?= $fetch_product['image']; ?>" class="img">

                <h3 class="name"><?= $fetch_product['name']; ?></h3>

                <div class="flex">
                    <p class="price">R<?= $fetch_product['price']; ?>/-</p>

                    <input type="number"
                           name="qty"
                           min="1"
                           max="99"
                           value="<?= $fetch_cart['qty']; ?>"
                           class="qty"
                           required>

                    <button type="submit" name="update_cart" class="bx bxs-edit"></button>
                </div>

                <p class="sub-total">
                    Sub total :
                    <span>R<?= $sub_total; ?>/-</span>
                </p>

                <button type="submit"
                        name="delete_item"
                        class="btn"
                        onclick="return confirm('Delete this item?')">
                    Delete
                </button>
            </form>
            <?php
                    } else {
                        echo '<p class="empty">Product not found</p>';
                    }
                }
            } else {
                echo '<p class="empty">No products added yet!</p>';
            }
            ?>
        </div>

        <?php if ($grand_total > 0) { ?>
        <div class="cart-total">
            <p>Total amount payable :
                <span>R<?= $grand_total; ?>/-</span>
            </p>

            <div class="button">
                <form method="post">
                    <button type="submit"
                            name="empty_cart"
                            class="btn"
                            onclick="return confirm('Empty your cart?')">
                        Empty Cart
                    </button>
                </form>

                <a href="checkout.php" class="btn">
                    Proceed to Checkout
                </a>
            </div>
        </div>
        <?php } ?>

    </section>

<?php include '../components/footer.php'; ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include '../components/alert.php'; ?>

</body>
</html>
