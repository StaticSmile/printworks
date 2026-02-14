<?php
include '../components/connection.php'; 

date_default_timezone_set('Africa/Johannesburg'); 

$delete_guest_orders = $conn->prepare("DELETE FROM `orders` WHERE status = 'canceled' AND (user_id IS NULL OR user_id = '')");
$delete_guest_orders->execute();
echo "Deleted canceled orders for guests: " . $delete_guest_orders->rowCount() . "\n";

$delete_registered_orders = $conn->prepare("
    DELETE FROM `orders`
    WHERE status = 'canceled' 
    AND user_id IS NOT NULL
    AND user_id != ''
    AND DATE(date) <= DATE_SUB(CURDATE(), INTERVAL 2 DAY)
");
$delete_registered_orders->execute();
echo "Deleted canceled orders for registered users older than 2 days: " . $delete_registered_orders->rowCount() . "\n";
?>
