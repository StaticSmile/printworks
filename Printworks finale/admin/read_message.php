<?php 
include '../components/connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location: login.php');
    exit;
}


if (isset($_POST['delete'])) {

    $delete_id = filter_var($_POST['delete_id'], FILTER_SANITIZE_NUMBER_INT);

    $verify_delete = $conn->prepare(
        "SELECT * FROM `message` WHERE id = ?"
    );
    $verify_delete->execute([$delete_id]);

    if ($verify_delete->rowCount() > 0) {

        $delete_message = $conn->prepare(
            "DELETE FROM `message` WHERE id = ?"
        );
        $delete_message->execute([$delete_id]);

        $success_msg[] = 'Message deleted successfully';
    } else {
        $warning_msg[] = 'Message already deleted';
    }
}

if (isset($_GET['unread_id'])) {

    $unread_id = filter_var($_GET['unread_id'], FILTER_SANITIZE_NUMBER_INT);

    $mark_unread = $conn->prepare(
        "UPDATE `message` SET status = 'unread' WHERE id = ?"
    );
    $mark_unread->execute([$unread_id]);

    header('location: read_message.php');
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
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?= time(); ?>">
    <title>Print Works Admin – Read Messages</title>
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<div class="main">

    <div class="banner">
        <h1>Read Messages</h1>
    </div>

    <div class="title2">
        <a href="dashboard.php">dashboard</a>
        <span> / read messages</span>
    </div>

    <section class="accounts">
        <h1 class="heading">Read Messages</h1>

        <div class="box-container">

        <?php
        $select_message = $conn->prepare(
            "SELECT * FROM `message` WHERE status = 'read' ORDER BY id DESC"
        );
        $select_message->execute();

        if ($select_message->rowCount() > 0) {

            while ($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="box read">
                <h3 class="name">
                    <?= htmlspecialchars($fetch_message['name']); ?>
                </h3>

                <p class="email">
                    <?= htmlspecialchars($fetch_message['email']); ?>
                </p>

                <h4>
                    <?= htmlspecialchars($fetch_message['subject']); ?>
                </h4>

                <p>
                    <?= nl2br(htmlspecialchars($fetch_message['message'])); ?>
                </p>

                <div class="flex-btn">

                    <a href="read_message.php?unread_id=<?= $fetch_message['id']; ?>" 
                       class="btn">
                       mark as unread
                    </a>

                    <form action="" method="post">
                        <input type="hidden" name="delete_id" value="<?= $fetch_message['id']; ?>">
                        <button type="submit" name="delete" class="btn"
                            onclick="return confirm('Delete this message?');">
                            delete
                        </button>
                    </form>

                </div>
            </div>
        <?php
            }
        } else {
            echo '
            <div class="empty">
                <p>No read messages yet!</p>
            </div>';
        }
        ?>

        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="ascript.js"></script>

<?php include '../components/alert.php'; ?>

</body>
</html>